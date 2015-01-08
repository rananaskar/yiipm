<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Client;

/**
 * Clients represents the model behind the search form about `app\models\Client`.
 */
class Clients extends Client
{
    public function rules()
    {
        return [
            [['id', 'client_of_id', 'created_by_id', 'updated_by_id'], 'integer'],
            [['name', 'description', 'email', 'address', 'city', 'state', 'zipcode', 'country', 'phone_number', 'logo_file', 'created_on', 'updated_on'], 'safe'],
            [['timezone'], 'number'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Client::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'client_of_id' => $this->client_of_id,
            'timezone' => $this->timezone,
            'created_on' => $this->created_on,
            'created_by_id' => $this->created_by_id,
            'updated_on' => $this->updated_on,
            'updated_by_id' => $this->updated_by_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'zipcode', $this->zipcode])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'phone_number', $this->phone_number])
            ->andFilterWhere(['like', 'logo_file', $this->logo_file]);

        return $dataProvider;
    }
}
