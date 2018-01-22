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

/**
 * This is the model class for table "reservation".
 *
 * The followings are the available columns in table 'reservation':
 * @property integer $id
 * @property integer $postulant_student
 * @property integer $is_student
 * @property double $amount
 * @property integer $payment_method
 * @property string $payment_date
 * @property integer $already_checked
 * @property string $comments
 * @property integer $academic_year
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 */
class Reservation extends BaseReservation
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Reservation the static model class
	 */
public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
public function tableName()
	{
		return 'reservation';
	}

public $recettesItems;
public $postulant_or_student;

public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
             return array_merge(
		    	parent::rules(),
		 array(
			     array('id, postulant_student, student, academic_year, student_fullname, student_fname, student_lname, method_fname, fee_fname, fee_period, amount_to_pay, amount_pay, balance, date_pay, payment_method, comments, date_created, date_updated, created_by, updated_by', 'safe', 'on'=>'search'),
		));
	}


public function attributeLabels()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
             return array_merge(
		    	parent::attributeLabels(), array(
			               'postulant_or_student' =>Yii::t('app','Postulant or Student'),
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
		$criteria->with= array('academicperiods0','paymentMethod');
		
		$criteria->condition = 'academic_year='.$acad;
		
		$criteria->order = 'payment_date ASC';

		$criteria->alias='r';
		

		$criteria->compare('id',$this->id);
		$criteria->compare('postulant_student',$this->postulant_student);
		$criteria->compare('is_student',$this->is_student);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('already_checked',$this->already_checked);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			
		));
	}
	
	
	
	
public function getPersonFullName(){
       
       $full_name='';
       
       if($this->is_student==0)//postulant
        {
        	$modelPos = Postulant::model()->findByPk($this->postulant_student);
        	$full_name= $modelPos->getFullName();
        	}
       elseif($this->is_student==1)//student
         {
         	$modelPos = Persons::model()->findByPk($this->postulant_student);
        	  $full_name= $modelPos->getFullName();
         	}
       
       
       return $full_name;
   }

	
	
  public function getIsStudent(){
            switch($this->is_student)
            {
                case 0:
                    return Yii::t('app','No');
                case 1:
                    return Yii::t('app','Yes');
               
            }
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
	
	
	
//return an array(id, amount) or null value	
public function getNonCheckedReservation($student, $previous_acad)
	{   	    
       $sql='SELECT id, amount FROM reservation WHERE already_checked=0 AND is_student=1 AND postulant_student ='.$student.' AND academic_year='.$previous_acad;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
       return $result;
           
 }

	
	
	
	
	
	
	
	
	
	
	
	
	
}