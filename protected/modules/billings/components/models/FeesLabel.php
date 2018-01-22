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
/**
 * This is the model class for table "fees_label".
 *
 * The followings are the available columns in table 'fees_label':
 * @property integer $id
 * @property string $fee_label
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Fees[] $fees
 */
class FeesLabel extends BaseFeesLabel
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return FeesLabel the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
	
		 /**
         * 
         * @return type Status value 
         * 0 ->  
         * 1 -> 
         */
        public function getStatus(){
            switch($this->status)
            {
                case 0:
                    return Yii::t('app','Other fees');
                case 1:
                    return Yii::t('app','Tuition fees');
                
            }
        }
        
        /**
         * 
         * @return type
         * Return human readable value for status from the DB 
         * 
         */
         public function getStatusValue(){
            return array(
                
                0=>Yii::t('app','Other fees'),
                1=>Yii::t('app','Tuition fees'),
                
                               
            );            
        } 		
	
	  
public function getFeeLabel(){
           
            	return Yii::t('app',$this->fee_label);
               
           
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

		$criteria->compare('id',$this->id);
		$criteria->compare('fee_label',$this->fee_label,true);
		$criteria->compare('status',$this->status);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			 'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}
	
	 
	
	
	
}










