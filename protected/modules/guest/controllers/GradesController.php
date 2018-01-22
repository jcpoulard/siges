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



//
Yii::import('ext.tcpdf.*');



class GradesController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	public $student_id;
	
	
	
	public $idAcademicP;
	
	public $temoin_update=0;
	public $temoin_list;
	public $old;
	
	public $course_id;
	public $evaluation_id;
	public $evaluationDate;
	
	public $message_room_id=false;
	public $message_course_id=false; 
	public $message_evaluation_id=false;
	public $success=false;
	
	public $extern=false;
	
	
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



	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
		 
			
		    
           $this->room_id=0;     
         
             $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                          $group_name=$group->group_name;
            if($group_name=='Student')
              {
                   $user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
              }
            elseif($group_name=='Parent')	    
		      {  //get ID of selected child  
		         if(isset($_POST['Persons']))
		           {  $pers=$_POST['Persons']['id'];
		              
		               unset(Yii::app()->session['child']);
		              //set current child variable session
					   Yii::app()->session['child']=$pers;
		            	$this->student_id=$pers;	
		            		        	           
		           }
		           else
                     $this->student_id=Yii::app()->session['child'];
		        }
                     
                          
        if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}        
                
                
			$model=new Grades('searchByStudentId');
			
			$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Grades']))
			{ $model->attributes=$_GET['Grades'];
                
			}
       

		$this->render('index',array(
			'model'=>$model,
		));
	}
        
        
        // Export to CSV 
        public function behaviors() {
           return array(
               'exportableGrid' => array(
                   'class' => 'application.components.ExportableGridBehavior',
                   'filename' => Yii::t('app','grades.csv'),
                   'csvDelimiter' => ',',
                   ));
        }
     
	
	public function actionAdmin()
	{
		$model=new Grades('search');
		if(isset($_GET['Grades']))
			$model->attributes=$_GET['Grades'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	        
	
	
	
//************************  loadChildren($userName) ******************************/
	public function loadChildren($userName)
	{     
	     
		 $userid = null;
		 $code= array();
          $code[null]= Yii::t('app','-- Select --');
          
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


	
	public function getAverageForAStudent($student, $room, $evaluation, $acad)
    {
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
		
		$dataProvider_Course=Courses::model()->searchCourseByRoomId($room, $acad);
										   
			 $k=0;
			$tot_grade=0;
                                                   
			$max_grade=0;

											           
		  if(isset($dataProvider_Course))
		   { $r=$dataProvider_Course->getData();//return a list of  objects
			foreach($r as $course) 
			 {					
				
				$grades=Grades::model()->searchForReportCard($student,$course->id, $evaluation);
																			  
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
                                                                                                                
             
		 if($max_grade!=0)
     		$average=round(($tot_grade/$max_grade)*100.00,2);


	    return $average;
	}
	
	
	
	public function getClassAverage($room, $acad)
    {
	  

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
		
		//total of student for this room
		$tot_stud=0;
		$dataProvider_studentEnrolled=Rooms::model()->getStudentsEnrolled($this->room_id, $acad);
			  if(isset($dataProvider_studentEnrolled))
			    {  $t=$dataProvider_studentEnrolled->getData();
				   foreach($t as $tot)
				       $tot_stud=$tot->total_stud;
				}
		//list of students for this room
		$classAverage=0;
		$dataProvider_student=Persons::model()->getStudentsByRoomForGrades($this->room_id, $acad);
			  if(isset($dataProvider_student))
			    {  $stud=$dataProvider_student->getData();
				   foreach($stud as $student)
				     { 
					   $averag=$this->getAverageForAStudent($student->id, $this->room_id, $this->evaluation_id, $acad);
					   if(isset($averag))
					     { 
						    $classAverage +=$averag;
						 }
					  
					  }
					  
					  
				}
				
		
	    return $classAverage;
	}
	
	
	//xxxxxxxxxxxxxxx  SUBJECTS xxxxxxxxxxxxxxxxxxx
		//************************  loadSubject by room_id and level_id  ******************************/
	public function loadSubject($room_id,$level_id,$acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseByRoom($room_id,$level_id,$acad);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' '.$i->teacher_name.' '.$i->name_period;
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	
	public function getAllSubjects($room_id,$level_id)
	{   
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

          $code= array();
          $code[null][null]= Yii::t('app','-- Select --');
		  
		 $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseByRoom($room_id,$level_id,$acad_sess);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			            //$k is a counter
						$k=0;
			    foreach($Course as $i){			   
					 
					  $code[$k][0]= $i->id;
					  $code[$k][1]= $i->subject_name;
					  $code[$k][2]= $i->weight;
					  $k=$k+1;
					  
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
	
	
	
	//************************  loadSubject by room_id  ******************************/
		public function loadSubjectByRoom($room_id,$acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		
		  
		  
	      $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseByRoomId($room_id,$acad); 
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' '.$i->teacher_name.' '.$i->name_period;
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	
	
	//xxxxxxxxxxxxxxx  EVALUATIONS xxxxxxxxxxxxxxxxxxx
		//************************  loadEvaluation  ******************************/
	public function loadEvaluation($acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=$modelEvaluation->searchIdName($acad);
			
		   
			 if(isset($result))
			  {  $r=$result->getData();//return a list of  objects
			    foreach($r as $i){			   
					  $code[$i->id]= $i->evaluation_name.' ('.$i->name_period.'/'.$i->evaluation_date.')';
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
	

	public function getAcademicPeriodName($acad,$room_id)
	  {    
	        $result=ReportCard::getAcademicPeriodName($acad,$room_id);
                if($result!=null)
                    return $result;//->name_period;
                    else
                        return null;
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



    
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Grades::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='grades-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
