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

?>
<?php

class MenfpGradesController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url ;
	
	public $part ='parlis';
	public $idLevel;
	public $student_id ;
	public $total_weight=0;
	
	public $gen_not=false;
	
	public $message_GradeHigherWeight=false;

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
	{      //!enpotant! $id se id elev la
	     
	    $model = new MenfpGrades;
	     
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MenfpGrades;
		$modelDecision= new MenfpDecision;
		
			$acad_sess = acad_sess();
			
			$this->message_GradeHigherWeight=false;
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MenfpGrades']))
		{
			$model->attributes=$_POST['MenfpGrades'];
               
               
			$this->student_id = $model->student;
			
			if(isset($this->student_id)&&($this->student_id!=""))
               {  $this->idLevel= getLevelByStudentId($this->student_id, $acad_sess)->id;
			      
			      $dataProvider=MenfpGrades::model()->searchGradesForStudent($this->student_id,$this->idLevel,$acad_sess);
	        
			        if(($dataProvider->getData()==null))
					   $this->gen_not=false;
					else
			   	      $this->gen_not=true;
               }
			
		  if(isset($_POST['create']))
			{ //on vient de presser le bouton
						 //reccuperer les lignes selectionnees()
						 
				$modelDecision->attributes=$_POST['MenfpDecision'];
				
				$total_grade=$_POST['total_grade']; 	
				$average = $_POST['average'];
						 
			    //$this->success=false;
					$temwen=false;
					$total_weight=0;
					
			    
			   if($this->gen_not==false)
			     {
							   $no_stud_has_grade=true;
						 
						if( ($total_grade!='')&&($modelDecision->mention!='') )
						  {	
						  	
						  	   
							  foreach($_POST['id_subj'] as $id)
		                        {   	   
								   if(isset($_POST['id_subj'][$id])&&($_POST['id_subj'][$id]!=''))
								     $no_stud_has_grade=false;
									
								}
					        
						     if(!$no_stud_has_grade) 
								{  foreach($_POST['id_subj'] as $id)
			                        {   	   
									           
									           if(isset($_POST['grades'][$id]))
									                $grade=$_POST['grades'][$id];
												else
													$grade=NULL;
													
										//check if grade is higher than the course weight	
											if($grade > $_POST['id_weight'][$id])  	   
												{  
													$grade=NULL;
													$this->message_GradeHigherWeight=true;
												}
										       
								              	  
												   $model->setAttribute('student',$this->student_id);
												   $model->setAttribute('menfp_exam',$id);
												   $model->setAttribute('grade',$grade);
												   $model->setAttribute('date_created',date('Y-m-d'));
												   $model->setAttribute('create_by',Yii::app()->user->name);
												   
												   if($model->save())
					                                 {  
													   $model->unSetAttributes();
													   $model= new MenfpGrades;
													   
													   $temwen=true;
													 }
											         
											 	   
				                        
									}
									
									//decision pou elev la
									
									
									 //$average = round( ($model->total_grade/$total_weight) ,2);
									 
									$modelDecision->setAttribute('student',$this->student_id);
									$modelDecision->setAttribute('total_grade',$total_grade);
									$modelDecision->setAttribute('average',$average);
									$modelDecision->setAttribute('academic_year',$acad_sess);
									 
									 if($modelDecision->save())
									   {
									   	 
									   	   if($this->message_GradeHigherWeight==true)
											  {
											  	    $message = Yii::t('app','Grades GREATER than COURSE WEIGHT are ignored.');
				                                      Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
											  	}

									   	 
									   	 $this->redirect(array('index'));
									   	}
									
									
									
																		
						        }
						      else //message vous n'avez entre aucune note
								{
									$message = Yii::t('app','You did not insert any grades.');
		                              Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
									
									}
								
						 }
						 else
						   {
						   	   $message = Yii::t('app','Total grade and mention can\'t be null.');
		                              Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
						   	}
			       }
			     elseif($this->gen_not==true)
			       {
			       	    $no_stud_has_grade=true;
			       	    $this->message_GradeHigherWeight=false;
						 
						if( ($total_grade!='')&&($modelDecision->mention!='') )
						  {	
						  	
						  	   
							  foreach($_POST['id_subj'] as $id)
		                        {   	   
								   if(isset($_POST['id_subj'][$id])&&($_POST['id_subj'][$id]!=''))
								     $no_stud_has_grade=false;
									
								}
					        
						     if(!$no_stud_has_grade) 
								{  foreach($_POST['id_subj'] as $id)
			                        {   	   
									         //load liy ki konsene a
									         $model2update=MenfpGrades::model()->findByPk($_POST['id_grad'][$id]);
									         
									            if(isset($_POST['grades'][$id]))
									                $grade=$_POST['grades'][$id];
												else
													$grade=NULL;
													
										//check if grade is higher than the course weight	
											if($grade > $_POST['id_weight'][$id])  	   
												{  
													$grade=NULL;
													$this->message_GradeHigherWeight=true;
												}
										       
								              	  
												   $model2update->setAttribute('grade',$grade);
												   $model2update->setAttribute('date_updated',date('Y-m-d'));
												   $model2update->setAttribute('update_by',Yii::app()->user->name);
												   
												   if($model2update->save())
					                                 {  
													   $model2update->unSetAttributes();
													   $model2update= new MenfpGrades;
													   
													   $temwen=true;
													 }
											         
											 	   
				                        
									}
									
									//decision pou elev la
									$modelDecision = new MenfpDecision;
									
									 $modelDecision = MenfpDecision::model()->findByAttributes(array('student'=>$this->student_id,'academic_year'=>$acad_sess));
                               	   
									 
									$modelDecision->setAttribute('total_grade',$total_grade);
									$modelDecision->setAttribute('average',$average);
									 
									 if($modelDecision->save())
									   {
									   	   if($this->message_GradeHigherWeight==true)
											  {
											  	    $message = Yii::t('app','Grades GREATER than COURSE WEIGHT are ignored.');
				                                      Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
											  	}
									   	   
									   	   $this->redirect(array('index'));
									   	}
									
									
									
									
									
						        }
						      else //message vous n'avez entre aucune note
								{
									$message = Yii::t('app','You did not insert any grades.');
		                              Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
									
									}
								
						 }
						 else
						   {
						   	   $message = Yii::t('app','Total grade and mention can\'t be null.');
		                              Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
						   	}



			       	}
					
					
					
					
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
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MenfpGrades']))
		{
			$model->attributes=$_POST['MenfpGrades'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$acad_sess = acad_sess();
         $acad=Yii::app()->session['currentId_academic_year']; 

$pageSize=100000;
 Yii::app()->user->setState('pageSize',$pageSize);
		
		                

        $model=new MenfpGrades('search');
		
			
			
			                // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Participant list: ')), null,false);
                            $this->exportCSV($model->search_($acad_sess), array(
                               
				//'id',
				'student0.fullName',
				'menfpExam.academicYear.name_period',
				'menfpExam.level0.level_name',
				
				
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
		$model=new MenfpGrades('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MenfpGrades']))
			$model->attributes=$_GET['MenfpGrades'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


public function loadStudentsForMENFPGrades($acad)
 {
		   
      $model=new Persons;
		$idPerson = $model->findAll(array('alias'=>'p',
		                              'select'=>'p.id,first_name,last_name,id_number',
                                     'join'=>'inner join level_has_person lhp on(lhp.students=p.id) inner join examen_menfp em on(em.level=lhp.level)',
                                     'condition'=>'p.active in(1,2) AND lhp.academic_year='.$acad.' AND em.academic_year='.$acad,
                                     
                               ));
		 $code= array();
		   
		  $code[null]= Yii::t('app','-- Select --');
		    if(isset($idPerson))
			 {  foreach($idPerson as $pers){
			        $code[$pers->id]= $pers->first_name.' '.$pers->last_name.'('.$pers->id_number.')';
		           
		           }
			 }
		   
		return $code;

	   
	
	}	


 // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','menfpGrades.csv'),
           'csvDelimiter' => ',',
           ));
        }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MenfpGrades the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MenfpGrades::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MenfpGrades $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menfp-grades-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
