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



 
class PersonsController extends Controller
{
	
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	public $pathLink="";
	
	 public $list_id=1;
	 
	 public $transcriptItems=0;
	 public $transcriptAcadItems;
	
	public $kals_dat_panull = false;
	public $previous_level;
	public $applyLevel;
	
	public $messageCostEmpty=false;
	
	public $health_state; 
	public $father_full_name; 
	public $mother_full_name; 
	public $person_liable; 
	public $person_liable_phone;
	public $school_date_entry;
	
	public $l_name; 
	public $f_name;
	public $data=0; 
	
	public $photo;
	
	
     
        public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	public $room_id_to;
	public $department_id;
	public $idPreviousLevel;
	public $previousSchool;
	public $noStud;
	public $tot_stud;
	
	public $student_id;
	public $temoin_data=false;
	
	
	public $job_status_id;
	public $blood_group_id;
	//public $is_active_check;
	
	public $temoin_update=0;
	public $temoin_list;
	public $old;
	
	public $tot_stud_s =0;
	public $female_s =0;
	public $male_s =0;
	
	public $menfp; //classSetup
	
	public $success;
	public $message;
	public $messageNoSchedule=false;
	public $messageERROR=0;// roomAffectation; 0:initial for no error; 1:error for no selected room ; 2:error for no checked lines
	public $messageSUCCESS=false;// roomAffectation
	public $messageNoStud=false;// roomAffectation
	public $useRoomAffectation_room=false;
	public $useRoomAffectation_level=false;
	public $sort_by_level=0;
	public $idLevel_sort_zero;
	public $messagePreviousLevel=false;
	
	
	 public $ext_allowed  = array( "pdf" );
	
			   

	public function filters()
	{
		return array(
			'accessControl', 
		);
	}
        
        public function actions()
        {
            return array(
                'suggestStudent'=>array(
                'class'=>'ext.actions.XSuggestAction',
                'modelName'=>'Persons',
                'methodName'=>'suggest',
                ),
               );
        }


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
        
        public function actionSendEmail(){
            $modelemail = new Mails;
            $modelP = $this->loadModel();
            $command = Yii::app()->db->createCommand();
            if(isset($_POST['sendMail'])){
                $path = $path=array('viewForReport','id'=>$modelP->id,'pg'=>'lr','pi'=>'no','isstud'=>1,'from'=>'stud','marqueur'=>2);
                $this->redirect($path);
                if(isset($_POST['Mails[subject]']) && isset($_POST['Mails[message]'])){
                $subject_e = $_POST['Mails[subject]'];
                $message_e = $_POST['Mails[message]'];
                echo $message_e;
                }
                $command->insert('mails', array(
                                              'sender'=>Yii::app()->params['adminEmail'],
                                              'receivers'=>$modelP->email,
                                              'subject'=>$subject_e,
                                              'message'=>$message_e,
                                              'is_read'=>1,
                                              
					));
                
                
                
                $path = $path=array('viewForReport','id'=>$modelP->id,'pg'=>'lr','pi'=>'no','isstud'=>1,'from'=>'stud','marqueur'=>2);
                $this->redirect($path);
            }
            $this->render('viewForReport',array('model'=>$this->loadModel()));
        }
        
        
	public function actionView()
	{
		 
		 $this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}
	
	
	public function actionViewForUpdate()
	{
		$model=new Persons;
		 
		 
		 $this->render('viewForUpdate',array(
			'model'=>$this->loadModel(),   ));
	}
	
	
public function actionViewForReport()
	{    
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

		
		 $model=$this->loadModel();
		 $active=$model->active;

 
 
	   if(isset($_POST['apply']))
		 { //on vient de presser le bouton 
		    if((($active==1)||($active==2))&&(!isset($_POST['active'])))// disable requested
		      {
		      	 
		      	 $profil=""; 
                         $path="";
		  
		          $username= Persons::model()->getUsername($_GET['id']);
	
	 if($username!='')
	  {
		 //update "active" to 0 and reset password to "password" in Users table
		 $user=new User;
            
             $user = User::model()->findByAttributes(array('username'=>$username));
       

        if(isset($user->profil)&&($user->profil=!''))
		  {  
                              
                $profil_person= Profil::model()->findByPk($user->profil);
             
             $profil=$profil_person->profil_name;
             
		  
        
	           $password=md5("password");
	           
	            //delete (desactive) user a ansanm ak contact li
	            $command0 = Yii::app()->db->createCommand();
	           
						
			       $command0->delete('users', 'person_id=:id', array(':id'=>$_GET['id']));
	         }     
	     }   	                            
			//--------------------------
		    if($profil=='Teacher') // dezaktive tout kou li t genyen
		       {
		       	    $modelCourses=Courses::model()->findByAttributes(array('teacher'=>$_GET['id'],'academic_period'=>$acad_sess ));
		       	    
		       	    if($modelCourses!=null)
		       	     {  foreach($modelCourses as $course)
		       	         {
		       	         	$command1_1 = Yii::app()->db->createCommand();
		                       $command1_1->update('courses', array( 'old_new'=>0), 'id=:ID', array(':ID'=>$course->id));
		             
		       	         	}
		       	     	
		       	      }
		       	}
			//-------------------------------
			
			 //record data in Person_history table
			 
			    $command = Yii::app()->db->createCommand();
			    if($model->is_student==1)
			      { 
			      	//gade si elev la gen det nan lekol la
			      	$modelBalance=Balance::model()->findByAttributes(array('student'=>$_GET['id'] ));
					$stud_name = $model->first_name.' '.$model->last_name;
					if($modelBalance!=null)
					  Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','{name} has billing issue to fix.',array('{name}'=>$stud_name) )); 
			      				      				      	
			      	$entry_date="";
			      	$leaving_date="";
			      	$modelStudInfo=StudentOtherInfo::model()->findByAttributes(array('student'=>$model->id));
			      	if(isset($modelStudInfo)&&($modelStudInfo!=null))
			      	    {  $entry_date= $modelStudInfo->school_date_entry;
			      	      if($modelStudInfo->leaving_date!='')
			      	             $leaving_date=$modelStudInfo->leaving_date;
			      	        else
			      	          $leaving_date=date('Y-m-d');
			      	     }
			      	$level_name=Persons::model()->getLevel($model->id,$acad_sess);
			      	
			      	$command->insert('person_history', array(
								  'person_id'=>$model->id,
								  'entry_hire_date'=>$entry_date,
								  'disable_date'=>date('Y-m-d'),
								  'leaving_date'=>$leaving_date,
								  'profil'=>$profil,
								  'last_level_name'=>$level_name,
								  'academic_year'=>Yii::app()->session['currentName_academic_year'],
								  'created_by'=>Yii::app()->user->name,
										));
										
					  $path=array('listForReport','isstud'=>1,'from'=>'stud');
					
			       }
			     else //employee
			       {
			       	     $title_name = "";
			       	     $hire_date="";
			      	     $leaving_date_em="";
			      	     $job_status_name="";
			      	
			       	     
			       	     $modelTitles = PersonsHasTitles::model()->findByAttributes(array('persons_id'=>$model->id,'academic_year'=>$acad));//title_name sou tout ane akademik lan
			       	    
			       	  if(isset($modelTitles->titles_id)&&($modelTitles->titles_id!=''))
			      	       {  
			      	       	   $tmwen=0;
			      	       	
			      	       	 
			      	            	$title = Titles::model()->findByPk($modelTitles->titles_id);
			      	            	if($tmwen==0)
			      	            	  { $title_name = $title->title_name;
			      	            	    $tmwen=1;
			      	            	  }
			      	            	else
			      	            	  $title_name .= ', '.$title->title_name;
			      	        
			      	       
			      	        }
			      	    
			      	   $modelEmpInfo = EmployeeInfo::model()->findByAttributes(array('employee'=>$model->id)); 
			       	  
			       	  if(isset($modelEmpInfo)&&($modelEmpInfo!=null))
			      	    {  
			      	    	$hire_date=$modelEmpInfo->hire_date;
			      	        
			      	        if($modelEmpInfo->leaving_date!='')
			      	             $leaving_date_em=$modelEmpInfo->leaving_date;
			      	        else
			      	          $leaving_date_em=date('Y-m-d');
			      	     
			      	         if($modelEmpInfo->job_status!='')
			      	           $job_status_name=JobStatus::model()->findByPk($modelEmpInfo->job_status)->status_name;
			      	     
			      	     }
			      	     
			       	  $command->insert('person_history', array(
								  'person_id'=>$model->id,
								  'entry_hire_date'=>$hire_date,
								  'disable_date'=>date('Y-m-d'),
								  'leaving_date'=>$leaving_date_em,
								  'title'=>$title_name,
								  'profil'=>$profil,
								  'job_status_name'=>$job_status_name,
								  'academic_year'=>Yii::app()->session['currentName_academic_year'],
								  'created_by'=>Yii::app()->user->name,
										));
			       	 
			       	   $path=array('listForReport','from'=>'emp');
			       	
			       	}
	                            
	
				  
		              $command11 = Yii::app()->db->createCommand();
		             $command11->update('persons', array( 'active'=>0), 'id=:ID', array(':ID'=>$model->id));
		                              
        
			    
			       
			       
			     
			      $this->redirect($path);
				   		      	
		       } //fen disable request
		  
		     elseif((($active==0)||($active==3))&&(isset($_POST['active'])&&($_POST['active']==1))) // enable requested
		      {
		      	
		      	if(isset($_GET['isstud']))
		      	 { 
		      	      if($_GET['isstud']==1)
		      	        { $this->redirect(array('/academic/persons/update/','id'=>$_GET['id'],'isstud'=>'1','pg'=>'ext','from1'=>'rpt','from'=>'rpt'));
		      	         
		      	          }
		      	       elseif($_GET['isstud']==0)
		      	          {  
		      	          	   $this->redirect(array('/academic/persons/update/','id'=>$_GET['id'],'isstud'=>'0','pg'=>'ext','from1'=>'rpt','from'=>'rpt'));
		      	             }
		      	
		      	   }
		      	else
		      	    {
		      	    	$this->redirect(array('/academic/persons/update/','id'=>$_GET['id'],'pg'=>'ext','from1'=>'rpt','from'=>'rpt'));
		      	    	}
		      	
		       }
		      elseif(($active==0)&&(isset($_POST['active'])&&($_POST['active']==3))) // excluded requested
		        {
		      	    if(isset($_GET['isstud']))
			      	 { 
			      	      if($_GET['isstud']==1)
			      	        {              
			      	        	      $path=array('/academic/persons/listArchive','from1'=>'rpt');
																       
						              $command11 = Yii::app()->db->createCommand();
						              $command11->update('persons', array( 'active'=>3), 'id=:ID', array(':ID'=>$model->id));

                                      $this->redirect($path);

			      	          }
			      	       
			      	   }
			      	

		           
		           }
		   
		 
	   
	    }
	  elseif(isset($_POST['saveDoc']))
		 {
		 	  $path= '/documents/students_doc/';					   
						   						   
			$target ='';
					
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
													$file_name_ = preg_replace('/\s+/', '_', $_FILES['document']['name']); //replace spaces with underscores
													
													$description = $_POST['description'];
													
													$folder = $model->first_name.'_'.$model->last_name;
													
								if (!file_exists(Yii::app()->basePath.'/../'.'documents/students_doc'))  //si homework n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.'documents/students_doc');
										 
						 if (!file_exists(Yii::app()->basePath.'/../'.'documents/students_doc/'.$folder))  //si homework n'existe pas, on le cree
										 mkdir(Yii::app()->basePath.'/../'.'documents/students_doc/'.$folder);
										 
													                                                       
                                                      $path='documents/students_doc/'.$folder;
													
													 $target =  Yii::app()->basePath.'/../'.$path.'/'.$file_name_;
			                                         
											  //command insert
											   $command1_ = Yii::app()->db->createCommand();
											   $command1_->insert('student_documents', array(
												  'id_student'=>$model->id,
												  'file_name'=>$file_name_,
												  'description'=>$description,
												  ));
											 
											 move_uploaded_file( $_FILES['document']['tmp_name'], $target);
											 
											
											 
											   }
											   
								         }
								      else
								         {
			                               Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Load PDF file extension.'));
											
										 }
										
										 
		
									}
					          }
					          
					       
			                             	
			                                 	 
			               //$this->redirect(array('/academic/homework/view/id/'.$model->id.'/from/stud'));
					       
					       
					       
					       
					       
					       
					       
					       
		 }
		 
		 
		$this->render('viewForReport',array(
			'model'=>$model,
		));
	}
	
	

	
public function actionViewDetailAdmission()
	{    
		  $this->messageCostEmpty=false;
		  
		  $modelStudentOtherInfo = new StudentOtherInfo;
		  
		 $model=$this->loadModel();
		 
		    if(isset($_POST['StudentOtherInfo']))
					  {  $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
				
						    $this->applyLevel = $modelStudentOtherInfo->apply_for_level;
						    
						     //update studentOtherInfo to add applyLevel
						     if($this->applyLevel!='')
						       { $modelStudent = StudentOtherInfo::model()->findByAttributes(array('student'=>$_GET['id']));
						         $modelStudent->setAttribute('apply_for_level',$this->applyLevel);
						         $modelStudent->save();
						        }
						    
					      }
					    else
						   {  if(isset($_GET['al'])&&($_GET['al']!=0))
									$this->applyLevel = $_GET['al'];
								else
								   $this->applyLevel = '';
						   
						     }
						
		 
		 if(isset($_POST['payAdmision']))
			  { 
				   $cost = $_POST['Persons']['cost'];
				   
				  if(($cost!='')&&($cost!=0))
				        $this->redirect(array('/billings/otherIncomes/create?ri=2&al='.$this->applyLevel.'&p='.$cost.'&p_id='.$_GET['id'].'&from=ad'));
				  else
				     $this->messageCostEmpty=true;
			
			  }

		 
		 
	    
		$this->render('viewDetailAdmission',array(
			'model'=>$model,
		));
		
	}
	
	
	
    public function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
    }
	
	 
	
