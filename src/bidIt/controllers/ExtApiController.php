<?php

namespace app\controllers;

use yii\web\Controller;

class ExtApiController extends Controller
{

    public function actionDoSubscribe()
    {   //msisdn
        echo json_encode(['success' => true, 'code' => 2000, 'info' => 'You have subscribed for daily package']);
    }


    public function actionDoUnsubscribe()
    {
        //msisdn
        echo json_encode(['success' => true, 'code' => 2000, 'info' => 'You have successfully unsubscribed']);
    }


    public function actionPurchase()
    {
        // $msisdn = msisdn;
        // $packageId = pack_id;
        
        echo json_encode(['success' => true, 'code' => 2000, 'info' => 'You have successfully purchased package 1']);
    }

}
