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



Yii::import('ext.tcpdf.*');


class SchedulesController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	public $idAcademicP;
	public $idAcademicP_hold;
	public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	
	public $allowLink=false;
	public $temoin_data=false;
	public $different=false; // pou chanjman ane akademik yo		
	
	public $success=false;
		
	public $pathLink="";
	
	public $messageidAcademicP=false;
	public $messageNoSchedule=false;
	
	

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

	public function actionCreate()
	{
		$flag=false;
		$flag1=false;
		$teacher_dispo=true;
		$idAcademicPeriod=null; 
		$nameAcademicPeriod=null;
		
		$model=new Schedules;
		$room_id=null;
		 
		$temoin1=null;
		$error=false;
		  
		
            
		   //saisie de l'annee academic en cours
		  $idAcademicPeriod=Yii::app()->session['currentId_academic_year'];  
		  $nameAcademicPeriod=Yii::app()->session['currentName_academic_year'];
		  
		   if(isset($_POST['Schedules']))
			{ 
 			  $this->performAjaxValidation($model);
			        $model->attributes=$_POST['Schedules'];
			         
			
            if(isset($_POST['create']))
			{ 			
					 					
						//verifier les hres
							
						$room=Rooms::model()->getRoomByIdCourse($model->course, $idAcademicPeriod);
						if(isset($room))
						 {	$rooms=$room->getData();
						  foreach($rooms as $r)
						     $room_id=$r->id;
						  } 
						   
						//tout le ki nan schedules pou jou nan salle la
						$times=$this->getTimesForSpecificDay($room_id, $model->day_course, $idAcademicPeriod);
						   //tcheke disponibilite l'hre$shift_time_start
						if(isset($times))
						 {	$times=$times->getData();
						    
							//verifye ke substr($model->time_start,0,5) >= substr(shift->time_start,0,5)
							//verifye ke substr($model->time_end,0,5) >= substr(shift->time_end,0,5)
							$shift_time_start= null;
						    $shift_time_end = null;
							
							$timeShift=Shifts::model()->searchTimesByRoomId($room_id);
							if(isset($timeShift))
						      { $ts=$timeShift->getData();
							     foreach($ts as $t)
						           { 
                                                                          $shift_time_start = $t->time_start;
									  $shift_time_end = $t->time_end;
								    }
							   
							  }
						  if((substr($shift_time_start,0,5)<=substr($model->time_start,0,5))&&(substr($model->time_end,0,5)<=substr($shift_time_end,0,5))&&(substr($shift_time_end,0,5)>substr($model->time_start,0,5)))
							 {
							
							       
							
							  foreach($times as $hres)
							   {  
									  
								if((substr($hres->time_start,0,5)<substr($model->time_start,0,5))&&(substr($model->time_start,0,5)<substr($hres->time_end,0,5)))
								 {	
								     $params=array();
									 $message = Yii::t('app','<b>ERROR_1 : Right overlapping! Time is not available on this day.</b>.');
									$model->getMessage('', $message, $params);	
														   
									
									  $error=true;
									  $teacher_dispo=false;
										  break;	break;break;												   
								 }
								 elseif((substr($hres->time_start,0,5)<substr($model->time_end,0,5))&&(substr($model->time_end,0,5)<substr($hres->time_end,0,5)))
									{  
									    $params=array();
										$message = Yii::t('app','<b>ERROR_2 : Left overlapping! Time is not available on this day.</b>.');
										$model->getMessage('', $message, $params);	
														   
										 
											$error=true;
											$teacher_dispo=false;
											  break;break;break;													   
									}
								elseif(((substr($hres->time_start,0,5)>=substr($model->time_start,0,5))&&(substr($model->time_end,0,5)>=substr($hres->time_end,0,5)))||((substr($hres->time_start,0,5)<=substr($model->time_start,0,5))&&(substr($model->time_end,0,5)<=substr($hres->time_end,0,5))))
								   { 
								      $params=array();
									  $message = Yii::t('app','<b>ERROR_3 : Overlapping! Time is not available on this day.</b>.');
									  $model->getMessage('', $message, $params);
									  
									  $error=true;
									  $teacher_dispo=false;
									   break;break;break;
									   
								 }
								elseif((substr($hres->time_start,0,5)===substr($model->time_start,0,5))&&(substr($model->time_end,0,5)===substr($hres->time_end,0,5)))
								  {  
								     $params=array();
									  $message = Yii::t('app','<b>ERROR_4 : Time is not available on this day.</b>.');
									  $model->getMessage('', $message, $params);
									  
									  $error=true;
									  $teacher_dispo=false;
									   break;break;break;
									   
								 }
								
							   
							   }
						  
						  }
						 else
						   {
						       $params=array();
									  $message = Yii::t('app','<b>ERROR_5 : Overlapping shift time.</b>.');
									  $model->getMessage('', $message, $params);
									  
									  $error=true;
									  $teacher_dispo=false;
									   					   
							   
						   }
						 
					   }
               
                 if($teacher_dispo==true)// le a disponib
				    {     
					       //return an array(id, subject_name, subject_parent)  
							$info_subject = Subjects::model()->getSubjectByCourseId($model->course);
                           
                            $subject_id =  '';
                            
                            foreach($info_subject as $info_subj) 
                             { $subject_id = $info_subj['id'];  break;
                             }
					       
					        
					         //disponibilite teacher
						      $teacher=Courses::model()->getTeacherByIdCourse($model->course,$idAcademicPeriod);
								    $teacher=$teacher->getData();
								    if($teacher<>NULL)
								      { foreach($teacher as $t) 
									      $teacher=$t->teacher;
										}
								 
								   $teacherC=Schedules::model()->getCoursesForTeacherByRoomAndDay($teacher, $model->day_course, $idAcademicPeriod);
								   $teacherCourses=$teacherC->getData();//return a list of  objects
								   if($teacherCourses<>NULL)
								      { 
									    
									    foreach($teacherCourses as $course) // pou chak kou ke nou jwenn
									       {  
										       //verifye le a pou we si teacher pa oqp
											   if((substr($course->time_start,0,5)<substr($model->time_start,0,5))&&(substr($model->time_start,0,5)<substr($course->time_end,0,5)))
												 {	
												     $params=array();
													 $message = Yii::t('app','<b>ERROR_1 : The choosen teacher is not available at this time. </b>.');
													$model->getMessage('', $message, $params);	
																		   
													//$chevauchement=true;
													  $error=true;
													  $teacher_dispo=false;
														  break;	break;break;												   
												 }
												 elseif((substr($course->time_start,0,5)<substr($model->time_end,0,5))&&(substr($model->time_end,0,5)<substr($course->time_end,0,5)))
													{   
													   $params=array();
														$message = Yii::t('app','<b>ERROR_2 : The choosen teacher is not available at this time. </b>.');
														$model->getMessage('', $message, $params);	
																		   
														 // $chevauchement=true;
															$error=true;
															$teacher_dispo=false;
															  break;break;break;													   
													}
												elseif(((substr($course->time_start,0,5)>=substr($model->time_start,0,5))&&(substr($model->time_end,0,5)>=substr($course->time_end,0,5)))||((substr($course->time_start,0,5)<=substr($model->time_start,0,5))&&(substr($model->time_end,0,5)<=substr($course->time_end,0,5))))
												   {  
												      $params=array();
													  $message = Yii::t('app','<b>ERROR_3 : The choosen teacher is not available at this time. </b>.');
													  $model->getMessage('', $message, $params);
													  
													  $error=true;
													  $teacher_dispo=false;
													   break;break;break;
													   
												 }
												elseif((substr($course->time_start,0,5)===substr($model->time_start,0,5))&&(substr($model->time_end,0,5)===substr($course->time_end,0,5)))
												  {  
												      $params=array();
													  $message = Yii::t('app','<b>ERROR_4 : The choosen teacher is not available at this time. </b>.');
													  $model->getMessage('', $message, $params);
													  
													  $error=true;
													  $teacher_dispo=false;
													   break;break;break;
													   
												 }
											   
										   }
										
									  
									  
									  }	
									  
					           
									  
									  
					
					}
				if($teacher_dispo) //le a bon, teacher a disponib
				  {       
						$model->setAttribute('date_created',date('Y-m-d'));
					 $model->setAttribute('date_updated',date('Y-m-d'));
								
						if($model->save())
						 {  
							$course=Courses::model()->findByPk($model->course);
							
								if(isset($course))
								 { $this->room_id=$course->room;
								  
								 }
							
							
							if(isset($_GET['emp'])&&($_GET['emp']!=""))
				             {   
				                  $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['emp'],'isstud'=>0,'from'=>'teach'));
				               }
				            else
							  $this->redirect(array('viewForUpdate','room'=>$this->room_id));
											
						  }
					 
				  }
				  
				  
			}
			
			 if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
			
			
			}
		   $this->render('create',array('model'=>$model,));
	  }	   
	
	
	
	//for ajaxrequest
