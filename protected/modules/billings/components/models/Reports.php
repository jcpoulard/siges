<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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



	
// auto-loading



class Reports extends CFormModel
{
	/*public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
  */
	
	public $start_date;
	public $end_date;
	
	public $payroll_month;
        

/**/public function attributeLabels()
	{	
            return array(
                        'payroll_month' =>  Yii::t('app','Payroll Month'),
                      
                    );    
	}
	
	
	
	

 public static function getIncomeLabel()
  {
		$command= Yii::app()->db->createCommand("SELECT id, category FROM label_category_for_billing WHERE income_expense='ri'");
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }
       	

 public static function getExpenseLabel()
  {
		$command= Yii::app()->db->createCommand("SELECT id, category FROM label_category_for_billing WHERE income_expense='di'");
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }


public static function getDescriptionChargeByIdCategory($label_id)
  {
		$command= Yii::app()->db->createCommand("SELECT id, description FROM charge_description WHERE category=".$label_id);
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }
    	



//TUITION
public static function getTotalAmountForTuitionByMonth($month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {  $command= Yii::app()->db->createCommand("SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id)  WHERE fl.status=1 AND academic_year=".$acad." AND month(date_pay)=".$month);
		 
		 }
		elseif($siges_structure==1)
		 {  $command= Yii::app()->db->createCommand("SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id) INNER JOIN academicperiods ap ON(ap.id=b.academic_year) WHERE fl.status=1 AND year=".$acad." AND month(date_pay)=".$month);
		 
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }

public static function getTotalAmountForTuitionByDateStartAndMonth($date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {  $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id)  WHERE fl.status=1 AND academic_year='.$acad.' AND (month(date_pay)='.$month.' AND date_pay >=\''.$date.'\')');
		 }
	 elseif($siges_structure==1)
		 {  $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id) INNER JOIN academicperiods ap ON(ap.id=b.academic_year)  WHERE fl.status=1 AND year='.$acad.' AND (month(date_pay)='.$month.' AND date_pay >=\''.$date.'\')');
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }

public static function getTotalAmountForTuitionByDateEndAndMonth($date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {  $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id)  WHERE fl.status=1 AND academic_year='.$acad.' AND (month(date_pay)='.$month.' AND date_pay <=\''.$date.'\')');
		 }
	 elseif($siges_structure==1)
		 {  $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id) INNER JOIN academicperiods ap ON(ap.id=b.academic_year)  WHERE fl.status=1 AND year='.$acad.' AND (month(date_pay)='.$month.' AND date_pay <=\''.$date.'\')');
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }


//ENROLLMENT

public static function getTotalAmountForEnrollmentByMonth($month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {  $command= Yii::app()->db->createCommand("SELECT SUM(amount) total_amount  FROM enrollment_income ei WHERE month(payment_date)=".$month." AND academic_year=".$acad);
		 
		 }
	    elseif($siges_structure==1)
		 {  $command= Yii::app()->db->createCommand("SELECT SUM(amount) total_amount  FROM enrollment_income ei INNER JOIN academicperiods ap ON(ap.id=ei.academic_year) WHERE month(payment_date)=".$month." AND year=".$acad);
		 
		 }
		 
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }

public static function getTotalAmountForEnrollmentByDateStartAndMonth($date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {  $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM enrollment_income ei  WHERE academic_year='.$acad.' AND month(payment_date)='.$month.' AND payment_date >=\''.$date.'\'');
		 }
	    elseif($siges_structure==1)
		 {  
		 	$command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM enrollment_income ei INNER JOIN academicperiods ap ON(ap.id=ei.academic_year) WHERE year='.$acad.' AND (month(payment_date)='.$month.' AND payment_date >=\''.$date.'\')');
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }

public static function getTotalAmountForEnrollmentByDateEndAndMonth($date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {  $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM enrollment_income ei  WHERE academic_year='.$acad.' AND month(payment_date)='.$month.' AND payment_date <=\''.$date.'\'');
		 }
	    elseif($siges_structure==1)
		 {  
		 	$command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM enrollment_income ei INNER JOIN academicperiods ap ON(ap.id=ei.academic_year) WHERE year='.$acad.' AND (month(payment_date)='.$month.' AND payment_date <=\''.$date.'\')');
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }





//ORTHER FEE
public static function getTotalAmountForOtherFeeByMonth($month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand("SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id) inner join academicperiods ap ON(ap.id=b.academic_year) WHERE fl.status=0 AND academic_year=".$acad." AND month(date_pay)=".$month);
		 
		 }
	  elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand("SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id) inner join academicperiods ap ON(ap.id=b.academic_year) WHERE fl.status=0 AND year=".$acad." AND month(date_pay)=".$month);
		 
		 }
		

		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }

