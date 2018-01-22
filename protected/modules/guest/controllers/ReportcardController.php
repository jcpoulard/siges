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




// always load alternative config file for examples
//require_once('/../extensions/tcpdf/config/tcpdf_config.php');
// Include the main TCPDF library (search for installation path).
//require_once('/../extensions/tcpdf/tcpdf.php');

Yii::import('ext.tcpdf.*');



class ReportcardController extends Controller
{
	
	
	
	public $layout='//layouts/column2';
	private $_model;
	
	//generale report - class average
	public $class_average;
	public $progress_student_class;
	public $progress_subject_period;
	public $repartition_grade_subject;
	public $course_id_rpt;
	public $room_id_subject_period;
	public $room_id_student_class;
	public $course_id_grade_subject;
	public $room_id_grade_subject;
	public $eval_id_grade_subject;
	
	public $eval_id_class_average;
	public $shift_id_rpt;
	public $section_id_rpt;
		
	
	public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	
	public $temoin_update=0;
	public $temoin_list;
	public $old;
	
	public $student_id;
	public $course_id;
	public $evaluation_id;
	public $evaluationDate;
        public $tot_stud;
		
    
	public $total_admit; //end year decision
	public $total_fail; //end year decision
	public $comment= array(); //end year decision
	public $comment2= array(); //end year decision, failed stud
	public $data_EYD; //end year decision
	public $data_EYD2; //end year decision, failed stud
	public $t_comment; //end year decision
	public $t_comment2; //end year decision, failed stud
	public $messageDecisionDone=false; //end year decision
	public $messageNoCheck=0; //end year decision
	public $isCheck=0; //end year decision
	public $isCheck2=0; //end year decision, failed stud
	
	
	public $extern=false;
	
	public $nb_subject= array();
	
	public $rpt_section_id;
	
	public $message=false;
	
	public $messageView=false; 
	
	public $success=false; 
	
	public $allowLink=false;
	
	public $messageEvaluation_id=false;
	
	public $messageEvaluation_id_admit=false;
        
        public $noStud = 0;
	
	public $pathLink="";
	
	public $pa_daksan= array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );



	    
	
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	public function accessRules()
	{
		      
		  $explode_url= explode("/",substr($_SERVER['REQUEST_URI'], 1));
            $controller=$explode_url[3];
            
            $actions=$this->getRulesArray($this->module->name,$controller);
              
            if($this->getModuleName($this->module->name))
                {
		            if($actions!=null)
             			 {     return array(
				              	  	array('allow',  
					                	
					                	'actions'=> $actions,
		                                  'users'=>array(Yii::app()->user->name),
				                    	),
				              		  array('deny',  
					                 	'users'=>array('*'),
				                    ),
			                );
             			 }
             			 else
             			  return array(array('deny', 'users'=>array('*')),);
                }
                else
                {
                    return array(array('deny', 'users'=>array('*')),);
                }

                
                
		
	}

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

		
		
			//for ajaxrequest
