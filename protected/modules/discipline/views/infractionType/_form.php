<div class="form">
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


$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'infraction-type-form',
	'enableAjaxValidation'=>false,
)); ?>
<p class="note">
    
    <?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?>
</p>
<?php echo $form->errorSummary($model); ?>


<div  id="resp_form_siges">

<form  id="resp_form">
    <div class="col-3">
            <label id="resp_form">
                <?php echo $form->labelEx($model,'name'); ?>
                <?php echo $form->textField($model,'name',array('size'=>60,'placeholder'=>Yii::t('app','Infraction type'))); ?>
            </label>
    </div>
    
    <div class="col-3">
        <label id="resp_form">
            <?php echo $form->labelEx($model,'deductible_value'); ?>
            <?php 
                  if(RecordInfraction::model()->getDiscGradeMethod()==1)
                      echo $form->textFieldRow($model,'deductible_value',array('size'=>60,'placeholder'=>Yii::t('app','Deduction make by %'),'labelOptions' => array('label' => false),'append'=>'%', ));
                  elseif(RecordInfraction::model()->getDiscGradeMethod()==0) 
                       echo $form->textField($model,'deductible_value',array('size'=>60,'placeholder'=>Yii::t('app','Deduction make by value') ));


?>
          
        </label>
    </div>
    
    <div class="col-3">
        <label id="resp_form">
            <?php echo $form->labelEx($model,'description'); ?>
            <?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>60,'placeholder'=>Yii::t('app', ' Description'))); ?>
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
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                             if(!isset($_GET['from']))
                                                echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                                ?>
    </div>
   
</form>
</div>



<?php $this->endWidget(); ?>

</div>