public function actionAddCourse()
	{  
	    $model=new Schedules;
		
		  //saisie de l'annee academic en cours
		  $idAcademicPeriod=Yii::app()->session['currentId_academic_year'];  
		  $nameAcademicPeriod=Yii::app()->session['currentName_academic_year'];
		

	
	  if(isset($_POST['Courses']))
		{   
			    
				
				$day=$_GET['day'];
				 $room=$_GET['room'];
                 $t_start=$_GET['t_start'];
				 $t_end=$_GET['t_end'];
				 
				$teacher1=null;
				
				$teacher_dispo=true;
				
			 
 		 if(isset($_POST['createCourse']))
		   {    
						
					//test overlaping
				 //tout le ki nan schedules pou jou nan salle la
				$times=$this->getTimesForSpecificDay($room, $day, $idAcademicPeriod);
				
				
				
				 //tcheke disponibilite l'hre$shift_time_start
				if(isset($times))
				  {  $times=$times->getData();						
				   foreach($times as $hres)
					{   
					   if((substr($hres->time_start,0,5)<substr($t_start,0,5))&&(substr($t_start,0,5)<substr($hres->time_end,0,5)))
							 {
								 
								 $params=array();
								 $message = Yii::t('app','<b>ERROR_1 : Right overlapping! Time is not available on this day.</b>.');
								$model->getMessage('', $message, $params);	
                                                       
								
								  $error=true;
								  $teacher_dispo=false;
                                      break;	break;break;												   
							 }     
							 elseif((substr($hres->time_start,0,5)<substr($t_end,0,5))&&(substr($t_end,0,5)<substr($hres->time_end,0,5)))
								{
								   
								   $params=array();
									$message = Yii::t('app','<b>ERROR_2 : Left overlapping! Time is not available on this day.</b>.');
									$model->getMessage('', $message, $params);	
                                                       
									
									    $error=true;
										$teacher_dispo=false;
                                          break;break;break;													   
								}
							elseif(((substr($hres->time_start,0,5)>=substr($t_start,0,5))&&(substr($t_end,0,5)>=substr($hres->time_end,0,5)))||((substr($hres->time_start,0,5)<=substr($model->time_start,0,5))&&(substr($model->time_end,0,5)<=substr($hres->time_end,0,5))))
				               {  
							      $params=array();
								  $message = Yii::t('app','<b>ERROR_3 : Overlapping! Time is not available on this day.</b>.');
								  $model->getMessage('', $message, $params);
								  
								  $error=true;
								  $teacher_dispo=false;
								   break;break;break;
								   
							 }
							elseif((substr($hres->time_start,0,5)===substr($t_start,0,5))&&(substr($t_end,0,5)===substr($hres->time_end,0,5)))
							  {  
							      $params=array();
								  $message = Yii::t('app','<b>ERROR_4 : Time is not available on this day.</b>.');
								  $model->getMessage('', $message, $params);
								  
								  $error=true;
								  $teacher_dispo=false;
								   break;break;break;
								   
							 }
					   
                         }
						 
						
                     }						 
				    //il faut verifier si le Teacher n'a pas deja un autre cours a cette heure
								 //__________________
								
						if($teacher_dispo==true)		
							{	
								//return an array(id, subject_name, subject_parent)  
								$info_subject = Subjects::model()->getSubjectByCourseId($model->course);
	                           
	                            $subject_id =  '';
	                            
	                            foreach($info_subject as $info_subj) 
	                             { $subject_id = $info_subj['id'];  break;
	                             }
						       
						       
								   $teacher=Courses::model()->getTeacherByIdCourse($model->course,$idAcademicPeriod);
								    $teacher=$teacher->getData();
								    if($teacher<>NULL)
								      { foreach($teacher as $t) 
									      $teacher=$t->teacher;
										}
								 
								   $teacherC=Courses::model()->getCourses($teacher1,$idAcademicPeriod);
								   $teacherCourses=$teacherC->getData();//return a list of  objects
								   if($teacherCourses<>NULL)
								      { foreach($teacherCourses as $course) // pou chak kou ke nou jwenn
									       {  
										       if($course->day_course==$model->day_course)
												  {	 if((substr($course->time_start,0,5)<$model->time_start)&&($model->time_start<substr($course->time_end,0,5)))
														 {
															 
															  $params=array();
															 $message = Yii::t('app','<b>ERROR_1 : The choosen teacher is not available at this time. </b>.');
															$model->getMessage('', $message, $params);	
																				   
															
															 $teacher_dispo=false;
																  break;													   
														 }
														 elseif((substr($course->time_start,0,5)<$model->time_end)&&($model->time_end<substr($course->time_end,0,5)))
															{
															   
															    $params=array();
																$message = Yii::t('app','<b>ERROR_2 : The choosen teacher is not available at this time. </b>.');
																$model->getMessage('', $message, $params);	
																				   
																 
																  $teacher_dispo=false;
																	  break;													   
															}
														elseif(((substr($course->time_start,0,5)>=$model->time_start)&&($model->time_end>=substr($course->time_end,0,5)))||((substr($course->time_start,0,5)<=$model->time_start)&&($model->time_end<=substr($course->time_end,0,5))))
															{
															    $params=array();
																$message = Yii::t('app','<b>ERROR_3 : The choosen teacher is not available at this time.</b>.');
																$model->getMessage('', $message, $params);	
																				   
																 
																  $teacher_dispo=false;
																	  break;													   
															}
														  elseif((substr($course->time_start,0,5)===$model->time_start)&&($model->time_end===substr($course->time_end,0,5)))
														  {  
														      $params=array();
															  $message = Yii::t('app','<b>ERROR_4 : The choosen teacher is not available at this time.</b>.');
															  $model->getMessage('', $message, $params);
															  
															   $teacher_dispo=false;
															   break;
															   
														 }
														 
													}
										   }
										
								       }
									  
									
									
                               }									  
						
					if($teacher_dispo)		
					  {	 
					
                          $model->setAttribute('course',$_POST['Courses']['subject_name']);

					 $model->setAttribute('day_course',$day);
					 $model->setAttribute('time_start',$t_start);
					 $model->setAttribute('time_end',$t_end);
					
					 $model->setAttribute('date_created',date('Y-m-d'));
					 $model->setAttribute('date_updated',date('Y-m-d'));
					  
						if($model->save())
						  {  
							$course=Courses::model()->findByPk($model->course);
							
								if(isset($course))
								  $this->room_id=$course->room;
										   
							$this->redirect (array('index'));
										  
						  }
				        
					   }
			  }
			
		}
       if(Yii::app()->request->isAjaxRequest) 
	     { 
		   $this->renderPartial('addCourse',array(
				'model'=>$model),false,true);
		 }
		else
		  { 
		   $this->render('addCourse',array(
				'model'=>$model),false,true);
		 }
		
	}	
	
	
		//for ajaxrequest
