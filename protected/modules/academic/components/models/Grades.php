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


class Grades extends BaseGrades
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}  
  
	public $student_iD;
	
	public $last_name;
	public $first_name;
	public $student_name;
	public $gender;
        //Field for search
        public $s_full_name;
        public $s_subject_name;
        public $weight;
		
        public $max_grade;
        public $name_period;
        public $sum;
        public $average;
        public $general_average;
        public $place;
        
    
	
	public $course_name;
	public $courseName;
        public $evaluation_date;
	public $subject_name;
	public $room_name;
	

	//Pou dachbod la 
	public $idantite_peryod;
        

  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
                            // Make date_created, date_updated unsafe 
                            array('validate,publish', 'numerical', 'integerOnly'=>true),
                            array('grade_value','gradecompare','message'=>'Grade value can\'t be greater than weight!'),
                            array('student+course+evaluation','application.extensions.uniqueMultiColumnValidator'),
                            array('course_name, courseName', 'length', 'max'=>125),
                            array('date_created, date_updated','unsafe'),
                            array('id, first_name, last_name, s_full_name,s_subject_name, student_name, course_name, courseName,validate,publish, evaluation_date, grade_value, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
				                   // array('',''),
									
									));
	}
	
       public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array('validate'=>Yii::t('app','Validate'),
                    'publish'=>Yii::t('app','Publish'),
                    
                        )
                    );
           
	}


public function search($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
$siges_structure = infoGeneralConfig('siges_structure_session');

		$criteria=new CDbCriteria;
		$criteria->alias='g';
		$criteria->with= array('student0','course0','evaluation0',);
		$student_name=$this->first_name.' '.$this->last_name;
        
                $criteria->join='inner join courses c ON(c.id =g.course) inner join subjects s ON(s.id=c.subject)';
                $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';

		
		if($siges_structure==1)
		    $criteria->condition = $condition.' (course0.academic_period=:acad  OR a.id=:acad)';
		elseif($siges_structure==0)
		   $criteria->condition = $condition.' (course0.academic_period=:acad  OR a.year=:acad)';


		
		$criteria->params = array(':acad'=>$acad);
			
		$criteria->compare('id',$this->id);
		$criteria->compare('student0.first_name',$this->first_name,true);
		$criteria->compare('course0.subject',$this->course,true);
		$criteria->compare('subject_name',$this->course_name,true);
		$criteria->compare('evaluation0.evaluation_date',$this->evaluation_date,true);
		$criteria->compare('grade_value',$this->grade_value);
                $criteria->compare('comment',$this->comment);
		
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                
                $criteria->compare('student0.last_name',$this->last_name, true);
                $criteria->compare('course0.weight',$this->weight,true);
               
                $criteria->order = 'last_name ASC, evaluation0.evaluation_date DESC';

		return new CActiveDataProvider($this, array(
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
			'criteria'=>$criteria,
			
		));
	}
   
   
	
public function searchForTeacherUser($condition,$id_teacher,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 $siges_structure = infoGeneralConfig('siges_structure_session');
 
		$criteria=new CDbCriteria;
		$criteria->alias='g';
		$criteria->with= array('student0','course0','evaluation0',);
		$student_name=$this->first_name.' '.$this->last_name;
        
                $criteria->join='inner join courses c ON(c.id =g.course) inner join subjects s ON(s.id=c.subject)';
                $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';

		
		
		if($siges_structure==1)
		    $criteria->condition = $condition.' (course0.academic_period=:acad  OR a.id=:acad) AND c.teacher=:teacher';
		elseif($siges_structure==0)
		  $criteria->condition = $condition.' (course0.academic_period=:acad  OR a.year=:acad) AND c.teacher=:teacher';


		
		$criteria->params = array(':acad'=>$acad,':teacher'=>$id_teacher);
					
		$criteria->compare('id',$this->id);
		$criteria->compare('student0.first_name',$this->first_name,true);
		$criteria->compare('course0.subject',$this->course,true);
		$criteria->compare('subject_name',$this->course_name,true);
		$criteria->compare('evaluation0.evaluation_date',$this->evaluation_date,true);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('comment',$this->comment);
             
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
              
                $criteria->compare('student0.last_name',$this->last_name, true);
                $criteria->compare('course0.weight',$this->weight,true);
               
                $criteria->order = 'last_name ASC, evaluation0.evaluation_date DESC';

		return new CActiveDataProvider($this, array(
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
			'criteria'=>$criteria,
			
		));
	}
   


