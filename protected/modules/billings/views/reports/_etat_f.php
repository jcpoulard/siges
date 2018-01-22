<?php 
 
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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


     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }


      

     
				  

?>


	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
           
         <div class= "col-4" > 
            <label id="resp_form" >
                       
                  
		             <?php  
		             
		                
							
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'Reports[start_date]',
									 'language'=>'fr',
									 'value'=>$this->start_date,
									 'htmlOptions'=>array('size'=>40, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Date Start')),
										 'options'=>array(
										 'showButtonPanel'=>true,
										 'changeYear'=>true,                                      
										 'dateFormat'=>'yy-mm-dd',
										 'yearRange'=>'1900:2100',
	                                     'changeMonth'=>true,
	                                     'showButtonPane'=>true,   
										 ),
									 )
								 );

                     ?>
                                         
                     
		     </label>
        </div>   


     
     <div class= "col-4"  > 
            <label id="resp_form"  >
                       
                 
		             <?php  
							
							
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'Reports[end_date]',
									 'language'=>'fr',
									 'value'=>$this->end_date,
									 'htmlOptions'=>array('size'=>40, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Date End')),
										 'options'=>array(
										 'showButtonPanel'=>true,
										 'changeYear'=>true,                                      
										 'dateFormat'=>'yy-mm-dd',
										 'yearRange'=>'1900:2100',
	                                     'changeMonth'=>true,
	                                     'showButtonPane'=>true,   
										 ),
									 )
								 );

                     ?>
                                         
                     
		     </label>
        </div>   
  

   <div class= "col-4"  > 
            <label id="resp_form"  >
                       
                  <div class="col-submit" style="margin-top:6px;">                             
                                <?php 
                                        
                            	        echo CHtml::submitButton(Yii::t('app', 'Go'),array('name'=>'go','class'=>'btn btn-warning')); 
	                                                                
                                ?>
              
                           </div>

                     
                     
		     </label>
        </div>   
  
 
 
 <div style="width:90%; overflow:auto;">
            <label  style="width:100%;">
  
	

<?php
         $this->displayButton = false;
		 
		 $start_month2 = null;
		 $end_month2 = null;
		 $start_year1 = null;
		 $start_year2 = null;
		 
		 $end_year1 = null;
		 
		 $end_date1 = null;                
		 $start_date1 = null;
		 
		 
		 
		 $column_number_part1=0;
		 $column_number_part2=0;
		 $column_number = 0;
		 $total_revenu = 0;
		 $start_month = getMonth($this->start_date);
		 $end_month = getMonth($this->end_date);
		 
		 $start_year1 = getYear($this->start_date);
		 $end_year1 = getYear($this->end_date);
		 
		 if($start_year1!=$end_year1)
		   {
		   	  $end_date1 = $start_year1.'-12-31';                
		   	  $start_date1 = $end_year1.'-01-01';
		   	                 
		   	}
		 
				
	
	if($start_month!=null)
	 {	 
	 	
		 $data_compare =false;
	 	
	 	if($this->start_date > $this->end_date)
	 	  $data_compare =true;


		 $num_month = date_diff ( date_create($this->start_date)  , date_create($this->end_date))->format('%R%a');
	
	if(($num_month > 366)||($data_compare))
	  {
	  	  	//error message
	     echo '<div class="" style=" padding-left:0px;">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			     			      
				 	if(($num_month > 366))			   
				     echo '<span style="color:red;" >'.Yii::t('app','Financial statement is calculated for at most a year.<br/>').'</span>';
				     
				      if(($data_compare))  		 
				      	echo '<span style="color:red;" >'.Yii::t('app','Date start must precede date end !').'</span>';
				      				 
			      echo '</td>
					    </tr>
						</table>';
					
           echo '</div>';

	  	
	  	}
	 else
	   {    
	           $this->displayButton =true;
	
	 	//Extract school name 
		//Extract school name 
								 $school_name = infoGeneralConfig('school_name');
        //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
         //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
         //Extract Phone Number
                                 $school_phone_number = infoGeneralConfig('school_phone_number');

?>

  
              <div id="print_receipt" style="float:left; padding:10px; border:1px solid #EDF1F6; width:98%; width:auto; ">
                 
          <?php 
                
                            
                             echo '<div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Financial statement'), pa_daksan() )).'</b>  </div> '; 
			
			echo '<br/>';
                


		 echo '<table style="font-size:12px; background-color:#F4F6F6;">
		           <tr>
		               <td></td>';
		                                	
		 if($end_date1!=null)
		   {
		   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
		                 { 
		                 	$column_number_part1++;
		                 	$column_number++;
		                 	echo '<td style="text-align:right; background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.getShortMonth($i).'. '.substr(getYear($end_date1), 2).'</b></td>';
		                 	
		                 	} 
		       for($i=getMonth($start_date1); $i<=$end_month; $i++)
		                 { 
		                 	$column_number_part2++;
		                 	$column_number++;
		                 	echo '<td style="text-align:right;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.getShortMonth($i).'. '.substr(getYear($start_date1), 2).'</b></td>';
		                 	
		                 	} 
		   	}
		  else
		    {
		         for($i=$start_month; $i<=$end_month; $i++)
		                 { 
		                 	$column_number++;
		                 	echo '<td style="text-align:right;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.getShortMonth($i).'. '.substr(getYear($this->start_date), 2).'</b></td>';
		                 	
		                 	} 	
		      }

        if($column_number>1)
          {
          	$column_number++;
          	   echo '<td style="text-align:right;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.Yii::t('app','Total').'</b></td>';
          	
          	}


		  echo '  </tr>';

