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



class Courses extends BaseCourses
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $subject_name;
	public $short_subject_name;
	public $subject_parent;
	public $subject_id;
	public $room;
	public $short_room_name;
	public $level;
	public $section;
	public $shift;
	public $course_name;
	public $teacher_name;
	public $teacher_id;
	public $last_name;
	public $first_name;
	public $room_name;
	public $name_period;
        public $teacher_fname;
        public $teacher_lname;
	public $nbr_subject;
	public $gender;
	public $profil;

    public $optional;	
	public $day_course;
	public $time_start;
	public $time_end;
	
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            //make date_created, date_updated unsafe
                            array('subject_name, teacher_lname,teacher_fname', 'length', 'max'=>125),
                            array('date_created, date_updated','unsafe'),
								array('id, subject_name, teacher_name, first_name, last_name, teacher, teacher_lname, teacher_fname, room_name, name_period, weight, debase, optional, old_new, reference_id, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
								array('subject+teacher+room+academic_period', 'application.extensions.uniqueMultiColumnValidator'),
                                  
									));
	}
	
	





	
	public function search($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with= array('room0','subject0','academicPeriod','teacher0');
				
		$criteria->condition=($condition.' old_new=1 AND (academicPeriod.year='.$acad.' OR academicPeriod.id='.$acad.') ');
		
		
		
		$criteria->compare('id',$this->id);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('teacher0.first_name',$this->teacher_fname,true);
		$criteria->compare('teacher0.last_name',$this->teacher_lname,true);
		$criteria->compare('room0.short_room_name',$this->room_name,true);
		
		$criteria->compare('concat(teacher0.first_name," ",teacher0.last_name)',$this->teacher_name,true);
		//$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('academicPeriod.name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('debase',$this->debase);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		
		
		$criteria->order = 'room0.short_room_name,subject0.subject_name ASC ';

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
		));
	}



	public function searchForSpecificTeacher($condition,$pers_id,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with= array('room0','subject0','academicPeriod','teacher0');
				
		$criteria->condition=($condition.' old_new=1 AND (academicPeriod.year='.$acad.' OR academicPeriod.id='.$acad.') AND teacher0.id='.$pers_id);
		
		
		$criteria->compare('id',$this->id);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('teacher0.first_name',$this->teacher_fname,true);
		$criteria->compare('teacher0.last_name',$this->teacher_lname,true);
		$criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('academicPeriod.name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('debase',$this->debase);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		
		
		$criteria->order = 'subject0.subject_name ASC ';

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> 100000,//Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
		));
	}
	
	
	
	
   public function searchCourseByRoomId($condition,$room_id,$acad)
	{   
          
		$criteria = new CDbCriteria;
	
		$criteria->alias = 'c';
		$criteria->distinct = 'true';
			
		$criteria->with= array('room0','subject0','academicPeriod','teacher0');
		$criteria->condition = $condition.' old_new=1 AND c.room ='.$room_id.' AND (c.academic_period='.$acad.' OR academicPeriod.year='.$acad.' )';
			
		
		
		$criteria->compare('c.id',$this->id);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('subject0.subject_parent',$this->subject_parent,true);
		$criteria->compare('teacher0.first_name',$this->teacher_fname,true);
		$criteria->compare('teacher0.last_name',$this->teacher_lname,true);
		$criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('academicPeriod.name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('debase',$this->debase);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
			
		
		$criteria->order = 'teacher0.last_name ASC, subject0.subject_name ASC ';


    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100000,//Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
		'criteria'=>$criteria,
				
    ));
	}  

	


	    
public function searchReport($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with= array('room0','subject0','academicPeriod','teacher0');
				
		$criteria->condition=($condition.' old_new=1 AND (academicPeriod.year='.$acad.' OR academicPeriod.id='.$acad.') ');
		
		
		$criteria->compare('id',$this->id);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('teacher0.first_name',$this->teacher_fname,true);
		$criteria->compare('teacher0.last_name',$this->teacher_lname,true);
		$criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('academicPeriod.name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('debase',$this->debase);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		
		
		$criteria->order = 'subject0.subject_name ASC ';

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> 100000,
    			),
				
		'criteria'=>$criteria,
		));
	}


