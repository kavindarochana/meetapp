<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_bid_bid_transaction".
 *
 * @property int $id
 * @property string $msisdn
 * @property int $bid_value
 * @property string $wallet_id
 * @property int $type 1 = purchas, 2 = bid
 * @property string $customer_id
 * @property int $balance
 * @property string $product_id
 * @property string $create_ts
 */
class BidTransaction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bid_bid_transaction';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['bid_value', 'wallet_id', 'customer_id'], 'required'],
            [['bid_value', 'type', 'balance'], 'integer'],
            [['create_ts'], 'safe'],
            [['msisdn'], 'string', 'max' => 12],
            [['wallet_id', 'customer_id', 'product_id'], 'string', 'max' => 10],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msisdn' => 'Msisdn',
            'bid_value' => 'Bid Value',
            'wallet_id' => 'Wallet ID',
            'type' => 'Type',
            'customer_id' => 'Customer ID',
            'balance' => 'Balance',
            'product_id' => 'Product ID',
            'create_ts' => 'Create Ts',
        ];
    }
}
