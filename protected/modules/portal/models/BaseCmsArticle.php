<?php
 /*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License.

    SIGES is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with SIGES.  If not, see <http://www.gnu.org/licenses/>.
 * 
 */
/**
 * This is the model class for table "cms_article".
 *
 * The followings are the available columns in table 'cms_article':
 * @property integer $id
 * @property string $article_title
 * @property string $article_description
 * @property string $date_create
 * @property string $create_by
 * @property integer $is_publish
 * @property integer $section
 * @property string $last_update
 * @property string $set_position
 *
 * The followings are the available model relations:
 * @property CmsSection $section0
 */
class BaseCmsArticle extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCmsArticle the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'cms_article';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('article_title, article_description', 'required'),
			array('is_publish, section, rank_article', 'numerical', 'integerOnly'=>true),
			array('article_title', 'length', 'max'=>255),
			array('create_by', 'length', 'max'=>128),
			array('set_position', 'length', 'max'=>64),
			array('date_create, last_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, article_title, rank_article, article_menu, article_description, date_create, create_by, is_publish, section, last_update, set_position', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'section0' => array(self::BELONGS_TO, 'CmsSection', 'section'),
                        'articleMenu' => array(self::BELONGS_TO, 'CmsMenu', 'article_menu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			
			'article_title' =>Yii::t('app','Article Title'),
			'article_description' =>Yii::t('app', 'Article Description'),
			'date_create' =>Yii::t('app', 'Date Create'),
			'create_by' =>Yii::t('app', 'Create By'),
			'is_publish' =>Yii::t('app', 'Is Publish'),
			'section' =>Yii::t('app', 'Section'),
			'last_update' =>Yii::t('app', 'Last Update'),
			'set_position' =>Yii::t('app', 'Set Position'),
                        'publish'=>Yii::t('app','Is Publish'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('article_title',$this->article_title,true);
		$criteria->compare('article_description',$this->article_description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('create_by',$this->create_by,true);
                $criteria->compare('article_menu',$this->article_menu);
		$criteria->compare('is_publish',$this->is_publish);
                $criteria->compare('rank_article',$this->rank_article);
		$criteria->compare('section',$this->section);
		$criteria->compare('last_update',$this->last_update,true);
		$criteria->compare('set_position',$this->set_position,true);
                $criteria->order = 'id DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}