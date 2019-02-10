<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

use app\models\BidProduct;
use app\models\Subscriber;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\User;
use app\models\Wallet;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Response;

use app\controllers\BidAuthController;

class BidAuthController extends Controller
{

    public static function authRequest()
    {
        $msisdn = 94717071207;
        $subscriber = Subscriber::findOne(['msisdn' => $msisdn]);
        $user = Wallet::findOne(['cust_id' => $subscriber->id]);
        
        $this->view->params['user'] = $user;

        if (!$msisdn) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }


    }

}
