<?php

/**
 * This is the model class for table "cms_doc".
 *
 * The followings are the available columns in table 'cms_doc':
 * @property integer $id
 * @property string $document_name
 * @property string $document_title
 * @property string $document_description
 * @property string $date_create
 * @property string $date_update
 * @property string $create_by
 * @property string $update_by
 */
class BaseCmsDoc extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCmsDoc the static model class
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
		return 'cms_doc';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('document_name, document_title', 'required'),
			array('document_name, document_title', 'length', 'max'=>128),
			array('create_by, update_by', 'length', 'max'=>32),
			array('document_description, date_create, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, document_name, document_title, document_description, date_create, date_update, create_by, update_by', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'document_name' => 'Document Name',
			'document_title' => 'Document Title',
			'document_description' => 'Document Description',
			'date_create' => 'Date Create',
			'date_update' => 'Date Update',
			'create_by' => 'Create By',
			'update_by' => 'Update By',
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
		$criteria->compare('document_name',$this->document_name,true);
		$criteria->compare('document_title',$this->document_title,true);
		$criteria->compare('document_description',$this->document_description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}