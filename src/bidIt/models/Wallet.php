<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_bid_wallet".
 *
 * @property int $id
 * @property int $cust_id
 * @property int $bid_balance
 * @property int $daily_bid_balance
 * @property int $daily_bid_balance_stauts
 * @property string $expire
 * @property string $create_ts
 * @property string $update_ts
 *
 * @property TblBidSubscriber $cust
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bid_wallet';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cust_id', 'bid_balance', 'update_ts'], 'required'],
            [['cust_id', 'bid_balance', 'daily_bid_balance', 'daily_bid_balance_stauts'], 'integer'],
            [['expire', 'create_ts', 'update_ts'], 'safe'],
            [['cust_id'], 'exist', 'skipOnError' => true, 'targetClass' => Subscriber::className(), 'targetAttribute' => ['cust_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cust_id' => 'Cust ID',
            'bid_balance' => 'Bid Balance',
            'daily_bid_balance' => 'Daily Bid Balance',
            'daily_bid_balance_stauts' => 'Daily Bid Balance Stauts',
            'expire' => 'Expire',
            'create_ts' => 'Create Ts',
            'update_ts' => 'Update Ts',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCust()
    {
        return $this->hasOne(Subscriber::className(), ['id' => 'cust_id']);
    }
}
