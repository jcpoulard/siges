<?php
/* @var $this CmsMenuController */
/* @var $model CmsMenu */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	

	<div class="row">
		
		<?php echo $form->textField($model,'menu_label',array('size'=>60,'maxlength'=>64,'placeholder'=>Yii::t('app','Search'))); ?>
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
        </div>

	

<?php $this->endWidget(); ?>

</div><!-- search-form -->