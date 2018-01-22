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

?>
<?php


class Products extends BaseProducts{
    
    
    public $buying_price;
    public $selling_price; 
	public $quantity;
    
    
    public static function model($className=__CLASS__)
        {
            return parent::model($className);
        }
    
    public function rules(){
        return array_merge(
                parent::rules(),
                array(
                     array('product_name','unique')
                    )
                ); 
    }
 
        
		   // getMessage
		       public function getMessage($field, $message, $params){
            
		                $this->addError($field, strtr($message, $params));
            
		        }
 
    public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app', 'ID'),
			'product_name' =>Yii::t('app','Product Name'),
			
			'description' =>Yii::t('app','Description'),
			'stock_alert' =>Yii::t('app','Stock Alert'),
			'create_by'   =>Yii::t('app',  'Create By'),
			'update_by'   =>Yii::t('app',  'Update By'),
			'date_create' =>Yii::t('app','Date Create'),
			'date_update' =>Yii::t('app','Date Update'),
                        'id_products'=>Yii::t('app','Id Products')
		);
	}



public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->alias = "p";
                $criteria->join = 'inner join stocks s on (s.id_product = p.id)';
               
		$criteria->compare('id',$this->id);
		$criteria->compare('product_name',$this->product_name,true);
		
		$criteria->compare('description',$this->description,true);
		$criteria->compare('stock_alert',$this->stock_alert);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
                $criteria->compare('s.buiying_price',$this->buying_price,true);
                $criteria->compare('s.selling_price',$this->selling_price,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
 
 
 
 
 
 
    
}

