var fs = require('fs');
var crypto = require('crypto');
var console = process.console;
var config  = require('./config.js');
var getSteamAPIKey = require('steam-web-api-key');
var SteamUser = require('steam-user');
var SteamTradeOffers = require('steam-tradeoffers');
var redisClient;
var SteamTotp = require('steam-totp');
var SteamcommunityMobileConfirmations = require('steamcommunity-mobile-confirmations');
module.exports.init = function(redis, requestifyCore) {
    redisClient = redis.createClient();
}
var requestify   = require('requestify');


function gucode(){
    console.tag('SteamBotCARD').log('Код авторизиции '+SteamTotp.generateAuthCode(config.shared_secret));
    setTimeout(function(){ gucode() }, 30000)
}
gucode();
var client = new SteamUser();

client.logOn({
    "accountName" :  config.username,
    "password"    :  config.password,
    "rememberPassword" : true,
    "twoFactorCode" :SteamTotp.generateAuthCode(config.shared_secret)
});



client.on('loggedOn', function(details) {
    console.log("Вошёл в стим " + client.steamID.getSteam3RenderedID());
    client.setPersona(SteamUser.Steam.EPersonaState.Online);
});
var offers = new SteamTradeOffers();
var checkingOffers = [],
    WebSession = false,
    globalSession;
client.on('error', function(e) {
    console.log(e);
});

const redisChannels = { 
itemsToSale: 'items.to.sale', 
itemsToGive: 'send.items', 
offersToCheck: 'offers.to.check', 
tradeoffersList: 'tradeoffers.list' 
}
client.on('webSession', function(sessionID, cookies) {
    function trademobile(){
        var steamcommunityMobileConfirmations = new SteamcommunityMobileConfirmations(
            {
                steamid: config.steamid,
                identity_secret: config.identity_secret,
                device_id: SteamTotp.getDeviceID(config.steamid),
                webCookie:  cookies,
            });
        steamcommunityMobileConfirmations.FetchConfirmations((function (err, confirmations)
        {
            if (err)
            {
                return;
            }
            if ( ! confirmations.length)
            {
                return;
            }
            steamcommunityMobileConfirmations.AcceptConfirmation(confirmations[0], (function (err, result)
            {
                if (err)
                {
                    //    console.tag('SteamBot').console.error(err);
                    return;
                }
            }).bind(this));
        }).bind(this));
        setTimeout(function(){ trademobile()}, 1000)
    }
    trademobile();
    console.log(cookies);

    console.log(config.apiKey);
offers.setup({ 
sessionID: sessionID, 
webCookie: cookies, 
APIKey: config.apiKey 
}, function(err){ 
WebSession = true; 
globalSession = sessionID; 
console.log('TradeofferList - ' + redisChannels.tradeoffersList);
redisClient.lrange(redisChannels.tradeoffersList, 0, -1, function(err, offers){ 
offers.forEach(function(offer) { 
checkingOffers.push(offer); 
}); 
handleOffers(); 
}); 
console.log('Setup Offers!'); 
});

    console.log("Создал сессию");
});


client.on('tradeOffers', function(count) {
    console.log('Трейдов: ' + count);
if (count > 0 && WebSession) { 
handleOffers(); 
}
});



