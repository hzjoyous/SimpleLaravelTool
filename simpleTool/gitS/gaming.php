<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/3/10
 * Time: 13:40
 */
declare(strict_types=1);

require __DIR__ . '/bootstrap.php';

/**
 * 项目根目录
 */
$dir = REPO_PATH;

$result = array_filter(scandir($dir), function ($item) {
    return !in_array($item, ['.', '..']);
});

/**
 * 项目目录
 */
$dirs = array_map(function ($item) use ($dir) {
    return $dir . '/' . $item;
}, $result);

$log_path = TMP . '/git.log';

if (file_exists($log_path)) {
    unlink($log_path);
}

$authorName = $argv[1] ?? '';

$author = $authorName ? ("--author=$author") : "";

$maxDate = '2018-01-01';

$minDate = '2019-01-01';

foreach ($dirs as $dir) {

    $array = [];

    /**
     * git低版本不支持--date
     */
    $__date = "--date='format:%Y-%m-%d %H:%M:%S'";

    /**
     * 使用 php 接管 git 日期管理
     */
    $cmd = "cd {$dir} && git log  $author --since='2018-01-01' --pretty=format:'%h %ce %cd %s' 2>> /dev/null";#" | awk '{hour=0+substr($4,0,2);  printf \"%s %s %s %s %s\\n\", $1, $2, $3, $4, $5 }' ";

    //println($cmd);

    $result = exec($cmd, $array);

    $array = array_map(function ($item) use (&$maxDate, &$minDate) {
        $item = explode(' ', $item);
        $date = "$item[2] $item[3] $item[4] $item[5] $item[6] $item[7]";

        $date    = new DateTime($date);
        $date    = $date->format('Y-m-d H:i:s');
        $maxDate = $maxDate > $date ? $maxDate : $date;
        $minDate = $minDate < $date ? $minDate : $date;
        return "$item[0] $item[1] $date $item[8]";

    }, $array);

    if (count($array) <= 0) {
        continue;
    }

    $project_name = basename($dir);

    foreach ($array as $item) {
        file_put_contents($log_path, $project_name . ' ' . $item . PHP_EOL, FILE_APPEND);
    }
}

$content = file_get_contents($log_path);

$content = explode(PHP_EOL, trim($content));

$data = [];

foreach ($content as $key => $value) {
    $row        = explode(' ', trim($value));
    $data[$key] = [
        'project' => $row[0],
        'hash'    => $row[1],
        'author'  => $row[2],
        'date'    => $row[3],
        'time'    => $row[4],
        'commit'  => $row[5] ?? 'undefined',
    ];
}

$date_array = [];

$latest_date = '';

$latest_time = '';

$time_commit = [0, 0, 0, 0];

$project_array = [];

$week_cnt = 0;

foreach ($data as $datum) {

    isset($date_array[$datum['date']]) ? $date_array[$datum['date']]++ : $date_array[$datum['date']] = 1;
    isset($project_array[$datum['project']]) ? $project_array[$datum['project']]++ : $project_array[$datum['project']] = 1;

    $time = explode(':', $datum['time']);
    $hour = $time[0];
    //0凌晨 1上午 2下午 3傍晚
    $time_commit[intval($hour / 6)]++;

    $commit_time = strtotime($datum['date'] . '' . $datum['time']);
    if (date('w', $commit_time) == 6 || date('w', $commit_time) == 0) {
        $week_cnt++;
    }

}

arsort($date_array);

$most_commit_date     = current(array_keys($date_array));
$most_commit_date_cnt = current(array_values($date_array));

arsort($time_commit);
$most_commit_segment     = current(array_keys($time_commit));
$most_commit_segment_cnt = current(array_values($time_commit));
$segment                 = '';

arsort($project_array);
$most_commit_project     = current(array_keys($project_array));
$most_commit_project_cnt = current(array_values($project_array));

$project_cnt = count($dirs);
$commit_cnt  = count($content);

switch ($most_commit_segment) {
    case 0:
        $segment = '凌晨';
        break;
    case 1:
        $segment = '上午';
        break;
    case 2:
        $segment = '下午';
        break;
    case 3:
        $segment = '傍晚';
        break;
}

$author = $author ?: '猪仔';

$str = <<<EOF
                亲爱的猪仔们:
                    这一年里【从 {$minDate} 到 {$maxDate} 】
                    你通过Git向{$project_cnt}个代码仓库
                    提交了{$commit_cnt}次代码
      
                    {$most_commit_date}大概是很特别的一天
                    这一天里
                    勤劳的你一共提交了{$most_commit_date_cnt}次代码
     
                    这一年
                    {$most_commit_project}接收了
                    {$most_commit_project_cnt}次代码提交
                    所有熟悉的项目中
                    你对他最专一
      
                    你最喜欢在{$segment}提交代码
                    在过去的一年中
                    即使是在安静的周末，
                    你在忘我的敲打着键盘 
                    在这无数个周末中，你一共提交了{$week_cnt}次代（八）码（哥）
                                     
                                     
                                     
                                     end~~~
                                     











EOF;


class WriteSleep
{
    const oneS = 1000000;
    protected static $pl    = [
        1 => 1,
        2 => 5,
        3 => 30,
    ];
    protected static $plNum = 1;

    public static function init()
    {
        self::$plNum = 1;
    }

    public static function sleep($pl = false)
    {
        usleep((int)(self::oneS / ($pl === false ? self::$pl[self::$plNum] : $pl)));
        if (self::$plNum < 3) {
            self::$plNum++;
        }
    }
}

$sa = array_map(function (int $y): string {
    return implode(array_map(function (int $x) use ($y) : string {
        return pow(pow($x * 0.05, 2) + pow($y * 0.1, 2) - 1, 3)
        - pow($x * 0.05, 2) * pow($y * 0.1, 3) <= 0
            ? str_split("xzdz")[$x - $y - floor(($x - $y) / 4) * 4]
            : " ";
    }, range(-30, 29)));
}, range(15, -14, -1));

$sa     = implode(PHP_EOL, $sa) . PHP_EOL;
$length = strlen($sa);
for ($i = 0; $i < $length; $i++) {
    echo $sa[$i];
    WriteSleep::sleep(1000);
}

//array_walk($sa, function (string $s) {
//    print($s . PHP_EOL);
//});

$length = strlen($str);

for ($i = 0; $i < $length; $i++) {
    echo $str[$i];
    WriteSleep::sleep();
}


$blog   = '感兴趣的收藏一下我的blog呀                          https://hzj991.github.io' . PHP_EOL .
    '感兴趣的收藏一下我的blog呀                          https://hzj991.github.io' . PHP_EOL .
    '感兴趣的收藏一下我的blog呀                          https://hzj991.github.io' . PHP_EOL .
    PHP_EOL;
$length = strlen($blog);
for ($i = 0; $i < $length; $i++) {
    echo $blog[$i];
    WriteSleep::sleep();
}