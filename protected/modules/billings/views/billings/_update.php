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


$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

?>

<?php $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

<?php 


$from=null;
if(isset($_GET['from']))
   $from=$_GET['from'];


?>



	<p class="note"><?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model); ?>
	
	
	
		

<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                       <?php if(($from!='bap')&&($this->old_balance!=0))
							   {
							?> 
							
							
							<tr>
                           <td><?php echo $form->label($model,'is_only_balance'); ?></td>
                           <td>	
							
																
							        <?php if($this->is_b_check==1)
									           echo $form->checkBox($model,'is_only_balance',array('onchange'=> 'submit()','checked'=>'checked'));
											   else
												   echo $form->checkBox($model,'is_only_balance',array('onchange'=> 'submit()')); ?>
							        
							  </td> 
						      <td></td>
						      <td></td>
						    </tr>  
						      <?php } ?>
      						
                        
                        <tr>
                           <td><?php echo $form->labelEx($model,'student'); ?></td>
                           <td>
								<?php //echo $form->textField($model,'student');
									
								$criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=1'));
								
								if(($this->is_b_check==1)||($from=='bap'))
								echo $form->dropDownList($model, 'student',
								CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
								array('prompt'=>Yii::t('app','-- Please select student --'),'disabled'=>'disabled')
								);
								else
									echo $form->dropDownList($model, 'student',
									CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
									array('prompt'=>Yii::t('app','-- Please select student --'))
									);
									
								 ?>
								<?php echo $form->error($model,'student'); ?>
		                  </td>
                        
                          <td><?php  echo $form->labelEx($model,'fee_period'); ?></td>
                          <td>
                             
							<?php 
							
							
							$criteria = new CDbCriteria(array('order'=>'fee_name'));
							$data_fees = Fees::model()->findAll($criteria); 
							if(($this->is_b_check==1)||($from=='bap'))
							echo $form->dropDownList($model, 'fee_period',
							CHtml::listData($data_fees,'id','fee_name','amount'),
							array('prompt'=>Yii::t('app','-- Please select fee name ---'),'onchange'=>"$('#amount_to_pay').val($(this).val());",'disabled'=>'disabled'));
							else
								echo $form->dropDownList($model, 'fee_period',
								CHtml::listData($data_fees,'id','fee_name','amount'),
								array('prompt'=>Yii::t('app','-- Please select fee name ---'),'onchange'=>"$('#amount_to_pay').val($(this).val());"));
								
							
						?>
						
							<?php echo $form->error($model,'fee_period'); ?>
                          </td>
                          
                        </tr>
						<tr>
                          <td><?php echo $form->labelEx($model,'amount_to_pay'); ?></td>
                          <td>
                             
							<?php 
							          echo $form->textField($model,'amount_to_pay',array('readonly' => true,'disabled'=>'disabled'));
							      
							       ?>
                          </td>
                          <td><?php echo $form->labelEx($model,Yii::t('app','Amount paid')); ?></td>
                          <td>
                             
							<?php echo $form->textField($model,'amount_pay',array('readonly' => true,'disabled'=>'disabled')); ?>
							<?php echo $form->error($model,'amount_pay'); ?>
                          </td>
                          
                        </tr>

						<tr>
                          <td><?php echo $form->labelEx($model,'amount_pay'); ?></td>
                          <td>
                             
							<?php 
							      $model->setAttribute('amount_pay',"");
							        if($this->old_balance==0)
							           echo $form->textField($model,'amount_pay',array('disabled'=>'disabled'));
							        else
							           echo $form->textField($model,'amount_pay'); ?>
							<?php echo $form->error($model,'amount_pay'); ?>
                          </td>
                          <td><?php echo $form->labelEx($model,'balance_to_pay'); ?></td>
                          <td>
                            
							<?php 
							      
							      $model->setAttribute('balance_to_pay',$model->balance);
							     echo $form->textField($model,'balance_to_pay',array('readonly' => true,'disabled'=>'disabled')); ?>
							<?php echo $form->error($model,'balance_to_pay'); ?>
                          </td>
                          
                        </tr>

						<tr>
                          <td><?php echo $form->labelEx($model,'balance_to_pay'); ?></td>
                          <td>
                             
							<?php 
							      
							      $model->setAttribute('balance_to_pay',$model->balance);
							     echo $form->textField($model,'balance_to_pay',array('readonly' => true,'disabled'=>'disabled')); ?>
							<?php echo $form->error($model,'balance_to_pay'); ?>
                          </td>
                          <td><?php echo $form->labelEx($model,'balance'); ?></td>
                          <td>
							<?php echo $form->textField($model,'balance',array('readonly' => true,'disabled'=>'disabled')); ?>
							<?php echo $form->error($model,'balance'); ?>
						</td>
                          
                        </tr>

						<tr>
						  <td><?php echo $form->labelEx($model,'date_pay'); ?></td>
						  <td>
								<?php 
								
								
								
								
						 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
												 array(
														 'model'=>'$model',
														 'name'=>'Billings[date_pay]',
														 //'language'=>'de',
														 'value'=>$model->date_pay,
														 'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
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
								       { echo '<span class="required">'.Yii::t('app','You must have a date for this payment.').'</span>';
								           $this->message_datepay=false;
								       }
								 ?>
						 </td>
						  
                          <td><?php echo $form->labelEx($model,'payment_method'); ?></td>
                          <td>
					                             
							<?php 
							
							$criteria = new CDbCriteria(array('order'=>'method_name'));
							
							echo $form->dropDownList($model, 'payment_method',
							CHtml::listData(PaymentMethod::model()->findAll($criteria),'id','method_name'),
							array('prompt'=>Yii::t('app','-- Please select a payment method --')));
							
							
							?>
							<?php echo $form->error($model,'payment_method'); 
							     if($this->message_paymentMethod)
							       { echo '<span class="required">'.Yii::t('app','Please fill payment method Field.').'</span>';
							           $this->message_paymentMethod=false;
							       }
							
							?>
                          </td>
                          
                        </tr>

<tr>
                          <td><?php echo $form->labelEx($model,'comments'); ?></td>
                          <td>
					                             
							<?php echo $form->textArea($model,'comments',array('rows'=>3, 'cols'=>160)); ?>
							<?php echo $form->error($model,'comments'); ?>
                          </td>
                          
                          <td></td>
                          <td></td>
                          
                        </tr>
                       
                        
                        <tr>
                            <td colspan="4"> 
                                
                                <?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                        
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))   
                                                  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          
                                ?>
                                
                            </td>
                            
                        </tr>
                       
                      
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>
<!-- END OF TEST -->



