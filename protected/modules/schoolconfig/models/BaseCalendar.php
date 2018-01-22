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
 * This is the model class for table "scalendar".
 *
 * The followings are the available columns in table 'scalendar':
 * @property integer $id
 * @property string $c_title
 * @property string $location
 * @property string $description
 * @property string $start_date
 * @property string $end_date
 * @property string $start_time
 * @property string $end_time
 * @property integer $is_all_day_event
 * @property string $color
 * @property integer $academic_year
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 */
class BaseCalendar extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCalendar the static model class
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
		return 'scalendar';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('c_title,start_date, end_date', 'required'),
			array('is_all_day_event, academic_year', 'numerical', 'integerOnly'=>true),
			array('c_title', 'length', 'max'=>255),
			array('location, color', 'length', 'max'=>200),
			array('description', 'length', 'max'=>1000),
			array('start_date, end_date, start_time, end_time', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, c_title, location, description, start_date, end_date, start_time, end_time, is_all_day_event, color, academic_year', 'safe', 'on'=>'search'),
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
			'academicYear' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_year'),
		);
	}
	/*
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'c_title' => Yii::t('app','Calendar title'),
			'location' => Yii::t('app','Location'),
			'description' => Yii::t('app','Description'),
			'start_date' => Yii::t('app','Date Start'),
			'end_date' => Yii::t('app','Date End'),
			'start_time' => Yii::t('app','Time Start'),
			'end_time' => Yii::t('app','Time End'),
			'is_all_day_event' => Yii::t('app','Is All Day Event'),
			'color' => Yii::t('app','Color'),
			'academic_year' =>  Yii::t('app','Academic Year'),
		);
	}

	
	
	
	
}