<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is  a free software: you can redistribute it and/or modify
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
 * This is the model class for table "grades".
 *
 * The followings are the available columns in table 'grades':
 * @property integer $id
 * @property integer $student
 * @property integer $course
 * @property integer $evaluation
 * @property double $grade_value
 * @property string $comment
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Persons $student0
 * @property Courses $course0
 * @property EvaluationByYear $evaluation0
 */
class BaseGrades extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseGrades the static model class
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
		return 'grades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, course, evaluation', 'required'),
			array('student, course, evaluation', 'numerical', 'integerOnly'=>true),
			array('grade_value', 'numerical'),
			array('create_by, update_by', 'length', 'max'=>45),
			array('comment', 'length', 'max'=>225),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student, course, evaluation, grade_value, comment, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'course0' => array(self::BELONGS_TO, 'Courses', 'course'),
                        'evaluation0' => array(self::BELONGS_TO, 'EvaluationByYear', 'evaluation'),
                       
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app','ID'),
			'student' =>Yii::t('app', 'Student'),
			'course' =>Yii::t('app', 'Course'),
			'course_name' =>Yii::t('app', 'Course name'),
			'evaluation' =>Yii::t('app', 'Evaluation'),
			'grade_value' =>Yii::t('app', 'Grade Value'),
			'comment' =>Yii::t('app', 'Comment'),
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
		$criteria->with= array('student0','course0','evaluation0',);
		$student_name=$this->first_name.' '.$this->last_name;

		$criteria->condition = $condition.' course0.academic_period=:acad';
		$criteria->params = array(':acad'=>$acad);
			
		$criteria->compare('id',$this->id);
		$criteria->compare('student0.first_name',$this->student_name,true);
		$criteria->compare('course0.subject',$this->course_name,true);
		$criteria->compare('evaluation0.evaluation_date',$this->evaluation_date,true);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('student0.last_name',$this->s_full_name, true);
                $criteria->compare('course0.weight',$this->weight,true);
               
			   $criteria->order = 'first_name ASC';

		return new CActiveDataProvider($this, array(
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
			'criteria'=>$criteria,
			
		));
	}
   
	

	
	
}