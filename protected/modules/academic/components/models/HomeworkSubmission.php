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
class HomeworkSubmission extends BaseHomeworkSubmission
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

	
        public $document;
	public $keepDoc;
	public $person_fname;
	public $person_lname;
	public $name_period;
	public $person_code;
	
	
	
	
  public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                        'keepDoc'=>Yii::t('app','Keep Document(s)'),
                        'student' => Yii::t('app','Student'),
						'homework_id' => Yii::t('app','Homework'),
						'date_submission' => Yii::t('app','Submission Date'),
						'comment' => Yii::t('app','Comment'),
						'attachment_ref' => Yii::t('app','Attachment Ref.'),
						'grade_value'=> Yii::t('app','Grade'),
						
                      
                      )
                    );
           
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	
	
	
	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('student0','homework');
               
               $criteria->condition = 'homework.academic_year=:acad';
		$criteria->params = array(':acad'=>$acad);
		

		$criteria->compare('student',$this->student);
		$criteria->compare('grade_value',$this->grade_value);
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
	
		
public function searchSubmitedHomework($course,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('student0','homework');
               
               $criteria->condition = 'homework.course='.$course.' AND homework.academic_year='.$acad;
		

		$criteria->compare('student',$this->student);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('homework_id',$this->homework_id);
		$criteria->compare('date_submission',$this->date_submission,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('attachment_ref',$this->attachment_ref,true);
		
		 $criteria->compare('student0.id_number',$this->person_code, true);
		 $criteria->compare('student0.last_name',$this->person_lname, true);
                $criteria->compare('student0.first_name', $this->person_fname,true);
                
          $criteria->order='date_submission DESC';       
                
   		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

          'criteria'=>$criteria,
		));
	}

	
		
public function searchSubmitedHomeworkByStudentId($stud,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with = array('student0','homework');
               
               $criteria->condition = 'student='.$stud.' AND homework.academic_year='.$acad;
		

		$criteria->compare('student',$this->student);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('homework_id',$this->homework_id);
		$criteria->compare('date_submission',$this->date_submission,true);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('attachment_ref',$this->attachment_ref,true);
		
		 $criteria->compare('student0.last_name',$this->person_lname, true);
                $criteria->compare('student0.first_name', $this->person_fname,true);
                
          $criteria->order='date_submission DESC';       
                
   		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

          'criteria'=>$criteria,
		));
	}

	 public function getDateSubmission(){
            $time = strtotime($this->date_submission);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }
        

	
	
	
	
}