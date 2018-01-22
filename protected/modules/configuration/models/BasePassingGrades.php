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
 * This is the model class for table "passing_grades".
 *
 * The followings are the available columns in table 'passing_grades':
 * @property integer $id
 * @property integer $level
 * @property integer $course
 * @property integer $academic_period
 * @property double $minimum_passing
 * @property integer $level_or_course
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Levels $level0
 * @property Academicperiods $academicPeriod
 */
class BasePassingGrades extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BasePassingGrades the static model class
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
		return 'passing_grades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('academic_period, minimum_passing', 'required'),
			array('level, course, academic_period,level_or_course', 'numerical', 'integerOnly'=>true),
			array('minimum_passing', 'numerical'),
			array('create_by, update_by', 'length', 'max'=>20),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, level, academic_period, level_or_course, course, minimum_passing, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'level0' => array(self::BELONGS_TO, 'Levels', 'level'),
			'course0' => array(self::BELONGS_TO, 'Courses', 'course'),
			'academicPeriod' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_period'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app','ID'),
			'level' =>Yii::t('app', 'Level'),
			'course' =>Yii::t('app', 'Course'),
			'academic_period' =>Yii::t('app', 'Academic Period'),
			'minimum_passing' =>Yii::t('app', 'Minimum Passing'),
			'level_or_course' =>Yii::t('app', 'Level/Course'),
			'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' => Yii::t('app','Date Updated'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
		);
	}

	
	
	
	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('level0','academicPeriod');
		
		$criteria->condition='academic_period=:acad';
		
		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('course',$this->course);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('minimum_passing',$this->minimum_passing);
		$criteria->compare('level_or_course',$this->level_or_course);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('level0.level_name',$this->level_lname, true);
		$criteria->compare('academicPeriod.name_period',$this->academic_lname, true);
		
		$criteria->params=array(':acad'=>$acad);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
	

	
	
	
	
	
	
}