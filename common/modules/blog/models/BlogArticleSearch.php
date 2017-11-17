<?php

namespace common\modules\blog\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\blog\models\BlogArticle;

/**
 * BlogArticleSearch represents the model behind the search form about `\common\modules\blog\models\BlogArticle`.
 */
class BlogArticleSearch extends BlogArticle
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'image_id', 'blog_category_id', 'user_id'], 'integer'],
            [['code', 'title', 'preview_content', 'content', 'seo_keywords', 'seo_description', 'created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = BlogArticle::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
              'pageSize' => 5,
            ],
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
            'active' => $this->active,
            //'created_at' => $this->created_at,
            //'updated_at' => $this->updated_at,
            'image_id' => $this->image_id,
            'blog_category_id' => $this->blog_category_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'preview_content', $this->preview_content])
            ->andFilterWhere(['like', 'content', $this->content])
            ->andFilterWhere(['like', 'seo_keywords', $this->seo_keywords])
            ->andFilterWhere(['like', 'seo_description', $this->seo_description])
            ->andFilterWhere(['>=', 'updated_at', $this->updated_at])
            ->andFilterWhere(['>=', 'created_at', $this->created_at]);

        return $dataProvider;
    }
}
