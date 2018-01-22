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



class Payroll extends BasePayroll
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Payroll the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

     public $full_name;
     public $first_name;
     public $last_name;
     public $person_id;
     public $payroll_month;
     public $amount;
     public $missing_hour;
     public $group;
	public $group_payroll;
	public $an_hour;
	public $number_of_hour;
	public $to_pay;
	
	public $id_payroll;
	
	public $depensesItems;
     
     public $taxe;
	
	
	
				
 public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   array('person_id', 'required'),
                   array('first_name, last_name,full_name,to_pay', 'length', 'max'=>40),
                    array('id_payroll_set+payroll_month+payment_date', 'application.extensions.uniqueMultiColumnValidator'),
                   
				 array('id, id_payroll_set,id_payroll_set2,first_name, cash_check, last_name,full_name, missing_hour, payroll_month, payroll_date, taxe, net_salary, payment_date', 'safe', 'on'=>'search'),
				 				
		));
	}
 

/**/public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                        'person_id'=>Yii::t('app','Person'), 
                        'group'=> Yii::t('app','By Group'), 
                        'taxe'=>Yii::t('app','Include taxe'),
                        'missing_hour'=> Yii::t('app','Missing hour'),
                        'depensesItems'=> Yii::t('app','Depenses Items'),
                                 
                        )
                    );
           
	}
	


  public function getPayrollGroup(){
            return array(
                1=>Yii::t('app','Employees'), // Les personnes dans person qui ont un poste [done] 
                2=>Yii::t('app','Teachers'), // Les professeurs uniquement sans un poste [done]
                
            );            
        }
        


public function isDone($month){
     
    	$acad=Yii::app()->session['currentId_academic_year']; 
    	
    	$criteria = new CDbCriteria;
			
			
			 $criteria->condition = ' ps.academic_year='.$acad.' AND payroll_month ='.$month.' AND MONTH(payroll_date)='.$month;
			$criteria->join = 'left join payroll_settings ps on (ps.id = p.id_payroll_set)';
			$criteria->alias = 'p';
			$criteria->select = '*';
          
            
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000000,
    			),
		'criteria'=>$criteria,
    ));
   
   
    }
    
    
    
public function isDoneForOnes($month, $pers,$acad){
     
    	$criteria = new CDbCriteria;
			
			
			 $criteria->condition = ' ps.academic_year='.$acad.' AND payroll_month ='.$month.' AND MONTH(payroll_date)='.$month.' AND ps.person_id='.$pers;
			$criteria->alias = 'p';
			$criteria->select = '*';
           $criteria->join = 'left join payroll_settings ps on (ps.id = p.id_payroll_set)';
            
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000000,
    			),
		'criteria'=>$criteria,
    ));
   
   
    }


public function anyAfterDoneForOnes($month,$date_payroll, $pers,$acad){
     
  if($month!='')
	{
	     
	     $sql = 'SELECT p.id FROM payroll p INNER JOIN payroll_settings ps ON(p.id_payroll_set=ps.id) WHERE ps.academic_year='.$acad.' AND payroll_date >\''.$date_payroll.'\' AND YEAR(payroll_date) >= YEAR(\''.$date_payroll.'\') AND ps.person_id='.$pers;
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        return $info__p;
        
	  }
	else
	  return null;

   
   
    }

    




//
public function getInfoLastPayroll(){
	            
	   $criteria = new CDbCriteria;
			
			$criteria->distinct = 'true';
			$criteria->alias = 'p';
			//$criteria->condition = 'ps.old_new=1 ';
			$criteria->join = 'left join payroll_settings ps on (ps.id = p.id_payroll_set)';
			$criteria->select = 'p.id, p.id_payroll_set,p.id_payroll_set2,p.missing_hour, p.payroll_month, p.payroll_date, ps.number_of_hour, p.taxe, p.net_salary, p.payment_date, p.cash_check';
			$criteria->order = 'p.payroll_month DESC, p.payroll_date DESC';
            
           
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100,
    			),
		'criteria'=>$criteria,
    ));
   

	
}



public function getInfoLastPayrollForOne($pers){
	            
	   $criteria = new CDbCriteria;
			
			$criteria->distinct = 'true';
			$criteria->alias = 'p';
			$criteria->condition = 'ps.person_id='.$pers;
			$criteria->join = 'left join payroll_settings ps on (ps.id = p.id_payroll_set)';
			$criteria->select = 'p.id, p.id_payroll_set,p.id_payroll_set2,p.missing_hour, p.payroll_month, p.payroll_date, ps.number_of_hour, p.taxe, p.net_salary, p.payment_date, p.cash_check';
			$criteria->order = 'p.payroll_month DESC, p.payroll_date DESC';
            
             
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100,
    			),
		'criteria'=>$criteria,
    ));
   

	
}



public function getInfoLastPayrollByPerson($person_id)
 {
	  $criteria = new CDbCriteria;
			
			$criteria->distinct = 'true';
			$criteria->alias = 'p';
			$criteria->join = 'left join payroll_settings ps on (ps.id = p.id_payroll_set)';
			$criteria->select = 'p.id, p.id_payroll_set,p.id_payroll_set2,p.missing_hour, p.payroll_month, p.payroll_date, ps.number_of_hour, p.taxe, p.net_salary, p.payment_date, p.cash_check';
			
			$criteria->condition = ' ps.person_id='.$person_id;
			$criteria->order = 'p.payroll_month DESC, p.payroll_date DESC';
            
            
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100,
    			),
		'criteria'=>$criteria,
    ));
   

  
  }



