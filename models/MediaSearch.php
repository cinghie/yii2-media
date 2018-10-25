<?php

/**
 * @copyright Copyright &copy; Gogodigital Srls
 * @company Gogodigital Srls - Wide ICT Solutions
 * @website http://www.gogodigital.it
 * @package yii2-wishlist
 * @version 0.1.0
 */

namespace cinghie\media\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * ItemsSearch represents the model behind the search form of `vendor\cinghie\models\Items`.
 */
class MediaSearch extends Media
{

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'size', 'hits'], 'integer'],
            [['title','alias','reference','filename','duration','extension','mimetype'], 'safe'],
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
        $query = Media::find();

	    $dataProvider = new ActiveDataProvider([
		    'query' => $query,
		    'sort' => [
			    'defaultOrder' => [
				    'id' => SORT_DESC
			    ],
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
            'hits' => $this->hits,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
	        ->andFilterWhere(['like', 'alias', $this->alias])
	        ->andFilterWhere(['like', 'reference', $this->reference])
	        ->andFilterWhere(['like', 'filename', $this->filename])
	        ->andFilterWhere(['like', 'extension', $this->extension])
	        ->andFilterWhere(['like', 'mimetype', $this->mimetype]);

        return $dataProvider;
    }

}
