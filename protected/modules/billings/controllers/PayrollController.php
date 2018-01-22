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

Yii::import('ext.tcpdf.*');



class PayrollController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	public $payroll_month;
	public $person_id;
	public $group;
	public $grouppayroll=1;
	public $taxe=1;
	public $payroll_date;
	
	public $part;
	public $depensesItems1=1;
	public $month_ =0;
	
	public $status_ = 0;
	
	public $payrollReceipt_available =false;
	
	
	public $message_PayrollDatePaymentDate_notInAcadRange=false;
	public $message_anyPayrollAfter=false;
	public $message_group_anyPayrollAfter=false;
	public $message_PayrollDate=false;
	public $message_PaymentDate=false;
	public $messageNoPayrollDone = false;
	public $messagePayrollReceipt_available=true;
	public $messageMissingHourNotOk=false;
	public $message_noOneSelected=false;
	public $message_wrongMissingTime=false;
	
	public $message_UpdatePastDate=false;
	
		  
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		 $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
            $controller=$explode_url[3];
            //print_r($explode_url);
             
            $actions=$this->getRulesArray($this->module->name,$controller);
        
          if($this->getModuleName($this->module->name))
                {
		            if($actions!=null)
             			 {     return array(
				              	  	array('allow',  
					                	
					                	'actions'=> $actions,
		                                  'users'=>array(Yii::app()->user->name),
				                    	),
				              		  array('deny',  
					                 	'users'=>array('*'),
				                    ),
			                );
             			 }
             			 else
             			  return array(array('deny', 'users'=>array('*')),);
                }
                else
                {
                    return array(array('deny', 'users'=>array('*')),);
                }



	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		
	
		
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			
		));
		
	
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Payroll;
		
		$this->message_PayrollDate=false;
		$this->message_PaymentDate=false;
		 $this->message_PayrollDatePaymentDate_notInAcadRange=false;
		 $this->message_anyPayrollAfter=false;
		 $this->message_group_anyPayrollAfter=false;
		
		$acad=Yii::app()->session['currentId_academic_year'];
		
		if(isset($_POST['Payroll']['depensesItems']))
		    $this->depensesItems1 = $_POST['Payroll']['depensesItems'];
		

		if($this->depensesItems1==0)
            {
         	    $this->redirect(array('/billings/loanOfMoney/create?part=pay&from=b'));

              }
            elseif($this->depensesItems1==2)
	           {
	         	  $this->redirect(array('/billings/chargePaid/create?di=2&part=pay&from=b'));
	
	         	}
	         	

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Payroll']))
		{
			                   
	               if(isset($_POST['Payroll']['group']))
			 		 {
                        $this->group = $_POST['Payroll']['group'];
                         if($this->group==1)
                           {
                           	 $this->person_id='';
								$this->payroll_month = '';
								Yii::app()->session['payroll_person_id']='';
                           	 }
                      }
                    
		            if(isset($_POST['Payroll']['group_payroll']))
					  {
                        $this->grouppayroll = $_POST['Payroll']['group_payroll'];
                       }

                 
		           if(isset($_POST['Payroll']['payroll_month']))
		              {  
		              	$this->payroll_month = $_POST['Payroll']['payroll_month'];
					     Yii::app()->session['payroll_payroll_month'] = $this->payroll_month;
		              }
		            else
		              {
		            	 $this->payroll_month=Yii::app()->session['payroll_payroll_month'];
		            	
		            	}
			
                  if(isset($_POST['Payroll']['person_id']))
		              {  
		              	$this->person_id = $_POST['Payroll']['person_id'];
					     Yii::app()->session['payroll_person_id']=$this->person_id;
		              }
		            else
		              {
		            	 $this->person_id=Yii::app()->session['payroll_person_id'];
		            	
		            	}
		            	
			
			
			if(isset($_POST['create']))
			  {    
			  	  
			  	  $id_payroll_set ='';
			  	  $deduction ='';
			  	  $timely_salary = 0;
			  	  $number_of_hour =null;
			  	  $missing_hour =null;
			  	  $gross_salary ='';
			  	  $net_salary ='';
			  	  $missing_hour_ok = true;
			  	  
			  	  $date_payment='';
			  	  $date_payroll='';
			  	  
			  	  $this->message_PayrollDate=false;
		          $this->message_PaymentDate=false;
		          $this->message_PayrollDatePaymentDate_notInAcadRange=false;
		          $this->message_anyPayrollAfter=false;
		          $this->message_group_anyPayrollAfter=false;
			    	  
			  	  
			  	  $model->attributes=$_POST['Payroll'];
			  	  
			  	  
			  	  $date_payment =  $model->payment_date;
			  	  
			  	  
			  	    if(isset($_POST['Payroll']['taxe']))
			           {
                        $this->taxe = $_POST['Payroll']['taxe'];
                        
                        }
  
  
                   
  
   if($model->payroll_month == getMonth($model->payroll_date) )
     {
     	if($model->payment_date >= $model->payroll_date)
     	  {
               
               if((isDateInAcademicRange($model->payroll_date,$acad))&&(isDateInAcademicRange($model->payment_date,$acad))) 
                 {             
     //youn pa youn               
         if($this->group==0)
		    {    
                 $missing_hour =0;
                 $total_missing_hour =0;
                 $numberHour_=0;
                 $all='';
                 
                 $temp_month = '';
                  
                  //check if there is any after this payroll_month
                  $any_after = $this->anyPayrollDoneAfterForOnes($model->payroll_month,$model->payroll_date,$this->person_id,$acad);
                  
               if(!$any_after)  //anyPayrollAfter
                 {
                 	    
                 $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.old_new=1 AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
                 //check if it is a timely salary 
                   $model_ = new PayrollSettings;
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                    
                    $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set2 = null;
                    $id_payroll_set_emp=null;
                    $id_payroll_set_teach=null;
                    $total_gross_salary=0;
                    $total_gross_salary_initial = 0;
                    $total_net_salary=0;
                    $total_deduction=0;
                    $total_taxe=0;
                    $iri_deduction =0;
                    
                    
                 foreach($pay_set as $amount)
                   {   
                   	  $gross_salary_initial =0;
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
			               	   
			               	   $gross_salary_initial =$amount->amount;
			               	   
			               	   $missing_hour = $amount->number_of_hour;
			               	   
			               	   $numberHour_ = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	 if(isset( $_POST['PayrollSettings']))
			             	  {  $model_->attributes = $_POST['PayrollSettings'];
				             	 //return working times in minutes
				             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
				                 
				                 $missing_hour = $missing_hour - $number_of_hour;
				                 
				                  $total_missing_hour =  $total_missing_hour + $missing_hour;
			             	  }
			             	 else
			             	    $number_of_hour = $missing_hour;
			                 //calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						          
						        }
			                  
			                  if(($numberHour_!=null)&&($numberHour_!=0))
						       {
						          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
						
						        } 
			                   
			                  
			                   
			                   
			                   
			             
				            }
			           
			            //$total_gross_salary = $total_gross_salary + $gross_salary;
			            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
			          
			          	  if($this->taxe==1)
	                         {
	                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
                      	    
	                       	    $total_deduction = $total_deduction + $deduction;
	                       	   // $net_salary = $gross_salary - $deduction;
	                       	    $net_salary = $gross_salary_initial - $deduction;
	                       	 } 
	                      elseif($this->taxe==0)
	                        {
	                        	//$net_salary = $gross_salary;
	                        	$net_salary = $gross_salary_initial;
	                        	
	                          }  
                          
                          $total_net_salary = $total_net_salary + $net_salary;
                          
                          
                          
                          }
                        elseif(($as_teach==0)&&($as==1))
                            {   $as_teach=1;
                                $all='t';
	                     
			                     if(($amount!=null))
					               {  
					               	   $id_payroll_set_teach = $amount->id;
					               	   $id_payroll_set = $amount->id;
					               	   
					               	   $gross_salary =$amount->amount;
					               	   
					               	   $gross_salary_initial =$amount->amount;
					               	   
					               	   $missing_hour = $amount->number_of_hour;
					               	   
					               	   $numberHour_ = $amount->number_of_hour;
					               	   
					               	   if($amount->an_hour==1)
					                     $timely_salary = 1;
					                 }
					           //get number of hour if it's a timely salary person
					            if($timely_salary == 1)
					              {
					             	  if(isset( $_POST['PayrollSettings']))
						             	  {  $model_->attributes = $_POST['PayrollSettings'];
							             	 //return working times in minutes
							             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
							                 
							                 $missing_hour = $missing_hour - $number_of_hour;
							                 
							                 $total_missing_hour =  $total_missing_hour + $missing_hour;
						             	  }
						             	 else
						             	    $number_of_hour = $missing_hour;
					                 
					                 //calculate $gross_salary by hour if it's a timely salary person 
								    /* if(($number_of_hour!=null)&&($number_of_hour!=0))
								       {
								          $gross_salary = ($gross_salary * $number_of_hour);
								          
								        }
								      */
								        
								     if(($numberHour_!=null)&&($numberHour_!=0))
								       {
								          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
								
								        } 
					                   
					             
						            }
					           
					            //$total_gross_salary = $total_gross_salary + $gross_salary;
					            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
					          
					          	  if($this->taxe==1)
			                         {
			                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
			                       	    $total_deduction = $total_deduction + $deduction;
			                       	    //$net_salary = $gross_salary - $deduction;
			                       	    $net_salary = $gross_salary_initial - $deduction;
			                       	 } 
			                      elseif($this->taxe==0)
			                        {
			                        	//$net_salary = $gross_salary;
			                        	$net_salary = $gross_salary_initial;
			                          }  
		                          
		                          $total_net_salary = $total_net_salary + $net_salary;
		                          
                          
                          
                               }
                       
                      }
                       
                       
                      if(($as_emp==1) && ($as_teach==1))
		                   {  //alafwa employee e teacher
		                   	   //save payroll la sou employee
		                   	   
		                   	   $all='e';
		                   	   
		                   	   $id_payroll_set=$id_payroll_set_emp;
		                   	   $id_payroll_set2 = $id_payroll_set_teach;
		                   	   $number_of_hour=null;
		                   	   $missing_hour=null;
		                   	   
		                   	 }

                      //DEDUCTION TAXE IRI
                       if($this->taxe==1)
	                     {
	                     		//IRI
	                       	$iri_deduction = getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary_initial);
	                       	$total_deduction = $total_deduction + $iri_deduction;
	                       	$total_net_salary = $total_net_salary - $iri_deduction;
	      
	       
	                       }
                       
                      
                     
                     
                       //loan nan ap prelve sou montan total payroll moun nan
                       //check if there is a loan
                       $modelLoan = new LoanOfMoney;
                       $dataModelLoan = $modelLoan->findByAttributes(array('person_id'=>$this->person_id, 'academic_year'=>$acad, 'paid'=>0));
                        
                                      
                        $total_taxe = $total_taxe + $total_deduction;
            
                        
                        if($dataModelLoan!=null)
                          { 
                          	 $loan=$dataModelLoan;//->getData();
                          	 $l_payroll_month= $loan->payroll_month;
                          	 $l_amount= $loan->amount;
                          	 $l_percent_of_deduct= $loan->deduction_percentage;
                          	 $l_solde= $loan->solde;

                          	$temp_month = $this->payroll_month;
                          	
                          	if($l_payroll_month <= $temp_month )
                          	  { 
                          	     $l_remaining_month_number = $loan->remaining_month_number -1;
                          	 
                          	 //$deduction_ = ( ($total_gross_salary * $l_percent_of_deduct)/100);
                          	 $deduction_ = ( ($total_gross_salary_initial * $l_percent_of_deduct)/100);
                          	 
                          	 
                          	 $total_deduction = $total_deduction + $deduction_;
  	         	
  	         	             $l_solde=$l_solde-$deduction_;
  	         	             //if $l_solde >0, ==0, <0
  	         	             if($l_solde>0)
  	         	               {
  	         	               	  $dataModelLoan->setAttribute('solde',$l_solde);
  	         	               	  $dataModelLoan->setAttribute('paid',0);
  	         	               	  $dataModelLoan->setAttribute('remaining_month_number',$l_remaining_month_number);
  	         	               	  $dataModelLoan->setAttribute('date_updated',date('Y-m-d'));
  	         	               	  $dataModelLoan->save();  
  	         	               	  
  	         	               	   $total_net_salary = $total_net_salary - $deduction_;
  	         	                 }
  	         	              elseif($l_solde==0)
  	         	                {
  	         	                	$dataModelLoan->setAttribute('solde',0);
  	         	                  $dataModelLoan->setAttribute('paid',1);
  	         	                   $dataModelLoan->setAttribute('remaining_month_number',0);
  	         	               	  $dataModelLoan->setAttribute('date_updated',date('Y-m-d'));
  	         	               	  $dataModelLoan->save();
  	         	               	  
  	         	               	    $total_net_salary = $total_net_salary - $deduction_;
  	         	                  }
  	         	               elseif($l_solde<0)
  	         	                 {
  	         	                  	$dataModelLoan->setAttribute('solde',0);
  	         	               	  $dataModelLoan->setAttribute('paid',1);
  	         	               	   $dataModelLoan->setAttribute('remaining_month_number',0);
  	         	               	  $dataModelLoan->setAttribute('date_updated',date('Y-m-d'));
  	         	               	  $dataModelLoan->save();
  	         	               	  
  	         	               	     $total_net_salary = ($total_net_salary - $deduction_) - $l_solde;
  
  	         	                   }
  	         	                   
  	         	                   
                          	    } 
  	         	                   
  	         	            
  	         	             }

		           
		                  		                   	 
		                   	 
		               if($model->cash_check=='')
		                  $model->setAttribute('cash_check', Yii::t('app','Cash') );
		           
			           $model->setAttribute('id_payroll_set',$id_payroll_set);
			           $model->setAttribute('id_payroll_set2',$id_payroll_set2);
			           //$model->setAttribute('person_id',$this->person_id);
			           //$model->setAttribute('number_of_hour',$number_of_hour);
			           $model->setAttribute('missing_hour',$total_missing_hour);
			           $model->setAttribute('taxe',$total_taxe);
			           $model->setAttribute('net_salary',$total_net_salary);
			           
							 
						$model->setAttribute('date_created',date('Y-m-d'));
					  	$model->setAttribute('created_by',Yii::app()->user->name);

			            
					if($model->save())
					 {
					   $month_=$model->payroll_month;
			           $year_= getYear($model->payment_date);
			           
			           //$this->redirect(array('index','month_'=>$month_,'year_'=>$year_,'all'=>$all,'di'=>1,'part'=>'pay','from'=>''));  
			           $this->redirect(array('view','id'=>$model->id,'month_'=>$month_,'year_'=>$year_,'all'=>$all,'di'=>1,'part'=>'pay','from'=>''));
					   }
					
		       
					
					
				}
     	     else  //fen "any payroll after this month"
     	       $this->message_anyPayrollAfter=true;	
					
					
					
					
					
					
		  }
	//fen youn pa youn_________________
	elseif($this->group==1)
	   {   
	   	       
	//an gwoup ____________________________				
					   $this->message_noOneSelected=false;
					   $this->message_wrongMissingTime=false;
					   $this->message_group_anyPayrollAfter=false;
					   Yii::app()->session['message_group_anyPayrollAfter']=0;
					   
					   $temwen=false;
					   $person='';
					   $missingHour='';
					   $month='';
					   
					   $temp_month='';
					   
					   $month_='';
					   $year_='';
					   $all='';
					   
					   $payroll_date = $model->payroll_date;
					   $payroll_month = $model->payroll_month;
					   $payment_date = $model->payment_date;   	
					
					  
				if(isset($_POST['chk'])) 
				 {  foreach($_POST['chk'] as $id)
		              {  
		                     $this->person_id = $id;
		                     
                 $total_missing_hour = 0;
                 $missing_hour =0;
                 $numberHour_=0;
                 $all='';
                 
                 //check if there is any after this payroll_month
                  $any_after = $this->anyPayrollDoneAfterForOnes($payroll_month,$payroll_date,$this->person_id,$acad);
                  
	               if($any_after)  //anyPayrollAfter
	                  Yii::app()->session['message_group_anyPayrollAfter']=1;
	               else
	               {
                 
	                 $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.old_new=1 AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
	                 //check if it is a timely salary 
	                   $model_ = new PayrollSettings;
	                     $pay_set = PayrollSettings::model()->findAll($criteria);
	                    
	                    $as_emp=0;
	                    $as_teach=0;
	                    $id_payroll_set2 = null;
	                    $id_payroll_set_emp=null;
	                    $id_payroll_set_teach=null;
	                    $total_gross_salary=0;
	                    $total_gross_salary_initial = 0;
	                    $total_net_salary=0;
	                    $total_deduction=0;
	                    $total_taxe=0;
	                    $iri_deduction =0;
	                   
	                    
	                 foreach($pay_set as $amount)
	                   {   
	                   	  $gross_salary_initial =0;
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
				               	   
				               	   $gross_salary_initial =$amount->amount;
				               	   
				               	   $missing_hour = $amount->number_of_hour;
				               	   
				               	   $numberHour_ = $amount->number_of_hour;
				               	   
				               	   if($amount->an_hour==1)
				                     $timely_salary = 1;
				                 }
				           //get number of hour if it's a timely salary person
				            if($timely_salary == 1)
				              {
				             	 if(isset( $_POST['PayrollSettings']))
				             	  {  $model_->attributes = $_POST['PayrollSettings'];
					             	 //return working times in minutes
					             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
					                 
					                 $missing_hour = $missing_hour - $number_of_hour;
					                 
					                 $total_missing_hour =  $total_missing_hour + $missing_hour;
					                 
				             	  }
				             	 else
				             	    $number_of_hour = $missing_hour;
				                 //calculate $gross_salary by hour if it's a timely salary person 
							    /* if(($number_of_hour!=null)&&($number_of_hour!=0))
							       {
							          $gross_salary = ($gross_salary * $number_of_hour);
							          
							        }
				                  */
				                  
				                  
				                  if(($numberHour_!=null)&&($numberHour_!=0))
							       {
							          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
							
							        } 
				                   
				                  
				                   
				                   
				                   
				             
					            }
				           
				            //$total_gross_salary = $total_gross_salary + $gross_salary;
				            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
				          
				          	  if($this->taxe==1)
		                         {
		                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
	                      	    
		                       	    $total_deduction = $total_deduction + $deduction;
		                       	    //$net_salary = $gross_salary - $deduction;
		                       	    $net_salary = $gross_salary_initial - $deduction;
		                       	 } 
		                      elseif($this->taxe==0)
		                        {
		                        	//$net_salary = $gross_salary;
		                        	$net_salary = $gross_salary_initial;
		                          }  
	                          
	                          $total_net_salary = $total_net_salary + $net_salary;
	                          
	                          
	                          
	                          }
	                        elseif(($as_teach==0)&&($as==1))
	                            {   $as_teach=1;
	                                $all='t';
		                     
				                     if(($amount!=null))
						               {  
						               	   $id_payroll_set_teach = $amount->id;
						               	   $id_payroll_set = $amount->id;
						               	   
						               	   $gross_salary =$amount->amount;
						               	   
						               	   $gross_salary_initial =$amount->amount;
						               	   
						               	   $missing_hour = $amount->number_of_hour;
						               	   
						               	   $numberHour_ = $amount->number_of_hour;
						               	   
						               	   if($amount->an_hour==1)
						                     $timely_salary = 1;
						                 }
						           //get number of hour if it's a timely salary person
						            if($timely_salary == 1)
						              {
						             	  if(isset( $_POST['PayrollSettings']))
							             	  {  $model_->attributes = $_POST['PayrollSettings'];
								             	 //return working times in minutes
								             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
								                 
								                 $missing_hour = $missing_hour - $number_of_hour;
								                 
								                 $total_missing_hour =  $total_missing_hour + $missing_hour;
								                 
							             	  }
							             	 else
							             	    $number_of_hour = $missing_hour;
						                 //calculate $gross_salary by hour if it's a timely salary person 
									    /* if(($number_of_hour!=null)&&($number_of_hour!=0))
									       {
									          $gross_salary = ($gross_salary * $number_of_hour);
									          
									        }
									      */
									        
									     if(($numberHour_!=null)&&($numberHour_!=0))
									       {
									          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
									
									        } 
						                   
						             
							            }
						           
						            //$total_gross_salary = $total_gross_salary + $gross_salary;
						            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
						          
						          	  if($this->taxe==1)
				                         {
				                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
				                       	    $total_deduction = $total_deduction + $deduction;
				                       	    //$net_salary = $gross_salary - $deduction;
				                       	    $net_salary = $gross_salary_initial - $deduction;
				                       	 } 
				                      elseif($this->taxe==0)
				                        {
				                        	//$net_salary = $gross_salary;
				                        	$net_salary = $gross_salary_initial;
				                        	
				                          }  
			                          
			                          $total_net_salary = $total_net_salary + $net_salary;
			                          
	                          
	                          
	                               }
	                       
	                      }
	                       
	                       
	                      if(($as_emp==1) && ($as_teach==1))
			                   {  //alafwa employee e teacher
			                   	   //save payroll la sou employee
			                   	   
			                   	   $all='e';
			                   	   
			                   	   $id_payroll_set=$id_payroll_set_emp;
			                   	   $id_payroll_set2 = $id_payroll_set_teach;
			                   	   $number_of_hour=null;
			                   	   $missing_hour=null;
			                   	   
			                   	 }
			                   	 
			                   	 
	                      //DEDUCTION TAXE IRI
	                       if($this->taxe==1)
		                     {
		                       	//IRI
		                       	$iri_deduction = getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary_initial);
		                       	$total_deduction = $total_deduction + $iri_deduction;
		                       	$total_net_salary = $total_net_salary - $iri_deduction;
		                       }
	                       
	                     
	                     
	                     
	                       //loan nan ap prelve sou montan total payroll moun nan
	                       //check if there is a loan
	                       $modelLoan = new LoanOfMoney;
	                       $dataModelLoan = $modelLoan->findByAttributes(array('person_id'=>$this->person_id, 'academic_year'=>$acad, 'paid'=>0));
	                          
	                        $total_taxe = $total_taxe + $total_deduction;
	                        
	                        if($dataModelLoan!=null)
	                          { 
	                          	 $loan=$dataModelLoan;//->getData();
	                          	 $l_payroll_month= $loan->payroll_month;
	                          	 $l_amount= $loan->amount;
	                          	 $l_percent_of_deduct= $loan->deduction_percentage;
	                          	 $l_solde= $loan->solde;
	
	                              $temp_month = $this->payroll_month;
	                          	
	                          	if($l_payroll_month <= $temp_month )
	                          	  { 
	                          	     $l_remaining_month_number = $loan->remaining_month_number -1;
	                          	 
	                          	 //$deduction_ = ( ($total_gross_salary * $l_percent_of_deduct)/100);
	                          	 $deduction_ = ( ($total_gross_salary_initial * $l_percent_of_deduct)/100);
	                          	 
	                          	 $total_deduction = $total_deduction + $deduction_;
	  	         	
	  	         	
	  	         	             $l_solde=$l_solde-$deduction_;
	  	         	             //if $l_solde >0, ==0, <0
	  	         	             if($l_solde>0)
	  	         	               {
	  	         	               	  $dataModelLoan->setAttribute('solde',$l_solde);
	  	         	               	  $dataModelLoan->setAttribute('paid',0);
	  	         	               	  $dataModelLoan->setAttribute('remaining_month_number',$l_remaining_month_number);
	  	         	               	  $dataModelLoan->setAttribute('date_updated',date('Y-m-d'));
	  	         	               	  $dataModelLoan->save();  
	  	         	               	  
	  	         	               	   $total_net_salary = $total_net_salary - $deduction_;
	  	         	                 }
	  	         	              elseif($l_solde==0)
	  	         	                {
	  	         	                	$dataModelLoan->setAttribute('solde',0);
	  	         	                  $dataModelLoan->setAttribute('paid',1);
	  	         	                   $dataModelLoan->setAttribute('remaining_month_number',0);
	  	         	               	  $dataModelLoan->setAttribute('date_updated',date('Y-m-d'));
	  	         	               	  $dataModelLoan->save();
	  	         	               	  
	  	         	               	    $total_net_salary = $total_net_salary - $deduction_;
	  	         	                  }
	  	         	               elseif($l_solde<0)
	  	         	                 {
	  	         	                  	$dataModelLoan->setAttribute('solde',0);
	  	         	               	  $dataModelLoan->setAttribute('paid',1);
	  	         	               	   $dataModelLoan->setAttribute('remaining_month_number',0);
	  	         	               	  $dataModelLoan->setAttribute('date_updated',date('Y-m-d'));
	  	         	               	  $dataModelLoan->save();
	  	         	               	  
	  	         	               	     $total_net_salary = ($total_net_salary - $deduction_) - $l_solde;
	  
	  	         	                   }
	  	         	                   
	  	         	                   
	                          	    } 
	  	         	                   
	  	         	            
	  	         	             }
	
			         
			                   	 
			                   	 
			               if($model->cash_check=='')
			                  $model->setAttribute('cash_check', Yii::t('app','Cash') );
			           
				           $model->setAttribute('id_payroll_set',$id_payroll_set);
				           $model->setAttribute('id_payroll_set2',$id_payroll_set2);
				           $model->setAttribute('person_id',$this->person_id);
				           $model->setAttribute('number_of_hour',$number_of_hour);
				           $model->setAttribute('missing_hour',$total_missing_hour);
				           $model->setAttribute('taxe',$total_taxe);
				           $model->setAttribute('net_salary',$total_net_salary);
				           $model->setAttribute('payroll_month',$payroll_month);
				            $model->setAttribute('payroll_date',$payroll_date);
				           $model->setAttribute('payment_date',$payment_date);
								 
							$model->setAttribute('date_created',date('Y-m-d'));
						  	$model->setAttribute('created_by',Yii::app()->user->name);
	
				            
									if($model->save())
									 {
									   $month_=$model->payroll_month;
							           $year_= getYear($model->payment_date);
							           	
							           	$model->unSetAttributes();
										$model= new Payroll;
													   
										 $total_taxe =0;
										 $total_missing_hour = 0;
													   
										$temwen=true;
	
									   }
						
			       
						
						
				                     
							     }
									   
		                         
		                }//fe message_group_anyPayrollAfter		   
		                     
							   
				        }
				      else //message vous n'avez croche personne
						{
							$this->message_noOneSelected=true;
							
							}
							
					
					  if($temwen)
					    {
					    	 	
						     $this->redirect(array('index','month_'=>$month_,'year_'=>$year_,'all'=>$all,'di'=>1,'part'=>'pay','from'=>''));  //$this->redirect(array('view','id'=>$model->id,'part'=>'pay','from'=>''));
					   
						     	
						     					            
					            
					     }
								
					 }		
		//fen an gwoup___________________________
		
		
		
		       }
     	     else  //$model->payment_date or $model->payroll_date not in academic range
     	       $this->message_PayrollDatePaymentDate_notInAcadRange=true;
		
		
				
     	  }
     	else  //$model->payment_date < $model->payroll_date
     	  $this->message_PaymentDate=true;
     }
  else  //$model->payroll_month != getMonth($model->payroll_date)
    $this->message_PayrollDate=true;
	 

	
	
		
		
		
	}//fen if($_POST['create'])	
			
			
			
			
			if(isset($_POST['cancel']))
			  {    
			  	$model=new Payroll;
				$this->person_id='';
				$this->payroll_month = '';
				Yii::app()->session['payroll_person_id']='';
				$this->grouppayroll = '';
				$this->group = 0;
				$this->taxe=0;
					
			  }
				
		}
     else
       {
       	       if((isset($_GET['from1']))&&($_GET['from1']=='vfr'))
       	         {
       	         	   $this->group =0;
                       
                         $this->person_id = $_GET['emp'];
					     Yii::app()->session['payroll_person_id']=$this->person_id;
		             
		              $this->payroll_month = $_GET['month_'];
					     Yii::app()->session['payroll_payroll_month'] = $this->payroll_month;
       	          
       	          }
		            
			
       	  }
       	  

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$acad=Yii::app()->session['currentId_academic_year'];
		$all='';
		$this->message_UpdatePastDate=false;
		$this->message_PayrollDate=false;
		$this->message_PaymentDate=false;                
                
		
		$loan=0;
		$total_taxe = 0;
		
		 $model_new=new Payroll;
		
	 if(!isset($_GET['group']))
      {	
		$id_payroll_set ='';
		$gross_salary ='';
		$timely_salary = 0;
		
		$model=$this->loadModel($id);
		
		//$loan = Payroll::model()->getLoanDeduction($model->idPayrollSet->person_id,$model->getGrossSalary($model->idPayrollSet->person_id),$model->idPayrollSet->number_of_hour,$model->missing_hour,$model->net_salary,$model->taxe); 
		$loan = Payroll::model()->getLoanDeduction($model->idPayrollSet->person_id,$model->getGrossSalaryIndex_value($model->idPayrollSet->person_id,$model->payroll_month,getYear($model->payment_date)  ),$model->idPayrollSet->number_of_hour,0,$model->net_salary,$model->taxe);
	/*------ nbre jours apres la date de paiement, on ne pourra plus editer les enregistrements    -------*/	
	//Extract limit payroll update 
		$limit_payroll_update = infoGeneralConfig('limit_payroll_update');
		
		if($limit_payroll_update!='')
		 {
		
			$date = $model->payment_date;
	        $newdate = strtotime ( '+'.$limit_payroll_update.' day' , strtotime ( $date ) ) ;
	        $newdate = date ( 'Y-m-j' , $newdate );//date('Y-m-d')
	         if(date('Y-m-d')>$newdate)
			   {
			     //$this->message_UpdateValidate=1;
			     //header('Location: ' . $_SERVER['HTTP_REFERER']);
			      $url=Yii::app()->request->urlReferrer;
				  $this->redirect($url.'/msguv/y');
				  //$this->redirect(Yii::app()->request->urlReferrer);
			    }
			
          }	       	
				       	
		
		if($model->taxe!=0)
		   $this->taxe=1;
		   
		 $this->person_id =$model->idPayrollSet->person_id; 
		 
		 $id_payroll_set = $model->id_payroll_set;
		 $id_payroll_set2 = $model->id_payroll_set2;
		 
		 
		 $missing_hour1 ='';
		 $number_of_hour = $model->number_of_hour;
		//check if it is a timely salary 
		 //$check = missingTimes($this->person_id,$number_of_hour,$acad);
		 
		$missing_hour1 = $model->missing_hour;
		
         /*          $model_ = new PayrollSettings;
                   $amount = PayrollSettings::model()->find('person_id=:Id AND academic_year=:acad order by date_created DESC',array(':Id'=>$this->person_id,':acad'=>$acad));
                     if(isset($amount)&&($amount!=null))
		               {  
		               	   $id_payroll_set = $amount->id;
		               	   
		               	   $gross_salary =$amount->amount;
		               	   
		               	   if($amount->an_hour==1)
		                     {  
		                     	 $timely_salary = 1;
		                     	 //return working times in minutes
		             	         $base_number_of_hour = $this->getHours($this->person_id,$acad);
		             	         
		                         $missing_hour1 = $base_number_of_hour - $number_of_hour;
		                     }
		                 }

              if($missing_hour1>0)
                {
                	$model->setAttribute('missing_hour',$this->setMissingTimeForUpdate($missing_hour1));
                	
                	}
                	
               */
               
           //if($check!=null)    
              //$model->setAttribute('missing_hour',$missing_hour1);  	

       }
      else 
        {
                $model=new Payroll;
                $condition='';
                $this->group = 1;
                $timely_salary = 0; 
               
               	
               	
               	 if(isset($_POST['Payroll']['payroll_month']))
		            {  
		              	$this->payroll_month = $_POST['Payroll']['payroll_month'];
					     
		              }
 
                
                  if(isset($_POST['Payroll']['group_payroll']))
					  {
                        $this->grouppayroll = $_POST['Payroll']['group_payroll'];
                        
                          if($this->grouppayroll!=Yii::app()->session['payroll_group_payroll'])
                            {  
                            	// Yii::app()->session['payroll_group_payroll'] = $this->grouppayroll;
                            	$this->payroll_month=null;
                            	 $this->payroll_date =null;
                                     $this->taxe =0;
                                    
                              }
                        
                       }
                        	
		                 
           
                            if($this->grouppayroll==2)//teacher
                              {   
                                 
                                $condition='p.is_student=0 AND p.active IN(1, 2) ';
                                    
                                    $header=Yii::t('app','Teachers name');
                                   // $all='t';
                                   // $this->grouppayroll=2;
                                                                    }
                               elseif($this->grouppayroll==1)//employee
                                  { $condition='is_student=0 AND active IN(1, 2)  ';
                                  
                                      $header=Yii::t('app','Employees name');
                                     // $all='e';
                                     // $this->grouppayroll=1;
                                     
                                   }
                
               if($this->payroll_month=='')
                 {    $as_ =0;
                 	//get the last payroll month
                       if($this->grouppayroll==2)
                          $as_ =1;
                       
                           
                 	$dataProvider_last_pay=Payroll::model()->getInfoLastPayrollByPayroll_group($as_);
                 	$last_pay=$dataProvider_last_pay->getData();
                 	 
                         if($last_pay!=null)
                           {   foreach($last_pay as $r)
                                 {
                                     $this->payroll_month=$r->payroll_month;
                                     break;
                                 	}
                            
                         	  }
                       else
                         { 
                         	$this->payroll_month=0;
                          }
                   
                   }
                 
                
                $this->payroll_date = $this->getLastPastPayrollDateByGroup($this->payroll_month);
                
                        $dataProvider=Payroll::model()->searchPersonsForUpdatePayroll($condition,$this->payroll_month, $this->payroll_date, $acad);	
                         $info=$dataProvider->getData();
                         
                         if($info!=null)
                           {   $taxe=0;
                               $payment_date='';
                              
                               foreach($info as $r)
                                 {
                                 	  if($r->taxe!=0)
                                 	    $this->taxe=1;
                                 	    
                                     $payment_date=$r->payment_date;
                                     $payroll_date=$r->payroll_date;
                                    
                                     break;
                                 	}
                                 	
                                	
							    $model->setAttribute('taxe',$this->taxe);
                         	    $model->setAttribute('payment_date',$payment_date);
                         	     $model->setAttribute('payroll_date',$this->payroll_date);
                         	    
                          	    
                         	  }
                         	  
                         	   
		              /*------ nbre jours apres la date de paiement, on ne pourra plus editer les enregistrements    -------*/	
					//Extract limit payroll update 
						$limit_payroll_update = infoGeneralConfig('limit_payroll_update');
						
						if($limit_payroll_update!='')
						 {
						   
							$date = $model->payment_date;
					        $newdate = strtotime ( '+'.$limit_payroll_update.' day' , strtotime ( $date ) ) ;
					        $newdate = date ( 'Y-m-j' , $newdate );//date('Y-m-d')
					         if(date('Y-m-d')>$newdate)
							   {
							     $this->group=1;
							     //$this->message_UpdateValidate=1;
							     //header('Location: ' . $_SERVER['HTTP_REFERER']);
							      $url=Yii::app()->request->urlReferrer;
								  $this->redirect($url.'/msguv/y');
								  //$this->redirect(Yii::app()->request->urlReferrer);
							    }
							
				          }
				
                                 	
                 Yii::app()->session['payroll_group_payroll'] = $this->grouppayroll;
            
            }


		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);



	 if(isset($_POST['Payroll']))
		{
			
			
						
						
			
	   if(isset($_POST['update']))
	    {    
		   $this->message_PayrollDate=false;
		   $this->message_PaymentDate=false;                
                
		   
		    $model_new->attributes=$_POST['Payroll'];
			  	  
			  	  
			  	  $date_payment =  $model_new->payment_date;
			  	  $date_payroll =  $model_new->payroll_date;
			  	  
			  	  
			  	    if(isset($_POST['Payroll']['taxe']))
			           {
                        $this->taxe = $_POST['Payroll']['taxe'];
                        
                        }
		   
		  
 
  	 
   if($model_new->payroll_month == getMonth($model_new->payroll_date) )
     {
     	if($model_new->payment_date >= $model_new->payroll_date)
     	  {
   	   
		   
		   if(!isset($_GET['group']))
		      { 
	 //youn pa youn ___________________________	  
			  	  $missing_hour =0;
                  $numberHour_=0;
                  $all='';

			    	$as_emp=0;
                    $as_teach=0;
                    $id_payroll_set2 = null;
                    $id_payroll_set_emp=null;
                    $id_payroll_set_teach=null;
                    $total_gross_salary=0;
                    $total_gross_salary_initial = 0;
                    $total_net_salary=0;
                    $total_deduction=0;
                    $total_taxe =0;
                    $iri_deduction =0; 
                      
			  	  
			  	  $model_new->attributes=$_POST['Payroll'];
			  	  
			  	  
			  	    if(isset($_POST['Payroll']['taxe']))
			           {
                        $this->taxe = $_POST['Payroll']['taxe'];
                        
                        }
                        
                  		
			        // $this->payroll_month=Yii::app()->session['payroll_payroll_month'];
			        
					 $employee_teacher = Persons::model()->isEmployeeTeacher($this->person_id, $acad);	
							  
				    if(!$employee_teacher)//si moun nan pa alafwa anplwaye-pwofese 
                     { $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>' ps.id='.$id_payroll_set.' AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
                 
                      $modelPayrollSettings = PayrollSettings::model()->findAll($criteria);

                      
	                  foreach($modelPayrollSettings as $amount)
	                   { 
                        $gross_salary_initial =0;
                   	    $gross_salary =0;
                   	    $deduction =0;
                   	    $net_salary=0;
                   	  
                         
	                     if(($amount!=null))
			               {  
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $gross_salary_initial =$amount->amount;
			               	   
			               	   $missing_hour = $amount->number_of_hour;
			               	   
			               	   $numberHour_ = $amount->number_of_hour;
			               	   
			               	   if($amount->as ==0)
			               	     $all= 'e';
			               	   elseif($amount->as ==1)
			               	      $all= 't';
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {  
			              	$model_ = new PayrollSettings;
			              	
			             	 if(isset( $_POST['PayrollSettings']))
			             	  {  $model_->attributes = $_POST['PayrollSettings'];
				             	 //return working times in minutes
				             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
				                 
				                 $missing_hour = $missing_hour - $number_of_hour;
			             	  }
			             	 else
			             	    $number_of_hour = $missing_hour;
			                 //calculate $gross_salary by hour if it's a timely salary person 
						    /* if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						          
						        }
			                  */
			                  
			                  
			                  if(($numberHour_!=null)&&($numberHour_!=0))
						       {
						          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
						
						        } 
			                   
			                  
			               }
			           
			            //$total_gross_salary = $total_gross_salary + $gross_salary;
			            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
			          
			          	  if($this->taxe==1)
	                         {
	                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
                      	    
	                       	    $total_deduction = $total_deduction + $deduction;
	                       	   // $net_salary = $gross_salary - $deduction;
	                       	    $net_salary = $gross_salary_initial - $deduction;
	                       	 } 
	                      elseif($this->taxe==0)
	                        {
	                        	//$net_salary = $gross_salary;
	                        	$net_salary = $gross_salary_initial;
	                          }  
                          
                          $total_net_salary = $total_net_salary + $net_salary;
                          
                          }
	                      
	                  
	                  
	                   //DEDUCTION TAXE IRI
                       if($this->taxe==1)
	                     {
	                      	//IRI
	                       	$iri_deduction = getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary_initial);
	                       	$total_deduction = $total_deduction + $iri_deduction;
	                       	$total_net_salary = $total_net_salary - $iri_deduction;
	                       	
	                       } 
                        
                        $total_taxe = $total_taxe + $total_deduction;
                        
                        //DEDUCTION LOAN
                         $total_deduction = $total_deduction + $loan;
	                       	$total_net_salary = $total_net_salary - $loan;
	                       
                         
                       }
                    else //moun nan alafwa anplwaye-pwofese
                      {  $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.old_new=1 AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
                        $modelPayrollSettings = PayrollSettings::model()->findAll($criteria);
                      	 
                      foreach($modelPayrollSettings as $amount)
	                   {   
	                   	  $gross_salary_initial =0;
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
				               	   
				               	   $gross_salary_initial =$amount->amount;
				               	   
				               	   $missing_hour = $amount->number_of_hour;
				               	   
				               	   $numberHour_ = $amount->number_of_hour;
				               	   
				               	   if($amount->an_hour==1)
				                     $timely_salary = 1;
				                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			              	  $model_ =  new PayrollSettings;
			              	  
			             	 if(isset( $_POST['PayrollSettings']))
			             	  {  $model_->attributes = $_POST['PayrollSettings'];
				             	 //return working times in minutes
				             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
				                 
				                 $missing_hour = $missing_hour - $number_of_hour;
			             	  }
			             	 else
			             	    $number_of_hour = $missing_hour;
			                 //calculate $gross_salary by hour if it's a timely salary person 
						     /*if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						          
						        }
			                  */
			                  
			                  if(($numberHour_!=null)&&($numberHour_!=0))
						       {
						          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
						
						        } 
			                   
			             
				            }
			           
			            //$total_gross_salary = $total_gross_salary + $gross_salary;
			            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
			          
			          	  if($this->taxe==1)
	                         {
	                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
                      	    
	                       	    $total_deduction = $total_deduction + $deduction;
	                       	    //$net_salary = $gross_salary - $deduction;
	                       	    $net_salary = $gross_salary_initial - $deduction;
	                       	 } 
	                      elseif($this->taxe==0)
	                        {
	                        	//$net_salary = $gross_salary;
	                        	$net_salary = $gross_salary_initial;
	                        	
	                          }  
                          
                          $total_net_salary = $total_net_salary + $net_salary;
                          
                          
                          
                          }
                        elseif(($as_teach==0)&&($as==1))
                            {   $as_teach=1;
                                $all='t';
	                     
			                     if(($amount!=null))
					               {  
					               	   $id_payroll_set_teach = $amount->id;
					               	   $id_payroll_set = $amount->id;
					               	   $id_payroll_set2 = $amount->id;
					               	   
					               	   $gross_salary =$amount->amount;
					               	   
					               	   $gross_salary_initial =$amount->amount;
					               	   
					               	   $missing_hour = $amount->number_of_hour;
					               	   
					               	   $numberHour_ = $amount->number_of_hour;
					               	   
					               	   if($amount->an_hour==1)
					                     $timely_salary = 1;
					                 }
					           //get number of hour if it's a timely salary person
					            if($timely_salary == 1)
					              {
			                     	  $model_ =  new PayrollSettings;
			              	  
					             	  if(isset( $_POST['PayrollSettings']))
						             	  {  $model_->attributes = $_POST['PayrollSettings'];
							             	 //return working times in minutes
							             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
							                 
							                 $missing_hour = $missing_hour - $number_of_hour;
						             	  }
						             	 else
						             	    $number_of_hour = $missing_hour;
					                 //calculate $gross_salary by hour if it's a timely salary person 
								    /* if(($number_of_hour!=null)&&($number_of_hour!=0))
								       {
								          $gross_salary = ($gross_salary * $number_of_hour);
								          
								        }
								       */ 
								     if(($numberHour_!=null)&&($numberHour_!=0))
								       {
								          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
								
								        } 
					                   
					             
						            }
					           
					            //$total_gross_salary = $total_gross_salary + $gross_salary;
					            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
					          
					          	  if($this->taxe==1)
			                         {
			                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
			                       	    $total_deduction = $total_deduction + $deduction;
			                       	    //$net_salary = $gross_salary - $deduction;
			                       	    $net_salary = $gross_salary_initial - $deduction;
			                       	 } 
			                      elseif($this->taxe==0)
			                        {
			                        	//$net_salary = $gross_salary;
			                        	$net_salary = $gross_salary_initial;
			                          }  
		                          
		                          $total_net_salary = $total_net_salary + $net_salary;
		                          
                          
                          
                               }
                       
                           }
                       
                       
                      
                      //DEDUCTION TAXE IRI
                       if($this->taxe==1)
	                     {
	                       	//IRI
	                       	$iri_deduction = getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary_initial);
	                       	$total_deduction = $total_deduction + $iri_deduction;
	                       	$total_net_salary = $total_net_salary - $iri_deduction;
	                       	
	                       }
                       
                       $total_taxe = $total_taxe + $total_deduction;
                       
                         //DEDUCTION LOAN
                         $total_deduction = $total_deduction + $loan;
	                       	$total_net_salary = $total_net_salary - $loan;
                      	
                      	} //fen alafwa anplwaye-pwofese
                     
                      if(($as_emp==1) && ($as_teach==1))
		                   {  //alafwa employee e teacher
		                   	   //save payroll la sou employee
		                   	   
		                   	   $all='e';
		                   	   
		                   	   //$id_payroll_set=$id_payroll_set_emp;
		                   	   //$id_payroll_set2 = $id_payroll_set_teach;
		                   	   $number_of_hour=null;
		                   	   $missing_hour=null;
		                   	   
		                   	 }
		                   	 
		                   	 
		               if($model_new->cash_check=='')
		                  $model->setAttribute('cash_check', Yii::t('app','Cash') );
		               else
		                  $model->setAttribute('cash_check', $model_new->cash_check );
		                  
		                  $model->setAttribute('payroll_date',$model_new->payroll_date);
		                  $model->setAttribute('payment_date',$model_new->payment_date);
			              $model->setAttribute('payroll_month',$model_new->payroll_month);
			           
		           
			           //$model->setAttribute('id_payroll_set',$id_payroll_set);
			           //$model->setAttribute('id_payroll_set2',$id_payroll_set2);
			           $model->setAttribute('person_id',$this->person_id);
			           $model->setAttribute('number_of_hour',$number_of_hour);
			           $model->setAttribute('missing_hour',$missing_hour);
			           $model->setAttribute('taxe',$total_taxe);
			           $model->setAttribute('net_salary',$total_net_salary);
			           							 
						$model->setAttribute('date_updated',date('Y-m-d'));
					  	$model->setAttribute('updated_by',Yii::app()->user->name);

			            
					if($model->save())
					 {
					   $month_=$model->payroll_month;
			           $year_= getYear($model->payment_date);
			           
			           //$this->redirect(array('index','month_'=>$month_,'year_'=>$year_,'all'=>$all,'di'=>1,'part'=>'pay','from'=>''));  
			           $this->redirect(array('view','id'=>$model->id,'month_'=>$month_,'year_'=>$year_,'all'=>$all,'di'=>1,'part'=>'pay','from'=>''));
					   }
					
                     
		         
			   }
// fen youn pa youn ___________________________
             else
               {
         //an gwoup ___________________________      	
                $this->message_noOneSelected=false;
					   $this->message_wrongMissingTime=false;
					   
					   $temwen=false;
					   $person='';
					   $missingHour='';
					   $month='';
					   
					   $month_='';
					   $year_='';
					   $all='';
					   
					     	
					
					  
				if(isset($_POST['chk'])) 
				 {  foreach($_POST['chk'] as $id)
		              {
		              	  $id_payroll_set ='';
		              	  $id_payroll_set2 = null;
		$gross_salary ='';
		$timely_salary = 0;
		$loan = 0;
		
		$model=$this->loadModel($id);
		
		//$loan = Payroll::model()->getLoanDeduction($model->idPayrollSet->person_id,$model->getGrossSalary($model->idPayrollSet->person_id),$model->idPayrollSet->number_of_hour,$model->missing_hour,$model->net_salary,$model->taxe);
		$loan = Payroll::model()->getLoanDeduction($model->idPayrollSet->person_id,$model->getGrossSalaryIndex_value($model->idPayrollSet->person_id, $model->payroll_month,getYear($model->payment_date)  ),$model->idPayrollSet->number_of_hour,0,$model->net_salary,$model->taxe);
		
		
		$this->person_id =$model->idPayrollSet->person_id; 
		 
		$id_payroll_set = $model->id_payroll_set;
		 
		 $missing_hour1 ='';
		 $number_of_hour = $model->number_of_hour;
		
		$missing_hour1 = $model->missing_hour;
		
        
        
        
        
        
         $missing_hour =0;
                  $numberHour_=0;
                  $all='';

			    	$as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $id_payroll_set_teach=null;
                    $total_gross_salary=0;
                    $total_gross_salary_initial = 0;
                    $total_net_salary=0;
                    $total_deduction=0;
                    $total_taxe =0;
                    $iri_deduction =0;
                   
			  	  
			  	  $model_new->attributes=$_POST['Payroll'];
			  	  
			  	  
			  	    if(isset($_POST['Payroll']['taxe']))
			           {
                        $this->taxe = $_POST['Payroll']['taxe'];
                        
                        }
                        
                  		
			        // $this->payroll_month=Yii::app()->session['payroll_payroll_month'];
			        
					 $employee_teacher = Persons::model()->isEmployeeTeacher($this->person_id, $acad);	
							  
				    if(!$employee_teacher)//si moun nan pa alafwa anplwaye-pwofese 
                     { $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.old_new=1 AND ps.id='.$id_payroll_set.' AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
                 
                 $modelPayrollSettings = PayrollSettings::model()->findAll($criteria);

                      
	                  foreach($modelPayrollSettings as $amount)
	                   { 
                        $gross_salary_initial =0;
                   	    $gross_salary =0;
                   	    $deduction =0;
                   	    $net_salary=0;
                   	  
                         
	                     if(($amount!=null))
			               {  
			               	   $gross_salary =$amount->amount;
			               	   
			               	   $gross_salary_initial =$amount->amount;
			               	   
			               	   $missing_hour = $amount->number_of_hour;
			               	   
			               	   $numberHour_ = $amount->number_of_hour;
			               	   
			               	   if($amount->as ==0)
			               	     $all= 'e';
			               	   elseif($amount->as ==1)
			               	      $all= 't';
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {  
			              	$model_ = new PayrollSettings;
			              	
			             	 if(isset( $_POST['PayrollSettings']))
			             	  {  $model_->attributes = $_POST['PayrollSettings'];
				             	 //return working times in minutes
				             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
				                 
				                 $missing_hour = $missing_hour - $number_of_hour;
			             	  }
			             	 else
			             	    $number_of_hour = $missing_hour;
			                 //calculate $gross_salary by hour if it's a timely salary person 
						     /*if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						          
						        }
			                  */
			                  
			                  if(($numberHour_!=null)&&($numberHour_!=0))
						       {
						          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
						
						        } 
			                   
			                  
			               }
			           
			           // $total_gross_salary = $total_gross_salary + $gross_salary;
			            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
			          
			          	  if($this->taxe==1)
	                         {
	                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
                      	    
	                       	    $total_deduction = $total_deduction + $deduction;
	                       	    //$net_salary = $gross_salary - $deduction;
	                       	    $net_salary = $gross_salary_initial - $deduction;
	                       	 } 
	                      elseif($this->taxe==0)
	                        {
	                        	//$net_salary = $gross_salary;
	                        	$net_salary = $gross_salary_initial;
	                        	
	                          }  
                          
                          $total_net_salary = $total_net_salary + $net_salary;
                          
                          }
	                      
	                   //DEDUCTION TAXE IRI
                       if($this->taxe==1)
	                     {
	                       	//IRI
	                       	$iri_deduction = getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary_initial);
	                       	$total_deduction = $total_deduction + $iri_deduction;
	                       	$total_net_salary = $total_net_salary - $iri_deduction;
	                       } 
                        
                        $total_taxe = $total_taxe + $total_deduction;
                        
                        //DEDUCTION LOAN
                         $total_deduction = $total_deduction + $loan;
	                       	$total_net_salary = $total_net_salary - $loan;
	                       
                         
                       }
                    else //moun nan alafwa anplwaye-pwofese
                      {  $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.old_new=1 AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
                        $modelPayrollSettings = PayrollSettings::model()->findAll($criteria);
                      	 
                      foreach($modelPayrollSettings as $amount)
	                   {   
	                   	  $gross_salary_initial =0;
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
				               	   
				               	   $gross_salary_initial =$amount->amount;
				               	   
				               	   $missing_hour = $amount->number_of_hour;
				               	   
				               	   $numberHour_ = $amount->number_of_hour;
				               	   
				               	   if($amount->an_hour==1)
				                     $timely_salary = 1;
				                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			              	  $model_ =  new PayrollSettings;
			              	  
			             	 if(isset( $_POST['PayrollSettings']))
			             	  {  $model_->attributes = $_POST['PayrollSettings'];
				             	 //return working times in minutes
				             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
				                 
				                 $missing_hour = $missing_hour - $number_of_hour;
			             	  }
			             	 else
			             	    $number_of_hour = $missing_hour;
			                 //calculate $gross_salary by hour if it's a timely salary person 
						     /*if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						          
						        }
			                  */
			                  
			                  if(($numberHour_!=null)&&($numberHour_!=0))
						       {
						          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
						
						        } 
			                   
			             
				            }
			           
			            //$total_gross_salary = $total_gross_salary + $gross_salary;
			            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
			          
			          	  if($this->taxe==1)
	                         {
	                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
                      	    
	                       	    $total_deduction = $total_deduction + $deduction;
	                       	    //$net_salary = $gross_salary - $deduction;
	                       	    $net_salary = $gross_salary_initial - $deduction;
	                       	 } 
	                      elseif($this->taxe==0)
	                        {
	                        	//$net_salary = $gross_salary;
	                        	$net_salary = $gross_salary_initial;
	                        	
	                          }  
                          
                          $total_net_salary = $total_net_salary + $net_salary;
                          
                          
                          
                          }
                        elseif(($as_teach==0)&&($as==1))
                            {   $as_teach=1;
                                $all='t';
	                     
			                     if(($amount!=null))
					               {  
					               	   $id_payroll_set_teach = $amount->id;
					               	   $id_payroll_set = $amount->id;
					               	   $id_payroll_set2 = $amount->id;
					               	   
					               	   $gross_salary =$amount->amount;
					               	   
					               	   $gross_salary_initial =$amount->amount;
					               	   
					               	   $missing_hour = $amount->number_of_hour;
					               	   
					               	   $numberHour_ = $amount->number_of_hour;
					               	   
					               	   if($amount->an_hour==1)
					                     $timely_salary = 1;
					                 }
					           //get number of hour if it's a timely salary person
					            if($timely_salary == 1)
					              {
			                     	  $model_ =  new PayrollSettings;
			              	  
					             	  if(isset( $_POST['PayrollSettings']))
						             	  {  $model_->attributes = $_POST['PayrollSettings'];
							             	 //return working times in minutes
							             	 $number_of_hour = $model_->number_of_hour;   //$this->getHours($this->person_id,$acad);
							                 
							                 $missing_hour = $missing_hour - $number_of_hour;
						             	  }
						             	 else
						             	    $number_of_hour = $missing_hour;
					                 //calculate $gross_salary by hour if it's a timely salary person 
								    /* if(($number_of_hour!=null)&&($number_of_hour!=0))
								       {
								          $gross_salary = ($gross_salary * $number_of_hour);
								          
								        }
								       */ 
								     if(($numberHour_!=null)&&($numberHour_!=0))
								       {
								          $gross_salary_initial = ($gross_salary_initial * $numberHour_);
								
								        } 
					                   
					             
						            }
					           
					           // $total_gross_salary = $total_gross_salary + $gross_salary;
					            $total_gross_salary_initial = $total_gross_salary_initial + $gross_salary_initial;
					          
					          	  if($this->taxe==1)
			                         {
			                       	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary_initial); 
			                       	    $total_deduction = $total_deduction + $deduction;
			                       	    //$net_salary = $gross_salary - $deduction;
			                       	    $net_salary = $gross_salary_initial - $deduction;
			                       	 } 
			                      elseif($this->taxe==0)
			                        {
			                        	//$net_salary = $gross_salary;
			                        	$net_salary = $gross_salary_initial;
			                          }  
		                          
		                          $total_net_salary = $total_net_salary + $net_salary;
		                          
                          
                          
                               }
                       
                           }
                       
                       
                      
                      //DEDUCTION TAXE IRI
                       if($this->taxe==1)
	                     {
	                       //IRI
	                       	$iri_deduction = getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary_initial);
	                       	$total_deduction = $total_deduction + $iri_deduction;
	                       	$total_net_salary = $total_net_salary - $iri_deduction;
	                       }
                       
                       $total_taxe = $total_taxe + $total_deduction;
                       
                         //DEDUCTION LOAN
                         $total_deduction = $total_deduction + $loan;
	                       	$total_net_salary = $total_net_salary - $loan;
                      	
                      	} //fen alafwa anplwaye-pwofese
                     
                      if(($as_emp==1) && ($as_teach==1))
		                   {  //alafwa employee e teacher
		                   	   //save payroll la sou employee
		                   	   
		                   	   $all='e';
		                   	   
		                   	   //$id_payroll_set=$id_payroll_set_emp;
		                   	   //$id_payroll_set2 = $id_payroll_set_teach; 
		                   	   $number_of_hour=null;
		                   	   $missing_hour=null;
		                   	   
		                   	 }
		                   	 
		                   	 
		               if($model_new->cash_check=='')
		                  $model->setAttribute('cash_check', Yii::t('app','Cash') );
		               else
		                  $model->setAttribute('cash_check', $model_new->cash_check );
		                  
		                  $model->setAttribute('payroll_date',$model_new->payroll_date);
		                  $model->setAttribute('payment_date',$model_new->payment_date);
			              $model->setAttribute('payroll_month',$model_new->payroll_month);
			           
		           
			           //$model->setAttribute('id_payroll_set',$id_payroll_set);
			           //$model->setAttribute('id_payroll_set2',$id_payroll_set2);
			           $model->setAttribute('person_id',$this->person_id);
			           $model->setAttribute('number_of_hour',$number_of_hour);
			           $model->setAttribute('missing_hour',$missing_hour);
			           $model->setAttribute('taxe',$total_taxe);
			           $model->setAttribute('net_salary',$total_net_salary);
			           							 
						$model->setAttribute('date_updated',date('Y-m-d'));
					  	$model->setAttribute('updated_by',Yii::app()->user->name);

			            
						if($model->save())
						 {
						   $month_=$model->payroll_month;
				           $year_= getYear($model->payment_date);
				           
				             $model->unSetAttributes();
										$model= new Payroll;
													   
										 $total_taxe =0;
													   
										$temwen=true;
	
				           
						  }
						
		              	
		               
		               }
								   
		                         
								   
		                     
							   
				        }
				      else //message vous n'avez croche personne
						{
							$this->message_noOneSelected=true;
							
							}
							
					
					  if($temwen)
					    {
					    	 	
						     $this->redirect(array('index','month_'=>$month_,'year_'=>$year_,'all'=>$all,'di'=>1,'part'=>'pay','from'=>''));  //$this->redirect(array('view','id'=>$model->id,'part'=>'pay','from'=>''));
					   
						     	
					     }
					 else //message vous n'avez croche personne
				       {
					     $this->message_noOneSelected=true;
								
					    }
		
		               	 
               	 }			   
	//fen an gwoup ___________________________ 
			
				
     	  }
     	else  //$model_new->payment_date < $model_new->payroll_date
     	  $this->message_PaymentDate=true;
     }
  else  //$model_new->payroll_month != getMonth($model_new->payroll_date)
    $this->message_PayrollDate=true;
	 

				
					
		  }//fen _POST['update']
		  
		  
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}