public function searchForTeacherUserRoomCourse($condition,$evaluation,$course_id, $acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 $siges_structure = infoGeneralConfig('siges_structure_session');
 
		$criteria=new CDbCriteria;
		$criteria->alias='g';
		$criteria->with= array('student0','course0','evaluation0',);
		$student_name=$this->first_name.' '.$this->last_name;
        
                $criteria->join='inner join courses c ON(c.id =g.course) inner join subjects s ON(s.id=c.subject)';
                $criteria->join.='inner join academicperiods a ON(a.id =c.academic_period)';

                
		if($siges_structure==1)
		    $criteria->condition = $condition.' g.evaluation='.$evaluation.' AND g.course='.$course_id.' AND (course0.academic_period='.$acad.'  OR a.id='.$acad.')';
		elseif($siges_structure==0)
		  $criteria->condition = $condition.' g.evaluation='.$evaluation.' AND g.course='.$course_id.' AND (course0.academic_period='.$acad.'  OR a.year='.$acad.')';
					
		$criteria->compare('id',$this->id);
		$criteria->compare('student0.first_name',$this->student_name,true);
		$criteria->compare('course0.subject',$this->course,true);
		$criteria->compare('subject_name',$this->course_name,true);
		$criteria->compare('evaluation0.evaluation_date',$this->evaluation_date,true);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('comment',$this->comment);
             
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('student0.last_name',$this->s_full_name, true);
                $criteria->compare('course0.weight',$this->weight,true);
               
			   $criteria->order = 'last_name ASC, evaluation0.evaluation_date DESC';

		return new CActiveDataProvider($this, array(
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
			'criteria'=>$criteria,
			
		));
	}
   
	
    
    // Return a nice formatted string for student grades 
    public function getStudentGrade(){
            
            return $this->student0->fullName.' ('.$this->course0->courseName.') ('.$this->evaluation0->examName.') ->'.$this->grade_value; 
        }
	
	
	
	
public function searchByRoom($course_id, $evaluation_id)
	{   
          	 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

   
   
          	 $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
		     if($acad!=$current_acad->id)
		         $condition = '';
		      else
		         $condition = 'p.active IN(1,2) AND ';
         
         
         
                        $criteria = new CDbCriteria;
	
			$criteria->condition = $condition.' g.course =:course AND g.evaluation =:evaluation';// AND validate=0';
			$criteria->params = array(':course'=>$course_id,':evaluation'=>$evaluation_id);
			
			$criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->select = 'p.first_name, p.last_name, p.gender, g.id, g.grade_value, c.weight, g.validate, g.publish, g.comment '; // on doit avoir shift et section aussi
			$criteria->join .= 'left join persons p on (p.id = g.student) ';
                        $criteria->join .= 'left join courses c on (c.id = g.course) ';
			$criteria->order = 'last_name ASC';
            
		    
		    
			
			
			
                    return new CActiveDataProvider($this, array(
                        'pagination'=>array(
                                                'pageSize'=> 100000,
                                        ),

                                'criteria'=>$criteria,


                    ));
	}
	
	
public function searchToValidate($condition,$course_id, $evaluation_id)
	{   
                        $criteria = new CDbCriteria;
	
			$criteria->condition = $condition.' g.course =:course AND g.evaluation =:evaluation AND (g.validate=0 OR g.publish=0)';//
			$criteria->params = array(':course'=>$course_id,':evaluation'=>$evaluation_id);
			
			$criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->select = 'p.first_name, p.last_name, p.gender, g.id, g.grade_value, c.weight, g.validate, g.publish, g.comment '; // on doit avoir shift et section aussi
			$criteria->join .= 'left join persons p on (p.id = g.student) ';
                        $criteria->join .= 'left join courses c on (c.id = g.course) ';
			$criteria->order = 'last_name ASC';
            
		
                    return new CActiveDataProvider($this, array(
                        'pagination'=>array(
                                                'pageSize'=> 100000,
                                        ),

                                'criteria'=>$criteria,


                    ));
	}

//return a boolean. true-false		
public function isCourseHasGrades($course_id, $acad)
	{   	    
         $siges_structure = infoGeneralConfig('siges_structure_session');
	     
	     $boul=false;
			
			if($siges_structure==1)
		    $sql='SELECT g.grade_value FROM grades  g inner join courses c on (c.id=g.course) inner join academicperiods a ON(a.id=c.academic_period) WHERE g.course ='.$course_id.' AND (c.academic_period='.$acad.' OR a.id='.$acad.')';
		elseif($siges_structure==0)
		    $sql='SELECT g.grade_value FROM grades  g inner join courses c on (c.id=g.course) inner join academicperiods a ON(a.id=c.academic_period) WHERE g.course ='.$course_id.' AND (c.academic_period='.$acad.' OR a.year='.$acad.')';


		   		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           if($result!=null)
             {   foreach($result as $r)
                   { $boul=true;
                       break;
                   }
             }
        
        return $boul;    
 }
		


