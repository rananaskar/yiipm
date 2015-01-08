<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Companyusers;

/**
 * CompanyusersSearch represents the model behind the search form about `frontend\models\Companyusers`.
 */
class CompanyusersSearch extends Companyusers
{
    public function rules()
    {
        return [
            [['id', 'company_id', 'user_id', 'use_gravatar', 'is_favorite', 'timezone', 'created_by_id', 'updated_by_id'], 'integer'],
            [['email', 'display_name', 'first_name', 'middle_name', 'last_name', 'title', 'avatar_file', 'office_number', 'fax_number', 'mobile_number', 'home_number', 'license_plate', 'food_preferences', 'department_details', 'location_details', 'language_preferences', 'created_on', 'updated_on'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Companyusers::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'company_id' => $this->company_id,
            'user_id' => $this->user_id,
            'use_gravatar' => $this->use_gravatar,
            'is_favorite' => $this->is_favorite,
            'timezone' => $this->timezone,
            'created_on' => $this->created_on,
            'created_by_id' => $this->created_by_id,
            'updated_on' => $this->updated_on,
            'updated_by_id' => $this->updated_by_id,
        ]);

        $query->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'display_name', $this->display_name])
            ->andFilterWhere(['like', 'first_name', $this->first_name])
            ->andFilterWhere(['like', 'middle_name', $this->middle_name])
            ->andFilterWhere(['like', 'last_name', $this->last_name])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'avatar_file', $this->avatar_file])
            ->andFilterWhere(['like', 'office_number', $this->office_number])
            ->andFilterWhere(['like', 'fax_number', $this->fax_number])
            ->andFilterWhere(['like', 'mobile_number', $this->mobile_number])
            ->andFilterWhere(['like', 'home_number', $this->home_number])
            ->andFilterWhere(['like', 'license_plate', $this->license_plate])
            ->andFilterWhere(['like', 'food_preferences', $this->food_preferences])
            ->andFilterWhere(['like', 'department_details', $this->department_details])
            ->andFilterWhere(['like', 'location_details', $this->location_details])
            ->andFilterWhere(['like', 'language_preferences', $this->language_preferences]);

        return $dataProvider;
    }
}