public function actionViewContact()
	{  
	    $model=new ReportCard;
        
		
       // Stop jQuery from re-initialization
       Yii::app()->clientScript->scriptMap['jquery.js'] = false;
          
	      
	         
		   $this->renderPartial('viewcontact',array(
				'model'=>$model, ),false,true);
		
		
	}	
	
	
	public function actionReport()
	{   $model=new ReportCard;
       $acad=Yii::app()->session['currentId_academic_year']; 
		  
		    
           $this->room_id=0;     
         
              //get ID of selected child  
		         if(isset($_POST['Persons']))
		           {  $pers=$_POST['Persons']['id'];
		              
		               unset(Yii::app()->session['child']);
		              //set current child variable session
					   Yii::app()->session['child']=$pers;
		            	$this->student_id=$pers;	
		            		        	           
		           }
		           else
                     $this->student_id=Yii::app()->session['child'];
                     
		      	$modelEvaluationByYear = new EvaluationByYear;
		 
		  if(isset($_POST['EvaluationByYear'])){
		  	$modelEvaluationByYear->attributes=$_POST['EvaluationByYear'];
						     $this->evaluation_id=$modelEvaluationByYear->evaluation;
		  }         
		      
		      
		        if(isset($_POST['create']))
		          { 
		          			
								


		
		          	}
		       
		   
		     

		$this->render('report',array(
			'model'=>$model,
		));
		
	}
	
	
	public function actionGeneralReport()
	{    $model=new ReportCard;
	    $modelshift = new Shifts;
	    $modelSection = new Sections;
	    $modelCourse = new Courses;
	    
	    $modelEvaluation = new EvaluationByYear;
	    $modelEvaluation1 = new EvaluationByYear;
	    
	    $modelRoom1 = new Rooms;
	    $modelRoom2 = new Rooms;
	    $modelRoom3 = new Rooms;
	    
	   
	   $progress_subject_period_set=true;
	   $progress_student_class_set=true;
	   $repartition_grade_subject_set=true;
	   	  
	    if(isset($_POST['Shifts']))
              {
              	
              	$modelshift->attributes=$_POST['Shifts'];
				   $this->shift_id_rpt=$modelshift->shift_name;
					Yii::app()->session['Shifts-rpt'] = $this->shift_id_rpt;
					
					$progress_student_class_set=false;
					$progress_subject_period_set=false;
					$repartition_grade_subject_set=false;
					 
              	}
              	
		     if(isset($_POST['Sections']))
               	{  
				   $modelSection->attributes=$_POST['Sections'];
				   $this->section_id_rpt=$modelSection->section_name;
					Yii::app()->session['Sections-rpt'] = $this->section_id_rpt;
					
					$progress_student_class_set=false;
					$progress_subject_period_set=false;
					$repartition_grade_subject_set=false;

                   					
	             }				   
				

       if(isset($_POST['ReportCard']['class_average']))
			         { $this->class_average=$_POST['ReportCard']['class_average']; 
			           
			           Yii::app()->session['class_average'] = $this->class_average;
			           
			         }
			       else
	             {
	             	 $this->class_average = Yii::app()->session['class_average'];
	               }
	                
			          
	   if(isset($_POST['ReportCard']['progress_subject_period']))
			         { $this->progress_subject_period=$_POST['ReportCard']['progress_subject_period']; 
			           
			           Yii::app()->session['progress_subject_period'] =$this->progress_subject_period;
			           
			           if($this->progress_subject_period==0)
			             $progress_subject_period_set=false;
			             
			   
			         }
			       else
	             {
	             	$this->progress_subject_period = Yii::app()->session['progress_subject_period'];
	               }
	               
	                  
	    if(isset($_POST['ReportCard']['progress_student_class']))
			         { $this->progress_student_class=$_POST['ReportCard']['progress_student_class']; 
			           
			           Yii::app()->session['progress_student_class'] =$this->progress_student_class;
			           
			           if($this->progress_student_class==0)
			             $progress_student_class_set=false;
			          
			         }
			   else
	             {
	             	$this->progress_student_class = Yii::app()->session['progress_student_class'];
	               }
	               
	                     
	     if(isset($_POST['ReportCard']['repartition_grade_subject']))
			         { $this->repartition_grade_subject=$_POST['ReportCard']['repartition_grade_subject']; 
			           
			           Yii::app()->session['repartition_grade_subject'] =$this->repartition_grade_subject;
			           
			           if($this->repartition_grade_subject==0)
			             $repartition_grade_subject_set=false;
			          
			         } 
	         else
	         {
	         	 $this->repartition_grade_subject = Yii::app()->session['repartition_grade_subject'];   
	           }
	   

	  
	   if(($this->progress_student_class==1))
	    {
			
       	 	  	
       	 	  //get ID of selected child  
		         if(isset($_POST['Persons']))
		           {  $pers=$_POST['Persons']['id'];
		              
		               unset(Yii::app()->session['stud_id11']);
		              //set current child variable session
					   Yii::app()->session['stud_id11']=$pers;	
		            		        	           
		           }
		           else
                      $this->student_id=Yii::app()->session['stud_id11'];
                     

       	 	  
              	
	   }  
	   
	   
	 if(($this->progress_subject_period==1))
	    {
			
       	 	  	
       	 	  //get ID of selected child  
		         if(isset($_POST['Persons']))
		           {  $pers=$_POST['Persons']['id'];
		              
		               unset(Yii::app()->session['stud_id22']);
		              //set current child variable session
					   Yii::app()->session['stud_id22']=$pers;	
		            		        	           
		           }
		           else
                      $this->student_id=Yii::app()->session['stud_id22'];
                     


       	 	       	 	              	
	   }
	        	
     
     if(($this->repartition_grade_subject==1))
	    {
			 if(isset($_POST['Rooms'][3]))
       	 	  {
       	 	  	   
       	 	  	   $modelRoom3->attributes=$_POST['Rooms'][3];
								   $this->room_id_grade_subject=$modelRoom3->room_name;
								   Yii::app()->session['Rooms-rpt_grade_subject']=$this->room_id_grade_subject;
			       
			       $repartition_grade_subject_set=false;
					
       	 	  }
       	 	  
			if(isset($_POST['Courses']))
       	 	  {				   
				   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id_grade_subject=$modelCourse->subject;
								   Yii::app()->session['Courses-rpt_grade_subject']=$this->course_id_grade_subject;
					               
						$repartition_grade_subject_set=false;	
       	 	  	}
       	 	  	
       	 	if(isset($_POST['EvaluationByYear'][1]))
       	 	  {
       	 	  	$modelEvaluation1->attributes=$_POST['EvaluationByYear'][1];
				   $this->eval_id_grade_subject=$modelEvaluation1->evaluation;
					Yii::app()->session['EvaluationByYear-grade-subject'] = $this->eval_id_grade_subject;
					
					$repartition_grade_subject_set=false;
       	 	  	}
       	 	
       	 	       	 	              	
	   }
    
	
	if($this->class_average==1)
	    {
			 if(isset($_POST['EvaluationByYear']))
       	 	  {
       	 	  	$modelEvaluation->attributes=$_POST['EvaluationByYear'];
				   $this->eval_id_class_average=$modelEvaluation->evaluation;
					Yii::app()->session['EvaluationByYear-class-average'] = $this->eval_id_class_average;
					
					
       	 	  	}
       	 	 else
       	 	 {
       	 	 	   //return an id(number)
		            $lastPeriod = $this->getLastEvaluationInGrade();
		            $this->eval_id_class_average = $lastPeriod;
		            
		            Yii::app()->session['EvaluationByYear-class-average'] = $this->eval_id_class_average;

       	 	 	}
       	 	 
       	 	 
              	
	   } 
	   
	   if(isset($_GET['stud1'])&&($_GET['stud1']!=0)&&($progress_student_class_set))
	    { 
	       
	       $this->class_average = Yii::app()->session['class_average'];
		   $this->progress_subject_period = Yii::app()->session['progress_subject_period'];
		   $this->repartition_grade_subject = Yii::app()->session['repartition_grade_subject'];
		   
		   
		   $this->room_id_subject_period = Yii::app()->session['Rooms-rpt_subject_period'];
		   $this->room_id_grade_subject = Yii::app()->session['Rooms-rpt_grade_subject'];
		   
		   
		   $this->course_id_grade_subject = Yii::app()->session['Courses-rpt_grade_subject'];
		   $this->eval_id_grade_subject = Yii::app()->session['EvaluationByYear-grade-subject'];
	    
	     }
	     
	   if(isset($_GET['stud2'])&&($_GET['stud2']!=0)&&($progress_subject_period_set))
	    {  
	       
	       $this->class_average = Yii::app()->session['class_average'];
		   $this->progress_student_class = Yii::app()->session['progress_student_class'];
		   $this->repartition_grade_subject = Yii::app()->session['repartition_grade_subject'];
		   
		   $this->room_id_student_class = Yii::app()->session['Rooms-rpt_student_class'];
		   
		   $this->room_id_grade_subject = Yii::app()->session['Rooms-rpt_grade_subject'];
	      
	       
	       $this->course_id_grade_subject = Yii::app()->session['Courses-rpt_grade_subject'];
		   $this->eval_id_grade_subject = Yii::app()->session['EvaluationByYear-grade-subject'];
	       
	     
	     }
	     
	  if(isset($_GET['stud3'])&&($_GET['stud3']!=0)&&($repartition_grade_subject_set))
	    { 
	       
	       $this->class_average = Yii::app()->session['class_average'];
		   $this->progress_subject_period = Yii::app()->session['progress_subject_period'];
		   $this->progress_student_class = Yii::app()->session['progress_student_class'];
		   
		   $this->room_id_student_class = Yii::app()->session['Rooms-rpt_student_class'];
		   $this->room_id_subject_period = Yii::app()->session['Rooms-rpt_subject_period'];
		   
		  
		   $this->course_id_grade_subject = Yii::app()->session['Courses-rpt_grade_subject'];
		   $this->eval_id_grade_subject = Yii::app()->session['EvaluationByYear-grade-subject'];
	       
	    
	     }
	     
			     
	 		     
					 
		$this->render('generalReport',array(
			'model'=>$model,
		
	    
	    
		));
		
		
		
	}
	
	
		