public function courseInGrades($course_id)
	{   	    
         $prosp=0;
         
         $sql='SELECT g.grade_value FROM grades  g inner join courses c on (c.id=g.course) WHERE g.course ='.$course_id.' group by evaluation';
		
		   $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           if($result!=null)
             {   foreach($result as $r)
                   { $prosp++;
                       
                   }
             }
          
             return $prosp;    
 }



	
        // Report card function 
        
   	public function searchForReportCard($condition,$student,$course_id, $evaluation_id)
	{   
                        $criteria = new CDbCriteria;
	
			$criteria->condition = $condition.' g.student =:student AND g.course =:course AND g.evaluation =:evaluation';
			$criteria->params = array(':student' => $student,':course'=>$course_id,':evaluation'=>$evaluation_id);
            
                        $criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->join = 'inner join persons p on(p.id = g.student)';
			$criteria->select = 'g.id, g.grade_value, g.validate, g.comment,g.publish';
			//$criteria->limit = '100';
		    
		 
                    return new CActiveDataProvider($this, array(
                        'pagination'=>array(
                                                'pageSize'=> 100000,
                                        ),

                                'criteria'=>$criteria,


                    ));
	}


public function getTotalGradeWeightByPeriodForSubjectParent($subject_parent,$stud, $eval)
	{
                    $sql='SELECT SUM(grade_value) AS grade_total, SUM(c.weight) AS weight_total FROM grades g INNER JOIN courses c ON(g.course=c.id) LEFT JOIN subjects s ON(c.subject=s.id) WHERE c.old_new=1 AND s.subject_parent='.$subject_parent.' AND g.student='.$stud.' AND g.evaluation ='.$eval.' GROUP BY s.subject_parent';
		 
                    $command= Yii::app()->db->createCommand($sql);
		
                    $sql_result = $command->queryAll();
		
		  return $sql_result;
 	
	}
	
	
 public function ifAllGradesValidated($condition,$student,$evaluation_id)
	{   
                        $criteria = new CDbCriteria;
	
			$criteria->condition = $condition.' g.student =:student AND g.evaluation =:evaluation';
			$criteria->params = array(':student' => $student,':evaluation'=>$evaluation_id);
            
                        $criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->join = 'left join persons p on(p.id = g.student)';
			$criteria->select = 'g.id, g.grade_value, g.validate, g.comment';
			
		    
		 
                    return new CActiveDataProvider($this, array(

                                'criteria'=>$criteria,


                    ));
	}

	
	

public function ifAllGradesValidatedPublished($condition,$student,$evaluation_id)
	{   
                        $criteria = new CDbCriteria;
	
			$criteria->condition = $condition.' g.student =:student AND g.evaluation =:evaluation';
			$criteria->params = array(':student' => $student,':evaluation'=>$evaluation_id);
            
                        $criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->join = 'left join persons p on(p.id = g.student)';
			$criteria->select = 'g.id, g.grade_value, g.validate, g.publish, g.comment';
			
		    
		 
                    return new CActiveDataProvider($this, array(

                                'criteria'=>$criteria,


                    ));
	}
	
	
		    
   public function searchPeriodForReportCard($acad,$evaluation)
	{   
                        $criteria = new CDbCriteria;
	$siges_structure = infoGeneralConfig('siges_structure_session');
	
			
			if($siges_structure==1)
		    $criteria->condition = 'ap.id=:acad AND ey.evaluation_date<=(SELECT evaluation_date FROM evaluation_by_year WHERE id=:id_eval)';
		elseif($siges_structure==0)
		   $criteria->condition = 'ap.year=:acad AND ey.evaluation_date<=(SELECT evaluation_date FROM evaluation_by_year WHERE id=:id_eval)';

			
			$criteria->params = array(':acad' => $acad,':id_eval'=>$evaluation,);
			
			$criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->select = 'g.evaluation, ap.name_period';
			$criteria->join = 'left join evaluation_by_year ey on (ey.id=g.evaluation) left join academicperiods ap on(ap.id=ey.academic_year)';
			$criteria->order = 'ey.evaluation_date ASC';
          	    
                        return new CActiveDataProvider($this, array(

                                    'criteria'=>$criteria,


                        ));
	}
	
//TranscriptNotes		    
 public function searchPeriodForTranscriptNotes($acad)
	{   
                        $criteria = new CDbCriteria;
	$siges_structure = infoGeneralConfig('siges_structure_session');
	
			
			if($siges_structure==1)
		    $criteria->condition = 'ap.id=:acad ';
		elseif($siges_structure==0)
		   $criteria->condition = 'ap.year=:acad ';

			
			$criteria->params = array(':acad' => $acad);
			
			$criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->select = 'g.evaluation, ap.name_period';
			$criteria->join = 'inner join evaluation_by_year ey on (ey.id=g.evaluation) inner join academicperiods ap on(ap.id=ey.academic_year)';
			$criteria->order = 'ey.evaluation_date ASC';
          	    
                        return new CActiveDataProvider($this, array(

                                    'criteria'=>$criteria,


                        ));
	}
	