//regrouper par matiere parente	
public function searchCourseByRoom($room_id,$level_id,$acad)  //IMA - CNR
	{   
          
	 	 
			$criteria = new CDbCriteria;
			
			$criteria->condition = 'old_new=1 AND optional=0 AND c.room =:idRoom AND r.level =:idLevel AND (c.academic_period=:acad OR a.year=:acad)';
			$criteria->params = array(':idRoom' => $room_id,':idLevel'=>$level_id,':acad'=>$acad);
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_parent, s.subject_name, s.short_subject_name, c.weight,c.debase, c.reference_id';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) ';
			$criteria->order = 's.subject_parent DESC, s.subject_name ASC';
			
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100000,
    			),
				
		'criteria'=>$criteria,
				
    ));
	}





public function searchCourseDeBase($acad)
	{   
          
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=1 AND optional=0 AND c.debase=1 AND (c.academic_period='.$acad.' OR a.year='.$acad.')';
			
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name, c.weight,c.debase,c.reference_id';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) ';
			
		
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100,
    			),
				
		'criteria'=>$criteria,
				
    ));
	
}
	

public function getPassingGradeForCourse($course)
	{   
                $command= Yii::app()->db->createCommand("SELECT minimum_passing FROM passing_grades WHERE course=".$course." AND level_or_course=1");
		
		$sql_result = $command->queryAll();
		if($sql_result!=null)
		  {
		  	 foreach($sql_result as $result)
		        return $result["minimum_passing"];
		          
		           
		  }
		else
		  {
		  	$command1= Yii::app()->db->createCommand("SELECT weight FROM courses WHERE id=".$course);
		        
		        $sql_result1 = $command1->queryAll();
		        if($sql_result1!=null)
		           {  
		           	  foreach($sql_result1 as $result)
		           	      return ($result["weight"] / 2);
		           	  
		           }
		        
		  	}
		  	
		  		
}
	
	
		public function searchCourseByIdCourse($id)	
		{   
                        $criteria = new CDbCriteria;
	
			$criteria->condition = 'c.id =:id';
			$criteria->params = array(':id' => $id);
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join persons p on (c.teacher = p.id) ';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name, c.weight,c.debase,c.optional,old_new,reference_id';
			
			
                    return new CActiveDataProvider($this, array(
       
                        'criteria'=>$criteria,
				
                    ));
                }
	
	
public function searchCourseByTeacherRoom($room_id,$id_teacher,$acad)
	{   
          
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=1 AND c.room ='.$room_id.' AND c.teacher='.$id_teacher.' AND (c.academic_period='.$acad.' OR a.year='.$acad.')';
			
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name, c.weight,c.debase,c.optional,old_new,reference_id';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) ';
			
		    
		    
			
                        return new CActiveDataProvider($this, array(
                            'pagination'=>array(
                                                    'pageSize'=> 100,
                                            ),

                                    'criteria'=>$criteria,

                        ));
	}
	
		
	
public function searchByRoomId($room_id,$acad)
	{  
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=1 AND c.room =:idRoom AND (c.academic_period=:acad OR a.year=:acad)';
			$criteria->params = array(':idRoom' => $room_id,':acad'=>$acad);
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name, c.weight,c.debase,c.optional,old_new, reference_id';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) ';
			
		    
		    			
                        return new CActiveDataProvider($this, array(
                            'pagination'=>array(
                                                    'pageSize'=> 100,
                                            ),

                                    'criteria'=>$criteria,

                        ));
	}
	
	

public function searchByRoomIdToValidateGrades($room_id,$evaluation,$acad)
	{   
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=1 AND optional=0 AND c.room =:idRoom AND g.evaluation=:eval AND (c.academic_period=:acad OR a.year=:acad) AND g.publish=0';
			$criteria->params = array(':idRoom' => $room_id,':eval'=>$evaluation,':acad'=>$acad);
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name, c.weight,c.debase,c.optional,old_new,reference_id';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) inner join grades g on(c.id=g.course)';
			
		    
		    			
                        return new CActiveDataProvider($this, array(
                            'pagination'=>array(
                                                    'pageSize'=> 100,
                                            ),

                                    'criteria'=>$criteria,

                        ));
	}

public function searchByRoomIdToValidateGradesSuper($room_id,$evaluation,$acad)
	{   //return subjects, take care if they have grade
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=1 AND optional=0 AND c.room =:idRoom AND g.evaluation=:eval AND (c.academic_period=:acad OR a.year=:acad) ';
			$criteria->params = array(':idRoom' => $room_id,':eval'=>$evaluation,':acad'=>$acad);
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name, c.weight,c.debase,c.optional,old_new,reference_id';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) inner join grades g on(c.id=g.course)';
			
		    
		    			
                    return new CActiveDataProvider($this, array(
                        'pagination'=>array(
                                                'pageSize'=> 100,
                                        ),

                                'criteria'=>$criteria,

                    ));
	}


