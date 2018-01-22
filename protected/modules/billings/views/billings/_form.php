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
/* @var $this BillingsController */
/* @var $model Billings */
/* @var $form CActiveForm */



    
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

$percentage_pay =0;


if(!isset($_GET['id']))
 {
?>


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        

                           
     
      						<div class="span2" >
                                
                               
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Recettes Items'));
                                        
                                        if(isset($this->recettesItems)&&($this->recettesItems!=''))
							       echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
                     
        </div>
    </div>
<br/>
<ul class="nav nav-tabs nav-justified"></ul>

<?php
    }

   	 
   	  $this->message_fullScholarship=false;
   	  $this->message_scholarship=false;
   	  //check if student is a full scholarship holder
  if($this->student_id!='')
   	{
   	   //check if student is scholarship holder
	   $model_scholarship = Persons::model()->getIsScholarshipHolder($this->student_id,$acad_sess); 
   	 $modelFee = Fees::model()->findByPk($this->fee_period);
   	   
														           	  	
																		$percentage_pay = 0;
																		 $this->internal=0;
                                                                       $partner_repondant = NULL;																		                                                           if($modelFee!=NULL)
																			{
																			          if($model_scholarship == 1) //se yon bousye
																			           {  //tcheke tout fee ki pa null nan bous la
																							   $notNullFee = ScholarshipHolder::model()->feeNotNullByStudentId($this->student_id,$acad_sess);
																			           	      $notNullFee = $notNullFee->getData();
																						   if($notNullFee!=NULL)
																							{																								
																							  foreach($notNullFee as $scholarship)
																			           	    	{
																			           	    	  
																				           	    	if(isset($scholarship->fee))
																				           	    	 {
																				           	    	   if($scholarship->fee == $modelFee->id)
																				           	    	    { 
																				           	    	    	$percentage_pay = $scholarship->percentage_pay;
																			           	                    $this->full_scholarship = true;
																												   $this->message_fullScholarship = true;
	
																										   if(($partner_repondant==NULL))
																										    {	
																												 if(($percentage_pay==100))
																												  { 																										                                              $this->internal=1;
																													 $partner_repondant = $scholarship->partner;
																												  }
																												 else
																												    $this->internal=0;
																										     
																											  }
																											 
																				           	    	     }
																				           	    	  }
																				           	    	 
																				           	    	 
																			           	    	 }
																								 
																								
																							}
																						   else
																						     {
																								 //fee ka NULL tou
																								  $check_partner=ScholarshipHolder::model()->getScholarshipPartnerByStudentIdFee($this->student_id,NULL,$acad_sess);
																								    
																								  if($check_partner!=NULL)
																								   {  $check_partner = $check_partner->getData();
																							             foreach($check_partner as $cp)
																										   {   $partner_repondant = $cp->partner;
																										      $percentage_pay = $cp->percentage_pay;
																										         break;
																										   }
																								   }
																								   
																								       if(($percentage_pay==100))
																										 { 
																										 	 if(($partner_repondant==NULL))
																									          {  
																										         $this->internal=1;
																									          }
																									          $this->full_scholarship = true;
																								      	          $this->message_fullScholarship = true;
																									     }
																								       else
																								       	{		  

																									   if(($partner_repondant==NULL))
																									      {  
																									      	$this->internal=0;
																										  }
																										  $this->full_scholarship = true;
																								      	          $this->message_fullScholarship = true;
																								       	}
																								  
																							 }
																			           	    	 
																			           	    
																			           	 }
																			           	 
   	                                                                           }
																			             	 
   	 
  
	       	
   	  }       					
 

   
?>






