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



class ShiftsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';

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
		$model=new Shifts;

		$this->performAjaxValidation($model);

		if(isset($_POST['Shifts']))
		{
			$model->attributes=$_POST['Shifts'];
			
			if(isset($_POST['create']))
              {
				$model->setAttribute('date_created',date('Y-m-d'));
				 $model->setAttribute('date_updated',date('Y-m-d'));
			
	
				if($model->save())
					$this->redirect (array('index'));
					
					
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

	public function actionUpdate()
	{
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Shifts']))
		{
			$model->attributes=$_POST['Shifts'];
			
			if(isset($_POST['update']))
             {
				$model->setAttribute('date_updated',date('Y-m-d'));
			
				if($model->save())
					$this->redirect (array('index'));
					
	                        
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

	public function actionDelete()
	{
		
		
		try {
   			 $this->loadModel()->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
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

        
	public function actionIndex()
	{
            
            if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                unset($_GET['pageSize']);
            }
            $model=new Shifts('search');
            $model->unsetAttributes();
            
		
		if(isset($_GET['Shifts']))
			$model->attributes=$_GET['Shifts'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of shift: ')), null,false);
			
			$this->exportCSV($model->search(), array(
					'shift_name',
					'time_start',
					'time_end',)); 
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
				$this->_model=Shifts::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='shifts-form')
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
	            'filename' => Yii::t('app','shift.csv'),
	            'csvDelimiter' => ',',
	            ));
	}
}