public function getInfoLastPayrollByPayroll_group($grouppayroll)
 {
	  $criteria = new CDbCriteria;
			
			$criteria->distinct = 'true';
			$criteria->alias = 'p';
			$criteria->join = 'left join payroll_settings ps on (ps.id = p.id_payroll_set)';
			$criteria->select = 'p.id, p.id_payroll_set,p.id_payroll_set2,p.missing_hour, p.payroll_month, p.payroll_date, ps.number_of_hour, p.taxe, p.net_salary, p.payment_date, p.cash_check';
			
			$criteria->condition = ' ps.as='.$grouppayroll;
			$criteria->order = 'p.payroll_month DESC, p.payroll_date DESC';
            
          
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100,
    			),
		'criteria'=>$criteria,
    ));
   

  
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
       case Yii::t('app','13 eme'):
            return 13;
            break;
      case Yii::t('app','14 eme'):
            return 14;
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
     
     

public function getDatePastPayrollByPerson($id_payroll_set, $month){

	$acad=Yii::app()->session['currentId_academic_year'];
	if($month!='')
	{
	     $sql = 'SELECT DISTINCT p.payroll_date FROM payroll p INNER JOIN payroll_settings ps ON(p.id_payroll_set=ps.id) WHERE p.payroll_month='.$month.' AND ps.academic_year='.$acad.' AND ps.id='.$id_payroll_set.' order by p.payroll_month ASC, p.payroll_date ASC';
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
           return $info__p;
        else
           return null;
	  }
	else
	  return null;

}



public function getDatePastPayrollByGroup($month){

	$acad=Yii::app()->session['currentId_academic_year'];
	if($month!='')
	{
	     $sql = 'SELECT DISTINCT p.payroll_date FROM payroll p INNER JOIN payroll_settings ps ON(p.id_payroll_set=ps.id) WHERE p.payroll_month='.$month.' AND ps.academic_year='.$acad.' order by p.payroll_month ASC, p.payroll_date ASC';
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
           return $info__p;
        else
           return null;
	  }
	else
	  return null;

}


     
public function getDatePastPayroll($month){

	$acad=Yii::app()->session['currentId_academic_year'];
	if($month!='')
	{
	     $sql = 'SELECT DISTINCT p.payroll_date FROM payroll p INNER JOIN payroll_settings ps ON(p.id_payroll_set=ps.id) WHERE p.payroll_month='.$month.' AND ps.academic_year='.$acad.' order by p.payroll_month ASC, p.payroll_date ASC';
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
           return $info__p;
        else
           return null;
	  }
	else
	  return null;

}


                 
public function getMonthPastPayrollByPerson($id_payroll_set){
	
	$acad=Yii::app()->session['currentId_academic_year'];
	if($id_payroll_set!='')
	{
	     $sql = 'SELECT DISTINCT p.payroll_month FROM payroll p INNER JOIN payroll_settings ps ON(p.id_payroll_set=ps.id) WHERE ps.academic_year='.$acad.' AND ps.id='.$id_payroll_set.' order by p.payroll_month ASC, p.payroll_date ASC';
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
           return $info__p;
        else
           return null;
	  }
	else
	  return null;

	
   }
   

   
   
public function getMonthPastPayrollByPayroll_group($grouppayroll){
	
	$acad=Yii::app()->session['currentId_academic_year'];
	
	if($grouppayroll==1)//employee
	   $group=0;
	elseif($grouppayroll==2)//teacher
	    $group=1;
	    
	$sql = 'SELECT DISTINCT p.payroll_month FROM payroll p INNER JOIN payroll_settings ps ON(p.id_payroll_set=ps.id) WHERE ps.academic_year='.$acad.' AND ps.as='.$group.' order by p.payroll_month ASC, p.payroll_date ASC';
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
           return $info__p;
        else
           return null;
	
   }
    
   
   
public function getMonthPastPayroll(){
	
	$acad=Yii::app()->session['currentId_academic_year'];
	
	
	    
	$sql = 'SELECT DISTINCT p.payroll_month FROM payroll p INNER JOIN payroll_settings ps ON(p.id_payroll_set=ps.id) WHERE ps.academic_year='.$acad.' order by p.payroll_month ASC, p.payroll_date ASC';
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
           return $info__p;
        else
           return null;
	
   }
       
   
    
                  
public function getTimeMissing($person,$numb_hour){
	                                                      
     $acad=Yii::app()->session['currentId_academic_year'];
        $missTime = 0;
        $nbr_time=0;
      	
		//pran enfo denye setting-payroll la
		$sql = 'SELECT number_of_hour, an_hour FROM payroll_settings  WHERE old_new=1 AND person_id='.$person.' AND academic_year='.$acad.' order by id DESC';
		$command = Yii::app()->db->createCommand($sql);
        $info_setting_p = $command->queryAll(); 
									       	   
		  if($info_setting_p!=null) 
			{ 
			 
			 $employee_teacher=Persons::model()->isEmployeeTeacher($person, $acad);
	  
			 if($employee_teacher) 
			   {
			   	     $compt=0;
			   	     
			   	     foreach($info_setting_p as $info_)
					  {
					      $compt++;
					      
					      if($info_['an_hour']==1)
			                {     
						      $nbr_time = $info_['number_of_hour'];					  	   	    
			                }
					     
					     if($compt==2)
					        break;
					        
					   }
			   	     
			   	     
			     }
			  elseif(!$employee_teacher)
			    {

				 foreach($info_setting_p as $info_)
				  {
				      if($info_['an_hour']==1)
			           {
			              $nbr_time = $info_['number_of_hour'];
					      
			             }
			             					  	   	    
				     break;
				   }
				
			    }
			
			   			   
			}
													  	   	  
                                        
        if($numb_hour >0)
           { 
	           	if( $nbr_time > 0 )
	           	  {
	           	   $missTime = $nbr_time - $numb_hour;
	           	
	           	  }
	           	
                
             }
                  
            
       return $missTime; 
       
        
    }
    
    
    
   
        

   
