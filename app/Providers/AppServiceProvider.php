<?php

namespace App\Providers;

use App\Service\TraceIdMaker;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Monolog\Logger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->updateSqlLog();
        //
    }


    /**
     * 非线上环境记录执行日志
     * @return $this
     */
    protected function updateSqlLog(): AppServiceProvider
    {
        if (!app()->environment(['production'])) {
            DB::listen(function ($query) {
                /* @var $query QueryExecuted */
                $sql = str_replace("?", "'%s'", $query->sql);
                foreach ($query->bindings as $i => $binding) {
                    if ($binding instanceof \DateTime) {
                        $query->bindings[$i] = $binding->format('Y-m-d H:i:s');
                    } else {
                        if (is_string($binding)) {
                            $query->bindings[$i] = "$binding";
                        }
                    }
                }
                $log = vsprintf($sql, $query->bindings);
                logger()->debug("sql", ['sql' => $log, 'time(s)' => $query->time]);
            });
        }
        return $this;
    }
}