//return a float as grade value		
public function getGradeByStudentCourseEvaluation_id($student,$course_id, $evaluation_date, $acad)
	{   	    
         $siges_structure = infoGeneralConfig('siges_structure_session');
	
			
			if($siges_structure==1)
		    $sql='SELECT g.grade_value FROM grades  g left join courses c on (c.id=g.course) inner join academicperiods a ON(a.id=c.academic_period) inner join evaluation_by_year ey on(ey.id=g.evaluation) WHERE g.student ='.$student.' AND g.course ='.$course_id.' AND ey.evaluation_date =\''.$evaluation_date.'\' AND (c.academic_period='.$acad.' OR a.id='.$acad.')';
		elseif($siges_structure==0)
		   $sql='SELECT g.grade_value FROM grades  g left join courses c on (c.id=g.course) inner join academicperiods a ON(a.id=c.academic_period) inner join evaluation_by_year ey on(ey.id=g.evaluation) WHERE g.student ='.$student.' AND g.course ='.$course_id.' AND ey.evaluation_date =\''.$evaluation_date.'\' AND (c.academic_period='.$acad.' OR a.year='.$acad.')';


		   		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
                foreach($result as $r)
                    return $r["grade_value"];
            
 }

public function getGradeComment($student,$course_id, $evaluation_id, $acad)
	{   
   $siges_structure = infoGeneralConfig('siges_structure_session');
	
			
			if($siges_structure==1)
		    $sql='SELECT g.comment FROM grades  g left join courses c on (c.id=g.course) inner join academicperiods a ON(a.id=c.academic_period)  WHERE g.student ='.$student.' AND g.course ='.$course_id.' AND g.evaluation ='.$evaluation_id.' AND (c.academic_period='.$acad.' OR a.id='.$acad.')';
		elseif($siges_structure==0)
		  $sql='SELECT g.comment FROM grades  g left join courses c on (c.id=g.course) inner join academicperiods a ON(a.id=c.academic_period)  WHERE g.student ='.$student.' AND g.course ='.$course_id.' AND g.evaluation ='.$evaluation_id.' AND (c.academic_period='.$acad.' OR a.year='.$acad.')';


                 	
		 $result = Yii::app()->db->createCommand($sql)->queryAll();
           
                 foreach($result as $r)
                    return $r["comment"];

	}	

		
