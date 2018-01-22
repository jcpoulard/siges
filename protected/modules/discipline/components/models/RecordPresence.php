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


// auto-loading



class RecordPresence extends BaseRecordPresence
{
    
    public $room_attendance;
    public $student_last_name;
    public $room_name;
    public $academic_period;
    
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	//public $arroondissement_name;
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            array('student_last_name, room_name', 'length', 'max'=>125),
                            array('comments', 'length', 'max'=>255),
									));
	}
	
        
// 0: present - 1: absent non-motive - 2: absent motive - 3:Retard non-motive
 // - 4: Retard

 public function getPresenceStatus()
         {
     return array(
         0=>Yii::t('app','Present'),
         1=>Yii::t('app','Absent No Excuse'),
         2=>Yii::t('app','Absent With Excuse'),
         3=>Yii::t('app','Tardy No Excuse'),
         4=>Yii::t('app','Tardy With Excuse'),
     );
 } 
 
 public function getPresence()
	{
                        switch($this->presence_type)
                        {
                                case 0:
                                    return Yii::t('app','Present');
                                    break;
                                case 1:
                                     return Yii::t('app','Absent No Excuse');
                                     break;
                                case 2:
                                    return Yii::t('app','Absent With Excuse');
                                    break;
                                case 3:
                                    return Yii::t('app','Tardy No Excuse');
                                    break;
                                case 4:
                                    return Yii::t('app','Tardy With Excuse');
                                    break;

                                }
        }
        
        public function getPresenceAbreviate($code)
	{
                        switch($code)
                        {
                                case 0:
                                    return Yii::t('app','P');
                                    break;
                                case 1:
                                     return Yii::t('app','ANE');
                                     break;
                                case 2:
                                    return Yii::t('app','AWE');
                                    break;
                                case 3:
                                    return Yii::t('app','TNE');
                                    break;
                                case 4:
                                    return Yii::t('app','TWE');
                                    break;

                                }
        }
        
        public function getPresenceFull($code)
	{
                        switch($code)
                        {
                                case 0:
                                    return Yii::t('app','Present');
                                    break;
                                case 1:
                                     return Yii::t('app','Absent No Excuse');
                                     break;
                                case 2:
                                    return Yii::t('app','Absent With Excuse');
                                    break;
                                case 3:
                                    return Yii::t('app','Tardy No Excuse');
                                    break;
                                case 4:
                                    return Yii::t('app','Tardy With Excuse');
                                    break;

                                }
        }

        
        public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('student0','room0');
                $criteria->condition=('academic_period ='.$acad.'');
		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('date_record',$this->date_record,true);
                $criteria->compare('student0.last_name',$this->student_last_name,true);
                $criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('presence_type',$this->presence_type);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                    'pagination'=>array(
                            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
        
        /**
         * 
         * @param type $acad
         * @param type $student
         * @return \CActiveDataProvider
         */
         public function searchStudent($acad, $stud)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('student0','room0');
                $criteria->condition=('academic_period ='.$acad.' AND student = '.$stud.'');
		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('date_record',$this->date_record,true);
                $criteria->compare('student0.last_name',$this->student_last_name,true);
                $criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('presence_type',$this->presence_type);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

                $criteria->order = 't.date_record DESC ';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                    'pagination'=>array(
                           'pageSize'=> 10000,
                        ),
		));
	}
        
        /**
         * 
         * @param date $date
         * @return int
         */
        public function getMonthAttendance($date){
            $time = strtotime($date);
                         $month=date("n",$time);
                         
            return $month;
        }
        
        /**
         * 
         * Return the number of time during a month a student is absent 
         * @param int $month
         * @param int $student
         * @param int $aca_year
         * @return int
         */
        
        public function getTotalAbsenceByMonth($month, $student, $aca_year){
            $model = new RecordPresence;
            $stud_ = $model->findAll(array('select'=>'presence_type, date_record',
                                      'condition'=>'student=:std AND academic_period=:acad',
                                      'params'=>array(':std'=>$student,':acad'=>$aca_year),
               ));
            
         //   $stud_ = $this->findAll();
           
            $absence_number = 0;
            foreach($stud_ as $sp){
                
                if($this->getMonthAttendance($sp->date_record) == $month){
                  
                  if($sp->presence_type == 1 || $sp->presence_type == 2){
                      
                      $absence_number++;
                  }  
                }
            }
            return $absence_number;
        }
        
        /**
         * Return the number of time during a month a student is tardy 
         * @param type $month
         * @param type $student
         * @param type $aca_year
         * @return int
         */
        public function getTotalRetardByMonth($month, $student, $aca_year){
            $model = new RecordPresence;
            $stud_ = $model->findAll(array('select'=>'presence_type, date_record',
                                      'condition'=>'student=:std AND academic_period=:acad',
                                      'params'=>array(':std'=>$student,':acad'=>$aca_year),
               ));
           // $stud_ = $this->findAll();
           
            $retard_number = 0;
            foreach($stud_ as $sp){
                
                if($this->getMonthAttendance($sp->date_record) == $month){
                  
                  if($sp->presence_type == 3 || $sp->presence_type == 4){
                      
                      $retard_number++;
                  }  
                }
            }
            return $retard_number;
        }
        /**
         * Return information about period exam (academic period) who's not academic_year 
         * @param date $currentDate
         * @return Data Provider 
         */
        public function searchCurrentExamPeriod($currentDate)
		{      	$acad = new AcademicPeriods;
	        $result=$acad->find(array('select'=>'id,name_period',
	                                     'condition'=>'is_year=0 AND date_start<=:current AND date_end>=:current',
	                                    'params'=>array(':current'=>$currentDate),
	                               ));
		
					return $result;
	    }
		
		
        public function searchRoomWithStudent($acad)
		{      	$room = new RoomHasPerson;
	        $result=$room->find(array('select'=>'room,students, academic_year',
	                                     'condition'=>'academic_year=:acad',
	                                    'params'=>array(':acad'=>$acad),
	                               ));
		
					return $result;
	    }
		
        
		
            
            /**
             * Return the total tardy(late) by exam period 
             * @param type $exam_perio period academic 
             * @param type $student
             * @param type $aca_year
             * @return int
             */
       public function getTotalRetardByExam($exam_period, $student, $aca_year){
           $model = new RecordPresence;
           $stud_ = $model->findAll(array('select'=>'presence_type',
                                      'condition'=>'exam_period=:examPeriod AND student=:std AND academic_period=:acad',
                                      'params'=>array(':examPeriod'=>$exam_period,':std'=>$student,':acad'=>$aca_year),
               ));
           // $stud_ = $this->findAll();
           
            $retard_number = 0;
            foreach($stud_ as $sp){
                    
               // if(($sp->student == $student)  && ($sp->academic_period == $aca_year) && ($sp->exam_period == $exam_period)){
                  
                  if(($sp->presence_type == 3) || ($sp->presence_type == 4)){
                      $retard_number++;
                  }  
              //  }
            }
            return $retard_number;
        } 
        
        /**
         * Return the total tardy(late) by exam period
         * @param type $exam_period period academic 
         * @param type $student
         * @param type $aca_year
         * @return int
         */
        
        /**
         * 
         * $idTit = $modelPH->find(array('select'=>'titles_id',
                                     'condition'=>'persons_id=:empID AND academic_year=:acad',
                                     'params'=>array(':empID'=>$emp,':acad'=>$acad),
                               ));
         */
        
        public function getTotalPresenceByExam($exam_period, $student, $aca_year){
           $model = new RecordPresence;
           $stud_ = $model->findAll(array('select'=>'presence_type',
                                      'condition'=>'exam_period=:examPeriod AND student=:std AND academic_period=:acad',
                                      'params'=>array(':examPeriod'=>$exam_period,':std'=>$student,':acad'=>$aca_year),
               ));
            $retard_number = 0;
            foreach($stud_ as $sp){
                
             //   if(($sp->student == $student)  && ($sp->academic_period == $aca_year) && ($sp->exam_period == $exam_period)){
                  
                  if(($sp->presence_type == 1) || ($sp->presence_type == 2)){
                      $retard_number++;
                  }  
                }
            //}
            return $retard_number;
        } 
        
        public function getDateRecord(){
            $time = strtotime($this->date_record);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }  

	
}
