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




class LoanOfMoney extends BaseLoanOfMoney
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LoanOfMoney the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


   
    public $employee_lname; 
	public $employee_fname;
	public $teacher_lname; 
	public $teacher_fname; 
	public $academic_year;
	public $total_loan;
	public $repayment_start_on;
	
	 public $depensesItems;
	
				
 public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   
									
		));
	}
 
	  
  public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                    'employee_fname'=> Yii::t('app','Employee First Name'),
                        'employee_lname'=> Yii::t('app','Employee Last Name'),
                        'teacher_fname'=> Yii::t('app','Teacher First Name'),
                        'teacher_lname'=> Yii::t('app','Teacher Last Name'),
                        'repayment_start_on'=>Yii::t('app','Repayment start on'),
                        'depensesItems'=> Yii::t('app','Depenses Items'),
                                    
                        )
                    );
           
	}
	


public function search_($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
 
		$criteria->with=array('academicYear','person');
		
		$criteria->join='left join persons p on(p.id=l.person_id)';
		
		$criteria->alias='l';
		$criteria->condition='l.academic_year='.$acad;

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('p.first_name',$this->employee_fname,true);
		$criteria->compare('p.last_name',$this->employee_lname,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('deduction_percentage',$this->deduction_percentage);
		$criteria->compare('solde',$this->solde);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('number_of_month_repayment',$this->number_of_month_repayment);
		$criteria->compare('remaining_month_number',$this->remaining_month_number);
		$criteria->compare('loan_date',$this->date_created,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
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
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('deduction_percentage',$this->deduction_percentage);
		$criteria->compare('solde',$this->solde);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('number_of_month_repayment',$this->number_of_month_repayment);
		$criteria->compare('remaining_month_number',$this->remaining_month_number);
		$criteria->compare('loan_date',$this->date_created,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
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
		$criteria->with=array('academicYear','person');
		
		$criteria->join='left join persons p on(p.id=l.person_id)';
		
		$criteria->alias='l';
		$criteria->condition='MONTH(l.loan_date)='.$month_.' AND  l.academic_year='.$acad;
		$criteria->order = 'person.last_name ASC, payroll_month ASC';

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('p.first_name',$this->employee_fname,true);
		$criteria->compare('p.last_name',$this->employee_lname,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('deduction_percentage',$this->deduction_percentage);
		$criteria->compare('solde',$this->solde);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('number_of_month_repayment',$this->number_of_month_repayment);
		$criteria->compare('remaining_month_number',$this->remaining_month_number);
		$criteria->compare('loan_date',$this->date_created,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);

	    
		//$criteria->compare('id',$this->id_bill, true); 

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	

				
	public function searchForView($person,$acad) //il fo cree colonne academic_year ds la table BILLINGS
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('academicYear','person');
		
		$criteria->join='left join persons p on(p.id=l.person_id)';
		
		$criteria->alias='l';
		$criteria->condition='l.person_id ='.$person.' AND  l.academic_year='.$acad;
		$criteria->order = 'person.last_name ASC, payroll_month ASC';

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('p.first_name',$this->employee_fname,true);
		$criteria->compare('p.last_name',$this->employee_lname,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('deduction_percentage',$this->deduction_percentage);
		$criteria->compare('solde',$this->solde);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('number_of_month_repayment',$this->number_of_month_repayment);
		$criteria->compare('remaining_month_number',$this->remaining_month_number);
		$criteria->compare('loan_date',$this->date_created,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
	    
		//$criteria->compare('id',$this->id_bill, true); 

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	
	
	
	
	//return the sum of all loan in this month
public function hasLoan($person,$month){
     
    	$criteria = new CDbCriteria;
			
			
			 $criteria->condition = 'ps.old_new=1 AND ps.person_id ='.$person.' AND payroll_month ='.$month;
			$criteria->alias = 'l';
			$criteria->select = 'l.id, l.amount, l.payroll_month,l.paid,l.deduction_percentage,l.solde,l.remaining_month_number, l.loan_date';
            $criteria->join = 'left join payroll_settings ps on (ps.person_id = l.person_id)';
            
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000000,
    			),
		'criteria'=>$criteria,
    ));
   
   
    }
   

//return the sum of all loan in this month
public function isPaid($person){
     
    	$criteria = new CDbCriteria;
			
			
			 $criteria->condition = 'l.person_id ='.$person;
			$criteria->alias = 'l';
			$criteria->select = 'l.id, l.amount, l.payroll_month,l.paid,l.deduction_percentage,l.solde, l.loan_date';
			$criteria->order ='l.date_created DESC';
           
            
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000000000,
    			),
		'criteria'=>$criteria,
    ));
   
   
    }


  
public function getTotalLoan($person, $acad)
  {
     
    	  $sql='SELECT SUM(amount) as total_loan FROM loan_of_money  WHERE person_id ='.$person.' AND  academic_year='.$acad;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           foreach($result as $r)
            return $r["total_loan"];   
   
    }

public function getTotalSolde($person, $acad)
  {
     
    	  $sql='SELECT SUM(solde) as total_solde FROM loan_of_money  WHERE person_id ='.$person.' AND  academic_year='.$acad;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           foreach($result as $r)
            return $r["total_solde"];   
   
    }
    
 	 public function getAmount(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->amount);
        }
    	 public function getSolde(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->solde);
        }
    


  public function getLoanDate(){
            $time = strtotime($this->loan_date);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
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
        13=>Yii::t('app','13 eme'),
        14=>Yii::t('app','14 eme'),
        );  
    }
   

// Return the name of a month in long format 
public function getSelectedLongMonth($month){
    switch ($month){
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
        case 13:
            return Yii::t('app','13 eme');
            break;

        case 14:
            return Yii::t('app','14 eme');
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
         case 13:
            return Yii::t('app','13 eme');
            break;
         case 14:
            return Yii::t('app','14 eme');
            break;


    }
   }

                  
// Return the name of a month in long format 
public function getloanPaid(){
    switch ($this->paid){
        case 0:
            return Yii::t('app','No');
            break;
        case 1:
            return Yii::t('app','Yes');
            break;
       
    }
   }

	
	
	
	
	
	
}