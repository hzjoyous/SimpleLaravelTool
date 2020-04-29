<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;

class PhpFpm extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:phpfpm';

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
        $phpFpmStr = <<<EOF

 cat /etc/mysql/debian.cnf

ubuntu 20.04 php7.4

where
/etc/php/7.4/fpm/pool.d
change:
;listen = /run/php/php7.4-fpm.sock
listen = 127.0.0.1:9000

which php-fpm7.4
sudo service php-fpm7.4 start


netstat -lnt | grep 9000

EOF;

        $this->info($phpFpmStr);

        $nginxStr = <<<EOF

        enable-php.conf

        location ~ [^/]\.php(/|$)
        {
            try_files \$uri =404;
            fastcgi_pass  unix:/tmp/php-cgi.sock;
            fastcgi_index index.php;
            include fastcgi.conf;
        }

----------
 /etc/nginx/sites-available/default
 change
 listen 80;
listen [::]:80 default_server;

listen 80;
listen [::]:80 ipv6only=on default_server;

------------
        wp.conf

    server
    {
        listen 80;
        #listen [::]:80;
        server_name wp.localhost.com ;
        index index.html index.htm index.php default.html default.htm default.php;
        root  /home/h/桌面/workspace/wordpress;

        #location / {
        #    # try to serve file directly, fallback to index.php
        #    try_files \$uri /index.php\$is_args\$args;
        #}

        #include rewrite/none.conf;
        #error_page   404   /404.html;

        # Deny access to PHP files in specific directory
        #location ~ /(wp-content|uploads|wp-includes|images)/.*\.php$ { deny all; }

        include enable-php.conf;

        location ~ .*\.(gif|jpg|jpeg|png|bmp|swf)$
        {
            expires      30d;
        }

        location ~ .*\.(js|css)?$
        {
            expires      12h;
        }

        location ~ /.well-known {
            allow all;
        }

        location ~ /\.
        {
            deny all;
        }


        #error_log /root/log/project_error.log;
        #access_log /root/log/project_access.log;

    }

EOF;

        $this->info($nginxStr);

        return;

    }
}
