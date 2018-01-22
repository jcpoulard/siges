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

class Stocks extends BaseStocks{
    
    
    public $product_name; 
    public $update_all_price;
    public $quantity_update=0;
    public $b_price;
    public $s_price;
    public $stock_alert;
    
     public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }
        
        public function rules(){
        return array_merge(
                parent::rules(),
                array(
                    array('id_product','unique'),
                    array('quantity_update','required'),
                    array('quantity_update','numerical', 'integerOnly'=>true),
                    array('b_price, s_price','numerical'),
                    array('id, id_product, product_name, quantity, acquisition_date, buiying_price, selling_price, is_donation, create_by, update_by, date_create, date_update', 'safe', 'on'=>'search'),
                    )
                ); 
    }
    
    
    public function attributeLabels()
	{
		return array(
			'id'                =>Yii::t('app',       'ID'),
			'id_product'        =>Yii::t('app','Id Product'),
			'quantity'          =>Yii::t('app',        'Quantity'),
			'acquisition_date'  =>Yii::t('app',          'Acquisition Date'),
			'buiying_price'     =>Yii::t('app',         'Buiying Price'),
			'selling_price'     =>Yii::t('app','Selling Price'),
			'is_donation'       =>Yii::t('app','Is Donation'),
			'create_by'         =>Yii::t('app','Create By'),
			'update_by'         =>Yii::t('app','Update By'),
			'date_create'       =>Yii::t('app','Date Create'),
			'date_update'       =>Yii::t('app','Date Update'),
                        'update_all_price'=>Yii::t('app','Update All Price'),
                        's_price'=>Yii::t('app','Selling Price'),
                        'b_price'=>Yii::t('app','Buying Price'),
                        'quantity_update'=>Yii::t('app','Quantity Update'),
                        'is_donation'=>Yii::t('app','Is Donation'),
                        'stock_alert'=>Yii::t('app','Stock Alert'),
		);
	}
    
    public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('idProduct');
		$criteria->compare('id',$this->id);
		$criteria->compare('id_product',$this->id_product);
                $criteria->compare('idProduct.product_name',$this->product_name, true);
		$criteria->compare('quantity',$this->quantity);
		$criteria->compare('acquisition_date',$this->acquisition_date,true);
		$criteria->compare('buiying_price',$this->buiying_price);
		$criteria->compare('selling_price',$this->selling_price);
		$criteria->compare('is_donation',$this->is_donation);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function searchProductName($condition){
                $criteria=new CDbCriteria;
                $criteria->condition = $condition;
                $criteria->alias = 's';
                $criteria->select = 's.id_product, s.id, p.id, p.stock_alert, p.description, p.product_name, s.quantity, s.buiying_price, s.selling_price ';
                $criteria->join = 'inner join products p on (s.id_product = p.id) ';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }

public function getBuyingPrice(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->buiying_price);
        }	


public function getSellingPrice(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->selling_price);
        }	

    
}