public function missingTimes($person,$nbr_of_hour,$acad)
	{
		 $missing_hour1 =0;
		          $model_ = new PayrollSettings;
                   $amount = PayrollSettings::model()->find('old_new=1 AND person_id=:Id AND academic_year=:acad order by date_created DESC',array(':Id'=>$person,':acad'=>$acad));
                     if(isset($amount)&&($amount!=null))
		               {  
		               	   $id_payroll_set = $amount->id;
		               	   
		               	   $gross_salary =$amount->amount;
		               	   
		               	   if($amount->an_hour==1)
		                     {  
		                     	 $timely_salary = 1;
		                     	 //return working times in minutes
		             	         $base_number_of_hour = $this->getHours($person,$acad);
		             	         
		                         $missing_hour1 = $base_number_of_hour - $nbr_of_hour;
		                     }
		                 }

              if($missing_hour1>0)
                {
                	return ($this->setMissingTimeForUpdate($missing_hour1));
                	
                }
               else
                  return null;


		
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		/*$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
				    			
		*/
		
		$acad=Yii::app()->session['currentId_academic_year'];
		$model2Delete = new Payroll;
		
		try {
   			  $loan=0;
			  $gross_salary =0;

			  $model2Delete = $this->loadModel($id);
   			   
   			   $person = $model2Delete->idPayrollSet->person_id;
   			   $month = $model2Delete->payroll_month;
			   $number_hour =$model2Delete->idPayrollSet->number_of_hour;
			   $net_salary=$model2Delete->net_salary;
			   $taxe=$model2Delete->taxe;
			   $year = getYear($model2Delete->payment_date);
			   $gross_salary =$model2Delete->getGrossSalaryIndex_value($person,$month,$year);
 			   
   			   //$loan = Payroll::model()->getLoanDeduction($model->idPayrollSet->person_id,$model->getGrossSalary($model2Delete->idPayrollSet->person_id),$model2Delete->idPayrollSet->number_of_hour,$model2Delete->missing_hour,$model2Delete->net_salary,$model2Delete->taxe);
		         $loan = Payroll::model()->getLoanDeduction($person,$gross_salary,$number_hour,0,$net_salary,$taxe);
   			   if($loan==0)
   			    {
   			       $model2Delete->delete();
   			       
   			    }
   			  else
   			    {
   			    	$modelLoan = new LoanOfMoney;
   			    	$solde_ = 0;
   			    	$remaining_month = 0;
   			    	$paid = 0;
   			    	
   			    	//load appropriate loan
   			    	$modelLoan = LoanOfMoney::model()->findByAttributes(array('person_id'=>$person,'payroll_month'=>$month, 'academic_year'=>$acad));
   			    	
					if($modelLoan!=null)
					{
   			    	$solde_ = $modelLoan->solde;
   			    	$remaining_month = $modelLoan->remaining_month_number;
   			    	$paid = $modelLoan->paid;
   			    	
   			    	if($paid==1)
   			    	  {
   			    	  	$paid=0;
   			    	  	}
   			    	
   			    	 $remaining_month = $remaining_month + 1;
   			    	 
   			    	 $solde_ = $solde_ + $loan;
   			    	 
   			    	 $modelLoan->setAttribute('solde',$solde_);
					 $modelLoan->setAttribute('remaining_month_number', $remaining_month);
					 $modelLoan->setAttribute('paid', $paid);
   			    	
   			    	 if($modelLoan->save())
   			    	   $model2Delete->delete();
					
					}
   			    	
   			      }
   			    	
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			        //header("HTTP/1.0 400 Relation Restriction");
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}



	}


	