public function actionCreate()
	{
		$automatic_code = infoGeneralConfig('automatic_code');


		$model = new Persons;
		 $modelFee = new Fees;	
                $modelShift = new Shifts;
		$modelSection = new Sections;
		$modelLevel = new LevelHasPerson;
		$modelRoomPerson = new RoomHasPerson;
		$modelDepartment = new DepartmentHasPerson;
		
		$modelStudentOtherInfo = new StudentOtherInfo;
		$modelEmployeeInfo = new EmployeeInfo;
                
                $modelCustomFieldData = new CustomFieldData;
		
		$this->health_state=''; 
		 $this->father_full_name=''; 
		 $this->mother_full_name=''; 
		 $this->person_liable=''; 
		 $this->person_liable_phone='';
		 
		 $this->idShift='';
		 $this->section_id='';
		 $this->idLevel='';
		 $this->room_id='';
		 $this->idPreviousLevel='';
		 $this->previousSchool='';
		 $this->school_date_entry='';
		 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 	
					   	   
		$this->performAjaxValidation($model);

		if(isset($_POST['Persons']))
		{   
		   if((isset($_GET['isstud'])) && ($_GET['isstud']==1))
             {		  
               	  //on n'a pas presser le bouton, il fo load apropriate rooms
						  
					if(isset($_POST['Shifts']))
					  {	  $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
						   
			               $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   
						   $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
						   $this->idPreviousLevel = $modelStudentOtherInfo->previous_level;
						   
			               $this->health_state=$modelStudentOtherInfo->health_state; 
							 $this->father_full_name=$modelStudentOtherInfo->father_full_name; 
							 $this->mother_full_name=$modelStudentOtherInfo->mother_full_name; 
							 $this->person_liable=$modelStudentOtherInfo->person_liable; 
							 $this->person_liable_phone=$modelStudentOtherInfo->person_liable_phone;
							 $this->idPreviousLevel=$modelStudentOtherInfo->previous_level;
							 $this->previousSchool=$modelStudentOtherInfo->previous_school;
							 $this->school_date_entry=$modelStudentOtherInfo->school_date_entry;
					  }	 
							     
						   $model->attributes=$_POST['Persons'];
						   
						  
			       
				if(isset($_POST['create']))
				  { //on vient de presser le bouton
				       
				            			
						//les donnees pr person
					   $model->attributes=$_POST['Persons'];
					   					   
				       
					   $model->setAttribute('is_student',1);
					   $model->setAttribute('date_created',date('Y-m-d'));
					   $model->setAttribute('date_updated',date('Y-m-d'));
					   
					    //code automatic
					     if($automatic_code ==1)
						   { $cf='';
					         $cl='';
							 
                               //first_name							
							$explode_firstname=explode(" ",substr($model->first_name,0));
            
				            if(isset($explode_firstname[1])&&($explode_firstname[1]!=''))
							 { 
						        $cf = strtoupper(  substr(strtr($explode_firstname[0],pa_daksan() ), 0,1).substr(strtr($explode_firstname[1],pa_daksan() ), 0,1)  );
							   
							 }
							else
							 {  $cf = strtoupper( substr(strtr($explode_firstname[0],pa_daksan() ), 0,2)  );
						    
							 }

							 //last_name							
							$explode_lastname=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
							 { 
						        $cl = strtoupper(  substr(strtr($explode_lastname[0],pa_daksan() ), 0,1).substr(strtr($explode_lastname[1],pa_daksan() ), 0,1) );
							   
							 }
							else
							 {  $cl = strtoupper( substr(strtr( $explode_lastname[0],pa_daksan() ), 0,2)  );
						    
							 }
							 
							  $code_ = $cf.$cl.$model->id;
							
							  
							  //$command = Yii::app()->db->createCommand();
	                         // $command->update('persons', array( 'id_number'=>$code_ ), 'id=:ID', array(':ID'=>$model->id));
			  	             $model->setAttribute('id_number',$code_);

						   }
					   
					if((($model->birthday!='')&&($model->ageCalculator($model->birthday)>=1 ))||($model->birthday==''))
					  {
					   //upload........image
					    $rnd = rand(0,9999);
						
						   $fileName =$_FILES["image"]["name"];
	                      $uploadedfile = $_FILES['image']['tmp_name'];
							//$fileName = "";
						if($fileName)  // check if uploaded file is set or not
						  {                        
						          $filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension == "jpg") || ($extension == "jpeg") || ($extension == "png") || ($extension == "gif")) 
									  $model->image=$model->first_name.'_'.$model->last_name.'.'.$extension;
									else
						              $model->image="";
						  
							}
						else
						  $model->image="";
					   
					   if($model->save())
                        { 
					       
        // Demarrer enregistrement champs personalisables 
        $criteria_cf = new CDbCriteria; 
        $criteria_cf->condition = "field_related_to = 'stud'";
        $cfData = CustomField::model()->findAll($criteria_cf);
        foreach($cfData as $cd){
            if(isset($_POST[$cd->field_name])){
                $customFieldValue = $_POST[$cd->field_name];
                $modelCustomFieldData->setAttribute('field_link', $cd->id);
                $modelCustomFieldData->setAttribute('field_data', $customFieldValue);
                $modelCustomFieldData->setAttribute('object_id', $model->id);
                $modelCustomFieldData->save();
                $modelCustomFieldData->unsetAttributes();
                $modelCustomFieldData = new CustomFieldData;
            }
        }
        // Terminer Enregistrement champs personalisables


//saving photo
							if ($fileName)  // check if uploaded file is set or not
							  {   
							      
								  //check image extension
								    
									$filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
									 {
		
										$mesage=Yii::t('app','Unknown Image extension.');
										
									 }
									else
									 {   //checking the size
									       $size=filesize($_FILES['image']['tmp_name']);


											if ($size > 400*1024)
											{
												$mesage=Yii::t('app','You have exceeded the size limit.');
												
											}
											
											  if($extension=="jpg" || $extension=="jpeg" )
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefromjpeg($uploadedfile);

												}
												else if($extension=="png")
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefrompng($uploadedfile);

												}
												else 
												{
												$src = imagecreatefromgif($uploadedfile);
												}
												
												
												list($width,$height)=getimagesize($uploadedfile);


												$newwidth=140; 
												$newheight=($height/$width)*$newwidth;
												$tmp=imagecreatetruecolor($newwidth,$newheight);


												$newwidth1=34;//25;
												$newheight1=($height/$width)*$newwidth1;
												$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

												imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

												imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


												//$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$_FILES['image']['name'];
												$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$model->first_name.'_'.$model->last_name.'.'.$extension;

												



												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);

									 
									 }
							      
								    
							  }
							
							
                            		 $group=Groups::model()->getGroupIdByName("Student");
							   	  $group=$group->getData();
							   	  if(isset($group)&&($group!=''))
							   	     {  foreach($group as $g)
							   	            {
							   	            	$group_id=$g->id;
							   	            	}
							   	     	
							   	     	}
							   	     	
							   	   $profil=Profil::model()->getProfilIdByName("Guest");
							   	  $profil=$profil->getData();
							   	  if(isset($profil)&&($profil!=''))
							   	     {  foreach($profil as $prof)
							   	            {
							   	            	$profil_id=$prof->id;
							   	            	}
							   	     	
							   	     	}
                            	  
                            	  

							
                            $explode_lastname=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
				              $username= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname[1]), pa_daksan() ).$model->id;
				            else
				              $username= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).$model->id;
                            
                            $full_name = ucwords($model->first_name.' '.$model->last_name);
                            $create_by = Yii::app()->user->name;
                            $password = md5("password");
                            
                            $command1 = Yii::app()->db->createCommand();
						    $command1->insert('users', array(
							  'username'=>$username,
							  'password'=>$password,
							  'full_name'=>$full_name,
							  'active'=>1,
							  'person_id'=>$model->id,
							  'profil'=>$profil_id,
							  'group_id'=>$group_id,
							  'is_parent'=>0,
							  'create_by'=>$create_by,
							  'date_created'=>date('Y-m-d'),
							  'date_updated'=>date('Y-m-d'),
									));
									
                   
							$pers=$model->id;
							$model->unSetAttributes();
							$this->useRoomAffectation_room=false;
							$this->useRoomAffectation_level=false;
					
					  if($modelLevel!=null)
					   {      $modelLevel->setAttribute('academic_year',$acad_sess);
						      $modelLevel->setAttribute('students',$pers);
							  
						  
						if($modelLevel->save())
						   { 
							  
							  		      
			
			//&&&&&&&&&&&&&&&&   calcul pour automatiser "balance a payer"
							     $model_fees= new Fees;
							     $data_fees_datelimit=Fees::model()->checkDateLimitPaymentByLevel(date('Y-m-d'),$this->idLevel,$acad_sess);
				
							     if(isset($data_fees_datelimit)&&($data_fees_datelimit!=null))
							       { 
							       	 $data_fees_datelimit=$data_fees_datelimit->getData();
							       	 foreach($data_fees_datelimit as $date_limit)
							       	   {  
								       	
								       	
								       	 $fee_period_id=$date_limit->id;
								         
								         $amount1=$date_limit->amount;
								         $amount=$date_limit->amount;
								          
								          $pass=false;
								          
								            //billings record for each stud
									           	   unset($modelBillings); 
									           	   $modelBillings= new Billings;
									       
									    	  
									           	 	$modelBillings->setAttribute('student',$pers);
													$modelBillings->setAttribute('fee_period',$fee_period_id);
													$modelBillings->setAttribute('academic_year',$acad_sess);
													$modelBillings->setAttribute('amount_to_pay',$amount); 
													$modelBillings->setAttribute('amount_pay',0); 
													$modelBillings->setAttribute('balance', $amount);
													$modelBillings->setAttribute('created_by', "SIGES");
													$modelBillings->setAttribute('date_created', date('Y-m-d')); 
													
									           
		 
							                if($modelBillings->save())
							                   {           
							                          
									           	   //balance record for each stud
									           	   //create new model
									           	          unset($modelBalance); 
							                              $modelBalance= new Balance;
							                              
							                              $modelBalance->setAttribute('balance',$amount); 
															  
														  $modelBalance->setAttribute('student',$pers);
														  $modelBalance->setAttribute('date_created',date('Y-m-d'));
																  
														  if($modelBalance->save())
															 $pass=true;
															
							           	     
									           	     
									           	    
									           	  
							                    } 
							                    
							                   
									   									     					           
							           }//fen foreach($data_fees_datelimit as $date_limit)
							           
							        }//fen if(isset($data_fees_datelimit)&&($data_fees_datelimit!=null))
							        
							     
					        
							  
							  
							  if(isset($_POST['RoomHasPerson'])&&($_POST['RoomHasPerson']!=null))
						        {  $room=new RoomHasPerson;
						           $room->attributes=$_POST['RoomHasPerson'];
							      //les donnees pr romm-has-person
							   
								 
								   $modelRoomPerson->setAttribute('academic_year',$acad_sess);
								   $modelRoomPerson->setAttribute('students',$pers);
								   $modelRoomPerson->setAttribute('room',$room->room);
								   $modelRoomPerson->setAttribute('date_created',date('Y-m-d'));
								   $modelRoomPerson->setAttribute('date_updated',date('Y-m-d'));
									  
							          
								      if($modelRoomPerson->save())	
										 {  
										 	//data pou Student_other_info
										 	if(isset($_POST['StudentOtherInfo'])&&($_POST['StudentOtherInfo']!=null))
											 {	 $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
									                $this->idPreviousLevel = $modelStudentOtherInfo->previous_level;
									   
									              $modelStudentOtherInfo->setAttribute('student',$pers);
											 	$modelStudentOtherInfo->setAttribute('date_created',date('Y-m-d'));
											 	$modelStudentOtherInfo->save();
											 	
											  }
										 	
										 	$this->redirect(array('viewForReport','id'=>$pers,'isstud'=>'1','from'=>'stud'));
										 }
									   else
							             { $this->useRoomAffectation_room=true;
							             	$this->redirect(array('viewForReport','urar'=>'y','id'=>$pers,'isstud'=>'1','from'=>'stud'));
							               }
						           }
							    else
							      {  $this->useRoomAffectation_room=true;
							      	$this->redirect(array('viewForReport','urar'=>'y','id'=>$pers,'isstud'=>'1','from'=>'stud'));
							       }
					          
						    }
						  else
						    { $this->useRoomAffectation_level=true;
							    $this->redirect(array('viewForReport','ural'=>'y','id'=>$pers,'isstud'=>'1','from'=>'stud'));
						      }
							 
					     }
					  else
					    { $this->useRoomAffectation_level=true;
						    $this->redirect(array('viewForReport','ural'=>'y','id'=>$pers,'isstud'=>'1','from'=>'stud'));
					      }
						
			            }
			        
				     }
				   else
				      Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Student may have at least').' 1 '.Yii::t('app','yr old'));
			        
			        
			         }
			         
			          if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
				  
		      }
			else
			  {   
			     				  
				  $model->attributes=$_POST['Persons'];
				   
				if(isset($_POST['create']))
				  { //on vient de presser le bouton
				      					   
				       	$model->setAttribute('is_student',0);												   
						$model->setAttribute('date_created',date('Y-m-d'));
					    $model->setAttribute('date_updated',date('Y-m-d'));
					    
					    //code automatic
					     if($automatic_code ==1)
						   { $cf='';
					         $cl='';
							 
                               //first_name							
							$explode_firstname=explode(" ",substr($model->first_name,0));
            
				            if(isset($explode_firstname[1])&&($explode_firstname[1]!=''))
							 { 
						        $cf = strtoupper(  substr(strtr($explode_firstname[0],pa_daksan() ), 0,1).substr(strtr($explode_firstname[1],pa_daksan() ), 0,1)  );
							   
							 }
							else
							 {  $cf = strtoupper( substr(strtr($explode_firstname[0],pa_daksan() ), 0,2)  );
						    
							 }

							 //last_name							
							$explode_lastname=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
							 { 
						        $cl = strtoupper(  substr(strtr($explode_lastname[0],pa_daksan() ), 0,1).substr(strtr($explode_lastname[1],pa_daksan() ), 0,1) );
							   
							 }
							else
							 {  $cl = strtoupper( substr(strtr( $explode_lastname[0],pa_daksan() ), 0,2)  );
						    
							 }
							 
							  $code_ = $cf.$cl.$model->id;
							
							  
							 // $command = Yii::app()->db->createCommand();
	                          //$command->update('persons', array( 'id_number'=>$code_ ), 'id=:ID', array(':ID'=>$model->id));
			  	             $model->setAttribute('id_number',$code_);

						   }


					if((($model->birthday!='')&&($model->ageCalculator($model->birthday)>=18 ))||($model->birthday==''))
					  {   //upload........image
					    $rnd = rand(0,9999);
						
						   $fileName =$_FILES["image"]["name"];
	                      $uploadedfile = $_FILES['image']['tmp_name'];
							
						if($fileName)  
						  {                        
						     $filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension == "jpg") || ($extension == "jpeg") || ($extension == "png") || ($extension == "gif")) 
									  $model->image=$model->first_name.'_'.$model->last_name.'.'.$extension;
									else
						              $model->image="";
							}
						else
						  $model->image="";
					   
					

					if($model->save())
					  {  
				         						   
				  
				          if ($fileName)  // check if uploaded file is set or not
							  {  //saving photo //$uploadedFile->saveAs(Yii::app()->basePath.'/../photo-Uploads/1/'.$fileName);
							      
								  //check image extension
								    
									$filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
									 {
		
										$mesage=Yii::t('app','Unknown Image extension.');
										
									 }
									else
									 {   //saving photo
									 
									      //checking the size
									       $size=filesize($_FILES['image']['tmp_name']);


											if ($size > 400*1024)
											{
												$mesage=Yii::t('app','You have exceeded the size limit.');
												
											}
											
											  if($extension=="jpg" || $extension=="jpeg" )
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefromjpeg($uploadedfile);

												}
												else if($extension=="png")
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefrompng($uploadedfile);

												}
												else 
												{
												$src = imagecreatefromgif($uploadedfile);
												}
												
												
												list($width,$height)=getimagesize($uploadedfile);


												$newwidth=105;//60;
												$newheight=($height/$width)*$newwidth;
												$tmp=imagecreatetruecolor($newwidth,$newheight);


												$newwidth1=25;
												$newheight1=($height/$width)*$newwidth1;
												$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

												imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

												imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


												//$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$_FILES['image']['name'];
												$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$model->first_name.'_'.$model->last_name.'.'.$extension;

												



												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);

									 }
									 
							  }
							  
					     //create more info for this employee
					    if(isset($_POST['EmployeeInfo']))
					     {   $modelEmployeeInfo->attributes=$_POST['EmployeeInfo'];
							
						    $command = Yii::app()->db->createCommand();
						    
						    if(($modelEmployeeInfo->hire_date!=null)&&($modelEmployeeInfo->job_status!=null))
						      $command->insert('employee_info', array(
							  'employee'=>$model->id,
							  'hire_date'=>$modelEmployeeInfo->hire_date,
							  'job_status'=>$modelEmployeeInfo->job_status,
							  'create_by'=>Yii::app()->user->name,
							  'date_created'=>date('Y-m-d'),
							  'date_updated'=>date('Y-m-d'),
									));
							elseif(($modelEmployeeInfo->hire_date!=null)&&($modelEmployeeInfo->job_status==null))
							  $command->insert('employee_info', array(
							  'employee'=>$model->id,
							  'hire_date'=>$modelEmployeeInfo->hire_date,
							 
							  'create_by'=>Yii::app()->user->name,
							  'date_created'=>date('Y-m-d'),
							  'date_updated'=>date('Y-m-d'),
									));
							elseif(($modelEmployeeInfo->hire_date==null)&&($modelEmployeeInfo->job_status!=null))
								$command->insert('employee_info', array(
							  'employee'=>$model->id,
							  
							  'job_status'=>$modelEmployeeInfo->job_status,
							  'create_by'=>Yii::app()->user->name,
							  'date_created'=>date('Y-m-d'),
							  'date_updated'=>date('Y-m-d'),
									));
	
					      }		
                            
                            // create login account for this person
                                   // c pa etudiant
                            	 $group=Groups::model()->getGroupIdByName("Default Group");
								   	  $group=$group->getData();
								   	  if(isset($group)&&($group!=''))
								   	     {  foreach($group as $g)
								   	            {
								   	            	$group_id=$g->id;
								   	            	}
								   	     	
								   	     	}
								   	     	
								   	   $profil=Profil::model()->getProfilIdByName("Guest");
								   	  $profil=$profil->getData();
								   	  if(isset($profil)&&($profil!=''))
								   	     {  foreach($profil as $prof)
								   	            {
								   	            	$profil_id=$prof->id;
								   	            	}
								   	     	
								   	     	}
	                              

							
                            $explode_lastname_=explode(" ",substr($model->last_name,0 ));
            
				            if(isset($explode_lastname_[1])&&($explode_lastname_[1]!=''))
				              $username= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname_[1]), pa_daksan() ).$model->id;
				            else
				              $username= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$model->id;
                            
                            $full_name = ucwords($model->first_name.' '.$model->last_name);
                            $create_by = Yii::app()->user->name;
                            $password = md5("password");
                           
                            
                            $command1 = Yii::app()->db->createCommand();
						    $command1->insert('users', array(
							  'username'=>$username,
							  'password'=>$password,
							  'full_name'=>$full_name,
							  'active'=>1,
							  'person_id'=>$model->id,
							  'profil'=>$profil_id,
							  'group_id'=>$group_id,
							  'is_parent'=>0,
							  'create_by'=>$create_by,
							  'date_created'=>date('Y-m-d'),
							  'date_updated'=>date('Y-m-d'),
									));
					
					 //department in which this person works
						    if(isset($_POST['DepartmentHasPerson']))
					          {     $modelDepartment->attributes=$_POST['DepartmentHasPerson'];
					      	       $modelDepartment->setAttribute('academic_year',$acad);  //sou tout ane akademik lan
								   $modelDepartment->setAttribute('employee',$model->id);
								   $modelDepartment->setAttribute('date_created',date('Y-m-d'));
								   $modelDepartment->setAttribute('date_updated',date('Y-m-d'));
			  
                                 $modelDepartment->save();
					          }				
                                               
						//title of this person
					 if(isset($_POST['Persons']['Title']))
						 {  $personsHasTitles=new PersonsHasTitles;
						 
						    $data= $_POST['Persons']['Title'];
							foreach ($data as $title)
							  {  
								$personsHasTitles->setAttribute('persons_id',$model->id);
								$personsHasTitles->setAttribute('titles_id',$title);
								$personsHasTitles->setAttribute('academic_year',$acad); //sou tout ane akademik lan
								 							
								$personsHasTitles->save();
															
								unset($personsHasTitles);
								$personsHasTitles=new PersonsHasTitles;
															
							   }
						 }
                         
                        
						if(isset($_GET['isstud']))
						    $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>0,'from'=>'teach'));
						else
						    $this->redirect(array('viewForReport','id'=>$model->id,'from'=>'emp'));
		      
		             
		             }
		          
		          
		          }
				   else
				      Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Employee may have at least').' 18 '.Yii::t('app',' yr old'));
			           
		             
			     }//fenPOST create 
			      
		             
		         if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
		      }
		}

		   		
		$this->render('create',array(
			'model'=>$model,
		));
	}



	
	
public function actionAdmission()
  {
		$automatic_code = infoGeneralConfig('automatic_code');
//code automatic
					     
						   
						   
		$model=new Persons;
        
		$modelStudentOtherInfo = new StudentOtherInfo;
		
		
		
		$this->health_state=''; 
		 $this->father_full_name=''; 
		 $this->mother_full_name=''; 
		 $this->person_liable=''; 
		 $this->person_liable_phone='';
		 $this->school_date_entry='';		 
		 
		$fileName_old="";
		
		$username="";
		$code_='';
		
		
	 if(isset($_GET['id'])&&($_GET['id']!=''))//pour l'affichage
	   { $model=$this->loadModel();
		   $fileName_old = $model->image;
		   
		    $explode_lastname=explode(" ",substr($model->last_name,0 ));
           
            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
              $username= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname[1]), pa_daksan() ).$model->id;
            else
              $username= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).$model->id;
           
		   //code automatic
					     if($automatic_code ==1)
						   { $cf='';
					         $cl='';
							 
                               //first_name							
							$explode_firstname=explode(" ",substr($model->first_name,0));
            
				            if(isset($explode_firstname[1])&&($explode_firstname[1]!=''))
							 { 
						        $cf = strtoupper(  substr(strtr($explode_firstname[0],pa_daksan() ), 0,1).substr(strtr($explode_firstname[1],pa_daksan() ), 0,1)  );
							   
							 }
							else
							 {  $cf = strtoupper( substr(strtr($explode_firstname[0],pa_daksan() ), 0,2)  );
						    
							 }

							 //last_name							
							$explode_lastname=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
							 { 
						        $cl = strtoupper(  substr(strtr($explode_lastname[0],pa_daksan() ), 0,1).substr(strtr($explode_lastname[1],pa_daksan() ), 0,1) );
							   
							 }
							else
							 {  $cl = strtoupper( substr(strtr( $explode_lastname[0],pa_daksan() ), 0,2)  );
						    
							 }
							 
							  $code_ = $cf.$cl.$model->id;
							
							 							  
						}
		  
		  
		  $modelStudentOtherInfo = StudentOtherInfo::model()->findByAttributes(array('student'=>$_GET['id']));
		   
	   }


		 	
		$this->performAjaxValidation($model);


		if(isset($_POST['Persons']))
		  {   
		        //on n'a pas presser le bouton, il faut load apropriate rooms
						  
				$modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
				$this->idPreviousLevel = $modelStudentOtherInfo->previous_level;
						   
			    $this->health_state=$modelStudentOtherInfo->health_state; 
							 $this->father_full_name=$modelStudentOtherInfo->father_full_name; 
							 $this->mother_full_name=$modelStudentOtherInfo->mother_full_name; 
							 $this->person_liable=$modelStudentOtherInfo->person_liable; 
							 $this->person_liable_phone=$modelStudentOtherInfo->person_liable_phone;
							 $this->idPreviousLevel=$modelStudentOtherInfo->previous_level;
							 $this->previousSchool=$modelStudentOtherInfo->previous_school;
							 $this->school_date_entry=$modelStudentOtherInfo->school_date_entry;
 

 
               
					$model->attributes=$_POST['Persons'];
					
						   
			if(!isset($_GET['id']))       
			  {
			  	if(isset($_POST['create']))
				  { //on vient de presser le bouton
				       
			   if((($model->birthday!='')&&($model->ageCalculator($model->birthday)>=1 ))||($model->birthday==''))
				{
				   if($this->idPreviousLevel!='')
				    {         			
						//les donnees pr person
					   $model->attributes=$_POST['Persons'];
					   					   
				       $model->setAttribute('is_student',1);
				       $model->setAttribute('active',2); //new (just come)
					   $model->setAttribute('date_created',date('Y-m-d'));
					   $model->setAttribute('date_updated',date('Y-m-d'));
					   
					   //code automatic
					     if($automatic_code ==1)
						   { $cf='';
					         $cl='';
							 
                               //first_name							
							$explode_firstname=explode(" ",substr($model->first_name,0));
            
				            if(isset($explode_firstname[1])&&($explode_firstname[1]!=''))
							 { 
						        $cf = strtoupper(  substr(strtr($explode_firstname[0],pa_daksan() ), 0,1).substr(strtr($explode_firstname[1],pa_daksan() ), 0,1)  );
							   
							 }
							else
							 {  $cf = strtoupper( substr(strtr($explode_firstname[0],pa_daksan() ), 0,2)  );
						    
							 }

							 //last_name							
							$explode_lastname=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
							 { 
						        $cl = strtoupper(  substr(strtr($explode_lastname[0],pa_daksan() ), 0,1).substr(strtr($explode_lastname[1],pa_daksan() ), 0,1) );
							   
							 }
							else
							 {  $cl = strtoupper( substr(strtr( $explode_lastname[0],pa_daksan() ), 0,2)  );
						    
							 }
							 
							  $code_ = $cf.$cl.$model->id;
							
							  
							  //$command = Yii::app()->db->createCommand();
	                          //$command->update('persons', array( 'id_number'=>$code_ ), 'id=:ID', array(':ID'=>$model->id));
			  	              $model->setAttribute('id_number',$code_);
 
						   }
					

					   
					   //upload........image
					    $rnd = rand(0,9999);
						//$uploadedFile=CUploadedFile::getInstance($model,'image'); 
						   $fileName =$_FILES["image"]["name"];
	                      $uploadedfile = $_FILES['image']['tmp_name'];
							//$fileName = "";
					   if($fileName)  // check if uploaded file is set or not
						  {                        
					        $filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension == "jpg") || ($extension == "jpeg") || ($extension == "png") || ($extension == "gif")) 
									  $model->image=$model->first_name.'_'.$model->last_name.'.'.$extension;
									else
						              $model->image="";
					   	}
					   else
						  $model->image="";
					   
					   if($model->save())
                        {  
										
					       //saving photo
							if ($fileName)  // check if uploaded file is set or not
							  {   
                                                            
							      
								  //check image extension
								    
									$filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
									 {
		
										$mesage=Yii::t('app','Unknown Image extension.');
										//$errors=1;
									 }
									else
									 {   //checking the size
									       $size=filesize($_FILES['image']['tmp_name']);


											if ($size > 400*1024)
											{
												$mesage=Yii::t('app','You have exceeded the size limit.');
												
											}
											
											  if($extension=="jpg" || $extension=="jpeg" )
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefromjpeg($uploadedfile);

												}
												else if($extension=="png")
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefrompng($uploadedfile);

												}
												else 
												{
												$src = imagecreatefromgif($uploadedfile);
												}
												
												
												list($width,$height)=getimagesize($uploadedfile);


												$newwidth=105;
												$newheight=($height/$width)*$newwidth;
												$tmp=imagecreatetruecolor($newwidth,$newheight);


												$newwidth1=25;
												$newheight1=($height/$width)*$newwidth1;
												$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

												imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

												imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


												//$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$_FILES['image']['name'];
												$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$model->first_name.'_'.$model->last_name.'.'.$extension;

												


												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);

									 
									 }
							      
								    
							  }
							
							
                            		 $group=Groups::model()->getGroupIdByName("Student");
							   	  $group=$group->getData();
							   	  if(isset($group)&&($group!=''))
							   	     {  foreach($group as $g)
							   	            {
							   	            	$group_id=$g->id;
							   	            	}
							   	     	
							   	     	}
							   	     	
							   	   $profil=Profil::model()->getProfilIdByName("Guest");
							   	  $profil=$profil->getData();
							   	  if(isset($profil)&&($profil!=''))
							   	     {  foreach($profil as $prof)
							   	            {
							   	            	$profil_id=$prof->id;
							   	            	}
							   	     	
							   	     	}
                            	  
                            	  
 
							
                            $explode_lastname=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
				              $username= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname[1]), pa_daksan() ).$model->id;
				            else
				              $username= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).$model->id;
                            
                            $full_name = ucwords($model->first_name.' '.$model->last_name);
                            $create_by = Yii::app()->user->name;
                            $password = md5("password");
                            
                            $command1 = Yii::app()->db->createCommand();
						    $command1->insert('users', array(
							  'username'=>$username,
							  'password'=>$password,
							  'full_name'=>$full_name,
							  'active'=>1,
							  'person_id'=>$model->id,
							  'profil'=>$profil_id,
							  'group_id'=>$group_id,
							  'is_parent'=>0,
							  'create_by'=>$create_by,
							  'date_created'=>date('Y-m-d'),
							  'date_updated'=>date('Y-m-d'),
									));
									
                   
							$pers=$model->id;
							$model->unSetAttributes();
							$this->useRoomAffectation_room=false;
							$this->useRoomAffectation_level=false;
					
					  
					  		
							 $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
							     $this->idPreviousLevel = $modelStudentOtherInfo->previous_level;
									   
							      $modelStudentOtherInfo->setAttribute('student',$pers);
								  $modelStudentOtherInfo->setAttribute('date_created',date('Y-m-d'));
								  $modelStudentOtherInfo->save();
											 	
							     
							     
							     
							     
							     
							     
						$this->redirect(array('viewDetailAdmission','id'=>$pers,'al'=>0,'from'=>'ad'));	  
							  
							  
							  
							  
							  
							  

			               }
			             }
				  }
				 else
				   Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Student may have at least').' 1 '.Yii::t('app','yr old')); 
				      
			           }
			        else
			            $this->messagePreviousLevel=true;
			    
			    }
			  elseif(isset($_GET['id'])&&($_GET['id']!=''))
			    {
			     	if(isset($_POST['update']))
				    {//on vient de presser le bouton
				       
					   //les donnees pr person
					   $model->attributes=$_POST['Persons'];
					   
					  if((($model->birthday!='')&&($model->ageCalculator($model->birthday)>=1 ))||($model->birthday==''))
					  { 				   
				        //on c dja que c 1 student
					   $model->setAttribute('date_updated',date('Y-m-d'));
					   
					   //code automatic
					     if($automatic_code ==1)
						   { $cf='';
					         $cl='';
							 
                               //first_name							
							$explode_firstname=explode(" ",substr($model->first_name,0));
            
				            if(isset($explode_firstname[1])&&($explode_firstname[1]!=''))
							 { 
						        $cf = strtoupper(  substr(strtr($explode_firstname[0],pa_daksan() ), 0,1).substr(strtr($explode_firstname[1],pa_daksan() ), 0,1)  );
							   
							 }
							else
							 {  $cf = strtoupper( substr(strtr($explode_firstname[0],pa_daksan() ), 0,2)  );
						    
							 }

							 //last_name							
							$explode_lastname=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
							 { 
						        $cl = strtoupper(  substr(strtr($explode_lastname[0],pa_daksan() ), 0,1).substr(strtr($explode_lastname[1],pa_daksan() ), 0,1) );
							   
							 }
							else
							 {  $cl = strtoupper( substr(strtr( $explode_lastname[0],pa_daksan() ), 0,2)  );
						    
							 }
							 
							  $code_ = $cf.$cl.$model->id;
							
							  
							  //$command = Yii::app()->db->createCommand();
	                         // $command->update('persons', array( 'id_number'=>$code_ ), 'id=:ID', array(':ID'=>$model->id));
			  	           $model->setAttribute('id_number',$code_);

						   }    	  

					         
							      $fileName =$_FILES["image"]["name"];
								  $uploadedfile = $_FILES['image']['tmp_name'];
									//$fileName = "";
								if($fileName)  // check if uploaded file is set or not
								  {  //check if we have the same image
                                     if(($fileName!=$fileName_old)&&($fileName_old!=""))
									   { $file_to_delete = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$fileName_old;
                                         if(file_exists($file_to_delete))
                                              unlink($file_to_delete);
                                             	
                                        }										  
									  $filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension == "jpg") || ($extension == "jpeg") || ($extension == "png") || ($extension == "gif")) 
									  $model->image=$model->first_name.'_'.$model->last_name.'.'.$extension;
									else
						              $model->image="";
									}
								else
								  $model->image = $fileName_old;
					  
					   if($model->save())
					    {    						     
							 if ($fileName)  // check if uploaded file is set or not
							  { //saving photo  
							      
								  //check image extension
								    
									$filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
									 {
		
										$mesage=Yii::t('app','Unknown Image extension.');
										
									 }
									else
									 {   //checking the size
									       $size=filesize($_FILES['image']['tmp_name']);


											if ($size > 400*1024)
											{
												$mesage=Yii::t('app','You have exceeded the size limit.');
												
											}
											
											  if($extension=="jpg" || $extension=="jpeg" )
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefromjpeg($uploadedfile);

												}
												else if($extension=="png")
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefrompng($uploadedfile);

												}
												else 
												{
												$src = imagecreatefromgif($uploadedfile);
												}
												
												
												list($width,$height)=getimagesize($uploadedfile);


												$newwidth=105;//60;
												$newheight=($height/$width)*$newwidth;
												$tmp=imagecreatetruecolor($newwidth,$newheight);


												$newwidth1=25;
												$newheight1=($height/$width)*$newwidth1;
												$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

												imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

												imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


												//$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$_FILES['image']['name'];
												$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$model->first_name.'_'.$model->last_name.'.'.$extension;

												



												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);
						          
						                 }
								} 
										 
										 
				  // update login account for this person
							
							
                            $explode_lastname_=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname_[1])&&($explode_lastname[1]!=''))
				              $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname_[1]), pa_daksan() ).$model->id;
				            else
				              $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$model->id;
				                            
                            
                            
                            
                            $full_name_up=ucwords($model->first_name.' '.$model->last_name);
                           
							
							$user=new User;
                            $user = User::model()->findByAttributes(array('username'=>$username));
                          
                         if($user!=null)// on fait 1 update
                           {
                            
                              $command2 = Yii::app()->db->createCommand();
	                          $command2->update('users', array(
												'username'=>$username_up,'full_name'=>$full_name_up,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name
											), 'id=:ID', array(':ID'=>$user->id));
                            }
                          else // enter 1 new record
                            {
                              if($model->is_student==1)//si c etudiant
                            	{ $group=Groups::model()->getGroupIdByName("Student");
							   	  $group=$group->getData();
							   	  if(isset($group)&&($group!=''))
							   	     {  foreach($group as $g)
							   	            {
							   	            	$group_id=$g->id;
							   	            	}
							   	     	
							   	     	}
							   	     	
							   	   $profil=Profil::model()->getProfilIdByName("Guest");
							   	  $profil=$profil->getData();
							   	  if(isset($profil)&&($profil!=''))
							   	     {  foreach($profil as $prof)
							   	            {
							   	            	$profil_id=$prof->id;
							   	            	}
							   	     	
							   	     	}
                            	   }
                            	 else
                            	    { $group=Groups::model()->getGroupIdByName("Default Group");
								   	  $group=$group->getData();
								   	  if(isset($group)&&($group!=''))
								   	     {  foreach($group as $g)
								   	            {
								   	            	$group_id=$g->id;
								   	            	}
								   	     	
								   	     	}
								   	     	
								   	   $profil=Profil::model()->getProfilIdByName("Guest");
								   	  $profil=$profil->getData();
								   	  if(isset($profil)&&($profil!=''))
								   	     {  foreach($profil as $prof)
								   	            {
								   	            	$profil_id=$prof->id;
								   	            	}
								   	     	
								   	     	}
	                            	   }
                              
                              $create_by = Yii::app()->user->name;
	                            $password = md5("password");
	                            
	                            $command10 = Yii::app()->db->createCommand();
							    $command10->insert('users', array(
								  'username'=>$username_up,
								  'password'=>$password,
								  'full_name'=>$full_name_up,
								  'active'=>1,
								  'person_id'=>$model->id,
								  'profil'=>$profil_id,
								  'group_id'=>$group_id,
								  'is_parent'=>0,
								  'create_by'=>$create_by,
								  'date_created'=>date('Y-m-d'),
								  'date_updated'=>date('Y-m-d'),
										));
								
                             }
                             
					             $pers=$model->id;
							$model->unSetAttributes();
							$this->useRoomAffectation_room=false;
							$this->useRoomAffectation_level=false;
					
					         $modelStudentOtherInfo = StudentOtherInfo::model()->findByAttributes(array('student'=>$pers));
					         
					         $apply_level = $modelStudentOtherInfo->apply_for_level;
					         
					  		//data pou Student_other_info
							 $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
							     
									   
							      $modelStudentOtherInfo->setAttribute('date_updated',date('Y-m-d'));
								  $modelStudentOtherInfo->save();
					   					  				
									  
								 						      
						            
									
									$this->redirect(array('viewDetailAdmission','id'=>$pers,'al'=>$apply_level,'from'=>'ad'));

						   } 
						   
					 }
				   else	   
					 Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Student may have at least').' 1 '.Yii::t('app','yr old'));   
						   
		
					   }
			     	
			     	
			     	
			     	
			     	
			     	}
			     	
			     	
			     	 
			          if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
				  
		      
			
			  
		}

		   		
		$this->render('admission',array(
			'model'=>$model,
		));
	
	
  }
	
	// Action pour enregistrer dans le view 
	public function actionUpdateMyInfo()
		{
			$es = new EditableSaver('Persons');
			$es->update();
		}
		
		