public function getGradeByStudentId($student,$course_id, $evaluation_id, $acad)
	{   
                        $criteria = new CDbCriteria;
	$siges_structure = infoGeneralConfig('siges_structure_session');
	
			
			if($siges_structure==1)
		   $criteria->condition = 'g.student =:student AND g.course =:course AND g.evaluation =:evaluation AND (c.academic_period=:academic_y OR a.id=:academic_y)';
		elseif($siges_structure==0)
		   $criteria->condition = 'g.student =:student AND g.course =:course AND g.evaluation =:evaluation AND (c.academic_period=:academic_y OR a.year=:academic_y)';

			
			$criteria->params = array(':student' => $student,':course'=>$course_id,':evaluation'=>$evaluation_id,':academic_y'=>$acad);
            
                        $criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->select = 'g.id, g.grade_value,g.validate, g.publish, g.comment ';
			$criteria->join = 'left join courses c on (c.id=g.course) inner join academicperiods a ON(a.id=c.academic_period)';
			
					
			
                    return new CActiveDataProvider($this, array(
                        'pagination'=>array(
                                                'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                                        ),

                                'criteria'=>$criteria,


                    ));
	}
        
  
public function getGradeByStudentIdForGraph($student,$course_id, $evaluation_id, $acad)
	{   
                        $criteria = new CDbCriteria;
	$siges_structure = infoGeneralConfig('siges_structure_session');
	
			
			if($siges_structure==1)
		   $criteria->condition = 'g.student =:student AND g.course =:course AND g.evaluation =:evaluation AND (c.academic_period=:academic_y OR a.id=:academic_y)';
		elseif($siges_structure==0)
		  $criteria->condition = 'g.student =:student AND g.course =:course AND g.evaluation =:evaluation AND (c.academic_period=:academic_y OR a.year=:academic_y)';

						$criteria->params = array(':student' => $student,':course'=>$course_id,':evaluation'=>$evaluation_id,':academic_y'=>$acad);
            
                        $criteria->alias = 'g';
			$criteria->distinct = 'true';
			$criteria->select = 'g.id, g.grade_value,g.validate, g.publish, g.comment ';
			$criteria->join = 'left join courses c on (c.id=g.course) inner join academicperiods a ON(a.id=c.academic_period)';
			
					
			
                    return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,


                    ));
	}
        

        
        // Help put place in report card 
        
        public function searchForPosition($condition,$evaluation_id,$shift,$section,$level,$room){   
                     
     $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

       
                        $criteria = new CDbCriteria;
				
			$criteria->condition = $condition.' rooms.shift=:idShift AND l.section=:idSection AND rooms.level=:idLevel AND rooms.id=:roomId AND evaluation like(:evaluation) AND h.academic_year=:acad';
			$criteria->params = array(':idShift' => $shift,':idSection'=>$section,':idLevel'=>$level,':roomId'=>$room,':evaluation'=>$evaluation_id,':acad'=>$acad_sess);
			
			$criteria->alias = 'g';
			
			$criteria->select = 'g.student, SUM(grade_value) as max_grade';
			$criteria->join = 'inner join room_has_person h on (g.student = h.students) inner join rooms on (h.room=rooms.id)  inner join persons p on(p.id = g.student) inner join levels l on(l.id=rooms.level)';//shift, level and room
			$criteria->group = 'g.student';
			$criteria->order = 'max_grade DESC';
      
   	  return new CActiveDataProvider($this, array(
                        
				'pagination'=>array(
        			'pageSize'=>150,
    			),
				
				'criteria'=>$criteria, 
				
            ));
	}




  public function searchForPosition_($stud, $evaluation_id)
       {   
                        $criteria = new CDbCriteria;
				
			$criteria->condition = 'g.student=:stud AND evaluation like(:evaluation) ';
			$criteria->params = array(':stud' => $stud,':evaluation'=>$evaluation_id);
			
			$criteria->alias = 'g';
			
			$criteria->select = 'g.student, SUM(grade_value) as max_grade';
			$criteria->join = 'left join room_has_person h on (g.student = h.students) left join persons p on(p.id = g.student)';//shift, level and room
			$criteria->group = 'g.student';
			$criteria->order = 'max_grade DESC';
      
   	  return new CActiveDataProvider($this, array(
                        
				'pagination'=>array(
        			'pageSize'=>150,
    			),
				
				'criteria'=>$criteria, 
				
            ));
	}



  public function searchById($id)
	{   
                        $criteria = new CDbCriteria;
	
			$criteria->condition = 'g.id like(:id)';
			$criteria->params = array(':id' => $id);
            
                        $criteria->alias = 'g';
			
			$criteria->select = '*';
			
		    
			
    return new CActiveDataProvider($this, array(
       
				
		'criteria'=>$criteria,
		
				
    ));
	}
  
 // Search grade by student ID 
       /* 
        *  Need to improve to allow only grades for the current academic year exam
         * and group the grades by evaluation period 
         *          */
        
   public function searchByStudentId($student_id, $acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 $siges_structure = infoGeneralConfig('siges_structure_session');
 
		$criteria=new CDbCriteria;
		$criteria->alias='g';
		$criteria->with= array('student0','course0','evaluation0');
		
		if($siges_structure==1)
		    $criteria->condition = "course0.old_new=1 AND course0.room=(select room from room_has_person rp where rp.students=:student and rp.academic_year=:acad) AND g.student=:student AND (course0.academic_period=:acad OR a.id=:acad)";
		elseif($siges_structure==0)
		   $criteria->condition = "course0.old_new=1 AND course0.room=(select room from room_has_person rp where rp.students=:student and rp.academic_year=:acad) AND g.student=:student AND (course0.academic_period=:acad OR a.year=:acad)";

        

        $criteria->params = array(':student'=>$student_id,':acad'=>$acad);
        
                $criteria->join ="left join room_has_person rh on(g.student=rh.students) inner join courses c ON(c.id=g.course)  inner join subjects s ON(s.id=c.subject) inner join academicperiods a ON(a.id=c.academic_period) ";
        
		$student_name=$this->first_name.' '.$this->last_name;
 
		$criteria->compare('id',$this->id);
		$criteria->compare('student0.first_name',$this->student_name,true);
		$criteria->compare('course0.subject',$this->course,true);
		$criteria->compare('subject_name',$this->course_name,true);
		$criteria->compare('evaluation0.evaluation_date',$this->evaluation_date,true);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
               $criteria->compare('student0.last_name',$this->s_full_name, true);
               $criteria->compare('course0.weight',$this->weight,true);
              
			   $criteria->order = 'evaluation0.evaluation_date DESC';
			  
			  
			  		return new CActiveDataProvider($this, array(
 			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
			'criteria'=>$criteria,
			
		));
	}
          

   //for vewForReport     
   public function searchByStudentId_forViewForReport($student_id, $acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 $siges_structure = infoGeneralConfig('siges_structure_session');
 
		$criteria=new CDbCriteria;
		$criteria->alias='g';
		$criteria->with= array('student0','course0','evaluation0');
		
		if($siges_structure==1)
		   $criteria->condition = "course0.old_new=1 AND course0.room=(select room from room_has_person rp where rp.students=:student and rp.academic_year=:acad) AND g.student=:student AND (course0.academic_period=:acad OR a.id=:acad)";
		elseif($siges_structure==0)
		   $criteria->condition = "course0.old_new=1 AND course0.room=(select room from room_has_person rp where rp.students=:student and rp.academic_year=:acad) AND g.student=:student AND (course0.academic_period=:acad OR a.year=:acad)";


		                   $criteria->params = array(':student'=>$student_id,':acad'=>$acad);
        
                $criteria->join ="left join room_has_person rh on(g.student=rh.students) inner join courses c ON(c.id=g.course)  inner join subjects s ON(s.id=c.subject) inner join academicperiods a ON(a.id=c.academic_period) ";
        
		$student_name=$this->first_name.' '.$this->last_name;
 
		$criteria->compare('id',$this->id);
		$criteria->compare('student0.first_name',$this->student_name,true);
		$criteria->compare('course0.subject',$this->course,true);
		$criteria->compare('subject_name',$this->course_name,true);
		$criteria->compare('evaluation0.evaluation_date',$this->evaluation_date,true);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
               $criteria->compare('student0.last_name',$this->s_full_name, true);
               $criteria->compare('course0.weight',$this->weight,true);
              
			   $criteria->order = 'evaluation0.evaluation_date DESC';
			  
			  
			  		return new CActiveDataProvider($this, array(
 			
			'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
			'criteria'=>$criteria,
			
		));
	}
	

