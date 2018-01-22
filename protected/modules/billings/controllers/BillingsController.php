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




class BillingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    
    
    public $back_url='';
    
        public $student_id; 
	public $is_b_check; 
	public $old_balance;
	public $old_student;
	public $fee_period;
	public $old_fee_period;
	public $old_amount_to_pay;
	public $old_amount_pay;
	public $remain_balance;
	
	
	public $applyLevel;	
	public $previous_level;
		
	public $id_income_desc;
	public $recettesItems = 0;
	 public $part; 
	public $month_ =0;
	public $status_ = 1;
	public $internal=0;
	
	public $id_reservation;
	public $amount_reservation;
	public $reservation = false;				     
	
	public $message_paymentMethod=false;
	public $message_datepay=false;
	public $message_paymentAllow=true;
	public $message_positiveBalance=false;
	public $message_2paymentFeeDatepay=false;
	public $message_fullScholarship=false;
	public $message_scholarship=false;
	public $full_scholarship = false;
	public $special_payment = false;
	
	public $is_pending_balance = false;
	
	
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
		$acad=Yii::app()->session['currentId_academic_year'];
		
		
		if(($id==0)||($id==''))
		{
			 $model = new Billings;
			 
		}
	  else
	    {	
		   $modelBilling = $this->loadModel($id);
           $status = 0;
         
		
		if(isset($_POST['Billings']['recettesItems'])){
                $this->recettesItems = $_POST['Billings']['recettesItems'];
                
                
                
                if($this->recettesItems ==  0)     
					 $status = 1;					              
				elseif($this->recettesItems ==  1)     
					   $status = 0;
			
			$condition_fee_status = 'fl.status='.$status.' AND ';	
				          	
                   $last_id = Billings::model()->getLastTransactionID($modelBilling->student, $condition_fee_status, $acad);
					   
					   if($last_id==null)
					     $last_id = $id;
            }else{
                    $condition_fee_status = 'fl.status='.$this->status_.' AND '; 
                      //return an Integer (id)
					$last_id = Billings::model()->getLastTransactionID($modelBilling->student, $condition_fee_status, $acad);

		               if(isset($_GET['ri']))
					   {         
					       if($_GET['ri']==0)
					         {  $this->recettesItems =  0;     
					         	$status = 1;
					         	$last_id = $_GET['id'];					              
					          }
					        elseif($_GET['ri']==1)
					          { $this->recettesItems =  1;     
					          	  $status = 0;
					          	  $last_id = $_GET['id'];
					          	 }
					   }
					   
					   
					   if($last_id==null)
					     $last_id = $id;
                   }
            
                 $model = $this->loadModel($last_id);
	       }
	       
		$this->render('view',array(
			'model'=>$model,
			 
		));
	
	
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	 {
		 
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
		
		$model=new Billings;
		
		$reservationInfo = new Reservation;
		
		$this->message_paymentAllow=true;
		$this->message_positiveBalance=false;
		$this->message_2paymentFeeDatepay=false;
		
		$this->full_scholarship = false;
		$this->special_payment = false;
		
		$this->is_pending_balance =false;
		
		$level= 0;
		
		//$this->status_ = 1;
		 
		
		if(isset($_POST['Billings']['recettesItems']))
		  { $this->recettesItems = $_POST['Billings']['recettesItems'];
		       $this->fee_period ='';
		       $model->setAttribute('fee_period',0);
		   }
		else
		     {
		     	 if(isset($_GET['ri']) )
		     	   $this->recettesItems = $_GET['ri']; 
		       }
		
		if($this->recettesItems==0)
		    {
		        $this->status_ = 1;
		 
		      }
		   elseif($this->recettesItems==1)
		    {
		        $this->status_ = 0;
		
		      }
		   elseif($this->recettesItems==2)
		    {
		        $this->redirect(array('/billings/otherIncomes/create?ri=2&from=b'));
		
		      }
		    elseif($this->recettesItems==3)
		    {
		        $this->redirect(array('/billings/enrollmentIncome/create?part=rec&ri=3&from=b'));
		
		      }
		    elseif($this->recettesItems==4)
		    {
		        $this->redirect(array('/billings/reservation/create?part=rec&ri=4&from=b'));
		
		      }   
     

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
		 
		 
		if(isset($_POST['Billings']))
		 {
		 	
		 	
								    
			 $this->student_id = Yii::app()->session['Student_billings'];
			 
			 $model->attributes=$_POST['Billings'];
			 
			 
			 //get level for this student
		    if($model->student!=null)
		      $level=$this->getLevelByStudentId($model->student,$acad_sess)->id;

			 
			 if($model->student != $this->student_id)
			   {  
			     	 
			   	      //gad si elev la gen balans ane pase ki poko peye
	   	                 $modelPendingBal=PendingBalance::model()->findAll(array('select'=>'id, balance',
												 'condition'=>'student=:stud AND is_paid=0 AND academic_year=:acad',
												 'params'=>array(':stud'=>$model->student,':acad'=>$previous_year),
										   ));
				//si gen pending, ajoutel nan lis apeye a			
						if( (isset($modelPendingBal))&&($modelPendingBal!=null) ){
							  foreach($modelPendingBal as $bal)
							     {			     	 
									$this->is_pending_balance =true;
									
									$criteria = new CDbCriteria(array('alias'=>'f', 'order'=>'date_limit_payment','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'fl.fee_label LIKE("Pending balance") AND fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
									
							     }
							     
						  }
						else
						   {
						   	$this->is_pending_balance =false;
						   	
						   	$criteria = new CDbCriteria(array('alias'=>'f', 'order'=>'date_limit_payment','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'fl.fee_label NOT LIKE("Pending balance") AND fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
						   	
						   	}
						
						$data_fees = Fees::model()->findAll($criteria);
						if($data_fees!=null)
						 {  
						 	foreach($data_fees as $fee)
						 	 {     
						 	 	$fee_ = $fee->id;
						 	 	
						 	 	 $modelBillings_balance0=Billings::model()->findByAttributes(array('student'=>$model->student,'fee_period'=>$fee_,'academic_year'=>$acad_sess, 'balance'=>0 ),array('order'=>'id DESC'));
						            
							     if($modelBillings_balance0==null)
							 	  { $this->fee_period = $fee_;
										 	    //$model->fee_period = $fee_;
									$model->setAttribute('fee_period', $fee_);
							 	 
							 	 	break;
							 	  }
						 	  
						 	  }
						 	 	
						   }
						 else
						  {  $this->fee_period = '';
						  
						  }
								 	
					   
								
		     	
					$this->student_id= $model->student;
					
					  unset(Yii::app()->session['Student_billings']);
		                      Yii::app()->session['Student_billings'] = $this->student_id;
			    }
			  else
			   {
			   	   //$this->fee_period = $model->fee_period;
			   	      
			   	      //gad si elev la gen balans ane pase ki poko peye
	   	                 $modelPendingBal=PendingBalance::model()->findAll(array('select'=>'id, balance',
												 'condition'=>'student=:stud AND is_paid=0 AND academic_year=:acad',
												 'params'=>array(':stud'=>$this->student_id,':acad'=>$previous_year),
										   ));
				//si gen pending, ajoutel nan lis apeye a			
						if( (isset($modelPendingBal))&&($modelPendingBal!=null) ){
							  foreach($modelPendingBal as $bal)
							     { 
									$this->is_pending_balance =true;
									
									$criteria = new CDbCriteria(array('alias'=>'f', 'order'=>'date_limit_payment','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'fl.fee_label LIKE("Pending balance") AND fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
									
							     }
						   }
						 else
						   {
						   	   $this->is_pending_balance =false;
						   	   
						   	   $criteria = new CDbCriteria(array('alias'=>'f', 'order'=>'date_limit_payment','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'fl.fee_label NOT LIKE("Pending balance") AND fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
						   	
						   	}

						
						$data_fees = Fees::model()->findAll($criteria);
						if($data_fees!=null)
						  {  
						  	    if(isset($_POST['Billings']['fee_period']))
						  	      { //$this->fee_period = $model->fee_period;
						  	      
						  	          
						  	          
						  	         $this->fee_period = $_POST['Billings']['fee_period'];
						  	        
						  	        if($this->fee_period =='')
						  	          {
						  	          	foreach($data_fees as $fee)
									 	 { 
									 	 		$fee_ = $fee->id;
									 	 		
									 	 	 $modelBillings_balance0=Billings::model()->findByAttributes(array('student'=>$model->student,'fee_period'=>$fee_,'academic_year'=>$acad_sess, 'balance'=>0 ),array('order'=>'id DESC'));
									            
										     if($modelBillings_balance0==null)
										 	  { 
									 	  	
										 	  	$this->fee_period = $fee_;
										 	    //$model->fee_period = $fee_;
										 	    $model->setAttribute('fee_period', $fee_);
										 	 	break;
										 	  }
									 	  
									 	   }
								 	   
						  	          	}
						  	          	
						  	       
						  	       
						  	       }
						  	    else
						  	      {  
						  	      	foreach($data_fees as $fee)
								 	 { 
								 	 	 $modelBillings_balance0=Billings::model()->findByAttributes(array('student'=>$model->student,'fee_period'=>$fee->id,'academic_year'=>$acad_sess, 'balance'=>0 ),array('order'=>'id DESC'));
								           
									     if($modelBillings_balance0==null)
									 	  { 
									 	  	
									 	  	$this->fee_period = $fee->id;
									 	    $model->fee_period = $fee->id;
									 	 	break;
									 	  }
								 	  
								 	   }
								 	   
			
								 	   
						  	      	}
						 	      	
						  	}
						else
						 { $model->fee_period = '';
						     //$this->fee_period = $model->fee_period;
						  
						   }
						     
		          }
			 			 
				
				$last_payment_transaction_fee_period =null;
						$last_fee_paid = null;				
				
			   
							 if(($this->student_id !='')&&($this->fee_period !=''))
								 {
					                 $this->message_positiveBalance = false;
					                 
					                 
					                 
					             //gad si gen rezevasyon   
					                 //return an array(id, amount) or null value
										$deja_peye = Reservation::model()->getNonCheckedReservation($this->student_id, $previous_year);				  
										if( ($deja_peye==null)||($deja_peye==0) )
										  $deja_peye = 0;
										else
										   {  foreach($deja_peye as $r)
                                                { $this->amount_reservation = $r["amount"];
                                                   $this->id_reservation = $r["id"];
                                                  }
                                                 
										   	    $this->reservation = true;
										      
										     }
				                   //-------------------------
				                   
				                   
				                   
				                   
					                 
								   //	$to_pay = Fees::model()->FindByAttributes(array('id'=>$this->fee_period));
								   		$to_pay = Fees::model()->Find(array('alias'=>'f', 'join'=>'inner join fees_label fl on(f.fee=fl.id)', 'condition'=>'f.id='.$this->fee_period.' AND fl.status='.$this->status_));
								   	  
									  
								     	
								   	  
						 if($to_pay!=null) 
							{	  
							      
								   	  
								   	  $student = $this->student_id;
								   	  $date_lim = $to_pay->date_limit_payment;
						              $new_balance = 0;
						              
						              $condition_fee_status = 'fl.status='.$this->status_.' AND '; 
									
									//return "id", "amount_pay" and "balance"
									$checkForBalance = Billings::model()->checkForBalance($this->student_id, $this->fee_period, $this->status_, $acad_sess);
								
							   if($checkForBalance != null)
								 {     
								   //foreach($checkForBalance_ as $checkForBalance)
								 	// {  
								 	 	if($checkForBalance['amount_pay']!=0)
									       { 
										      
									       	  $this->remain_balance = $checkForBalance['balance'];
									       }
									      else
									       {
									    	        $amount = 0;
											                	 
												                	 $modelFee = Fees::model()->findByPk($this->fee_period);
												                	 
												                	  //check if student is scholarship holder
														           	  $model_scholarship = Persons::model()->getIsScholarshipHolder($this->student_id,$acad_sess);    
														           	  
														           	  $konte =0;
																	  $amount = 0;	
																		$percentage_pay = 0;
																		 $porcentage_level = 0; //mwens ke 100%
																		  $this->internal=0;
                                                                       $partner_repondant = NULL;																		
																	  $premye_fee = NULL;
																			          if($model_scholarship == 1) //se yon bousye
																			           {  //tcheke tout fee ki pa null nan bous la
																							   $notNullFee = ScholarshipHolder::model()->feeNotNullByStudentId($this->student_id,$acad_sess);
																			           	      $notNullFee = $notNullFee->getData();
																						   if($notNullFee!=NULL)
																							{																								
																							  foreach($notNullFee as $scholarship)
																			           	    	{ $konte++;
																			           	    	  
																			           	    	  if(isset($scholarship->fee) )
																			           	    	   {
																			           	    	     if($scholarship->fee == $modelFee->id)
																			           	    	      { 
																			           	    	    	$percentage_pay = $scholarship->percentage_pay;
																										$partner_repondant = $scholarship->partner;
																		           	                    
																									   if(($partner_repondant==NULL))
																									    {	$amount = $modelFee->amount - (($modelFee->amount * $percentage_pay)/100) ;
																		           	                    
																											 if(($percentage_pay==100))
																											  { $this->full_scholarship = true;
																										          $porcentage_level = 1; //100%
																												   $this->internal=1;
																												 $partner_repondant = $scholarship->partner;
																											  }
																									     
																										  }
																										 else
																											  $amount = $modelFee->amount;
																			           	    	      }
																			           	    	      
																			           	    	    }
																								   
																			           	    	 }
																								 
																								if((($konte>0)&&($amount==0))&&(!$this->full_scholarship))
																				           	    	  $amount = $modelFee->amount;
																							}
																						   else
																						     {
																								 // $this->full_scholarship = true;
																								 
																								 //fee ka NULL tou
																								  $check_partner=ScholarshipHolder::model()->getScholarshipPartnerByStudentIdFee($this->student_id,NULL,$acad_sess);
																								  //$porcentage_level = 1; //100%
																								  //$percentage_pay=100;
																								  
																								   if($check_partner!=NULL)
																								   {  $check_partner = $check_partner->getData();
																							             foreach($check_partner as $cp)
																										   {   $partner_repondant = $cp->partner;
																										      $percentage_pay = $cp->percentage_pay;
																										         break;
																										   }
																								   }
																								   
																								       if(($percentage_pay==100))
																											  { $this->full_scholarship = true;
																										          $porcentage_level = 1; //100%
																												   $this->internal=1;
																												 
																											  }
																								       else
																								       {			  

																								   if(($partner_repondant==NULL))
																								      {  $amount = $modelFee->amount - (($modelFee->amount * $percentage_pay)/100) ;
																								         $this->internal=1;
																									  }
																								   else
																								      $amount = $modelFee->amount;
																								       }
																							 }
																			           	    	 
																			           	    
																			           	 }
																			           elseif($model_scholarship == 0)   //se pa yon bousye
																					     $amount = $modelFee->amount;
							           	  

														             //$this->remain_balance = $amount ;
														             
														       //etap 2
														            //gade si denye peman gen balans (-) nan tab billins lan
															       //return an Integer (id)
																  $last_payment_transaction = Billings::model()->getLastTransactionID($this->student_id, $condition_fee_status, $acad_sess);
																  
																 if($last_payment_transaction!=null)
																  {
																	  
																	  //return "id", "amount_pay" and "balance"
									                                  $getPreviousFeeBalance = Billings::model()->getPreviousFeeBalance($this->student_id, $modelFee->level, $modelFee->date_limit_payment, $acad_sess);
								
												                       if($getPreviousFeeBalance != null)
													                       {     
														                        if($getPreviousFeeBalance['balance']>0)
														                           $this->message_positiveBalance = true;
														       
													                       }	
													                       	
												 				    $modelBillings_last_payment=Billings::model()->findByPk($last_payment_transaction);
																       if($modelBillings_last_payment->balance <= 0)
																          {  
																          
																          
																          	$this->remain_balance = $amount + $modelBillings_last_payment->balance;
																          	   if($this->remain_balance <= 0)
										                                           { $this->special_payment = true;
										                                              
										                                               $model->setAttribute('amount_pay', $amount );
										                                             }
																          	   
																          	}
																       elseif($modelBillings_last_payment->balance == $checkForBalance['balance'])
							                                                  $this->remain_balance = $checkForBalance['balance'];
							                                                else
																               $this->message_positiveBalance = true;
							                                                    									          
																   }
																 else
																   {
																   	   $this->remain_balance = $amount;
																   	 }

														             
									    	
									          	}
								    
								    
											    if(($this->remain_balance <= 0) )//if(($this->remain_balance <= 0)&&($this->remain_balance!='') )
													$this->message_paymentAllow = false;
								
								           
								        //  break;
								        
								        // }//end foreach checkbalance
								       
								         
								     }
								   else
								     {     
										  $amount = 0;
												                	 
												                	 $modelFee = Fees::model()->findByPk($this->fee_period);
												                
												                //si se pending balance
												                if($modelFee->fee0->fee_label=="Pending balance")
												                 {
												                 	 //gad si elev la gen balans ane pase ki poko peye
																		$modelPendingBal=PendingBalance::model()->findAll(array('select'=>'id, balance',
																			'condition'=>'student=:stud AND is_paid=0 AND academic_year=:acad',
																			'params'=>array(':stud'=>$this->student_id,':acad'=>$previous_year),
																			));
																		//si gen pending, ajoutel nan lis apeye a			
																		if( (isset($modelPendingBal))&&($modelPendingBal!=null) )
																		 {
															
																		   foreach($modelPendingBal as $bal)
																			 {	
																			 	$this->remain_balance =  $bal->balance;
																			 	
																			 	$this->is_pending_balance =true;
																			 }
																		 }	
												                 	
												                 	
												                  }
												                else
												                 {	 
												                	  $this->is_pending_balance =false;
												                	  
												                	  //check if student is scholarship holder
														           	  $model_scholarship = Persons::model()->getIsScholarshipHolder($this->student_id,$acad_sess);    
														           	  
														           	  $konte =0;
																	  $amount = 0;	
																		$percentage_pay = 0;
																		 $porcentage_level = 0; //mwens ke 100%
																		 $this->internal=0;
                                                                   $partner_repondant = NULL;																		
																	  $premye_fee = NULL;
																			          if($model_scholarship == 1) //se yon bousye
																			           {  //tcheke tout fee ki pa null nan bous la
																							   $notNullFee = ScholarshipHolder::model()->feeNotNullByStudentId($this->student_id,$acad_sess);
																			           	      $notNullFee = $notNullFee->getData();
																						   if($notNullFee!=NULL)
																							{																								
																							  foreach($notNullFee as $scholarship)
																			           	    	{ $konte++;
																			           	    	  
																			           	    	  if(isset($scholarship->fee) )
																			           	    	   {
																			           	    	   	 if($scholarship->fee == $modelFee->id)
																			           	    	      { 
																			           	    	    	$percentage_pay = $scholarship->percentage_pay;
																										$partner_repondant = $scholarship->partner;
																		           	                    
																									    if(($partner_repondant==NULL))
																									     {	$amount = $modelFee->amount - (($modelFee->amount * $percentage_pay)/100) ;
																		           	                    
																											 if(($percentage_pay==100))
																											  { $this->full_scholarship = true;
																										          $porcentage_level = 1; //100%
																												   $this->internal=1;
																												 $partner_repondant = $scholarship->partner;
																											  }
																									     
																										  }
																										 else
																											  $amount = $modelFee->amount;
																			           	    	      }
																			           	    	      
																			           	    	    }
																								   
																			           	    	 }
																								 
																								if((($konte>0)&&($amount==0))&&(!$this->full_scholarship))
																				           	    	  $amount = $modelFee->amount;
																							}
																						   else
																						     {
																								// $this->full_scholarship = true;
																								 
																								 //fee ka NULL tou
																								  $check_partner=ScholarshipHolder::model()->getScholarshipPartnerByStudentIdFee($this->student_id,NULL,$acad_sess);
																								  //$porcentage_level = 1; //100%
																								  //$percentage_pay=100;
																								  
																								   if($check_partner!=NULL)
																								   {  $check_partner = $check_partner->getData();
																							             foreach($check_partner as $cp)
																										   {   $partner_repondant = $cp->partner;
																										      $percentage_pay = $cp->percentage_pay;
																										         break;
																										   }
																								   }
																								   
																								       if(($percentage_pay==100))
																											  { $this->full_scholarship = true;
																										          $porcentage_level = 1; //100%
																												   $this->internal=1;
																												 
																											  }
																								       else
																								       {			  

																								   if(($partner_repondant==NULL))
																								      {  $amount = $modelFee->amount - (($modelFee->amount * $percentage_pay)/100) ;
																								         $this->internal=1;
																									  }
																								   else
																								      $amount = $modelFee->amount;
																								       }
																							 }
																			           	    	 
																			           	    
																			           	 }
																			           elseif($model_scholarship == 0)   //se pa yon bousye
																					     $amount = $modelFee->amount;
							           	  

														             //$this->remain_balance = $amount ;
														             
														       //etap 2
														            //gade si denye peman gen balans (-) nan tab billins lan
															       //return an Integer (id)
																  $last_payment_transaction = Billings::model()->getLastTransactionID($this->student_id, $condition_fee_status, $acad_sess);
																  
																 if($last_payment_transaction!=null)
																  {
																  	
												 				    $modelBillings_last_payment=Billings::model()->findByPk($last_payment_transaction);
																       
																    //return "id", "amount_pay" and "balance"
									                                $getPreviousFeeBalance = Billings::model()->getPreviousFeeBalance($this->student_id, $modelFee->level, $modelFee->date_limit_payment, $acad_sess);
								
												                       if($getPreviousFeeBalance != null)
													                       {     
														                        if($getPreviousFeeBalance['balance']>0)
														                           $this->message_positiveBalance = true;
														       
													                       }	
								                              
																       if($modelBillings_last_payment->balance <= 0)
																          {  
		  														          	
																          	$this->remain_balance = $amount + $modelBillings_last_payment->balance;
																          	  if(($modelBillings_last_payment->balance < 0)&&($this->remain_balance==0))
																          	   {
																          	   	   $this->message_paymentAllow =false;
																          	     	$this->special_payment = true;
																          	     	
										                                              
										                                               $this->remain_balance = $amount;
										                                               $model->setAttribute('amount_pay', $amount );
																          	   	  }
																          	     
																          	     if($this->remain_balance < 0)
										                                           { $this->special_payment = true;
										                                              
										                                               $model->setAttribute('amount_pay', $amount );
										                                             }
																          	}
																         else
																            $this->message_positiveBalance = true;
																          
																          
																          
																          
																   }
																 else
																   {
																   	   $this->remain_balance = $amount;
																   	 }
																   	 
								                         }//fen se pa "Pending balance"

											if(($this->remain_balance <= 0) )//if(($this->remain_balance <= 0)&&($this->remain_balance!='') )
										       $this->message_paymentAllow = false;			             
								       
								       
								       }
								    
								    
								      
							
							  }//end  topay  
								  
								 									 
			
								   		          
								  }
								  
					        
				      //tcheke si elev sa te peye rezevasyon 
					    if($this->reservation == true)
						   {
						   	   $this->remain_balance = $this->remain_balance - $this->amount_reservation;
						   	   
						   	   if($this->remain_balance!=0)
								 {
									//$this->message_paymentAllow = false;
									//$this->special_payment = false;
													     
								  }
								else
								  {     $this->message_paymentAllow = false;
										$this->special_payment = true;
										
										//load appropriate info reservation 
										$reservationInfo = Reservation::model()->findByPk($this->id_reservation);
										
										$model->setAttribute('amount_pay', $this->amount_reservation );
										$model->setAttribute('payment_method', $reservationInfo->payment_method );
										$model->date_pay=$reservationInfo->payment_date;
										$model->setAttribute('comments', $reservationInfo->comments );
										$model->setAttribute('reservation_id', $this->id_reservation );
										           	
								   }
								   
						   	 }       
   
								  $model->setAttribute('amount_to_pay', $this->remain_balance );
						
								  
				
				  	
				  			  
								  
			 if(isset($_POST['create']))
              {
                  $save_ok = false;
                          	
				if(($_POST['Billings']['date_pay']!="")&&($_POST['Billings']['date_pay']!='0000-00-00'))
				 {  
				 	$date_pay_ = $_POST['Billings']['date_pay'];
				 	$model->setAttribute('date_pay', $date_pay_);
				 	if($model->payment_method!="")
					  {	
						//tcheke si yo peye fre sa nan date_pay sa deja
						$modelBillings_datePay=Billings::model()->findByAttributes(array('student'=>$this->student_id,'fee_period'=>$this->fee_period,'academic_year'=>$acad_sess, 'date_pay'=>$date_pay_),array('order'=>'id DESC'));
						            
					 if($modelBillings_datePay==null)
						{
						
							$condition_fee_status = 'fl.status='.$this->status_.' AND ';
							//return an Integer (id)
							$last_payment_transaction_id = Billings::model()->getLastTransactionID($this->student_id, $condition_fee_status, $acad_sess);

							
							$fee_period_r = $_POST['Billings']['fee_period'];
							$amount_pay = $model->amount_pay; 
							//$acad_sess_year=$model->academic_year;
							
							//$to_pay = Fees::model()->FindByAttributes(array('id'=>$fee_period_r));
							
							if($this->special_payment)
							  $amount_2p = $model->amount_pay;
							else
							   $amount_2p = $model->amount_to_pay;
											   
						
						//tcheke balans pou peryod sa lap peye pou li a
						$there_is_balance=Billings::model()->checkForBalance($model->student, $fee_period_r, $this->status_, $acad_sess);
	
						if(isset($there_is_balance)&&($there_is_balance!=null))
						  { 
						  	$new_model_billing =$this->loadModel($there_is_balance->id);
						  	
						  	$amount_to_pay = 0;
						  	 
						  	  if($to_pay!=null)
                                 $amount_to_pay = $amount_2p;
									
								if($new_model_billing->amount_pay==0)// update this record made by SYGES
								 {
								 	
								  	   if($this->special_payment)
								  	     {    if( ($amount_pay-$this->remain_balance) == 0)
										  	    $balance = 0;
										  	 else
										  	   $balance = $this->remain_balance;// + $amount_pay;
										  	
								  	      }
								  	   else
								  	      $balance = $amount_to_pay - $amount_pay;  
								  	   	
								  	   	    
								  	   	  $payment_method = $model->payment_method;
								  	   	  $comments = $model->comments;
								  	   	  $date_pay = $model->date_pay;
								  	   	  
								  	   	  if($balance==0)
								  	   	    $new_model_billing->setAttribute('fee_totally_paid', 1);
								  	   	       
								  	   	      
								  	   	   
								  	   	   $new_model_billing->setAttribute('amount_to_pay', $amount_to_pay);
								  	   	   $new_model_billing->setAttribute('amount_pay', $amount_pay);
								  	   	   $new_model_billing->setAttribute('balance', $balance);
								  	   	   $new_model_billing->setAttribute('date_pay', $date_pay);
								  	   	   
								  	   	   $new_model_billing->setAttribute('payment_method', $payment_method);
								  	   	   $new_model_billing->setAttribute('comments', $comments);
								  	   	   $new_model_billing->setAttribute('academic_year', $acad_sess);
					                        
					                         $new_model_billing->setAttribute('updated_by', Yii::app()->user->name );
							                 $new_model_billing->setAttribute('date_updated', date('Y-m-d'));
							                        
								  	
								  	  $ID = '';
								  	      
								  	   if($new_model_billing->save())
								         {  
								         	//fee_totally_paid=1 pou tranzaksyon ki vin anvan sa
								         	//$model_billing_anvan =$this->loadModel($last_payment_transaction_id);
								         	     $command_ = Yii::app()->db->createCommand();
								                 $command_->update('billings', array('fee_totally_paid'=>1 ), 'id=:ID', array(':ID'=>$last_payment_transaction_id,));
								         	
								         	// fee_totally_paid=1 pou tout lot tranzaksyon fee sa pou ane a
								         	if($balance==0)
								         	  {  $command = Yii::app()->db->createCommand();
								                 $command->update('billings', array('fee_totally_paid'=>1 ), 'academic_year=:year AND fee_period=:fee AND student=:stud', array(':year'=>$acad_sess, ':fee'=>$fee_period_r, ':stud'=>$model->student));
								                 
								                 if($this->is_pending_balance==true) //update pending_balance to paid
								  	   	         {
								  	   	         	$command11 = Yii::app()->db->createCommand();
								                 $command11->update('pending_balance', array('is_paid'=>1 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$model->student));
								  	   	          }
								         	  
								         	     }
								         	
								         	$model->balance = $new_model_billing->balance;
								         	$ID = $new_model_billing->id;
								         	$save_ok = true;  
								          }
								          
								  }
								else
								   {	
								  	   	  if($new_model_billing->balance > 0)
								  	   	    {
								  	   	    	if($this->special_payment)
										  	      {  if( ($amount_pay-$this->remain_balance) == 0)
										  	             $balance = 0;
										  	         else
										  	            $balance = $this->remain_balance;// + $amount_pay;
										  	       }
										  	    else
										  	      $balance = $new_model_billing->balance - $amount_pay;
								  	   	    }
								  	   	  else
								  	   	    {
								  	   	      if($this->special_payment)
										  	     {  if( ($amount_pay-$this->remain_balance) == 0)
										  	             $balance = 0;
										  	        else
										  	            $balance = $this->remain_balance;// + $amount_pay;
										  	            
										  	      }
										  	    else
										  	      $balance = $new_model_billing->balance + $amount_pay;
								  	   	    }
								  	   	  
								  	   	  $payment_method = $model->payment_method;
								  	   	  $comments = $model->comments;
								  	   	  $date_pay = $model->date_pay;
								  	   	  
								  	   	   if($balance==0)
								  	   	     $model->setAttribute('fee_totally_paid', 1);
								  	   	   
								  	   	   $model->setAttribute('amount_to_pay', $amount_to_pay); 
								  	   	   $model->setAttribute('amount_pay', $amount_pay);
								  	   	   $model->setAttribute('balance', $balance);
								  	   	   $model->setAttribute('date_pay', $date_pay);
								  	   	   
								  	   	   $model->setAttribute('payment_method', $payment_method);
								  	   	   $model->setAttribute('comments', $comments);
								  	   	   $model->setAttribute('academic_year', $acad_sess);
					                        
					                         $model->setAttribute('created_by', Yii::app()->user->name );
							                 $model->setAttribute('date_created', date('Y-m-d'));
							                        
								  	
								  	  
								  	  $ID = '';
								  	      
								  	   if($model->save())
								         {  
								         	//fee_totally_paid=1 pou tranzaksyon ki vin anvan sa
								         	//$model_billing_anvan =$this->loadModel($last_payment_transaction_id);
								         	     $command_ = Yii::app()->db->createCommand();
								                 $command_->update('billings', array('fee_totally_paid'=>1 ), 'id=:ID', array(':ID'=>$last_payment_transaction_id,));

                                           // fee_totally_paid=1 pou tout lot tranzaksyon fee sa pou ane a
								         	if($balance==0)
								         	  {  $command = Yii::app()->db->createCommand();
								                 $command->update('billings', array('fee_totally_paid'=>1 ), 'academic_year=:year AND fee_period=:fee AND student=:stud', array(':year'=>$acad_sess, ':fee'=>$fee_period_r, ':stud'=>$model->student));
								         	  
								         	    if($this->is_pending_balance==true) //update pending_balance to paid
								  	   	         {
								  	   	         	$command11 = Yii::app()->db->createCommand();
								                 $command11->update('pending_balance', array('is_paid'=>1 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$model->student));
								  	   	          }
								         	    
								         	   }

								         	
								         	$ID = $model->id;
								         	$save_ok = true;  
								          } 
								          
								    }
						  	        
						   }
						else
						  {
						     $amount_to_pay =0;
						     
						     if($to_pay!=null)
                                 $amount_to_pay = $amount_2p;
						    
						            if($this->special_payment)
										 {  if( ($amount_pay-$this->remain_balance) == 0)
										  	    $balance = 0;
										  	 else
										  	   $balance = $this->remain_balance;// + $amount_pay;
									  	   
										  }
									 else
										$balance = $amount_to_pay - $amount_pay;
								  	   	  
								  	   	  $payment_method = $model->payment_method;
								  	   	  $comments = $model->comments;
								  	   	  $date_pay = $model->date_pay;
								  	   	  
								  	   	   if($balance==0)
								  	   	    $model->setAttribute('fee_totally_paid', 1);
								  	   	    
								  	   	   $model->setAttribute('amount_to_pay', $amount_to_pay);
								  	   	   $model->setAttribute('amount_pay', $amount_pay);
								  	   	   $model->setAttribute('balance', $balance);
								  	   	   $model->setAttribute('date_pay', $date_pay);
								  	   	   
								  	   	   $model->setAttribute('payment_method', $payment_method);
								  	   	   $model->setAttribute('comments', $comments);
								  	   	   $model->setAttribute('academic_year', $acad_sess);
					                        
					                         $model->setAttribute('created_by', Yii::app()->user->name );
							                 $model->setAttribute('date_created', date('Y-m-d'));
							              
							              //si t gen rezevasyon   
						        	        if($this->reservation==true)
						        	          { if( ($this->message_paymentAllow == true)&&($this->special_payment == false) )
						        	          	  $model->setAttribute('reservation_id', $this->id_reservation);
						        	           }
						     
						     
						$ID = '';
			                      
						      if($model->save())
						        { 
						        	       //si t gen rezevasyon   #################################
						        	        if($this->reservation==true)
						        	          {  
						        	          /*	if( ($this->message_paymentAllow == true)&&($this->special_payment == false) )
						        	          	  { //anrejistre reservation ki te fet la
						        	          	    //load appropriate info reservation 
										               $reservationInfo = Reservation::model()->findByPk($this->id_reservation);
										               
										               $modelFeeInfo = Fees::model()->findByPk($this->fee_period);
										               
										               $__balance = $modelFeeInfo->amount-$this->amount_reservation;
										               
										               $model_new = new Billings;
										               
										               if($model->balance==0)
								  	   	                 $model_new->setAttribute('fee_totally_paid', 1);
								  	   	               else
								  	   	                 $model_new->setAttribute('fee_totally_paid', 0);
								  	   	    
														$model_new->setAttribute('student', $model->student );
														$model_new->setAttribute('fee_period', $model->fee_period );
														$model_new->setAttribute('amount_to_pay', $modelFeeInfo->amount );
														$model_new->setAttribute('amount_pay', $this->amount_reservation );
														$model_new->setAttribute('balance', $__balance );
														$model_new->setAttribute('payment_method', $reservationInfo->payment_method );
														$model_new->date_pay=$reservationInfo->payment_date;
														$model_new->setAttribute('comments', $reservationInfo->comments );
														$model_new->setAttribute('academic_year', $acad_sess);
														
														 $model_new->setAttribute('created_by', Yii::app()->user->name );
							                             $model_new->setAttribute('date_created', date('Y-m-d'));
														
						        	          	         $model_new->save();
						        	          	    
						        	          	   }
						        	          	  */
						        	          	 $command_11 = Yii::app()->db->createCommand();
								                 $command_11->update('reservation', array('already_checked'=>1 ), 'id=:ID', array(':ID'=>$this->id_reservation,));
								                 
						        	            }
						        	            
						        	          //##########################################
						        	       
						        	        //fee_totally_paid=1 pou tranzaksyon ki vin anvan sa
								         	//$model_billing_anvan =$this->loadModel($last_payment_transaction_id);
								         	     $command_ = Yii::app()->db->createCommand();
								                 $command_->update('billings', array('fee_totally_paid'=>1 ), 'id=:ID', array(':ID'=>$last_payment_transaction_id,));

                                          // fee_totally_paid=1 pou tout lot tranzaksyon fee sa pou ane a
								         	if($balance==0)
								         	  {  $command = Yii::app()->db->createCommand();
								                 $command->update('billings', array('fee_totally_paid'=>1 ), 'academic_year=:year AND fee_period=:fee AND student=:stud', array(':year'=>$acad_sess, ':fee'=>$fee_period_r, ':stud'=>$model->student));
								         	  
								         	     if($this->is_pending_balance==true) //update pending_balance to paid
								  	   	         {
								  	   	         	$command11 = Yii::app()->db->createCommand();
								                 $command11->update('pending_balance', array('is_paid'=>1 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$model->student));
								  	   	          }
								  	   	          
								         	   }


                                        $ID = $model->id;
						        	   $save_ok = true;
						         }
						 
						  }     
			                      
			                  
			                       
							 	if($save_ok)
									{   
										//update tab balance lan
										
				                         $modelBalance=Balance::model()->findByAttributes(array('student'=>$model->student));
					                            if($modelBalance!=null)
						                           {   
						                           	 if($this->status_ == 1) 
						                           	  {
							                           	  if($model->balance == 0) //delete  $modelBalance
								                            {	
								                            	$new_balance_1= 0;
								                            	//$modelBalance->delete();
								                            	if($modelBalance->balance >= $model->amount_pay)
								                            	  { $new_balance_1= $modelBalance->balance - $model->amount_pay;
								                            	
								                            	     $modelBalance->setAttribute('balance',  $new_balance_1);
															       	    
															       	     $modelBalance->save();
								                            	  }
								                            	else
								                            	  {   $new_balance_1= 0;
								                            	
								                            	     $modelBalance->setAttribute('balance',  $new_balance_1);
															       	    
															       	     $modelBalance->save();
								                            	  	
								                            	  	}
								                          
								                             }
								                            elseif($model->balance != 0) //$model->balance se nouvo balans lan
								                            {  
													       	    $new_balance_1= 0;
								                            	//$modelBalance->delete();
								                            	if($modelBalance->balance >= $model->amount_pay)
								                            	   $new_balance_1= $modelBalance->balance - $model->amount_pay;
								                            	//else
								                            	//   $new_balance_1= $modelBalance->balance + $model->amount_pay;
								                            	
													       	    $modelBalance->setAttribute('balance',  $new_balance_1);
													       	    
													       	     $modelBalance->save();
								                            	
								                              }	 
								                              
						                           	   }
						                           	 elseif($this->status_ == 0)
						                           	   {
						                           	   	 if($model->balance != 0) //$model->balance se nouvo balans lan
								                            {  
													       	   
													       	   // on ajoute 
								                            	  
															       	    $new_balance1= $modelBalance->balance + $model->balance;
															       	    $modelBalance->setAttribute('balance',  $new_balance1);
															       	    
															       	     $modelBalance->save();
								                            	   
								                              }	 
								                              
						                           	   	 }
														
														
						                           }
						                         else // add new balance record in balance table
						                          {   
						                          		  
							                          if($model->balance != 0) 
						                           	    {
							                           	  	$modelBalance= new Balance;
							                              
							                              $modelBalance->setAttribute('student',$model->student);
							                              $modelBalance->setAttribute('balance', $model->balance);
							                              $modelBalance->setAttribute('date_created', date('Y-m-d'));
							                              
							                               $modelBalance->save();
						                           	    }
							                      
						                              			                          	
						                          }
						                         
						                         
				                      					
										$this->redirect(array('view','id'=>$ID,'ri'=>$this->recettesItems,'part'=>'rec','from'=>'stud'));
										
										}  
					
			                    }
					         else
					           $this->message_2paymentFeeDatepay=true;
			              
			               }
				         else
				           $this->message_paymentMethod=true;
					 }
					else
			           $this->message_datepay=true;
		           
              }
              
               if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          } 
                          
		}
		
	  else
	    {
	    	if((isset($_GET['id']))&&(isset($_GET['stud'])))
	    	  {
	    	
	    	  	    $this->student_id = $_GET['stud'];
	    	  	    
	    	  	     $model->setAttribute('student',$this->student_id);
			 
			 		$this->fee_period='';
			 
			 //get level for this student
		    if($this->student_id!=null)
		      $level=$this->getLevelByStudentId($this->student_id,$acad_sess)->id;

			 
			 if($model->student != $this->student_id)
			   {  
			     		 //gad si elev la gen balans ane pase ki poko peye
	   	                 $modelPendingBal=PendingBalance::model()->findAll(array('select'=>'id, balance',
												 'condition'=>'student=:stud AND is_paid=0 AND academic_year=:acad',
												 'params'=>array(':stud'=>$this->student_id,':acad'=>$previous_year),
										   ));
				//si gen pending, ajoutel nan lis apeye a			
						if( (isset($modelPendingBal))&&($modelPendingBal!=null) ){
							  foreach($modelPendingBal as $bal)
							     { 
									$this->is_pending_balance =true;
									
									$criteria = new CDbCriteria(array('alias'=>'f', 'order'=>'date_limit_payment','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'fl.fee_label LIKE("Pending balance") AND fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
									
							     }
						   }
						 else
						   {
						   	   $this->is_pending_balance =false;
						   	   
						   	   $criteria = new CDbCriteria(array('alias'=>'f', 'order'=>'date_limit_payment','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'fl.fee_label NOT LIKE("Pending balance") AND fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
						   	
						   	}
						   	
						   	
						$data_fees = Fees::model()->findAll($criteria);
						if($data_fees!=null)
						 {  
						 	foreach($data_fees as $fee)
						 	 {     
						 	 	$fee_ = $fee->id;
						 	 	
						 	 	 $modelBillings_balance0=Billings::model()->findByAttributes(array('student'=>$model->student,'fee_period'=>$fee_,'academic_year'=>$acad_sess, 'balance'=>0 ),array('order'=>'id DESC'));
						            
							     if($modelBillings_balance0==null)
							 	  { $this->fee_period = $fee_;
										 	    //$model->fee_period = $fee_;
									$model->setAttribute('fee_period', $fee_);
							 	 
							 	 	break;
							 	  }
						 	  
						 	  }
						 	 	
						   }
						 else
						    $this->fee_period = '';
								 	
					   
								
		     	
					$this->student_id= $model->student;
					
					  unset(Yii::app()->session['Student_billings']);
		                      Yii::app()->session['Student_billings'] = $this->student_id;
			    }
			  else
			   {
			   	   //$this->fee_period = $model->fee_period;
			   	    
						 //gad si elev la gen balans ane pase ki poko peye
	   	                 $modelPendingBal=PendingBalance::model()->findAll(array('select'=>'id, balance',
												 'condition'=>'student=:stud AND is_paid=0 AND academic_year=:acad',
												 'params'=>array(':stud'=>$this->student_id,':acad'=>$previous_year),
										   ));
				//si gen pending, ajoutel nan lis apeye a			
						if( (isset($modelPendingBal))&&($modelPendingBal!=null) ){
							  foreach($modelPendingBal as $bal)
							     { 
									$this->is_pending_balance =true;
									
									$criteria = new CDbCriteria(array('alias'=>'f', 'order'=>'date_limit_payment','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'fl.fee_label LIKE("Pending balance") AND fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
									
							     }
						   }
						 else
						   {
						   	   $this->is_pending_balance =false;
						   	   
						   	   $criteria = new CDbCriteria(array('alias'=>'f', 'order'=>'date_limit_payment','join'=>'inner join fees_label fl on(fl.id=f.fee)','condition'=>'fl.fee_label NOT LIKE("Pending balance") AND fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
						   	
						   	}
						   	
						
						$data_fees = Fees::model()->findAll($criteria);
						if($data_fees!=null)
						  {
						  	    if(isset($_POST['Billings']['fee_period']))
						  	      { //$this->fee_period = $model->fee_period;
						  	        
						  	         $this->fee_period = $_POST['Billings']['fee_period'];
						  	        
						  	        if($this->fee_period =='')
						  	          {
						  	          	foreach($data_fees as $fee)
									 	 { 
									 	 		$fee_ = $fee->id;
									 	 		
									 	 	 $modelBillings_balance0=Billings::model()->findByAttributes(array('student'=>$model->student,'fee_period'=>$fee_,'academic_year'=>$acad_sess, 'balance'=>0 ),array('order'=>'id DESC'));
									            
										     if($modelBillings_balance0==null)
										 	  { 
									 	  	
										 	  	$this->fee_period = $fee_;
										 	    //$model->fee_period = $fee_;
										 	    $model->setAttribute('fee_period', $fee_);
										 	 	break;
										 	  }
									 	  
									 	   }
								 	   
						  	          	}
						  	          	
						  	       
						  	       
						  	       }
						  	    else
						  	      {
						  	      	foreach($data_fees as $fee)
								 	 { 
								 	 	 $modelBillings_balance0=Billings::model()->findByAttributes(array('student'=>$model->student,'fee_period'=>$fee->id,'academic_year'=>$acad_sess, 'balance'=>0 ),array('order'=>'id DESC'));
								            
									     if($modelBillings_balance0==null)
									 	  { 
									 	  	
									 	  	$this->fee_period = $fee->id;
									 	    $model->fee_period = $fee->id;
									 	 	break;
									 	  }
								 	  
								 	   }
								 	   
			
								 	   
						  	      	}
						  	}
						else
						 { $model->fee_period = '';
						     //$this->fee_period = $model->fee_period;
						  
						   }
						     
		          }
			 		
			 			 
				
			$last_payment_transaction_fee_period =null;
						$last_fee_paid = null;				
				
			   
							 if(($this->student_id !='')&&($this->fee_period !=''))
								 {
					                 $this->message_positiveBalance = false;
					                 
								   //	$to_pay = Fees::model()->FindByAttributes(array('id'=>$this->fee_period));
								   		$to_pay = Fees::model()->Find(array('alias'=>'f', 'join'=>'inner join fees_label fl on(f.fee=fl.id)', 'condition'=>'f.id='.$this->fee_period.' AND fl.status='.$this->status_));
								   	  
									  
								     	
								   	  
								  if($to_pay!=null)
								    {	  
								  
								   	  
								   	  $student = $this->student_id;
								   	  $date_lim = $to_pay->date_limit_payment;
						              $new_balance = 0;
						              
						              $condition_fee_status = 'fl.status='.$this->status_.' AND '; 
									
									//return "id", "amount_pay" and "balance"
									$checkForBalance = Billings::model()->checkForBalance($this->student_id, $this->fee_period, $this->status_, $acad_sess);
								
							   if($checkForBalance != null)
								 {     
									    if($checkForBalance['amount_pay']!=0)
									       { 
										      
									       	  $this->remain_balance = $checkForBalance['balance'];
									       }
									    else
									       {
									    	        $amount = 0;
											                	 
												                	 $modelFee = Fees::model()->findByPk($this->fee_period);
												                	 
												                	  //check if student is scholarship holder
														           	  $model_scholarship = Persons::model()->getIsScholarshipHolder($this->student_id,$acad_sess);    
														           	  
														           	  $konte =0;
																	  $amount = 0;	
																		$percentage_pay = 0;
																		 $porcentage_level = 0; //mwens ke 100%
																		  $this->internal=0;
                                                                       $partner_repondant = NULL;																		
																	  $premye_fee = NULL;
																			          if($model_scholarship == 1) //se yon bousye
																			           {  //tcheke tout fee ki pa null nan bous la
																							   $notNullFee = ScholarshipHolder::model()->feeNotNullByStudentId($this->student_id,$acad_sess);
																			           	      $notNullFee = $notNullFee->getData();
																						   if($notNullFee!=NULL)
																							{																								
																							  foreach($notNullFee as $scholarship)
																			           	    	{ $konte++;
																			           	    	  
																			           	    	    if(isset($scholarship->fee) )
																			           	    	   {
																			           	    	   if($scholarship->fee == $modelFee->id)
																			           	    	    { 
																			           	    	    	$percentage_pay = $scholarship->percentage_pay;
																										$partner_repondant = $scholarship->partner;
																		           	                    
																									   if(($partner_repondant==NULL))
																									    {	$amount = $modelFee->amount - (($modelFee->amount * $percentage_pay)/100) ;
																		           	                    
																											 if(($percentage_pay==100))
																											  { $this->full_scholarship = true;
																										          $porcentage_level = 1; //100%
																												   $this->internal=1;
																												 $partner_repondant = $scholarship->partner;
																											  }
																									     
																										  }
																										 else
																											  $amount = $modelFee->amount;
																			           	    	    }
																			           	    	    
																			           	    	   }
																								   
																			           	    	 }
																								 
																								if((($konte>0)&&($amount==0))&&(!$this->full_scholarship))
																				           	    	  $amount = $modelFee->amount;
																							}
																						   else
																						     {
																								 // $this->full_scholarship = true;
																								 
																								 //fee ka NULL tou
																								  $check_partner=ScholarshipHolder::model()->getScholarshipPartnerByStudentIdFee($this->student_id,NULL,$acad_sess);
																								  //$porcentage_level = 1; //100%
																								  //$percentage_pay=100;
																								  
																								   if($check_partner!=NULL)
																								   {  $check_partner = $check_partner->getData();
																							             foreach($check_partner as $cp)
																										   {   $partner_repondant = $cp->partner;
																										      $percentage_pay = $cp->percentage_pay;
																										         break;
																										   }
																								   }
																								   
																								       if(($percentage_pay==100))
																											  { $this->full_scholarship = true;
																										          $porcentage_level = 1; //100%
																												   $this->internal=1;
																												 
																											  }
																								       else
																								       {			  

																								   if(($partner_repondant==NULL))
																								      {  $amount = $modelFee->amount - (($modelFee->amount * $percentage_pay)/100) ;
																								         $this->internal=1;
																									  }
																								   else
																								      $amount = $modelFee->amount;
																								       }
																							 }
																			           	    	 
																			           	    
																			           	 }
																			           elseif($model_scholarship == 0)   //se pa yon bousye
																					     $amount = $modelFee->amount;
							           	  

														             //$this->remain_balance = $amount ;
														             
														       //etap 2
														            //gade si denye peman gen balans (-) nan tab billins lan
															       //return an Integer (id)
																  $last_payment_transaction = Billings::model()->getLastTransactionID($this->student_id, $condition_fee_status, $acad_sess);
																  
																 if($last_payment_transaction!=null)
																  {
																	  	
												 				    $modelBillings_last_payment=Billings::model()->findByPk($last_payment_transaction);
																       if($modelBillings_last_payment->balance <= 0)
																          {  
																          
																          
																          	$this->remain_balance = $amount + $modelBillings_last_payment->balance;
																          	   if($this->remain_balance <= 0)
										                                           { $this->special_payment = true;
										                                              
										                                               $model->setAttribute('amount_pay', $amount );
										                                             }
																          	   
																          	}
																       elseif($modelBillings_last_payment->balance == $checkForBalance['balance'])
							                                                  $this->remain_balance = $checkForBalance['balance'];
							                                                else
																               $this->message_positiveBalance = true;
							                                                    									          
																   }
																 else
																   {
																   	   $this->remain_balance = $amount;
																   	 }

														             
									    	
									          }
								    
								    if(($this->remain_balance <= 0) )//if(($this->remain_balance <= 0)&&($this->remain_balance!='') )
										$this->message_paymentAllow = false;
								
								
								     }
								   else
								     {     
										  $amount = 0;
												                	 
												                	 $modelFee = Fees::model()->findByPk($this->fee_period);
												                	 
												                	  //check if student is scholarship holder
														           	  $model_scholarship = Persons::model()->getIsScholarshipHolder($this->student_id,$acad_sess);    
														           	  
														           	  $konte =0;
																	  $amount = 0;	
																		$percentage_pay = 0;
																		 $porcentage_level = 0; //mwens ke 100%
																		 $this->internal=0;
                                                                   $partner_repondant = NULL;																		
																	  $premye_fee = NULL;
																			          if($model_scholarship == 1) //se yon bousye
																			           {  //tcheke tout fee ki pa null nan bous la
																							   $notNullFee = ScholarshipHolder::model()->feeNotNullByStudentId($this->student_id,$acad_sess);
																			           	      $notNullFee = $notNullFee->getData();
																						   if($notNullFee!=NULL)
																							{																								
																							  foreach($notNullFee as $scholarship)
																			           	    	{ $konte++;
																			           	    	  
																			           	    	   if(isset($scholarship->fee) )
																			           	    	   {
																			           	    	    if($scholarship->fee == $modelFee->id)
																			           	    	    { 
																			           	    	    	$percentage_pay = $scholarship->percentage_pay;
																										$partner_repondant = $scholarship->partner;
																		           	                    
																									   if(($partner_repondant==NULL))
																									    {	$amount = $modelFee->amount - (($modelFee->amount * $percentage_pay)/100) ;
																		           	                    
																											 if(($percentage_pay==100))
																											  { $this->full_scholarship = true;
																										          $porcentage_level = 1; //100%
																												   $this->internal=1;
																												 $partner_repondant = $scholarship->partner;
																											  }
																									     
																										  }
																										 else
																											  $amount = $modelFee->amount;
																			           	    	    }
																			           	    	    
																			           	    	   }
																								   
																			           	    	 }
																								 
																								if((($konte>0)&&($amount==0))&&(!$this->full_scholarship))
																				           	    	  $amount = $modelFee->amount;
																							}
																						   else
																						     {
																								// $this->full_scholarship = true;
																								 
																								 //fee ka NULL tou
																								  $check_partner=ScholarshipHolder::model()->getScholarshipPartnerByStudentIdFee($this->student_id,NULL,$acad_sess);
																								  //$porcentage_level = 1; //100%
																								  //$percentage_pay=100;
																								  
																								   if($check_partner!=NULL)
																								   {  $check_partner = $check_partner->getData();
																							             foreach($check_partner as $cp)
																										   {   $partner_repondant = $cp->partner;
																										      $percentage_pay = $cp->percentage_pay;
																										         break;
																										   }
																								   }
																								   
																								       if(($percentage_pay==100))
																											  { $this->full_scholarship = true;
																										          $porcentage_level = 1; //100%
																												   $this->internal=1;
																												 
																											  }
																								       else
																								       {			  

																								   if(($partner_repondant==NULL))
																								      {  $amount = $modelFee->amount - (($modelFee->amount * $percentage_pay)/100) ;
																								         $this->internal=1;
																									  }
																								   else
																								      $amount = $modelFee->amount;
																								       }
																							 }
																			           	    	 
																			           	    
																			           	 }
																			           elseif($model_scholarship == 0)   //se pa yon bousye
																					     $amount = $modelFee->amount;
							           	  

														             //$this->remain_balance = $amount ;
														             
														       //etap 2
														            //gade si denye peman gen balans (-) nan tab billins lan
															       //return an Integer (id)
																  $last_payment_transaction = Billings::model()->getLastTransactionID($this->student_id, $condition_fee_status, $acad_sess);
																  
																 if($last_payment_transaction!=null)
																  {
																  	
												 				    $modelBillings_last_payment=Billings::model()->findByPk($last_payment_transaction);
																       if($modelBillings_last_payment->balance <= 0)
																          {  
		  														          	
																          	$this->remain_balance = $amount + $modelBillings_last_payment->balance;
																          	  if(($modelBillings_last_payment->balance < 0)&&($this->remain_balance==0))
																          	   {
																          	   	   $this->message_paymentAllow =false;
																          	     	$this->special_payment = true;
																          	     	
										                                              
										                                               $this->remain_balance = $amount;
										                                               $model->setAttribute('amount_pay', $amount );
																          	   	  }
																          	     
																          	     if($this->remain_balance < 0)
										                                           { $this->special_payment = true;
										                                              
										                                               $model->setAttribute('amount_pay', $amount );
										                                             }
																          	}
																         else
																            $this->message_positiveBalance = true;
																          
																   }
																 else
																   {
																   	   $this->remain_balance = $amount;
																   	 }

											if(($this->remain_balance <= 0) )//if(($this->remain_balance <= 0)&&($this->remain_balance!='') )
										       $this->message_paymentAllow = false;			             
								       }
								    
								    }
								      
                               
								  
								 									 
			
								   		          
								  }
				
				
				   
				//tcheke si elev sa te peye rezevasyon 
				    if($this->reservation == true)
					   {
					   	   $this->remain_balance = $this->remain_balance - $deja_peye;
					   	 }       
				         
								  $model->setAttribute('amount_to_pay', $this->remain_balance );
						
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
			$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
 
 
$this->is_pending_balance=false;
 
		
		
		    if($_GET['ri'] ==  0)     
					 $this->status_ = 1;					              
				elseif($_GET['ri'] ==  1)     
					   $this->status_ = 0;
					 

		$model=$this->loadModel($id);
		
		$this->message_paymentAllow=true;
		$this->message_positiveBalance=false;
		$this->message_2paymentFeeDatepay=false;
		
         $this->old_balance =0;
         $this->old_student ="";
		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);
        
        $balance_current_record = $model->balance;
        
        $this->old_balance = $model->balance;  //
        $this->old_student = $model->student; //
        $this->fee_period=$model->fee_period;
        $this->old_fee_period = $model->fee_period;
        $this->old_amount_to_pay = $model->amount_to_pay;
        $this->old_amount_pay = $model->amount_pay;
        
        
        $modelFee = Fees::model()->findByPk($model->fee_period);
        //$modelFeeLabel = FeesLabel::model()->findByPk($modelFee->fee);
          if($modelFee->fee0->fee_label=="Pending balance")
            $this->is_pending_balance=true;
          
         
        
	  if(isset($_POST['Billings']))
		{
		    $condition_fee_status = 'fl.status='.$this->status_.' AND ';
		    
			$this->student_id = $this->old_student;//Yii::app()->session['Student_billings'];
			$this->fee_period = $this->old_fee_period;
			 
			 $model->attributes=$_POST['Billings'];
		
					 $this->message_positiveBalance = false;
							
				 if(isset($_POST['update']))
				   {  
					  	 $from="";
					  	  if(isset($_GET['from']))
					  	       $from=$_GET['from'];
					  	 
						 if(($_POST['Billings']['date_pay']!="")&&($_POST['Billings']['date_pay']!='0000-00-00'))
						    {  $model->setAttribute('date_pay',$_POST['Billings']['date_pay'] );
						 	    $date_pay_ = $_POST['Billings']['date_pay'];
						 	  if($model->payment_method!="")
							    {  	 
							  	    $amount_to_pay = 0;
							  	    $model->setAttribute('student',$this->old_student );
							  	 	
							  	  	   $amount_pay = $model->amount_pay; 
									   //$acad_year=$model->academic_year;
									
									   // $to_pay = Fees::model()->FindByPk($this->fee_period);
								 
			                     	          $balance = $model->amount_to_pay - $model->amount_pay;
			                     	          
									  	   	  $payment_method = $model->payment_method;
									  	   	  	
									  	   	  $comments = $model->comments;
									  	   	  if($model->date_pay =='0000-00-00')
									  	   	     $date_pay = date('Y-m-d');
									  	   	  else
									  	   	     $date_pay = $model->date_pay;
									  	   	  
									  	   	    $model= new Billings;
									  	   	    
									  	   	   $model=$this->loadModel($_GET['id']);

    //si old > new =>  ajout (old - new) sur la balance de la table balance
	//si old < new =>  soustr (new - old) sur la balance de la table balance
									  	   	   
									  	   	   if($balance==0)
								  	   	         $model->setAttribute('fee_totally_paid', 1);
								  	   	       else
								  	   	         $model->setAttribute('fee_totally_paid', 0);
								  	   	    
									  	   	   $model->setAttribute('amount_pay', $amount_pay);
									  	   	   $model->setAttribute('balance', $balance);
									  	   	   
									  	   	   $model->setAttribute('payment_method', $payment_method);
									  	   	   $model->setAttribute('comments', $comments);
									  	   	   $model->setAttribute('date_pay', $date_pay);
						                        
						                         $model->setAttribute('updated_by', Yii::app()->user->name );
								                        $model->setAttribute('date_updated', date('Y-m-d'));
			                    
				
							  	  if($model->save())
								       {  
								       	  		 if( ($this->is_pending_balance==true)&&($balance<=0) ) //update pending_balance to paid
													{
													   $command11 = Yii::app()->db->createCommand();
													   $command11->update('pending_balance', array('is_paid'=>1 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$this->student_id));
													}
											      elseif( ($this->is_pending_balance==true)&&($balance >0) ) //update pending_balance to not paid
													{
													   $command11 = Yii::app()->db->createCommand();
													   $command11->update('pending_balance', array('is_paid'=>0 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$this->student_id));
													}
											      
																  	   	          
																  	   	          	                                  	
					                            $new_balance = 0;
					                            $date_pay = null;
					                            $student = $model->student;
					                            $fee_period = $model->fee_period;
					                            $old_balance_ = $model->balance;
					                            $old_fee_period = $model->fee_period;
					                            
					                            $id_bill = $model->id;
					              
					          					               
					               //cheche tout lot peman ki fet apre peman sila pou moun sa (date_pay DESC)
					         $sql_1 = 'SELECT b.id, b.balance FROM billings b  INNER JOIN fees f ON(f.id=b.fee_period) INNER JOIN fees_label fl ON(fl.id=f.fee)  WHERE b.student='.$this->student_id.' AND fl.status='.$this->status_.' AND b.date_pay > \''.$model->date_pay.'\'  order by b.id ASC';
					          $command1 = Yii::app()->db->createCommand($sql_1);
 
                                    $result1 = $command1->queryAll(); 
											       	   
									if($result1!=null) 
									  { 
										 $last_id_in_range ='';
										 $stop=false;
										 
										 foreach($result1 as $bill)
											{  
											      $id_bill = $bill['id'];
											      $last_id_in_range = $bill['id'];
											      
											       $new_model=$this->loadModel($bill['id']);
											      
											       if(($balance!=0)&&($stop==true))
											        {
											        	$balance_current_record = $new_model->balance;
											        	
											        	if($balance < 0)
											        	  {
											        	  	  if( ($this->is_pending_balance==true) ) //update pending_balance to paid
																  	   	         {
																  	   	         	$command11 = Yii::app()->db->createCommand();
																                 $command11->update('pending_balance', array('is_paid'=>1 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$this->student_id));
																  	   	          }
											        	  	 
											        	  	 $amount_to_pay = $new_model->amount_to_pay + $balance;
											        	  	 $new_balance1 = $amount_to_pay - $new_model->amount_pay;
											        	  	 
											        	   	          if($new_balance1<=0)
														  	   	         $new_model->setAttribute('fee_totally_paid', 1);
														  	   	      // else
														  	   	        // $new_model->setAttribute('fee_totally_paid', 0);
														  	   	    
															  	   	   $new_model->setAttribute('amount_to_pay', $amount_to_pay);
															  	   	   $new_model->setAttribute('balance', $new_balance1);
															  	   	    
												                         $new_model->setAttribute('updated_by', Yii::app()->user->name );
														                        $new_model->setAttribute('date_updated', date('Y-m-d'));
														                        
														                 if($new_model->save())
														                   {
														                       unset($new_model); 
												 	 	   	      	            $stop=true;         
												 	 	   	      	          $balance = $new_balance1;  
												 	 	   	      	        
												 	 	   	      	        if( ($this->is_pending_balance==true)&&($new_balance1<=0) ) //update pending_balance to paid
																  	   	         {
																  	   	         	$command11 = Yii::app()->db->createCommand();
																                 $command11->update('pending_balance', array('is_paid'=>1 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$this->student_id));
																  	   	          }
												 	 	   	      	          
														                   } 
							 	 	   	      	             
									        	  	
											        	  	}
											        	 elseif($balance > 0)
											        	   {
											        	   	    if($new_model->fee_period == $old_fee_period)
											        	   	       { $amount_to_pay = $balance;
											        	   	          
											        	   	          $new_balance1 = $amount_to_pay - $new_model->amount_pay;
											        	   	          
											        	   	          if($new_balance1<=0)
														  	   	         $new_model->setAttribute('fee_totally_paid', 1);
														  	   	      // else
														  	   	        // $new_model->setAttribute('fee_totally_paid', 0);
														  	   	    
															  	   	   $new_model->setAttribute('amount_to_pay', $amount_to_pay);
															  	   	   $new_model->setAttribute('balance', $new_balance1);
															  	   	    
												                         $new_model->setAttribute('updated_by', Yii::app()->user->name );
														                        $new_model->setAttribute('date_updated', date('Y-m-d'));
														                        
														                if($new_model->save())
														                  {  unset($new_model); 
							 	 	   	      	                        
											        	   	                  $balance = $new_balance1;
											        	   	               
											        	   	               if( ($this->is_pending_balance==true)&&($new_balance1<=0) ) //update pending_balance to paid
																  	   	         {
																  	   	         	$command11 = Yii::app()->db->createCommand();
																                 $command11->update('pending_balance', array('is_paid'=>1 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$this->student_id));
																  	   	          }
																  	   	             
														                  }
											        	   	        
					
											        	   	       }
											        	   	   else
											        	   	      {  //fe yon nouvo anrejistreman pou fin peye fre sa
											        	   	           $amount_to_pay =  $balance;
											        	   	           $amount_pay =  $balance;
											        	   	           $date_pay = $new_model->date_pay;
											        	   	            $fee_totally_paid = 1;
								  	   	    
									  	   	                            $new_balance1 = 0;
									  	   	   
									  	   	                            $payment_method = $new_model->payment_method;
									  	   	                           
									  	   	                               unset($modelBillings_); 
							 	 	   	      	                            $modelBillings_= new Billings; 
							 	 	   	      	                            
							 	 	   	      	                      $modelBillings_->setAttribute('fee_totally_paid', $fee_totally_paid);
														  	   	       
															  	   	   $modelBillings_->setAttribute('amount_to_pay', $amount_to_pay);
															  	   	   $modelBillings_->setAttribute('amount_pay', $amount_pay);
															  	   	   $modelBillings_->setAttribute('balance', $new_balance1);
															  	   	   $modelBillings_->setAttribute('payment_method', $payment_method);
															  	   	   $modelBillings_->setAttribute('date_pay', $date_pay);
															  	   	    
												                         $modelBillings_->setAttribute('created_by', Yii::app()->user->name );
														                        $modelBillings_->setAttribute('date_created', date('Y-m-d'));
														                        
														               if( $modelBillings_->save())
									  	   	                             {
											        	   	               $balance = $new_balance1;
											        	   	               
											        	   	               if( ($this->is_pending_balance==true)&&($new_balance1<=0) ) //update pending_balance to paid
																  	   	         {
																  	   	         	$command11 = Yii::app()->db->createCommand();
																                 $command11->update('pending_balance', array('is_paid'=>1 ), 'academic_year=:year AND student=:stud', array(':year'=>$previous_year,  ':stud'=>$this->student_id));
																  	   	          }
							 	 	   	      	               
											        	   	      	        $old_fee_period = $new_model->fee_period;
											        	   	      	        
									  	   	                             }
									  	   	                             
											        	   	      	}
											        	   	}
											         }
											       else
											          {      
											          	    //pran balans lan retire l nan tab balance lan aavan delete
											                $balance_current_record = $new_model->balance;
											          	    $new_model->delete();
											          	    
											          	}
											         
											 }
											 
											 
											$modelBill = Billings::model()->findByPk($last_id_in_range);
											
											
									  	   	   if($balance>0)
								  	   	         { 
								  	   	            if($modelBill != null)
								  	   	             {	
								  	   	             	$modelBill->setAttribute('fee_totally_paid', 0);
								  	   	                $modelBill->save(); 
								  	   	              }
								  	   	          }
								  	   	       
								  	   	       
								  	   	              
					                  	   $new_balance = 0;
					                        $bal = 0;
					                        
					                       $modelBalance=Balance::model()->findByAttributes(array('student'=>$model->student));             
					                        
					                        if($modelBalance!=null)
						                      {   

							                  	    if($balance_current_record > $balance)
							                          { $new_balance = $balance_current_record - $balance;
							                            $bal = $modelBalance->balance - $new_balance;
							
														if($bal>=0)
							                               {	 // nan balanse total la
									 	 	   	  			 $modelBalance->setAttribute('balance', $bal);
															 $modelBalance->save();  
							                               }
							                             else
							                             {	 // nan balanse total la
									 	 	   	  			 $modelBalance->setAttribute('balance', 0);
															 $modelBalance->save();  
							                               }
							                                                       
							                           }
							                        elseif($balance_current_record < $balance)
							                           {   $new_balance = $balance - $balance_current_record;
							                               $bal = $modelBalance->balance + $new_balance;
							  
			                                               if($bal>=0)
							                               {// nan balanse total la
									 	 	   	  			 $modelBalance->setAttribute('balance', $bal);
															 $modelBalance->save();   
															 
							                               }
							                              else
							                              {// nan balanse total la
									 	 	   	  			 $modelBalance->setAttribute('balance', 0);
															 $modelBalance->save();   
															 
							                               }
							                                                        
							                           }
							                           
							                           
							                             
					                                
														
						                         }
						                       else
						                          {
						                           	   if($balance>0)
							                             {
							                               	$new_modelBalance= new Balance;
							                              
							                              $new_modelBalance->setAttribute('student',$model->student);
							                              $new_modelBalance->setAttribute('balance', $balance);
							                              $new_modelBalance->setAttribute('date_created', date('Y-m-d'));
							                              
							                               $new_modelBalance->save();
							                             }
							                             
						                           	}
						                             
								  	   	        
											 
											 
									   }     
					                 else
					                  {     
					                  	    $modelBill=$this->loadModel($model->id);
									  	   	    if($model->balance>0)
								  	   	          { 
								  	   	            if($modelBill != null)
								  	   	             {	
								  	   	             	$modelBill->setAttribute('fee_totally_paid', 0);
								  	   	                $modelBill->save(); 
								  	   	              }
								  	   	              
								  	   	           } 
								  	   	         
								  	   	         
								  	   	         
					                  	   $new_balance = 0;
					                        $bal = 0;
					                        
					                       $modelBalance=Balance::model()->findByAttributes(array('student'=>$model->student));             
					                        
					                        if($modelBalance!=null)
						                      {   

							                  	    if($balance_current_record > $model->balance)
							                          { $new_balance = $balance_current_record - $model->balance;
							                            $bal = $modelBalance->balance - $new_balance;
							  
			                                            if($bal>=0)
							                               {                       
							                                 // nan balanse total la
									 	 	   	  			 $modelBalance->setAttribute('balance', $bal);
															 $modelBalance->save();
							                               }
							                             else
							                               {                       
							                                 // nan balanse total la
									 	 	   	  			 $modelBalance->setAttribute('balance', 0);
															 $modelBalance->save();
							                               }
							                               
							                           }
							                        elseif($balance_current_record < $model->balance)
							                           {   $new_balance = $model->balance - $balance_current_record;
							                               $bal = $modelBalance->balance + $new_balance;
								                               
							                              if($bal>=0)
							                               {
							                               // nan balanse total la
									 	 	   	  			 $modelBalance->setAttribute('balance', $bal);
															 $modelBalance->save();
							                               }
							                              else
							                                {
							                               // nan balanse total la
									 	 	   	  			 $modelBalance->setAttribute('balance', 0);
															 $modelBalance->save();
							                               }
							                              
							                               
							                           }
						                             
						                         }
						                       else
						                          {
						                           	  if($model->balance >0)
							                               {  $new_modelBalance= new Balance;
							                              
							                              $new_modelBalance->setAttribute('student',$model->student);
							                              $new_modelBalance->setAttribute('balance', $model->balance);
							                              $new_modelBalance->setAttribute('date_created', date('Y-m-d'));
							                              
							                               $new_modelBalance->save();
							                               
							                               }
							                               
						                           	}
						                            
						                            
						                            
					                  	}
					               
					                
					                    $new_balance1 = $old_balance_;     
	          
						                       			       	  
								  	  $this->redirect(array('view','id'=>$model->id,'ri'=>$_GET['ri'],'part'=>'rec','from'=>'stud'));
								       	                                
								       	 
								       	  
								       }
																       
								     
					            }
					          else
					             $this->message_paymentMethod=true;
					        }
					      else
				             $this->message_datepay=true;
				      }
				      
				      if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }
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
          
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

       
		
		try {
   			   $modelB=$this->loadModel($id);
   			   
   			   $student = $modelB->student; 
   			   $acad = $modelB->academic_year;
   			   $date_pay = $modelB->date_pay;
   			   $fee_period = $modelB->fee_period;
   			   $id_bill = $modelB->id;
   			   $balance_bill = $modelB->balance;
   			   $amount_pay = $modelB->amount_pay;
   			 
   			  if(!isset($_GET['ajax']))
				{ 
					//tcheke si gen lot peman apre peman sila pou fre sa
					 $modelBilling_next =Billings::model()->find(array('condition'=>'fee_period='.$fee_period.' AND academic_year='.$acad.' AND date_pay >\''.$date_pay.'\''));
					 
					 if($modelBilling_next==null)
					  {
					 		//tcheke si gen lot peman avan peman sila pou fre sa
					       $modelBilling_before =Billings::model()->find(array('condition'=>'fee_period='.$fee_period.' AND academic_year='.$acad.' AND date_pay <\''.$date_pay.'\''));
					 
					 			
							//update tab balance lan
							    
							 	$modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
								   if($modelBalance!=null)
									 {  
									 	if( $modelBilling_before!=null) 
									 	  { $balance = $modelBalance->balance + $amount_pay;
									 	      $modelBalance->setAttribute('balance',$balance);
									 	      $modelBalance->save();
									 	  }
									 	else
									 	  { 
									 	  	//if($this->status_==0)
									 	  	  //{ 
									 	  	  	$balance = $modelBalance->balance + $amount_pay; //$balance = $modelBalance->balance + $balance_bill; 
									 	  	     $modelBalance->setAttribute('balance',$balance);
									 	         $modelBalance->save();
									 	  	//  }
									 	  	  
									 	   }
									 	     									 	
									   }
									else
									  {
									  	  $modelBalance1= new Balance;
									  	  
									  	//  if($this->status_==0) 
									  	  // {
									  	         $balance1 = $amount_pay  + $balance_bill;
							                              
							                              $modelBalance1->setAttribute('student',$student);
							                              $modelBalance1->setAttribute('balance', $balance1);
							                              $modelBalance1->setAttribute('date_created', date('Y-m-d'));
							                              
							                               $modelBalance1->save();
									  	    //   }
									 	
									  	}
		
		          
		                        $modelB->delete();
		                        
		                        //gade si denye tranzaksyon an gen balans +
		                        $modelBillings_balance=Billings::model()->findByAttributes(array('student'=>$student,'fee_period'=>$fee_period,'academic_year'=>$acad),array('order'=>'id DESC'));
						            
							            if($modelBillings_balance!=null)
								          {
								          	
								          	  if($modelBillings_balance->balance >0)
								          	   {
								          	   	  $modelBill___=$this->loadModel($modelBillings_balance->id);
										  	   	    $modelBill___->setAttribute('fee_totally_paid', 0);
									  	   	                $modelBill___->save(); 
									  	   	              
								          	   	
								          	   	}
								          }
		          
		                       $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		                       
					       }
					     else
					       { 
					       	    Yii::app()->user->setFlash(Yii::t('app','Warning'),'Cannot delete a parent transaction.');
					       	 }
			  
			    	}
			      else
			        {
			        	
			        	//tcheke si gen lot peman apre peman sila pou fre sa
					 $modelBilling_next =Billings::model()->find(array('condition'=>'fee_period='.$fee_period.' AND academic_year='.$acad.' AND date_pay >\''.$date_pay.'\''));
					 
					 if($modelBilling_next==null)
					  {
						 	//tcheke si gen lot peman avan peman sila pou fre sa
					       $modelBilling_before =Billings::model()->find(array('condition'=>'fee_period='.$fee_period.' AND academic_year='.$acad.' AND date_pay <\''.$date_pay.'\''));
					 
					 			
							//update tab balance lan
							    
							 	$modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
								   if($modelBalance!=null)
									 {  
									 	if( $modelBilling_before!=null) 
									 	  { $balance = $modelBalance->balance + $amount_pay;
									 	      $modelBalance->setAttribute('balance',$balance);
									 	       $modelBalance->save();
									 	  }
									 	else
									 	  { 
									 	  	//if($this->status_==0)
									 	  	  //{ 
									 	  	  	$balance = $modelBalance->balance + $amount_pay; //$balance = $modelBalance->balance + $balance_bill;
									 	  	      $modelBalance->setAttribute('balance',$balance);
									            	$modelBalance->save();
									 	  	  //}
									 	   }									 	
									 	
									 	
									   }
									else
									  {
									  	  $modelBalance1= new Balance;
									  	  
									  	    //if($this->status_==0)
									 	  	 // {
									 	  	  	  $balance1 = $amount_pay  + $balance_bill;
							                              
							                              $modelBalance1->setAttribute('student',$student);
							                              $modelBalance1->setAttribute('balance', $balance1);
							                              $modelBalance1->setAttribute('date_created', date('Y-m-d'));
							                              
							                               $modelBalance1->save();
									 	  	  // }
									 	
									  	}
		
							 
							      $this->loadModel($id)->delete();
							      
							      //gade si denye tranzaksyon an gen balans +
		                        $modelBillings_balance=Billings::model()->findByAttributes(array('student'=>$student,'fee_period'=>$fee_period,'academic_year'=>$acad),array('order'=>'id DESC'));
						            
							            if($modelBillings_balance!=null)
								          {
								          	
								          	  if($modelBillings_balance->balance >0)
								          	   {
								          	   	  $modelBill___=$this->loadModel($modelBillings_balance->id);
										  	   	    $modelBill___->setAttribute('fee_totally_paid', 0);
									  	   	                $modelBill___->save(); 
									  	   	              
								          	   	
								          	   	}
								          }
		          
							      
							      
				        	 }
					     else
					       { 
					       	    Yii::app()->user->setFlash(Yii::t('app','Warning'),'Cannot delete a parent transaction.');
					       	 }
			        		
			          }
				
			
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


public function delete($id)
	{
       
		try {
   			   $modelB=$this->loadModel($id);
   			   
   			   $student = $modelB->student; 
   			   $acad = $modelB->academic_year;
   			   $id_bill = $modelB->id;
   			 
   			      $modelB->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				{ 
					
					//update balance cumulee
					//update balance cumulee
					$new_balance = Billings::model()->updateMainBalance($student, $acad);
					
					//update tab balance lan
					if($new_balance == 0)
					 {  
					 	 $modelBillings = Billings::model()->findByAttributes(array('student'=>$student)); 
					 	//2 ka posib: 
					 	// a) pa gen tranzaksyon ditou pou elev sa pandan ane a (li gen balans tout echeyans pase yo)
					 	if($modelBillings == null)
					 	 {
					 	 	 $new_balance = 0;
					 	 	 
					 	 	 $modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
							   if($modelBalance!=null)
								 {   
								 	$modelBalance->delete();
								 	
								   }
					 	 	 
					 	 	 $level = $this->getLevelByStudentId($student, $acad)->id;
	
					 	 	 //cheche tout "fees model" kote "checked=1"
					 	 	 $checked=1;
					 	 	 $modelFees = Fees::model()->getFeeInfoByLevelAcademicperiodChecked($level, $acad, $checked);
					 	 	 
					 	 	 if($modelFees!=null)
					 	 	   {
					 	 	   	    foreach($modelFees as $fee)
					 	 	   	      {
							 	 	   	      	 unset($modelBillings); 
							 	 	   	      	 $modelBillings= new Billings;
									           	    
													$modelBillings->setAttribute('student',$student);
													$modelBillings->setAttribute('fee_period',$fee['academic_period']);
													$modelBillings->setAttribute('academic_year',$acad);
													$modelBillings->setAttribute('amount_to_pay',$fee['amount']); 
													$modelBillings->setAttribute('amount_pay',0); 
													$modelBillings->setAttribute('balance', $fee['amount']);
													$modelBillings->setAttribute('created_by', Yii::app()->user->name);
													$modelBillings->setAttribute('date_created', date('Y-m-d')); 
													
		
							                if($modelBillings->save())
							                   {           
							                          
									           	   //balance record for each stud
									           	   $modelBalance= new Balance;
									           	   
									           	   $modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
											     							           	  
									           	  if(isset($modelBalance)&&($modelBalance!=null))
									           	    {  //update this model
									           	    	$balance1=$modelBalance->balance + $fee['amount'];
									           	    	 $modelBalance->setAttribute('balance',$balance1);
									           	    	 
									           	    	   if($modelBalance->save())
									           	               $pass=true;
									           	    }
									           	  else
									           	    { //create new model
									           	          unset($modelBalance); 
							                              $modelBalance= new Balance;
							                              
									           	      $modelBalance->setAttribute('student',$student);
									           	      $modelBalance->setAttribute('balance',$fee['amount']);
									           	      $modelBalance->setAttribute('date_created',date('Y-m-d'));
									           	      
									           	      $modelBalance->save();
									           	           
									           	     
									           	    }
									           	  
							                    } 

					 	 	   	      	}
					 	 	   	 }
					 	 	   	 
					 	 	  
					 	 	
					 	   }
					 	else
					 	  {
						 	// b) li pa dwe sou okenn tranzaksyon
						 	$modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
							   if($modelBalance!=null)
								 {   
								 	$modelBalance->delete();
								 	
								   }
								else 
								  {  $modelBalance= new Balance;
							                              
									           	      $modelBalance->setAttribute('student',$student);
									           	      $modelBalance->setAttribute('balance',$new_balance);
									           	      $modelBalance->setAttribute('date_created',date('Y-m-d'));
									           	      
									           	      $modelBalance->save();
								   }
								   
					 	     }
	
					 	
					   }
					 else
					   {  
					   	 //pran info denye peman
					   	  $modelBillings_balance=Billings::model()->findByAttributes(array('student'=>$student,'fee_period'=>$this->fee_period,'academic_year'=>$acad),array('order'=>'id DESC'));
						            
							            if($modelBillings_balance!=null)
								          {  
								          	 if($modelBillings_balance->balance != null)
								          	      { $this->remain_balance = $modelBillings_balance->balance;

								          	        
								          	        if($this->remain_balance != 0)
									                  {  $modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
														   if($modelBalance!=null)
															 {   
															   $modelBalance->setAttribute('balance',  $new_balance);
																					       	    
																$modelBalance->save();
																
														       }
														    else
														      {
														      	   $modelBalance= new Balance;
							                              
												           	      $modelBalance->setAttribute('student',$student);
												           	      $modelBalance->setAttribute('balance',$new_balance);
												           	      $modelBalance->setAttribute('date_created',date('Y-m-d'));
												           	      
												           	      $modelBalance->save();
									           	      
														      	}

									                  	
									                  	}
									                 
									                 
								          	      }
								          	  
								           }
					
					      }

			    	}
			      else
			        {
			        	
					
					//update balance cumulee
					//update balance cumulee
					$new_balance = Billings::model()->updateMainBalance($student, $acad);
					
					//update tab balance lan
					if($new_balance == 0)
					 {  
					 	 $modelBillings = Billings::model()->findByAttributes(array('student'=>$student)); 
					 	//2 ka posib: 
					 	// a) pa gen tranzaksyon ditou pou elev sa pandan ane a (li gen balans tout echeyans pase yo)
					 	if($modelBillings == null)
					 	 {
					 	 	 $new_balance = 0;
					 	 	 
					 	 	 $modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
							   if($modelBalance!=null)
								 {   
								 	$modelBalance->delete();
								 	
								   }
					 	 	 
					 	 	 $level = $this->getLevelByStudentId($student, $acad)->id;
	
					 	 	 //cheche tout "fees model" kote "checked=1"
					 	 	 $checked=1;
					 	 	 $modelFees = Fees::model()->getFeeInfoByLevelAcademicperiodChecked($level, $acad, $checked);
					 	 	 
					 	 	 if($modelFees!=null)
					 	 	   {
					 	 	   	    foreach($modelFees as $fee)
					 	 	   	      {
							 	 	   	      	 unset($modelBillings); 
							 	 	   	      	 $modelBillings= new Billings;
									           	    
													$modelBillings->setAttribute('student',$student);
													$modelBillings->setAttribute('fee_period',$fee['academic_period']);
													$modelBillings->setAttribute('academic_year',$acad);
													$modelBillings->setAttribute('amount_to_pay',$fee['amount']); 
													$modelBillings->setAttribute('amount_pay',0); 
													$modelBillings->setAttribute('balance', $fee['amount']);
													$modelBillings->setAttribute('created_by', Yii::app()->user->name);
													$modelBillings->setAttribute('date_created', date('Y-m-d')); 
													
		
							                if($modelBillings->save())
							                   {           
							                          
									           	   //balance record for each stud
									           	   $modelBalance= new Balance;
									           	   
									           	   $modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
											     							           	  
									           	  if(isset($modelBalance)&&($modelBalance!=null))
									           	    {  //update this model
									           	    	$balance1=$modelBalance->balance + $fee['amount'];
									           	    	 $modelBalance->setAttribute('balance',$balance1);
									           	    	 
									           	    	   if($modelBalance->save())
									           	               $pass=true;
									           	    }
									           	  else
									           	    { //create new model
									           	          unset($modelBalance); 
							                              $modelBalance= new Balance;
							                              
									           	      $modelBalance->setAttribute('student',$student);
									           	      $modelBalance->setAttribute('balance',$fee['amount']);
									           	      $modelBalance->setAttribute('date_created',date('Y-m-d'));
									           	      
									           	      $modelBalance->save();
									           	           
									           	     
									           	    }
									           	  
							                    } 

					 	 	   	      	}
					 	 	   	 }
					 	 	   	 
					 	 	  
					 	 	
					 	   }
					 	else
					 	  {
						 	// b) li pa dwe sou okenn tranzaksyon
						 	$modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
							   if($modelBalance!=null)
								 {   
								 	$modelBalance->delete();
								 	
								   }
								else 
								  {  $modelBalance= new Balance;
							                              
									           	      $modelBalance->setAttribute('student',$student);
									           	      $modelBalance->setAttribute('balance',$new_balance);
									           	      $modelBalance->setAttribute('date_created',date('Y-m-d'));
									           	      
									           	      $modelBalance->save();
								   }
								   
					 	     }
	
					 	
					   }
					 else
					   {  
					   	 //pran info denye peman
					   	  $modelBillings_balance=Billings::model()->findByAttributes(array('student'=>$student,'fee_period'=>$this->fee_period,'academic_year'=>$acad),array('order'=>'id DESC'));
						            
							            if($modelBillings_balance!=null)
								          {  
								          	if($modelBillings_balance->balance != null)
								          	      { $this->remain_balance = $modelBillings_balance->balance;

								          	        
								          	        if($this->remain_balance != 0)
									                  {  $modelBalance=Balance::model()->findByAttributes(array('student'=>$student));
														   if($modelBalance!=null)
															 {   
															   $modelBalance->setAttribute('balance',  $new_balance);
																					       	    
																$modelBalance->save();
																
														       }
														    else
														      {
														      	   $modelBalance= new Balance;
							                              
												           	      $modelBalance->setAttribute('student',$student);
												           	      $modelBalance->setAttribute('balance',$new_balance);
												           	      $modelBalance->setAttribute('date_created',date('Y-m-d'));
												           	      
												           	      $modelBalance->save();
									           	      
														      	}

									                  	
									                  	}
									                 
									                 
								          	      }
								          	    
								         
								           }
																      
					      }
					      
					      
					      
			          }
				
			
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


	//************************  getRoomByStudentId($id,$acad) ******************************/
	public function getRoomByStudentId($id,$acad)
	{
		$modelRoomH=new RoomHasPerson;
		
		//$acad=Yii::app()->session['currentId_academic_year']; 
		 
		$idRoom = $modelRoomH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id,':acad'=>$acad),
                               ));
		$room = new Rooms;
      if(isset($idRoom)){           
		   $result=$room->find(array('select'=>'id,room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			//foreach($room->room_name as $i)
						   

				if(isset($result))			   
					return $result;
				else
				return null;	
				
		  }
		  else
		    return null;
		
	}
	
//************************  getLevelByStudentId($id,$acad) ******************************/
	public function getLevelByStudentId($id, $acad)
	{
		//$acad=Yii::app()->session['currentId_academic_year']; 
		 
		$idRoom= $this->getRoomByStudentId($id, $acad);
		
	  if(isset($idRoom)){	
		$modelRoom=new Rooms;
		$idLevel = $modelRoom->find(array('select'=>'level',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$level = new Levels;
        if(isset($idLevel)){
		   $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel->level),
                               ));
                              
		       if(isset($result))
				    return $result;
			    else
				    return null;
				
		   }
		  else
		     return null;
				
		}
	  else
	      return null;
		
	}
	

	
//************************  loadRecettesItems ******************************/
	public function loadRecettesItems()
	{     $code= array();
		   
		   $code[0]= Yii::t('app','Tuition fees');
		   $code[1]= Yii::t('app','Other fees');
		   $code[2]= Yii::t('app','Manage other incomes');
		   $code[3]= Yii::t('app','Enrollment fee');  
		   $code[4]= Yii::t('app','Reservation');        
		    		   
		return $code;
         
	}
 

//************************  loadRecettesItemsSummary ******************************/
	public function loadRecettesItemsSummary()
	{     $code= array();
		   
		   $code[0]= Yii::t('app','Tuition fees');
		   $code[1]= Yii::t('app','Other fees');
		   //$code[2]= Yii::t('app','Manage other incomes');
		 // $code[3]= Yii::t('app','Enrollment fee');         
		    		   
		return $code;
         
	}


	public function actionPaymentReceipt()
	{
		$this->part = 'payrec';
		$this->applyLevel  ='';
		$this->student_id  ='';
		$acad=Yii::app()->session['currentId_academic_year']; 
	
         $model=new Billings;
         $modelOtherIncome = new OtherIncomes;  
         $modelStudentOtherInfo = new StudentOtherInfo;
              
  	       
     if((isset($_GET['ri']))&&($_GET['ri']!=''))
		     $this->recettesItems = $_GET['ri'];
		     
      if((isset($_GET['id']))&&($_GET['id']!=''))
		  {   $this->student_id = $_GET['id'];
		      $model->setAttribute('student',$this->student_id );
		   }		     
		     
     if(isset($_POST['Billings']))
	   {

          if(isset($_POST['Billings']['recettesItems']))
		       $this->recettesItems = $_POST['Billings']['recettesItems'];
		   
		
		 if(isset($_POST['Billings']['student']))
		       $this->student_id = $_POST['Billings']['student'];
		       
		  		 	   
		 }
		 
		 
		if(isset($_GET['from'])&&($_GET['from']=='ad'))
            {     
            	  if(isset($_POST['StudentOtherInfo']))
					  {  $modelStudentOtherInfo->attributes = $_POST['StudentOtherInfo'];
				
						    $this->applyLevel = $modelStudentOtherInfo->apply_for_level;
						    
						     //update studentOtherInfo to add applyLevel
						     if($this->applyLevel!='')
						       { $modelStudent = StudentOtherInfo::model()->findByAttributes(array('student'=>$_GET['id']));
						         $modelStudent->setAttribute('apply_for_level',$this->applyLevel);
						         $modelStudent->save();
						        }
						    
					      }
					    else
						   {  if(isset($_GET['al'])&&($_GET['al']!=0))
									$this->applyLevel = $_GET['al'];
								else
								   $this->applyLevel = '';
						   
						     }
						
					  
				   
				  				   
				   
				   
              }
		   


		$this->render('payment_receipt',array(
			'model'=>$model,
		));
    		
		
	}



//************************  loadStudentByCriteria ******************************/
	public function loadStudentByCriteria($criteria)
	{    $code= array();
		   
		    $persons=Persons::model()->findAll($criteria);
            
			
		    if(isset($persons))
			 {  
			    foreach($persons as $stud){
			        $code[$stud->id]= $stud->fullName." (".$stud->id_number.")";
		           
		           }
			 }
		   
		return $code;
         
	}
	
	
	
	//xxxxxxxxxxxxxxx STUDENT  xxxxxxxxxxxxxxxxx
	    //************************  getStudent($id) ******************************/
   public function getStudent($id)
	{
		
		$student=Persons::model()->findByPk($id);
        
			
		       if(isset($student))
				return $student->first_name.' '.$student->last_name;
		
	}
	
	
	/**
	 * Lists all models.
	 */
//	public function actionIndex()
//	{
//		$dataProvider=new CActiveDataProvider('Billings');
//		$this->render('index',array(
//			'dataProvider'=>$dataProvider,
//		));
//	}

	/**
	 * Manages all models.
	 */
 public function actionIndex()
  {
		$acad_sess = acad_sess();
		$acad=Yii::app()->session['currentId_academic_year']; 
		
		if(isset($_POST['Billings']['recettesItems']))
		    $this->recettesItems = $_POST['Billings']['recettesItems'];
		else
	     {
	     	 if(isset($_GET['ri']) )
	     	   $this->recettesItems = $_GET['ri']; 
	       }
		
		
		  
		 if(isset($_GET['pageSize'])) 
		   {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                   unset($_GET['pageSize']);
             }
                
                
	 if($this->recettesItems==0)
      {         
               $this->status_ = 1;
               $condition ='fl.status=1 AND ';
               
                if(!isset($_GET['month_']))
			       {
			       	   $sql__ = 'SELECT DISTINCT date_pay FROM billings b INNER JOIN fees f ON( f.id = b.fee_period ) INNER JOIN fees_label fl ON( fl.id = f.fee ) WHERE fl.status='.$this->status_.' ORDER BY b.id DESC';
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						     { $current_month = getMonth($r['date_pay']);
						          break;
						     }
						  }
						else
						  $current_month = getMonth(date('Y-m-d'));
			       	  
			        }
			     else 
			       {  $current_month = $_GET['month_'];
			       	  
			        }
           
           if(isset($_GET['Billings']['search']) )
	     	   $model=new Billings('searchGlobal('.$condition.','.$acad.')');
	     else   
	     	$model=new Billings('searchByMonth('.$condition.','.$current_month.','.$acad.')');
		        $model->unsetAttributes();  // clear any default values
		
		
		if(isset($_GET['Billings']))
			$model->attributes=$_GET['Billings'];
           
            // Here to export to CSV 
				if($this->isExportRequest()){
					$this->exportCSV(array(Yii::t('app','Billings: ')), null,false);
		                            $this->exportCSV($model->searchByMonth($condition,$current_month, $acad_sess), array(
		                                'id',
						//'student0.last_name',
						'student0.fullName',
						'feePeriod.feeName',
						'amount_to_pay',
						'amount_pay',
		                                'balance',
						'paymentMethod.method_name',
						'DatePay')); 
				}
				 
         }
       elseif($this->recettesItems==1)
		    {
		        $this->status_ = 0;
		        $condition ='fl.status=0 AND ';
		        
		           if(!isset($_GET['month_']))
			       {
			       	   $sql__ = 'SELECT DISTINCT date_pay FROM billings b INNER JOIN fees f ON( f.id = b.fee_period ) INNER JOIN fees_label fl ON( fl.id = f.fee ) WHERE fl.status='.$this->status_.' ORDER BY b.id DESC';
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						     { $current_month = getMonth($r['date_pay']);
						          break;
						     }
						  }
						else
						  $current_month = getMonth(date('Y-m-d'));
			       	  
			        }
			     else 
			       {  $current_month = $_GET['month_'];
			       	  
			        }
           
            $model=new Billings('searchByMonth('.$condition.','.$current_month.','.$acad.')');
		        $model->unsetAttributes();  // clear any default values
		
		
		if(isset($_GET['Billings']))
			$model->attributes=$_GET['Billings'];
           
            // Here to export to CSV 
				if($this->isExportRequest()){
					$this->exportCSV(array(Yii::t('app','Billings: ')), null,false);
		                            $this->exportCSV($model->searchByMonth($condition,$current_month, $acad_sess), array(
		                                'id',
						//'student0.last_name',
						'student0.fullName',
						'feePeriod.feeName',
						'AmountToPay',
						'AmountPay',
		                                'BalanceCurrency',
						'paymentMethod.method_name',
						'DatePay')); 
				}

		
		      }
		   elseif($this->recettesItems==2)
		    {
		        $this->redirect(array('/billings/otherIncomes/index?ri=2&from=b'));
		
		      }
		    elseif($this->recettesItems==3)
		       {
		        $this->redirect(array('/billings/enrollmentIncome/index?part=rec&from=b'));
		
		      }
             elseif($this->recettesItems==4)
		       {
		        $this->redirect(array('/billings/reservation/index?part=rec&from=b'));
		
		      }

 
  
		$this->render('index',array(
			'model'=>$model,
		));
    		
		
	}
        
        // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','billings.csv'),
           'csvDelimiter' => ',',
           ));
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Billings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Billings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Billings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='billings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	
        
     
	// Fonction to load the fees as AJAX autocomplete 
	
	public function actionFee()
	    {
	        // search keyword from ajax
	        $q = $_GET['q'];

	        $rows = array();
			
			$stringSql = 'SELECT id, fee_name FROM fees WHERE fee_name LIKE "%'.$q.'%"'; 
			$sql = $stringSql;
	        //$sql = 'SELECT id, `fee_name` FROM fees WHERE `fee_name` LIKE "%' . $q . '%"';
	        $rows = Yii::app()->db->createCommand($sql)->queryAll();
	        if ($rows)
	            echo CJSON::encode($rows);
	    }
		

	//************************  loadApplyLevel  ******************************/
	public function loadApplyLevel($idLevel)
	{    
       	  $acad=Yii::app()->session['currentId_academic_year']; 
		 
		  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	       $modelLevel= new Levels();

	      $pLevel_id=$modelLevel->findAll(array('select'=>'id',
                                     'condition'=>'previous_level=:levelID',
                                     'params'=>array(':levelID'=>$idLevel),
                               ));
			if(isset($pLevel_id))
			 {  
			    foreach($pLevel_id as $i){			   
					 					   
					  //$code[$i->id]= $i->level_name;
					  
					  $level=$modelLevel->findAll(array('select'=>'id, level_name',
												 'condition'=>'id=:levelID OR id=:IDLevel',
												 'params'=>array(':levelID'=>$i->id,':IDLevel'=>$idLevel),
										   ));
						
					if(isset($level)){
						  foreach($level as $l)
						       $code[$l->id]= $l->level_name;
					    }  
							   }						 
		    
						  }	
			
		return $code;
         
	}
			
		public function actionSearch($term)
		     {
		          if(Yii::app()->request->isAjaxRequest && !empty($term))
		        {
		              $variants = array();
		              $criteria = new CDbCriteria;
		              $criteria->select='last_name';
		              $criteria->addSearchCondition('last_name',$term.'%',false);
		              $tags = Persons::model()->findAll($criteria);
		              if(!empty($tags))
		              {
		                foreach($tags as $tag)
		                {
		                    $variants[] = $tag->attributes['last_name'];
		                }
		              }
		              echo CJSON::encode($variants);
		        }
		        else
		            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		     }
	
}