public function actionUpdate()  
	{   
		$model=new Persons;
		 $modelFee = new Fees;	
                $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoomPerson=new RoomHasPerson;
		
		 $modelDepartment=new DepartmentHasPerson;
		 $modelEmployeeInfo = new EmployeeInfo;
		 $modelStudentOtherInfo = new StudentOtherInfo;
		 $modelStudentOtherInfo__ = new StudentOtherInfo;
		 
		 $isNull=false;
		 $this->health_state=''; 
		 $this->father_full_name=''; 
		 $this->mother_full_name=''; 
		 $this->person_liable=''; 
		 $this->person_liable_phone='';
		 $this->school_date_entry='';
		 
		 $automatic_code = infoGeneralConfig('automatic_code');
 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

		 
		$levelAvan = 0;
		
		$fileName_old="";
		
		$username="";
		
		$username_up = '';
		
		
	 if($this->temoin_update==0)//pour l'affichage
	   { $model=$this->loadModel();
	   
	       if($model->is_student==1)//si c etudiant
	         {   $modelStudentOtherInfo=StudentOtherInfo::model()->find('student=:IdStudent',array(':IdStudent'=>$model->id ));
			      
			       if($modelStudentOtherInfo ==null)
			        {  $isNull=true;
			        
			             $modelStudentOtherInfo=new StudentOtherInfo;
			          }
	           }
	     
	     $modelLevel=LevelHasPerson::model()->find('students=:IdStudent AND academic_year=:acad',array(':IdStudent'=>$model->id,':acad'=>$acad_sess));
	     
	     if($modelLevel!=null)
	        $levelAvan = $modelLevel->level;
	      
		   $fileName_old = $model->image;
		   
		    $explode_lastname=explode(" ",substr($model->last_name,0 ));
            
             if(isset($explode_lastname[1]))
				              {  if(($explode_lastname[1]!=''))
				                       $username_up= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname[1]), pa_daksan() ).$model->id;
				              }
				            else
				              $username_up= strtr( strtolower( $explode_lastname[0]), pa_daksan() ).$model->id;
				                
           
		  
		   
		 }
        		
		$this->performAjaxValidation($model);
		
		
   
	 if(isset($_POST['Persons']))
		{      
			//on n'a pas presser le bouton, il faut load apropriate rooms
			        if($model->is_student==1)//si c etudiant
						{ $this->temoin_update+=1;//pour assurer l'execution de certaines lignes une seule fois
						  
						//if($this->kals_dat_panull == true) 
						// { 
					    if($model->active==2)
					     {
						  $modelShift->attributes=$_POST['Shifts']; 
			              $this->idShift=$modelShift->shift_name;
						   
                           $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   
						   $modelRoomPerson->attributes=$_POST['RoomHasPerson'];
						   $this->room_id=$modelRoomPerson->room;
						   
						   
						   $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
						   
						   $this->idPreviousLevel=$modelStudentOtherInfo->previous_level;
						   $this->previousSchool=$modelStudentOtherInfo->previous_school;
						   $this->school_date_entry=$modelStudentOtherInfo->school_date_entry;
						   
					     }
						   
						  // }
						   
		                 }   
		                 
		                 
		                 
						   $model->attributes = $_POST['Persons'];
						   
						   if($model->is_student==1)//si c etudiant
							  { 
							  	if($model->active==2)
							  	{ 
								  	if(isset($_POST['Shifts']))
								  	 { $modelShift->attributes=$_POST['Shifts']; 
							              $this->idShift=$modelShift->shift_name;
										   
				                           $modelSection->attributes=$_POST['Sections'];
										   $this->section_id=$modelSection->section_name;
										   
										   $modelLevel->attributes=$_POST['LevelHasPerson'];
										   $this->idLevel=$modelLevel->level;
										   
										   $modelRoomPerson->attributes=$_POST['RoomHasPerson'];
										   $this->room_id=$modelRoomPerson->room;
								  	   }
								  	 
								  	$modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo']; 
								  	
								  	$this->health_state=$modelStudentOtherInfo->health_state; 
									 $this->father_full_name=$modelStudentOtherInfo->father_full_name; 
									 $this->mother_full_name=$modelStudentOtherInfo->mother_full_name; 
									 $this->person_liable=$modelStudentOtherInfo->person_liable; 
									 $this->person_liable_phone=$modelStudentOtherInfo->person_liable_phone;
								 						  	
							  	   }
							  	   
							    }  
						  
			       
				if(isset($_POST['update']))
				    {//on vient de presser le bouton
				       
					   //les donnees pr person
					   $model->attributes=$_POST['Persons'];
					   
			$ageCalculate= false;
			$age_message="";

if($model->is_student==1)
  {  if($model->ageCalculator($model->birthday)>=1)
  	    $ageCalculate= true;
  	 
  	 $age_message= Yii::t('app','Student may have at least').' 1 ';
  	 
  }
elseif($model->is_student==0)
  {    if($model->ageCalculator($model->birthday)>=18)
  	       $ageCalculate= true; 
  	       
  	     $age_message= Yii::t('app','Employee may have at least').' 18 ';
  	
  	}
  	
if((($model->birthday!='')&&($ageCalculate==true ))||($model->birthday==''))
					  {		   					   
				         //$automatic_code = infoGeneralConfig('automatic_code');
						//code automatic
					     if($automatic_code ==1)
						   { 
					        if(($model->create_by =='siges_migration_tool')&&($model->id_number==''))
						     { 
					   
								$cf='';
					         $cl='';
							 
                               //first_name							
							$explode_firstname=explode(" ",substr($model->first_name,0));
            
				            if(isset($explode_firstname[1])&&($explode_firstname[1]!=''))
							 { 
						        $cf = strtoupper(  substr(strtr($explode_firstname[0],pa_daksan() ), 0,1).substr(strtr($explode_firstname[1],pa_daksan() ), 0,1)  );
							   
							 }
							else
							 {  $cf = strtoupper( substr(strtr($explode_firstname[0],pa_daksan() ), 0,2)  );
						    
							 }

							 //last_name							
							$explode_lastname=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname[1])&&($explode_lastname[1]!=''))
							 { 
						        $cl = strtoupper(  substr(strtr($explode_lastname[0],pa_daksan() ), 0,1).substr(strtr($explode_lastname[1],pa_daksan() ), 0,1) );
							   
							 }
							else
							 {  $cl = strtoupper( substr(strtr( $explode_lastname[0],pa_daksan() ), 0,2)  );
						    
							 }
							 
							  $code_ = $cf.$cl.$model->id;
							
							  								
								  $model->setAttribute('id_number',$code_);
								  
							   }
							 
						   }
					   
					   
					   //$model->setAttribute('is_student',1);  //on c dja que c 1 student
					   $model->setAttribute('date_updated',date('Y-m-d'));
					         
							      $fileName =$_FILES["image"]["name"];
								  $uploadedfile = $_FILES['image']['tmp_name'];
									//$fileName = "";
								if($fileName)  // check if uploaded file is set or not
								  {  //check if we have the same image
                                     if(($fileName!=$fileName_old)&&($fileName_old!=""))
									   { $file_to_delete = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$fileName_old;
                                         if(file_exists($file_to_delete))
                                              unlink($file_to_delete);
                                             	
                                        }										  
									  $filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension == "jpg") || ($extension == "jpeg") || ($extension == "png") || ($extension == "gif")) 
									  $model->image=$model->first_name.'_'.$model->last_name.'.'.$extension;
									else
						              $model->image="";
									}
								else
								  $model->image = $fileName_old;
					  
					   if(isset($_GET['pg']))
					     {  if(($_GET['pg']=='ext')&&($_GET['from']=='rpt'))
			                  {   // c yon reyaktivasyon
			                  	  $model->setAttribute('active',1);
			                  	}
					        }
					        
					        
			         if($model->save())
					    {   
					    	if($model->is_student==1)//si c etudiant
							 {
                                                    
        // Demarrer mise a jours champs personalisables 
        $criteria_cf = new CDbCriteria; 
        $criteria_cf->condition = "field_related_to = 'stud'";
        $cfData = CustomField::model()->findAll($criteria_cf);
        if(isset($_GET['id'])){$id_student = $_GET['id'];}
        foreach($cfData as $cd){
            if(isset($_POST[$cd->field_name])){
                $customFieldValue = $_POST[$cd->field_name];
                $modelCustomFieldData = CustomFieldData::model()->loadCustomFieldValue($id_student,$cd->id);
                if($modelCustomFieldData!=null){ // S'il y a deja des donnees on fait la mise a jour
                $modelCustomFieldData->setAttribute('field_link', $cd->id);
                $modelCustomFieldData->setAttribute('field_data', $customFieldValue);
                $modelCustomFieldData->setAttribute('object_id', $model->id);
                $modelCustomFieldData->save();
                $modelCustomFieldData->unsetAttributes();
                $modelCustomFieldData = new CustomFieldData;
                }else{ // S'il n'y a pas de donnees on ajoute
                $modelCustomFieldData = new CustomFieldData;
                $modelCustomFieldData->setAttribute('field_link', $cd->id);
                $modelCustomFieldData->setAttribute('field_data', $customFieldValue);
                $modelCustomFieldData->setAttribute('object_id', $model->id);
                $modelCustomFieldData->save();
                $modelCustomFieldData->unsetAttributes();
                $modelCustomFieldData = new CustomFieldData;
                }
            }
        }
        // Terminer mise a jour des champs personalisables                
                                                    
							 	
							     $modelStudentOtherInf=StudentOtherInfo::model()->findByAttributes(array('student'=>$model->id ));
	      
							       if($modelStudentOtherInf ==null)
							        {  $isNull=true;
							        
							             $modelStudentOtherInfo=new StudentOtherInfo;
							             $modelStudentOtherInfo->setAttribute('student',$model->id);
							          }
							 	    else
							 	     {
							 	     	
							 	     	$modelStudentOtherInfo= StudentOtherInfo::model()->findByPk($modelStudentOtherInf->id);
							 	     	}
							 	     	
							 	$modelStudentOtherInfo__->attributes=$_POST['StudentOtherInfo'];
							
									$modelStudentOtherInfo->setAttribute('health_state',$modelStudentOtherInfo__->health_state);
			                        $modelStudentOtherInfo->setAttribute('father_full_name',$modelStudentOtherInfo__->father_full_name);
			                        $modelStudentOtherInfo->setAttribute('mother_full_name',$modelStudentOtherInfo__->mother_full_name);
			                        $modelStudentOtherInfo->setAttribute('person_liable',$modelStudentOtherInfo__->person_liable);
			                        $modelStudentOtherInfo->setAttribute('person_liable_phone',$modelStudentOtherInfo__->person_liable_phone);	
			                        
			                        if($modelStudentOtherInfo__->previous_level == true) //if($this->kals_dat_panull == true) 
						              { 
						              	  $modelStudentOtherInfo->setAttribute('previous_level',$modelStudentOtherInfo__->previous_level);
			                              $modelStudentOtherInfo->setAttribute('previous_school',$modelStudentOtherInfo__->previous_school);
			                              $modelStudentOtherInfo->setAttribute('school_date_entry',$modelStudentOtherInfo__->school_date_entry);	

						                 }
			                        			                        
			                        
										 $modelStudentOtherInfo->save();
										   
								    	
								    	
							 }
					    	
						     if ($fileName)  // check if uploaded file is set or not
							  { 
							      
								  //check image extension
								    
									$filename = stripslashes($_FILES['image']['name']);
 	
									$extension = $this->getExtension($filename);
									$extension = strtolower($extension);
									
									if (($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
									 {
		
										$mesage=Yii::t('app','Unknown Image extension.');
										//$errors=1;
									 }
									else
									 {   //checking the size
									       $size=filesize($_FILES['image']['tmp_name']);


											if ($size > 400*1024)
											{
												$mesage=Yii::t('app','You have exceeded the size limit.');
												//$errors=1;
											}
											
											  if($extension=="jpg" || $extension=="jpeg" )
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefromjpeg($uploadedfile);

												}
												else if($extension=="png")
												{
												$uploadedfile = $_FILES['image']['tmp_name'];
												$src = imagecreatefrompng($uploadedfile);

												}
												else 
												{
												$src = imagecreatefromgif($uploadedfile);
												}
												
												
												list($width,$height)=getimagesize($uploadedfile);


												$newwidth=500;//140;//105;//60;
												$newheight=($height/$width)*$newwidth;
												$tmp=imagecreatetruecolor($newwidth,$newheight);


												$newwidth1=500;//34;//25;
												$newheight1=($height/$width)*$newwidth1;
												$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

												imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

												imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


												//$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$_FILES['image']['name'];
												$filename = Yii::app()->basePath.'/../documents/photo-Uploads/1/'.$model->first_name.'_'.$model->last_name.'.'.$extension;

												



												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);
						          
						                 }
								} 
										 
										 
										 
 if(isset($_GET['pg']))
  {
	if((($_GET['pg']=='lr')||($_GET['pg']=='vrlr'))&&($_GET['from']=='stud'))
	  {									 
				  // update login account for this person
							
							
                            $explode_lastname_=explode(" ",substr($model->last_name,0));
            
				             if(isset($explode_lastname_[1]))
				              {  if(($explode_lastname[1]!=''))
				                       $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname_[1]), pa_daksan() ).$model->id;
				                 else
				                      $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$model->id;
				              }
				            else
				              $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$model->id;
				                               
                            
                            
                            
                            $full_name_up=ucwords($model->first_name.' '.$model->last_name);
                           
							
							$user=new User;
                            $user = User::model()->findByAttributes(array('person_id'=>$model->id,'is_parent'=>0));
                          
                         if($user!=null)// on fait 1 update
                           {
                            
                              $command2 = Yii::app()->db->createCommand();
	                          $command2->update('users', array(
												'username'=>$username_up,'full_name'=>$full_name_up,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name
											), 'id=:ID', array(':ID'=>$user->id));
                            }
                          else // enter 1 new record
                            {
                              if($model->is_student==1)//si c etudiant
                            	{ $group=Groups::model()->getGroupIdByName("Student");
							   	  $group=$group->getData();
							   	  if(isset($group)&&($group!=''))
							   	     {  foreach($group as $g)
							   	            {
							   	            	$group_id=$g->id;
							   	            	}
							   	     	
							   	     	}
							   	     	
							   	   $profil=Profil::model()->getProfilIdByName("Guest");
							   	  $profil=$profil->getData();
							   	  if(isset($profil)&&($profil!=''))
							   	     {  foreach($profil as $prof)
							   	            {
							   	            	$profil_id=$prof->id;
							   	            	}
							   	     	
							   	     	}
                            	   }
                            	 else
                            	    { $group=Groups::model()->getGroupIdByName("Default Group");
								   	  $group=$group->getData();
								   	  if(isset($group)&&($group!=''))
								   	     {  foreach($group as $g)
								   	            {
								   	            	$group_id=$g->id;
								   	            	}
								   	     	
								   	     	}
								   	     	
								   	   $profil=Profil::model()->getProfilIdByName("Guest");
								   	  $profil=$profil->getData();
								   	  if(isset($profil)&&($profil!=''))
								   	     {  foreach($profil as $prof)
								   	            {
								   	            	$profil_id=$prof->id;
								   	            	}
								   	     	
								   	     	}
	                            	   }
                              
                              $create_by = Yii::app()->user->name;
	                            $password = md5("password");
	                            
	                            $command10 = Yii::app()->db->createCommand();
							    $command10->insert('users', array(
								  'username'=>$username_up,
								  'password'=>$password,
								  'full_name'=>$full_name_up,
								  'active'=>1,
								  'person_id'=>$model->id,
								  'profil'=>$profil_id,
								  'group_id'=>$group_id,
								  'is_parent'=>0,
								  'create_by'=>$create_by,
								  'date_created'=>date('Y-m-d'),
								  'date_updated'=>date('Y-m-d'),
										));
								
                             }
                             
	  }
  elseif(($_GET['pg']=='ext')&&($_GET['from']=='rpt'))
     {    // c yon reyaktivasyon
     		
                            $explode_lastname_=explode(" ",substr($model->last_name,0));
            
				             if(isset($explode_lastname_[1]))
				              {  if(($explode_lastname[1]!=''))
				                       $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname_[1]), pa_daksan() ).$model->id;
				                 else
				                     $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$model->id;
				              }
				            else
				              $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$model->id;
				                        
                            
                            
                            
                            $full_name_up=ucwords($model->first_name.' '.$model->last_name);
                           
							
						
                              if($model->is_student==1)//si c etudiant
                            	{ $group=Groups::model()->getGroupIdByName("Student");
							   	  $group=$group->getData();
							   	  if(isset($group)&&($group!=''))
							   	     {  foreach($group as $g)
							   	            {
							   	            	$group_id=$g->id;
							   	            	}
							   	     	
							   	     	}
							   	     	
							   	   $profil=Profil::model()->getProfilIdByName("Guest");
							   	  $profil=$profil->getData();
							   	  if(isset($profil)&&($profil!=''))
							   	     {  foreach($profil as $prof)
							   	            {
							   	            	$profil_id=$prof->id;
							   	            	}
							   	     	
							   	     	}
                            	   }
                            	 else
                            	    { $group=Groups::model()->getGroupIdByName("Default Group");
								   	  $group=$group->getData();
								   	  if(isset($group)&&($group!=''))
								   	     {  foreach($group as $g)
								   	            {
								   	            	$group_id=$g->id;
								   	            	}
								   	     	
								   	     	}
								   	     	
								   	   $profil=Profil::model()->getProfilIdByName("Guest");
								   	  $profil=$profil->getData();
								   	  if(isset($profil)&&($profil!=''))
								   	     {  foreach($profil as $prof)
								   	            {
								   	            	$profil_id=$prof->id;
								   	            	}
								   	     	
								   	     	}
	                            	   }
                     
                     
                      	   $command0 = Yii::app()->db->createCommand();
	                       $command0->delete('users', 'person_id=:id', array(':id'=>$model->id));
	                       
	                               
                              $create_by = Yii::app()->user->name;
	                            $password = md5("password");
	                            
	                            $command10 = Yii::app()->db->createCommand();
							    $command10->insert('users', array(
								  'username'=>$username_up,
								  'password'=>$password,
								  'full_name'=>$full_name_up,
								  'active'=>1,
								  'person_id'=>$model->id,
								  'profil'=>$profil_id,
								  'group_id'=>$group_id,
								  'is_parent'=>0,
								  'create_by'=>$create_by,
								  'date_created'=>date('Y-m-d'),
								  'date_updated'=>date('Y-m-d'),
										));
								
     	
     	}
     	

}
elseif(isset($_GET['from']))
  {
  	 if(($_GET['from']=='emp') || ($_GET['from']=='teach'))
  	   {
  	   	     // update login account for this person
							
							
                            $explode_lastname_=explode(" ",substr($model->last_name,0));
            
				            if(isset($explode_lastname_[1]))
				              {  if(($explode_lastname[1]!=''))
				                       $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname_[1]), pa_daksan() ).$model->id;
				                 else
				                   $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$model->id;
				              }
				            else
				              $username_up= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$model->id;
				                            
           
                            
                            
                            
                            $full_name_up=ucwords($model->first_name.' '.$model->last_name);
                           
							
							$user=new User;
                            $user = User::model()->findByAttributes(array('person_id'=>$model->id,'is_parent'=>0));
                          
                         if($user!=null)// on fait 1 update
                           {
                            
                              $command2 = Yii::app()->db->createCommand();
	                          $command2->update('users', array(
												'username'=>$username_up,'full_name'=>$full_name_up,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name
											), 'id=:ID', array(':ID'=>$user->id));
                            }
                          else // enter 1 new record
                            {
                              if($model->is_student==1)//si c etudiant
                            	{ $group=Groups::model()->getGroupIdByName("Student");
							   	  $group=$group->getData();
							   	  if(isset($group)&&($group!=''))
							   	     {  foreach($group as $g)
							   	            {
							   	            	$group_id=$g->id;
							   	            	}
							   	     	
							   	     	}
							   	     	
							   	   $profil=Profil::model()->getProfilIdByName("Guest");
							   	  $profil=$profil->getData();
							   	  if(isset($profil)&&($profil!=''))
							   	     {  foreach($profil as $prof)
							   	            {
							   	            	$profil_id=$prof->id;
							   	            	}
							   	     	
							   	     	}
                            	   }
                            	 else
                            	    { $group=Groups::model()->getGroupIdByName("Default Group");
								   	  $group=$group->getData();
								   	  if(isset($group)&&($group!=''))
								   	     {  foreach($group as $g)
								   	            {
								   	            	$group_id=$g->id;
								   	            	}
								   	     	
								   	     	}
								   	     	
								   	   $profil=Profil::model()->getProfilIdByName("Guest");
								   	  $profil=$profil->getData();
								   	  if(isset($profil)&&($profil!=''))
								   	     {  foreach($profil as $prof)
								   	            {
								   	            	$profil_id=$prof->id;
								   	            	}
								   	     	
								   	     	}
	                            	   }
                              
                              $create_by = Yii::app()->user->name;
	                            $password = md5("password");
	                            
	                            $command10 = Yii::app()->db->createCommand();
							    $command10->insert('users', array(
								  'username'=>$username_up,
								  'password'=>$password,
								  'full_name'=>$full_name_up,
								  'active'=>1,
								  'person_id'=>$model->id,
								  'profil'=>$profil_id,
								  'group_id'=>$group_id,
								  'is_parent'=>0,
								  'create_by'=>$create_by,
								  'date_created'=>date('Y-m-d'),
								  'date_updated'=>date('Y-m-d'),
										));
								
                             }

  	   	 }
  	   	 
  	}
                             
					             $pers=$model->id;
					   			 $emp=false;	
					   			  				
									  
									if($model->is_student==1)//si c etudiant
									 { 
										    $modelLevel=LevelHasPerson::model()->find('students=:IdStudent AND academic_year=:acad',array(':IdStudent'=>$model->id,':acad'=>$acad_sess));
												
													//if($this->kals_dat_panull == true) 
						                            // { 
														if(isset($modelLevel)&&($modelLevel!=null))//on fait un update
														   {  $modLevel=LevelHasPerson::model()->findbyPk($modelLevel->id);	
														      $level=new LevelHasPerson;
														    if($model->active==2)
									                         {   
														      
															  $level->attributes=$_POST['LevelHasPerson'];  
														     
															  $modLevel->setAttribute('level',$level->level);
															  
									                         }
									                         
															 if($modLevel->save())
																 { 
																 	
																 	if($level->level != $levelAvan)
																 	 { 
																 	//delete tout Balance ak Billing pou Student sa
																       $modelBalance=Balance::model()->findByAttributes(array('student'=>$model->id));
							   											if($modelBalance!=null)
																		 	$modelBalance->delete();
																		 	
																	    $modelFee = Fees::model()->findByAttributes(array('level'=>$levelAvan, 'academic_period'=>$acad_sess));	
																	    
																	    if($modelFee!=null)
																	      {
																	      	foreach($modelFee as $fee)
																	      	  {
																	      	  	if(isset($fee->fee))
																	      	  	  { $modBillings = Billings::model()->findByAttributes(array('student'=>$model->id,'fee_period'=>$fee->fee,'academic_year'=>$acad_sess));
																	      	  	
																	      	  	   if($modBillings!=null)
																	      	  	      $modBillings->delete();
																	      	  	  }
																	      	  	   
																	      	  	}
																	      	  	
																	      	}
																 	 				
														//&&&&&&&&&&&&&&&&   calcul pour automatiser "balance a payer"
																		     $model_fees= new Fees;
																		     $data_fees_datelimit=Fees::model()->checkDateLimitPaymentByLevel(date('Y-m-d'),$this->idLevel, $acad_sess);
															
																		     if(isset($data_fees_datelimit)&&($data_fees_datelimit!=null))
																		       { 
																		       	 $data_fees_datelimit=$data_fees_datelimit->getData();
																		       	 foreach($data_fees_datelimit as $date_limit)
																		       	   {  
																			       	
																			       	
																			       	 $fee_period_id=$date_limit->id;
																			         
																			         $amount1=$date_limit->amount;
																			         $amount=$date_limit->amount;
																			          
																			          $pass=false;
																			          
																			        					         
																		               $modelBillings= new Billings; 
																				     	    
																				     	
																				     	  $percentage_pay = 0;
																				           	  //check if student is scholarship holder
																				           	  $model_scholarship = ScholarshipHolder::model()->findByAttributes(array('student'=>$pers, 'academic_year'=>$acad_sess));
																				           	  $konte =0; 
																				           	    $premye_fee = NULL;
																				           	  if($model_scholarship != null)
																				           	    { 
																				           	      foreach($model_scholarship as $scholarship)
																				           	    	{ $konte++;
																				           	    	  if($scholarship->fee == $fee_period_id)
																				           	    	    { 
																				           	    	    	$percentage_pay = $model_scholarship->percentage_pay;
																			           	                   $amount = $amount - (($amount * $percentage_pay)/100) ;
																				           	    	    }
																				           	    	    
																				           	    	    if($konte==1)
																				           	    	        $premye_fee = $scholarship->fee;
																				           	    	 }
																				           	    	 
																				           	    	if(($konte==1)&&($premye_fee==NULL))
																				           	    	  { 
																				           	    	    	$percentage_pay = $model_scholarship->percentage_pay;
																			           	                   $amount = $amount - (($amount * $percentage_pay)/100) ;
																				           	    	    }
																			           	              
																				           	    }
																				           	   else
																				           	     $amount = $amount1;
																				           	  
																				           	  
																				        //billings record for each stud
																				           	   unset($modelBillings); 
																				           	   $modelBillings= new Billings;
																				       
																				       if($percentage_pay==100)
																				         {  											      	    
															
																							    $modelBillings->setAttribute('student',$pers);
																								$modelBillings->setAttribute('fee_period',$fee_period_id);
																								$modelBillings->setAttribute('academic_year',$acad_sess);
																								$modelBillings->setAttribute('amount_to_pay',$amount1); 
																								$modelBillings->setAttribute('amount_pay',$amount1); 
																								$modelBillings->setAttribute('date_pay',date('Y-m-d'));
																								$modelBillings->setAttribute('comments', Yii::t('app','Full scholarship holder'));
																								$modelBillings->setAttribute('balance', 0);
																								$modelBillings->setAttribute('created_by', "SIGES");
																								$modelBillings->setAttribute('date_created', date('Y-m-d')); 
																																	       	
																				       	  }
																				       else
																				         { 	  
																				           	 	$modelBillings->setAttribute('student',$pers);
																								$modelBillings->setAttribute('fee_period',$fee_period_id);
																								$modelBillings->setAttribute('academic_year',$acad_sess);
																								$modelBillings->setAttribute('amount_to_pay',$amount); 
																								$modelBillings->setAttribute('amount_pay',0); 
																								$modelBillings->setAttribute('balance', $amount);
																								$modelBillings->setAttribute('created_by', "SIGES");
																								$modelBillings->setAttribute('date_created', date('Y-m-d')); 
																								
																				           }
													 
																		                if($modelBillings->save())
																		                   {           
																		                          
																				           	   //balance record for each stud
																				           	   $modelBalance= new Balance;
																				           	   
																				           	   $modelBalance=Balance::model()->findByAttributes(array('student'=>$pers));
																						     							           	  
																				           	  if(isset($modelBalance)&&($modelBalance!=null))
																				           	    {  //update this model
																				           	    	if($percentage_pay==100)
																				                       $balance1=$modelBalance->balance;
																				                    else
																				                       $balance1=$modelBalance->balance + $amount;
																				                       
																				           	    	 $modelBalance->setAttribute('balance',$balance1);
																				           	    	 
																				           	    	   if($modelBalance->save())
																				           	               $pass=true;
																				           	    }
																				           	  else
																				           	    { //create new model
																				           	          unset($modelBalance); 
																		                              $modelBalance= new Balance;
																		                              
																		                              if($percentage_pay==100)
																				                         $modelBalance->setAttribute('balance',0);
																				                      else
																				                         $modelBalance->setAttribute('balance',$amount); 
																				                          
																				           	      $modelBalance->setAttribute('student',$pers);
																				           	      $modelBalance->setAttribute('date_created',date('Y-m-d'));
																				           	      
																				           	      if($modelBalance->save())
																				           	            $pass=true;
																				           	     
																				           	    }
																				           	  
																		                    } 
																		                    
																		                   
																				   									     					           
																		           }//fen foreach($data_fees_datelimit as $date_limit)
																		           
																		        }//fen if(isset($data_fees_datelimit)&&($data_fees_datelimit!=null))
																		        
																		      }
																											 	
																 	
																 	//check room
																    $modelRoomPerson=RoomHasPerson::model()->find('students=:IdStudent AND academic_year=:acad',array(':IdStudent'=>$model->id,':acad'=>$acad_sess));
									   
																   //les donnees pr romm-has-person
																		
																		if(isset($modelRoomPerson)&&($modelRoomPerson!=null))//on fait un update
																		  {	$modRoomPerson=RoomHasPerson::model()->findbyPk($modelRoomPerson->id);	
														                   $room=new RoomHasPerson;
															                
															                if($model->active==2)
															                {
																                $room->attributes=$_POST['RoomHasPerson'];		
																				 											  
																				$modRoomPerson->setAttribute('date_updated',date('Y-m-d'));
	                                                                            $modRoomPerson->setAttribute('room',$room->room);																			                  }
																														
																																
																			if($modRoomPerson->save())
																			   { 
																				  $this->temoin_update=0;
																                  $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'1','from'=>'stud'));

																				  
																				}
                                                                              $this->temoin_update=0;																				
																		 }
																		 else//li pat ko nan room
																			{ //nouvel enregistrement
																			   $modelRoomPerson=new RoomHasPerson;
																			 
																			 if($model->active==2)
															                  { 
																			    $modelRoomPerson->attributes=$_POST['RoomHasPerson'];	
																				$modelRoomPerson->setAttribute('academic_year',$acad_sess);	
																				 $modelRoomPerson->setAttribute('students',$pers);												
																									
																																	
																				if($modelRoomPerson->save())
																				   { 
																					  $this->temoin_update=0;
																                  $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'1','from'=>'stud'));
																					  
																					}
																					
																			     }
																			     
																				$this->temoin_update=0;
																				$this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'1','from'=>'stud'));
																			  
																			}
																			
																			
																	}
																	
														  }
														else//pas de level dit aussi pas de salle
														     //on fait de nouveaux enregistrements
														  {  
														  	
														  	  $modelLevel=new LevelHasPerson;
														      
														   if($model->active==2)
															 {  
														       $modelLevel->attributes=$_POST['LevelHasPerson'];
															   
															     $modelLevel->setAttribute('academic_year',$acad_sess);
																  $modelLevel->setAttribute('students',$pers);
																  
																  if($modelLevel->save())
																	 {  
																	 				
											//&&&&&&&&&&&&&&&&   calcul pour automatiser "balance a payer"
															     $model_fees= new Fees;
															     $data_fees_datelimit=Fees::model()->checkDateLimitPaymentByLevel(date('Y-m-d'),$this->idLevel,$acad_sess );
												
															     if(isset($data_fees_datelimit)&&($data_fees_datelimit!=null))
															       { 
															       	 $data_fees_datelimit=$data_fees_datelimit->getData();
															       	 foreach($data_fees_datelimit as $date_limit)
															       	   {  
																       	
																       	
																       	 $fee_period_id=$date_limit->id;
																         
																         $amount1=$date_limit->amount;
																         $amount=$date_limit->amount;
																          
																          $pass=false;
																          
																        					         
															               $modelBillings= new Billings; 
																	     	    
																	     	
																	     	  $percentage_pay = 0;
																	           	  //check if student is scholarship holder
																	           	  $model_scholarship = ScholarshipHolder::model()->findByAttributes(array('student'=>$pers, 'academic_year'=>$acad_sess));
																	           	  $konte =0; 
																	           	    $premye_fee = NULL;
																	           	  if($model_scholarship != null)
																	           	    { 
																	           	      foreach($model_scholarship as $scholarship)
																	           	    	{ $konte++;
																	           	    	  if($scholarship->fee == $fee_period_id)
																	           	    	    { 
																	           	    	    	$percentage_pay = $model_scholarship->percentage_pay;
																           	                   $amount = $amount - (($amount * $percentage_pay)/100) ;
																	           	    	    }
																	           	    	    
																	           	    	    if($konte==1)
																	           	    	        $premye_fee = $scholarship->fee;
																	           	    	 }
																	           	    	 
																	           	    	if(($konte==1)&&($premye_fee==NULL))
																	           	    	  { 
																	           	    	    	$percentage_pay = $model_scholarship->percentage_pay;
																           	                   $amount = $amount - (($amount * $percentage_pay)/100) ;
																	           	    	    }
																           	              
																	           	    }
																	           	   else
																	           	     $amount = $amount1;
																	           	  
																	           	  
																	        //billings record for each stud
																	           	   unset($modelBillings); 
																	           	   $modelBillings= new Billings;
																	       
																	       if($percentage_pay==100)
																	         {  											      	    
												
																				    $modelBillings->setAttribute('student',$pers);
																					$modelBillings->setAttribute('fee_period',$fee_period_id);
																					$modelBillings->setAttribute('academic_year',$acad_sess);
																					$modelBillings->setAttribute('amount_to_pay',$amount1); 
																					$modelBillings->setAttribute('amount_pay',$amount1); 
																					$modelBillings->setAttribute('date_pay',date('Y-m-d'));
																					$modelBillings->setAttribute('comments', Yii::t('app','Full scholarship holder'));
																					$modelBillings->setAttribute('balance', 0);
																					$modelBillings->setAttribute('created_by', "SIGES");
																					$modelBillings->setAttribute('date_created', date('Y-m-d')); 
																														       	
																	       	  }
																	       else
																	         { 	  
																	           	 	$modelBillings->setAttribute('student',$pers);
																					$modelBillings->setAttribute('fee_period',$fee_period_id);
																					$modelBillings->setAttribute('academic_year',$acad_sess);
																					$modelBillings->setAttribute('amount_to_pay',$amount); 
																					$modelBillings->setAttribute('amount_pay',0); 
																					$modelBillings->setAttribute('balance', $amount);
																					$modelBillings->setAttribute('created_by', "SIGES");
																					$modelBillings->setAttribute('date_created', date('Y-m-d')); 
																					
																	           }
										 
															                if($modelBillings->save())
															                   {           
															                          
																	           	   //balance record for each stud
																	           	   $modelBalance= new Balance;
																	           	   
																	           	   $modelBalance=Balance::model()->findByAttributes(array('student'=>$pers));
																			     							           	  
																	           	  if(isset($modelBalance)&&($modelBalance!=null))
																	           	    {  //update this model
																	           	    	if($percentage_pay==100)
																	                       $balance1=$modelBalance->balance;
																	                    else
																	                       $balance1=$modelBalance->balance + $amount;
																	                       
																	           	    	 $modelBalance->setAttribute('balance',$balance1);
																	           	    	 
																	           	    	   if($modelBalance->save())
																	           	               $pass=true;
																	           	    }
																	           	  else
																	           	    { //create new model
																	           	          unset($modelBalance); 
															                              $modelBalance= new Balance;
															                              
															                              if($percentage_pay==100)
																	                         $modelBalance->setAttribute('balance',0);
																	                      else
																	                         $modelBalance->setAttribute('balance',$amount); 
																	                          
																	           	      $modelBalance->setAttribute('student',$pers);
																	           	      $modelBalance->setAttribute('date_created',date('Y-m-d'));
																	           	      
																	           	      if($modelBalance->save())
																	           	            $pass=true;
																	           	     
																	           	    }
																	           	  
															                    } 
															                    
															                   
																	   									     					           
															           }//fen foreach($data_fees_datelimit as $date_limit)
															           
															        }//fen if(isset($data_fees_datelimit)&&($data_fees_datelimit!=null))
															        
															     
																	 	
																	 	
																	 	//saving room
																	     $modelRoomPerson=new RoomHasPerson;
																			  $modelRoomPerson->attributes=$_POST['RoomHasPerson'];	
																				$modelRoomPerson->setAttribute('academic_year',$acad_sess);	
																				 $modelRoomPerson->setAttribute('students',$pers);												
																										
																																	
																				if($modelRoomPerson->save())
																				   { 
																					  $this->temoin_update=0;
																                     $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'1','from'=>'stud'));
																					  
																					}
                                                                              $this->temoin_update=0;
																	 }
																	 
														       }
														       
														    $this->temoin_update=0;
															$this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'1','from'=>'stud'));
   
														       
														  }
									            
									            
									         /*    }
									           else
									             {
									             	$this->temoin_update=0;
											  $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'1','from'=>'stud'));

									             	}
											*/
									  }
									else
									  {
									            									      
									      if(isset($_POST['Persons']['Title'])) //c pa etudiant, on va update person-has-title. o mw 1 titre a ete attribue
										       {       
												  $personsHasTitles=new PersonsHasTitles;
												   //supprimer tous les titres de la personne ds la table 'persons_has_titles'
												   PersonsHasTitles::model()->deleteAll('persons_id=:IdPerson AND academic_year=:acad',array(':IdPerson'=>$model->id,':acad'=>$acad)); //tit la sou tout ane akademik lan
 
														
													 $data= $_POST['Persons']['Title'];
													foreach ($data as $title)
													 {  
															$personsHasTitles->setAttribute('persons_id',$model->id);
															$personsHasTitles->setAttribute('titles_id',$title);
															$personsHasTitles->setAttribute('academic_year',$acad);  //tit la sou tout ane akademik lan
															
															$personsHasTitles->save();
															
															 unset($personsHasTitles);
															 $personsHasTitles=new PersonsHasTitles;
															
															$emp=true;
													   }
										         }
										         		
													
													
											$modelDepartmentEmp=DepartmentHasPerson::model()->find('employee=:ID AND academic_year=:acad',array(':ID'=>$model->id,':acad'=>$acad)); //depatman sou tout ane akademik lan
												
														if(isset($modelDepartmentEmp))//on fait un update
														   {  $modelDepartment=DepartmentHasPerson::model()->findbyPk($modelDepartmentEmp->id);	
														      $departmentID=new DepartmentHasPerson;
															  $departmentID->attributes=$_POST['DepartmentHasPerson'];  
														     
															  $modelDepartment->setAttribute('date_updated',date('Y-m-d'));
															 		
															  $modelDepartment->save();
														   } 
														else /// save new record
														  { 
														  	  $modelDepartment=new DepartmentHasPerson;
															  $modelDepartment->attributes=$_POST['DepartmentHasPerson'];  
														      $modelDepartment->setAttribute('academic_year',$acad); //depatman sou tout ane akademik lan
															  $modelDepartment->setAttribute('employee',$model->id);
															  $modelDepartment->setAttribute('date_created',date('Y-m-d'));
															  $modelDepartment->setAttribute('date_updated',date('Y-m-d'));
															 		
															
														  	$modelDepartment->save();
														  	

														   }
														   
										     $employeeInfo=EmployeeInfo::model()->find('employee=:ID',array(':ID'=>$model->id));
												
											   if(isset($employeeInfo))//on fait un update
											     {
											     	if(isset($_POST['EmployeeInfo']))
											        { $employeeInfo->attributes=$_POST['EmployeeInfo'];
												     	$employeeInfo->setAttribute('update_by',Yii::app()->user->name);
												     	$employeeInfo->setAttribute('date_updated',date('Y-m-d'));
												     	$employeeInfo->save();
												     	
												     	$emp=true;
											        }
											     }
											   else
											     {
											     //create more info for this employee
											        $modelEmployeeInfo= new EmployeeInfo;
											      
											       if(isset($_POST['EmployeeInfo']))
											        { 
											        	$emp=true;
											         $modelEmployeeInfo->attributes=$_POST['EmployeeInfo'];
											         $job=$modelEmployeeInfo->job_status;
													 
												    $command11 = Yii::app()->db->createCommand();
												      if($job!='')
												      {
													      $command11->insert('employee_info', array(
														  'employee'=>$model->id,
														  'hire_date'=>$modelEmployeeInfo->hire_date,
														  'job_status'=>$modelEmployeeInfo->job_status,
														  'create_by'=>Yii::app()->user->name,
														  'date_created'=>date('Y-m-d'),
														  'date_updated'=>date('Y-m-d'),
																)); 
												      }
												      else
												      {
												      	    $command11->insert('employee_info', array(
														  'employee'=>$model->id,
														  'hire_date'=>$modelEmployeeInfo->hire_date,
														  
														  'create_by'=>Yii::app()->user->name,
														  'date_created'=>date('Y-m-d'),
														  'date_updated'=>date('Y-m-d'),
																));
												      	
												      	}
															
											        }
											        
														
											     }  
											     
											     										       
						 
									  }
						      
						            $this->temoin_update=0;
						         if(!$emp)
									{  $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'0','from'=>$_GET['from']));
									 }
								  else
									$this->redirect(array('viewForReport','id'=>$model->id,'from'=>'emp'));
									
                             
						} 
		
		           
		          }
			   else
				  Yii::app()->user->setFlash(Yii::t('app','Error'), $age_message.Yii::t('app',' yr old'));
		
		
		
		
		
		
		
		
		
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

	
	
		

	public function actionDisableStudents()
	 {  
		$model=new Persons;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		
		
		$this->performAjaxValidation($model);

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
	
		if(isset($_POST['Shifts']))
               	{  
				
				//on n'a pas presser le bouton, il fo load apropriate rooms
					      $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
	                      Yii::app()->session['Shifts'] = $this->idShift;
                      
				     

								  
						   $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   Yii::app()->session['Sections'] = $this->section_id;
					     						
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   Yii::app()->session['LevelHasPerson'] = $this->idLevel;
						   
						   
						if(isset($_POST['Rooms']))
	                      {   $modelRoom->attributes=$_POST['Rooms'];
							   $this->room_id=$modelRoom->room_name;
							 
							  
	                      }
	                    else
	                      {
	                      	   if(isset($_GET['roo']))
	                      	      $this->room_id=$_GET['roo'];
	                      	
	                      	}

					
                       
						   
	             }				   
				else //$_POST['Shifts'] not set
				  {
				   				   $this->idShift=null;
                                   $this->section_id=null;
				   $this->idLevel=null;
				   $this->room_id=null;
				   
				                   $this->noStud = 0; 
				     }
		
		if(isset($_POST['create']))
		   { //on vient de presser le bouton create
				$stud_name=''; 
				$billing_issue =false;	 				 	
		         //reccuperer la ligne selectionnee()
	            if(isset($_POST['chk'])) {
						   	     						
				 foreach($_POST['chk'] as $stud_id) {
						
				    $model=Persons::model()->findByPk($stud_id);
					 $profil=""; 
						      
							  
					$username= Persons::model()->getUsername($stud_id);
					
			  if($username!='')
				{	 //update "active" to 0 and reset password to "password" in Users table
					 $user=new User;
			            
			             $user = User::model()->findByAttributes(array('username'=>$username));
				       
			
			        if(isset($user->profil)&&($user->profil=!''))
					  {  
			                              
			                $profil_person= Profil::model()->findByPk($user->profil);
			             
			             $profil=$profil_person->profil_name;
			             
					  
				           $password=md5("password");
				           
				            //desactive user a ansanm ak contact li
				            $command0 = Yii::app()->db->createCommand();
				             $command0->update('users', array(
															'password'=>$password,'date_updated'=>date('Y-m-d'),'active'=>0,'update_by'=>Yii::app()->user->name
														), 'person_id=:ID', array(':ID'=>$stud_id));
				         }     
				 }      	                            
				 //record data in Person_history table
				 
				    $command = Yii::app()->db->createCommand();
				      	
			      				      				      	
			      	$entry_date="";
			      	$leaving_date="";
			      	$modelStudInfo=StudentOtherInfo::model()->findByAttributes(array('student'=>$stud_id));//$entry_date, $leaving_date
			      	if(isset($modelStudInfo)&&($modelStudInfo!=null))
			      	    {  $entry_date= $modelStudInfo->school_date_entry;
			      	      if($modelStudInfo->leaving_date!='')
			      	             $leaving_date=$modelStudInfo->leaving_date;
			      	        else
			      	          $leaving_date=date('Y-m-d');
			      	     }
			      	$level_name=Persons::model()->getLevel($stud_id,$acad_sess);
			      	
			      	$command->insert('person_history', array(
								  'person_id'=>$stud_id,
								  'entry_hire_date'=>$entry_date,
								  'disable_date'=>date('Y-m-d'),
								  'leaving_date'=>$leaving_date,
								  'profil'=>$profil,
								  'last_level_name'=>$level_name,
								  'academic_year'=>Yii::app()->session['currentName_academic_year'],
								  'created_by'=>Yii::app()->user->name,
										));
										
					 
			       
		           //update "active" in Persons table 
		             $command11 = Yii::app()->db->createCommand();
		             $command11->update('persons', array( 'active'=>0), 'id=:ID', array(':ID'=>$stud_id));
		                              
		            
					//gade si elev la gen det nan lekol la
			      	$modelBalance=Balance::model()->findByAttributes(array('student'=>$stud_id ));
					if($modelBalance!=null)
					 {	
					 	$billing_issue =true;
					 	
					 	if($stud_name=='')
						  $stud_name = $model->first_name.' '.$model->last_name;
						else
						   $stud_name = $stud_name.', '.$model->first_name.' '.$model->last_name;
					 }
					 
					
		
							$this->success=true;				   
					            
			    	    
						    
						    
								
                    }// end of chak elev		
					       												   
                    
				}      
              else                                
                 $this->message=true;
					
					//si elev gen det nan lekol la		 
					if($billing_issue)
					 {
					 	Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','{name} has/have billing issue to fix.',array('{name}'=>$stud_name) )); 

					 	}	 
						
			          
		     } 
			elseif(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
		
		
		$this->render('disableStudents',array(
			'model'=>$model,
		));
		
	}	
	
	
		

 public function actionAdmissionSearch()
      {
          $model=new Persons;
          $this->data=0;
         		  	
		  if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		  
		 if(isset($_POST['search']))
		  {
		  	$this->data=1;
		  	$model->attributes=$_POST['Persons'];
	
	
	             $this->f_name = $model->first_name;
	             $this->l_name = $model->last_name;	
	        
		  	
		  	}
		  		
			
			$this->render('admissionSearch',array(
			'model'=>$model,
		)); 
      
      
   }


   
  public function actionTranscriptNotesSearch()
      {
          $model=new Persons;
          $this->data=0;
         		  	
		  if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		  
		 if(isset($_POST['search']))
		  {
		  	$this->data=1;
		  	$model->attributes=$_POST['Persons'];
	
	
	             $this->f_name = $model->first_name;
	             $this->l_name = $model->last_name;	
	        
		  	
		  	}
	     else 
		   {
			    if(isset($_GET['pn'])&&($_GET['pn']!=''))
				 $this->f_name=$_GET['pn'];
				 
			  if(isset($_GET['n'])&&($_GET['n']!=''))
				 $this->l_name=$_GET['n'];
		   }
		  		
			
			$this->render('transcriptNotesSearch',array(
			'model'=>$model,
		)); 
      
      
   }

   public function actionTranscriptNotes()
	 {
		
		$model=new Persons;
		
		$level= 0;
		$i=0;
		
		//$this->status_ = 1;
		
		
		if(isset($_POST['Persons']['transcriptItems']))
		  { $this->transcriptItems = $_POST['Persons']['transcriptItems'];
		       
		   }
		
		if(isset($_POST['Persons']['transcriptAcadList']))
		  { $this->transcriptAcadItems = $_POST['Persons']['transcriptAcadList'];
		       
		   }
		else
			{
				$modelPersonRoom= new RoomHasPerson();
				  $PersonRoom=$modelPersonRoom->findAll(array('alias'=>'rhp',
											 'distinct'=>true,
											 'join'=>'inner join academicperiods a on(a.id=rhp.academic_year)',
											 'order'=>'a.date_start DESC',
											 'select'=>'rhp.academic_year,a.name_period',
											 
									   ));
					if(isset($PersonRoom)&&($PersonRoom!=''))
					 {  $i= 0;
						foreach($PersonRoom as $pr)
						 {			   
							if($this->transcriptAcadItems =='')  
							{    
								   $this->transcriptAcadItems = $pr->academic_year;
								   break;
							   
							 }
						  
						 }
						
					  }
					 else
						  $this->transcriptAcadItems = 0;
			}
		
		
		   if(isset($_POST['Persons']['student']))
		  { $this->student_id = $_POST['Persons']['student'];
		       
		   } 		      	                  	
						
	
	                   
     

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		 
		 
		if(isset($_POST['Persons']))
		 {
		 	//Extract school name 
									$school_name = infoGeneralConfig('school_name');
								//Extract school address
									  $school_address = infoGeneralConfig('school_address');
								 //Extract  email address 
									   $school_email_address = infoGeneralConfig('school_email_address');
								//Extract Phone Number
									   $school_phone_number = infoGeneralConfig('school_phone_number');
								//Extract school Director
                                         $school_director_name = infoGeneralConfig('school_director_name');
                                 $transcript_signature = $school_director_name;
							    //Extract transcript_note_text
						          $transcript_note_text = infoGeneralConfig('transcript_note_text');
								 //Extract transcript_footer_text
						          $transcript_footer_text = infoGeneralConfig('transcript_footer_text');
						          
						        $administration_signature_text = infoGeneralConfig('administration_signature_text');;
						          
						          
						  
                              //get level for this student
								$modelLevel = null;;
								$level_name='';
								$section_name='';
								$student_name='';
								$acad_name = '';
								
								if(($this->student_id!=''))
								  {	  $level_name=Persons::model()->getLevel($this->student_id,$this->transcriptAcadItems);
							          $section_name=Persons::model()->getSections($this->student_id,$this->transcriptAcadItems);
									  
									  $student_ = Persons::model()->getFlashInfoById($this->student_id);
									  
									  foreach($student_ as $stud)
									   { $student_name = $stud['first_name'].' '.strtoupper($stud['last_name']);
									   }
							  
							        $acad_ =AcademicPeriods::model()->getAcademicPeriodNameById($this->transcriptAcadItems);
									  
											$acad_name = $acad_->name_period;
							             
								  }
										
			 $transcript_note = Yii::t('app',$transcript_note_text,array('{name}'=>$school_name, '{name1}'=>$student_name, '{name2}'=>$level_name, '{name3}'=>$section_name, '{name4}'=>$acad_name));
			 
								
								
			$model->attributes=$_POST['Persons'];
		if($i==0)
		  {	$i++;
			$model->setAttribute('transcript_note_text',$transcript_note);
			$model->setAttribute('transcript_signature',$transcript_signature);
			$model->setAttribute('administration_signature_text',$administration_signature_text);
		  }
			
			
			 
		   if(isset($_POST['create']))
              {
				  $model->attributes=$_POST['Persons'];
				  
				  $pastp = null; //pou denye evalyasyon nan chak peryod pase
				 	 
					 //getting past evaluation period
						  if(isset($_POST['Evaluations']['evaluation_name'])&&($_POST['Evaluations']['evaluation_name']!=null)) 
						     {	
					 			$pastp = $_POST['Evaluations']['evaluation_name'];
								
								if($model->header_text_date!='') 
								 {
									
											
									// create new PDF document
								$pdf = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app',"Report Card"));
								$pdf->SetSubject(Yii::t('app',"Report Card"));
							
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
								
								$dataProvider=$this->loadSubject(getRoomByStudentId($this->student_id,$this->transcriptAcadItems)->id,getLevelByStudentId($this->student_id,$this->transcriptAcadItems)->id,$this->transcriptAcadItems);              
								 
								$student=0;
								if(($this->student_id!=''))
									$student=$this->student_id;
								$shiftName= getShiftByStudentId($student,$this->transcriptAcadItems)->shift_name;
									$sectionName= getSectionByStudentId($student,$this->transcriptAcadItems)->section_name;
									$levelName= getLevelByStudentId($student,$this->transcriptAcadItems)->level_name;
									$roomName= getRoomByStudentId($student,$this->transcriptAcadItems)->room_name;
								
								//Extract  email address 
									   $transcript_footer_text = infoGeneralConfig('transcript_footer_text');
									 
							 $header_text_date = $model->header_text_date;
							 $transcript_note_text = $_POST['Persons']['transcript_note_text'];
							 $transcript_signature_n_title = $_POST['Persons']['transcript_signature'].'<br/>'.$_POST['Persons']['administration_signature_text'];
                                  //if($reportcard_structure==1) //One evaluation by Period
								//	  {
										  $pdf->writeHTML($this->htmlReportcard1($dataProvider,$student,$pastp,$this->transcriptAcadItems,$header_text_date, $transcript_note_text,$transcript_footer_text,$transcript_signature_n_title), true, false, true, false, '');
									      $pdf->Output(Yii::t("app","Transcript of notes ").'.pdf', 'D');                                	
									///   }
///elseif($reportcard_structure==2)  //Many evaluations in ONE Period
				//					   {
									    //   $pdf->writeHTML($this->htmlReportcard2($dataProvider,$student,$pastp,$this->transcriptAcadItems,$evaluationPeriod,$period_exam_name,$tot,$eval_date, $last_eval_, $past_period), true, false, true, false, '');
									                                        	
									    // }    
                                      
                                      
									   
						    


							

								 }
							   else
								   {
									  Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Add the date.') );									  
											
								   }	

							}
                           else
							   {
								  Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Choose at least a period.') );									  
								        
							   }							   
                               	
						   
                  
                          	
				
              }
              
               if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          } 
                          
		}
		
	  else
	    {
	    	  //Extract school name 
									$school_name = infoGeneralConfig('school_name');
								//Extract school address
									  $school_address = infoGeneralConfig('school_address');
								 //Extract  email address 
									   $school_email_address = infoGeneralConfig('school_email_address');
								//Extract Phone Number
									   $school_phone_number = infoGeneralConfig('school_phone_number');
								//Extract school Director
                                         $school_director_name = infoGeneralConfig('school_director_name');
                                       $transcript_signature = $school_director_name;
							    //Extract transcript_note_text
						          $transcript_note_text = infoGeneralConfig('transcript_note_text');
								 //Extract transcript_footer_text
						          $transcript_footer_text = infoGeneralConfig('transcript_footer_text');
						  
                              //get level for this student
								$modelLevel = null;;
								$level_name='';
								$section_name='';
								$student_name='';
								$acad_name = '';
								
								if(isset($_GET['id'])&&($_GET['id']!=''))
								  {	  $level_name=Persons::model()->getLevel($_GET['id'],$this->transcriptAcadItems);
							          $section_name=Persons::model()->getSections($_GET['id'],$this->transcriptAcadItems);
									  
									  $student_ = Persons::model()->getFlashInfoById($_GET['id']);
									  
									  foreach($student_ as $stud)
									   { $student_name = $stud['first_name'].' '.strtoupper($stud['last_name']);
									   }
							  
							  
							          $acad_ =AcademicPeriods::model()->getAcademicPeriodNameById($this->transcriptAcadItems);
									  
											if($acad_!=null)
												$acad_name = $acad_->name_period;  
										  
									  
									     
								  }
								  	
								 //echo Yii::t('app',$transcript_note_text,array('{name}'=>$school_name, '{name1}'=>$student_name, '{name2}'=>$level_name, '{name3}'=>$section_name, '{name4}'=>$acad_name));
							      $transcript_note = Yii::t('app',$transcript_note_text,array('{name}'=>$school_name, '{name1}'=>$student_name, '{name2}'=>$level_name, '{name3}'=>$section_name, '{name4}'=>$acad_name));
							    $model->setAttribute('transcript_note_text',$transcript_note);
								 $model->setAttribute('transcript_footer_text',$transcript_footer_text);
								 $model->setAttribute('transcript_signature',$transcript_signature);

			 		
			 			 
				
				
	    	  	
	    	
	      } 

		$this->render('transcriptNotes',array(
			'model'=>$model,
		));
	}

		
