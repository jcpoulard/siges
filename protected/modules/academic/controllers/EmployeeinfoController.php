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




class EmployeeinfoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_model;
	
	public $extern=false; //pou konn si c nan view apel update(kreyasyon) an fet
	
	public $back_url='';

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
		$model=new EmployeeInfo;
		$this->extern=false;
		$employee=null;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		
		if(isset($_GET['emp'])&&($_GET['emp']!=""))
           {   $this->extern=true;
                $employee=$_GET['emp'];
           
           }
       else
            $this->extern=false;



	if(isset($_POST['EmployeeInfo']))
		{
			$model->attributes=$_POST['EmployeeInfo'];
			
		if(isset($_POST['create']))
		  { //on vient de presser le bouton
			if(isset($_GET['emp'])&&($_GET['emp']!=""))
             {   $model->setAttribute('employee',$employee);
             
               }
               
			$model->setAttribute('date_created',date('Y-m-d'));
			
			if($model->save())
				{	 
			  	  if($this->extern)
				   	   {   
				   	   	  $this->extern=false; 
				   	   	  if(isset($_GET['isstud'])&&($_GET['isstud']==0))
				   	   	     $this->redirect(array('persons/viewForReport','id'=>$_GET['emp'],'isstud'=>0,'pg'=>'lr','from'=>$_GET['from']));
				   	   	  else
				   	   	     $this->redirect(array('persons/viewForReport','id'=>$_GET['emp'],'pg'=>'lr','from'=>$_GET['from']));
				   	   	     
				   	   	 
				   	   }
				   	 else
				   	    $this->redirect(array('view','id'=>$model->id));
				   	    
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
	public function actionUpdate()
	{
		if(isset($_GET['emp'])&&($_GET['emp']!=""))
            $this->extern=true;
       else
            $this->extern=false;

		
		$model=$this->loadModel();

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['EmployeeInfo']))
		{
			$model->attributes=$_POST['EmployeeInfo'];
			
		 if(isset($_POST['update']))
		  {	
		  				$model->setAttribute('date_updated',date('Y-m-d'));
			if($model->save())
			  {	 
			  	  if($this->extern)
				   	   {   
				   	   	  $this->extern=false; 
				   	   	  if(isset($_GET['isstud'])&&($_GET['isstud']==0))
				   	   	     $this->redirect(array('persons/viewForReport','id'=>$_GET['emp'],'isstud'=>0,'pg'=>'lr','from'=>$_GET['from']));
				   	   	  else
				   	   	     $this->redirect(array('persons/viewForReport','id'=>$_GET['emp'],'pg'=>'lr','from'=>$_GET['from']));
				   	   	 
				   	   }
				   	 else
				   	    $this->redirect(array('view','id'=>$model->id));
			  	  
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
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
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
		if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
                
        $model=new EmployeeInfo('search_');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['EmployeeInfo']))
			$model->attributes=$_GET['EmployeeInfo'];
                if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List employee info: ')), null,false);
			
			$this->exportCSV($model->search() , array(
					'employee0.last_name',
					'employee0.first_name',
					'hire_date',
                                        'university_or_school',
                            'number_of_year_of_study',
                            'qualification0.qualification_name',
                            'fieldStudy.field_name')); 
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return EmployeeInfo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=EmployeeInfo::model()->findbyPk($_GET['id']);
			 else
			   { if(isset($_GET['emp'])&&($_GET['emp']!=""))
			   	  $this->_model=EmployeeInfo::model()->findbyAttributes(array('employee'=>$_GET['emp']));
			   	}
			   	
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
		
			}

	/**
	 * Performs the AJAX validation.
	 * @param TeacherInfo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='employee-info-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
        public function behaviors() {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','employee more info.csv'),
	            'csvDelimiter' => ',',
	            ));
	}
}
