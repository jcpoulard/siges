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
/* @var $this PayrollController */
/* @var $dataProvider CActiveDataProvider */

  $acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year']; 
 $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 

           

 $this->grouppayroll=Yii::app()->session['payroll_group_payroll'];

  $disabled='';

   if(isset($_GET['id'])&&($_GET['id']!=''))
       $disabled = 'disabled';
     
       
        
?>

<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p><br/>';

	       echo $form->errorSummary($model); 
             
        
	
	   	        
	        //error message 
	        	if((!$this->messagePayrollReceipt_available)||($this->messageNoPayrollDone))//||($this->success))
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ';//-20px; ';
				      echo '">';
				      				      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			       
			       }			      
				 					     	
				   
				    if(!$this->messagePayrollReceipt_available)
				      {  echo '<span style="color:red;" > '.Yii::t('app','Payroll receipt is not available.').'</span>'.'<br/>';
				      }
				    
				    if($this->messageNoPayrollDone)
				      {  echo '<span style="color:red;" > '.Yii::t('app','Payroll is not yet done.').'</span>'.'<br/>';
				      }
				 
				   				    
				     				   
						   
			     if((!$this->messagePayrollReceipt_available)||($this->messageNoPayrollDone))//||($this->success))
			      { 
					 echo'</td>
					    </tr>
						</table>';
					
                      echo '</div>';
			       }
       		
	?>

	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
  <?php if(isset($_GET['id'])&&($_GET['id']!=''))
          {
  ?>         
        <div class="col-4">
            <label id="resp_form"> 
            
                   <?php 
                         
                          
                                echo $form->labelEx($model,'person_id'); ?>
                   
                       <?php
                        //get a default month
								  $default_month='';
								  $month ='';
								  $month_ =$model->getLongMonthValue();
								   foreach($month_ as $m)
								    { $default_month = $model->getIdLongMonth($m);
								     
								      break;
								     }
								  
								  if($this->payroll_month !='')
								     $month = $this->payroll_month;
								  else
								     $month = $default_month;   
						 				                  
                        $criteria = new CDbCriteria(array('group'=>'p.id','alias'=>'p', 'order'=>'last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND (p.id IN(SELECT person_id FROM payroll_settings ps INNER JOIN payroll pl ON(pl.id_payroll_set=ps.id) WHERE (ps.academic_year='.$acad.') )) '));
                    	
                    	
                    	if($this->person_id!='')
						  {  
							  echo $form->dropDownList($model, 'person_id',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('onchange'=> 'submit()', 'options' => array($this->person_id=>array('selected'=>true)), 'disabled'=>$disabled));
										    
							}
						 else
							{   
								 echo $form->dropDownList($model, 'person_id',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array( 'onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Search --'), 'disabled'=>$disabled));
										  	
										  	
							 }
										    
                                   						                            
                          
                          ?>
		                <?php  echo $form->error($model,'person_id'); ?>
		                       
		                       
		     </label>
        </div>
        
 <?php }   ?>
 
        
        <div class="col-4">
            <label id="resp_form">
    
                    <?php   echo $form->labelEx($model,'payroll_month');    ?>
                    
                    <?php 
                         
                          	    if($this->payroll_month!=null)
				                   {
								     if(isset($_GET['id'])&&($_GET['id']!=''))
								        echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValueByPerson($model->id_payroll_set),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true)),'disabled'=>$disabled));
								     else
								        echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValue(),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true)),'disabled'=>$disabled));
							       }
							    else
							      {
							         if(isset($_GET['id'])&&($_GET['id']!=''))
								        echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValueByPerson($model->id_payroll_set),array('onchange'=> 'submit()','disabled'=>$disabled));
								     else
								        echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValue(),array('onchange'=> 'submit()','disabled'=>$disabled));
							       }
					   
					    ?>
                         
                        <?php echo $form->error($model,'payroll_month'); ?>
		       
		     </label>
        </div>
        
        
       <div class= "col-4" > 
            <label id="resp_form" >
                       
                   <?php  echo $form->labelEx($model,'payroll_date'); ?>
		             <?php  
		                       $date__ = $this->payroll_date;
							
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'Payroll[payroll_date]',
									 'language'=>'fr',
									 'value'=>$date__,
									 'htmlOptions'=>array('size'=>40, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Payroll Date')),
									 
									  'options'=>array(
										 'disabled'=>$disabled,
										 'showButtonPanel'=>true,
										 'changeYear'=>true,                                      
										 'dateFormat'=>'yy-mm-dd',
										 'yearRange'=>'1900:2100',
	                                     'changeMonth'=>true,
	                                     'showButtonPane'=>true,  
	                                     
	                                   //  'showAnim'=>'fold',
								         'beforeShowDay' => 'js:$.datepicker.noWeekends',
								          'onSelect'=> 'js: function(date) { 
														    if(date != "") { 
														    document.getElementById("payroll-receipt-form").submit();// window.location.reload();
														     
														    } 
														   }',
 
										 ),
									 )
								 );

                     ?>
                     <?php echo $form->error($model,'payroll_date');  ?>
                     
                     
		     </label>
        </div>   

   
   