//************************  loadRecettesItems ******************************/
	public function loadDepensesItems()
	{     $code= array();
		   
		   $code[1]= Yii::t('app','Payroll');
		   $code[2]= Yii::t('app','Charge');
		           
		    		   
		return $code;
         
	}


	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		
		if(isset($_POST['Payroll']['depensesItems']))
		    $this->depensesItems1 = $_POST['Payroll']['depensesItems'];
		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}

		if($this->depensesItems1==1)
      {         
             $this->status_ = 1;
               
                if(!isset($_GET['month_']))
			       {
			       	   $sql__ = 'SELECT DISTINCT payment_date, payroll_date FROM payroll ORDER BY id DESC';
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						     { $current_month = getMonth($r['payment_date']);
						        $current_date = $r['payroll_date'];
						          break;
						     }
						  }
						else
						  { $current_month = getMonth(date('Y-m-d'));
						     $current_date = date('Y-m-d');
						   }
			       	  // $month_display=$current_month;
			        }
			     else 
			       {  $current_month = $_GET['month_'];
			       	  //$month_display= $_GET['month_'];
			       	  $current_date = date('Y-m-d');
			        }
	           
	            $model=new Payroll('searchByMonth('.$current_month.','.$current_date.','.$acad.')');
			        $model->unsetAttributes();  // clear any default values
			
				
				if(isset($_GET['Payroll']))
					$model->attributes=$_GET['Payroll'];
		
		
		                // Here to export to CSV 
				if($this->isExportRequest()){
					$this->exportCSV(array(Yii::t('app','Payroll')), null,false);
		                            $this->exportCSV($model->searchByMonth($current_month,$current_date,$acad), array(
		                                
						'PaymentDate',
						'first_name." ".last_name',
						//'person.first_name',
						//'GrossSalaryInd(person_id)',
						'Taxe',
						//'LoanDeduction(person_id,amount,number_of_hour,net_salary,taxe)',
						'NetSalary',
						'cash_check',

		                )); 
				}
		

           }
       elseif($this->depensesItems1==2)
	         {
	         	 $this->status_ = 2;
	         	 $this->redirect(array('/billings/chargePaid/index/di/2/from/b'));
	
	         	}
      

		$this->render('index',array(
			'model'=>$model,
		));
		
	}


