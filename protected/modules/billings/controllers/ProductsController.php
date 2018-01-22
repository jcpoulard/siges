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

class ProductsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $part = "prod";
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
		$model=new Products;
                $stock = new Stocks;
                $stockHistory = new StockHistory;
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Products']) && isset($_POST['Stocks']))
		{
			$model->attributes=$_POST['Products'];
			
			
		      if($model->stock_alert > $_POST['Stocks']['quantity'])
		        {
		          $stock->setAttribute('quantity',$_POST['Stocks']['quantity']);
				  
			       $message = Yii::t('app','Stock alert can\'t be greater than quantity!');

			          $params = array(
		                    '{attribute}'=>$model->stock_alert, '{compareValue}'=>$_POST['Stocks']['quantity']
		                );
						
					 $model->getMessage('stock_alert', $message, $params);	
		                
						
		        }
			else
			  {
                        $model->setAttribute('create_by',Yii::app()->user->name);
                        $model->setAttribute('date_create',date('Y-m-d H:m:s'));
                            if($model->save()){
                                $stock->setAttribute('id_product',$model->id);
                                $stock->setAttribute('acquisition_date',date('Y-m-d'));
                                $stock->setAttribute('quantity',$_POST['Stocks']['quantity']);
                                if(!isset($_POST['Stocks']['buiying_price'])){
                                    $stock->setAttribute('buiying_price',0);
                                }else{
                                    $stock->setAttribute('buiying_price',$_POST['Stocks']['buiying_price']);
                                }
                                $stock->setAttribute('selling_price',$_POST['Stocks']['selling_price']);
                                $stock->setAttribute('is_donation',$_POST['Stocks']['is_donation']);
                                $stock->setAttribute('create_by',Yii::app()->user->name);
                                $stock->setAttribute('date_create',date('Y-m-d H:m:s'));
                                if($stock->save()){
                                    $stockHistory->setAttribute('id_product',$model->id);
                                    $stockHistory->setAttribute('buying_date',date('Y-m-d'));
                                    $stockHistory->setAttribute('quantity',$_POST['Stocks']['quantity']);
                                    if(!isset($_POST['Stocks']['buiying_price'])){
                                    $stockHistory->setAttribute('buying_price',0);
                                    }else{
                                    $stockHistory->setAttribute('buying_price',$_POST['Stocks']['buiying_price']);
                                    }
                                    
                                    $stockHistory->setAttribute('selling_price',$_POST['Stocks']['selling_price']);
                                    $stockHistory->setAttribute('id_stock',$stock->id);
                                    $stockHistory->setAttribute('create_by',Yii::app()->user->name);
                                    $stockHistory->setAttribute('create_date',date('Y-m-d H:m:s'));
                                    if($stockHistory->save())
                                        $this->redirect(array('index'));
                                }
                            }
							
			}
                       
		}
                
                if(isset($_POST['cancel']))
                          {
                               $this->redirect(array('products/index'));
                          }

		$this->render('create',array(
			'model'=>$model,
                        'stock'=>$stock,
                        'stockHistory'=>$stockHistory,
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
                if(isset($_GET['idstock'])){
                    $id_stock = $_GET['idstock'];
                    $stock =  Stocks::model()->findByPk($id_stock);
                }else{
                    $stock = new Stocks;
                }
                
                $stockHistory = new StockHistory;
                
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Products']) && isset($_POST['Stocks']))
		{
			$model->attributes=$_POST['Products'];
                        $stock->attributes=$_POST['Stocks'];
                        $model->setAttributes('update_by',Yii::app()->user->name);
                        $model->setAttributes('date_update',date('Y-m-d H:m:s'));
			if($model->save()){
                                $stock->setAttribute('id_product',$model->id);
                                $stock->setAttribute('acquisition_date',date('Y-m-d'));
                                $stock->setAttribute('quantity',$_POST['Stocks']['quantity']);
                                if(!isset($_POST['Stocks']['buiying_price'])){
                                    $stock->setAttribute('buiying_price',0);
                                }else{
                                    $stock->setAttribute('buiying_price',$_POST['Stocks']['buiying_price']);
                                }
                                $stock->setAttribute('selling_price',$_POST['Stocks']['selling_price']);
                                $stock->setAttribute('is_donation',$_POST['Stocks']['is_donation']);
                                $stock->setAttribute('create_by',Yii::app()->user->name);
                                $stock->setAttribute('date_create',date('Y-m-d H:m:s'));
                                if($stock->save()){
                                    $stockHistory->setAttribute('id_product',$model->id);
                                    $stockHistory->setAttribute('buying_date',date('Y-m-d'));
                                    $stockHistory->setAttribute('quantity',$_POST['Stocks']['quantity']);
                                    if(!isset($_POST['Stocks']['buiying_price'])){
                                    $stockHistory->setAttribute('buying_price',0);
                                    }else{
                                    $stockHistory->setAttribute('buying_price',$_POST['Stocks']['buiying_price']);
                                    }
                                    
                                    $stockHistory->setAttribute('selling_price',$_POST['Stocks']['selling_price']);
                                    $stockHistory->setAttribute('id_stock',$stock->id);
                                    $stockHistory->setAttribute('create_by',Yii::app()->user->name);
                                    $stockHistory->setAttribute('create_date',date('Y-m-d H:m:s'));
                                    if($stockHistory->save()){
                                        $this->redirect(array('index'));
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
                        'stock'=>$stock,
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
	 * Manages all models.
	 */
	public function actionIndex()
	{
		   if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
            
                $stock=new Stocks('search');
		
                $stock->unsetAttributes();
             
        // Here to export to CSV 
		if($this->isExportRequest()){
		$this->exportCSV(array(Yii::t('app','Stock report: ')), null,false);
		
		$dataProvider = null;
		if(isset($_GET['srcProd']) && $_GET['srcProd']!="")
          {   $productName = $_GET['srcProd'];
			$dataProvider = $stock->searchProductName("p.product_name LIKE '%".$productName."%'");
          }
         else
              {      $dataProvider = $stock->search();
              	
              	 }
	
	
	
		$this->exportCSV($dataProvider, array(
		'idProduct.product_name',
		'quantity',
		'idProduct.stock_alert',
        'BuyingPrice',
        'SellingPrice',
                )); 
		}

               
		$this->render('index',array(
			//'model'=>$model,
                        'stock'=>$stock,
		));
	}


	// Export to CSV 
	public function behaviors() {
	   return array(
	       'exportableGrid' => array(
	           'class' => 'application.components.ExportableGridBehavior',
	           'filename' => Yii::t('app','stocks.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
     

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Products the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Products::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Products $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='products-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
