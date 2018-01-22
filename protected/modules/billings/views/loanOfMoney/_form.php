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

/* @var $this LoanOfMoneyController */
/* @var $model LoanOfMoney */
/* @var $form CActiveForm */

    
$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 




?>


<br/>



<div class="grid-view">


	<?php
	
     
	  echo $form->errorSummary($model); 
	
	   	        
	        //error message 
	        	if(($this->messageLoanNotPaid)||($this->messageLoanNotPossible)||($this->messageAmountNotAllowed)||($this->messageRemainPayroll)||($this->messageRefund))//||($this->success))
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ';//-20px; ';
				      echo '">';
				      				      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			       
			       }			      
				 					     	
				   
				    if($this->messageLoanNotPaid)
				      {  echo '<span style="color:red;" >'.$model->person->fullName.', '.Yii::t('app','You are not available to get a loan. Your solde must be zero.').'</span>'.'<br/>';
				      
				          $this->messageLoanNotPossible=false;
				      }
				 
				    if($this->messageLoanNotPossible)
				      echo '<span style="color:red;" >'.Yii::t('app','You cannot get a loan at this month. Payroll or next payroll is already done.').'</span>'.'<br/>';
				    
				     
				    if($this->messageAmountNotAllowed)
				      echo '<span style="color:red;" >'.Yii::t('app','Amount not allowed.').'</span>'.'<br/>';
				      
				    
				     if($this->messageRemainPayroll)
				        echo '<span style="color:red;" >'.Yii::t('app','Number of payroll remain < Repayment deadline(numb. payroll).').'</span>'.'<br/>';

                     
                     if($this->messageRefund)
				        echo '<span style="color:red;" >'.Yii::t('app','Refund > Net salary.').'</span>'.'<br/>';


					   
			     if(($this->messageLoanNotPaid)||($this->messageLoanNotPossible)||($this->messageAmountNotAllowed)||($this->messageRemainPayroll)||($this->messageRefund))//||($this->success))
			      { 
					 echo'</td>
					    </tr>
						</table>';
					
                      echo '</div>';
			       }
       		
	?>

	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-1">
            <label id="resp_form"> 
            
                  <?php  echo $form->labelEx($model,'person_id'); ?>
                          
                  <?php 
                    	 $criteria = new CDbCriteria(array('group'=>'id','alias'=>'p', 'order'=>'last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND (p.id IN(SELECT person_id FROM payroll_settings ps WHERE (ps.academic_year='.$acad.') )) '));
                    	
                    	if(isset($this->person_id)&&($this->person_id!=''))
						  {  
							 echo $form->dropDownList($model, 'person_id',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('onchange'=> 'submit()', 'options' => array($this->person_id=>array('selected'=>true)), 'disabled'=>''));
										    
							}
						 else
							{
								echo $form->dropDownList($model, 'person_id',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array( 'onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Search --'), 'disabled'=>''));
										  	
							 }
										    
													                            
                          
                          ?>
		                <?php echo $form->error($model,'person_id'); ?>
		       
		     </label>
        </div>
        
 <br/>       

<?php
    if($this->person_id!='')
      {
?>        
        <div class="col-4">
            <label id="resp_form">
		       
                 <?php echo $form->labelEx($model,'amount'); ?>
                  
                  <?php echo $form->textField($model,'amount', array('size'=>60,'placeholder'=>Yii::t('app','Amount')) ); ?>
		                 <?php echo $form->error($model,'amount'); ?>
		           
		     </label>
        </div>
        

        
        <div class="col-4">
            <label id="resp_form">

                             <?php echo $form->labelEx($model,'loan_date'); ?>                              
							<?php 
							        
                                
	                                if((isset($_GET['id'])&&($_GET['id']!=''))||($model->loan_date!=''))
	                                   $date__ = $model->loan_date;
	                                else
	                                   $date__ = date('Y-m-d');
							
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'LoanOfMoney[loan_date]',
									 'language'=>'fr',
									 'value'=>$date__,
									 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Loan date')),
										 'options'=>array(
										 'showButtonPanel'=>true,
										 'changeYear'=>true,                                      
										 'changeYear'=>true,
	                                     'dateFormat'=>'yy-mm-dd',   
										 ),
									 )
								 );
										
								
								?>
								<?php echo $form->error($model,'loan_date'); 
								     if($this->message_loandate)
								       { echo '<br/><span class="required">'.Yii::t('app','You must have a date for this loan.').'</span>';
								           $this->message_loandate=false;
								       }
								
								?>
                           </label>
        </div>


        <div class="col-4">
            <label id="resp_form">
		       
		        <?php  echo $form->labelEx($model,'number_of_month_repayment'); ?>
		                                
		         <?php echo $form->textField($model,'number_of_month_repayment', array('size'=>60,'placeholder'=>Yii::t('app','Repayment deadline(numb. of month)'))  ); ?>
		         
		         <?php echo $form->error($model,'number_of_month_repayment'); ?>
		            
		     </label>
        </div>
        
        

        
        <div class="col-4">
            <label id="resp_form">
		       		            
		        <label> <?php  echo Yii::t('app','Repayment start on');  
                         ?> </label>
                    
                  <?php 
                           if($this->payroll_month!=null)
			                 {
							   echo $form->dropDownList($model, 'payroll_month',$this->getSelectedLongMonthValueForOne($this->person_id),array('onchange'=> 'submit()', 'options' => array($this->payroll_month=>array('selected'=>true))));
						       }
						    else
						      {
						         echo $form->dropDownList($model, 'payroll_month',$this->getSelectedLongMonthValueForOne($this->person_id),array('onchange'=> 'submit()'));
						       }

                         ?>
                         
                        <?php echo $form->error($model,'payroll_month'); ?>

		     </label>
        </div>


        
        
       
        <div class="col-submit"> 
                                
                    <?php 
                         if((!$this->messageLoanNotPaid)&&(!$this->messageLoanNotPossible))       
                            {
                            	    if(!isset($_GET['id'])){
                                          if(!isAchiveMode($acad))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                        
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {   if(!isAchiveMode($acad))
                                                   echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                               
                            }
                         else
                            echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                       
                                ?>
                    
                          </div>
                        
 <?php
        }
 ?>                       
                        
                          
                     </form>
              </div>



</div>