public function searchByStudentId_teacherId_forViewForReport($student_id, $teacher_id, $acad)	
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 $siges_structure = infoGeneralConfig('siges_structure_session');
 
		$criteria=new CDbCriteria;
		$criteria->alias='g';
		$criteria->with= array('student0','course0','evaluation0');
		
		if($siges_structure==1)
		   $criteria->condition = "coourse0.old_new=1 AND course0.teacher=:teacher AND course0.room=(select room from room_has_person rp where rp.students=:student and rp.academic_year=:acad) AND g.student=:student AND (course0.academic_period=:acad OR a.id=:acad)";
		elseif($siges_structure==0)
		  $criteria->condition = "course0.old_new=1 AND course0.teacher=:teacher AND course0.room=(select room from room_has_person rp where rp.students=:student and rp.academic_year=:acad) AND g.student=:student AND (course0.academic_period=:acad OR a.year=:acad)";


		                $criteria->params = array(':teacher'=>$teacher_id,':student'=>$student_id,':acad'=>$acad);
        
                $criteria->join ="left join room_has_person rh on(g.student=rh.students) inner join courses c ON(c.id=g.course)  inner join subjects s ON(s.id=c.subject) inner join academicperiods a ON(a.id=c.academic_period) ";
        
		$student_name=$this->first_name.' '.$this->last_name;
 
		$criteria->compare('id',$this->id);
		$criteria->compare('student0.first_name',$this->student_name,true);
		$criteria->compare('course0.subject',$this->course,true);
		$criteria->compare('subject_name',$this->course_name,true);
		$criteria->compare('evaluation0.evaluation_date',$this->evaluation_date,true);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
               $criteria->compare('student0.last_name',$this->s_full_name, true);
               $criteria->compare('course0.weight',$this->weight,true);
              
			   $criteria->order = 'evaluation0.evaluation_date DESC';
			  
			  
			  		return new CActiveDataProvider($this, array(
 			
			'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
			'criteria'=>$criteria,
			
		));
	}

	
public function searchByStudentIdForGuestUser($student_id, $acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.
 $siges_structure = infoGeneralConfig('siges_structure_session');
 
		$criteria=new CDbCriteria;
		$criteria->alias='g';
		$criteria->with= array('student0','course0','evaluation0',);
		
		if($siges_structure==1)
		    $criteria->condition = "c.old_new=1 AND c.room=(select room from room_has_person rp where rp.students=:student and rp.academic_year=:acad) AND student=:student AND (c.academic_period=:acad OR a.id=:acad) AND g.publish=1";
		elseif($siges_structure==0)
		   $criteria->condition = "c.old_new=1 AND c.room=(select room from room_has_person rp where rp.students=:student and rp.academic_year=:acad) AND student=:student AND (c.academic_period=:acad OR a.year=:acad) AND g.publish=1";

		
		        $criteria->params = array(':student'=>$student_id,':acad'=>$acad);
        
        $criteria->join ="left join room_has_person rh on(student=rh.students) inner join courses c ON(c.id=g.course)  inner join subjects s ON(s.id=c.subject) inner join academicperiods a ON(a.id=c.academic_period) ";
        
		$student_name=$this->first_name.' '.$this->last_name;
 
		$criteria->compare('id',$this->id);
		$criteria->compare('student0.first_name',$this->student_name,true);
		$criteria->compare('course0.subject',$this->course,true);
		$criteria->compare('subject_name',$this->course_name,true);
		$criteria->compare('evaluation0.evaluation_date',$this->evaluation_date,true);
		$criteria->compare('grade_value',$this->grade_value);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
               $criteria->compare('student0.last_name',$this->s_full_name, true);
               $criteria->compare('course0.weight',$this->weight,true);
              
			   $criteria->order = 'evaluation0.evaluation_date ASC';
			  
			  
			  		return new CActiveDataProvider($this, array(
 			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
				
			'criteria'=>$criteria,
			
		));
	}
       
       
	
	

	
