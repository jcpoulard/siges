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


 
class PersonsController extends Controller
{
	
	public $layout='//layouts/column2';
	private $_model;
	
        public $idShift;
	public $section_id;
	public $idLevel;
	public $room_id;
	public $department_id;
	public $idPreviousLevel;
	
	public $job_status_id;
	public $blood_group_id;
	//public $is_active_check;
	
	public $temoin_update=0;
	public $temoin_list;
	public $old;
	
	public $tot_stud_s =0;
	public $female_s =0;
	public $male_s =0;
	
	public $messageERROR=0;// roomAffectation; 0:initial for no error; 1:error for no selected room ; 2:error for no checked lines
	public $messageSUCCESS=false;// roomAffectation
	
	   

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
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
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


	// Action pour enregistrer dans le view 
	public function actionUpdateMyInfo()
		{
			$es = new EditableSaver('Persons');
			$es->update();
		}


public function actionViewForReport()
	{    
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
		 //update "active" to 0 and reset password to "password" in Users table
		 $user=new User;
             $user = User::model()->findByAttributes(array('username'=>$username));
             $profil= Profil::model()->findByPk($user->profil)->profil_name;
        
	           $password=md5("password");
	            
	            $command0 = Yii::app()->db->createCommand();
	             $command0->update('users', array(
												'password'=>$password,'date_updated'=>date('Y-m-d'),'active'=>0,'update_by'=>Yii::app()->user->name
											), 'id=:ID', array(':ID'=>$user->id));
	             
	             	                            
			 //record data in Person_history table
			 
			    $command = Yii::app()->db->createCommand();
			    if($model->is_student==1)
			      { 
			      	$entry_date="";
			      	$leaving_date="";
			      	$modelStudInfo=StudentOtherInfo::model()->findByAttributes(array('student'=>$model->id));//$entry_date, $leaving_date
			      	if(isset($modelStudInfo)&&($modelStudInfo!=null))
			      	    {  $entry_date= $modelStudInfo->school_date_entry;
			      	      $leaving_date = $modelStudInfo->leaving_date;
			      	     }
			      	$level_name=Persons::model()->getLevel($model->id,$acad);
			      	
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
			      	
			       	     
			       	     $modelTitles = PersonsHasTitles::model()->findByAttributes(array('person_id'=>$model->id,'academic_year'=>$acad));//title_name
			       	     
			       	  if(isset($modelTitles)&&($modelTitles!=null))
			      	       {  
			      	       	   $tmwen=0;
			      	       	
			      	       	  foreach($modelTitles as $t)
			      	            {
			      	            	$title = Titles::model()->findByPk($t->titles_id);
			      	            	if($tmwen==0)
			      	            	  { $title_name = $title->title_name;
			      	            	    $tmwen=1;
			      	            	  }
			      	            	else
			      	            	  $title_name .= ', '.$title->title_name;
			      	            	
			      	             }
			      	       
			      	        }
			      	    
			      	   $modelEmpInfo = EmployeeInfo::model()->findByAttributes(array('employee'=>$model->id)); //$hire_date, $leaving_date, $job_status_name
			       	  
			       	  if(isset($modelEmpInfo)&&($modelEmpInfo!=null))
			      	    {  
			      	    	$hire_date=$modelEmpInfo->hire_date;
			      	     $leaving_date_em=$modelEmpInfo->leaving_Date;
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
								  'create_by'=>Yii::app()->user->name,
										));
			       	 
			       	   $path=array('listForReport','from'=>'emp');
			       	
			       	}
	                            
	
				 //update "active" in Persons table                  
		             $model->setAttribute('active', 0);
		             
		             $model->save();            
			    