/**
         * 
         * @param float $monthlySalary 
         * @param //array $bareme 5 values like this array(array(0, 60000, 0),array(60000, 240000, 0.1),array(240000, 480000, 0.15),array(480000, 1000000, 0.25), array(1000000, , 0.3))
        * @return array $salaire 
         */
     public function getIriCharge_new($monthlySalary,$bareme){
            $netSalary = 0;
            $deduction = 0;
            $eder_marc_poulard_prosper =-1;
                        
            $salaire = array(); // $salaire['month_salary_net'] : salaire net mensuel, $salaire['month_iri']: deduction IRI mensuel, $salaire['salary_year']: salaire net annuel, $salaire['iri_year']: deduction IRI annuelle
            $annualSalary = 12*$monthlySalary;
           
            //detemine nan ki enteval sale sa ye
            for($i=0; $i< 4 ; $i++)
             {
             	if(($bareme[$i][0]< $annualSalary) && ($annualSalary<=$bareme[$i][1]))
             	  {
             	  	  $eder_marc_poulard_prosper = $i;
             	  	    break;
             	  	}
             	}
            
             if($eder_marc_poulard_prosper == -1)
                 $eder_marc_poulard_prosper = 4;
            
            
            switch($eder_marc_poulard_prosper)
               {
               	
               	      case 0:
               	             $deduction = 0;
               	             $netSalary = $annualSalary - $deduction;
               	              break;
               	    
               	      case 1:
               	               $deduction = $deduction +(  ( $annualSalary - $bareme[1][0] ) * $bareme[1][2]/100  );
               	             
               	                 $netSalary = $annualSalary - $deduction;
               	           
               	               break;
               	              
               	      case 2:
               	                $deduction = $deduction +(  ( $annualSalary - $bareme[2][0] ) * $bareme[2][2]/100  );
               	                
               	                $deduction = $deduction +(  ( $bareme[1][1] - $bareme[1][0] ) * $bareme[1][2]/100  );
               	              
               	                 $netSalary = $annualSalary - $deduction;
               	                 
               	                 
               	                break;
               	              
               	      case 3:
               	                $deduction = $deduction +(  ( $annualSalary - $bareme[3][0] ) * $bareme[3][2]/100  );
               	                
               	                $deduction = $deduction +(  ( $bareme[2][1] - $bareme[2][0] ) * $bareme[2][2]/100  );
               	                
               	                $deduction = $deduction +(  ( $bareme[1][1] - $bareme[1][0] ) * $bareme[1][2]/100  );
               	             
               	                 $netSalary = $annualSalary - $deduction;
               	              
               	                 break;
               	              
               	      case 4:
               	              $deduction = $deduction +(  ( $annualSalary - $bareme[4][0] ) * $bareme[4][2]/100  );
               	                
               	                $deduction = $deduction +(  ( $bareme[3][1] - $bareme[3][0] ) * $bareme[3][2]/100  );
               	                
               	                $deduction = $deduction +(  ( $bareme[2][1] - $bareme[2][0] ) * $bareme[2][2]/100  );
               	                
               	                $deduction = $deduction +(  ( $bareme[1][1] - $bareme[1][0] ) * $bareme[1][2]/100  );
               	             
               	                 $netSalary = $annualSalary - $deduction;
                               
                                  break;
               	
               	}
            
                          
            
            $salaire['month_salary_net'] = round(($netSalary/12),2); // Salaire mensuel net
            $salaire['month_iri'] = round(($deduction/12),2); // Deduction IRI mensuel
            $salaire['salary_year'] = round($netSalary,2); // Salaire annuel
            $salaire['iri_year'] = round($deduction,2); // Deduction IRI annuel        
            
            
            
            return $salaire;
        }
        
        
        
        
        
                            
public function getLoanDeduction($person,$amount,$numb_hour,$missing_hour,$net_salary,$taxe){
	                                                      
     $acad=Yii::app()->session['currentId_academic_year'];
     $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 

         $loan = 0;
         $gross_salary =0;
          $diff_salary = 0;
         //nbr d'hre
         $nbr_time=0;
         $pay_time= 0;
      
			
		//pran enfo denye setting-payroll la
		$sql = 'SELECT number_of_hour,amount, an_hour FROM payroll_settings  WHERE old_new=1 AND person_id='.$person.' AND academic_year='.$acad.' order by id DESC';
		$command = Yii::app()->db->createCommand($sql);
        $info_setting_p = $command->queryAll(); 
									       	   
		  if($info_setting_p!=null) 
			{ 
			 
			 $employee_teacher=Persons::model()->isEmployeeTeacher($person, $acad);
	  
			 if($employee_teacher) 
			   {
			   	     $compt=0;
			   	     
			   	     foreach($info_setting_p as $info_)
					  {
					      $compt++;
					      
					      if($info_['an_hour']==1)
			                {     
						      $pay_time= $info_['amount'];
							  $nbr_time = $info_['number_of_hour'];					  	   	    
			                }
					     
					     if($compt==2)
					        break;
					        
					   }
			   	     
			   	     
			     }
			  elseif(!$employee_teacher)
			    {

				 foreach($info_setting_p as $info_)
				  {
				      if($info_['an_hour']==1)
			           {
			             $pay_time= $info_['amount'];
					      $nbr_time = $info_['number_of_hour'];
					      
			             }
			             					  	   	    
				     break;
				   }
				
			    }
			
			   
			}
			
          
          if(($missing_hour!='')&&( $missing_hour!=0))
           { 	           	      	
           	  $diff_salary = round( ($pay_time * $missing_hour), 2);
	          
             }
			 
        $gross_salary = $amount;
   
          $loan = round( ($gross_salary - $diff_salary - $taxe ), 2)- $net_salary;   
       
            return $loan;  
    }
 
                             