<div class="grid-view" style=" margin-top:-25px;">

	<?php
	
	//get level for this student
								$modelLevel = null;;
								$level=0;
								if($model->student=='')
								  {
								  	if(isset($_GET['stud'])&&($_GET['stud']!=''))
								  	  $modelLevel=$this->getLevelByStudentId($_GET['stud'],$acad_sess);
								  	}
								else
								{
								   $modelLevel=$this->getLevelByStudentId($model->student,$acad_sess);
								   }
								
								if($modelLevel!=null)
								 {
								 	$level=$modelLevel->id;
								 	
								   }
							

	 echo '<br/>'.$form->errorSummary($model); 
	 
	 
	 //error message 
	        	if((!$this->message_paymentAllow) ||($this->message_positiveBalance) ||($this->message_2paymentFeeDatepay) || ($this->message_fullScholarship)|| ($this->message_scholarship) )
				    {   echo '<div class="" style=" padding-left:0px;margin-right:0px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				      
				       echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
				      }
				   
			   	   
				  if(!$this->message_paymentAllow)
				     { 
				     	if($this->special_payment)
				     	   echo '<span style="color:red;" >'.Yii::t('app','Press the SAVE button to confirm this payment.').'</span>'.'<br/>';
				     	 else
				     	    echo '<span style="color:red;" >'.Yii::t('app','Fee is totaly paid.').'</span>'.'<br/>';
				   
				       
				     }
				   
				   if($this->message_positiveBalance)
				     { echo '<span style="color:red;" >'.Yii::t('app','{name} has an old fee with a positive balance.', array('{name}'=>$model->student0->fullName)).'</span>'.'<br/>';
				   
				       
				     }
				    
				     if($this->message_2paymentFeeDatepay)
				     { 
				     	$fee_name='';
				     	$criteria = new CDbCriteria(array('condition'=>'id='.$model->fee_period.' AND level='.$level.' AND academic_period='.$acad_sess));
							                
								$data_fee = Fees::model()->findAll($criteria); 
	                            if($data_fee!=null)
	                              {
	                              	foreach($data_fee as $fee)
	                              	  $fee_name = $fee->fee_name;
	                              	  
	                              	}

				     	echo '<span style="color:red;" >'.Yii::t('app','{name} already has a record for {name_fee} on {name_datePay}. Please, update it.', array('{name}'=>$model->student0->fullName, '{name_fee}'=>$fee_name, '{name_datePay}'=>$model->date_pay )).'</span>'.'<br/>';
				   
				       
				     } 
				     
				  
				 
				   if(($this->message_fullScholarship)||($this->message_scholarship))
				     { 
				     	 echo '<span style="color:red;" >'.Yii::t('app','{name} is subsidized up to {percentage}%.', array('{name}'=>$model->student0->fullName,'{percentage}'=>$percentage_pay)).'</span>'.'<br/>';
				       
				       
				     }
				      
				  
			if((!$this->message_paymentAllow) ||($this->message_positiveBalance) ||($this->message_2paymentFeeDatepay) || ($this->message_fullScholarship)|| ($this->message_scholarship) )
			  {
			  	         echo'</td>
					       </tr>
						  </table>';
						  echo '</div>';
			  	}						
					 
	 
	 ?>

	
	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form"> 
                          <?php echo $form->labelEx($model,'student'); ?>
								<?php 
									
								$criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC','join'=>'left join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1,2) AND rh.academic_year ='.$acad_sess));
								
							if(isset($_GET['id']))
							 {	 
									if(isset($_GET['stud']))
									 {  $this->student_id = $_GET['stud'];
									 	
									 	echo $form->dropDownList($model,'student',$this->loadStudentByCriteria($criteria), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)) ));
										
									  }
									else
									  {
									  	echo $form->dropDownList($model,'student',$this->loadStudentByCriteria($criteria), array('onchange'=> 'submit()', 'disabled'=>'disabled' ));

										
									   }
									   
							  }
							else
							  {
							  	if($this->student_id!='')
							  	 {
								  	
								  	 echo $form->dropDownList($model,'student',$this->loadStudentByCriteria($criteria), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)) ));
								  	 
								  	
							  	  }
							  	else
							  	  {
							  	  	
							  	  	  echo $form->dropDownList($model,'student',$this->loadStudentByCriteria($criteria), array('onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Please select student --') ));
							  	  	
							  	  	
							  	  }
								
							  	}
							  	
								 ?>
								<?php echo $form->error($model,'student'); ?>
                           </label>
        </div>
        <div class="col-3">
            <label id="resp_form">

                    
                   <label for="fee_name" style="color:red;"><?php echo Yii::t('app','Fee name').' *'; ?></label>       
                     
								<?php 
								
								
							$criteria = new CDbCriteria(array('alias'=>'f', 'join'=>'inner join fees_label fl on(fl.id=f.fee)', 'order'=>'fee','condition'=>'fl.status='.$this->status_.' AND level='.$level.' AND academic_period='.$acad_sess));
						if(isset($_GET['id']))
							 {
							 	
							 	
							 	if(isset($_GET['stud']))
								  { 
									 	
									 /*	$data_fees = Fees::model()->findAll($criteria); 
										echo $form->dropDownList($model, 'fee_period',
										CHtml::listData($data_fees,'id','feeName'),
										array('onchange'=>'submit()','options' => array($this->fee_period=>array('selected'=>true)) ));										                    */
										echo $form->dropDownList($model,'fee_period',loadFeeName($this->status_,$level,$acad_sess,$this->student_id), array('onchange'=>'submit()','options' => array($this->fee_period=>array('selected'=>true)) ));
									}
								  else
								     {
								     	/*$data_fees = Fees::model()->findAll($criteria); 
										echo $form->dropDownList($model, 'fee_period',
										CHtml::listData($data_fees,'id','feeName'),
							array('onchange'=>'submit()'  ,'options' => array($this->fee_period=>array('selected'=>true)), 'disabled'=>'disabled'));
							*/
							echo $form->dropDownList($model,'fee_period',loadFeeName($this->status_,$level,$acad_sess,$this->student_id), array('onchange'=>'submit()'  ,'options' => array($this->fee_period=>array('selected'=>true)), 'disabled'=>'disabled'));
	     	
								       }
								       
									   
								
							 }
							else
							  {              
								/* $data_fees = Fees::model()->findAll($criteria); 
								echo $form->dropDownList($model, 'fee_period',
								CHtml::listData($data_fees,'id','feeName'),
								array('prompt'=>Yii::t('app','-- Please select fee name ---'),'onchange'=>'submit()'));
								*/
								echo $form->dropDownList($model,'fee_period',loadFeeName($this->status_,$level,$acad_sess,$this->student_id), array('prompt'=>Yii::t('app','-- Please select fee name ---'),'onchange'=>'submit()'  ));
															    
								}
							 
								
							?>
							
								<?php echo $form->error($model,'fee_period'); ?>
						 </label>
        </div>
 
 
        <div class="col-3">
            <label id="resp_form">
                               <?php echo $form->labelEx($model,'amount_to_pay'); ?>
                          
                          
							<?php 
							    
							     
							          echo $form->textField($model,'amount_to_pay',array('readonly' => true,'disabled'=>'disabled'));
							      
							       ?>
         				 </label>
        </div>

 
 <?php
      
      if(((($this->message_paymentAllow)&&(!$this->message_positiveBalance))&&($this->fee_period!=''))||($this->special_payment))
        {
 
 ?>
        
    <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'payment_method'); ?> 

