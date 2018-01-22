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
	'id'=>'record-presence-form',
	'enableAjaxValidation'=>false,
)); ?>

<p class="note">
    
    <?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?>
</p>

	

	<?php echo $form->errorSummary($model); ?>

<div  id="resp_form_siges">

<form  id="resp_form">
        
        <div class="col-2">
            <label id="resp_form">
            <?php echo $form->labelEx($model,'student'); ?>
                              <?php 
                              $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=1 AND active IN (1,2)'));
		
                             echo $form->dropDownList($model, 'student',
                                        CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
                                        array('prompt'=>Yii::t('app','-- Please select student --'),'disabled'=>true)
                                        );
                              ?>
            </label>
        </div>
    
        <div class="col-2">
            <label id="resp_form">
                                  <?php echo $form->labelEx($model,'presence_type'); ?>
                              <?php 
                                echo $form->dropDownList($model, 'presence_type',$model->getPresenceStatus(),
                                        array('prompt'=>Yii::t('app','-- Select presene status --'),'disabled'=>false));
                              ?>
            </label>
        </div>
        <div class="col-2">
            <label id="resp_form">                       
                                <?php echo $form->labelEx($model,'date_record'); ?>
                            
                                
                                <?php 
                             
                                $this->widget('zii.widgets.jui.CJuiDatePicker',
						 array(
                                                     'model'=>'$model',
                                                     'name'=>'RecordPresence[date_record]',
                                                     'language' => 'fr',  
                                                     'value'=>$model->date_record,
                                                     'htmlOptions'=>array('size'=>10, 'style'=>'width:80px !important'),
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
            </label>
        </div>
    
        <div class="col-2">
            <label id="resp_form">                     
                              <?php echo $form->labelEx($model,'comments'); ?> 
                           
                                <?php echo $form->textArea($model,'comments',array('rows'=>4, 'cols'=>50,'placeholder'=>Yii::t('app','Comments'))); ?>
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
				             
                                            
                                                echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

                                ?>
                        </div>
                                
</form>
</div>


	

<?php $this->endWidget(); ?>
</div>

