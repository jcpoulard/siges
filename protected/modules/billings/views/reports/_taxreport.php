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
 
$acad_sess=acad_sess();  
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
                       
                  <!--  <label for="start_date"><?php //echo Yii::t('app','Start date'); ?></label>  -->
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
                                         
                     <?php echo $form->error($model,'start_date'); ?>
		     </label>
        </div>   


     
     <div class= "col-4"  > 
            <label id="resp_form"  >
                       
                  <!-- <label for="end_date"><?php //echo Yii::t('app','End date'); ?></label>  -->
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
                                         
                    <?php echo $form->error($model,'end_date'); ?> 
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
  
 
 
 <div style="width:90%;">
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
		 $total_tax = 0;
		 $start_month = getMonth($this->start_date);
		 $end_month = getMonth($this->end_date);
		 
		 $start_year1 = getYear($this->start_date);
		 $end_year1 = getYear($this->end_date);
		 
		 if($start_year1!=$end_year1)
		   {
		   	  $end_date1 = $start_year1.'-12-01';                
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
				     echo '<span style="color:red;" >'.Yii::t('app','Tax reports is calculated for at most a year.<br/>').'</span>';
				      		 
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
								 $school_name = infoGeneralConfig('school_name');
        //Extract school address
				   				$school_address = infoGeneralConfig('school_address');
         //Extract  email address 
                                 $school_email_address = infoGeneralConfig('school_email_address');
         //Extract Phone Number
                                 $school_phone_number = infoGeneralConfig('school_phone_number');



?>

  
              <div id="print_receipt" style="float:left; padding:10px; border:1px solid #EDF1F6; width:98%; ">
                 
          <?php 
                                            
                             echo '<div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Tax reports'), pa_daksan() )).'</b>  </div> '; 
			
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
		                 	echo '<td style="text-align:right;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.getShortMonth($i).'. '.substr(getYear($end_date1), 2).'</b></td>';
		                 	
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
          	   echo '<td style="text-align:right; background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.Yii::t('app','Total').'</b></td>';
          	
          	}


		  