function handleOffers() {
    offers.getOffers({
        get_received_offers: 1,
        active_only: 1
    }, function(error, body) {
        if (
            body
            && body.response
            && body.response.trade_offers_received
        ) {
            body.response.trade_offers_received.forEach(function(offer) {
                if (offer.trade_offer_state == 2) {
                    if(offer.items_to_give) {
                        if (config.admins.indexOf(offer.steamid_other) != -1) {
                            console.tag('SteamBot', 'TradeOffer').log('TRADE OFFER #' + offer.tradeofferid + ' FROM: Admin ' + offer.steamid_other);
                            offers.acceptOffer({tradeOfferId: offer.tradeofferid});
                            return;

                        }else{
                            console.log(offer.message);
                            offers.declineOffer({tradeOfferId: offer.tradeofferid});
                        }

                    }

                    if(config.admins.indexOf(offer.steamid_other) == -1) {


                        if (offer.message.length != 4) {
                            console.log(offer.message);
                            offers.declineOffer({tradeOfferId: offer.tradeofferid});

                        }
                    }

                    offers.acceptOffer({
                        tradeOfferId: offer.tradeofferid
                    }, function(error, traderesponse) {
                        if(!error) {
                            if ('undefined' != typeof traderesponse.tradeid) {
                                offers.getItems({
                                    tradeId: traderesponse.tradeid
                                }, function (error, recieved_items) {
                                    if (!error) {
                                        var itemsForParse = [], itemsForSale = [], i = 0;
                                        recieved_items.forEach(function(item){
                                            itemsForParse[i++] = item.id;
                                        })
                                        offers.loadMyInventory({appId: 730, contextId: 2, language: 'russian'}, function(error, botItems){
                                            if(!error){
                                                i = 0;
                                                botItems.forEach(function(item){
                                                    if(itemsForParse.indexOf(item.id) != -1){
                                                        var rarity = '', type = '';
                                                        var arr = item.type.split(',');
                                                        if (arr.length == 2) rarity = arr[1].trim();
                                                        if (arr.length == 3) rarity = arr[2].trim();
                                                        if (arr.length && arr[0] == '���') rarity = '������';
                                                        if (arr.length) type = arr[0];
                                                        var quality = item.market_name.match(/\(([^()]*)\)/);
                                                        if(quality != null && quality.length == 2) quality = quality[1];
                                                        itemsForSale[i++] = {
                                                            inventoryId: item.id,
                                                            classid: item.classid,
                                                            name: item.name,
                                                            market_hash_name: item.market_hash_name,
                                                            rarity: rarity,
                                                            quality: quality,
                                                            type: type
                                                        }
                                                    }
                                                });
                                            }
                                            redisClient.rpush(redisChannels.itemsToSale, JSON.stringify(itemsForSale));
                                            return;
                                        });
                                    }
                                    return;
                                });
                            }
                        }
                        return;
                    });

                    return;
                }
            });
        }
    });
}








var sendTradeOffer = function(offerJson){
    var offer = JSON.parse(offerJson);
    try {
        offers.loadMyInventory({
            appId: 730,
            contextId: 2
        }, function (err, items) {
            var itemsFromMe = [];

            items.forEach(function(item){
                if(item.id == offer.itemId){
                    itemsFromMe[0] = {
                        appid: 730,
                        contextid: 2,
                        amount: item.amount,
                        assetid: item.id
                    };
                }
            }, function(err){});




            function getErrorCode(err, callback){
                var errCode = 0;
                var match = err.match(/\(([^()]*)\)/);
                if(match != null && match.length == 2) errCode = match[1];
                callback(errCode);
            }

            if (itemsFromMe.length > 0) {
                offers.makeOffer({
                    partnerSteamId: offer.partnerSteamId,
                    accessToken: offer.accessToken,
                    itemsFromMe: itemsFromMe,
                    itemsFromThem: [],
                    message: 'Your purchase on the site '+config.domain+''
                }, function (err, response) {
                    if (err) {
                        //console.tag('SteamBotCARD', 'SendItem').error('Error to send offer. Error: ' + err);

                        getErrorCode(err.message, function(errCode){
                            if(errCode == 15 || errCode == 25 || err.message.indexOf('an error sending your trade offer.  Please try again later.')) {
                                redisClient.lrem(redisChannels.itemsToGive, 0, offerJson, function (err, data) {
                                    setItemStatus(offer.id, 4);
                                    sendProcceed = false;
                                });

                                sendProcceed = false;
                            }
                            sendProcceed = false;
                        });
                        sendProcceed = false;
                    }else if(response){
                        redisClient.lrem(redisChannels.itemsToGive, 0, offerJson, function(err, data){
                            sendProcceed = false;
                            setItemStatus(offer.id, 3);
                            console.tag('SteamBotCARD', 'SendItem').log('TradeOffer #' + response.tradeofferid +' send!');
                            redisClient.rpush(redisChannels.offersToCheck, response.tradeofferid);
                        });}
                });
            }else{
                console.tag('SteamBotCARD', 'SendItem').log('Items not found!');
                setItemStatus(offer.id, 2);
                redisClient.lrem(redisChannels.itemsToGive, 0, offerJson, function(err, data){
                    sendProcceed = false;
                });
            }
        });

    }catch(ex){
        console.tag('SteamBotCARD').error('Error to send the item');
        sendProcceed = false;
    }
};