public static function getTotalAmountForOtherFeeByDateStartAndMonth($date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id)  WHERE fl.status=0 AND academic_year='.$acad.' AND (month(date_pay)='.$month.' AND date_pay >=\''.$date.'\')');
		 
		 }
	   elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id) inner join academicperiods ap on(ap.id=b.academic_year) WHERE fl.status=0 AND year='.$acad.' AND (month(date_pay)='.$month.' AND date_pay >=\''.$date.'\')');
		 
		 }
	   
	   
	   
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }
  
public static function getTotalAmountForOtherFeeByDateEndAndMonth($date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id)  WHERE fl.status=0 AND academic_year='.$acad.' AND (month(date_pay)='.$month.' AND date_pay <=\''.$date.'\')');
		 
		 }
	  elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) total_amount  FROM billings b inner join fees f on(b.fee_period = f.id) inner join fees_label fl on(f.fee=fl.id) inner join academicperiods ap on(ap.id=b.academic_year) WHERE fl.status=0 AND year='.$acad.' AND (month(date_pay)='.$month.' AND date_pay <=\''.$date.'\')');
		 
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }







//OTHER INCOME
public static function getTotalAmountForOtherIncomeByMonth($desciption_id,$month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM other_incomes oi inner join other_incomes_description oid on(oi.id_income_description = oid.id)  WHERE academic_year='.$acad.' AND oid.category='.$desciption_id.' AND month(income_date)='.$month);
		 
		 }
	  elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM other_incomes oi inner join other_incomes_description oid on(oi.id_income_description = oid.id) inner join academicperiods ap on(ap.id=oi.academic_year) WHERE year='.$acad.' AND oid.category='.$desciption_id.' AND month(income_date)='.$month);
		 
		 }
		

		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }

public static function getTotalAmountForOtherIncomeByDateStartAndMonth($desciption_id,$date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM other_incomes oi inner join other_incomes_description oid on(oi.id_income_description = oid.id)  WHERE academic_year='.$acad.' AND oid.category='.$desciption_id.' AND (month(income_date)='.$month.' AND income_date >=\''.$date.'\')');
		 
		 }
	   elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM other_incomes oi inner join other_incomes_description oid on(oi.id_income_description = oid.id) inner join academicperiods ap on(ap.id=oi.academic_year) WHERE year='.$acad.' AND oid.category='.$desciption_id.' AND (month(income_date)='.$month.' AND income_date >=\''.$date.'\')');
		 
		 }
		 
		 
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }
  
public static function getTotalAmountForOtherIncomeByDateEndAndMonth($desciption_id,$date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM other_incomes oi inner join other_incomes_description oid on(oi.id_income_description = oid.id)  WHERE academic_year='.$acad.' AND oid.category='.$desciption_id.' AND (month(income_date)='.$month.' AND income_date <=\''.$date.'\')');
		 
		 }
       elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount  FROM other_incomes oi inner join other_incomes_description oid on(oi.id_income_description = oid.id) inner join academicperiods ap on(ap.id=oi.academic_year) WHERE year='.$acad.' AND oid.category='.$desciption_id.' AND (month(income_date)='.$month.' AND income_date <=\''.$date.'\')');
		 
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }






//POS
public static function getTotalAmountForPOSByMonth($month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { 
		 	$command= Yii::app()->db->createCommand('SELECT SUM(amount_sale) total_amount, SUM(st.discount) total_discount FROM sale_transaction st WHERE  academic_year='.$acad.' AND month(st.create_date)='.$month);
		 
		 }
	   elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_sale) total_amount, SUM(st.discount) total_discount FROM sale_transaction st inner join academicperiods ap on(ap.id = st.academic_year) WHERE  year='.$acad.' AND month(st.create_date)='.$month);
		 
		 }
		

		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }

public static function getTotalAmountForPOSByDateStartAndMonth($date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_sale) total_amount, SUM(st.discount) total_discount FROM sale_transaction st WHERE  academic_year='.$acad.' AND (month(st.create_date)='.$month.' AND st.create_date >=\''.$date.'\')');
		 
		 }
	   elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_sale) total_amount, SUM(st.discount) total_discount FROM sale_transaction st inner join academicperiods ap on(ap.id = st.academic_year) WHERE  year='.$acad.' AND (month(st.create_date)='.$month.' AND st.create_date >=\''.$date.'\')');
		 
		 }	 
		 
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }
  
