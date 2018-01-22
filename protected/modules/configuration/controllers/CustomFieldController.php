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
class CustomFieldController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $field_type;
        public $field_related_to;
        public $value_type;
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
		$model=new CustomField;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['CustomField']))
		{
                    
			$model->attributes=$_POST['CustomField'];
                        
                        if(isset($_POST['CustomField']['field_type'])){
                        $this->field_type = $_POST['CustomField']['field_type'];
                        }
                        if(isset($_POST['CustomField']['value_type'])){
                        $this->value_type = $_POST['CustomField']['value_type'];
                        }
                        
                        if(isset($_POST['CustomField']['field_related_to'])){
                        $this->field_related_to = $_POST['CustomField']['field_related_to'];
                        }
                        
                        /**
                         * Enleve les spaces du nom des champs
                         */
                        
                        if(isset($_POST['CustomField']['field_name'])){
                            $field_name_brut = $_POST['CustomField']['field_name'];
                            $field_name_tab = explode(" ", $field_name_brut);
                            $field_name_clean = "";
                            if(count($field_name_tab)>1){
                                foreach($field_name_tab as $fnb){
                                    $field_name_clean .=$fnb.'_';
                                }
                            }else{
                                $field_name_clean = $field_name_brut;
                            }
                            $model->setAttribute('field_name',$field_name_clean);
                            $model->setAttribute('field_related_to',$this->field_related_to);
                        }
                        
                        if(isset($_POST['create'])){
			if($model->save())
				$this->redirect(array('index'));
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

		if(isset($_POST['CustomField']))
		{
                    if(isset($_POST['CustomField']['field_type'])){
                        $this->field_type = $_POST['CustomField']['field_type'];
                        }
                        
                     if(isset($_POST['CustomField']['field_related_to'])){
                        $this->field_related_to = $_POST['CustomField']['field_related_to'];
                        }    
                        
			$model->attributes=$_POST['CustomField'];
                         if(isset($_POST['update'])){
                            if($model->save())
				$this->redirect(array('index'));
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
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
        /**
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('CustomField');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}
         * 
         */

	/**
	 * Manages all models.
	 */
	public function actionIndex()
	{
		$model=new CustomField('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['CustomField']))
			$model->attributes=$_GET['CustomField'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return CustomField the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=CustomField::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CustomField $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='custom-field-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
