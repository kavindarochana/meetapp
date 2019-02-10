<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\commands;

use app\models\BidProduct;
use Yii;
use yii\console\Controller;

/**
 * This command echoes the first argument that you have entered.
 *
 * This command is provided as an example for you to learn how to create console commands.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class CoreController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    // public function actionIndex($message = 'hello world')
    // {
    //     echo $message . "\n";

    //     return ExitCode::OK;
    // }

    public function actionUpdateProductStatus()
    {
        $this->cron_log('update_product', 'ok', 'start execution');
        try {
            $q = 'UPDATE tbl_bid_product
                SET `status` = CASE
                        WHEN `start_date` <=NOW() AND `end_date` > NOW() THEN 1
                        WHEN `start_date` <=NOW() AND `end_date` <= NOW() THEN 2
                        ELSE 0
                    END
                WHERE (`status` = 0 OR `status` = 1)';

            //query_log('cron_update_product_status', $q);
            $this->cron_log('update_product', 'ok', 'start');
            $res = Yii::$app->db->createCommand($q)->execute();
            $this->cron_log('update_product', 'ok', 'end res -' . $res);

            $ltst = BidProduct::findOne(['status' => 2]);

            // $qLowBid = "UPDATE tbl_product SET ()SELECT * FROM tbl_bid_bid_transaction WHERE bid_value NOT IN
            //             (SELECT bid_value FROM tbl_bid_bid_transaction GROUP BY bid_value HAVING COUNT(bid_value) > 1)
            //             AND product_id = $ltst->id order by bid_value LIMIT 1";

            // $lowBid = Yii::$app->db->createCommand($qLowBid)->queryAll();

            $this->cron_log('update_product', 'ok', 'start winner select product ' . @$ltst->id . ' ID -' . @$ltst->name);

            if ($ltst) {
                $qWinnerAssign = "UPDATE tbl_bid_product CROSS join
                (SELECT bid_value,customer_id FROM tbl_bid_bid_transaction WHERE product_id = $ltst->id AND bid_value NOT IN
                (SELECT bid_value FROM tbl_bid_bid_transaction WHERE product_id = $ltst->id GROUP BY bid_value HAVING COUNT(bid_value) > 1) AND
                product_id = $ltst->id order by bid_value limit 1)  AS z
                SET winner_id = z.customer_id,
                    winner_bid = z.bid_value,
                    status = 3
                WHERE id = $ltst->id and status = 2";

                $this->cron_log('update_product', 'ok', "start winner select product $ltst->id $ltst->name query ---> $qWinnerAssign ");

                $rs = Yii::$app->db->createCommand($qWinnerAssign)->execute();

                $this->cron_log('update_product', 'ok', 'start winner select product ' . @$ltst->id . 'name - ' . @$ltst->name . 'result ' . $rs);

                if ((int) @$rs == 0) {
                    $this->cron_log('update_product', 'ok', 'start no winner ' . @$ltst->id . 'name - ' . @$ltst->name . 'result ' . $rs);

                    $ltst->status = 3;

                    if (!$ltst->save()) {
                        $this->cron_log('update_product', 'not_ok', 'winner update failed' . @$ltst->id . 'name - ' . $ltst->name . 'result' . $rs);
                        return;
                    }

                    $this->cron_log('update_product', 'ok', 'end no winner ' . @$ltst->id . $ltst->name . 'result ' . $rs);
                }
            }

        } catch (Exception $e) {
            print_r($e);
            $this->cron_log('update_product', 'not_ok', 'error' . json_encode($e));
        }
        $this->cron_log('update_product', 'ok', 'end execution');
    }

    public function cron_log()
    {
        $csv_line = func_get_args();
        $date = date('Y/m/d H:i:s');

        array_unshift($csv_line, $date);

        $data = implode($csv_line, '|');
        $data = str_replace("\n", "@@", $data);
        $log_file = Yii::$app->params['cron_log'] . date("ymd") . '_cron' . ".log";

        @file_put_contents($log_file, "$data\n", FILE_APPEND);

    }

}