public static function getTotalAmountForPOSByDateEndAndMonth($date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_sale) total_amount, SUM(st.discount) total_discount FROM sale_transaction st WHERE academic_year='.$acad.' AND (month(st.create_date)='.$month.' AND st.create_date <=\''.$date.'\')');
		 
		 }
	   elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount_sale) total_amount, SUM(st.discount) total_discount FROM sale_transaction st inner join academicperiods ap on(ap.id = st.academic_year) WHERE year='.$acad.' AND (month(st.create_date)='.$month.' AND st.create_date <=\''.$date.'\')');
		 
		 }
		 
		 
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }







//EXPENSES
 public static function getTotalAmountExpenseByDescriptionAndMonth($description_id, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount FROM charge_paid cp inner join charge_description cd on(cp.id_charge_description = cd.id)  WHERE  academic_year='.$acad.' AND cd.id='.$description_id.' AND month(cp.payment_date)='.$month);
		 
		 }
		elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount FROM charge_paid cp inner join charge_description cd on(cp.id_charge_description = cd.id) inner join academicperiods ap on(ap.id=cp.academic_year) WHERE  year='.$acad.' AND cd.id='.$description_id.' AND month(cp.payment_date)='.$month);
		 
		 } 
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }

public static function getTotalAmountExpenseByDescriptionAndDateStartAndMonth($description_id,$date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount FROM charge_paid cp inner join charge_description cd on(cp.id_charge_description = cd.id)  WHERE academic_year='.$acad.' AND cd.id='.$description_id.' AND  (month(cp.payment_date)='.$month.' AND cp.payment_date >=\''.$date.'\')');
		 
		 }
		elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount FROM charge_paid cp inner join charge_description cd on(cp.id_charge_description = cd.id) inner join academicperiods ap on(ap.id=cp.academic_year) WHERE year='.$acad.' AND cd.id='.$description_id.' AND  (month(cp.payment_date)='.$month.' AND cp.payment_date >=\''.$date.'\')');
		 
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }
  
public static function getTotalAmountExpenseByDescriptionAndDateEndAndMonth($description_id,$date, $month)
  {
		$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount FROM charge_paid cp inner join charge_description cd on(cp.id_charge_description = cd.id)  WHERE academic_year='.$acad.' AND cd.id='.$description_id.' AND  (month(cp.payment_date)='.$month.' AND cp.payment_date <=\''.$date.'\')');
		 
		 }
		elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(amount) total_amount FROM charge_paid cp inner join charge_description cd on(cp.id_charge_description = cd.id) inner join academicperiods ap on(ap.id=cp.academic_year) WHERE year='.$acad.' AND cd.id='.$description_id.' AND  (month(cp.payment_date)='.$month.' AND cp.payment_date <=\''.$date.'\')');
		 
		 }
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
  }







//PAYROLL
public static function getTotalAmountForPayrollByDateStartAndMonth($date, $month)
   {
   	     $acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(net_salary) total_amount,SUM(taxe) total_taxe FROM payroll p inner join payroll_settings ps on(ps.id=p.id_payroll_set) WHERE academic_year='.$acad.' AND  (month(p.payment_date)='.$month.' AND p.payment_date >=\''.$date.'\')');
		 
		 }
		elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(net_salary) total_amount,SUM(taxe) total_taxe FROM payroll p inner join payroll_settings ps on(ps.id=p.id_payroll_set) inner join academicperiods ap on (ap.id=ps.academic_year) WHERE year='.$acad.' AND  (month(p.payment_date)='.$month.' AND p.payment_date >=\''.$date.'\')');
		 
		 } 
		 
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	}



public static function getTotalAmountForPayrollByDateEndAndMonth($date, $month)
   {
   	    $acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(net_salary) total_amount,SUM(taxe) total_taxe FROM payroll p inner join payroll_settings ps on(ps.id=p.id_payroll_set) WHERE academic_year='.$acad.' AND (month(p.payment_date)='.$month.' AND p.payment_date <=\''.$date.'\')');
		 
		 }
		elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(net_salary) total_amount,SUM(taxe) total_taxe FROM payroll p inner join payroll_settings ps on(ps.id=p.id_payroll_set) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE year='.$acad.' AND (month(p.payment_date)='.$month.' AND p.payment_date <=\''.$date.'\')');
		 
		 } 
		 
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	}


public static function getTotalAmountForPayrollByMonth( $month)
  {
   	      $acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(net_salary) total_amount,SUM(taxe) total_taxe FROM payroll p inner join payroll_settings ps on(ps.id=p.id_payroll_set) WHERE academic_year='.$acad.' AND  month(p.payment_date)='.$month);
		 
		 }
		elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT SUM(net_salary) total_amount,SUM(taxe) total_taxe FROM payroll p inner join payroll_settings ps on(ps.id=p.id_payroll_set) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE year='.$acad.' AND  month(p.payment_date)='.$month);
		 
		 }


		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	}