public function checkDdataByEvaluation($evaluation, $course)
	  {
	        $command= Yii::app()->db->createCommand("SELECT * FROM grades WHERE evaluation=:eval AND course=:course");
			$command->bindValue(':eval', $evaluation);
			$command->bindValue(':course', $course);	
			
			$sql_result = $command->queryAll();
			
			
			   return $sql_result;
			
	  
	  }

	
public function checkDdataByEvaluation_externRequest($student, $evaluation, $course)
	  {
	        $command= Yii::app()->db->createCommand("SELECT * FROM grades WHERE student=:stud AND evaluation=:eval AND course=:course");
			$command->bindValue(':stud', $student);
			$command->bindValue(':eval', $evaluation);
			$command->bindValue(':course', $course);	
			
			$sql_result = $command->queryAll();
			
			
			   return $sql_result;
			
	  
	  }


public function getComment()
	{
		 $command= Yii::app()->db->createCommand("SELECT comment FROM grades WHERE student=:stud AND evaluation=:eval AND course=:course");
			$command->bindValue(':stud', $this->student);
			$command->bindValue(':eval', $this->evaluation);
			$command->bindValue(':course', $this->course);	
			
			$sql_result = $command->queryAll();
			
			if($sql_result!=null)
			   {  
			   	  foreach($sql_result as $result)
			   	    { if($result["comment"]!=null)
				   	       return 1;
				   	  else
				   	      return null;
				   	      
			   	    }
			   	   
			   }
			else
			   return null;

 	
	}
	
	



//******** AVERAGE BY PERIOD  ************//
  
  public function checkDataAverageByPeriod($acadPeriod,$evaluation_id,$student_id)
	{   $siges_structure = infoGeneralConfig('siges_structure_session');
	    if($siges_structure==1)
		    $sql='SELECT student FROM average_by_period abp inner join academicperiods a ON(a.id=abp.academic_year)WHERE abp.evaluation_by_year='.$evaluation_id.' AND abp.student='.$student_id.' AND (abp.academic_year='.$acadPeriod.' OR a.id='.$acadPeriod.')' ;
		elseif($siges_structure==0)
		    $sql='SELECT student FROM average_by_period abp inner join academicperiods a ON(a.id=abp.academic_year)WHERE abp.evaluation_by_year='.$evaluation_id.' AND abp.student='.$student_id.' AND (abp.academic_year='.$acadPeriod.' OR a.year='.$acadPeriod.')' ;

	
				  $is_there = Yii::app()->db->createCommand($sql)->queryAll();
            return $is_there;
 	
	}
	
	
