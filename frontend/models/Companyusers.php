<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pm_company_users".
 *
 * @property string $id
 * @property string $company_id
 * @property string $user_id
 * @property string $email
 * @property string $display_name
 * @property string $first_name
 * @property string $middle_name
 * @property string $last_name
 * @property string $title
 * @property string $avatar_file
 * @property integer $use_gravatar
 * @property integer $is_favorite
 * @property integer $timezone
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
 *
 * @property PmCompanies $company
 */
class Companyusers extends \yii\db\ActiveRecord {

    public $password;
    public $user_name;
    public $status;

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'pm_company_users';
    }

    /**
     * @inheritdoc
     */
   
    public function rules() {
        return [
            [['email', 'display_name', 'first_name', 'last_name', 'mobile_number', 'password', 'user_name', 'timezone', 'status'], 'required', "on"=>"create"],
            [['email', 'display_name', 'first_name', 'last_name', 'mobile_number', 'user_name', 'timezone', 'status'], 'required', "on"=>"update"],
            ['email', 'email'],
            [['avatar_file'], 'file'],
            [['company_id', 'user_id', 'use_gravatar', 'is_favorite', 'created_by_id', 'updated_by_id'], 'integer'],
            [['timezone'], 'integer', 'message' => 'Select a proper timezone'],
            [['created_on', 'updated_on', 'password'], 'safe'],
            [['email'], 'string', 'max' => 255],
            [['display_name', 'first_name', 'middle_name', 'last_name', 'title', 'avatar_file', 'office_number', 'fax_number', 'mobile_number', 'home_number', 'license_plate', 'food_preferences', 'department_details', 'location_details', 'language_preferences'], 'string', 'max' => 50],
            ['user_name', function ($attribute, $params) {
                $data = \app\models\User::findOne(['username' => $this->$attribute]);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCompany() {
        return $this->hasOne(PmCompanies::className(), ['id' => 'company_id']);
    }

}
