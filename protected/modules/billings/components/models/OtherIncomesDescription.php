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





class OtherIncomesDescription extends BaseOtherIncomesDescription
{
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
 public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   array('income_description', 'unique'),
                   
									
		));
	}



public function getCategory()
			{
			
		        
      // $params= array(':categ'=>$this->category);
           $sql='select category from label_category_for_billing lcb where id = :categ ';
	
         $result= Yii::app()->db->createCommand($sql)->queryAll(true, array(':categ'=> $this->category));

    		             if((isset($result))&&($result!=null))
		               { 
		               	   foreach($result as $r)
		               	     return Yii::t('app',$r['category']);
		               
		               }
		             else
		                 return null;
		                             
			}
			
		

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->alias = 'oid';
		$criteria->order = 'oid.category ASC';
		//$criteria->join='inner join label_category_for_billing lcb on(oid.category = lcb.id)';


		$criteria->compare('id',$this->id);
		$criteria->compare('income_description',$this->income_description,true);
		$criteria->compare('oid.category',$this->category,true);
		//$criteria->compare('lcb.category',$this->category);
		$criteria->compare('comment',$this->comment,true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),

		));
	}
}