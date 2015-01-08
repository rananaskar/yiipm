<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "sugar_users".
 *
 * @property integer $id
 * @property string $fullname
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $joined_date
 * @property string $dob
 * @property string $gender
 */
class User extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pm_users';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
//            [['fullname', 'email', 'username', 'joined_date', 'dob', 'gender'], 'required'],
//            [['fullname', 'email', 'username', 'password', 'joined_date', 'dob', 'gender'], 'required','on' => 'create'],
//            [['joined_date', 'dob'], 'safe'],
//            [['gender'], 'string'],
//            [['fullname', 'email', 'username', 'password'], 'string', 'max' => 256],
//            ['email', function ($attribute, $params) {
//                $data = User::findOne(['email' => $this->$attribute]);
//                if (!empty($data)) {
//                    $this->addError($attribute, "This email already registered");
//                }
//            },'on' => 'create'],
            ['username', function ($attribute, $params) {
            $data = User::findOne(['username' => $this->$attribute]);
            if (!empty($data)) {
                $this->addError($attribute, "This username already taken");
            }
        }, 'on' => 'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'fullname' => 'Name',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'joined_date' => 'Joined Date',
            'dob' => 'Date Of Birth',
            'gender' => 'Gender',
        ];
    }

}