<?php 
  if(($this->payrollReceipt_available)&&($this->messagePayrollReceipt_available))
     {  
   
   if((isset($_GET['id']))&&($_GET['id']!=''))
    {
     	$employee='';
     	$id_payroll_set ='';
     	$id_payroll_set2 = '';
     	$payment_date ='';
     	$payroll_date = '';
     	$net_salary = 0;
     	$taxe = 0;
     	$total_deduction = 0;
     	$number_of_hour = null;
     	$missing_hour = 0;
     	$gross_for_hour = 0;
     	$payroll_month = '';
     	
     	$title = Persons::model()->getTitles($this->person_id,$acad);
     	$working_dep = Persons::model()->getWorkingDepartment($this->person_id,$acad);
     	$gross_salary= Payroll::model()->getGrossSalaryPerson_idMonthAcad($this->person_id,$this->payroll_month,$acad);
     	
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
     	   	      	     $payroll_date = $payroll_->payroll_date;
     	   	      	     $net_salary = $payroll_->net_salary;
     	   	      	     $id_payroll_set = $payroll_->id_payroll_set;
     	   	      	     $id_payroll_set2 = $payroll_->id_payroll_set2;
     	   	      	     $taxe = $payroll_->taxe;
     	   	      	     $missing_hour = $payroll_->missing_hour;
     	   	      	     $payroll_month = $payroll_->payroll_month;
     	   	      	     $employee = $payroll_->idPayrollSet->person->fullName;
     	   	      	}
     	   	      	
     	   	 }
	        
	     if($missing_hour!=0)
	       {
	       	   $number_of_hour = PayrollSettings::model()->getSimpleNumberHourValue($this->person_id);
	       	   $gross_for_hour = $gross_salary;
	       	 }
	       	 
	       	     	   	
