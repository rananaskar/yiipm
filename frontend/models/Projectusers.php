<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pm_project_users".
 *
 * @property string $project_id
 * @property string $user_id
 * @property string $note
 * @property string $role_id
 * @property string $created_on
 * @property string $created_by_id
 */
class Projectusers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pm_project_users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'role_id', 'created_by_id'], 'integer'],
            [['note'], 'string'],
            [['created_on'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'project_id' => 'Project ID',
            'user_id' => 'User ID',
            'note' => 'Note',
            'role_id' => 'Role ID',
            'created_on' => 'Created On',
            'created_by_id' => 'Created By ID',
        ];
    }
}
