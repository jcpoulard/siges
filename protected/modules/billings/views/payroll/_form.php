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
/* @var $form CActiveForm */

$acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];
 $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 



if(!isset($_GET['id']))
 {
?>


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        


                           
     
      						<div class="span2" >
                                
                               
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                       echo $form->labelEx($model,Yii::t('app','Depenses Items'));
                                        
                                        if(isset($this->depensesItems1)&&($this->depensesItems1!=''))
							       echo $form->dropDownList($model,'depensesItems',$this->loadDepensesItems(), array('onchange'=> 'submit()','options' => array($this->depensesItems1=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'depensesItems',$this->loadDepensesItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
                            
                            
                          <?php if((!isset($_GET['group']))&&(!isset($_GET['id']))){      ?>                
                          <div class="span2" >
                                
                                
                                <div class="left" style="padding-left:40px; ">  
	                            <?php 
	                              
                                      echo $form->label($model,'group'); 
		                              if($this->group==1)
				                          { echo $form->checkBox($model,'group',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
				                           }
						                 else
							               echo $form->checkBox($model,'group',array('onchange'=> 'submit()'));
							               
                                  
                               ?>

                                </div>
                                
                            </div>
                           
                     <?php }      ?> 


                   
        </div>
    </div>

<?php

 }

?>


<br/>



<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	 if(!isset($_GET['group']))
             echo $form->errorSummary($model); 
             
             
          $dataProvider_noPerson ='';
          $dataProvider_updateOne ='';
             

	
	   	       
	        //error message 
	        	if(($this->messageMissingHourNotOk)||($this->message_PaymentDate)||($this->message_PayrollDate)||($this->message_PayrollDatePaymentDate_notInAcadRange)||($this->message_anyPayrollAfter)||($this->message_group_anyPayrollAfter))
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ">';
				      				      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			       
			       }			      
				 					     	
				   
				    if($this->messageMissingHourNotOk)
				      {  echo '<span style="color:red;" > '.Yii::t('app','Please, be careful about Missing time format.').'</span>'.'<br/>';
				      }
				 
				   	if($this->message_PayrollDatePaymentDate_notInAcadRange)
				      {  echo '<span style="color:red;" > '.Yii::t('app','"payroll date" or "Payment date" is not in this academic year.').'</span>'.'<br/>';
				      }	
				      
				   	if($this->message_anyPayrollAfter)
				   	 {  echo '<span style="color:red;" > '.Yii::t('app','Payroll is not allowed because we already have payroll done for a next month.').'</span>'.'<br/>';
				      }	
				      
				    if($this->message_group_anyPayrollAfter)
				   	 {  echo '<span style="color:red;" > '.Yii::t('app','People who have payroll already done for any month that follow this one are rejected.').'</span>'.'<br/>';
				      }
				      
				   	if($this->message_PaymentDate)
				      {  echo '<span style="color:red;" > '.Yii::t('app','"Payment date" cannot be earlier than "payroll date".').'</span>'.'<br/>';
				      }	
				      
				    if($this->message_PayrollDate)
				      {  echo '<span style="color:red;" > '.Yii::t('app','Please make sure "payroll date" is in the appropriate "payroll month".').'</span>'.'<br/>';
				      }			    
				     				   
					
					   
			     if(($this->messageMissingHourNotOk)||($this->message_PayrollDate)||($this->message_PaymentDate)||($this->message_PayrollDatePaymentDate_notInAcadRange)||($this->message_anyPayrollAfter)||($this->message_group_anyPayrollAfter))
			      { 
					 echo'</td>
					    </tr>
						</table>';
					
                      echo '</div>';
			       }
       		
	?>

	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
           
                <div class="col-4">
            <label id="resp_form">

                    <?php   echo $form->labelEx($model,'payroll_month');    ?>
                    
                    <?php 
                    
                    
                         if($this->group==0)
                          {  
                          	
                          	if(!isset($_GET['id']))//create
                          	 { if($this->payroll_month!=null)
			                    {
							     echo $form->dropDownList($model, 'payroll_month',$this->getSelectedLongMonthValueByPerson($this->person_id),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true))));
							    
						         }
						       else
						        {
						         echo $form->dropDownList($model, 'payroll_month',$this->getSelectedLongMonthValueByPerson($this->person_id),array('onchange'=> 'submit()'));
						         }
                          	 }//end create
						    elseif((isset($_GET['id']))&&($_GET['id']!=''))   //update
						      {  
						      	
						      	if( ((isset($_GET['from1']))&&($_GET['from1']=='vfr'))&&(isset($_GET['add'])))
						      	  {
							        if($this->payroll_month!=null)
				                     {
								       echo $form->dropDownList($model, 'payroll_month',$this->getSelectedLongMonthValueByPerson($this->person_id),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true))));
							          }
							        else
							          {
							            echo $form->dropDownList($model, 'payroll_month',$this->getSelectedLongMonthValueByPerson($this->person_id),array('onchange'=> 'submit()'));
							           }
							      	
						      	   }
						      	else
						      	  { if($this->payroll_month!=null)
					                   {
									     echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValueByPerson($model->id_payroll_set),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true))));
								       }
								    else
								      {
								         echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValueByPerson($model->id_payroll_set),array('onchange'=> 'submit()'));
								       }
								       
							       
						           }
						        
						       }//end update
						       
                           }
                         else
                           {
                          	 if(!isset($_GET['group']))
	                           {   if($this->payroll_month!='')
					                 {
									   echo $form->dropDownList($model, 'payroll_month',$this->getSelectedLongMonthValue(),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true))));
								       }
								    else
								      {
								         echo $form->dropDownList($model, 'payroll_month',$this->getSelectedLongMonthValue(),array('onchange'=> 'submit()'));
								       }
								       
	                            }
	                          else
	                            {
	                            	if($this->payroll_month!='')
					                 {
									   echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValueByPayroll_group($this->grouppayroll),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true))));
								       }
								    else
								      {
								         echo $form->dropDownList($model, 'payroll_month',$this->getPastLongMonthValueByPayroll_group($this->grouppayroll),array('onchange'=> 'submit()'));
								       }
	                              }
                           	
                           	 }

                         ?>
                         
                        <?php echo $form->error($model,'payroll_month'); ?>
		       
		     </label>
        </div>

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
								     
								      
                    	if((isset($_GET['id']))&&($_GET['id']!=''))
                          {  
	                           if((isset($_GET['from1']))&&($_GET['from1']=='vfr'))
	                            {	
	                            	$this->person_id=$_GET['emp'];
	                              }
	                            else
	                              {
	                              	if(!isset($_GET['group'])) 
	                                  $this->person_id=$model->idPayrollSet->person->id;
	                                  
	                              	}
                                
                          }
                               
                           				                  
                        if($this->group==0)
                         {//one by one
                        
                 	
                    	if($this->person_id!='')
						  {  
							  $criteria = new CDbCriteria(array('group'=>'id','alias'=>'p', 'order'=>'last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND (p.id IN(SELECT person_id FROM payroll_settings ps WHERE (ps.old_new =1 AND ps.academic_year='.$acad.') )) '));
							  
							  echo $form->dropDownList($model, 'person_id',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('onchange'=> 'submit()', 'options' => array($this->person_id=>array('selected'=>true)), 'disabled'=>''));
										$dataProvider_updateOne =Persons::model()->findAll($criteria);    
							}
						 else
							{   
								   
												 
								// $criteria = new CDbCriteria(array('group'=>'id','alias'=>'p', 'order'=>'last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND ((p.id IN(SELECT person_id FROM payroll_settings ps WHERE ps.old_new = 1 AND ps.academic_year='.$acad.' )) AND (p.id NOT IN(SELECT person_id FROM payroll_settings ps INNER JOIN payroll p ON(p.id_payroll_set=ps.id) WHERE ps.old_new = 1 AND ps.academic_year='.$acad.' AND p.payroll_month='.$month.' ) )) '));
								
								$criteria = new CDbCriteria(array('group'=>'id','alias'=>'p', 'order'=>'last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND ((p.id IN(SELECT person_id FROM payroll_settings ps WHERE ps.old_new = 1 AND ps.academic_year='.$acad.' )) AND (p.id NOT IN(SELECT person_id FROM payroll_settings ps INNER JOIN payroll p ON(p.id_payroll_set=ps.id) WHERE ps.academic_year='.$acad.' AND p.payroll_month='.$month.' ) )) '));
								 
								 echo $form->dropDownList($model, 'person_id',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array( 'onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Search --'), 'disabled'=>''));
										  	
										  	$dataProvider_createOne =Persons::model()->findAll($criteria);
							 }
										    
                          }
                        elseif($this->group==1)
				           { 
			                         if($this->grouppayroll!=null)
			                           {
									      echo $form->dropDownList($model, 'group_payroll',$model->getPayrollGroup(),array('onchange'=> 'submit()','options' => array($this->grouppayroll=>array('selected'=>true))));
						                }
						               else
						                 {
						                    echo $form->dropDownList($model, 'group_payroll',$model->getPayrollGroup(),array('onchange'=> 'submit()'));
						                   }
						                   
                                    
                                       	
                                       	
				                    }
				                    
				                    						                            
                          
                          ?>
		                <?php if(!isset($_GET['group']))
		                       echo $form->error($model,'person_id'); ?>
		                       
		                       
		     </label>
        </div>
        
        
        
        
         <div class= "col-4" > 
            <label id="resp_form" >
                       
                   <?php  echo $form->labelEx($model,'payroll_date'); ?>
		             <?php  if((isset($_GET['id'])&&($_GET['id']!=''))||(isset($_GET['group']))||($model->payroll_date!=''))
	                                   $date__ = $model->payroll_date;
	                                else
	                                   $date__ = date('Y-m-d');
							 
							
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'Payroll[payroll_date]',
									 'language'=>'fr',
									 'value'=>$date__,
									 'htmlOptions'=>array('size'=>40, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Payroll Date')),
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
                     <?php echo $form->error($model,'payroll_date');  ?>
                     
                     
		     </label>
        </div>   

<?php
   
      if($this->group==0)
         { $col= 'col-4';
            $style = '';
            $br ='';
          }
       elseif($this->group==1)
          {  $col= 'col-4';
             $style = '';//'margin-left:92px;'; 
             $br ='';//'<br/>';
             }
     
     echo $br;
     
     
     if((($this->group==0)&&($this->person_id!=''))||($this->group==1))
        {
     ?>
     
     <div class= <?php echo $col; ?> > 
            <label id="resp_form" style= <?php echo $style; ?>>
                       
                   <?php  echo $form->labelEx($model,'payment_date'); ?>
		             <?php  if((isset($_GET['id'])&&($_GET['id']!=''))||(isset($_GET['group']))||($model->payment_date!=''))
	                                   $date__ = $model->payment_date;
	                                else
	                                   $date__ = date('Y-m-d');
							
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'Payroll[payment_date]',
									 'language'=>'fr',
									 'value'=>$date__,
									 'htmlOptions'=>array('size'=>40, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Payment date')),
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
                     <?php echo $form->error($model,'payment_date');  ?>
                     
                     
		     </label>
        </div>   
  
  <?php
        }
  ?>

   
   
   
   
   
      	         
		            <?php 
   //youn pa youn  _________________________________  		            
		            if($this->group==0)
                    {   
                    	
                    	$modPerson=Persons::model()->findAll($criteria);
                    	
                    if($modPerson!=null)
                     {
             	
                ?>
	


<?php 
         if($this->person_id!='')
		  {  
		                   	   	
		?>  
        <div class="col-4">
            <label id="resp_form">

		               <?php
		                 echo '<div style=" ">';
		                  
		                    if(isset($_GET['id'])&&($_GET['id']!=''))
		                       $gross_sal = $model->getGrossSalaryIndex_value($this->person_id,$model->payroll_month,getYear($model->payment_date)  );
		                    else
		                        $gross_sal = $model->getGrossSalary($this->person_id);
		                        
		                          
		                   $model->to_pay =  $currency_symbol.' '.numberAccountingFormat($gross_sal);
		                   
		            
		                    
		                    echo Yii::t('app','Salary');
		                    
		                    
		                       echo $form->textField($model,'to_pay',array('size'=>60, 'readonly' => true,'disabled'=>'disabled')); 
		                
		                echo '</div>';       
		                ?>
		                
		     </label>
        </div>
        
      
      <?php 
             $employee_teacher = Persons::model()->isEmployeeTeacher($this->person_id, $acad);	
			
			$Pay_set = new PayrollSettings;
			//return nbre d'hre de l'annee en cours
			$number_hour = $Pay_set->getSimpleNumberHourValue($this->person_id, $acad);
				
		    
         if($number_hour!=0)
		  {  
		  			                      	   
		?>  
        <div class="col-4">
            <label id="resp_form">

                    
                       <?php 
                               $modelPay_set = new PayrollSettings;
                       
                                   echo $form->labelEx($modelPay_set,'number_of_hour'); 
                                     
                                     echo $form->textField($modelPay_set,'number_of_hour',array( 'size'=>60, 'readonly'=> false,'disabled'=>'disabled','value'=> $number_hour ));
								     
								    
								      echo $form->error($modelPay_set,'number_of_hour'); 
		                      
		                      
						    ?>

		     </label>
        </div>
      <?php
          	   
		                      	   
		        }
		                      
		     }
                     
                        
                          
         }           
     
     }
     // fen youn pa youn  _________________________________   
              
         

      if(($this->group==0)&&($this->person_id!=''))
         {
  ?>      
   <div class="col-4">
            <label id="resp_form">

                    <?php 
                               
                       
                                   echo $form->labelEx($model,'cash_check'); 
                                     
                                     echo $form->textField($model,'cash_check',array( 'size'=>60, ));
								     
								    
								      echo $form->error($model,'cash_check'); 
		                      
		                      
						    ?>
		     </label>
        </div>
        
   <?php
         }
   ?>   
   
   
        <div class="col-4">
            <label id="resp_form">

              
                    <?php echo $form->label($model,'taxe'); 
		                              if($this->taxe==1)
				                          { echo $form->checkBox($model,'taxe',array('checked'=>'checked'));
				                              
				                           }
						                 else
							               echo $form->checkBox($model,'taxe');
		                    ?>
		     </label>
        </div>
        
        
  

  <?php      
     //an gwoup  _________________________________              
                      
  if($this->group==1){         ?>  
                
        
		        
        
  
                    
                        <div class="list_secondaire" style="margin-left:10px; width:90%;">
											

			<?php
			$provider_to_show_button=null;
			$header='';
              $condition='';
               
               $id='';
                                            
                 if(!isset($_GET['group'])) //to create
                   {    //MOUN KI ALAFWA ANPLWAYE-PWOFESE PAP PARET NAN LIS PWOFESE
	    	  	              if($this->grouppayroll=='2')//teacher
                                 {	
                                    $condition='p.is_student=0 AND p.active IN(1, 2) AND p.id NOT IN((SELECT c.teacher FROM courses c INNER JOIN academicperiods a ON(a.id=c.academic_period) WHERE (c.academic_period='.$acad.'  OR a.year='.$acad.' ) AND c.teacher IN(SELECT persons_id FROM persons_has_titles WHERE academic_year='.$acad.' ) )) AND ps.academic_year='.$acad.' AND ps.as=1 AND ps.id NOT IN( SELECT id_payroll_set FROM payroll pl WHERE pl.payroll_month='.$month.' )';
                                    
                                    $header=Yii::t('app','Teachers name');
                                 }
                               elseif($this->grouppayroll=='1')//employee
                                  { $condition='p.is_student=0 AND p.active IN(1, 2) AND ps.academic_year='.$acad.' AND ps.as=0 AND ps.id NOT IN( SELECT id_payroll_set FROM payroll pl WHERE pl.payroll_month='.$month.' )';
                                  
                                      $header=Yii::t('app','Employees name');
                                   }
                                   
                         $dataProvider_noPerson =PayrollSettings::model()->searchPersonsMakePayroll($condition);//searchPersonsMakePayroll
	    	  	       $dataProvider_noPerson =$dataProvider_noPerson->getData();
	    	  	       
                   }
                 else  //to update
                  {
                  	          if($this->grouppayroll=='2')//teacher
                                {  //MOUN KI ALAFWA ANPLWAYE-PWOFESE PAP PARET NAN LIS PWOFESE
                                  $condition='p.is_student=0 AND p.active IN(1, 2) AND (p.id IN(SELECT person_id FROM payroll_settings ps WHERE ps.academic_year='.$acad.' AND ps.as=1  ) AND p.id NOT IN((SELECT c.teacher FROM courses c INNER JOIN academicperiods a ON(a.id=c.academic_period) WHERE (c.academic_period='.$acad.'  OR a.year='.$acad.' ) AND c.teacher IN(SELECT persons_id FROM persons_has_titles WHERE academic_year='.$acad.' ) )) )';
                                    
                                    $header=Yii::t('app','Teachers name');
                                 }
                               elseif($this->grouppayroll=='1')//employee
                                  { $condition='is_student=0 AND active IN(1, 2) AND p.id IN(SELECT person_id FROM payroll_settings ps WHERE ps.academic_year='.$acad.' AND ps.as=0 ) ';
                                  
                                      $header=Yii::t('app','Employees name');
                                   }
                           $dataProvider_noPerson =Persons::model()->searchEmployeeForPayroll($condition);
	    	  	       $dataProvider_noPerson =$dataProvider_noPerson->getData();
                  	}            
                                   
               
			if( $dataProvider_noPerson ==null)                     
                 echo ' <label style="width:100%; padding-left:0px;margin-right:250px; margin-bottom:-20px;"><div class="" style=" padding-left:0px;margin-right:290px; margin-bottom:-18px; ">';//-20px; ';
               else
                  {
                  	  if(isset($_GET['group'])) //to update  
                  	    { 
                  	    	$dataProvider=Payroll::model()->searchPersonsForUpdatePayroll($condition,$this->payroll_month,$this->payroll_date, $acad);
                  	    	$info=$dataProvider->getData();
                  	    	if($info!=null)	
                  	           echo '<label style="width:100%; padding-left:0px;margin-right:250px; margin-bottom:-20px;"><div class="" style=" padding-left:0px;margin-right:290px; margin-bottom:-48px; ">';//-20px; ';
                  	         else
                  	            echo '<label style="width:100%; padding-left:0px;margin-right:250px; margin-bottom:-20px;"><div class="" style=" padding-left:0px;margin-right:290px; margin-bottom:-18px; ">';//-20px; ';
                  	            
                  	     }
                  	   else
                  	     {
                  	     	echo '<label style="width:100%; padding-left:0px;margin-right:250px; margin-bottom:-20px;"><div class="" style=" padding-left:0px;margin-right:290px; margin-bottom:-48px; ">';//-20px; ';
                  	     	}

                  	
                    }
	      
				   	  	
					    
				  		   if( $dataProvider_noPerson ==null) 
				  			{   if($this->grouppayroll==1)
				  			      $all='e';
				  			    elseif($this->grouppayroll==2)
				  			      $all='t';
				  			   
				  			   //to get an id  
				  			     $mod_id= $model->search_($acad);
				  			      $mod_id=$mod_id->getData();
				  			      foreach($mod_id as $i)
				  			        {
				  			        	$id = $i->id;
				  			        	 break;
				  			        	}
				  			      
				  			 	
				  			 	}
				  			
				  			if($this->message_noOneSelected)
				  			 {  
				  			 	 echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
								   <tr>
								    <td style="text-align:center;">';
					    
				  			 	echo '<span style="color:red;" >'.Yii::t('app','You must select at least a person.').' </span> <br/>';
				  			 	  $this->message_noOneSelected =false;
				  			 	
				  			 	echo'</td>
								    </tr>
									</table>';
									
				  			 	}
				  			 			   
				  	 
					
					 
					
           echo '</div></label>';

          
              
              	    	  	
	    	  	 if(!isset($_GET['group'])) //to create  
                   {
	    	  	       
	    	  	       $dataProvider=PayrollSettings::model()->searchPersonsMakePayroll($condition);
	    	  	     $provider_to_show_button = $dataProvider;
	    	  	         $this->widget('zii.widgets.grid.CGridView', array(
					    //'id'=>'grades-grid',
						'dataProvider'=>$dataProvider,
						'showTableOnEmpty'=>'true',
						'selectableRows' => 2,
						//'filter'=>$model,
					    'columns'=>array(
						 	
						 array('name'=>$header,
					                'header'=>$header,
						        'value'=>'$data->first_name." ".$data->last_name'
								),
					     array('header' =>Yii::t('app','Amount'), 
					            'value'=>'$data->Amount',
					             ),
					           
					       
					     array(  'header' =>Yii::t('app','An Hour'),
					                  'value'=>'$data->anHour',
					                 ), 
					                 
					     array('header' =>Yii::t('app','Number Of Hour'), 'id'=>'numberHourValue', 'value' => '\'
					           <input name="numberHour[\'.$data->id.\']" type=text value="\'.$data->numberHour.\'" style="width:92%;"  disabled  />
					          
							   <input name="id_payroll_set[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
					           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
					           \'','type'=>'raw' ),
					     
					      array('header' =>Yii::t('app','Cash/Check'), 'id'=>'cashCheckValue', 'value' => '\'
					           <input name="cashCheck[\'.$data->id.\']" type=text  style="width:92%;"  />
					          
							   <input name="id_payroll_set[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
					           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
					           \'','type'=>'raw' ),
					           
					       
					     array(             'class'=>'CCheckBoxColumn',   
					                           'id'=>'chk',
					                 ),           
							
					       ),
					    ));
					                          
                     }
                  else  //to update
                    {
                         
                         $dataProvider=Payroll::model()->searchPersonsForUpdatePayroll($condition,$this->payroll_month, $this->payroll_date, $acad);
                         $provider_to_show_button =$dataProvider;	
                                         
                       $this->widget('zii.widgets.grid.CGridView', array(
					    //'id'=>'grades-grid',
						'dataProvider'=>$dataProvider,
						'showTableOnEmpty'=>'true',
						'selectableRows' => 2,
						//'filter'=>$model,
					    'columns'=>array(
						  	
						 array('name'=>$header,
					                'header'=>$header,
						        'value'=>'$data->first_name." ".$data->last_name'
								),
					     array('header' =>Yii::t('app','Amount'), 
					            'value'=>'$data->Amount',
					             ),
					           
					       
					     array(  'header' =>Yii::t('app','An Hour'),
					                  'value'=>'$data->anHour',
					                 ), 
					                 
					     array('header' =>Yii::t('app','Number Of Hour'), 'id'=>'numberHourValue', 'value' => '\'
					           <input name="numberHour[\'.$data->id.\']"  value="\'.$data->numberHour.\'" type=text style="width:92%;" disabled  />
					          
							   <input name="id_payroll[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
					           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
					           \'','type'=>'raw' ),
					           
					     array('header' =>Yii::t('app','Cash/Check'), 'id'=>'cashCheckValue', 'value' => '\'
					           <input name="cashCheck[\'.$data->id.\']" type=text value="\'.$data->cash_check.\'" style="width:92%;"  />
					          
							   <input name="id_payroll[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
					           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
					           \'','type'=>'raw' ),
					           
  
					     array(             'class'=>'CCheckBoxColumn',   
					                           'id'=>'chk',
					                 ),           
							
					       ),
					    ));
					                          							

                     
                     
                      }
	    	  	
	    	  	 
				

			 ?>

 
 
                        </div>       
                   
		           
<br/>        
 
                
              <?php   }
       //fe an gwoup  _________________________________  
                          
                          
   if((($this->group==0)&&($this->person_id!=''))||(($this->group==1)&&($provider_to_show_button->getData()!=null)))
        {
        	                       
     ?>    
   		    
<div class="col-submit">                             
                                <?php 
                         
                            	    if(!isset($_GET['id']))
                            	      {
                            	    	
                            	    	 if(!isAchiveMode($acad_sess))
                            	    	    echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
	                                         
	                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                            	    	     
                            	    	   
                                        }
                                         else
                                           {  
                                           	  if( ((isset($_GET['from1']))&&($_GET['from1']=='vfr'))&&(isset($_GET['add'])))
		                            	    	  {
		                            	    	  	 if(!isAchiveMode($acad_sess))
		                            	    	  	     echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
			                                         
			                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
		                            	    	  	
		                            	    	    }
		                            	    	 else
		                            	    	   {
	                                         
                                           	
		                                           	   if(!isAchiveMode($acad_sess))
		                                           	       echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
		                                            
		                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
		                                              
		                            	    	    }
		                            	    	   
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                        
                                ?>
              
                           </div>
 <?php
        }
 ?>                         
                     </form>
              </div>








	
	
	
	
	
	