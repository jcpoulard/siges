<?php /*
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
<div class="wide form">
<?php
 $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    
 <div class="row">
		
    <?php echo $form->textField($model,'student_last_name',array('size'=>45,'maxlength'=>45,'placeholder'=>Yii::t('app','Student last name'))); ?>
   <?php echo $form->textField($model,'room_name',array('size'=>45,'maxlength'=>45,'placeholder'=>Yii::t('app','Room name'))); ?>
   <?php
        echo $form->dropDownList($model, "presence_type",$model->getPresenceStatus(),
                array('prompt'=>Yii::t('app','-- Select presence status --'),'disabled'=>false)
                );
   ?>
   <?php 
    $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
                                                     'model'=>'$model',
                                                     'name'=>'RecordPresence[date_record]',
                                                     'language' => 'fr',  
                                                     'value'=>$model->date_record,
                                                     
                                                     'htmlOptions'=>array('size'=>10, 'style'=>'width:100px !important','placeholder'=>Yii::t('app','Attendance date')),
									 'options'=>array(
									 'showButtonPanel'=>true,
                                                                         'yearRange'=>'2012:2100',    
									 'changeYear'=>true,                                      
									 'changeYear'=>true,
                                                                        'dateFormat'=>'yy-mm-dd',
                                                                         
									 ),
								 )
							 );
   ?>  
     
    <?php echo CHtml::submitButton(Yii::t('app','Search')); ?>
</div>

<?php $this->endWidget(); ?>
</div>