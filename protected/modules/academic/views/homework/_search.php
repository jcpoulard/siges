
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

?>

<?php
/* @var $this HomeworkController */
/* @var $model Homework */
/* @var $form CActiveForm */
?>



<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		
		<?php echo $form->textField($model,'person_fname',array('size'=>25,'maxlength'=>25,'placeholder'=>Yii::t('app','Teacher'))); ?>
       	
		<?php echo $form->textField($model,'course_name',array('size'=>25,'maxlength'=>25,'placeholder'=>Yii::t('app','Subject'))); ?>
		
		<?php echo $form->textField($model,'title',array('size'=>45,'maxlength'=>45,'placeholder'=>Yii::t('app','Homework Title'))); ?>
		
		
	
		<?php echo CHtml::submitButton(Yii::t('app','Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->