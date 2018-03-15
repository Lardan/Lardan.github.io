var auth = require('http-auth'),
    scribe = require('scribe-js')(),
    console = process.console,
    config = require('./config.js'),
    app = require('express')(),
    server = require('http').Server(app),
    io = require('socket.io')(server),
    redis = require('redis'),
    requestify = require('requestify'),
    fs = require('fs');
bot = require('./bot.js');
var redisClient = redis.createClient(),
    client = redis.createClient();
bot.init(redis, io, requestify);
server.listen(2020);

var basicAuth = auth.basic({ //basic auth config
    realm: "EZYSKINS.ru WebPanel",
    file: __dirname + "/users.htpasswd" // test:test
});
app.use('/logs', auth.connect(basicAuth), scribe.webPanel());
redisClient.subscribe('new.winner');
redisClient.subscribe('new.msg');
redisClient.subscribe('del.msg');
redisClient.setMaxListeners(0);
redisClient.on("message", function (channel, message) {
    if (channel == 'new.winner') {
        io.sockets.emit(channel, message);
    }
    if (channel == 'new.msg') {
        io.sockets.emit('chat', message);
    }
    if (channel == 'del.msg') {
        io.sockets.emit('chatdel', message);
    }
});

io.sockets.on('connection', function (socket) {

    updateOnline();


    socket.on('disconnect', function () {

        updateOnline();
    })
});



// использование Math.round() даст неравномерное распределение!
function getRandomInt(min, max)
{
    return Math.floor(Math.random() * (max - min + 1)) + min;
}


function updateOnline() {
    var online = Object.keys(io.sockets.adapter.rooms).length;
    client.set("online", online, redis.print);
    io.sockets.emit('online', online);
    console.info('Онлайн ' + online);
}


function updateTrade() {

    requestify.get('https://market.csgo.com/api/Trades/?key=mIuTiwdFISEXS9JPev4EH5a7M6I0wQg', {})
        .then(function (response) {
            //data = response;
            data = JSON.parse(response.body);

            console.log('в ожидание ' + count(data) + ' предмета')
            for (i = 0; i < count(data); i++) {
                result = data[i]['ui_status'];
                classid = data[i]['i_classid'];
                instanceid = data[i]['i_instanceid'];

                if (result == 3) {
                    console.log('Ожидаем подтверждение от продавца/n');
                }
                if (result == 4) {
                    bid = data[i]['ui_bid'];
                    console.log('Номер ' + bid);

                    res = sendme(bid);

                }
            }

        });

}
function sendme(id) {
    requestify.get('https://market.csgo.com/api/ItemRequest/out/' + id + '/?key=mIuTiwdFISEXS9JPev4EH5a7M6I0wQg', {})
        .then(function (response) {
                data = JSON.parse(response.body);
                console.log(data);
                if (res['success']) {
                    console.log('Запрос на выдачу отправлен. Ник бота - ' + res['nick'] + '. Проверочный код - ' + res['secret']);
                }
                //console.log(data);

            }
        );
}

function listbuy() {
    requestify.get('http://' + config.domain + '/api/listbuy', {})
        .then(function (response) {


            }
        );
}
function Fake() {
    requestify.get('http://' + config.domain + '/api/fake', {})
        .then(function (response) {


            }
        );
}
Fake();
listbuy();
updateTrade();
function uponline() {
    requestify.get('https://market.csgo.com/api/PingPong/?key=mIuTiwdFISEXS9JPev4EH5a7M6I0wQg', {})
        .then(function (response) {

            }
        );
}
listupprice();
function listupprice() {
    requestify.get('http://' + config.domain + '/api/listupdate', {})
        .then(function (response) {
                data = JSON.parse(response.body);
                for (i = 0; i < count(data); i++) {
                    name = data[i]['name'];
                }
                newbuy(name);

            }
        );
}
setInterval(listupprice, 180000);
setInterval(updateTrade, 60000);

//setInterval(Fake, 60000);
setInterval(listbuy, 5000);
setInterval(uponline, 240000);
function updatestats() {
    requestify.get('http://' + config.domain + '/api/stats', {})
        .then(function (response) {
                data = JSON.parse(response.body);
                io.sockets.emit('stats', data);
            }
        );
}
setInterval(updatestats, 500);

function updateinfocase() {
    requestify.get('http://' + config.domain + '/api/case', {})
        .then(function (response) {
                data = JSON.parse(response.body);
                io.sockets.emit('infocase', data);
            }
        );
}
setInterval(updateinfocase, 500);

function count(array) {
    var cnt = 0;
    for (var i in array) {
        if (i) {
            cnt++
        }
    }
    return cnt
}