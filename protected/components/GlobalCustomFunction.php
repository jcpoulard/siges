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

?>
<?php
	
// auto-loading




	function numberAccountingFormat($number)
	{
		//string number_format ( float $number , int $decimals = 0 , string $dec_point = "." , string $thousands_sep = ",” )
       // english notation with thousands separator
		$format_number = preg_replace( '/(-)([\d\.\,]+)/ui','($2)', number_format($number, 2, '.', ',')  );
		// french notation with thousands separator
		//$format_number = number_format($number, 2, ',', '.');
		return $format_number;
	}
	
	
	function pa_daksan()
	{
		 return array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );

    
    }
 
 function capital_aksan()
	{
		 return ['Š'=>'Š', 'š'=>'Š', 'Ž'=>'Ž', 'ž'=>'Ž', 'À'=>'À', 'Á'=>'Á', 'Â'=>'Â', 'Ã'=>'Ã', 'Ä'=>'Ä', 'Å'=>'Å', 'Æ'=>'Æ', 'Ç'=>'Ç', 'È'=>'È', 'É'=>'É', 'Ê'=>'Ê', 'Ë'=>'Ë', 'Ì'=>'Ì', 'Í'=>'Í', 'Î'=>'Î', 'Ï'=>'Ï', 'Ñ'=>'Ñ', 'Ò'=>'Ò', 'Ó'=>'Ó', 'Ô'=>'Ô', 'Õ'=>'Õ', 'Ö'=>'Ö', 'Ø'=>'Ø', 'Œ'=>'Œ', 'Ù'=>'Ù', 'Ú'=>'Ú', 'Û'=>'Û', 'Ü'=>'Ü', 'Ū'=>'Ū', 'Ý'=>'Ý', 'Ÿ'=>'Ÿ', 'Þ'=>'B', 'à'=>'À', 'á'=>'Á', 'â'=>'Â', 'ã'=>'Ã', 'ä'=>'Ä', 'å'=>'Å', 'æ'=>'Æ', 'ç'=>'Ç', 'è'=>'È', 'é'=>'É', 'ê'=>'Ê', 'ë'=>'Ë', 'ì'=>'Ì', 'í'=>'Í', 'î'=>'Î', 'ï'=>'Ï', 'ñ'=>'Ñ', 'ò'=>'Ò', 'ó'=>'Ó', 'ô'=>'Ô', 'õ'=>'Õ', 'ö'=>'Ö', 'ø'=>'Ø', 'œ'=>'Œ', 'ù'=>'Ù', 'ú'=>'Ú', 'û'=>'Û', 'ü'=>'Ü', 'ū'=>'Ū', 'ý'=>'Ý', 'ÿ'=>'Ÿ' ];

    
    }
 
function headerLogo()
  { 
    $string_add_logo = "<img src='".Yii::app()->baseUrl."/css/images/school_logo.png' style=\"margin-right:10px; max-height:50px; width:auto; \">";
     
     return $string_add_logo;
  
   }
   
   
    
 function acad_sess()
  {
		$acad_sess = 0;
			
	$siges_structure = infoGeneralConfig('siges_structure_session');
	     
	   if($siges_structure==1)
	    {
	         $sess=Yii::app()->session['currentId_academic_session'];  
             $sess_name=Yii::app()->session['currentName_academic_session'];	
	      }

$acad=Yii::app()->session['currentId_academic_year']; 
		
 if($siges_structure==1)
 {  if( $sess=='')
        $acad_sess = 0;
    else 
		$acad_sess = $sess;
 }
 elseif($siges_structure==0)
   $acad_sess = $acad;


		
		 return $acad_sess;
 
    }
  

//-1: migration not yet done; 1: migration is not completed 2: migration done; 0: no migration to do  
function getYearMigrationCheck($acad)
{
    $result=2;
    $data = YearMigrationCheck::model()->getValueYearMigrationCheck($acad);
    
         if($data!=null)
           {  foreach($data as $d){
    	         if( ($d['period']==0)&&($d['student']==0)&&($d['postulant']==0)&&($d['course']==0)&&($d['evaluation']==0)&&($d['passing_grade']==0)&&($d['reportcard_observation']==0)&&($d['fees']==0)&&($d['taxes']==0)&&($d['pending_balance']==0) )
    	           {
    	           	  $result=-1; 
    	           	  break;
    	           }
    	         else
    	           {
		    	         if( ($d['period']==0)||($d['student']==0)||($d['postulant']==0)||($d['course']==0)||($d['evaluation']==0)||($d['passing_grade']==0)||($d['reportcard_observation']==0)||($d['fees']==0)||($d['taxes']==0)||($d['pending_balance']==0) )
		    	         $result=1; 
		                    break;
    	           }
                      
              }
           }
         else
            $result = 0;
          
           
	return $result;
       
  }
  
  
  
