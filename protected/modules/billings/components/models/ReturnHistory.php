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

class ReturnHistory extends BaseReturnHistory{
    
    public $total_amount_return; 
    public $product_name;
    public $selling_price;
    
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getTotalAmountReturn($id){
        $sum = 0.00; 
        if($id!=null){
        $sql_string = "SELECT sum(return_amount) as total_amount_return FROM return_history WHERE id_transaction = $id";
        $data = ReturnHistory::model()->findAllBySql($sql_string); 
        foreach($data as $d){
            $sum = $d->total_amount_return; 
            
        }
        
        if($sum!=0.00){
            return $sum;
        }else{
            return 0.00; 
        }
        }
        else{
            return 0.00;
        }
    }
    
    public function searchReturnHistory($condition){
        
                $criteria=new CDbCriteria;
                $criteria->condition = $condition;
                $criteria->alias = 'r';
                $criteria->select = 'r.id, r.id_transaction, r.id_product, p.product_name, s.selling_price, r.return_amount, r.return_quantity, r.date_return ';
                $criteria->join = 'JOIN products p on (r.id_product = p.id) JOIN stocks s ON (r.id_product = s.id_product)';
                
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
        }
    
    
}
