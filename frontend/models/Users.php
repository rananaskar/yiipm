<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * Users represents the model behind the search form about `app\models\User`.
 */
class Users extends User
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fullname', 'email', 'username', 'password', 'joined_date', 'dob', 'gender'], 'safe'],
            [['email'],'checkemailexists']
        ];
    }
    
    function checkemailexists($attribute, $param){
        $this->addError($attribute, 'eroarea');
    }

    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = User::find();

        $query->where("user_type!='A'");
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }
        

        $query->andFilterWhere([
            'id' => $this->id,
            'joined_date' => $this->joined_date,
            'dob' => $this->dob,
        ]);

        $query->andFilterWhere(['like', 'fullname', $this->fullname])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'password', $this->password])
            ->andFilterWhere(['like', 'gender', $this->gender]);

        return $dataProvider;
    }
}
