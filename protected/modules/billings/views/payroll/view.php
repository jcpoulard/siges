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
/* @var $model Payroll */

$acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year'];
$currency_name = Yii::app()->session['currencyName'];
$currency_symbol = Yii::app()->session['currencySymbol']; 
$type_profil = Yii::app()->session['profil_selector'];


     if(isset($_GET['all_']))
       $this->group=Yii::app()->session['payroll_group'];
     
     $this->grouppayroll=Yii::app()->session['payroll_group_payroll'];
     
     
     if(Yii::app()->session['payroll_payroll_month_']!='')
        { $this->payroll_month=Yii::app()->session['payroll_payroll_month_'];
             
        }
     else
        {
        	$this->payroll_month=1;
        	
        	}



?>

<?php
if(Yii::app()->user->profil=='Manager' || Yii::app()->user->profil=='Teacher' || $type_profil == "emp" || $type_profil=="teach"){ 
    if(isset($_GET['id'])){
    $id_person = $_GET['id'];
    $data = User::model()->findAllBySql("SELECT id FROM users where person_id = (SELECT DISTINCT ps.person_id FROM payroll p join payroll_settings ps ON (p.id_payroll_set = ps.id) where p.id = $id_person)");
    
    $compteur=0;
    foreach($data as $d){
       // echo $d->id;
        if($d->id == Yii::app()->user->userid){
            
            $compteur = 1;
        }
    }
   
    
}

if($compteur==1){
    
}else{
    Yii::app()->user->setFlash(Yii::t('app','Violation'), Yii::t('app','{name}, You tried to violate your access level !',array('{name}'=>Yii::app()->user->fullname)));
   $this->redirect(Yii::app()->user->returnUrl);
}
    
}
    
    

?>

<div id="dash">
          
          <div class="span3"><h2>
               <?php 
                 
                      echo Yii::t('app', 'Payroll').' : '.$model->longMonth.' / '.$model->idPayrollSet->person->fullName;            
                  ?>
               
          </h2> </div>
     
		   <div class="span3">
  
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '';  
        
   ?>


