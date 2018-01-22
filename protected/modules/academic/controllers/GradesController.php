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
	
	public $back_url='';
	
	public $message_UpdateValidate=false;
	public $message_UpdateValidate1=false;//for teacher user
	public $message_UpdatePublish=false;
	public $message_already_validate=false;
	public $message_course_already_validate=false;
	public $message_noGrades=false;
	public $message_gradesOk=false;
	public $message_GradeHigherWeight=false;
	
	public $message_noGradeEntered=false;
	
	public $template_update_only = false;
	
	public $success_=0;
	
	
	public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	public $grade_id;
	
	public $first_name;
	public $last_name;
	
	
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
	
	public $message_validate=false;
	public $messageNoCheck=false;
	public $use_update=false;
	
	
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



 public function actionCreate()
	{   
		
		$model=new Grades;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelCourse=new Courses;
		$modelEvaluation= new EvaluationByYear;
		
		$this->use_update=false;
		
		$this->performAjaxValidation($model);
        
        if(isset($_GET['stud'])&&($_GET['stud']!=""))
            $this->extern=true;
       else
            $this->extern=false;
       
        
		if($this->extern)
		  {
		  	       
		  	    if((Yii::app()->user->profil!='Teacher'))
                  {    
		  	           if(isset($_POST['EvaluationByYear']))
               	         {   $modelEvaluation->attributes=$_POST['EvaluationByYear'];
						     $this->evaluation_id=$modelEvaluation->evaluation;
						     Yii::app()->session['Evaluation']=$this->evaluation_id;
						   
						     $modelCourse->attributes=$_POST['Courses'];
						     $this->course_id=$modelCourse->subject;
						     Yii::app()->session['Courses']=$this->course_id;
						     
						      $this->use_update=false;
		                    if(($this->course_id!="")&&($this->evaluation_id!=""))
						        {
				                     $check = $this->checkDdataByEvaluation_externRequest($_GET['stud'],$this->evaluation_id, $this->course_id);
							 
									 if($check)
									  { $this->use_update=true; }										  	
						        }

               	         }
               	       else
               	        {
               	        	//return an id(number)
				            $lastPeriod = $this->getLastEvaluationInGrade();
				            $this->evaluation_id = $lastPeriod;
				            Yii::app()->session['Evaluation']=$this->evaluation_id;

               	        	
               	          }
               	         
		            }

		  }
		else
		 {
			 if((Yii::app()->user->profil!='Teacher'))
     			 {	    if(isset($_POST['Shifts']))
			               	{  //on n'a pas presser le bouton, il faut charger apropriate rooms
							     $modelShift->attributes=$_POST['Shifts'];
					              $this->idShift=$modelShift->shift_name;
					              
											  
								   $modelSection->attributes=$_POST['Sections'];
								   $this->section_id=$modelSection->section_name;
							     						
								   $modelLevel->attributes=$_POST['LevelHasPerson'];
								   $this->idLevel=$modelLevel->level;
								   
								   $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['Rooms']=$this->room_id; 
								   
								   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id=$modelCourse->subject;
								   Yii::app()->session['Courses']=$this->course_id;
								   
								   $modelEvaluation->attributes=$_POST['EvaluationByYear'];
								   $this->evaluation_id=$modelEvaluation->evaluation;
								   Yii::app()->session['Evaluation']=$this->evaluation_id;
							
		             
					         $this->use_update=false;
		                    if(($this->room_id!="")&&($this->course_id!="")&&($this->evaluation_id!=""))
						        {
				                     $check = $this->checkDdataByEvaluation($this->evaluation_id, $this->course_id);
							 
									 if($check)
									  { $this->use_update=true; }
										  	
						        }
					       
								   
				             }				   
							else
							{  $this->idShift=null;
						       $this->section_id=null;
							   $this->idLevel=null;
							   $this->room_id=null;
							   $this->course_id=null;
							   
							   //return an id(number)
					            $lastPeriod1 = $this->getLastEvaluationInGrade();
					            $this->evaluation_id = $lastPeriod1;
					            Yii::app()->session['Evaluation']=$this->evaluation_id;
				            
							}
				
     			 }//fen  if((Yii::app()->user->profil!='Teacher'))
                else // Yii::app()->user->profil=='Teacher'
                  {
                  	                      	   
                  	   if(isset($_POST['Rooms']))
			               	{  //on n'a pas presser le bouton, il faut load apropriate rooms
							    
								   $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['Rooms']=$this->room_id;
								   
								   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id=$modelCourse->subject;
								   Yii::app()->session['Courses']=$this->course_id;
								   
								   $modelEvaluation->attributes=$_POST['EvaluationByYear'];
								   $this->evaluation_id=$modelEvaluation->evaluation;
								   Yii::app()->session['Evaluation']=$this->evaluation_id;
							
		           
					         $this->use_update=false;
		                    if(($this->room_id!="")&&($this->course_id!="")&&($this->evaluation_id!=""))
						        {
				                     $check = $this->checkDdataByEvaluation($this->evaluation_id, $this->course_id);
							 
									 if($check)
									  { $this->use_update=true; }
										  	
						        }
					  
								   
				             }				   
							else
							{  $this->room_id=null;
							   $this->course_id=null;
							   
							   //return an id(number)
					            $lastPeriod2 = $this->getLastEvaluationInGrade();
					            $this->evaluation_id = $lastPeriod2;
					            Yii::app()->session['Evaluation']=$this->evaluation_id;
				            
							}
                  	
                    }// Yii::app()->user->profil=='Teacher'
                    
				
	         }
	         
	         
			 if(isset($_POST['create']))
				  { //on vient de presser le bouton
						 //reccuperer les lignes selectionnees()
					$this->message_room_id=false;
					$this->message_course_id=false; 
					$this->message_evaluation_id=false;
					$this->success=false;
					$temwen=false;
			        
					$this->message_noGradeEntered=false;
					   $this->message_GradeHigherWeight=false;	
					   $no_stud_has_grade=true;
                    $weight = ' ';
                     
                     $result = Courses::model()->getWeight($this->course_id);
                    $result =$result->getData();
                    foreach($result as $r)
                      $weight = $r->weight;
			      
				 
				 if($this->extern)
				  {
			  	         $grade=0;
			  	         $comment='';
					   
					   //tcheke si stud la record pou evaluation sa deja, pran ID a Update li
					   
					   //sinon akseptel kom nouvo ensesyon
					   
					   $this->message_noGradeEntered=false;
					   $no_stud_has_grade=true;
					   
					  foreach($_POST['id_stud'] as $id)
                        {   	   
						           if(isset($_POST['grades'][$id])&&($_POST['grades'][$id]!=''))
						                $no_stud_has_grade=false;
							
						}
						
					  
					if(!$no_stud_has_grade) 
						{  foreach($_POST['id_stud'] as $id)
	                        {   	   
							           if(isset($_POST['grades'][$id]))
							                $grade=$_POST['grades'][$id];
										else
											$grade=0;
											
									    if(isset($_POST['comments'][$id]))
							                $comment=$_POST['comments'][$id];
										else
											$comment='';
						               
								   //check if grade is higher than the course weight	
									if($grade <= $weight)  	   
										{      
										   $model->setAttribute('student',$id);
										   $model->setAttribute('course',$this->course_id);
										   $model->setAttribute('evaluation',$this->evaluation_id);
										   $model->setAttribute('grade_value',$grade);
										   $model->setAttribute('comment',$comment);
										   $model->setAttribute('date_created',date('Y-m-d'));
										   $model->setAttribute('create_by',Yii::app()->user->name);
										   
										   if($model->save())
			                                 {  
											   $model->unSetAttributes();
											   $model= new Grades;
											   
											   $temwen=true;
											   
									         }
									         
									 	 }
								    else
						               {
						              	     
						              	     $this->message_GradeHigherWeight=true;
						              	 
						               }   
		                     
							}
				        }
				      else //message vous n'avez entre aucune note
						{
							$this->message_noGradeEntered=true;
							
							}
						
				  	  $this->extern=false;
					}
				 else
					{		 
					 if(($this->room_id!="")&&($this->course_id!="")&&($this->evaluation_id!=""))
				        {         $grade=0;
				                  $comment='';
						   
								     $this->message_noGradeEntered=false;
							   $no_stud_has_grade=true;
							   
							  foreach($_POST['id_stud'] as $id)
		                        {   	   
								           if(isset($_POST['grades'][$id])&&($_POST['grades'][$id]!=''))
								                $no_stud_has_grade=false;
									
								}
								
							  
							if(!$no_stud_has_grade) 
								{  
								   foreach($_POST['id_stud'] as $id)
			                        {   	   
									        if(isset($_POST['grades'][$id]))
								                $grade=$_POST['grades'][$id];
											else
												$grade=0;
												
												
											if(isset($_POST['comments'][$id]))
								                $comment=$_POST['comments'][$id];
											else
												$comment='';
							           
							                   //check if grade is higher than the course weight
						           if($grade <= $weight)  
						             {  
								      
								       }
						            else
						              {
						              	 $grade='';
						              	 $this->message_GradeHigherWeight=true;
						              	 
						               }
           
									       $model->setAttribute('student',$id);
										   $model->setAttribute('course',$this->course_id);
										   $model->setAttribute('evaluation',$this->evaluation_id);
										   $model->setAttribute('grade_value',$grade);
										   $model->setAttribute('comment',$comment);
										   $model->setAttribute('date_created',date('Y-m-d'));
										   $model->setAttribute('create_by',Yii::app()->user->name);
										   
										   if($model->save())
			                                 {  
											   $model->unSetAttributes();
											   $model= new Grades;
											   
											   $temwen=true;
											   
									         }
			                     
										}
										
				                  }
				                else //message vous n'avez entre aucune note
									{
										$this->message_noGradeEntered=true;
							        }
							        
							        
							}						     
						   else
						     {
						     	if($this->room_id=="")
						     	  $this->message_room_id=true;
						     	  
						     	if($this->course_id=="")
						     	  { $this->message_course_id=true;
						     	     $this->message_room_id=true;
						     	  }
						     	  
						     	if($this->evaluation_id=="")
						     	  { $this->message_evaluation_id=true;
						     	    $this->message_room_id=true;
						     	  }
						      }
						      
						   }
						
						if($temwen)
						  $this->success=true;
						  
						
						$this->room_id=null;
						
					
						
		   }
		   
		   
		    if(isset($_POST['cancel']))
              {
                 
                     $this->redirect(Yii::app()->request->urlReferrer);
                          
                 }
		
		
		$this->render('create',array(
			'model'=>$model,
		));
		
	}

	
	
	
	
	
	public function actionUpdate()
	{   
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

		       $this->message_UpdateValidate=false;
		       $this->message_UpdateValidate1=false;
		       $this->message_UpdatePublish=false;
		       $this->message_noGrades=false;
		       $this->message_gradesOk=false;
		       $this->messageNoCheck=false;
		       
		       $this->message_GradeHigherWeight=false;
		      
		       $weight = ' ';
                     
		      
		 if(!isset($_GET['all']))
		  {  $model=$this->loadModel();
              $this->performAjaxValidation($model);
		      
		           
		        $result = Courses::model()->getWeight($model->course);
                    $result =$result->getData();
                    foreach($result as $r)
                      $weight = $r->weight;

           if((Yii::app()->user->profil=='Admin'))
		     { 
		     	if(isset($_POST['update']))
				   {   //on vient de presser le bouton
								 //reccuperer le ligne modifiee
									 $grade=0;
									 $comment='';
									 
							   foreach($_POST['id_stud'] as $id)
								{   	   
										   if(isset($_POST['grades'][$id]))
												$grade=$_POST['grades'][$id];
												
												
											if(isset($_POST['comments'][$id]))
								                $comment=$_POST['comments'][$id];
																						
										   
										  if($grade<=$weight) 
										  {
										  	  $model->setAttribute('date_updated',date('Y-m-d'));
										      $model->setAttribute('grade_value',$grade);
										      $model->setAttribute('comment',$comment);
										      $model->setAttribute('update_by',Yii::app()->user->name);
										   
										   
										     if($model->save())
											    { 											   
											      $this->redirect(array('view','id'=>$model->id,'from'=>'stud'));
											    }
											 
										   }
										 else
										   $this->message_GradeHigherWeight=true;

								 
								}
					
					
						
				}
		     }
		    else                 
		      {   if(($model->validate!=1))   //rasire ke se pou pwofese li tcheke
		             {
		             	if(isset($_POST['update']))
				          {   //on vient de presser le bouton
								 //reccuperer le ligne modifiee
									 $grade=0;
									 $comment='';
									 
							   foreach($_POST['id_stud'] as $id)
								{   	   
										   if(isset($_POST['grades'][$id]))
												$grade=$_POST['grades'][$id];
											
										   	
											if(isset($_POST['comments'][$id]))
								                $comment=$_POST['comments'][$id];
											
											
										  if($grade<=$weight) 
										  {
										  	  $model->setAttribute('date_updated',date('Y-m-d'));
										      $model->setAttribute('grade_value',$grade);
										      $model->setAttribute('comment',$comment);
										      $model->setAttribute('update_by',Yii::app()->user->name);
										   
										   
										     if($model->save())
											    { 											   
											      $this->redirect(array('view','id'=>$model->id,'from'=>'stud'));
											    }
											 
										   }
										 else
										   $this->message_GradeHigherWeight=true;

								 
								}
					
					
						
				             }
		             	
		             	 }
				     else
				       {
				       	   
				       	     $url=Yii::app()->request->urlReferrer;
				       	     $this->redirect($url.'&msguv=y');
				       	     
				       	 
				       	}
				
		      }
				if(isset($_POST['cancel']))
                          {
                             
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }
                          
		     
		       	 
		       	 
		  }
		elseif($_GET['all']==1)
		 {	$model=new Grades;
			$modelRoom=new Rooms;
			$modelCourse=new Courses;
			$modelEvaluation= new EvaluationByYear;
			$this->message_UpdateValidate=false;
		
			if(isset($_POST['Rooms']))
					{        						   
								$this->message_noGrades=false;
								
							   $modelEvaluation->attributes=$_POST['EvaluationByYear'];
								   $this->evaluation_id=$modelEvaluation->evaluation;
								   Yii::app()->session['Evaluation']=$this->evaluation_id;

                                    $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['Rooms']=$this->room_id;
								   
								   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id=$modelCourse->subject;
								   Yii::app()->session['Courses']=$this->course_id;
								   
				   
							   
							   
					         if(($this->course_id!='')&&($this->evaluation_id!=''))
					          { $result = Grades::model()->searchByRoom($this->course_id,$this->evaluation_id);
                  
                   
                    			   $content=$result->getData();
                    			     if($content==null)
							                $this->message_noGrades=true;
							          else
							             { 
							                   $this->message_noGrades=false;
							                  
							                 			                                   
							              }
									 
							   }  
							   
						    
					           $result = Courses::model()->getWeight($this->course_id);
                    $result =$result->getData();
                    foreach($result as $r)
                      $weight = $r->weight;  
 
												   
					 }
				
				  	if((Yii::app()->session['Courses']!='')&&( Yii::app()->session['Evaluation']!=''))
				  	  {
				  	  	$result = Grades::model()->searchByRoom(Yii::app()->session['Courses'],Yii::app()->session['Evaluation']);
                   
                   
                    			   $content=$result->getData();
                    			     if($content!=null)
							           { 
							                   
							                 if((Yii::app()->user->profil!='Admin')&&(Yii::app()->user->profil!='Manager'))
			                                   { 
							                     foreach($content as $g)
										           {
													if($g->validate==1)
													  {
													  	
												        $this->message_UpdateValidate=true;
												        
																			       	     
													   }
												  }
			                                   }
			                                   
							              }
							              
							              
				  	  	}
				  	  	
				  //	} 
					 
					 
		
		if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))
			{
			    
				if(isset($_POST['update']))
					{   //on vient de presser le bouton
									 //reccuperer le ligne modifiee
						$this->message_UpdateValidate=false;
						
						$this->message_UpdatePublish=false;
						$this->success_=0;
						$update_validate=false;
						$ok=false;
						$this->message_GradeHigherWeight=false;
						
						$ok_update_validate=false;
						
										 $grade=0;
									 $comment='';
										 $average=0;
										 $nbr_grade=0;
						 
							   foreach($_POST['id_stud'] as $grade_id)
							     {  
							     	$nbr_grade++;
							     	 
							     	
							     	if(isset($_POST['grades'][$grade_id]))
										$grade=$_POST['grades'][$grade_id];
										
									if(isset($_POST['comments'][$grade_id]))
								        $comment=$_POST['comments'][$grade_id];
							     	
							     	$model=Grades::model()->findbyPk($grade_id);	   
											   
							
                                           if(($model->publish!=1))
		                                    {                                                
											   
											   if($grade<=$weight) 
											      {   
										     	     $average=$average+ $grade;
										     	    
										     	    $model->setAttribute('date_updated',date('Y-m-d'));
											        $model->setAttribute('grade_value',$grade);	
											         $model->setAttribute('comment',$comment);
											         $model->setAttribute('update_by',Yii::app()->user->name);									     	   
											        
											       }
											     else
												   $this->message_GradeHigherWeight=true;

                                                                                           
											   if($model->save())
												 {  
												   $model->unSetAttributes();
												   $model= new Grades;
												   $this->success_=1;
												   $ok=true;
												   
												 }
		                                     }
		                                   else
									         {       $groupid=Yii::app()->user->groupid;
					                                 $group=Groups::model()->findByPk($groupid);
					                                 $group_name=$group->group_name;
					 								
					 							
					 							if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))
					 							  {
							 							if($grade<=$weight) 
													      {   
												     	     $average=$average+ $grade;
												     	    
												     	    $model->setAttribute('date_updated',date('Y-m-d'));
													        $model->setAttribute('grade_value',$grade);	
													         $model->setAttribute('comment',$comment);									     	                                                         $model->setAttribute('update_by',Yii::app()->user->name);
													        
													       }
													     else
														   $this->message_GradeHigherWeight=true;
                                          
													   
													   if($model->save())
														 {  
														   $model->unSetAttributes();
														   $model= new Grades;
														   $this->success_=1;
														   $ok=true;
														   $ok_update_validate=true;
														   
														 }

					 							   }
					 							 elseif((Yii::app()->user->profil!='Admin')&&(Yii::app()->user->profil!='Manager'))
					 							  {

										         	
										             $url=Yii::app()->request->urlReferrer;
			       	    							 
			       	    							 $update_validate=true;
			       	    							 $this->message_UpdateValidate=true;
			       	    							 $this->message_UpdatePublish=true;
			       	    							 
					 							   }
					 							   
					 							   
									          }
									}
							    
								
						if(($ok==true)||($ok_update_validate==true))	     
						  { $this->success_=1;
							         //******** SUBJECT AVERAGE BY PERIOD  ************//
                            if($nbr_grade>0)
                             {  $average=$average/$nbr_grade;
										 
			      	//save subject average for this period			  
						  $command = Yii::app()->db->createCommand();
						   //check if already exit
							  $data =  Grades::model()->checkDataSubjectAverage($acad_sess,$this->evaluation_id,$this->course_id);
							  $is_present=false;
							       if($data)
								     $is_present=true;
								  
                                if($is_present){// yes, update
								
								    $command->update('subject_average', array(
											'average'=>$average,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name,
										), 'academic_year=:year AND evaluation_by_year=:period AND course=:course', array(':year'=>$acad_sess, ':period'=>$this->evaluation_id, ':course'=>$this->course_id));
                                   }
								 else{// no, insert
								   $command->insert('subject_average', array(
										'academic_year'=>$acad_sess,
										'evaluation_by_year'=>$this->evaluation_id,
										'course'=>$this->course_id,
										'average'=>$average,
										'create_by'=>Yii::app()->user->name,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								 
                             }
							       

							      
							      
							   $this->redirect (array('update?all=1&from=stud&mn=std&ok=yes&greater='.$this->message_GradeHigherWeight));
						  }
						if($update_validate)
						  { $this->message_UpdateValidate=true;
						      $this->redirect (array('update?all=1&from=stud&mn=std&msguv=y'));
						   }
						else
						  $this->redirect (array('index?from=stud'));
							
					}
						
			}
		 else
		   {	
		   	
		   	
			 if($this->message_UpdateValidate==false)   //rasire ke se pou pwofese li tcheke
		       {
		 
				if(isset($_POST['update']))
					{   //on vient de presser le bouton
									 //reccuperer le ligne modifiee
						$this->message_UpdateValidate=false;
						
						$this->message_UpdatePublish=false;
						$this->success_=0;
						$update_validate=false;
						$ok=false;
						$this->message_GradeHigherWeight=false;
						
						$ok_update_validate=false;
						
										 $grade=0;
									 $comment='';
										 $average=0;
										 $nbr_grade=0;
						
							   foreach($_POST['id_stud'] as $grade_id)
							     {  
							     	$nbr_grade++;
							     	
							     	
							     	if(isset($_POST['grades'][$grade_id]))
										$grade=$_POST['grades'][$grade_id];
										
									if(isset($_POST['comments'][$grade_id]))
								        $comment=$_POST['comments'][$grade_id];
							     	
							     	$model=Grades::model()->findbyPk($grade_id);	   
											   
							
												
                                           if(($model->publish!=1))
		                                    {                                                
											   
											   if($grade<=$weight) 
											      {   
										     	     $average=$average+ $grade;
										     	    
										     	    $model->setAttribute('date_updated',date('Y-m-d'));
											        $model->setAttribute('grade_value',$grade);	
											         $model->setAttribute('comment',$comment);	
											         $model->setAttribute('update_by',Yii::app()->user->name);								     	   
											        
											       }
											     else
												   $this->message_GradeHigherWeight=true;

                                                                                           
											   if($model->save())
												 {  
												   $model->unSetAttributes();
												   $model= new Grades;
												   $this->success_=1;
												   $ok=true;
												  
												 }
		                                     }
		                                   else
									         {       $groupid=Yii::app()->user->groupid;
					                                 $group=Groups::model()->findByPk($groupid);
					                                 $group_name=$group->group_name;
					 								
					 							
					 							if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))
					 							  {
							 							if($grade<=$weight) 
													      {   
												     	     $average=$average+ $grade;
												     	    
												     	    $model->setAttribute('date_updated',date('Y-m-d'));
													        $model->setAttribute('grade_value',$grade);	
													         $model->setAttribute('comment',$comment);
													         $model->setAttribute('update_by',Yii::app()->user->name);									     	   
													        
													       }
													     else
														   $this->message_GradeHigherWeight=true;
                                          
													   
													   if($model->save())
														 {  
														   $model->unSetAttributes();
														   $model= new Grades;
														   $this->success_=1;
														   $ok=true;
														   $ok_update_validate=true;
														   
														 }

					 							   }
					 							 elseif((Yii::app()->user->profil!='Admin')&&(Yii::app()->user->profil!='Manager'))
					 							  {

										         	
										             $url=Yii::app()->request->urlReferrer;
			       	    							 
			       	    							 $update_validate=true;
			       	    							 $this->message_UpdateValidate=true;
			       	    							 $this->message_UpdatePublish=true;
			       	    							 
					 							   }
					 							   
					 							   
									          }
									}
							     //}
								
						if(($ok==true)||($ok_update_validate==true))	     
						  { $this->success_=1;
							         //******** SUBJECT AVERAGE BY PERIOD  ************//
                            if($nbr_grade>0)
                             {  $average=$average/$nbr_grade;
										 
			      	//save subject average for this period			  
						  $command = Yii::app()->db->createCommand();
						   //check if already exit
							  $data =  Grades::model()->checkDataSubjectAverage($acad_sess,$this->evaluation_id,$this->course_id);
							  $is_present=false;
							       if($data)
								     $is_present=true;
								  
                                if($is_present){// yes, update
								
								    $command->update('subject_average', array(
											'average'=>$average,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name,
										), 'academic_year=:year AND evaluation_by_year=:period AND course=:course', array(':year'=>$acad_sess, ':period'=>$this->evaluation_id, ':course'=>$this->course_id));
                                   }
								 else{// no, insert
								   $command->insert('subject_average', array(
										'academic_year'=>$acad_sess,
										'evaluation_by_year'=>$this->evaluation_id,
										'course'=>$this->course_id,
										'average'=>$average,
										'create_by'=>Yii::app()->user->name,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								 
                             }
							       

							      
							      
							   $this->redirect (array('update?all=1&from=stud&mn=std&ok=yes&greater='.$this->message_GradeHigherWeight));
						  }
						if($update_validate)
						  { $this->message_UpdateValidate=true;
						      $this->redirect (array('update?all=1&from=stud&mn=std&msguv=y'));
						   }
						else
						  $this->redirect (array('index?from=stud'));
							
					}
					
					
				  }
				else
				  {
				      
				      $url=Yii::app()->request->urlReferrer;
				      $this->redirect($url.'&msguv=y');
				       
				       	 
				    }
					
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
	
	public function actionValidatePublish()
	{   
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		
		    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
        if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1, 2) AND ';
						        }

      

		
			$model=new Grades;
			$modelRoom=new Rooms;
			$modelCourse=new Courses;
			$modelEvaluation= new EvaluationByYear;
			
			$ok=false;
			$grades_average=0;
			$number_of_grades=0;
			
			if(isset($_POST['Rooms']))
					{        						   
							   $modelRoom->attributes=$_POST['Rooms'];
							   $this->room_id=$modelRoom->room_name;
							   
							   $modelEvaluation->attributes=$_POST['EvaluationByYear'];
							   $this->evaluation_id=$modelEvaluation->evaluation;
								
							   $modelCourse->attributes=$_POST['Courses'];
							   $this->course_id=$modelCourse->subject;
							   
							   				   
					 
					         if(($this->evaluation_id!=''))
					          { $result1 = Courses::model()->searchByRoomIdToValidateGrades($this->room_id,$this->evaluation_id,$acad_sess);
					           	     $content1=$result1->getData();
						      if((isset($content1))&&($content1==null))
					                $this->message_course_already_validate=true;
					          else
					              $this->message_course_already_validate=false;
					          }	
					          
					          
					         if(($this->course_id!='')&&($this->evaluation_id!=''))
					          { $result = Grades::model()->searchToValidate($condition,$this->course_id,$this->evaluation_id);
                              
                    			   
									     $content=$result->getData();
						      if((isset($content))&&($content==null))
					                $this->message_already_validate=true;
					          else
					              $this->message_already_validate=false;
					          }			 
					 
					 }
				   else
				     {
				     	  //return an id(number)
				            $lastPeriod3 = $this->getLastEvaluationInGrade();
				            $this->evaluation_id = $lastPeriod3;

				     	}
				     	
					 
				if(isset($_POST['validate_publish']))
					{   //on vient de presser le bouton
									 //reccuperer le ligne modifiee
							
							
							
							if(isset($_POST['chk'])) 
							  {
							   foreach($_POST['chk'] as $grade)
							     {  
							     	$this->grade_id=$grade;
							     	
							     	$model=Grades::model()->findbyPk($this->grade_id);
                                                    
											   
                                                                                           
											$grades_average += $model->grade_value;
											$number_of_grades++;
											
											   $model->setAttribute('date_updated',date('Y-m-d'));
											   $model->setAttribute('validate',1);
											   $model->setAttribute('publish',1);
                                                                                           
											   
											   if($model->save())
												 {  
												   $model->unSetAttributes();
												   $model= new Grades;
												   $ok=true;
												  
												 }

							     	
							     	}
							   }
							 else
							    $this->messageNoCheck=true;  
							 
							   								
						
							
					}
			elseif(isset($_POST['validate']))
			     {     //on vient de presser le bouton
									 //reccuperer le ligne modifiee
							if(isset($_POST['chk'])) 
							  {
							   foreach($_POST['chk'] as $grade)
							     {  
							     	$this->grade_id=$grade;
							     	
							     	$model=Grades::model()->findbyPk($this->grade_id);
                                                    
											   
                                               
                                               $grades_average += $model->grade_value;
											$number_of_grades++;
											
                                                                                           
											   $model->setAttribute('date_updated',date('Y-m-d'));
											   $model->setAttribute('validate',1);
											                                                                                              
											   
											   if($model->save())
												 {  
												   $model->unSetAttributes();
												   $model= new Grades;
												   $ok=true;
												   
												 }

							     	
							     	}
							    }
							  else
							    $this->messageNoCheck=true;
			     	
			     	
			     	}
			    elseif(isset($_POST['publish']))
			      {
			      	//on vient de presser le bouton
									 //reccuperer le ligne modifiee
							if(isset($_POST['chk'])) 
							  {
							   foreach($_POST['chk'] as $grade)
							     {  
							     	$this->grade_id=$grade;
							     	
							     	$model=Grades::model()->findbyPk($this->grade_id);
                                                    
											  
                                          if($model->validate==1)
                                            {                                               
											   $this->message_validate=false;
											   
											   $model->setAttribute('date_updated',date('Y-m-d'));
											   $model->setAttribute('publish',1);
                                                                                           
											   
											   if($model->save())
												 {  
												   $model->unSetAttributes();
												   $model= new Grades;
												   $ok=true;
												  
												 }
												 
                                            }
                                           elseif($model->validate==0)
                                             { 
                                             	$this->message_validate=true;
                                             	$model->unSetAttributes();
												   $model= new Grades;
                                             	
                                             	}
												 
												 

							     	
							     	}
							   
							  }
							  else
							    $this->messageNoCheck=true;
			      	
			      	}
			      elseif(isset($_POST['cancel']))
                          {
                              
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }	 
		 
		    if($ok)
		      { $this->success=true;
		            
		             //******** SUBJECT AVERAGE BY PERIOD  ************//
 
			      if(($grades_average!=0)&&($number_of_grades!=0))
					{		
						$grades_average = round(($grades_average/$number_of_grades),2);
						
											
				

			      	//save subject average for this period			  
						  $command = Yii::app()->db->createCommand();
						   //check if already exit
							  $data =  Grades::model()->checkDataSubjectAverage($acad_sess,$this->evaluation_id,$this->course_id);
							  $is_present=false;
							       if($data)
								     $is_present=true;
								  
                                if($is_present){// yes, update
								
								    $command->update('subject_average', array(
											'average'=>$grades_average,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name,
										), 'academic_year=:year AND evaluation_by_year=:period AND course=:course', array(':year'=>$acad_sess, ':period'=>$this->evaluation_id, ':course'=>$this->course_id));
                                   }
								 else{// no, insert
								   $command->insert('subject_average', array(
										'academic_year'=>$acad_sess,
										'evaluation_by_year'=>$this->evaluation_id,
										'course'=>$this->course_id,
										'average'=>$grades_average,
										'create_by'=>Yii::app()->user->name,
										'date_created'=>date('Y-m-d'),
									));
									
								     
								     }
								 
					   } 
					   
					   
							       
		       }
		    else
		    $this->success=false;


		$this->render('validatePublish',array(
			'model'=>$model,
		));
	   
	}
	
	
	

	public function actionDelete()
	{
	  
		
		try {
			    $_model = $this->loadModel();
			    if(($_model->validate!=1))   //rasire ke se pou pwofese li tcheke
			       $_model->delete();
			    else
			     { if((Yii::app()->user->profil=='Admin'))
			           $_model->delete();
			       
			      }
		      
   			 
   			 
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect( array('index'));
			
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
		$this->template_update_only = false;
	
	  $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'student0.active IN(1, 2) AND ';
						        }
         
       
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		
		if((Yii::app()->user->profil!='Teacher'))	    
	      {  $dataProvider=Grades::model()->search($condition,$acad_sess);
	      	 $title = Yii::t('app','List of student grades: ');
	      	
	      	$model=new Grades('search');
			if(isset($_GET['Grades']))
				$model->attributes=$_GET['Grades'];
	              
	       }
	      else 
	       {  
	       	
	       	$id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				
			 $dataProvider=Grades::model()->search($condition,$acad_sess);
	      	 $title = Yii::t('app','List of student grades: ');
	      	
	      	$model=new Grades('search');
	      	if(isset($_GET['Grades']))
				$model->attributes=$_GET['Grades'];
	               
	         }
	         
	             // Here to export to CSV 
	                if($this->isExportRequest()){
	                $this->exportCSV(array($title), null,false);
	               
	                $this->exportCSV($dataProvider, array(
	                'student0.fullName',
	                'course0.courseName',
	                'evaluation0.examName',
	                'grade_value',
	                'course0.weight',
	                'comment')); 
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
	        
	
	public function actionListByRoom()
	{
		$model=new Grades;
		$modelRoom=new Rooms;
		$modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;

		$modelCourse=new Courses;
		$modelEvaluation= new EvaluationByYear;
		
		$academic= new AcademicPeriods;
	        
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		
		    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1, 2) AND ';
						        }

      

	
	
	
if((Yii::app()->user->profil!='Teacher'))
  {		
	
		
		if(isset($_POST['Shifts']))
               	{        						   
						   $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
						  	                     
				          $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   						  						
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   
						   $modelRoom->attributes=$_POST['Rooms'];
						   $this->room_id=$modelRoom->room_name;
						   
						   
						   
						   $modelEvaluation->attributes=$_POST['EvaluationByYear'];
						   $this->evaluation_id=$modelEvaluation->evaluation;
                                                   
                         
											   
	             
	                 if(isset($_POST['viewPDF']))
	                  {
	                  	 if((isset($this->room_id))&&($this->room_id!=""))
			                { if((isset($this->evaluation_id))&&($this->evaluation_id!=""))
			                   {    $room=$this->getRoom($this->room_id);
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
									$evaluationPeriod=$this->getEvaluationPeriod($this->evaluation_id);
									$acadPeriod_for_this_room = $this->getAcademicPeriodName($acad_sess,$this->room_id);
                           
								
								// create new PDF document
								$pdf = new tcpdf('L', PDF_UNIT, 'array(216,356)', true, 'UTF-8', false); //legal: 216x356 mm  612.000, 1008.00 ; 11.00x17.00 :279x432 mm

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								
								
								//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
                                //Extract  email address 
                                $school_email_address = infoGeneralConfig('school_email_address');
                                //Extract Phone Number
                                $school_phone_number = infoGeneralConfig('school_phone_number');
								
								$include_discipline=0;
							   //Extract 
							   $include_discipline = infoGeneralConfig("include_discipline_grade");
							   //Extract max grade of discipline
								$max_grade_discipline = infoGeneralConfig('note_discipline_initiale');
						 
							   $include_discipline_comment=Yii::t('app',"Behavior grade is included in this average.");

                                                               
                                                                                             
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app','Grades by room'));
								$pdf->SetSubject(Yii::t('app','Grades by room'));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n\n\n");
								$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 

								// set margins
								$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

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
								$pdf->SetFont('dejavusans', '', 11, '', true);
								
//*******************************************/			
						 
	 
						// To find period name in in evaluation by year 
                                                                
                                                               $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
															if(isset($result))
															 {  $result=$result->getData();//return a list of  objects
																foreach($result as $r)
																  {
																	$period_exam_name= $r->name_period;
																   $period_acad_id = $r->id;
																   }
															 }
                                                               // end of code 
								     
							        $room=$this->getRoom($this->room_id); 
									$level=$this->getLevel($this->idLevel);
									$section=$this->getSection($this->section_id);
									$shift=$this->getShift($this->idShift);
									
									
								                
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();

								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

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
		margin-top:10px;
		margin-bottom:5px;
		
	}
	
	
	
	
	tr.couleur1 {
		background-color:#E5F1F4;
		font-size: 0.9em;
	}
	
	tr.couleur2 {
		background-color:#F8F8F8;
		font-size: 0.9em;
	}
	
	td.couleur1 {
		background-color:#E5F1F4;
		font-size: 0.9em;
	}
	
	td.couleur2 {
		background-color:#F8F8F8;
		font-size: 0.9em;
	}
	
		
	 
	 .tb
	  {
	      width:86%; 
	     // font-size: 0.9em;
	    //  background-color: #c9d4dd; 
	     // color: #1E65A4;	    
	  `}
	  
	 td.stud_name
	  {
	      width:176px;	
	  	
	  }
	  
	 td.stud_name1
	  {
	      width:176px;
	      text-align:left; 
	      border-bottom: 3px solid  #FFF;
	      border-right: 3px solid  #FFF; 
	      border-top: 3px solid  #FFF;
	      font-size: 0.8em;
	  	
	  }
	  
	td.average
	     {
	        width:65px;	
	        font-size: 0.8em;
	     }
	     
	 td.average1
	     {
	        width:65px;
	        text-align:center; 
	        border-bottom: 3px solid  #FFF; 
	        border-right: 3px solid  #FFF; 
	        border-top: 3px solid  #FFF;
	        font-size: 0.9em;
	        	
	     }
	     
	td.course
	    {
	     text-align:center; 
	     border-left: 1px solid  #FFF;
	     font-size: 0.7em; 
	     //width:100px ; 	
	    }
	    
	td.coeff
	    {
	     text-align:center; 
	     border-left: 1px solid  #FFF;
	     font-size: 0.7em;
	      
	     //width:100px ; 	
	    }
	    
	td.grade
	    {
	     text-align:center; 
	    font-size: 0.8em; 
	    
	   
	    } 
	 
	  
	.header {
		width:1px;
		-webkit-transform:rotate(-85deg);
		-moz-transform:rotate(-85deg);
		-o-transform:rotate(-85deg);
		-ms-transform:rotate(-85deg);
		transform:rotate(-85deg);
	}
	
		
	td.subject {
		width:50%;
		
		
	}
	
	
	
	
</style>
                                       
										<div class="title" >
EOD;
	 
				   						$html .=strtoupper(Yii::t('app','Grades By Room ')).'<br/>'.$evaluationPeriod.' : '.$period_exam_name.'</div> '; 
										$html .='<div class="info" ><b>'.Yii::t('app','Level / Room: ').'</b> '.$level.' / '.$room.'<br/> <b>'.Yii::t('app','Section / Shift: ').'</b> '.$section.' / '.$shift.'<br/><b>'.Yii::t('app','Academic period: ').'</b> '.$acadPeriod_for_this_room->name_period.'
														  </div>'; 
														  
			$total_succ =0;
			   $total_fail=0;
			
			
			$stud_order_desc_average = array();
				$max_average = 0;
				$max_average_ = 0;
				$min_average = 0;
				$success_f = 0;
				$success_m = 0;
				
				
											  
									 //totall etudiant
			 $dataProvider_studentEnrolled=Rooms::model()->getStudentsEnrolled($condition,$this->room_id, $acad_sess);
			  if(isset($dataProvider_studentEnrolled))
			    {  $t=$dataProvider_studentEnrolled->getData();
				   foreach($t as $tot)
				       $tot_stud=$tot->total_stud;
				}
			 
			   //moyenne de la classe
			 $classAverage=$this->getClassAverage($this->room_id, $acad_sess);
			
			 //total reussi, et echoue
			    //moyenne de passage classe
			    $passing_grade=$this->getPassingGrade($this->idLevel,$acad_sess); //note de passage pour la classe
			    
			   //Extract average base
			  $average_base = infoGeneralConfig('average_base');
								   				
								   				 
			 $dataProvider_studentEnrolledInfo= Rooms::model()->getInfoStudentsEnrolled($condition,$this->room_id, $acad_sess); 
			 if(isset($dataProvider_studentEnrolledInfo))
			    {  $t=$dataProvider_studentEnrolledInfo->getData();
				   foreach($t as $stud)
				      {
				      	  //moyenne yon elev
				      	 $averag=$this->getAverageForAStudent($stud->student_id, $this->room_id, $this->evaluation_id, $acad_sess);
				      	   
				      	 $stud_order_desc_average[$stud->student_id]= $averag;
				      	 
				      	 
				      	 if($passing_grade!='')
						  {
							   if($averag>=$passing_grade)
					      	    {  $total_succ ++;
					      	        
					      	        if($stud->gender == 1)
								        $success_f++;
								     elseif($stud->gender == 0)
								         $success_m++;
								         	   
					      	      }
					      	   elseif($averag<$passing_grade)
					      	      $total_fail ++;
				      	   
						   }
						 else
						   {   if($averag>=($average_base/2)) 
						         {  $total_succ ++;
					      	        
					      	        if($stud->gender == 1)
								        $success_f++;
								     elseif($stud->gender == 0)
								         $success_m++;
								         	   
					      	      }
					      	   elseif($averag<($average_base/2))
					      	      $total_fail ++;
						    }
				      	   				      	  
				      }
				}
			 
			//$min_average et $max_average_ 
			   arsort($stud_order_desc_average);
			     // get the first item in the $stud_order_desc_average
			     $max_average = reset($stud_order_desc_average);
			     
			     // get the last item in the $stud_order_desc_average
			     $min_average = end($stud_order_desc_average);
			
			
			 
			 
			$dataProvider=$this->getAllSubjects($this->room_id,$this->idLevel);
			
				
				
				//Grades for the current period
																	   				   
												   $k=0;
												   			 //liste des etudiants
			 $dataProvider_student=Persons::model()->getStudentsByRoomForGrades($condition,$this->room_id, $acad_sess);
			 
			 $total_row = $dataProvider_student->getItemCount();
			 
			 
				
              $couleur=1;
			 
			 //
		 $html .='<div style="float:left; font-size: 0.9em;">
			      
			       
			   <table class="" style="width:80%; background-color: #E5F1F4; color: #1E65A4; -webkit-border-top-left-radius: 5px;-webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
					   <tr>
					   
					   <td style="text-align:center;">'.Yii::t("app","Students Enrolled").' <br/>'.$tot_stud.'</td>
					       <td style="text-align:center; ">'.Yii::t("app","Passing Average").'<br/>';
					       
					       if($passing_grade!='') 
					           $html .= $passing_grade; 
					      else $html .='N/A';
					      
					       
					        $html .='</td>
					       <td style="text-align:center; ">'.Yii::t("app","Class Average").'<br/>'.$classAverage.'</td>
					       <td style="text-align:center; ">'.Yii::t("app","Max average").'<br/>'.$max_average.'</td>
					       <td style="text-align:center; ">'.Yii::t("app","Min average").'<br/>'.$min_average.'</td>
					       <td style="text-align:center; ">'.Yii::t("app"," Success(F)").'<br/>'.$success_f.'</td>
					       <td style="text-align:center; ">'.Yii::t("app"," Success(M)").'<br/>'.$success_m.'</td>
					       <td style="text-align:center; ">'.Yii::t("app"," Total Success").'<br/>'.$total_succ.'</td>
					       
					    </tr>
						</table>
				</div>
			      
			       
			       ';
	 $html .= '<div  style=" float:left;  margin-top:0px; ';		
			     	   $html .= 'color:blue;">';
				  if(isset($this->room_id)&&($this->room_id!=''))
					{ $html .= '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">'.Yii::t('app','- Averages descending order. -').' / '. Yii::t('app','- Weak grades are in <span style="color:red">Red</span>, <span style="color:black">Black</span> grades aren\'t validated yet. -').'</td>
					    </tr>
						</table>';
					  }
					    
				 $html .= '</div>';

			       			   
	$html .= ' 	<div >  
	
	       <table class="tb" >
  
      <!-- <thead>  -->
           <tr>
				    <td class="stud_name">. </td>
					<td class="average" >.</td>
				          ';
if($include_discipline==1)
   {    												
  	   $html .= ' <td class="course" >'.Yii::t('app','Discipline').'</td>';  		
		
   }
		//liste des cours
		while(isset($dataProvider[$k][0]))
				{
	              $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);         
			  
			      if($careAbout)
				     {			
						
				 // $dataProvider[$k][1] subject_name
				// $dataProvider[$k][3] short_subject_name
				
				 $html .= ' <td class="course" >'.$dataProvider[$k][3].'</td>';
				   
				      }
				      
				      $k++;
		        }
$html .= '	
     </tr>
  
  <tr style=""> 
     <td class="stud_name">'.Yii::t('app',"Student Name").' </td>
	<td class="average" >'.Yii::t('app',"Average").' </td>
    ';   
   
		 
		//coefficients
		$k=0;
		 if($include_discipline==1)
		   {    												
			  $html .= '<td class="coeff" ><b>'.$max_grade_discipline.'</b></td>'; 		
				
		   }		

		while(isset($dataProvider[$k][0]))
				{
	              $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);         
			  
			      if($careAbout)
				     {			
							 $html .= '<td class="coeff" ><b>'.$dataProvider[$k][2].'</b></td>';
														
					}
					
					$k++;
		  }
 $html .= '</tr>
	     	
	   	
	  <!-- </thead>	 -->
	   	
          
  	';
  	
  	    //pou chak elev
					       
					       if(isset($dataProvider_student))
			                 {  
				                 
								 
				             foreach($stud_order_desc_average as $stud_id =>$averageee)//($students as $stud)
				              {  
				              	 $k=0;
				              	 
							      if($couleur===1)  //choix de couleur																
									 $style_tr="couleur1";//"font-size: 0.9em; background: #E5F1F4;";
								 elseif($couleur===2)
									$style_tr="couleur2";//"font-size: 0.9em; background: #F8F8F8; ";
									
							    $html .= '<tr class="'.$style_tr.'">
								            <td class="stud_name1"> <div >
				  								<b>';
				  								$student_name = '';
				  								$mod_stud = Persons::model()->searchById($stud_id);
				  								$mod_stud = $mod_stud->getData();
				  								foreach($mod_stud as $stud)
				  								  $student_name = $stud->first_name.' '.$stud->last_name;
				  					
				  					$html .= $student_name;			
				  						$html .= '</b></div ></td>';
				
								$html .= '<td class="average1" ><b>';
										
										
										$average_ = $averageee;
										
										if($average_ < $passing_grade)
										 $html .= '<div style="color:red;">'.$average_.'</div>';
										else 
										   $html .= '<div >'.$average_.'</div>';
										
										
										$html .= '</b> </td>';
										
										if($include_discipline==1)
									  {		
											//discipline grade
											  $period_acad_id =null;
			                                  $result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
												 if(isset($result))
													{  $result=$result->getData();//return a list of  objects
														foreach($result as $r)
														 {
															$period_exam_name= $r->name_period;
															$period_acad_id = $r->id;
														  }
													  }
			                                    
			                                   $grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($stud->id, $period_acad_id);
																
											$html .= '<td class="grade">';
												$html .= '<div style="color:green;">'.$grade_discipline.'</div>';
                                            $html .= '</td>';

											
									   }
	
											  while(isset($dataProvider[$k][0]))
				                                {
	                                              $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);         
			  
			                                      if($careAbout)
				                                     {			
							                           
							                            //calculer grade puis afficher
																  
															$grades=Grades::model()->searchForReportCard($condition,$stud_id,$dataProvider[$k][0],$this->evaluation_id); 
																	if(isset($grades))
																		{
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade)
																			      {
																			        $html .= '<td class="grade">';
																			         $html .= '<div  style="';		
			     	                                                              $html .=  'color:blue;">';
																			        if($grade->grade_value!=null)
																			          {
																			          	 $html .=  '<div  style="';		
			     	                                                                        if($grade->validate==0)
																			           	      $html .=  'color:black;">';
																			           	     elseif($grade->grade_value<($dataProvider[$k][2]/2))
																			           	     { 																			           	       										 $html .= 'color:red;">';
																			           	      }
																			           	    elseif($grade->validate==1)
																			           	      $html .=  '">';
																			           	      
 																							$html .= $grade->grade_value;
 																							
 																							 $html .=  '</div>';
																			           	     
																			           }
																		           	 else
																			           {
																			           	 $html .= '<div style="';		
			     	                                                                        if($grade->validate==0)
																			           	      $html .= 'color:black;">';
																			           	    elseif($grade->grade_value<($dataProvider[$k][2]/2))
																			           	     { 																			           	       										 $html .= 'color:red;">';
																			           	      }
                                                                                           elseif($grade->validate==1)
																			           	      $html .= '">';
													
																								$html .= 'N/A';
																								 
																						    $html .= '</div>';
																			           	   
																			            }
																			            
																			            $html .= '</div>';
																			            
                                                                                     $html .= '</td>';
                                                                                                                                                        
                                                                                                                                                   
															                        }
																	             }
																                else
																                   $html .= '<td class="grade"><div >N/A</div ></td>';
																	$showButton=true;
																	
																         }//fin if(isset($grades))
															
														}//fin careAbout
														
														$k++;
					                    
				                                }//fin while(isset($dataProvider[$k][0]))								  
									   $couleur++;
	                                if($couleur===3) //reinitialisation
				                       $couleur=1;
								$html .= '</tr>';
								}// fin foreach($students as $stud)
							  
							 //class average
						    $html .= '<tr ><td></td></tr> <tr ><td class="stud_name">'.Yii::t('app','Class Average').' </td>';
                            $html .= ' <td > </td>';
						   if($include_discipline==1)
						   {    												
							   $html .= ' <td > </td>'; 		
								
						   }
								//liste des cours
								$k=0;
								while(isset($dataProvider[$k][0]))
									{
									  $careAbout=$this->isSubjectEvaluated($dataProvider[$k][0],$this->room_id,$this->evaluation_id);         
								  
									  if($careAbout)
										 {			
											
									 
									 $html .= ' <td class="grade" >'.course_average($dataProvider[$k][0],$this->evaluation_id).'</td>';
									   
										  }
										  
										  $k++;
									}
				
						$html .= '	
							 </tr>';						
							   
							  
							  
							  }// fin if(isset($dataProvider_student))
                    $html .= '
                    
                                               
                           </table>
                    
               </div>  ';   
      
                                           // $pdf->writeHTML($html, true, false, true, false, '');
		                                    // Print text using writeHTMLCell()
                                          $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
							 
								  
								$pdf->Output($room.'_'.$section.'_'.$shift.'_'.$acadPeriod_for_this_room->name_period, 'D');
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
	                  	
			                   }//fin isset(evaluation_id
			                   
			                   
			                   
			                }//fin isset(room_id
	                  	
	                  	
	                  }//fin isset($_POST['viewPDF'])
	             elseif(isset($_POST['validate_publish']))
					{   //on vient de presser le bouton
									
						$dataProvider_c=$this->getAllSubjects($this->room_id,$this->idLevel);
						
						$k=0;	
						//tcheke si yo valide-publiye deja
						  while(isset($dataProvider_c[$k][0]))
				             {
	                           $careAbout=$this->isSubjectEvaluated($dataProvider_c[$k][0],$this->room_id,$this->evaluation_id);         
			  
			                   if($careAbout)
				                 {		
				                 	//valide tout not kou sa
				                 	$command = Yii::app()->db->createCommand();
				                 	$command->update('grades', array(
													'validate'=>1,'publish'=>1,'date_updated'=>date('Y-m-d')
												), 'evaluation=:period AND course=:course', array(':period'=>$this->evaluation_id, ':course'=>$dataProvider_c[$k][0]));
												
				                 	
		                            
		                            
           
                                     //tout kalkile wayenn kou sa
                                     $subject_average = null;
                                     
                                     $sql='SELECT AVG(grade_value) as average FROM grades  WHERE course ='.$dataProvider_c[$k][0].' AND  evaluation='.$this->evaluation_id;
		 							 $result = Yii::app()->db->createCommand($sql)->queryAll();
           
							           foreach($result as $r)
							            $subject_average = $r["average"];   
                                     
                                     if($subject_average =!null)
                                      {
					                 	 $command1 = Yii::app()->db->createCommand();
									      //check if already exit
										  $data =  Grades::model()->checkDataSubjectAverage($acad_sess,$this->evaluation_id,$dataProvider_c[$k][0]);
										  $is_present=false;
										       if($data)
											     $is_present=true;
											  
			                                if($is_present){// yes, update
											
											    $command1->update('subject_average', array(
														'average'=>$subject_average,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name,
													), 'academic_year=:year AND evaluation_by_year=:period AND course=:course', array(':year'=>$acad_sess, ':period'=>$this->evaluation_id, ':course'=>$dataProvider_c[$k][0]));
			                                   }
											 else{// no, insert
											   $command1->insert('subject_average', array(
													'academic_year'=>$acad_sess,
													'evaluation_by_year'=>$this->evaluation_id,
													'course'=>$dataProvider_c[$k][0],
													'average'=>$subject_average,
													'create_by'=>Yii::app()->user->name,
													'date_created'=>date('Y-m-d'),
												));
												
											     
											     }
                                         }
				                 	 
				                 	  }
				                 
				                 $k++;
				                 
				               }	
							
							
							
					}
			elseif(isset($_POST['validate']))
			     {     //on vient de presser le bouton
									
						$dataProvider_c=$this->getAllSubjects($this->room_id,$this->idLevel);
						
						$k=0;	
						//tcheke si yo valide-publiye deja
						  while(isset($dataProvider_c[$k][0]))
				             {
	                           $careAbout=$this->isSubjectEvaluated($dataProvider_c[$k][0],$this->room_id,$this->evaluation_id);         
			  
			                   if($careAbout)
				                 {		
				                 	//valide tout not kou sa
				                 	$command = Yii::app()->db->createCommand();
				                 	$command->update('grades', array(
													'validate'=>1,'date_updated'=>date('Y-m-d')
												), 'evaluation=:period AND course=:course', array(':period'=>$this->evaluation_id, ':course'=>$dataProvider_c[$k][0]));
												
				                 	
		                            
		                            
           
                                     //tout kalkile wayenn kou sa
                                     $subject_average = null;
                                     
                                     $sql='SELECT AVG(grade_value) as average FROM grades  WHERE course ='.$dataProvider_c[$k][0].' AND  evaluation='.$this->evaluation_id;
		 							 $result = Yii::app()->db->createCommand($sql)->queryAll();
           
							           foreach($result as $r)
							            $subject_average = $r["average"];   
                                     
                                     if($subject_average =!null)
                                      {
					                 	 $command1 = Yii::app()->db->createCommand();
									      //check if already exit
										  $data =  Grades::model()->checkDataSubjectAverage($acad_sess,$this->evaluation_id,$dataProvider_c[$k][0]);
										  $is_present=false;
										       if($data)
											     $is_present=true;
											  
			                                if($is_present){// yes, update
											
											    $command1->update('subject_average', array(
														'average'=>$subject_average,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name,
													), 'academic_year=:year AND evaluation_by_year=:period AND course=:course', array(':year'=>$acad_sess, ':period'=>$this->evaluation_id, ':course'=>$dataProvider_c[$k][0]));
			                                   }
											 else{// no, insert
											   $command1->insert('subject_average', array(
													'academic_year'=>$acad_sess,
													'evaluation_by_year'=>$this->evaluation_id,
													'course'=>$dataProvider_c[$k][0],
													'average'=>$subject_average,
													'create_by'=>Yii::app()->user->name,
													'date_created'=>date('Y-m-d'),
												));
												
											     
											     }
                                         }
				                 	 
				                 	  }
				                 
				                 $k++;
				                 
				               }	
								
			     	
			     	
			     	}
			   
			      	    
	                 
	             
	             }//fin isset($_POST['Shift'])
               else
                 {
                 	if(Yii::app()->session['Evaluation'] =='')
	                  {	//return an id(number)
			            $lastPeriod1 = $this->getLastEvaluationInGrade();
			            $this->evaluation_id = $lastPeriod1;
						Yii::app()->session['Evaluation']=$this->evaluation_id;
	                  }
	                 else
						$this->evaluation_id = Yii::app()->session['Evaluation'];
						                    
                  }     
               
               
               
               
	}//fen if((Yii::app()->user->profil!='Teacher'))
else // Yii::app()->user->profil=='Teacher'
  {
			  			if(isset($_POST['Rooms']))
							{        						   
								$this->message_noGrades=false;
								
							      $modelEvaluation->attributes=$_POST['EvaluationByYear'];
								   $this->evaluation_id=$modelEvaluation->evaluation;
								   Yii::app()->session['Evaluation']=$this->evaluation_id;

                                    $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['Rooms']=$this->room_id;
								   
								   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id=$modelCourse->subject;
								   Yii::app()->session['Courses']=$this->course_id;
								   
				   
							 }
							else
							{
					                 	if(Yii::app()->session['Evaluation'] =='')
						                  {	//return an id(number)
								            $lastPeriod1 = $this->getLastEvaluationInGrade();
								            $this->evaluation_id = $lastPeriod1;
											Yii::app()->session['Evaluation']=$this->evaluation_id;
						                  }
						                else
						                  $this->evaluation_id = Yii::app()->session['Evaluation'];
					                  
									$this->room_id=Yii::app()->session['Rooms'];
								    $this->course_id=Yii::app()->session['Courses'];

							    	
							  }   
							
							
					         if(($this->course_id!='')&&($this->evaluation_id!=''))
					          { $result = Grades::model()->searchByRoom($this->course_id,$this->evaluation_id);
                    
                    			   $content=$result->getData();
                    			  if($content==null)
							                $this->message_noGrades=true;
							          else
							             { 
							                   $this->message_noGrades=false;
							                }
									 
									 
								}	
								
								
								
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			
			}
			
			$model=new Grades('searchForTeacherUserRoomCourse');
		if(isset($_GET['Grades']))
			$model->attributes=$_GET['Grades'];
                
                // Here to export to CSV 
                if($this->isExportRequest()){
                $this->exportCSV(array(Yii::t('app','List of grades by room: ')), null,false);
                
                $this->exportCSV($model->searchForTeacherUserRoomCourse($this->evaluation_id,$this->course_id, $acad_sess), array(
                'student0.fullName',
                'evaluation0.examName',    
                'grade_value',
                'course0.weight',
                'validateGrade',
			    'publishGrade',
			    )); 
                }
 		
					             
												   
					

  }              
		
		
		$this->render('listByRoom',array(
			'model'=>$model,
		));
	}
	
	
	
	
	
	public function getAverageForAStudent($student, $room, $evaluation, $acad)
    {
	      $include_discipline=0;
          $max_grade_discipline=0;
     
			//Extract max grade of discipline
			$max_grade_discipline = infoGeneralConfig('note_discipline_initiale');
			//Extract 
			$include_discipline = infoGeneralConfig('include_discipline_grade');
								   				
	      
	      
	      
	      $dataProvider_Course = new Courses;
	        $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
           $average_base =0;
          
          //Extract average base
          $average_base = infoGeneralConfig('average_base');
     
     
   
       if($current_acad==null)
						        {$condition = '';
						           $condition1 = '';
						         }
						     else{
						     	   if($acad!=$current_acad->id)
							          {$condition = '';
							           $condition1 = '';
							         }
							      else
							         { $condition = ' p.active IN(1,2) AND ';
								          $condition1 = '';
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
			 	$careAbout= false;
			 		
			 	      if($course->reference_id!=NULL) 
			 	         {  $id_course = $course->reference_id;
							 //si kou a evalye pou peryod sa
							$old_subject_evaluated=$this->isOldSubjectEvaluated($id_course,$room,$evaluation);         
							  if($old_subject_evaluated)
								 { $grades=Grades::model()->searchForReportCard($condition,$student,$id_course,$evaluation);
									$careAbout=$old_subject_evaluated; 						                        
								  }
							   else
								 {  $id_course = $course->id;
								 	$grades=Grades::model()->searchForReportCard($condition,$student,$course->id,$evaluation);
										$careAbout=$this->isSubjectEvaluated($course->id,$room,$evaluation); 					                       															                       
									}
		
						 }
					 else
						{  $id_course = $course->id;
							$grades=Grades::model()->searchForReportCard($condition,$student,$course->id,$evaluation);
						   $careAbout=$this->isSubjectEvaluated($course->id,$room,$evaluation);
						}
																	    
			      
 
					//	$grades=Grades::model()->searchForReportCard($condition,$student,$course->id, $evaluation);
						 if(($careAbout))
						  {															  
							if(isset($grades)&&($grades!=null))
							 {
							   $r=$grades->getData();//return a list of  objects
							   foreach($r as $grade) 
								 {									       
									$tot_grade=$tot_grade+$grade->grade_value;
									
																																			 
																			   
								 }
																																		   
							  }
							$max_grade=$max_grade+$course->weight;
						  }
			    }
			    
			 }
       
      //check to include discipline grade
		
		if($include_discipline==1)
		  { 
		  	// To find period name in in evaluation by year 
		        $period_acad_id =null;
				//$result=EvaluationByYear::model()->searchPeriodName($evaluation);
				$period_acad_id = ReportCard::searchPeriodNameForReportCard($evaluation)->id;
				
				  																 
				$grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($student, $period_acad_id);
				
				$tot_grade=$tot_grade+$grade_discipline;
				 $max_grade=$max_grade+$max_grade_discipline;
				
		   }
			 
                                                                                                                 
             
		 if(($average_base==10)||($average_base==100)) 
			{ if($max_grade!=0)  
				$average=round(($tot_grade/$max_grade)*$average_base,2);
		      }
		  else			
			 $average =null;					
								

	    return $average;
	}
	
	
	
	public function getClassAverage($room, $acad)
    {
	  
          $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     
    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }

  

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
		$dataProvider_studentEnrolled=Rooms::model()->getStudentsEnrolled($condition,$this->room_id, $acad);
			  if(isset($dataProvider_studentEnrolled))
			    {  $t=$dataProvider_studentEnrolled->getData();
				   foreach($t as $tot)
				       $tot_stud=$tot->total_stud;
				}
		//list of students for this room
		$classAverage=0;
		$dataProvider_student=Persons::model()->getStudentsByRoomForGrades($condition,$this->room_id, $acad);
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
				
		if($tot_stud!=0)
	      return (round(($classAverage/$tot_stud),2));
	    else
	       return 'N/A';
	}



public function getPassingGrade($id_level, $id_academic_period)
	{
		$criteria = new CDbCriteria;
		$criteria->condition='level_or_course=0 AND level=:idLevel AND academic_period=:idAcademicLevel';
		$criteria->params=array(':idLevel'=>$id_level,':idAcademicLevel'=>$id_academic_period);
		$pass_grade = PassingGrades::model()->find($criteria);
	 
	  if(isset($pass_grade))
	  return $pass_grade->minimum_passing; 
	  else 
	    return null;
	} 
		
	
public function checkDdataByEvaluation($evaluation, $course)
	{    
		$data= Grades::model()->checkDdataByEvaluation($evaluation, $course);
           
           if(isset($data)&&($data!=null))
           		return true;
           	else
           	   return false;
         
	}

	


public function checkDdataByEvaluation_externRequest($student,$evaluation, $course)	
	{    
		$data= Grades::model()->checkDdataByEvaluation_externRequest($student, $evaluation, $course);
           
           if(isset($data)&&($data!=null))
           		return true;
           	else
           	   return false;
         
	}
		
	
//************************  getLastEvaluationInGrade  ******************************/
	public function getLastEvaluationInGrade()
	{    //return an id(number)
       	  	  
	
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


	$code='';
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=$modelEvaluation->searchLastEvaluationInGrade($acad_sess);
			
		   
			 if(isset($result))
			  {  $r=$result->getData();//return a list of  objects
			    foreach($r as $i){			   
					  $code= $i->id;
					  
					  break; //to have only the 1st result which is the last
				}  
			 }	 					 
		      
			
		return $code;
         
	}

	
	//xxxxxxxxxxxxxxx  LEVEL xxxxxxxxxxxxxxxxxxx
		//************************  loadLevelByIdShiftSectionIdAcademicP  ******************************/
	public function loadLevelByIdShiftSectionIdAcademicP($idShift,$section_id,$acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('alias'=>'r',
		                             'select'=>'r.level',
		                             'join'=>'left join room_has_person rh on(rh.room=r.id) left join levels l on(r.level=l.id)',
                                     'condition'=>'r.shift=:shiftID AND l.section=:sectionID AND rh.academic_year=:acad',
                                     'params'=>array(':shiftID'=>$idShift, ':sectionID'=>$section_id, ':acad'=>$acad),
									 'order'=>'l.level_name ASC',
                               ));
			
			if(isset($level_id))
			 {  
			    foreach($level_id as $i){			   
					  $modelLevel= new Levels();
					   
					  $level=$modelLevel->findAll(array('select'=>'id,level_name',
												 'condition'=>'id=:levelID',
												 'params'=>array(':levelID'=>$i->level),
												 'order'=>'level_name ASC',
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
		$idShift = $model->find(array('select'=>'level',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$level = new Levels;
        $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift->level),
                               ));
		
				return $result;
		
	}
	
	//************************  getLevelIdFromPersons ******************************/
	public function getLevelIdFromPersons()
	{    
       
	   $modelLevel=new Levels;
					
			 if(isset($_POST['Grades']))
		        $modelLevel->attributes=$_POST['Levels'];
		           
				   $level_id=$modelLevel->level_name;
	               
				   return $level_id;
	}
	
//xxxxxxxxxxxxxxx  ROOM xxxxxxxxxxxxxxxxxxx
	
	//************************  changeRoom ******************************/
	public function changeRoom()
	{    $modelLevel= new Levels();
           $code= array();
		   
		  if(isset($_POST['Grades']['Levels']))
		        $idLevel->attributes=$_POST['Levels'];
		           
				   //$idLevel=$modelLevel->level_name;
	               
				    //return $idLevel;
         
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




	//************************  loadRoomByIdShiftSectionLevel ******************************/
	public function loadRoomByIdShiftSectionLevel($shift,$section,$idLevel,$acad)
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'r.id,r.room_name',
                                     'join'=>'left join room_has_person rh on(rh.room= r.id) left join levels l on(l.id=r.level)',
									 'condition'=>'r.shift=:idShift AND l.section=:idSection AND r.level=:levelID AND rh.academic_year=:acad',
                                     'params'=>array(':idShift'=>$shift,':idSection'=>$section,':levelID'=>$idLevel, ':acad'=>$acad),
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
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonRoom))
			 {  foreach($modelPersonRoom as $room){
			        $code[$room->id]= $room->room_name;
		           
		           }
			 }
		   
		return $code;
         
	}
   //************************  getRoom($id) ******************************/
   public function getRoom($id)
	{
		$room = new Rooms;
		$room=Rooms::model()->findByPk($id);
        
			
		//echo $id." --- ".$room->room_name;
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
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id,':acad'=>$acad_sess),
                               ));
		$room = new Rooms;
        $result=$room->find(array('select'=>'id,room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
						   

						   
				return $result;
		
	}
	
	//************************  getRoomIdFromGrades ******************************/
	public function getRoomIdFromGrades()
	{    
       
	   $modelRoom=new Rooms;
					
			 //if(isset($_POST['Grades']))
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
		$idShift = $model->find(array('select'=>'shift',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$shift = new Shifts;
        $result=$shift->find(array('select'=>'id,shift_name',
                                     'condition'=>'id=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift->shift),
                               ));
		
				return $result;
		
	}
	
	//************************  getShiftIdFromPersons ******************************/
	public function getShiftIdFromPersons()
	{    
       
	   $modelShift=new Shifts;
					
			 if(isset($_POST['Grades']))
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
		$idShift = $model->find(array('alias'=>'r',
		                             'join'=>'left join levels l on(l.id=r.level)',
		                             'select'=>'l.section',
                                     'condition'=>'r.id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$shift = new Shifts;
        $result=$shift->find(array('select'=>'id,shift_name',
                                     'condition'=>'id=:shiftID',
                                     'params'=>array(':shiftID'=>$idShift->section),
                               ));
		
				return $result;
		
	}
	
		
	
	//************************  getSectionIdFromPersons ******************************/
	public function getSectionIdFromPersons()
	{    
       
	   $modelSection=new Sections;
					
			 if(isset($_POST['Grades']))
		        $modelSection->attributes=$_POST['Sections'];
		           
				   $this->section_id=$modelSection->section_name;
	               
				   return $this->section_id;
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
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';//.$i->name_period;
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	


	//************************  loadSubjectByTeacherRoom($room_id,$id_teacher,$acad)  ******************************/
	public function loadSubjectByTeacherRoom($room_id,$id_teacher,$acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseByTeacherRoom($room_id,$id_teacher,$acad);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	


public function getAllSubjects($room_id,$level_id)
	{    
       	  
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
//acad_sess tou


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
					  $code[$k][3]= $i->short_subject_name;
					   $code[$k][4]= $i->reference_id;
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
			
			 if(isset($result)&&($result!=null))
			  {  $Course=$result->getData();//return a list of Course objects
			            //$k is a counter
						$k=0;
						
			    foreach($Course as $i)
			       {		
					  if($i->id!=null)
					       $bool=true;
					 }
			     
			      	 
			       	 
			 }
			
			  	 					 
		    
			
		return $bool;
         
	}
	
public function isOldSubjectEvaluated($course_id,$room,$period_id)
	{    
       	  
                $bool=false;
		  
		 $modelCourse= new Courses();
	       $result=$modelCourse->evaluatedOldSubject($course_id,$room,$period_id);
			
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
	       $result=$modelCourse->searchByRoomId($room_id,$acad); 
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	


	
	//************************  loadSubject by room_id to validate grades  ******************************/
		public function loadSubjectByRoomToValidateGrades($room_id,$evaluation,$acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		
		  
		  
	      $modelCourse= new Courses();
	       $result=$modelCourse->searchByRoomIdToValidateGrades($room_id,$evaluation,$acad); 
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';//.$i->name_period;
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	


	
	//xxxxxxxxxxxxxxx  EVALUATIONS xxxxxxxxxxxxxxxxxxx
		//************************  loadEvaluationToCreate  ******************************/
	public function loadEvaluationToCreate($acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelEvaluation= new EvaluationByYear();
	       $result=$modelEvaluation->searchIdNameToCreate($acad);
			
		   
			 if(isset($result))
			  {  $r=$result->getData();//return a list of  objects
			    foreach($r as $i){	
			    	$time = strtotime($i->evaluation_date);
                        $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
                        $date = $day.'/'.$month.'/'.$year;  			   
					  $code[$i->id]= $i->name_period.' / '.$i->evaluation_name.' ('.$date.')';
				}  
			 }	 					 
		      
			
		return $code;
         
	}


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
			    	$time = strtotime($i->evaluation_date);
                        $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
                        $date = $day.'/'.$month.'/'.$year;  		   
					  $code[$i->id]= $i->name_period.' / '.$i->evaluation_name.' ('.$date.')';
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
