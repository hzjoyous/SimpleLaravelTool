<?php

namespace App\Console\Commands\Demo;

use Illuminate\Console\Command;

class RBAC extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'demo:rbac';

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
        /**
         * 用户
         */
        $admin = [
            [
                'id',
                'name',
            ]
        ];
        /**
         * 角色
         */
        $adminRole = [
            [
                'id'
            ]
        ];
        /**
         * 权限
         */
        $adminPermission = [
            [
                'id'
            ]
        ];
        /**
         * 用户角色关系
         */
        $adminRoleRelation = [
            [
                'admin_id' => 1,
                'role_id' => 1
            ]
        ];
        /**
         * 角色权限关系
         */
        $adminPermissionRelation = [
            [
                'role_id' => 1,
                'permission_id' => 1
            ]
        ];
    }
}
