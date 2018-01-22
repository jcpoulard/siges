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
class PartnersController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	
	public $back_url;

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
		$acad=Yii::app()->session['currentId_academic_year'];
		
		$model=new Partners;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Partners']))
		{
                                $model->attributes=$_POST['Partners'];
			
			if(isset($_POST['create']))
              {
				$model->setAttribute('created_by', Yii::app()->user->name  );
			    $model->setAttribute('date_created', date('Y-m-d') ); 
			    
			    
				if($model->save())
				 $this->redirect(array('index'));
				 
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
		$acad=Yii::app()->session['currentId_academic_year'];
		
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Partners']))
		{
			$model->attributes=$_POST['Partners'];
			
			  if(isset($_POST['update']))
                {	
                	$model->setAttribute('updated_by', Yii::app()->user->name  );
			        $model->setAttribute('date_updated', date('Y-m-d') );
			    
                	if($model->save())
						$this->redirect(array('index'));
				
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
	public function actionDelete($id)
	{
		
		
		$model_to_delete = ScholarshipHolder::model()->findByAttributes(array('partner'=>$id));
		
		if($model_to_delete != null)
		 {
		 	 header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
		 	}
		else
		   $this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
			
			
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year'];
		
		 if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
                
                $model=new Partners('search');
		
		$model->unsetAttributes();  // clear any default values
		
		if(isset($_GET['Partners']))
			$model->attributes=$_GET['Partners'];
			
	                    // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Partners : ')), null,false);
                            $this->exportCSV($model->search(), array(
                               
				'name',
				'address',
				'email',
				'phone',
				'activity_field',
				'date_created',
				
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
		$model=new Partners('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Partners']))
			$model->attributes=$_GET['Partners'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


 // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','partners.csv'),
           'csvDelimiter' => ',',
           ));
        }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Partners the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Partners::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Partners $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='partners-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