public function getMissingHourDeduction($person,$missing_hour){
	                                                      
     $acad=Yii::app()->session['currentId_academic_year'];
     $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 

         $gross_salary_deduction = 0;
         //nbr d'hre
         $nbr_time=0;
         $pay_time= 0;
      
    
		//pran enfo denye setting-payroll la
		$sql = 'SELECT number_of_hour,amount, an_hour FROM payroll_settings  WHERE old_new=1 AND person_id='.$person.' AND academic_year='.$acad.' order by id DESC';
		$command = Yii::app()->db->createCommand($sql);
        $info_setting_p = $command->queryAll(); 
									       	   
		  if($info_setting_p!=null) 
			{ 
			 
			 $employee_teacher=Persons::model()->isEmployeeTeacher($person, $acad);
	  
			 if($employee_teacher) 
			   {
			   	     $compt=0;
			   	     
			   	     foreach($info_setting_p as $info_)
					  {
					      $compt++;
					      
					      if($info_['an_hour']==1)
			                {     
						      $pay_time= $info_['amount'];
							  $nbr_time = $info_['number_of_hour'];					  	   	    
			                }
					     
					     if($compt==2)
					        break;
					        
					   }
			   	     
			   	     
			     }
			  elseif(!$employee_teacher)
			    {

				 foreach($info_setting_p as $info_)
				  {
				      if($info_['an_hour']==1)
			           {
			             $pay_time= $info_['amount'];
					      $nbr_time = $info_['number_of_hour'];
					      
			             }
			             					  	   	    
				     break;
				   }
				
			    }
			
			   
			}
													  	   	  
      if($nbr_time!=0)
        $gross_salary_deduction =round(  (($pay_time * $missing_hour) ), 2);         
           
           return $currency_symbol.' '.numberAccountingFormat($gross_salary_deduction);  
    }
 


 public function getNumberHour(){
        
        if(($this->number_of_hour!=0)&&($this->number_of_hour!=''))
             return $this->number_of_hour;
        else
            return  Yii::t('app','N/A');
                
        }


//for index and update
 public function getGrossSalaryInd($person_id,$month,$year)
  {
         $acad=Yii::app()->session['currentId_academic_year'];
         
         $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
         $id_payroll_set ='';
         $id_payroll_set2 ='';
         //jwenn id_payroll_set apati de payroll la
         $sql = 'SELECT id_payroll_set, id_payroll_set2 FROM payroll p inner join payroll_settings ps on(ps.id = p.id_payroll_set) where ps.person_id='.$person_id.' AND p.payroll_month='.$month.' AND YEAR(p.payment_date)='.$year;		   	     
			
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          { 
          	  foreach($info__p as $info)
          	     {  $id_payroll_set = $info['id_payroll_set'];
          	        $id_payroll_set2 =$info['id_payroll_set2'];
          	         break;
          	     }
          
          }
        
           
         $person_id = PayrollSettings::model()->getPersonIdByIdPayrollSetting($id_payroll_set);

	     $employee_teacher=Persons::model()->isEmployeeTeacher($person_id, $acad);
	  
		 if($employee_teacher) 
		   {
		   	       if(($id_payroll_set2 =='')||($id_payroll_set2 ==NULL))
		   	         $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id ='.$id_payroll_set.' AND ps.academic_year='.$acad));
		   	      else
		   	          $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id IN('.$id_payroll_set.','.$id_payroll_set2.') AND ps.academic_year='.$acad));
		   	     
		   	      //check if it is a timely salary 
                   $model_ = new PayrollSettings;
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                     
                     $compt=0;
                     $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $total_gross_salary=0;
                    $timely_salary = '';
                  
                 foreach($pay_set as $amount)
                   {   
                   	  $compt++;
                   	 
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	  $net_salary=0;
                   	  $as = $amount->as;
                   	  
                     //fosel pran yon ps.as=0 epi yon ps.as=1
                       if(($as_emp==0)&&($as==0))
                        { $as_emp=1;
                           $all= 'e';
	                     
	                     if(($amount!=null))
			               {  
			               	   $id_payroll_set_emp = $amount->id;
			               	   $id_payroll_set = $amount->id;
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $number_of_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	//calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						         
						        }
			                   
			             
				            }
			           
			            $total_gross_salary = $total_gross_salary + $gross_salary;
			          
			          	                           
                          }
                        elseif(($as_teach==0)&&($as==1))
                            {   $as_teach=1;
                                $all='t';
	                    
			                     if(($amount!=null))
					               {  
					               	   $id_payroll_set_teach = $amount->id;
					               	   $id_payroll_set = $amount->id;
					               	   
					               	   $gross_salary =$amount->amount;
					               	   
					               	   $number_of_hour = $amount->number_of_hour;
					               	   
					               	   if($amount->an_hour==1)
					                     $timely_salary = 1;
					                 }
					           //get number of hour if it's a timely salary person
					            if($timely_salary == 1)
					              {
					             	 //calculate $gross_salary by hour if it's a timely salary person 
								     if(($number_of_hour!=null)&&($number_of_hour!=0))
								       {
								          $gross_salary = ($gross_salary * $number_of_hour);
								          
								        }
					                   
						            }
					           
					            $total_gross_salary = $total_gross_salary + $gross_salary;
					          
					          	                          
                               }
                       
                        if($compt==2)
                           break;
                       
                      }
                 
                 return $currency_symbol.' '.numberAccountingFormat($total_gross_salary);
		   	     
		   	 }
		  elseif(!$employee_teacher)
		   { 
		           $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id ='.$id_payroll_set.' AND ps.academic_year='.$acad));

                   
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                     
                     $compt=0;
                     $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $total_gross_salary=0;
                    $timely_salary = '';$gross_salary = 0;
		              
                 foreach($pay_set as $amount)
                   {   
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	  $net_salary=0;
                   	  $as = $amount->as;
                   	  
                     
	                     if(($amount!=null))
			               {  
			               	   $id_payroll_set_emp = $amount->id;
			               	   $id_payroll_set = $amount->id;
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $number_of_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	//calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						         
						        }
			                   
			             
				            }
			           
                          break;
                      }
                      
                 return  $currency_symbol.' '.numberAccountingFormat($gross_salary);     
                      		           
		     }     
 
  }


