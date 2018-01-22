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

class SaleTransaction extends BaseSaleTransaction{
    
    public $total_cash;
    public $total_discount;
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }
    
    public function getTotalCash($date1, $date2){
            $sum = 0.00; 
            
            $sql_string = "SELECT sum(amount_sale) AS total_cash FROM sale_transaction WHERE date(create_date) >='$date1' AND date(create_date)<='$date2'";
            $data = SaleTransaction::model()->findAllBySql($sql_string);
            foreach($data as $d){
                $sum = $d->total_cash;
            }
            
            if($sum!=0.00){
                return $sum;
            }else{
                return 0.00;
            }
        }
        
    public function getTotalDiscount($date1, $date2){
        $sum = 0.00; 
            
            $sql_string = "SELECT sum(discount) AS total_discount FROM sale_transaction WHERE date(create_date) >='$date1' AND date(create_date)<='$date2'";
            $data = SaleTransaction::model()->findAllBySql($sql_string);
            foreach($data as $d){
                $sum = $d->total_discount;
            }
            
            if($sum!=0.00){
                return $sum;
            }else{
                return 0.00;
            }
    }    
    
    
}
