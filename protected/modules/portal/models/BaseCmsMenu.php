<?php

/**
 * This is the model class for table "cms_menu".
 *
 * The followings are the available columns in table 'cms_menu':
 * @property integer $id
 * @property string $menu_label
 * @property integer $menu_position
 * @property integer $is_publish
 * @property string $date_create
 * @property string $date_update
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property CmsArticle[] $cmsArticles
 */
class BaseCmsMenu extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCmsMenu the static model class
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
		return 'cms_menu';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('menu_label, menu_position', 'required'),
			array('menu_position, is_publish', 'numerical', 'integerOnly'=>true),
			array('menu_label', 'length', 'max'=>64),
			array('create_by, update_by', 'length', 'max'=>32),
			array('date_create, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, menu_label, menu_position, is_publish, date_create, date_update, create_by, update_by', 'safe', 'on'=>'search'),
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
			'cmsArticles' => array(self::HAS_MANY, 'CmsArticle', 'article_menu'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'menu_label' =>Yii::t('app','Menu Label'),
			'menu_position' =>Yii::t('app',  'Menu Position'),
			'is_publish' =>   Yii::t('app',   'Is Publish'),
			'date_create' =>  Yii::t('app',     'Date Create'),
			'date_update' =>  Yii::t('app',     'Date Update'),
			'create_by' =>    Yii::t('app',     'Create By'),
			'update_by' =>    Yii::t('app', 'Update By'),
                        'article_menu'=>Yii::t('app','Article menu'),
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
		$criteria->compare('menu_label',$this->menu_label,true);
		$criteria->compare('menu_position',$this->menu_position);
		$criteria->compare('is_publish',$this->is_publish);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->order = 'menu_label ASC';
                $criteria->condition = 'is_home IS NULL';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}