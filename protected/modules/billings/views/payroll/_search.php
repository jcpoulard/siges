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
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>


	<div class="row">
		 <?php echo $form->textField($model,'first_name',array('size'=>20,'maxlength'=>40, 'placeholder'=>Yii::t('app','First name'))); ?>
                <?php echo $form->textField($model,'last_name',array('size'=>20,'maxlength'=>40, 'placeholder'=>Yii::t('app','Last name'))); ?>
                 <?php  echo $form->dropDownList($model, 'payroll_month',$model->getLongMonthValue(),array('prompt'=>Yii::t('app','-- Select month --'))  );   
                        
                   ?>

                
                <?php echo CHtml::submitButton(Yii::t('app','Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->