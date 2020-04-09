<?php
/**
 * Created by PhpStorm.
 * User: hzj
 * Date: 2019/3/10
 * Time: 13:39
 */
declare(strict_types=1);

define('TMP', __DIR__ . '/tmp');
define('REPO_PATH', TMP . '/repo');
define('XZ_REPO_LOCK', TMP . '/xiaozhuGitLab.json');

function println(string $str)
{
    echo($str . PHP_EOL);
}
