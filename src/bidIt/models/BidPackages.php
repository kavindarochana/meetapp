<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_bid_packages".
 *
 * @property int $id
 * @property string $name
 * @property double $price
 * @property int $bids
 * @property int $status
 * @property string $image
 * @property string $create_ts
 * @property string $update_ts
 */
class BidPackages extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bid_packages';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price', 'bids', 'update_ts'], 'required'],
            [['price'], 'number'],
            [['bids', 'status'], 'integer'],
            [['create_ts', 'update_ts'], 'safe'],
            [['name'], 'string', 'max' => 100],
            [['image'], 'string', 'max' => 150],
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
            'price' => 'Price',
            'bids' => 'Bids',
            'status' => 'Status',
            'image' => 'Image',
            'create_ts' => 'Create Ts',
            'update_ts' => 'Update Ts',
        ];
    }
}