<?php 
      if( (Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Billing') )
		{     
			    	
  ?>
            
           <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                    if((isset($_GET['from1']))&&($_GET['from1']=='vfr'))
                        echo CHtml::link($images,array('/billings/payroll/create/id/'.$model->id.'/part/pay/emp/'.$_GET['emp'].'/month_/'.$_GET['month_'].'/year_/'.$_GET['year_'].'/di/'.$_GET['di'].'/from1/vfr/from/emp/part/pay/add'));
                     else
                        echo CHtml::link($images,array('/billings/payroll/create/part/pay/from/stud')); 

                   ?>

              </div>
              
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard 

                        
	                   if((isset($_GET['from1']))&&($_GET['from1']=='vfr'))
                            echo CHtml::link($images,array('/billings/payroll/update/','id'=>$model->id,'from'=>'view','month_'=>$_GET['month_'], 'year_'=>$_GET['year_'], 'di'=>$_GET['di'],'emp'=>$_GET['emp'],'from1'=>'vfr', 'part'=>'pay')); 
                        else
                           echo CHtml::link($images,array('/billings/payroll/update/','id'=>$model->id,'from'=>'view','month_'=>$_GET['month_'], 'year_'=>$_GET['year_'], 'di'=>$_GET['di'], 'part'=>'pay'));
	                   
                     ?>

              </div> 
  
<?php }  ?>  
         
         

 <?php
        }
      
      ?>       
              
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                if( (Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Billing') )
		           { 
                        if((isset($_GET['from1']))&&($_GET['from1']=='vfr'))
                           {
                           	  if($_GET['from']=='emp')
                           	    echo CHtml::link($images,array('/academic/persons/viewForReport/id/'.$_GET['emp'].'/from/emp'));
                           	  elseif($_GET['from']=='teach')
                           	      echo CHtml::link($images,array('/academic/persons/viewForReport/id/'.$_GET['emp'].'/isstud/0/from/teach'));
                           	 
                           }
                        else
                            echo CHtml::link($images,array('/billings/payroll/index/month_/'.$_GET['month_'].'/year_/'.$_GET['year_'].'/di/'.$_GET['di'].'/part/pay/from')); 
                            
		              }
		            else
		               echo CHtml::link($images,array('/'));
                                         

                   ?>

            </div> 

        </div>
  </div>



<div style="clear:both"></div>


<?php
	        
          $dataProvider_noPerson ='';
          $dataProvider_updateOne ='';
          $condition='';   

	
	   	        

       		
	?>


<div class="row-fluid" >
	
		         
<?php 


	
	 if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_UpdatePastDate=true;
	
			//error message
	    if(($this->message_UpdatePastDate))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-8px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }			      
				 				   
				  if($this->message_UpdatePastDate)
				     { echo '<span style="color:red;" >'.Yii::t('app','19 days after payment date, Update Action is denied.<br/>').'</span>';
				        	 echo'</td>
							    </tr>
								</table>';
							
					           echo '</div>
					           <div style="clear:both;"></div>';
                           
                            $this->message_UpdatePastDate=false;
				       }
				     
				 
		

?>

<div class="span6 grid-view">

<?php

$this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array('name'=>Yii::t('app','Salary'),
		                'header'=>Yii::t('app','Salary'),
			        'value'=>$model->getGrossSalaryInd($model->idPayrollSet->person_id,$model->payroll_month,getYear($model->payment_date)),
					),
					
        
        array('name'=>Yii::t('app','Number Of Hour'),
		                'header'=>Yii::t('app','Number Of Hour'),
			        'value'=>$model->idPayrollSet->numberHour,
					),
		array('name'=>Yii::t('app','Taxe'),
		                'header'=>Yii::t('app','Taxe'),
			        'value'=>"$model->Taxe",
					),
					
		array('name'=>Yii::t('app','Loan(deduction)'),
		                'header'=>Yii::t('app','Loan(deduction)'),
			        'value'=>$currency_symbol.' '.numberAccountingFormat($model->getLoanDeduction($model->idPayrollSet->person_id,$model->getGrossSalaryIndex_value($model->idPayrollSet->person_id,$model->payroll_month,getYear($model->payment_date)),$model->idPayrollSet->number_of_hour,0,$model->net_salary,$model->taxe) ),//$model->getLoanDeduction($model->idPayrollSet->person_id,$model->getGrossSalary($model->idPayrollSet->person_id),$model->idPayrollSet->number_of_hour,$model->missing_hour,$model->net_salary,$model->taxe),
					),
					
		array('name'=>Yii::t('app','Net Salary'),
			'value'=>$model->NetSalary),
		
		array('name'=>'payroll_date',
			//'header'=>Yii::t('app','Payroll Date'), 
			'value'=>$model->PayrollDate),
	        
	   
		array('name'=>'payment_date',
			//'header'=>Yii::t('app','Payment Date'), 
			'value'=>$model->PaymentDate),
	        
	     array('name'=>'cash_check',
			//'header'=>Yii::t('app','Cash/Check'), 
			'value'=>$model->cash_check),
	),
	
)); 



  
?>

    </div>
 
  


   
<div class="span2 photo_view">
    <?php
    
         
    if($model->idPayrollSet->person->image!=null)
                    
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/photo-Uploads/1/'.$model->idPayrollSet->person->image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
    ?>


    
</div>
      
</div>





<div style="clear:both"></div>
 <!-- Seconde ligne -->
 

<div class="row-fluid" style="margin-top:5px;">
  
    <div>   
        <ul class="nav nav-tabs">
        
<?php if(((isset($_GET['id']))&&(isset($_GET['emp'])))||( (Yii::app()->user->profil!='Admin')&&(Yii::app()->user->profil!='Billing') )){ ?>
    <li class="active"><a data-toggle="tab" href="#transaction_list">  <?php echo Yii::t('app','Payroll history'); ?></a></li>
    
    <li ><a data-toggle="tab" href="#payroll_receipt">  <?php echo Yii::t('app','Payroll receipt'); ?></a></li> 
    
    <li ><a data-toggle="tab" href="#loan">  <?php echo Yii::t('app','Loan history'); ?></a></li>    
      
<?php  $class1="tab-pane fade";
        $class2="tab-pane fade in active";
        
       }else{  ?>
        	<li class="active"><a data-toggle="tab" href="#payroll_receipt">  <?php echo Yii::t('app','Payroll receipt'); ?></a></li>
    
            <li ><a data-toggle="tab" href="#transaction_list">  <?php echo Yii::t('app','Payroll history'); ?></a></li>
            
            <li ><a data-toggle="tab" href="#loan">  <?php echo Yii::t('app','Loan history'); ?></a></li> 
 <?php  
        $class1="tab-pane fade in active";
        $class2="tab-pane fade";

       }
        
       ?>
    
        </ul>
  
  
   <div class="tab-content">
    
     <!--  ************************** payroll receipt *************************    -->
   
