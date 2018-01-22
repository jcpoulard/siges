<?php
/* @var $this CmsDocController */
/* @var $model CmsDoc */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>
    
    <div class="row">
		<?php echo $form->textField($model,'document_title',array('size'=>40,'maxlength'=>40, 'placeholder'=>Yii::t('app','Document title'))); ?>
        
                <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
	</div>

	
<?php $this->endWidget(); ?>

</div><!-- search-form -->