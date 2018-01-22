
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

$acad_sess=acad_sess();  
$acad=Yii::app()->session['currentId_academic_year'];

?>


<?php $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

</br>
<div class="b_m">

	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

	

	
<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        <tr>
                          <td><?php echo $form->labelEx($model,'employee'); ?> </td>
                          <td>
								<?php 
								if(isset($_GET['emp'])&&($_GET['emp']!="")) 
								  {
						            	$this->extern=true;
						            	
						            	
								      $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=0 AND active IN(1,2) AND id='.$_GET['emp']));
								
										echo $form->dropDownList($model, 'employee',
										CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
						
						            }
						          elseif(isset($_GET['id'])&&($_GET['id']!="")) 
								  {
						            	
						            	
						            	
								      $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=0  AND active IN(1,2)'));
								
										echo $form->dropDownList($model, 'employee',
										CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
						
						            }
						          else
						            {  $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=0  AND active IN(1,2)'));
								
										echo $form->dropDownList($model, 'employee',
										CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
										array('prompt'=>Yii::t('app','-- Please select teacher --'))
										);
										
						            }
								?>
								<?php echo $form->error($model,'employee'); ?>                          
		                   </td>
                          
                          <td><?php echo $form->labelEx($model,'hire_date'); ?> </td>
                          <td>
								<?php 
								
						  		 $this->widget('zii.widgets.jui.CJuiDatePicker',
										 array(
												 'model'=>'$model',
												 'name'=>'EmployeeInfo[hire_date]',
												 'language'=>'fr',
												 'value'=>$model->hire_date,
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
								<?php echo $form->error($model,'hire_date'); ?>
		                 </td>

                          
                        </tr>
						<tr>
                          <td><?php echo $form->labelEx($model,'country_of_birth'); ?> </td>
                          <td>
								<?php echo $form->textField($model,'country_of_birth',array('size'=>45,'maxlength'=>45)); ?>
								<?php echo $form->error($model,'country_of_birth'); ?>
                          </td>
                          
                          <td><?php echo $form->labelEx($model,'university_or_school'); ?> </td>
                          <td>
							<?php echo $form->textField($model,'university_or_school',array('size'=>45,'maxlength'=>45)); ?>
							<?php echo $form->error($model,'university_or_school'); ?>                         
					     </td>

                          
                        </tr>
						<tr>
                          <td><?php echo $form->labelEx($model,'number_of_year_of_study'); ?> </td>
                          <td>
							<?php echo $form->textField($model,'number_of_year_of_study'); ?>
							<?php echo $form->error($model,'number_of_year_of_study'); ?>
                          </td>
                          
                          <td><?php echo $form->labelEx($model,'field_study'); ?> </td>
                          <td>
							<?php 
							//echo $form->textField($model,'field_study'); 
							$criteria = new CDbCriteria(array('order'=>'field_name',));
							
							echo $form->dropDownList($model, 'field_study',
							CHtml::listData(FieldStudy::model()->findAll($criteria),'id','field_name'),
							array('prompt'=>Yii::t('app','-- Please select a field name --'))
							);
							?>
							<?php echo $form->error($model,'field_study'); ?>                          
							</td>
                          
                        </tr>
						<tr>
                          <td> <?php echo $form->labelEx($model,'qualification'); ?></td>
                          <td>
								<?php  
								
								
								$criteria = new CDbCriteria(array('order'=>'qualification_name',));
								
								echo $form->dropDownList($model, 'qualification',
								CHtml::listData(Qualifications::model()->findAll($criteria),'id','qualification_name'),
								array('prompt'=>Yii::t('app','-- Please select a qualification --'))
								);
								?>
								<?php echo $form->error($model,'qualification'); ?>
                          </td>
                          
                          <td><?php echo $form->labelEx($model,'job_status'); ?> </td>
                          <td>
								<?php 
								
								$criteria = new CDbCriteria(array('order'=>'status_name',));
								
								echo $form->dropDownList($model, 'job_status',
								CHtml::listData(JobStatus::model()->findAll($criteria),'id','status_name'),
								array('prompt'=>Yii::t('app','-- Please select a job status --'))
								);
								?>
								<?php echo $form->error($model,'job_status'); ?>
                          </td>

                          
                        </tr>
						<tr>
                          <td><?php echo $form->labelEx($model,'permis_enseignant'); ?> </td>
                          <td>
                              
								<?php echo $form->textField($model,'permis_enseignant'); ?>
								<?php echo $form->error($model,'permis_enseignant'); ?>

                          </td>
                          
                          
                          <td><?php echo $form->labelEx($model,'leaving_date'); ?> </td>
                          <td>
                              
								<?php 
								
								
						 		 $this->widget('zii.widgets.jui.CJuiDatePicker',
									 array(
											 'model'=>'$model',
											 'name'=>'EmployeeInfo[leaving_date]',
											 'language'=>'fr',
											 'value'=>$model->leaving_date,
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
								<?php echo $form->error($model,'leaving_date'); ?>
                          </td>
                          
                          
                        </tr>
                      
                      <tr>
                         <td><?php echo $form->labelEx($model,'comments'); ?> </td>
                          <td>
                              
								<?php echo $form->textArea($model,'comments',array('rows'=>3, 'cols'=>60)); ?>
								<?php echo $form->error($model,'comments'); ?>

                          </td>
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
                                              $url=Yii::app()->request->urlReferrer;
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
              
              </div>
<!-- END OF TEST -->	
	
	
	
	
	
	