//************************  loadTranscriptItems ******************************/
	public function loadTranscriptItems()
	{     $code= array();
		   
		   $code[0]= Yii::t('app','Transcript of notes');
		   //$code[1]= Yii::t('app','Certificate');
		    		   
		return $code;
         
	}

	
//************************  loadTranscriptAcadList() ******************************/
	public function loadTranscriptAcadList()
	{     $code= array();
		 
         //nan room_has_person, pran tout acad $stud_id ladan
         //select academic_year from room_has_person where students=$stud_id
         $modelPersonRoom= new RoomHasPerson();
	      $PersonRoom=$modelPersonRoom->findAll(array('alias'=>'rhp',
		                             'distinct'=>true,
									 'join'=>'inner join academicperiods a on(a.id=rhp.academic_year)',
									 'order'=>'a.date_start DESC',
									 'select'=>'rhp.academic_year,a.name_period',
                                     
                               ));
			if(isset($PersonRoom))
			 {  $i= 0;
			    foreach($PersonRoom as $pr)
				 {			   
					if($this->transcriptAcadItems =='')  
					{  if($i==0)
					   {  $i=1;
						   $this->transcriptAcadItems = $pr->academic_year;
					   }
					 }
				   $code[$pr->academic_year]= $pr->name_period;
				   
				 }
		    	
			 }
			 
		return $code;
         
	}
	

	 