var setItemStatus = function(item, status){
    console.log(505);
    requestify.post('http://'+config.domain+'/api/setItemStatus', {
            id: item,
            status: status
        })
        .then(function(response) {
        },function(response){
            console.tag('SteamBotCARD').error('Something wrong with setItemStatus. Retry...');
            setTimeout(function(){setItemStatus()}, 1000);
        });
}

var addNewItems = function(){
    requestify.get('http://'+config.domain+'/api/newItems', {})
        .then(function(response) {
            var answer = JSON.parse(response.body);
            if(answer.success){
                itemsToSaleProcced = false;
            }
        },function(response){
            console.tag('SteamBotCARD').error('Something wrong with newItems. Retry...');
            setTimeout(function(){addNewItems()}, 1000);
        });
}

var checkOfferForExpired = function(offer){
    offers.getOffer({tradeOfferId: offer}, function (err, body){
        if(body.response.offer){
            var offerCheck = body.response.offer;
            if(offerCheck.trade_offer_state == 2) {
                var timeCheck = Math.floor(Date.now() / 1000) - offerCheck.time_created;
                console.log(timeCheck);
                if(timeCheck >= config.timeForCancelOffer){
                    offers.cancelOffer({tradeOfferId: offer}, function(err, response){
                        if(!err){
                            redisClient.lrem(redisChannels.offersToCheck, 0, offer, function(err, data){
                                steamBotLogger('Offer #' + offer + ' was expired!')
                                checkProcceed = false;
                            });
                        }else{
                            checkProcceed = false;
                        }
                    });
                }else{
                    checkProcceed = false;
                }
                return;
            }else if(offerCheck.trade_offer_state == 3 || offerCheck.trade_offer_state == 7){
                redisClient.lrem(redisChannels.offersToCheck, 0, offer, function(err, data){
                    checkProcceed = false;
                });
            }else{
                checkProcceed = false;
            }
        }else{
            checkProcceed = false;
        }
    })
}

var queueProceed = function(){
    redisClient.llen(redisChannels.itemsToSale, function(err, length) {
        if (length > 0 && !itemsToSaleProcced) {
            console.tag('SteamBotCARD','Queues').info('New items to sale:' + length);
            itemsToSaleProcced = true;
            addNewItems();
        }
    });
    redisClient.llen(redisChannels.itemsToGive, function(err, length) {
        if (length > 0 && !sendProcceed) {
            console.log(length+' 505');
            console.tag('SteamBotCARD','Queues').info('Send items:' + length);
            sendProcceed = true;
            redisClient.lindex(redisChannels.itemsToGive, 0,function (err, offerJson) {
                sendTradeOffer(offerJson);
            });
        }
    });
    redisClient.llen(redisChannels.offersToCheck, function(err, length) {
        if (length > 0 && !checkProcceed && WebSession) {
            console.tag('SteamBotCARD','Queues').info('Check Offers:' + length);
            checkProcceed = true;
            redisClient.lindex(redisChannels.offersToCheck, 0,function (err, offer) {
                setTimeout(function(){
                    checkOfferForExpired(offer)
                }, 1000 * config.timeForCancelOffer);
            });
        }
    });
}
var itemsToSaleProcced = false;
var sendProcceed = false;
var checkProcceed = false;
setInterval(queueProceed, 1500);