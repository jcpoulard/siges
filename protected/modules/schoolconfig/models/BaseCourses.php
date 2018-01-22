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
 * This is the model class for table "courses".
 *
 * The followings are the available columns in table 'courses':
 * @property integer $id
 * @property integer $subject
 * @property integer $teacher
 * @property integer $room
 * @property integer $academic_period
 * @property double $weight
 * @property integer $debase
 * @property integer $optional
 * @property integer $old_new
 * @property integer $reference_id
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicPeriod
 * @property Rooms $room0
 * @property Persons $teacher0
 * @property Subjects $subject0
 * @property Grades[] $grades
 * @property Schedules[] $schedules
 */
class BaseCourses extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCourses the static model class
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
		return 'courses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
  public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('subject, teacher, room, academic_period, weight', 'required'),
			array('subject, teacher, room, academic_period,debase,optional,old_new', 'numerical', 'integerOnly'=>true),
			array('weight,reference_id', 'numerical'),
			array('create_by, update_by', 'length', 'max'=>45),
			array('date_created, date_updated', 'safe'),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, subject, teacher, room, academic_period, weight, debase, optional, old_new, reference_id, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'subject0' => array(self::BELONGS_TO, 'Subjects', 'subject'),
			'teacher0' => array(self::BELONGS_TO, 'Persons', 'teacher'),
			'room0' => array(self::BELONGS_TO, 'Rooms', 'room'),
			'academicPeriod' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_period'),
			'grades' => array(self::HAS_MANY, 'Grades', 'course'),
			'schedules' => array(self::HAS_MANY, 'Schedules', 'course'),
			
			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app','ID'),
			'subject' =>Yii::t('app', 'Subject'),
			'teacher' =>Yii::t('app', 'Teacher'),
			'room' =>Yii::t('app', 'Room'),
			'academic_period' =>Yii::t('app', 'Academic Period'),
			'weight' =>Yii::t('app','Weight'),
			'debase' =>Yii::t('app','De base'),
			'optional' =>Yii::t('app','Optional'),
			'old_new' =>Yii::t('app','Old/New'),
			'reference_id' =>Yii::t('app','Id Reference'),
			'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app', 'Date Updated'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
			
			
		);
	}

	
	
	public function search($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with= array('room0','subject0','academicPeriod','teacher0');
				
		$criteria->condition=($condition.' (academicPeriod.year='.$acad.' OR academicPeriod.id='.$acad.') ');
		
		
		$criteria->compare('id',$this->id);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('teacher0.first_name',$this->teacher_fname,true);
		$criteria->compare('teacher0.last_name',$this->teacher_lname,true);
		$criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('academicPeriod.name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('debase',$this->debase);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		
		
		$criteria->order = 'subject0.subject_name ASC ';

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
		));
	}



}