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

class ExamenMenfpController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $part ='emlis';
	
	public $idLevel;
	public $number_row;
	
	

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
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

            $model = new ExamenMenfp;
            $number_line = infoGeneralConfig('nb_grid_line');
            
         // Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
            
            $error_report = False;
					
			
        if(isset($_POST['level']))
		  {
                $this->idLevel = $_POST['level'];
                
                if($this->idLevel!='')		  
			      {  
					 if($number_line!=null)
					    $this->number_row = $number_line;
					 else
						$this->number_row = 6;
				   }
			    else
				  $this->number_row = 0;
				   
            }
         else
           {
                $this->idLevel = null;
                $this->number_row = 0;
            }

            if(isset($_POST['btnSave']))
			 {
                $subject = array();
                $weight = array();
                $pass=false;
                $error=0;
                
               for($j=0;$j<$this->number_row;$j++)
				{
                    if(isset($_POST['weight'.$j]) && $_POST['weight'.$j]!='')
					{
                       
                       $subject[$j] = NULL;
                       $weight[$j] = NULL;
                       
                        $model->setAttribute('level', $this->idLevel);
                        
                        if(isset($_POST['subject'.$j]))
                         {
                           $subject[$j] = $_POST['subject'.$j];
                          }
                        
                        
                        $weight[$j] = $_POST['weight'.$j];
                        
                             $subj_ = NULL;
							  	 //tcheke si matye a deja ..
							  	 $sql1 = "SELECT * FROM examen_menfp WHERE level=".$this->idLevel." AND subject=".$subject[$j]." AND academic_year=".$acad_sess;
                                $command1 = Yii::app()->db->createCommand($sql1);
                                $result1 = $command1->queryAll();
					  
					       if(($result1!=null))
							 {   $error=2;
								          
								}
							  else
							    {  
								  	$model->setAttribute('subject', $subject[$j]);
			                        $model->setAttribute('weight', $weight[$j]);
								  	$model->setAttribute('academic_year', $acad_sess);
			                        $model->setAttribute('date_created', date('Y-m-d'));
			                        $model->setAttribute('create_by', Yii::app()->user->name);
									   
	                                  if($model->save()){
				                             $pass=true;
										}
							    }
								 
						     
								 
								  
                          
                      }
                    $model->unsetAttributes();
                    $model = new ExamenMenfp;
                }
                    
                    if(($error==2)) 
                    {
                      $message = Yii::t('app','Some subjects are already set!');
                              Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
			          }
			 
                    if(($this->number_row >1) &&($pass==true)) 
                        $this->redirect(array('index'));
                   
                
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
	public function actionUpdate($id)
	{
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

         $model=new ExamenMenfp;

        $model=$this->loadModel($id);
        
        $level_old=$model->level;
        $subject_old=$model->subject;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);


    if(isset($_POST['ExamenMenfp']))
		{	
          if(isset($_POST['level']))
			  {
                $this->idLevel = $_POST['level'];
                $model->setAttribute('level', $this->idLevel);
                
               }
           
             
            $this->idLevel = $model->level;
            
            
     	
		if(isset($_POST['update']))
		  {
			 	$pass=true;
			 	$model->attributes=$_POST['ExamenMenfp'];
			 	
			   if(($model->subject!=$subject_old)||($model->level!=$level_old))
				{
					
					 //tcheke si matye a deja ..
							  	 $sql1 = "SELECT * FROM examen_menfp WHERE level=".$this->idLevel." AND subject=".$model->subject." AND academic_year=".$acad_sess;
                                $command1 = Yii::app()->db->createCommand($sql1);
                                $result1 = $command1->queryAll();
					  
					       if(($result1!=null))
							 {  
							 	$pass=false;
							 
							 	 $message = Yii::t('app','Some subjects are already set!');
                                  Yii::app()->user->setFlash(Yii::t('app','Warning'), $message);
								          
								}
				  }
				             if($pass==true)
								{  
									
                                    $model->setAttribute('date_updated', date('Y-m-d'));
			                        $model->setAttribute('update_by', Yii::app()->user->name);
									   
	                                  if($model->save()){
				                             $this->redirect(array('index'));
										}
							    }

						
				 
			   
			
			 }
					
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
		
		$sql1 = "SELECT * FROM menfp_grades WHERE menfp_exam=".$id;
        $command1 = Yii::app()->db->createCommand($sql1);
        $result1 = $command1->queryAll();
					  
		   if(($result1==null))
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


		
		 if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
                

        $model=new ExamenMenfp('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ExamenMenfp']))
			$model->attributes=$_GET['ExamenMenfp'];
			
			
			                // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','MENFP exam list: ')), null,false);
                            $this->exportCSV($model->search($acad_sess), array(
                               
				//'id',
				'level0.level_name',
		'subject0.subject_name',
		'weight',
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
		$model=new ExamenMenfp('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['ExamenMenfp']))
			$model->attributes=$_GET['ExamenMenfp'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}



 // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','examenMenfp.csv'),
           'csvDelimiter' => ',',
           ));
        }



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return ExamenMenfp the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=ExamenMenfp::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param ExamenMenfp $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='examen-menfp-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
