<?php

namespace common\modules\link\models;

use Yii;

/**
 * This is the model class for table "{{%link_item}}".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $link
 * @property integer $price
 *
 * @property User $user
 * @property LinkUserBalance $userBalance
 */
class LinkItem extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%link_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'link'], 'required'],
            [['user_id', 'price'], 'integer'],
            [['link'], 'string', 'max' => 255],
            [['link'], 'unique'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'link' => 'Link',
            'price' => 'Price',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getUserBalance()
    {
        return $this->hasOne(LinkUserBalance::class, ['user_id' => 'user_id']);
    }
}