//for index and update
public function getGrossSalaryIndex_value($person_id,$month,$year)
  {
         $acad=Yii::app()->session['currentId_academic_year'];
         
         $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
         $id_payroll_set ='';
         $id_payroll_set2 ='';
         //jwenn id_payroll_set apati de payroll la
         $sql = 'SELECT id_payroll_set, id_payroll_set2 FROM payroll p inner join payroll_settings ps on(ps.id = p.id_payroll_set) where ps.person_id='.$person_id.' AND p.payroll_month='.$month.' AND YEAR(p.payment_date)='.$year;		   	     
			
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          { 
          	  foreach($info__p as $info)
          	     {  $id_payroll_set = $info['id_payroll_set'];
          	        $id_payroll_set2 =$info['id_payroll_set2'];
          	         break;
          	     }
          
          }
        
           
         $person_id = PayrollSettings::model()->getPersonIdByIdPayrollSetting($id_payroll_set);

	     $employee_teacher=Persons::model()->isEmployeeTeacher($person_id, $acad);
	  
		 if($employee_teacher) 
		   {
		   	      if(($id_payroll_set2 =='')||($id_payroll_set2 ==NULL))
		   	         $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id ='.$id_payroll_set.' AND ps.academic_year='.$acad));
		   	      else
		   	          $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id IN('.$id_payroll_set.','.$id_payroll_set2.') AND ps.academic_year='.$acad));
		   	        
		   	     
		   	      //check if it is a timely salary 
                   $model_ = new PayrollSettings;
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                     
                     $compt=0;
                     $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $total_gross_salary=0;
                    $timely_salary = '';
                  
                 foreach($pay_set as $amount)
                   {   
                   	  $compt++;
                   	 
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	  $net_salary=0;
                   	  $as = $amount->as;
                   	  
                     //fosel pran yon ps.as=0 epi yon ps.as=1
                       if(($as_emp==0)&&($as==0))
                        { $as_emp=1;
                           $all= 'e';
	                     
	                     if(($amount!=null))
			               {  
			               	   $id_payroll_set_emp = $amount->id;
			               	   $id_payroll_set = $amount->id;
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $number_of_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	//calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						         
						        }
			                   
			             
				            }
			           
			            $total_gross_salary = $total_gross_salary + $gross_salary;
			          
			          	                           
                          }
                        elseif(($as_teach==0)&&($as==1))
                            {   $as_teach=1;
                                $all='t';
	                    
			                     if(($amount!=null))
					               {  
					               	   $id_payroll_set_teach = $amount->id;
					               	   $id_payroll_set = $amount->id;
					               	   
					               	   $gross_salary =$amount->amount;
					               	   
					               	   $number_of_hour = $amount->number_of_hour;
					               	   
					               	   if($amount->an_hour==1)
					                     $timely_salary = 1;
					                 }
					           //get number of hour if it's a timely salary person
					            if($timely_salary == 1)
					              {
					             	 //calculate $gross_salary by hour if it's a timely salary person 
								     if(($number_of_hour!=null)&&($number_of_hour!=0))
								       {
								          $gross_salary = ($gross_salary * $number_of_hour);
								          
								        }
					                   
						            }
					           
					            $total_gross_salary = $total_gross_salary + $gross_salary;
					          
					          	                          
                               }
                       
                        if($compt==2)
                           break;
                       
                      }
                 
                 return $total_gross_salary;
		   	     
		   	 }
		  elseif(!$employee_teacher)
		   { 
		           $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id ='.$id_payroll_set.' AND ps.academic_year='.$acad));

                   
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                     
                     $compt=0;
                     $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $total_gross_salary=0;
                    $timely_salary = '';$gross_salary = 0;
		              
                 foreach($pay_set as $amount)
                   {   
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	  $net_salary=0;
                   	  $as = $amount->as;
                   	  
                     
	                     if(($amount!=null))
			               {  
			               	   $id_payroll_set_emp = $amount->id;
			               	   $id_payroll_set = $amount->id;
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $number_of_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	//calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						         
						        }
			                   
			             
				            }
			           
                          break;
                      }
                      
                 return  $gross_salary;     
                      		           
		     }     
 
 
  }