public function searchByRoomIdInReport($room_id,$acad)
	{   //return subjects, take care if they have grade
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=1 AND c.room =:idRoom AND (c.academic_period=:acad OR a.year=:acad) ';
			$criteria->params = array(':idRoom' => $room_id,':acad'=>$acad);
            
            $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name, c.weight,c.debase, c.optional,old_new,reference_id';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) inner join grades g on(c.id=g.course)';
			
		    
		    			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100,
    			),
				
		'criteria'=>$criteria,
				
    ));
	}


public function searchByRoomIdEvenIfNoGrades($room_id,$acad)
	{   //return subjects, no worry if they have grade or not
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=1 AND c.optional=0 AND c.room =:idRoom AND (c.academic_period=:acad OR a.year=:acad) ';
			$criteria->params = array(':idRoom' => $room_id,':acad'=>$acad);
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name, c.weight,c.debase, c.optional,old_new,reference_id';
			$criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) ';
			
		    
		    			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100,
    			),
				
		'criteria'=>$criteria,
				
    ));
	}



	
public function evaluatedSubject($course_id,$room,$period_id)
	{   
                        $criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=1 AND c.optional=0 AND c.id=:course AND c.room=:room AND g.evaluation=:eval';
			$criteria->params = array(':course' => $course_id,':room'=>$room,':eval'=>$period_id);
            
                        $criteria->alias = 'c';
			
			$criteria->select = 'g.id';
			$criteria->join = 'inner join grades g on (c.id = g.course) ';
			
		    
		    
			
			
			
    return new CActiveDataProvider($this, array(
        
				
		'criteria'=>$criteria,
				
    ));
	}
	
	
public function evaluatedOldSubject($course_id,$room,$period_id)
	{   
                        $criteria = new CDbCriteria;
	
			$criteria->condition = 'old_new=0 AND c.optional=0 AND c.id=:course AND c.room=:room AND g.evaluation=:eval';
			$criteria->params = array(':course' => $course_id,':room'=>$room,':eval'=>$period_id);
            
                        $criteria->alias = 'c';
			
			$criteria->select = 'g.id';
			$criteria->join = 'inner join grades g on (c.id = g.course) ';
			
		    
		    
			
			
			
    return new CActiveDataProvider($this, array(
        
				
		'criteria'=>$criteria,
				
    ));
	}
	
	 

public function searchTeachersBySection($sec_id,$acad)
	{   
         
		 
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'l.section =:idSec AND c.old_new=1 AND (c.academic_period=:acad OR a.year=:acad)';
			$criteria->params = array(':idSec' => $sec_id,':acad'=>$acad);
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.teacher,p.gender';
			
			$criteria->join .= 'inner join rooms r on (r.id = c.room) inner join levels l on(l.id=r.level) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) ';
			
		 	
			
                return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                                            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                                    ),

                            'criteria'=>$criteria,

                ));
	}   	
	
	
public function searchNumberOfSubjectByRoom($sec_id,$acad)
    {   
         
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'l.section =:idSec AND c.old_new=1 AND (c.academic_period=:acad OR a.year=:acad)';
			$criteria->params = array(':idSec' => $sec_id,':acad'=>$acad);
            
                        $criteria->alias = 'c';
			
			$criteria->select = 'COUNT(c.subject) as nbr_subject, r.room_name';
			$criteria->join = 'inner join rooms r on (r.id = c.room) inner join levels l on(l.id=r.level) inner join academicperiods a ON(a.id=c.academic_period)';
			$criteria->group = 'room';
			
			
			
                return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                            'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                                    ),

                            'criteria'=>$criteria,

                ));
	}     
            
        
      public function getTeacherByIdCourse($courseId){
            
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'c.id =:idCourse ';
			$criteria->params = array(':idCourse' => $courseId, );
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.teacher,p.gender';
			$criteria->join = 'inner join rooms r on (r.id = c.room) inner join persons p on (c.teacher = p.id)';
			
		    
		    
			
                    return new CActiveDataProvider($this, array(

                                'criteria'=>$criteria,

                    ));
	}
	
	public function getRoomByIdCourse($courseId){
            
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'c.id =:idCourse';
			$criteria->params = array(':idCourse' => $courseId);
            
                        $criteria->alias = 'c';
			
			$criteria->select = 'c.room';
			$criteria->join = 'inner join rooms r on (r.id = c.room)';
			
		    
		    
			
                    return new CActiveDataProvider($this, array(

                                'criteria'=>$criteria,

                    ));
	}
	
	public function getWeight($courseId){
            
			$criteria = new CDbCriteria;
	
			$criteria->condition = 'c.id =:idCourse';
			$criteria->params = array(':idCourse' => $courseId);
            
                        $criteria->alias = 'c';
			
			$criteria->select = 'c.weight';
			
                        return new CActiveDataProvider($this, array(

                                    'criteria'=>$criteria,

                        ));
	}
	