function lastBillingTransactionID($tud, $acad)
  { 
  	$fee_status = 'fl.status IN(0,1) AND ';  
  	
     $last_bill_id =0;
          $result = Billings::model()->getLastTransactionID($tud,$fee_status, $acad);
          if($result!=null)
            $last_bill_id = $result;
        
        return $last_bill_id;
  
   }
	


function sumPeriodWeight($pastp,$current_p)
  {
  	  if($pastp!=null)
  	    {
  	    	 $sum_ = 0;
  	    	 $weight_null=false;
  	    	 $weight_100=true;
  	    	 
  	    	 foreach($pastp as $pId)
  	    	   {
  	    	   	 //jwenn peryod eval sa ye
  	    	   	  $p_acad = EvaluationByYear::model()->getPeriodNameByEvaluationID($pId);
  	    	   	  
  	    	   	   foreach($p_acad as $p_weight)
  	    	   	     {  
  	    	   	     	if($p_weight['weight']!=null)
  	    	   	          { $sum_ =  $sum_ + $p_weight['weight'];
  	    	   	             
  	    	   	             if($p_weight['weight']!=100)
  	    	   	               $weight_100=false;
  	    	   	                
  	    	   	          }
  	    	   	        else
  	    	   	           $weight_null=true;
  	    	   	          
  	    	   	     }
  	    	   	  
  	    	   	 
  	    	   	}
  	    	   
  	    	if($current_p!='')
  	    	  {
  	    	  	   //jwenn peryod eval sa ye
  	    	   	  $p_acad = EvaluationByYear::model()->getPeriodNameByEvaluationID($current_p);
  	    	   	  
  	    	   	   foreach($p_acad as $p_weight)
  	    	   	     {  
  	    	   	     	if($p_weight['weight']!=null)
  	    	   	          { $sum_ =  $sum_ + $p_weight['weight'];
  	    	   	             
  	    	   	             if($p_weight['weight']!=100)
  	    	   	               $weight_100=false;
  	    	   	                
  	    	   	          }
  	    	   	        else
  	    	   	           $weight_null=true;
  	    	   	          
  	    	   	     }
  	    	  	}
  	    	   	
  	    	   	if( ($sum_==0) && ($weight_null==true) ) //tout peryod yo gen menm koyefisyan
  	    	   	  return -1;   
  	    	   	elseif( ($sum_!=0) && ($weight_null==true) )
  	    	   	       return $sum_;
  	    	   	    elseif( ($sum_!=0) && ($weight_null==false) )
  	    	   	        {
  	    	   	        	if( ($weight_100==true) )//tout peryod yo gen menm koyefisyan
  	    	   	        	  return -1;
  	    	   	        	else
  	    	   	        	   return $sum_;
  	    	   	          }
  	    	
  	      }
  	  else
  	     return 0;
  	
  	}
  	
  	

	//************************  loadPreviousLevel  ******************************/
function loadPreviousLevel($idLevel)
	{    
       	  
		  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      
	       $modelLevel= new Levels();

	      $pLevel_id=$modelLevel->findAll(array('select'=>'previous_level',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel),
                               ));
			if(isset($pLevel_id))
			 {  
			    foreach($pLevel_id as $i){			   
					 					   
					  
					  
					  $level=$modelLevel->findAll(array('select'=>'id, level_name',
												 'condition'=>'id=:levelID OR id=:IDLevel',
												 'params'=>array(':levelID'=>$i->previous_level,':IDLevel'=>$idLevel),
										   ));
						
					if(isset($level)){
						  foreach($level as $l)
						       $code[$l->id]= $l->level_name;
					    }  
							   }						 
		    
						  }	
			
		return $code;
         
	}
		

	
	
	//************************  loadLevel ******************************/
function loadAllLevel()
	{    
	    $modelLevel= new Levels();
		
		 
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}


	//************************  loadAllLevelToSort ******************************/
function loadAllLevelToSort()
	{    
	    $modelLevel= new Levels();
		
		 
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll();
            $code[null]= Yii::t('app','-- Sort by level --');
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}


	//************************  loadLevelForMenfpExam ******************************/