?>  
  <div style="width:90%;">
            <label id="resp_form" style="width:90%;">
  
       

      <?php
         					//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                                                                                //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
                                                                                                //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
                                                                                                //Extract Phone Number
                                 $school_phone_number = infoGeneralConfig('school_phone_number');


              	
             
           echo ' <div id="print_receipt" style="float:left; padding:10px; border:1px solid #EDF1F6; width:98%; ">
                  <div id="header" style="display:none; ">
                 
                  <div class="info">'.headerLogo().'<b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' &nbsp; / &nbsp; '.Yii::t('app','Tel: ').$school_phone_number.' &nbsp; / &nbsp; '.Yii::t('app','Email: ').$school_email_address.'<br/></div> 
                  
                  <br/> 
                  
                  <div class="info" style="text-align:center;  margin-top:-9px; margin-bottom:-15px; "> <b>'.strtoupper(strtr(Yii::t('app','Payroll receipt'), pa_daksan() )).'</b></div>
                  <br/>
                  </div>'; 
                  
			echo '<div class="info" style="padding-left:30px;">
			      <div id="emp_name" style="display:none; float:left;">'.Yii::t('app','Name').':  '.$employee.' </div>
			     
			           <div id="p_month" style="display:none; margin-left:62%;">'.Yii::t('app','Payroll month').': '.Payroll::model()->getSelectedLongMonth($payroll_month).'</div> 
			           <div style="float:left;">'.Yii::t('app','Working department').': '.$working_dep.'</div> 
			      
			         <div id="p_date" style="display:none; margin-left:62%;">'.Yii::t('app','Payment date').' '.ChangeDateFormat($payment_date).' </div>   
			         
			         <br/><div style=""><b>'.Yii::t('app','Monthly gross salary').'</b>: '.$currency_symbol.' '.numberAccountingFormat($gross_salary).'</div>
			         ';
			         
			      			      
			         
			         //gad si yo pran taxe pou payroll sa
			         $employee_teacher = Persons::model()->isEmployeeTeacher($this->person_id, $acad);	
					
					 $deduct_iri=false; 
										  
					  if(!$employee_teacher)//si moun nan pa alafwa anplwaye-pwofese 
			           { 
			           	   
			           	   
			           	   echo ' <br/><div style="margin-left:1%;"> 
			           	        
			           	        <div style="margin-left:12%;"><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary).'): 
			         				<table class="" style="width:80%; background-color: #E5F1F4; color: #1E65A4; -webkit-border-top-left-radius: 5px;-webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
									   <tr>
									   
									   <td style="text-align:center; "> '.Yii::t('app',' Taxe ').' </td>
									       <td style="text-align:center; ">'.Yii::t('app','%').' </td>
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
								     	 
								     	 if($r['id_taxe']!=1) //c pa iri
								     	      {
								     	      	  $sql1 = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																		
												  $command1 = Yii::app()->db->createCommand($sql1);
												  $result1 = $command1->queryAll(); 
																			       	   
											     foreach($result1 as $r1)
											       {  $deduction = ( ($gross_salary * $r1['taxe_value'])/100);
											          $total_deduction = $total_deduction + $deduction;
								     	      	      echo '<tr>
									                             <td style="text-align:center;"> '.$r1["taxe_description"].'  </td>
															       <td style="text-align:center; ">'.$r1["taxe_value"].' </td>
															       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($deduction).'</td>
															 </tr>';

											         
											         }
											         
								     	      	}
								     	    elseif($r['id_taxe']==1)
								     	       $deduct_iri=true; 
			 						     	      	
										  
										  }
											  
									 }
				              
			           	      }  
			           	          
				                  
				             if($deduct_iri)
		                           {$iri = 0; 
		                           	$iri = getIriDeduction($id_payroll_set,$id_payroll_set2,$gross_salary);
		                           	  $total_deduction = $total_deduction + $iri;
		                           	 echo '   
									  <tr> 
									   <td style="text-align:center; "> '.Yii::t('app','IRI ').' </td>
									       <td style="text-align:center; ">&nbsp;&nbsp; </td>
									       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($iri).'</td>
									       
									       
									    </tr>';
		                              }     
				              
				                 
				               echo '  </table> 
						           </div>';  
						            
			             }
			          elseif($employee_teacher) //si moun nan alafwa anplwaye-pwofese 
			           {  
			           	     $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.person_id='.$this->person_id.' AND ps.academic_year='.$acad.' AND ps.person_id IN( SELECT id FROM persons p WHERE p.id='.$this->person_id.' AND p.active IN(1, 2)) '));
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
							               	    
								               	   if($amount->an_hour==1)
								                     {
								                         $gross_salary1 = $gross_salary1 * $number_of_hour;
								                        }
								                        
								                     
							               	       $gross_for_hour = $gross_salary1;
							               	   
							                 }
						           
						                
			           	         echo ' <br/><div style="margin-left:1%;">      
			           	               <div style="margin-left:12%;"><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary1).' '.strtolower(Yii::t('app','As').' '.Yii::t('app','Employee')).'): 
			         				<table class="" style="width:80%; background-color: #E5F1F4; color: #1E65A4; -webkit-border-top-left-radius: 5px;-webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
									   <tr>
									   
									   <td style="text-align:center; "> '.Yii::t('app',' Taxe ').' </td>
									       <td style="text-align:center; ">'.Yii::t('app','%').' </td>
									       <td style="text-align:center; "> '.Yii::t('app','Worth value').'</td>
									       
									       
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
											     	 
											     	 if($r['id_taxe']!=1) //c pa iri
											     	      {
											     	      	  $sql1 = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																					
															  $command1 = Yii::app()->db->createCommand($sql1);
															  $result1 = $command1->queryAll(); 
																						       	   
														     foreach($result1 as $r1)
														       {  $deduction1 = ( ($gross_salary1 * $r1['taxe_value'])/100);
														          $total_deduction = $total_deduction + $deduction1;
											     	      	      echo '<tr>
												                             <td style="text-align:center;"> '.$r1["taxe_description"].'  </td>
																		       <td style="text-align:center; ">'.$r1["taxe_value"].' </td>
																		       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($deduction1).'</td>
																		 </tr>';
			
														         
														         }
														         
											     	      	}
											     	    elseif($r['id_taxe']==1)
											     	       $deduct_iri=true; 
						 						     	      	
													  
													  }
														  
												 }
								              
							           	      } 
							              
							             echo '  </table> 
						                    </div>';
				                          
				                          }
				                        elseif(($as_teach==0)&&($as==1))
				                           {   $as_teach=1;
				                          
						                     if(($amount!=null))
								               {  
								               	   $id_payroll_set1 = $amount->id;
								               	   
								               	   $gross_salary1 =$amount->amount;
								               	   
								               	   $number_of_hour = $amount->number_of_hour;
								               	   
								               	   if($amount->an_hour==1)
								                     {
								                         $gross_salary1 = $gross_salary1 * $number_of_hour;
								                        }
								                        
								                     
							               	            $gross_for_hour = $gross_salary1;
								               	   
								                 }
							           
						                
					           	         echo ' <div style="margin-left:12%;"><b>'.Yii::t('app','Taxe').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary1).' '.strtolower(Yii::t('app','As').' '.Yii::t('app','Teacher')).'): 
					         				<table class="" style="width:80%; background-color: #E5F1F4; color: #1E65A4; -webkit-border-top-left-radius: 5px;-webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
											   <tr>
											   
											   <td style="text-align:center; "> '.Yii::t('app',' Taxe ').' </td>
											       <td style="text-align:center; ">'.Yii::t('app','%').' </td>
											       <td style="text-align:center; "> '.Yii::t('app','Worth value').'</td>
											       
											       
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
													     	 
													     	 if($r['id_taxe']!=1) //c pa iri
													     	      {
													     	      	  $sql1 = 'SELECT taxe_description, taxe_value FROM taxes WHERE id='.$r['id_taxe'];
																							
																	  $command1 = Yii::app()->db->createCommand($sql1);
																	  $result1 = $command1->queryAll(); 
																								       	   
																     foreach($result1 as $r1)
																       {  $deduction1 = ( ($gross_salary1 * $r1['taxe_value'])/100);
																          $total_deduction = $total_deduction + $deduction1;
													     	      	      echo '<tr>
														                             <td style="text-align:center;"> '.$r1["taxe_description"].'  </td>
																				       <td style="text-align:center; ">'.$r1["taxe_value"].' </td>
																				       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($deduction1).'</td>
																				 </tr>';
					
																         
																         }
																         
													     	      	}
													     	    elseif($r['id_taxe']==1)
													     	       $deduct_iri=true; 
								 						     	      	
															  
															  }
																  
														 }
									              
								           	      } 
								              
								           
				                     echo '  </table> 
						                    </div>';				                          
				                             
				                             }
			                       
			                   
			                      }//end foreach
			                       
			                      	
			                   
			                     if($deduct_iri)
		                           {
		                           	   $iri = 0; 
		                              	$iri = getIriDeduction($id_payroll_set,$id_payroll_set2,$gross_salary);
		                           	  $total_deduction = $total_deduction + $iri;
		                            	  
		                         echo ' <div style="margin-left:12%;"><b>'.Yii::t('app','IRI').'</b>('.$currency_symbol.' '.numberAccountingFormat($gross_salary).' '.Yii::t('app','Gross salary').'): 
					         				<table class="" style="width:80%; background-color: #E5F1F4; color: #1E65A4; -webkit-border-top-left-radius: 5px;-webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
											   <tr>
											   
											   <td style="text-align:; "> '.Yii::t('app',' Taxe ').' </td>
											       <td style="text-align:center; "> &nbsp;&nbsp;</td>
											       <td style="text-align:center; "> '.Yii::t('app','Worth value').'</td>
											       
											       
											    </tr>  
											  <tr> 
											   <td style="text-align:; "> '.Yii::t('app','IRI ').' </td>
											       <td style="text-align:center; ">&nbsp;&nbsp; </td>
											       <td style="text-align:; "> '.$currency_symbol.' '.numberAccountingFormat($iri).'</td>
											       
											       
											    </tr>
											     </table> 
						                 </div>';
		                              }     
				              


			                  }
			                   
		                   
		                    echo '     <div style="margin-left:12%;"><b>'.Yii::t('app','Total charge').'</b>: '.$currency_symbol.' '.numberAccountingFormat($total_deduction).' </div>  ';           
							         
			                 //tcheke loan
			               $loan = 0;
			               $loan = Payroll::model()->getLoanDeduction($this->person_id,$gross_salary,$number_of_hour,$missing_hour,$net_salary,$taxe);
			                   $total_deduction = $total_deduction + $loan;
			      echo '     <br/><div style="margin-left:12%;"><b>'.Yii::t('app','Loan(deduction)').'</b>: '.$loan.' </div>  ';
			          
