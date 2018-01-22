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



class CoursesController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	public $extern=false; //pou konn si c nan view apel kreyasyon an fet
	public $student_id;
	 // Si la salle est choisi dans la creation en grille
        public $room_choose=null;
        
    public $new_teacher;
    public $usedCourse = false;
    public $newNotUsedCourse = false;
    public $debase=0;
    public $optional=0;
    
    public $messageWeightBase=false;

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
		

$acad=Yii::app()->session['currentId_academic_year']; 
$acad_sess = acad_sess();	

//Extract average base
$average_base = infoGeneralConfig('average_base');	

		
		$model=new Courses;
		
		$teacher='';
		$ok = true;
		$this->messageWeightBase=false;

		$this->performAjaxValidation($model);
        // Cancel the update of a subject 
        
        if(isset($_GET['emp'])&&($_GET['emp']!=""))
           {   $this->extern=true;
                $teacher=$_GET['emp'];
           
           }
       else
            $this->extern=false;


		if(isset($_POST['Courses']))
		{
			$model->attributes=$_POST['Courses'];
			
			if(isset($_POST['Courses']['debase']))
			  {
                        $this->debase = $_POST['Courses']['debase'];
                        if($this->debase ==1)
                           $this->optional = 0;
                    }
            
            if(isset($_POST['Courses']['optional']))
			  {
                        $this->optional = $_POST['Courses']['optional'];
                        if($this->optional ==1)
                            $this->debase = 0;
                    }

			
			if(isset($_POST['create']))
              {
				if(isset($_GET['emp'])&&($_GET['emp']!=""))
	             {   $model->setAttribute('teacher',$teacher);
	             
	               }
	            
	            if($this->debase==1)
					   $model->setAttribute('optional',0);
					   
				$model->setAttribute('date_created',date('Y-m-d'));
				$model->create_by = Yii::app()->user->name;
			
	          if($average_base==100)
	            { 
	            	if($model->weight < 100)  //anpechel save
	            	    $ok = false;
	              }
	           elseif($average_base==10)
	            { 
	            	if($model->weight >= 100)  //anpechel save
	            	    $ok = false;
	              }
	              
	          if($ok==true)
	           {  
				if($model->save())
					{   
						$prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_course = Courses::model()->getAllCourseInAcademicYear($acad);
 											$all_course = $all_course->getData();
 											foreach($all_course as $c)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   } 
								     	 if($prosper_marc_hilaire_poulard==1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'course'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	   	} 
						
						
						
						$title=PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$model->teacher,'academic_year'=>$acad));
		                
                        $id_profil =4;
						$id_group =8;
						
							//update Group and Profil for this user
								$modelUser=User::model()->findByAttributes(array('person_id'=>$model->teacher)); 
							
                           $command = Yii::app()->db->createCommand();
 
								
		                if($title!=null)
		                  { 
		                      $modelGroup=Groups::model()->findByAttributes(array('group_name'=>'Teacher'));
					        
							    if(isset($modelGroup))
								  { $id_profil = $modelGroup->belongs_to_profil;
								    $id_group = $modelGroup->id;
								   }
					
						       
						    
						     if($modelUser!=null)
							  {				        
							  	 if($modelUser->group_id==2)
							  	   { $command->update('users', array(
														'profil'=>$id_profil,'group_id'=>$id_group,'update_by'=>Yii::app()->user->name
													), 'id=:ID', array(':ID'=>$modelUser->id));
							  	   }
							  	  
							  	   
							    }
							 else
							    {  //update this person so that he gets an user credential
							          $_model=Persons::model()->findByPk($model->teacher);
							          
							           $explode_lastname_=explode(" ",substr($_model->last_name,0));
		            
						            if(isset($explode_lastname_[1])&&($explode_lastname[1]!=''))
						              $username_up= strtolower( $explode_lastname_[0]).'_'.strtolower( $explode_lastname_[1]).$_model->id;
						            else
						              $username_up= strtolower( $explode_lastname_[0]).$_model->id;
						                            
		                            
		                            $full_name_up=ucwords($_model->first_name.' '.$_model->last_name);
		                           
		                             $create_by = Yii::app()->user->name;
			                            $password = md5("password");
			                            
			                            $command = Yii::app()->db->createCommand();
									    $command->insert('users', array(
										  'username'=>$username_up,
										  'password'=>$password,
										  'full_name'=>$full_name_up,
										  'active'=>1,
										  'person_id'=>$_model->id,
										  'profil'=>$id_profil,
										  'group_id'=>$id_group,
										  'is_parent'=>0,
										  'create_by'=>$create_by,
										  'date_created'=>date('Y-m-d'),
										  'date_updated'=>date('Y-m-d'),
												));
												
							    
							    }
							      
		                     }
							else
							 {
								 if($modelUser!=null)
								  {				        
									 if($modelUser->group_id==2)
									   { $command->update('users', array(
															'profil'=>$id_profil,'group_id'=>$id_group,'update_by'=>Yii::app()->user->name
														), 'id=:ID', array(':ID'=>$modelUser->id));
									   }
									   
									}
								 else
									{  //update this person so that he gets an user credential
										  $_model=Persons::model()->findByPk($model->teacher);
										  
										   $explode_lastname_=explode(" ",substr($_model->last_name,0));
						
										if(isset($explode_lastname_[1])&&($explode_lastname[1]!=''))
										  $username_up= strtolower( $explode_lastname_[0]).'_'.strtolower( $explode_lastname_[1]).$_model->id;
										else
										  $username_up= strtolower( $explode_lastname_[0]).$_model->id;
														
										
										$full_name_up=ucwords($_model->first_name.' '.$_model->last_name);
									   
										 $create_by = Yii::app()->user->name;
											$password = md5("password");
											
											$command = Yii::app()->db->createCommand();
											$command->insert('users', array(
											  'username'=>$username_up,
											  'password'=>$password,
											  'full_name'=>$full_name_up,
											  'active'=>1,
											  'person_id'=>$_model->id,
											  'profil'=>$id_profil,
											  'group_id'=>$id_group,
											  'is_parent'=>0,
											  'create_by'=>$create_by,
											  'date_created'=>date('Y-m-d'),
											  'date_updated'=>date('Y-m-d'),
													));
													
									
									}
								 
							 }
		                     
		                     						
						if($this->extern)
					   	   {   
					   	   	  $this->extern=false; 
					   	   	  $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['emp'],'pg'=>'lr','isstud'=>0,'from'=>'teach'));
					   	   	 
					   	   }
					   	 else
					   	   {   if(isset($_GET['from'])&&($_GET['from']=="teach"))
					   	   	       $this->redirect (array('/schoolconfig/courses/index/isstud/0/from/teach'));
					   	   	    else
					   	   	        $this->redirect (array('index'));
					              
					         
					         
					   	   }
					   
					    }
					    
					    
                    }
                 else
					$this->messageWeightBase=true;
					
		        }
		        
		      if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
        
       /**
        * Verifie si le coeficient d'un cours en update reste superieure a la plus grande note dans la table note pour ce cours
        * @param type $idCourse
        * @param type $coefficient
        * @return boolean
        */
        public function isCoefficientValid($idCourse, $coefficient){
            // verifie que la note du cours dans la table grade est inferieure au coefficient du cours a modifier
                            
                            $temoin = TRUE;
                            $criteria = new CDbCriteria;
                            $criteria->condition='course=:idCourse';
                            $criteria->params=array(':idCourse'=>$idCourse,);
                            $grade_value = Grades::model()->findAll($criteria);
                            
                            foreach ($grade_value as $mg){
                               if($coefficient < $mg->grade_value){
                                        $temoin = FALSE;
                                }
                              
                            }
              return $temoin;              
            
        }

  public function actionUpdate()
	{
		$acad_sess = acad_sess();
		$acad=Yii::app()->session['currentId_academic_year']; 
	
	//Extract average base
    $average_base = infoGeneralConfig('average_base');	
    
    $ok=true;
    $this->messageWeightBase=false;
	
		$model=$this->loadModel();
		
		$this->newNotUsedCourse =  true; 
		 $this->usedCourse =  false;

		$this->performAjaxValidation($model);
		
		//PHASE 1
		$usedCourse_ = Grades::model()->isCourseHasGrades($model->id, $acad_sess);
          //si kou sa poko gen not ki antre pou li pou ane acad sa
          if($usedCourse_==false)
            {  
            	//gad si l referanse yon kou ki gen not pou ane a
            	  if($model->reference_id!=null)
            	    {  $usedCourse_1 = Grades::model()->isCourseHasGrades($model->reference_id, $acad_sess);
            	       
            	       if($usedCourse_1==true) //sel non pwofese a ki ka chanje: matye - sal - koyefisyan not editable
            	         $this->newNotUsedCourse =  false; 
            	    
            	    }
            	
            	//PHASE 2
            	  //gad si matye sa pou sal sa pou ane academik gen hold_new=0
            	  $course_has_hold_teacher = Courses::model()->iscourseHasHoldTeacher($model->subject, $model->room, $acad_sess);
            	 
            	  if($course_has_hold_teacher==true)
            	    { //$this->newNotUsedCourse =  true; 
            	        $this->usedCourse =  true;
            	    } 
            	 // elseif($course_has_hold_teacher==false) //pemet tout chanjman tankou se te yon kou ki fek ap kreye
                  //  $this->newNotUsedCourse =  false;              
                                  
             }
           elseif($usedCourse_==true)//si gen not ki antre deja pou kou sa pou ane a 
              {    //sel non pwofese a ki ka chanje: matye - sal - koyefisyan not editable
                   $this->newNotUsedCourse =  false;               	
               }
          
    

		if(isset($_POST['Courses']))
		{
			if(isset($_POST['new_teacher']))
			  {
                        $this->new_teacher = $_POST['new_teacher'];
                        
                        
                        
                    }
                    
                    
             $model->attributes=$_POST['Courses'];
			
			if(isset($_POST['Courses']['debase']))
			  {
                        $this->debase = $_POST['Courses']['debase'];
                        if($this->debase ==1)
                           $this->optional = 0;
                    }
            
            if(isset($_POST['Courses']['optional']))
			  {
                        $this->optional = $_POST['Courses']['optional'];
                        if($this->optional ==1)
                            $this->debase = 0;
                    }
                    
             

                        
				if(isset($_POST['update']))
	             {
	              if(($this->newNotUsedCourse==true)) //kou a poko gen not pou ane a
	               {  
	                  if($model->reference_id!=null)
	                    { 
	                    	 $usedCourse_1_ = Grades::model()->isCourseHasGrades($model->reference_id, $acad_sess);
	                    	 if($usedCourse_1_==true)	
	                  	      {     //tout chanjman posib sof weight //konseve ID kou a
	                  	               $model->attributes=$_POST['Courses'];  
				                       
				                 if($this->isCoefficientValid($model->id,$model->weight)==TRUE)
			                      {  
						                       if($this->debase==1)
										   $model->setAttribute('optional',0); 
										   
										   $model->setAttribute('debase',$this->debase);
						                       
						                        
						                        $model->update_by =Yii::app()->user->name;
						                        $model->date_updated =date('Y-m-d');
						                        
						                  if($average_base==100)
								            { 
								            	if($model->weight < 100)  //anpechel save
								            	    $ok = false;
								              }
								           elseif($average_base==10)
								            { 
								            	if($model->weight >= 100)  //anpechel save
								            	    $ok = false;
								              }
								              
								          if($ok==true)
								           {   
						                        if($model->save())
						                           {
						                           	   $title=PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$model->teacher,'academic_year'=>$acad));
						                      
										                if($title!=null)
										                  { 
							
														     //update Group and Profil for this user
															 $modelUser=User::model()->findByAttributes(array('person_id'=>$model->teacher)); 
														                  
														     $id_profil = 5;
														     $id_group = 2;
												             if(($modelUser->profil==$id_profil)&&($modelUser->group_id==$id_group))
													           {   $modelGroup=Groups::model()->findByAttributes(array('group_name'=>'Teacher'));
													                        
																     if(isset($modelGroup))
																	   { $id_profil = $modelGroup->belongs_to_profil;
																	     $id_group = $modelGroup->id;
																	    }
														                           
															         $command = Yii::app()->db->createCommand();
															         $command->update('users', array(
																						'profil'=>$id_profil,'group_id'=>$id_group,'update_by'=>Yii::app()->user->name
																					), 'id=:ID', array(':ID'=>$modelUser->id));
																					
													              }
													    
													              
									                         }
									                         
					                         
					                         
													     if((isset($_GET['from']))&&($_GET['from']=='teach'))
														   {                                  
														      $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['pers'],'isstud'=>0,'from'=>'teach'));
														      
														   }
														  else{
				                                                    $this->redirect (array('index'));
				                                                    }
			
						                           	}
						                           	
			                                     }
						                       else
						                            $this->messageWeightBase=true;
						                           	
						               }
						          else
						             {
					                  Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Weight is lower than grades saved for this courses'));
					                 }
				                  	
				                  	
	                  	        }
	                  	     else  //tout chanjman posib //konseve ID kou a
	                  	       {
	                  	       	    $model->attributes=$_POST['Courses'];  
				                       
				                       
						                       if($this->debase==1)
										   $model->setAttribute('optional',0); 
										   
										   $model->setAttribute('debase',$this->debase);
						                       
						                        
						                        $model->update_by =Yii::app()->user->name;
						                        $model->date_updated =date('Y-m-d');
						                        
						                        if($model->save())
						                           {
						                           	   $title=PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$model->teacher,'academic_year'=>$acad));
						                      
										                if($title!=null)
										                  { 
							
														     //update Group and Profil for this user
															 $modelUser=User::model()->findByAttributes(array('person_id'=>$model->teacher)); 
														                  
														     $id_profil = 5;
														     $id_group = 2;
												             if(($modelUser->profil==$id_profil)&&($modelUser->group_id==$id_group))
													           {   $modelGroup=Groups::model()->findByAttributes(array('group_name'=>'Teacher'));
													                        
																     if(isset($modelGroup))
																	   { $id_profil = $modelGroup->belongs_to_profil;
																	     $id_group = $modelGroup->id;
																	    }
														                           
															         $command = Yii::app()->db->createCommand();
															         $command->update('users', array(
																						'profil'=>$id_profil,'group_id'=>$id_group,'update_by'=>Yii::app()->user->name
																					), 'id=:ID', array(':ID'=>$modelUser->id));
																					
													              }
													    
													              
									                         }
									                         
					                         
					                         
													     if((isset($_GET['from']))&&($_GET['from']=='teach'))
														   {                                  
														      $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['pers'],'isstud'=>0,'from'=>'teach'));
														      
														   }
														  else{
				                                                    $this->redirect (array('index'));
				                                                    }
			
						                           	}
				                  	

	                  	       	 }
	                  	
	                    }
	                   else
	                     {    //tout chanjman posib //konseve ID kou a
	                     	     	$model->attributes=$_POST['Courses'];  
				                       
				                       
						                       if($this->debase==1)
										   $model->setAttribute('optional',0); 
										   
										   $model->setAttribute('debase',$this->debase);
						                       
						                        
						                        $model->update_by =Yii::app()->user->name;
						                        $model->date_updated =date('Y-m-d');
						                        
						                        if($model->save())
						                           {
						                           	   $title=PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$model->teacher,'academic_year'=>$acad));
						                      
										                if($title!=null)
										                  { 
							
														     //update Group and Profil for this user
															 $modelUser=User::model()->findByAttributes(array('person_id'=>$model->teacher)); 
														                  
														     $id_profil = 5;
														     $id_group = 2;
												             if(($modelUser->profil==$id_profil)&&($modelUser->group_id==$id_group))
													           {   $modelGroup=Groups::model()->findByAttributes(array('group_name'=>'Teacher'));
													                        
																     if(isset($modelGroup))
																	   { $id_profil = $modelGroup->belongs_to_profil;
																	     $id_group = $modelGroup->id;
																	    }
														                           
															         $command = Yii::app()->db->createCommand();
															         $command->update('users', array(
																						'profil'=>$id_profil,'group_id'=>$id_group,'update_by'=>Yii::app()->user->name
																					), 'id=:ID', array(':ID'=>$modelUser->id));
																					
													              }
													    
													              
									                         }
									                         
					                         
					                         
													     if((isset($_GET['from']))&&($_GET['from']=='teach'))
														   {                                  
														      $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['pers'],'isstud'=>0,'from'=>'teach'));
														      
														   }
														  else{
				                                                    $this->redirect (array('index'));
				                                                    }
			
						                           	}
				                  	
				                  	   			                  	      
			                  	
	                      }
	                    
	                }
	               elseif(($this->newNotUsedCourse==false)) //kou a gen not pou ane a
	                 {  
	                  	  if($this->new_teacher==1) //nouvo record ak ID kou sa nan referans
	                  	  {  
		                  	  $old_id = $model->id; 
		                  	 
		                  	   $newModelCourse = new Courses;
		                      $newCourse = new Courses;
		                     
		                       $newModelCourse->attributes=$_POST['Courses'];  
		                       
		                       if($this->isCoefficientValid($old_id,$newModelCourse->weight)==TRUE)
			                      {
				                       if($this->debase==1)
								   $newCourse->setAttribute('optional',0); 
								   
								   $newCourse->setAttribute('debase',$this->debase);
				                       
				                        $newCourse->academic_period =$newModelCourse->academic_period;
				                        $newCourse->subject =$model->subject;
				                        $newCourse->teacher =$newModelCourse->teacher;
				                        $newCourse->room =$model->room;
				                        $newCourse->weight =$newModelCourse->weight;
				                        $newCourse->reference_id =$old_id;
				                        $newCourse->create_by =Yii::app()->user->name;
				                        $newCourse->date_created =date('Y-m-d');
				                        
				                        if($newCourse->save())
				                           {
				                           	    $command0 = Yii::app()->db->createCommand();
										         $command0->update('courses', array(
																	'old_new'=>0 ), 'id=:ID', array(':ID'=>$old_id));
								     
								               $title=PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$newModelCourse->teacher,'academic_year'=>$acad));
				                      
								                if($title!=null)
								                  { 
					
												     //update Group and Profil for this user
													 $modelUser=User::model()->findByAttributes(array('person_id'=>$newModelCourse->teacher)); 
												                  
												     $id_profil = 5;
												     $id_group = 2;
										             if(($modelUser->profil==$id_profil)&&($modelUser->group_id==$id_group))
											           {   $modelGroup=Groups::model()->findByAttributes(array('group_name'=>'Teacher'));
											                        
														     if(isset($modelGroup))
															   { $id_profil = $modelGroup->belongs_to_profil;
															     $id_group = $modelGroup->id;
															    }
												                           
													         $command = Yii::app()->db->createCommand();
													         $command->update('users', array(
																				'profil'=>$id_profil,'group_id'=>$id_group,'update_by'=>Yii::app()->user->name
																			), 'id=:ID', array(':ID'=>$modelUser->id));
																			
											              }
											    
											              
							                         }
							                         
			                         
			                         
											     if((isset($_GET['from']))&&($_GET['from']=='teach'))
												   {                                  
												      $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['pers'],'isstud'=>0,'from'=>'teach'));
												      
												   }
												  else{
		                                                    $this->redirect (array('index'));
		                                                    }
	
				                           	}
		                  	
		                  	        }
						          else
						             {
					                  Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Weight is lower than grades saved for this courses'));
					                 }
	                  	      
	                  	      }
	                  	    elseif($this->new_teacher==0) //
	                  	  {  
		                  	  $old_id = $model->id; 
		                  	    
		                  	  $newModelCourse = new Courses;
		                      $newCourse = Courses::model()->findByPk($old_id);
		                     
		                       $newModelCourse->attributes=$_POST['Courses'];  
		                       
		                       
		                       if($this->isCoefficientValid($old_id,$newModelCourse->weight)==TRUE)
			                      { 
				                       if($this->debase==1)
								   $newCourse->setAttribute('optional',0); 
								   
								   $newCourse->setAttribute('debase',$this->debase);
								   
								   $newCourse->teacher = $newModelCourse->teacher;
				                        $newCourse->update_by =Yii::app()->user->name;
				                        $newCourse->date_created =date('Y-m-d');
				                        
				                        if($newCourse->save())
				                          {
				                          	   if((isset($_GET['from']))&&($_GET['from']=='teach'))
												   {                                  
												      $this->redirect(array('/academic/persons/viewForReport','id'=>$_GET['pers'],'isstud'=>0,'from'=>'teach'));
												      
												   }
												  else{
		                                                    $this->redirect (array('index'));
		                                                    }
				                          	
				                            }
				                            
		                             }
						          else
						             {
					                  Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Weight is lower than grades saved for this courses'));
					                 }
					                 
					                 
	                  	  }
		                  	
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
	
	

	public function actionDelete()
	{
		
		
		try {
   			 $this->loadModel()->delete();
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

        /**
         * 
         */


 public function actionGridcreateCourse(){
           $model = new Courses; 
           $acad = Yii::app()->session['currentId_academic_year'];
           $acad_sess = acad_sess();
           $number_line = infoGeneralConfig('nb_grid_line');
           $subject = array(); 
           $teacher = array(); 
           $academic_year = array();
           $weight = array();
           $debase = array(); 
           $optional = array(); 
           $error_report = False;
           $subject_name = array();
           $j = 0;
           if(isset($_POST['room'])){
               $this->room_choose = $_POST['room'];
           }else{
               $this->room_choose = null;
           }
           
          if(isset($_POST['btnSave'])){
              
              $one_save=0;
              
              for($i=0;$i<$number_line;$i++){
                  if((isset($_POST['subject'.$i]) && $_POST['subject'.$i]!="") && (isset($_POST['teacher'.$i]) && $_POST['teacher'.$i]!="")  && (isset($_POST['academic_year'.$i]) && $_POST['academic_year'.$i]!="") && (isset($_POST['weight'.$i])&&$_POST['weight'.$i])!=""){
                      // Si c'est une matiere de base
                      if(isset($_POST['debase'.$i]))
                        {
                          $debase[$i] = 1; 
                         }
                       else
                         {
                          $debase[$i] = 0;
                          }
                          
                      if($debase[$i]==1)
					       $optional[$i] = 0;
					  else
					    {
							// Si c'est un cours optionnel
		                      if(isset($_POST['optional'.$i]))
		                        {
		                          $optional[$i] = 1; 
		                         }
		                       else
		                         {
		                          $optional[$i] = 0;
		                          }
		                          
					      }

                                                    
                      $subject[$i] = $_POST['subject'.$i]; 
                      $teacher[$i] = $_POST['teacher'.$i];
                      $academic_year[$i] = $_POST['academic_year'.$i]; 
                      $weight[$i] = $_POST['weight'.$i];
                      $model->setAttribute('subject', $subject[$i]);
                      $model->setAttribute('teacher', $teacher[$i]);
                      $model->setAttribute('academic_period', $academic_year[$i]);
                      $model->setAttribute('weight', $weight[$i]);
                      $model->setAttribute('room', $this->room_choose);
                      $model->setAttribute('debase', $debase[$i]);
                      $model->setAttribute('optional', $optional[$i]);
                      $model->setAttribute('date_created', date('Y-m-d H:m:s'));
                      $model->setAttribute('create_by', Yii::app()->user->name);
                      if($model->save()){
                        
                         $one_save=1;
                         
                          $title = PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$model->teacher,'academic_year'=>$acad));
                          if($title!=null){
                              $modelUser=User::model()->findByAttributes(array('person_id'=>$model->teacher));
                              $id_profil = 5;
                              $id_group = 2;
                              $modelGroup = Groups::model()->findByAttributes(array('group_name'=>'Teacher'));
                              if(isset($modelGroup)){ 
                                  $id_profil = $modelGroup->belongs_to_profil;
                                  $id_group = $modelGroup->id;
                               }
                            $command = Yii::app()->db->createCommand();
                            if($modelUser!=null)
                              {				        
                                 if($modelUser->group_id==2)
                                   { 
                                     $command->update('users', array(
                                        'profil'=>$id_profil,'group_id'=>$id_group,'update_by'=>Yii::app()->user->name
                                        ), 'id=:ID', array(':ID'=>$modelUser->id));
                                   }
                                }else{
                                    $_model = Persons::model()->findByPk($model->teacher);
                                    $explode_lastname_ = explode(" ",substr($_model->last_name,0));
                                    if(isset($explode_lastname_[1])&&($explode_lastname[1]!=''))
                                      $username_up= strtolower( $explode_lastname_[0]).'_'.strtolower( $explode_lastname_[1]).$_model->id;
                                    else
                                      $username_up= strtolower( $explode_lastname_[0]).$_model->id;
                                    
                                $full_name_up=ucwords($_model->first_name.' '.$_model->last_name);
                                $create_by = Yii::app()->user->name;
                                $password = md5("password");
                                
                                $command = Yii::app()->db->createCommand();
                                $command->insert('users', array(
                                      'username'=>$username_up,
                                      'password'=>$password,
                                      'full_name'=>$full_name_up,
                                      'active'=>1,
                                      'person_id'=>$_model->id,
                                      'profil'=>$id_profil,
                                      'group_id'=>$id_group,
                                      'is_parent'=>0,
                                      'create_by'=>$create_by,
                                      'date_created'=>date('Y-m-d'),
                                      'date_updated'=>date('Y-m-d'),
                                                    ));
                                
                                }
                            
                          }
                      }else{
                         
                          $error_report = True;
                          $subject_name[$j] = Subjects::model()->findByPk($subject[$i])->subject_name; 
                          $j++;
                      }
                  }
                  $model->unsetAttributes(); 
                  $model = new Courses; 
              }
            
            if($one_save==1)
              {
              	$prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_course = Courses::model()->getAllCourseInAcademicYear($acad);
 											$all_course = $all_course->getData();
 											foreach($all_course as $c)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   } 
								     	 if($prosper_marc_hilaire_poulard >= 1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'course'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	   	} 
              	} 
             
             
             
              if($error_report){
                  $liste_subject = "";
                  for($i=0; $i<count($subject_name); $i++){
                      $liste_subject .= $subject_name[$i].'<br/>';
                  }
                  $message=Yii::t('app',"At least {name} error(s) occured when you saved the courses !<br/> The following subjects were about to be affected twice to the same teacher in the same room:<br/><b> {subject}</b>",array('{name}'=>$j,'{subject}'=>$liste_subject));
                 Yii::app()->user->setFlash(Yii::t('app','Error'), $message);
              }
              
          $this->redirect(array('index'));
          }
           
           $this->render('gridcreate',array(
			'model'=>$model,
		));
           
        }
		
	
	
	public function actionIndex()
	{
                  $acad=Yii::app()->session['currentId_academic_year'];
		  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'teacher0.active IN(1,2) AND ';
						        }


      

                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                    }
                $model=new Courses('search');
                $model->unsetAttributes();

		if(isset($_GET['Courses']))
			$model->attributes=$_GET['Courses'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of courses: ')), null,false);
                            $this->exportCSV($model->search($condition,$acad), array(
				'teacher0.last_name',
				'teacher0.first_name',
				'subject0.subject_name',
				'room0.room_name',
				'academicPeriod.name_period',
				'weight',
				'debase',
				'optional')); 
		}
		

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	
	
	public function actionViewForTeacher()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
            
                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
                $model=new Courses('search');
                $model->unsetAttributes();
		if(isset($_GET['Courses']))
			$model->attributes=$_GET['Courses'];
                
                // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of courses: ')), null,false);
                            $this->exportCSV($model->search($acad), array(
				'teacher0.last_name',
				'teacher0.first_name',
				'subject0.subject_name',
				'room0.room_name',
				'academicPeriod.name_period',
				'weight',
				'debase',
				'optional')); 
		}

		$this->render('viewForTeacher',array(
			'model'=>$model,
		));
	}

	
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Courses::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='courses-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	// Export to CSV 
	public function behaviors() {
	   return array(
	       'exportableGrid' => array(
	           'class' => 'application.components.ExportableGridBehavior',
	           'filename' => Yii::t('app','courses.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
	
}
