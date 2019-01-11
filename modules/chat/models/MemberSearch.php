<?php

namespace app\modules\chat\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\chat\models\Member;

/**
 * MemberSearch represents the model behind the search form of `app\modules\chat\models\Member`.
 */
class MemberSearch extends Member
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'chat_group_id'], 'integer'],
            [['joined_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Member::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'chat_group_id' => $this->chat_group_id,
            'joined_at' => $this->joined_at,
        ]);

        return $dataProvider;
    }
}
