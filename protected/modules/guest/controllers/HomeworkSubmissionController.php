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



class HomeworkSubmissionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $_model;
	
	public $back_url='';
	
	public $homework_id;
	public $student_id;

	public $document;
	public $message_UpdateLimitDateSubmission=false;
	
	public $message_room_id=false;
        public $message_course_id=false;
        public $messageSize=false;
	public $success=false;
	public $path;
        public $messageExtension;
	
	
		public $pa_daksan= array('Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E', 'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U', 'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c', 'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o', 'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y' );
		
		 public $ext_allowed_by_viewer = array( "odt", "pdf", "ods", "fods", "fodt", "odb", "odi", "oos", "oot", "otf", "otg", "oth", "oti", "otp", "ots", "sdp", "sds", "sdv", "sfs", "ods", "smf", "sms", "std", "stw", "sxg", "sxm", "vor", "sda", "sdc", "sdd", "odf", "odg", "ott", "pub", "rtf", "sdw", "sxc", "sxw", "bau", "dump", "fodg", "fodp", "odm", "odp", "otc", "psw", "sdb", "sgl", "smd", "stc", "sti", "svm", "sxd", "uot" );

	  
	   public $ext_allowed  = array( "odt", "pdf", "ods", "fods", "fodt", "odb", "odi", "oos", "oot", "otf", "otg", "oth", "oti", "otp","ots", "sdp", "sds", "sdv", "sfs", "ods", "smf", "sms", "std", "stw", "sxg", "sxm", "vor", "sda", "sdc", "sdd", "doc", "odf", "odg", "ott", "pub", "rtf", "sdw", "sxc", "sxw", "bau", "dump", "fodg", "fodp", "odm", "odp", "otc", "psw", "sdb", "sgl", "smd", "stc", "sti", "svm", "sxd", "uot", "docx", "docm", "dotx", "dotm", "docb", "xls", "xlt", "xlm", "xlsx", "xlsm", "xltx", "xltm", "xlsb", "xla", "xlam", "xll", "xlw", "ppt", "pot", "pps", "pptx", "pptm", "potx", "potm", "ppam", "ppsx", "ppsm", "sldx", "sldm", "accdb", "accde", "accdt", "accdr", "pub" );


 



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
		$model=new HomeworkSubmission;

		// Uncomment the following line if AJAX validation is needed
	   $this->performAjaxValidation($model);
	   
	   
	   $submission='homework_submission';
	   
	   $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $this->student_id = $p->id;

     	     
	  if(isset($_POST['HomeworkSubmission']))
		{
			
	        $model->attributes=$_POST['HomeworkSubmission'];
			
		 
		
		
		   if($_POST['create'])
		     {
		     	     //on vient de presser le bouton
						 //reccuperer les lignes selectionnees()
			$model->setAttribute('student',$this->student_id);
			$model->setAttribute('date_submission',date('Y-m-d'));
			
			
			
			
					$this->success=false;
					$temwen=false;
					
					//a random number to add to file_name
					 $rnd = rand(0,9999);
	            
					 
					 $path_ = $this->getPath($this->student_id);
					 
					 $path= explode("/",substr($path_, 0));
					 
					$room = $path[4];
				    $level = $path[3];
				    $section = $path[2];
				    $shift = $path[1];
				    
				    $name_acad = $path[0];           
					 
					
					                                   
				 if (!file_exists(Yii::app()->basePath.'/../'.$submission))  //si submission n'existe pas, on le cree
														 mkdir(Yii::app()->basePath.'/../'.$submission);
													if(!file_exists(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad))    //submission existe.si acadPeriod n'existe pas, on le cree 
														 mkdir(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad);
													if(!file_exists(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad.'/'.$shift))    //acadPeriod existe.si shiftName n'existe pas, on le cree
														 mkdir(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad.'/'.$shift);
													if(!file_exists(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad.'/'.$shift.'/'.$section))    //shiftName existe.si sectionName n'existe pas, on le cree
														 mkdir(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad.'/'.$shift.'/'.$section);
													  
				                                    if(!file_exists(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level))    //sectionName existe.si levelName n'existe pas, on le cree
														 mkdir(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level); 
														 
													                                       	
													if(!file_exists(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room))    //levelName existe.si roomName n'existe pas, on le cree
														 mkdir(Yii::app()->basePath . '/../'.$submission.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room);
													
													
				$path_new = $submission.'/'.$name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room;	
			
		 if($model->homework_id !='')
			 {	
				$modelH=Homework::model()->findByPk($model->homework_id);
				
				  				   
				$homework_name_ =$modelH->attachment_ref;
				
				 $homework_name= explode("_",substr($homework_name_, 0));
				 $target ='';
					$this->messageSize=false;
					$this->messageExtension=false;	  
						  
						if($_FILES['document']['name']!='')				  
					     {    $info = pathinfo($_FILES['document']['name']);
								  if($info)  // check if uploaded file is set or not
								    {                        
								         //$info = pathinfo($_FILES['document']['name']);
		                                    $ext = $info['extension']; // get the extension of the file
		 
										
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
													
													
													 $explode_name= explode(".",substr($_FILES['document']['name'], 0));
                                                      
                                                      $newname=$explode_name[0].'_'.$rnd.'.'.$ext;
													
													  $model->setAttribute('attachment_ref',$newname);
			
			                                        $target =  Yii::app()->basePath.'/../'.$path_new.'/'.$newname;
			                                         
			                                         
			                                         $this->path=Yii::app()->basePath.'/../'.$path_new.'/';	  
											   }
											   
								         }
								       else
								         {
			                                $this->messageExtension=true;
											$mesage=Yii::t('app','This document is not a valid one. Use one of these extensions: "odt", "pdf", "doc", "ods", "fods", "fodt", "odb", "odi", "oos", "oot", "otf", "otg", "oth", "oti", "otp", "ots", "sdp", "sds", "sdv", "sfs", "ods", "smf", "sms", "std", "stw", "sxg", "sxm", "vor", "sda", "sdc", "sdd", "odf", "odg", "ott", "pub", "rtf", "sdw", "sxc", "sxw"< "bau", "dump", "fodg", "fodp", "odm", "odp", "otc", "psw", "sdb", "sgl", "smd", "stc", "sti", "svm", "sxd", "uot".');
											
										 }
																				 
								         
		
									}
						       }
							 else
							     $model->attachment_ref="";
		               }
		                   
				 		  
						if(!$this->messageSize)
						 {    
							    	   
										   if($model->save())
			                                 {  
			                                 	 move_uploaded_file( $_FILES['document']['tmp_name'], $target);
			                                 	 $this->success=true;
			                                 	
			                                 	 
			                                 	 $this->redirect(array('/guest/homeworkSubmission/index'));
			                                 	 

									         }
			                     
						    }
						    else
						      {	$this->messageSize=true; 		
						       
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
		$acad=Yii::app()->session['currentId_academic_year']; 
		$acad_name=Yii::app()->session['currentName_academic_year'];
		
		
		$model= new HomeworkSubmission;
		
		$submission='homework_submission';
		$path='';
		$document='';
		


		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel()->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		
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
				   { $this->student_id=0;
			           if(Yii::app()->session['child']!=null)
						  $this->student_id=Yii::app()->session['child'];
			          
				   }
		        }
		         	    
		 if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			} 
			
		$model=new HomeworkSubmission('searchSubmitedHomeworkByStudentId('.$this->student_id.','.$acad.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['HomeworkSubmission']))
			$model->attributes=$_GET['HomeworkSubmission'];
                
                // Here to export to CSV 
                if($this->isExportRequest()){
                $this->exportCSV(array(Yii::t('app','List of submited homeworks: ')), null,false);
                
                $this->exportCSV($model->searchSubmitedHomeworkByStudentId($this->student_id,$acad), array(
                'student0.last_name'." ".'student0.first_name',
                'attachment_ref',
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
		$model=new HomeworkSubmission('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['HomeworkSubmission']))
			$model->attributes=$_GET['HomeworkSubmission'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	

//************************  getUserInfo ******************************/		
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



	//************************  loadHomeworkByRoomId ******************************/
	public function loadHomeworkByRoomId($room_id,$acad)
	{    $modelH= new Homework();
           $code= array();
		   
		   $date_ = date('Y-m-d');
		    
               
		  $modelHomework=$modelH->findAll(array('alias'=>'hw','select'=>'hw.id,hw.title',
		                             'join'=>'left join courses c on(c.id = hw.course)',
                                    'condition'=>'c.room='.$room_id.' AND hw.academic_year='.$acad.' AND hw.limit_date_submission >= \''.$date_.'\'',
                                   
                               ));
                               
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($modelHomework))
			 {  
			    foreach($modelHomework as $hom){
			        $code[$hom->id]= $hom->title;
		           
		           }
			 }
		   
		return $code;
         
	}
	
	

public function getPath($person_id)
	{    
       	  $acad=Yii::app()->session['currentId_academic_year'];
       	  
       	  $code= array();
          	
          	$room_id = $this->getRoomByStudentId($person_id);
          	
          	$acad_name_ = $this->getAcademicPeriodName($acad,$room_id->id)->name_period;
          	
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
            
            $room = strtr( $room_name_, $this->pa_daksan );
			$level = strtr( $this->getLevel($level_), $this->pa_daksan );
			$section = strtr( $this->getSection($section_), $this->pa_daksan );
			$shift = strtr( $this->getShift($shift_), $this->pa_daksan );
			
			$name_acad = strtr( $acad_name_, $this->pa_daksan );
						    
						      	
          	
          	$path = $name_acad.'/'.$shift.'/'.$section.'/'.$level.'/'.$room;
		
		return $path;
         
	}
	

		
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return HomeworkSubmission the loaded model
	 * @throws CHttpException
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=HomeworkSubmission::model()->findByPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
		
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
                                     'condition'=>'r.shift=:shiftID AND r.section=:sectionID AND rh.academic_year=:acad',
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
	{    $modelRoom= new Rooms();
           $code= array();
		   
		  $modelPersonRoom=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'r.id,room_name',
                                     'join'=>'left join room_has_person rh on(rh.room= r.id) left join courses c on(rh.room=c.room)',
									 'condition'=>'c.teacher='.$id_teacher.' AND rh.academic_year='.$acad,
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
									 'select'=>'r.id,room_name',
                                     'join'=>'left join room_has_person rh on(rh.room= r.id)',
									 'condition'=>'shift=:idShift AND section=:idSection AND level=:levelID AND rh.academic_year=:acad',
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
		$acad=Yii::app()->session['currentId_academic_year'];
		$model=new RoomHasPerson;
		$idRoom = $model->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id,':acad'=>$acad),
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
		//$section = new Sections;
		$section=Sections::model()->findByPk($id);
        
			
		       if(isset($section))
				return $section->section_name;
		
	}
	
	//************************  getSectionByStudentId($id) ******************************/
	public function getSectionByStudentId($id)
	{
		$idRoom= $this->getRoomByStudentId($id);
		
		
		$model=new Rooms;
		$idShift = $model->find(array('select'=>'section',
                                     'condition'=>'id=:roomID',
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
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';
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
					  $code[$i->id]= $i->name_period.' / '.$i->evaluation_date;//$i->evaluation_name.' ('.$i->name_period.'/'.$i->evaluation_date.')';
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
					  $code[$i->id]= $i->name_period.' / '.$i->evaluation_date;//$i->evaluation_name.' ('.$i->name_period.'/'.$i->evaluation_date.')';
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
			    { 
                                    $evalId=$eYear->evaluation;
				    $result=Evaluations::model()->findByPk($evalId);
					
					
				 }
				return $result->evaluation_name;
	  
	  }
	

	
	
		//************************  getHomeworkInfo  ******************************/
	public function getHomeworkInfo($id)
	  {
	     $hom=new Homework();
		    
		    
        $result=$hom->findByPk($id);
			
		       if($result!=null)
			      return $result;
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

	


	
	       // Export to CSV 
    public function behaviors() {
       return array(
           'exportableGrid' => array(
               'class' => 'application.components.ExportableGridBehavior',
               'filename' => Yii::t('app','homework_submission.csv'),
               'csvDelimiter' => ',',
               ));
    }



	/**
	 * Performs the AJAX validation.
	 * @param HomeworkSubmission $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='homework-submission-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        //************************  loadChildren($userName) ******************************/
	public function loadChildren($userName)
	{     
	      $acad=Yii::app()->session['currentId_academic_year']; 
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
        
}
