<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pm_client_users".
 *
 * @property string $id
 * @property string $company_id
 * @property string $user_id
 * @property string $email
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $display_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $title
 * @property string $avatar_file
 * @property integer $use_gravatar
 * @property integer $is_favorite
 * @property double $timezone
 * @property string $office_number
 * @property string $fax_number
 * @property string $mobile_number
 * @property string $home_number
 * @property string $license_plate
 * @property string $food_preferences
 * @property string $department_details
 * @property string $location_details
 * @property string $language_preferences
 * @property string $created_on
 * @property string $created_by_id
 * @property string $updated_on
 * @property string $updated_by_id
 */
class ClientUsers extends \yii\db\ActiveRecord {

    public $username;
    public $password;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pm_client_users';
    }
    
    public function scenarios()
    {
	$scenarios = parent::scenarios();
        $scenarios['create'] = ['display_name', 'email', 'username', 'first_name', 'last_name', 'password', 'timezone'];//Scenario Values Only Accepted
        $scenarios['update'] = ['display_name', 'email', 'username', 'first_name', 'last_name', 'timezone'];//Scenario Values Only Accepted
        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['display_name', 'email', 'username', 'first_name', 'last_name', 'password', 'timezone'], 'required','on'=>'create'],
            [['display_name', 'email', 'username', 'first_name', 'last_name', 'timezone'], 'required','on'=>'update'],
            [['company_id', 'user_id', 'use_gravatar', 'is_favorite', 'created_by_id', 'updated_by_id'], 'integer'],
            [['timezone'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['display_name', 'first_name', 'middle_name', 'last_name', 'title', 'avatar_file', 'office_number', 'fax_number', 'mobile_number', 'home_number', 'license_plate', 'food_preferences', 'department_details', 'location_details', 'language_preferences'], 'string', 'max' => 50],
            ['username', function ($attribute, $params) {
            $data = User::findOne(['username' => $this->$attribute]);
            if (!empty($data)) {
                $this->addError($attribute, "This username already taken");
            }
        },'on'=>'create'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'company_id' => 'Company ID',
            'user_id' => 'User ID',
            'email' => 'Email',
            'username' => 'Username',
            'password' => 'Password',
            'display_name' => 'Display Name',
            'first_name' => 'First Name',
            'middle_name' => 'Middle Name',
            'last_name' => 'Last Name',
            'title' => 'Title',
            'avatar_file' => 'Avatar File',
            'use_gravatar' => 'Use Gravatar',
            'is_favorite' => 'Is Favorite',
            'timezone' => 'Timezone',
            'office_number' => 'Office Number',
            'fax_number' => 'Fax Number',
            'mobile_number' => 'Mobile Number',
            'home_number' => 'Home Number',
            'license_plate' => 'License Plate',
            'food_preferences' => 'Food Preferences',
            'department_details' => 'Department Details',
            'location_details' => 'Location Details',
            'language_preferences' => 'Language Preferences',
            'created_on' => 'Created On',
            'created_by_id' => 'Created By ID',
            'updated_on' => 'Updated On',
            'updated_by_id' => 'Updated By ID',
        ];
    }

}