//ONA

//pran tout moun ki nan payroll pou kondisyon sas yo
public static function getPersonIdtForONAByDateStartAndMonth($acad, $date, $month)
   {
   	    $acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {   //pran tout moun ki nan payroll pou kondisyon sas yo
   	         $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll p INNER JOIN payroll_settings ps  ON(ps.id=p.id_payroll_set) WHERE month(p.payment_date)='.$month.' AND p.payment_date >=\''.$date.'\' AND ps.academic_year='.$acad);
   	         
		 }
		else if($siges_structure==1)
		 {   //pran tout moun ki nan payroll pou kondisyon sas yo
   	         $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll p INNER JOIN payroll_settings ps  ON(ps.id=p.id_payroll_set) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE month(p.payment_date)='.$month.' AND p.payment_date >=\''.$date.'\' AND year='.$acad);
   	         
		 }
		 
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   
   
public static function getPersonIdtForONAByDateEndAndMonth($acad, $date, $month)
   {
   	   $acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {    //pran tout moun ki nan payroll pou kondisyon sas yo
   	         $command= Yii::app()->db->createCommand('SELECT distinct ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll p INNER JOIN payroll_settings ps ON(ps.id=p.id_payroll_set) WHERE  month(p.payment_date)='.$month.' AND p.payment_date <=\''.$date.'\' AND ps.academic_year='.$acad);
		 }
		elseif($siges_structure==1)
		 {    //pran tout moun ki nan payroll pou kondisyon sas yo
   	         $command= Yii::app()->db->createCommand('SELECT distinct ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll p INNER JOIN payroll_settings ps ON(ps.id=p.id_payroll_set) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE  month(p.payment_date)='.$month.' AND p.payment_date <=\''.$date.'\' AND year='.$acad);
		 } 
		 
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   
 
 public static function getPersonIdtForONAByMonth($acad, $month)
   {
   	   $acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {  //pran tout moun ki nan payroll pou kondisyon sas yo
   	        $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll p INNER JOIN payroll_settings ps ON(ps.id=p.id_payroll_set) WHERE  month(p.payment_date)='.$month.' AND ps.academic_year='.$acad);
   	        
		 }
		elseif($siges_structure==1)
		 {  //pran tout moun ki nan payroll pou kondisyon sas yo
   	        $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll p INNER JOIN payroll_settings ps ON(ps.id=p.id_payroll_set) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE  month(p.payment_date)='.$month.' AND year='.$acad);
   	        
		 } 
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   
     
   	
 public static function getAmountForONA($acad, $ona_id, $person_id, $month)
   {
   	
   	   $acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT amount, number_of_hour FROM payroll_settings ps INNER JOIN payroll_setting_taxes pst ON(ps.id=pst.id_payroll_set) INNER JOIN payroll p ON(p.id_payroll_set=ps.id) WHERE MONTH(p.payment_date)='.$month.' AND pst.id_taxe ='.$ona_id.' AND ps.academic_year='.$acad.' AND ps.person_id ='.$person_id);
		 
		 }
		elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT amount, number_of_hour FROM payroll_settings ps INNER JOIN payroll_setting_taxes pst ON(ps.id=pst.id_payroll_set) INNER JOIN payroll p ON(p.id_payroll_set=ps.id) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE MONTH(p.payment_date)='.$month.' AND pst.id_taxe ='.$ona_id.' AND year='.$acad.' AND ps.person_id ='.$person_id);
		 
		 } 
		 
		
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	}








//TAXES
public static function getAmountForTax($acad, $tax_id, $person_id, $month)
   {
   	
   	   //$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { $command= Yii::app()->db->createCommand('SELECT amount, number_of_hour FROM payroll_settings ps INNER JOIN payroll_setting_taxes pst ON(ps.id=pst.id_payroll_set) INNER JOIN payroll p ON(p.id_payroll_set=ps.id) WHERE MONTH(p.payment_date)='.$month.' AND pst.id_taxe ='.$tax_id.' AND ps.academic_year='.$acad.' AND ps.person_id ='.$person_id);
		 
		 }
		elseif($siges_structure==1)
		 { $command= Yii::app()->db->createCommand('SELECT amount, number_of_hour FROM payroll_settings ps INNER JOIN payroll_setting_taxes pst ON(ps.id=pst.id_payroll_set) INNER JOIN payroll p ON(p.id_payroll_set=ps.id) inner join academicperiods ap ON(ap.id=ps.academic_year) WHERE MONTH(p.payment_date)='.$month.' AND pst.id_taxe ='.$tax_id.' AND year='.$acad.' AND ps.person_id ='.$person_id);
		 
		 }
		 
		 
		$sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	}








