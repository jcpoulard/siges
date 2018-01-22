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
	
	$acad=Yii::app()->session['currentId_academic_year'];  
        $acad_name=Yii::app()->session['currentName_academic_year'];
	
	$criteria = new CDbCriteria;
	$criteria->condition='item_name=:item_name';
	$criteria->params=array(':item_name'=>'school_name',);
	$school_name = GeneralConfig::model()->find($criteria)->item_value;
	//echo $school_name;
        // School address
        $criteria2 = new CDbCriteria;
	$criteria2->condition='item_name=:item_name';
	$criteria2->params=array(':item_name'=>'school_address',);
	$school_address = GeneralConfig::model()->find($criteria2)->item_value;
        //School Phone number 
        $criteria3 = new CDbCriteria;
	$criteria3->condition='item_name=:item_name';
	$criteria3->params=array(':item_name'=>'school_phone_number',);
	$school_phone_number = GeneralConfig::model()->find($criteria3)->item_value;
      

  $criteria->condition='item_name=:item_name';
	$criteria->params=array(':item_name'=>'school_acronym',);
	$school_acronym = GeneralConfig::model()->find($criteria)->item_value;
      
      $path=null;
      
?>



   


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
   
   
       <title>""</title>
  

    <!-- Bootstrap core CSS -->
        <!-- Custom styles for this template -->



  </head>
<!-- NAVBAR
================================================== -->



<body>
<div class="row">
    <div class="col-md-2">
        
    </div>
		
    <div class="col-md-8">	
				
				
        <?php $form=$this->beginWidget('CActiveForm', array(
                'id'=>'contact-form',
                'enableClientValidation'=>true,
                'clientOptions'=>array(
                        'validateOnSubmit'=>true,
                ),
        )); ?>



                <div class="form-group col-md-6">
                        <?php echo $form->labelEx($model,'name',array('for'=>'name')); ?>
                        <?php echo $form->textField($model,'name',array('class'=>'form-control')); ?>
                    <span class="alert-danger"><?php echo $form->error($model,'name'); ?></span>
                </div>

                 <div class="form-group col-md-6">
                        <?php echo $form->labelEx($model,'email',array('for'=>'email')); ?>
                        <?php echo $form->textField($model,'email',array('class'=>'form-control')); ?>
                       <span class="alert-danger"> <?php echo $form->error($model,'email'); ?></span>
                </div>

               <div class="form-group col-md-6">
                        <?php echo $form->labelEx($model,'subject',array('for'=>'subject')); ?>
                        <?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>128,'class'=>'form-control')); ?>
                   <span class="alert-danger">   <?php echo $form->error($model,'subject'); ?></span>
                </div>

               <div class="form-group col-md-6">
                        <?php echo $form->labelEx($model,'body',array('for'=>'body')); ?>
                        <?php echo $form->textArea($model,'body',array('rows'=>6, 'cols'=>50,'class'=>'form-control')); ?>
                   <span class="alert-danger">  <?php echo $form->error($model,'body'); ?></span>
                </div>

                <?php if(CCaptcha::checkRequirements()): ?>
                <div class="form-group col-md-12">
                        <?php echo $form->labelEx($model,'verifyCode',array('for'=>'verifyCode')); ?>
                        
                        <?php $this->widget('CCaptcha'); ?>
                        <?php echo $form->textField($model,'verifyCode',array('class'=>'form-control')); ?>
                        
                    <span class="alert-danger"><?php echo $form->error($model,'verifyCode'); ?></span>
                </div>
                <?php endif; ?>

                <div class="col-md-6">
                        <?php echo CHtml::submitButton(Yii::t('app','Send message'),array('class'=>'btn btn-success')); ?>
                </div>

        <?php $this->endWidget(); ?>
        
    </div>
				
	<div class="col-md-2">
        
        </div>
    
</div>

 </body>
</html>
