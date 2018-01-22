<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


 ?>
<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>

	
	
	<div  id="resp_form_siges">

<form  id="resp_form">



	  <div class="col-2">
			    <label id="resp_form">

<div for="Courses"><?php echo Yii::t('app','Course'); ?></div>
                              <?php    
                                       //course_id = 0 <=> 'Break' 
                              
                                    if(isset($_GET['emp'])&&($_GET['emp']!="")) 
								       { 
								       	 $criteria = new CDbCriteria(array('order'=>'subject ASC','join'=>'inner join academicperiods a on( a.id = academic_period)','condition'=>'teacher='.$_GET['emp'].' AND (academic_period='.$acad.' OR a.year='.$acad.')'));
								       	 
								       }
								     else
								       {
								       	 $criteria = new CDbCriteria(array('order'=>'subject ASC','join'=>'inner join academicperiods a on( a.id = academic_period)','condition'=>'academic_period='.$acad.' OR a.year='.$acad));
								       	 
								       }
		             
	//echo $form->dropDownList($model,'course', $this->loadCourse($criteria), array('prompt'=>Yii::t('app','-- Please select course --') )   ); 
	                         echo $form->dropDownList($model, 'course',
                                CHtml::listData(Courses::model()->findAll($criteria),'id','courseName'),
                                array('prompt'=>Yii::t('app','-- Please select course --'))
                                );
                         
                                
        //course_id = 0 <=> 'Break'                        
                                
                                 ?>
                              <?php echo $form->error($model,'course'); ?>
                          </label>
</div>
                          
<div class="col-2">
	<label id="resp_form">

<?php echo $form->labelEx($model,'day_course'); ?>

<?php echo $form->dropDownList($model, 'day_course', $model->getDays()); ?>
	          					  <?php echo $form->error($model,'day_course'); ?>
	                     </label>
</div>
	
	
	
<div class="col-2">
	<label id="resp_form">

<?php echo $form->labelEx($model,'time_start'); ?>
                                     	
								<?php $this->widget('ext.timepicker.JTimePicker', array(
								    'model'=>$model,
								     'attribute'=>'time_start',
								     // additional javascript options for the date picker plugin
								     'options'=>array(
								        'showPeriod'=>false,
								         ),
								     'htmlOptions'=>array('size'=>60,'maxlength'=>8, 'placeholder'=>Yii::t('app','Time Start'))
			    
								   ));?>
								<?php echo $form->error($model,'time_start'); ?>
                          </label>
</div>
	
	
	
<div class="col-2">
	<label id="resp_form">
<?php echo $form->labelEx($model,'time_end'); ?>
                              <?php $this->widget('ext.timepicker.JTimePicker', array(
							    'model'=>$model,
							     'attribute'=>'time_end',
							     // additional javascript options for the date picker plugin
							     'options'=>array(
							        'showPeriod'=>false,
							         ),
							     'htmlOptions'=>array('size'=>60,'maxlength'=>8, 'placeholder'=>Yii::t('app','Time End'))
		    
							   ));?>
	<?php echo $form->error($model,'time_end'); ?>
                          </label>
</div>
	
	
	
<div class="col-submit">
                     
                                
                                <?php if(!isset($_GET['id'])){
                                         echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
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
	
			
			