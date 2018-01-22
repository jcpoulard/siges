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
 *//* @var $this PartnersController */
/* @var $model Partners */
/* @var $form CActiveForm */


$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];
$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 



?>



<div class="form">
	
<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p><br/>';
    
	  
             echo $form->errorSummary($model); 
             
          
?>

<div  id="resp_form_siges">

        <form  id="resp_form">

       <div class="col-3">
            <label id="resp_form">
              <?php echo $form->labelEx($model,'name'); ?>
		      <?php echo $form->textField($model,'name',array('size'=>60 )); ?>
		      <?php echo $form->error($model,'name'); ?>


            </label>
        </div>
            

 
         <div class="col-3">
             <label id="resp_form">  
                    <?php echo $form->labelEx($model,'address'); ?>
					<?php echo $form->textField($model,'address',array('size'=>60 )); ?>
					<?php echo $form->error($model,'address'); ?>

            </label>
        </div>
            

 
           <div class="col-3">
              <label id="resp_form"> 
                   <?php echo $form->labelEx($model,'email'); ?>
					<?php echo $form->textField($model,'email',array('size'=>60 )); ?>
					<?php echo $form->error($model,'email'); ?>

            </label>
        </div>
            

 
          <div class="col-3">
              <label id="resp_form"> 
                    <?php echo $form->labelEx($model,'phone'); ?>
					<?php echo $form->textField($model,'phone',array('size'=>60)); ?>
					<?php echo $form->error($model,'phone'); ?>
              
              
           </label>
        </div>
            

 
                <div class="col-3">
                   <label id="resp_form"> 
                         <?php echo $form->labelEx($model,'activity_field'); ?>
						<?php echo $form->textField($model,'activity_field',array('size'=>60)); ?>
						<?php echo $form->error($model,'activity_field'); ?>
                         

            </label>
        </div>

       <div class="col-3">
                   <label id="resp_form"> 
                         <?php echo $form->labelEx($model,'contact'); ?>
						<?php echo $form->textField($model,'contact',array('size'=>60)); ?>
						<?php echo $form->error($model,'contact'); ?>
                         

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
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                        
                                ?>
         </div>
        </form>
</div>
                        
<!-- END OF TEST -->

</div>
     
     
     
  
 
              
              