/*if($missing_hour!=0)
	       {
	       	   $number_of_hour = PayrollSettings::model()->getSimpleNumberHourValue($this->person_id);
	       	   $gross_salary_deduction = ($gross_for_hour * $missing_hour) / $number_of_hour;
	       	   
	       	   $total_deduction = $total_deduction + $gross_salary_deduction;
	       	   
	       	    echo '     <br/><div style="margin-left:12%;">'.Yii::t('app','Deduction').' ('.Yii::t('app','Missing hour').': '.$missing_hour.') : '.$gross_salary_deduction.' </div>  ';
	       	   
	       	 }
			   */       
			      echo '    <br/><div style=""><b>'.Yii::t('app','Total deduction').'</b>: '.$currency_symbol.' '.numberAccountingFormat($total_deduction).' </div>  ';
			       
			       
			         
			      echo '    <br/><div style=""><b>'.Yii::t('app','Monthly net salary').'</b>: '.$currency_symbol.' '.numberAccountingFormat($net_salary).' </div>
			      
			      </div>
			      <br/>
			      <div style="text-indent: 450px; font-weight: bold; font-style: italic;"> &nbsp;&nbsp;&nbsp;'.Yii::t('app','Authorized signature').'</div><br/><br/>
			         
			       </div>
		<div style="float:right; text-align: right; font-size: 6px; margin-bottom:-8px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>		      
			     </div>
		     
			     </div>';
										
	   ?>
	   </label>
    </div>    
    
       
