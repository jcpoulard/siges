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





class Homework extends BaseHomework
{
	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	public $person_lname; 
	public $person_fname;
	public $name_period;
	public $course_name;
	public $document;
	public $keepDoc;
	
	
	public function rules()
	{
		return array_merge(
		    	parent::rules(), array(
		
		         array('id, person_id, person_lname, person_fname, name_period, course, title, description, limit_date_submission, given_date, attachment_ref, academic_year', 'safe', 'on'=>'search'),
		         							
						));
									
	}


		
   public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                      'keepDoc'=>Yii::t('app','Keep Document(s)'),
                      
                      )
                    );
           
	}
	
	

	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		 $criteria->with = array('person','persons', 'academicYear', 'course0');
               
               $criteria->condition = 'academic_year=:acad';
		$criteria->params = array(':acad'=>$acad);

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('course',$this->course);
		$criteria->compare('course0.subject',$this->course_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('limit_date_submission',$this->limit_date_submission,true);
		$criteria->compare('given_date',$this->given_date,true);
		$criteria->compare('attachment_ref',$this->attachment_ref,true);
		$criteria->compare('academic_year',$this->academic_year);
		
		$criteria->compare('academicYear.name_period',$this->name_period);
		 $criteria->compare('person.last_name',$this->person_lname, true);
                $criteria->compare('person.first_name', $this->person_fname,true);
                
          $criteria->order='given_date DESC';       
                
   		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

          'criteria'=>$criteria,
		));
	}
	
	
	public function searchForTeacher($id_teacher,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		 $criteria->with = array('person','persons', 'academicYear', 'course0');
               
               $criteria->condition = 'course0.teacher='.$id_teacher.' AND academic_year='.$acad;
		

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('course',$this->course);
		$criteria->compare('course0.subject',$this->course_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('limit_date_submission',$this->limit_date_submission,true);
		$criteria->compare('given_date',$this->given_date,true);
		$criteria->compare('attachment_ref',$this->attachment_ref,true);
		$criteria->compare('academic_year',$this->academic_year);
		
		$criteria->compare('academicYear.name_period',$this->name_period);
		 $criteria->compare('person.last_name',$this->person_lname, true);
                $criteria->compare('person.first_name', $this->person_fname,true);
                
          $criteria->order='given_date DESC';       
                
   		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

          'criteria'=>$criteria,
		));
	}
	
		

public function searchHomeworkByRoomId($room_id,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		 $criteria->with = array('person','persons', 'academicYear', 'course0');
               
               $criteria->condition = 'course0.room='.$room_id.' AND academic_year='.$acad;
		

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('course',$this->course);
		$criteria->compare('course0.subject',$this->course_name,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('limit_date_submission',$this->limit_date_submission,true);
		$criteria->compare('given_date',$this->given_date,true);
		$criteria->compare('attachment_ref',$this->attachment_ref,true);
		$criteria->compare('academic_year',$this->academic_year);
		
		$criteria->compare('academicYear.name_period',$this->name_period);
		 $criteria->compare('person.last_name',$this->person_lname, true);
                $criteria->compare('person.first_name', $this->person_fname,true);
                
          $criteria->order='given_date DESC';       
                
   		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

          'criteria'=>$criteria,
		));
	}
	
	
	  public function getGivenDate(){
            $time = strtotime($this->given_date);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }
        
  public function getLimitDateSubmission(){
            $time = strtotime($this->limit_date_submission);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }
        

	
}