//return an integer
public function getCourseWeight($courseId){
         
        $sql='SELECT weight FROM courses  WHERE id ='.$courseId;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           foreach($result as $r)
            return $r["weight"];

	}
	
		
       // Return course name 
	
	public function getCourseName(){
		
		return $this->subject0->subjectName.' - '.$this->room0->short_room_name.' ['.$this->teacher0->last_name.']';
	}
        
        public function getCourseNameForSchedule(){
		
		return $this->subject0->subjectName.' - '.$this->room0->short_room_name.' '.$this->teacher0->fullName;
	}
        
        
	
	public function getSimpleCourseName(){
		return $this->subject0->subjectName.', '.$this->teacher0->fullName.' - '.$this->academicPeriod->name_period;
	}   
            
      		 // return the name of courses in a specific the person 
   public function getCourses($idPerson,$idAcademicPeriod){
            
                $criteria = new CDbCriteria;
			
                $criteria->with= array('room0','subject0','academicPeriod','teacher0');
			 
		$criteria->condition = 'c.old_new=1 AND c.teacher=:idPers AND (c.academic_period=:academic OR academicPeriod.year=:academic)';
		$criteria->params = array(':idPers' => $idPerson,':academic'=>$idAcademicPeriod);
		    
		$criteria->alias = 'c';
			
		$criteria->compare('c.id',$this->id);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('teacher0.first_name',$this->teacher_fname,true);
		$criteria->compare('teacher0.last_name',$this->teacher_lname,true);
		$criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('academicPeriod.name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('debase',$this->debase);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		
		
		$criteria->order = 'room0.short_room_name,subject0.subject_name ASC ';
			
			
			
        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
	
	    }
	    
	
	 public function getCoursesForViewTeach($idPerson,$idAcademicPeriod){
            
                $criteria = new CDbCriteria;
			
                $criteria->with= array('room0','subject0','academicPeriod','teacher0');
			 
		$criteria->condition = 'c.old_new=1 AND c.teacher=:idPers AND (c.academic_period=:academic OR academicPeriod.year=:academic)';
		$criteria->params = array(':idPers' => $idPerson,':academic'=>$idAcademicPeriod);
		    
		$criteria->alias = 'c';
			
		$criteria->compare('c.id',$this->id);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('teacher0.first_name',$this->teacher_fname,true);
		$criteria->compare('teacher0.last_name',$this->teacher_lname,true);
		$criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('academicPeriod.name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('debase',$this->debase);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		
		
		$criteria->order = 'room0.short_room_name,subject0.subject_name ASC ';
			
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
                       'pageSize'=> 100000,
          ),
									
		'criteria'=>$criteria,
    ));
	
	    }
	    
	        
	    
	public function getAllCourses($idPerson){
            
                $criteria = new CDbCriteria;
			
		$criteria->with= array('room0','subject0','academicPeriod','teacher0');
			 
		$criteria->condition = 'old_new=1 AND c.teacher=:idPers ';
		$criteria->params = array(':idPers' => $idPerson);
		    
		$criteria->alias = 'c';
			
		$criteria->compare('c.id',$this->id);
		$criteria->compare('subject0.subject_name',$this->subject_name,true);
		$criteria->compare('subject_name',$this->subject_name,true);
		$criteria->compare('teacher0.first_name',$this->teacher_fname,true);
		$criteria->compare('teacher0.last_name',$this->teacher_lname,true);
		$criteria->compare('room0.room_name',$this->room_name,true);
		$criteria->compare('room_name',$this->room_name,true);
		$criteria->compare('academicPeriod.name_period',$this->name_period,true);
		$criteria->compare('weight',$this->weight);
		$criteria->compare('debase',$this->debase);
		$criteria->compare('optional',$this->optional);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('reference_id',$this->reference_id);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		
		
		
		$criteria->order = 'room0.short_room_name,subject0.subject_name ASC ';
			
			
                return new CActiveDataProvider($this, array(
                    'pagination'=>array(
                       'pageSize'=> 100000,
                     ),
									
		             'criteria'=>$criteria,
                ));
	
	    }  
		
		// return the subject name of a course with a specific idCourse 
		        public function getSubjectName($id){
            
                                        $criteria = new CDbCriteria;
			
                                        $criteria->condition = 'c.id=:idCourse ';
					$criteria->params = array(':idCourse' => $id);
		    
					$criteria->alias = 'c';
					$criteria->select = 's.subject_name,c.weight,c.debase,c.optional,c.old_new, c.reference_id, r.room_name,p.last_name,p.first_name,p.id as teacher_id ';
					$criteria->join = 'left join subjects s on(s.id = c.subject) ';
					$criteria->join .= 'left join rooms r on(r.id = c.room) ';
					$criteria->join .= 'left join persons p on(p.id = c.teacher) ';
					
		    
			
			
			
		    return new CActiveDataProvider($this, array(
		        'criteria'=>$criteria,
		    ));
	
			    }  
		
	
	
