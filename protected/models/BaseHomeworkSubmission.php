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

?>
<?php

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
			array('comment', 'length', 'max'=>255),
			array('attachment_ref', 'length', 'max'=>100),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student, homework_id, date_submission, comment, attachment_ref', 'safe', 'on'=>'search'),
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

		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
/*	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('homework_id',$this->homework_id);
		$criteria->compare('date_submission',$this->date_submission,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('attachment_ref',$this->attachment_ref,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
	
		public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('student0','homework');
               
               $criteria->condition = 'homework.academic_year=:acad';
		$criteria->params = array(':acad'=>$acad);
		

		$criteria->compare('student',$this->student);
		$criteria->compare('homework_id',$this->homework_id);
		$criteria->compare('date_submission',$this->date_submission,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('attachment_ref',$this->attachment_ref,true);
		
		$criteria->compare('homework.academic_year.name_period',$this->name_period);
		 $criteria->compare('student0.last_name',$this->person_lname, true);
                $criteria->compare('student0.first_name', $this->person_fname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),


		));
	}
	
	*/

}