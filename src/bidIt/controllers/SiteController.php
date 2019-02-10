<?php

namespace app\controllers;

use app\models\BidPackages;
use app\models\BidProduct;
use app\models\BidTransaction;
use app\models\ContactForm;
use app\models\LoginForm;
use app\models\Subscriber;
use app\models\User;
use app\models\Wallet;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\HttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */

    public $userObj = 0;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    // public function beforeAction($action) {
    //     $this->enableCsrfValidation = false;
    //     return parent::beforeAction($action);
    // }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $this->authRequest();
        $user = $this->view->params['user'];
        $product = $this->view->params['products'];
        return $this->render('index', ['products' => $product, 'balance' => $user->bid_balance]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAbc()
    {

        $code = @$_POST['code'] = 1;
        $color = @$_POST['color'] = 2;

        // $lottery = TblLottery::find()
        // ->where(['code'=>$code])
        // ->one();

        $days = [
            "1" => "Monday",
            "2" => "Tuesday",
            "3" => "Wednesday",
            "4" => "Thursday",
            "5" => "Friday",
            "6" => "Saturday",
            "7" => "Sunday",
        ];

        // $dates = (array)json_decode($lottery->date_values);

        // $strDays = "";
        // for ($x = 0; $x < count($dates); $x++) {
        //     if($x == (count($dates)-1) ){
        //         $strDays .= $days[$dates[$x]];
        //     }else{
        //         $strDays .= $days[$dates[$x]].',';
        //     }
        // }

        echo '<div class="modal-dialog">
        <div class="modal-content c-square">
            <div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
                 <h4 style="font-size:25px" class="modal-title" id="myModalLabel">Buy $lottery->name</h4>
            </div>
            <div class="modal-body">
                <h5 class="modal-title" id="myModalLabel">How many tickets do you want to buy for a draw?</h5>

                <div class="c-content-panel">

                    <div class="buy-table-wrapper">
                        <label onclick="onAmountSelected(1)" class="radioLabelContainer">
                            <input type="radio" checked="checked" name="radioGroup1" style="opacity: 0">
                            <div class="checkmark buy-table">
                                <a href="javascript:void(0);">
                                    <h2 style="background:#12313" class="buy-table__header">Rs.20</h2>
                                    <h3 style="color:#123123" class="buy-table__price">1</h3>
                                </a>
                            </div>
                        </label>
                        <label onclick="onAmountSelected(2)" class="radioLabelContainer">
                            <input type="radio" name="radioGroup1" style="opacity: 0">
                            <div class="checkmark buy-table">
                                <a  href="javascript:void(0);">
                                    <h2 style="background:#123123"  class="buy-table__header">Rs.40</h2>
                                    <h3 style="color:#123123" class="buy-table__price">2</h3>
                                </a>
                            </div>
                        </label>
                        <label onclick="onAmountSelected(3)" class="radioLabelContainer">
                            <input type="radio" name="radioGroup1" style="opacity: 0">
                            <div class="checkmark buy-table">
                                <a  href="javascript:void(0);">
                                    <h2 style="background:#123123" class="buy-table__header">Rs.60</h2>
                                    <h3 style="color:#123123" class="buy-table__price">3</h3>
                                </a>
                            </div>
                        </label>
                        <label onclick="onAmountSelected(-1)" class="radioLabelContainer">
                            <input type="radio" name="radioGroup1" style="opacity: 0">
                            <div class="checkmark buy-table" style="height: 148px;vertical-align:top;width:98px;">
                                <a href="javascript:void(0);">
                                    <h2 style="background::#123123" class="buy-table__header" id="num_price">More</h2>
                                    <input onkeyup="onInptNumberPress()" class="input-number" id="num_input" type="number" value="4" min="0" max="100" style="margin-top: 8px;
                                    border: 3px solid:#123123;
                                    padding: 5px;
                                    border-radius: 6px;
                                    font-size: 21px;
                                    text-align: center;
                                    color: #12313;
                                    width: 90px;
                                    ">

                                </a>
                            </div>
                        </label>
                    </div>

                    <div class="input-group input-number-group" style="display:none;">
                        <div class="input-group-button" id="num_dec" >
                            <span class="input-number-decrement" >-</span>
                        </div>
                        <input onclick="onInptNumberPress()" class="input-number" id="num_input1" type="number" value="0" min="0" max="100" maxlength="2">
                        <div class="input-group-button" id="num_inc" >
                            <span class="input-number-increment" >+</span>
                        </div>
                    </div>

                </div>
                <p style="color:#5c6873; text-align:center; font-size:16px;">Draws available on 1wq</p>
                <p style="color:#6d46ca; text-align:center; font-size:11px;">* Rs.4 telecom fee + tax will apply for each ticket</p>
            </div>
            <div class="modal-footer">
                <button style="border-color:sas; color:sa"   onclick="submitBuyticket()" type="button" class="btn c-buy-btn c-btn-border-2x c-btn-square c-btn-bold c-btn-uppercase">Buy</button>
            </div>
        </div>
        <input type="hidden" id="amount_selection" name="amount_selection" value="1" />
        <input type="hidden" id="ticket_code" name="ticket_code" value="xz" />
        <input type="hidden" id="ticket_name" name="ticket_code" value="as" />
        <!-- /.modal-content -->
    </div>';
        die;
    }

    public function actionCreate()
    {

        print_r(Yii::$app->request->post());
        echo 'aaaa';
        // $model = new BidProduct();

        // if ($model->load(Yii::$app->request->post()) && $model->save()) {

        //     return $this->redirect(['index']);
        // } else {
        //     return $this->renderAjax('create', [
        //         'model' => $model,
        //     ]);
        // }
    }

    public function actionUnsubscribe()
    {
        $this->authRequest();
        $subscriber = Subscriber::findOne(['id' => $_GET['uid'], 'msisdn' => $_GET['msisdn']]);

        if ($subscriber->status == 0) {
            $msg = ['alert', 'You have already unsubscribed with BidIt'];
            return $this->render('index', ['products' => $this->view->params['products'], 'message' => $msg, 'balance' => $this->view->params['user']->bid_balance]);
        }

        $subscriber->status = 0;

        $wallet = Wallet::findOne(['cust_id' => $_REQUEST['uid']]);
        $wallet->daily_bid_balance_stauts = 0;

        if ($subscriber->save() && $wallet->save()) {
            $this->authRequest();
            $msg = ['success', 'You have successfully unsubscribed from BidIt.'];
        } else {
            $msg = ['error', 'Your request can not be process right now.'];
        }
        return $this->render('index', ['products' => $this->view->params['products'], 'message' => $msg, 'balance' => $this->view->params['user']->bid_balance]);
    }

    public function actionSubscribe()
    {
        $this->authRequest();

        $subscriber = Subscriber::findOne(['id' => $_REQUEST['uId'], 'msisdn' => $_REQUEST['msisdn']]);

        if ($subscriber->status == 1) {
            $msg = ['alert', 'You have already subscribed with BidIt'];
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);
            return $this->render('index', ['products' => $this->view->params['products'], 'message' => $msg, 'balance' => $this->view->params['user']->bid_balance]);
        }

        $sub = $this->subUser(1, 1);

        if (1 * $sub !== 1) {
            $msg = ['error', 'Error'];
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);
            return $this->render('index', ['products' => $this->view->params['products'], 'message' => $msg, 'balance' => $this->view->params['user']->bid_balance]);
        }
        $subscriber->status = 1;

        $wallet = Wallet::findOne(['cust_id' => $_REQUEST['uId']]);
        $wallet->daily_bid_balance_stauts = 1;

        if ($subscriber->save() && $wallet->save()) {
            $this->authRequest();
            $msg = ['success', 'You have been successfully subscribed for BidIt.'];

        } else {
            $msg = ['error', 'Your request can not be process right now.'];
        }
        $user = $this->view->params['user'];
        Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);
        return $this->render('index', ['products' => $this->view->params['products'], 'message' => $msg, 'balance' => $this->view->params['user']->bid_balance]);
    }

    private function authRequest($msisdn = null)
    {
        if (!$msisdn) {
            $msisdn = @$_REQUEST['msisdn'] == null ? @$this->view->params['user']->cust->msisdn : $_REQUEST['msisdn'];
        }

        if (!in_array(substr($msisdn, -9, -7), Yii::$app->params['msisdn_prefix'])) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }

        // if (!Yii::$app->session->get('user')) {
        //     $subscriber = Subscriber::findOne(['msisdn' => @$msisdn]);
        // } else {
        //     $subscriber = Yii::$app->session->get('user');print_r('aaa');
        // }

        $subscriber = Subscriber::findOne(['msisdn' => @$msisdn]);

        if (!$subscriber) {
            $this->initialReg($msisdn);
        }

        if ($subscriber = Subscriber::findOne(['msisdn' => @$msisdn])) {
            $user = Wallet::findOne(['cust_id' => $subscriber->id]);
            $prd = BidProduct::find()->where("`status` != 2 and `status` != 3 and `create_ts` >= '" . date('Y-m-d H:i:s', strtotime('-16 days')) . " ORDER BY id'")->limit(26)->all();
            $product = [];
            foreach ($prd as $p) {
                if ($p['status'] == 1) {
                    $product['active'] = $p;
                    continue;
                }
                if (($p['status'] == 0)) {
                    $product['queue'][] = $p;
                    continue;
                }
            }

            $q = 'SELECT a.id,a.name, a.image,a.description,a.image,a.price,a.winner_bid,a.start_date,a.end_date,a.winner_id,a.status,a.create_ts,a.update_ts,b.msisdn, b.id as winId, b.name as winner FROM `tbl_bid_product` a, tbl_bid_subscriber b WHERE
                a.winner_id = b.id AND a.status = 3 order by id DESC limit 5';

            foreach (Yii::$app->db->createCommand($q)->queryAll() as $q) {
                $product['end'][] = (object) $q;
            }
//Todo Chang active
            if (!@$product['active'] && @$product['queue'][0]) {
                $product['next'] = $product['queue'][0];
                array_shift($product['queue']);
            }

            $packages = BidPackages::find(['status = 1'])->all();
            $this->view->params['user'] = $user;
            $this->view->params['products'] = $product;
            $this->view->params['packs'] = $packages;
            Yii::$app->session->set('user', $user);
            return $user;
        }

        throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));

    }

    public function actionPurchase()
    {
        $user = $this->authRequest();
        $msg = ['error', 'Your request can not be process right now.'];
        $pack = BidPackages::findOne(['id' => @$_REQUEST['pack'], 'status' => 1]);
        $wallet = $this->view->params['user'];
        $status = $this->subStatus();

        if (@$status[2] == 100) {
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($status), 2);
            return $this->render('index', ['products' => $this->view->params['products'], 'error' => ['error', $status['1']], 'balance' => $this->view->params['user']->bid_balance]);

        }

        $pay = $this->payAuth(@$_REQUEST['msisdn'], $pack->price);

        if (@$pay[0] == 'alert') {
            $msg = $pay;
            audit_log($_REQUEST['msisdn'], 'pack_purchase', 'ok', " Pack purchased in the que -$pack->name,price-$pack->price,bid-$pack->bids");

        }

        if (@$pay[0] == 'error') {
            $msg = $pay;
            audit_log($_REQUEST['msisdn'], 'pack_purchase', 'ok', " Pack purchased in the que -$pack->name,price-$pack->price,bid-$pack->bids");

        }

        if (@$pay[0] == 'success') {

            $q = "UPDATE tbl_bid_wallet set bid_balance = bid_balance + $pack->bids WHERE id = $wallet->id";

            try {
                $a = Yii::$app->db->createCommand($q)->execute();
                $t = new BidTransaction();
                $t->wallet_id = (string) $wallet->id;
                $t->customer_id = (string) $wallet->cust->id;
                $t->msisdn = $wallet->cust->msisdn;
                $t->bid_value = $pack->bids;
                $t->product_id = (string) $pack->id;
                $t->type = 1;
                $t->balance = $wallet->bid_balance + $pack->bids;

                if (!$t->save()) {
                    // print_r($t->getErrors());
                }

                audit_log($_REQUEST['msisdn'], 'pack_purchase', 'ok', " Pack purchased-$pack->name,price-$pack->price,bid-$pack->bids");
                $msg = ['success', 'You have successfully purchased ' . $pack->name . ' package.'];
            } catch (Exception $e) {
                audit_log($_REQUEST['msisdn'], 'pack_purchase', 'not_ok', "db error Pack - $pack->name");
            }
            query_log($q);
        }

        Yii::$app->cache->set($wallet->cust->id . 'notice_message', json_encode($msg), 2);

        return $this->render('index', ['products' => $this->view->params['products'], 'message' => ['success', $msg], 'balance' => $this->view->params['user']->bid_balance]);

    }

    private function payAuth($msisdn, $price)
    {
        $val = Yii::$app->cache->get($msisdn . 'pay');

        if ($val === false) {
            Yii::$app->cache->set($msisdn . 'pay', true, 10);
            //ToDO payment api
            $api = true;
            if ($api) {
                return ['success'];
            } else {
                return ['error', 'Your request can not be process right now.'];
            }
        }

        return ['alert', 'Your another purchase request already in the queue.'];
    }

    private function initialReg($msisdn)
    {
        $s = new Subscriber();
        $s->msisdn = $msisdn;
        $s->status = 2;

        if (!$s->save()) {
            audit_log($msisdn, 'initial_registration', 'not_ok', 'Error ' . json_encode(@$s->getErrors()));
            throw new HttpException(500, 'Your request currently face some issue. Pleas try again in few seconds.');
        }

        audit_log($msisdn, 'initial_registration', 'ok', "Subscriber added customer id = $s->id");

        $c = new Wallet();
        $c->cust_id = $s->id;
        $c->bid_balance = 2;
        $c->update_ts = date('Y-m-d H:i:s');
        // $c->save();

        if (!$c->save()) {
            audit_log($msisdn, 'initial_registration_wallet', 'not_ok', 'Error ' . json_encode(@$c->getErrors()));
            throw new HttpException(500, 'Your regisraion process faced some issue . You have to contact customer care for complete your process. Don\'t to be late. Today is your lucky day. Please complete your registration.');
        }
        audit_log($msisdn, 'initial_registration_wallet', 'ok', "success - wallet - $c->id ");

    }

    public function actionUpdateAccount()
    {
        $user = $this->authRequest(Yii::$app->session->get('user')['cust']['msisdn']);
        $id = Yii::$app->session->get('user')['cust']['id'];
        $usr = Subscriber::findOne($id);

        $usr->name = $_REQUEST['name'];
        $usr->email = $_REQUEST['email'];
        $usr->nic = $_REQUEST['nic'];

        if($usr->save()){
            $msg = ['success', 'Successfully profile data updated.'];
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);
            $this->authRequest();
            return $this->render('index', ['products' => $this->view->params['products'], 'error' => $msg, 'balance' => $this->view->params['user']->bid_balance]);

        } else {
            $msg = ['error', 'Can not update profile data right now.'];
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);

            return $this->render('index', ['products' => $this->view->params['products'], 'error' => $msg, 'balance' => $this->view->params['user']->bid_balance]);

        }
    }

    public function actionUpdateProductStatus()
    {
        try {
            $q = 'UPDATE tbl_bid_product
                SET
                    `status` = CASE
                        WHEN `start_date` <=NOW() AND `end_date` > NOW() THEN 1
                        WHEN `start_date` <=NOW() AND `end_date` <= NOW() THEN 2
                        ELSE 6
                    END
                WHERE (`status` = 0 OR `status` = 1)';

            query_log('cron_update_product_status', $q);

            $res = Yii::$app->db->createCommand($q)->execute();
            print_r($res);

        } catch (Exception $e) {
            print_r($e);
        }
    }

    public function actionHistory()
    {
        $user = $this->authRequest();

        $out = [];

        // $q = "SELECT a.id, a.msisdn, a.bid_value, a.wallet_id, a.type, a.customer_id, a.balance, a.create_ts,
        //     coalesce(b.name, c.name) name, coalesce(b.price, c.price) price from tbl_bid_bid_transaction a where  a.wallet_id = $user->id
        //     left outer join tbl_bid_packages b on b.id = a.product_id and a.type = 1
        //     left outer join tbl_bid_product c on c.id = a.product_id and a.type = 2
        //     ORDER by a.id desc limit 30";

        $q1 = "SELECT a.id, a.msisdn, a.bid_value, a.wallet_id, a.type, a.customer_id, a.balance, a.create_ts, b.name, b.price from
            tbl_bid_bid_transaction a,tbl_bid_product b where
            a.product_id = b.id and a.type = 2 and a.wallet_id = $user->id ORDER by a.id desc limit 30";

        $q2 = "SELECT a.id, a.msisdn, a.bid_value, a.wallet_id, a.type, a.customer_id, a.balance, a.create_ts, b.name, b.price from
            tbl_bid_bid_transaction a,tbl_bid_packages b where
            a.product_id = b.id and a.type = 1 and a.wallet_id = $user->id ORDER by a.id desc limit 30";

        foreach (Yii::$app->db->createCommand($q1)->queryAll() as $o) {
            $out[] = [
                'date' => $o['create_ts'],
                'name' => $o['name'],
                'price' => $o['price'],
                'bid_value' => $o['bid_value'],
                'bid_price' => $o['type'] == 1 ? $o['price'] . 'LKR' : $o['bid_value'] . '*' . $o['price'] . ' = ' . $o['bid_value'] * $o['price'] . 'pts',
                'type' => $o['type'],
            ];
        }

        foreach (Yii::$app->db->createCommand($q2)->queryAll() as $o) {
            $out[] = [
                'date' => $o['create_ts'],
                'name' => $o['name'],
                'price' => $o['price'],
                'bid_value' => $o['bid_value'],
                'bid_price' => $o['type'] == 1 ? $o['price'] . 'LKR' : $o['bid_value'] . '*' . $o['price'] . ' = ' . $o['bid_value'] * $o['price'] . 'pts',
                'type' => $o['type'],
            ];
        }
        arsort($out);
        return $this->render('history', ['data' => $out]);
    }

    public function actionBidNow()
    {
        $msisdn = Yii::$app->session->get('user')['cust']['msisdn'];
        $bidVal = 1 * $_REQUEST['bid'];
        $pId = $_REQUEST['pId'];
        $user = $this->authRequest($msisdn);
        $status = $this->subStatus(false);

        // if ($bidVal % 5 !== 0) {
        //     $msg = ['error', 'Invalid bid. Accept only divisible by 5 values'];
        //     Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);
        //     return $this->render('index', ['products' => $this->view->params['products'], 'balance' => $this->view->params['user']->bid_balance]);

        // }

        $product = BidProduct::findOne($pId);

        if (1 * $product->price >= $bidVal) {
            $msg = ['alert', "Invalid bid. Your bid shoud greater than $product->price LKR."];
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);

            return $this->render('index', ['products' => $this->view->params['products'], 'error' => $msg, 'balance' => $this->view->params['user']->bid_balance]);

        }

        if ($product->end_date < date('Y-m-d H:i:s')) {
            $msg = ['alert', 'This auction is expired.'];
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);

            return $this->render('index', ['products' => $this->view->params['products'], 'error' => $msg, 'balance' => $this->view->params['user']->bid_balance]);

        }

        if ($status[0] == 1) {
            $msg = $this->doCharge($user['id'], $bidVal, $pId);
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($msg), 2);

            return $this->render('index', ['products' => $this->view->params['products'], 'balance' => $this->view->params['user']->bid_balance]);

        } else {
            Yii::$app->cache->set($user->cust->id . 'notice_message', json_encode($status), 2);

            return $this->render('index', ['products' => $this->view->params['products'], 'error' => ['error', $status['1']], 'balance' => $this->view->params['user']->bid_balance]);

        }

    }

    private function subStatus($initCheck = true)
    {
        $user = Yii::$app->session->get('user');

        if ($initCheck && (1 * $user->cust['status'] !== 1)) {
            return ['alert', 'You have not subscribe for BidIt. Please subscribe.', 100];
        }

        if ($user['bid_balance'] == 0 && $user['daily_bid_balance'] == 0 && $user['daily_bid_balance_stauts'] == 0) {
            return ['alert', 'You have not subscribe for BidIt. Please subscribe.'];
        }

        if ($user['bid_balance'] == 0 && $user['daily_bid_balance'] == 0 && $user['daily_bid_balance_stauts'] == 1) {
            return ['alert', 'Insufficent bid balance.  Today is your lucky day. Please purchase bids.'];
        }

        if ($user['bid_balance'] == 0 && $user['daily_bid_balance'] == 0 && $user['daily_bid_balance_stauts'] == 1) {
            return ['alert', 'Insufficent bid balance. Please purchase bids.'];
        }

        return [1];
    }

    private function doCharge($id, $bidVal, $pId)
    {
        $wallet = Wallet::findOne($id);

        if (1 * $wallet->daily_bid_balance > 0) {
            $wallet->daily_bid_balance = $wallet->daily_bid_balance - 1;

            if ($wallet->save()) {
                $t = new BidTransaction();
                $t->wallet_id = (string) $wallet->id;
                $t->customer_id = (string) $wallet->cust->id;
                $t->msisdn = $wallet->cust->msisdn;
                $t->bid_value = $bidVal;
                $t->product_id = $pId;
                $t->type = 2;
                $t->balance = $wallet->bid_balance + $wallet->daily_bid_balance;
                $t->save();
                audit_log($wallet->cust->msisdn, 'bid_place', 'ok', " daily bid Product - $pId Bid - $bidVal");
                return ['success', 'You Bid placed successfully'];
            } else {
                audit_log($wallet->cust->msisdn, 'bid_place', 'not_ok', " daily bid Product - $pId Bid - $bidVal");
                return ['error', 'Your bid can not be place right now.'];
            }

        }

        if (1 * $wallet->bid_balance > 0) {audit_log('bid');
            $wallet->bid_balance = $wallet->bid_balance - 1;

            if ($wallet->save()) {
                audit_log($wallet->cust->msisdn, 'bid_place', 'not_ok', "bid db error Product - $pId Bid - $bidVal");
                $t = new BidTransaction();
                $t->wallet_id = (string) $wallet->id;
                $t->customer_id = (string) $wallet->cust->id;
                $t->msisdn = $wallet->cust->msisdn;
                $t->bid_value = $bidVal;
                $t->product_id = $pId;
                $t->type = 2;
                $t->balance = $wallet->bid_balance + $wallet->daily_bid_balance;
                $t->save();
                return ['success', 'You Bid placed successfully'];
            } else {audit_log('dailybid not save');
                audit_log($wallet->cust->msisdn, 'bid_place', 'ok', " bid Product - $pId Bid - $bidVal");
                return ['error', 'Your bid can not be place right now.'];
            }

        }

    }

    public function actionProducts()
    {
        $user = $this->authRequest();

        $out = [];

        $q = 'SELECT a.id,a.name, a.image,a.description,a.image,a.price,a.winner_bid,a.start_date,a.end_date,a.winner_id,a.status,a.create_ts,a.update_ts,b.id as winId, b.msisdn,b.name as winner FROM `tbl_bid_product` a, tbl_bid_subscriber b WHERE
                a.winner_id = b.id and a.status = 3 order by id DESC limit 26';

        foreach (Yii::$app->db->createCommand($q)->queryAll() as $q) {
            $out[] = (object) $q;
        }

        return $this->render('products', ['list' => $out]);
    }

    public function actionProduct()
    {
        $msisdn = @$msisdn = Yii::$app->session->get('user')['cust']['msisdn'];
        $user = $this->authRequest($msisdn);
        if (!@$_REQUEST['product'] || !$product = BidProduct::findOne($_REQUEST['product'])) {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
        return $this->render('product', ['data' => $product]);
    }

    private function subUser($msisdn, $pack)
    {
        //TODO api call

        return true;
    }
}