			      $this->redirect($path);
				   		      	
		       } 
		 
	   
	    }//fen isset($_POST['apply'])
	    
	    
		$this->render('viewForReport',array(
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
		
		$model=new Persons;
                $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoomPerson=new RoomHasPerson;
		$modelDepartment= new DepartmentHasPerson;
		
		$modelStudentOtherInfo = new StudentOtherInfo;
		$modelEmployeeInfo = new EmployeeInfo;
		
		$acad=Yii::app()->session['currentId_academic_year']; 
		 	
		
					   	   
		$this->performAjaxValidation($model);

		if(isset($_POST['Persons']))
		{   
		   if((isset($_GET['isstud'])) && ($_GET['isstud']==1))
             {		  
               	  //on n'a pas presser le bouton, il fo load apropriate rooms
						  
                                        $modelShift->attributes=$_POST['Shifts'];
                                        $this->idShift=$modelShift->shift_name;
						   
                                        $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   
						   $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
						   $this->idPreviousLevel = $modelStudentOtherInfo->previous_level;
			                   
						   $model->attributes=$_POST['Persons'];
						   
						  
			       
				if(isset($_POST['create']))
				  { //on vient de presser le bouton
				       
				        $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
						$this->idPreviousLevel = $modelStudentOtherInfo->previous_level;
				            			
						//les donnees pr person
					   $model->attributes=$_POST['Persons'];
					   					   
				       $model->setAttribute('is_student',1);
					   $model->setAttribute('date_created',date('Y-m-d'));
					   $model->setAttribute('date_updated',date('Y-m-d'));
					   
					   //upload........image
					    $rnd = rand(0,9999);
						
						   $fileName =$_FILES["image"]["name"];
	                      $uploadedfile = $_FILES['image']['tmp_name'];
							//$fileName = "";
						if($fileName)  // check if uploaded file is set or not
						  {                        
						     $model->image=$fileName;
							}
						else
						  $model->image="";
					   
					   if($model->save())
                        {  //saving photo
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


												$newwidth=105;//60;
												$newheight=($height/$width)*$newwidth;
												$tmp=imagecreatetruecolor($newwidth,$newheight);


												$newwidth1=25;
												$newheight1=($height/$width)*$newwidth1;
												$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

												imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

												imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);


												$filename = Yii::app()->basePath.'/../photo-Uploads/1/'.$_FILES['image']['name'];

												



												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);

									 
									 }
							      
								    
							  }
							
							//create other info for this student
							 
						    $command = Yii::app()->db->createCommand();
						    $command->insert('student_other_info', array(
							  'student'=>$model->id,
							  'school_date_entry'=>$modelStudentOtherInfo->school_date_entry,
							  'previous_school'=>$modelStudentOtherInfo->previous_school,
							  'previous_level'=>$modelStudentOtherInfo->previous_level,
							  'create_by'=>Yii::app()->user->name,
							  'date_created'=>date('Y-m-d'),
							  'date_updated'=>date('Y-m-d'),
									));
                            
                            // create login account for this person
                            
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
                            	 
                            	  

							$username = strtolower($model->last_name).'.'.strtolower($model->first_name).$model->id;
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
					
					          $modelLevel->setAttribute('academic_year',$acad);
						      $modelLevel->setAttribute('students',$pers);
							  
						  
						if($modelLevel->save())
						   { 
					          $modelRoomPerson->attributes=$_POST['RoomHasPerson'];
					      //les donnees pr romm-has-person
					   
						 
						   $modelRoomPerson->setAttribute('academic_year',$acad);
						   $modelRoomPerson->setAttribute('students',$pers);
						   $modelRoomPerson->setAttribute('room',$modelRoomPerson->room);
						   $modelRoomPerson->setAttribute('date_created',date('Y-m-d'));
						   $modelRoomPerson->setAttribute('date_updated',date('Y-m-d'));
							  
					          
						      if($modelRoomPerson->save())	
								 {  
								 	//data pou Student_other_info
								 	$modelStudentOtherInfo->setAttribute('student',$pers);
								 	$modelStudentOtherInfo->setAttribute('date_created',date('Y-m-d'));
								 	$modelStudentOtherInfo->save();
								 	
								 	
								 	
								 	$this->redirect(array('viewForReport','id'=>$pers,'isstud'=>'1','from'=>'stud'));
								 }
							  else
							     $this->redirect(array('viewForReport','id'=>$pers,'isstud'=>'1','from'=>'stud'));
					          
						    }
						    
						
			            }
			         }
				  
		      }
			else
			  {   
			     				  
				  $model->attributes=$_POST['Persons'];
				  					   
				       	$model->setAttribute('is_student',0);												   
						$model->setAttribute('date_created',date('Y-m-d'));
					    $model->setAttribute('date_updated',date('Y-m-d'));

					   //upload........image
					    $rnd = rand(0,9999);
						
						   $fileName =$_FILES["image"]["name"];
	                      $uploadedfile = $_FILES['image']['tmp_name'];
							
						if($fileName)  // check if uploaded file is set or not
						  {                        
						     $model->image=$fileName;
							}
						else
						  $model->image="";
					   
					

					if($model->save())
					  {  if ($fileName)  // check if uploaded file is set or not
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


												$filename = Yii::app()->basePath.'/../photo-Uploads/1/'.$_FILES['image']['name'];

												



												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);

									 }
									 
							  }
							  
					     //create more info for this employee
					         $modelEmployeeInfo->attributes=$_POST['EmployeeInfo'];
							
						    $command = Yii::app()->db->createCommand();
						    $command->insert('employee_info', array(
							  'employee'=>$model->id,
							  'hire_date'=>$modelEmployeeInfo->hire_date,
							  'job_status'=>$modelEmployeeInfo->job_status,
							  'create_by'=>Yii::app()->user->name,
							  'date_created'=>date('Y-m-d'),
							  'date_updated'=>date('Y-m-d'),
									));
									
									
                            
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
	                              

							$username = strtolower($model->last_name).'.'.strtolower($model->first_name).$model->id;
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
					      	       $modelDepartment->setAttribute('academic_year',$acad);
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
								$personsHasTitles->setAttribute('academic_year',$acad);
								 							
								$personsHasTitles->save();
															
								unset($personsHasTitles);
								$personsHasTitles=new PersonsHasTitles;
															
							   }
						 }
                         
                        
						if(isset($_GET['isstud']))
						    $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>0));
						else
						    $this->redirect(array('viewForReport','id'=>$model->id,'from'=>'emp'));
		      
		             
		             }
		      
		      }
		}

		   		
		$this->render('create',array(
			'model'=>$model,
		));
	}

		
	public function actionUpdate()
	{   
		$model=new Persons;
        $modelShift= new Shifts;
		$modelSection= new Sections;
		$modelLevel= new LevelHasPerson;
		$modelRoomPerson=new RoomHasPerson;
		
		 $modelDepartment=new DepartmentHasPerson;
		 $modelEmployeeInfo = new EmployeeInfo;
 
					     
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
		
		$fileName_old="";
		
		$username="";
		
		
	 if($this->temoin_update==0)//pour l'affichage
		 { $model=$this->loadModel();
		   $fileName_old = $model->image;
		   
		   $username= strtolower($model->last_name).'.'.strtolower($model->first_name).$model->id;
		   
		 }
        		
		$this->performAjaxValidation($model);
		
		
   
		if(isset($_POST['Persons']))
		{      
			//on n'a pas presser le bouton, il fo load apropriate rooms
			        if($model->is_student==1)//si c etudiant
						{ $this->temoin_update+=1;//pour assurer l'execution de certaines lignes une seule fois
						  $modelShift->attributes=$_POST['Shifts']; 
			              $this->idShift=$modelShift->shift_name;
						   
                           $modelSection->attributes=$_POST['Sections'];
						   $this->section_id=$modelSection->section_name;
						   
						   $modelLevel->attributes=$_POST['LevelHasPerson'];
						   $this->idLevel=$modelLevel->level;
						   
						   $modelRoomPerson->attributes=$_POST['RoomHasPerson'];
						   $this->room_id=$modelRoomPerson->room;
		                 }       
						   $model->attributes=$_POST['Persons'];
						   
						  
			       
				if(isset($_POST['update']))
				    {//on vient de presser le bouton
				       
					   //les donnees pr person
					   $model->attributes=$_POST['Persons'];
					   	
					   					   
				       //$model->setAttribute('is_student',1);  //on c dja que c 1 student
					   $model->setAttribute('date_updated',date('Y-m-d'));
					         
							      $fileName =$_FILES["image"]["name"];
								  $uploadedfile = $_FILES['image']['tmp_name'];
									
								if($fileName)  // check if uploaded file is set or not
								  {  //check if we have the same image
                                     if(($fileName!=$fileName_old)&&($fileName_old!=""))
									   { $file_to_delete = Yii::app()->basePath.'/../photo-Uploads/1/'.$fileName_old;
                                          unlink($file_to_delete);	
                                        }										  
									  $model->image = $fileName;
									}
								else
								  $model->image = $fileName_old;
					  
					   if($model->save())
					    {        	  
						     if ($fileName)  // check if uploaded file is set or not
							  { //saving photo  //$uploadedFile->saveAs(Yii::app()->basePath.'/../photo-Uploads/1/'.$fileName);
							      
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


												$filename = Yii::app()->basePath.'/../photo-Uploads/1/'.$_FILES['image']['name'];

												



												imagejpeg($tmp,$filename,100);

												

												imagedestroy($src);
												imagedestroy($tmp);
												imagedestroy($tmp1);
						          
						                 }
								} 
										 
										 
				  // update login account for this person
							
							$username_up=strtolower($model->last_name).'.'.strtolower($model->first_name).$model->id;
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
					   					  				
									  
									if($model->is_student==1)//si c etudiant
									 { 
										    $modelLevel=LevelHasPerson::model()->find('students=:IdStudent AND academic_year=:acad',array(':IdStudent'=>$model->id,':acad'=>$acad));
												
														if(isset($modelLevel))//on fait un update
														   {  $modLevel=LevelHasPerson::model()->findbyPk($modelLevel->id);	
														      $level=new LevelHasPerson;
															  $level->attributes=$_POST['LevelHasPerson'];  
														     
															  $modLevel->setAttribute('level',$level->level);
															  
															 
															 if($modLevel->save())
																 { //check room
																    $modelRoomPerson=RoomHasPerson::model()->find('students=:IdStudent AND academic_year=:acad',array(':IdStudent'=>$model->id,':acad'=>$acad));
									   
																   //les donnees pr romm-has-person
																		
																		if(isset($modelRoomPerson))//on fait un update
																		  {	$modRoomPerson=RoomHasPerson::model()->findbyPk($modelRoomPerson->id);	
														                   $room=new RoomHasPerson;
															                $room->attributes=$_POST['RoomHasPerson'];		
																			 // $modelRoomPerson->setAttribute('academic_year',$acad);											  
																			$modRoomPerson->setAttribute('date_updated',date('Y-m-d'));
                                                                            $modRoomPerson->setAttribute('room',$room->room);																			
																			//$modRoomPerson->setAttribute('students',$pers);											
																																
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
																			  $modelRoomPerson->attributes=$_POST['RoomHasPerson'];	
																				$modelRoomPerson->setAttribute('academic_year',$acad);	
																				 $modelRoomPerson->setAttribute('students',$pers);												
																									
																																	
																				if($modelRoomPerson->save())
																				   { 
																					  $this->temoin_update=0;
																                  $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'1','from'=>'stud'));
																					  
																					}
																				$this->temoin_update=0;
																			  
																			}
																			
																			
																	}
																	
														  }
														else//pas de level dit aussi pas de salle
														     //on fait de nouveaux enregistrements
														  {    $modelLevel=new LevelHasPerson;
														       $modelLevel->attributes=$_POST['LevelHasPerson'];
															   
															     $modelLevel->setAttribute('academic_year',$acad);
																  $modelLevel->setAttribute('students',$pers);
																  
																  if($modelLevel->save())
																	 {  //saving room
																	     $modelRoomPerson=new RoomHasPerson;
																			  $modelRoomPerson->attributes=$_POST['RoomHasPerson'];	
																				$modelRoomPerson->setAttribute('academic_year',$acad);	
																				 $modelRoomPerson->setAttribute('students',$pers);												
																										
																																	
																				if($modelRoomPerson->save())
																				   { 
																					  $this->temoin_update=0;
																                     $this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'1','from'=>'stud'));
																					  
																					}
                                                                              $this->temoin_update=0;
																	 }
														  }
											
											
									  }
									else
									  {
									            									      
									      if(isset($_POST['Persons']['Title'])) //c pa etudiant, on va update person-has-title. o mw 1 titre a ete attribue
										       {       
												  $personsHasTitles=new PersonsHasTitles;
												   //supprimer tous les titres de la personne ds la table 'persons_has_titles'
												   PersonsHasTitles::model()->deleteAll('persons_id=:IdPerson AND academic_year=:acad',array(':IdPerson'=>$model->id,':acad'=>$acad));
 
														
													 $data= $_POST['Persons']['Title'];
													foreach ($data as $title)
													 {  
															$personsHasTitles->setAttribute('persons_id',$model->id);
															$personsHasTitles->setAttribute('titles_id',$title);
															$personsHasTitles->setAttribute('academic_year',$acad);
															
															$personsHasTitles->save();
															
															 unset($personsHasTitles);
															 $personsHasTitles=new PersonsHasTitles;
															
													   }
										         }
										         		
													
													
											$modelDepartmentEmp=DepartmentHasPerson::model()->find('employee=:ID AND academic_year=:acad',array(':ID'=>$model->id,':acad'=>$acad));
												
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
														      $modelDepartment->setAttribute('academic_year',$acad);
															  $modelDepartment->setAttribute('employee',$model->id);
															  $modelDepartment->setAttribute('date_created',date('Y-m-d'));
															  $modelDepartment->setAttribute('date_updated',date('Y-m-d'));
															 		
															 if( $modelDepartment->save())
														  	
														  	$this->redirect(array('viewForReport','id'=>$model->id,'from'=>'emp'));

														   }
														   
										     $employeeInfo=EmployeeInfo::model()->find('employee=:ID',array(':ID'=>$model->id));
												
											   if(isset($employeeInfo))//on fait un update
											     {
											     	$employeeInfo->attributes=$_POST['EmployeeInfo'];
											     	$employeeInfo->setAttribute('update_by',Yii::app()->user->name);
											     	$employeeInfo->setAttribute('date_updated',date('Y-m-d'));
											     	$employeeInfo->save();
											     }
											   else
											     {
											     //create more info for this employee
											         $modelEmployeeInfo->attributes=$_POST['EmployeeInfo'];
													 
												    $command11 = Yii::app()->db->createCommand();
												    $command11->insert('employee_info', array(
													  'employee'=>$model->id,
													  'hire_date'=>$modelEmployeeInfo->hire_date,
													  'job_status'=>$modelEmployeeInfo->job_status,
													  'create_by'=>Yii::app()->user->name,
													  'date_created'=>date('Y-m-d'),
													  'date_updated'=>date('Y-m-d'),
															)); 
														
											     }  										       
						 
									  }
						      
						            $this->temoin_update=0;
									$this->redirect(array('viewForReport','id'=>$model->id,'isstud'=>'0','from'=>$_GET['from']));

						} 
		
					}
		}
						     
		                  		

		$this->render('update',array(
			'model'=>$model,
		));
	}

	
	
		
	
	
	
	/**
         * List of inactive people in the database 
         */
