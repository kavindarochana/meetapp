<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tbl_bid_config".
 *
 * @property int $id
 * @property string $config
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tbl_bid_config';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['config', 'value'], 'required'],
            [['value'], 'string'],
            [['config'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'config' => 'Config',
            'value' => 'Value',
        ];
    }
}
