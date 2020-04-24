<?php

namespace App\Console\Commands\Tool;

use App\HttpClient\CQHttpClient;
use Illuminate\Console\Command;

class ZQQBotTmp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:zqqbotTmp';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

    }


    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $client = new CQHttpClient();
//        $result = $client->getGroupList();
//        $result = array_map(function($item){
//            return $item['group_id'];
//        },json_decode($result,true)['data']);
//        dump($result);
//        return ;

        $counter = 0;
        $faceCQ = "";
        for ($i = 5; $i < 100; $i++) {
            $faceCQ = $faceCQ."\"$i\":\"......\",".PHP_EOL;
        }
        echo $faceCQ;
        foreach ($this->data2 as $message) {
            break;
            $result = $client->sendPrivateMsg('2776404988', date('Y年m月d日 H时i分s秒') . PHP_EOL . '[CQ:face,id=' . mt_rand(1, 182) . ']' . $message);
            dump($result);
//            $result = $client->sendPrivateMsg('982947456', date('Y年m月d日 H时i分s秒') . PHP_EOL . '[CQ:face,id=' . mt_rand(1, 182) . ']' . $message);
//            dump($result);
//            $result = $client->sendPrivateMsg('1344958020', date('Y年m月d日 H时i分s秒') . PHP_EOL . '[CQ:face,id=' . mt_rand(1, 182) . ']' . $message);
//            dump($result);
//            $result = $client->sendPrivateMsg('784754921', date('Y年m月d日 H时i分s秒') . PHP_EOL . '[CQ:face,id=' . mt_rand(1, 182) . ']' . $message);
            $result = $client->getGroupList();
            dump($result);

//            $result = $client->sendGroupMsg('224219634', '[CQ:at,qq=2321213675] ' . PHP_EOL . '[CQ:face,id=' . mt_rand(1, 182) . ']' . $message);
//            dump($result);

            $sleepTime = mt_rand(1, 10);
            dump('sleepTime:' . $sleepTime);
            sleep($sleepTime);
        }

        return;
    }

    public $dataArr = [
        '我的心分成两半，一半因为责任留给我的妻子，另一半留在新桥底下，用此一生来思念你。',
        '人生那个东西，也许只是在一段刻骨铭心之后才算是真正的开始，但有时候想想，徒留遗憾罢了。',
        '生活就像一盒巧克力，你永远不知道你会得到什么。（励志电影）',
        '世界上总有一半人不理解另一半人的快乐。',
        '上帝会把我们身边最好的东西拿走，以提醒我们得到的太多！',
        '好多东西都没了，就象是遗失在风中的烟花，让我来不及说声再见就已经消逝不见。',
        '我听别人说这世界上有一种鸟是没有脚的，它只能一直飞呀飞呀，飞累了就在风里面睡觉，这种鸟一辈子只能下地一次，那边一次就是它死亡的时候。',
        '“小时候，看着满天的星斗，当流星飞过的时候，却总是来不及许愿，长大了，遇见了自己真正喜欢的人，却还是来不及。”',
        '我觉得生命是最重要的，所以在我心里，没有事情是解决不了的。不是每一个人都可以幸运的过自己理想中的生活，有楼有车当然好了，没有难道哭吗？所以呢，我们一定要享受我们所过的生活。',
        '有信心不一定会成功，没信心一定不会成功。',
        '有人就有恩怨，有恩怨就有江湖。人就是江湖，你怎么退出？',
        '当你年轻时，以为什么都有答案，可是老了的时候，你可能又觉得其实人生并没有所谓的答案。',
        '最了解你的人不是你的朋友，而是你的敌人。',
        '爱情这东西，时间很关键，认识得太早或太晚，都不行。',
        '生命中充满了巧合，两条平行线也会有相交的一天。',
        '我手上的爱情线、生命线和事业线，都是你的名字拼成的。',
        '我要你知道，这个世界上有一个人会永远等着你。无论是在什么时候，无论你在什么地方，反正你知道总会有这样一个人！',
        '当我站在瀑布前，觉得非常的难过，我总觉得，应该是两个人站在这里。',
        '我一直怀疑27岁是否还会有一见钟情的倾心。我不知道该说什么，我只是突然在那一刻很想念她。',
        '我以经老了，在人来人往的大厅，有一位老人他向我走来，他说我认识你，那时的你还很年轻，美丽，你的身边有许许多多的追求者，不过跟那时相比，我更喜欢现在你这经历了沧桑的容颜？',
        '当你不能控制别人，就要控制你自己，赛车和做人一样，有时候要停，有时候要冲。',
        '人生下来的时候都只有一半，为了找到另一半而在人世间行走。有的人幸运，很快就找到了。而有人却要找一辈子？',
        '每天你都有机会和很多人擦身而过，而你或者对他们一无所知，不过也许有一天他会变成你的朋友或是知己。',
        '我们最接近的时候，我跟她之间的距离只有0.01公分，57个小时之后，我爱上了这个女人。',
        '不知道从什么时候开始，在什么东西上面都有个日期，秋刀鱼会过期，肉罐头会过期，连保鲜纸都会过期，我开始怀疑，在这个世界上，还有什么东西是不会过期的？',
        '其实了解一个人并不代表什么，人是会变的，今天他喜欢凤梨，明天他可以喜欢别的。“',
        '我知道爱情的感觉会褪色，就像老照片，而你却会在我的心中永远美丽，到我生命的最后一刻。',
        '其实”醉生梦死“只不过是她跟我开的一个玩笑，你越想知道自己是不是忘记的时候，你反而记得清楚。我曾经听人说过，当你不能够再拥有，你唯一可以做的，就是令自己不要忘记。',
        '一直以为我跟他不一样，原来寂寞的时候，所有的人都一样。',
        '每个人都有失恋的时候，而每一次我失恋呢，我就会去跑步，因为跑步可以将你身体里面的水分蒸发掉，而让我不那么容易流泪，我怎么可以流泪呢？在阿美的心中里面，我可是一个很酷的男人。',
        '其它星星都换了方位，北极星依然会在原地，当别人不了解你、不原谅你，甚至离开你，只要我守在原地，你就不会迷路。',
        '爱一个女孩子，与其为她的幸福而放弃她，不如留住她，为她的幸福而努力。',
        '我爱你，不是因为你是一个怎样的人，而是因为我喜欢与你在一起时的感觉。',
        '对于世界而言，你是一个人；但是对于某个人，你是他的整个世界。',
        '在遇到梦中人之前，上天也许会安排我们先遇到别的人；在我们终于遇见心仪的人时，便应当心存感激。',
        '在你感到寂寞无助的时候，你可以去大自然中，你可以从每一棵树，每一朵花上面，感觉生命无处不在，感觉上帝就在我们身边。',
        '我今天来这里并不抱任何期望，我只是想告诉你，我的心将永远属于你？',
        '我知道最终我还是要走的。我一直这么提醒自己，让自己在每天醒来的时候喜欢你少一点，在离开的时候就可以轻松一点。',
        '即便互相伤害，我们也不会分开，只要两人在一起，尽管有时会受伤，伤口总会愈合的。因为我听得见他心里的声音。',
        '我早上到海滩看日出，我知道从今以后一切会不同，这是一个新的开始，就在此时此刻，我不管别人怎么说，我无法控制自己，我有点喜欢你。',
        '我情愿做个犯错的人，也不愿错过你？',
        '我并不是每次吃完饭就看电视，有时我边吃边看电视，生活中有些改变会增加乐趣。',
        '这么多年我一直以为是我赢了，其实不是，我一生最美好的时光没有和自己最爱的人在一起。',
        '人生不如意的时候，是上帝给的长假，这个时候就应该好好享受假期。当突然有一天假期结束，时来运转，人生才真正开始了。',
        '其实爱情是有时间性的，认识得太早或太晚都是不行的，如果我在另一个时间或空间认识她，这个结局也许会不一样。',
        '为什么选择我？这个问题的答案很长，我需要用一生的时间来回答你。',
        '只要两个相爱的人在一起，哪里都是天堂。',
        '对真心相爱的人来说，对方的心才是最好的房子。',
        '我在想，你可能没有真正爱过一个人吧？你不知道一个生活在你身边的人，某天早上忽然消失的感觉，周围的一切都没有改变，只是你身边少了一个人，那种感觉像你这样的人会明白吗？',
        '我相信除了寂寞，缘分是男人和女人之间相爱的另一种原由。因为缘分而使两颗寂寞的心结合的爱情称为真爱。寂寞是每时每刻，缘分是不知不觉，真爱是一生一世。',
        '多希望地球是平的，那样，我一直望下去，就可以看到你。',
        '以前我认为那句话很重要，因为我觉得有些话说出来就是一生一世，现在想一想，说不说也没有什么分别，有些事会变的。',
        '有可能，他爱你，你却爱上另一个他，而你的他又爱上他的她，而他的她又只爱爱你的他……就这样，每个人的心里都住着人，但那个人却不见得是手里牵着的他。',
        '每个人都有一个习惯，我的习惯是在这里等阿MAY下班！',
        '对爱的人说心里话，不要等太久。',
        '我觉得生命是一份礼物，我不想浪费它，你不会知道下一手牌会是什么，要学会接受生活。',
        '当我渐渐觉得这个城市很冰冷的时候，遇见了你。',
        '不管再怎么痛苦、烦恼，即使说一定要忘记你，还是办不到，还是那么喜欢你，不能从这种心情中逃跑。',
        '我觉得比起早死，我更要感谢神让我降生到这世上来？？能够这样跟你相遇，这样被你爱着。',
        '”如果你不出去走走，你就会以为这就是世界。“',
        '人家说女人的水做的，其实有些男人也一样。一般人的初恋是在十几岁，而我呢，可能比较晚熟吧，或者是要求比较高吧。1995年5月30日，我得到了我的初恋。她就好像是一家店，我不知道能停留多久，当然，越久越好。',
        '十四年了，日子过的真快，对中年以后的人来讲，十年八年好像是指缝间的事，可是对年轻人来说，三年五年就可以是一生一世。',
        '为了记住你的笑容，我拼命按下心中的快门。',
        '赛车和做人一样，有时候要停，有时候要冲。',
        '然我不介意牺牲自己的感情，但是我真的很介意牺牲你。',
        '只有笨蛋才思考，聪明人用灵感，我们大多时间都是笨蛋，偶尔才成为了聪明人。事实上，我们一直是聪明人，突然我们觉得自己有点笨，然后，我们开始思考，于是，我们真的变笨蛋了。',
        '如果我和他真的结婚了，这也就不会成为一个故事了。',
        '一个男人要和一个女人一辈子永远不变生活在一起，是一种冒险，所以世上需要冒险王。',
        '”缘分不是这样的。俩个人相遇，你喜欢我，我喜欢你，这才叫缘分。如果俩个人都不喜欢，就算遇上几百万次，都不算缘分。如果一个喜欢一个不喜欢，喜欢的死缠不放，不喜欢的想走，那更不是缘分，是痛苦。',
        '好女人和好男人一样，总是在别人身旁。',
        '“爸爸说我们原本是天上飘下来的雪花，落到地上，结成了冰，化成了水，就再也分不开了！”',
        '我想我们必须马上分开，如果必要的话，最好在我们之间隔一个海洋，可是，我怕我的心会飘洋过海来看你。',
        '人生总许多的意外，握在手里的风筝也会？？突然断了线！',
        '现在很清楚，我向你走去，你向我走来已经很久很久了。虽然在我们相会之前谁也不知道对方的存在。',
        '她一直被爱情抛弃，当终于有天遇到了真正的爱情，她却不能好好地看清他。为什么世间的爱情总是要经过如此多的磨难？',
        '一九九七年一月，我终于来到世界尽头，这里是南美洲南面最后一个灯塔，再过去就是南极，突然之间我很想回家，虽然我跟他们的距离很远，但那刻我的感觉是很近的。',
        '每个成功男人的背后，都有一个女人。每个不成功男人的背后，都有两个。',
        '聪明人都是未婚的，结婚的人很难再聪明起来。',
        '爱情就象照片，需要大量的暗房时间来培养。',
        '应该有更好的方式开始新一天，而不是千篇一律的在每个上午都醒来。',
        '努力工作不会导致死亡！不过我不会用自己去证明。',
        '现在我终于明白了，原来每一段恋爱，只要在心里面，已经是天长地久。',
        '一段爱情可以带来多大的伤害，也一定曾经带来多大的快乐，爱情其实就是这样！',
        '暗恋一个人的心情，就象是瓶中等待发芽的种子，永远不能确定未来是否是美丽的，但却真心而倔强地等待着。',
        '承诺是男人给女人的定心丸。吃了安心，虽然这定心丸的药性有待考证，但女人都希望吃了再说。',
        '生命不必每时每刻都要冲刺，低沉时就当是放一个悠长假期。',
        '我不希望看到你流泪，除非是为了幸福。',
        '人生总有这么一个阶段，一个做什么也快乐的阶段，一个说什么也真诚的阶段。笑他们，皆因我们曾经荒唐过，爱他们皆因我们曾经甜蜜过。',
        '我真的很想念她，我现在才知道，原来想见一个人见不到的感觉是这样的。',
        '谁会了解，生命中的过客竟会让我如此感动，感谢你给我带来的一切',
    ];

    public $data2 = [
        '悟空你也真调皮呀！我叫你不要乱扔东西，乱扔东西是不对的。哎呀我话没说完你怎么把棍子扔掉了？月光宝盒是宝物，乱扔它会污染环境，砸到小朋友怎么办？就算砸不到小朋友砸到花花草草也不好嘛！....',
        '你干什么？',
        '放手！',
        '你想要啊？悟空，你要是想要的话你就说话嘛，你不说我怎么知道你想要呢，虽然你很有诚意地看着我，可是你还是要跟我说你想要的。你真的想要吗？那你就拿去吧！你不是e79fa5e98193e59b9ee7ad9431333332633037真的想要吧？难道你真的想要吗？……',
        '我Kao！',
        '哈哈哈哈哈！大家看到啦？这个家伙没事就长篇大论婆婆妈妈叽叽歪歪，就好象整天有一只苍蝇，嗡……对不起，不是一只，是一堆苍蝇围着你，嗡…嗡…嗡 <…嗡…飞到你的耳朵里面，救命啊！',
        '所以呢我就抓住苍蝇挤破它的肚皮把它的肠子扯出来再用它的肠子勒住他的脖子用力一拉，呵－－！整条舌头都伸出来啦！我再手起刀落哗－－！整个世界清净了。现在大家明白，为什么我要杀他！...',
        '姐姐，这是你的不对了！',
        '啊？',
        '悟空他要吃我，只不过是一个构思，还没有成为事实，你又没有证据，他又何罪之有呢？不如等他吃了我之后，你有凭有据，再定他的罪也不迟啊！',
        '唐三藏，你的罗嗦我早就听说过了，不过没想到你居然这么罗嗦！我给你的金刚圈让你用来制伏这猴子你居然不用！',
        '唉，那个金刚圈尺寸太差，前重后轻左宽右窄，他带上之后很不舒服，整晚失眠，会连累我嘛！他虽然是个猴子，可是你也不能这样对他，官府知道了会说我虐待动物的！说起那个金刚圈，去年我在陈家村认识了一位铁匠，他手工精美、价钱又公道、童叟无欺，干脆我介绍你再定做一个吧！',
        '我不会使你为难的。请姐姐跟玉皇大帝说一声，贫僧愿意一命赔一命！正所谓我不入地狱谁入地狱？求姐姐你体谅我这样做，无非是想感化劣徒，以配合我佛慈悲的大无畏精神啊！',
        '刀下留人！原来是自杀的，你为什么要自杀呢？',
        '我先杀了你！',
        '英雄啊！你放过我吧！',
        '放过你？你给我一个不杀你的理由！',
        '正在想……你给我个杀我的理由先！',
        '长夜漫漫无心睡眠，我以为只有我睡不着觉，原来晶晶姑娘你也睡不着啊！',
        '你把胡子剃光干什么？你知不知道你少了胡子一点性格都没有了？',
        '是吗？',
        '唉，文也不行武也不行，你不做山贼，你想做状元啊？',
        '我有想过……',
        '省省吧你！改变什么形象，好好地做你山贼这份很有前途的职业去吧！',
        '我知道了，我一定会继续努力的！',
        '大家不要生气，生气会犯了嗔戒的！悟空你也太调皮了，我跟你说过叫你不要乱扔东西，你怎么又…你看我还没说完你又把棍子给扔掉了！月光宝盒是宝物，你把他扔掉会污染环境，要是砸到小朋友怎么办？就算砸不到小朋友砸到那些花花草草也是不对的！',
        '你以为我不知道！(指着旁边一人)我骂瞎子谁让你惭愧？(一转身)你还跑－－！(追到一只狗面前)看看你这副德性，鬼鬼祟祟丢人现眼披头散发人模狗样，怎么跟我出来闯荡江湖，啊？',
        '长夜漫漫无心睡眠，我以为只有我睡不着觉，原来晶晶姑娘你也睡不着啊！',
        '我Kao！I服了You！',
        '放过你？你给我一个不杀你的理由！',
        '正在想……你给我个杀我的理由先！',
        '我明白了，你神经病！',
        '那我们大家立刻开始这段感情吧！',
        '悟空，你怎么可以这样跟观音姐姐讲话呢？',
        '哗－－！闭嘴！',
        '你又吓我！',
        '我爱你。如果非要在这份爱上加上一个期限，我希望是……一万年！',
        '悟空，你尽管捅死我吧，生又何哀，死又何苦，等你明白了舍生取义，你自然会回来跟我唱这首歌的！喃呒阿弥陀佛、喃呒阿弥陀佛、喃呒阿弥陀佛……',
        '喂喂喂，做人干嘛那么认真、冲动呢？',
        '爱一个人需要理由吗？',
        '不需要吗？',
        '需要吗？',
        '不需要吗？',
        '需要吗？',
        '不需要吗？',
        '尘世间的事你不再留恋了吗？',
        '没关系了，生亦何哀，死亦何苦……',
        '哈！我不是关心你，只是蝼蚁尚且偷生，神仙干成你这个样子，干脆不要干算了！',
        '人是人他妈生的，妖是妖他妈生的，如果这妖还有点人性的话，那他妈一定是人妖……',
        '悟空，你知不知道什么是铛铛铛铛铛铛？',
        '什么铛铛铛铛？',
        '铛得铛铛铛铛铛，就是(唱道)On--ly you--！ 能伴我去西经...',
        '哎……',
        'On--ly you－－！',
        '....',
        '背黑锅我来，送死你去，拼全力为众生！',
        '...',
        '我真的不行啊，我跟你说……',
        'On－On--！',
        'On你妈个头啊！你有完没完啊！(一拳将唐僧打倒)我已经跟你说过我不行了，你还要On-On-！On-On-！完全不理人家受得了受不了，你再On我一刀捅死你！',
        '悟空，你尽管捅死我吧，生又何哀，死又何苦，等你明白了舍生取义，你自然会回来跟我唱这首歌的！喃呒阿弥陀佛、喃呒阿弥陀佛、喃呒阿弥陀佛……',
        '大话西游经典对白二',
        '长夜漫漫无心睡眠，我以为只有我睡不着觉，原来晶晶姑娘你也睡不着啊！',
        '......',
        '你把胡子剃光干什么？你知不知道你少了胡子一点性格都没有了？',
        '是吗？',
        '唉，文也不行武也不行，你不做山贼，你想做状元啊？',
        '我有想过……',
        '省省吧你！改变什么形象，好好地做你山贼这份很有前途的职业去吧！',
        '我知道了，我一定会继续努力的！(转身奔去)',
        '因为那个臭猴子不会对我这么温柔。你到底是谁？',
        '我就是你五百年后的老公五百年后你因为我而放弃现在这段感情我千辛万苦回到这儿来和在这儿做的所有这些事情全都是为了你晶晶我想念你我真的想念你我太－－想念你了！你相不相信？',
        '刀下留人！原来是自杀的，你为什么要自杀呢？',
        '我先杀了你！',
        '英雄啊！你放过我吧！',
        '放过你？你给我一个不杀你的理由！',
        '正在想……你给我个杀我的理由先！',
        '好！你一声不响丢下我，还跟我师姐生下个儿子！',
        '你完全误会了……',
        '找死！(挥剑欲砍)',
        '不要啊英雄！我是回去跟你师姐拿解药救你的，谁知道晚了一步，回去已经找不到你了。',
        '你骗我！',
        '你不信？(掏出玉佩)Look',
        '大话西游经典对白三',
        '论智慧跟武功呢，我一直比他高一点点，可是现在多了个紫霞仙子，他恐怕比我高一点点了。',
        '这边有我嘛！',
        '就是因为多了你这个累赘他才会高我一点点！',
        '走！',
        '上哪儿去啊师傅？',
        '天竺！',
        '师傅怎么这么说话？',
        '师傅说话一向简单明了！走啦',
        '我看今晚不会有月光了。',
        '是吗？贱人，你跑不出我的五指山，哼哼哼！',
        '贵姓？',
        '姓林。',
        '哦，原来你就是我大哥常说的那个“林青霞”啊。',
        '你大哥？',
        '昨天被你打的那个家伙，叫至尊宝的。',
        '那你呢？',
        '我是他的双胞胎弟弟，叫至尊玉。',
        '至尊宝、至尊玉？想骗我？',
        '嘻嘻，你真是聪明伶俐。其实我大哥真名叫做秦汉，我叫秦祥林。',
        '你在这儿干什么？',
        '我……我很仰慕你。',
        '大话西游经典对白四',
        '孙悟空，你这个畜生，你为了跟牛魔王的妹妹成亲，居然把你师傅唐三藏作贺礼，还约了妖魔鬼怪一起吃唐僧宴，你认不认错？',
        '三八婆！你追了我三天三夜，因为你是女人我才不杀你，不要以为我怕了你了！',
        '悟空，你怎么可以这样跟观音姐姐讲话呢？',
        '哗－－！闭嘴！',
        '你又吓我！',
        '...',
        '悟空你也真调皮呀！我叫你不要乱扔东西，乱扔东西是不对的。哎呀我话没说完你怎么把棍子扔掉了？月光宝盒是宝物，乱扔它会污染环境，砸到小朋友怎么办？就算砸不到小朋友砸到花花草草也不好嘛！',
        '....',
        '你干什么？',
        '放手！',
        '你想要啊？你想要说清楚不就行了吗？你想要的话我会给你的，你想要我当然不会不给你啦！不可能你说要我不给你，你说不要我却偏要给你，大家讲道理嘛！现在我数三下，你要说清楚你要不要……',
        '我Kao！',
        '啊？孙悟空！',
        '哈哈哈哈哈！大家看到啦？这个家伙没事就长篇大论婆婆妈妈叽叽歪歪，就好象整天有一只苍蝇，嗡……对不起，不是一只，是一堆苍蝇围着你，嗡…嗡…嗡…嗡…飞到你的耳朵里面，救命啊！(悟空倒地翻滚，异常痛苦。)',
        '所以呢我就抓住苍蝇挤破它的肚皮把它的肠子扯出来再用它的肠子勒住他的脖子用力一拉，呵－－！整条舌头都伸出来啦！我再手起刀落哗－－！整个世界清净了。现在大家明白，为什么我要杀他！',
        '...',
        '姐姐，这是你的不对了！',
        '啊？',
        '悟空他要吃我，只不过是一个构思，还没有成为事实，你又没有证据，他又何罪之有呢？不如等他吃了我之后，你有凭有据，再定他的罪也不迟啊！',
        '唐三藏，你的罗嗦我早就听说过了，不过没想到你居然这么罗嗦！我给你的金刚圈让你用来制伏这猴子你居然不用！',
        '唉，那个金刚圈尺寸太差，前重后轻左宽右窄，他带上之后很不舒服，整晚失眠，会连累我嘛！他虽然是个猴子，可是你也不能这样对他，官府知道了会说我虐待动物的！说起那个金刚圈，去年我在陈家村认识了一位铁匠，他手工精美、价钱又公道、童叟无欺，干脆我介绍你再定做一个吧！',
        '我不会使你为难的。请姐姐跟玉皇大帝说一声，贫僧愿意一命赔一命！正所谓我不入地狱谁入地狱？求姐姐你体谅我这样做，无非是想感化劣徒，以配合我佛慈悲的大无畏精神啊！',
        '大话西游经典对白五',
        '我一定是太想念晶晶了。',
        '是啊，你昏倒的时候叫了晶晶这个名字九十八次。',
        '晶晶是我娘子。',
        '还有一个名字叫紫霞的你叫了七百八十四次！',
        '啊？！',
        '七百八十四次……这个紫霞一定欠你很多钱。',
        '出来吧！葡萄！',
        '我不是想监视你，我只不过是想研究一下人与人之间的一些微妙的感情。',
        '你只是强盗啊大哥，别学人家做学问。',
        '强盗也有学问。',
        '省省吧，睡啦！',
        '紫霞在你心目中是不是一个惊叹号，还是一个句号，你脑袋里是不是充满了问号……',
        '紫霞只不过是一个我认识的人！我以前说过一个谎话骗她，现在只不过心里面有点内疚而已。我越来越讨厌她了！我明天就要结婚了，你想怎么样嘛！',
        '有一天当你发觉你爱上一个你讨厌的人，这段感情才是最要命的！',
        '可是我怎么会爱上一个我讨厌的人呢？请你给我一个理由好不好？拜托！',
        '爱一个人需要理由吗？',
        '不需要吗？',
        '需要吗？',
        '不需要吗？',
        '需要吗？',
        '不需要吗？',
        '哎，我是跟你研究研究嘛，干嘛那么认真呢？需要吗？',
        '大话西游经典对白六',
        '你有多少兄弟姐妹？你父母尚在吗？你说句话啊，我只是想在临死之前多交一个朋友而已。',
        '所以说做妖就象做人一样，要有仁慈的心，有了仁慈的心，就不再是妖，是人妖。',
        '哎，他明白了，你明白了没有？',
        '人和妖精都是妈生的，不同的人是人他妈的，妖是妖他妈的',
        '……',
        '我受不了啦－－！',
        '你妈贵姓啊？',
        '啊－－！',
        '看，现在是妹妹要救姐姐，等一会那个姐姐一定会救妹妹的。',
        '看，我说对了吧？',
        '居然比我还快，你真行！',
        '小心啊！打雷喽！下雨收衣服啊！',
    ];

}
