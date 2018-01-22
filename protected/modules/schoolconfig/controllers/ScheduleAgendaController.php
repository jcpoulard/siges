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


class ScheduleAgendaController extends Controller
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
	
	                      
public function actionViewForAgenda()
	{
		 $_model=new ScheduleAgenda;
		 
		 if(isset($_POST['delete']))
		   {//$this->redirect(array('index'));
			 
			 }
		  else
			 {
				 if(isset($_GET['id']))
					{	$_model=ScheduleAgenda::model()->findbyPk($_GET['id']);
				        
				        if($_model===null)
					       throw new CHttpException(404,'The requested page does not exist.');
					    else
					      {
							 if (@$_GET['asModal']==true)
						        {
						            $this->renderPartial('viewForAgenda',
						                array('model'=>$_model),false,true
						            );
						        }
					         else{ $this->render('viewForAgenda',array(
										'model'=>$_model,
									));
									
					           }
					         
					        }
				     
				         
					}
				else
		           throw new CHttpException(404,'The requested page does not exist.');
		           
			}
			
			
           
	}
	
	


	public function actionCreate()
	{
		$flag=false;
		$flag1=false;
		$teacher_dispo=true;
		$idAcademicPeriod=null; 
		$nameAcademicPeriod=null;
		
		$model=new ScheduleAgenda;
		$modelRoom=new Rooms;
		
		$room_id=null;
		 
		$temoin1=null;
		$error=false;
		  
		
            
		   //saisie de l'annee academic en cours
		  $idAcademicPeriod=Yii::app()->session['currentId_academic_year'];  
		  $nameAcademicPeriod=Yii::app()->session['currentName_academic_year'];
		  
		   if(isset($_POST['Rooms']))
 			     {  $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['RoomsAgenda']=$this->room_id; 
 			  
 			       }
 			else
 			  {
 			  	  if(Yii::app()->session['RoomsAgenda']!='')
 			  	     $this->room_id = Yii::app()->session['RoomsAgenda']; 
 			  	}
		  
		  
		  if(isset($_GET['agenda'])&&(($_GET['agenda']!='')&&($_GET['agenda']!=0)) )
		    {   $id_to_delete = $_GET['agenda'];
				ScheduleAgenda::model()->findbyPk($id_to_delete)->delete();
				
		      }
		      
		      
		   if(isset($_POST['ScheduleAgenda']))
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
										     
										       //return an array(id, subject_name, subject_parent)  
												$info_subject = Subjects::model()->getSubjectByCourseId($course->course);
					                           
					                            $subject_id =  '';
					                            
					                            foreach($info_subject as $info_subj) 
					                             { $subject_id = $info_subj['id'];  break;
					                             }
										       
										        
										   if($subject_id!=1) //se pa yon repi
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
				                  if(isset($_GET['ad']))
				                       $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['emp'],'isstud'=>0,'from'=>'teach','ad'=>''));
				                  elseif(isset($_GET['up']))
				                     $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['emp'],'isstud'=>0,'from'=>'teach','up'=>''));
				                  
				               }
				            else
							  {  if(isset($_GET['ad']))
							         $this->redirect(array('viewForUpdate','room'=>$this->room_id,'ad'=>''));
							     elseif(isset($_GET['up']))
								    $this->redirect(array('viewForUpdate','room'=>$this->room_id,'up'=>''));
							  }
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
	   	$model=new ScheduleAgenda;
       
		
		  //saisie de l'annee academic en cours
		  $idAcademicPeriod=Yii::app()->session['currentId_academic_year'];  
		  $nameAcademicPeriod=Yii::app()->session['currentName_academic_year'];
		
      
	
	  if(isset($_POST['Courses']))
		{   
			    
				
				$day=$_GET['day'];
				$date_=$_GET['sta_d'];
				 $room=$_GET['room'];
                 $t_start=$_GET['t_start'];
				 $t_end=$_GET['t_end'];
				 
				$teacher1=null;
				$teacher_dispo=true;
				
			 
 		 if(isset($_POST['createCourse']))
		   {    
						
			if(isset($_GET['asModal'])&&($_GET['asModal']==true)) 
			  {
			  	 
			  	 
			  	 $c_description='';
			  	 $teacher_name='';
			  	 $teacher_dispo=true;
			  	 
			  		 $course_id=$_POST['Courses']['subject_name'];
			  		 
			  		
			  		 $subject=$this->getSubjectName($course_id);
			  		 $teacher_id = '';
					foreach($subject as $name)
					  { $c_description=$name->subject_name;
				        
				        $teacher_fname = str_split($name->first_name,1);
                       
                        $teacher_name = ' ('.$teacher_fname[0].' '.$name->last_name.')';
			      	
				        $teacher_id = $name->teacher_id;
					  }
					
					  //return an array(id, subject_name, subject_parent)  
							$info_subject = Subjects::model()->getSubjectByCourseId($course_id);
                           
                            $subject_id =  '';
                            
                            foreach($info_subject as $info_subj) 
                             { $subject_id = $info_subj['id'];  break;
                             }
					       
					        
					       if($subject_id!=1) //se pa yon repi
					        { 
					          //disponibilite teacher
						       $teacherC=ScheduleAgenda::model()->getCoursesForTeacherByDate($teacher_id, $date_, $idAcademicPeriod);
								   $teacherCourses=$teacherC->getData();//return a list of  objects
								   if($teacherCourses<>NULL)
								      { 
									    
									    foreach($teacherCourses as $course) // pou chak kou ke nou jwenn
									       {  
										       //verifye le a pou we si teacher pa oqp
											   if((substr($course->start_time,0,5)<substr($t_start,0,5))&&(substr($t_start,0,5)<substr($course->end_time,0,5)))
												 {	
												    // $params=array();
													// $message = Yii::t('app','<b>ERROR_1 : The choosen teacher is not available at this time. </b>.'); 
													 //$model->getMessage('', $message, $params);
													 
													 Yii::app()->user->setFlash(Yii::t('app','TeacherAvaliability'), Yii::t('app','<b>ERROR_1 : The choosen teacher is not available at this time.</b>.'));
														
																		   
													$teacher_dispo=false;
														  break;	break;break;												   
												 }
												 elseif((substr($course->start_time,0,5)<substr($t_end,0,5))&&(substr($t_end,0,5)<substr($course->end_time,0,5)))
													{   
													   //$params=array();
														//$message = Yii::t('app','<b>ERROR_2 : The choosen teacher is not available at this time. </b>.');
														//$model->getMessage('', $message, $params);	
																		   
														 Yii::app()->user->setFlash(Yii::t('app','TeacherAvaliability'), Yii::t('app','<b>ERROR_2 : The choosen teacher is not available at this time. </b>.'));

                                                            $teacher_dispo=false;
															  break;break;break;													   
													}
												elseif(((substr($course->start_time,0,5)>=substr($t_start,0,5))&&(substr($t_end,0,5)>=substr($course->end_time,0,5)))||((substr($course->start_time,0,5)<=substr($t_start,0,5))&&(substr($t_end,0,5)<=substr($course->end_time,0,5))))
												   {  
												      //$params=array();
													  //$message = Yii::t('app','<b>ERROR_3 : The choosen teacher is not available at this time. </b>.');
													  //$model->getMessage('', $message, $params);
													  
													   Yii::app()->user->setFlash(Yii::t('app','TeacherAvaliability'), Yii::t('app','<b>ERROR_3 : The choosen teacher is not available at this time.</b>.'));
													   
													   $teacher_dispo=false;
													   break;break;break;
													   
												 }
												elseif((substr($course->start_time,0,5)===substr($t_start,0,5))&&(substr($t_end,0,5)===substr($course->end_time,0,5)))
												  {  
												       //$params=array();
													  //$message = Yii::t('app','<b>ERROR_4 : The choosen teacher is not available at this time. </b>.');
													  //$model->getMessage('', $message, $params);
													  
													   Yii::app()->user->setFlash(Yii::t('app','TeacherAvaliability'), Yii::t('app','<b>ERROR_4 : The choosen teacher is not available at this time.</b>.'));
													   
													  
													  $teacher_dispo=false;
													   break;break;break;
													   
												 }
											   
										   }
										
									  
									  
									  }	
									 
			                  } 

					
					
					
					
				if($teacher_dispo)	
				  {																						
					$c_description=$c_description.$teacher_name;
			  		 
			  		
			  		 $model->setAttribute('course',$course_id);
			  		 
			  		 $model->setAttribute('c_description',$c_description);
			  		 $model->setAttribute('day_course',$day);
			  		 $model->setAttribute('start_date',$date_);
					 $model->setAttribute('end_date',$date_);
					 $model->setAttribute('start_time',$t_start);
					 $model->setAttribute('end_time',$t_end);
					 $model->setAttribute('academic_year',$idAcademicPeriod);
					 
					 if($model->save())
					     $this->redirect (array('create'));
					     
				  }
			else
			  {
				     $this->redirect (array('/schoolconfig/scheduleAgenda/create'));
				}
				  
					 
			  }//end (!isset($_GET['asModal'])) 
			
				
			  
		  }
			
		}
       if((Yii::app()->request->isAjaxRequest)||(@$_GET['asModal']==true)) 
	     { 
		   $this->renderPartial('addCourse',array(
				'model'=>$model),false,true);
		 }
		else
		  { 
		   $this->renderPartial('addCourse',array(
				'model'=>$model),false,true);
		 }
		
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
  		$acad=Yii::app()->session['currentId_academic_year']; 
  		$acad_name=Yii::app()->session['currentName_academic_year'];
  		
		$model=new ScheduleAgenda;
		$modelRoom = new Rooms;
		
		  //saisie de l'annee academic en cours
		  $idAcademicPeriod=Yii::app()->session['currentId_academic_year'];  
		  $nameAcademicPeriod=Yii::app()->session['currentName_academic_year'];
		  
		   if(isset($_POST['Rooms']))
 			     {  $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['RoomsAgenda']=$this->room_id; 
 			  
 			       }
 			else
 			  {
 			  	  if(Yii::app()->session['RoomsAgenda']!='')
 			  	     $this->room_id = Yii::app()->session['RoomsAgenda']; 
 			  	}
		  
           if(isset($_POST['createPDF']))
			 {
				 	$start_date_ = $_POST['start_date_'];
				 	$end_date_ = $_POST['end_date_'];
				 	
				 	//print_r('<br/><br/>*******************************************************************'.$start_date_);
				 	$d1 = $start_date_;
		            $d2 = $end_date_;
				 	
				 		 //Extract school name 
						$school_name = infoGeneralConfig("school_name");
                          //Extract school address
				   		$school_address = infoGeneralConfig("school_address");
                         //Extract  email address 
                        $school_email_address = infoGeneralConfig("school_email_address");
                        //Extract Phone Number
                        $school_phone_number = infoGeneralConfig("school_phone_number");
                        
                        
                        


?>
<script type="text/javascript">
    
     printDiv('print_receipt');
     
    function printDiv(divName) {
          
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     document.body.innerHTML = printContents;
     
     window.print();
     
     document.body.innerHTML = originalContents;
     
     document.getElementById(divName).style.display = "none";
     
     
    }    
    
    
    
     </script>
 <?php                       
                        
			/*	   								
				   				// create new PDF document
								$pdf = new tcpdf("Legal", PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle($school_name.' '.Yii::t('app',"Agenda"));
								$pdf->SetSubject($school_name.' '.Yii::t('app',"Agenda"));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								
								//$pdf->SetHeaderData(PDF_HEADER_LOGO_REPORTCARD, PDF_HEADER_LOGO_REPORTCARD_WIDTH, "", ""); //CNR
								$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								//$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);      //CNR
								$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, 5); // PDF_MARGIN_BOTTOM

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
								$pdf->SetFont('helvetica', '', 12, '', true);
								
								
								
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();
$general_average=0;
								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print
								
								$html = <<<EOD
 <style>
	
.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		//color: #1e5c8c;
        font-size: 16px;
		width:100%;
		text-align: center;
		
		 
	   }
	
	
.info{   font-size:10px;
      background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
	 }
		
 .corps{
	 
	width:100%;
	background-color: #F5F6F7;
	
	}

		
table.signature {
		width:90%;
		float:right;
		font-size:10px;
		margin-top:55px;
		margin-bottom:5px;
		
	}
	
.place{
	  font-size:6pt;
	}
	
	td.signature1 {
		
		
	}
	
	td.signature2 {
		
		
	}
	
	td.space {
		width:30%;
		
	}

.tb {
		
		width:100%;
	    
		//loat:right;
		
		font-size:10px;
				
	}
	
 .discipline {
		width:65%; 
		margin-top:20px;
		font-size:10px;
	}

		
 .subjectheadnote {
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			width:30%;
			
			}
			
			

.subjectheadnote_white_tr{
			
			background-color:#FFFFFF; 
	
			}
						
						
 .subject{
			color:#000; 
			font-size:10px; 
			height:20px;
			font-weight: normal; //bold; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;
			}
		
 .color1{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}


 .color2	{
			color:#000; 
			font-size:10px; 
			//font-weight:bold; 
			text-align:left;
			background-color: #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
	
 .sommes	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes1	{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			background-color:  #F5F6F7;
			border-bottom: 1px solid #ecedf4;
		}
 .sommes2{
			font-size:10px; 
			//font-weight:bold;
			text-align:left;
			border-top: 1px solid #EE6539;
			border-radius: 5px;
			background-color:  #EFEFEF;
			border-bottom: 1px solid #ecedf4;
			
		}

 .border	{
			
			border-bottom: 1px solid #ecedf4;
		}
			
.headnote {
		//width:10%;
		
	}
	
	
.periodsommes2{
		height:20px; 
		text-align: right;
			border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}
.periodsommes{
	height:20px;
	text-align: right; 	
	border-bottom: 1px solid #ecedf4;
	}
 .period {
		width:10%;
		text-align: center;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodParent {
		width:10%;
		text-align: center;
		font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	border-bottom: 1px solid #ecedf4;
	}
	
.periodsommes2_red{
		width:10%;
		text-align: center;
		border-top: 1px solid #EE6539;
	border-bottom: 1px solid #ecedf4;
	}	
	
.periodheadnote {
		width:10%;
		font-size:9px;
	
	}

.subjectParent{
	//text-transform: uppercase; //capitalize; //|uppercase|lowercase|initial|inherit|none;
	height:15px;
	font-weight:bold;
	font-style: italic;
	background-color: #F1F1F1;//#F0F0F0;//#EFEFEF;//#F2F2F2;
	
			
	}
	

			
div > .subject {
		width:30%;
		 text-indent: 10px;
		 font-weight: normal; //bold; 
		
	}
	
.subject_single{
		    color:#000; 
			font-size:10px; 
			height:20px;
			font-weight:bold;
			text-indent: 0px; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;	
	}	
	
	
</style>
                                       
										
EOD;
	 
				   					//	$html .='<div class="title" >'.strtoupper(Yii::t("app","Report Card ")).'</div>'; 
										$html .='<span class="title" >'.strtoupper(Yii::t("app","Agenda ")).'</span>
										<div class="info" >  <b>'.Yii::t('app','Name: ').'</b>     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b> : </b><br/> <b>  '.Yii::t('app','Level / Room: ').'</b> <br/>  <b>  '.Yii::t('app','Section / Shift: ').'</b>    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>'.Yii::t('app','Academic period: ').'</b>  / <b>'.Yii::t('app','Number of students: ').'</b>  </div>
														    
                                                      <div class="corps"> ';   

      
 $html .= '<table style="font-size:12px; background-color:#F4F6F6;">
		           <tr>
		               <td style="width:70px; "></td><td ></td>';
		               
		      $column_number =0;     
		      
		      $room_array=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'*',
									 'distinct'=>true,
                                     'join'=>'left join room_has_person rh on(rh.room=r.id)',
									 'condition'=>'rh.academic_year=:acad ',
                                     'params'=>array(':acad'=>$acad,),
									 'order'=>'r.room_name',
                               ));
            
		   	  
		         foreach($room_array as $room)
		           {
		           	   $column_number++;
		                 	$html .= '<td style="text-align:center;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.$room->short_room_name.'</b></td>';
		           	}
		           	
		           	$html .= '</tr>';
		           	$column_number = $column_number+1;
		           	
		           	//$d1 = '2016-05-16';
		            //$d2 = '2016-05-21';
                    
		          
		                $day_start = strtotime($d1);//DateTime::createFromFormat('Y-m-d', '2016-05-10');
		                $day_end = strtotime($d2);//DateTime::createFromFormat('Y-m-d', '2016-05-15');   	
		            	$pass =1;	
		                 
		               for($j=$day_start; $j<=$day_end; $j+=86400 )
		                 {	 
		                 	$date_ = date("Y-m-d",$j);
		                 	$d = DateTime::createFromFormat('Y-m-d', $date_);
		                 	  //seaching times
		                 	  
		                    $sch_times = ScheduleAgenda::model()->searchTimesByDate($date_);
		                        
		                 	$nb_line=0;
		                 	$nb_line = sizeof($sch_times);
		                 	
		                 	if($nb_line!=null)
		                 	   $nb_line++;
		                 	
		                 	
		                     
		                 	
		                 	
		                       
		                      
		                          	$html .= '<tr>';  
		                          	  
		                          	  if($pass==1)
		                          	    { 
		                          	    	$html .= '<td rowspan="'.$nb_line.'" style=" width:50px; text-align:center;  background-color: #F1F1F1; border-bottom: 1px solid #FFFFFF; "><b>'.getShortDay( getDayNumberByShortDay(Yii::t('app',$d->format('D'))) ).' <br/>('.ChangeDateFormat($date_).') </b></td>';    	    
		                          	       $nb_line=1;
		                          	      $pass=2;
		                          	    }
		                          	   
		                     if($nb_line>0)         
			                    {
		 
		                              
		                                 
		                          	    if($sch_times!=null)
				                         { 
				                         	
				                         	
				                          foreach($sch_times as $times )
		                                    {
		                                    	$html .= '<tr>';  
		                                    	
				                          	      $html .= '<td style="border-left: 1px solid #FFFFFF; border-bottom: 1px solid #C8CACE;">'.date("H:i",strtotime($times["start_time"])).' - '.date("H:i",strtotime($times["end_time"])).'</td>';
				                             
					                          if($room_array!=null)
				                                 {  foreach($room_array as $room)
					                                  {
					                               	     $html .= '<td  style=" text-align:center; border-left: 1px solid #FFFFFF; border-bottom: 1px solid #C8CACE;">';
					                               	    
					                               	     //retreive course name   $day_given_date
				                                          $sch_course_name = ScheduleAgenda::model()->searchDescriptionByDate($room->id,$date_,$times["start_time"],$times["end_time"]);
				                                          if($sch_course_name!=null)
				                                            { foreach($sch_course_name as $course )
				                                                $html .= '-'.$course["c_description"];
				                                            }
				                                          
				                                          				                                          
					                               	      $html .= '</td>';
					                               	      
					                               	     
					                                  }
				                                 }
				                               else
				                                 {
				                                 	$html .= '<td  style=" text-align:center; border-left: 1px solid #FFFFFF; border-bottom: 1px solid #C8CACE;"> f </td>';
				                                 	} 
					                                 
					                              $html .= '</tr>';   
		                                     }
		                                     
		                                   }
		                                 		                                 
		                               $pass=1;
		                            
		                           }
		                          else
		                          {
		                          	          if($room_array!=null)
				                                 {  foreach($room_array as $room)
					                               {
					                               	  $html .= '<td  style=" text-align:center; border-left: 1px solid #FFFFFF; border-bottom: 1px solid #C8CACE;">';
					                               	  
					                               	    				                                          
					                               	  $html .= '</td>';
					                                 }
				                                 }

		                          	} 
			          
		                           

		         
		                                       
			            		                           
		                           
		                          $html .= '</tr>';
		                       }
		                           
		                         
		           		  
		 
		$html .= ' </table>';



                                       	
                                       	
                                       	
                                       	$html .= '</div>';
		

                            $pdf->writeHTML($html, true, false, true, false, '');
                            
 							$pdf->Output($school_name.'_'.Yii::t('app',"Agenda").'_'.$acad_name.'.pdf', 'D'); 
				 	*/
				 	             /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/

								//============================================================+
								// END OF FILE
								//============================================================+	
				 	
				 
			   }
		 	 					
				
		$this->render('index',array(
			'model'=>$model,
		));
	}

	
	
		
  public function actionSchedulesAgenda()
    {       
        
       $acad=Yii::app()->session['currentId_academic_year']; //current academic year
       $course_id =Yii::app()->session['RoomsAgenda'];
   
   $condition = 'course IN(select id from courses where room='.$course_id.')';
        
        $items = array();
        $model=ScheduleAgenda::model()->findAll($condition);
                                    
          
                                                                    
        foreach ($model as $value) {
            $items[]=array(
                
                'id'=>$value->id,
                'title'=>$value->c_description,
                'start'=>$value->start_date.'T'.$value->start_time,
                'end'=>$value->end_date.'T'.$value->end_time,
                'color'=>'#'.$value->color,
                
            );
            
           
         }
        
      
        echo CJSON::encode($items);
        Yii::app()->end();
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
	{     $acad=Yii::app()->session['currentId_academic_year']; 
		
		$modelCourse= new Courses();
           $code= array();
		   
		    $c=$modelCourse->searchByRoomId($room_id, $acad);
            $courses=$c->getData();
			
			
		    if(isset($courses))
			 {  
			    foreach($courses as $course)
			      {
			      	$teacher='';
			      	
			      	$explode_teacher_name= explode(" ",$course->teacher_name);
                    
                     $nb_line = sizeof($explode_teacher_name);
                     
                     for($i=1; $i<$nb_line; $i++)
                       $teacher = $teacher.' '.$explode_teacher_name[$i];
                       
                       $teacher_fname = str_split($explode_teacher_name[0],1);
                       
                       $teacher = $teacher_fname[0].' '.$teacher;
			      	
			      	
			        $code[$course->id]= $course->subject_name.'('.$teacher.')';
		           
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
/*	public function loadRoom()
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
*/
	
	//************************  loadRoom ******************************/
	public function loadRoom($acad)
	{    $modelRoom= new Rooms();
           $code= array();
		     
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'*',
                                     'join'=>'left join room_has_person rh on(rh.room=r.id)',
									 'condition'=>'rh.academic_year=:acad ',
                                     'params'=>array(':acad'=>$acad,),
									 'order'=>'r.room_name',
                               ));
            $code[null]= Yii::t('app','-- Select room --');
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
                                     'condition'=>'r.shift=:shiftID AND l.section=:sectionID AND rh.academic_year=:academic_year',
                                     'params'=>array(':shiftID'=>$idShift, ':sectionID'=>$section_id,':academic_year'=>$idAcademicP),
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
		

//************************  loadRoomByIdTeacher($id_teacher,$acad) ******************************/
	public function loadRoomByIdTeacher($id_teacher,$acad)
	{    

	
		$modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'r.id,room_name',
                                     'join'=>'left join courses c on(c.room=r.id)',
                                     'condition'=>'c.academic_period IN(select ap.id from academicperiods ap where (ap.id='.$acad.' OR ap.year='.$acad.') ) AND c.teacher='.$id_teacher,
                                     'order'=>'r.room_name ASC',
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