<div id="payroll_receipt" class="<?php echo $class1; ?>" >
      
       <div class="grid-view">

	<?php
	
		//Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                 //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
                                  //Extract  email address 
                                $school_email_address = infoGeneralConfig('school_email_address');
                                   //Extract Phone Number
                                $school_phone_number = infoGeneralConfig('school_phone_number');


								
								
									
?>
	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
       
<?php
   
         
         $employee = $model->idPayrollSet->person->fullName;
         
         $id_payroll_set ='';
         $id_payroll_set2 ='';
     	$payment_date ='';
     	$payroll_date = '';
     	$net_salary = 0;
     	$taxe = 0;
     	$total_deduction = 0;
     	$number_of_hour = null;
     	$missing_hour = 0;
     	$gross_for_hour = 0;
     	
     	$title = Persons::model()->getTitles($model->idPayrollSet->person->id,$acad);
     	$working_dep = Persons::model()->getWorkingDepartment($model->idPayrollSet->person->id,$acad);
     	$gross_salary= Payroll::model()->getGrossSalaryIndex_value($model->idPayrollSet->person->id,$model->payroll_month,getYear($model->payment_date));
     	$currency = '';
     /*   $currency_result = Fees::model()->getCurrency($acad);
     	foreach($currency_result as $result)
     	 {
     	 	$currency = $result["devise_name"].'('.$result["devise_symbol"].')';
     	 	break;
     	 	 }
       
       $currency = $currency_name.' '.$currency_symbol;
       */  
        
        //cheche payroll la
     	 $modelPayroll = Payroll::model()->searchByMonthPersonId($model->payroll_month, $model->payroll_date, $model->idPayrollSet->person->id, $acad);
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
   	   	      	     
     	   	      	}
     	   	      	
     	   	 }
	     
	     if($missing_hour!=0)
	       {
	       	   $number_of_hour = PayrollSettings::model()->getSimpleNumberHourValue($model->idPayrollSet->person->id);
	       	   $gross_for_hour = $gross_salary;
	       	 }
	       	 
 
		 

