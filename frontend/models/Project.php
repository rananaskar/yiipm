<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pm_projects".
 *
 * @property string $id
 * @property string $name
 * @property string $parent_id
 * @property string $description
 * @property integer $show_description_in_overview
 * @property string $logo_file
 * @property string $completed_on
 * @property integer $completed_by_id
 * @property string $created_on
 * @property string $created_by_id
 * @property string $updated_on
 * @property string $updated_by_id
 */
class Project extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pm_projects';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['show_description_in_overview', 'completed_by_id', 'created_by_id', 'updated_by_id'], 'integer'],
            [['description'], 'string'],
            [['completed_on', 'created_on', 'updated_on'], 'safe'],
            [['name'], 'string', 'max' => 50],
            [['logo_file'], 'string', 'max' => 44]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent Project',
            'description' => 'Description',
            'show_description_in_overview' => 'Show Description In Overview',
            'logo_file' => 'Logo File',
            'completed_on' => 'Completed On',
            'completed_by_id' => 'Completed By ID',
            'created_on' => 'Created On',
            'created_by_id' => 'Created By ID',
            'updated_on' => 'Updated On',
            'updated_by_id' => 'Updated By ID',
        ];
    }
}
