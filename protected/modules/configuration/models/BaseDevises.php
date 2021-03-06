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
 * This is the model class for table "devises".
 *
 * The followings are the available columns in table 'devises':
 * @property integer $id
 * @property string $devise_name
 * @property string $devise_symbol
 * @property string $description
 * @property string $date_create
 * @property string $date_update
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Fees[] $fees
 */
class BaseDevises extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseDevises the static model class
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
		return 'devises';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('devise_name, devise_symbol', 'required'),
			array('devise_name, devise_symbol, create_by, update_by', 'length', 'max'=>45),
			array('description, date_create, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, devise_name, devise_symbol, description, date_create, date_update, create_by, update_by', 'safe', 'on'=>'search'),
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
			'fees' => array(self::HAS_MANY, 'Fees', 'devise'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app', 'ID'),
			'devise_name' =>Yii::t('app','Devise Name'),
			'devise_symbol' =>Yii::t('app', 'Devise Symbol'),
			'description' =>Yii::t('app', 'Description'),
			'date_create' => Yii::t('app','Date Create'),
			'date_update' =>Yii::t('app', 'Date Update'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
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
		$criteria->compare('devise_name',$this->devise_name,true);
		$criteria->compare('devise_symbol',$this->devise_symbol,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}