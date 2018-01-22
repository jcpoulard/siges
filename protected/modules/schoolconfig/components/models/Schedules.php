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


// auto-loading



class Schedules extends BaseSchedules
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//public $day_course;
	public $course_name;
	
	
	//define constant to manage day on the system
	
	const M = 1;
	const T = 2;
	const W = 3;
	const Th = 4;
	const F = 5;
	const S = 6;
	const Su = 7;
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            //make date_created, date_updated unsafe 
                            array('time_start','timescompare'),
                            array('date_created,date_updated','unsafe'),
                            array('id, course_name, day_course,time_start, time_end date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
				                
									
									));
	}
	
public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('course0');

		$criteria->compare('id',$this->id);
		$criteria->compare('course0.subject',$this->course_name,true);
		$criteria->compare('day_course', $this->day_course, true); 
		
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		$criteria->order = 'course0.subject ASC';

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}    

 
 
public function searchForSpecificTeacher($id_teacher)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('course0');

		$criteria->condition = 'course0.teacher='.$id_teacher;
			
		$criteria->compare('id',$this->id);
		$criteria->compare('course0.subject',$this->course_name,true);
		$criteria->compare('day_course', $this->day_course, true); 
		
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		$criteria->order = 'day_course ASC, time_start ASC';

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}    
 
 
 
public function getTimesForSpecificTeacherForPayroll($id_teacher,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		

		$criteria->alias='s';
		
		$criteria->join='left join courses c on(c.id=s.course) left join room_has_person rh on(rh.room = c.room)';
			
		$criteria->condition = 'c.teacher='.$id_teacher.' AND rh.academic_year='.$acad;
		$criteria->distinct ='true';	
		$criteria->compare('id',$this->id);
		$criteria->compare('c.subject',$this->course_name,true);
		$criteria->compare('day_course', $this->day_course, true); 
		$criteria->compare('time_start',$this->time_start);
		$criteria->compare('time_end',$this->time_end);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> 100000000000000000000,
    			),
			'criteria'=>$criteria,
		));
	}    
 
 
 
        
        
        // Return a nice formatted string for schedule 
        
        public function getScheduleString(){
            
            return $this->course0->courseName.' '.$this->day.' ['.$this->time_start.' - '.$this->time_end.']';
        }
		
		
		public function getDays()
                {
                    return array(
                                        self::M => Yii::t('app','Monday'),
                                        self::T => Yii::t('app', 'Thuesday'),
                                        self::W => Yii::t('app', 'Wednesday'),
                                        self::Th => Yii::t('app', 'Thursday'),
                                        self::F =>Yii::t('app','Friday'), 
                                        self::S => Yii::t('app', 'Saturday'),
                                        self::Su => Yii::t('app', 'Sunday'),
                                );
            
            }
		
		public function getDay()
		{
			
			switch($this->day_course)
			{
				case 1:
					return Yii::t('app','Monday');
				
				case 2:
					return Yii::t('app','Thuesday');
					
				case 3:
					return Yii::t('app','Wednesday');	
					
				case 4:
					return Yii::t('app','Thursday');
					
				case 5:
					return Yii::t('app','Friday');
					
				case 6:
					return Yii::t('app','Saturday');
						
				case 7:
					return Yii::t('app','Sunday');
				
				default: 
					return Yii::t('app','Unknow');
				}
		}
		
		// Compare two times 
		    public function timescompare($attribute, $params){
		            $message = Yii::t('app','Time start must precede time end !');
		            if(strtotime($this->time_end)<  strtotime($this->time_start))
		            {
		                $params = array(
		                    '{attribute}'=>$this->time_end, '{compareValue}'=>$this->time_start
		                );
		                $this->addError('time_end', strtr($message, $params));
		            }
		        }

		   // getMessage
		       public function getMessage($field, $message, $params){
            
		                $this->addError($field, strtr($message, $params));
            
		        }

		public function searchCoursesAndTimes($id,$acad)
                                {      
					$criteria = new CDbCriteria;
			
					$criteria->condition = 'c.room=:Id AND (c.academic_period=:acad OR a.year=:acad)';
                                        $criteria->params = array(':Id'=>$id, ':acad'=>$acad);
					
					$criteria->alias ='s';
					$criteria->join='inner join courses c ON(c.id =s.course)';
                                        $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';
		  
                                        $criteria->select = 's.id, s.course, s.day_course, s.time_start, s.time_end';
					$criteria->order = 's.time_start ASC';
	        
                                return new CActiveDataProvider($this, array(
                                        'pagination'=>array(
                                                            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                                                    ), 
                                                    'criteria'=>$criteria,


                                ));
                                }
			
			
	public function searchTimesForSpecificDay($id, $day, $idAcad)
			{      
					$criteria = new CDbCriteria;
			
					$criteria->condition = 'c.room=:Id AND s.day_course=:day AND (c.academic_period=:idAcad OR a.year=:idAcad)';
                                        $criteria->params = array(':Id'=>$id, ':day'=>$day, ':idAcad'=>$idAcad);
					
					$criteria->alias ='s';
					
					$criteria->join='inner join courses c ON(c.id =s.course)';
                                        $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';
		  
                                        $criteria->select = 's.time_start, s.time_end';
					$criteria->order = 's.time_start ASC';
	        
		    		 
                                return new CActiveDataProvider($this, array(
                                        'pagination'=>array(
                                                            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                                                    ), 
                                                    'criteria'=>$criteria,


                                ));
		    }
	