public function actionReceipt()
	{
		$model=new Payroll;
		
		$this->part = 'payrollrec';
		$acad=Yii::app()->session['currentId_academic_year'];
		$acad_name=Yii::app()->session['currentName_academic_year'];
		$currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 

				         
		 $new_payroll_date ='';
		 
		$this->payrollReceipt_available =false;
		$this->messagePayrollReceipt_available=true;
		$this->messageNoPayrollDone = false;
		
		 if((isset($_GET['id']))&&($_GET['id']!=''))
		   {   
		        $modelPayroll2Print=$this->loadModel($_GET['id']);
		
		          $this->person_id = $modelPayroll2Print->idPayrollSet->person_id;
		          $this->payroll_month = $modelPayroll2Print->payroll_month;
		          $this->payroll_date = $modelPayroll2Print->payroll_date;
		          
		          
		          $model->setAttribute('id_payroll_set',$modelPayroll2Print->id_payroll_set);
		          $model->setAttribute('id_payroll_set2',$modelPayroll2Print->id_payroll_set2);
                  $model->setAttribute('person_id',$this->person_id);
		           $model->setAttribute('payroll_month',$this->payroll_month );
		            $model->setAttribute('payroll_date',$this->payroll_date);
		            
		            $this->payrollReceipt_available =true;
		
		     		          
		if(isset($_POST['viewPDF'])) //to create PDF file
			  {
			         				         								//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                                                                                //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
                                                                                                //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
                                                                                                //Extract Phone Number
                                 $school_phone_number = infoGeneralConfig('school_phone_number');
                                                               
                                                                                             
				   								
										 
								// create new PDF document
								$pdf = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app',"Payroll receipt"));
								$pdf->SetSubject(Yii::t('app',"Payroll receipt"));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								
								//$pdf->SetHeaderData(PDF_HEADER_LOGO_REPORTCARD, PDF_HEADER_LOGO_REPORTCARD_WIDTH, "", ""); //CNR
								$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								//$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);      //CNR
								$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, 5); // PDF_MARGIN_BOTTOM

								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 12, '', true);
								
	

                             
                             	 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();
$general_average=0;
								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

					
					
							$html = <<<EOD
 <style>
	
	
.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		//color: #1e5c8c;
        font-size: 16px;
		width:100%;
		text-align: center;
		
		 
	   }
	
	