//************************  loadAllStudentsInAcadItems($acadItems) ******************************/
	public function loadAllStudentsInAcadItems($acadItems)
	{     
         $code= array();
		 $code[null]=  Yii::t('app','-- Select --'); 
		 
		 $modelPersonRoom= new RoomHasPerson();
	      $PersonRoom=$modelPersonRoom->findAll(array('alias'=>'rhp',
		                             'join'=>'inner join persons p on(p.id=rhp.students)',
									 'order'=>'p.last_name ASC',
									 'select'=>'p.id, concat(p.first_name," ",p.last_name," (",p.id_number,")") as full_name, rhp.students',
									 'condition'=>'rhp.academic_year='.$acadItems,
                                     
                               ));
			if(isset($PersonRoom))
			 { 
		
  		         foreach($PersonRoom as $pr)
				 {		
				    $code[$pr->id]= $pr->full_name;
				   
				 }
		    	
			 }
			 
		return $code;
         
	}
	
	
public function loadInactiveTitle()
 {
        $code= array();
		   
		  $code[1]= Yii::t('app','All'); 
		  $code[2]= Yii::t('app','Inactive Students');
		  $code[3]= Yii::t('app','Inactive Teachers');
		  $code[4]= Yii::t('app','Inactive Employees');
		           
		    
		return $code;
      
   }


	/**
         * List of inactive people in the database 
         */
public function actionListArchive()
 {
      
		
		$model=new Persons;
        		 
         if(isset(Yii::app()->session['list_id']) &&(Yii::app()->session['list_id']!=''))
           $this->list_id = Yii::app()->session['list_id'];
         else 
           $this->list_id=1;
           
         Yii::app()->session['list_id'] = $this->list_id;
				
		
 		 					  
	         if(isset($_POST['Persons']))
               	{  //
					      $this->list_id=$_POST['Persons']['list_id'];
			              unset(Yii::app()->session['list_id']);
	                      Yii::app()->session['list_id'] = $this->list_id;
												
	                 } 
                   else
                     {
                         $this->list_id=Yii::app()->session['list_id'];
							
					 }				   
	
	
			if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			
	 
	    
	  if($this->list_id == 1)  //Inactive people
		{	
				$model=new Persons('searchInactivePerson');
	            $model->unsetAttributes();
			if(isset($_GET['Persons']))
				$model->attributes=$_GET['Persons'];
				
	
				         
			 // Here to export to CSV 
			if($this->isExportRequest()){
				$this->exportCSV(array(Yii::t('app','Inactive people')), null,false);
				
				  
				  $this->exportCSV($model->searchInactivePerson() , array(
						'last_name',
						'first_name',
						'genders1',
	                   	'id_number')); 
	              }
		
		   }
		 elseif($this->list_id == 2) //Inactive Students
		   {
		   	    $model=new Persons('searchExStudents_');
	            $model->unsetAttributes();
			if(isset($_GET['Persons']))
				$model->attributes=$_GET['Persons'];
				
	
				         
			 // Here to export to CSV 
			if($this->isExportRequest()){
				$this->exportCSV(array(Yii::t('app','Inactive Students')), null,false);
				
				  
				  $this->exportCSV($model->searchExStudents_() , array(
						'last_name',
						'first_name',
						'genders1',
	                   	'id_number')); 
	              }
		   	
		     }
		   elseif($this->list_id == 3) //Inactive Teachers
		    {
		    	$model=new Persons('searchExTeachers');
	            $model->unsetAttributes();
			if(isset($_GET['Persons']))
				$model->attributes=$_GET['Persons'];
				
	
				         
			 // Here to export to CSV 
			if($this->isExportRequest()){
				$this->exportCSV(array(Yii::t('app','Inactive Teachers')), null,false);
				
				  
				  $this->exportCSV($model->searchExTeachers() , array(
						'last_name',
						'first_name',
						'genders1',
	                   	'id_number')); 
	              }
		      }
		    elseif($this->list_id == 4) //Inactive Employees
		      {
		      	    $model=new Persons('searchExEmployee');
	            $model->unsetAttributes();
			if(isset($_GET['Persons']))
				$model->attributes=$_GET['Persons'];
				
	
				         
			 // Here to export to CSV 
			if($this->isExportRequest()){
				$this->exportCSV(array(Yii::t('app','Inactive Employees')), null,false);
				
				  
				  $this->exportCSV($model->searchExEmployee() , array(
						'last_name',
						'first_name',
						'genders1',
	                   	'id_number')); 
	              }
		        }
		    	
    	

			
			   $this->render('listArchive',array(
			  'model'=>$model,
		  ));
		

 }

	
	
 public function actionExStudents()
      {
      
		  if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new Persons('searchExStudents_');
            $model->unsetAttributes();
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
			
			$this->render('exStudents',array(
			'model'=>$model,
		)); 
       }

	
