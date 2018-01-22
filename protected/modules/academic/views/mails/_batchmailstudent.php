
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
/* @var $this MailsController */
/* @var $model Mails */
/* @var $form CActiveForm */
?>
<?php $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'mails-form',
	'enableAjaxValidation'=>true,
));



$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 

$id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p){
				      $id_teacher=$p->id;
                                      $this->teacher_id = $p->id;
                                 }

?>

	

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		
		<?php 
                $is_disable = true;
                if($this->groupemail!=null){
                 echo $form->dropDownList($model, 'group_email',$this->loadRoomByIdTeacher($id_teacher, $acad_sess),array('onchange'=> 'submit()','options' => array($this->groupemail=>array('selected'=>true))));
                }else{
                    echo $form->dropDownList($model, 'group_email',$this->loadRoomByIdTeacher($id_teacher, $acad_sess),array('onchange'=> 'submit()'));
                }
                
                
                ?>
	
		
          
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'subject'); ?>
		<?php echo $form->textField($model,'subject',array('size'=>60,'maxlength'=>255,'class'=>'input-xxlarge')); ?>
		<?php echo $form->error($model,'subject'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'message'); ?>
		<?php echo $form->textArea($model,'message',array('rows'=>6, 'cols'=>40,'class'=>'ckeditor')); ?>
		<?php echo $form->error($model,'message'); ?>
	</div>

	

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app', 'Send email'),array('name'=>'create','class'=>'btn btn-warning'));
                
                //back button   
                  $url=Yii::app()->request->urlReferrer;
                  $explode_url= explode("php",substr($url,0));

                  echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                            
                ?>
	</div>

<?php $this->endWidget(); ?>

</div>

<!-- form -->