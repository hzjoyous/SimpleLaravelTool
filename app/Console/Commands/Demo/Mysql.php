<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;

class Mysql extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'xdemo:mysql';

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
        // zl
        // 不保证可以运行
        $this->output->title('create');
        $this->info('create database simple_demo');
        $this->info('use simple_demo');
        $this->info('create');
        $this->info(' CREATE TABLE `users` (
            `id` bigint unsigned NOT NULL AUTO_INCREMENT,
            `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `email_verified_at` timestamp NULL DEFAULT NULL,
            `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
            `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT NULL,
            `updated_at` timestamp NULL DEFAULT NULL,
            PRIMARY KEY (`id`)
          ) ENGINE=InnoDB AUTO_INCREMENT=10790252 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;');
        $this->info('show create table users');
        $this->info('desc users');
        $this->output->title('insert');
        $this->info('insert into `bookorder` (`id`,`price`) values("123",123.12);');
        $this->info('insert into `bookorder` values("123",123.12);');
        $this->info('insert into `bookorder` values("123",123.12),values("124",123.12);');
        $this->output->title('select');
        $this->info('select * from bookorder;');
        $this->info('select * from bookorder as b;');
        $this->info('select * from bookorder as b order by id limit 10;');
        $this->info('select * from bookorder as b order by id desc limit 10,1;');
        $this->info('select * from loginunit as l inner join loginUnit as address on l.id = address.luid;');
        $this->info('select * from loginunit as l left join smartlock as s on l.id = s.luid;');
        $this->info('select * from loginunit where addressid is not null and city in (1,2,3);');
        $this->output->title('update');
        $this->info("update bookorder set status='wait' where status='pay';");
        $this->output->title('alter');
        $this->output->note('去除索引');
        $this->info('alter table users drop index `users_email_unique`;');
        $this->info('alter table user add age int ;');
        $this->info('alter table user modify s int;');
        $this->info('alter table user change s sex int;');
        $this->output->title('delete');
        $this->info("delete from bookorder where createtime >'2019-01-01';");
        $this->info("truncate table bookorder;");


        $this->output->title('other');
        $this->info("select
                    TABLE_NAME,
                    concat(truncate(data_length/1024/1024,2),' MB') as data_size,
                    concat(truncate(index_length/1024/1024,2),' MB') as index_size
                    from information_schema.tables
                    where TABLE_SCHEMA = 'simple_laravel'
                    order by data_length desc;");
        return;
    }
}
