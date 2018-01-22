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




class LoanOfMoneyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url='';
	public $person_id;
	public $payroll_month;
	
	
	public $depensesItems=0;
	 public $part; 
	public $month_ =0;
	
	public $message_loandate=false;
	public $messageLoanNotPossible =false;
	public $messageLoanExceed =false;
	public $messageLoanNotPaid =false;
	public $message_UpdateAlreadyPaid=false;
	public $messageAmountNotAllowed=false;
	public $messageRemainPayroll = false;
	public $messageRefund = false;	

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
		   
		  $explode_url= explode("/",substr($_SERVER['REQUEST_URI'], 1));
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
		$acad=Yii::app()->session['currentId_academic_year'];
		
		
		$model=new LoanOfMoney;
		
		$this->message_loandate=false;
		
		

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LoanOfMoney']))
		{   
			  	$model->attributes=$_POST['LoanOfMoney'];
			   
			     if($model->person_id!='')
			       $this->person_id = $model->person_id;
			       
			     if($model->payroll_month!='')
			       $this->payroll_month = $model->payroll_month;

			     
			//if(Yii::app()->session['PersonLoan'] == '')
			 //    Yii::app()->session['PersonLoan'] = $this->person_id;
			//else
			//    $this->person_id = Yii::app()->session['PersonLoan'];


			$id_payroll_set ='';
			$id_payroll_set2=null;
			$amount_to_be_paid=0;
			$an_hour = 0;
			$timely_salary = 0;
			$sum_loan=0;
			
			$this->messageAmountNotAllowed = false;
			$this->messageRemainPayroll = false;
			$this->messageRefund = false;			
			  
			  
			  if($this->person_id!='')
			    {   
			    	
			    	//tcheke si moun sa gen avans ki poko fin paye
					 $loanPaid = $this->allLoanPaid($this->person_id);
					 if(!$loanPaid)
					   {  
					   	   
					   	   $this->messageLoanNotPaid =true;
				        }

			   				    	
			    	//check if payroll for this month already done
			    	$payrollDone = $this->isPayrollDoneForOnes($this->payroll_month,$this->person_id,$acad);  
								
					  if($payrollDone)
					   {
					   	//print_r('<br/><br/>*********************************************************************************************A-'.$payrollDone);
					   	    $this->messageLoanNotPossible =true;
					   	}
					   	
			     }

			if(isset($_POST['create']))
			 {
				$number_of_hour = null;
				$gross_salary = 0;
				$total_payroll =0;
				$remain_payroll =0;
				$number_past_payroll =0;
				
			   $model->setAttribute('person_id',$this->person_id);
				
				//check the total payroll of this year
				$total_payroll = infoGeneralConfig('total_payroll');
				
			
			if(($model->number_of_month_repayment!='')&&($model->amount!=''))
			  {
				//number of past payroll
				$sql2 = 'SELECT DISTINCT payment_date, count(payment_date) as number_past_payroll FROM payroll p INNER JOIN payroll_settings ps ON(ps.id= p.id_payroll_set) WHERE ps.old_new=1 AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad;
				
															
					  $command2 = Yii::app()->db->createCommand($sql2);
					  $result2 = $command2->queryAll(); 
																       	   
						if($result2!=null) 
						 { foreach($result2 as $r)
						     { $number_past_payroll =$r['number_past_payroll'];
						          break;
						     }
						  }
				
				$remain_payroll = $total_payroll - $number_past_payroll;
				
								     
				//check if amount value > max_amount_loan
				$max_amount_loan = infoGeneralConfig('max_amount_loan');
	         if($model->amount <= $max_amount_loan)
			  {
								                     
                 $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.old_new=1 AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
                 //check if it is a timely salary 
                   $model_ = new PayrollSettings;
                     $pay_set = PayrollSettings::model()->findAll($criteria);
                    
                    $as_emp=0;
                    $as_teach=0;
                    $id_payroll_set_emp=null;
                    $id_payroll_set_teach=null;
                    $total_gross_salary=0;
                    $total_net_salary=0;
                    $total_deduction=0;
                    $iri_deduction =0;
                    
                 foreach($pay_set as $amount)
                   {   
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
			               	   
			               	   $missing_hour = $amount->number_of_hour;
			               	   
			               	   if($amount->an_hour==1)
			                     $timely_salary = 1;
			                 }
			           //get number of hour if it's a timely salary person
			            if($timely_salary == 1)
			              {
			             	 $number_of_hour = $amount->number_of_hour;   //$this->getHours($this->person_id,$acad);
			                 
			                //calculate $gross_salary by hour if it's a timely salary person 
						     if(($number_of_hour!=null)&&($number_of_hour!=0))
						       {
						          $gross_salary = ($gross_salary * $number_of_hour);
						          
						          
						
						        }
			                   
			             
				            }
			           
			            $total_gross_salary = $total_gross_salary + $gross_salary;
			          
			          	  	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary); 
	                       	    $total_deduction = $total_deduction + $deduction;
	                       	    $net_salary = $gross_salary - $deduction;
	                       	  
                          
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
					               	   
					               	   $missing_hour = $amount->number_of_hour;
					               	   
					               	   if($amount->an_hour==1)
					                     $timely_salary = 1;
					                 }
					           //get number of hour if it's a timely salary person
					            if($timely_salary == 1)
					              {
					             	  $number_of_hour = $amount->number_of_hour;   //$this->getHours($this->person_id,$acad);
					                 
					                  //calculate $gross_salary by hour if it's a timely salary person 
								     if(($number_of_hour!=null)&&($number_of_hour!=0))
								       {
								          $gross_salary = ($gross_salary * $number_of_hour);
								          
								          
								
								        }
					                   
					             
						            }
					           
					            $total_gross_salary = $total_gross_salary + $gross_salary;
					          
					          	       $deduction= $this->getTaxes($id_payroll_set,$gross_salary); 
			                       	    $total_deduction = $total_deduction + $deduction;
			                       	    $net_salary = $gross_salary - $deduction;
			                       
		                          $total_net_salary = $total_net_salary + $net_salary;
		                          
                          
                          
                               }
                       
                      }
                       
                        if(($id_payroll_set_teach!=null)&&($id_payroll_set_emp!=null))
			                       {
			                       	   $id_payroll_set = $id_payroll_set_emp;
			                       	   $id_payroll_set2 = $id_payroll_set_teach;
			                       	}

                      
                      //DEDUCTION TAXE IRI
                          $iri_deduction = getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary);
	                       	$total_deduction = $total_deduction + $iri_deduction;
	                       	$total_net_salary = $total_net_salary - $iri_deduction;
	                       
                       $amount_to_be_paid = $total_net_salary;

				     
				     //$amount_to_be_paid = $this->salaire_net($model->person_id);
				    if(($model->loan_date=='0000-00-00') ||($model->loan_date==''))
				      $model->setAttribute('loan_date',date('Y-m-d'));
				      
				   $amount=$model->amount;
				   //check if already has a loan for this month
				     //return the total amount for this month
				      $sum_loan = $this->personHasLoan($model->person_id,$model->payroll_month);
				   
								   	 
				   	  if($amount_to_be_paid < ($amount + $sum_loan))
				  	     $this->messageLoanExceed =true;
				   	 
				      
				      
				   	  if($remain_payroll >= ($model->number_of_month_repayment))
				   	   {//la remise/payroll
				   	       
				   	       $refund = $amount/$model->number_of_month_repayment;
				   	       
				   	       if($refund <= $total_net_salary)
				   	         {
						   	  	 
						   	  	  $percent = ($refund/$total_net_salary)*100;
						   	  	  
						   	  	  if(is_decimal($percent) )
						   	  	     {
						   	  	     	  $percent = round(($refund/$total_net_salary)*100 , 0) + 1; 
						   	  	       }
						   	  	  
						   	  	   
						   	  	   $model->setAttribute('deduction_percentage',$percent);
						   	  	   $model->setAttribute('remaining_month_number',$model->number_of_month_repayment);
								   $model->setAttribute('academic_year',$acad);
								   $model->setAttribute('solde',$amount);
								   $model->setAttribute('date_created',date('Y-m-d'));
							  	   $model->setAttribute('created_by',Yii::app()->user->name);

							  	
							    if($model->save())
								  {
								  	 unset(Yii::app()->session['PersonLoan']);
								  	 
								  	 $this->redirect(array('view','id'=>$model->id,'part'=>'pay','from'=>'c'));
								  	 
								  }
								   
				   	         }
				   	       else
				   	          $this->messageRefund = true;
					   
				   	   }
				   	 else
				   	   $this->messageRemainPayroll = true;
					   
			      }
			    else
			      {
			      	$this->messageAmountNotAllowed = true;	
			      	}
					   
					   
			    }
			    
					   
			   }
			   
			
			if(isset($_POST['cancel']))
			  {    
			  	//$model=new LoanOfMoney;
			  		
				$this->person_id='';
				//  Yii::app()->session['PersonLoan']='';
				  $this->messageLoanNotPaid = false;
				  $this->messageLoanNotPossible = false;
				  $this->messageAmountNotAllowed = false;
				  $this->messageRemainPayroll = false;
				  $this->messageRefund = false;
									
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
		
		$model=$this->loadModel($id);
		
		$this->person_id = $model->person_id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['LoanOfMoney']))
		  {
			$model->attributes=$_POST['LoanOfMoney'];
		    }
			  if(($model->paid!=1))   //rasire ke se pou pwofese li tcheke
		        {
				  
				    $id_payroll_set ='';
				    $id_payroll_set2 =null;
					$amount_to_be_paid=0;
					$an_hour = 0;
					$sum_loan=0;
			
			 			
			  
			  
				  if($this->person_id!='')
				    {
				    	
				    	//check if payroll for this month already done
				    	$payrollDone = $this->isPayrollDoneForOnes($model->payroll_month,$this->person_id,$acad);
									
						  if($payrollDone)
						   {
						   	    $this->messageLoanNotPossible =true;
						   	}
					   	
			         }

				  
					  if(isset($_POST['update']))
					   { 
					      $number_of_hour = null;
							$gross_salary = 0;
							$total_payroll =0;
							$remain_payroll =0;
							$number_past_payroll =0;
							$timely_salary =0;
							
							//check the total payroll of this year
							$total_payroll = infoGeneralConfig('total_payroll');
							
							//number of past payroll
							$sql2 = 'SELECT DISTINCT payment_date, count(payment_date) as number_past_payroll FROM payroll p INNER JOIN payroll_settings ps ON(ps.id= p.id_payroll_set) WHERE ps.old_new=1 AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad;
							
																		
								  $command2 = Yii::app()->db->createCommand($sql2);
								  $result2 = $command2->queryAll(); 
																			       	   
									if($result2!=null) 
									 { foreach($result2 as $r)
									     { $number_past_payroll =$r['number_past_payroll'];
									          break;
									     }
									  }
							
							$remain_payroll = $total_payroll - $number_past_payroll;
							
											     
							//check if amount value > max_amount_loan
							$max_amount_loan = infoGeneralConfig('max_amount_loan');
				         if($model->amount <= $max_amount_loan)
						  {
							 
							                     
			                 $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.old_new=1 AND ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
			                 //check if it is a timely salary 
			                   $model_ = new PayrollSettings;
			                     $pay_set = PayrollSettings::model()->findAll($criteria);
			                    
			                    $as_emp=0;
			                    $as_teach=0;
			                    $id_payroll_set_emp=null;
			                    $id_payroll_set_teach=null;
			                    $total_gross_salary=0;
			                    $total_net_salary=0;
			                    $total_deduction=0;
			                    $iri_deduction =0;
			                    
			                 foreach($pay_set as $amount)
			                   {   
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
						               	   
						               	   $missing_hour = $amount->number_of_hour;
						               	   
						               	   if($amount->an_hour==1)
						                     $timely_salary = 1;
						                 }
						           //get number of hour if it's a timely salary person
						            if($timely_salary == 1)
						              {
						             	 $number_of_hour = $amount->number_of_hour;   //$this->getHours($this->person_id,$acad);
						                 
						                //calculate $gross_salary by hour if it's a timely salary person 
									     if(($number_of_hour!=null)&&($number_of_hour!=0))
									       {
									          $gross_salary = ($gross_salary * $number_of_hour);
									          
									          
									
									        }
						                   
						             
							            }
						           
						            $total_gross_salary = $total_gross_salary + $gross_salary;
						          
						          	  	    $deduction= $this->getTaxes($id_payroll_set,$gross_salary); 
				                       	    $total_deduction = $total_deduction + $deduction;
				                       	    $net_salary = $gross_salary - $deduction;
				                       	  
			                          
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
								               	   
								               	   $missing_hour = $amount->number_of_hour;
								               	   
								               	   if($amount->an_hour==1)
								                     $timely_salary = 1;
								                 }
								           //get number of hour if it's a timely salary person
								            if($timely_salary == 1)
								              {
								             	  $number_of_hour = $amount->number_of_hour;   //$this->getHours($this->person_id,$acad);
								                 
								                  //calculate $gross_salary by hour if it's a timely salary person 
											     if(($number_of_hour!=null)&&($number_of_hour!=0))
											       {
											          $gross_salary = ($gross_salary * $number_of_hour);
											          
											          
											
											        }
								                   
								             
									            }
								           
								            $total_gross_salary = $total_gross_salary + $gross_salary;
								          
								          	       $deduction= $this->getTaxes($id_payroll_set,$gross_salary); 
						                       	    $total_deduction = $total_deduction + $deduction;
						                       	    $net_salary = $gross_salary - $deduction;
						                       
					                          $total_net_salary = $total_net_salary + $net_salary;
					                          
			                          
			                          
			                               }
			                       
			                      }
			                       
			                     if(($id_payroll_set_teach!=null)&&($id_payroll_set_emp!=null))
			                       {
			                       	   $id_payroll_set = $id_payroll_set_emp;
			                       	   $id_payroll_set2 = $id_payroll_set_teach;
			                       	}
			                      
			                      //DEDUCTION TAXE IRI
			                          $iri_deduction = getIriDeduction($id_payroll_set,$id_payroll_set2,$total_gross_salary);
				                       	$total_deduction = $total_deduction + $iri_deduction;
				                       	$total_net_salary = $total_net_salary - $iri_deduction;
				                       
			                       $amount_to_be_paid = $total_net_salary;
			
							     
							     //$amount_to_be_paid = $this->salaire_net($model->person_id);
							    if(($model->loan_date=='0000-00-00') ||($model->loan_date==''))
							      $model->setAttribute('loan_date',date('Y-m-d'));
							      
							   $amount=$model->amount;
							   //check if already has a loan for this month
							     //return the total amount for this month
							      $sum_loan = $this->personHasLoan($model->person_id,$model->payroll_month);
							   
							   
							   	 
							   	  if($amount_to_be_paid < ($amount + $sum_loan))
							  	     $this->messageLoanExceed =true;
							   	 
							      
							   	  if($remain_payroll >= ($model->number_of_month_repayment))
							   	   {//la remise/payroll
							   	       
							   	       $refund = $amount/$model->number_of_month_repayment;
							   	       
							   	       if($refund <= $total_net_salary)
							   	         {
									   	  	   $percent = ($refund/$total_net_salary)*100;
						   	  	  
									   	  	  if(is_decimal($percent) )
									   	  	     {
									   	  	     	  $percent = round(($refund/$total_net_salary)*100 , 0) + 1; 
									   	  	       }
						   	  	  									   	  	  
									   	  	   $model->setAttribute('deduction_percentage',$percent);
									   	  	   $model->setAttribute('remaining_month_number',$model->number_of_month_repayment);
											   $model->setAttribute('solde',$amount);
											   $model->setAttribute('date_updated',date('Y-m-d'));
										  	   $model->setAttribute('updated_by',Yii::app()->user->name);
			
										  	
										    if($model->save())
											   $this->redirect(array('view','id'=>$model->id,'part'=>'pay','from'=>'u'));
											   
							   	         }
							   	       else
							   	          $this->messageRefund = true;
								   
							   	   }
							   	 else
							   	   $this->messageRemainPayroll = true;
								   
						      }
						    else
						      {
						      	$this->messageAmountNotAllowed = true;	
						      	}
			
								
					
					 }
					    
			      }
			     else
				   {
					   //$this->message_UpdateValidate=1;
					   //header('Location: ' . $_SERVER['HTTP_REFERER']);
					     $url=Yii::app()->request->urlReferrer;
					     $this->redirect($url.'/msguv/y');
					      //$this->redirect(Yii::app()->request->urlReferrer);
					       	 
					}
		  
		   
				  if(isset($_POST['cancel']))
                    {
                        //$this->redirect(array($this->back_url));
                        $this->redirect(Yii::app()->request->urlReferrer);
                     }
                              
		      
	

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		
		
		try {
   			 $this->loadModel($id)->delete();
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




	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		
		
		  
		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}

	             
                if(!isset($_GET['month_']))
			       {
			       	   $sql__ = 'SELECT DISTINCT loan_date FROM loan_of_money ORDER BY id DESC';
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						     { $current_month = getMonth($r['loan_date']);
						          break;
						     }
						  }
						else
						  $current_month = getMonth(date('Y-m-d'));
			       	  // $month_display=$current_month;
			        }
			     else 
			       {  $current_month = $_GET['month_'];
			       	  //$month_display= $_GET['month_'];
			        }
           
            $model=new LoanOfMoney('searchByMonth('.$current_month.','.$acad.')');
		        $model->unsetAttributes();  // clear any default values
		
		
		if(isset($_GET['LoanOfMoney']))
			$model->attributes=$_GET['LoanOfMoney'];
           
                            // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Loan of Money: ')), null,false);
                            $this->exportCSV($model->searchByMonth($current_month,$acad), array(
                                
				'person.last_name',
				'person.first_name',
				'amount',
				'payroll_month',
				'loanPaid',
				'loan_date',
                )); 
		    }
				
        
      
		
				

		$this->render('index',array(
			'model'=>$model,
		));	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new LoanOfMoney('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['LoanOfMoney']))
			$model->attributes=$_GET['LoanOfMoney'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


//************************  isPayrollDoneForOnes($month,$pers,$acad)  ******************************/	
	public function isPayrollDoneForOnes($month,$pers,$acad)
	{    
                $bool=false;
               
		 if($month!='')
		   {
			  $result=Payroll::model()->isDoneForOnes($month,$pers,$acad);
				
				 if(isset($result)&&($result!=null))
				  {  $payroll=$result->getData();//return a list of  objects
				           
				      foreach($payroll as $p)
				       {			   
						  if($p->id!=null)
						       $bool=true;
						}
						  
				   }
				   
				//check if there is any after
		/*		if(!$bool)
				  {
				  	 $any_after = Payroll::model()->anyAfterDoneForOnes($month,$pers,$acad);
  
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
			*/				 
		     }
		     
		     
		return $bool;
         
	}


//************************  isPayrollDone($month)  ******************************/	
	public function isPayrollDone($month)
	{    
                $bool=false;
		 if($month!='')
		   {
			  $result=Payroll::model()->isDone($month);
				
				 if(isset($result))
				  {  $payroll=$result->getData();//return a list of  objects
				           
				      foreach($payroll as $p)
				       {			   
						  if($p->id!=null)
						       $bool=true;
						}  
				   }	 					 
		     }
		     
		     
		return $bool;
         
	}



//return an objects of type Payroll
//************************  infoLastPayrollDone()  ******************************/	
	public function infoLastPayrollDone()
	{    
                
		  $result=Payroll::model()->getInfoLastPayroll();
		  
		  	 if(isset($result))
			  {  $payroll=$result->getData();//return a list of ... objects
			           
			      foreach($payroll as $p)
			       {			   
					  if($p->id!=null)
					     {  
					     	return $p;
					     	 break;
					     	 
					     }
					     
					}  
			   }	 					 
			
		return null;
         
	}


//return an objects of type Payroll
//************************  infoLastPayrollDoneForOne($pers)  ******************************/	
	public function infoLastPayrollDoneForOne($pers)
	 {    
                
		  $result=Payroll::model()->getInfoLastPayrollForOne($pers);
		  
			 if(isset($result))
			  {  $payroll=$result->getData();//return a list of ... objects
			           
			      foreach($payroll as $p)
			       {			   
					  if($p->id!=null)
					     {  
					     	return $p;
					     	 break;
					     	 
					     }
					     
					}  
			   }	 					 
			
		return null;
         
	}


//************************  getSelectedLongMonthValueForOne($pers)  ******************************/	
 public function getSelectedLongMonthValueForOne($pers)
	{    
         $code = array(); 
          
          $nbre_payroll = infoGeneralConfig('total_payroll');  
               
		  $last_payroll_info=$this->infoLastPayrollDoneForOne($pers);
			
			if(isset($last_payroll_info)&&($last_payroll_info!=null))
			 {
				  if($last_payroll_info->payroll_month == $nbre_payroll)
				    {
				    	for($i=1; $i<=$nbre_payroll; $i++)
						   {			   
							   $month_name=LoanOfMoney::model()->getSelectedLongMonth($i);
							   
							   $code[$i]= $month_name; 	  
								     
						     }  
				     }
				  else
					{  for($i=($last_payroll_info->payroll_month + 1); $i<=$nbre_payroll; $i++)
					   {			   
						   $month_name=LoanOfMoney::model()->getSelectedLongMonth($i);
						   
						   $code[$i]= $month_name; 	  
							     
					     }
					}  
			     
			  }
			else
			  {
			  	 
			  	 
			  	 for($i=1; $i<=$nbre_payroll; $i++)
				   {			   
					   $month_name=LoanOfMoney::model()->getSelectedLongMonth($i);
					   
					   $code[$i]= $month_name; 	  
						     
				     }  
			  	}
			  	 	
		return $code;
         
	}


//************************  getSelectedLongMonthValue()  ******************************/	
 public function getSelectedLongMonthValue()
	{    
         $code = array();       
		  
		  $nbre_payroll = infoGeneralConfig('total_payroll');  
               
		  $last_payroll_info=$this->infoLastPayrollDone();
			
			if(isset($last_payroll_info)&&($last_payroll_info!=null))
			 {
				  if($last_payroll_info->payroll_month == $nbre_payroll)
				    {
				    	for($i=1; $i<=$nbre_payroll; $i++)
						   {			   
							   $month_name=LoanOfMoney::model()->getSelectedLongMonth($i);
							   
							   $code[$i]= $month_name; 	  
								     
						     }  
				     }
				  else
					{  for($i=($last_payroll_info->payroll_month + 1); $i<=$nbre_payroll; $i++)
						   {			   
							   $month_name=LoanOfMoney::model()->getSelectedLongMonth($i);
							   
							   $code[$i]= $month_name; 	  
								     
						     }  
					}
			     
			  }
			else
			  {
			  	 for($i=1; $i<=$nbre_payroll; $i++)
				   {			   
					   $month_name=LoanOfMoney::model()->getSelectedLongMonth($i);
					   
					   $code[$i]= $month_name; 	  
						     
				     }  
			  	}
			  	 	
		return $code;
         
	}


			   
//************************  allLoanPaid($person)  ******************************/	
	public function allLoanPaid($person)
	{    
                $bool=true;
		  $result=LoanOfMoney::model()->isPaid($person);
			
			 if(isset($result))
			  {  $loan_paid=$result->getData();//return a list of  objects
			           
			      foreach($loan_paid as $l)
			       {			   
					  if($l->paid == 0)
					       $bool=false;
					}  
			   }	 					 
			
		return $bool;
         
	}


//return total deduction over gross_salary
public function getTaxes($id_pay_set, $gross_salary)
  {
  	     
$acad=Yii::app()->session['currentId_academic_year']; 

     $deduction=0;
  	 $total_deduction=0;
  	 
  	  $sql__ = 'SELECT id_taxe FROM payroll_setting_taxes WHERE id_payroll_set='.$id_pay_set;
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						     { 
						     	  $deduction = 0;
						     	  
						     	  $sql1 = 'SELECT taxe_value FROM taxes WHERE id='.$r['id_taxe'];
															
								  $command1 = Yii::app()->db->createCommand($sql1);
								  $result1 = $command1->queryAll(); 
																       	   
								     foreach($result1 as $r1)
								         $deduction = ( ($gross_salary * $r1['taxe_value'])/100);
								     
								  $total_deduction = $total_deduction + $deduction;
							  }
								  
						 }
	  	     
  	  return $total_deduction;
  	
  }

  	
  	

//************************  personHasLoan($person,$month)  ******************************/	
//return the total amount for this month
public function personHasLoan($person,$month)
	{    
                $sum=0;
		  $result=LoanOfMoney::model()->hasLoan($person,$month);
			
			 if(isset($result))
			  {  $loan=$result->getData();//return a list of  objects
			           
			      foreach($loan as $l)
			       {			   
					   $sum= $sum + $l->amount;
					}  
			   }	 					 
			
		return $sum;
         
	}

     // Export to CSV 
        public function behaviors() {
           return array(
               'exportableGrid' => array(
                   'class' => 'application.components.ExportableGridBehavior',
                   'filename' => Yii::t('app','loan.csv'),
                   'csvDelimiter' => ',',
                   ));
        }

    	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return LoanOfMoney the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=LoanOfMoney::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param LoanOfMoney $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='loan-of-money-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