//TOP/TMS

//pran tout moun ki nan payroll pou kondisyon sas yo
public static function getPersonIdtForTMSByDateStartAndMonth($acad, $date, $month)
   {
   	  //$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {    //pran tout moun ki nan payroll pou kondisyon sas yo
   	         $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) WHERE ps.academic_year='.$acad.' AND (month(p.payment_date)='.$month.' AND p.payment_date >=\''.$date.'\')');
   	         
		 }
	else if($siges_structure==1)
		 {    //pran tout moun ki nan payroll pou kondisyon sas yo
   	         $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE year='.$acad.' AND (month(p.payment_date)='.$month.' AND p.payment_date >=\''.$date.'\')');
   	         
		 }

   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   
   
public static function getPersonIdtForTMSByDateEndAndMonth($acad, $date, $month)
   {
   	  //$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 {  //pran tout moun ki nan payroll pou kondisyon sas yo
   	        $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) WHERE ps.academic_year='.$acad.' AND (month(p.payment_date)='.$month.' AND p.payment_date <=\''.$date.'\')');
   	        
		 }
   	   elseif($siges_structure==1)
		 {  //pran tout moun ki nan payroll pou kondisyon sas yo
   	        $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE year='.$acad.' AND (month(p.payment_date)='.$month.' AND p.payment_date <=\''.$date.'\')');
   	        
		 }
		 
		 
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   
 
 public static function getPersonIdtForTMSByMonth($acad, $month)
   {
   	   //$acad = Yii::app()->session['currentId_academic_year'];
		$siges_structure = infoGeneralConfig('siges_structure_session');

	     
	   if($siges_structure==0)
		 { //pran tout moun ki nan payroll pou kondisyon sas yo
   	       $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) WHERE ps.academic_year='.$acad.' AND month(p.payment_date)='.$month);
		 
		 }
   	   elseif($siges_structure==1)
		 { //pran tout moun ki nan payroll pou kondisyon sas yo
   	       $command= Yii::app()->db->createCommand('SELECT ps.person_id, p.id_payroll_set,p.id_payroll_set2 FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) inner join academicperiods ap on(ap.id=ps.academic_year) WHERE year='.$acad.' AND month(p.payment_date)='.$month);
		 
		 }
		 
		 
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   










//return id, taxe_description, taxe_value
 public static function getAllTaxes($acad)
   {
   	//
   	$command= Yii::app()->db->createCommand('SELECT id, taxe_description, employeur_employe, taxe_value FROM taxes t WHERE academic_year='.$acad);
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   

//return id, taxe_description, taxe_value
 public static function getTaxesForFDM($acad)
   {
   	//
   	$command= Yii::app()->db->createCommand('SELECT id, taxe_description, employeur_employe, taxe_value FROM taxes t WHERE particulier=0 AND academic_year='.$acad);
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   


//Taxes
//pran tout moun ki nan payroll pou kondisyon sas yo
public static function getPersonIdtForTaxeByDateStartAndMonth($acad, $date, $month)
   {
   	//pran tout moun ki nan payroll pou kondisyon sas yo
   	$command= Yii::app()->db->createCommand('SELECT distinct ps.person_id FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) WHERE ps.academic_year='.$acad.' AND (month(p.payment_date)='.$month.' AND p.payment_date >=\''.$date.'\')');
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   
   
public static function getPersonIdtForTaxeByDateEndAndMonth($acad, $date, $month)
   {
   	//pran tout moun ki nan payroll pou kondisyon sas yo
   	$command= Yii::app()->db->createCommand('SELECT ps.person_id FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) WHERE ps.academic_year='.$acad.' AND (month(p.payment_date)='.$month.' AND p.payment_date <=\''.$date.'\')');
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   
 
 public static function getPersonIdtForTaxeByMonth($acad, $month)
   {
   	//pran tout moun ki nan payroll pou kondisyon sas yo
   	$command= Yii::app()->db->createCommand('SELECT ps.person_id FROM payroll_settings ps INNER JOIN payroll p ON(ps.id=p.id_payroll_set) WHERE ps.academic_year='.$acad.' AND month(p.payment_date)='.$month);
   	   
   	   $sql_result = $command->queryAll();
		//if($sql_result!=null)
		  return $sql_result;
   	
   }  	
   









  	
	}
