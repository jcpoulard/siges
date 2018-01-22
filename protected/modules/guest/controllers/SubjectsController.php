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



class SubjectsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;

	public function filters()
	{
		return array(
			'accessControl', 
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
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		$model=new Subjects;
                // Cancel the creation of a subject
		 if(isset($_POST['cancel'])) {
                            $this->redirect(array('index'));
                            }
                            
                $this->performAjaxValidation($model);

		if(isset($_POST['Subjects']))
		{
			$model->attributes=$_POST['Subjects'];
			$model->setAttribute('date_created',date('Y-m-d'));
			$model->setAttribute('date_updated',date('Y-m-d'));
		

			if($model->save())
                                //Recdirect to manage 
                                $this->redirect (array('index'));
				;
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
		
               
                $model=$this->loadModel();
                
                // Cancel the update of a subject 
                if(isset($_POST['cancel'])) {
                            $this->redirect(array('index'));
                            }

		$this->performAjaxValidation($model);
                

		if(isset($_POST['Subjects']))
		{
			$model->attributes=$_POST['Subjects'];
			$model->setAttribute('date_updated',date('Y-m-d'));
                        
			if($model->save())
                            //Redirect to amdmin 
                            $this->redirect(array('index'));
				
                        
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete()
	{
		if(Yii::app()->request->isPostRequest)
		{
			$this->loadModel()->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
		}
		else
			throw new CHttpException(400,
					Yii::t('app', 'Invalid request. Please do not repeat this request again.'));
	}

//	

        // Update the actionAdmin() en actionIndex()
	public function actionIndex()
	{
		
                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                    }
                $model=new Subjects('search');
                $model->unsetAttributes();
                
		if(isset($_GET['Subjects']))
			$model->attributes=$_GET['Subjects'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
		$this->exportCSV(array(Yii::t('app','List of subjects: ')), null,false);
		
		$this->exportCSV($model->search(), array(
		'subject_name',
		'subjectParent.subject_name',
		'is_subject_parent',)); 
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Subjects::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='subjects-form')
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
	           'filename' => Yii::t('app','subjects.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
	
	
	
}
