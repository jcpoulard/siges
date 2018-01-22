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
 * This is the model class for table "homework_submission".
 *
 * The followings are the available columns in table 'homework_submission':
 * @property integer $id
 * @property integer $student
 * @property integer $homework_id
 * @property string $date_submission
 * @property string $comment
 * @property string $attachment_ref
 *
 * The followings are the available model relations:
 * @property Homework $homework
 * @property Persons $student0
 */
class BaseHomeworkSubmission extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseHomeworkSubmission the static model class
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
		return 'homework_submission';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, homework_id, date_submission, comment, attachment_ref', 'required'),
			array('student, homework_id', 'numerical', 'integerOnly'=>true),
			array('grade_value', 'numerical'),
			array('comment', 'length', 'max'=>255),
			array('attachment_ref', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student, homework_id, grade_value, date_submission, comment, attachment_ref', 'safe', 'on'=>'search'),
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
			'homework' => array(self::BELONGS_TO, 'Homework', 'homework_id'),
			'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			
			'student' => 'Student',
			'homework_id' => 'Homework',
			'date_submission' => 'Date Submission',
			'comment' => 'Comment',
			'attachment_ref' => 'Attachment Ref',
			'grade_value'=>'Grade',

		);
	}

	

}