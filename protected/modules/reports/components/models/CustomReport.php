<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class CustomReport extends Persons{
    
    public $academic_year = null;
    public $nom_periode = null;
    public $academic_period=null;
    public $age = null;
    
    
    
    public $test = "Message";
    
    public function getAllElement($string){
        
        return Persons::model()->findAllBySql($string);
        
    }
    
    
    
    
     public function report($str_query){   
            $criteria = new CDbCriteria;
            $criteria->select = $str_query;

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'pagination'=>array(
                        'pageSize'=>100000,
                        ),
                        ));
	}
        
        
        public function personAttributesLabels(){
            
            return array(
                'id'=>Yii::t('app','ID'),
                'last_name'=>Yii::t('app','Last name'),
                'first_name'=>Yii::t('app','First name'),
                'gender'=>Yii::t('app','Gender'),
                'blood_group'=>Yii::t('app','Blood group'),
                'birthday'=>Yii::t('app','Birthday'),
                'id_number'=>Yii::t('app','ID Number'),
                'is_student'=>Yii::t('app','Is student'),
                'adresse'=>Yii::t('app','Address'),
                'phone'=>Yii::t('app','Phone'),
                'email'=>Yii::t('app','Email'),
                'nif_cin'=>Yii::t('app','NIF/CIN'),
                'cities'=>Yii::t('app','City'),
                'citizenship'=>Yii::t('app','Citizenship'),
                'mother_first_name'=>Yii::t('app','Mother first name'),
                'identifiant'=>Yii::t('app','Identifiant'),
                'matricule'=>Yii::t('app','Matricule'),
                'paid'=>Yii::t('app','Paid'),
                'date_created'=>Yii::t('app','Date created'),
                'date_updated'=>Yii::t('app','Date updated'),
                'create_by'=>Yii::t('app','Create by'),
                'update_by'=>Yii::t('app','update_by'),
                'active'=>Yii::t('app','Active'),
                'image'=>Yii::t('app','Image'),
                'comment'=>Yii::t('app','comment'),
               
            );
          //  [0] => id 
          //  [1] => last_name 
          //  [2] => first_name
          //  [3] => gender
          //  [4] => blood_group 
          //  [5] => birthday 
          //  [6] => id_number 
          //  [7] => is_student 
          //  [8] => adresse 
          //  [9] => phone 
          //  [10] => email 
          //  [11] => nif_cin [
          //  12] => cities 
          //  [13] => citizenship 
          //  [14] => mother_first_name 
          //  [15] => identifiant 
          //  [16] => matricule 
          //  [17] => paid 
          //  [18] => date_created 
          //  [19] => date_updated 
          //  [20] => create_by 
          //  [21] => update_by 
          //  [22] => active 
          //  [23] => image
          //  [24] => comment 
            
        }
        
        public function getOperateurs(){
            return array(
                0=>Yii::t('app','Equal'), // Numeric, date and string
                1=>Yii::t('app','Superior'), // NUmeric or date 
                2=>Yii::t('app','Inferior'), // Numeric or date
                3=>Yii::t('app','Superior or equal'), // Numeric or date
                4=>Yii::t('app','Inferior or equal'), // NUmeric or date 
                5=>Yii::t('app','Start with'), // String
                6=>Yii::t('app','End with'), // String 
                7=>Yii::t('app','Have content'), // String
            ); 
            
        }
        
        
public function getAttendanceCountByRoom($room, $acad, $attendance_type){
    
    $string_sql = "SELECT id, room, academic_period, presence_type FROM record_presence where presence_type IN ($attendance_type[0],$attendance_type[1]) AND room = $room AND academic_period = $acad";
    $data = RecordPresence::model()->findAllBySql($string_sql);
    $count_attendance = 0;
    foreach($data as $d){
        $count_attendance++; 
    }
   
   return $count_attendance;  
}

public function getAttendanceCountByRoomBySex($room, $acad, $attendance_type,$sexe){
    $string_sql = "SELECT DISTINCT p.id, r.room, p.gender, r.academic_period, r.presence_type FROM record_presence r INNER JOIN persons p ON (r.student = p.id) where r.presence_type IN ($attendance_type[0],$attendance_type[1]) AND room = $room AND academic_period = $acad AND p.gender = $sexe";
    $data = RecordPresence::model()->findAllBySql($string_sql);
    $count_attendance = 0;
    foreach($data as $d){
        $count_attendance++; 
    }
   
   return $count_attendance;  
}

