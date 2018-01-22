<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

class StocksController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $part = "prod";
        public $back_url;
	/**
         * 
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
		$model=new Stocks;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Stocks']))
		{
			$model->attributes=$_POST['Stocks'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
                $stockHistory = new StockHistory;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

	if(isset($_POST['Stocks']))
		{
                    if(isset($_POST['update'])){
                        if(isset($_GET['soti']) && $_GET['soti']=='upstock'){
                            
                            if(isset($_POST['Stocks']['update_all_price']) && $_POST['Stocks']['update_all_price']==1 ){
                                $b_price = $_POST['Stocks']['b_price']; 
                                $s_price = $_POST['Stocks']['s_price'];
                                $quantity_update = $_POST['Stocks']['quantity_update'];
                                $model->quantity = $model->quantity+$quantity_update;
                                $model->setAttribute('buiying_price',$b_price);
                                $model->setAttribute('selling_price',$s_price);
                                $model->setAttribute('update_by',Yii::app()->user->name);
                                $model->setAttribute('date_update', date('Y-m-d H:m:s'));
                                $stockHistory->setAttribute('id_stock',$model->id);
                                $stockHistory->setAttribute('id_product',$model->id_product);
                                $stockHistory->setAttribute('buying_date',date('Y-m-d H:m:s'));
                                $stockHistory->setAttribute('buying_price',$b_price);
                                $stockHistory->setAttribute('selling_price',$s_price);
                                $stockHistory->setAttribute('quantity',$quantity_update);
                                $stockHistory->setAttribute('create_by',Yii::app()->user->name);
                                $stockHistory->setAttribute('create_date', date('Y-m-d H:m:s'));
                                
                                
                                if($model->save() && $stockHistory->save()){
                                    $this->redirect(array('products/index'));
                                }
                            }
                            
                            if(isset($_POST['Stocks']['quantity_update'])){
                                $quantity_update = $_POST['Stocks']['quantity_update'];
                                $model->quantity = $model->quantity+$quantity_update;
                                $model->setAttribute('update_by',Yii::app()->user->name);
                                $model->setAttribute('date_update', date('Y-m-d H:m:s'));
                                $stockHistory->setAttribute('id_stock',$model->id);
                                $stockHistory->setAttribute('id_product',$model->id_product);
                                $stockHistory->setAttribute('buying_date',date('Y-m-d H:m:s'));
                                $stockHistory->setAttribute('buying_price',$model->buiying_price);
                                $stockHistory->setAttribute('selling_price',$model->selling_price);
                                $stockHistory->setAttribute('quantity',$quantity_update);
                                $stockHistory->setAttribute('create_by',Yii::app()->user->name);
                                $stockHistory->setAttribute('create_date', date('Y-m-d H:m:s'));
                                if($model->save() && $stockHistory->save()){
                                    
                                     $this->redirect(array('products/index')); 
                                }
                            }
                            
                            
                            
                                
                            }
                        }
                    }
                    
                    
		    
                if(isset($_POST['cancel']))
                          {
                               $this->redirect(array('products/index'));
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
		$dataProvider=new CActiveDataProvider('Stocks');
                
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Stocks('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Stocks']))
			$model->attributes=$_GET['Stocks'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Stocks the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Stocks::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Stocks $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='stocks-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