?>  

 <div style="width:85%;">
            <label id="resp_form" style="width:100%;">
  
       

      <?php
         	
         				             
           echo '<div id="print_receipt" style="float:left; padding:10px; border:1px solid #EDF1F6; width:98%; ">
                  <div id="header" style="display:none; ">
                 
                  <div class="info">'.headerLogo().'<b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' &nbsp; / &nbsp; '.Yii::t('app','Tel: ').$school_phone_number.' &nbsp; / &nbsp; '.Yii::t('app','Email: ').$school_email_address.'<br/></div> 
                  
                  <br/> 
                  
                  <div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Payroll receipt'), pa_daksan() )).'</b></div>
                  <br/>
                  </div>'; 
                  
			echo '<div class="info" style="padding-left:30px;">
                       <div id="emp_name" style="float:left; display:none;">'.Yii::t('app','Name').': '.$employee.' </div>
			      
			         <div id="p_month" style="margin-left:62%; display:none;">'.Yii::t('app','Payroll month').': '.$model->getSelectedLongMonth($model->payroll_month).'</div> 
			               <div style="float:left;">'.Yii::t('app','Working department').': '.$working_dep.'</div> 
			      
			         <div id="p_date" style="margin-left:62%; display:none;">'.Yii::t('app','Payment date').' '.ChangeDateFormat($model->payment_date).' </div>    
			         
			             <br/><div style=""><b>'.Yii::t('app','Monthly gross salary').'</b>: '.$currency_symbol.' '.numberAccountingFormat($gross_salary).'</div>';
			        
			         
			         //gad si yo pran taxe pou payroll sa
			         $employee_teacher = Persons::model()->isEmployeeTeacher($model->idPayrollSet->person->id, $acad);	
					
					 $deduct_iri=false; 
										   
					  if(!$employee_teacher)//si moun nan pa alafwa anplwaye-pwofese 
			           { 
			           	   
			           	   
			           	   echo ' <br/><div style="margin-left:1%;">
			           	   
			           	     <div style="margin-left:12%;"><b>'.Yii::t('app','Taxe').'</b>( '.$currency_symbol.' '.numberAccountingFormat($gross_salary).'): 
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
								     	      	      echo '<tr>
									                             <td style="text-align:center;"> '.$tx_des.'  </td>
															       <td style="text-align:center; ">'.$tx_val.' </td>
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
			          elseif($employee_teacher)//si moun nan alafwa anplwaye-pwofese 
			           {  
			           	     if(($id_payroll_set2=='')||($id_payroll_set2==NULL))
							    $criteria = new CDbCriteria(array('alias'=>'ps', 'order'=>'date_created DESC', 'condition'=>'ps.id IN('.$id_payroll_set.')'));
                             else						
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
											     	      	      echo '<tr>
												                             <td style="text-align:center;"> '.$tx_des.'  </td>
																		       <td style="text-align:center; ">'.$tx_val.' </td>
																		       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($deduction1).'</td>
																		 </tr>';
			
														         
														         
														         
											     	      	}
											     	    elseif($tx_des=='IRI')
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
								               	   $id_payroll_set2 = $amount->id;
								               	   
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
													     	      	      echo '<tr>
														                             <td style="text-align:center;"> '.$tx_des.'  </td>
																				       <td style="text-align:center; ">'.$tx_val.' </td>
																				       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($deduction1).'</td>
																				 </tr>';
					
																         
																         
																         
													     	      	}
													     	    elseif($tx_des=='IRI')
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
		                              	$iri = getIriDeduction($id_payroll_set,$id_payroll_set2,$gross_salary);;
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
											       <td style="text-align:center; "> '.$currency_symbol.' '.numberAccountingFormat($iri).'</td>
											       
											       
											    </tr>
											     </table> 
						                 </div>';
		                              }     
				              


			                  }
			                   
		                              
						 echo '     <div style="margin-left:12%;"><b>'.Yii::t('app','Total charge').'</b>: '.$currency_symbol.' '.numberAccountingFormat($total_deduction).' </div>  ';
						          
			                 //tcheke loan
			                 $loan = 0;
			               //$loan = Payroll::model()->getLoanDeduction($model->idPayrollSet->person->id,$gross_salary,$number_of_hour,$missing_hour,$net_salary,$taxe);
			               $loan = Payroll::model()->getLoanDeduction($model->idPayrollSet->person->id,$gross_salary,$number_of_hour,0,$net_salary,$taxe);
			                   
			      echo '     <br/><div style="margin-left:12%;"><b>'.Yii::t('app','Loan(deduction)').'</b>: '.$currency_symbol.' '.numberAccountingFormat($loan).' </div>  ';
			          
			          
			          $total_deduction = $total_deduction + $loan;
			          
/*if($missing_hour!=0)
	       {
	       	   $number_of_hour = PayrollSettings::model()->getSimpleNumberHourValue($model->idPayrollSet->person->id);
	       	   $gross_salary_deduction = ($gross_for_hour * $missing_hour) / $number_of_hour;
	       	   
	       	   $total_deduction = $total_deduction + $gross_salary_deduction;
	       	   
	       	    echo '     <br/><div style="margin-left:12%;">'.Yii::t('app','Deduction').' ('.Yii::t('app','Missing hour').': '.$missing_hour.') : '.$gross_salary_deduction.' </div>  ';
	       	   
	       	 }
			*/          
			      echo '    <br/><div style=""><b>'.Yii::t('app','Total deduction').'</b>: '.$currency_symbol.' '.numberAccountingFormat($total_deduction).' </div>  ';
			       
			       
			         
			      echo '    <br/><div style=""><b>'.Yii::t('app','Monthly net salary').'</b>: '.$currency_symbol.' '.numberAccountingFormat($net_salary).' </div>
			      
			      <br/>
			      <div style="text-indent: 450px; font-weight: bold; font-style: italic;"> &nbsp;&nbsp;&nbsp;'.Yii::t('app','Authorized signature').'</div><br/><br/>
			         
			       </div>
		<div style="float:right; text-align: right; font-size: 6px; margin-bottom:-8px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>	      
			     </div>
			     
			     </div>';
																			
	   ?>
	   </label>
    </div> 