public function getInfractionCountByRoom($room, $acad){
    $string_sql = "SELECT r.id, r.student, rhp.room FROM record_infraction r INNER JOIN room_has_person rhp ON (r.student = rhp.students) WHERE rhp.room = $room AND r.academic_period = $acad";
    $data = RecordInfraction::model()->findAllBySql($string_sql);
    $count_infraction = 0; 
    foreach($data as $d){
        $count_infraction++;
    }
    return $count_infraction; 
}

public function getExpectedAmountByRoom($room, $acad){
    $string_sql_a = "SELECT f.id, f.level, f.academic_period, f.amount, f.fee  FROM fees f INNER JOIN rooms r ON (f.level = r.level) where r.id = $room AND f.academic_period = $acad";
    $string_sql_s = "SELECT rhp.id FROM room_has_person rhp INNER JOIN persons p ON (rhp.students = p.id)  where rhp.room = $room and rhp.academic_year = $acad AND p.active IN (1,2)";
    $data_a = Fees::model()->findAllBySql($string_sql_a);
    $data_s = RoomHasPerson::model()->findAllBySql($string_sql_s);
    $total_fees = 0;
    $count_students = 0;
   
    foreach($data_a as $da){
        $total_fees = $total_fees + $da->amount; 
    }
    
    foreach($data_s as $ds){
        $count_students++;
    }
    $total_expected = $total_fees*$count_students;
    
    return  $total_expected; 
}

public function getAmountPayByRoom($room, $acad){
    $string_sql = "SELECT b.id, b.student, b.amount_pay, b.academic_year FROM billings b INNER JOIN room_has_person rhp ON (b.student = rhp.students) WHERE rhp.room = $room AND b.academic_year = $acad";
    $data = Billings::model()->findAllBySql($string_sql); 
    $total_amount = 0;
    foreach($data as $d){
        $total_amount = $total_amount + $d->amount_pay;
    }
    
    return $total_amount;
}

public function getBalancePayByRoom($room, $acad){
    $string_sql = "SELECT b.id, b.student, b.balance, rhp.room FROM balance b INNER JOIN room_has_person rhp ON (b.student = rhp.students) WHERE rhp.room = $room AND rhp.academic_year = $acad";
    $data = Balance::model()->findAllBySql($string_sql);
    $total_balance = 0; 
    foreach($data as $d){
        $total_balance = $total_balance + $d->balance; 
    }
    
    return $total_balance; 
}
        
public function calMoyStudent($student, $evaluation){
    $string_sql = "Select g.student, g.course, g.evaluation, g.grade_value, c.weight  from grades g INNER JOIN courses c ON (g.course = c.id) WHERE g.student = $student AND g.evaluation = $evaluation";
    $data = Grades::model()->findAllBySql($string_sql);
    $tot_grade = 0;
    $tot_coef = 0;
    $average = 0;
    $average_base = 0;
      //Extract average base
    $average_base = infoGeneralConfig('average_base');
    
    
    foreach($data as $d){
        if($d->grade_value!=null){
            $tot_grade = $tot_grade + $d->grade_value;
            
        }else{
            $tot_grade = $tot_grade + 0;
        }
        $tot_coef = $tot_coef + $d->weight; 
      }
    
    if(($average_base ==10)||($average_base ==100)){
        if($tot_coef!=0){
            $average = ($tot_grade/$tot_coef)*$average_base; 
        }
    }
    
    
    return round($average,2); 
    
    
}

        /**
         * 
         * @param int $student
         * @param int $acad
         * @return real
         */
   public function disciplineDeduction($student,$acad){
            $total = 0.00;
            $criteria = new CDbCriteria;
            $criteria->condition='student=:student AND academic_period=:academic_period';
            $criteria->params=array(':student'=>$student,':academic_period'=>$acad);
            $infractions = RecordInfraction::model()->findAll($criteria);
            foreach($infractions as $in){
                $total = $total + $in->value_deduction;
                
            }
            return $total;
        }
        
        /**
         * 
         * @param int $student
         * @param int $exam_period
         * @param int $room
         * @return float
         */
      public function getDisciplineGradeByAcademicYear($student, $acad)
          {
            $note_discipline_finale = 0.00;
            $method = RecordInfraction::model()->getDiscGradeMethod();
            $note_discipline_initiale = RecordInfraction::model()->getDiscInitialGrade();
            
            if($method == 0){
            $note_discipline_finale = $note_discipline_initiale - $this->disciplineDeduction($student,$acad);
            }
            elseif($method == 1){
            $note_discipline_finale =$note_discipline_initiale - ($note_discipline_initiale*$this->disciplineDeduction($student, $acad))/100.00;
            }
			
			if($note_discipline_finale <= 0)
			{
				return 0.00;
			}
			else {
                return $note_discipline_finale;
			}
        }