public function actionUpdateCourse()
	{  
	    $model=new Schedules;
		
		 //saisie de l'annee academic en cours
		  $idAcademicPeriod=Yii::app()->session['currentId_academic_year'];  
		  $nameAcademicPeriod=Yii::app()->session['currentName_academic_year'];
									  
		
	
	  if(isset($_POST['Courses']))
		{   $model=$this->loadModel();

		$this->performAjaxValidation($model);
			    $day=$_GET['day'];
				 $room=$_GET['room'];
                 $t_start=$_GET['t_start'];
				 $t_end=$_GET['t_end'];
				 
				
			 
 			     $model->setAttribute('course',$_POST['Courses']['subject_name']);

			  	
				 $model->setAttribute('date_updated',date('Y-m-d'));
				 
				 	
				    //il faut verifier si le Teacher n'a pas deja un autre cours a cette heure
								 //__________________
								
								$teacher1=null;
								
								$teacher_dispo=true;
								
								//return an array(id, subject_name, subject_parent)  
								$info_subject = Subjects::model()->getSubjectByCourseId($model->course);
	                           
	                            $subject_id =  '';
	                            
	                            foreach($info_subject as $info_subj) 
	                             { $subject_id = $info_subj['id'];  break;
	                             }
						       
						      
								
								   $teacher11=Courses::model()->getTeacherByIdCourse($model->course,$idAcademicPeriod);
								    $teacher21=$teacher11->getData();
								    if($teacher21<>NULL)
								      { foreach($teacher21 as $t) 
									      $teacher1=$t->teacher;
										}
								 
								   $teacherC=Courses::model()->getCourses($teacher1,$idAcademicPeriod);
								   $teacherCourses=$teacherC->getData();//return a list of  objects
								   if($teacherCourses<>NULL)
								      { foreach($teacherCourses as $course) // pou chak kou ke nou jwenn
									       {  
										       if($course->day_course==$model->day_course)
												  {	 if((substr($course->time_start,0,5)<$model->time_start)&&($model->time_start<substr($course->time_end,0,5)))
														 {
															 
															 $params=array();
															 $message = Yii::t('app','<b>ERROR_1 : The choosen teacher is not available at this time.</b>.');
															 $model->getMessage('', $message, $params);	
																				   
															
															 $teacher_dispo=false;
																  break;													   
														 }     
														 elseif((substr($course->time_start,0,5)<$model->time_end)&&($model->time_end<substr($course->time_end,0,5)))
															{
															   
															   $params=array();
																$message = Yii::t('app','<b>ERROR_2 : The choosen teacher is not available at this time. </b>.');
																$model->getMessage('', $message, $params);	
																				   
																 
																$teacher_dispo=false;
																	  break;													   
															}
														elseif(((substr($course->time_start,0,5)>=$model->time_start)&&($model->time_end>=substr($course->time_end,0,5)))||((substr($course->time_start,0,5)<=$model->time_start)&&($model->time_end<=substr($course->time_end,0,5))))
															{
															   
															   $params=array();
																$message = Yii::t('app','<b>ERROR_3 : The choosen teacher is not available at this time.</b>.');
																$model->getMessage('', $message, $params);	
																				   
																 
																  $teacher_dispo=false;
																	  break;													   
															}
														  elseif((substr($course->time_start,0,5)===$model->time_start)&&($model->time_end===substr($course->time_end,0,5)))
														  {  
                                                                                                                          $params=array();
															  $message = Yii::t('app','<b>ERROR_4 : The choosen teacher is not available at this time.</b>.');
															  $model->getMessage('', $message, $params);
															  
															  $teacher_dispo=false;
															   break;
															   
														 }
														 
													}
										   }
										
									  
									  
									  }		
									  
		                         
						
				if($teacher_dispo)		
				  {			
					if($model->save())
					  {  
						$course=Courses::model()->findByPk($model->course);
						
							if(isset($course))
							  $this->room_id=$course->room;
									   
						$this->redirect (array('index'));
									  
					  }
			 
		           }
			
			
		}
       if(Yii::app()->request->isAjaxRequest) 
	     { 
		   $this->renderPartial('updateCourse',array(
				'model'=>$model),false,true);
		 }
		else
		  { 
		   $this->render('updateCourse',array(
				'model'=>$model),false,true);
		 }
				
			 
		           
	
		
		
	}	
	

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Schedules']))
		{
			$model->attributes=$_POST['Schedules'];
			
			 if(isset($_POST['update']))
              {
                        
				$model->setAttribute('date_updated',date('Y-m-d'));
			     
				if($model->save())
	                            
					$this->redirect(array('viewForUpdate','room'=>$_GET['room']));
					
              }
              
             if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
              
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete()
	{
		
		
		try {
   			 $this->loadModel()->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			        
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}



	}

        

	public function actionIndex()
	{    
                $model=new Schedules;
		$modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelacademicP = new AcademicPeriods;
		 
		$this->different=false;	
                $this->allowLink=false;				
		
		
		if(isset($_POST['AcademicPeriods']))
               	{      
						  
				    //on n'a pas presser le bouton, il fo load apropriate rooms
					      $modelacademicP->attributes=$_POST['AcademicPeriods'];
			              $this->idAcademicP=$modelacademicP->name_period;
						 
						 if($this->idAcademicP!=Yii::app()->session['AcademicP_sch'])
						   { 

                                                         $this->different=true;
							 $this->idLevel="";
                                                         Yii::app()->session['LevelHasPerson_sch'] =$this->idLevel;
						   
						    
                                                        $this->room_id="";
						   
						   }
						   
						  Yii::app()->session['AcademicP_sch'] = $this->idAcademicP;
	                        
	                        
                                                 $this->messageNoSchedule=false;
						 
			
						 $modelShift->attributes=$_POST['Shifts'];
                                                 $this->idShift=$modelShift->shift_name;
						 Yii::app()->session['Shifts_sch'] =$this->idShift;
	                     
                                                 $modelSection->attributes=$_POST['Sections'];
						 $this->section_id=$modelSection->section_name;
						 Yii::app()->session['Sections_sch'] =$this->section_id;
						  						
						 $modelLevel->attributes=$_POST['LevelHasPerson'];
						 $this->idLevel=$modelLevel->level;
						 Yii::app()->session['LevelHasPerson_sch'] =$this->idLevel;
						   
						    
						  $modelRoom->attributes=$_POST['Rooms'];
                                                  $this->room_id=$modelRoom->room_name;
						  
						  if((!$this->different)&&($this->room_id!=""))
						  {  
						     
							   
                                                                        $room=$this->getRoom($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
								//to show update link and create_pdf button only when there records for the room
								$courses=$this->getCoursesAndTimes($this->room_id,$this->idAcademicP);
								if((isset($courses))&&($courses!=null)) 
								  {  
								     $this->temoin_data=true;
								     $this->messageNoSchedule=false;
								  }
								 else
									$this->messageNoSchedule=true;	
										
						     
                                                                        $acadPeriod=$this->getAcademicPeriodeName($this->idAcademicP);
						      
							   if($acadPeriod!=null)
                                 {							
							    	$path='documents/schedules/'.$acadPeriod.'/'.$shift.'/'.$section;
								
														
							       if(file_exists(Yii::app()->basePath . '/../'.$path.'/'.$room.'_'.$section.'_'.$shift.'_schedule_'.$acadPeriod.'.pdf')) // if pdf file exist, allowlink to print it 
									   {
									             $this->pathLink='/'.$path.'/'.$room.'_'.$section.'_'.$shift.'_schedule_'.$acadPeriod.'.pdf';
												 $this->allowLink=true;
												 
									   }
                                    
						         }
						  
						  }
						 
						 
						 
					  
						  
					$this->success=false;				

	             }
		       else
		         {         $this->success=false;
				           $this->messageidAcademicP=false;
						   $this->messageNoSchedule=false;
						   
						   
			
						  
						  $this->idShift=Yii::app()->session['Shifts_sch'];
	                      $this->section_id=Yii::app()->session['Sections_sch'];
						  	$this->idLevel=Yii::app()->session['LevelHasPerson_sch'];
						   if($this->different)
						     $this->room_id='';
						  
						   $this->idAcademicP=Yii::app()->session['AcademicP_sch'];
							
							
															
						 if(isset($this->room_id)&&($this->room_id!=""))
						   { 
						   	  //to show update link and create_pdf button only when there records for the room
								$courses=$this->getCoursesAndTimes($this->room_id,$this->idAcademicP);
								if((isset($courses))&&($courses!=null)) 
								  {  
								     $this->temoin_data=true;
								     $this->messageNoSchedule=false;
								  }
								 else
									$this->messageNoSchedule=true;
									
									
                                                                        $room=$this->getRoom($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);

						   	
						   	
						   	
							 $acadPeriod=$this->getAcademicPeriodeName($this->idAcademicP);
							 $path='documents/schedules/'.$acadPeriod.'/'.$shift.'/'.$section;
							 if(file_exists(Yii::app()->basePath . '/../'.$path.'/'.$room.'_'.$section.'_'.$shift.'_schedule_'.$acadPeriod.'.pdf')) // if pdf file exist, allowlink to print it 
									{
									             $this->pathLink='/'.$path.'/'.$room.'_'.$section.'_'.$shift.'_schedule_'.$acadPeriod.'.pdf';
												 $this->allowLink=true;
												 
									}
									
							}
					
		
		    }
			
	
		if(isset($_POST['createPdf']))
		     {     $modelacademicP->attributes=$_POST['AcademicPeriods'];
			              $this->idAcademicP=$modelacademicP->name_period;
	                     
                                                   $modelShift->attributes=$_POST['Shifts'];
                                                   $this->idShift=$modelShift->shift_name;
	                     
                                                   $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						  						
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   
						   $modelRoom->attributes=$_POST['Rooms'];
                                                   $this->room_id=$modelRoom->room_name;
						  
						  
						     
                                                    $acadPeriod=$this->getAcademicPeriodeName($this->idAcademicP);
                                                    $room=$this->getRoom($this->room_id);
                                                    $level=$this->getLevel($this->idLevel);
                                                    $section=$this->getSection($this->section_id);
                                                    $shift=$this->getShift($this->idShift);
						     
						  
						  
						  $reportCard = 'documents';
								$schedules = 'schedules';
								
								
								// create new PDF document
								$pdf = new tcpdf('L', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								
								$criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'school_name',);
				   								$school_name = GeneralConfig::model()->find($criteria)->item_value;
				   								$criteria2 = new CDbCriteria;
				   								$criteria2->condition='item_name=:item_name';
				   								$criteria2->params=array(':item_name'=>'school_address',);
				   								$school_address = GeneralConfig::model()->find($criteria2)->item_value;
				   								
													 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app',"Schedule"));
								$pdf->SetSubject(Yii::t('app',"Schedule"));
							
								// set default header data
								
                                                                $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \n (509)3601-2959 / 3710-0802 / 3710-4799.");
								

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
								$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('dejavusans', '', 14, '', true);
								
//*******************************************/
                               
								   										   
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();

								// set text shadow effect
								$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print
					$html = <<<EOD
 <style>
	
	div.title {
		width:100%;
		font-style:bold;
		text-align: center;
	}
	
	div.info {
		float:left;
		font-size:10pt;
		margin-top:20px;
		margin-bottom:10px;
		
	}
	
	table.signature {
		width:90%;
		float:right;
		font-size:10pt;
		margin-top:55px;
		margin-bottom:5px;
		
	}
	
	
	
	td.signature1 {
		
		
	}
	
	td.signature2 {
		
		
	}
	
	td.space {
		width:30%;
		
	}
	
	

	
	table.tb {
		width:100%;
		float:right;
		
		font-size:8pt;
				
	}
	
	
	tr.color1 {
		background-color:#F5F6F7;
		
	}
	
	tr.color2 {
		background-color:#efefef;
		
	}
	
	td.color1 {
		background-color:#F5F6F7;
		
	}
	
	td.color2 {
		background-color:#efefef;
		
	}
	
	td.headnote {
		width:25%;
		
	}
	
	td.subject {
		width:60%;
		
		
	}
	
	th, td.style_td{
	     border-right: 1px solid #FFF; 
	     
	
	}
	
	
	tr.style_tr_head {
	    //color: #FFF; 
	    font-style:bold;
	    font-size: 0.9em; 
		height:100px;
		background-color: -webkit-linear-gradient(#85bad8 30%, #4c99c5 100%);
		background-color: -o-linear-gradient(#85bad8 30%, #4c99c5 100%);
	    background-color: -moz-linear-gradient(#85bad8 30%, #4c99c5 100%); 
	    background-color: -ms-linear-gradient(#85bad8 30%, #4c99c5 100%);
	    background-color: linear-gradient(#85bad8 30%, #4c99c5 100%);
     	background-color:#E4E9EF;
	}
	tr.color1 {
		background-color:#F5F6F7;
		font-size: 0.9em;
		margin-bottom:10px;
	}
	
	tr.color2 {
		background-color:#efefef;
		font-size: 0.9em;
		margin-bottom:10px;
	}
	
	
	
</style>
                                       
									
EOD;
	 
				   						  $first_line =true;
										   $compteur=0;
										   $couleur=1;
										  
										   
										   $class_tr_head="style_tr_head";
										   
										   $class_td="style_td";
										   
										   
										$html.='<div class="info" ><br/>
												   <b>'.Yii::t('app',' Room: ').'</b> '.$room.'<br/> <b>'.Yii::t('app',' Section: ').'</b> '.$section.'<br/><b> '.Yii::t('app',' Shift: ').'</b> '.$shift.'<br/><b>'.Yii::t('app','Academic period: ').'</b> '.$acadPeriod.'<br/><br/>
														  </div>  
                                                   <div  ><table class="tb">
												   <tr class="'.$class_tr_head.'"><th class="'.$class_td.'" >'.strtoupper(Yii::t('app',' Monday')).'</th><th class="'.$class_td.'">'.strtoupper(Yii::t('app','Tuesday')).'</th><th class="'.$class_td.'">'.strtoupper(Yii::t('app','Wednesday')).'</th><th class="'.$class_td.'">'.strtoupper(Yii::t('app','Thursday')).'</th><th class="'.$class_td.'">'.strtoupper(Yii::t('app','Friday')).'</th><th class="'.$class_td.'">'.strtoupper(Yii::t('app','Saturday')).'</th><th class="'.$class_td.'">'.strtoupper(Yii::t('app','Sunday')).'</th></tr>';
														
														if(isset($this->room_id)&&($this->room_id!=null))
                                         {
										 
										 
										 
										   $times=$this->getTimes($this->room_id, $this->idAcademicP);
										  if(isset($times))
										     $times=$times->getData();
											 
										  $courses=$this->getCoursesAndTimes($this->room_id, $this->idAcademicP);
										  
										   
										   }
										
															if(isset($courses)) 
															 {  
															    $day[]= array();
																$max=0;
																$max1=0;
																$trash=0;
																$max_day=0;
																$compteur=1;
														        
																foreach($courses as $course)
																  {   
																	switch($course->day_course)
																	  { case 1: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																				 
																			    $day[0][]=$course;
																				
																				break;
																				 
																		case 2: 
																			       $max++;
																				if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[1][]=$course; 
																			   
																				break;
																				 
																		case 3: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																					 
																				 $day[2][]=$course;
																			   
																				break;
																				 
																		case 4: 
																			       $max++;
																				if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[3][]=$course;
																			   
																				break;
																				 
																		case 5: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[4][]=$course;
																			   
																				break;
																				 
																		case 6: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[5][]=$course;
																			   
																				break;
																				 
																		case 7: 
																			       $max++;
																				   if($max!=0)
																				     $trash=$trash-1;
																					 
																				$day[6][]=$course;
																			   
																				break;
																	  }
																	  
																   }
																    
																	
																     
																	 $old_max=count($day[0]);
																  for($i=1; $i<=6;$i++)
																	{    
																	    
																		 if(isset($day[$i+1]))
																	      { 
																		     if(count($day[$i+1])>=count($day[$i]))
																		        $max1=count($day[$i+1]);
																			 else
																		        $max1=count($day[$i]);
																				
																				
																		    if($old_max <= $max1 )
																		       $old_max=$max1;
																		   
																		      
																		   }
																		 elseif(isset($day[$i]))
																		   {   
																		      $max1=count($day[$i]);
																			  if($max1>=$old_max)
																			    $old_max=$max1;
                                                                               					break;														  
																		   }
																		  
																	}
																	
																
																	
																	
																    for($c=0; $c<$old_max;$c++)
																	{   	
																	      //pour la couleur des lignes
														        
																
																			if($couleur===1)  //choix de couleur
																			{
																				$class_tr="color1";
																				 
																																					
																			}
																			elseif($couleur===2)
																			 {
																				$class_tr="color2";
																					
																		     }
																			
																		     $html.='<tr class="'.$class_tr.'"> ';
                                                                           for($j=0; $j<=6;$j++)
																		      { 
																			     if(isset($day[$j][$c]->course))
																			       {   
																					   if($first_line)
																					     {
																						     $subject=$this->getSubjectName($day[$j][$c]->course);
																											foreach($subject as $name)
																											   $subject_name=$name->subject_name;
																											$html.='<td class="'.$class_td.'">'.$subject_name.'<br/> <i> ('.$name->first_name.' '.$name->last_name.') </i>'.'<br/> <b>'.substr($day[$j][$c]->time_start,0,5).' - '.substr($day[$j][$c]->time_end,0,5).' </b></td>';
																									$compteur++;
																									
                                                                                                       // break;  
                                                                                                     //  }																										  
																						 }
																					   
																						 
																					 
																					}
																					else
																					  $html.='<td class="'.$class_td.'">***</td>';
																				  
																					
																			  }
																	         
																			  $couleur++;
	                                                            if($couleur===3) //reinitialisation
																    $couleur=1;
																	   
																		     $html.='</tr> ';
																	   
																	}//end foreach course
														          
																	
																	 
																 
																 
                                                              }//fin isset($course)
																
										  
															
																
													
											       $html.='<tr><td><br/><br/></td></tr></table></div>';
											       $html.='<div style="float:right; text-align: right; font-size: 6px; margin-top:-20px;margin-bottom:-8px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>';  
													
                                      $pdf->writeHTML($html, true, false, true, false, '');
	
								
								
									if (!file_exists(Yii::app()->basePath.'/../'.$reportCard.'/'.$schedules))  //si reportCard n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.$reportCard.'/'.$schedules);
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.'/'.$schedules.'/'.$acadPeriod))    //reportCard existe.si acadPeriod n'existe pas, on le cree 
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.'/'.$schedules.'/'.$acadPeriod);
									
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.'/'.$schedules.'/'.$acadPeriod.'/'.$shift))    //schedules existe.si shiftName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.'/'.$schedules.'/'.$acadPeriod.'/'.$shift);
									
									if(!file_exists(Yii::app()->basePath . '/../'.$reportCard.'/'.$schedules.'/'.$acadPeriod.'/'.$shift.'/'.$section))    //acadPeriod existe.si schedules n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$reportCard.'/'.$schedules.'/'.$acadPeriod.'/'.$shift.'/'.$section);	 
										 
									$path=$reportCard.'/'.$schedules.'/'.$acadPeriod.'/'.$shift.'/'.$section;
								
																					  
								
								
								
								 
								$pdf->Output($path.'/'.$room.'_'.$section.'_'.$shift.'_schedule_'.$acadPeriod.'.pdf', 'F');

								//============================================================+
								// END OF FILE
								//============================================================+		

							 $this->success=true;
							 $this->allowLink=true;
							 $this->pathLink='/'.$path.'/'.$room.'_'.$section.'_'.$shift.'_schedule_'.$acadPeriod.'.pdf';
												 
										          
		     
		
		
		       
                                                         
                                                       }				  
		      			  
		      
		
		$model=new Schedules('search');
		
		$this->render('index',array(
			'model'=>$model,
		));
	}
	

	
	
	
	public function actionViewForTeacher()
	{
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			$model=new Schedules('search');
		if(isset($_GET['Schedules']))
			$model->attributes=$_GET['Schedules'];
         
		 // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Schedules View for teacher: ')), null,false);
			
			$this->exportCSV($model->search(), array(
					'course0.courseName',
					'day',
					'time_start',
					'time_end')); 
		}
		
				
		$this->render('viewForTeacher',array(
			'model'=>$model,
		));
	}
	
	public function actionViewForUpdate()
	{
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			
			//$model=new Schedules('search');
			$model=new Schedules;
			
		if(isset($_GET['Schedules']))
			$model->attributes=$_GET['Schedules'];
			
			
		

		$this->render('viewForUpdate',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Schedules::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}
	
	
	
	
	
	//************************  academic year ******************************/
	public function loadAcademicPeriod()
	{    $modelAcademicP = new AcademicPeriods;
           $code= array();
		  //we will set it at the current academic period for this version, and later set it to have past academic period too
		  
		  
		  $modelAcadP=$modelAcademicP->findAll(array('select'=>'id,name_period',
                                     'condition'=>'is_year=1 ', 'order'=>'name_period ASC',));
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelAcadP))
			 {  
			     foreach($modelAcadP as $acad){
			        $code[$acad->id]= $acad->name_period;
		           
		           }
			 }
		    
			
				
			
			
		return $code;
         
	}
	
	//************************  loadCourseByRoomId ******************************/
	public function loadCourseByRoomId($room_id)
	{    $modelCourse= new Courses();
           $code= array();
		   
		    $c=$modelCourse->searchCourseByRoomId($room_id);
            $courses=$c->getData();
			
			
		    if(isset($courses))
			 {  
			    foreach($courses as $course){
			        $code[$course->id]= $course->subject_name.'('.$course->teacher_name.')';
		           
		           }
			 }
		   
		return $code;
         
	}
	
	
	//************************  loadRoomByAcademicYear ******************************/
	public function loadRoomByAcademicYear($academicY)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $rooms=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'r.id,r.room_name',
                                     'join'=>'left join courses c on(c.room=r.id)',
									 'condition'=>'c.academic_period=:acad',
                                     'params'=>array(':acad'=>$academicY,),
									 'order'=>'room_name ASC',
                               ));
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($rooms))
			 {  
			    foreach($rooms as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	//************************  getCoursesAndTimes($this->room_id, $idAcad) ******************************/
	public function getCoursesAndTimes($room_id,$idAcad)
	{
	    
		  
		  
		  
		   
		  $times=Schedules::model()->findAll(array('alias'=>'s',
									'select'=>'s.id, s.course, s.day_course, s.time_start, s.time_end',
									 'join' => 'left join courses c on (s.course=c.id)',
                                     'condition'=>'c.room=:Id AND c.academic_period=:idAcad',
                                     'params'=>array(':Id'=>$room_id, ':idAcad'=>$idAcad),
									 'order' => 's.time_start ASC',
                               ));
            
		    if(isset($times))
			 {  
			    return $times;
		      
			 }
		     else
			   return null;
		  
			 
	}
	
	//************************  getTimesForSpecificDay($this->room_id, day, $idAcad) ******************************/
	public function getTimesForSpecificDay($room_id, $day, $idAcad)
	{
		  $times=Schedules::model()->searchTimesForSpecificDay($room_id, $day, $idAcad);
		  
		   
	      if(isset($times))
			 return $times;
	      else
		     return null;
	}
	
	//************************  getTimes($this->room_id, $idAcad) ******************************//
	public function getTimes($room_id, $idAcad)
	{
		  $times=Schedules::model()->searchTimes($room_id, $idAcad);
		  
		   
	      if(isset($times))
			 return $times;
	      else
		     return null;
	}
	
	 // return the subject name of a course with a specific idCourse 
        public function getSubjectName($id){
		     
		     $subject=Courses::model()->getSubjectName($id);
			 
			 return $subject->getData();
		}
	
public function currentAcademicPeriod($currentDate,$room_id)
	  {    $report= new ReportCard;
	        $result=$report->currentAcademicPeriod($currentDate,$room_id);
                if($result!=null)
                    return $result->name_period;
                    else
                        return null;
	  }
	
	
	public function getAcademicPeriodeName($id)
	  {    $acad = new AcademicPeriods;
	        $result=$acad->getAcademicPeriodNameById($id);
                if($result!=null)
                    return $result->name_period;
                    else
                        return null;
	  }
	
	
 //************************  getRoom($id) ******************************/
   public function getRoom($id)
	{
		$room = new Rooms;
		
		$room=Rooms::model()->findByPk($id);
        
			
		
		    if(isset($room))
				return $room->room_name;
		
	}

//************************  getSection($id) ******************************/
   public function getSection($id)
	{
		
		$section=Sections::model()->findByPk($id);
        
			
		       if(isset($section))
				return $section->section_name;
		
	}

//************************  getShift($id) ******************************//
   public function getShift($id)
	{
		
		$shift=Shifts::model()->findByPk($id);
        
			
		      if(isset($shift))
				return $shift->shift_name;
		
	}

 //************************  getLevel($id) ******************************/
   public function getLevel($id)
	{
		$level = new Levels;
		$level=Levels::model()->findByPk($id);
        
			
		    if(isset($level))
				return $level->level_name;
		
	}

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

	//************************  loadSectionByIdShift ******************************/
	public function loadSectionByIdShift($idShift)
	{     
	      $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $section_id=$modelRoom->findAll(array('alias'=>'r',
	                                 'join'=>'left join levels l on(l.id=r.level)',
	                                 'select'=>'l.section',
                                     'condition'=>'r.shift=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift),
                               ));
			if(isset($section_id))
			 {  
			    foreach($section_id as $i){			   
					  $modelSection= new Sections();
					   
					  $section=$modelSection->findAll(array('select'=>'id,section_name',
												 'condition'=>'id=:sectionID',
												 'params'=>array(':sectionID'=>$i->section),
										   ));
						
						 if(isset($section)){
						     foreach($section as $s)
							    $code[$s->id]= $s->section_name;
						   }	   
							   }						 }
		   
		return $code;
		$this->section_id=null;
         
	}
	

public function loadLevelByIdShiftSectionIdAcademicP($idShift,$section_id,$idAcademicP)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('select'=>'l.id,l.level_name','alias'=>'r',
		                             'join'=>'left join room_has_person rh on (rh.room=r.id) left join levels l on(l.id = r.level)',
                                     'condition'=>'r.shift=:shiftID AND l.section=:sectionID', //AND rh.academic_year=:academic_year',
                                     'params'=>array(':shiftID'=>$idShift, ':sectionID'=>$section_id),//,':academic_year'=>$idAcademicP),
									  'order'=>'l.level_name ASC',
                               ));
			if(isset($level_id))
			 {  
			    foreach($level_id as $i){			   
					  
						       $code[$i->id]= $i->level_name;
					      
							   }						 
		    
						  }	
			
		return $code;
         
	}
	
	
//************************  loadRoomByIdShiftSectionLevel ******************************/
	public function loadRoomByIdShiftSectionLevel($shift,$section,$idLevel)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
		                             'join'=>'left join levels l on(l.id=r.level)',
		                             'select'=>'r.id,r.room_name',
                                     'condition'=>'r.shift=:idShift AND l.section=:idSection AND r.level=:levelID ',
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
		
	
	
			//************************  getLevelByRoomId  ******************************/
	public function getLevelByRoomId($room_id,$idSection)
	{    
       	  
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('alias'=>'',
	                                 'join'=>'left join levels l on(l.id=r.level)',
	                                 'select'=>'r.level',
                                     'condition'=>'r.id=:roomID AND l.section=:sectionID',
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
	
	
	
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='schedules-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	// Behavior the create Export to CSV 
	public function behaviors() {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','Schedules-View-For Teacher.csv'),
	            'csvDelimiter' => ',',
	            ));
	}
	
	
}
