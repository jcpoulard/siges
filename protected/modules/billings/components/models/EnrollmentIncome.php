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

/**
 * This is the model class for table "enrollment_income".
 *
 * The followings are the available columns in table 'enrollment_income':
 * @property integer $id
 * @property integer $postulant
 * @property integer $apply_level
 * @property double $amount
 * @property integer $payment_method
 * @property string $comments
 * @property string $payment_date
 * @property integer $academic_year
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Levels $applyLevel
 */
class EnrollmentIncome extends BaseEnrollmentIncome
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return EnrollmentIncome the static model class
	 */
	
	public $recettesItems;
	public $fee_period;
	public $apply_for_level;
	public $first_name;
	public $last_name;
	
	
	
	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'enrollment_income';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   array('first_name,last_name', 'length', 'max'=>45),
			       //array('full_name, employee_lname, employee_fname,academic_year,date_payroll', 'length', 'max'=>65),
                  // array('person_id+as+academic_year', 'application.extensions.uniqueMultiColumnValidator'),
           array('id, postulant, first_name, last_name, apply_level, amount, paymentMethod, comments, payment_date, academic_year, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),        
                 					
		));
	}

	//'academicPeriod' => array(self::BELONGS_TO, 'Academicperiods', 'academic_year'),
	//'applyLevel' => array(self::BELONGS_TO, 'Levels', 'apply_level'),
	//'paymentMethod' => array(self::BELONGS_TO, 'PaymentMethod', 'payment_method'),

	
public function attributeLabels()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
             return array_merge(
		    	parent::attributeLabels(), array(
			               'recettesItems' =>Yii::t('app','Recettes Items'),
		));
	}		
		



   public function getFullName(){
       
  	
		 
		$postu=Postulant::model()->findByPk($this->postulant);
        
			
		    if(isset($postu))
				return $postu->first_name.' '.$postu->last_name;
		
	}

   
public function getAmount(){
            $currency_name = Yii::app()->session['currencyName'];
	        $currency_symbol = Yii::app()->session['currencySymbol']; 

            return $currency_symbol.' '.numberAccountingFormat($this->amount);
        }
        
  public function getPaymentDate(){
            if(($this->payment_date!=null)&&($this->payment_date!='0000-00-00'))
             {  $time = strtotime($this->payment_date);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;  
             }
           else
             return '00/00/0000'; 
           	   
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
		$criteria->alias='e';
		///$criteria->with=array('academicPeriod','applyLevel');
		$criteria->join='inner join postulant p on(p.id=e.postulant)';
		$criteria->condition = 'e.academic_year='.$acad;

		$criteria->compare('e.id',$this->id);
		$criteria->compare('postulant',$this->postulant);
		$criteria->compare('p.first_name',$this->first_name,true);
		$criteria->compare('p.last_name',$this->last_name,true);
		$criteria->compare('e.apply_level',$this->apply_level);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('e.academic_year',$this->academic_year,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}