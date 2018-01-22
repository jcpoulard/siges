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
 * This is the model class for table "homework".
 *
 * The followings are the available columns in table 'homework':
 * @property integer $id
 * @property integer $person_id
 * @property integer $course
 * @property string $title
 * @property string $description
 * @property string $limit_date_submission
 * @property string $given_date
 * @property string $attachment_ref
 * @property integer $academic_year
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 * @property Courses $course0
 * @property Persons $person
 * @property Persons[] $persons
 */
class BaseHomework extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseHomework the static model class
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
		return 'homework';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('course, title, limit_date_submission', 'required'),
			array('person_id, course, academic_year', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>45),
			array('description', 'length', 'max'=>255),
			array('attachment_ref', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, person_id, course, title, description, limit_date_submission, given_date, attachment_ref, academic_year', 'safe', 'on'=>'search'),
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
			'course0' => array(self::BELONGS_TO, 'Courses', 'course'),
			'person' => array(self::BELONGS_TO, 'Persons', 'person_id'),
			'persons' => array(self::MANY_MANY, 'Persons', 'homework_submission(homework_id, student)'),
		     
                    );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'person_id' => Yii::t('app','Teacher'),
			'course' => Yii::t('app','Subject'),
			'title' => Yii::t('app','Homework Title'),
			'description' => Yii::t('app','Description'),
			'limit_date_submission' => Yii::t('app','Submission deadline'),
			'given_date' => Yii::t('app','Given Date'),
			'attachment_ref' => Yii::t('app','Document(s)'),
			'academic_year' => Yii::t('app','Academic Year'),
		);
	}

	
	
}