$grand_total_taxe = array($column_number);
//initialiser $grand_total_taxe
for($i=0; $i< $column_number; $i++)
  { 
  	  $grand_total_taxe[$i] = 0;
  	}
		  
		  
		 $all_taxes = Reports::getTaxesForFDM($acad);
		  
	//$ona_id = $this->getOnaID(); ////return an array(id, taxe_value)	   	        		   	  
		 foreach($all_taxes as $taxe)
		   {
		   	  
		   	  if($taxe['taxe_description']=="ONA")
		   	    {
		   	    	//ONA Employe
		   	    	if($taxe['employeur_employe']==0)
		   	    	 {
		   	    	 echo '<tr>'; 
		   	         echo '<td style=" width:23%; background-color: #F1F1F1; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;"> <b>'.Yii::t('app','ONA').' '.Yii::t('app','Employee').'</b></td>';
		   	         
		   	         $total_tax=0;
		   	         
		   	          if($end_date1!=null)
					   { 
					   	   $col=0;
					   	   
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;       
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($taxe['id'], $taxe['taxe_value'], $this->start_date, $i);
				                 	  	     
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($taxe['id'], $taxe['taxe_value'], $end_date1, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($taxe['id'], $taxe['taxe_value'], $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 		$col++;
					           } 
					           
					           
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($taxe['id'], $taxe['taxe_value'], $start_date1, $i);
				                 	  	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($taxe['id'], $taxe['taxe_value'], $this->end_date, $i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($taxe['id'], $taxe['taxe_value'], $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
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
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($taxe['id'], $taxe['taxe_value'], $this->start_date, $i);
				                 	  	 
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($taxe['id'], $taxe['taxe_value'], $this->end_date, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($taxe['id'], $taxe['taxe_value'],$i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	     $col++;
					             } 	
					      }

                 if($column_number>1)
				   {  
				   	    $grand_total_taxe[$column_number-1] = $grand_total_taxe[$column_number-1] + $total_tax;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_tax).'</b></td>';
				     }
                     		   	         
		   	  echo '</tr>';
		   	    	 }
		   	      elseif($taxe['employeur_employe']==1)
                    { //ONA Employeur
                   echo '<tr>'; 
		   	         echo '<td style=" background-color: #F1F1F1; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;"> <b>'.Yii::t('app','ONA').' '.Yii::t('app','Employer').'</b></td>';
		   	         
		   	         //pran id_taxe ONA employe a pou kalkile ONA patwon
		   	         $tax_id_emp='';
		   	           $sql__ = 'SELECT id FROM taxes WHERE  employeur_employe=0 AND taxe_description LIKE(\'ONA\') AND academic_year='.$acad;
															
					  $command__ = Yii::app()->db->createCommand($sql__);
					  $result__ = $command__->queryAll(); 
																       	   
						if($result__!=null) 
						 { foreach($result__ as $r)
						   $tax_id_emp=$r['id'];
						 }
		   	         
		   	         //
		   	         
		   	   $total_tax=0;
		   	         
		   	          if($end_date1!=null)
					   { 
					   	   $col=0;
					   	   
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;       
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($tax_id_emp, $taxe['taxe_value'], $this->start_date, $i);
				                 	  	     
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($tax_id_emp, $taxe['taxe_value'], $end_date1, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($tax_id_emp, $taxe['taxe_value'], $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 		$col++;
					           } 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($tax_id_emp, $taxe['taxe_value'], $start_date1, $i);
				                 	  	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($tax_id_emp, $taxe['taxe_value'], $this->end_date, $i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($tax_id_emp, $taxe['taxe_value'], $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
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
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($tax_id_emp, $taxe['taxe_value'], $this->start_date, $i);
				                 	  	 
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($tax_id_emp, $taxe['taxe_value'], $this->end_date, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($tax_id_emp, $taxe['taxe_value'],$i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	     $col++;
					             } 	
					      }

                 if($column_number>1)
				   {  
				   	    $grand_total_taxe[$column_number-1] = $grand_total_taxe[$column_number-1] + $total_tax;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_tax).'</b></td>';
				     }
                     		   	         
		   	  echo '</tr>';
		   	    	 }



		   	      }
		   	   elseif($taxe['taxe_description']=="TMS")  //for TOP/TMS
		   	     { 
		   	     	 echo '<tr>'; 
		   	         echo '<td style=" background-color: #F1F1F1; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;"> <b>'.Yii::t('app','TMS').' ('.Yii::t('app','Tax on payroll').')</b></td>';
		   	         
		   	         $total_tax=0;
		   	         
		   	          if($end_date1!=null)
					   { 
					   	   $col=0;
					   	   
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  
				                 	  	   $amount = $this->getTotalAmountForTMS($this->start_date,null, $i);       
				                 	  	  				                 	  	     
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	
				                 	  	$amount = $this->getTotalAmountForTMS(null,$end_date1, $i); 
				                 	  	 
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTMS(null,null, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 		$col++;
					           } 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $amount = $this->getTotalAmountForTMS($start_date1,null, $i);
				                 	  	  				                 	  	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTMS(null, $this->end_date, $i);
				                 	  					                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTMS(null,null, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
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
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $amount = $this->getTotalAmountForTMS($this->start_date,null, $i);				                 	  	 
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTMS(null,$this->end_date, $i);				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTMS(null,null, $i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	     $col++;
					             } 	
					      }

                 if($column_number>1)
				   {  
				   	    $grand_total_taxe[$column_number-1] = $grand_total_taxe[$column_number-1] + $total_tax;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_tax).'</b></td>';
				     }
                     		   	         
		   	  echo '</tr>';

		   	       
		   	       }
		   	     elseif($taxe['taxe_description']=="IRI")  //for impot sur le revenu
		   	     { 
		   	     	 echo '<tr>'; 
		   	         echo '<td style=" background-color: #F1F1F1; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;"> <b>'.Yii::t('app','IRI ').'</b></td>';
		   	         
		   	         $total_tax=0;
		   	         
		   	           if($end_date1!=null)
					   { 
					   	   $col=0;
					   	   
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  
				                 	  	  $amount = $this->getTotalAmountForIRI($this->start_date,null, $i);
				                 	  	   				                 	  	     
				                 	  	   $total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForIRI(null,$end_date1, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForIRI(null,null, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 		$col++;
					           } 
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	 
				                 	  	  $amount = $this->getTotalAmountForIRI($start_date1,null, $i);
				                 	  	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	
				                 	  	$amount = $this->getTotalAmountForIRI(null,$this->end_date, $i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForIRI(null,null, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
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
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  
				                 	  	  $amount = $this->getTotalAmountForIRI($this->start_date,null, $i);
				                 	  	 
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	
				                 	  	$amount = $this->getTotalAmountForIRI(null,$this->end_date, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	
				                 	  	$amount = $this->getTotalAmountForIRI(null,null, $i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	     $col++;
					             } 	
					      }

                 if($column_number>1)
				   {  
				   	    $grand_total_taxe[$column_number-1] = $grand_total_taxe[$column_number-1] + $total_tax;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_tax).'</b></td>';
				     }
				     
				                          		   	         
		   	  echo '</tr>';

		   	       
		   	       }
		   	     else
		   	       {
		   	      
		   	      echo '<tr>'; 
		   	         echo '<td style=" width:23%; background-color: #F1F1F1; border-bottom: 1px solid #ecedf4;  border-left: 1px solid #FFFFFF;"> <b>'.Yii::t('app',$taxe['taxe_description']).'</b></td>';
		   	         
		   	         $total_tax=0;
		   	         
		   	          if($end_date1!=null)
					   { 
					   	   $col=0;
					   	   
					   	   for($i=$start_month; $i<=getMonth($end_date1); $i++)
					         { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;       
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($taxe['id'], $taxe['taxe_value'], $this->start_date, $i);
				                 	  	     
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($end_date1))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($taxe['id'], $taxe['taxe_value'], $end_date1, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($taxe['id'], $taxe['taxe_value'], $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 		$col++;
					           } 
					      
					      
					      
					       for($i=getMonth($start_date1); $i<=$end_month; $i++)
					          { 
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($start_date1))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($taxe['id'], $taxe['taxe_value'], $start_date1, $i);
				                 	  	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($taxe['id'], $taxe['taxe_value'], $this->end_date, $i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($taxe['id'], $taxe['taxe_value'], $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
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
				                 	$tax_amount = 0;
				                 	
				                 	if($i==getMonth($this->start_date))
				                 	  {  
				                 	  	  $amount = 0;
				                 	  	  $amount = $this->getTotalAmountForTaxesByDateStartAndMonth($taxe['id'], $taxe['taxe_value'], $this->start_date, $i);
				                 	  	 
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 elseif($i==getMonth($this->end_date))
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByDateEndAndMonth($taxe['id'], $taxe['taxe_value'], $this->end_date, $i);
				                 	  	
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  
				                 	    }
				                 	 else
				                 	  {  
				                 	  	$amount = 0;
				                 	  	$amount = $this->getTotalAmountForTaxesByMonth($taxe['id'], $taxe['taxe_value'],$i);
				                 	  
				                 	  	$total_tax = $total_tax + $amount;
						                 	  	
						                 	  	$grand_total_taxe[$col] = $grand_total_taxe[$col] + $amount;
						                 	  	
				                 	  	echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;">'.numberAccountingFormat($amount).'</td>';
				                 	  	}
		                 	     $col++;
					             } 	
					      }

                 if($column_number>1)
				   {  
				   	    $grand_total_taxe[$column_number-1] = $grand_total_taxe[$column_number-1] + $total_tax;
				   	    echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4; border-left: 1px solid #FFFFFF;"> <b>'.numberAccountingFormat($total_tax).'</b></td>';
				     }
                     		   	         
		   	  echo '</tr>';
		   	  
		   	     }
		   	  
		   	  
		   	}

		   	  
		 echo '<tr>'; 
		   	         echo '<td style="text-align:right; border-bottom: 1px solid #ecedf4;"><b>'.Yii::t('app','Total tax').'</b></td>';
		   	         
		   	         for($i=0; $i< $column_number; $i++)
                          { 
		   	                  echo '<td style="text-align:right; border-top: 2px solid #EDC1B1; border-left: 1px solid #FFFFFF;"><b><hr style="border-style: inset;
    border-width: 1px; color:black; margin-top:0px; margin-bottom:0px;" />'.numberAccountingFormat($grand_total_taxe[$i]).'</b></td>';
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
    
} 


</script>

 