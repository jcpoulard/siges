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
/* @var $this ChargeDescriptionController */
/* @var $model ChargeDescription */
/* @var $form CActiveForm */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

 
?>


<div class="b_m">

<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

</br>
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form"> 
                    
                   <?php echo $form->labelEx($model,'description'); ?>

                        <?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>65,'placeholder'=>Yii::t('app','Income Description'))); ?>
		                <?php echo $form->error($model,'description'); ?>
                    
            </label>
        </div>
        
        
         <div class="col-3">
            <label id="resp_form"> 
                    
                   <?php echo $form->labelEx($model,'category'); ?>

                  <?php echo $form->dropDownList($model,'category',$this->loadCategoryExpenses());  ?>
		                
		                <?php echo $form->error($model,'category'); ?>
                    
            </label>
        </div>
        

         
        <div class="col-3">
            <label id="resp_form"> 
            
            
<?php echo $form->labelEx($model,'comment'); ?>
                        <?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255,'placeholder'=>Yii::t('app','Comment'))); ?>
		                <?php echo $form->error($model,'comment'); ?>
                   
        </label>
        </div>
       
        
        
                   <div class="col-submit">
                                
                                <?php 
                         
                            	    if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                        
                                ?>
                </div>         
                      
                </form>
              </div>



