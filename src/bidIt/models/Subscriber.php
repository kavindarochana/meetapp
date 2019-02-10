<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_bid_subscriber".
 *
 * @property int $id
 * @property string $msisdn
 * @property string $nic
 * @property string $name
 * @property string $email
 * @property int $status
 * @property int $chanel 1=web, 2=ussd, 3=sms, 4 = mobile app, 5 = unknown
 * @property string $propic
 * @property string $create_ts
 * @property string $update_ts
 *
 * @property TblBidWallet[] $tblBidWallets
 */
class Subscriber extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bid_subscriber';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['msisdn'], 'required'],
            [['status', 'chanel'], 'integer'],
            [['create_ts', 'update_ts'], 'safe'],
            [['msisdn'], 'string', 'max' => 15],
            [['nic'], 'string', 'max' => 12],
            [['email'], 'string', 'max' => 60],
            [['name'], 'string', 'max' => 100],
            [['propic'], 'string', 'max' => 140],
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
            'nic' => 'Nic',
            'name' => 'Name',
            'email' => 'Email',
            'status' => 'Status',
            'chanel' => 'Chanel',
            'propic' => 'Propic',
            'create_ts' => 'Create Ts',
            'update_ts' => 'Update Ts',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblBidWallets()
    {
        return $this->hasMany(Wallet::className(), ['cust_id' => 'id']);
    }
}