.info{   font-size:12px;
       text-align: center;
      background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
	 }
		
.content{   
       font-size:12px;
       text-indent: 10px;
      //background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
		
		
	 }

.taxe_line{   
           font-size:11px;
           text-indent: 60px;
           		
	 }


.tb_taxe_line{
	        width:90%;
	       text-indent: -10px;
	       
	       background-color: #FCFCFC; //#E5F1F4; 
	       color: #000; //#1E65A4; 
	       -webkit-border-top-left-radius: 5px;
	       -webkit-border-top-right-radius: 5px;
	       -moz-border-radius-topleft: 5px;
	       -moz-border-radius-topright: 5px;
	       border-top-left-radius: 5px;
	       border-top-right-radius: 5px;
   }


.td_taxe{   
           width:9%;
           //border-bottom: 1px solid blue;		
	 }

.td_libelle_taxe{   
           width:50%;
           text-align: center;
           //border-bottom: 1px solid red;		
	 }


.siyati {
	    width:50%;
	    text-indent: 310px;
	    font-weight: bold;
	    font-style: italic;
	
	}



   
div > .subject {
		width:30%;
		 text-indent: 10px;
		 font-weight: normal; //bold; 
		
	}
	
.subject_single{
		    color:#000; 
			font-size:10px; 
			height:20px;
			font-weight:bold;
			text-indent: 0px; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;	
	}	
		
	
	
