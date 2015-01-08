<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Cms;

/**
 * Cmss represents the model behind the search form about `app\models\Cms`.
 */
class Cmss extends Cms
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['title', 'keyword', 'pagename', 'pagedetails', 'status'], 'safe'],
        ];
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Cms::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'keyword', $this->keyword])
            ->andFilterWhere(['like', 'pagename', $this->pagename])
            ->andFilterWhere(['like', 'pagedetails', $this->pagedetails])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
