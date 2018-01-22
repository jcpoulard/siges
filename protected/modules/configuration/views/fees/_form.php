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
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$acad_name=Yii::app()->session['currentName_academic_year'];

$currency_symbol = Yii::app()->session['currencySymbol'];
$currency_name = Yii::app()->session['currencyName'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


 ?>

<div class="form">
	
<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	 echo $form->errorSummary($model); ?>

<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form">
    
                          <label for="Level"><?php echo Yii::t('app', 'Level'); ?></label>
                          
                              <?php 
                                       $criteria = new CDbCriteria(array('alias'=>'l', 'order'=>'l.level_name ASC','join'=>'inner join level_has_person lhp on(lhp.level = l.id)', 'condition'=>'lhp.academic_year ='.$acad_sess));
		
								echo $form->dropDownList($model, 'level',
								CHtml::listData(Levels::model()->findAll($criteria),'id','level_name'),
                                                                       
								array('prompt'=>Yii::t('app','-- Please select level --'))
								);
								
								 ?>
                              <?php //echo $form->error($model,'level'); ?>
            </label>
        </div>

         
        <div class="col-3">
            <label id="resp_form">    
                          
                        <?php echo $form->labelEx($model,'fee'); ?>
                          
                                <?php $criteria = new CDbCriteria(array('condition'=>'fee_label NOT LIKE("Pending balance")','order'=>'id'));
		
								echo $form->dropDownList($model, 'fee',
								CHtml::listData(FeesLabel::model()->findAll($criteria),'id','fee_label'),
                                                                       
								array('prompt'=>Yii::t('app','-- Please select fee --'))
								);
								
								 ?>
								 
                              
            </label>
        </div>
            
        <div class="col-3">
            <label id="resp_form">    
                          
                          <?php echo $form->labelEx($model,'amount'); ?>
                          <?php echo $form->textField($model,'amount',array('size'=>60,'placeholder'=>Yii::t('app','Amount'))); ?>
                               <?php echo $form->error($model,'amount'); ?>
            </label>
        </div>
                          
        <div class="col-3">
            <label id="resp_form">              
                         <label for="Devise"><?php echo Yii::t('app', 'Currency'); ?></label>
                          
                           
						<?php echo $form->textField($model,'devise',array('size'=>60,'placeholder'=>$currency_name, 'readOnly'=>true, 'disabled'=>'disabled')); ?> 
								
							
                              <?php echo $form->error($model,'devise'); ?>
            </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">    
                
                          <?php echo $form->labelEx($model,'date_limit_payment'); ?>
                          <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
								 array(
										 'model'=>'$model',
										 'name'=>'Fees[date_limit_payment]',
										 'language'=>'fr',
										 'value'=>$model->date_limit_payment,
										 'htmlOptions'=>array('size'=>100,'style'=>'width:100% !important','placeholder'=>Yii::t('app','Date Limit Payment')),
											 'options'=>array(
											 'showButtonPanel'=>true,
											 'changeYear'=>true,                                      
											 'changeYear'=>true,
		                                     'dateFormat'=>'yy-mm-dd',   
											 ),
										 )
									 );
				             ?>
                               <?php echo $form->error($model,'date_limit_payment'); ?>
            </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">    
                       <?php echo $form->labelEx($model,'description'); ?>
                          
                              <?php echo $form->textArea($model,'description',array('rows'=>4, 'cols'=>60,'placeholder'=>Yii::t('app',' Description'))); ?>
                              <?php echo $form->error($model,'description'); ?>
                          
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
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo '<a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                         
                                ?>
            </div>
        </form>
</div>
                        
<!-- END OF TEST -->

</div>