<?php 
		
									$criteria = new CDbCriteria(array('order'=>'method_name'));
									
									echo $form->dropDownList($model, 'payment_method',
									CHtml::listData(PaymentMethod::model()->findAll($criteria),'id','method_name'),
									array('prompt'=>Yii::t('app','-- Please select a payment method --')));
									
									
									?>
									<?php echo $form->error($model,'payment_method'); 
									     if($this->message_paymentMethod)
									       { echo '<br/><span class="required">'.Yii::t('app','Please fill payment method Field.').'</span>';
									           $this->message_paymentMethod=false;
									       }
									?>
						 </label>
        </div>

    
        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'amount_pay'); ?>
 
<?php if(($model->amount_pay!='')&&(!isset($_GET['id']))&&(!$this->message_2paymentFeeDatepay))       
          echo $form->textField($model,'amount_pay',array('readonly' => true,'disabled'=>'disabled'));
      else
         echo $form->textField($model,'amount_pay', array('size'=>60,'placeholder'=>Yii::t('app','Amount Pay'))); ?>

								<?php echo $form->error($model,'amount_pay'); ?>
                           </label>
        </div>
   
   
   
        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'date_pay'); ?>                              
							<?php 
							        
                                
	                                if((isset($_GET['id'])&&($_GET['id']!='')) || (($this->reservation==true)&&($this->remain_balance==0)) )
	                                   $date__ = $model->date_pay;
	                                else
	                                   $date__ = date('Y-m-d');
							
							
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'Billings[date_pay]',
									 'language'=>'fr',
									 'value'=>$date__,
									 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Date Pay')),
										 'options'=>array(
										 'showButtonPanel'=>true,
										 'changeYear'=>true,                                      
										 'changeYear'=>true,
	                                     'dateFormat'=>'yy-mm-dd',   
										 ),
									 )
								 );
										
								
								?>
								<?php echo $form->error($model,'date_pay'); 
								     if($this->message_datepay)
								       { echo '<br/><span class="required">'.Yii::t('app','You must have a date for this payment.').'</span>';
								           $this->message_datepay=false;
								       }
								
								?>
                           </label>
        </div>

         <div class="col-3">
            <label id="resp_form">

					<?php echo $form->labelEx($model,'comments'); ?>                              
							<?php 
							        
                                echo  $form->textArea($model,'comments',array('rows'=>3, 'cols'=>160)); 
                                echo $form->error($model,'comments');
                          								
								?>
                           </label>
        </div>







<?php 
   
   if((!$this->message_fullScholarship)||( $this->internal==0))
     {
?>                            
                            
                            <div class="col-submit">
 
                                
                                <?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  if(isset($_GET['stud']))
                                                {
                                                	 if(!isAchiveMode($acad_sess))
                                                	     echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                         
                                                  }
                                              else
                                                {     if(!isAchiveMode($acad_sess))
                                                          echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                                    echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                                  }
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                ?>
     
                            
                  </div><!-- /.table-responsive -->
                  
<?php
        }
        
        
        
    }
      
 
 ?>
                   
                  
                </form>
              </div>



</div>

