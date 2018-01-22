<?php 
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

?>
<?php
//session_start();

class SellingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
        public $part = "pos";
        
        public $quantity = null; 
        public $amount_receive; 
        public $amount_selling = 0;
        public $amount_balance = 0;
        public $discount = 0;
        
        public $unit_price; 
        public $product_id = null; 
        
        public $j=0;
        public $id_transaction; 
        public $id_;
        
        
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			//'postOnly', // we only allow deletion via POST request
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
           $academic_year = Yii::app()->session['currentId_academic_year']; 
           
            $modelSale = new SaleTransaction; 
            if(!isset($_GET['id'])){
		$model=new Sellings;
            }else{
                $id = $_GET['id'];
                $model = $this->loadModel($id);
            }
                
		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model,$modelSale);
                $this->id_transaction = Yii::app()->session['last_transaction']+1;
                if(isset($_POST['Sellings']['id_products']) && $_POST['Sellings']['id_products']!=null){
                    $this->product_id = $_POST['Sellings']['id_products'];
                    $this->unit_price = $this->getProductPriceById($this->product_id); 
                   // $this->quantity = $_POST['Sellings']['quantity'];
                    
               
                if(isset($_POST['quantity'])){
                        $this->quantity = $_POST['quantity'];
                        if(isset($_POST['Sellings']['id_products']) && isset($_POST['quantity'])){
                            
                            $stock = Stocks::model()->findByPk($this->getStockIdByProductId($this->product_id));
                           if($stock!=null)
                                if($stock->quantity >=$this->quantity){
                                
                                $this->amount_selling = $this->quantity*$this->unit_price;
                            
                        }else{
                            Yii::app()->user->setFlash(Yii::t('app','Stock'), Yii::t('app','Stock bellow {name} ! Not enought product for this sale !',array('{name}'=>$this->quantity)));
                            $this->quantity = null;
                        }
                }
                  
                }
                
                 
               
                
                if(isset($_POST['add'])){
                     
                    $model->setAttribute('transaction_id',$this->id_transaction);
                    $model->setAttribute('id_products',$this->product_id);
                    $model->setAttribute('quantity',$this->quantity);
                    $model->setAttribute('selling_date',date('Y-m-d H:m:s'));
                    $model->setAttribute('unit_selling_price',$this->unit_price);
                    $model->setAttribute('sell_by',Yii::app()->user->fullname);
                    $model->setAttribute('amount_selling',$this->quantity*$this->unit_price);
                    
                    $stock = Stocks::model()->findByPk($this->getStockIdByProductId($this->product_id));
                   
                    $stock->setAttribute('quantity',$stock->quantity-$this->quantity);
                    $stock->setAttribute('date_update',date('Y-m-d H:m:s')); 
                    $stock->setAttribute('update_by',Yii::app()->user->fullname);
                    $this->id_=$model->id; 
                    
                    if($model->save()){
                        if($stock->save()){
                           // $this->amount_selling=0;
                            $this->quantity=0;
                            $this->amount_receive=0;
                            $this->amount_balance=0;
                           
                                $this->redirect(array('create'));
                           
                        }
                    }
                }
                
                
                
        }else{
            
          
        }
        
        if(isset($_POST['close_sale'])){
                   // $sale_transaction = new SaleTransaction; 
                    $total_sale = $_POST['amount_selling'];
                    $discount = $_POST['discount'];
                    $real_sale = $_POST['real_sale'];
                    $amount_receive = $_POST['amount_receive'];
                    $amount_balance = $_POST['balance'];
                    $discount_value = ($discount/100)*$real_sale;
                    $modelSale->setAttribute('id_transaction',$this->id_transaction);
                    $modelSale->setAttribute('amount_sale',$total_sale);
                    $modelSale->setAttribute('discount',$discount_value);
                    $modelSale->setAttribute('amount_receive',$amount_receive);
                    $modelSale->setAttribute('amount_balance',$amount_balance);
                    $modelSale->setAttribute('academic_year',$academic_year);
                    $modelSale->setAttribute('create_by',Yii::app()->user->name);
                    $modelSale->setAttribute('create_date',date('Y-m-d H:m:s'));
                    
                    
                    if($modelSale->save()){
                        
                        unset(Yii::app()->session['last_transaction']);
                        Yii::app()->session['last_transaction'] = Sellings::model()->getMaxTransactionId();
                        
                        
                        $this->quantity=0;
                        $this->amount_receive=0;
                        $this->amount_balance=0;
                        $this->redirect(array('create'));
                    }
                }
                    
             
                            if(!isset($_GET['id'])){  
		$this->render('create',array(
			'model'=>$model,
                        'amount_selling'=>$this->amount_selling,
                        
		));
               }else{
                  $this->render('create',array(
			'model'=>$model,
                        'amount_selling'=>$this->amount_selling,
                        
		)); 
               }
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

		if(isset($_POST['Sellings']))
		{
			$model->attributes=$_POST['Sellings'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}
        
        public function actionReturnitem($id){
            if(isset($_GET['idProducts']) && isset($_GET['qty']) && isset($_GET['pu']) && isset($_GET['idt'])){
                    $idProducts = $_GET['idProducts'];
                     $qty = $_GET['qty'];
                     $pu = $_GET['pu'];
                     $idt = $_GET['idt'];
                     $stock = Stocks::model()->findByPk($this->getStockIdByProductId($idProducts));
                     $stock->quantity = $stock->quantity+$qty; 
                     $stock->save();
                     $model = $this->loadModel($id);
                     $model->setAttribute('is_return',1);
                     $model->setAttribute('update_by',Yii::app()->user->name);
                     $model->setAttribute('update_date',date('Y-m-d H:m:s'));
                     $model->save();
                     
                     $transaction = SaleTransaction::model()->findByPk($this->getSaleIdByTransactionId($idt));
                     if($transaction==null){
                         $this->redirect('return?src_trans='.$idt);
                     }else{
                        $transaction->amount_sale = $transaction->amount_sale - $pu*$qty;
                        $transaction->save();
                        
                        $modelReturn = new ReturnHistory; 
                        $modelReturn->setAttribute('id_transaction',$idt);
                        $modelReturn->setAttribute('id_product',$idProducts);
                        $modelReturn->setAttribute('return_amount',$qty*$pu);
                        $modelReturn->setAttribute('return_quantity',$qty);
                        $modelReturn->setAttribute('date_return',date('Y-m-d H:m:s'));
                        $modelReturn->setAttribute('return_by',Yii::app()->user->name);
                        $modelReturn->save();
                        
                        $this->redirect('return?src_trans='.$idt);
                     }
            }
        }

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
                /**
                 *  Enlever le stock de la valeur de la transaction efface 
                 *  Passer le id product en URL et ensuite trouver le id stock et puis enlever le stock de la transaction
                 *  Passer la quantite en URL aussi 
                 */
                 if(isset($_GET['idProducts']) && isset($_GET['qty'])){
                     $idProducts = $_GET['idProducts'];
                     $qty = $_GET['qty'];
                     $stock = Stocks::model()->findByPk($this->getStockIdByProductId($idProducts));
                      
                     $stock->quantity = $stock->quantity+$qty; 
                     $stock->save();
                     $this->loadModel($id)->delete();
                     $this->redirect('create');
                 }
                    
	}
        
        
        public function actionEmptyCart($id){
            if($id!=null){
            $sql_string = "SELECT id, transaction_id, id_products, quantity FROM sellings where transaction_id = $id and is_return is NULL ";
                $data_ = Sellings::model()->findAllBySql($sql_string);
            
                foreach($data_ as $d){
                    $stock = Stocks::model()->findByPk($this->getStockIdByProductId($d->id_products));
                     $stock->quantity = $stock->quantity+$d->quantity; 
                     $stock->save();
                     $this->loadModel($d->id)->delete();
                     
                }
            $this->redirect('create');
            
                 
            }
            
        }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Sellings');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
                $this->part = "rep";
		$model=new Sellings('search');
		$model->unsetAttributes();  // clear any default values
                
                if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
                
                if(isset($_GET['src_date_1'])&&isset($_GET['src_date_2'])){
                    $date1 = $_GET['src_date_1'];
                    $date2 = $_GET['src_date_2'];
                }
		if(isset($_GET['Sellings']))
			$model->attributes=$_GET['Sellings'];
                
                // Here to export to CSV 
				if($this->isExportRequest()){
					$this->exportCSV(array(Yii::t('app','Sale report')), null,false);
		                            $this->exportCSV($model->searchByDate($date1,$date2), array(
		                                
						'transaction_id',
                                                'idProducts.product_name',
                                                'quantity',
                                                'saleDate',
                                                'sell_by',
                                                'unit_selling_price',

		                )); 
				}

		$this->render('admin',array(
			'model'=>$model,
		));
	}
        
        public function actionReturn(){
            
            $model=new Sellings('search');
            $model->unsetAttributes();
            $this->part = "ret";
            $this->render('return',array(
			'model'=>$model,
		));
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Sellings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Sellings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Sellings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sellings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
  public function loadProducts()
	{   
		 $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol'];  //$modelLevel= new Levels();
                    $code= array();
                    $find_stock = "SELECT s.id_product, p.product_name,s.selling_price FROM stocks s INNER JOIN products p on (p.id = s.id_product) where s.quantity > 0 ";
                    $data_stock = Stocks::model()->findAllBySql($find_stock);
		  
           
		    foreach($data_stock as $ds){
			    $code[$ds->id_product]= $ds->product_name.' ( '.$currency_symbol.' '.numberAccountingFormat($ds->selling_price).')';
		           
		      }
		   
		return $code;
         
	}
        
        public function getProductPriceById($id){
            $price = 0.00;
            if($id!=null){
            $find_price = "Select selling_price from stocks where id_product = ".$id;
            $data_ = Stocks::model()->findAllBySql($find_price); 
            foreach ($data_ as $d){
                $price = $d->selling_price;
            }
            
            return $price; 
            
            }else{
                return 0.00; 
            }
            
        }
        
        public function getStockIdByProductId($id){
            $stock_id=null;
            if($id!=null){
            $find_stock_id = "Select id from stocks where id_product = ".$id;
            $data_ = Stocks::model()->findAllBySql($find_stock_id); 
            foreach ($data_ as $d){
                $stock_id = $d->id;
            }
            
            return $stock_id; 
            
            }else{
                return null; 
            }
            
        }
        
        
        
        public function getSaleIdByTransactionId($id){
            $trans_id=null;
            if($id!=null){
            $find_trans_id = "Select id from sale_transaction where id_transaction = ".$id;
            $data_ = Stocks::model()->findAllBySql($find_trans_id); 
            foreach ($data_ as $d){
                $trans_id = $d->id;
            }
            
            return $trans_id; 
            
            }else{
                return null; 
            }
            
        }
        
        
        
        // Export to CSV 
        public function behaviors() {
           return array(
               'exportableGrid' => array(
                   'class' => 'application.components.ExportableGridBehavior',
                   'filename' => Yii::t('app','sale_reports.csv'),
                   'csvDelimiter' => ',',
                   ));
        }
        
        public function formatDate($date_){
            $time = strtotime($date_);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }
        
        
        public function runStockAlert(){
            
            $sql_string = "SELECT p.product_name, s.quantity, p.stock_alert FROM `stocks` s JOIN products p ON (s.id_product = p.id) where s.quantity <= p.stock_alert";
            $data = Stocks::model()->findAllBySql($sql_string);
            $prod_name = null;
            $string_final = null;
            
            foreach($data as $d){
               $prod_name .= $d->product_name.'\n'; 
            }
            
            if($prod_name!=null){
                $string_final =  Yii::t('app','Products:\n\n{name}\n Have stock below alert level! ',array('{name}'=>$prod_name));
               
            }
            return $string_final; 
        }
        
        
}
