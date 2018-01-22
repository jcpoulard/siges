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



class ReportCard extends CFormModel
{
	
	public $class_average;
	public $progress_subject_period;
	public $progress_student_class;
	public $repartition_grade_subject;
	public $student_iD;
	
	public $last_name;
	public $first_name;
	public $student_name;
	
	public $reportcard_category;
    
	
	public $mention;
	
	public $course_name;
        public $evaluation_date;
	public $subject_name;
	public $room_name;
	
	public $evaluation;//for "create reportcard"
	

 
        
        
 public static function searchForPosition($evaluation_id){   
                        $criteria = new CDbCriteria;
				
			$criteria->condition = 'evaluation like(:evaluation)';
			
			$criteria->select = 'student, SUM(grade_value) as max_grade';
			$criteria->params = array(':evaluation'=>$evaluation_id);
			$criteria->group = 'student';
			$criteria->order = 'max_grade DESC';
        return new CActiveDataProvider($this, array(
        	'criteria'=>$criteria,
		    ));
	}


   
	public static function searchCurrentAcademicPeriod($currentDate)
		{      	$acad = new AcademicPeriods;
	        $result=$acad->find(array('select'=>'id,name_period',
	                                     'condition'=>'is_year= 1  AND date_start<:current AND date_end>:current',
	                                    'params'=>array(':current'=>strtotime ($currentDate)),
	                               ));
		
					return $result;
	    }
	
	
		public static function getAcademicPeriodName($acad,$idRoom)
			{      	
				$condition = '';
				$siges_structure = infoGeneralConfig('siges_structure_session');
				if($siges_structure==1)
				    $condition = 'is_year= 0';
				elseif($siges_structure==0)
				   $condition = 'is_year= 1';

		        $result=AcademicPeriods::model()->find(array( 'alias'=>'a',
				                           'select'=>'a.id, a.name_period',
				                           'join'=>'left join room_has_person rhp on (rhp.academic_year=a.id)',
		               'condition'=>'a.'.$condition.'  AND rhp.room=:id_room AND rhp.academic_year=:acad',
		                                    'params'=>array(':id_room'=>$idRoom, ':acad'=>$acad),
		                               ));
		
						return $result;
          
		    }
		    
		public static function getAcademicPeriodNameLevel($acad,$idLevel)
			{      	
				$condition = '';
				$siges_structure = infoGeneralConfig('siges_structure_session');
				if($siges_structure==1)
				    $condition = 'is_year= 0';
				elseif($siges_structure==0)
				   $condition = 'is_year= 1';
				   
		        $result=AcademicPeriods::model()->find(array( 'alias'=>'a',
				                           'select'=>'a.id, a.name_period',
				                           'join'=>'left join level_has_person lhp on (lhp.academic_year=a.id)',
		               'condition'=>'a.'.$condition.' AND lhp.level=:id_level AND lhp.academic_year=:acad',
		                                    'params'=>array(':id_level'=>$idLevel, ':acad'=>$acad),
		                               ));
		
						return $result;
          
		    }
	
 public static function searchPeriodNameForReportCard($evaluation)
	{   
          	$result = AcademicPeriods::model()->find(array('alias'=>'a',
				                           'select'=>'a.id,a.name_period, a.weight',
				                           'join'=>'left join evaluation_by_year ey on(a.id=ey.academic_year)',
		               'condition'=>'ey.id=:id_eval',
		                                    'params'=>array(':id_eval'=>$evaluation),
		                                    
		                               ));
		             return $result;                  
          		    
		}
		
 public static function searchEvaluationNameForReportCard($evaluation) ///evaluation name
	{   
          	$result = Evaluations::model()->find(array('alias'=>'e',
				                           'select'=>'e.evaluation_name,e.weight',
				                           'join'=>'inner join evaluation_by_year ey on(e.id=ey.evaluation) ',
		               'condition'=>'ey.id=:id_eval',
		                                    'params'=>array(':id_eval'=>$evaluation),
		                                    
		                               ));
		             return $result;                  
          		    
		}
	
   public static function checkDataGeneralAverage($acad,$student,$gAverage,$idLevel)
       {
           $params= array(':acad'=>$acad, ':student'=>$student, ':gAverage'=>$gAverage, ':level'=>$idLevel);
           $sql='select id from decision_finale where academic_year=:acad AND student=:student AND general_average=:gAverage AND current_level=:level';
				
    
         $result= Yii::app()->db->createCommand($sql)->queryAll(true, array(':acad'=> $acad, ':student'=>$student, ':gAverage'=>$gAverage, ':level'=>$idLevel));

    
		             return $result;
        
       }

	
       
     
//return info for Palmares Average       
public static function searchStudentsForPA2($condition,$student,$eval,$acad)
  {
		$command= Yii::app()->db->createCommand("SELECT gabp.general_average, df.general_average as general_average_df, abp.average FROM general_average_by_period gabp LEFT JOIN persons p on(p.id = gabp.student) LEFT JOIN average_by_period abp on(p.id = abp.student) INNER JOIN decision_finale df ON(df.student=p.id) WHERE p.is_student=1  AND p.id=:stud AND abp.evaluation_by_year=:eval AND gabp.academic_period=:eval1 AND abp.academic_year=:acad AND gabp.academic_year=:acad1 ".$condition);
		$command->bindValue(':stud', $student);
		$command->bindValue(':eval', $eval);
		$command->bindValue(':eval1', $eval);
		$command->bindValue(':acad1', $acad);
		$command->bindValue(':acad', $acad);
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }
       

// return info for Palmares Average       
public static function searchStudentsForPA1($condition,$student,$eval,$acad)
  {
		$command= Yii::app()->db->createCommand("SELECT abp.average, df.general_average FROM average_by_period abp LEFT JOIN persons p on(p.id = abp.student) LEFT JOIN decision_finale df on(p.id = df.student) WHERE p.is_student=1  AND p.id=:stud AND abp.evaluation_by_year=:eval AND abp.academic_year=:acad AND df.academic_year=:acad ".$condition);
		$command->bindValue(':stud', $student);
		$command->bindValue(':eval', $eval);
		$command->bindValue(':acad', $acad);
		$sql_result = $command->queryAll();
		
		  return $sql_result;
  }
       


//return info of all evaluations for Palmares Average       
public static function searchPeriodForPA($acad)
  {
		$command= Yii::app()->db->createCommand("SELECT DISTINCT abp.evaluation_by_year, ap.name_period FROM average_by_period abp LEFT JOIN evaluation_by_year ey on (ey.id = abp.evaluation_by_year) LEFT JOIN academicperiods ap on(ap.id=ey.academic_year) WHERE ap.year=".$acad." AND abp.academic_year=".$acad." order by ey.evaluation_date ASC");
		
		$sql_result = $command->queryAll();
		
		  return $sql_result;
  }
       

    

	
	
	
	}