public function getCoursesForTeacherByRoomAndDay($teacher, $day, $idAcad)	
		{      
                    $criteria = new CDbCriteria;

                    $criteria->condition = 'c.teacher=:teacher AND s.day_course=:day AND (c.academic_period=:idAcad OR a.year=:idAcad)';
                    $criteria->params = array(':teacher'=>$teacher,':day'=>$day, ':idAcad'=>$idAcad);

                    $criteria->alias ='s';

                    $criteria->join='inner join courses c ON(c.id =s.course)';
                    $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';

                    $criteria->select = '*';

			
		    return new CActiveDataProvider($this, array(
		             
					'criteria'=>$criteria,
		
		
		    ));
		 }


			
		public function searchTimes($id, $idAcad)
			{      
                        $criteria = new CDbCriteria;

                        $criteria->condition = 'c.room=:Id AND (c.academic_period=:idAcad OR a.year=:idAcad)';
                        $criteria->params = array(':Id'=>$id, ':idAcad'=>$idAcad);

                        $criteria->alias ='s';

                        $criteria->join='inner join courses c ON(c.id =s.course)';
                        $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';

                        $criteria->distinct =true;
                        $criteria->select = 's.time_start, s.time_end';
                        $criteria->order = 'CONCAT(s.time_start,s.time_end) ASC';
	        
				 
		    return new CActiveDataProvider($this, array(
		            'pagination'=>array(
		        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
		    			), 
					'criteria'=>$criteria,
		
		
		    ));
		    }
	
			public function checkSchedulesElement($course,$day,$idAcad)
			{      
                                    $criteria = new CDbCriteria;
			
                                    $criteria->condition = 's.course=:Id AND s.day_course=:day AND (c.academic_period=:academic OR a.year=:academic)';
				    $criteria->params = array(':Id'=>$course,':day'=>$day,':academic'=>$idAcad);
					
                                    $criteria->alias ='s';
					
                                    $criteria->join='inner join courses c ON(c.id =s.course)';
                                    $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';
		  
                                    $criteria->select = 's.id, s.time_start, s.time_end';
                                    $criteria->order = 's.time_start ASC';
	        
					
		    return new CActiveDataProvider($this, array(
           
					'criteria'=>$criteria,
		
		
		    ));
		    }
			
			public function checkSchedulesTime($day,$idAcad)
			{      
					$criteria = new CDbCriteria;
					
					$criteria->condition = 's.day_course=:day AND (c.academic_period=:academic OR a.year=:academic)';
				    $criteria->params = array(':day'=>$day,':academic'=>$idAcad);
					
					$criteria->alias ='s';
					
					$criteria->join='inner join courses c ON(c.id =s.course)';
                    $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';
		  
		  			$criteria->select = 's.id, s.time_start, s.time_end';
					 $criteria->order = 's.time_start ASC';
	        
					
		    
		    		 
		    return new CActiveDataProvider($this, array(
           
					'criteria'=>$criteria,
		
		
		    ));
		    }
                    
  public function searchForOneTeacher($id,$acad)
{


        $criteria=new CDbCriteria;
        $criteria->alias='sc';
        $criteria->with=array('course0');
        
        $criteria->condition='course0.teacher=:idTeacher AND (course0.academic_period=:acad OR a.year=:acad)';
        $criteria->params=array(':idTeacher'=>$id, ':acad'=>$acad);

        $criteria->join='inner join courses c ON(c.id =sc.course)';
        $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';
		

        $criteria->compare('id',$this->id);
        $criteria->compare('course0.subject',$this->course_name,true);
        $criteria->compare('day_course', $this->day_course, true); 
        
        $criteria->compare('date_created',$this->date_created,true);
        $criteria->compare('date_updated',$this->date_updated,true);
        $criteria->compare('create_by',$this->create_by,true);
        $criteria->compare('update_by',$this->update_by,true);

                $criteria->order = 'day_course ASC, time_start ASC';

        return new CActiveDataProvider($this, array(
            'pagination'=>array(
            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
            ),
            'criteria'=>$criteria,
        ));
}

