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


 $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
   
$acad=Yii::app()->session['currentId_academic_year']; 
$current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
$currency_name = Yii::app()->session['currencyName'];
$currency_symbol = Yii::app()->session['currencySymbol']; 


     
				  

?>


	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
       <div class="col-4">
            <label id="resp_form">
    
                    <?php   echo $form->labelEx($model,'payroll_month');    ?>
                    
                    <?php 
                         
                          	    if($this->payroll_month!=null)
				                   {
								     echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValue(),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true))    ));
							       }
							    else
							      {
							        echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValue(),array('onchange'=> 'submit()'    ));
							       }
					   
					    ?>
                         
                        <?php echo $form->error($model,'payroll_month'); ?>
		       
		     </label>
        </div> 
          
   


  
 
 <div style="width:96%;">
   <label  style="width:100%;">
   
       
<?php

 //error message 
	        	if($this->payroll_month=='')
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ';//-20px; ';
				      echo '">';
				      				      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			       
			       }			      
				 					     	
				   
				    if($this->payroll_month=='')
				      {  echo '<span style="color:red;" > '.Yii::t('app','Payroll not yet done.').'</span>'.'<br/>';
				      }
				      				   
						   
			     if($this->payroll_month=='')
			      { 
					 echo'</td>
					    </tr>
						</table>';
					
                      echo '</div>';
			       }
       		


      
          //Extract school name 
								$school_name = infoGeneralConfig('school_name');
                                 //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
                                  //Extract  email address 
                                $school_email_address = infoGeneralConfig('school_email_address');
                                   //Extract Phone Number
                                $school_phone_number = infoGeneralConfig('school_phone_number');

   
         		
			$provider_to_show_button=null;
			$header='';
              $condition='';
               
               $di= 1;
	           $month_= '';
	           $year_= '';
	   
	                                   
                            $condition='p.is_student=0 AND p.active IN(1, 2) ';
          
        
                                            
         echo '<div id="print_receipt" style="float:left; padding:10px; border:1px solid #EDF1F6; width:100%; ">
                 <!-- <div class="info"> <b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' <br/>'.Yii::t('app','Tel: ').$school_phone_number.'<br/>'.Yii::t('app','Email: ').$school_email_address.'</div> 
                 -->
                  
                   <div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Monthly declaration sheet'), pa_daksan() )).'</b>  </div> '; 
			
			echo '<br/>';
                


		 echo '<table style="font-size:12px; background-color:#F4F6F6;">
		           <tr>
		               <td><b>'.Yii::t('app','#').'</b></td> <td><b>'.Yii::t('app','Last name').'</b></td>  <td><b>'.Yii::t('app','First name').'</b></td>  <td style="text-align:right;"><b>'.Yii::t('app','Gross salary').'</b></td>';

                  $all_taxes = Reports::getTaxesForFDM($acad);
               
             if($all_taxes!=null)
              {   
		       foreach($all_taxes as $taxe)
		        {
				 if($taxe['employeur_employe']==0)
			   	  {  	
			  
			   	  if($taxe['taxe_description']=="ONA")
			   	    {
			   	    	//ONA Employe
			   	    	if($taxe['employeur_employe']==0)
			   	    	 {
			   	    	    echo '<td style="text-align:right;"> <b>'.Yii::t('app','ONA').'</b></td>';// '.Yii::t('app','Employee').'</b></td>';
			   	         }
			   	      
	                  }
			   	   elseif($taxe['taxe_description']=="TMS")  //for TOP/TMS
			   	     { 
			   	     	 echo '<td style="text-align:right;"> <b>'.Yii::t('app','TMS').'</b></td>';
			   	        
			   	       }
			   	     elseif($taxe['taxe_description']=="IRI")  //for impot sur le revenu
			   	     { 
			   	     	echo '<td style="text-align:right;"> <b>'.Yii::t('app','IRI ').'</b></td>';
			   	         
	                  }
			   	     else
			   	       {
			   	         echo '<td style="text-align:right;"> <b>'.Yii::t('app',$taxe['taxe_description']).'</b></td>';
			   	        }
			   	  
				  
				
				  }
				
				
			   	 }
			   	 
              }
                  
          echo ' <td style="text-align:right;"><b>'.Yii::t('app','Net Salary').'</b></td></tr>'; 
                    
            
            if($this->payroll_month !='')  
              {
                 $prosper_metuschael =1;  
                $modelPersonPayroll=Payroll::model()->searchPersonsInPayrollForReports($condition,$this->payroll_month, $acad);
         
               $modelPersonPayroll = $modelPersonPayroll->getData();
                  
		     	 if($modelPersonPayroll!=null)
		     	   {
		     	   	    foreach($modelPersonPayroll as $personPayroll_)
		     	   	     {
		     	   	        echo ' <tr>';
		     	   	           echo ' <td>'.$prosper_metuschael.'</td> <td>'.$personPayroll_->last_name.'</td><td>'.$personPayroll_->first_name.'</td>';
		     	   	           $gross_salary= Payroll::model()->getGrossSalaryPerson_idMonthAcad($personPayroll_->person_id,$personPayroll_->payroll_month, $acad  );
		     	   	           
		     	   	           echo ' <td style="text-align:right;">'.numberAccountingFormat($gross_salary).'</td>';
		    	   	           
		     	   	           $total_deduction = 0;
		     	   	           
		     	   	        if($all_taxes!=null)
                             {
                               foreach($all_taxes as $taxe)
						        {
					 			if($taxe['employeur_employe']==0)
			   	    	         { 	  
							   	  if($taxe['taxe_description']=="ONA")
							   	      {
							   	    	//ONA Employe
							   	    	if($taxe['employeur_employe']==0)
							   	    	 {
							   	    	 	$deduction = 0;
							   	     	 	
							   	    	    $deduction =getDeductionTaxeForReport($personPayroll_->person_id,$taxe['id'],$personPayroll_->payroll_month,$acad); 
											          $total_deduction = $total_deduction + $deduction;
											          
							   	    	    echo '<td style="text-align:right;"> '.numberAccountingFormat($deduction).'</td>';// '.Yii::t('app','Employee').'</b></td>';
							   	         }
							   	      
					                  }
							   	   elseif($taxe['taxe_description']=="TMS")  //for TOP/TMS
							   	     { 
							   	     	$deduction = 0;
							   	    	 
							   	     	 $deduction = getDeductionTaxeForReport($personPayroll_->person_id,$taxe['id'],$personPayroll_->payroll_month,$acad);
											          $total_deduction = $total_deduction + $deduction;
									     echo '<td style="text-align:right;"> '.numberAccountingFormat($deduction).'</td>';
							   	        
							   	       }
							   	     elseif($taxe['taxe_description']=="IRI")  //for impot sur le revenu
							   	     { 
							   	     	$deduction = 0;
							   	     	
							   	     	//get id payroll_setting for this person
				                         $id_pay_set= PayrollSettings::model()->getIdPayrollSettingByPersonId($personPayroll_->person_id);
				                                             
				                          $total_gross_salary = Payroll::model()->getGrossSalaryPerson_idMonthAcad($personPayroll_->person_id,$personPayroll_->payroll_month, $acad  );    
							  	    	
							  	    	   $deduction = getIriDeduction($personPayroll_->id_payroll_set,$personPayroll_->id_payroll_set2, $total_gross_salary);
			  	    	  
							   	    	    $total_deduction = $total_deduction + $deduction;
									     echo '<td style="text-align:right;"> '.numberAccountingFormat($deduction).'</td>';
							   	         
					                  }
							   	     else
							   	       {
							   	       	    $deduction = 0;
							   	         $deduction =getDeductionTaxeForReport($personPayroll_->person_id,$taxe['id'],$personPayroll_->payroll_month,$acad);
											          $total_deduction = $total_deduction + $deduction;
										   echo '<td style="text-align:right;"> '.numberAccountingFormat($deduction).'</td>';
							   	        }
							   	  
							   	    }
								 
								 
							    }
							   	 
                             }
		     	   	           
		     	   	            $net_salary = $gross_salary - $total_deduction;
										   echo '<td style="text-align:right;"> '.numberAccountingFormat($net_salary).'</td>';
		     	   	           
		     	   	        echo '</tr>';
		     	   	        
		     	   	        
		     	   	        $prosper_metuschael ++;
		     	   	        
		     	   	      }
		    
		     	     } 
                    
                  }
                  
                  
                  
                 echo '  </table>
                    
                    </div>';         
        								
	   ?>
	   
   </label > 
</div>        
  

 	    
<div class="col-submit">                             
                                <?php 
                            
                              
                             echo CHtml::submitButton(Yii::t('app', 'Create PDF'),array('name'=>'viewPDF','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER" 
                           // if($this->displayButton)
                           //    {	    
                               	?>
                              <!-- 	<a  class="btn btn-success col-4" style="margin-left:10px; margin-right: 5px;" onclick="printDiv('print_receipt')"><?php echo Yii::t('app','Print'); ?></a>    
                              -->
                               	<?php                       	    	
                            	    		                                                                    	    	     
                             //     }
                            	    	  
                        
                                ?>
              
                           </div>

 

<script type="text/javascript">
    
function printDiv(divName) {
     document.getElementById(divName).style.display = "block";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    
} 


</script>

 