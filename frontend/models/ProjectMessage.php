<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pm_project_messages".
 *
 * @property string $id
 * @property string $milestone_id
 * @property string $project_id
 * @property string $title
 * @property string $text
 * @property string $additional_text
 * @property integer $is_important
 * @property integer $is_private
 * @property integer $comments_enabled
 * @property integer $anonymous_comments_enabled
 * @property string $created_on
 * @property string $created_by_id
 * @property string $updated_on
 * @property string $updated_by_id
 */
class ProjectMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pm_project_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['milestone_id', 'project_id', 'is_important', 'is_private', 'comments_enabled', 'anonymous_comments_enabled', 'created_by_id', 'updated_by_id'], 'integer'],
            [['text', 'additional_text'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['title'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'milestone_id' => 'Milestone ID',
            'project_id' => 'Project ID',
            'title' => 'Title',
            'text' => 'Text',
            'additional_text' => 'Additional Text',
            'is_important' => 'Is Important',
            'is_private' => 'Is Private',
            'comments_enabled' => 'Comments Enabled',
            'anonymous_comments_enabled' => 'Anonymous Comments Enabled',
            'created_on' => 'Created On',
            'created_by_id' => 'Created By ID',
            'updated_on' => 'Updated On',
            'updated_by_id' => 'Updated By ID',
        ];
    }
}