//************************  loadChildren($userName) ******************************/
	public function loadChildren($userName)
	{     
	      $acad=Yii::app()->session['currentId_academic_year']; 
		 $userid = null;
		 $code= array();
          $code[null]= null;
          
          $contact=null;
          
		 if(isset(Yii::app()->user->userid))
           $userid = Yii::app()->user->userid;
                            
           $contact_ID=ContactInfo::model()->getIdContactByUserID($userid);
	       $contact_ID= $contact_ID->getData();
					                    
			     foreach($contact_ID as $c)
					{  $contact= $c->id;
                       break;					
					}
			
			if($contact!=null)       
              {
                  $modelPerson= new Persons();
					   
					  $person=$modelPerson->findAll(array('alias'=>'p',
					                             'select'=>'p.id,p.first_name, p.last_name',
					                             'join'=>'left join contact_info c on(c.person=p.id)',
												 'condition'=>'p.is_student=1 AND p.active IN(1,2) AND (c.id=:contact OR c.one_more=:contact)',
												 'params'=>array(':contact'=>$contact),
										   ));
						
						 if(isset($person)){
						     foreach($person as $child)
							    $code[$child->id]= $child->first_name.' '.$child->last_name;
						   }	   
                }
                
                   		   
		return $code;
		
         
	}


//************************  getSubgetCoursesByRoomForGraph  ******************************/
		public function getCoursesByRoomForGraph($room_id,$acad)
	{    
       	  		 
	      $modelCourse= new Courses();
	       $result=$modelCourse->searchByRoomIdEvenIfNoGrades($room_id,$acad); 
		
			
		return $result;
         
	}



	
	
	public function getUserInfo()
	  {
	  	 $userid =null;
	  	 
	  	if(isset(Yii::app()->user->userid))
          {
               $userid = Yii::app()->user->userid;
           
           }
           
           
           $this->_model=User::model()->findbyPk($userid);
	  	
	  	return $this->_model;
	  	
	  	
	  	}



	

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