function loadLevelForMenfpExam()
	{    
	    $modelLevel= new Levels();
		
		 
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll(array('alias'=>'l',
		  										 'select'=>'l.id, l.level_name',
												 'join'=>'inner join examen_menfp em on(em.level=l.id)',
												 //'condition'=>'l.section=:sectionID',
												 //'params'=>array(':sectionID'=>$idSection),
										   ) );
            $code[null]= Yii::t('app','-- Sort by level --');
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}
	

	//************************  loadFeeName ******************************/
function loadFeeName($status,$level,$acad_sess,$student)
	{    
	   	    $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol'];
	       
	       $previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
	   	
	   	$code= array();
	   	//gad si elev la gen balans ane pase ki poko peye
	   	$modelPendingBal=PendingBalance::model()->findAll(array('select'=>'id, balance',
												 'condition'=>'student=:stud AND is_paid=0 AND academic_year=:acad',
												 'params'=>array(':stud'=>$student,':acad'=>$previous_year),
										   ));
			//si gen pending, ajoutel nan lis apeye a			
					if(isset($modelPendingBal)){
						  foreach($modelPendingBal as $bal)
						     {  
						     	$criteria1 = new CDbCriteria(array('alias'=>'f', 'join'=>'inner join fees_label fl on(fl.id=f.fee)', 'order'=>'fee','condition'=>'fl.fee_label LIKE("Pending balance") AND fl.status='.$status.' AND level='.$level.' AND academic_period='.$acad_sess));
						     	
						     	$model_feesPend_level = Fees::model()->findAll($criteria1);
						     	
						     	foreach($model_feesPend_level as $model_feesPend_level_)
						     	  $code[$model_feesPend_level_->id]= Yii::t('app',$model_feesPend_level_->fee0->fee_label).' '.$model_feesPend_level_->level0->level_name.' '.$currency_symbol.' '.numberAccountingFormat($bal->balance);
						     	 						     
						     }
					    } 
		 
           
		   
		  $criteria = new CDbCriteria(array('alias'=>'f', 'join'=>'inner join fees_label fl on(fl.id=f.fee)', 'order'=>'fee','condition'=>'fl.fee_label NOT LIKE("Pending balance") AND fl.status='.$status.' AND level='.$level.' AND academic_period='.$acad_sess));
		  
		  $modelFeeName=Fees::model()->findAll($criteria);
            //$code[null]= Yii::t('app','-- Please select fee name ---');
		    foreach($modelFeeName as $fee_name){
			    $code[$fee_name->id]= $fee_name->feeName;
		           
		      }
		   
		return $code;
         
	}

    
         
        /*
         * Get month from a date 
         */
      function getMonth($date){
            if(($date!='')&&($date!='0000-00-00'))
              {  $time = strtotime($date);
                         $month=date("n",$time);
                         
            return $month;
              }
           else
              return null;
        }
       
       
        /*
         * Get day from a date 
         */
      function getDay($date){
            if(($date!='')&&($date!='0000-00-00'))
              {  $time = strtotime($date);
                         $day=date("j",$time);
                         
            return $day;
              }
           else
              return null;
        }
        
     
        /*
         * Get year form a date 
         */
      function getYear($date){
            if(($date!='')&&($date!='0000-00-00'))
              {  $time = strtotime($date);
                        $year=date("Y",$time);
                         
                return $year;
              }
           else
              return null;
        }
        
      
      function ChangeDateFormat($d){
            if(($d!='')&&($d!='0000-00-00'))
              { $time = strtotime($d);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
               return $day.'/'.$month.'/'.$year; 
               }
             else
                return '00/00/0000'; 
        }


         
        // Return the name of a month in long format 
  function getLongMonth($mois){
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
    
    
  function getShortMonth($mois){
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

	
  		
	function getLongDay($day){
		switch($day){
				case 1:
					return Yii::t('app','Monday');
				     break;
				case 2:
					return Yii::t('app','Tuesday');
					break;
				case 3:
					return Yii::t('app','Wednesday');	
					break;
				case 4:
					return Yii::t('app','Thursday');
					break;
				case 5:
					return Yii::t('app','Friday');
					break;
				case 6:
					return Yii::t('app','Saturday');
					break;	
				case 7:
					return Yii::t('app','Sunday');
				      break;
				default: 
					return Yii::t('app','Unknow');
				}
		}

	
    function getShortDay($day){
		switch($day){
				case 1:
					return Yii::t('app','Mon');
				     break;
				case 2:
					return Yii::t('app','Tue');
					break;
				case 3:
					return Yii::t('app','Wed');	
					break;
				case 4:
					return Yii::t('app','Thu');
					break;
				case 5:
					return Yii::t('app','Fri');
					break;
				case 6:
					return Yii::t('app','Sat');
					break;	
				case 7:
					return Yii::t('app','Sun');
				      break;
				default: 
					return Yii::t('app','Unknow');
				}
		}

	
    function getDayNumberByShortDay($day){
		switch($day){
				case Yii::t('app','Mon'):
					return 1;
				     break;
				case Yii::t('app','Tue'):
					return 2;
					break;
				case Yii::t('app','Wed'):
					return 3;	
					break;
				case Yii::t('app','Thu'):
					return 4;
					break;
				case Yii::t('app','Fri'):
					return 5;
					break;
				case Yii::t('app','Sat'):
					return 6;
					break;	
				case Yii::t('app','Sun'):
					return 7;
				      break;
				default: 
					return Yii::t('app','Unknow');
				}
		}


function isAchiveMode($acad)   
    {
    	//fok li pa ane ancour epi fok desizyon final pran pou tout elev aktif
    	
    	
    	$result = false;
   
      if($acad!='')
	    {
	    		    	 	   	    if( ( (totalActiveStudentsInRoomByAcad($acad) !=0 ) && ( totalDecisionTakenByAcad($acad)!=0) )&&( totalActiveStudentsInRoomByAcad($acad) == totalDecisionTakenByAcad($acad) ) )
		                    $result = true;
	    	 	      	 
	       }
	       
       return $result;           
    	
      }
      
      
 function totalActiveStudentsInRoomByAcad($acad)
    {   //SELECT count(rh.students) FROM room_has_person rh INNER JOIN persons p ON(p.id=rh.students)WHERE p.active IN(1,2) AND rh.academic_year=1
    	$total = 0;
    	    $command= Yii::app()->db->createCommand('SELECT count(rh.students) as tot_stud FROM room_has_person rh INNER JOIN persons p ON(p.id=rh.students) WHERE p.active IN(1,2) AND rh.academic_year='.$acad); 
	
	     $data_ = $command->queryAll();
    
         foreach($data_ as $d){
    	         $total = $d['tot_stud']; 
                    break;
                      
         }

    	 return $total;
    	 
    	}
    	
 
 function totalDecisionTakenByAcad($acad)
   {   //SELECT count(df.student) FROM decision_finale df INNER JOIN persons p ON(p.id=df.student)WHERE p.active IN(1,2) AND df.academic_year=1
   	    $total1 = 0;
   	       $command1= Yii::app()->db->createCommand('SELECT count(df.student) as tot_stud1 FROM decision_finale df INNER JOIN persons p ON(p.id=df.student)WHERE p.active IN(1,2) AND df.academic_year='.$acad.' AND is_move_to_next_year <> NULL'); 
	
	     $data_1 = $command1->queryAll();
    
         foreach($data_1 as $d){
    	         $total1 = $d['tot_stud1']; 
                    break;
                      
         }
   	    return $total1;
   	    
   	 }
 
 
 
 
	
//return 0,1 ou total-weight
function evaluationWeightCheck($old_weight)	
  { 
  	 $total_weight=0;
  	 $_weight_=0;
  	 
  	 $pass = false;
  	 
  	 $acad=Yii::app()->session['currentId_academic_year'];   
  	//searchAllEvaluations($acad)
		$eval = Evaluations::model()->searchAllEvaluations($acad);
		
	  if($eval!=null)
	   {
		foreach($eval as $e)
		  {  //getEvaluationWeight($eval_id)
		    // $weight = '';
		  	 $weight = Evaluations::model()->getEvaluationWeight($e['id']);
		  
		  if($weight!=NULL)
		    {
			 foreach($weight as $w)
		      {   
		      	 if( ($w['weight']==NULL)||($w['weight']==100) )	
			  	    {   $pass = true;
			  	    
			  	         if($w['weight']==NULL)
			  	            $_weight_= 0;
			  	            
			  	         if($w['weight']==100)
			  	            $_weight_= 1;
			  	    }
			  	  else
			  	      $total_weight = $total_weight + $w['weight'];
			  	      
		        }
		      
		      }
		     
		   }
		
           
          if($pass==true)
              return $_weight_;
           else
             {
             	if( ($total_weight-$old_weight)==0)
             	   return ($total_weight);
             	else
             	   return ($total_weight-$old_weight);
             }
	   }
	  else
	     return -1;
  
 }
	

//return true/false
function isCourseInPeriod($course,$period)
{
	$result = false;
	
   	       $command1= Yii::app()->db->createCommand('SELECT c.weight FROM courses c WHERE c.id='.$course.' AND c.academic_period='.$period); 
	
	     $data_1 = $command1->queryAll();
    
        if($data_1!=null)
         { foreach($data_1 as $d)
            {
    	        if($d['weight']!='') 
    	         { $result = true;
                    break;
    	         }
             }
         
         }
   	    return $result;
 
 }	  
 
 //return id course
function isCourseAReference($id_course)
 {
	
   	       $command1= Yii::app()->db->createCommand('SELECT c.id FROM courses c WHERE c.reference_id='.$id_course); 
	
	     $data_1 = $command1->queryAll();
    
        if($data_1!=null)
         { foreach($data_1 as $d)
            {
    	        if($d['id']!='') 
    	         { return $d['id'];
                    
    	         }
    	        else
    	           return null;
             }
         
         } 
   	    return null;
 
 }	  
 
  //return 
function isLevelExamenMenfp($level, $acad)
 {
	       $command1= Yii::app()->db->createCommand('SELECT em.id as id, s.subject_name,em.weight FROM examen_menfp em inner join subjects s on(s.id=em.subject) WHERE em.level='.$level.' AND em.academic_year='.$acad); 
	
	     $data_1 = $command1->queryAll();
    
        if($data_1!=null)
         { foreach($data_1 as $d)
            {
    	        if($d['id']!='') 
    	         { return $d;
                    
    	         }
    	        else
    	           return null;
             }
         
         } 
   	    return null;
 
 }	  
  
   
function infoGeneralConfig($param_value){
        $item_value=null;
        $criteria = new CDbCriteria;
	$criteria->condition='item_name=:item_name';
	$criteria->params=array(':item_name'=>$param_value,);
	$item_name = GeneralConfig::model()->find($criteria);
        
        if(isset($item_name)&&($item_name!=null))
            $item_value=$item_name->item_value;
            
            return $item_value;
               
   }


/** Take observation from base de donnees **/   
function observationReportcard($section,$moyenne,$aca){  
    
    //$data_ = ReportcardObservation::model()->findAll('academic_year='.$aca);
    
	$command= Yii::app()->db->createCommand('SELECT distinct start_range,end_range,comment, academic_year FROM reportcard_observation ro  WHERE academic_year='.$aca.' AND section='.$section.' AND (start_range<'.$moyenne.' AND end_range>='.$moyenne.') '); 
	
	$data_ = $command->queryAll();
   if($data_!=null)
    { 
       foreach($data_ as $d)
         {
    	         return $d['comment']; 
                    break;
                      
          }
     }
    else
       return null;
} 
	
//return datetime (last_activity)
function isUserConnected($user_id){  
    
    
	$command= Yii::app()->db->createCommand('SELECT id, last_activity FROM session  WHERE user_id='.$user_id ); 
	
	$data_ = $command->queryAll();
    
    foreach($data_ as $d){
    	         return $d['last_activity']; 
                    break;
                      
         }
         
         
}


/**  from base de donnees **/   
function isDateInAcademicRange($dat,$acad){  
    
    $result = false;
    
	$command= Yii::app()->db->createCommand('SELECT id FROM academicperiods a  WHERE id ='.$acad.' AND (date_start <\''.$dat.'\' AND date_end >\''.$dat.'\')'); 
	
	$data_ = $command->queryAll();

  
    if($data_ !=null)
      { foreach($data_ as $d){
    	        $result = true;

                  break;             
         }
         
       }
         
    return $result;     
} 
	

function getAcademicYearNameByPeriodId($id){
            $data = AcademicPeriods::model()->findAllBySql("SELECT id,name_period,is_year,year FROM academicperiods where id = $id"); 
            $string_acad_name = null;
            foreach($data as $d){
                $string_acad_name = AcademicPeriods::model()->findByPk($d->year)->name_period;
            }
            return $string_acad_name;
        }


function standard_deviation($aValues, $bSample = false)
        {
            $fMean = array_sum($aValues) / count($aValues);
            $fVariance = 0.0;
            foreach ($aValues as $i)
            {
                $fVariance += pow($i - $fMean, 2);
            }
            $fVariance /= ( $bSample ? count($aValues) - 1 : count($aValues) );
            return (float) sqrt($fVariance);
        }
        
        
        


//return iri deduction over total_gross_salary
function getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary)
  {
     $deduct_iri=false;
     $deduction=0;
     
     if($id_payroll_set2==null)
       {     $sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_payroll_set;
        
        }
     elseif($id_payroll_set2!=null)
	     {  $sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set IN('.$id_payroll_set.','.$id_payroll_set2.')';
	     
	       }
			           	      
		$command__ = Yii::app()->db->createCommand($sql__);
		$result__ = $command__->queryAll(); 
			
																					       	   
		  if($result__!=null) 
			{ foreach($result__ as $r)
				{ 
				    $tx_des='';
					$sql_tx_des = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																				
					$command_tx_des = Yii::app()->db->createCommand($sql_tx_des);
					$result_tx_des = $command_tx_des->queryAll(); 
																								       	   
					foreach($result_tx_des as $tx_desc)
					 {   $tx_des= $tx_desc['taxe_description'];
						 
					  }
											     	 
					if( ($tx_des=='IRI') ) //c iri,
						$deduct_iri=true; 					     	      			                        
		 
				}
				
			}
			            	 
		
		if($deduct_iri)
		  {
	          $bareme = array();
	        
	        //pran vale barem lan nan baz la
	        //return an array  
	         $potential_bareme = Bareme::model()->getBaremeInUse();
	           if($potential_bareme!=null)
	             { $i =0;
	                
	                foreach($potential_bareme as $bar_)
	                 { 
	                    $bareme[$i] = array($bar_['min_value'], $bar_['max_value'], $bar_['percentage']);
	                     $i++;
	  				  }
			     
	            
		           // Salaire mensuel net
				   // Deduction IRI mensuel
				   // Salaire annuel
				   // Deduction IRI annuel
				   $salaire = Payroll::model()->getIriCharge_new($total_gross_salary,$bareme);
										              
					$deduction = $salaire['month_iri'];
					
												         
				   }
				      				   
	  	  
		      }
	  	     
  	  return $deduction;
  	
  	
  	}




function getDeductionTaxeForReport($person_id,$taxe_id,$payroll_month,$acad)	  
   {
  	      
  	       $sql__ = 'SELECT id_payroll_set, id_payroll_set2 FROM payroll p WHERE p.id_payroll_set in(SELECT id FROM payroll_settings ps WHERE ps.person_id='.$person_id.' AND ps.academic_year='.$acad.') AND p.payroll_month='.$payroll_month ;
															
								  $command__ = Yii::app()->db->createCommand($sql__);
								  $result__ = $command__->queryAll(); 
																			       	   
		  							
									
									 $total_deduction=0;
									
									     	 
				if($result__!=null) 
				 { 
				 	foreach($result__ as $res)
				 	 {
				 	 	
  	               $criteria = new CDbCriteria(array('alias'=>'ps',  'condition'=>' ps.id='.$res['id_payroll_set']));
                 //check if it is a timely salary 
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                    
                    $total_gross_salary=0;
                   
                    
                    
                 foreach($pay_set as $amount)
                   {   
                   	  $gross_salary_initial =0;
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	   $timely_salary=0;
                         
	                     if(($amount!=null))
			               {  
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $gross_salary_initial =$amount->amount;
			               	   
			               	   $missing_hour = $amount->number_of_hour;
			               	   
			               	   $numberHour_ = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	 
			                  if(($numberHour_!=null)&&($numberHour_!=0))
						       {
						          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
						
						        } 
			                   
			                 
				            }
			           
			           
			          	         $sql__ = 'SELECT t.taxe_value FROM payroll_setting_taxes pst INNER JOIN payroll_settings ps ON(pst.id_payroll_set=ps.id)  INNER JOIN taxes t ON(t.id=pst.id_taxe)  WHERE ps.id='.$res['id_payroll_set'].' AND pst.id_taxe='.$taxe_id.' AND t.academic_year='.$acad;
															
								  $command__ = Yii::app()->db->createCommand($sql__);
								  $result__ = $command__->queryAll(); 
																			       	   
									$deduction = 0;
									$tx_val='';
									     	 
									if($result__!=null) 
									 { foreach($result__ as $r)
									      $tx_val= $r['taxe_value'];
											
									  $deduction = ( ($gross_salary_initial * $tx_val)/100);
									  
									  }
									 
								   
									     	      	
                      	    
	                       	    $total_deduction = $total_deduction + $deduction;
	                       	  
                            } 
                            
                            
                            if($res['id_payroll_set2']!=NULL)
                              {
                              	 
				  	               $criteria = new CDbCriteria(array('alias'=>'ps',  'condition'=>' ps.id='.$res['id_payroll_set2']));
				                 //check if it is a timely salary 
				                     $pay_set = PayrollSettings::model()->findAll($criteria);
				                    
				                    $total_gross_salary=0;
				                   
				                    
				                    
				                 foreach($pay_set as $amount)
				                   {   
				                   	  $gross_salary_initial =0;
				                   	  $gross_salary =0;
				                   	  $deduction =0;
				                   	   $timely_salary=0;
				                         
					                     if(($amount!=null))
							               {  
							               	   
							               	   $gross_salary =$amount->amount;
							               	   
							               	   $gross_salary_initial =$amount->amount;
							               	   
							               	   $missing_hour = $amount->number_of_hour;
							               	   
							               	   $numberHour_ = $amount->number_of_hour;
							               	   
							               	   if($amount->an_hour==1)
							                     $timely_salary = 1;
							                 }
							           //get number of hour if it's a timely salary person
							            if($timely_salary == 1)
							              {
							             	 							                  
							                  if(($numberHour_!=null)&&($numberHour_!=0))
										       {
										          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
										
										        } 
							                   
							                  							             
								            }
							           
							           
							          	         $sql__ = 'SELECT t.taxe_value FROM payroll_setting_taxes pst INNER JOIN payroll_settings ps ON(pst.id_payroll_set=ps.id) INNER JOIN taxes t ON(t.id=pst.id_taxe)  WHERE ps.id='.$res['id_payroll_set2'].' AND pst.id_taxe='.$taxe_id.' AND t.academic_year='.$acad;
																			
												  $command__ = Yii::app()->db->createCommand($sql__);
												  $result__ = $command__->queryAll(); 
																							       	   
													$deduction = 0;
													$tx_val='';
													     	 
													if($result__!=null) 
													 { foreach($result__ as $r)
													      $tx_val= $r['taxe_value'];
															
													  $deduction = ( ($gross_salary_initial * $tx_val)/100);
													  
													  }
													 
												   
													     	      	
				                      	    
					                       	    $total_deduction = $total_deduction + $deduction;
					                       	  
				                        }
                        
                              	}
	                       
				 	    
	                      
				 	 }
                                                 
                          
                      
				 }
                       
					
		       						    
	      return $total_deduction;
  	      
  	}
 
function getShiftByStudentId($student,$acad)
{
	$idRoom= getRoomByStudentId($student,$acad);
		
		
		$model=new Rooms;
		$result=null;
		
		if(isset($idRoom)&&($idRoom!=''))
        {   $idShift = $model->find(array('select'=>'shift',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$shift = new Shifts;
	        if(isset($idShift)&&($idShift!=''))
	        {  
             $result=$shift->find(array('select'=>'id,shift_name',
                                     'condition'=>'id=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift->shift),
                               ));
                               
               }
        }
				return $result;
}

function getSectionByStudentId($student,$acad)
{
	$idRoom= getRoomByStudentId($student,$acad);
		
		
		$model=new Rooms;
		$result=null;
		if(isset($idRoom)&&($idRoom!=''))
		 {  $idSec = $model->find(array('alias'=>'r',
		                             'join'=>'left join levels l on(l.id=r.level)',
		                             'select'=>'l.section',
                                     'condition'=>'r.id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$sec = new Sections;
          if(isset($idSec)&&($idSec!=''))
		    {  $result=$sec->find(array('select'=>'id,section_name',
                                     'condition'=>'id=:secID',
                                     'params'=>array(':secID'=>$idSec->section),
                               ));
                               
                               
	                }
	                
	       }
		
				return $result;
}

function getLevelByStudentId($student,$acad)
{
	$idRoom= getRoomByStudentId($student,$acad);
		
		
		$model=new Rooms;
		$result=null;
		if(isset($idRoom)&&($idRoom!=''))
		 { $idLev = $model->find(array('select'=>'level',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$lev = new Levels;
            if(isset($idLev)&&($idLev!=''))
		 		{ $result=$lev->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLev->level),
                               ));
		          }
                               
		  }
		
				return $result;
}

function getRoomByStudentId($student,$acad)
{
	    
	   
		   
      $model=new RoomHasPerson;
		$idRoom = $model->find(array('select'=>'room',
                                     'condition'=>'students=:studID and academic_year=:acad',
                                     'params'=>array(':studID'=>$student,':acad'=>$acad),
                               ));
		$room = new Rooms;
         $result=null;
       if(isset($idRoom)&&($idRoom!=''))
        { $result=$room->find(array('select'=>'id,room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
        }				   

	   

						   
				return $result;
} 


 // Retourne le total d'absence pour un un eleve pour l'annee academique 
 function getTotalAbsenceByStudent($student, $aca_year){
            $model = new RecordPresence;
            $stud_ = $model->findAll(array('select'=>'presence_type, date_record',
                                      'condition'=>'student=:std AND academic_period=:acad',
                                      'params'=>array(':std'=>$student,':acad'=>$aca_year),
               ));
        $absence_number = 0;
            foreach($stud_ as $sp){
                if($sp->presence_type == 1 || $sp->presence_type == 2){
                      $absence_number++;
                  }  
             }
            return $absence_number;
        }
 
 
  // Retourne le total retard pour un un eleve pour l'annee academique 
 function getTotalRetardByStudent($student, $aca_year){
            $model = new RecordPresence;
            $stud_ = $model->findAll(array('select'=>'presence_type, date_record',
                                      'condition'=>'student=:std AND academic_period=:acad',
                                      'params'=>array(':std'=>$student,':acad'=>$aca_year),
               ));
       $retard_number = 0;
            foreach($stud_ as $sp){
                if($sp->presence_type == 3 || $sp->presence_type == 4){
                      $retard_number++;
                  }  
             }
            return $retard_number;
        }
  
   /**
         *  Total of infraction par annee
         * @param int $student
         * @param int $exam_period
         * @return int
         */
 
 function numberOfInfraction($student,$acad){
            $total = 0;
            $criteria = new CDbCriteria;
            $criteria->condition='student=:student AND academic_period=:academic_period';
            $criteria->params=array(':student'=>$student,':academic_period'=>$acad);
            $infractions = RecordInfraction::model()->findAll($criteria);
            foreach($infractions as $in){
                $total++;
            }
            return $total;
        }       
 
 
 
//############ subject average  #################
function course_average($course_id,$eval_id)
{
         $grade_array = array();
	   	   $i=0;
		   $class_average_value =0;
		   
		   $grade=Grades::model()->searchByRoom($course_id, $eval_id);
						             
				if(isset($grade)&&($grade!=null))
				 { 
				    $grade___=$grade->getData();//return a list of  objects
		                               
		               if(($grade___!=null))
						{ 
							
		           		  foreach($grade___ as $g) 
							{
								if($g->grade_value=='')
							       $grade_array[$i] = 0;
							    else
							       $grade_array[$i] = $g->grade_value;
							        	     
							
							   $i++;
							}
							
						}
						
				 }

                         if($grade_array!=null)
							$class_average_value = round(average_for_array($grade_array),2);
   
   

    return $class_average_value;
}





	//************************  loadFeeNameByLevelForScholarship ******************************/
function loadFeeNameByLevelForScholarship($level,$acad)
	{   
		 $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol'];
	       
	   	 	       	$code= array();
	    
	    
 	     $sql__ = 'SELECT f.id FROM fees f inner join fees_label fl on(f.fee=fl.id) WHERE level='.$level.' AND academic_period='.$acad.' AND f.id not in(SELECT fee_period FROM billings b inner join fees f on(b.fee_period=f.id) WHERE f.level='.$level.' AND academic_year='.$acad.')';
															
								  $command__ = Yii::app()->db->createCommand($sql__);
								  $result__ = $command__->queryAll(); 
 	       	
	      
		  if(isset($result__)&&($result__!=null))
		  {  foreach($result__ as $fee_name){
		  	      
		  	      $modelFe=Fees::model()->findByPk($fee_name['id']);
		  	       
            $name = Yii::t('app',$modelFe->fee0->fee_label).' '.$modelFe->level0->level_name.' '.$currency_symbol.' '.numberAccountingFormat($modelFe->amount);
		  	      
			    $code[$fee_name['id'] ]= $name;// ->getFeeName();
		           
		      }
		  }
		    
		return $code;
         
	}





  	

function is_decimal( $val )
{
    return is_numeric( $val ) && floor( $val ) != $val;
}

  	
	//####################  VARIANCE  ###################  

  
//(note: variance function uses the average function...)
function average_for_array($arr)
{
    if (!count($arr)) return 0;

    $sum = 0;
    for ($i = 0; $i < count($arr); $i++)
    {
        $sum += $arr[$i];
    }

    return $sum / count($arr);
}

function variance($arr)
{
    if (!count($arr)) return 0;

    
    $sum = 0;
    for ($i = 0; $i < count($arr); $i++)
    {
        $sum += $arr[$i];
    }

    $mean =  $sum / count($arr);
    
    $sos = 0;    // Sum of squares
    for ($i = 0; $i < count($arr); $i++)
    {
        $sos += ($arr[$i] - $mean) * ($arr[$i] - $mean);
    }

    return $sos / (count($arr)-1);  // denominator = n-1; i.e. estimating based on sample
                                    // n-1 is also what MS Excel takes by default in the
                                    // VAR function
}



 //####################  FIN VARIANCE  ###################   
 









	