//return a boolean. true-false	
public function iscourseHasHoldTeacher($subject, $room, $acad)
	{   	    
         $siges_structure = infoGeneralConfig('siges_structure_session');
	     
	     $boul=false;
			
			if($siges_structure==1)
		    $sql='SELECT c.id FROM courses  c inner join academicperiods a ON(a.id=c.academic_period) WHERE c.old_new=0 AND c.room='.$room.' AND c.subject ='.$subject.' AND (c.academic_period='.$acad.' OR a.id='.$acad.')';
		elseif($siges_structure==0)
		    $sql='SELECT c.id FROM courses  c inner join academicperiods a ON(a.id=c.academic_period) WHERE c.old_new=0 AND c.room='.$room.' AND c.subject ='.$subject.' AND (c.academic_period='.$acad.' OR a.year='.$acad.')';


		   		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           if($result!=null)
             {   foreach($result as $r)
                   { $boul=true;
                       break;
                   }
             }
        
        return $boul;    
 }

		
		
 public function getTeacherByCourse($course_id){
            
                        $criteria = new CDbCriteria;
			
			$criteria->condition = 'c.id='.$course_id;
			$criteria->join = 'inner join persons p ON(p.id=c.teacher)';
			$criteria->alias = 'c';
			$criteria->select = 'p.id,p.first_name, p.last_name, p.gender,p.adresse,p.phone, p.email';
			
			
						
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
    ));
	
	    }
	    
	    
public function getShiftSectionLevelRoomSubject_nameSubject_idWeightTeacher_nameTeacherByCourse($course_id)
	{   
         	
                        $criteria = new CDbCriteria;
	
			$criteria->condition = 'c.id =:id';
			$criteria->params = array(':id' => $course_id);
                        $criteria->join = 'left join subjects s on (s.id = c.subject) left join rooms r on (r.id = c.room) inner join levels l on(l.id=r.level) inner join academicperiods a ON(a.id=c.academic_period) inner join persons p on (c.teacher = p.id) ';
            
                        $criteria->alias = 'c';
			$criteria->distinct = 'true';
			$criteria->select = 'c.id, CONCAT(p.last_name," ", p.first_name) as teacher_name, s.subject_name,s.id as subject_id, c.weight,c.debase,c.optional,c.old_new,c.reference_id,c.teacher, c.room, r.shift, l.section, r.level';
					    
			
    return new CActiveDataProvider($this, array(
       				
		'criteria'=>$criteria,
				
    ));
	}


//return id,teacher, room
public function getAllCourseInAcademicYear($acad){
            
			$criteria = new CDbCriteria;
			
			$criteria->select = 'id,teacher, room';
			$criteria->condition = 'old_new=1 AND academic_period='.$acad;
			
			
						
    return new CActiveDataProvider($this, array(
       	'criteria'=>$criteria,
    ));		
        }

		
			
public function  getDebase()
        {
            $bool = $this->debase; 
            $bool_label = null;
            if($bool==0)
                $bool_label = Yii::t('app','No');
            else
                $bool_label = Yii::t('app','Yes');
            return $bool_label;
            
        }	


public function  getOptional()
        {
            $bool = $this->optional; 
            $bool_label = null;
            if($bool==0)
                $bool_label = Yii::t('app','No');
            else
                $bool_label = Yii::t('app','Yes');
            return $bool_label;
            
        }	
 
public function ifCourseDeBase($course)
  {
		$command= Yii::app()->db->createCommand("SELECT room, teacher, weight, debase FROM courses WHERE id=".$course);
		
		$sql_result = $command->queryAll();
		
		  return $sql_result;
  }
       
	
	
		      
            
	
}
