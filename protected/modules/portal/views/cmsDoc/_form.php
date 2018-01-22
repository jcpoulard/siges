<?php
/* @var $this CmsDocController */
/* @var $model CmsDoc */
/* @var $form CActiveForm */
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'cms-doc-form',
	'enableAjaxValidation'=>false,
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
      ),
        
)); ?>
    
    <p class="note">
        <?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?>
    </p>

    	<?php echo $form->errorSummary($model); ?>
    
    <div  id="resp_form_siges">
        
        <form  id="resp_form" >
            <div class="col-3">
            <label id="resp_form">
                <?php echo $form->labelEx($model,'document_name'); ?>
                <?php if(isset($_GET['id'])){
                    echo '<input type="file" name="document_name"/>'.$model->document_name;;
                }else{
                   echo '<input type="file" name="document_name"/>';  
                } 
                
                ?> 
		<?php echo $form->error($model,'document_name'); ?>
            </label>
            </div>
            
            <div class="col-3">
            <label id="resp_form">
                <?php echo $form->labelEx($model,'document_title'); ?>
		<?php echo $form->textField($model,'document_title',array('size'=>60,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'document_title'); ?>
            </label>
            </div>
            
            <div class="col-3">
            <label id="resp_form">
                <?php echo $form->labelEx($model,'document_description'); ?>
		<?php echo $form->textArea($model,'document_description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'document_description'); ?>
            </label>
            </div>
            
       
        
    </div>

    <div class="col-submit">
                                
            <?php if(!isset($_GET['id'])){
                     echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning'));
                     echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                    }
                     else
                       {  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));

                          echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));

                         } 
                       //back button   
                          $url=Yii::app()->request->urlReferrer;
                          $explode_url= explode("php",substr($url,0));

                         if(!isset($_GET['from']))
                            echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                ?>
    </div>     
	

	

<?php $this->endWidget(); ?>
 </form>
        
</div><!-- form -->