public function actionListArchive()
 {
      
		  if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		$model=new Persons('searchInactive');
            $model->unsetAttributes();
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
			
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
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
	  if(Yii::app()->request->isPostRequest)
		{
			$person=new Persons;
			
			$person=$this->loadModel();
            $username=strtolower($person->last_name).'.'.strtolower($person->first_name).$person->id;
                        
            $this->loadModel()->delete();
            
             // delete login account for this person
				$user=new User;
                $user = User::model()->findByAttribute('username',$username);

                 $user->delete();
                 
            
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
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
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
       	  $acad=Yii::app()->session['currentId_academic_year']; 
		 
		  $code= array();
          $code[null]= null;
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
	
	
	
	//************************  loadPreviousLevel  ******************************/
	public function loadPreviousLevel($idLevel)
	{    
       	  $acad=Yii::app()->session['currentId_academic_year']; 
		 
		  $code= array();
          $code[null]= null;
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
	public function loadLevel()
	{    
	    $modelLevel= new Levels();
		
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll();
            $code[null]= null;
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}
   //************************  getLevel($id) ******************************/
   public function getLevel($id)
	{
		$level = new Levels;
		
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
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
	   
	   $acad=Yii::app()->session['currentId_academic_year']; 
		 
					
			 if(isset($_POST['Persons']))
		        $modelLevel->attributes=$_POST['Levels'];
		           
				   $level_id=$modelLevel->level_name;
	               
				   return $level_id;
	}
	
//xxxxxxxxxxxxxxx  ROOM xxxxxxxxxxxxxxxxxxx
	
	//************************  changeRoom ******************************/
	public function changeRoom()
	{    $modelLevel= new Levels();
	
	     $acad=Yii::app()->session['currentId_academic_year']; 
		 
           $code= array();
		   
		  if(isset($_POST['Persons']['Levels']))
		        $idLevel->attributes=$_POST['Levels'];
		           
				   
         
	}
	
	//************************  loadRoomByIdShiftSectionLevel ******************************/
	public function loadRoomByIdShiftSectionLevel($shift,$section,$idLevel)
	{    
	      $modelRoom= new Rooms();
		  
		  $acad=Yii::app()->session['currentId_academic_year']; 
		 
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('select'=>'id,room_name',
                                     'condition'=>'shift=:idShift AND section=:idSection AND level=:levelID ',
                                     'params'=>array(':idShift'=>$shift,':idSection'=>$section,':levelID'=>$idLevel),
                               ));
            $code[null]= null;
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
            $code[null]= null;
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
	   
	   $acad=Yii::app()->session['currentId_academic_year']; 
		 
					
			 if(isset($_POST['Persons']))
		        $modelRoom->attributes=$_POST['RoomHasPerson'];
		           
				   $this->room_id=$modelRoom->room;
	               
				   return $this->room_id;
	}
		 

	 //xxxxxxxxxxxxxxx  SHIFT xxxxxxxxxxxxxxxxxxx
	//************************  loadShift ******************************/
	public function loadShift()
	{    $modelShift= new Shifts();
	
	     $acad=Yii::app()->session['currentId_academic_year']; 
		 
           $code= array();
		   
		  $modelPersonShift=$modelShift->findAll();
            $code[null]= null;
		    foreach($modelPersonShift as $shift){
			    $code[$shift->id]= $shift->shift_name;
		           
		      }
		   
		return $code;
         
	}
   //************************  getShift($id) ******************************/
   public function getShift($id)
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
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
	   
	   $acad=Yii::app()->session['currentId_academic_year']; 
		 
					
			 if(isset($_POST['Persons']))
		        $modelShift->attributes=$_POST['Shifts'];
		           
				   $shift_id=$modelShift->shift_name;
	               
				   return $shift_id;
	}
	
	
	
	
	        //xxxxxxxxxxxxxxx  SECTION  xxxxxxxxxxxxxxxxxxx
	
	//************************  loadSectionByIdShift ******************************/
	public function loadSectionByIdShift($idShift)
	{     
	      $acad=Yii::app()->session['currentId_academic_year']; 
		 
		 
		  $code= array();
          $code[null]= null;
	      $modelRoom= new Rooms();
	      $section_id=$modelRoom->findAll(array('select'=>'section',
                                     'condition'=>'shift=:shiftID',
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
	
	    $acad=Yii::app()->session['currentId_academic_year']; 
		 
		 
           $code= array();
		   
		  $modelPersonSection=$modelSection->findAll();
            $code[null]= null;
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
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
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
		$idSection = $modelRoom->find(array('select'=>'section',
                                     'condition'=>'id=:roomID',
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
	   
	   $acad=Yii::app()->session['currentId_academic_year']; 
		 
					
			 if(isset($_POST['Persons']))
		        $modelSection->attributes=$_POST['Sections'];
		           
				   $this->section_id=$modelSection->section_name;
	               
				   return $this->section_id;
	}
	
	
	

//xxxxxxxxxxxxxxx  DEPARTMENT IN SCHOOL xxxxxxxxxxxxxxxxxxx
	
	//************************  loadDepartment ******************************/
	public function loadDepartment()
	{    $modelDepartment= new DepartmentInSchool;
	     
		 
		 
           $code= array();
		   
		  $modelPersonDepartment=$modelDepartment->findAll();
            $code[null]= null;
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
	   
	   $acad=Yii::app()->session['currentId_academic_year']; 
		 
					
			 if(isset($_POST['Persons']))
		        $modelDepartment->attributes=$_POST['DepartmentHasPerson'];
		           
				   $this->department_id=$modelDepartment->department_id;
	               
				   return $this->department_id;
	}
		
	
	
//xxxxxxxxxxxxxxx  EMPLOYEE INFO  xxxxxxxxxxxxxxxxxxx
	
	
		//************************  loadJobStatus ******************************/
	public function loadJobStatus()
	{    $modelJobStatus= new JobStatus();
	
	    $acad=Yii::app()->session['currentId_academic_year']; 
		 
		 
           $code= array();
		   
		  $modelPersonJobStatus=$modelJobStatus->findAll();
            $code[null]= null;
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
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
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
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
		 $emp_info = new EmployeeInfo;
		 $model=EmployeeInfo::model()->findByattributes(array('employee'=>$id));
		 
		
				return $model;
		
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
		
		
		$acad=Yii::app()->session['currentId_academic_year']; 
		 					  
		
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
			
	   
					
			
			if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			     
			        $sh=null;
					$se=null;
	                $le=null;
	                $ro=null;
					
					 $this->idShift=Yii::app()->session['Shifts'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['Sections'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	                $this->idLevel=Yii::app()->session['LevelHasPerson'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
					  
	                $this->room_id=Yii::app()->session['RoomHasPerson'];
					if($this->room_id!=null)
					  $ro=$this->room_id;
					  
	                      
			$model=new Persons('searchStudents($sh,$se,$le,$ro,$acad)');
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
         
		 // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List Students by Room: ')), null,false);
			
			$this->exportCSV($model->searchStudents($sh,$se,$le,$ro,$acad) , array(
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
		
		$acad=Yii::app()->session['currentId_academic_year']; 
		 		
		
		     if(isset($_POST['LevelHasPerson']))
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
						   $this->idLevel=$modelLevel->level;
						    unset(Yii::app()->session['LevelHasPerson']);
	                      Yii::app()->session['LevelHasPerson'] = $this->idLevel;
						  
						 					
	                 }
                 else
                     {
                         $this->idShift=null;
							$this->section_id=null;
							$this->idLevel=null;
							$this->room_id=null;
							
							$this->messageERROR=0;
							$this->messageSUCCESS=false;
							
					 }						 
			
	   
					
			
			
		if(isset($_POST['execute']))
		  { //on vient de presser le bouton
				  $modelRoom->attributes=$_POST['Rooms'];
				  $this->room_id=$modelRoom->room_name;
						
						 
			//reccuperer les lignes selectionnees(checked lines)
			if($this->room_id!=null) 
			  {			 
			        if(isset($_POST['chk']))			  
				      {	   
				        
						           
						   foreach($_POST['chk'] as $pers) 
							{	  $modelRoomPerson=new RoomHasPerson;								
						          $modelRoomPerson->setAttribute('room',$this->room_id);
						          $modelRoomPerson->setAttribute('students',$pers);
								  $modelRoomPerson->setAttribute('academic_year',$acad);
								  $modelRoomPerson->setAttribute('date_created',date('Y-m-d'));
								  $modelRoomPerson->setAttribute('date_updated',date('Y-m-d'));
						                  
								//verifye si done sa yo nan baz la deja
								$is_there= RoomHasPerson::model()->checkData($this->room_id, $pers, $acad);
								$here=$is_there->getData();
								
							 if((!isset($here))||($here==null))
							  {
								if($modelRoomPerson->save())
								    { 
								     echo '<br/><br/><br/><br/><br/><br/><br/><br/>'.$this->room_id.'OOOOOOOOOOOOO'.$pers;
 
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
			
			
			
			if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			     
			        $sh=null;
					$se=null;
	                $le=null;
	           
					
					 $this->idShift=Yii::app()->session['Shifts'];
					 if($this->idShift!=null)
					  $sh=$this->idShift;
					  
					$this->section_id=Yii::app()->session['Sections'];
					if($this->section_id!=null)
					  $se=$this->section_id;
					  
	                $this->idLevel=Yii::app()->session['LevelHasPerson'];
					if($this->idLevel!=null)
					  $le=$this->idLevel;
					  
	         	  
	                      
			$model=new Persons('searchStudentsByLevel($le,$acad)');
		if(isset($_GET['Persons']))
			$model->attributes=$_GET['Persons'];
         
		 
			   $this->render('roomAffectation',array(
			  'model'=>$model,
		  ));
		
	}
	
		
public function actionListForReport()
	{       
	     $model=new Persons;
		 
		 $acad=Yii::app()->session['currentId_academic_year']; 
		 
		       		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
	
	 if(isset($_GET['isstud']))
		 {
			 if($_GET['isstud']==1)
				 {
					 $dataProvider_s= Persons::model()->searchStudents_($acad);
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
			       $model=new Persons('searchStudents_('.$acad.')');
					
					 if(isset($_GET['Persons']))
						$model->attributes=$_GET['Persons']; 
						
				}
			 elseif($_GET['isstud']==0)
				 {
					if (isset($_GET['pageSize'])) {
					Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
					unset($_GET['pageSize']);
					}
					$model=new Persons('searchTeacher('.$acad.')');
					if(isset($_GET['Persons']))
						$model->attributes=$_GET['Persons']; 
                                        // Here to export to CSV 
					if($this->isExportRequest()){
						$this->exportCSV(array(Yii::t('app','List teacher: ')), null,false);
						
						$this->exportCSV($model->searchTeacher() , array(
								'last_name',
								'first_name',
								'birthday',
								'')); 
						}
				 
				 }
			
			}
		else
		   {
		     if (isset($_GET['pageSize'])) {
		       Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		        unset($_GET['pageSize']);
			  }
			$model=new Persons('searchEmployee');
				if(isset($_GET['Persons']))
					$model->attributes=$_GET['Persons']; 
		   }
				
			   $this->render('listForReport',array(
			  'model'=>$model,
		  ));
		
	}
	
	

	
	public function actionExTeachers()
	{    
	     $model=new Persons;
       		
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
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
	
	
	
	
	
	
	public function loadModel()
	{
	   $acad=Yii::app()->session['currentId_academic_year']; 
		 
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
	public function behaviors() {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','persons.csv'),
	            'csvDelimiter' => ',',
	            ));
	}
	
}
