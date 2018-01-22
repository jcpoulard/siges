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



class SiteController extends Controller
{
	 public $message=false;
	 public $layout = "";
	 
	 
	  public $full_scholarship=false;
	  public $internal;
	 
	 /**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			/*
			'page'=>array(
				'class'=>'CViewAction',
			),
			*/
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionLogin()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
           // $this->render('index');
            $this->layout = "//layouts/column3";
            $model=new LoginForm;
            if($model->login()){
               
                $this->render('index');
            }
            else{
                $this->redirect(Yii::app()->baseUrl);
            }
               
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
			  {
			  		echo $error['message'];
			  		
			  		
			   }
			else
			  {
			  		$this->render('error', $error);
			  		
			    }
			  
			  
		}
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
                $this->layout = "//layouts/column3";
		$model=new ContactForm;
                 $gc = GeneralConfig::model()->findAll();
                $email = null;
                $school_name = null;
                foreach($gc as $c){
                    if($c->item_name == "school_email_address"){
                        $email = $c->item_value;
                    }
                    if($c->item_name == "school_name"){
                        $school_name = $c->item_value;
                    }
                    
                }
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$name='=?UTF-8?B?'.base64_encode($model->name).'?=';
				$subject='=?UTF-8?B?'.base64_encode($model->subject).'?=';
				$headers="From: $name <{$model->email}>\r\n".
					"Reply-To: {$model->email}\r\n".
					"MIME-Version: 1.0\r\n".
					"Content-type: text/plain; charset=UTF-8";

				mail($email,$subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
				//$this->refresh();
                                $this->redirect(array('../index.php/portal'));
			}
		}
		$this->render('contact',array('model'=>$model));
	}


        
 public function actionIndex()
	{
        $siges_structure = infoGeneralConfig('siges_structure_session');            
        $this->noSession = false;
        $acad_id='';
    
    
      	// Set transaction id for point of sale
       unset(Yii::app()->session['last_transaction']);
       Sellings::model()->deleteNoCompleteSale(); 
       Yii::app()->session['last_transaction'] = Sellings::model()->getMaxTransactionId();
		
		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

         $model=new LoginForm;
        $modelAcad=new AcademicPeriods;
        $modelAcad1 =new AcademicPeriods;
        
		//$acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
		$acad=AcademicPeriods::model()->searchLastAcademicPeriod();
	if(isset($acad) )
	{	
		if($siges_structure==0)
		  {
			if(isset($_POST['AcademicPeriods']))
			  {
			  	 $modelAcad->attributes=$_POST['AcademicPeriods'];
				 $acad_id=$modelAcad->name_period;
				 
				  unset(Yii::app()->session['currentId_academic_year']);
				  unset(Yii::app()->session['currentName_academic_year']);
						   
				 Yii::app()->session['currentId_academic_year']=$acad_id;
				  $name=AcademicPeriods::model()->getAcademicPeriodNameById($acad_id);
				                       
			  	  Yii::app()->session['currentName_academic_year']=$name->name_period;
			  	  
			  	 		  	  
			  	}
		  
		   
	         }
		elseif($siges_structure==1)
		  {  	
			
			
				
			 if(isset($_POST['AcademicPeriods'])) //sa ekzekite kit ou chanje l kit se pa li ki chanje
			  {
		  	
			  	    $modelAcad->attributes=$_POST['AcademicPeriods'];
				    $acad_id=$modelAcad->name_period;
					 
				  	
				  	if($acad_id!=Yii::app()->session['currentId_academic_year'])
				  	  {
				  	  	Yii::app()->session['currentId_academic_year']=$acad_id;
				  	  	
				  	  	$name=AcademicPeriods::model()->getAcademicPeriodNameById($acad_id);
				                       
			  	  Yii::app()->session['currentName_academic_year']=$name->name_period;
				  	  	
				  	  	
				  	  	 unset(Yii::app()->session['currentId_academic_session']);
						  unset(Yii::app()->session['currentName_academic_session']);
				  	  
				  	  }
				  		   
				 
				  			      
			                if((isset(Yii::app()->session['currentId_academic_session']))&&(Yii::app()->session['currentId_academic_session']!=NULL))
			                  {   
			                  	 $this->noSession = false;
			                  }
			                else
			                   {   
			                      $current_sess_0=AcademicPeriods::model()->lastAcademicSession($acad_id);
						                $current_sess_0=$current_sess_0->getData();
						                if($current_sess_0!=NULL)
						                 {
							                foreach($current_sess_0 as $sess)
							                  {  //set current academic variable session
								  				 Yii::app()->session['currentId_academic_session'] =$sess->id;
							    	            Yii::app()->session['currentName_academic_session']=$sess->name_period;
							    	             
							                   }
							    	          
						                  }
						                else
						                  {
						                  	    $this->noSession = true;
						                  	   
						                  	}
			                  }
						                
						           						         
				  }
			/*	 else
				   {
					  if((isset(Yii::app()->session['currentId_academic_session']))&&(Yii::app()->session['currentId_academic_session']!=NULL))
			            {   
			              $this->noSession = false;
			             }
			          else
			             {
                 
						      if(Yii::app()->session['currentId_academic_session']=='');
							     {
					                  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
		                   
									if( $current_acad!=null)
									{
										 //set current academic variable session
									   Yii::app()->session['currentId_academic_year']=$current_acad->id;
									   Yii::app()->session['currentName_academic_year']=$current_acad->name_period;
									}
					                  
		
									  $current_sess_0=AcademicPeriods::model()->lastAcademicSession($current_acad->id);
								                $current_sess_0=$current_sess_0->getData();
								                if($current_sess_0!=NULL)
								                 {
									                foreach($current_sess_0 as $sess)
									                  {  //set current academic variable session
										  				 Yii::app()->session['currentId_academic_session'] =$sess->id;
									    	            Yii::app()->session['currentName_academic_session']=$sess->name_period;
									    	             
									                   }
									    	          
								                  }
								                else
								                  {
								                  	    $this->noSession = true;
								                  	   
								                  	}
								    }
								    
			             }
							
					 }  
					 */
			 
			 
					 if(isset($_POST['AcademicPeriods'][1]))
					  {
					  	 $modelAcad->attributes=$_POST['AcademicPeriods'];
						 
			  	        $modelAcad1->attributes=$_POST['AcademicPeriods'][1];
						 $sess_id=$modelAcad1->name_period;
						 
						  unset(Yii::app()->session['currentId_academic_session']);
						  unset(Yii::app()->session['currentName_academic_session']);
								   
						 Yii::app()->session['currentId_academic_session']=$sess_id;
						  $name1=AcademicPeriods::model()->getAcademicPeriodNameById($sess_id);
						                       
					  	  Yii::app()->session['currentName_academic_session']=$name1->name_period;
					  	  
					  	 		  	  
					  	}
		  	
	             }
		
	     }
	     
	       
		// collect user input data
	  if(isset($_POST['LoginForm']))
		{
		 if(isset($_POST['login']))
		  {
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login())
               {   
                   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
                   
                 if($current_acad!=null)
                   {  if( $current_acad->date_end > date('Y-m-d') )
                       //if( $current_acad->name_period!=null)
				  //if(($acad->name_period!=null)||($acad->name_period!=''))
                    {  
					   
					   //gad si moun nan alafwa ANPLWAYE_PWOFESE
					   Yii::app()->session['employee_teacher']=0;
					      $modelP=new Persons;
					      if(Yii::app()->user->profil!='')
					        {  
					        	 $person_id=0;
					             $person_ID=Persons::model()->getIdPersonByUserID(Yii::app()->user->userid);
							     $person_ID= $person_ID->getData();
											                    
									     foreach($person_ID as $c)
											$person_id= $c->id;	
						
		                        
		                        $employee_teacher = Persons::model()->isEmployeeTeacher($person_id, $acad->id);
		                        
		                        if($employee_teacher)
		                          {
		                        	      Yii::app()->session['employee_teacher']=1;
                                         	Yii::app()->session['profil_selector']='emp';
		                        	}
		  
					      }
					    
					    
					   //set current academic variable session
					   Yii::app()->session['currentId_academic_year']=$current_acad->id;
					   Yii::app()->session['currentName_academic_year']=$current_acad->name_period;
			            

						  if($siges_structure==1)
						    {
					    	 
						    	 
						    	 $current_sess_id='';
						    	 $current_sess_name='';
						    	 
						    	 $current_sess=AcademicPeriods::model()->searchCurrentAcademicSession($current_acad->id,date('Y-m-d'));
						         
						         if($current_sess==NULL)
						           {  $current_sess_=AcademicPeriods::model()->lastAcademicSession($current_acad->id);
						                $current_sess_=$current_sess_->getData();
						                if($current_sess_!=NULL)
						                 {
							                foreach($current_sess_ as $sess)
							                  {  $current_sess_id=$sess->id;
							    	             $current_sess_name=$sess->name_period;
							    	             
							                   }
							    	          
						                 }
						                 
						            }
						         else
						           {
						           	     $current_sess_id=$current_sess->id;
						    	          $current_sess_name=$current_sess->name_period;
						    	 	 }
						         
						           //set current academic variable session
								   Yii::app()->session['currentId_academic_session']= $current_sess_id;
								   Yii::app()->session['currentName_academic_session']=$current_sess_name;
									   
						    	 
						      }
						         
						     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad_id!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }
      

	//&&&&&&&&&&&&&&&&   calcule pour automatiser "balance a payer"
					     $model_fees= new Fees;
					     $fee_academic_period=0;
					     $data_fees_datelimit=Fees::model()->checkDateLimitPayment(date('Y-m-d'),$acad->id);//date_du_jour >= date_limt_payment AND checked=0
		
					     if(isset($data_fees_datelimit)&&($data_fees_datelimit!=null))
					       { 
						   
					       	 $data_fees_datelimit=$data_fees_datelimit->getData();
					       	 foreach($data_fees_datelimit as $date_limit)
					       	   {  
						       	
						       	
						       	 $fee_period_id=$date_limit->id;
						         $level=$date_limit->level;
						         $amount1=$date_limit->amount;
						         $amount=$date_limit->amount;
								 $amount_to_pay = $date_limit->amount;
								 $fee_academic_period = $date_limit->academic_period;
	                            
	                            $fee_name = $date_limit->fee0->fee_label;
	                            
                             if($fee_name!='Pending balance')
                             	{
                             	$pass=false;
						         
						         $fee_status = Fees::model()->getFeeStatus($fee_period_id); 
  
                                 
						        					         
					      $personsBillings=Persons::model()->getStudentsForBillings($condition,$level,$fee_period_id);
					      

					           if(isset($personsBillings)&&($personsBillings!=null))
							     {   
							     	    $personsBillings=$personsBillings->getData();
							     	    $modelBillings= new Billings; 
							     	    
							     	foreach($personsBillings as $stud)
							           {  $percentage_pay = 0;
							           	 
							           	  $this->full_scholarship=false;
										  $porcentage_level = 0; //mwens ke 100%
										 
                                         
                                         $modelFee = Fees::model()->findByPk($fee_period_id);
                                         //check if student is scholarship holder
											$model_scholarship = Persons::model()->getIsScholarshipHolder($stud->id,$acad->id);    
														           	  
														           	  $konte =0;
																	  $amount = 0;	
																		$percentage_pay = 0;
																	$partner_repondant = NULL;																			
																	  $premye_fee = NULL;
																			          if($model_scholarship == 1) //se yon bousye
																			           {  //tcheke tout fee ki pa null nan bous la
																							   $notNullFee = ScholarshipHolder::model()->feeNotNullByStudentId($stud->id,$acad->id);
																			           	      $notNullFee = $notNullFee->getData();
																						   if($notNullFee!=NULL)
																							{																								
																							  foreach($notNullFee as $scholarship)
																			           	    	{ $konte++;
																			           	    	
																			           	    	  if(isset($scholarship->fee))
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
																								  $check_partner=ScholarshipHolder::model()->getScholarshipPartnerByStudentIdFee($stud->id,NULL,$acad->id);
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
																					   
                                        
										
										
										
										
										
										
							           	  
							        //billings record for each stud
							           	   unset($modelBillings); 
							           	   $modelBillings= new Billings;
							       
							     if(($this->full_scholarship)&&($partner_repondant==NULL)) //nap record le l full e se pa lekol la ki repondan, poul pa fose etafinansye a
									    { 
										    if($porcentage_level==0) //mwens ke 100%
											    {	 
													if($siges_structure==0)
													   $modelBillings->setAttribute('academic_year',$acad->id);
													 elseif($siges_structure==1)
													   $modelBillings->setAttribute('academic_year',$fee_academic_period);
													   
													$modelBillings->setAttribute('student',$stud->id);
													$modelBillings->setAttribute('fee_period',$fee_period_id);
													
													$modelBillings->setAttribute('amount_to_pay',$amount); 
													$modelBillings->setAttribute('amount_pay',0); 
													$modelBillings->setAttribute('date_pay',date('Y-m-d'));
													$modelBillings->setAttribute('comments', Yii::t('app','Full scholarship holder'));
													$modelBillings->setAttribute('balance', $amount);
													$modelBillings->setAttribute('created_by', "SIGES");
													$modelBillings->setAttribute('date_created', date('Y-m-d')); 
												}
																				       	
							       	  }
								   else 
									    { 	  
							           	 	if($siges_structure==0)
													   $modelBillings->setAttribute('academic_year',$acad->id);
													 elseif($siges_structure==1)
													   $modelBillings->setAttribute('academic_year',$fee_academic_period);
													   

							           	 	
							           	 	$modelBillings->setAttribute('student',$stud->id);
											$modelBillings->setAttribute('fee_period',$fee_period_id);
											$modelBillings->setAttribute('amount_to_pay',$amount); 
											$modelBillings->setAttribute('amount_pay',0); 
											$modelBillings->setAttribute('balance', $amount);
											$modelBillings->setAttribute('created_by', "SIGES");
											$modelBillings->setAttribute('date_created', date('Y-m-d')); 
											
							           }
 
					                if($modelBillings->save())
					                   {           
					                          
							           	   //balance record for each stud
							           	   $modelBalance= new Balance;
							           	   
							           	   $modelBalance=Balance::model()->findByAttributes(array('student'=>$stud->id));
									     							           	  
							           	  if(isset($modelBalance)&&($modelBalance!=null))
							           	    {  //update this model
							           	    	if(($this->full_scholarship)&&($partner_repondant==NULL))
												  { 
											        if($porcentage_level==0) //mwens ke 100%
         											  $balance1=$modelBalance->balance + $amount;
												  
												  }
							                    else
							                       $balance1=$modelBalance->balance + $amount;
							                       
							           	    	 $modelBalance->setAttribute('balance',$balance1);
							           	    	 
							           	    	   if($modelBalance->save())
							           	               $pass=true;
							           	    }
							           	  else
							           	    { //create new model
							           	          unset($modelBalance); 
					                              $modelBalance= new Balance;
					                              
												  if( (($this->full_scholarship)&&($partner_repondant!=NULL)) || (!$this->full_scholarship) )
					                               {  $modelBalance->setAttribute('balance',$amount); 
							                          
														  $modelBalance->setAttribute('student',$stud->id);
														  $modelBalance->setAttribute('date_created',date('Y-m-d'));
														  
														  if($modelBalance->save())
																$pass=true;
													}
							           	     
							           	    }
							           	  
					                    } 
					                   
					                    
					                    
							           	    
							            }//fen foreach
							            
							     }//fen if(isset($personsBillings)&&($personsBillings!=null))
							     
							    if($pass) 
							      {   //udate this fees model, checked=1
						       	     $modelFees=Fees::model()->findByPk($date_limit->id);
						       	  
						       	      $modelFees->setAttribute('checked',1);
						             $modelFees->save();
						             
							      }


					       	   }//fen sil pa "pending balance"

							     					           
					           }//fen foreach($data_fees_datelimit as $date_limit)
					           
					        }//fen if(isset($data_fees_datelimit)&&($data_fees_datelimit!=null))
					        
					     
					        
					 //CURRENCY
					 //Extract devise name and symbol 
					  $currency_name_symbol = infoGeneralConfig('currency_name_symbol');
					    
					    $explode_currency_name_symbol= explode("/",substr($currency_name_symbol, 0));
					    
					    $currency_name = $explode_currency_name_symbol[0];
					    $currency_symbol = $explode_currency_name_symbol[1];
					    Yii::app()->session['currencyName']=$currency_name;
					    Yii::app()->session['currencySymbol']=$currency_symbol;           
					        
		               
							   
							   if(Yii::app()->user->groupid==1)
							      $this->redirect(array('users/actions/index',));
							  elseif((Yii::app()->user->profil=='Admin') || Yii::app()->user->profil=='Manager' || Yii::app()->user->profil=='Billing')
							    {  
								       $pass = '';
									   
									$default_vacation_name = infoGeneralConfig('default_vacation');
										$criteria2 = new CDbCriteria;
										$criteria2->condition='shift_name=:item_name';
										$criteria2->params=array(':item_name'=>$default_vacation_name,);
										$default_vacation = Shifts::model()->find($criteria2);
										
										$shift_id = $default_vacation->id;
										
										 $data=  Rooms::model()->findAll(array('alias'=>'r','join'=>'inner join room_has_person rh on(r.id=rh.room)','condition'=>'shift='.$shift_id)  );

										foreach($data as $value)
										{  $pass = $value->id;
											break;
										}
									  
									  if($pass =='')
									      $this->redirect(array('/site/index'));
								      else
										$this->redirect(array('reports/customReport/dashboard?from1=rpt',));
									
								  }
						     else
							      $this->redirect(array('/site/index'));
							    
							
					    
					}  
                  else				
                   {    //$modelAcad = new AcademicPeriods;
						  //alert to create the new one
						 if(Yii::app()->user->profil=='Admin')
						   $this->redirect(Yii::app()->baseUrl.'/index.php/configuration/academicperiods/create?from=gol');
						 else
						   $this->message=true;
						  //echo Yii::t('app','Please set the new academic period.');
						
				      }
				   
                   }
                 else
                   {    //$modelAcad = new AcademicPeriods;
						  //alert to create the new one
						 if(Yii::app()->user->profil=='Admin')
						   $this->redirect(Yii::app()->baseUrl.'/index.php/configuration/academicperiods/create?from=gol');
						 else
						   $this->message=true;
						  //echo Yii::t('app','Please set the new academic period.');
						
				      }
		
		     }
		
		    }
		      elseif(isset($_POST['logout'])) 
		       { $this->message=false;
			      unset(Yii::app()->session['currentId_academic_year']);
					   unset(Yii::app()->session['currentName_academic_year']);
					   unset(Yii::app()->session['currentId_academic_session']);
					   unset(Yii::app()->session['currentName_academic_session']);
					    unset(Yii::app()->session['employee_teacher']);
					    unset(Yii::app()->session['profil_selector']);
					    
			   }
		
		}
			
                if(Yii::app()->user->isGuest){
                  
                // Pour amener la racine de SIGES dans le portal 
                    // Si c'est un utilisateur non connecte qui click sur login on met la variable log a wi
                    //  et on l'envoi vers le 
                    if((isset ($_GET['log']) && $_GET['log']=='wi')){
                        $this->render('login',array('model'=>$model));
                       
                    }else{
                         $this->layout = "//layouts/column4";
                        $this->redirect(Yii::app()->baseUrl.'/index.php/portal/default');
                    }
                }  
				
				
                
               else
                  {    
				     if($acad!=null)
					    $this->render('index');
					  else
					    $this->render('login',array('model'=>$model));
                                           //   $this->render('index');
				  }  
                 
				   
				   
				  
				
                
                
		// display the login form
		//$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
		$last_Activity = '';
		
		if(isset(Yii::app()->user->userid))
		 { $user_id = Yii::app()->user->userid;
		 
		    //return datetime (last_activity)
             $last_Activity = isUserConnected($user_id);
		 }
		else
		  $user_id = '';
		
		if(($last_Activity=='')||($last_Activity==NULL))
		  {
		
				unset(Yii::app()->session['currentId_academic_year']);
				unset(Yii::app()->session['currentName_academic_year']);
				unset(Yii::app()->session['employee_teacher']);
				unset(Yii::app()->session['profil_selector']);
		                
		                Sellings::model()->deleteNoCompleteSale(); 
				
				$this->message=false;
		              
		                              $dir = realpath(Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."assets");
		                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
		                    shell_exec("RD /S /Q C:\\".$dir);
		                    shell_exec("MD C:\\".$dir);
		                }
		                else{
		                    
		                    $cmd = "rm -rf ".$dir."/*";
		                    
		                    shell_exec($cmd);
		               }
		              
				$this->redirect(Yii::app()->baseUrl.'/index.php/portal/');
		
	        }
	      else
	         {
	              unset(Yii::app()->session['currentId_academic_year']);
					unset(Yii::app()->session['currentName_academic_year']);
					unset(Yii::app()->session['employee_teacher']);
					unset(Yii::app()->session['profil_selector']);
			                
			                Sellings::model()->deleteNoCompleteSale(); 
					
					$this->message=false;
			              
			                              $dir = realpath(Yii::app()->basePath.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."assets");
			                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
			                    shell_exec("RD /S /Q C:\\".$dir);
			                    shell_exec("MD C:\\".$dir);
			                }
			                else{
			                    
			                    $cmd = "rm -rf ".$dir."/*";
			                    
			                    shell_exec($cmd);
			               }
			               
					Yii::app()->user->logout();
			                
					$this->redirect(Yii::app()->baseUrl.'/index.php/portal/');	
	         	
	         }
              
              
	}
	
	
        /*
         * 
         */
        
}