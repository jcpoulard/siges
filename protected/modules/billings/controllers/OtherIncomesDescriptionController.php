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




class OtherIncomesDescriptionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	public $part='incdes';
	
	
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
            //print_r($explode_url);
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
		$model=new OtherIncomesDescription;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OtherIncomesDescription']))
		{
			$model->attributes=$_POST['OtherIncomesDescription'];
			
			if(isset($_POST['create']))
			  { 
				if($model->save())
				  $this->redirect(array('otherIncomesDescription/index/part/rec/from/stud'));
			
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
		
		$model=$this->loadModel($id);
		
		
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['OtherIncomesDescription']))
		{
			$model->attributes=$_POST['OtherIncomesDescription'];
			
			if(isset($_POST['update']))
			  { 
				if($model->save())
				  $this->redirect(array('otherIncomesDescription/index/part/rec/from/stud'));
				
				
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
				
		try {
   			  
			  
	       $this->loadModel($id)->delete();
                

   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			        //header("HTTP/1.0 400 Relation Restriction");
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
	public function actionIndex() //actionAdmin()
	{
		$acad=Yii::app()->session['currentId_academic_year']; //current academic year
		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
			
		$model=new OtherIncomesDescription('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['OtherIncomesDescription']))
			$model->attributes=$_GET['OtherIncomesDescription'];
		
		    // Here to export to CSV 
	                if($this->isExportRequest()){
	                $this->exportCSV(array(Yii::t('app','Other incomes description list: ')), null,false);
	                //$this->exportCSV($model, array_keys($model->attributeLabels()),false, 3);
	                $this->exportCSV($model->search(), array(
	                'income_description',
	                'Category',
		            'comment',)); 
	                }
	                
	
		$this->render('index',array(
			'model'=>$model,
		));
	}


      // Export to CSV 
        public function behaviors() {
           return array(
               'exportableGrid' => array(
                   'class' => 'application.components.ExportableGridBehavior',
                   'filename' => Yii::t('app','otherIncomesDescription.csv'),
                   'csvDelimiter' => ',',
                   ));
        }
     



	//************************  loadCategoryIncome ******************************/
	public function loadCategoryIncome()
	{    
	    
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
           $code= array();
		   
		    $sql='select id, category from label_category_for_billing where income_expense=\'ri\'';
	
         $result= Yii::app()->db->createCommand($sql)->queryAll(true, array());

    
		           
		 $code[null]= Yii::t('app','-- Select --');
		    foreach($result as $r){
			    $code[$r['id']]= Yii::t('app',$r['category']);
		           
		      }
		   
		return $code;
         
	}
	

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return OtherIncomesDescription the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=OtherIncomesDescription::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param OtherIncomesDescription $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='other-incomes-description-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
