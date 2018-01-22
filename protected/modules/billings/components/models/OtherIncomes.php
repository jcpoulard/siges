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




class OtherIncomes extends BaseOtherIncomes
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return OtherIncomes the static model class
	 */
	 
   public $recettesItems;
 
 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	


public function attributeLabels()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
             return array_merge(
		    	parent::attributeLabels(), array(
			               'recettesItems' =>Yii::t('app','Recettes Items'),
		));
	}		
			



	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('idIncomeDescription','academicYear');
		
		$criteria->condition = 'academic_year='.$acad;

		$criteria->compare('id',$this->id);
		$criteria->compare('id_income_description',$this->id_income_description);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('income_date',$this->income_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	
	
	
	
public function searchByMonth($current_month, $acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('idIncomeDescription','academicYear');
		
		$criteria->condition = 'MONTH(income_date)='.$current_month.' AND academic_year='.$acad;
		
		$criteria->order = 'idIncomeDescription.income_description ASC, income_date ASC';

		$criteria->compare('id',$this->id);
		$criteria->compare('id_income_description',$this->id_income_description);
		//$criteria->compare('idIncomeDescription.income_description',$this->income_description,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('income_date',$this->income_date,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}

	
	
	
	
	 public function getAmount(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->amount);
        }
	
	
	
	       public function getIncomeDate(){
            $time = strtotime($this->income_date);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }

	
	
	
	
}