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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Sellings extends BaseSellings{
    
    /*
    public $quantity = 0; 
    public $amount_receive = 0; 
    public $amount_selling = 0;
    public $amount_balance = 0;
     * 
     */
    
    public $max_id; 
    public $discount = 0;
    public $sum_amount_selling;
    public $total_sale;
    
    
    public $src_date_1;
    public $src_date_2;
    
    public $fake_total;
    
    
    
    
    
     public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }
        
        
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('transaction_id, id_products, quantity, selling_date', 'required'),
			array('id, transaction_id, id_products, quantity', 'numerical', 'integerOnly'=>true),
			array('amount_receive, amount_selling, amount_balance, discount, unit_selling_price', 'numerical'),
			array('client_name', 'length', 'max'=>128),
			array('sell_by, update_by', 'length', 'max'=>64),
			array('update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, transaction_id, fake_total, src_date_1, src_date_2, total_cash, is_return, id_products, quantity, selling_date, client_name, sell_by, amount_receive, amount_selling, amount_balance, discount, update_by, update_date, unit_selling_price', 'safe', 'on'=>'search'),
		);
	}
        
        

        
        public function getMaxTransactionId(){
            $trans = null;
            $find_trans = "Select MAX(transaction_id) as max_id from sellings";
            $data = Sellings::model()->findAllBySql($find_trans); 
           
            foreach($data as $d){
                $trans = $d->max_id; 
               
            }
            
            if($trans!=null){
                return $trans;
            }else{
                return 0; 
            }
        }
        
        public function searchByTransaction($id_trans)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->condition = 'transaction_id=:idTrans AND is_return is NULL';
		$criteria->params = array(':idTrans'=>$id_trans);
		$criteria->compare('id',$this->id);
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('id_products',$this->id_products);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('selling_date',$this->selling_date,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('sell_by',$this->sell_by,true);
		$criteria->compare('amount_receive',$this->amount_receive);
		$criteria->compare('amount_selling',$this->amount_selling);
		$criteria->compare('amount_balance',$this->amount_balance);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('unit_selling_price',$this->unit_selling_price);
                $criteria->order = 'transaction_id DESC';
		return new CActiveDataProvider($this, array(
                    'pagination'=>array(
        			'pageSize'=> 1000,
    			),
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchReturnByTransaction($id_trans)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->condition = 'transaction_id=:idTrans AND is_return = 1';
		$criteria->params = array(':idTrans'=>$id_trans);
		$criteria->compare('id',$this->id);
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('id_products',$this->id_products);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('selling_date',$this->selling_date,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('sell_by',$this->sell_by,true);
		$criteria->compare('amount_receive',$this->amount_receive);
		$criteria->compare('amount_selling',$this->amount_selling);
		$criteria->compare('amount_balance',$this->amount_balance);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('unit_selling_price',$this->unit_selling_price);
                $criteria->order = 'transaction_id DESC';
		return new CActiveDataProvider($this, array(
                    'pagination'=>array(
        			'pageSize'=> 1000,
    			),
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchReturn()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->condition = 'is_return = 1';
		$criteria->compare('id',$this->id);
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('id_products',$this->id_products);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('selling_date',$this->selling_date,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('sell_by',$this->sell_by,true);
		$criteria->compare('amount_receive',$this->amount_receive);
		$criteria->compare('amount_selling',$this->amount_selling);
		$criteria->compare('amount_balance',$this->amount_balance);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('unit_selling_price',$this->unit_selling_price);
                $criteria->order = 'transaction_id DESC';
		return new CActiveDataProvider($this, array(
                    'pagination'=>array(
        			'pageSize'=> 1000,
    			),
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchByDate($date1, $date2)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->condition = 'date(selling_date)>=:date1 AND date(selling_date)<=:date2 AND is_return is NULL';
		$criteria->params = array(':date1'=>$date1,':date2'=>$date2);
		$criteria->compare('id',$this->id);
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('id_products',$this->id_products);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('selling_date',$this->selling_date,true);
		$criteria->compare('client_name',$this->client_name,true);
		$criteria->compare('sell_by',$this->sell_by,true);
		$criteria->compare('amount_receive',$this->amount_receive);
		$criteria->compare('amount_selling',$this->amount_selling);
		$criteria->compare('amount_balance',$this->amount_balance);
		$criteria->compare('discount',$this->discount);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('unit_selling_price',$this->unit_selling_price);
                $criteria->order = 'transaction_id DESC';
		return new CActiveDataProvider($this, array(
                        'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
        
        
        
        public function getAmountSellingByTransaction($trans_id){
            $sum = null;
            $sql_string = "SELECT sum(amount_selling)  as sum_amount_selling FROM sellings WHERE transaction_id = $trans_id AND is_return is NULL GROUP BY transaction_id";
            $data = Sellings::model()->findAllBySql($sql_string);
            foreach($data as $d){
                $sum = $d->sum_amount_selling; 
               
            }
            
            if($sum!=null){
                return $sum;
            }else{
                return 0; 
            }
            
        }
        
  
  	
 public function getAmountReceive(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->amount_receive);
        }	

	
 public function getAmountSelling(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->amount_selling);
        }	

	
 public function getAmountBalance(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->amount_balance);
        }	

	
 public function getDiscount(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->discount);
        }	

	
 public function getUnitSellingPrice(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->unit_selling_price);
        }
        
public function getSale(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->unit_selling_price*$this->quantity);
        }        
      
        public function getTotalSale($date1, $date2){
            $sum = 0; 
            $sql_string = "SELECT sum(amount_selling) AS total_sale FROM sellings WHERE date(selling_date) >='$date1' AND date(selling_date) <='$date2' AND is_return is NULL ";
            $data = Sellings::model()->findAllBySql($sql_string);
            foreach($data as $d){
                $sum = $d->total_sale;
            }
            
            if($sum!=0){
                return $sum;
            }else{
                return 0; 
            }
        }
        
        
        
        public  function attributeLabels(){
            return array(
                'amount_selling'=>Yii::t('app','Total sale'),
                'discount'=>Yii::t('app','Discount %'),
                'amount_receive'=>Yii::t('app','Receive'),
                'id' => 'ID',
                'transaction_id' =>Yii::t('app','Transaction'),
                'id_products'    =>Yii::t('app','Id Products'),
                'quantity'       =>Yii::t('app','Quantity'),
                'selling_date'   =>Yii::t('app','Selling Date'),
                'client_name'    =>Yii::t('app','Client Name'),
                'sell_by'        =>Yii::t('app','Sold By'),
                'amount_receive' =>Yii::t('app','Amount Receive'),
                'amount_selling' =>Yii::t('app','Amount Selling'),
                'amount_balance' =>Yii::t('app','Amount Balance'),
                'balance'=>Yii::t('app','Balance '), // Balance pour point of sale
                'discount'       =>Yii::t('app','Discount'),
                'update_by'      =>Yii::t('app','Update By'),
                'update_date'    =>Yii::t('app','Update Date'),
                'unit_selling_price'  =>Yii::t('app', 'Unit Selling Price'),
                'saleDate'=>Yii::t('app','Sale date'),
                
            );
        }
        
        public function getSaleDate(){
           if(($this->selling_date!=null)&&($this->selling_date!='0000-00-00'))
	        {    $time = strtotime($this->selling_date);
	                         $month=date("m",$time);
	                         $year=date("Y",$time);
	                         $day=date("j",$time);
	                         
	            return $day.'/'.$month.'/'.$year;    
	         }
	       else
	           return '00/00/0000';
        }
        
        public function getTotal(){
            return null;
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
        
        
        public function deleteNoCompleteSale(){
            
            $string_sql = "SELECT id, transaction_id, id_products, quantity FROM sellings where transaction_id not in (Select id_transaction from sale_transaction)";
            $data_ = Sellings::model()->findAllBySql($string_sql);
             
            foreach ($data_ as $d){
                $id_sale = $d->id;
                $id_product = $d->id_products;
                
                $id_stock = $this->getStockIdByProductId($id_product);
                $stock = Stocks::model()->findByPk($id_stock);
                $stock->quantity = $stock->quantity+$d->quantity;
                $stock->save();
                $model=Sellings::model()->findByPk($id_sale);
                $model->delete();
            }
            
            
            
        }
        
        
        
}