<?php       

     }
   else
     {
   ?>  	                    
                        <div class="list_secondaire" style="margin-left:10px; width:90%;">
											

			<?php
			$provider_to_show_button=null;
			$header='';
              $condition='';
               
               $di= 1;
	           $month_= '';
	           $year_= '';
	   
	                                   
                                       $header=Yii::t('app','Full name');
                                   	   $condition='p.is_student=0 AND p.active IN(1, 2) ';
                                   	   
                  	    	$dataProvider=Payroll::model()->searchPersonsForUpdatePayroll($condition,$this->payroll_month,$this->payroll_date, $acad);
                  	    				  			
				  			if($this->message_noOneSelected)
				  			 { echo ' <label style="width:100%; padding-left:0px;margin-right:250px; margin-bottom:-20px;"><div class="" style=" padding-left:0px;margin-right:290px; margin-bottom:-48px; ">';//-20px; ';
				  			 
				  			 	echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
								   <tr>
								    <td style="text-align:center;">';
					    
				  			 	echo '<span style="color:red;" >'.Yii::t('app','You must select at least a person.').' </span> <br/>';
				  			 	  $this->message_noOneSelected =false;
				  			 	
				  			 	   echo'</td>
								    </tr>
									</table>';
									
									 echo '</div></label>';
									 
									 $this->message_noOneSelected = false;
									 
				  			 	}
				  			 			   
				  	               
					    
					    $this->widget('groupgridview.GroupGridView', array(
					    'id'=>'payroll-grid',
						'dataProvider'=>$dataProvider,
						'showTableOnEmpty'=>'true',
						'selectableRows' => 2,
	                    'mergeColumns'=>array('payment_date', $header,'payroll_month'),
						//'filter'=>$model,
					    'columns'=>array(
						 
				                                       
                       array('name' =>'payment_date',
						       'header' =>Yii::t('app','Payment Date'), 
					            'value'=>'$data->PaymentDate', 
					             ),
         
                       array('name'=>$header,
					                'header'=>$header,
					                'type' => 'raw',
						       'value'=>'$data->first_name." ".$data->last_name'
								),
					    
					    array('header' =>Yii::t('app','Gross salary'), 
					               'type' => 'raw',
					            'value'=>'$data->getGrossSalaryInd($data->person_id,$data->payroll_month,getYear($data->payment_date))',
					             ),
					  
						array('name'=>Yii::t('app','Taxe'),
						                'header'=>Yii::t('app','Taxe'),
							        'value'=>'$data->Taxe',
									),
									
						array('name'=>Yii::t('app','Loan(deduction)'),
						                'header'=>Yii::t('app','Loan(deduction)'),
		         'value'=>'$data->getLoanDeduction($data->person_id,$data->getGrossSalaryIndex_value($data->person_id,$data->payroll_month,getYear($data->payment_date)),$data->number_of_hour,$data->missing_hour,$data->net_salary,$data->taxe)',
									),
						 			
						array('header' =>Yii::t('app','Net Salary'), 
					            'value'=>'$data->NetSalary',
					             ),
					             
					   
					   array('header' =>Yii::t('app','Cash/Check'), 
					            'value'=>'$data->cash_check',
					             ),
					             
					     
					    	array(             'class'=>'CCheckBoxColumn',   
					                           'id'=>'chk',
					                 ), 
							
					       ),
					    ));
					    

					                          							

                    

			 ?>

 
 
                        </div>  </div>       
                   
		           
<br/>        
<?php
       }
 ?>      		    
             <div class="col-submit">                             
                                <?php  
									   if(($this->payrollReceipt_available)&&($this->messagePayrollReceipt_available))
                                         {  
                                         	if((isset($_GET['id']))&&($_GET['id']!=''))
                                         	  {
									       ?><a  class="btn btn-success col-4" style="margin-left:10px; margin-right: 5px;" onclick="printDiv('print_receipt')"><?php echo Yii::t('app','Print'); ?></a>   <?php }}									                         
                                             echo CHtml::submitButton(Yii::t('app', 'Create PDF'),array('name'=>'viewPDF','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                           // echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                       
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				                         
				                         if(isset($_GET['id'])&&($_GET['id']!=''))
				                             echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
				                         else
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                        
                                ?>
              
             </div>
<?php        
	}
	?>
                     
                     
        </form>
  
    </div>



<script type="text/javascript">
    
function printDiv(divName) {
     document.getElementById("header").style.display = "block";
     document.getElementById("emp_name").style.display = "block";
    document.getElementById("p_month").style.display = "block";
    document.getElementById("p_date").style.display = "block";
     document.getElementById(divName).style.display = "block";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
     document.getElementById("header").style.display = "none";
     document.getElementById("emp_name").style.display = "none";
    document.getElementById("p_month").style.display = "none";
    document.getElementById("p_date").style.display = "none";
} 


</script>