$grand_total_revenu = array($column_number);
//initialiser $grand_total_revenu
for($i=0; $i< $column_number; $i++)
  { 
  	  $grand_total_revenu[$i] = 0;
  	}
		  
		  echo '<tr style="font-style: italic; background-color: #F1F1F1;" ><td ><b>'.strtoupper(strtr(Yii::t('app','Income'), pa_daksan() )).'</b></td><td colspan='.$column_number.'></td></tr>'; 
		 $label_income = Reports::getIncomeLabel();
		 echo '<tr>'; 
		   	         echo '<td style="width:23%; border-bottom: 1px solid #ecedf4; ">'.Yii::t('app','Tuition fees').'</td>';
		   	         
		   	          if($end_date1!=null)
					   {
					   	   $col=0;
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					                 { 
					                 	
					                 	$tuition_amount = 0;
						                 	
						                 	if($i==getMonth($this->start_date))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $tuition_amount = Reports::getTotalAmountForTuitionByDateStartAndMonth($this->start_date, $i);
						                 	  	  foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;" >'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($end_date1))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByDateEndAndMonth($end_date1, $i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByMonth($i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}

					                $col++; 	
					                 	} 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					                 { 
					                 	$tuition_amount = 0;
						                 	
						                 	if($i==getMonth($start_date1))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $tuition_amount = Reports::getTotalAmountForTuitionByDateStartAndMonth($start_date1, $i);
						                 	  	  foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($this->end_date))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByDateEndAndMonth($this->end_date, $i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByMonth($i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}

					                 	$col++;
          	
					                 	} 
					   	}
					  else
					    {  
					    	$col=0;
					    	
					         for($i=$start_month; $i<=$end_month; $i++)
				                 { 
				                 	$tuition_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $tuition_amount = Reports::getTotalAmountForTuitionByDateStartAndMonth($this->start_date, $i);
				                 	  	  foreach($tuition_amount as $tuition_a)
				                 	  	    { if($tuition_a['total_amount']!='')
				                 	  	        $amount = $tuition_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByDateEndAndMonth($this->end_date, $i);
				                 	  	foreach($tuition_amount as $tuition_a)
				                 	  	    { if($tuition_a['total_amount']!='')
				                 	  	        $amount = $tuition_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$tuition_amount = Reports::getTotalAmountForTuitionByMonth($i);
				                 	  	foreach($tuition_amount as $tuition_a)
				                 	  	    { if($tuition_a['total_amount']!='')
				                 	  	        $amount = $tuition_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
				                 	
				                 	$col++;
				                 	
				                 	}

					      }

				if($column_number>1)
				   {  
				   	   $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
		   	         
		   	  echo '</tr>';

	//ENROLLMENT
	 echo '<tr>'; 
			   	         echo '<td style="width:23%; border-bottom: 1px solid #ecedf4; ">'.Yii::t('app','Enrollment fee').'</td>';
			   	         
			   	         $total_revenu=0;
			   	          if($end_date1!=null)
						   {
						   	   $col=0;
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						                 { 
						                 	
						                 	$enrollment_amount = 0;
							                 	
							                 	if($i==getMonth($this->start_date))
							                 	  {  
							                 	  	  $amount = 0;
							                 	  	  $enrollment_amount = Reports::getTotalAmountForEnrollmentByDateStartAndMonth($this->start_date, $i);
							                 	  	  foreach($enrollment_amount as $enrollment_a)
							                 	  	    { if($enrollment_a['total_amount']!='')
							                 	  	        $amount = $enrollment_a['total_amount'];
							                 	  	     }
							                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
							                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;" >'.numberAccountingFormat($amount).'</td>';
							                 	  
							                 	    }
							                 	 elseif($i==getMonth($end_date1))
							                 	  {  
							                 	  	$amount = 0;
							                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByDateEndAndMonth($end_date1, $i);
							                 	  	foreach($enrollment_amount as $enrollment_a)
							                 	  	    { if($enrollment_a['total_amount']!='')
							                 	  	        $amount = $enrollment_a['total_amount'];
							                 	  	     }
							                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
							                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
							                 	  
							                 	    }
							                 	 else
							                 	  {  
							                 	  	$amount = 0;
							                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByMonth($i);
							                 	  	foreach($enrollment_amount as $enrollment_a)
							                 	  	    { if($enrollment_a['total_amount']!='')
							                 	  	        $amount = $enrollment_a['total_amount'];
							                 	  	     }
							                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
							                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
							                 	  	}
	
						                $col++; 	
						                 	} 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						                 { 
						                 	$enrollment_amount = 0;
							                 	
							                 	if($i==getMonth($start_date1))
							                 	  {  
							                 	  	  $amount = 0;
							                 	  	  $enrollment_amount = Reports::getTotalAmountForEnrollmentByDateStartAndMonth($start_date1, $i);
							                 	  	  foreach($enrollment_amount as $enrollment_a)
							                 	  	    { if($enrollment_a['total_amount']!='')
							                 	  	        $amount = $enrollment_a['total_amount'];
							                 	  	     }
							                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
							                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
							                 	  
							                 	    }
							                 	 elseif($i==getMonth($this->end_date))
							                 	  {  
							                 	  	$amount = 0;
							                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByDateEndAndMonth($this->end_date, $i);
							                 	  	foreach($enrollment_amount as $enrollment_a)
							                 	  	    { if($enrollment_a['total_amount']!='')
							                 	  	        $amount = $enrollment_a['total_amount'];
							                 	  	     }
							                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
							                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
							                 	  
							                 	    }
							                 	 else
							                 	  {  
							                 	  	$amount = 0;
							                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByMonth($i);
							                 	  	foreach($enrollment_amount as $enrollment_a)
							                 	  	    { if($enrollment_a['total_amount']!='')
							                 	  	        $amount = $enrollment_a['total_amount'];
							                 	  	     }
							                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
							                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
							                 	  	}
	
						                 	$col++;
	          	
						                 	} 
						   	}
						  else
						    {  
						    	$col=0;
						    	
						         for($i=$start_month; $i<=$end_month; $i++)
					                 { 
					                 	$enrollment_amount = 0;
					                 	
					                 	if($i==getMonth($this->start_date))
					                 	  {  
					                 	  	  $amount = 0;
					                 	  	  $enrollment_amount = Reports::getTotalAmountForEnrollmentByDateStartAndMonth($this->start_date, $i);
					                 	  	  foreach($enrollment_amount as $enrollment_a)
					                 	  	    { if($enrollment_a['total_amount']!='')
					                 	  	        $amount = $enrollment_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
					                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  
					                 	    }
					                 	 elseif($i==getMonth($this->end_date))
					                 	  {  
					                 	  	$amount = 0;
					                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByDateEndAndMonth($this->end_date, $i);
					                 	  	foreach($enrollment_amount as $enrollment_a)
					                 	  	    { if($enrollment_a['total_amount']!='')
					                 	  	        $amount = $enrollment_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
					                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  
					                 	    }
					                 	 else
					                 	  {  
					                 	  	$amount = 0;
					                 	  	$enrollment_amount = Reports::getTotalAmountForEnrollmentByMonth($i);
					                 	  	foreach($enrollment_amount as $enrollment_a)
					                 	  	    { if($enrollment_a['total_amount']!='')
					                 	  	        $amount = $enrollment_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
							                 	  	
							                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
							                 	  	
					                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  	}
					                 	
					                 	$col++;
					                 	
					                 	}
	
						      }
	
					if($column_number>1)
					   {  
					   	   $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
					   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
					     }
			   	         
			   	  echo '</tr>';
	







             echo '<tr>'; 
		   	         echo '<td style="border-bottom: 1px solid #ecedf4;">'.Yii::t('app','Other fees').'</td>';
		   	         
		   	         $total_revenu=0;
		   	         
		   	           if($end_date1!=null)
						   {
						   	  $col=0;
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						          {    
						                 	$tuition_amount = 0;
						                 	
						                 	if($i==getMonth($this->start_date))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $tuition_amount = Reports::getTotalAmountForOtherFeeByDateStartAndMonth($this->start_date, $i);
						                 	  	  foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($end_date1))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByDateEndAndMonth($end_date1, $i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByMonth($i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}
						               $col++;
						                 							                 	
						            } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						           { 
					                 	$tuition_amount = 0;
					                 	
					                 	if($i==getMonth($start_date1))
					                 	  {  
					                 	  	  $amount = 0;
					                 	  	  $tuition_amount = Reports::getTotalAmountForOtherFeeByDateStartAndMonth($start_date1, $i);
					                 	  	  foreach($tuition_amount as $tuition_a)
					                 	  	    { if($tuition_a['total_amount']!='')
					                 	  	        $amount = $tuition_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
					                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  
					                 	    }
					                 	 elseif($i==getMonth($this->end_date))
					                 	  {  
					                 	  	$amount = 0;
					                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByDateEndAndMonth($this->end_date, $i);
					                 	  	foreach($tuition_amount as $tuition_a)
					                 	  	    { if($tuition_a['total_amount']!='')
					                 	  	        $amount = $tuition_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
					                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  
					                 	    }
					                 	 else
					                 	  {  
					                 	  	$amount = 0;
					                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByMonth($i);
					                 	  	foreach($tuition_amount as $tuition_a)
					                 	  	    { if($tuition_a['total_amount']!='')
					                 	  	        $amount = $tuition_a['total_amount'];
					                 	  	     }
					                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
					                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
					                 	  	}
					                 	
                                   $col++;
                                   
						             }
						              
						   	}
						  else
						    {
						       $col=0;
						       
						         for($i=$start_month; $i<=$end_month; $i++)
						                 { 
						                 	$tuition_amount = 0;
						                 	
						                 	if($i==getMonth($this->start_date))
						                 	  {  
						                 	  	  $amount = 0;
						                 	  	  $tuition_amount = Reports::getTotalAmountForOtherFeeByDateStartAndMonth($this->start_date, $i);
						                 	  	  foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 elseif($i==getMonth($this->end_date))
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByDateEndAndMonth($this->end_date, $i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  
						                 	    }
						                 	 else
						                 	  {  
						                 	  	$amount = 0;
						                 	  	$tuition_amount = Reports::getTotalAmountForOtherFeeByMonth($i);
						                 	  	foreach($tuition_amount as $tuition_a)
						                 	  	    { if($tuition_a['total_amount']!='')
						                 	  	        $amount = $tuition_a['total_amount'];
						                 	  	     }
						                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
						                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 	  	}
						                 $col++;	

						                 	} 	
						      }
                   	if($column_number>1)
				   {  
				   	   $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
	   	         
		   	  echo '</tr>';
		   	  
		 foreach($label_income as $label)
		   {
		   	  echo '<tr>'; 
		   	         echo '<td style="border-bottom: 1px solid #ecedf4;">'.Yii::t('app',$label['category']).'</td>';
		   	         
		   	         $total_revenu=0;
		   	         
		   	          if($end_date1!=null)
					   { 
					   	   $col=0;
					   	   
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         { 
				                 	$income_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $income_amount = Reports::getTotalAmountForOtherIncomeByDateStartAndMonth($label['id'],$this->start_date, $i);
				                 	  	  foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByDateEndAndMonth($label['id'],$end_date1, $i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByMonth($label['id'],$i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 		$col++;
					           } 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          { 
				                 	$income_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $income_amount = Reports::getTotalAmountForOtherIncomeByDateStartAndMonth($label['id'],$start_date1, $i);
				                 	  	  foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByDateEndAndMonth($label['id'],$this->end_date, $i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByMonth($label['id'],$i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	
					                $col++; 	
					            } 
					   	}
					  else
					    {
					    	$col=0;
					    	
					         for($i=$start_month; $i<=$end_month; $i++)
					             {
				                 	$income_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $income_amount = Reports::getTotalAmountForOtherIncomeByDateStartAndMonth($label['id'],$this->start_date, $i);
				                 	  	  foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByDateEndAndMonth($label['id'],$this->end_date, $i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$income_amount = Reports::getTotalAmountForOtherIncomeByMonth($label['id'],$i);
				                 	  	foreach($income_amount as $income_a)
				                 	  	    { if($income_a['total_amount']!='')
				                 	  	        $amount = $income_a['total_amount'];
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $amount;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	     $col++;
					             } 	
					      }

                 if($column_number>1)
				   {  
				   	    $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
                     		   	         
		   	  echo '</tr>';
		   	  
		   	  
		   	}

             echo '<tr>'; 
		   	         echo '<td style="border-bottom: 1px solid #ecedf4;">'.Yii::t('app','Point of sale').'</td>';
		   	         
		   	         $total_revenu=0;
		   	         
		   	         if($end_date1!=null)
					   {
					   	  $col=0;
					   	  
					   
					   
					   
					   
					   
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         {
				                 	$sale_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $sale_amount = Reports::getTotalAmountForPOSByDateStartAndMonth($this->start_date, $i);
				                 	  	  foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByDateEndAndMonth($end_date1, $i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	       
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
				                 	  							                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByMonth($i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  	}
				                  $col++;
					             } 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          {
				                 	$sale_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $sale_amount = Reports::getTotalAmountForPOSByDateStartAndMonth($start_date1, $i);
				                 	  	  foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByDateEndAndMonth($this->end_date, $i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByMonth($i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  	}
				                 $col++;	

					            } 
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					            
					   	}
					  else
					    {
					         $col=0;
					         
					         for($i=$start_month; $i<=$end_month; $i++)
					            {
				                 	$sale_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $sale_amount = Reports::getTotalAmountForPOSByDateStartAndMonth($this->start_date, $i);
				                 	  	  foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByDateEndAndMonth($this->end_date, $i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	       // $amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$sale_amount = Reports::getTotalAmountForPOSByMonth($i);
				                 	  	foreach($sale_amount as $sale_a)
				                 	  	    { $sale = 0;
				                 	  	       $discount = 0;
				                 	  	       
				                 	  	     if($sale_a['total_amount']!='')
				                 	  	        $sale = $sale_a['total_amount'];
				                 	  	        
				                 	  	      if($sale_a['total_discount']!='')
				                 	  	        $discount = $sale_a['total_discount'];
				                 	  	        
				                 	  	        
				                 	  	        //$amount = $sale - $discount;
				                 	  	     }
		
				                 	  	$total_revenu = $total_revenu + $sale;
						                 	  	
						                 	  	$grand_total_revenu[$col] = $grand_total_revenu[$col] + $sale;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($sale).'</td>';
				                 	  	}
				                   $col++;	
					             } 	
					      }

                  	if($column_number>1)
				   {  
				   	   $grand_total_revenu[$column_number-1] = $grand_total_revenu[$column_number-1] + $total_revenu;
				   	   echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_revenu).'</b></td>';
				     }
		                 
		   	         
		   	         
		   	  echo '</tr>';
		   	  
		 echo '<tr>'; 
		   	         echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4;"><b>'.Yii::t('app','Total income').'</b></td>';
		   	         
		   	         for($i=0; $i< $column_number; $i++)
                          { 
		   	                  echo '<td style="text-align:right; border-top: 2px solid #EDC1B1; border-left: 1px solid #FFFFFF;"><b><hr style="border-style: inset;
    border-width: 1px; color:black; margin-top:0px; margin-bottom:0px;" />'.numberAccountingFormat($grand_total_revenu[$i]).'</b></td>';
                          }
		   	  echo '</tr>';
		   	  
///////EXPENSES
$total_depense = 0;
$grand_total_depense = array($column_number);
//initialiser $grand_total_revenu
for($i=0; $i< $column_number; $i++)
  { 
  	  $grand_total_depense[$i] = 0;
  	}
		  


  echo '<tr style="font-style: italic; background-color: #F1F1F1;" ><td ><b>'.strtoupper(strtr(Yii::t('app','Expenses'), pa_daksan() )).'</b></td><td colspan='.$column_number.'></td></tr>'; 
		 $label_expense = Reports::getExpenseLabel();
		  $col=0; 	  
		 foreach($label_expense as $label)
		   {
		   	  echo '<tr>'; 
		   	         echo '<td style="text-transform: uppercase; font-size:10px; font-weight:bold; border-bottom: 1px solid #ecedf4; ">'.Yii::t('app',$label['category']).'</td>  <td colspan='.$column_number.' style=" border-bottom: 1px solid #ecedf4; "> </td>';
		   	  echo '</tr>';
		   	 
		   	  
		   	  if($label['id']==5) // (for staff)
		   	   {
		   	   	    //report payroll 
		   	   	    echo '<tr>'; 
			   	         echo '<td style="text-indent:0px; border-bottom: 1px solid #ecedf4; "><i>'.Yii::t('app','Payroll').'</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	         if($end_date1!=null)
						   {  
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
											$taxe = 0;
					               $payroll_amount = Reports::getTotalAmountForPayrollByDateStartAndMonth($this->start_date, $i);
					                 	  	foreach($payroll_amount as $payroll_a)
					                 	  	    { if($payroll_a['total_amount']!='')
													{  $amount = $payroll_a['total_amount'];
											     	   $taxe = $payroll_a['total_taxe'];
													}
					                 	  	     }
					                 	  	$total_depense = $total_depense + ($amount + $taxe);
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + ($amount + $taxe);
							                 	  	
					                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount + $taxe).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
											$taxe = 0;
						              $payroll_amount = Reports::getTotalAmountForPayrollByDateEndAndMonth($this->end_date, $i);
						                 	  	foreach($payroll_amount as $payroll_a)
						                 	  	    { if($payroll_a['total_amount']!='')
						                 	  	        { $amount = $payroll_a['total_amount'];
													       $taxe = $payroll_a['total_taxe'];
													    }
						                 	  	     }
						                 	  	$total_depense = $total_depense + ($amount + $taxe);
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + ($amount + $taxe);
								                 	  	
						                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount + $taxe).'</td>';
								            
								            $col++;     	
						            } 
						            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
											$taxe = 0;
				                 	  	$payroll_amount = Reports::getTotalAmountForPayrollByMonth( $i);
				                 	  	foreach($payroll_amount as $payroll_a)
				                 	  	    { if($payroll_a['total_amount']!='')
				                 	  	        { $amount = $payroll_a['total_amount'];
											       $taxe = $payroll_a['total_taxe'];
												 }
				                 	  	     }
				                 	  	$total_depense = $total_depense + ($amount + $taxe);
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + ($amount + $taxe);
						                 	  	
				                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount + $taxe).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  echo '</tr>';
			   	  
			   	 
		   	  
		 //ONA
		 //get ONA id 
		       
		        $ona_id = $this->getOnaID(); ////return an array(id, taxe_value)
		  /*  if($ona_id!=null)
		       {		   	   	
		   	   	    //report ONA 
		   	   	    echo '<tr>'; 
			   	         echo '<td style=" text-indent:0px; border-bottom: 1px solid #ecedf4; "><i>'.Yii::t('app','ONA').'( '.Yii::t('app','Employer').' )</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	         if($end_date1!=null)
						   {  
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
					               $amount = $this->getTotalAmountForONA($ona_id[0],$ona_id[1],$this->start_date,null, $i);
					                 	  	
					                 	  		$total_depense = $total_depense + $amount;
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
							                 	  	
					                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
						              $amount = $this->getTotalAmountForONA($ona_id[0],$ona_id[1],null,$this->end_date, $i);
						              		
						              		$total_depense = $total_depense + $amount;
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
								                 	  	
						                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
								            
								            $col++;     	
						            } 
				            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForONA($ona_id[0],$ona_id[1],null,null, $i);
				                 	  	
				                 	  		$total_depense = $total_depense + $amount;
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  echo '</tr>';
			   	  
			   	 
		   	   	
		   	   	}
		   	  */
		    
			}    	   
		   
		   
		   if($label['id']==6) // (TAX)
		   	   {
		   	   	    //report IRI 
		   	   	 /*   echo '<tr>'; 
			   	         echo '<td style="text-indent:0px; border-bottom: 1px solid #ecedf4; "><i>'.Yii::t('app','IRI ').'</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	            if($end_date1!=null)
						   {  
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
					               $amount = $this->getTotalAmountForIRI($this->start_date,null, $i);
					                 	  	
					                 	  		$total_depense = $total_depense + $amount;
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
							                 	  	
					                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
						              $amount = $this->getTotalAmountForIRI(null,$this->end_date, $i);
						              		
						              		$total_depense = $total_depense + $amount;
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
								                 	  	
						                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
								            
								            $col++;     	
						            } 
				            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForIRI(null,null, $i);
				                 	  	
				                 	  		$total_depense = $total_depense + $amount;
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  echo '</tr>';
			   	  
			   	  */
			   	  
			   	   //report TOP/TMS 
		   	   	    echo '<tr>'; 
			   	         echo '<td style="text-indent:0px; border-bottom: 1px solid #ecedf4; "><i>'.Yii::t('app','TOP').'('.Yii::t('app','Tax on payroll').')</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	       if($end_date1!=null)
						   {  
						   	   
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
					               $amount = $this->getTotalAmountForTMS($this->start_date,null, $i);
					                 	  	
					                 	  		$total_depense = $total_depense + $amount;
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
							                 	  	
					                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
						              $amount = $this->getTotalAmountForTMS(null,$this->end_date, $i);
						              		
						              		$total_depense = $total_depense + $amount;
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
								                 	  	
						                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
								            
								            $col++;     	
						            } 
				            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTMS(null,null, $i);
				                 	  	
				                 	  		$total_depense = $total_depense + $amount;
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  echo '</tr>';
			   	  
			   
		   	  
		   	 }	   
		   	 
		   	 
		   	 
		   	  
		    $description_charge = Reports::getDescriptionChargeByIdCategory($label['id']);
		   	   foreach($description_charge as $description)
		   	    {  
		   	    	 
		   	    	
			   	   echo '<tr>'; 
			   	         echo '<td style="text-indent:0px; border-bottom: 1px solid #ecedf4; "><i>'.$description['description'].'</i></td>';
			   	         
			   	         $col=0;
			   	         $total_depense=0;
			   	         
			   	         if($end_date1!=null)
						   {  
						   	  
						   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
						         { 
						                 	$amount = 0;
					               $expense_amount = Reports::getTotalAmountExpenseByDescriptionAndDateStartAndMonth($description['id'],$this->start_date, $i);
					                 	  	foreach($expense_amount as $expense_a)
					                 	  	    { if($expense_a['total_amount']!='')
					                 	  	        $amount = $expense_a['total_amount'];
					                 	  	     }
					                 	  	$total_depense = $total_depense + $amount;
							                 	  	
							                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
							                 	  	
					                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						             } 
						       for($i=getMonth($start_date1); $i<=$end_month; $i++)
						         { 
						                 	$amount = 0;
						              $expense_amount = Reports::getTotalAmountExpenseByDescriptionAndDateEndAndMonth($description['id'],$this->end_date, $i);
						                 	  	foreach($expense_amount as $expense_a)
						                 	  	    { if($expense_a['total_amount']!='')
						                 	  	        $amount = $expense_a['total_amount'];
						                 	  	     }
						                 	  	$total_depense = $total_depense + $amount;
								                 	  	
								                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
								                 	  	
						                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF; ">'.numberAccountingFormat($amount).'</td>';
								            
								            $col++;     	
						            } 
						            
						          
						            
						   	}
						  else
						    {
						         for($i=$start_month; $i<=$end_month; $i++)
						             { 
						                 	$amount = 0;
				                 	  	$expense_amount = Reports::getTotalAmountExpenseByDescriptionAndMonth($description['id'], $i);
				                 	  	foreach($expense_amount as $expense_a)
				                 	  	    { if($expense_a['total_amount']!='')
				                 	  	        $amount = $expense_a['total_amount'];
				                 	  	     }
				                 	  	$total_depense = $total_depense + $amount;
						                 	  	
						                 	  	$grand_total_depense[$col] = $grand_total_depense[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; text-indent:0px; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
						                 
						                 $col++;	
						           } 
						           
						         	
						      }
                      
                 if($column_number>1)
				   {  
				   	    $grand_total_depense[$column_number-1] = $grand_total_depense[$column_number-1] + $total_depense;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_depense).'</b></td>';
				     }
                     	  
			   	         
			   	  echo '</tr>';
			   	  
			   	 
			   	  
		   	    }   	  
		   	  
		   	  
		   	  
		   	  
		   	  
		   	  
		   	  		   	  
		     
		   	  
		   	}

             
		 echo '<tr>'; 
		   	         echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; "><b>'.Yii::t('app','Total expenses').'</b></td>';
		   	         
		   	         for($i=0; $i< $column_number; $i++)
                          { 
		   	                  echo '<td style="text-align:right; border-top: 2px solid #EDC1B1; border-left: 1px solid #FFFFFF;"><b><hr style="border-style: inset;
    border-width: 1px; color:black; margin-top:0px; margin-bottom:0px;" />'.numberAccountingFormat($grand_total_depense[$i]).'</b></td>';
                          }
		   	  echo '</tr>';
		   	  
		 echo '<tr>'; 
		   	         echo '<td style="text-align:right; border-bottom: 0px solid #ecedf4; "><b>'.Yii::t('app','Profit(Loss)').'</b></td>';
		   	         
		   	         for($i=0; $i< $column_number; $i++)
                          { 
		   	                  if(($grand_total_revenu[0] -$grand_total_depense[0])!=0)
		   	                    $this->displayButton=true;
		   	                  
		   	                  echo '<td style="text-align:right; border-top: 2px solid #EDC1B1; border-left: 1px solid #FFFFFF;"><b><hr style="border-style: inset;
    border-width: 1px; color:black; margin-top:0px; margin-bottom:0px;" />'.numberAccountingFormat($grand_total_revenu[$i] -$grand_total_depense[$i]).'</b></td>';
                          }
		   	  echo '</tr>'; 	 
		 
		echo ' </table>
<div style="float:right; text-align: right; font-size: 6px; margin-top:40px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>		
		</div>';
		

	 } 
  
 }
  
  ?> 
      	         
		           	
 
  </label >       
	        
</div>        
  
 	    
<div class="col-submit">                             
                                <?php 
                            
                              
                              
                            if($this->displayButton)
                               {	    
                               	?>
                               	<a  class="btn btn-success col-4" style="margin-left:10px; margin-right: 5px;" onclick="printDiv('print_receipt')"><?php echo Yii::t('app','Print'); ?></a>    
                               	<?php                       	    	
                            	    	echo CHtml::submitButton(Yii::t('app', 'Create PDF'),array('name'=>'createPDF','class'=>'btn btn-warning')); 
	                                                                    	    	     
                                  }
                            	    	  
                        
                                ?>
              
                           </div>

                    </form>
              </div>




<script type="text/javascript">
    
function printDiv(divName) {
     document.getElementById(divName).style.display = "block";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
    // document.getElementById(divName).style.display = "none";
} 


</script>

 