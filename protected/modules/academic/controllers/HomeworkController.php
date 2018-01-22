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




class HomeworkController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	public $_model;
	
	
	public $back_url='';
	
	public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	public $course_id;
	public $evaluation_id;
	public $homework_id;
	public $document;
	public $keep=0;
	public $message_UpdateLimitDateSubmission=false;
	
	public $message_room_id=false;
    public $message_course_id=false;
    public $messageSize=false;
    public $messageExtension=false;
	public $success=false;
	public $path;
	
	
		   
	   public $ext_allowed_by_viewer = array( "odt", "pdf", "ods", "fods", "fodt", "odb", "odi", "oos", "oot", "otf", "otg", "oth", "oti", "otp", "ots", "sdp", "sds", "sdv", "sfs", "ods", "smf", "sms", "std", "stw", "sxg", "sxm", "vor", "sda", "sdc", "sdd", "odf", "odg", "ott", "pub", "rtf", "sdw", "sxc", "sxw", "bau", "dump", "fodg", "fodp", "odm", "odp", "otc", "psw", "sdb", "sgl", "smd", "stc", "sti", "svm", "sxd", "uot" );
	   
	   
	 public $ext_allowed  = array( "odt", "pdf", "ods", "fods", "fodt", "odb", "odi", "oos", "oot", "otf", "otg", "oth", "oti", "otp","ots", "sdp", "sds", "sdv", "sfs", "ods", "smf", "sms", "std", "stw", "sxg", "sxm", "vor", "sda", "sdc", "sdd", "doc", "odf", "odg", "ott", "pub", "rtf", "sdw", "sxc", "sxw", "bau", "dump", "fodg", "fodp", "odm", "odp", "otc", "psw", "sdb", "sgl", "smd", "stc", "sti", "svm", "sxd", "uot", "docx", "docm", "dotx", "dotm", "docb", "xls", "xlt", "xlm", "xlsx", "xlsm", "xltx", "xltm", "xlsb", "xla", "xlam", "xll", "xlw", "ppt", "pot", "pps", "pptx", "pptm", "potx", "potm", "ppam", "ppsx", "ppsm", "sldx", "sldm", "accdb", "accde", "accdt", "accdr", "pub", "jpeg", "jpg", "png" );




	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
	   $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');

		$acad_name=Yii::app()->session['currentName_academic_year'];
		
		$model=new Homework;
		$modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelCourse=new Courses;
		$modelEvaluation= new EvaluationByYear;
		$modelEvaluationHom= new EvaluationByYear;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		
		
		if(isset($_POST['Homework']))
		{
		     
		     if((Yii::app()->user->profil!='Teacher'))
     			 {	    if(isset($_POST['Shifts']))
			               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
							     $modelShift->attributes=$_POST['Shifts'];
					              $this->idShift=$modelShift->shift_name;
					              
											  
								   $modelSection->attributes=$_POST['Sections'];
								   $this->section_id=$modelSection->section_name;
							     						
								   $modelLevel->attributes=$_POST['LevelHasPerson'];
								   $this->idLevel=$modelLevel->level;
								   
								   $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['RoomsHom']=$this->room_id; 
								   
								   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id=$modelCourse->subject;
								   Yii::app()->session['CoursesHom']=$this->course_id;
								   
							
								   
				             }				   
							else
							{  $this->idShift=null;
						       $this->section_id=null;
							   $this->idLevel=null;
							   $this->room_id=null;
							   $this->course_id=null;
							  
							}
				
     			 }//fen  if((Yii::app()->user->profil!='Teacher'))
                else // Yii::app()->user->profil=='Teacher'
                  {
                  	                      	   
                  	   if(isset($_POST['Rooms']))
			               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
							    
								   $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['Rooms']=$this->room_id;
								   
								   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id=$modelCourse->subject;
								   Yii::app()->session['Courses']=$this->course_id;
								   
								
								   
				             }				   
							else
							{  $this->room_id=null;
							   $this->course_id=null;
							  
							}
                  	
                    }// Yii::app()->user->profil=='Teacher'
                    
				
     
		        $model->attributes=$_POST['Homework'];
		     
		      }
		      
		      
		   if(isset($_POST['create']))
		    {
	            $homework='documents/homework';
	            //on vient de presser le bouton
						 //reccuperer les lignes selectionnees()
					$this->message_room_id=false;
					$this->message_course_id=false; 
					//$this->message_evaluation_id=false;
					$this->success=false;
					$temwen=false;
					
					//a random number to add to file_name
					 $rnd = rand(0,9999);
	            
	            
				    if(($this->room_id!="")&&($this->course_id!=""))
				        {        
	
	
	 						  $course_name_=$this->getCourse($this->course_id);
								$room=$this->getRoom($this->room_id);
						
						if((Yii::app()->user->profil!='Teacher'))
     			         {    	
								$level=$this->getLevel($this->idLevel);
								$section=$this->getSection($this->section_id);
								$shift=$this->getShift($this->idShift);
								
								
     			          }
     			        else
     			          { 
     			          	            
							$infoRoom = Rooms::model()->getInfoRoom($this->room_id);
          	
					          	$infoRoom_ = $infoRoom->getData();
					            
					                 $shift_='';
					              	 $section_='';
					              	 $level_='';
					              	
					              	 
					             foreach($infoRoom_ as $r)
					              {
					              	 $shift_=$r->shift;
					              	 $section_=$r->section;
					              	 $level_=$r->level;
					              	
					              	}
					              	
					            $level=$this->getLevel($level_);
								$section=$this->getSection($section_);
								$shift=$this->getShift($shift_);
					            
					            
     			          	 } 
     			          	 
     			          	 //retire tout aksan yo    
							    
								$room = strtr( $room, pa_daksan() );
							    $level = strtr( $level, pa_daksan() );
							    $section = strtr( $section, pa_daksan() );
							    $shift = strtr( $shift, pa_daksan() );
							    //$evaluationPeriod = strtr( $evaluationPeriod, pa_daksan() );
							    $sess_name='';
							    $base = '';
                      
			                      if($siges_structure==1)
			                        {  if($this->noSession)
			                             {  Yii::app()->session['currentName_academic_session']=null;
			                                Yii::app()->session['currentId_academic_session']=null;
			                             	$sess_name=' / ';
			                             }
			                           else
			                             { $sess_name=' / '.Yii::app()->session['currentName_academic_session'];
			                               $base = '/'.Yii::app()->session['currentName_academic_year'];
			                               
			                               $name_acad = strtr( Yii::app()->session['currentName_academic_session'], pa_daksan() );
			                             }
			                        }
			                       elseif($siges_structure==0)
							         $name_acad = strtr( $acad_name, pa_daksan() );
							    
							     $course_name = strtr( $course_name_, pa_daksan() );

	                           
	                         /*  if($siges_structure==1)	
									$base = '/'.Yii::app()->session['currentName_academic_year'];
							    elseif($siges_structure==0)	
							         $base = '';
						       */
								 
								if(!file_exists(Yii::app()->basePath.'/../'.$homework))  //si homework n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.$homework); 
								 
									 if($siges_structure==1)
										{
										   if(!file_exists(Yii::app()->basePath.'/../'.$homework.$base))    //reportCard existe.si acadPeriod n'existe pas, on le cree 
											 mkdir(Yii::app()->basePath.'/../'.$homework.$base);
											
											}

									if(!file_exists(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad))    //homework existe.si acadPeriod n'existe pas, on le cree  
									     mkdir(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad);
									if(!file_exists(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad.'/'.$shift))    //acadPeriod existe.si shiftName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad.'/'.$shift);
									if(!file_exists(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad.'/'.$shift.'/'.$section))    //shiftName existe.si sectionName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad.'/'.$shift.'/'.$section);
									  
                                    if(!file_exists(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level))    //sectionName existe.si levelName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level); 
										 
									                                       	
									if(!file_exists(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room))    //levelName existe.si roomName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.$homework.$base.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room);
									
									
$path=$homework.$base.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room;					   
						   						   
					$target ='';
					$this->messageSize=false;
					$this->messageExtension=false;	  
						  
						if($_FILES['document']['name']!='')				  
					     {    $info = pathinfo($_FILES['document']['name']);
								  if($info)  // check if uploaded file is set or not
								    {                        
								         //$info = pathinfo($_FILES['document']['name']);
		                                    $ext = $info['extension']; // get the extension of the file
		 
										//$extension = $this->getExtension($filename);
										$ext = strtolower($ext);
					
					
										
								    if (in_array($ext, $this->ext_allowed))  
										 { 
									 		    //checking the size
											       $size=filesize($_FILES['document']['tmp_name']);
		
											if ($size > 4*1024*1024)
										      {
														$this->messageSize=true; //Yii::t('app','You have exceeded the size limit.');
														//$errors=1;
											   }
											 else
											   {
													
													//$newname = $course_name.'_'.date('Y-m-d').'_'.$rnd.'.'.$ext; 
													
													 $explode_name= explode(".",substr($_FILES['document']['name'], 0));
                                                      
                                                      $newname=$explode_name[0].'_'.$rnd.'.'.$ext;
													
													 $model->setAttribute('attachment_ref',$newname);
			
			                                        $target =  Yii::app()->basePath.'/../'.$path.'/'.$newname;
			                                         // move_uploaded_file( $_FILES['document']['tmp_name'], $target);
			                                         
			                                         $this->path=Yii::app()->basePath.'/../'.$path.'/';	  
											   }
											   
								         }
								      else
								         {
			                                $this->messageExtension=true;
											$mesage=Yii::t('app','This document is not a valid one. Use one of these extensions: "odt", "pdf", "doc", "ods", "fods", "fodt", "odb", "odi", "oos", "oot", "otf", "otg", "oth", "oti", "otp", "ots", "sdp", "sds", "sdv", "sfs", "ods", "smf", "sms", "std", "stw", "sxg", "sxm", "vor", "sda", "sdc", "sdd", "odf", "odg", "ott", "pub", "rtf", "sdw", "sxc", "sxw", "bau", "dump", "fodg", "fodp", "odm", "odp", "otc", "psw", "sdb", "sgl", "smd", "stc", "sti", "svm", "sxd", "uot".');
											//$errors=1;
										 }
										
										 
		
									}
					       }
						 else
						     $model->attachment_ref="";
						     
						  
				    if((!$this->messageSize)&&(!$this->messageExtension))
						 {
						 	   $teacher_id='';
						    //jwenn teacher apartir course
						    $person=Courses::model()->getTeacherByCourse($this->course_id);
						    if($person!=null)
						      $person=$person->getData();
						        foreach($person as $p)
						           $teacher_id=$p->id;
		
						     
							     $model->setAttribute('person_id',$teacher_id);
								 $model->setAttribute('course',$this->course_id);
								 $model->setAttribute('given_date',date('Y-m-d'));
								 $model->setAttribute('academic_year',$acad_sess);
								 
										   
										   if($model->save())
			                                 {  
			                                 	 move_uploaded_file( $_FILES['document']['tmp_name'], $target);
			                                 	 $this->success=true;
			                                 	 
			                                 	 $this->room_id=null;
			                                 	
			                                 	 
			                                 	 $this->redirect(array('/academic/homework/view/id/'.$model->id.'/from/stud')); 

									         }
			                     
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
						     	  
						     	
						      }
						      
				  		
		       						  
						
				  
		    }
		 
		 
		 
		 if(isset($_POST['cancel']))
                          {
                              
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }

		 
		 
		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');

		$acad_name=Yii::app()->session['currentName_academic_year'];
		
		$homework='documents/homework';
		$path='';
		$document='';
		
		$model=new Homework;
		$modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelCourse=new Courses;
		$modelEvaluation= new EvaluationByYear;
		$modelEvaluationHom= new EvaluationByYear;
		
		
		$model=$this->loadModel();
		
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

	  
		
		 //get shift,section,level,rom by course_id
		  $result=Courses::model()->getShiftSectionLevelRoomSubject_nameSubject_idWeightTeacher_nameTeacherByCourse($model->course);
		  
		  if($result!=null)
	         $results=$result->getData();
			     
			     foreach($results as $data)
			       {
			       	   $this->course_id=$model->course;
						$this->room_id=$data->room;
						$this->idLevel=$data->level;
						$this->section_id=$data->section;
						$this->idShift=$data->shift;
			       	
			       	}
			       	
			   //to get old path
			     $room=$this->getRoom($this->room_id);
					$level=$this->getLevel($this->idLevel);
					$section=$this->getSection($this->section_id);
					$shift=$this->getShift($this->idShift);
					
					//retire tout aksan yo    
				    //$str='';$str = strtr( $str, pa_daksan() );
					$room = strtr( $room, pa_daksan() );
				    $level = strtr( $level, pa_daksan() );
				    $section = strtr( $section, pa_daksan() );
				    $shift = strtr( $shift, pa_daksan() );
				    //$evaluationPeriod = strtr( $evaluationPeriod, pa_daksan() );
				    $sess_name='';
                      
                      if($siges_structure==1)
                        {  if($this->noSession)
                             {  Yii::app()->session['currentName_academic_session']=null;
                                Yii::app()->session['currentId_academic_session']=null;
                             	$sess_name=' / ';
                             }
                           else
                             $sess_name=' / '.Yii::app()->session['currentName_academic_session'];
                        }
                        
				    $name_acad = strtr( $acad_name.$sess_name, pa_daksan() );    	
			       	
		$old_room= $this->room_id;
		$old_courseID= $model->course;
		$old_document= $model->attachment_ref;
		$old_path=$homework.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room;
		
		
		$this->document=$model->attachment_ref;
		
		//a random number to add to file_name
		$rnd = rand(0,9999);
		
		if(isset($_POST['Homework']))
		{
			
			 if((Yii::app()->user->profil!='Teacher'))
     			 {	    if(isset($_POST['Shifts']))
			               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
							     $modelShift->attributes=$_POST['Shifts'];
					              $this->idShift=$modelShift->shift_name;
					              
											  
								   $modelSection->attributes=$_POST['Sections'];
								   $this->section_id=$modelSection->section_name;
							     						
								   $modelLevel->attributes=$_POST['LevelHasPerson'];
								   $this->idLevel=$modelLevel->level;
								   
								   $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['RoomsHom']=$this->room_id; 
								   
								   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id=$modelCourse->subject;
								   Yii::app()->session['CoursesHom']=$this->course_id;
								   
							
								   
				             }				   
						
						
				
     			 }//fen  if((Yii::app()->user->profil!='Teacher'))
                else // Yii::app()->user->profil=='Teacher'
                  {
                  	                      	   
                  	   if(isset($_POST['Rooms']))
			               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
							    
								   $modelRoom->attributes=$_POST['Rooms'];
								   $this->room_id=$modelRoom->room_name;
								   Yii::app()->session['Rooms']=$this->room_id;
								   
								   $modelCourse->attributes=$_POST['Courses'];
								   $this->course_id=$modelCourse->subject;
								   Yii::app()->session['Courses']=$this->course_id;
								   
								 
								   
				             }				   
							
                  	
                    }// Yii::app()->user->profil=='Teacher'
                    
				if(isset($_POST['Homework']['keepDoc']))
				 {
				 	$this->keep = $_POST['Homework']['keepDoc'];
				 	}
				
			$model->attributes=$_POST['Homework'];
			
		  $file_to_delete ='';
		  
		  
		  
		  
		  if(isset($_POST['update']))	
			{
				$target_new = '';
				 $teacher_id='';
				 $course_name='';
				 $final_new_name='';
				 $path='';
				 $upload_file='';
				 $homework='documents/homework';
				$this->messageSize=false;
				$this->messageExtension=false;
				$this->message_room_id=false;
					$this->message_course_id=false; 
					
					$this->success=false;
				
		 if(($this->room_id!="")&&($this->course_id!=""))
	        {   
			   
			    //getting new path
						    $course_name_=$this->getCourse($this->course_id);
						      $room=$this->getRoom($this->room_id);
							$level=$this->getLevel($this->idLevel);
							$section=$this->getSection($this->section_id);
							$shift=$this->getShift($this->idShift);
							
							//retire tout aksan yo    
						  
							$room = strtr( $room, pa_daksan() );
						    $level = strtr( $level, pa_daksan() );
						    $section = strtr( $section, pa_daksan() );
						    $shift = strtr( $shift, pa_daksan() );
						    //$evaluationPeriod = strtr( $evaluationPeriod, pa_daksan() );
						    $name_acad = strtr( $acad_name, pa_daksan() );
						    
						    $course_name = strtr( $course_name_, pa_daksan() );
						    
						  					                                     
 if (!file_exists(Yii::app()->basePath.'/../'.$homework))  //si homework n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.$homework);
									if(!file_exists(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad))    //homework existe.si acadPeriod n'existe pas, on le cree 
										 mkdir(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad);
									if(!file_exists(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad.'/'.$shift))    //acadPeriod existe.si shiftName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad.'/'.$shift);
									if(!file_exists(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad.'/'.$shift.'/'.$section))    //shiftName existe.si sectionName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad.'/'.$shift.'/'.$section);
									  
                                    if(!file_exists(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level))    //sectionName existe.si levelName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level); 
										 
									                                       	
									if(!file_exists(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room))    //levelName existe.si roomName n'existe pas, on le cree
										 mkdir(Yii::app()->basePath . '/../'.$homework.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room);
									
   
						    $path = $homework.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room;
			   
			   
			  if($old_room != $this->room_id)
				 { //change PATH and DOCUMENT NAME
				     
				   //check if keeping requested
				   if(isset($_POST['Homework']['keepDoc'])&&($_POST['Homework']['keepDoc']==1))
				     {
						    
						    //move DOCUMENT to new path
                                   $explode_fileName= explode("/",substr($old_document, 0));
		                       
			                       for ($i = 0; $i < count($explode_fileName); $i++)
			                         {  
			                         	 $new_target1 =  Yii::app()->basePath.'/../'.$path.'/'.$explode_fileName[$i];
							             $old_target1 =  Yii::app()->basePath.'/../'.$old_path.'/'.$explode_fileName[$i];
			             
							               if(file_exists($old_target1))
					                         {  
					    
					     
					     rename($old_target1,$new_target1);
					     
					     
				//le dat remiz rive,update non permi	     
					                         	
					         			      }
					                           
					                        $new_target1 = '';
							                $old_target1 = '';
			                           }
			         
			         
			          //change DOCUMENT NAME in new path
				     	   	  //rename file
						       //find file extension
						       $explode_new_fileName= explode("/",substr($old_document, 0));
		                       
		                       $_new_name = '';
		                       $pass=0;
		                       for ($i = 0; $i < count($explode_new_fileName); $i++)
		                         {  
		                         	 $old_course_name =explode("_",substr($explode_new_fileName[$i], 0));
		                         	 
		                         	 $newname = $course_name.'_'.$old_course_name[1].'_'.$old_course_name[2];
		                         	 
		                         	
		                         	 
		                         	 $new_target =  Yii::app()->basePath.'/../'.$path.'/'.$newname;
						             $old_target =  Yii::app()->basePath.'/../'.$path.'/'.$explode_new_fileName[$i];
	             
						               if(file_exists($old_target))
				                         {  
				                         	rename($old_target,$new_target);
				                         	
				                         	if($pass==0)
				                         	   {  $pass=1;
				                         	   	  $_new_name = $newname;
				                         	   }
				                         	 else
				                         	    $_new_name = $_new_name.'/'.$newname; 
				                         	   
                                             
				                       
				                           }
				                           
				                        $new_target = '';
						                $old_target = '';
		                           }
						       
						          $model->setAttribute('attachment_ref',$_new_name);
                                  
                                  $final_new_name = $_new_name;
                        
                     			  						  
						  				                           
				        }
				     elseif(isset($_POST['Homework']['keepDoc'])&&($_POST['Homework']['keepDoc']==0))
			     	    	   {  
			     	    	   	    //delete sa ki te la deja
			     	    	   	    if($old_document!='')
			     	    	   	     { 
			     	    	   	     
			     	    	   	         $explode_name= explode("/",substr($old_document, 0));
                                           
						           	     for ($i = 0; $i < count($explode_name); $i++)
						           	        { 
						           	           $file_to_delete = Yii::app()->basePath.'/../'.$old_path.'/'.$explode_name[$i];//$name;
						           	            if(file_exists($file_to_delete))
                                                  {  unlink($file_to_delete);
                                                    $old_document='';
                                                    
                                                   }
						           	         }
						           	         
                                         if($old_document=='')
                                            {  
                                            	$model->setAttribute('attachment_ref','');
                                            	
                                            	$final_new_name = '';
                                              }
                                              
			     	    	   	       }    
                                           
                                              
                             }
			     	    	 	

				       //jwenn teacher apartir course
						    $person=Courses::model()->getTeacherByCourse($this->course_id);
						    if($person!=null)
						      $person=$person->getData();
						        foreach($person as $p)
						           $teacher_id=$p->id;
		
						     
							     $model->setAttribute('person_id',$teacher_id);
								 $model->setAttribute('course',$this->course_id);
								

				     
				  }
			   else //room hasn't been changed
			      {
			     	 //check if course is the same
			     	 if($old_courseID != $this->course_id)
			     	   {  
			     	   	  //check if keeping requested
			     	   	 if(isset($_POST['Homework']['keepDoc'])&&($_POST['Homework']['keepDoc']==1))
			     	   	   {
				     	   	  //change DOCUMENT NAME
				     	   	  $course_name_=$this->getCourse($this->course_id);
				     	   	  $course_name = strtr( $course_name_, pa_daksan() );
				     	   	  
				     	   	  //rename file
						       //find file extension
						       $explode_fileName= explode("/",substr($old_document, 0));
		                       
		                       $_new_name = '';
		                       $pass=0;
		                       for ($i = 0; $i < count($explode_fileName); $i++)
		                         {  
		                         	 $old_course_name =explode("_",substr($explode_fileName[$i], 0));
		                         	 
		                         	 $newname = $course_name.'_'.$old_course_name[1].'_'.$old_course_name[2];
		                         	 
		                         	
		                         	 
		                         	 $new_target =  Yii::app()->basePath.'/../'.$path.'/'.$newname;
						             $old_target =  Yii::app()->basePath.'/../'.$path.'/'.$explode_fileName[$i];
		             
						               if(file_exists($old_target))
				                         {  
				                         	rename($old_target,$new_target);
				                         	
				                         	if($pass==0)
				                         	   {  $pass=1;
				                         	   	  $_new_name = $newname;
				                         	   }
				                         	 else
				                         	    $_new_name = $_new_name.'/'.$newname; 
				                         	   
                                             
				                       
				                           }
				                           
				                        $new_target = '';
						                $old_target = '';
		                           }
						       
						          $model->setAttribute('attachment_ref',$_new_name);
                                  
                                  $final_new_name = $_new_name;
						      
			     	   	    }
			     	   	  elseif(isset($_POST['Homework']['keepDoc'])&&($_POST['Homework']['keepDoc']==0))
			     	    	   {  
			     	    	   	    //delete sa ki te la deja
			     	    	   	    if($old_document!='')
			     	    	   	     { 
			     	    	   	     
			     	    	   	         $explode_name= explode("/",substr($old_document, 0));
                                           
						           	     for ($i = 0; $i < count($explode_name); $i++)
						           	        { 
						           	           $file_to_delete = Yii::app()->basePath.'/../'.$path.'/'.$explode_name[$i];//$name;
						           	            if(file_exists($file_to_delete))
                                                  {  unlink($file_to_delete);
                                                    $old_document='';
                                                    
                                                   }
						           	         }
						           	         
                                         if($old_document=='')
                                            {  
                                            	$model->setAttribute('attachment_ref','');
                                            	
                                            	$final_new_name = '';
                                              }
                                              
			     	    	   	       }    
                                              
			     	    	     }      
			                     
			                     								  
 	
			     	    	  //jwenn teacher apartir course
						    $person=Courses::model()->getTeacherByCourse($this->course_id);
						    if($person!=null)
						      $person=$person->getData();
						        foreach($person as $p)
						           $teacher_id=$p->id;
		
						     
							     $model->setAttribute('person_id',$teacher_id);
								 $model->setAttribute('course',$this->course_id);
								 
			     	   	
			     	     }
			     	  else //course hasn't been changed
			     	     {
			     	    	//check if keeping not requested
			     	    	 if(isset($_POST['Homework']['keepDoc'])&&($_POST['Homework']['keepDoc']==0))
			     	    	   {  
			     	    	   	    //delete sa ki te la deja
			     	    	   	    if($old_document!='')
			     	    	   	     { 
			     	    	   	     
			     	    	   	         $explode_name= explode("/",substr($old_document, 0));
                                           
						           	     for ($i = 0; $i < count($explode_name); $i++)
						           	        { 
						           	           $file_to_delete = Yii::app()->basePath.'/../'.$path.'/'.$explode_name[$i];//$name;
						           	            if(file_exists($file_to_delete))
                                                  {  unlink($file_to_delete);
                                                    $old_document='';
                                                    
                                                   }
						           	         }
						           	         
                                          
			     	    	   	       }    
                                              
			     	    	     }   
			     	    	     
			     	    	    if($old_document=='')
                                            {  
                                            	$model->setAttribute('attachment_ref','');
                                            	
                                            	$final_new_name = '';
                                              }
                                          else
                                           $final_new_name = $old_document;
                                            
			     	    	   
	                        }//end of course  hasn't  been changed		     	    	     
			     	    	     
			     	    	     
	                    }//end of room  hasn't  been changed	     
			     	    	   
			     	    	   
			     	    	                                
                                            $ext_1 = '';
                            if($this->keep==0)
						  	  {
						  	  	if($_FILES['document']['name']!='')				  
								  { $info = pathinfo($_FILES['document']['name']);
									  if($info)  // check if uploaded file is set or not
									    {                        
								        
		                                    $ext = $info['extension']; // get the extension of the file
		                                   
										$ext = strtolower($ext);
										
								   if (in_array($ext, $this->ext_allowed))
										 { 
									 		   
		                                    $upload_file = $_FILES['document']['tmp_name'];
											    //checking the size
											       $size=filesize($_FILES['document']['tmp_name']);
		
											if ($size > 4*1024*1024)
										      {
														$this->messageSize=true; //Yii::t('app','You have exceeded the size limit.');
														//$errors=1;
											   }
											 else
											   {
													
													
													
													 $explode_name= explode(".",substr($_FILES['document']['name'], 0));
                                                      
                                                      $newname_1=$explode_name[0].'_'.$rnd.'.'.$ext;

													
													   
													   	$model->setAttribute('attachment_ref',$newname_1);
			
			                                        $target_new =  Yii::app()->basePath.'/../'.$path.'/'.$newname_1;
			                                         	  
											   }
											   
											   
										   }
										else
										   {
			                                   $this->messageExtension=true;
											$mesage=Yii::t('app','This document is not a valid one. Use one of these extensions: "odt", "pdf", "doc", "ods", "fods", "fodt", "odb", "odi", "oos", "oot", "otf", "otg", "oth", "oti", "otp", "ots", "sdp", "sds", "sdv", "sfs", "ods", "smf", "sms", "std", "stw", "sxg", "sxm", "vor", "sda", "sdc", "sdd", "odf", "odg", "ott", "pub", "rtf", "sdw", "sxc", "sxw", "bau", "dump", "fodg", "fodp", "odm", "odp", "otc", "psw", "sdb", "sgl", "smd", "stc", "sti", "svm", "sxd", "uot".');
											
										 }
										
										   
		
									       }
								       
			     	    	          }
								   			     	    	 	
	                          }
			     	    	
			     	      
			     	      
			       
	            if($this->keep==0)
				  {
					 if($_FILES['document']['name']!='')				  
					  {   if((!$this->messageSize)&&(!$this->messageExtension))
							 {				     
								        
											   if($model->save())
				                                 {  
				                                 	 move_uploaded_file( $upload_file, $target_new);
				                                 	 $this->success=true;
				                                 	 
				                                 	 $this->redirect(array('/academic/homework/view/id/'.$model->id.'/from/stud')); 
				                                 	 
										         }
				                     
							    }
							    
					   }
					  else
					    {
					    		if($model->save())
				                                 {  
				                              			                                 	 $this->success=true;
				                                 	 $this->redirect(array('/academic/homework/view/id/'.$model->id.'/from/stud'));
				                                         	 
										         }
	
					    	}
				    	
				   }
				 else
				   {
				   	    if($model->save())
				                                 {  
				                              			                                 	 $this->success=true;
				                                 	 $this->redirect(array('/academic/homework/view/id/'.$model->id.'/from/stud'));
				                                         	 
										         }

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
						     	  
						     	
			    }
			    
			    
				
			}
			
			
			
		}
		
		if(isset($_POST['cancel']))
                          {
                             
                              $this->redirect(Yii::app()->request->urlReferrer);
                          }



		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		
		
		try {
   			 $this->loadModel()->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			
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
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];  

