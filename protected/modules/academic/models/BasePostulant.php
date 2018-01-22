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
 * This is the model class for table "postulant".
 *
 * The followings are the available columns in table 'postulant':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $blood_group
 * @property string $birthday
 * @property integer $cities
 * @property string $adresse
 * @property string $phone
 * @property string $health_state
 * @property string $person_liable
 * @property string $person_liable_phone
 * @property string $person_liable_adresse
 * @property integer $person_liable_relation
 * @property integer $apply_for_level
 * @property integer $previous_level
 * @property string $previous_school
 * @property string $school_date_entry
 * @property double $last_average
 * @property integer $status
 * @property integer $academic_year
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Levels $applyForLevel
 * @property Cities $cities0
 * @property Levels $previousLevel
 * @property Relations $personLiableRelation
 */
class BasePostulant extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Postulant the static model class
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
		return 'postulant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('first_name, last_name, gender, apply_for_level, previous_level', 'required'),
			array('cities, person_liable_relation, apply_for_level, previous_level, status, academic_year', 'numerical', 'integerOnly'=>true),
			array('last_average', 'numerical'),
			array('first_name', 'length', 'max'=>120),
			array('last_name, gender, phone, create_by, update_by', 'length', 'max'=>45),
			array('blood_group', 'length', 'max'=>10),
			array('health_state, adresse, person_liable_adresse, previous_school', 'length', 'max'=>255),
			array('person_liable', 'length', 'max'=>100),
			array('person_liable_phone', 'length', 'max'=>65),
			array('birthday, date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, first_name, last_name, gender, blood_group, birthday, cities, adresse, phone, health_state, person_liable, person_liable_phone, person_liable_adresse, person_liable_relation, apply_for_level, previous_level, previous_school, school_date_entry, last_average, status, academic_year, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'academicPeriod' => array(self::BELONGS_TO, 'Academicperiods', 'academic_year'),
			'applyForLevel' => array(self::BELONGS_TO, 'Levels', 'apply_for_level'),
			'cities0' => array(self::BELONGS_TO, 'Cities', 'cities'),
			'previousLevel' => array(self::BELONGS_TO, 'Levels', 'previous_level'),
			'personLiableRelation' => array(self::BELONGS_TO, 'Relations', 'person_liable_relation'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'first_name' => Yii::t('app','First Name'),
			'last_name' => Yii::t('app','Last Name'),
			'gender' => Yii::t('app','Gender'),
			'blood_group' => Yii::t('app','Blood Group'),
			'birthday' => Yii::t('app','Birthday'),
			'cities' => Yii::t('app','Cities'),
			'adresse' => Yii::t('app','Adresse'),
			'phone' => Yii::t('app','Phone'),
			'health_state' => Yii::t('app','Health state'),
			'person_liable' => Yii::t('app','Person liable'),
			'person_liable_phone' => Yii::t('app','Person liable phone'),
			'person_liable_adresse' => Yii::t('app','Person Liable Adresse'),
			'person_liable_relation' => Yii::t('app','Person Liable Relation'),
			'apply_for_level' => Yii::t('app','Apply for level'),
			'previous_level' => Yii::t('app','Previous Level'),
			'previous_school' => Yii::t('app','Previous School'),
			'school_date_entry' => Yii::t('app','School Date Entry'),
			'last_average' => Yii::t('app','Last Average'),
			'status' => Yii::t('app','Status'),
			'academic_year' => Yii::t('app','Academic Year'),
			'date_created' => Yii::t('app','Date Created'),
			'date_updated' => Yii::t('app','Date Updated'),
			'create_by' => Yii::t('app','Create By'),
			'update_by' => Yii::t('app','Update By'),
		);
	}
 
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
/*	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('blood_group',$this->blood_group,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('cities',$this->cities);
		$criteria->compare('adresse',$this->adresse,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('health_state',$this->health_state,true);
		$criteria->compare('person_liable',$this->person_liable,true);
		$criteria->compare('person_liable_phone',$this->person_liable_phone,true);
		$criteria->compare('person_liable_adresse',$this->person_liable_adresse,true);
		$criteria->compare('person_liable_relation',$this->person_liable_relation);
		$criteria->compare('apply_for_level',$this->apply_for_level);
		$criteria->compare('previous_level',$this->previous_level);
		$criteria->compare('previous_school',$this->previous_school,true);
		$criteria->compare('school_date_entry',$this->school_date_entry,true);
		$criteria->compare('last_average',$this->last_average);
		$criteria->compare('status',$this->status);
		$criteria->compare('academic_year',$this->academic_year,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	*/
}