</style>
                                       
										
EOD;
	 
				   						 
		//$html .='<span class="title" >'.strtoupper(Yii::t("app","Payroll receipt")).'</span>';
										
	 
     	$id_payroll_set ='';
     	$id_payroll_set2 ='';
     	$payment_date ='';
     	$net_salary = 0;
     	$taxe = 0;
     	$total_deduction = 0;
     	$number_of_hour = null;
     	$missing_hour = 0;
     	$gross_for_hour = 0;
     	
     	$month_ = getLongMonth($this->payroll_month);
     	$employee = $this->getPerson($this->person_id);
     	$title = Persons::model()->getTitles($this->person_id,$acad);
     	$working_dep = Persons::model()->getWorkingDepartment($this->person_id,$acad);
     	$gross_salary= Payroll::model()->getGrossSalaryIndex_value($this->person_id,$this->payroll_month,getYear($this->payroll_date));
    /* 	$currency_result = Fees::model()->getCurrency($acad);
     	foreach($currency_result as $result)
     	 {
     	 	$currency = $result["devise_name"].'('.$result["devise_symbol"].')';
     	 	break;
     	 	 }
     */	
     	//cheche payroll la
     	 $modelPayroll = Payroll::model()->searchByMonthPersonId($this->payroll_month, $this->payroll_date, $this->person_id, $acad);
     	 $modelPayroll = $modelPayroll->getData();
     	 if($modelPayroll!=null)
     	   {
     	   	    foreach($modelPayroll as $payroll_)
     	   	      {
     	   	      	     $payment_date = $payroll_->payment_date;
     	   	      	     $net_salary = $payroll_->net_salary;
     	   	      	     $id_payroll_set = $payroll_->id_payroll_set;
     	   	      	     $id_payroll_set2 = $payroll_->id_payroll_set2;
     	   	      	     $taxe = $payroll_->taxe;
     	   	      	     $missing_hour = $payroll_->missing_hour;
     	   	      	     
     	   	      	}
     	   	      	
     	   	 }
	        
	     if($missing_hour!=0)
	       {
	       	   $number_of_hour = PayrollSettings::model()->getSimpleNumberHourValue($this->person_id);
	       	   $gross_for_hour = $gross_salary;
	       	   
	       	 }
	       	 
	       	     	   	
  
 $html .= ' <div >
         <label >  ';
   
     
             
           $html .= '<div style="float:left; padding:10px; border:1px solid #EDF1F6;  ">
                  <div class="info"> <b>'.strtoupper(Yii::t('app','Payroll receipt')).'</b></div> '; 
			$html .= '<div class="content" >'.Yii::t('app','Payroll month').': '.$month_.' <br/><br/> '.Yii::t('app','Payment date').': '.ChangeDateFormat($payment_date).'
			       <br/><br/> '.Yii::t('app','Name: ').$employee;//.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app','Title').': '.$title.'
			   $html .= '   <!-- <div style="float:left;">'.Yii::t('app','Code').': C / </div>  -->
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app','Working department').': '.$working_dep.' 
			           
			      
			          
			         <br/><b>'.Yii::t('app','Monthly gross salary').'</b>: '.$currency_symbol.' '.numberAccountingFormat($gross_salary).'   ';
			         
			         //gad si yo pran taxe pou payroll sa
			         $employee_teacher = Persons::model()->isEmployeeTeacher($this->person_id, $acad);	
					
					 $deduct_iri=false; 
										  
					  if(!$employee_teacher)//si moun nan pa alafwa anplwaye-pwofese 
			           { 
			           	   
			           	   
			           	   $html .= ' <br/><div  class="taxe_line" ><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary).'): 
			         				 <br/> <table class="tb_taxe_line" >
									   <tr>
									   
									  <td class="td_libelle_taxe" style="text-align:center; "> '.Yii::t('app',' Taxe ').' </td>
									       <td class="td_taxe" style="text-align:center; ">'.Yii::t('app','%').' </td>
									       <td style="text-align:center; "> '.Yii::t('app','Worth value').'</td>
									       
									       
									    </tr>';

 
			           	  if($taxe != 0)  
			           	    { 
			           	    				           	    	
			           	    	
			           	    	$sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_payroll_set;
															
							  $command__ = Yii::app()->db->createCommand($sql__);
							  $result__ = $command__->queryAll(); 
																		       	   
								if($result__!=null) 
								 { foreach($result__ as $r)
								     { 
								     	  $deduction = 0;
								     	 $tx_des='';
											     	   $tx_val='';
											     	   
											     	 $sql_tx_des = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																				
													  $command_tx_des = Yii::app()->db->createCommand($sql_tx_des);
													  $result_tx_des = $command_tx_des->queryAll(); 
																								       	   
														foreach($result_tx_des as $tx_desc)
														     {   $tx_des= $tx_desc['taxe_description'];
														         $tx_val= $tx_desc['taxe_value'];
														       }
											     	 
											     	 
											 if( ($tx_des!='IRI') ) //c pa iri,
								     	       {
								     	      	    $deduction = ( ($gross_salary * $tx_val)/100);
											          $total_deduction = $total_deduction + $deduction;
								     	      	      $html .= '<tr>
									                  <td class="td_libelle_taxe" style="text-align:center;"> '.$tx_des.'  </td>
															       <td class="td_taxe" style="text-align:center; ">'.$tx_val.' </td>
															       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($deduction).'</td>
															 </tr>';

											         
											         
											         
								     	      	}
								     	    elseif($tx_des=='IRI')
								     	       $deduct_iri=true; 
			 						     	      	
										  
										  }
											  
									 }
				              
			           	      }  
			           	          
				                  
				             if($deduct_iri)
		                           {$iri = 0; 
		                           	$iri = getIriDeduction($id_payroll_set,$id_payroll_set2,$gross_salary);
		                           	  $total_deduction = $total_deduction + $iri;
		                           	 $html .= '   
									  <tr> 
									   <td class="td_libelle_taxe" style="text-align:center; "> '.Yii::t('app','IRI ').' </td>
									       <td class="td_taxe" style="text-align:center; ">&nbsp;&nbsp; </td>
									       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($iri).'</td>
									       
									       
									    </tr>';
		                              }     
				              
				                 
				               $html .= '  </table> 
						           </div>';  
						            
			             }
			          elseif($employee_teacher)//si moun nan alafwa anplwaye-pwofese 
			           {  
			           	      $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.id IN('.$id_payroll_set.','.$id_payroll_set2.')'));
			           	      
			                        $modelPayrollSettings = PayrollSettings::model()->findAll($criteria);
			                        
			                        $as_emp=0;
			                        $as_teach=0;
			                        $payroll_set1 = '';
			                        $deduct_iri=false;
			                      	 
			                      foreach($modelPayrollSettings as $amount)
				                   {   
				                   	  $gross_salary1 =0;
				                   	  $deduction1 =0;
				                   	  $as = $amount->as;
				                   	  $gross_for_hour = 0;
				                   	  
				                     //fosel pran yon ps.as=0 epi yon ps.as=1
				                       if(($as_emp==0)&&($as==0))
				                        { $as_emp=1;
				                          
					                     if(($amount!=null))
							               {  
							               	   $id_payroll_set1 = $amount->id;
							               	   
							               	   $gross_salary1 =$amount->amount;
							               	   
							               	   $number_of_hour = $amount->number_of_hour;
							               	   
							               	   
							               	       $gross_for_hour = $gross_salary1;
							               	       
							                 }
						           
						                
			           	         $html .= '<br/><div  class="taxe_line" ><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary1).' '.strtolower(Yii::t('app','As').' '.Yii::t('app','Employee')).'): 
			         				<br/> <table class="tb_taxe_line" >
									   <tr>
									   
									  <td class="td_libelle_taxe" style="text-align:center; ">'.Yii::t('app',' Taxe ').' </td>
									       <td class="td_taxe" style="text-align:center; ">'.Yii::t('app','%').' </td>
									       <td style="text-align:center; ">'.Yii::t('app','Worth value').'</td>
									       
									       
									    </tr>';

 
						           	  if($taxe != 0)  
						           	    { 
						           	    				           	    	
						           	    	
						           	    	$sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_payroll_set1;
																		
										  $command__ = Yii::app()->db->createCommand($sql__);
										  $result__ = $command__->queryAll(); 
																					       	   
											if($result__!=null) 
											 { foreach($result__ as $r)
											     { 
											     	  $deduction1 = 0;
											     	 $tx_des='';
											     	   $tx_val='';
											     	   
											     	 $sql_tx_des = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																				
													  $command_tx_des = Yii::app()->db->createCommand($sql_tx_des);
													  $result_tx_des = $command_tx_des->queryAll(); 
																								       	   
														foreach($result_tx_des as $tx_desc)
														     {   $tx_des= $tx_desc['taxe_description'];
														         $tx_val= $tx_desc['taxe_value'];
														       }
											     	 
											     	 
											           if( ($tx_des!='IRI') ) //c pa iri,
											     	      {
											     	      	  $deduction1 = ( ($gross_salary1 * $tx_val)/100);
														          $total_deduction = $total_deduction + $deduction1;
											     	      	      $html .= '<tr>
												      <td class="td_libelle_taxe" style="text-align:center;">'.$tx_des.'  </td>
																		       <td class="td_taxe" style="text-align:center; ">'.$tx_val.' </td>
																		       <td style="text-align:center; ">'.$currency_symbol.' '.numberAccountingFormat($deduction1).'</td>
																		 </tr>';
			
														         
														         
														         
											     	      	}
											     	    elseif($tx_des=='IRI')
											     	       $deduct_iri=true; 
						 						     	      	
													  
													  }
														  
												 }
								              
							           	      } 
							              
							             $html .= '  </table> 
						                    </div>';
				                          
				                          }
				                        elseif(($as_teach==0)&&($as==1))
				                           {   $as_teach=1;
				                          
						                     if(($amount!=null))
								               {  
								               	   $id_payroll_set2 = $amount->id;
								               	   
								               	   $gross_salary1 =$amount->amount;
								               	   
								               	   $number_of_hour = $amount->number_of_hour;
								               	   
								               	   if($amount->an_hour==1)
								                     {
								                         $gross_salary1 = $gross_salary1 * $number_of_hour;
								                        }
								               	   
								               	   $gross_for_hour = $gross_salary1;
								               	   
								                 }
							           
						                
					           	         $html .= '<div  class="taxe_line" ><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary1).' '.strtolower(Yii::t('app','As').' '.Yii::t('app','Teacher')).'): 
					         				<br/> <table class="tb_taxe_line" >
											   <tr>
											   
									<td class="td_libelle_taxe" style="text-align:center; ">'.Yii::t('app',' Taxe ').'</td>
											       <td class="td_taxe" style="text-align:center; ">'.Yii::t('app','%').'</td>
											       <td style="text-align:center; ">'.Yii::t('app','Worth value').'</td>
											       
											       
											    </tr>';
		
		 
								           	  if($taxe != 0)  
								           	    { 
								           	    				           	    	
								           	    	
								           	    	$sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_payroll_set2;
																				
												  $command__ = Yii::app()->db->createCommand($sql__);
												  $result__ = $command__->queryAll(); 
																							       	   
													if($result__!=null) 
													 { foreach($result__ as $r)
													     { 
													     	  $deduction1 = 0;
													     	 $tx_des='';
													     	   $tx_val='';
													     	   
													     	 $sql_tx_des = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																						
															  $command_tx_des = Yii::app()->db->createCommand($sql_tx_des);
															  $result_tx_des = $command_tx_des->queryAll(); 
																										       	   
																foreach($result_tx_des as $tx_desc)
																     {   $tx_des= $tx_desc['taxe_description'];
																         $tx_val= $tx_desc['taxe_value'];
																       }
													     	 
													     	 
													     	 if( ($tx_des!='IRI') ) //c pa iri,
													     	      {
													     	      	    $deduction1 = ( ($gross_salary1 * $tx_val)/100);
																          $total_deduction = $total_deduction + $deduction1;
													     	      	      $html .= '<tr>
										     <td class="td_libelle_taxe" style="text-align:center;">'.$tx_des.'</td>
																				       <td class="td_taxe" style="text-align:center; ">'.$tx_val.'</td>
																				       <td style="text-align:center; ">'.$currency_symbol.' '.numberAccountingFormat($deduction1).'</td>
																				 </tr>';
					
																         
																         
																         
													     	      	}
													     	    elseif($tx_des=='IRI')
													     	       $deduct_iri=true; 
								 						     	      	
															  
															  }
																  
														 }
									              
								           	      } 
								              
								           
				                     $html .= '  </table> 
						                    </div>';				                          
				                             
				                             }
			                       
			                   
			                      }//end foreach
			                       
			                      	
			                   
			                     if($deduct_iri)
		                           {
		                           	   $iri = 0; 
		                              	$iri = getIriDeduction($id_payroll_set,$id_payroll_set2,$gross_salary);
		                           	  $total_deduction = $total_deduction + $iri;
		                           	  
		                         $html .= '<div  class="taxe_line" ><b>'.Yii::t('app','IRI').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary).' '.Yii::t('app','Gross salary').'): 
					         				<br/> <table class="tb_taxe_line" >
											   <tr>
											   
									<td class="td_libelle_taxe" style="text-align:center; ">'.Yii::t('app',' Taxe ').'</td>
											       <td class="td_taxe" style="text-align:center; ">&nbsp;&nbsp;</td>
											       <td style="text-align:center; ">'.Yii::t('app','Worth value').'</td>
											       
											       
											    </tr>  
											  <tr> 
											   <td class="td_libelle_taxe" >'.Yii::t('app','IRI ').'</td>
											       <td class="td_taxe" style="text-align:center; ">&nbsp;&nbsp;</td>
											       <td >'.$currency_symbol.' '.numberAccountingFormat($iri).'</td>
											       
											       
											    </tr>
											     </table> 
						                 </div>';
		                              }     
				              


			                  }
			                   
		                 $html .= '     <div class="taxe_line" ><b>'.Yii::t('app','Total charge').'</b>: '.$currency_symbol.' '.numberAccountingFormat($total_deduction).' </div>  ';             
							         
			                 //tcheke loan
			                 $loan = 0;
			               $loan = Payroll::model()->getLoanDeduction($this->person_id,$gross_salary,$number_of_hour,$missing_hour,$net_salary,$taxe);
			                   $total_deduction = $total_deduction + $loan;
			      $html .= '<br/><div class="taxe_line" ><b>'.Yii::t('app','Loan(deduction)').'</b>: '.$currency_symbol.' '.numberAccountingFormat($loan).'</div>';
			          
		/* if($missing_hour!=0)
	       {
	       	   $number_of_hour = PayrollSettings::model()->getSimpleNumberHourValue($this->person_id);
	       	   $gross_salary_deduction = ($gross_for_hour * $missing_hour) / $number_of_hour;
	       	   
	       	   $total_deduction = $total_deduction + $gross_salary_deduction;
	       	   
	       	     $html .= '     <br/><div class="taxe_line" > '.Yii::t('app','Deduction').' ('.Yii::t('app','Missing hour').': '.$missing_hour.') : '.$gross_salary_deduction.' </div>';
	       	   
	       	 }
	      */          
	          
			      $html .= '    <br/> <b>'.Yii::t('app','Total deduction').'</b>: '.$currency_symbol.' '.numberAccountingFormat($total_deduction).'   ';
			       
			       
			         
			      $html .= '   <br/><br/> <b>'.Yii::t('app','Monthly net salary').'</b>: '.$currency_symbol.' '.numberAccountingFormat($net_salary).' 
			         
			       <br/>
			      <div class="siyati"> &nbsp;&nbsp;&nbsp;'.Yii::t('app','Authorized signature').'</div>
			      
			      </div>
		<div style="float:right; text-align: right; font-size: 6px; margin-bottom:-8px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>	      
			     </div>';
										
	   