$siges_structure = infoGeneralConfig('siges_structure_session');
		
		 if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			} 
			
		$model=new Homework('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Homework']))
			$model->attributes=$_GET['Homework'];
                
                // Here to export to CSV 
                if($this->isExportRequest()){
	                $this->exportCSV(array(Yii::t('app','List of homeworks: ')), null,false);
	                
	                $this->exportCSV($model->search($acad_sess), array(
	                'person.Fullname',
	                'course0.subject0.subject_name',
	                'course0.room0.room_name',
					'title',
					'description',
					'limit_date_submission',
					'given_date',
					'academicYear.name_period',
	                )); 
                }

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Homework('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Homework']))
			$model->attributes=$_GET['Homework'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}
	

	
public function getPath_teacher($room_id)
	{    
       	  $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');
       	  
       	  $code= array();
          	
          	$acad_name_ = $this->getAcademicPeriodName($acad_sess,$room_id)->name_period;
          	
          	$infoRoom = Rooms::model()->getInfoRoom($room_id);
          	
          	$infoRoom_ = $infoRoom->getData();
            
                 $shift_='';
              	 $section_='';
              	 $level_='';
              	 $room_name_='';
              	 
             foreach($infoRoom_ as $r)
              {
              	 $shift_=$r->shift;
              	 $section_=$r->section;
              	 $level_=$r->level;
              	 $room_name_=$r->room_name;
              	}
            
            $room = strtr( $room_name_, pa_daksan() );
			$level = strtr( $this->getLevel($level_), pa_daksan() );
			$section = strtr( $this->getSection($section_), pa_daksan() );
			$shift = strtr( $this->getShift($shift_), pa_daksan() );
			
			$sess_name='';
			$name_acad___ = '';
                      
                      if($siges_structure==1)
                        {  if($this->noSession)
                             {  Yii::app()->session['currentName_academic_session']=null;
                                Yii::app()->session['currentId_academic_session']=null;
                             	$sess_name=' / ';
                             }
                           else
                            { $sess_name =' / '.Yii::app()->session['currentName_academic_session'];
                              $name_acad___ = strtr( Yii::app()->session['currentName_academic_year'], pa_daksan() ).'/';
                            }
                        }
                      
                      
                        $name_acad = strtr( $acad_name_, pa_daksan() );
						    
						      	
          	
          	$path = $name_acad___.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room;

		
		return $path;
         
	}




