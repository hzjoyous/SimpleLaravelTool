<?php

file_put_contents('./data.tmp',json_encode($_REQUEST).PHP_EOL.date('Y-m-d H:i:s').PHP_EOL,8);
