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
 * This is the model class for table "student_other_info".
 *
 * The followings are the available columns in table 'student_other_info':
 * @property integer $id
 * @property integer $student
 * @property string $school_date_entry
 * @property string $leaving_date
 * @property string $previous_school
 * @property string $previous_level
 * @property string $apply_for_level
 * @property string $health_state
 * @property string $father_full_name
 * @property string $mother_full_name
 * @property string $person_liable
 * @property string $person_liable_phone
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Persons $student0
 */

class BaseStudentOtherInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseStudentOtherInfo the static model class
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
		return 'student_other_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('previous_school, school_date_entry', 'required'),
			array('student', 'numerical', 'integerOnly'=>true),
			array('previous_school, health_state', 'length', 'max'=>255),
			array('previous_level, apply_for_level, create_by, update_by', 'length', 'max'=>45),
			array('father_full_name, mother_full_name, person_liable', 'length', 'max'=>100),
			array('person_liable_phone', 'length', 'max'=>65),
			array('school_date_entry, date_created, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student,health_state,mother_full_name,person_liable,person_liable_phone, school_date_entry, leaving_date, previous_school, previous_level, apply_for_level, date_created, date_update, create_by, update_by', 'safe', 'on'=>'search'),
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
			'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'student' => 'Student',
			'school_date_entry' => 'School Date Entry',
			'leaving_date' => 'Leaving Date',
			'previous_school' => 'Previous School',
			'previous_level' => 'Previous Level',
			'apply_for_level'=>'Apply for level',
			'health_state'=> Yii::t('app','Health state'),
			'father_full_name'=> Yii::t('app','Father full name'),
			'mother_full_name'=> Yii::t('app','Mother full name'),
			'person_liable'=> Yii::t('app','Person liable'),
			'person_liable_phone'=> Yii::t('app','Person liable phone'),
			'date_created' => 'Date Created',
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
		$criteria->compare('student',$this->student);
		$criteria->compare('school_date_entry',$this->school_date_entry,true);
		$criteria->compare('leaving_date',$this->leaving_date,true);
		$criteria->compare('previous_school',$this->previous_school,true);
		$criteria->compare('previous_level',$this->previous_level,true);
		$criteria->compare('apply_for_level',$this->apply_for_level,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}