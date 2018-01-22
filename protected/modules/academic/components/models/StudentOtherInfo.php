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
 
 */
class StudentOtherInfo extends BaseStudentOtherInfo
{
	/**
	 
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


        public $person_lname; 
        public $person_fname;
        
        
        
		/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                       
			array('student', 'numerical', 'integerOnly'=>true),
			array('previous_school, health_state', 'length', 'max'=>255),
			array('previous_level, apply_for_level, create_by, update_by', 'length', 'max'=>45),
			array('father_full_name, mother_full_name, person_liable', 'length', 'max'=>100),
			array('person_liable_phone', 'length', 'max'=>65),
			array('school_date_entry, date_created, date_updated', 'safe'),
                 
                 array('id, student,health_state,mother_full_name,person_liable,person_liable_phone, school_date_entry, leaving_date, previous_school, previous_level, apply_for_level, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
   				 

                      
									
		));
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'student' => Yii::t('app','Student'),
			'school_date_entry' => Yii::t('app','School Date Entry'),
			'leaving_date' => Yii::t('app','Leaving Date'),
			'previous_school' => Yii::t('app','Previous School'),
			'person_fname'=>Yii::t('app','First Name'),
                    'person_lname'=>Yii::t('app','Last Name'),
                    'fullName'=>Yii::t('app','Full name'),
			'previous_level' => Yii::t('app','Previous Level'),
			'apply_for_level'=> Yii::t('app','Apply for level'),
			'health_state'=> Yii::t('app','Health state'),
			'father_full_name'=> Yii::t('app','Father full name'),
			'mother_full_name'=> Yii::t('app','Mother full name'),
			'person_liable'=> Yii::t('app','Person liable'),
			'person_liable_phone'=> Yii::t('app','Person liable phone'),
			'date_created' => Yii::t('app','Date Created'),
			'date_updated' => Yii::t('app','Date Update'),
			'create_by' => Yii::t('app','Create By'),
			'update_by' => Yii::t('app','Update By'),
		);
	}

	
	
	
	public function searchForOneStudent($studentID)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0');
		$criteria->condition='student=:Id';
		$criteria->params=array(':Id'=>$studentID);

		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('school_date_entry',$this->school_date_entry,true);
		$criteria->compare('leaving_date',$this->leaving_date,true);
		$criteria->compare('previous_school',$this->previous_school,true);
		$criteria->compare('previous_level',$this->previous_level,true);
		$criteria->compare('apply_for_level',$this->apply_for_level,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('student0.last_name',$this->person_lname, true);
		$criteria->compare('student0.first_name',$this->person_fname, true); 
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}



                               
   public function getPreviousLevel($previous_level)
			{
			
				
		$level = new Levels;
               
                        $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$previous_level),
                               ));
			
                
						   

			if(isset($result))		   
				return $result->level_name;
		    else
		        return null;
               
                
			}
			
			
		 public function getSchoolDateEntry(){
            $time = strtotime($this->school_date_entry);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }
        
        public function getLeavingDate(){
            $time = strtotime($this->leaving_date);
            
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
          	return $day.'/'.$month.'/'.$year;    
           
        }
		


	
	
}