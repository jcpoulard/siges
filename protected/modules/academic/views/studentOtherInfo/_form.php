
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




$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

 

 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

?>

</br>
<div class="b_mail">

	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

	

	
<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        <tr>
                          <td><?php echo $form->labelEx($model,'student'); ?> </td>
                          <td>
								<?php 
								if(isset($_GET['stud'])&&($_GET['stud']!="")) 
								  {
						            	$this->extern=true;
						            	
						            	
								      $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=1 AND active IN(1,2) AND id='.$_GET['stud']));
								
										echo $form->dropDownList($model, 'student',
										CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
						
						            }
						          elseif(isset($_GET['id'])&&($_GET['id']!="")) 
								  {
						            	
						            	
						            	
								      $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=1  AND active IN(1,2)'));
								
										echo $form->dropDownList($model, 'student',
										CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
						
						            }
						          else
						            {  $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=1  AND active IN(1,2)'));
								
										echo $form->dropDownList($model, 'student',
										CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
										array('prompt'=>Yii::t('app','-- Please select student --'))
										);
										
						            }
								?>
								<?php echo $form->error($model,'student'); ?>                          
		                   </td>
                                                  </tr>
						<tr>
                          
                          <td><?php echo $form->labelEx($model,'school_date_entry'); ?> </td>
                          <td>
								<?php 
								
						  		 $this->widget('zii.widgets.jui.CJuiDatePicker',
										 array(
												 'model'=>'$model',
												 'name'=>'StudentOtherInfo[school_date_entry]',
												 
												 'value'=>$model->school_date_entry,
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
								<?php echo $form->error($model,'school_date_entry'); ?>
		                 </td>
                        
                           <td><?php echo $form->labelEx($model,'previous_school'); ?> </td>
                          <td>
							<?php echo $form->textField($model,'previous_school',array('size'=>60,'maxlength'=>255)); ?>
							<?php echo $form->error($model,'previous_school'); ?>                         
					     </td>
                      
                       </tr>
                       <tr>  
                        <td><?php 
                        if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Entry Level'); 
                         ?>
                    </td>
                    <td>
                        <?php 
					 
					 
						$modelLevelPerson = new LevelHasPerson;
						if($model->student!='')//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {   $level=$this->getLevelByStudentId($model->student,$acad_sess);
                                                       if($level != null)
						          $this->idLevel=$level->id;
                                                       else
                                                           $this->idLevel=null;
                                                       
					            }
							     
					     if(isset($this->idLevel))
						         echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByStudentId($model->student), array('options' => array($this->idLevel=>array('selected'=>true)), 'onchange'=> 'submit()',)); 
							  else
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByStudentId($model->student), array('onchange'=> 'submit()' )); 
					       }
						else //for create
						   {    $tudent='';  
						   	
						   	 if(isset($_GET['stud'])&&($_GET['stud']!=''))
						            $tudent=$_GET['stud'];
						            
						   	  if(isset($this->idLevel))
							      echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByStudentId($tudent), array('onchange'=> 'submit()','options' => array($this->idLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByStudentId($tudent), array('onchange'=> 'submit()' )); 
						   }
						   
						     echo $form->error($modelLevelPerson,'level'); 
						
					 
					  ?>
                    </td>
                        
                        <td>
                        <?php echo $form->labelEx($model,'previous_level'); ?>
                    </td>
                    <td>
                    <?php 
                       
						
						 //for create
							 if(isset($this->idPreviousLevel))
							    echo $form->dropDownList($model,'previous_level',$this->loadPreviousLevel($this->idLevel), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($model,'previous_level',$this->loadPreviousLevel($this->idLevel)); 

		
		 echo $form->error($model,'previous_level'); 
		 
					
                    ?>
                    </td>
                          
                       </tr>
                       <tr> 
						
                          <td><?php echo $form->labelEx($model,'leaving_date'); ?> </td>
                          <td>
                              
								<?php 
								
								
						 		 $this->widget('zii.widgets.jui.CJuiDatePicker',
									 array(
											 'model'=>'$model',
											 'name'=>'StudentOtherInfo[leaving_date]',
											 
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
                          
                          <td></td>
                          <td></td>
                                                    
                        </tr>
						
						
                            <td colspan="4"> 
                                
                                <?php if(!isset($_GET['id'])){
                                         echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
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
