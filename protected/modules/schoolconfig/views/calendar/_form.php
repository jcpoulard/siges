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

?>
    
<?php
/* @var $this CalendarController */
/* @var $model Calendar */
/* @var $form CActiveForm */

 $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 
 
 $acad_sess=acad_sess();
 $acad=Yii::app()->session['currentId_academic_year']; //current academic year


?>


	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>


<div  id="resp_form_siges">

<form  id="resp_form">



	  <div class="col-2">
			    <label id="resp_form">


      <?php echo $form->labelEx($model,'c_title'); ?>

	<?php echo $form->textField($model,'c_title',array('size'=>60,'maxlength'=>255)); ?>
	<?php echo $form->error($model,'c_title'); ?>

</label>
</div>
	

<div class="col-2">
	<label id="resp_form">

	<?php echo $form->labelEx($model,'location'); ?>
	<?php echo $form->textField($model,'location',array('size'=>60,'maxlength'=>200)); ?>
								<?php echo $form->error($model,'location'); ?>
						</label>
</div>


<div class="col-2">
	<label id="resp_form">
		<?php echo $form->labelEx($model,'start_date'); ?>
		 <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Calendar[start_date]',
								  'language' => 'fr',  
								 'value'=>$model->start_date,
								 'htmlOptions'=>array('size'=>60 ),
									 'options'=>array(
									 'showButtonPanel'=>true,
                                                                         'yearRange'=>'1950:2100',    
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
                                     'dateFormat'=>'yy-mm-dd',   
									 ),
								 )
							 );
					; ?>
								<?php echo $form->error($model,'start_date'); ?>
	 </label>
</div>
	
	
	
<div class="col-2">
	<label id="resp_form">

		<?php echo $form->labelEx($model,'end_date'); ?>
<?php $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
								 'model'=>'$model',
								 'name'=>'Calendar[end_date]',
								  'language' => 'fr',  
								 'value'=>$model->end_date,
								 'htmlOptions'=>array('size'=>60 ),
									 'options'=>array(
									 'showButtonPanel'=>true,
                                                                         'yearRange'=>'1950:2100',    
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
                                     'dateFormat'=>'yy-mm-dd',   
									 ),
								 )
							 );
					; ?>

								<?php echo $form->error($model,'end_date'); ?>
						 </label>
</div>
	
<!--	
<div class="col-2">
	<label id="resp_form">
-->
	<?php /* echo $form->labelEx($model,'start_time'); 
	          $this->widget('ext.timepicker.JTimePicker', array(
								    'model'=>$model,
								     'attribute'=>'start_time',
								     // additional javascript options for the date picker plugin
								     'options'=>array(
								        'showPeriod'=>false,
								         ),
								     'htmlOptions'=>array('size'=>60,'maxlength'=>8 ),
			    
								   ));
								   
								 echo $form->error($model,'start_time'); 
			    */
			?>
<!--							</label>
</div>
-->	
	
<!--	
<div class="col-2">
	<label id="resp_form">
-->
		<?php /* echo $form->labelEx($model,'end_time'); 	
		       $this->widget('ext.timepicker.JTimePicker', array(
								    'model'=>$model,
								     'attribute'=>'end_time',
								     // additional javascript options for the date picker plugin
								     'options'=>array(
								        'showPeriod'=>false,
								         ),
								     'htmlOptions'=>array('size'=>60),
			    
								   ));
								
						echo $form->error($model,'end_time'); 
						
					*/	
			?>
<!--							</label>
</div>
-->	

	
	
<div class="col-2">
	<label id="resp_form">

		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>2, 'cols'=>60)); ?>
			<?php echo $form->error($model,'description'); ?>

	</label>
</div>
	
	
	
<div class="col-2">
	<label id="resp_form">

		<?php echo $form->labelEx($model,'color'); ?>
	<?php echo $form->textField($model,'color',array('size'=>60,'maxlength'=>200,'class'=>'color')); ?>
                              
                               <?php echo $form->error($model,'color'); ?>
                          </label>
</div>
	
	
	
	
                       
                        <div class="col-submit">
                               
                                <?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                                ?>
                                </div>
                             </form>

</div>
			
