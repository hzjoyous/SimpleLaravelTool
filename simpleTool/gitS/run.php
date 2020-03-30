<?php

require __DIR__ . '/bootstrap.php';

if (!is_dir(TMP)) {
    mkdir(TMP, 0777, 1);
}
if (!is_dir(REPO_PATH)) {
    mkdir(REPO_PATH, 0777, 1);
}

$gitlab_Token = 'zxPnDVLgByCx3aUZhMrD';

$appGit = [];

if (!is_file(XZ_REPO_LOCK)) {

    for ($i = 1; $i <= 10; $i++) {
        $shell          = "curl --header \"PRIVATE-TOKEN: $gitlab_Token\" http://gitlab.idc.xiaozhu.com/api/v4/projects?simple=true\&page={$i}";
        $shellOutPut    = [];
        $shellReturnVar = [];

        $str = exec($shell, $shellOutPut, $shellReturnVar);

        $xzGitArr = json_decode($str, 1);
        if (!$xzGitArr) {
            echo '共10页';
            continue;
        }
        $appGit = array_merge($appGit, $xzGitArr);
    }
    file_put_contents(XZ_REPO_LOCK, json_encode($appGit));
} else {
    $str    = file_get_contents(XZ_REPO_LOCK);
    $appGit = json_decode($str, 1);
}

foreach ($appGit as $git) {

    $i += 1;

    println("第{$i}个项目开始");

    $xz_repo = $git['ssh_url_to_repo'];

    $sh = "cd " . REPO_PATH . " && git clone {$xz_repo}";

    println($sh);

    $result = exec($sh);

    println($result);
}





