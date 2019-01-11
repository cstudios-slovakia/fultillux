<?php

namespace app\modules\chat\models;

use Yii;

use app\models\Assignment;
use app\models\Project;
use app\modules\chat\models\Member;

use thamtech\uuid\helpers\UuidHelper;

use yii\db\Exception;
use yii\db\Expression;
use yii\behaviors\TimestampBehavior;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "chat_group".
 *
 * @property int $id
 * @property string $name
 * @property int $status
 * @property int $last_message_id
 * @property string $last_notification_at
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Message $message
 * @property Member[] $members
 * @property Message[] $messages
 */
class Group extends \yii\db\ActiveRecord
{

    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE   = 1;
    const STATUS_MFD      = 2; //marked for deletion
    const STATUS_RFD      = 3; //ready for deletion

    const STATUS_MARKED_FOR_DELETION     = 2;
    const STATUS_READY_FOR_DELETION      = 3;

    public static function tableName()
    {
        return 'chat_group';
    }

    public function rules()
    {
        return [
            [['status', 'last_message_id'], 'integer'],
            [['last_notification_at', 'created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['last_message_id'], 'exist', 'skipOnError' => true, 'targetClass' => Message::className(), 'targetAttribute' => ['last_message_id' => 'id']],
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
                'value' => new Expression('NOW()'),
            ],
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
            'status' => 'Status',
            'last_message_id' => 'Last Message ID',
            'last_notification_at' => 'Last Notification At',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function create($userIds, $projectId = null, $assignmentId = null, $name = null){

      if($this->isNewRecord){

        $this->status = self::STATUS_ACTIVE;
        $this->project_id = $projectId;
        $this->assignment_id = $assignmentId;

        if (!isset($name)) {
          $this->name = UuidHelper::uuid();
        }else{
          $this->name = $name;
        }

        if($this->save()){

          foreach ($userIds as $userId) {
            $member = new Member;
            $member->chat_group_id = $this->id;
            $member->user_id = $userId;
            if (!$member->save()) throw new RuntimeException('Could not save $member');
          }

          return true;

        }else{
          throw new Exception('Could not save this group.');
        }

        $this->save();

      }else{
        throw new Exception('You need a completely new record for this');
      }

    }

    public function getStatuses()
    {
        return [
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_MFD => 'Marked for deletion',
            self::STATUS_RFD => 'Ready for deletion',
        ];
    }

    public function getMessage()
    {
        return $this->hasOne(Message::className(), ['id' => 'last_message_id']);
    }

    public function getMembers()
    {
        return $this->hasMany(Member::className(), ['chat_group_id' => 'id']);
    }

    public function getMessages()
    {
        return $this->hasMany(Message::className(), ['chat_group_id' => 'id']);
    }
}