$html .= '  </label>
    </div>  ';     
          
    		    
            



    
                                            $pdf->writeHTML($html, true, false, true, false, '');
		                                    // Print text using writeHTMLCell()
                                          //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
							 
								  $file_name = Yii::t('app','Payroll receipt').'_'.$employee.'_'.$month_.'_'.$acad_name;
								$pdf->Output($file_name, 'D');
	                  	          /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option 
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/


			     }
			     
			     
		    }
		
		      if($this->payroll_month =='')
			          {  
			          	$month_payroll=Payroll::model()->getMonthPastPayroll();
			  
			  			if($month_payroll!=null)
						 {
							 foreach($month_payroll as $p)
						       {	 
								     	//$mwa[$p['payroll_month']] = Payroll::model()->getSelectedLongMonth($p['payroll_month']);
							            $this->payroll_month = $p['payroll_month'];
							            break; 
								} 
								
						      if($this->payroll_date=='')
								{  $this->payroll_date = $this->getLastPastPayrollDate($this->payroll_month);
									if(($this->payroll_date!='0000-00-00')&&($this->payroll_month!=0))
						              {  $this->payrollReceipt_available =true;
						                 $this->messagePayrollReceipt_available = true;
						                }
								 }
								 
						  }
				     
			          }
			     
			     
		
	if(isset($_POST['Payroll']))
	   {
	    
		  
		                if(isset($_POST['Payroll']['payroll_date']))
                    $new_payroll_date =  $_POST['Payroll']['payroll_date'];
               
                   
                                   
                 if(isset($_POST['Payroll']['person_id']))
		              {  
		              	$this->person_id = $_POST['Payroll']['person_id'];
					     Yii::app()->session['payroll_person_id']=$this->person_id;
					     
					      
					      $Pay_set=PayrollSettings::model()->find('ps.old_new=1 AND person_id=:Id AND academic_year=:acad order by date_created DESC',array(':Id'=>$this->person_id,':acad'=>$acad));
       
					         if(isset($Pay_set)&&($Pay_set!=null))
							  { $model->id_payroll_set = $Pay_set->id;
							    Yii::app()->session['payroll_id_payroll_set'] = $Pay_set->id; 
							  
							     if($this->payroll_month =='')
							      {  $this->payroll_month = $this->getLastPastLongMonthValueByPerson($model->id_payroll_set);
							        Yii::app()->session['payroll_payroll_month'] = $this->payroll_month;
							        
							        
							       }
							       
							       if($this->payroll_month =='')
							          $this->messagePayrollReceipt_available = false;
							  	}

		              }
		            else
		              {
		            	 $this->person_id=Yii::app()->session['payroll_person_id'];
		            	     if($this->person_id =='')
		            	       {
		            	       	   $criteria = new CDbCriteria(array('group'=>'p.id','alias'=>'p', 'order'=>'last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND (p.id IN(SELECT person_id FROM payroll_settings ps INNER JOIN payroll pl ON(pl.id_payroll_set=ps.id) WHERE (ps.academic_year='.$acad.') )) '));
                    	            
                    	            $data=Persons::model()->findAll($criteria);
                    	            if($data==null)
                    	               $this->messageNoPayrollDone = true;
                    	
		            	       	 }
		            	
		            	}
		         
		         
		           if(isset($_POST['Payroll']['payroll_month']))
		              {  
		              	$this->payroll_month = $_POST['Payroll']['payroll_month'];
		              	
		             	
		              	  if($this->payroll_month != Yii::app()->session['payroll_new_payroll_month'] )
		              	    {  
		              	    	$this->payroll_date = $this->getLastPastPayrollDate($this->payroll_month);
		              	    	  Yii::app()->session['payroll_new_payroll_month'] = $this->payroll_month;
		              		  
		              		  }
					       else
					          $this->payroll_date=$new_payroll_date;
					     
					     
					     //$model->id_payroll_set = Yii::app()->session['payroll_id_payroll_set'];
					     
					     
					     
		              }
		            else
		              {
		            	 $this->payroll_month=Yii::app()->session['payroll_payroll_month'];
		            	 
		            	
		            	}
		            	
	          
	           
		          
		          
		          
			          if($this->payroll_date=='')
						{  $this->payroll_date = $this->getLastPastPayrollDate($this->payroll_month);
							
						 }
							 
			       // if(isset($_POST['create'])) //to view it
					//	  {
						    if(($this->payroll_date!='')&&($this->payroll_month!=''))
						       { 
						      	  if(($this->payroll_date!='0000-00-00')&&($this->payroll_month!=0))
						            {  $this->payrollReceipt_available =true;
						               $this->messagePayrollReceipt_available = true;
						            }
						        }
						    
						   // }		
				
				
						
	
	                  
	                  
		          
		          
		          
		if(isset($_POST['viewPDF'])) //to create PDF file
			  {
			      $this->message_noOneSelected = false;   	
			         								//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                                                                                //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
                                                                                                //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
                                                                                                //Extract Phone Number
                                 $school_phone_number = infoGeneralConfig('school_phone_number');
                                 
                                                               
                                                                                             
				 if(isset($_POST['chk'])) {						
										 
								// create new PDF document
								$pdf = new tcpdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

								// set document information
								$pdf->SetCreator(PDF_CREATOR);
								                                      
				   								
										 
								$pdf->SetAuthor($school_name);
								$pdf->SetTitle(Yii::t('app',"Payroll receipt"));
								$pdf->SetSubject(Yii::t('app',"Payroll receipt"));
							
								// set default header data
								//$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
								
								//$pdf->SetHeaderData(PDF_HEADER_LOGO_REPORTCARD, PDF_HEADER_LOGO_REPORTCARD_WIDTH, "", ""); //CNR
								$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, $school_name, "$school_address \nTel: $school_phone_number\nE-mail: $school_email_address\n \n\n");
								//$pdf->setFooterData(array(0,64,0), array(0,64,128));

								// set header and footer fonts
								$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
								//$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

								// set default monospaced font
								$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

								// set margins
								//$pdf->SetMargins(PDF_MARGIN_LEFT, 24, PDF_MARGIN_RIGHT);      //CNR
								$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
								$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
								//$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

								// set auto page breaks
								$pdf->SetAutoPageBreak(TRUE, 5); // PDF_MARGIN_BOTTOM

								// set image scale factor
								$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

								// set some language-dependent strings (optional)
								if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
									require_once(dirname(__FILE__).'/lang/eng.php');
									$pdf->setLanguageArray($l);
								}

								// ---------------------------------------------------------

								// set default font subsetting mode
								$pdf->setFontSubsetting(true);

								// Set font
								// dejavusans is a UTF-8 Unicode font, if you only need to
								// print standard ASCII chars, you can use core fonts like
								// helvetica or times to reduce file size.
								$pdf->SetFont('helvetica', '', 12, '', true);
								

		

                            foreach($_POST['chk'] as $id_payroll) 
                               {
                              	   $modelPayrollLa=$this->loadModel($id_payroll);
		
				                   $this->person_id =$modelPayrollLa->idPayrollSet->person_id; 
		 
		                            $id_payroll_set = $modelPayrollLa->id_payroll_set;
		                            $id_payroll_set2 = $modelPayrollLa->id_payroll_set2;
		         
        


                             	 // Add a page
								// This method has several options, check the source code documentation for more information.
								$pdf->AddPage();
$general_average=0;
								// set text shadow effect
								//$pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

					
					
							$html = <<<EOD
 <style>
	
	
.title {
		font-weight:bold;
	font-family:Helvetica, sans-serif;
		//color: #1e5c8c;
        font-size: 16px;
		width:100%;
		text-align: center;
		
		 
	   }
	
	
.info{   font-size:12px;
       text-align: center;
      background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
	 }
		
.content{   
       font-size:12px;
       text-indent: 10px;
      //background-color: #F5F6F7;
		border-bottom: 1px solid #ECEDF2;
		
		
	 }

.taxe_line{   
           font-size:11px;
           text-indent: 60px;
           		
	 }


.tb_taxe_line{
	        width:90%;
	       text-indent: -10px;
	       
	       background-color: #FCFCFC; //#E5F1F4; 
	       color: #000; //#1E65A4; 
	       -webkit-border-top-left-radius: 5px;
	       -webkit-border-top-right-radius: 5px;
	       -moz-border-radius-topleft: 5px;
	       -moz-border-radius-topright: 5px;
	       border-top-left-radius: 5px;
	       border-top-right-radius: 5px;
   }


.td_taxe{   
           width:9%;
           //border-bottom: 1px solid blue;		
	 }

.td_libelle_taxe{   
           width:50%;
           text-align: center;
           //border-bottom: 1px solid red;		
	 }

.siyati {
	    width:50%;
	    text-indent: 310px;
	    font-weight: bold;
	    font-style: italic;
	
	}


	   
div > .subject {
		width:30%;
		 text-indent: 10px;
		 font-weight: normal; //bold; 
		
	}
	
.subject_single{
		    color:#000; 
			font-size:10px; 
			height:20px;
			font-weight:bold;
			text-indent: 0px; 
			text-align:left;
			border-bottom: 1px solid #ecedf4;	
	}	
		
	
	
</style>
                                       
										
EOD;
	 
				   						 
		//$html .='<span class="title" >'.strtoupper(Yii::t("app","Payroll receipt")).'</span>';
										
	 
     	$id_payroll_set ='';
     	$id_payroll_set2 ='';
     	$payment_date ='';
     	$net_salary = 0;
     	$taxe = 0;
     	$total_deduction = 0;
     	$number_of_hour = null;
     	$missing_hour = 0;
     	$gross_for_hour = 0;
     	
     	$month_ = getLongMonth($this->payroll_month);
     	$employee = $this->getPerson($this->person_id);
     	$title = Persons::model()->getTitles($this->person_id,$acad);
     	$working_dep = Persons::model()->getWorkingDepartment($this->person_id,$acad);
     	$gross_salary= Payroll::model()->getGrossSalaryIndex_value($this->person_id,$this->payroll_month,getYear($this->payroll_date));
     /*	$currency_result = Fees::model()->getCurrency($acad);
     	foreach($currency_result as $result)
     	 {
     	 	$currency = $result["devise_name"].'('.$result["devise_symbol"].')';
     	 	break;
     	 	 }
     */	
     	//cheche payroll la
     	 $modelPayroll = Payroll::model()->searchByMonthPersonId($this->payroll_month, $this->payroll_date, $this->person_id, $acad);
     	 $modelPayroll = $modelPayroll->getData();
     	 if($modelPayroll!=null)
     	   {
     	   	    foreach($modelPayroll as $payroll_)
     	   	      {
     	   	      	     $payment_date = $payroll_->payment_date;
     	   	      	     $net_salary = $payroll_->net_salary;
     	   	      	     $id_payroll_set = $payroll_->id_payroll_set;
     	   	      	     $id_payroll_set2 = $payroll_->id_payroll_set2;
     	   	      	     $taxe = $payroll_->taxe;
     	   	      	     $missing_hour = $payroll_->missing_hour;
     	   	      	     
     	   	      	}
     	   	      	
     	   	 }
	        
	     if($missing_hour!=0)
	       {
	       	   $number_of_hour = PayrollSettings::model()->getSimpleNumberHourValue($this->person_id);
	       	   $gross_for_hour = $gross_salary;
	       	   
	       	 }
	       	 
	       	     	   	
  
 $html .= ' <div >
         <label >  ';
   
     
             
           $html .= '<div style="float:left; padding:10px; border:1px solid #EDF1F6;  ">
                  <div class="info"> <b>'.strtoupper(Yii::t('app','Payroll receipt')).'</b></div> '; 
			$html .= '<div class="content" >'.Yii::t('app','Payroll month').': '.$month_.' <br/><br/> '.Yii::t('app','Payment date').': '.ChangeDateFormat($payment_date).'
			       <br/><br/> '.Yii::t('app','Name: ').$employee;//.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app','Title').': '.$title.'
			   $html .= '   <!-- <div style="float:left;">'.Yii::t('app','Code').': C / </div>  -->
			            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.Yii::t('app','Working department').': '.$working_dep.' 
			           
			      
			       
			         <br/><b>'.Yii::t('app','Monthly gross salary').'</b>: '.$currency_symbol.' '.numberAccountingFormat($gross_salary).'   ';
			         
			         //gad si yo pran taxe pou payroll sa
			         $employee_teacher = Persons::model()->isEmployeeTeacher($this->person_id, $acad);	
					
					 $deduct_iri=false; 
										  
					  if(!$employee_teacher)//si moun nan pa alafwa anplwaye-pwofese 
			           { 
			           	   
			           	   
			           	   $html .= ' <br/><div  class="taxe_line" ><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary).'): 
			         				 <br/> <table class="tb_taxe_line" >
									   <tr>
									   
									  <td class="td_libelle_taxe" style="text-align:center; "> '.Yii::t('app',' Taxe ').' </td>
									       <td class="td_taxe" style="text-align:center; ">'.Yii::t('app','%').' </td>
									       <td style="text-align:center; "> '.Yii::t('app','Worth value').'</td>
									       
									       
									    </tr>';

 
			           	  if($taxe != 0)  
			           	    { 
			           	    				           	    	
			           	    	
			           	    	$sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_payroll_set;
															
							  $command__ = Yii::app()->db->createCommand($sql__);
							  $result__ = $command__->queryAll(); 
																		       	   
								if($result__!=null) 
								 { foreach($result__ as $r)
								     { 
								     	  $deduction = 0;
								     	 $tx_des='';
											     	   $tx_val='';
											     	   
											     	 $sql_tx_des = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																				
													  $command_tx_des = Yii::app()->db->createCommand($sql_tx_des);
													  $result_tx_des = $command_tx_des->queryAll(); 
																								       	   
														foreach($result_tx_des as $tx_desc)
														     {   $tx_des= $tx_desc['taxe_description'];
														         $tx_val= $tx_desc['taxe_value'];
														       }
											     	 
											     	 
											if( ($tx_des!='IRI') ) //c pa iri,
								     	      {
								     	      	    $deduction = ( ($gross_salary * $tx_val)/100);
											          $total_deduction = $total_deduction + $deduction;
								     	      	      $html .= '<tr>
									                  <td class="td_libelle_taxe" style="text-align:center;"> '.$tx_des.'  </td>
															       <td class="td_taxe" style="text-align:center; ">'.$tx_val.' </td>
															       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($deduction).'</td>
															 </tr>';

											         
											         
											         
								     	      	}
								     	    elseif($tx_des=='IRI')
								     	       $deduct_iri=true; 
			 						     	      	
										  
										  }
											  
									 }
				              
			           	      }  
			           	          
				                  
				             if($deduct_iri)
		                           {$iri = 0; 
		                           	$iri = getIriDeduction($id_payroll_set,$id_payroll_set2,$gross_salary);
		                           	  $total_deduction = $total_deduction + $iri;
		                           	 $html .= '   
									  <tr> 
									   <td class="td_libelle_taxe" style="text-align:center; "> '.Yii::t('app','IRI').' </td>
									       <td class="td_taxe" style="text-align:center; ">&nbsp;&nbsp; </td>
									       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($iri).'</td>
									       
									       
									    </tr>';
		                              }     
				              
				                 
				               $html .= '  </table> 
						           </div>';  
						            
			             }
			          elseif($employee_teacher)//si moun nan alafwa anplwaye-pwofese 
			           {  
			           	      $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.id IN('.$id_payroll_set.','.$id_payroll_set2.')'));
			           	      
			                        $modelPayrollSettings = PayrollSettings::model()->findAll($criteria);
			                        
			                        $as_emp=0;
			                        $as_teach=0;
			                        $payroll_set1 = '';
			                        $deduct_iri=false;
			                      	 
			                      foreach($modelPayrollSettings as $amount)
				                   {   
				                   	  $gross_salary1 =0;
				                   	  $deduction1 =0;
				                   	  $as = $amount->as;
				                   	  $gross_for_hour = 0;
				                   	  
				                     //fosel pran yon ps.as=0 epi yon ps.as=1
				                       if(($as_emp==0)&&($as==0))
				                        { $as_emp=1;
				                          
					                     if(($amount!=null))
							               {  
							               	   $id_payroll_set1 = $amount->id;
							               	   
							               	   $gross_salary1 =$amount->amount;
							               	   
							               	   $number_of_hour = $amount->number_of_hour;
							               	   
							               	   
							               	       $gross_for_hour = $gross_salary1;
							               	       
							                 }
						           
						                
			           	         $html .= '<br/><div  class="taxe_line" ><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary1).' '.strtolower(Yii::t('app','As').' '.Yii::t('app','Employee')).'): 
			         				<br/> <table class="tb_taxe_line" >
									   <tr>
									   
									  <td class="td_libelle_taxe" style="text-align:center; ">'.Yii::t('app',' Taxe ').' </td>
									       <td class="td_taxe" style="text-align:center; ">'.Yii::t('app','%').' </td>
									       <td style="text-align:center; ">'.Yii::t('app','Worth value').'</td>
									       
									       
									    </tr>';

 
						           	  if($taxe != 0)  
						           	    { 
						           	    				           	    	
						           	    	
						           	    	$sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_payroll_set1;
																		
										  $command__ = Yii::app()->db->createCommand($sql__);
										  $result__ = $command__->queryAll(); 
																					       	   
											if($result__!=null) 
											 { foreach($result__ as $r)
											     { 
											     	  $deduction1 = 0;
											     	 $tx_des='';
											     	   $tx_val='';
											     	   
											     	 $sql_tx_des = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																				
													  $command_tx_des = Yii::app()->db->createCommand($sql_tx_des);
													  $result_tx_des = $command_tx_des->queryAll(); 
																								       	   
														foreach($result_tx_des as $tx_desc)
														     {   $tx_des= $tx_desc['taxe_description'];
														         $tx_val= $tx_desc['taxe_value'];
														       }
											     	 
											     	 
											     	 if( ($tx_des!='IRI') ) //c pa iri,
											     	      {
											     	      	   $deduction1 = ( ($gross_salary1 * $tx_val)/100);
														          $total_deduction = $total_deduction + $deduction1;
											     	      	      $html .= '<tr>
												      <td class="td_libelle_taxe" style="text-align:center;">'.$tx_des.'  </td>
																		       <td class="td_taxe" style="text-align:center; ">'.$tx_val.' </td>
																		       <td style="text-align:center; ">'.$currency_symbol.' '.numberAccountingFormat($deduction1).'</td>
																		 </tr>';
			
														         
														         
														         
											     	      	}
											     	    elseif($tx_des=='IRI')
											     	       $deduct_iri=true; 
						 						     	      	
													  
													  }
														  
												 }
								              
							           	      } 
							              
							             $html .= '  </table> 
						                    </div>';
				                          
				                          }
				                        elseif(($as_teach==0)&&($as==1))
				                           {   $as_teach=1;
				                          
						                     if(($amount!=null))
								               {  
								               	   $id_payroll_set2 = $amount->id;
								               	   
								               	   $gross_salary1 =$amount->amount;
								               	   
								               	   $number_of_hour = $amount->number_of_hour;
								               	   
								               	   if($amount->an_hour==1)
								                     {
								                         $gross_salary1 = $gross_salary1 * $number_of_hour;
								                        }
								               	   
								               	   $gross_for_hour = $gross_salary1;
								               	   
								                 }
							           
						                
					           	         $html .= '<div  class="taxe_line" ><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary1).' '.strtolower(Yii::t('app','As').' '.Yii::t('app','Teacher')).'): 
					         				<br/> <table class="tb_taxe_line" >
											   <tr>
											   
									<td class="td_libelle_taxe" style="text-align:center; ">'.Yii::t('app',' Taxe ').'</td>
											       <td class="td_taxe" style="text-align:center; ">'.Yii::t('app','%').'</td>
											       <td style="text-align:center; ">'.Yii::t('app','Worth value').'</td>
											       
											       
											    </tr>';
		
		 
								           	  if($taxe != 0)  
								           	    { 
								           	    				           	    	
								           	    	
								           	    	$sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_payroll_set2;
																				
												  $command__ = Yii::app()->db->createCommand($sql__);
												  $result__ = $command__->queryAll(); 
																							       	   
													if($result__!=null) 
													 { foreach($result__ as $r)
													     { 
													     	  $deduction1 = 0;
													     	 $tx_des='';
													     	   $tx_val='';
													     	   
													     	 $sql_tx_des = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																						
															  $command_tx_des = Yii::app()->db->createCommand($sql_tx_des);
															  $result_tx_des = $command_tx_des->queryAll(); 
																										       	   
																foreach($result_tx_des as $tx_desc)
																     {   $tx_des= $tx_desc['taxe_description'];
																         $tx_val= $tx_desc['taxe_value'];
																       }
													     	 
													     	 
													     	 if( ($tx_des!='IRI') ) //c pa iri,
													     	      {
													     	      	    $deduction1 = ( ($gross_salary1 * $tx_val)/100);
																          $total_deduction = $total_deduction + $deduction1;
													     	      	      $html .= '<tr>
										     <td class="td_libelle_taxe" style="text-align:center;">'.$tx_des.'</td>
																				       <td class="td_taxe" style="text-align:center; ">'.$tx_val.'</td>
																				       <td style="text-align:center; ">'.$currency_symbol.' '.numberAccountingFormat($deduction1).'</td>
																				 </tr>';
					
																         
																         
																         
													     	      	}
													     	    elseif($tx_des=='IRI')
													     	       $deduct_iri=true; 
								 						     	      	
															  
															  }
																  
														 }
									              
								           	      } 
								              
								           
				                     $html .= '  </table> 
						                    </div>';				                          
				                             
				                             }
			                       
			                   
			                      }//end foreach
			                       
			                      	
			                   
			                     if($deduct_iri)
		                           {
		                           	   $iri = 0; 
		                              	$iri = getIriDeduction($id_payroll_set,$id_payroll_set2,$gross_salary);
		                           	  $total_deduction = $total_deduction + $iri;
		                           	  
		                         $html .= '<div  class="taxe_line" ><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary).'): 
					         				<br/> <table class="tb_taxe_line" >
											   <tr>
											   
									<td class="td_libelle_taxe" style="text-align:center; ">'.Yii::t('app',' Taxe ').'</td>
											       <td class="td_taxe" style="text-align:center; ">&nbsp;&nbsp;</td>
											       <td style="text-align:center; ">'.Yii::t('app','Worth value').'</td>
											       
											       
											    </tr>  
											  <tr> 
											   <td class="td_libelle_taxe" style="text-align:center; ">'.Yii::t('app','IRI').'</td>
											       <td class="td_taxe" style="text-align:center; ">&nbsp;&nbsp;</td>
											       <td style="text-align:center; ">'.$currency_symbol.' '.numberAccountingFormat($iri).'</td>
											       
											       
											    </tr>
											     </table> 
						                 </div>';
		                              }     
				              


			                  }
			                   
		            $html .= '     <div class="taxe_line" ><b>'.Yii::t('app','Total charge').'</b>: '.$currency_symbol.' '.numberAccountingFormat($total_deduction).' </div>  ';                       
							         
			                 //tcheke loan
			                 $loan = 0;
			               $loan = Payroll::model()->getLoanDeduction($this->person_id,$gross_salary,$number_of_hour,$missing_hour,$net_salary,$taxe);
			                   $total_deduction = $total_deduction + $loan;
			      $html .= '<br/><div class="taxe_line" ><b>'.Yii::t('app','Loan(deduction)').'</b>: '.$loan.'</div>';
			          
		/* if($missing_hour!=0)
	       {
	       	   $number_of_hour = PayrollSettings::model()->getSimpleNumberHourValue($this->person_id);
	       	   $gross_salary_deduction = ($gross_for_hour * $missing_hour) / $number_of_hour;
	       	   
	       	   $total_deduction = $total_deduction + $gross_salary_deduction;
	       	   
	       	     $html .= '     <br/><div class="taxe_line" > '.Yii::t('app','Deduction').' ('.Yii::t('app','Missing hour').': '.$missing_hour.') : '.$gross_salary_deduction.' </div>';
	       	   
	       	 }
			          
	        */  
			      $html .= '    <br/> <b>'.Yii::t('app','Total deduction').'</b>: '.$currency_symbol.' '.numberAccountingFormat($total_deduction).'   ';
			       
			       
			         
			      $html .= '   <br/><br/> <b>'.Yii::t('app','Monthly net salary').'</b>: '.$currency_symbol.' '.numberAccountingFormat($net_salary).' 
			      
			      <br/>
			      <div class="siyati"> &nbsp;&nbsp;&nbsp;'.Yii::t('app','Authorized signature').'</div>
			      <br/><br/>
			         
			       </div>
	<div style="float:right; text-align: right; font-size: 6px; margin-bottom:-8px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>			      
			     </div>';
										
	   
