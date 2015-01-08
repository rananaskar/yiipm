<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pm_companies".
 *
 * @property string $id
 * @property string $client_of_id
 * @property string $name
 * @property string $description
 * @property string $email
 * @property string $address
 * @property string $city
 * @property string $state
 * @property string $zipcode
 * @property string $country
 * @property string $phone_number
 * @property string $logo_file
 * @property double $timezone
 * @property string $created_on
 * @property string $created_by_id
 * @property string $updated_on
 * @property string $updated_by_id
 */
class Client extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pm_companies';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name','email','phone_number','country'], 'required'],
            [['client_of_id', 'created_by_id', 'updated_by_id'], 'integer'],
            [['description'], 'string'],
            [['timezone'], 'number'],
            [['created_on', 'updated_on'], 'safe'],
            [['name', 'city', 'state', 'zipcode', 'country', 'phone_number', 'logo_file'], 'string', 'max' => 50],
            [['email', 'address'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'client_of_id' => 'Client Of ID',
            'name' => 'Name',
            'description' => 'Description',
            'email' => 'Email',
            'address' => 'Address',
            'city' => 'City',
            'state' => 'State',
            'zipcode' => 'Zipcode',
            'country' => 'Country',
            'phone_number' => 'Phone Number',
            'logo_file' => 'Logo File',
            'timezone' => 'Timezone',
            'created_on' => 'Created On',
            'created_by_id' => 'Created By ID',
            'updated_on' => 'Updated On',
            'updated_by_id' => 'Updated By ID',
        ];
    }
}
