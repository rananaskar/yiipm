<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pm_comments".
 *
 * @property string $id
 * @property string $rel_object_id
 * @property string $rel_object_manager
 * @property string $text
 * @property integer $is_private
 * @property integer $is_anonymous
 * @property string $author_name
 * @property string $author_email
 * @property string $author_homepage
 * @property string $created_on
 * @property string $created_by_id
 * @property string $updated_on
 * @property string $updated_by_id
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pm_comments';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['rel_object_id', 'is_private', 'is_anonymous', 'created_by_id', 'updated_by_id'], 'integer'],
            [['text'], 'string'],
            [['created_on', 'updated_on'], 'safe'],
            [['rel_object_manager', 'author_name'], 'string', 'max' => 50],
            [['author_email', 'author_homepage'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'rel_object_id' => 'Rel Object ID',
            'rel_object_manager' => 'Rel Object Manager',
            'text' => 'Text',
            'is_private' => 'Is Private',
            'is_anonymous' => 'Is Anonymous',
            'author_name' => 'Author Name',
            'author_email' => 'Author Email',
            'author_homepage' => 'Author Homepage',
            'created_on' => 'Created On',
            'created_by_id' => 'Created By ID',
            'updated_on' => 'Updated On',
            'updated_by_id' => 'Updated By ID',
        ];
    }
}
