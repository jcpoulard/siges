<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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
 * This is the model class for table "users".
 *
 * The followings are the available columns in table 'users':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property integer $active
 * @property integer $person_id
 * @property string $create_by
 * @property string $update_by
 * @property string $date_created
 * @property string $date_updated
 * @property integer $profil
 * @property integer $group_id
 *
 * The followings are the available model relations:
 * @property Persons $person
 * @property Groups $group0
 * @property Profil $profil0
 */
class BaseUser extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseUser the static model class
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
		return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username', 'required'),
			array('person_id, active, group_id, profil', 'numerical', 'integerOnly'=>true),
			array('username', 'length', 'max'=>20),
			//array('profil', 'length', 'max'=>32),
			array('password', 'length', 'max'=>128),
			array('create_by, update_by', 'length', 'max'=>255),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, profil, username, active, password, person_id, created_by, update_by, date_created, date_updated, group_id', 'safe', 'on'=>'search'),
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
			'person' => array(self::BELONGS_TO, 'Persons', 'person_id'),
            'group0'=>array(self::BELONGS_TO,'Groups','group_id'),
            'profil0'=>array(self::BELONGS_TO,'Profil','profil'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'username' => Yii::t('app','Username'),
			'password' => Yii::t('app','Password'),
			'active'=>Yii::t('app','Active'),
			'person_id' => Yii::t('app','Person'),
			'person_lname'=>Yii::t('app','Last name'),
			'person_fname'=>Yii::t('app','First name'),
			'profil' => Yii::t('app','profil'),
            'group_id' => Yii::t('app','Group user'),
			'create_by' => Yii::t('app','Create By'),
			'update_by' => Yii::t('app','Update By'),
			'date_created' => Yii::t('app','Date Created'),
			'date_updated' => Yii::t('app','Date Updated'),
                        
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

		$criteria->compare('id',$this->id,true);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('password',$this->password,true);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('profil',$this->profil);
                $criteria->compare('group_id',$this->group_id);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}