//	

	public function actionIndex()
	{
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new ReportCard('search');
		if(isset($_GET['ReportCard']))
			$model->attributes=$_GET['ReportCard'];

		$this->render('index',array(
			'model'=>$model,
		));
	}
     
	     

	
	public function actionAdmin()
	{
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new ReportCard('search');
		if(isset($_GET['ReportCard']))
			$model->attributes=$_GET['ReportCard'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	        
	
	        
	//xxxxxxxxxxxxxxxxxx             xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx

	
public function checkDecisionFinale($stud_id, $acad)
	  {
	        $command= Yii::app()->db->createCommand("SELECT * FROM decision_finale WHERE student=:studID AND academic_year=:acad");
			$command->bindValue(':studID', $stud_id);
			$command->bindValue(':acad', $acad);	
			
			$sql_result = $command->queryAll();
			
			
			   return $sql_result;
			
	  
	  }
	
	public function checkDataGeneralAverage($acad,$student,$gAverage,$level)
	  {
	        				  
			$command= Yii::app()->db->createCommand("SELECT * FROM decision_finale WHERE academic_year=:acad AND student=:student");
			$command->bindValue(':acad', $acad);	
			$command->bindValue(':student',$student );
			$sql_result = $command->queryAll();
			
			
			   return $sql_result;
			
	  
	  }
	  
	  
	//xxxxxxxxxxxxxxx STUDENT  xxxxxxxxxxxxxxxxx
	    //************************  getStudent($id) ******************************/
   public function getStudent($id)
	{
		
		$student=Persons::model()->findByPk($id);
        
			
		       if(isset($student))
				return $student->first_name.' '.$student->last_name;
		
	}
	
	
	
	//xxxxxxxxxxxxxxx CITY  NAME  xxxxxxxxxxxxxxxxx
	    //************************  getCityName($city) ******************************/
   public function getCityName($city)
	{
		
		$cities=Cities::model()->findByPk($city);
        
			
		       if(isset($cities))
				return $cities->city_name;
		
	}
	
	
	//xxxxxxxxxxxxxxx  LEVEL xxxxxxxxxxxxxxxxxxx
		//************************  loadLevelByIdShiftSectionId  ******************************/
	public function loadLevelByIdShiftSectionId($idShift,$section_id)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('select'=>'level',
                                     'condition'=>'shift=:shiftID AND section=:sectionID',
                                     'params'=>array(':shiftID'=>$idShift, ':sectionID'=>$section_id),
                               ));
			if(isset($level_id))
			 {  
			    foreach($level_id as $i){			   
					  $modelLevel= new Levels();
					   
					  $level=$modelLevel->findAll(array('select'=>'id,level_name',
												 'condition'=>'id=:levelID',
												 'params'=>array(':levelID'=>$i->level),
										   ));
						
					 if(isset($level)){
						  foreach($level as $l)
						       $code[$l->id]= $l->level_name;
					    }  
							   }						 
		    
						  }	
			
		return $code;
         
	}
	
	
		//************************  getLevelByRoomId  ******************************/
	public function getLevelByRoomId($room_id,$idSection)
	{    
       	  
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('select'=>'level',
                                     'condition'=>'id=:roomID AND section=:sectionID',
                                     'params'=>array(':roomID'=>$room_id, ':sectionID'=>$idSection),
                               ));
			if(isset($level_id))
			 {  
			    foreach($level_id as $i){			   
					  $modelLevel= new Levels();
					   
					  $level=$modelLevel->findAll(array('select'=>'id,level_name',
												 'condition'=>'id=:levelID',
												 'params'=>array(':levelID'=>$i->level),
										   ));
						
					 if(isset($level)){
						  foreach($level as $l)
						  {   
						       return $l->level_name;
							}
					    
						
						}  
							   }
                							   
		    
						  }	
			
		//return $code;
         
	}
	

	
		//************************  getLevelByIdShiftSection  ******************************/
	public function getLevelByIdShiftSection($idShift,$section,$acad)
	{    
       	  
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('select'=>'r.level',
                                     'alias'=>'r',
                                     'distinct'=>true,
                                     'join'=>'inner join level_has_person lh on(r.level=lh.level) left join levels l on(l.id=r.level)',
                                     'condition'=>'r.shift=:shiftID AND l.section=:section AND lh.academic_year=:acad',
                                     'params'=>array(':shiftID'=>$idShift, ':section'=>$section, ':acad'=>$acad),
                               ));
                               
			if(isset($level_id)&&($level_id!=''))
			 {  
			    
			    return $level_id;
			    
			  }
			else	
			  return null;
         
	}
	
	
	//************************  getRoomBySection($r, $s) ******************************/
   public function getRoomBySection($r, $s)
	{
		$room = new Rooms;
		$criteria = new CDbCriteria;
		$criteria->condition='id=:room AND section=:idSection';
		$criteria->params=array(':room'=>$r,':idSection'=>$s);
		$room=Rooms::model()->find($criteria);
        
			
		
		    if(isset($room))
				return $room->room_name;
		
	}
	
	
	//************************  getNumberOfSubjectByRoom  ******************************/
	public function getNumberOfSubjectByRoom($idSection)
	{    
       	  
	$acad=Yii::app()->session['currentId_academic_year']; //current academic year

	       $code1;
		  $code2;
          
	      $modelCourse= new Courses();
		  
        
		$result=$modelCourse->searchNumberOfSubjectByRoom($idSection,$acad);
				return $result;
				
				
	     
	}
	//************************  loadLevel ******************************/
	public function loadLevel()
	{    $modelLevel= new Levels();
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}
   //************************  getLevel($id) ******************************/
   public function getLevel($id)
	{
		$level = new Levels;
		$level=Levels::model()->findByPk($id);
        
			
		    if(isset($level))
				return $level->level_name;
		
	}
	
	//************************  getLevelByStudentId($id) ******************************/
	public function getLevelByStudentId($id)
	{
		$idRoom= $this->getRoomByStudentId($id);
		
		
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
	
	//************************  getLevelIdFromPersons ******************************/
	public function getLevelIdFromPersons()
	{    
       
	   $modelLevel=new Levels;
					
			 if(isset($_POST['ReportCard']))
		        $modelLevel->attributes=$_POST['Levels'];
		           
				   $level_id=$modelLevel->level_name;
	               
				   return $level_id;
	}
	
//xxxxxxxxxxxxxxx  ROOM xxxxxxxxxxxxxxxxxxx
	
	//************************  changeRoom ******************************/
	public function changeRoom()
	{    $modelLevel= new Levels();
           $code= array();
		   
		  if(isset($_POST['ReportCard']['Levels']))
		        $idLevel->attributes=$_POST['Levels'];
		           
				   //$idLevel=$modelLevel->level_name;
	               
				    //return $idLevel;
         
	}

	
	//************************  loadRoomByIdSection ******************************/
	public function loadRoomByIdSection($section)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
		                             'select'=>'r.id,r.room_name',
                                     'join'=>'left join levels l on(l.id=r.level)',
                                     'condition'=>'l.section=:idSection',
                                     'params'=>array(':idSection'=>$section),
                               ));
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  
			    foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	
	
	//************************  loadRoomByIdShiftSectionLevel ******************************/
	public function loadRoomByIdShiftSectionLevel($shift,$section,$idLevel)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('select'=>'id,room_name',
                                     'condition'=>'shift=:idShift AND section=:idSection AND level=:levelID ',
                                     'params'=>array(':idShift'=>$shift,':idSection'=>$section,':levelID'=>$idLevel),
                               ));
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  
			    foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	//************************  loadRoom ******************************/
	public function loadRoom()
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
   //************************  getRoomName($id) ******************************/
   public function getRoomName($id)
	{
		$room = new Rooms;
		
		$room=Rooms::model()->findByPk($id);
        
			
		
		    if(isset($room))
				return $room->room_name;
		
	}
	
	
	//************************  getRoomByStudentId($id) ******************************/
	public function getRoomByStudentId($id)
	{
		 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		   
      $model=new RoomHasPerson;
		$idRoom = $model->find(array('select'=>'room',
                                     'condition'=>'students=:studID and academic_year=:acad',
                                     'params'=>array(':studID'=>$id,':acad'=>$acad_sess),
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
	
	//************************  getRoomIdFromReportCard ******************************/
	public function getRoomIdFromReportCard()
	{    
       
	   $modelRoom=new Rooms;
					
			 
		        $modelRoom->attributes=$_POST['Rooms'];
		           
				   $id=$modelRoom->room_name;
		
				   return $id;
	}
		 

	 //xxxxxxxxxxxxxxx  SHIFT xxxxxxxxxxxxxxxxxxx
	//************************  loadShift ******************************/
	public function loadShift()
	{    $modelShift= new Shifts();
           $code= array();
		   
		  $modelPersonShift=$modelShift->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    foreach($modelPersonShift as $shift){
			    $code[$shift->id]= $shift->shift_name;
		           
		      }
		   
		return $code;
         
	}
   //************************  getShift($id) ******************************/
   public function getShift($id)
	{
		
		$shift=Shifts::model()->findByPk($id);
        
			
		      if(isset($shift))
				return $shift->shift_name;
		
	}
	
	//************************  getShiftByStudentId($id) ******************************/
	public function getShiftByStudentId($id)
	{
		
		$idRoom= $this->getRoomByStudentId($id);
		
		
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
	
	//************************  getShiftIdFromPersons ******************************/
	public function getShiftIdFromPersons()
	{    
       
	   $modelShift=new Shifts;
					
			 if(isset($_POST['ReportCard']))
		        $modelShift->attributes=$_POST['Shifts'];
		           
				   $shift_id=$modelShift->shift_name;
	               
				   return $shift_id;
	}
	
	
	
	
	        //xxxxxxxxxxxxxxx  SECTION  xxxxxxxxxxxxxxxxxxx
	
	//************************  loadSectionByIdShift ******************************/
	public function loadSectionByIdShift($idShift)
	{     
	      $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $section_id=$modelRoom->findAll(array('alias'=>'r',
	                                 'select'=>'sec.id, sec.section_name',
                                     'join'=>'left join levels l on(l.id=r.level) left join sections sec on(l.section=sec.id)',
	                                 'condition'=>'r.shift=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift),
                               ));
	
	if(isset($section_id))
			 {  
			    foreach($section_id as $i)
			     {			   
					$code[$i->id]= $i->section_name;
			      }	   
			  }						 
		   
		return $code;
		$this->section_id=null;
         
	}
	
	//************************  loadSection ******************************/
	public function loadSection()
	{    $modelSection= new Sections();
           $code= array();
		   
		  $modelPersonSection=$modelSection->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonSection))
			 {  foreach($modelPersonSection as $section){
			        $code[$section->id]= $section->section_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	//************************  loadSectionForGR ******************************/
	public function loadSectionForGR()
	{    $modelSection= new Sections();
           $code= array();
		   
		  $modelPersonSection=$modelSection->findAll();
            //$code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonSection))
			 {  foreach($modelPersonSection as $section){
			        $code[$section->id]= $section->section_name;
		           
		           }
			 }
		   
		return $code;
         
	}
   //************************  getSection($id) ******************************/
   public function getSection($id)
	{
		
		$section=Sections::model()->findByPk($id);
        
			
		       if(isset($section))
				return $section->section_name;
		
	}
	
	//************************  getSectionByStudentId($id) ******************************/
	public function getSectionByStudentId($id)
	{
		$idRoom= $this->getRoomByStudentId($id);
		
		
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
	
		
	
	//************************  getSectionIdFromPersons ******************************/
	public function getSectionIdFromPersons()
	{    
       
	   $modelSection=new Sections;
					
			 if(isset($_POST['ReportCard']))
		        $modelSection->attributes=$_POST['Sections'];
		           
				   $this->section_id=$modelSection->section_name;
	               
				   return $this->section_id;
	}
	
	
	
	//xxxxxxxxxxxxxxx  SUBJECTS xxxxxxxxxxxxxxxxxxx
		//************************  loadSubject  ******************************/
  public function loadSubject($room_id,$level_id)
	 {    
       	  

        $acad=Yii::app()->session['currentId_academic_year']; //current academic year
          $code= array();
          $code[null][null]= Yii::t('app','-- Select --');
		  
		 $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseByRoom($room_id,$level_id,$acad);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			            //$k is a counter
						$k=0;
			    foreach($Course as $i){			   
					  
					  $code[$k][0]= $i->id;
					  $code[$k][1]= $i->subject_name;
					  $code[$k][2]= $i->weight;
					  $code[$k][3]= $i->subject_parent;
					  $k=$k+1;
					  
				}  
			 }	 					 
		      
			
		  return $code;
         
	  }
	
		
	//************************  loadSubject by room_id in report  ******************************/
		public function loadSubjectByRoomInReport($room_id,$acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		
		  
		  
	      $modelCourse= new Courses();
	       $result=$modelCourse->searchByRoomIdInReport($room_id,$acad); 
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	

	
//************************  isSubjectEvaluated($subject_id,$room,$period_id)  ******************************/	
	public function isSubjectEvaluated($course_id,$room,$period_id)
	{    
       	  
                $bool=false;
		  
		 $modelCourse= new Courses();
	       $result=$modelCourse->evaluatedSubject($course_id,$room,$period_id);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			            //$k is a counter
						$k=0;
						
			    foreach($Course as $i){			   
					  
					  
					  if($i->id!=null)
					       $bool=true;
					  					  
				}  
			 }	 					 
		      
			
		return $bool;
         
	}
	
	
	//xxxxxxxxxxxxxxx  EVALUATIONS xxxxxxxxxxxxxxxxxxx
		//************************  loadEvaluation  ******************************/
	public function loadEvaluation()
	{    
       	  	  
	$acad=Yii::app()->session['currentId_academic_year']; //current academic year

	$code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=$modelEvaluation->searchIdName($acad);
			
		   
			 if(isset($result))
			  {  $r=$result->getData();//return a list of  objects
			    foreach($r as $i){			   
					  $code[$i->id]= $i->name_period.' / '.$i->evaluation_date;
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	


		//************************  loadEvaluationReportcardDone  ******************************/
	public function loadEvaluationReportcardDone()
	{    
       	  	  
	$acad=Yii::app()->session['currentId_academic_year']; //current academic year

	$code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=$modelEvaluation->searchIdNameReportcardDone($acad);
			
		   
			 if(isset($result))
			  { 
			    foreach($result as $i){	
			    	 $code[$i['id_eval_year']]= $i['name_period'].' / '.$i['evaluation_date'];//$i->evaluation_name.' ('.$i->evaluation_date.')';
				}  
			 }	 					 
		      
			
		return $code;
         
	}


	
	//************************  getLastEvaluationInGrade  ******************************/
	public function getLastEvaluationInGrade()
	{    //return an id(number)
       	  	  
	$acad=Yii::app()->session['currentId_academic_year']; //current academic year

	$code='';
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=$modelEvaluation->searchLastEvaluationInGrade($acad);
			
		   
			 if(isset($result))
			  {  $r=$result->getData();//return a list of  objects
			    foreach($r as $i){			   
					  $code= $i->id;
					  
					  break; //to have only the 1st result which is the last
				}  
			 }	 					 
		      
			
		return $code;
         
	}

		
	
	//************************  getEvaluationPeriod  ******************************/
	public function getEvaluationPeriod($id)
	  {
	     $evalByYear=new EvaluationByYear();
		    $eYear=$evalByYear->findByPk($id);
        $result='';
			
		       if(isset($eYear))
			    { $evalId=$eYear->evaluation;
				    $result=Evaluations::model()->findByPk($evalId);
					
					
				 }
				return $result->evaluation_name;
	  
	  }
	
	//Method to take the passing grade from the database 
	
	public function getPassingGrade($id_level, $id_academic_period)
	{
		$criteria = new CDbCriteria;
		$criteria->condition='level=:idLevel AND academic_period=:idAcademicLevel';
		$criteria->params=array(':idLevel'=>$id_level,':idAcademicLevel'=>$id_academic_period);
		$pass_grade = PassingGrades::model()->find($criteria);
	 
	  if(isset($pass_grade))
	  return $pass_grade->minimum_passing; 
	  else 
	    return null;
	} 
	
	public function getAcademicPeriodName($acad,$room_id)
	  {    
	        $result=ReportCard::getAcademicPeriodName($acad,$room_id);
                if($result!=null)
                    return $result;
                    else
                        return null;
	  }
	  
   
   
   
    public function searchPeriodName($evaluation)
	   {
	   	    $result=ReportCard::searchPeriodNameForReportCard($evaluation);
                if($result)
                    return $result->name_period;
                    else
                        return null;
	   }
	
	//XXXXXXXXXXXXXXXXXXXXXXXXXXX   GENERAL REPORT	XXXXXXXXXXXXXXXXXXXXXXXXXXXXX
	public function searchStudentsBySection($sec_id)
	  {
             	  
		  $modelRoomHasPerson= new RoomHasPerson();
	      $result= $modelRoomHasPerson->searchStudents_($sec_id);
		   
		  		
		     return $result;
		 
	     }
	
	public function searchTeachersBySection($sec_id)
	  {	  
		  
	$acad=Yii::app()->session['currentId_academic_year']; //current academic year

	
		$teach = new Courses;
        
		$result=$teach->searchTeachersBySection($sec_id,$acad);
				return $result;
		  
	}
	
	
	  

public function getClassAverageForReport($level,$eval, $acad)
    {  
	    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($acad!=$current_acad->id)
         $condition = '';
      else
         $condition = 'p.active IN(1,2) AND ';
      


	  
	  	  
	   $modelRoom= new Rooms;
	   $result=$modelRoom->find(array('alias'=>'r',
	                                 'select'=>'r.id',
	                                 'distinct'=>true,
                                     'join'=>'left join level_has_person lh on(r.level=lh.level) ',
									 'condition'=>'lh.level=:lev AND lh.academic_year=:acad',
                                     'params'=>array(':lev'=>$level,':acad'=>$acad),
                               )); 
		$level=null;					   
		
	    $data= array();
		$nb_room=0;
		
		$tot_female=0; 
		$tot_male=0;
		
		$classTotalAverage_female=0;
		$classTotalAverage_male=0;
   		$classTotalAverage=0;
   		

		
		if(isset($result))	
           {  
   		     //average for each room
   		          		     
   		     foreach($result as $room)
   		      {
		   		   if($room!=null)
		   		    {       $nb_room++;
		   		        
		   		          $id_room=$room;
		   		          //total of student for this room
							$tot_stud=0;
							$dataProvider_studentEnrolled=Rooms::model()->getStudentsEnrolled($condition,$id_room, $acad);
								  if(isset($dataProvider_studentEnrolled))
								    {  $t=$dataProvider_studentEnrolled->getData();
									   foreach($t as $tot)
									    {
									       $tot_stud=$tot->total_stud;
									    }
									}
									
						$male=0;
						$female=0;
						$average_male=0;
						$average_female=0;	
					
							//average for this room
							$classAverage=0;
							$dataProvider_student=Persons::model()->getStudentsByRoomForGrades($condition,$id_room, $acad);
								  if(isset($dataProvider_student))
								    {  $stud=$dataProvider_student->getData();
									   foreach($stud as $student)
									     { 
									     	
									     	
									     	
										  $average =0;
										  
											$average = $this->getAverageForAStudent($student->id, $id_room, $eval, $acad);
											//return a number
											
											 $classAverage +=$average;
												
											  if($student->gender==1)
										     	 {
										     	 	  $female++;
										     	 	  $average_female+=$average;
										     	 	}
										     	elseif($student->gender==0)
										     	  {
										     	  	  $male++; 
										     	  	  $average_male+=$average;
										     	  	   
										     	  	}
											  
										  }
										  
										  
									}		
							
						if($tot_stud!=0)
						  	$classAverage=round(($classAverage/$tot_stud),2);
						      
						      if($female!=0)
						        $average_female=round(($average_female/$female),2);
						      
						      if($male!=0)
						        $average_male=round(($average_male/$male),2);
						      
						        $tot_female += $female; 
								$tot_male += $male;
						      
						    
							
							$classTotalAverage=$classTotalAverage + $classAverage;
							
							$classTotalAverage_female=$classTotalAverage_female + $average_female;
							
							$classTotalAverage_male=$classTotalAverage_male + $average_male;	
							
			    	 					
		   		            }
		   		        
   		        }
   		        
   		        if($nb_room > 1)
   		         {  $classTotalAverage = round(($classTotalAverage/$nb_room),2);
   		         
   		            $classTotalAverage_female=round(($classTotalAverage_female/$tot_female),2);
   		            
   		            $classTotalAverage_male=round(($classTotalAverage_male/$tot_male),2);
   		            
   		           }
   		           
   		   
   		           

			 }
		
		
				 
		  $data["class_average"]= $classTotalAverage;
		  $data["female_average"]= $classTotalAverage_female;
		  $data["male_average"]= $classTotalAverage_male;
		  $data["tot_female"]= $tot_female;
		  $data["tot_male"]= $tot_male;
		 
		  
	    return $data;
	    
	    
	}



public function getAverageForAStudent($student, $room, $evaluation, $acad)
    {  //return value: average
	   
      $acad=Yii::app()->session['currentId_academic_year']; 
      
      $average_base = 0;
      //Extract average base
         $average_base = infoGeneralConfig('average_base');
    

    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($acad!=$current_acad->id)
        { $condition = '';
          $condition1 = '';
        }
      else
        { $condition = 'p.active IN(1,2) AND ';
          $condition1 = 'teacher0.active IN(1,2) AND ';
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
							if($grade->publish==1)
							 {
							
							$tot_grade=$tot_grade+$grade->grade_value;
							$max_grade=$max_grade+$course->weight;
							 }
							else
								  break;
																																	 
																	   
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

	
	
	
	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=ReportCard::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='ReportCard-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	
 public function if_all_grades_validated($student,$evaluation)
  {
  	       $there_is=true;
  	       
  	        $gradesInfo= Grades::model()->ifAllGradesValidated($student,$evaluation);
  	        
  	        if(isset($gradesInfo))
			  {
				 $r=$gradesInfo->getData();
														
					foreach($r as $grade)
					 {
					 	if($grade->validate==0)
					 	  $there_is=false;
					 }
					 
					 
			  }
			  else
			     $there_is=false;
			     
			     
	
	       return $there_is;
  
  
  }
  
  
  public function if_all_grades_published($condition,$student,$evaluation)
  {
  	       $there_is=true;
  	       
  	        $gradesInfo= Grades::model()->ifAllGradesValidatedPublished($condition,$student,$evaluation);
  	        
  	        if(isset($gradesInfo))
			  {
				 $r=$gradesInfo->getData();
														
					foreach($r as $grade)
					 {
					 	if($grade->publish==0)
					 	  $there_is=false;
					 }
					 
					 
			  }
			  else
			     $there_is=false;
			     
			     
	
	       return $there_is;
  
  
  }

	

	//************************  getStudentAverageInfo($stud,$room,$level, $shift, $section,$eval,$acad) ******************************/
	
	// return values: $tot_grade; $average; $place
 public function getStudentAverageInfo($stud,$room,$level, $shift, $section,$eval,$acad)
	{
		
		
		$average_base=0;
		//Extract average base
                                $criteria3 = new CDbCriteria;
                                $criteria3->condition='item_name=:item_name';
				   				$criteria3->params=array(':item_name'=>'average_base',);
				   				$average_base = GeneralConfig::model()->find($criteria3)->item_value;
				   				
		
		  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
		     if($acad!=$current_acad->id)
		         $condition = '';
		      else
		         $condition = 'p.active IN(1,2) AND ';
      


		 
		 $result[null]= null;
		
			$dataProvider1=$this->loadSubject($room,$level,$acad);
										   
												   $k=0;
												   $tot_grade=0;
                                                   $place=0;
												   
                               
												   $max_grade=0;
                        $position = Grades::model()->searchForPosition($condition,$eval, $shift, $section, $level, $room);
                                            
										
										$old_maxValue=0;
											$old_place=0;
											$position_to_placecode= array();
											$position_to_placecode[null][null]= null;
										   $j = 1;
										   $compteur = 0;
										  if(isset($position))
										    {
											  $r=$position->getData();
														
												foreach($r as $pos)
												  {
												    $position_to_placecode[$compteur][0]= $pos->student ;
													if($pos->max_grade===$old_maxValue)
													   $position_to_placecode[$compteur][1]= $old_place;
													else
													  { $position_to_placecode[$compteur][1]= $j;
														   $old_place=$j;
													   }
													   
												  $compteur++;
												  $old_maxValue=$pos->max_grade;
												  $j=$j+1; 	
												  
												 }
										     }
										   
							
							                 for($jj = 0; $jj<$compteur; $jj++)
									       {
                                                       
										     if($position_to_placecode[$jj][0]===$stud)
										           {
                                                         $place = $position_to_placecode[$jj][1]; 
                                                                                                               
                                                    }
                                                    			                                
                                              }

                                    $point2Note=false;
													    while(isset($dataProvider1[$k][0])){
													      
													       $careAbout=$this->isSubjectEvaluated($dataProvider1[$k][0],$room,$eval);         
													                   
													  if($careAbout)                
													     {  //somme des coefficients des matieres
													           $max_grade=$max_grade+$dataProvider1[$k][2];
													     
													     } 
													     
													     $grades=Grades::model()->searchForReportCard($condition,$stud,$dataProvider1[$k][0], $eval);
                                                               $_grade=0;														  
														   if(isset($grades)){
														       $r=$grades->getData();//return a list of  objects
														     foreach($r as $grade) {
														       
														
														       $point2Note=false;
														         
														         if($grade->grade_value!=null)
														           {
															             $tot_grade=$tot_grade+$grade->grade_value;   //somme des notes obtenues par matieres
															          
															          
															               
														           }
														          else //pas de notes
                                                               {
                                                               	   $point2Note=true;
                                                               	}
                                                        
                                                               
															   
															   }
                                                                                                                           
                                                               }
                                                             else //pas de notes
                                                               {
                                                               	   $point2Note=true;
                                                               	}
													          	 
														$k=$k+1;
														}
														
								$average=-1;
								if($point2Note)
								   $max_grade=0;
								  
								if(($average_base ==10)||($average_base ==100))
		                          { if($max_grade!=0) 
		                                $average=round(($tot_grade/$max_grade)*$average_base,2);
		                          }
		                         else
		                           $average=null;
																			
														
								$result[0]= $tot_grade;
								$result[1]= $max_grade;
								$result[2]= $average;
								$result[3]= $place;
								
								
				return $result;

		
	}
	
	
	
	
	
	
	
	
}











