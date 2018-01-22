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




class ChargePaid extends BaseChargePaid
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ChargePaid the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public $charge_description;
	public $depensesItems;
	
	
				
 public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   array('charge_description', 'length', 'max'=>200),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_charge_description, comment, charge_description, amount, payment_date, month, academic_year, created_by', 'safe', 'on'=>'search'),
                   
									
		));
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
		$criteria->compare('id_charge_description',$this->id_charge_description);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	
public function searchByMonth($month_, $acad)  //il fo cree colonne academic_year ds la table BILLINGS
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('idChargeDescription','academicYear');
		
		$criteria->condition = 'MONTH(payment_date)='.$month_.' AND academic_year='.$acad;
		//$criteria->params = array( ':acad1'=>$acad,':acad2'=>$acad);
		$criteria->order = ' payment_date DESC';
		
		$criteria->compare('id',$this->id);
		$criteria->compare('id_charge_description',$this->id_charge_description,true);
		$criteria->compare('idChargeDescription.description',$this->charge_description,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('academic_year',$this->academic_year,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));


	}	
	
	
 public function getAmount(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->amount);
        }	

 public function getExpenseDate(){
            
            
             if(($this->payment_date!='')&&($this->payment_date!='0000-00-00'))
              { $time = strtotime($this->payment_date);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
               return $day.'/'.$month.'/'.$year; 
               }
             else
                return '00/00/0000';     
        }

		
 	
	
// Return the key=>value  of a month in long format 
public function getLongMonthValue(){
     return array(
        1=>Yii::t('app','January'),
        2=>Yii::t('app','February'),
        3=>Yii::t('app','March'),
        4=>Yii::t('app','April'),
        5=>Yii::t('app','May'),
        6=>Yii::t('app','June'),
        7=>Yii::t('app','July'),
        8=>Yii::t('app','August'),
        9=>Yii::t('app','September'),
        10=>Yii::t('app','October'),
        11=>Yii::t('app','November'),
        12=>Yii::t('app','December'),
        );  
    }
 
 
 // Return the key=>value  of a month in long format 
public function getIdLongMonth($month){
     switch ($month){
        case Yii::t('app','January'):
            return 1;
            break;
        case Yii::t('app','February'):
            return 2;
            break;
        case Yii::t('app','March'):
            return 3;
            break;
        case Yii::t('app','April'):
            return 4;
            break;
        case Yii::t('app','May'):
            return 5;
            break;
        case Yii::t('app','June'):
            return 6;
            break;
        case Yii::t('app','July'):
            return 7;
            break;
        case Yii::t('app','August'):
            return 8;
            break;
        case Yii::t('app','September'):
            return 9;
            break;
        case Yii::t('app','October'):
            return 10;
            break;
        case Yii::t('app','November'):
            return 11;
            break;
        case Yii::t('app','December'):
            return 12;
            break;
    }

 }
   
  

// Return the name of a month in long format 
public function getLongMonth(){
    switch ($this->payroll_month){
        case 1:
            return Yii::t('app','January');
            break;
        case 2:
            return Yii::t('app','February');
            break;
        case 3:
            return Yii::t('app','March');
            break;
        case 4:
            return Yii::t('app','April');
            break;
        case 5:
            return Yii::t('app','May');
            break;
        case 6:
            return Yii::t('app','June');
            break;
        case 7:
            return Yii::t('app','July');
            break;
        case 8:
            return Yii::t('app','August');
            break;
        case 9:
            return Yii::t('app','September');
            break;
        case 10:
            return Yii::t('app','October');
            break;
        case 11:
            return Yii::t('app','November');
            break;
        case 12:
            return Yii::t('app','December');
            break;
    }
   }
	
	
	
	
}