//for index and update
public function getGrossSalaryPerson_idMonthAcad($person_id,$month,$acad)
  {
         $acad=Yii::app()->session['currentId_academic_year'];
         
         $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
         $id_payroll_set ='';
         $id_payroll_set2 ='';
         //jwenn id_payroll_set apati de payroll la
         $sql = 'SELECT id_payroll_set, id_payroll_set2 FROM payroll p inner join payroll_settings ps on(ps.id = p.id_payroll_set) where ps.person_id='.$person_id.' AND p.payroll_month='.$month.' AND ps.academic_year='.$acad;		   	     
			
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          { 
          	  foreach($info__p as $info)
          	     {  $id_payroll_set = $info['id_payroll_set'];
          	        $id_payroll_set2 =$info['id_payroll_set2'];
          	         break;
          	     }
          
          }
        
           
         $person_id = PayrollSettings::model()->getPersonIdByIdPayrollSetting($id_payroll_set);

	     $employee_teacher=Persons::model()->isEmployeeTeacher($person_id, $acad);
	  
		 if($employee_teacher) 
		   {
		   	       if(($id_payroll_set2 =='')||($id_payroll_set2 ==NULL))
		   	         $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id ='.$id_payroll_set.' AND ps.academic_year='.$acad));
		   	      else
		   	          $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id IN('.$id_payroll_set.','.$id_payroll_set2.') AND ps.academic_year='.$acad));
		   	     
		   	      //check if it is a timely salary 
                   $model_ = new PayrollSettings;
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                     
                     $compt=0;
                     $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $total_gross_salary=0;
                    $timely_salary = '';
                  
                 foreach($pay_set as $amount)
                   {   
                   	  $compt++;
                   	 
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	  $net_salary=0;
                   	  $as = $amount->as;
                   	  
                     //fosel pran yon ps.as=0 epi yon ps.as=1
                       if(($as_emp==0)&&($as==0))
                        { $as_emp=1;
                           $all= 'e';
	                     
	                     if(($amount!=null))
			               {  
			               	   $id_payroll_set_emp = $amount->id;
			               	   $id_payroll_set = $amount->id;
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $number_of_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	//calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						         
						        }
			                   
			             
				            }
			           
			            $total_gross_salary = $total_gross_salary + $gross_salary;
			          
			          	                           
                          }
                        elseif(($as_teach==0)&&($as==1))
                            {   $as_teach=1;
                                $all='t';
	                    
			                     if(($amount!=null))
					               {  
					               	   $id_payroll_set_teach = $amount->id;
					               	   $id_payroll_set = $amount->id;
					               	   
					               	   $gross_salary =$amount->amount;
					               	   
					               	   $number_of_hour = $amount->number_of_hour;
					               	   
					               	   if($amount->an_hour==1)
					                     $timely_salary = 1;
					                 }
					           //get number of hour if it's a timely salary person
					            if($timely_salary == 1)
					              {
					             	 //calculate $gross_salary by hour if it's a timely salary person 
								     if(($number_of_hour!=null)&&($number_of_hour!=0))
								       {
								          $gross_salary = ($gross_salary * $number_of_hour);
								          
								        }
					                   
						            }
					           
					            $total_gross_salary = $total_gross_salary + $gross_salary;
					          
					          	                          
                               }
                       
                        if($compt==2)
                           break;
                       
                      }
                 
                 return $total_gross_salary;
		   	     
		   	 }
		  elseif(!$employee_teacher)
		   { 
		           $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.id ='.$id_payroll_set.' AND ps.academic_year='.$acad));

                   
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                     
                     $compt=0;
                     $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $total_gross_salary=0;
                    $timely_salary = '';$gross_salary = 0;
		              
                 foreach($pay_set as $amount)
                   {   
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	  $net_salary=0;
                   	  $as = $amount->as;
                   	  
                     
	                     if(($amount!=null))
			               {  
			               	   $id_payroll_set_emp = $amount->id;
			               	   $id_payroll_set = $amount->id;
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $number_of_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	//calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						         
						        }
			                   
			             
				            }
			           
                          break;
                      }
                      
                 return  $gross_salary;     
                      		           
		     }     
 
 
  }