//pou elev
public function getPath($person_id)
	{    
       	  $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');

       	  
       	  $code= array();
          	
          	$room_id = $this->getRoomByStudentId($person_id);
          	
          	$acad_name_ = $this->getAcademicPeriodName($acad_sess,$room_id->id)->name_period;
          	
          	$infoRoom = Rooms::model()->getInfoRoom($room_id->id);
          	
          	$infoRoom_ = $infoRoom->getData();
            
                 $shift_='';
              	 $section_='';
              	 $level_='';
              	 $room_name_='';
              	 
             foreach($infoRoom_ as $r)
              {
              	 $shift_=$r->shift;
              	 $section_=$r->section;
              	 $level_=$r->level;
              	 $room_name_=$r->room_name;
              	}
            
            $room = strtr( $room_name_, pa_daksan() );
			$level = strtr( $this->getLevel($level_), pa_daksan() );
			$section = strtr( $this->getSection($section_), pa_daksan() );
			$shift = strtr( $this->getShift($shift_), pa_daksan() );
			
			$sess_name='';
                      
                      if($siges_structure==1)
                        {  if($this->noSession)
                             {  Yii::app()->session['currentName_academic_session']=null;
                                Yii::app()->session['currentId_academic_session']=null;
                             	$sess_name=' / ';
                             }
                           else
                             $sess_name=' / '.Yii::app()->session['currentName_academic_session'];
                        }
                        
			$name_acad = strtr( $acad_name_.$sess_name, pa_daksan() );
						    
						      	
          	
          	$path = $name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room;
			
		return $path;
         
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
   //************************  getCourse($id) ******************************/
   public function getCourse($id)
	{
		$modelCourse= new Courses();
	    $result=$modelCourse->searchCourseByIdCourse($id);
        
			
		   if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i)
			     {			   
					return ( $i->subject_name.' ['.$i->teacher_name.'] ' );
			  	 }  
			  }
			else
			  return null;
			  
		
	}
	



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
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';//.$i->name_period;
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
	       $result=$modelCourse->searchByRoomId($room_id,$acad); 
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';//.$i->name_period;
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
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';
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
					  $code[$i->id]= $i->name_period.' / '.$i->evaluation_date;
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
					  $code[$i->id]= $i->name_period.' / '.$i->evaluation_date;
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

	


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Homework the loaded model
	 * @throws CHttpException
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Homework::model()->findByPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}
	
	
	       // Export to CSV 
    public function behaviors() {
       return array(
           'exportableGrid' => array(
               'class' => 'application.components.ExportableGridBehavior',
               'filename' => Yii::t('app','homework.csv'),
               'csvDelimiter' => ',',
               ));
    }



	/**
	 * Performs the AJAX validation.
	 * @param Homework $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='homework-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
}