/**
 * 
 * @param type $room
 * @param type $acad
 * @param type $pay_indicator
 * @return int
 */
public function  getCountStudentForPay($room, $acad,$pay_indicator){
    /*
     *  $pay_indicator
     *  1 : with 0 or negative balance
     *  2 : With positive balance 
     *  
     */
    
    $count_student = 0;
    if($pay_indicator==2){
        $string_sql1 = "SELECT DISTINCT b.student FROM balance b INNER JOIN room_has_person rhp ON (b.student = rhp.students) INNER JOIN persons p ON (b.student = p.id) WHERE rhp.room = $room AND rhp.academic_year = $acad AND p.active IN (1,2) AND b.balance > 0 GROUP BY b.student ";
        $data1 = Billings::model()->findAllBySql($string_sql1);
        if($data1!=null){
            foreach($data1 as $d){
                $count_student++;
            }
        }
    }
    
    if($pay_indicator==1){
        $string_sql2 = "SELECT DISTINCT b.student FROM billings b INNER JOIN room_has_person rhp ON (b.student = rhp.students) INNER JOIN persons p ON (b.student = p.id) WHERE rhp.room = $room AND rhp.academic_year = $acad AND p.active IN (1,2) AND b.student not in(select ba.student from balance ba where ba.balance>0) GROUP BY b.student";
        $data2 = Billings::model()->findAllBySql($string_sql2);
        if($data2!=null){
            foreach($data2 as $d){
                $count_student++;
            }
        }
    }
    
    return $count_student;
    
        
}

/**
 * 
 * @param type $room
 * @param type $acad
 * @return real
 */
public function getMinimumFeeByRoom($room, $acad){
    $minimum_fee = 0.00; 
    $string_sql = "SELECT f.amount FROM fees f INNER JOIN rooms r ON (f.level = r.level) WHERE f.date_limit_payment <= NOW() AND r.id = $room AND f.academic_period = $acad ORDER BY f.amount ASC LIMIT 0,1";
    $data = Fees::model()->findAllBySql($string_sql);
    if($data!=null){
        foreach ($data as $d){
            $minimum_fee = $d->amount;
        }
    }
    
    return $minimum_fee; 
}

public function getCountStudentNotPay($room, $acad){
    
}

public function getCountStudentWithBalance($room, $acad){
    
}



public function getAverageForAStudent($student, $room, $evaluation, $acad){  //return value: average
	   
      $acad_=Yii::app()->session['currentId_academic_year']; 
      
      $average_base = 0;
      //Extract average base
      $average_base = infoGeneralConfig('average_base');
    

    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
 if($current_acad==null)
						         { $condition = '';
          $condition1 = '';
        }
						     else{
						     	   


     if($acad_!=$current_acad->id)
        { $condition = '';
          $condition1 = '';
        }
      else
        { $condition = 'p.active IN(1,2) AND ';
          $condition1 = 'teacher0.active IN(1,2) AND ';
        }
    }
	    
	    
	    $average=0;
	   
		
	   $level_has_person= new LevelHasPerson;
	   $result=$level_has_person->find(array('alias'=>'lhp',
	                                 'select'=>'lhp.level',
                                     'join'=>'left join rooms r on(r.level=lhp.level) ',
									 'condition'=>'r.id=:room AND lhp.academic_year=:acad',
                                     'params'=>array(':room'=>$room,':acad'=>$acad),
                               ));
		$level=null;					   
		if(isset($result))	
           {  
   		     $level=$result->level;
			 
			 }
		
		$dataProvider_Course=Courses::model()->searchCourseByRoomId($condition1,$room, $acad);
										   
			 $k=0;
			$tot_grade=0;
                                                   
			$max_grade=0;

											           
		  if(isset($dataProvider_Course))
		   { $r=$dataProvider_Course->getData();//return a list of  objects
			foreach($r as $course) 
			 {					
				
				$grades=Grades::model()->searchForReportCard($condition,$student,$course->id, $evaluation);
																			  
					if(isset($grades))
					 {
					   $r=$grades->getData();//return a list of  objects
					   foreach($r as $grade) 
						 {									       
							$tot_grade=$tot_grade+$grade->grade_value;
							$max_grade=$max_grade+$course->weight;
																																	 
																	   
						 }
																																   
					  }
					
			  }
			 }
                                                                                                                
              
	if(($average_base ==10)||($average_base ==100))
		 { if($max_grade!=0)
     		 $average=round(($tot_grade/$max_grade)*$average_base,2);

		 }
	else
	   $average = null;
	   
	   
	    return $average;
	}
    
    
    
}

