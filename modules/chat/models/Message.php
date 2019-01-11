<?php

namespace app\modules\chat\models;

use app\models\User;

use Yii;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "chat_message".
 *
 * @property int $id
 * @property int $user_id
 * @property int $chat_group_id
 * @property string $content
 * @property string $timestamp
 *
 * @property ChatGroup[] $groups
 * @property ChatGroup $group
 * @property User $user
 */
class Message extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */

    const SCENARIO_SELF_VALIDATOR = 'self'; //user is sending the message himself
    const SCENARIO_REMOTE_VALIDATOR = 'remote'; //a service or admin sending a message for the user

    public static function tableName()
    {
        return 'chat_message';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'chat_group_id'], 'required'],
            [['user_id', 'chat_group_id'], 'integer'],
            [['content'], 'string'],
            [['timestamp'], 'safe'],
            [['chat_group_id'], 'validateMyselfAsGroupMember', 'on' => self::SCENARIO_SELF_VALIDATOR],
            [['chat_group_id'], 'validateUserAsGroupMember','on' => self::SCENARIO_REMOTE_VALIDATOR],
            [['chat_group_id'], 'exist', 'skipOnError' => true, 'targetClass' => Group::className(), 'targetAttribute' => ['chat_group_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'timestamp',
                'updatedAtAttribute' => 'timestamp',
                'value' => new Expression('NOW()'),
            ],
        ];
    }

    public function validateUserAsGroupMember(){

    }
    public function validateMyselfAsGroupMember(){

    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'chat_group_id' => 'Chat Group ID',
            'content' => 'Content',
            'timestamp' => 'Timestamp',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    // public function getGroups()
    // {
    //     return $this->hasMany(Group::className(), ['last_message_id' => 'id']);
    // }

    public function getGroup()
    {
        return $this->hasOne(Group::className(), ['id' => 'chat_group_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_SELF_VALIDATOR => ['chat_group_id'],
            self::SCENARIO_REMOTE_VALIDATOR => ['chat_group_id'],
        ];
    }
}
