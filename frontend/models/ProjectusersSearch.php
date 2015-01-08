<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Projectusers;

/**
 * ProjectusersSearch represents the model behind the search form about `app\models\Projectusers`.
 */
class ProjectusersSearch extends Projectusers
{
    public function rules()
    {
        return [
            [['project_id', 'user_id', 'role_id', 'created_by_id'], 'integer'],
            [['note', 'created_on'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Projectusers::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'project_id' => $this->project_id,
            'user_id' => $this->user_id,
            'role_id' => $this->role_id,
            'created_on' => $this->created_on,
            'created_by_id' => $this->created_by_id,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
