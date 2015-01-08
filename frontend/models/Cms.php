<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sugar_cms".
 *
 * @property integer $id
 * @property string $title
 * @property string $keyword
 * @property string $pagename
 * @property string $pagedetails
 * @property string $status
 */
class Cms extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sugar_cms';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'keyword', 'pagename', 'pagedetails'], 'required'],
            [['keyword', 'pagedetails', 'status'], 'string'],
            [['title'], 'string', 'max' => 255],
            [['pagename'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'keyword' => 'Keyword',
            'pagename' => 'Page Name',
            'pagedetails' => 'Page Content',
            'status' => 'Status',
        ];
    }
}
