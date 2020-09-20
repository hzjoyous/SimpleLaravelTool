<?php

namespace App\Console\Commands\Tool;

use Illuminate\Console\Command;

class ValueInsertT extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'z:vit';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'this is test';

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
     * @return int
     */
    public function handle()
    {
        $str = <<<EOF
SELECT b0_.id AS id_0, b0_.ver AS ver_1, b0_.estate AS estate_2, b0_.parentid AS parentid_3, b0_.submiterid AS submiterid_4, b0_.landlordid AS landlordid_5, b0_.luid AS luid_6, b0_.checkinday AS checkinday_7, b0_.checkoutday AS checkoutday_8, b0_.actualcheckoutday AS actualcheckoutday_9, b0_.checkintime AS checkintime_10, b0_.checkouttime AS checkouttime_11, b0_.roomnum AS roomnum_12, b0_.cancelroomnum AS cancelroomnum_13, b0_.cancelpayallday AS cancelpayallday_14, b0_.cancelrulea AS cancelrulea_15, b0_.cancelruleb AS cancelruleb_16, b0_.cancelable AS cancelable_17, b0_.cancelrulespe AS cancelrulespe_18, b0_.bookperiodno AS bookperiodno_19, b0_.submitername AS submitername_20, b0_.submiteremail AS submiteremail_21, b0_.submitermobile AS submitermobile_22, b0_.submitersex AS submitersex_23, b0_.tenantnum AS tenantnum_24, b0_.createtime AS createtime_25, b0_.confirmtime AS confirmtime_26, b0_.paytime AS paytime_27, b0_.currentstate AS currentstate_28, b0_.laststate AS laststate_29, b0_.operid AS operid_30, b0_.operfrom AS operfrom_31, b0_.opertime AS opertime_32, b0_.isclose AS isclose_33, b0_.remark AS remark_34, b0_.bookflow AS bookflow_35, b0_.bookfrom AS bookfrom_36, b0_.bookfromenv AS bookfromenv_37, b0_.lastupdatetime AS lastupdatetime_38, b0_.zhimainfo AS zhimainfo_39, b0_.bdchannel AS bdchannel_40, b0_.timezone AS timezone_41, b0_.paymethod AS paymethod_42, b0_.originalprice AS originalprice_43, b0_.acutalprice AS acutalprice_44, b0_.isdelete AS isdelete_45, b0_.paymenttype AS paymenttype_46, b0_.booktradeno AS booktradeno_47 FROM bookorder b0_ WHERE (b0_.luid IN (?) AND b0_.currentstate IN (?) AND b0_.lastupdatetime < ? AND b0_.lastupdatetime > ?) AND (b0_.estate = 'valid')
EOF;
        $valEnd = array(
            0 => '"70000169409901","70000087266103","442199701","70000169409901","70000152223003","26056052303","70000068781601","442199701","70000149661801","70000169409901"',
            1 => '"canceled","waitcheckin","checkout","checkin","checkout"',
            2 => '2019-10-27 15:27:31',
            3 => '2019-01-27 15:27:31',
        );

        foreach ($valEnd as $val) {
            //$final_words = str_replace('?', $val, $str , $a);
            $val = '"' . $val . '"';
            $str = preg_replace('#\?#', $val, $str, 1);
        }

        $this->line($str);
        return 0;
    }
}