// Return the name of a month in short format 
public function getMonth($mois){
    switch ($mois){
        case 1:
            return Yii::t('app','Jan');
            break;
        case 2:
            return Yii::t('app','Feb');
            break;
        case 3:
            return Yii::t('app','Mar');
            break;
        case 4:
            return Yii::t('app','Apr');
            break;
        case 5:
            return Yii::t('app','May');
            break;
        case 6:
            return Yii::t('app','Jun');
            break;
        case 7:
            return Yii::t('app','Jul');
            break;
        case 8:
            return Yii::t('app','Aug');
            break;
        case 9:
            return Yii::t('app','Sep');
            break;
        case 10:
            return Yii::t('app','Oct');
            break;
        case 11:
            return Yii::t('app','Nov');
            break;
        case 12:
            return Yii::t('app','Dec');
            break;
    }
   }

// Return the key=>value  of a month in long format 
public function getLongMonthValue(){
    
        return array(
        1=>Yii::t('app','January'),
        2=>Yii::t('app','February'),
        3=>Yii::t('app','March'),
        4=>Yii::t('app','April'),
        5=>Yii::t('app','May'),
        6=>Yii::t('app','June'),
        7=>Yii::t('app','July'),
        8=>Yii::t('app','August'),
        9=>Yii::t('app','September'),
        10=>Yii::t('app','October'),
        11=>Yii::t('app','November'),
        12=>Yii::t('app','December'),
        ); 
            
    }
   

// Return the name of a month in long format 
public function getLongMonth($mois){
    switch ($mois){
        case 1:
            return Yii::t('app','January');
            break;
        case 2:
            return Yii::t('app','February');
            break;
        case 3:
            return Yii::t('app','March');
            break;
        case 4:
            return Yii::t('app','April');
            break;
        case 5:
            return Yii::t('app','May');
            break;
        case 6:
            return Yii::t('app','June');
            break;
        case 7:
            return Yii::t('app','July');
            break;
        case 8:
            return Yii::t('app','August');
            break;
        case 9:
            return Yii::t('app','September');
            break;
        case 10:
            return Yii::t('app','October');
            break;
        case 11:
            return Yii::t('app','November');
            break;
        case 12:
            return Yii::t('app','December');
            break;
    }
   }
                  
		
	
}