public function checkDataSubjectAverage($acadPeriod,$evaluation_id,$course)
	{  $siges_structure = infoGeneralConfig('siges_structure_session');
	
	     if($siges_structure==1)
		   $sql='SELECT course FROM subject_average sa inner join academicperiods a ON(a.id=sa.academic_year) WHERE sa.evaluation_by_year='.$evaluation_id.' AND sa.course='.$course.' AND (sa.academic_year='.$acadPeriod.' OR a.id='.$acadPeriod.')' ;
		elseif($siges_structure==0)
		   $sql='SELECT course FROM subject_average sa inner join academicperiods a ON(a.id=sa.academic_year) WHERE sa.evaluation_by_year='.$evaluation_id.' AND sa.course='.$course.' AND (sa.academic_year='.$acadPeriod.' OR a.year='.$acadPeriod.')' ;

	
		 		  $is_there = Yii::app()->db->createCommand($sql)->queryAll();
            return $is_there;
 	
	}
	
	
 public function getDataAverageByPeriod($acadPeriod,$evaluation_id,$student_id)
	{  $siges_structure = infoGeneralConfig('siges_structure_session');
	
	      	$criteria = new CDbCriteria;
	
	if($siges_structure==1)
		     $criteria->condition = 'abp.evaluation_by_year=:evaluation AND abp.student=:student AND (abp.academic_year=:acadPeriod OR a.id=:acadPeriod)';
		elseif($siges_structure==0)
		    $criteria->condition = 'abp.evaluation_by_year=:evaluation AND abp.student=:student AND (abp.academic_year=:acadPeriod OR a.year=:acadPeriod)';
        
	       			$criteria->params = array(':acadPeriod'=>$acadPeriod, ':evaluation'=>$evaluation_id, ':student'=>$student_id);
            
            $criteria->alias = 'g';
			$criteria->distinct = true;
			$criteria->select = 'abp.sum, abp.average,abp.place';
			$criteria->join = 'left join average_by_period abp on(abp.evaluation_by_year=g.evaluation) inner join academicperiods a ON(a.id=abp.academic_year)';
			
    return new CActiveDataProvider($this, array(
        'criteria'=>$criteria,
		));
		
	 
	}
	
	
 public function getDataGeneralAverageByPeriod($acad_year,$acadPeriod,$student_id)
	{  $siges_structure = infoGeneralConfig('siges_structure_session');
	
	if($siges_structure==1)
		  {  
		      $command= Yii::app()->db->createCommand("SELECT DISTINCT general_average, ap.name_period FROM general_average_by_period gabp INNER JOIN academicperiods ap on(ap.id=gabp.academic_year) WHERE (ap.id=".$acad_year." OR gabp.academic_year=".$acad_year.') AND academic_period='.$acadPeriod.' AND student='.$student_id);
		  
		  }
		elseif($siges_structure==0)
		  {  
		      $command= Yii::app()->db->createCommand("SELECT DISTINCT general_average, ap.name_period FROM general_average_by_period gabp INNER JOIN academicperiods ap on(ap.id=gabp.academic_year) WHERE (ap.year=".$acad_year." OR gabp.academic_year=".$acad_year.') AND academic_period='.$acadPeriod.' AND student='.$student_id);
		  }
        
	    		
		$sql_result = $command->queryAll();
		
		  return $sql_result;
	 
	}
	



public function checkDataGeralAverageByPeriodForReport($acad,$period)
	{  $siges_structure = infoGeneralConfig('siges_structure_session');
	
		 if($siges_structure==1)
		    $sql='SELECT general_average FROM general_average_by_period gabp inner join academicperiods a ON(a.id=gabp.academic_year) WHERE gabp.academic_period='.$period.' AND (gabp.academic_year='.$acad.' OR a.id='.$acad.')' ;
		elseif($siges_structure==0)
		   $sql='SELECT general_average FROM general_average_by_period gabp inner join academicperiods a ON(a.id=gabp.academic_year) WHERE gabp.academic_period='.$period.' AND (gabp.academic_year='.$acad.' OR a.year='.$acad.')' ;

		   
		 		  
		  $command= Yii::app()->db->createCommand($sql);
		
		$sql_result = $command->queryAll();
		
		  return $sql_result;
 	
	}
	


public function checkDataAverageByPeriodForReport($evaluation_id,$acadPeriod)
	{  $siges_structure = infoGeneralConfig('siges_structure_session');
	
		 if($siges_structure==1)
		    $sql='SELECT student FROM average_by_period abp inner join academicperiods a ON(a.id=abp.academic_year)WHERE abp.evaluation_by_year='.$evaluation_id.' AND (abp.academic_year='.$acadPeriod.' OR a.id='.$acadPeriod.')' ;
		elseif($siges_structure==0)
		    $sql='SELECT student FROM average_by_period abp inner join academicperiods a ON(a.id=abp.academic_year)WHERE abp.evaluation_by_year='.$evaluation_id.' AND (abp.academic_year='.$acadPeriod.' OR a.year='.$acadPeriod.')' ;

		   
		 		  $is_there = Yii::app()->db->createCommand($sql)->queryAll();
            return $is_there;
 	
	}
	
	
	 public function gradecompare($attribute, $params){
		            $message = Yii::t('app','The grade must be lower than the weight!');
		            if($this->grade_value >  $this->course0->weight)
		            {
		                $params = array(
		                    '{attribute}'=>$this->course0->weight, '{compareValue}'=>$this->grade_value
		                );
		                $this->addError('grade_value', strtr($message, $params));
		            }
		        }
          

	
	public function getValidateGrade(){
            switch($this->validate)
            {
                case 0:
                    return Yii::t('app','No');
                case 1:
                    return Yii::t('app','Yes');
                
            }
        }
        
        public function getPublishGrade(){
            switch($this->publish)
            {
                case 0:
                    return Yii::t('app','No');
                case 1:
                    return Yii::t('app','Yes');
                
            }
        }
        

	
}