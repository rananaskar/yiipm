<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Project;

/**
 * Projects represents the model behind the search form about `app\models\Project`.
 */
class Projects extends Project
{
    public function rules()
    {
        return [
            [['id', 'parent_id', 'show_description_in_overview', 'completed_by_id', 'created_by_id', 'updated_by_id'], 'integer'],
            [['name', 'description', 'logo_file', 'completed_on', 'created_on', 'updated_on'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Project::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'parent_id' => $this->parent_id,
            'show_description_in_overview' => $this->show_description_in_overview,
            'completed_on' => $this->completed_on,
            'completed_by_id' => $this->completed_by_id,
            'created_on' => $this->created_on,
            'created_by_id' => $this->created_by_id,
            'updated_on' => $this->updated_on,
            'updated_by_id' => $this->updated_by_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'logo_file', $this->logo_file]);

        return $dataProvider;
    }
}