<br/>
                 
                            <div class="col-submit">
 
                                
                                <?php  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                     //  if($dataPro->getData()!=null)
                                     //    {
									       ?><a  class="btn btn-success col-4" style="margin-left:10px; margin-right: 50px;" onclick="printDiv('print_receipt')"><?php echo Yii::t('app','Print'); ?></a>   <?php
									     
									     echo '<br/>';
									               
                                     //    }
                                         
                                         
                                              //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				                        if( (Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Billing') )
		                                  {
                                              echo '  <a href="'.$explode_url[0].'php/billings/payroll/index/month_/'.$_GET['month_'].'/year_/'.$_GET['year_'].'/di/'.$_GET['di'].'/part/pay/from" style="margin-left:10px;margin-top:10px;" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
		                                    }
		                                  else
		                                     echo '  <a href="'.$explode_url[0].'php" style="margin-left:10px;margin-top:10px;" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                ?>
     
                            
                  </div><!-- /.table-responsive -->
                  
<?php
 
?>

                  
                </form>
              </div>



    </div>
</div>   
   
   <!--  ************************** Transactions list *************************    -->

<div id="transaction_list" class="<?php echo $class2; ?>" >
       
    
<?php
 
 
$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'billings-grid',
	'dataProvider'=>Payroll::model()->searchByPersonId($model->idPayrollSet->person->id,$acad),
	'showTableOnEmpty'=>true,
	//'emptyText'=>Yii::t('app','No academic period found'),
	'summaryText'=>'',
     'mergeColumns'=>array('payment_date', 'payroll_month'),
						//'filter'=>$model,
					    'columns'=>array(
						 // 'id',
							
						
						                                         
                       //'payment_date',
						array('name' =>'payment_date',
						       'header' =>Yii::t('app','Payment date'), 
						       'type' => 'raw',
					            'value'=>'CHtml::link($data->PaymentDate,Yii::app()->createUrl("/billings/payroll/view",array("id"=>$data->id, "from"=>"pay","id_"=>$data->id,"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->PaymentDate', 
					             ),
                      
                       //'payroll_month',
					    array('name'=>'payroll_month',
		                'header'=>Yii::t('app','Payroll month'),
		                 'type' => 'raw',
					      'value'=>'CHtml::link($data->longMonth,Yii::app()->createUrl("/billings/payroll/view",array("id"=>$data->id, "from"=>"pay","id_"=>$data->id,"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->longMonth',
			            'htmlOptions'=>array('style'=>'vertical-align: top'),
                         ),
                         
						
                     /*  array('name'=>Yii::t('app',' name'),
					                'header'=>Yii::t('app',' name'),
					                'type' => 'raw',
						        'value'=>'$data->idPayrollSet->person->first_name." ".$data->idPayrollSet->person->last_name'
								),
					    */
					    
					    array('header' =>Yii::t('app','Gross salary'), 
					               'type' => 'raw',
					            'value'=>'CHtml::link($data->getGrossSalaryInd($data->idPayrollSet->person_id,$data->payroll_month,getYear($data->payment_date)),Yii::app()->createUrl("/billings/payroll/view",array("id"=>$data->id, "from"=>"pay","id_"=>$data->id,"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->getGrossSalary($data->idPayrollSet->person_id)',
					             ),
					    
					    //'number_of_hour',
						/*	array('name'=>'number_of_hour',
							                'header'=>Yii::t('app','Number Of Hour'),
								        'value'=>'$data->NumberHour',
										),
							*/
					    /* array('header' =>Yii::t('app','Deduction').' ('.Yii::t('app','Missing hour').')', 
					            'value'=>'$data->getMissingHourDeduction($data->idPayrollSet->person_id,$data->missing_hour)',
					             ),
					      */
					      
						//'taxe', 
						array('name'=>Yii::t('app','Taxe'),
						                'header'=>Yii::t('app','Taxe'),
							        'type' => 'raw',
					            'value'=>'CHtml::link($data->Taxe,Yii::app()->createUrl("/billings/payroll/view",array("id"=>$data->id, "from"=>"pay","id_"=>$data->id,"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->taxe',
									),
									
						array('name'=>Yii::t('app','Loan(deduction)'),
						                'header'=>Yii::t('app','Loan(deduction)'),
		         'type' => 'raw',
					            'value'=>'CHtml::link($data->getLoanDeduction($data->idPayrollSet->person_id,$data->getGrossSalaryIndex_value($data->idPayrollSet->person_id,$data->payroll_month,getYear($data->payment_date)),$data->number_of_hour,0,$data->net_salary,$data->taxe),Yii::app()->createUrl("/billings/payroll/view",array("id"=>$data->id, "from"=>"pay","id_"=>$data->id,"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->getLoanDeduction($data->idPayrollSet->person_id,$data->getGrossSalary($data->idPayrollSet->person_id),$data->number_of_hour,0,$data->net_salary,$data->taxe)', //'$data->getLoanDeduction($data->idPayrollSet->person_id,$data->getGrossSalary($data->idPayrollSet->person_id),$data->number_of_hour,$data->missing_hour,$data->net_salary,$data->taxe)',
									),
						 			
						//'net_salary',
						array('header' =>Yii::t('app','Net Salary'), 
					            'type' => 'raw',
					            'value'=>'CHtml::link($data->NetSalary,Yii::app()->createUrl("/billings/payroll/view",array("id"=>$data->id, "from"=>"pay","id_"=>$data->id,"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->net_salary',
					             ),
					             
										    	        
							
					       ),
					    ));

