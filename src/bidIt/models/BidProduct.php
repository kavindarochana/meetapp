<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_bid_product".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property string $image
 * @property double $price
 * @property string $start_date
 * @property string $end_date
 * @property int $status 0-queue,1-active,2-end,3-disable/pause
 * @property string $create_ts
 * @property string $update_ts
 *
 * @property TblBidBidTransaction[] $tblBidBidTransactions
 */
class BidProduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bid_product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'image', 'price', 'start_date', 'end_date', 'update_ts'], 'required'],
            [['description'], 'string'],
            [['price'], 'number'],
            [['start_date', 'end_date', 'create_ts', 'update_ts'], 'safe'],
            [['status'], 'integer'],
            [['name'], 'string', 'max' => 35],
            [['image'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'description' => 'Description',
            'image' => 'Image',
            'price' => 'Price',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'create_ts' => 'Create Ts',
            'update_ts' => 'Update Ts',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTblBidBidTransactions()
    {
        return $this->hasMany(TblBidBidTransaction::className(), ['product_id' => 'id']);
    }
}