//for create
 public function getGrossSalary($person_id)
  {
         $acad=Yii::app()->session['currentId_academic_year'];
         
         $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
         
         $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'ps.id DESC', 'condition'=>'ps.old_new=1 AND ps.person_id='.$person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$person_id.' AND p.active IN(1, 2)) '));
                 //check if it is a timely salary 
                   $model_ = new PayrollSettings;
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                    
                    $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $total_gross_salary=0;
                    $timely_salary = '';

	  $employee_teacher=Persons::model()->isEmployeeTeacher($person_id, $acad);
	  
		 if($employee_teacher) 
		   {
		   	     $compt=0;
                  
                 foreach($pay_set as $amount)
                   {   
                   	  $compt++;
                   	 
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	  $net_salary=0;
                   	  $as = $amount->as;
                   	  
                     //fosel pran yon ps.as=0 epi yon ps.as=1
                       if(($as_emp==0)&&($as==0))
                        { $as_emp=1;
                           $all= 'e';
	                     
	                     if(($amount!=null))
			               {  
			               	   $id_payroll_set_emp = $amount->id;
			               	   $id_payroll_set = $amount->id;
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $number_of_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	//calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						         
						        }
			                   
			             
				            }
			           
			            $total_gross_salary = $total_gross_salary + $gross_salary;
			          
			          	                           
                          }
                        elseif(($as_teach==0)&&($as==1))
                            {   $as_teach=1;
                                $all='t';
	                    
			                     if(($amount!=null))
					               {  
					               	   $id_payroll_set_teach = $amount->id;
					               	   $id_payroll_set = $amount->id;
					               	   
					               	   $gross_salary =$amount->amount;
					               	   
					               	   $number_of_hour = $amount->number_of_hour;
					               	   
					               	   if($amount->an_hour==1)
					                     $timely_salary = 1;
					                 }
					           //get number of hour if it's a timely salary person
					            if($timely_salary == 1)
					              {
					             	 //calculate $gross_salary by hour if it's a timely salary person 
								     if(($number_of_hour!=null)&&($number_of_hour!=0))
								       {
								          $gross_salary = ($gross_salary * $number_of_hour);
								          
								        }
					                   
						            }
					           
					            $total_gross_salary = $total_gross_salary + $gross_salary;
					          
					          	                          
                               }
                       
                        if($compt==2)
                           break;
                       
                      }
                 
                 return $total_gross_salary;
		   	     
		   	 }
		  elseif(!$employee_teacher)
		   { 
		          $gross_salary = 0;
		              
                 foreach($pay_set as $amount)
                   {   
                   	  $gross_salary =0;
                   	  $deduction =0;
                   	  $net_salary=0;
                   	  $as = $amount->as;
                   	  
                     
	                     if(($amount!=null))
			               {  
			               	   $id_payroll_set_emp = $amount->id;
			               	   $id_payroll_set = $amount->id;
			               	   
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $number_of_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	//calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						         
						        }
			                   
			             
				            }
			           
                          break;
                      }
                      
                 return  $gross_salary;     
                      		           
		     }     
 
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
	           return '00-00-0000';  
	         
        }

	 public function getTaxe(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->taxe);
        }


	 public function getNetSalary(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->net_salary);
        }


 public function getPayrollDate(){
           if(($this->payroll_date!=null)&&($this->payroll_date!='0000-00-00'))
	        {    $time = strtotime($this->payroll_date);
	                         $month=date("m",$time);
	                         $year=date("Y",$time);
	                         $day=date("j",$time);
	                         
	            return $day.'/'.$month.'/'.$year;    
	         }
	       else
	           return '00-00-0000';
        }




  public function getAnHour(){
            switch($this->an_hour)
            {
                case 0:
                    return Yii::t('app','No');
                case 1:
                    return Yii::t('app','Yes');
               
            }
        }
        
   public function getAnHourValue(){
            return array(
                0=>Yii::t('app','No'),
                1=>Yii::t('app','Yes'),
                             
            );            
        } 		
      


  public function searchPersonsForShowingPayroll($condition, $acad)
	{      
			$criteria = new CDbCriteria;
			
			
			//$criteria->with=array('idPayrollSet');
		$criteria->alias = 'pl';
		 $criteria->join = 'left join payroll_settings ps on(ps.id=pl.id_payroll_set) left join persons p on(p.id=ps.person_id)';
		 
		// $criteria->condition = $condition.' AND ps.old_new=1 AND ps.academic_year='.$acad;
		 $criteria->condition = $condition.' AND ps.academic_year='.$acad;
			   
            $criteria->select = 'pl.id, pl.id_payroll_set,pl.id_payroll_set2, ps.person_id, p.last_name , p.first_name,concat(p.first_name,p.last_name) as full_name, p.id_number, p.birthday, p.gender, ps.amount, ps.an_hour, ps.academic_year, pl.net_salary, pl.payroll_date, pl.payment_date, pl.cash_check, pl.taxe,ps.number_of_hour, pl.missing_hour,pl.payroll_month';
                       // $criteria->alias = 'courses c';
			             
			
						 $criteria->order = 'pl.payment_date DESC, pl.payroll_date DESC, p.last_name ASC';
			//$criteria->limit = '100';
		     
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }

  public function searchPersonsForUpdatePayroll($condition, $month, $payroll_date, $acad)
	{      
			$criteria = new CDbCriteria;
			
			
			//$criteria->with=array('idPayrollSet');
		$criteria->alias = 'pl';
		 $criteria->join = 'left join payroll_settings ps on(ps.id=pl.id_payroll_set) left join persons p on(p.id=ps.person_id)';
		 
		 $criteria->condition = $condition.' AND ps.academic_year='.$acad.' AND pl.payroll_month='.$month.' AND pl.payroll_date=\''.$payroll_date.'\'' ;
			   
            $criteria->select = 'pl.id, pl.id_payroll_set,pl.id_payroll_set2, ps.person_id, p.last_name , p.first_name, p.id_number, p.birthday, p.gender, ps.amount, ps.an_hour, ps.academic_year, pl.net_salary, pl.payroll_date, pl.payment_date, pl.cash_check, pl.taxe,ps.number_of_hour, pl.missing_hour,pl.payroll_month';
                       // $criteria->alias = 'courses c';
			             
			
						 $criteria->order = 'p.last_name ASC';
			//$criteria->limit = '100';
		     
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    
   public function searchPersonsInPayrollForReports($condition, $month, $acad)
	{      
			$criteria = new CDbCriteria;
			
			
			//$criteria->with=array('idPayrollSet');
		$criteria->alias = 'pl';
		 $criteria->join = 'left join payroll_settings ps on(ps.id=pl.id_payroll_set) left join persons p on(p.id=ps.person_id)';
		 
		 $criteria->condition = $condition.' AND ps.academic_year='.$acad.' AND pl.payroll_month='.$month ;
			   
            $criteria->select = 'pl.id, pl.id_payroll_set,pl.id_payroll_set2, ps.person_id, p.last_name , p.first_name, p.id_number, p.birthday, p.gender, ps.amount, ps.an_hour, ps.academic_year, pl.net_salary, pl.payroll_date, pl.payment_date, pl.cash_check, pl.taxe,ps.number_of_hour, pl.missing_hour,pl.payroll_month';
                       // $criteria->alias = 'courses c';
			             
			
						 $criteria->order = 'p.last_name ASC';
			//$criteria->limit = '100';
		     
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 10000,
    			),
				
		'criteria'=>$criteria,
		
		
    ));
 	
    }
    

 public function getYearFromAcad($month, $acad)
	{      
		$sql = 'SELECT YEAR(p.payroll_date) as year FROM payroll p left join payroll_settings ps on(ps.id=p.id_payroll_set) where ps.old_new = 1 AND ps.academic_year ='.$acad.' AND p.payroll_month ='.$month;
		
		$command = Yii::app()->db->createCommand($sql);
        $info__p = $command->queryAll(); 
        
        if($info__p!=null)
          { 
          	  foreach($info__p as $info)
          	     {  return $info['year'];
          	         break;
          	     }
          
          }
        else
           return null;
           	
    }
    
    

