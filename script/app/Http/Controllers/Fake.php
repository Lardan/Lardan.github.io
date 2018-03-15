<?php namespace App\Http\Controllers;

use App\Cases;
use App\Config;
use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Inventory;
use App\Items;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Redis;

class Fake extends Controller
{


    const NEW_WINNER = 'new.winner';

    public function __construct()
    {
        parent::__construct();
        $this->redis = Redis::connection();
    }

    public function __destruct()
    {
        $this->redis->disconnect();
    }

    public function addfake(){
        $i = 0;
        $fake = array(
            array('Ethan', '76561198108743684', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/10/1070d3af8a1283ae975a97e4a0281c4faedf13fa_full.jpg'),
            array('BROYLES', '76561198110756296', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/7e/7eca8ee5cdd6888a2853a0e28c83e4ea6bc4741f_full.jpg'),
            array('MIKELEN', '76561198250665296', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/74/74f266ff8337760788c9fe9b102a313d92d11b55_full.jpg'),
            array('Kerreg', '76561198049974715', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e9/e928a8454d472a20f4e4a77894b27b69bc33a99a_full.jpg'),
            array('MR.DR.FADE', '76561198049675004', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/38/385ef396e77974e88427addd05ff2b3548d59387_full.jpg'),
            array('Alec.', '76561198021476635', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a0/a07a24149e71d58df6e1e5b95346f2e2827da2c3_full.jpg'),
            array('Pixel', '76561198222574232', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ec/ec797238683faa5d42857d451fa1d740e4dcb324_full.jpg'),
            array('mASTERY', '76561198124155748', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/03/039dead147866dff230d2ebbbf60b70a8982d9ff_full.jpg'),
            array('KGN', '76561198075983440', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/74/74650d06068804c74662e273725fcfd26ffca4f3_full.jpg'),
            array('DACX', '76561198045387138', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e0/e054443cb5dd469ac6819696f29304aa2fa642af_full.jpg'),
            array('PIGGIES', '76561198079272684', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/9a/9a8d32f125098f0d37ba4357ec3065611cb596f3_full.jpg'),
            array('Nordsee', '76561198111020129', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/58/580394b76c73f4f7c4275344b69ecd146fa79342_full.jpg'),
            array('Yesrock', '76561198162141927', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/db/dbb52f289b3842d8095a5637bd4098a47024aa32_full.jpg'),
            array('Gofer', '76561198051399308', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/50/50e3a1e80dabd09facd07a2d5aff0b4cde1ab3f5_full.jpg'),
            array('vvombat', '76561198040081090', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/7c/7ca70c066a0268ae1da80c1c08798418c3170d75_full.jpg'),
            array('L2-R4MS3', '76561198050152428', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/6d/6d79c9cf6b171297a3fee10987a79f5c0403f3f5_full.jpg'),
            array('EiseN', '76561197997765804', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/3d/3d087c35794487e4ef9486b47174180d6b6d7ddc_full.jpg'),
            array('zenden', '76561197989749908', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/6d/6df93bfb184ab937f05094d829a66bcd39f59bb6_full.jpg'),
            array('strolchy', '76561197990029067', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/b9/b92d5e4e3c13fab3b84a85883a139bd66198933c_full.jpg'),
            array('STFN', '76561197973161332', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/8e/8e1c8169a9fce02161af1d562599c727253e1a74_full.jpg'),
            array('plato', '76561197986003636', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c3/c39437201ebb37cf938482a83fa2582dedabf31e_full.jpg'),
            array('Obi789', '76561197986723860', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c1/c136208e740dd15cd8c4d5f37c99248ee80ce392_full.jpg'),
            array('CREEPEN', '76561198043271837', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e3/e359925260c8b17f3663d5989dfa3631ceae61b9_full.jpg'),
            array('cyn.n', '76561197981539330', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/50/506736a93d726f64d151d2f54dde822e75a48ec0_full.jpg'),
            array('GERDES', '76561197983677460', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/d4/d42ad2e5319fb8010f0c9c10f8f83d7c8a6a16cb_full.jpg'),
            array('cHap', '76561197980891330', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/07/079ac4c7f287f653a08a5404c10f44f13713abc9_full.jpg'),
            array('Karabazz', '76561197967742433', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ea/ea95b763ab6799d8485b6f82037d3a9ea5b35915_full.jpg'),
            array('keegan', '76561197990958487', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/1b/1b7e68898d8c370ebabef11b9cc2856f0f5cb3d1_full.jpg'),
            array('kaspJESUS', '76561197999830172', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/27/27eb4b6f9caf9df89676901245acbbd9315ef07a_full.jpg'),
            array('inetmist', '76561197989498397', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/1e/1e49e2ec7889e1688dbce65a70941c381cb431ff_full.jpg'),
            array('SyNapse', '76561198061020647', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/bb/bba63f8abf6bc621f5c9886cf1090a6cce7d8a18_full.jpg'),
            array('ZoKey', '76561198138359290', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/bc/bc7c7771bac761ecfe5c294534f4065ec58591b3_full.jpg'),
            array('unRayo', '76561198123970892', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e7/e78ab3a323724a95573c583d3f33f9f8b0697a95_full.jpg'),
            array('TeaCheR', '76561198020411566', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c3/c3fc66a1f264914eedf986a1e31e551762cdd724_full.jpg'),
            array('Julie Luck', '76561198169435519', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/38/380c423b525a6a5ae43da5936983e54b98bf2294_full.jpg'),
            array('dmk', '76561198130975885', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/64/646e22407bdd8e5a64393e484eb7dc6a067606f8_full.jpg'),
            array('64H', '76561198116797507', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/22/228c71a2fc8aa26fcaba0045b45dbbe90c042a18_full.jpg'),
            array('GaMeOver', '76561197999352674', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a5/a586a8faadf9b9170df343952f65b8a71c11f4be_full.jpg'),
            array('bR@AscA', '76561197984688825', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/21/218f13dcdecb30d421541cdc3ea39d0b23522f1f_full.jpg'),
            array('AlexKIO', '76561198149966325', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/b5/b5d5d4c065d11d341e6b0a0d8488a793c6ac666f_full.jpg'),
            array('Nigguh.Plz', '76561198054596137', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/87/87f6dd9e9a6d964048258d41885a5082dce0cbc2_full.jpg'),
            array('Papy', '76561198145499735', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/af/af5af63aebbc9e34c75ae61c23ae8e5611c071d6_full.jpg'),
            array('Kappa', '76561198227338344', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/4a/4a52159edd014e487866cd017dd7c2dfc90063b1_full.jpg'),
            array('Jones BBQ', '76561198055508445', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/34/34b9b988a4f32dfdd0305f5bc5cfa0877ef7d0bd_full.jpg'),
            array('FeeFe[e]', '76561198053635965', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/13/1389ac6363dcc56163704b9c1bccb64dd940b1be_full.jpg'),
            array('MaNeVRa', '76561198204822781', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/73/730211fd48ddad62559da51f7f6601d4a716c13d_full.jpg'),
            array('Real1zm', '76561198188403154', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/fe/fe07307941e9ecb48f827e741146706c4e5f8c39_full.jpg'),
            array('kzuyEx', '76561197961956999', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/0c/0c3871864814b11d9cfae5d4e036034951e6208e_full.jpg'),
            array('Ezra', '76561198105753774', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/49/49c5f53cc893a91088edc4349ba0c798cbaefbac_full.jpg'),
            array('Cyan', '76561198157465362', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/90/90c78c66fe9d59dedf74a4a6f8b6bb4877a82a54_full.jpg'),
            array('M1D0R1US', '76561198060878141', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/31/317bc8d35aa455b282924ffc6e5d7ff5180c0b4c_full.jpg'),
            array('MuLLdOx', '76561198137486260', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ac/acd7d630f6d1590daaddb5993974ebe3a299946a_full.jpg'),
            array('Tharic', '76561198026698310', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c4/c40b25727655f5b75adb7095fb5f7a9658e0bde3_full.jpg'),
            array('Black Sheep', '76561197977710084', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/96/96f04d439a90de8dc2d566d4adbdffd7774d28c3_full.jpg'),
            array('Emperor', '76561198152607971', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/aa/aae9e2b39e6a2c4fca8459825af541f72cfe4537_full.jpg'),
            array('NoWay', '76561198039029832', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c3/c3ec837685ff8c9e7d0f9824b16080febbe895f1_full.jpg'),
            array('Sweet@Silence', '76561197972147499', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/7d/7ddba9541e6abfc77edaa2230c59c837c638807c_full.jpg'),
            array('b34r', '76561197972337484', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/5c/5ce5be977690407333d28a7228a391f9813f73ee_full.jpg'),
            array('Kenny', '76561197978463610', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/28/28fb899be7c6744ef19791421d85ccfef0c43dad_full.jpg'),
            array('Fidrin', '76561197973086647', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ac/ac042c99b1bb4d3add11fdbd8d4fa719dcdc27bb_full.jpg'),
            array('Leo', '76561197982217767', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/36/36eda65f30d8a21f625e6c37ac3bab801c8dccb4_full.jpg'),
            array('BryndZiu', '76561197987128045', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/44/444d68d8353e2a7bf89f2513df20db235b352292_full.jpg'),
            array('Wertygo', '76561198015010828', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ba/bade4de6422163f7c9013d8f5d2c8dc74b418bf8_full.jpg'),
            array('ziege450', '76561198023734458', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ce/ce280f2bf6f8aa1896cb725324bb5e8d15b318b5_full.jpg'),
            array('DoT', '76561198043166080', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/dd/ddbf659dde81d57f83eef0a1841a501e5e719bd4_full.jpg'),
            array('Just La', '76561198049165726', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a8/a8617b4cf8ff32bdfa492e1eef1f8d601ea25c5e_full.jpg'),
            array('sugi.mil', '76561198052208127', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/53/536be4f4bffde65b5189adb83eea6088e07f6a85_full.jpg'),
            array('Allahedim', '76561198044311518', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/52/52ce33fee082beed17b7b378a6b0959be221e294_full.jpg'),
            array('wwwwww', '76561198056763446', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/60/605a01e1672f44164f7584ca1d6740e4b5cf4db1_full.jpg'),
            array('Money', '76561198060381418', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/21/21b223d07f733e1617209e58dc0ab2de10ab84f8_full.jpg'),
            array('Pr1zeee', '76561198062729864', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/f7/f71e490539206106a9a50aa34662e81b6f19887e_full.jpg'),
            array('angeL', '76561198060080400', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a2/a2824447c3be330cf5230c63c3bac698eca27a85_full.jpg'),
            array('Darth Maul', '76561198057998830', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/29/2919e12c7b2bd615591a7684e9f5d74ecabf0b78_full.jpg'),
            array('NeXCSGO', '76561198077304223', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a4/a45947113bd06cfbea90ebf74fa79c94b836a8b8_full.jpg'),
            array('Keistl', '76561198075873027', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/d3/d3d26f71b4659a0302d622c8a2632937bf9bc2e1_full.jpg'),
            array('Poopybutthole', '76561198099665063', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/03/0342a022715a921f587e63c1cb39440a6d427093_full.jpg'),
            array('mjoel', '76561198034087601', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/99/996df0b74b051e06b491beb0f9f1be5d696d771f_full.jpg'),
            array('Jun Yong Lee', '76561198074995019', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/e0/e07086cd0c418f74e893028feb7f16b5ed52559b_full.jpg'),
            array('Frank', '76561198148000808', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/d7/d7b1684179069c68adbfc8652e1c42644af0fa66_full.jpg'),
            array('Arfington', '76561198102782667', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a3/a389cbbb652234e7ba97c089b4fd4eab946836d3_full.jpg'),
            array('Mikaela', '76561198162165468', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/00/00ffa0610244ce4e797f46f138b2674850b5094f_full.jpg'),
            array('Scottiyio', '76561197988911399', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/e9/e9e5d5b3637f3d1757467c01dc1183e5d96f380d_full.jpg'),
            array('elax', '76561198055544760', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/81/8142d31a3fa58eba348e8ed45d9eba954c06d6d5_full.jpg'),
            array('Smurf', '76561198055291268', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/26/26790b6f1a47817fea9f680a60f1a3683e48bc78_full.jpg'),
            array('kakomonsta', '76561198113350876', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/b3/b373f9945a8d0ce914ab57dea704db4cb82a63ce_full.jpg'),
            array('Chakinator', '76561198170826882', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/20/208cf4d40e3d44c7f4df6a8c30728512a19cf380_full.jpg'),
            array('sterniT', '76561198074788308', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/f5/f59c94c32f0c7b58b57ad666b500642ce0b9c72d_full.jpg'),
            array('Brad', '76561198152240534', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/a2/a2638228606d2978fecaecb735df1904804db462_full.jpg'),
            array('Mariah Carry', '76561198035173082', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/19/19750f74a53a46671185fbd360b1e1d03b0a0ee5_full.jpg'),
            array('BLANKIO', '76561197965880510', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/13/13ef786e4f11da627c3956151427c000d0dc0a5b_full.jpg'),
            array('Terwater', '76561197972042194', 'https://steamcdn-a.akamaihd.net/steamcommunity/public/images/avatars/c1/c15e9173863a80096756bfd0b8b7bb69919c8be6_full.jpg'),
            array('The Dentist', '76561198215066467', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/f0/f058bcfce72748f5e4e43d32999a40c5970938d9_full.jpg'),
            array('Saitama', '76561198112330790', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/80/80aa2ba12306df3cc7ddc7716dcd610f2914a1ae_full.jpg'),
            array('Blockinho', '76561198142818170', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a9/a9f938523d5dbc741cc28baa61cfccfcabc6dae8_full.jpg'),
            array('Blade', '76561197974901264', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/df/df1b73194a446c65089f584d6ec7cc3fe2c026ac_full.jpg'),
            array('Mr.Fawk', '76561197989854161', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/fa/fa6e6cfb9253960e9b673a6051fbb28a23150e65_full.jpg'),
            array('CharlestONE', '76561198077663556', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/25/25c6b0cc8fd0f62d2f1b928b37ef8470c2fcaaa4_full.jpg'),
            array('Ufomaniac', '76561198028113109', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/5d/5ddf8dcd696a5928cc416810bf4a411f49d5ed71_full.jpg'),
            array('nOOaim', '76561198126754789', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/8c/8c8398f5b63f9ea42b7e82070c544268879a1895_full.jpg'),
            array('Pimba', '76561198038668119', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c9/c98eb7948894c54d8993deb2bf4c84b7b3c9c30a_full.jpg'),
            array('happy heaton', '76561197961559713', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/d1/d1f51a7e4ac34a02abe4b0a29246d50878a44696_full.jpg'),
            array('УТИНАЯ КОТЛЕТА', '76561198019561670', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a6/a6576cb649a03ad60e72f06753213d077f9bfa84_full.jpg'),
            array('nOOberto', '76561198054587526', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/51/51ad0f6c55738802d31d75ba94e43fd3e08352e6_full.jpg'),
            array('Mr.Kalashnikov', '76561198046271207', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/b6/b65dd6e22c24103f4925dd3c404f1717b1251d3f_full.jpg'),
            array('Arrej', '76561198021369975', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/2b/2bbaa00297a51f8af00d23042745a530f67d5d14_full.jpg'),
            array('JWonderchild', '76561198093798736', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/fd/fd06585f1f3325a53c74c59cd74b4e78ae8fb2a6_full.jpg'),
            array('pew pew', '76561198080762118', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/73/73d5b525082936f9942c3e6ad15ff272fd625b41_full.jpg'),
            array('shady', '76561198067692366', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ca/ca856d59584002ba6dee19d121060e26e2daa2ae_full.jpg'),
            array('Megamanzap', '76561198236542780', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a0/a050167dd3722e1533f1f18b2bfe3f770155a938_full.jpg'),
            array('SestY', '76561198129951963', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/b3/b3b6219062f728319c92d27cecc8f28554117aff_full.jpg'),
            array('roly', '76561198045598892', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/11/11f18412296a31f9099d9cec34c967bcced3982f_full.jpg'),
            array('d1mqua', '76561197972555277', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/6c/6c75289dd97e231de9a3644255814bed4b5490de_full.jpg'),
            array('Eyepatch', '76561198061758930', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ef/efdd7c7121f1e810c6e3e291f98f0cb91ee629ef_full.jpg'),
            array('Marly', '76561198036710911', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/f8/f82274ed9ef1d6ece24db6ef1cd55b4b53439f04_full.jpg'),
            array('Gummy', '76561198076129713', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/bb/bb75d786edc53cf6f7081c69217cf98b86333b3b_full.jpg'),
            array('SleyDer', '76561198085611516', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/dd/dd226bc6fdf528acc7e96bbc2bc57e2f02d02036_full.jpg'),
            array('reicharx', '76561198074656206', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/61/61c27d9c1623116ab5047eb075db94057695780f_full.jpg'),
            array('J4V!X', '76561198263387426', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/60/604e2359b6d55f0e2d489d38ca18a510403f5e49_full.jpg'),
            array('Kauppisen Pete', '76561198169693588', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/30/301a1f734532e17ab1cd5f4761f2158cc61664b0_full.jpg'),
            array('ZeRo', '76561198007323345', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/91/916a18db992cfbe3d9a2f6ab775283d3aeace6b3_full.jpg'),
            array('Jes', '76561198143284053', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c7/c75c4cf782c53c53d7df1d39998f9c4befce0968_full.jpg'),
            array('Brrieosto', '76561198258770136', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/dd/dd8fd465191ed7a2702cefd639585bd916e40394_full.jpg'),
            array('Yylia ^^', '76561198253034626', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/0c/0c2b2969c774e316c94fb5ef06ad8f40c482a518_full.jpg'),
            array('Herzug', '76561198148790201', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/5b/5b30112970241abaf0290080e97c40b75226ab53_full.jpg'),
            array('ROCKBOY', '76561198057103681', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/3a/3a60a8340339d8ebf8c3f3ac4233996e4381c8c0_full.jpg'),
            array('Lxzze', '76561198126698038', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/54/54d2602fe9be1a74e02e328f471402088ddf7591_full.jpg'),
            array('HanSolo', '76561198220537192', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/de/de5ed22604c2f01022812572502c6ab3eb28504c_full.jpg'),
            array('Morlurn', '76561198257736364', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/27/2769fcbbb119b674e75793719e012cf58aa7b3c4_full.jpg'),
            array('Dave', '76561197987752556', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e0/e0d20647ac72394ced2c7b2e57803ae83c4440fa_full.jpg'),
            array('oHRis#70', '76561198194789066', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ac/ac15e217d5b149fd618cb244b555f355e03d91d7_full.jpg'),
            array('Mid Player', '76561198092529185', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/df/df420e855204b4fb91f1c341f679ee8029e352a4_full.jpg'),
            array('Krosts', '76561198038968402', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/66/66ccc07e20d979d106256c46c36a091713be3632_full.jpg'),
            array('Marty McFly', '76561198098653631', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/b5/b551024a072ff86d38e9e6edece4234501163801_full.jpg'),
            array('NamoR', '76561198068217287', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/f4/f41d930de13b1245d20a3235687175abb5582420_full.jpg'),
            array('7*', '76561198184555282', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/83/83339af7599826ffb134c1531b4fabbdf1701b78_full.jpg'),
            array('Saftarn Baloo', '76561198176631623', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/1a/1a31e25012507a5f281b3fdc2ba073aef43ad0d6_full.jpg'),
            array('Alexxo', '76561198096894043', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/9b/9bdc94edac147ea1da263268d72c16daf0f8ee4f_full.jpg'),
            array('F30 Power', '76561198241528504', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/16/1664b8ef44ee4f46e954491da60445d64765df97_full.jpg'),
            array('Magzi', '76561198161174362', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/9e/9ee5bd00254028371afcfcbec4e39b4f9ba79bb3_full.jpg'),
            array('QOZQOZ', '76561198003423453', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/be/bee71f8a2fd7d4d3963c2eb996d8ee0449a4d634_full.jpg'),
            array('dubya', '76561198118622175', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/db/db88df65c91d1ce82827dd2335e94f89d2112911_full.jpg'),
            array('YASHATRICEPS', '76561198115786814', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/0b/0b25bd29f75b74262c313f15e717e665750418c1_full.jpg'),
            array('cyron.', '76561198084188278', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/96/962686bc12240fa84758e3d674eeaf42e1140151_full.jpg'),
            array('Stiff', '76561197973284154', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/32/329a4228bed5c8efed8a3be1c4bb85b85824c1eb_full.jpg'),
            array('Akuma', '76561198141838616', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/eb/eb614245de9075e3a7614c52894bccbd1d0447bf_full.jpg'),
            array('Z!dane4eG', '76561198059446099', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/12/12c7f55e5838ca98a6ab3410f383979868b17367_full.jpg'),
            array('Ta6yPeTKo', '76561198025590646', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/10/10e9ddd9f8f293691ac421b3a206fa02fdda4aa6_full.jpg'),
            array('GoR', '76561198059629425', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/34/34cc14ef7953299dcc29b2796256840f7ab9d543_full.jpg'),
            array('Riptide', '76561198102413738', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/08/08ead657c1b6469a6d9f571e975f28aef64a44e6_full.jpg'),
            array('braH', '76561197983857427', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/01/010496457d75126f40cb32670ca1a51074c32cf8_full.jpg'),
            array('FalconS', '76561198041861112', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/37/378139fed614898104de2287588b1764f69a9b65_full.jpg'),
            array('CAVEMAn', '76561198000601801', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/55/55466a72ed5e4e27c8c6f84850a1f6ff974b1d9e_full.jpg'),
            array('Slip', '76561198040591062', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/1f/1f1aff7f6bd67f56d24e3c963b19bfe18296be1d_full.jpg'),
            array('Aratilar', '76561198257740558', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/0b/0b8177326249833d858ff14c153292e1622a0f69_full.jpg'),
            array('Eligor', '76561198124687297', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/18/18fc3282c85573cb77fb0965681d64ddd37011d2_full.jpg'),
            array('Markiza', '76561198200934383', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/54/5401c975b21e759238821db269a0ae5711334435_full.jpg'),
            array('dikiy', '76561198203269392', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/17/17d61cd3c19883fb6e0b19706b50f6afba25aee5_full.jpg'),
            array('71Miha71', '76561198183169747', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a5/a5db706da3f66021ae4b6aecd0511043b640acac_full.jpg'),
            array('OXXXYMIRON', '76561198218407728', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/f8/f887dfcfc77fd7a582960710611de81f2799289c_full.jpg'),
            array('No morals', '76561198173750277', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ce/ce73e3078e773540e859919ba85215e6a18c343a_full.jpg'),
            array('Аллах', '76561198260196765', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/60/608eaa579d5709fdbf72dc6ca23c95ca402843e6_full.jpg'),
            array('adrenalin', '76561198112576765', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/fd/fdb60f67c22492b840ad96c91708d7923caadf71_full.jpg'),
            array('YouKnow', '76561198123342025', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg'),
            array('Medzy', '76561198132091276', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/6e/6ec93f8bf3ebe5bc0c814ffe9b1ebfb1e24422a2_full.jpg'),
            array('n1ce_sn1p3r', '76561198215696772', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/61/614e2b4497d9fae7920868ba0421bef603fe104c_full.jpg'),
            array('!mQ', '76561197990886894', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/4a/4a05f63a09ac24eeb7fb47a4fba5b91a6636f310_full.jpg'),
            array('Execution', '76561198155754315', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/47/47c3c623cb1184501b0a5ad59bc42fca0f6439b5_full.jpg'),
            array('Kartoffel', '76561198060980933', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/09/09cf8e936c82da8e9f33a4a8d64c919f9f860b7a_full.jpg'),
            array('Jack_Hellstone', '76561198067903364', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/19/19d98d97be2283d9ca67e8ed448ed52a2be28c17_full.jpg'),
            array('Silent Death', '76561198107227143', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/26/261a02f8c01b4012072bdcddd41dc3c0a389ab4c_full.jpg'),
            array('BangKiller', '76561198049867970', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/d3/d33447dd38c40bb7e301374a09b0c763c0996d94_full.jpg'),
            array('АХХИЛЕС', '76561198269119421', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/fe/fef49e7fa7e1997310d705b2a6158ff8dc1cdfeb_full.jpg'),
            array('BORODATED EVIL', '76561198124538748', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a8/a8bdc0d99ee4e2cf5f0d6e36de9acb010322e291_full.jpg'),
            array('h1t_man', '76561198177863343', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/b4/b4cb2c348a04c47484d547d7bc82ab973c41df6a_full.jpg'),
            array('PenGuin', '76561198238349670', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/4d/4dd283d3a6a464d5483b8dcaed9a4cb830c3f6ca_full.jpg'),
            array('Mack3L', '76561198108849464', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/9e/9e0fbd7e3b020050626bf9cea0886350e785834a_full.jpg'),
            array('Dr3bs', '76561198035101448', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/0d/0dbbfe78313d3cd0512158a42ffd620ce081244a_full.jpg'),
            array('Boss', '76561198096041900', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/07/0789568d347c8c3b5deeb0f2144234a3620b7e3d_full.jpg'),
            array('Wladimir Putin', '76561198267416008', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c9/c99f90ed743a7dce5286504bcd177123d8d16a1f_full.jpg'),
            array('Creatttor', '76561198172356565', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/88/88247b164426d2d5b88f2c1edd96c458d348c366_full.jpg'),
            array('SUDA IDI', '76561198077229891', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/b6/b640359f00aa3a516c94aa542e1d6b115a376311_full.jpg'),
            array('Siragas', '76561198257743081', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/49/49e8d81ac08a20c9edd005412b45e0eb779d8cfe_full.jpg'),
            array('Goga', '76561198208283916', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/c4/c41f1bead08eea293eb1ddbd1af6516eaede1177_full.jpg'),
            array('I love beer', '76561198193724797', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/a1/a11c675d71a2643d90ba27a01f75071e9c1d27f0_full.jpg'),
            array('!Hor', '76561197987113358', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/2a/2aaf7f6e76113fde28d4e56253f383d5cfd04348_full.jpg'),
            array('#PatGum', '76561198070746064', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/97/97be2254d7f08ff036f348b3f579dbe3b083eca7_full.jpg'),
            array('NotNub', '76561198048733716', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/ae/aeba93bc712c2558f457405e19d40f9596cb667a_full.jpg'),
            array('Magikx', '76561198204488572', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/21/2137110c2db3fd6619d77490b8656632385278cb_full.jpg'),
            array('freaKo', '76561198047849207', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/65/651d8f3c1462e4b6d64a4677992e99c9fdb9e170_full.jpg'),
            array('WICKEDONE', '76561198068698307', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/e2/e2606951ac1ad630fd5c852d41b0b7d8f84790b8_full.jpg'),
            array('MerBear', '76561198120084725', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/23/2376249151a258bc2d31e0c07b5661ef4a6d1b76_full.jpg'),
            array('Andy Bernard', '76561198261889531', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/f3/f32bf13ed1c763b819eda7410e668e169f66f148_full.jpg'),
            array('Dozilkree', '76561198257747735', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/08/084084caa9e4e8b9e702cbf53cf6c52991a43c50_full.jpg'),
            array('ИOИAME', '76561198046683739', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/33/3397f5a04982c09f570b1a57fb3dbd623328e04a_full.jpg'),
            array('Windblade', '76561198262252969', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/09/09f2b3305722e71ef1779be3e21eb38991a0405f_full.jpg'),
            array('notriXxX', '76561198128084782', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/44/44c3b378b44a678cc51bc65e57b7a1cabffb0457_full.jpg'),
            array('Pessto', '76561198026544982', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/df/df205fdfd3e5b51c5961c599f052510ab0996fd8_full.jpg'),
            array('intelligent fool', '76561198104692340', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/9c/9c43603abcd6c4ebe698498176463d2cfe577d39_full.jpg'),
            array('47', '76561198079238477', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/31/31cfff12f8febe9124ebea417f90b8e1003707ff_full.jpg'),
            array('B191N', '76561198078423592', 'http://cdn.akamai.steamstatic.com/steamcommunity/public/images/avatars/6b/6b0c7b844f1462427809ca2c560bd210bdbfb0cd_full.jpg'),
        );
        foreach($fake as $is){
if(is_null(User::where('steamid64',$is[1])->first())){
            User::insertGetId(['username' => $is[0],'steamid64' => $is[1],'avatar' => $is[2]]);
}
            $fl[$i] = $is;
            $i++;
        }
        return $fl[1];

    }

    public function fake(){


        $user =  User::whereBetween('id', [419, 618])
            ->orWhereBetween('id', [99, 199])
            ->orderByRaw("RAND()")->first();


        // $user =  User::where('id','>',98) ->where('id','<',200)->orWhere('id', 209)->orderByRaw("RAND()")->first();
    $items = Items::where('counts','>',0)->where('price', '<' , 5000)->where('price', '>' , 10)->orderByRaw("RAND()")->first();
        $items->market_name = str_replace(' (После полевых испытаний)', '',  $items->market_name);
        $items->market_name = str_replace('(После полевых испытан', '',  $items->market_name);
        $items->market_name = str_replace(' (Прямо с завода)', '',  $items->market_name);
        $items->market_name = str_replace(' (Закаленное в боях)', '',  $items->market_name);
        $items->market_name = str_replace(' (Немного поношенное)', '', $items->market_name);
        $items->market_name = str_replace(' (Поношенное)', '',  $items->market_name);
        $name = explode('|',  $items->market_name);
      $item =   ["fullname"=> $name[0],"spacename" => $name[1],
           "type" => $items->type,"classid" =>$items->classid, "item_id" =>$items->id,"price" => $items->price];
        $case = Cases::find($items->case_id);
        $this->redis->publish(self::NEW_WINNER, json_encode(["status" => "success",  "user_id" => $user->id, "userName" =>$user->username,
            "firstName" => $name[0] . " | " . $name[1], "type" => $items->type, "classid" => $items->classid, "caseimage" => $case->images]));
       Game::insertGetId(['status' => 1,'price' =>  $items->price,'userid' => $user->id,'case' => $items->case_id,'weapon' => json_encode($item),'item_id' => $items->id, 'buy' => 1]);
        return response()->json(["status" => "success"]);
    }
}