?>



</div>

   <!--  ************************** Loan *************************    -->

<div id="loan" class="tab-pane fade" >
       
    
<?php
 
 
$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'billings-grid',
	'dataProvider'=>LoanOfMoney::model()->searchForView($model->idPayrollSet->person->id,$acad),
	'showTableOnEmpty'=>true,
	//'emptyText'=>Yii::t('app','No academic period found'),
	'summaryText'=>'',
     //'mergeColumns'=>array(),
						//'filter'=>$model,
					    'columns'=>array(
						 
							
						
		array('name'=>'loan_date',
		                //'header'=>Yii::t('app','Loan date'),
		                'type' => 'raw',
			        'value'=>'CHtml::link($data->LoanDate,Yii::app()->createUrl("/billings/loanOfMoney/view",array("id"=>$data->id, "from"=>"pay","id_"=>'.$_GET['id'].',"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->LoanDate',
					),				                                         
                      
         array('name'=>'amount',
		                'header'=>Yii::t('app','Amount'),
		                'type' => 'raw',
			        'value'=>'CHtml::link($data->Amount,Yii::app()->createUrl("/billings/loanOfMoney/view",array("id"=>$data->id, "from"=>"pay","id_"=>'.$_GET['id'].',"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))',
			        ),
			        
		array('name'=>'repayment_start_on',
		                'header'=>Yii::t('app','Repayment start on'),
		                'type' => 'raw',
			        'value'=>'CHtml::link($data->longMonth,Yii::app()->createUrl("/billings/loanOfMoney/view",array("id"=>$data->id, "from"=>"pay","id_"=>'.$_GET['id'].',"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->longMonth',
					),
		
		array('name'=>'paid',
		                'header'=>Yii::t('app','Paid'),
		                'type' => 'raw',
			        'value'=>'CHtml::link($data->loanPaid,Yii::app()->createUrl("/billings/loanOfMoney/view",array("id"=>$data->id, "from"=>"pay","id_"=>'.$_GET['id'].',"month_"=>'.$_GET['month_'].',"year_"=>'.$_GET['year_'].',"di"=>'.$_GET['di'].')))', //'$data->loanPaid',
					),
					             
										    	        
							
					       ),
					    ));

?>



</div>



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