public function search_($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
 
		$criteria->with=array('idPayrollSet');
		
		$criteria->join='left join payroll_settings ps on(ps.id=pl.id_payroll_set) left join persons p on(p.id=ps.person_id)';
		
		$criteria->alias='pl';
		$criteria->condition='idPayrollSet.academic_year='.$acad;
		
		$criteria->compare('pl.id',$this->id);
		$criteria->compare('id_payroll_set',$this->id_payroll_set);
		$criteria->compare('p.first_name',$this->first_name,true);
		$criteria->compare('p.last_name',$this->last_name,true);
		$criteria->compare('pl.fullName',$this->full_name,true);
		$criteria->compare('idPayrollSet.amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('payroll_date',$this->payroll_date,true);
		$criteria->compare('idPayrollSet.number_of_hour',$this->number_of_hour);
		$criteria->compare('missing_hour',$this->missing_hour);
		$criteria->compare('taxe',$this->taxe,true);
		$criteria->compare('net_salary',$this->net_salary);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('cash_check',$this->cash_check,true);
		
		$criteria->order='idPayrollSet.id ASC, payroll_month ASC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


public function searchByMonth($month_, $payroll_date, $acad)  //il fo cree colonne academic_year ds la table BILLINGS
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('idPayrollSet');
		
		$criteria->join='left join payroll_settings ps on(ps.id=pl.id_payroll_set) left join persons p on(p.id=ps.person_id)';
		
		$criteria->alias='pl';
		$criteria->condition='pl.payroll_month='.$month_.' AND pl.payroll_date=\''.$payroll_date.'\' AND ps.old_new=1 AND  ps.old_new=1 AND idPayrollSet.academic_year='.$acad;
		
		$criteria->compare('pl.id',$this->id);
		$criteria->compare('id_payroll_set',$this->id_payroll_set);
		$criteria->compare('p.first_name',$this->first_name,true);
		$criteria->compare('p.last_name',$this->last_name,true);
		$criteria->compare('pl.fullName',$this->full_name,true);
		$criteria->compare('idPayrollSet.amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('payroll_date',$this->payroll_date,true);
		$criteria->compare('idPayrollSet.number_of_hour',$this->number_of_hour);
		$criteria->compare('missing_hour',$this->missing_hour);
		$criteria->compare('taxe',$this->taxe,true);
		$criteria->compare('net_salary',$this->net_salary);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('cash_check',$this->cash_check,true);
		
		$criteria->order='idPayrollSet.id DESC, payroll_month ASC';

	    
		//$criteria->compare('id',$this->id_bill, true); 

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	


public function searchByPersonId($person_id, $acad)  
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('idPayrollSet');
		
		$criteria->join='left join payroll_settings ps on(ps.id=pl.id_payroll_set) left join persons p on(p.id=ps.person_id)';
		
		$criteria->alias='pl';
		$criteria->condition=' ps.person_id='.$person_id.' AND idPayrollSet.academic_year='.$acad;
		
		$criteria->compare('pl.id',$this->id);
		$criteria->compare('id_payroll_set',$this->id_payroll_set);
		$criteria->compare('p.first_name',$this->first_name,true);
		$criteria->compare('p.last_name',$this->last_name,true);
		$criteria->compare('pl.fullName',$this->full_name,true);
		$criteria->compare('idPayrollSet.amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('payroll_date',$this->payroll_date,true);
		$criteria->compare('idPayrollSet.number_of_hour',$this->number_of_hour);
		$criteria->compare('missing_hour',$this->missing_hour);
		$criteria->compare('taxe',$this->taxe,true);
		$criteria->compare('net_salary',$this->net_salary);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('cash_check',$this->cash_check,true);
		
		$criteria->order='idPayrollSet.id DESC, payroll_month ASC';

	    
		//$criteria->compare('id',$this->id_bill, true); 

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> 1000000,
    			),
			'criteria'=>$criteria,
		));
	}
	


public function searchByMonthPersonId($month_, $payroll_date, $person_id, $acad)  //il fo cree colonne academic_year ds la table BILLINGS
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with=array('idPayrollSet');
		
		$criteria->join='left join payroll_settings ps on(ps.id=pl.id_payroll_set) left join persons p on(p.id=ps.person_id)';
		
		$criteria->alias='pl';
		$criteria->condition='pl.payroll_date=\''.$payroll_date.'\' AND pl.payroll_month='.$month_.' AND ps.person_id='.$person_id.' AND idPayrollSet.academic_year='.$acad;
		
		$criteria->compare('pl.id',$this->id);
		$criteria->compare('id_payroll_set',$this->id_payroll_set);
		$criteria->compare('p.first_name',$this->first_name,true);
		$criteria->compare('p.last_name',$this->last_name,true);
		$criteria->compare('pl.fullName',$this->full_name,true);
		$criteria->compare('idPayrollSet.amount',$this->amount);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('payroll_date',$this->payroll_date,true);
		$criteria->compare('idPayrollSet.number_of_hour',$this->number_of_hour);
		$criteria->compare('missing_hour',$this->missing_hour);
		$criteria->compare('taxe',$this->taxe,true);
		$criteria->compare('net_salary',$this->net_salary);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('cash_check',$this->cash_check,true);
		
		$criteria->order='idPayrollSet.id DESC, payroll_month ASC';

	    
		//$criteria->compare('id',$this->id_bill, true); 

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> 100,
    			),
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
		
		$criteria->with=array('idPayrollSet');


		$criteria->compare('id',$this->id);
		$criteria->compare('id_payroll_set',$this->id_payroll_set);
		$criteria->compare('idPayrollSet.person.first_name',$this->first_name);
		$criteria->compare('idPayrollSet.person.last_name',$this->last_name);
		//$criteria->compare('idPayrollSet.person.fullName',$this->full_name,true);
		$criteria->compare('payroll_month',$this->payroll_month);
		$criteria->compare('payroll_date',$this->payroll_date,true);
		$criteria->compare('idPayrollSet.number_of_hour',$this->number_of_hour);
		$criteria->compare('missing_hour',$this->missing_hour);
		$criteria->compare('taxe',$this->taxe,true);
		$criteria->compare('net_salary',$this->net_salary);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('cash_check',$this->cash_check,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}