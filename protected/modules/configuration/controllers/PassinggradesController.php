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



class PassinggradesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	
	public $level_or_course;
	public $course_id;
	public $weight;

        public $alert_ = null;

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

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
public function actionCreate()
	{
		$model=new PassingGrades;
		$modelCourse = new Courses;
		
		$modelAcademicPeriod = new AcademicPeriods; 

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['PassingGrades']))
		{
				
			

 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

			$model->attributes=$_POST['PassingGrades'];
			
			
			$this->level_or_course = $model->level_or_course;
			
			if($this->level_or_course==1)
			  {
				 if(isset($_POST['Courses']))
			       { 	
			       	 $modelCourse->attributes=$_POST['Courses'];
				  	 $this->course_id = $modelCourse->subject;
				  	 
				  	     $result = Courses::model()->getWeight($this->course_id);
						    $result =$result->getData();
						    foreach($result as $r)
						     {  
						     	$model->setAttribute('weight', $r->weight);
						        $this->weight = $r->weight;
						      }
						                      
			        }
			  	
			  	}
			  	
			
			if(isset($_POST['create']))
             {
				if($this->level_or_course==0)
			      {	
					if($model->level=='')
				      { 
			                $message =  Yii::t('app','Level').' '.Yii::t('app','cannot be empty.');
			                $params1 = array();
				        $model->addError('level', strtr($message, $params1));
	                   }
	                 else
	                   {
							$model->setAttribute('level_or_course',0 );
							$model->setAttribute('academic_period',$acad_sess);
							$model->setAttribute('date_created',date('Y-m-d'));
						
						  if($model->save())
							{
								$prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_passingGrades = PassingGrades::model()->search($acad_sess);
 											$all_passingGrades = $all_passingGrades->getData();
 											foreach($all_passingGrades as $pg)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   }
								     	 if($prosper_marc_hilaire_poulard==1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'passing_grade'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	   	} 
								     	   	
								     	   	
								     	$this->redirect(array('index'));
								
							 }
						
	                   }
                    
                    }
				 elseif($this->level_or_course==1)
			        {
				       if($this->course_id!='')
				        {
				        	if($model->minimum_passing > $this->weight)
			                 {  
			                 	$message = Yii::t('app','Passing grade cannot be greatter than weight course.');
                                                $params1 = array();
				                $model->addError('minimum_passing', strtr($message, $params1));
	                          }
				           else
				            {
					        	$model->setAttribute('level',NULL );
					        	$model->setAttribute('course',$this->course_id );
					        	$model->setAttribute('level_or_course',1 );
					        	$model->setAttribute('academic_period',$acad_sess);
							$model->setAttribute('date_created',date('Y-m-d'));
							    
							    if($model->save())
							      {
							      	 $prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_passingGrades = PassingGrades::model()->search($acad_sess);
 											$all_passingGrades = $all_passingGrades->getData();
 											foreach($all_passingGrades as $pg)
 											  {
 											  	 $prosper_marc_hilaire_poulard ++;
 											   }
								     	 if($prosper_marc_hilaire_poulard==1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'passing_grade'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	   	} 
								     	   	
								     	 
								     	 $this->redirect(array('index'));
							      	 
							       }
							      
							 }
				         }
				       else
				         { 
				         	    $message = Yii::t('app','Subjects').' '.Yii::t('app','cannot be empty.');
                                                    $params1 = array();
                                                    $model->addError('subject', strtr($message, $params1));
                           }
				         	
			        	
			          }
			        	
			        	
					
			        	
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
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$modelCourse = new Courses;
		$old_level='';
		$old_course='';
		
		$model=$this->loadModel($id);

		if($model->level_or_course==0)
		   {	
                        $this->level_or_course=0;
		         
		         $old_level=$model->level;
		         $old_course='';
		   }
		elseif($model->level_or_course==1)
		   {	
                        $this->level_or_course=1;
		        $this->course_id=$model->course;
		        
		        $old_course=$model->course;
		        $old_level='';
		        
		        
                                        $result = Courses::model()->getWeight($this->course_id);
					 $result =$result->getData();
					   foreach($result as $r)
						{  
						   $model->setAttribute('weight', $r->weight);
						   $this->weight = $r->weight;
						 }

		    }
		
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['PassingGrades']))
		{
			$model->attributes=$_POST['PassingGrades'];
			
			   $this->level_or_course = $model->level_or_course;
			
			if($this->level_or_course==1)
			  {
				 if(isset($_POST['Courses']))
			       { 	
                                        $modelCourse->attributes=$_POST['Courses'];
				  	 $this->course_id = $modelCourse->subject;
				  	 
				  	 
				  	     $result = Courses::model()->getWeight($this->course_id);
						    $result =$result->getData();
						    foreach($result as $r)
						     {  
						     	$model->setAttribute('weight', $r->weight);
						        $this->weight = $r->weight;
						      }

			        }
			  	
			  	}
			  	
			
			if(isset($_POST['update']))
             {
				if($this->level_or_course==0)
			      {	
					if($model->level=='')
				      { 
                                            $message =  Yii::t('app','Level').' '.Yii::t('app','cannot be empty.');
                                            $params1 = array();
				            $model->addError('level', strtr($message, $params1));
	                   }
	                 else
	                   {
							$model->setAttribute('level_or_course',0 );
							$model->setAttribute('date_created',date('Y-m-d'));
						
						  if($model->save())
							$this->redirect(array('index'));
						
	                   }
                    
                    }
				 elseif($this->level_or_course==1)
			        {
				       if($this->course_id!='')
				        {
				        	if($model->minimum_passing > $this->weight)
			                 {  
			                 	$message = Yii::t('app','Passing grade cannot be greatter than weight course.');
                                                $params1 = array();
				                $model->addError('minimum_passing', strtr($message, $params1));
	                          }
				           else
				            {
					        	$model->setAttribute('level',NULL );
					        	$model->setAttribute('course',$this->course_id );
					        	$model->setAttribute('level_or_course',1 );
					        	$model->setAttribute('date_created',date('Y-m-d'));
							    
							    if($model->save())
							       $this->redirect(array('index'));
							 }
				         }
				       else
				         { 
				         	    $message = Yii::t('app','Subjects').' '.Yii::t('app','cannot be empty.');
                                                $params1 = array();
				                $model->addError('subject', strtr($message, $params1));
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




//************************  loadLevelOrCourse ******************************/
public function loadLevelOrCourse()
	{   
           $code= array();
		   
		       $code[0]=Yii::t('app','Levels');
		       $code[1]=Yii::t('app','Courses');
		   
		return $code;
         
	   }




	//************************  loadSubjectDeBase($acad)  ******************************/
public function loadSubjectDeBase($acad)
	{    
       	  $code= array();
          $code[null]= Yii::t('app','-- Select --');
		  
		  $modelCourse= new Courses();
	       $result=$modelCourse->searchCourseDeBase($acad);
			
			 if(isset($result))
			  {  $Course=$result->getData();//return a list of Course objects
			    foreach($Course as $i){			   
					
                                $code[$i->id] = $i->subject_name.' ['.$i->teacher_name.'] ';//.$i->name_period;
				}  
			 }	 					 
		      
			
		return $code;
         
	}
	

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		try {
   			 $this->loadModel($id)->delete();
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
	 * Manages all models.
	 */
	public function actionIndex()
                
	{
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 

                if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                unset($_GET['pageSize']);
                }
            $model=new PassingGrades('searchLevels');
            $model->unsetAttributes();
            
            $modelC=new PassingGrades('searchCourses');
            $modelC->unsetAttributes();

           
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PassingGrades']))
			$model->attributes=$_GET['PassingGrades'];
			
		$modelC->unsetAttributes();  // clear any default values
		if(isset($_GET['PassingGrades']))
			$modelC->attributes=$_GET['PassingGrades'];
			
	
                // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of levels: ')), null,false);
			
			             $this->exportCSV($model->search($acad_sess), array(
				'level0.level_name',
				'academicPeriod.name_period',
                                'minimum_passing',
				)); 
		}

		$this->render('index',array(
			'model'=>$model,
			'modelC'=>$modelC,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PassingGrades the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PassingGrades::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PassingGrades $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='passing-grades-form')
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
	           'filename' => Yii::t('app','passinggrades.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
}