public function actionExEmployees()
       {
      
		  if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new Persons('searchExEmployees');
            $model->unsetAttributes();
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
			
			$this->render('exEmployees',array(
			'model'=>$model,
		)); 
      }


	
	
	
	public function actionDelete()
	{
		
		
		try {
   			 $person=new Persons;
			
			$person=$this->loadModel();
            
             $explode_lastname_=explode(" ",substr($person->last_name,0));
            
				            if(isset($explode_lastname_[1])&&($explode_lastname_[1]!=''))
				              $username= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).'_'.strtr( strtolower( $explode_lastname_[1]), pa_daksan() ).$person->id;
				            else
				              $username= strtr( strtolower( $explode_lastname_[0]), pa_daksan() ).$person->id;
				                            
            // Supprimer les donnees des champs personalisables lors de la suppression d'une personne 
           $customFieldData = CustomFieldData::model()->loadCustomFieldDataByPersonId($person->id); 
           $customFieldData->delete();            
            $this->loadModel()->delete();
            
             // delete login account for this person
				$user=new User;
                $user = User::model()->findByAttributes(array('username'=>$username));

                 $user->delete();
                 
            
                 
            
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


    public function actionDeletedoc($id){
         $fileName='';
         $folderName='';
         $id_student='';
         
             $command0 = Yii::app()->db->createCommand();
	         $command0= Yii::app()->db->createCommand("SELECT file_name, id_student FROM student_documents WHERE id=".$id);
	         $sql_result = $command0->queryAll();
	         
	         if($sql_result!=null)
	           { foreach($sql_result as $r)
	               { $fileName=$r['file_name'];
	                  $id_student = $r['id_student'];
	               }
	               
	           }
       
       
             $command1 = Yii::app()->db->createCommand();
	         $command1->delete('student_documents', 'id=:id', array(':id'=>$id)); 
	         
	         if (isset($_GET['elif']))
	           $folderName = $_GET['elif'];
	           
	         $file_to_delete = Yii::app()->basePath.'/../documents/students_doc/'.$folderName.'/'.$fileName;
               if(file_exists($file_to_delete))
                  unlink($file_to_delete);
               
              
               if(count(glob(Yii::app()->basePath.'/../documents/students_doc/'.$folderName.'/*')) === 0 ) 
                  { // empty
                         
                            rmdir(Yii::app()->basePath.'/../documents/students_doc/'.$folderName);
                      }
            
            $this->redirect(array('/academic/persons/viewForReport/id/'.$id_student.'/pg/lr/pi/no/isstud/1/from/stud#doc'));
       
    }
    
    
    
	public function actionIndex()
	{   
	     
		  if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new Persons('search');
            $model->unsetAttributes();
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
			
			$this->render('listForReport',array(
			'model'=>$model,
		));
		
	}

	public function actionAdmin()
	{
		 
		 if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new Persons('search');
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}



	


	        
	             //xxxxxxxxxxxxxxx  LEVEL xxxxxxxxxxxxxxxxxxx
		//************************  loadLevelByIdShiftSectionId  ******************************/
	public function loadLevelByIdShiftSectionId($idShift,$section_id)
	{    
       	  
		  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('alias'=>'r',
	                                 'join'=>'left join levels l on(l.id=r.level)',
	                                 'select'=>'r.level',
                                     'condition'=>'r.shift=:shiftID AND l.section=:sectionID',
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
	
	
	
	//************************  loadPreviousLevel  ******************************/
	public function loadPreviousLevel($idLevel)
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
	

	//************************  loadApplyLevel  ******************************/
	public function loadApplyLevel($idLevel)
	{    
       	 
		  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	       $modelLevel= new Levels();

	      $pLevel_id=$modelLevel->findAll(array('select'=>'id',
                                     'condition'=>'previous_level=:levelID',
                                     'params'=>array(':levelID'=>$idLevel),
                               ));
			if(isset($pLevel_id))
			 {  
			    foreach($pLevel_id as $i){			   
					 					   
					  
					  
					  $level=$modelLevel->findAll(array('select'=>'id, level_name',
												 'condition'=>'id=:levelID OR id=:IDLevel',
												 'params'=>array(':levelID'=>$i->id,':IDLevel'=>$idLevel),
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
	
	//************************  loadLevelBySection ******************************/
	public function loadLevelBySection($idSection)
	{    
	    $modelLevel= new Levels();
		
		 
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll(array('alias'=>'l',
		  										 'select'=>'l.id, l.level_name',
												 'condition'=>'l.section=:sectionID',
												 'params'=>array(':sectionID'=>$idSection),
										   ) );
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
	
	//************************  getLevelByStudentId($id,$acad) ******************************/
	public function getLevelByStudentId($id, $acad)
	{
		
		 
		$idRoom= $this->getRoomByStudentId($id, $acad);
		
	  if(isset($idRoom)){	
		$modelRoom=new Rooms;
		$idLevel = $modelRoom->find(array('select'=>'level',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$level = new Levels;
        if(isset($idLevel)){
		   $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel->level),
                               ));
		       if(isset($result))
				    return $result;
			    else
				    return null;
				
		   }
		  else
		     return null;
				
		}
	  else
	      return null;
		
	}
	
	//************************  getLevelIdFromPersons ******************************/
	public function getLevelIdFromPersons()
	{    
       
	   $modelLevel=new Levels;
	   
	   
					
			 if(isset($_POST['Persons']))
		        $modelLevel->attributes=$_POST['Levels'];
		           
				   $level_id=$modelLevel->level_name;
	               
				   return $level_id;
	}
	
//xxxxxxxxxxxxxxx  ROOM xxxxxxxxxxxxxxxxxxx
	
	//************************  changeRoom ******************************/
	public function changeRoom()
	{    $modelLevel= new Levels();
	
	     
           $code= array();
		   
		  if(isset($_POST['Persons']['Levels']))
		        $idLevel->attributes=$_POST['Levels'];
		           
				   
         
	}
	
	
	
	
	//************************  loadRoomByIdTeacher($id_teacher) ******************************/
	public function loadRoomByIdTeacher($id_teacher)
	{    
	      
	      
	      $modelRoom= new Rooms();
		 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

		 
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('select'=>'r.id,r.room_name',
                                     'alias'=>'r',
                                     'join'=>'left join courses c on(c.room=r.id)',
                                     'condition'=>'c.academic_period IN(select ap.id from academicperiods ap where (ap.id='.$acad_sess.' OR ap.year='.$acad_sess.') ) AND c.teacher='.$id_teacher,
                                     
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
	{    
	      $modelRoom= new Rooms();
		  
		 
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
	

//movement
	//************************  loadRoom_To($room_id,$idLevel) ******************************/
	public function loadRoom_To($room_id,$idLevel)
	{    
	      $modelRoom= new Rooms();
		  
		 
           $code= array();
		 if(($room_id!=null)&&($room_id!=''))
		   {  
		      $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
		                             'join'=>'left join levels l on(l.id=r.level)',
		                             'select'=>'r.id,r.room_name',
                                     'condition'=>'r.level=:levelID AND r.id NOT IN(:room_) ',
                                     'params'=>array(':levelID'=>$idLevel,':room_'=>$room_id),
                               ));
	            $code[null]= Yii::t('app','-- Select --');
			    if(isset($modelPersonRoom))
				 {  
				    foreach($modelPersonRoom as $room){
				        $code[$room->id]= $room->room_name;
			           
			           }
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
   //************************  getRoom($id) ******************************/
   public function getRoom($id)
	{
		$room = new Rooms;
		
		
		 
		 
		$room=Rooms::model()->findByPk($id);
        
			
		
		    if(isset($room))
				return $room->room_name;
		
	}
	
	//************************  getRoomByStudentId($id,$acad) ******************************/
	public function getRoomByStudentId($id,$acad)
	{
		$modelRoomH=new RoomHasPerson;
		
		
		 
		$idRoom = $modelRoomH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id,':acad'=>$acad),
                               ));
		$room = new Rooms;
      if(isset($idRoom)){           
		   $result=$room->find(array('select'=>'id,room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
						   

				if(isset($result))			   
					return $result;
				else
				return null;	
				
		  }
		  else
		    return null;
		
	}
	
	//************************  getRoomIdFromPersons ******************************/
	public function getRoomIdFromPersons()
	{    
       
	   $modelRoom=new RoomHasPerson;
	   
	    
					
			 if(isset($_POST['Persons']))
		        $modelRoom->attributes=$_POST['RoomHasPerson'];
		           
				   $this->room_id=$modelRoom->room;
	               
				   return $this->room_id;
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
		 
		 //$shift = new Shifts;
		$shift=Shifts::model()->findByPk($id);
        
			
		      if(isset($shift))
				return $shift->shift_name;
		
	}
	
	//************************  getShiftByStudentId($id, $acad) ******************************/
	public function getShiftByStudentId($id, $acad)
	{
		 
		 
		$idRoom= $this->getRoomByStudentId($id, $acad);
	 if(isset($idRoom)){ 
		
		$modelRoom=new Rooms;
		$idShift = $modelRoom->find(array('select'=>'shift',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$shift = new Shifts;
         if(isset($idShift)){ 
				$result=$shift->find(array('select'=>'id,shift_name',
											 'condition'=>'id=:shiftID',
											 'params'=>array(':shiftID'=>$idShift->shift),
									   ));
				   if(isset($result))
						return $result;
					else
					   return null;
			}
			else
		       return null;	
		}
		else
		  return null;
		
	}
	
	//************************  getShiftIdFromPersons ******************************/
	public function getShiftIdFromPersons()
	{    
       
	   $modelShift=new Shifts;
	   
	  	 
					
			 if(isset($_POST['Persons']))
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
	
//************************  loadSectionByLevel ******************************/
	public function loadSectionByLevel($levelID)
	{    $modelSection= new Sections();
	
	    
		 
           $code= array();
		   
		  $modelPersonSection=$modelSection->findAll(array('alias'=>'s',
		  										 'select'=>'s.id, s.section_name',
												 'join'=>'left join levels l on(l.section=s.id) ',
												 'condition'=>'l.id=:levelID',
												 'params'=>array(':levelID'=>$levelID),
										   ) );
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
		 
		 //$section = new Sections;
		$section=Sections::model()->findByPk($id);
        
			
		       if(isset($section))
				return $section->section_name;
		
	}
	
	//************************  getSectionByStudentId($id, $acad) ******************************/
	public function getSectionByStudentId($id, $acad)
	{
		
		 
		$idRoom= $this->getRoomByStudentId($id, $acad);
		
	  if(isset($idRoom)){	
		$modelRoom=new Rooms;
		$idSection = $modelRoom->find(array('alias'=>'r',
		                             'join'=>'left join levels l on(l.id=r.level)',
		                             'select'=>'l.section',
                                     'condition'=>'r.id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$section = new Sections;
        if(isset($idSection)){
		     $result=$section->find(array('select'=>'id,section_name',
                                     'condition'=>'id=:sectionID',
                                     'params'=>array(':sectionID'=>$idSection->section),
                               ));
		      if(isset($result))
				 return $result;
			  else
			     return null;
				 
	  	 }
		else
		   return null;
				
				
		}
	else
      return null;	
		
	}
	
		
	
	//************************  getSectionIdFromPersons ******************************/
	public function getSectionIdFromPersons()
	{    
       
	   $modelSection=new Sections;
	   
	   
					
			 if(isset($_POST['Persons']))
		        $modelSection->attributes=$_POST['Sections'];
		           
				   $this->section_id=$modelSection->section_name;
	               
				   return $this->section_id;
	}
	
	

//************************  loadStudentByCriteria ******************************/
	public function loadStudentByCriteria($criteria)
	{    $code= array();
		   
		    $persons=Persons::model()->findAll($criteria);
            
			
		    if(isset($persons))
			 {  
			    foreach($persons as $stud){
			        $code[$stud->id]= $stud->fullName." (".$stud->id_number.")";
		           
		           }
			 }
		   
		return $code;
         
	}
	
	

//xxxxxxxxxxxxxxx  DEPARTMENT IN SCHOOL xxxxxxxxxxxxxxxxxxx
	
	//************************  loadDepartment ******************************/
	public function loadDepartment()
	{    $modelDepartment= new DepartmentInSchool;
	     
		
		 
           $code= array();
		   
		  $modelPersonDepartment=$modelDepartment->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonDepartment))
			 {  foreach($modelPersonDepartment as $department){
			        $code[$department->id]= $department->department_name;
		           
		           }
			 }
		   
		return $code;
         
	}
   //************************  getDepartment($id) ******************************/
   public function getDepartment($id)
	{
		$department = new DepartmentInSchool;
		
		
		 
		 
		$department=DepartmentInSchool::model()->findByPk($id);
        
			
		
		    if(isset($department))
				return $department->department_name;
		
	}
	
	//************************  getDepartmentByEmployeeId($id,$acad) ******************************/
	public function getDepartmentByEmployeeId($id,$acad)
	{
		$modelDepartmentH=new DepartmentHasPerson;
		
		
		 
		$idDepartment = $modelDepartmentH->find(array('select'=>'department_id',
                                     'condition'=>'employee=:empID AND academic_year=:acad',
                                     'params'=>array(':empID'=>$id,':acad'=>$acad),
                               ));
		$department = new DepartmentInSchool;
      if((isset($idDepartment))&&($idDepartment!=null)){           
		   $result=$department->find(array('select'=>'id,department_name',
                                     'condition'=>'id=:departmentID',
                                     'params'=>array(':departmentID'=>$idDepartment->department_id),
                               ));
			//foreach($room->room_name as $i)
						   

				if(isset($result))			   
					return $result;
				else
				return null;	
				
		  }
		  else
		    return null;
		
	}
	
	//************************  getDepartmentIdFromPersons ******************************/
	public function getDepartmentIdFromPersons()
	{    
       
	   $modelDepartment=new DepartmentHasPerson;
	   
	  	 
					
			 if(isset($_POST['Persons']))
		        $modelDepartment->attributes=$_POST['DepartmentHasPerson'];
		           
				   $this->department_id=$modelDepartment->department_id;
	               
				   return $this->department_id;
	}
		
	
	
//xxxxxxxxxxxxxxx  EMPLOYEE INFO  xxxxxxxxxxxxxxxxxxx
	
	
		//************************  loadJobStatus ******************************/
	public function loadJobStatus()
	{    $modelJobStatus= new JobStatus();
	
	    
		 
           $code= array();
		   
		  $modelPersonJobStatus=$modelJobStatus->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelPersonJobStatus))
			 {  foreach($modelPersonJobStatus as $job_status){
			        $code[$job_status->id]= $job_status->status_name;
		           
		           }
			 }
		   
		return $code;
         
	}
   //************************  getJobStatus($id) ******************************/
   public function getJobStatus($id)
	{
			 
		 $emp_info = new EmployeeInfo;
		 $id_job=$emp_info::model()->findByattributes(array('employee'=>$id));
		 
		if(isset($id_job))
		  $jobStatus=JobStatus::model()->findByPk($id_job->job_status);
        
			
		       if(isset($jobStatus))
				return $jobStatus->id;
		
	}
	
	
	 //************************  getHireDate($id) ******************************/
   public function getHireDate($id)
	{
		 
		 $emp_info = new EmployeeInfo;
		 $model=EmployeeInfo::model()->findByattributes(array('employee'=>$id));
		 
		
				return $model;
		
	}
	
	
	
	 //************************  getAcademicPeriodNameL($acad,$level_id) ******************************/	
	  public function getAcademicPeriodNameL($acad,$level_id)
	  {    
	        $result=ReportCard::getAcademicPeriodNameLevel($acad,$level_id);
                if($result!=null)
                    return $result;
                    else
                        return null;
	  }


		
	
	
	//************************  actionList ******************************/
	public function actionList()
	{    
       $model=new Persons;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoomPerson=new RoomHasPerson;
		
		 $this->idShift=null;
		$this->section_id=null;
		$this->idLevel=null;
		$this->room_id=null;
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


 $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     				/*   if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							     */
							         $condition = 'p.active IN(1,2) AND ';
						        //}
      

		 					  
if(Yii::app()->user->profil=='Teacher')		
{
	 if(isset($_POST['RoomHasPerson']))
               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
						  
						   $modelRoomPerson->attributes=$_POST['RoomHasPerson'];
						   $this->room_id=$modelRoomPerson->room;
						   unset(Yii::app()->session['RoomHasPerson']);
	                      Yii::app()->session['RoomHasPerson'] = $this->room_id;
						  
						
	                 } 
                   else
                     {
						$this->room_id=null;
					 }
	
 }//fen if(Yii::app()->user->profil=='Teacher')
else //Yii::app()->user->profil!='Teacher'
  {	         
  	         if(isset($_POST['Shifts']))
               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
					      $modelShift->attributes=$_POST['Shifts'];
			              $this->idShift=$modelShift->shift_name;
							 unset(Yii::app()->session['Shifts']);
	                      Yii::app()->session['Shifts'] = $this->idShift;
						  
						   $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
					     	 unset(Yii::app()->session['Sections']);
	                      Yii::app()->session['Sections'] = $this->section_id;
						  
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						    unset(Yii::app()->session['LevelHasPerson']);
	                      Yii::app()->session['LevelHasPerson'] = $this->idLevel;
						  
						   $modelRoomPerson->attributes=$_POST['RoomHasPerson'];
						   $this->room_id=$modelRoomPerson->room;
						   unset(Yii::app()->session['RoomHasPerson']);
	                      Yii::app()->session['RoomHasPerson'] = $this->room_id;
						    
						  
						
	                 } 
                   else
                     {
                         $this->idShift=null;
							$this->section_id=null;
							$this->idLevel=null;
							$this->room_id=null;
					 }				   
			
	   
   }//fen Yii::app()->user->profil!='Teacher'
	     
			
			if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			     
			        $sh=null;
					$se=null;
	                $le=null;
	                $ro=null;
if(Yii::app()->user->profil!='Teacher')		
{					
					 $this->idShift=Yii::app()->session['Shifts'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['Sections'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	                $this->idLevel=Yii::app()->session['LevelHasPerson'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
}				  
	                $this->room_id=Yii::app()->session['RoomHasPerson'];
					if($this->room_id!=null)
					  $ro=$this->room_id;
					  
	                      
			$model=new Persons('searchStudents($condition,$sh,$se,$le,$ro,$acad_sess)');
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
         
		 // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List Students by Room: ')), null,false);
			
			  
			  $this->exportCSV($model->searchStudents($condition,$sh,$se,$le,$ro,$acad_sess) , array(
					'last_name',
					'first_name',
					'genders1',
                  	'id_number')); 
                  	
			    
			 
		}
		
		

			
			   $this->render('list',array(
			  'model'=>$model,
		  ));
		
	}
	
	
//************************  actionRoomAffectation ******************************/
	public function actionRoomAffectation()
	{    
       $model=new Persons;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		//$modelRoomPerson=new RoomHasPerson;
		
		$this->performAjaxValidation($model);

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

		
		  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
      					/*    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							    */
							         $condition = 'p.active IN(1,2) AND ';
						       // }
      


		 		
		
		     if(isset($_POST['Persons']['sort_by_level']))
			         { $this->sort_by_level=$_POST['Persons']['sort_by_level']; 
			              if($this->sort_by_level==0)
			                $this->idLevel!=null;
			         }   
		    
		     if($this->sort_by_level==1)
		     {
			     if(isset($_POST['LevelHasPerson']))
	               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
							   $this->idLevel=$modelLevel->level;
							    unset(Yii::app()->session['LevelHasPerson']);
		                      Yii::app()->session['LevelHasPerson'] = $this->idLevel;
							 
							  
                           if(isset($_POST['Shifts']))
	                 	     { $modelShift->attributes=$_POST['Shifts'];
				              $this->idShift=$modelShift->shift_name;
								 unset(Yii::app()->session['Shifts']);
		                      Yii::app()->session['Shifts'] = $this->idShift;
							  }
							  
						   if(isset($_POST['Sections']))
	               	         { $modelSection->attributes=$_POST['Sections'];
							   $this->section_id=$modelSection->section_name;
						     	 unset(Yii::app()->session['Sections']);
		                      Yii::app()->session['Sections'] = $this->section_id;
							  }
							  							  
							  $this->messageNoStud=false;
							    $model_aff=Persons::model()->searchStudentsByLevel($condition,$this->idLevel,$acad_sess);
							   if(isset($model_aff))														  
								{ if($model_aff->getItemCount()==0)
			                        $this->messageNoStud=true;	
								}	
								
								
		                 }
	                 else
	                     {
	                         $this->idShift=null;
								$this->section_id=null;
								$this->idLevel=null;
								
								$this->idLevel_sort_zero=null;
								$this->room_id=null;
								
								$this->messageERROR=0;
								$this->messageSUCCESS=false;
								$this->messageNoStud=false;
								
						 }						 
		       }
		     elseif($this->sort_by_level==0)	
		      {
		      	  if(isset($_POST['Shifts']))
	               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
						   if(isset($_POST['Shifts']))
	                 	     { $modelShift->attributes=$_POST['Shifts'];
				              $this->idShift=$modelShift->shift_name;
								 unset(Yii::app()->session['Shifts']);
		                      Yii::app()->session['Shifts'] = $this->idShift;
							  }
							  
						   if(isset($_POST['Sections']))
	               	         { $modelSection->attributes=$_POST['Sections'];
							   $this->section_id=$modelSection->section_name;
						     	 unset(Yii::app()->session['Sections']);
		                      Yii::app()->session['Sections'] = $this->section_id;
							  }
							   $modelLevel->attributes=$_POST['LevelHasPerson'];
							   $this->idLevel_sort_zero=$modelLevel->level;
							    unset(Yii::app()->session['LevelHasPerson_sort_zero']);
		                      Yii::app()->session['LevelHasPerson_sort_zero'] = $this->idLevel_sort_zero;
							 
							  
							  $this->messageNoStud=false;
							  
							    $model_aff=Persons::model()->searchStudentsToAffectRoom($acad_sess);
							   if(isset($model_aff))														  
								{ if($model_aff->getItemCount()==0)
			                        $this->messageNoStud=true;	
								}	
								
								
		                 }
	                 else
	                     {
	                         $this->idShift=null;
								$this->section_id=null;
								$this->idLevel=null;
								$this->idLevel_sort_zero=null;
								$this->room_id=null;
								
								$this->messageERROR=0;
								$this->messageSUCCESS=false;
								$this->messageNoStud=false;
								
						 }			
						 
		      	}
	   
					
			
			
		if(isset($_POST['execute']))
		  { //on vient de presser le bouton
			if($this->sort_by_level==1)  
			  {   $modelLevel->attributes=$_POST['LevelHasPerson'];
				  $this->idLevel=$modelLevel->level;
			   }
			elseif($this->sort_by_level==0)			   
			  {	  $modelLevel->attributes=$_POST['LevelHasPerson'];
				  $this->idLevel_sort_zero=$modelLevel->level;
			    }		   
				  $modelRoom->attributes=$_POST['Rooms'];
				  $this->room_id=$modelRoom->room_name;
						
						 
			//reccuperer les lignes selectionnees(checked lines)
			if($this->room_id!=null) 
			  {			 
			        if(isset($_POST['chk']))			  
				      {	   
				           $OK=false;
						           
					 foreach($_POST['chk'] as $pers) 
						{	  
							if($this->sort_by_level==1)
							 { 
								$OK=true;
								
							   }
							elseif($this->sort_by_level==0)
							    {
							    	$modelLevelPerson=new LevelHasPerson;
									 
									 $modelLevelPerson->setAttribute('level',$this->idLevel_sort_zero);
						          $modelLevelPerson->setAttribute('students',$pers);
								  $modelLevelPerson->setAttribute('academic_year',$acad_sess);
								  $modelLevelPerson->setAttribute('date_created',date('Y-m-d'));
								  $modelLevelPerson->setAttribute('date_updated',date('Y-m-d'));
								  $modelLevelPerson->setAttribute('create_by',Yii::app()->user->name);
						                 
								
										if($modelLevelPerson->save())
										    { 
										     	$OK=true;//$this->messageSUCCESS=true;
										    }
																		 
								   	
							      }
							      
							if($OK)	
							 {
							 	$modelRoomPerson=new RoomHasPerson;								
						          $modelRoomPerson->setAttribute('room',$this->room_id);
						          $modelRoomPerson->setAttribute('students',$pers);
								  $modelRoomPerson->setAttribute('academic_year',$acad_sess);
								  $modelRoomPerson->setAttribute('date_created',date('Y-m-d'));
								  $modelRoomPerson->setAttribute('date_updated',date('Y-m-d'));
								  $modelRoomPerson->setAttribute('create_by',Yii::app()->user->name);

						                  
								
									
										if($modelRoomPerson->save())
										    { 
										     	$this->messageSUCCESS=true;
										    }
									
								   
								   
							 }
							 
							 
						 }
							
							$this->room_id=null;	
								
																	  
						  }
						 else  //no line is checked
						  {
								$this->messageERROR=2;// for no checked lines
								$this->messageSUCCESS=false;
						   }			   

			  }		
			 else  //no room is selected
			  {
				$this->messageERROR=1; //for no selected room
				$this->messageSUCCESS=false;
			  }        
			  
			  
		   }
		
		if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
	
			
			
			if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			     
			        $sh=null;
					$se=null;
	                $le=null;
	                $le_sort_zero=null;
	             //   $ro=null;
					
					 $this->idShift=Yii::app()->session['Shifts'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['Sections'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	              if($this->sort_by_level==1)
		     		{  $this->idLevel=Yii::app()->session['LevelHasPerson'];
						if($this->idLevel!=null)
						  $le=$this->idLevel;
						 $model=new Persons('searchStudentsByLevel($le,$acad_sess)'); 
		     		 }
		     		elseif($this->sort_by_level==0)
		     		  {
		     		 $this->idLevel_sort_zero=Yii::app()->session['LevelHasPerson_sort_zero'];
						if($this->idLevel_sort_zero!=null)
						  $le_sort_zero=$this->idLevel_sort_zero;
						  $model=new Persons('searchStudentsToAffectRoom($acad_sess)');
		     		  	}
					  
	        
					  
	                      
			$model=new Persons('searchStudentsByLevel($le,$acad_sess)');
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
         
		
			   $this->render('roomAffectation',array(
			  'model'=>$model,
		  ));
		
	}

	
	
//************************  actionLevelRoomAffectation ******************************/
	public function actionLevelRoomAffectation()
	{    
       $model=new Persons;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		//$modelRoomPerson=new RoomHasPerson;
		
		$this->performAjaxValidation($model);
		

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		
		  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     					/*   if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         */
							         $condition = 'p.active IN(1,2) AND ';
						      //  }


      


		 		
		
		     if(isset($_POST['Persons']['sort_by_level']))
			         { $this->sort_by_level=$_POST['Persons']['sort_by_level']; 
			              if($this->sort_by_level==0)
			                $this->idLevel!=null;
			         }   
		    
		     if($this->sort_by_level==1)
		     {
			     if(isset($_POST['LevelHasPerson']))
	               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
							   $this->idLevel=$modelLevel->level;
							    unset(Yii::app()->session['LevelHasPerson']);
		                      Yii::app()->session['LevelHasPerson'] = $this->idLevel;
							 
							  
                           if(isset($_POST['Shifts']))
	                 	     { $modelShift->attributes=$_POST['Shifts'];
				              $this->idShift=$modelShift->shift_name;
								 unset(Yii::app()->session['Shifts']);
		                      Yii::app()->session['Shifts'] = $this->idShift;
							  }
							  
						   if(isset($_POST['Sections']))
	               	         { $modelSection->attributes=$_POST['Sections'];
							   $this->section_id=$modelSection->section_name;
						     	 unset(Yii::app()->session['Sections']);
		                      Yii::app()->session['Sections'] = $this->section_id;
							  }
							  							  
							  $this->messageNoStud=false;
							    $model_aff=Persons::model()->searchStudentsByLevel($condition,$this->idLevel,$acad_sess);
							   if(isset($model_aff))														  
								{ if($model_aff->getItemCount()==0)
			                        $this->messageNoStud=true;	
								}	
								
								
		                 }
	                 else
	                     {
	                         $this->idShift=null;
								$this->section_id=null;
								$this->idLevel=null;
								
								$this->idLevel_sort_zero=null;
								$this->room_id=null;
								
								$this->messageERROR=0;
								$this->messageSUCCESS=false;
								$this->messageNoStud=false;
								
						 }						 
		       }
		     elseif($this->sort_by_level==0)	
		      {
		      	  if(isset($_POST['Shifts']))
	               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
						   if(isset($_POST['Shifts']))
	                 	     { $modelShift->attributes=$_POST['Shifts'];
				              $this->idShift=$modelShift->shift_name;
								 unset(Yii::app()->session['Shifts']);
		                      Yii::app()->session['Shifts'] = $this->idShift;
							  }
							  
						   if(isset($_POST['Sections']))
	               	         { $modelSection->attributes=$_POST['Sections'];
							   $this->section_id=$modelSection->section_name;
						     	 unset(Yii::app()->session['Sections']);
		                      Yii::app()->session['Sections'] = $this->section_id;
							  }
							   $modelLevel->attributes=$_POST['LevelHasPerson'];
							   $this->idLevel_sort_zero=$modelLevel->level;
							    unset(Yii::app()->session['LevelHasPerson_sort_zero']);
		                      Yii::app()->session['LevelHasPerson_sort_zero'] = $this->idLevel_sort_zero;
							 
							  
							  $this->messageNoStud=false;
							  
							    $model_aff=Persons::model()->searchStudentsToAffectLevelRoom($condition,$acad_sess);
							   if(isset($model_aff))														  
								{ if($model_aff->getItemCount()==0)
			                        $this->messageNoStud=true;	
								}	
								
								
		                 }
	                 else
	                     {
	                         $this->idShift=null;
								$this->section_id=null;
								$this->idLevel=null;
								$this->idLevel_sort_zero=null;
								$this->room_id=null;
								
								$this->messageERROR=0;
								$this->messageSUCCESS=false;
								$this->messageNoStud=false;
								
						 }			
						 
		      	}
	   
					
			
			
		if(isset($_POST['execute']))
		  { //on vient de presser le bouton
			if($this->sort_by_level==1)  
			  {   $modelLevel->attributes=$_POST['LevelHasPerson'];
				  $this->idLevel=$modelLevel->level;
			   }
			elseif($this->sort_by_level==0)			   
			  {	  $modelLevel->attributes=$_POST['LevelHasPerson'];
				  $this->idLevel_sort_zero=$modelLevel->level;
			    }		   
				  $modelRoom->attributes=$_POST['Rooms'];
				  $this->room_id=$modelRoom->room_name;
						
			if($this->room_id!=null) 
			  {			 
			        if(isset($_POST['chk']))			  
				      {	   
				           $OK=false;
						           
					 foreach($_POST['chk'] as $pers) 
						{	  
							if($this->sort_by_level==1)
							 { 
								$OK=true;
								
							   }
							elseif($this->sort_by_level==0)
							    {
							    	$modelLevelPerson=new LevelHasPerson;
									 
									 $modelLevelPerson->setAttribute('level',$this->idLevel_sort_zero);
						          $modelLevelPerson->setAttribute('students',$pers);
								  $modelLevelPerson->setAttribute('academic_year',$acad_sess);
								  $modelLevelPerson->setAttribute('date_created',date('Y-m-d'));
								  $modelLevelPerson->setAttribute('date_updated',date('Y-m-d'));
								  $modelLevelPerson->setAttribute('create_by',Yii::app()->user->name);
						                 
								
										if($modelLevelPerson->save())
										    { 
										     	$OK=true;
										    }
																		 
								   	
							      }
							      
							if($OK)	
							 {
							 	$modelRoomPerson=new RoomHasPerson;								
						          $modelRoomPerson->setAttribute('room',$this->room_id);
						          $modelRoomPerson->setAttribute('students',$pers);
								  $modelRoomPerson->setAttribute('academic_year',$acad_sess);
								  $modelRoomPerson->setAttribute('date_created',date('Y-m-d'));
								  $modelRoomPerson->setAttribute('date_updated',date('Y-m-d'));
								  $modelRoomPerson->setAttribute('create_by',Yii::app()->user->name);

						                  
								
										if($modelRoomPerson->save())
										    { 
										     	$this->messageSUCCESS=true;
										     	//update persons table, set Paid to NULL
										     	$modelPers = Persons::model()->findByPk($pers);
										     	$modelPers->setAttribute('paid',NULL);
										     	$modelPers->save();
										     	
										     	
										    }
								
								   
								   
							 }
							 
							 
						 }
							
							$this->room_id=null;	
								
																	  
						  }
						 else  //no line is checked
						  {
								$this->messageERROR=2;// for no checked lines
								$this->messageSUCCESS=false;
						   }			   

			  }		
			 else  //no room is selected
			  {
				$this->messageERROR=1; //for no selected room
				$this->messageSUCCESS=false;
			  }        
			  
			  
		   }
		
		if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
	
			
			
			if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			     
			        $sh=null;
					$se=null;
	                $le=null;
	                $le_sort_zero=null;
	             //   $ro=null;
					
					 $this->idShift=Yii::app()->session['Shifts'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['Sections'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	              if($this->sort_by_level==1)
		     		{  $this->idLevel=Yii::app()->session['LevelHasPerson'];
						if($this->idLevel!=null)
						  $le=$this->idLevel;
						 $model=new Persons('searchStudentsByLevel($le,$acad_sess)'); 
		     		 }
		     		elseif($this->sort_by_level==0)
		     		  {
		     		 $this->idLevel_sort_zero=Yii::app()->session['LevelHasPerson_sort_zero'];
						if($this->idLevel_sort_zero!=null)
						  $le_sort_zero=$this->idLevel_sort_zero;
						  $model=new Persons('searchStudentsToAffectLevelRoom($acad_sess)');
		     		  	}
		
					  
	                      
			$model=new Persons('searchStudentsByLevel($le,$acad_sess)');
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
         
		
			   $this->render('levelRoomAffectation',array(
			  'model'=>$model,
		  ));
		
	}



//************************  actionMouvement ******************************/
//pemet ou chanje elev la sal 
	public function actionMouvement()
	{    
       $model=new Persons;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoom=new Rooms;
		$modelRoomTo=new Rooms;
		//$modelRoomPerson=new RoomHasPerson;
		
		$this->performAjaxValidation($model);

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		
		  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     						/*    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							   */
							         $condition = 'p.active IN(1,2) AND ';
						        //}


       
		      	  if(isset($_POST['Shifts']))
	               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
						   if(isset($_POST['Shifts']))
	                 	     { $modelShift->attributes=$_POST['Shifts'];
				              $this->idShift=$modelShift->shift_name;
								 unset(Yii::app()->session['Shifts']);
		                      Yii::app()->session['Shifts'] = $this->idShift;
							  }
							  else
	               	             $this->idShift=Yii::app()->session['Shifts'];
							  
						   if(isset($_POST['Sections']))
	               	         { $modelSection->attributes=$_POST['Sections'];
							   $this->section_id=$modelSection->section_name;
						     	 unset(Yii::app()->session['Sections']);
		                      Yii::app()->session['Sections'] = $this->section_id;
							  }
							  else
	               	             $this->section_id=Yii::app()->session['Sections'];
							   
						    if(isset($_POST['LevelHasPerson']))
	               	         { $modelLevel->attributes=$_POST['LevelHasPerson'];
							   $this->idLevel_sort_zero=$modelLevel->level;
							    unset(Yii::app()->session['LevelHasPerson_sort_zero']);
		                      Yii::app()->session['LevelHasPerson_sort_zero'] = $this->idLevel_sort_zero;
							 
	               	         }
	               	         else
	               	             $this->idLevel_sort_zero =Yii::app()->session['LevelHasPerson_sort_zero'];
	               	         
	               	        if(isset($_POST['Rooms']))
	               	         {  $modelRoom->attributes=$_POST['Rooms'];
	               	         	$this->room_id=$modelRoom->room_name;
							    unset(Yii::app()->session['RoomFrom']);
		                      Yii::app()->session['RoomFrom'] = $this->room_id;
	               	         
	               	          }
	               	          else
	               	             $this->room_id=Yii::app()->session['RoomFrom'];
	               	         
							  $this->messageNoStud=false;
							  
							   
								
								
		                 }
	                 else
	                     {
	                         $this->idShift=null;
								$this->section_id=null;
								$this->idLevel=null;
								$this->idLevel_sort_zero=null;
								$this->room_id=null;
								
								$this->messageERROR=0;
								$this->messageSUCCESS=false;
								$this->messageNoStud=false;
								
						 }			
						 
		      	
	   
					
			
			
		if(isset($_POST['execute']))
		  { //on vient de presser le bouton
			
			     $modelLevel->attributes=$_POST['LevelHasPerson'];
				  $this->idLevel_sort_zero=$modelLevel->level;
			    		   
				  $modelRoom->attributes=$_POST['Rooms'];
				  $this->room_id=$modelRoom->room_name;
				  
				  $modelRoomTo->attributes=$_POST['Rooms'][1];
				  $this->room_id_to=$modelRoomTo->room_name;
						
			if($this->room_id_to!=null) 
			  {			 
			        if(isset($_POST['chk']))			  
				      {	   
				           $OK=false;
						           
					 foreach($_POST['chk'] as $pers) 
						{	  
							
							
							    /*	$modelLevelPerson=new LevelHasPerson;
									 
								  $modelLevelPerson->setAttribute('level',$this->idLevel_sort_zero);
						          $modelLevelPerson->setAttribute('students',$pers);
								  $modelLevelPerson->setAttribute('academic_year',$acad_sess);
								  $modelLevelPerson->setAttribute('date_created',date('Y-m-d'));
								  $modelLevelPerson->setAttribute('date_updated',date('Y-m-d'));
								  $modelLevelPerson->setAttribute('create_by',Yii::app()->user->name);
						                 
								
										if($modelLevelPerson->save())
										    { 
										     	$OK=true;
										    }
									*/									 
								   	
							      
							      
							
							 	  //update RoomHasPerson
							 	   $room_has_pers = RoomHasPerson::model()->findByAttributes(array('students'=>$pers,'academic_year'=>$acad_sess));
                                   
                                    $command = Yii::app()->db->createCommand();
								  $command->update('room_has_person', array(
								   'room'=>$this->room_id_to,'date_updated'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name ), 'students=:stud AND academic_year=:year', array(':stud'=>$pers,':year'=>$acad_sess));
								
										     	$OK=true;
										   
								   
							 
							 
							 
						 }
						 
						     if($OK)	
							    Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation SUCCESS.'));
						 
							
							$this->room_id=null;	
								
																	  
						  }
						 else  //no line is checked
						  {
								Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Please check all students that you would like to move.'));
								
						   }			   

			  }		
			 else  //no room is selected
			  {
				Yii::app()->user->setFlash(Yii::t('app','Error'), Yii::t('app','Please select the room where students will be moved to.'));
				
				
			  }        
			  
			  
		   }
		
		if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
	
			
			
			
			     
			       
					 $this->idShift=Yii::app()->session['Shifts'];
					  
					$this->section_id=Yii::app()->session['Sections'];
					  
	              
		     		 $this->idLevel_sort_zero=Yii::app()->session['LevelHasPerson_sort_zero'];
					
					$this->room_id=Yii::app()->session['RoomFrom'];
         
		
			   $this->render('mouvement',array(
			  'model'=>$model,
		  ));
		
	}
	
	

//************************  actionClassSetup ******************************/
	public function actionClassSetup()
	{    
       $model=new Persons;
        $modelLevel= new LevelHasPerson;
		
		$siges_structure = infoGeneralConfig('siges_structure_session'); 
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		 		
        $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     						/*    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							    */
							         $condition = 'p.active IN(1,2) AND ';
						        //}

      

		    
		         if(isset($_POST['Persons']['menfp']))
			 		 {
                        $this->menfp = $_POST['Persons']['menfp'];
                        Yii::app()->session['menfp_classSetup'] = $this->menfp;
                         
                      }
			     else
	                 {
	                      if(Yii::app()->session['menfp_classSetup']!='')
	                        $this->menfp = Yii::app()->session['menfp_classSetup'];
	                      else
	                        $this->menfp=0;
					
					 }					
			    
			     if(isset($_POST['LevelHasPerson']))
	               	{  //on n'a pas presser le bouton, il fo load apropriate rooms
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
							   $this->idLevel=$modelLevel->level;
							    unset(Yii::app()->session['LevelHasPerson_classSetup']);
		                      Yii::app()->session['LevelHasPerson_classSetup'] = $this->idLevel;
							 
					 }
	              else
	                 {
	                      if(Yii::app()->session['LevelHasPerson_classSetup']!='')
	                        $this->idLevel = Yii::app()->session['LevelHasPerson_classSetup'];
	                      else
	                        $this->idLevel=null;
					
					 }						 
		      
		     	
		   if(isset($_POST['createPdf']))
				{
	                  	 

								// create new PDF document
								$pdf = new tcpdf('L', PDF_UNIT, 'legal', true, 'UTF-8', false); // letter: 216x279 mm ; legal: 216x356;  612.000, 1008.00 ; 11.00x17.00 :279x432 mm

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
								//Extract Code1 Number
								       $school_code1 = infoGeneralConfig('code1');
				   				//Extract Code2(11 digit) Number
                                       $school_code2 = infoGeneralConfig('code2');
				   				//Extract school Licence Number
                                       $school_licence_number = infoGeneralConfig('school_licence_number');
				   				//Extract school Director
                                         $school_director_name = infoGeneralConfig('school_director_name');
                                                               
                                                                                             
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app','Class Setup List'));
								$pdf->SetSubject(Yii::t('app','Class Setup List'));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, 27, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								//$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED); 

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetMargins(10, PDF_MARGIN_TOP,10 );
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
/*
								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);
*/
								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 13, '', true);
								
			
						 
	 
														                
								 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();

								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

								// Set some content to print
					$html = <<<EOD
 <style>
	
	div.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		font-size: 22px;
		width:100%;
		text-align: center;
		line-height:15px;
		
	}
	
  span.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		font-size: 13px;
		text-align: center;
	}

	
	div.info {
		float:left;
		font-size:10px;
		margin-top:10px;
		margin-bottom:5px;
		
	}
	
	
	
	
	tr.color1 {
		background-color:#F5F6F7; 
		
	}
	
	tr.color2 {
		background-color:#efefef; 
		
	}
	
	td.couleur1 {
		background-color:#F5F6F7; 
				
	}
	
	td.couleur2 {
		background-color:#efefef;  
		
	}
	
		
	
	tr.tr_body {
		border:1px solid #DDDDDD;
	   
	  }
	
	td.header_first{
		border-left:0px solid #FFFFFF; 
		border-bottom:0px solid #FFFFFF;
		border-top:0px solid #FFFFFF;
		
		font-weight:bold;
		width:33px;
		
		
	   }
	   
	 td.header_first1{
		border-left:2px solid #DDDDDD; 
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:123px;
		background-color:#E4E9EF;
	   }
	
	td.header_special1{
		border-right:2px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:205px;
		background-color:#E4E9EF;
		
	   }
	td.header_special2{
		border-right:2px solid #DDDDDD;
		border-top:1px solid #DDDDDD;
		font-weight:bold;
		width:270px;
		background-color:#E4E9EF;
		
	   }
	   
	td.header_special3{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:95px;
		background-color:#E4E9EF;
	   }
	   
	
	   
	 td.header{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:80px;
		background-color:#E4E9EF;
	   }
	   
	td.header_prenom{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:145px;
		background-color:#E4E9EF;
	   }

   td.header_prenom_m{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:125px;
		background-color:#E4E9EF;
	   }
	  
	td.header_sexe{
		border-top:1px solid #DDDDDD;
		border-right:2px solid #DDDDDD; 
		border-bottom:1px solid #DDDDDD;
		font-weight:bold;
		width:40px;
		background-color:#E4E9EF;
	   }

     td.data {
		border:1px solid #DDDDDD; 
		border-right:2px solid #DDDDDD;
	
	  }
	  
	  td.data_sexe {
		border:1px solid #DDDDDD; 
		border-right:2px solid #DDDDDD;
	    width:40px;
	  }
	  
	td.data_last {
		border:1px solid #DDDDDD; 
		
	  }
	td.no_border{
		border:0px solid #FFFFFF;
		}
		
    td.div.pad{
    	padding-left:10px;
    	margin-left:20px;
    	}
    td.code{
    	width:280px; 
    	font-weight:bold;
    	}
    	
    span.code{
    	font-size:14px; 
    	}
    	
    span.licence{
    	font-size:14px;
    	}
    	
    td.director{
    	width:360px;  
    	font-weight:bold; 
    	}
    	
     td.space{
    	width:660px;  
    	 
    	}
    	
    td.diege_district{
    	width:200px;  
    	font-weight:bold;   
    	}
    	
    span.section{
    	font-size:18px; 
    	}
	
</style>
                                       
										
EOD;
	   //pou antet
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
                        
	   $acad_name=Yii::app()->session['currentName_academic_year'];
	   $acad_name_ = strtr( $acad_name.$sess_name, pa_daksan() );
	   
	   $level=$this->getLevel($this->idLevel);
	   $level_ = strtr( $level, pa_daksan() );
	   
	   //pou elev yo(ane ki sot pase a)
	    //$previous_level=$this->getLevel($previousLevel_id);
	   
	
	$html .='<br/><div class="title" >'.strtoupper(strtr(Yii::t("app","Class setup list"), pa_daksan() )).'
	            <br/> <span class="title" >'.strtoupper(strtr(Yii::t("app","Academic Year"), pa_daksan() ).' '.$acad_name).'<br/>'.strtoupper(Yii::t("app","Level : ").$level_).' </span>
	</div>';
	
	
	$html .=' <br/><br/>
			<table class="table no-margin" style="width:100%; ">
		         <tbody>
		             
		             <tr >
		               <td class="code">'.strtoupper(Yii::t("app","Code : ")).'<span class="code" > '.$school_code1.'</span><br/><br/>'.Yii::t("app","Licence number : ").'<span class="licence" >'.$school_licence_number.'</span></td><td class="director">'.Yii::t("app","Director : ").$school_director_name.'</td><td class="siege_district">'.Yii::t("app","Siege / District scolaire : ").'<br/><br/> <span class="section" >'.Yii::t("app","Section : ").'</span></td>            
		             </tr>
		             
		            </tbody>
		      </table>
      ';
      
      
if($this->menfp==1)      
  {    
	  $html .=' <br/><br/>
	
	       <table >
         <tbody>
             <tr >
                  
                  <td rowspan="2" class="header_first" >  </td><td rowspan="2" class="header_first1" ><div class="pad">  '.Yii::t("app","Last name").' </div></td><td rowspan="2" class="header_prenom"><div class="pad">  '.Yii::t("app","First name").' </div></td><td rowspan="2" class="header_prenom_m" ><div class="pad">  '.Yii::t("app","Mother-s First Name").' </div></td><td rowspan="2" class="header_sexe" ><div class="pad" style="text-align:center;">  '.Yii::t("app","Gender").' </div></td><td colspan="2" class="header_special1"><div class="pad" style="text-align:center;">  '.Yii::t("app","Birthday and place").' </div></td><td colspan="3" class="header_special2" ><div class="pad" style="text-align:center;"> '.Yii::t("app","Success level").' '.$level.'  </div></td>                                                                                                                   																												<!--$previous_level-->
             </tr>
             <tr style="border:0px solid #DDDDDD;">
                 <td class="header" ><div class="pad" style="text-align:center;">  '.Yii::t("app","Date").' </div></td><td class="header_prenom_m" ><div class="pad" style="text-align:center;">  '.Yii::t("app","Place").' </div></td>
                 <td class="header_special3" ><div class="pad" style="text-align:center;"> '.Yii::t("app","Identifiant").' </div></td><td class="header_special3" ><div class="pad" style="text-align:center;">  '.Yii::t("app","Matricule").' </div></td><td class="header" ><div class="pad" style="text-align:center;">  '.Yii::t("app","Year").' </div></td>         
             </tr>
            
             <tr style="border:0px solid #DDDDDD;">
               <td colspan="10" class="no_border" ></td>            
             </tr>
             
                 ';
      
      
          
			
	     
	      $le='';
	      
	          
	       
	                $this->idLevel=Yii::app()->session['LevelHasPerson_classSetup'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
				 
					  
			 $data_annee = $this->getAcademicPeriodNameL( $acad_sess,$le);
			 
			 
			 $annee ='';
			 if($data_annee!=null)
                $annee =  $data_annee->name_period;

	         $dataProvider = Persons::model()->searchStudentsForPdfCSL($condition,$le, $acad_sess);
          
          if(isset($dataProvider))
			    {  $result=$dataProvider->getData();
				      $i=0;
				      $color=0;
				      $class="";
				      
				    foreach($result as $pers)
                     {   $i++;
                     	          $sexe = 'M';
                     	          if($pers->gender==1)
                     	            $sexe = 'F';
                     	          
                     	          if($color==2)
									 $color=0;
								  if($color==0)
									$class="color1";
								  elseif($color==1)
									$class="color2";  
                     	            
                   $html .=' <tr class="'.$class.'">
               <td class="data" ><div class="pad"> '.$i.' </div></td><td class="data" ><div class="pad"> '.$pers->last_name.' </div></td><td class="data" ><div class="pad"> '.$pers->first_name.' </div></td><td class="data" ><div class="pad"> '.$pers->mother_first_name.' </div></td><td class="data_sexe" ><div class="pad"> '.$sexe.' </div></td><td class="data" ><div class="pad"> '.$pers->Birthday_.' </div></td><td class="data" ><div class="pad"> '.$pers->city_name.' </div></td><td class="data" ><div class="pad"> '.$pers->identifiant.' </div></td><td class="data" ><div class="pad"> '.$pers->matricule.' </div></td><td class="data" ><div class="pad"> '.$annee.' </div></td>            
             </tr>';
                     	$color++;
                     	}
                     	
			    }
      
		     $html .='   </tbody>
		              </table> 
		              ';
		              
		              
		              
		  $html .=' <br/><br/><br/>
			<table class="table no-margin" style="width:100%; ">
		         <tbody>
		             <tr >
		               <td class="code">'.Yii::t("app","Code (11 chiffres): ").'<span class="code" > '.$school_code2.'</span></td><td > </td><td class="siege_district"> <span class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t("app","Signature du(de la) Directeur(trice) ").'</span></td>            
		             </tr>
		            </tbody>
		      </table>
      ';
      
      $file_name = strtr("LFC_CSL_MENFP", pa_daksan() ).'_'.$acad_name_.'_'.$level_;	 
      
  }
elseif($this->menfp==0)
  {    
	  $html .=' <br/><br/>
	
	       <table >
         <tbody>
             <tr >
                 <td class="header_first" >  </td><td class="header_first1" ><div class="pad">  '.Yii::t("app","Last name").' </div></td><td  class="header_prenom"><div class="pad">  '.Yii::t("app","First name").' </div></td><td  class="header_sexe" ><div class="pad">  '.Yii::t("app","Gender").' </div></td><td  class="header_first1"><div class="pad">  '.Yii::t("app","Birthday").' </div></td><td class="header_prenom" ><div class="pad"> '.Yii::t("app","Person liable phone").' </div></td><td class="header_special1" ><div class="pad"> '.Yii::t("app","Address").'</div></td>
                                                      <!--$previous_level-->
             </tr>
            
            
             <tr style="border:0px solid #DDDDDD;">
               <td colspan="7" class="no_border" ></td>            
             </tr>
             
                 ';
      
      
          
			
	      //$sh='';
	      //$se='';
	      $le='';
	      
	          
	      
	                $this->idLevel=Yii::app()->session['LevelHasPerson_classSetup'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
				 
					  
			 $data_annee = $this->getAcademicPeriodNameL($acad_sess,$le);
			
			 
			 $annee ='';
			 if($data_annee!=null)
                $annee =  $data_annee->name_period;

	         $dataProvider = Persons::model()->searchStudentsForPdfCSL($condition,$le,$acad_sess);
          
          if(isset($dataProvider))
			    {  $result=$dataProvider->getData();
				      $i=0;
				      $color=0;
				      $class="";
				      
				    foreach($result as $pers)
                     {   $i++;
                     	          $sexe = 'M';
                     	          if($pers->gender==1)
                     	            $sexe = 'F';
                     	          
                     	          if($color==2)
									 $color=0;
								  if($color==0)
									$class="color1";
								  elseif($color==1)
									$class="color2";  
                     	            
                   $html .=' <tr class="'.$class.'">
               <td class="data" ><div class="pad"> '.$i.' </div></td><td class="data" ><div class="pad"> '.$pers->last_name.' </div></td><td class="data" ><div class="pad"> '.$pers->first_name.' </div></td><td class="data_sexe" ><div class="pad"> '.$sexe.' </div></td><td class="data" ><div class="pad"> '.$pers->birthday.' </div></td><td class="data" ><div class="pad"> '.$pers->person_liable_phone.' </div></td><td class="data" ><div class="pad"> '.$pers->adresse.' </div></td>            
             </tr>';
                     	$color++;
                     	}
                     	
			    }
	      
		     $html .='   </tbody>
		              </table> 
		              ';
		              
		              
		              
		  $html .=' <br/><br/><br/>
			<table class="table no-margin" style="width:100%; ">
		         <tbody>
		             <tr >
		               <td class="code">'.Yii::t("app","Code (11 chiffres): ").'<span class="code" > '.$school_code2.'</span></td><td > </td><td class="siege_district"> <span class="signature1" style=" width:30%;">  <hr style="width:93%;" /> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t("app","Signature du(de la) Directeur(trice) ").'</span></td>            
		             </tr>
		            </tbody>
		      </table>
      ';
      
      $file_name = strtr("LFC_CSL", pa_daksan() ).'_'.$acad_name_.'_'.$level_;	 
  }
  
      
                 $end_year_decision = 'documents/lfc_csl';

	            if (!file_exists(Yii::app()->basePath.'/../'.$end_year_decision))  
					mkdir(Yii::app()->basePath.'/../'.$end_year_decision);
					
			    if (!file_exists(Yii::app()->basePath.'/../'.$end_year_decision.'/'.$acad_name_))  
					mkdir(Yii::app()->basePath.'/../'.$end_year_decision.'/'.$acad_name_);
										 
						$this->pathLink = $end_year_decision.'/'.$acad_name_;				 
										 
                                           // $pdf->writeHTML($html, true, false, true, false, '');
		                                    // Print text using writeHTMLCell()
                                          $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
							 
								
								  
								$pdf->Output($end_year_decision.'/'.$acad_name_.'/'.$file_name.'.pdf', 'F');
					
								
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
	                  	
			                   	                  	
	                  }  
				  
				  
						
			
			if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			     
			        $le=null;
	                $le_sort_zero=null;
	             //   $ro=null;
					
					
	               $this->idLevel=Yii::app()->session['LevelHasPerson_classSetup'];
						if($this->idLevel!=null)
						  $le=$this->idLevel;
						
			           
			   
	                      
			$model=new Persons('searchStudentsForPdfCSL($condition,$le,$acad_sess)');
		
		    // $model=new ReportCard;
		     
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
         
		 // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Class setup list / Level: '.$model->getLevelById($le))), null,false);
				
                if($this->menfp==1)
                 { 
                 	$this->exportCSV($model->searchStudentsForPdfCSL($condition,$le, $acad_sess) , array(  
                 	'last_name',
					'first_name',
					'mother_first_name',
					'sexe',
			        'birthday',
			        'cities0.city_name',
					'identifiant',
					'matricule',
					
					
					            
					             )); 
					             
                 }
                elseif($this->menfp==0)
                  {
                  	$this->exportCSV($model->searchStudentsForPdfCSL($condition,$le, $acad_sess) , array(  
                 	'last_name',
					'first_name',
					'sexe',
			        'person_liable_phone',
			        'adresse',
					            
					     ));
					      
                  	}
                  		 
		      }
		      
		      
	
			   $this->render('classSetup',array(
			  'model'=>$model,
		  ));
		
	}
	

		
public function actionListForReport()
  {       
	     $model=new Persons;
	     $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoomPerson=new RoomHasPerson;
		
		 $this->idShift=null;
		$this->section_id=null;
		$this->idLevel=null;
		$this->room_id=null;
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

		   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
          /*         if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							   */
							         $condition = 'p.active IN(1,2) AND ';
						       // }

      
		       		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
	
	 if(isset($_GET['isstud']))
		 {
			 if($_GET['isstud']==1)
				 {
					 $dataProvider_s= Persons::model()->searchStudents_($condition,$acad_sess);
				  if(isset($dataProvider_s))														  
					{ if($dataProvider_s->getItemCount()!=0)
                        $this->tot_stud_s =$dataProvider_s->getItemCount();
	               			       
						//reccuperer la qt des diff. sexes
						$person_s=$dataProvider_s->getData();
																								   
						foreach($person_s as $stud){
							if($stud->gender==1)
							   $this->female_s++;
							elseif($stud->gender==0)
							   $this->male_s++;
					      }
						  
					 }
					
					if (isset($_GET['pageSize'])) {
					Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
					unset($_GET['pageSize']);
					}
			       $model=new Persons('searchStudents_('.$condition.','.$acad_sess.')');
					
					 if(isset($_GET['Persons']))
						$model->attributes=$_GET['Persons']; 
						  // Here to export to CSV 
					if($this->isExportRequest()){
						$this->exportCSV(array(Yii::t('app','List student: ')), null,false);
						$this->exportCSV($model->searchStudents_($condition,$acad_sess) , array(
								'last_name',
								'first_name',
								'birthday',
								'sexe',
								'status',
								'')); 
						}

						
				}
			 elseif($_GET['isstud']==0)
			    {   if((isset($_GET['from1']) )&& ($_GET['from1']=='rpt'))
						 {
							
							if(isset($_POST['Shifts']))
			               	  {  //on n'a pas presser le bouton, il fo load apropriate rooms
								      $modelShift->attributes=$_POST['Shifts'];
						              $this->idShift=$modelShift->shift_name;
										 unset(Yii::app()->session['Shifts_teacher_report']);
				                      Yii::app()->session['Shifts_teacher_report'] = $this->idShift;
									  
									   $modelSection->attributes=$_POST['Sections'];
									   $this->section_id=$modelSection->section_name;
								     	 unset(Yii::app()->session['Sections_teacher_report']);
				                      Yii::app()->session['Sections_teacher_report'] = $this->section_id;
									  
									   $modelLevel->attributes=$_POST['LevelHasPerson'];
									   $this->idLevel=$modelLevel->level;
									    unset(Yii::app()->session['LevelHasPerson_teacher_report']);
				                      Yii::app()->session['LevelHasPerson_teacher_report'] = $this->idLevel;
									  
									   $modelRoomPerson->attributes=$_POST['RoomHasPerson'];
									   $this->room_id=$modelRoomPerson->room;
									   unset(Yii::app()->session['RoomHasPerson_teacher_report']);
				                      Yii::app()->session['RoomHasPerson_teacher_report'] = $this->room_id;
									    
									  
									
				                 } 
			                   else
			                     {
			                         $this->idShift=null;
										$this->section_id=null;
										$this->idLevel=null;
										$this->room_id=null;
								 }				   
					
							
							
							if (isset($_GET['pageSize'])) {
							Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
							unset($_GET['pageSize']);
							}
							
							$sh=null;
							$se=null;
			                $le=null;
			                $ro=null;
			                
			                
			                $this->idShift=Yii::app()->session['Shifts_teacher_report'];
							 if($this->idShift!=null)
							  $sh=$this->idShift;
							  
							$this->section_id=Yii::app()->session['Sections_teacher_report'];
							if($this->section_id!=null)
							  $se=$this->section_id;
							  
			                $this->idLevel=Yii::app()->session['LevelHasPerson_teacher_report'];
							if($this->idLevel!=null)
							  $le=$this->idLevel;
						  
			                $this->room_id=Yii::app()->session['RoomHasPerson_teacher_report'];
							if($this->room_id!=null)
							  $ro=$this->room_id;
		
		
							$model=new Persons('searchTeacherSortBy('.$condition.','.$sh.','.$se.','.$le.','.$ro.','.$acad_sess.')');
							if(isset($_GET['Persons']))
								$model->attributes=$_GET['Persons']; 
		                                        // Here to export to CSV 
							if($this->isExportRequest()){
								$this->exportCSV(array(Yii::t('app','List teacher: ')), null,false);
								$this->exportCSV($model->searchTeacherSortBy($condition,$sh,$se,$le,$ro,$acad_sess) , array(
										'last_name',
										'first_name',
										'birthday',
										'')); 
								}
						 
						 }
					   else
					     {
					     	if (isset($_GET['pageSize'])) {
						       Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
						        unset($_GET['pageSize']);
							  }
							$model=new Persons('searchTeacher('.$condition.','.$acad_sess.')');
								if(isset($_GET['Persons']))
									$model->attributes=$_GET['Persons'];
				                                if($this->isExportRequest()){
										$this->exportCSV(array(Yii::t('app','List teachers: ')), null,false);
										$this->exportCSV($model->searchTeacher($condition,$acad_sess) , array(
												'last_name',
												'first_name',
				                                                                'sexe',    
												
												'')); 
										}
					     	
					       }
			
			 }
			
			
		  }
		else
		   {
		     if (isset($_GET['pageSize'])) {
		       Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		        unset($_GET['pageSize']);
			  }
			$model=new Persons('searchEmployee('.$condition.','.$acad_sess.')');
				if(isset($_GET['Persons']))
					$model->attributes=$_GET['Persons'];
                                if($this->isExportRequest()){
						$this->exportCSV(array(Yii::t('app','List employees: ')), null,false);
						$this->exportCSV($model->searchEmployee($condition,$acad_sess) , array(
								'last_name',
								'first_name',
                                                                'sexe',    
								
								'')); 
						}
		   }
				
			   $this->render('listForReport',array(
			  'model'=>$model,
		  ));
		
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
	
		
public function actionViewListAdmission()
	{       
	     $model=new Persons;
		 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		 
		   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
                    /* if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							      */
							         $condition = 'p.active IN(1,2) AND ';
						      //  }

      


		 
		       		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
	
	 
			$dataProvider_s= Persons::model()->searchStudents_($condition,$acad_sess);
				  
				  if(isset($dataProvider_s))														  
					{ if($dataProvider_s->getItemCount()!=0)
                        $this->tot_stud_s =$dataProvider_s->getItemCount();
	               			       
						//reccuperer la qt des diff. sexes
						$person_s=$dataProvider_s->getData();
																								   
						foreach($person_s as $stud){
							if($stud->gender==1)
							   $this->female_s++;
							elseif($stud->gender==0)
							   $this->male_s++;
					      }
						  
					 }
					
					if (isset($_GET['pageSize'])) {
					Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
					unset($_GET['pageSize']);
					}
			       $model=new Persons('searchStudents_('.$condition.','.$acad_sess.')');
					
					 if(isset($_GET['Persons']))
						$model->attributes=$_GET['Persons']; 
						  // Here to export to CSV 
					if($this->isExportRequest()){
						$this->exportCSV(array(Yii::t('app','Admission list: ')), null,false);
						$this->exportCSV($model->searchStudents_($condition,$acad_sess) , array(
								'last_name',
								'first_name',
								'birthday',
								'sexe',
								'status',
								'')); 
						}

						
				
			   $this->render('viewListAdmission',array(
			  'model'=>$model,
		  ));
		
	}
	
	
	
public function actionExTeachers()
	{    
	     $model=new Persons;
       		
		 
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
	
				 $model=new Persons('searchExTeachers');
				if(isset($_GET['Persons']))
					$model->attributes=$_GET['Persons'];  
				
				
			   $this->render('exTeachers',array(
			  'model'=>$model,
		  ));
		
	}
	
	
	    //************************  getStudent($id) ******************************/
   public function getStudent($id)
	{
		
		$student=Persons::model()->findByPk($id);
        
			
		       if(isset($student))
				return $student->first_name.' '.$student->last_name;
		
	}
 	
	
		
  public function actionSchedulesAgenda()
    {       
        
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
    


//pou relve not 
public function htmlReportcard1($dataProvider,$student,$pastp,$acad,$header_text_date, $transcript_note_text,$transcript_footer_text,$transcript_signature_n_title)
	{
		$acad_=Yii::app()->session['currentId_academic_year']; 
   
    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
    //if($current_acad==null)
						          $condition = 'p.active IN(0,1,2) AND ';
						    /* else{
						     	   if($acad_!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }
*/
      
								   								
	 $general_average_current_period =0;
     $max_grade_discipline=0;
     $include_discipline=0;
     $include_place = 1;
     $average_base =0;
	 $max_grade=0;
	 $k=0;
     
				                               //Extract max grade of discipline
				                              $max_grade_discipline = infoGeneralConfig('note_discipline_initiale');
								   				//Extract school Director
				                               $include_discipline = infoGeneralConfig('include_discipline_grade');
				                               //Extract school Director
				                               $tardy_absence_display = infoGeneralConfig('tardy_absence_display');
				                               //Extract include_place
				                               $include_place = infoGeneralConfig('include_place');
								   				
								   				//Extract average base
				                                $average_base = infoGeneralConfig('average_base');
				                                
				                                //Extract observation line
				                                $show_observation_line = infoGeneralConfig('observation_line');
				                                
				                                //Extract student code
				                                $display_student_code = infoGeneralConfig('display_student_code');
				                                
				                                 //Extract display_administration_signature
				                                $display_administration_signature = infoGeneralConfig('display_administration_signature');
				                               
				                                //Extract display_parent_signature
				                                $display_parent_signature = infoGeneralConfig('display_parent_signature');
				                              
				                                //Extract administration_signature_text
				                                $administration_signature_text = infoGeneralConfig('administration_signature_text');
				                               
				                                //Extract parent_signature_text
				                                $parent_signature_text = infoGeneralConfig('parent_signature_text');
				                               
				                                 //Extract display_created_date
				                                $display_created_date = infoGeneralConfig('display_created_date');
				     
     
     $eval_date = null;
			                   $acad_year = null;
			                    


                  //find date of the current evaluation
			/*			$result=EvaluationByYear::model()->searchPeriodName($this->evaluation_id);
							if(isset($result))
							 {  $result=$result->getData();//return a list of  objects
								 foreach($result as $r)
								   { $eval_date = $r->evaluation_date;
									  $acad_year = $r->academic_year;	   
									}
							   }
 
     
     
       $data_current_period =null;	      
	   $p_name_general_average = EvaluationByYear::model()-> getPeriodNameByEvaluationDATE($eval_date);
			           
		   foreach($p_name_general_average as $p_na)
			 $data_current_period = $p_na;
		
*/

							
							
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
	
.date_right{   font-size:12px;
         text-align: right;
      
	 }
	 
.info{   font-size:12px;
      text-align: justify;
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
	     
		            $html .='<br/>  <div class="date_right">'.$header_text_date.'</div>';
				   						 
										$html .='<br/><span class="title" >'.strtoupper(strtr( Yii::t("app","Transcript of notes "), pa_daksan() ) ).'</span><br/><br/>';
									
					$html .='<span class="info" >'.$transcript_note_text.'</span><br/>';
					
										$html .='<div class="corps">    
															<table class="tb"> 
                                                                     													  
														             <tr><td class="subjectheadnote"></td>';
														             
					
			 //&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&&
		// debut of cases depending on past period	   
			                    $eval_period='';
			                    $compter_p=1;
			                     if($pastp!=null)
				                     {  
					                   foreach($pastp as $id_past_period)
					                      {
			 	                                $compter_p++;
			 	                                $eval_period = $this->searchPeriodName($id_past_period);
			 	                                
										                        
												$html .='<td class="periodheadnote" > <span style="font-size:8pt;"> <b>'.$eval_period.'</b> </span> </td>';
																		
											}
											
											
								       }
								   							      
									//fin ajout  
									$compter_p=$compter_p+1;          
											$html .=' <td class="periodheadnote" >  <b>'.Yii::t('app','MAX GRADE').'</b>  </td></tr><tr class=""><td ></td></tr>																 
																	 ';
																	
											            $i=0;
											            $k=0;
														$tot_grade=0;
											              $old_parent='';
														  
											 while(isset($dataProvider[$k][0]))
													     {
													     
                                                               $_grade=0;														  
														      if($i==2)
																 $i=0;
																if($i==0)
																	$class="color1";
																elseif($i==1)
																	$class="color2";
											             
  //$class_child="subject";																//$line=
																
if($dataProvider[$k][3]!=null)
  {  
  	  $parent_name ='';
  	  $grade_total=0;
  	  $weight_total=0;
 	  
  	  $subject_parent_name = Subjects::model()->getSubjectNameBySubjectID($dataProvider[$k][3]);
  	  $subject_parent_name = $subject_parent_name->getData();
  	  
  	  $class_child="subject";
  	  
  	    foreach($subject_parent_name as $subject_parent)
  	       $parent_name = $subject_parent;
  	  
  	    if($old_parent!= $dataProvider[$k][3])                     
  	     {  
  	     	if($parent_name!=null)
  	     	   $html .='<tr class=""  > <td class="subjectParent" colspan="'.$compter_p.'" > '.strtoupper(strtr($parent_name->subject_name, pa_daksan() )).'  </td> </tr>';
  	     	else
  	     	   $html .='<tr class=""  > <td class="subjectParent" colspan="'.$compter_p.'" > Not Found </td> </tr>';
  	     	   
   
  	         $old_parent = $dataProvider[$k][3];
  	       }
  	  
  	    
     }
  else
     {
     	   $class_child="subject_single";
     	   
        if($old_parent!= $dataProvider[$k][3])
  	     { 
           $old_parent = $dataProvider[$k][3];
           
  	     }
  	    	       	   
  	     
      }
  
 
 													$html .='<tr class="'.$class.'"> <td class="'.$class_child.'"> '.$dataProvider[$k][1].'  </td>';	     
															
													 if($pastp!=null)
														   { 
														   	  $reference=false;
														   	 
														   	 if($dataProvider[$k][4]!=NULL)
															    { $id_course = $dataProvider[$k][4];
															       $reference= true;
															    }
															  else
															    $id_course = $dataProvider[$k][0];
															    
															    $prosper_metuschael=0;
															  foreach($pastp as $id_past_period)
															    {  
																		$grades=Grades::model()->searchForReportCard($condition,$student,$id_course,$id_past_period);
																			if(isset($grades)){
														                        $r=$grades->getData();//return a list of  objects
															                 if($r!=null)
																			   { foreach($r as $grade) {
																			          // pr creer bulletin pr ceux ki ont au moins 1 note

																			        if($grade->grade_value!=null)
																						{  $temoin_has_note=true;	
									
									                                              //les colonnes notes suivant le nbre d'etape anterieur
										              
																		           $html .=' <td class="period" > '.$grade->grade_value.' </td>';
														//fin...			           
														                             
																			            }
																			           else
																			             $html .=' <td class="period" > --- </td>';
																			             
																			            if($prosper_metuschael==0) 
																							$max_grade=$max_grade+$dataProvider[$k][2];
																			             
   															                      }//fin foreach grades
																		   } 
																		elseif($reference==true)
													  	                   { 
													  	                   	  $reference=false;
													  	                   
													  	                   	    $grades=Grades::model()->searchForReportCard($condition,$student,$dataProvider[$k][0],$id_past_period);
																				if(isset($grades)){
															                        $r=$grades->getData();//return a list of  objects
																                 if($r!=null)
																				   { foreach($r as $grade) {
																				          // pr creer bulletin pr ceux ki ont au moins 1 note
	
																				        if($grade->grade_value!=null)
																							{  $temoin_has_note=true;	
										
										                                              //les colonnes notes suivant le nbre d'etape anterieur
											              
																			           $html .=' <td class="period" > '.$grade->grade_value.' </td>';
															//fin...			           
															                             
																				            }
																				           else
																				             $html .=' <td class="period" > --- </td>';
																				             
																				            if($prosper_metuschael==0) 
																								$max_grade=$max_grade+$dataProvider[$k][2];
																				             
	   															                      }//fin foreach grades
																					}
																				  else
																				  $html .=' <td class="period" > --- </td>';
																				  
																				  
														  	                   }
													  	                   	
													  	                   	}
													  	                   else
																			  $html .=' <td class="period" > --- </td>';
																			  
																			  
													  	                   } //fin isset grades
													  	                 
																		  
																		   $prosper_metuschael=1;
																	   }//fin foreach past_period
																	   
																	
																	 
																	  
                                                                   }//fin past !=null
                                                          
                                                             
                                                  
													
											$html .=' <td class="period" ><b> '.$dataProvider[$k][2].'</b></td>
											
											  
												  </tr>
												 ';              $i++;
														       						                                        
                                                            
														$k=$k+1;
														}    
	//check to include discipline grade
//check to include discipline grade

if($include_discipline==1)
  {    												
  	     $html .='<tr class="" > <td class="subject_single"> '.Yii::t('app','Discipline').'  </td>';                                
  	                                      if($pastp!=null)
														   {  
															  foreach($pastp as $id_past_period)
															    {   // To find period name in in evaluation by year 
                                                                    $period_acad_id =null;
			                                                        $result=EvaluationByYear::model()->searchPeriodName($id_past_period);
																		if(isset($result))
																		 {  $result=$result->getData();//return a list of  objects
																			foreach($result as $r)
																			  {
																				$period_exam_name= $r->name_period;
																			   $period_acad_id = $r->id;
																			   }
																		 }
			                                                               // end of code 
																															  	                   
													  	               		$grade_discipline = RecordInfraction::model()->getDisciplineGradeByExamPeriod($this->student_id, $period_acad_id);
																		  	 
																		  	if(($grade_discipline==null))
																	  	   $html .='<td class="period" > --- </td>';
																	  	 else
																	  	    $html .='<td class="period" > '.$grade_discipline.' </td>';	     
																	
																		  
													  	                   
																 }//fin foreach past_period
																
																 
																	  						  	                   
																	  
                                                              }//fin past !=null
                                                          
                                                               
                                  if(($max_grade_discipline==null)||($max_grade_discipline==0))
                                     $html .=' <td class="period" ><b> --- </b></td></tr>';
                                  else
                                     $html .=' <td class="period" ><b> '.$max_grade_discipline.'</b></td></tr>';                          	 
	}
  
 
      
	          
                                                                                     
                                              $average=0;  	$general_average=0; 
						  
						  if(($average_base==10)||($average_base==100)) 
							   { if($max_grade!=0)  
							       $average=round(($tot_grade/$max_grade)*$average_base,2);
							   }
							  else			
								$average =null;	
												
										$html .= '<tr class="subjectheadnote_white_tr"><td colspan="'.$compter_p.'" > </td></tr>';
										
										          $html .= '<tr class="sommes2"><td class="periodsommes2"><b>'.Yii::t('app','Total: ').'</b></td>';
											                    
												           if($pastp!=null)
														     {  
															    foreach($pastp as $id_past_period)
															      {
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$student);
																			if(isset($data_))
																			{
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) 
																			       {
																			 
																				     if($_data->sum!=null)
																				         $html .='<td class="periodsommes2_red"> '.$_data->sum.' </td>';
																				     else
																				         $html .='<td class="periodsommes2_red"> --- </td>';
														                            }//fin foreach _data
																				}
																				else
																			      $html .='<td class="periodsommes2_red"> --- </td>';
													  	                     } //fin isset data_
																	   }//fin foreach past period
																	  
																	    
													  	                   
																	   
                                                                   }//fin past period!=null
										                      if($max_grade==0)
															    { $max_grade_=0;
															         $k=0;
																	
														            while(isset($dataProvider[$k][0]))
																	 {$max_grade_=$max_grade_+$dataProvider[$k][2];
																	   $k++;
																	 }
															      $html .='<td class="periodsommes2_red"> <b>'.$max_grade_.' </b></td>';
																}
																else
																  { $html .='<td class="periodsommes2_red"> <b>'.$max_grade.' </b></td>';
																  }

														  $html .=' </tr>
												  
												  <tr class="sommes"><td class="periodsommes"><b>'.Yii::t('app','Average: ').'</b></td>';
														$general_average=0; 
														
													 if($pastp!=null)
														     {  
															    foreach($pastp as $id_past_period)
															      {
																		$data_=Grades::model()->getDataAverageByPeriod($acad,$id_past_period,$student);
																			if(isset($data_)){
														                        $rs=$data_->getData();//return a list of  objects
															                 if($rs!=null)
																			   { foreach($rs as $_data) 
																			       {
																			         $general_average = $general_average + $_data->average;
																				     $html .='<td class="period"> '.$_data->average.' </td>';
														                          }//fin foreach _data
																				}
																				else
																			      $html .='<td class="period"> --- </td>';
													  	                   } //fin isset data_
																	   }//fin foreach past period
																	  
																	  
													  	                   
                                                                   }//fin isset period
                                                                 
												          						     
												               $html .='<td class="period"> </td>
												  </tr>';
			
			 
				 
	
		     
		     
		     
		     							 

$html .= '</table>&nbsp;<span style="float:right; font-size:9px; color:#000000;text-shadow: 2px 2px 1px #FFF;">.</span>
            </div>';


  $html .='<span class="info" >'.$transcript_footer_text.'</span>';
  
$html .= '																	 
<div class="" style="font-size:9px; font-weight:bold;" >   
';


$html .= '<br/><br/><br/>            
<table class="signature" ><tr>';

 
 	
    	
    	//if($display_administration_signature==1)
		//{
			  $school_director_name = infoGeneralConfig('school_director_name');
			  
			 $html .= '<td class="signature1" style="width:70%;">  </td>'
                  . '<td class="signature1" style=" width:30%;">  <hr style="width:100%;" /><div style="text-align: center;">'.$transcript_signature_n_title.'</div> </td>
                      ';
			
		// }	
		
		
		
    	  
    	  
    

     
$html .= '</tr></table>';

//if($display_created_date==1)
//  $html .= ' <div style="float:right; font-weight:normal;">    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.ChangeDateFormat(date('Y-m-d')).'</div>  </div>   ';
	
	

							 
					  
	      
	  
	  //***********   END   ***************//
		
		return $html;
		
		}			
	
   //end of   htmlReportcard1


		//************************  loadSubject  ******************************/
	public function loadSubject($room_id,$level_id,$acad)
	{    
       	  

   
   
          $code= array();
          $code[null][null]= Yii::t('app','-- Select --');
		  
		 $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseByRoom($room_id,$level_id,$acad);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			            
						$k=0;
			    foreach($Course as $i){			   
					  
					  $code[$k][0]= $i->id;
					  $code[$k][1]= $i->subject_name;
					  $code[$k][2]= $i->weight;
					  $code[$k][3]= $i->subject_parent;
					  $code[$k][4]= $i->reference_id;
					  $k=$k+1;
					  
				}  
			 }	 					 
		      
			
		return $code;
         
	}

    public function searchPeriodName($evaluation)
	   {
	   	    $result=ReportCard::searchPeriodNameForReportCard($evaluation);
                if($result)
                    return $result->name_period;
                    else
                        return null;
	   }
		
	
public function loadModel()
  {
	  	 
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Persons::model()->findByPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}



protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='persons-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        

        
         
	
	
// Behavior the create Export to CSV 
public function behaviors() 
   {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','persons.csv'),
	            'csvDelimiter' => ',',
	            ));
	}
	
}




?>