$html .= '  </label>
    </div>  ';     
          
    		    
            



    
                                            $pdf->writeHTML($html, true, false, true, false, '');
		                                    // Print text using writeHTMLCell()
                                          //$pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);
                           }	
                           
                            
								  $file_name = Yii::t('app','Payroll receipt').'_'.$this->payroll_date.'_'.$month_.'_'.$acad_name;
								$pdf->Output($file_name, 'D');
	                  	          /*Parameters
    $name	(string) The name of the file when saved. Note that special characters are removed and blanks characters are replaced with the underscore character.
    $dest	(string) Destination where to send the document. It can take one of the following values:

        I: send the file inline to the browser (default). The plug-in is used if available. The name given by name is used when one selects the "Save as" option on the link generating the PDF.
        D: send to the browser and force a file download with the name given by name.
        F: save to a local server file with the name given by name.
        S: return the document as a string (name is ignored).
        FI: equivalent to F + I option 
        FD: equivalent to F + D option
        E: return the document as base64 mime multi-part email attachment (RFC 2045)
*/
				   		
				       }
				else //message vous n'avez croche personne
				   {
					 $this->message_noOneSelected=true;
							
					}

			     }	
			  	
			if(isset($_POST['cancel']))
			  {    
			  	$model=new Payroll;
				$this->person_id=0;
				$this->payroll_month = 0;
				$this->payrollReceipt_available =false;
				Yii::app()->session['payroll_person_id']='';
				Yii::app()->session['payroll_id_payroll_set']='';
				$this->grouppayroll = '';
				
					
			  }
			  
	   }

		$this->render('receipt',array(
			'model'=>$model,
		));
	}





	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Payroll('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Payroll']))
			$model->attributes=$_GET['Payroll'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}



//return charge deduction over gross_salary
public function getTaxes($id_pay_set, $gross_salary)
  {
       $deduction=0;
  	 $total_deduction=0;
  	 
  	  $sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_pay_set;
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						     { 
						     	  $deduction = 0;
						     	 $tx_des='';
						     	   $tx_val='';
					     	   
						     	 $sql_tx_des = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
															
								  $command_tx_des = Yii::app()->db->createCommand($sql_tx_des);
								  $result_tx_des = $command_tx_des->queryAll(); 
																			       	   
									foreach($result_tx_des as $tx_desc)
									     {   $tx_des= $tx_desc['taxe_description'];
									         $tx_val= $tx_desc['taxe_value'];
									       }
						     	 
						     	 
						     	 if( ($tx_des!='IRI') ) //c pa iri, 
						     	      {
						     	      	  $deduction = ( ($gross_salary * $tx_val)/100);
						     	      	}
	 						     	      	
								  $total_deduction = $total_deduction + $deduction;
							  }
								  
						 }
	  	     
  	  return $total_deduction;
  	
  }


  	  	

//return working times in minutes
public function getHours($person_id,$acad)
  {
  	    $nbr_time =null;
  	    $minute= null;
  	     $dat=null;
  	    $i=0;
  	    $data_times = Schedules::model()->getTimesForSpecificTeacherForPayroll($person_id,$acad);
  	     
  	      $data_times=$data_times->getData();
		    if($data_times<>NULL)
			  { foreach($data_times as $t) 
				  {	$diff=((strtotime($t->time_end)) - ( strtotime($t->time_start)))/60;
				     
				       $nbr_time = $nbr_time +  $diff;
				        	 
				        	
					}				
				}
				
				
		
          if($nbr_time !=0)
            return $nbr_time;
          else
             return null;
  	   
  	}


//************************  anyPayrollDoneAfterForOnes($month,$pers,$acad)  ******************************/	
	public function anyPayrollDoneAfterForOnes($month,$date,$pers,$acad)
	{    
                $bool=false;
               
		 if($month!='')
		   {
		   	  	 $any_after = Payroll::model()->anyAfterDoneForOnes($month,$date,$pers,$acad);
  
				  	 if(isset($any_after)&&($any_after!=null))
						  {  //$any_after_ = $any_after->getData();//return a list of  objects
						           
						      foreach($any_after as $p)
						       {			   
								  
								  if($p['id']!=null)
								     {				     	
								     	  $bool=true;
								     }
								}  
						   }
				  	
							 
		     }
		     
		     
		return $bool;
         
	}




//************************  getSelectedLongMonthValueByPerson($person_id)  ******************************/	
 public function getSelectedLongMonthValueByPerson($person_id)
	{    
         $code = array(); 
         
         $nbre_payroll = infoGeneralConfig('total_payroll');  
         
           if($person_id!='')
           {
            $last_payroll_info=Payroll::model()->getInfoLastPayrollByPerson($person_id);
		  
			
				if(isset($last_payroll_info)&&($last_payroll_info!=null))
				 {
					  $last_payroll_month=0;
	 				  
					  $payroll=$last_payroll_info->getData();//return a list of ... objects
				           
				      foreach($payroll as $p)
				       {			   
						  if($p->id!=null)
						     {  
						     	$last_payroll_month = $p->payroll_month;
						     	 break;
						     	 
						     }
						     
						} 
					  
					 if($last_payroll_month!=$nbre_payroll)
					  { 
						  for($i=($last_payroll_month + 1); $i<=$nbre_payroll; $i++)
						   {			   
							   $month_name=Payroll::model()->getSelectedLongMonth($i);
							   
							   $code[$i]= $month_name; 	  
								     
						     }  
					   }
					  else
					  {
					  	 for($i=1; $i<=$nbre_payroll; $i++)
						   {			   
							   $month_name=Payroll::model()->getSelectedLongMonth($i);
							   
							   $code[$i]= $month_name; 	  
								     
						     }  
					  	}
				     
				   }
				 else
				  {
				  	 for($i=1; $i<=$nbre_payroll; $i++)
					   {			   
						   $month_name=Payroll::model()->getSelectedLongMonth($i);
						   
						   $code[$i]= $month_name; 	  
							     
					     }  
				  	}
			   
             }
			else
			  {
			  	 for($i=1; $i<=$nbre_payroll; $i++)
				   {			   
					   $month_name=Payroll::model()->getSelectedLongMonth($i);
					   
					   $code[$i]= $month_name; 	  
						     
				     }  
			  	}
			  	 	
		return $code;
         
	}

	    //************************  getPerson($id) ******************************/
   public function getPerson($id)
	{
		
		$person=Persons::model()->findByPk($id);
        
			
		       if(isset($person))
				return $person->first_name.' '.$person->last_name;
		
	}
	

//************************  getSelectedLongMonthValue()  ******************************/	
 public function getSelectedLongMonthValue()
	{    
         $code = array();   
         
          $nbre_payroll = infoGeneralConfig('total_payroll');  
          
			  	 for($i=1; $i<=$nbre_payroll; $i++)
				   {			   
					   $month_name=Payroll::model()->getSelectedLongMonth($i);
					   
					   $code[$i]= $month_name; 	  
						     
				     }  
			  
			  	 	
		return $code;
         
	}



//************************  getPastLongMonthValueByPerson($id_payroll_set)  ******************************/	
 public function getPastLongMonthValueByPerson($id_payroll_set)
	{    
         $code = array();   
         
         $payroll=Payroll::model()->getMonthPastPayrollByPerson($id_payroll_set);
		        
			
			if($payroll!=null)
			 {
				 foreach($payroll as $p)
			       {	 
					     	$code[$p['payroll_month']] = Payroll::model()->getSelectedLongMonth($p['payroll_month']);
				     
					} 
			  }
			
			  	 	
		return $code;
         
	}




//************************  getLastPastPayrollDateByPerson($id_payroll_set, $payroll_month)  ******************************/	
 public function getLastPastPayrollDateByPerson($id_payroll_set, $payroll_month)
	{    
         $last_pyrollDate = null;   
         
         $payroll=Payroll::model()->getDatePastPayrollByPerson($id_payroll_set, $payroll_month);
		        
			
			if($payroll!=null)
			 {
				 foreach($payroll as $p)
			       {	 
					     	$last_pyrollDate = $p['payroll_date'];
				     
					} 
			  }
			
			  	 	
		return $last_pyrollDate;
         
	}



//************************  getLastPastPayrollDateByGroup($payroll_month)  ******************************/	
 public function getLastPastPayrollDateByGroup($payroll_month)
	{    
         $last_pyrollDate = null;   
         
         $payroll=Payroll::model()->getDatePastPayrollByGroup($payroll_month);
		        
			
			if($payroll!=null)
			 {
				 foreach($payroll as $p)
			       {	 
					     	$last_pyrollDate = $p['payroll_date'];
				     
					} 
			  }
			
			  	 	
		return $last_pyrollDate;
         
	}


//************************  getLastPastPayrollDate($payroll_month)  ******************************/	
 public function getLastPastPayrollDate($payroll_month)
	{    
         $last_pyrollDate = null;   
         
         $payroll=Payroll::model()->getDatePastPayroll($payroll_month);
		        
			
			if($payroll!=null)
			 {
				 foreach($payroll as $p)
			       {	 
					     	$last_pyrollDate = $p['payroll_date'];
				     
					} 
			  }
			
			  	 	
		return $last_pyrollDate;
         
	}



//************************  getLastPastLongMonthValueByPerson($id_payroll_set)  ******************************/	
 public function getLastPastLongMonthValueByPerson($id_payroll_set)
	{    
         $last_pyrollMonth = null;   
         
         $payroll=Payroll::model()->getMonthPastPayrollByPerson($id_payroll_set);
		        
			
			if($payroll!=null)
			 {
				 foreach($payroll as $p)
			       {	 
					     	$last_pyrollMonth = $p['payroll_month'];
				     
					} 
			  }
			
			  	 	
		return $last_pyrollMonth;
         
	}



//************************  getPastLongMonthValueByPayroll_group($grouppayroll)  ******************************/	
 public function getPastLongMonthValueByPayroll_group($grouppayroll)
	{    
         $code = array();   
         
         $payroll=Payroll::model()->getMonthPastPayrollByPayroll_group($grouppayroll);
		  
			
			if($payroll!=null)
			 {
				 foreach($payroll as $p)
			       {	 
					     	$code[$p['payroll_month']] = Payroll::model()->getSelectedLongMonth($p['payroll_month']);
				     
					} 
			  }
			
			  	 	
		return $code;
         
	}


//************************  getPastLongMonthValue()  ******************************/	
 public function getPastLongMonthValue()
	{    
         $code = array();   
         
         $payroll=Payroll::model()->getMonthPastPayroll();
		  
			
			if($payroll!=null)
			 {
				 foreach($payroll as $p)
			       {	 
					     	$code[$p['payroll_month']] = Payroll::model()->getSelectedLongMonth($p['payroll_month']);
				     
					} 
			  }
			
			  	 	
		return $code;
         
	}
	
    
public function setTimeToH_i_s($time) 
   {
   	    $time_set='';
   	    //convert to hour: H
   	    $explode_H = explode(".",substr(($time/60), 0));
			$time_set= $explode_H[0].': ';
		  //check for minute: i	
			if(isset($explode_H[1]))
			 { $minute= round((('0.'.$explode_H[1])*60),2);
				 $explode_i = explode(".",substr(($minute), 0));
				   $time_set= $time_set.$explode_i[0].': ';
				   //check for seconde: s
				    if(isset($explode_i[1]))
					 { $seconde = round((('0.'.$explode_i[1])*60),2);
					      $explode_s = explode(".",substr(($seconde), 0));
					 	
					 	  $time_set= $time_set.$explode_s[0];
					  }
					else
					   $time_set= $time_set.'00';
			  }
		    else
		      $time_set= $time_set.'00: 00';
		      
   	         
   	   return date($time_set);
     }


public function setMissingTimeForUpdate($time) 
   {
   	    $time_set='';
   	    //convert to hour: H
   	    $explode_H = explode(".",substr(($time/60), 0));
			$time_set= $explode_H[0].'.';
		  //check for minute: i	
			if(isset($explode_H[1]))
			 { $minute= round((('0.'.$explode_H[1])*60),2);
				 $time_set= $time_set.$minute;
	    	  }
		    else
		      $time_set= $time_set.'00';
		      
   	         
   	   return $time_set;
     }


//return null if format is wrong, time in minutes if ok
public function missingTimeFormatCheck($time) 
   {
   	    $time_set='';
   	    //convert to hour: H
   	    $explode_H = explode(".",substr(($time), 0));
			$time_set= $explode_H[0].': ';
		  //check for minute: i	
			if((!isset($explode_H[1]))||($explode_H[1]>59))
			  return null;
			else
			  {  $time_set= ($explode_H[0]*60)+$explode_H[1];
			    	return $time_set;
			   }
			 
     }
	
	
	
	
  // Export to CSV 
        public function behaviors() {
           return array(
               'exportableGrid' => array(
                   'class' => 'application.components.ExportableGridBehavior',
                   'filename' => Yii::t('app','payroll.csv'),
                   'csvDelimiter' => ',',
                   ));
        }


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Payroll the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Payroll::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Payroll $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payroll-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
