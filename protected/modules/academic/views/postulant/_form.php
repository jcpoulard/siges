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
/* @var $this PostulantController */
/* @var $model Postulant */
/* @var $form CActiveForm */



$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 $siges_structure = infoGeneralConfig('siges_structure_session');

$day_for_currentYear_postulant = infoGeneralConfig('day_for_currentYear_postulant'); 
 if($day_for_currentYear_postulant=='')
	$day_for_currentYear_postulant=30;

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


?>

<?php
	
	  echo $form->errorSummary($model); ?>
        
 <?php 
        $acad_or_sess=Yii::t('app','academic year');
        if($siges_structure==1)
           $acad_or_sess=Yii::t('app','session');
           
          echo '<div ><label>'.Yii::t('app','Decision take in the first {name} day(s) of the current {name1} start from the his "start date" can have impact on this {name1}.',array('{name}'=>$day_for_currentYear_postulant,'{name1}'=>$acad_or_sess)).'</label></div>'; ?> 
 
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form">

	<?php 
	echo $form->labelEx($model,'first_name'); ?>
                        <?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','First Name'))); ?>
                        <?php echo $form->error($model,'first_name'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form"> 

<?php echo $form->labelEx($model,'last_name'); ?>
                        <?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Last Name'))); ?>
                        <?php echo $form->error($model,'last_name'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">
<?php echo $form->labelEx($model,'Blood Group'); ?>
<!-- <?php echo Yii::t('app','Blood Group');?> -->

                        <?php echo $form->dropDownList($model,'blood_group',$model->getBlood_groupValue(),array('prompt'=>Yii::t('app','-- Select blood group --'))); ?>
                        <?php echo $form->error($model,'blood_group'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form"> 

<?php echo $form->labelEx($model,'gender'); ?>
<?php echo $form->dropDownList($model,'gender',$model->getGenders(),array('prompt'=>Yii::t('app','-- Select gender --'))); ?>
                        <?php echo $form->error($model,'gender'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'birthday'); ?>

                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
                             array(
                             'model'=>'$model',
                             'name'=>'Postulant[birthday]',
                             'language'=>'fr',
                             'value'=>$model->birthday,
                             'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Birthday')),
                                     'options'=>array(
                                     'showButtonPanel'=>true,
                                     'changeYear'=>true,                                      
                                     'dateFormat'=>'yy-mm-dd',
                                     'yearRange'=>'1900:2100',
                                     'changeMonth'=>true,
                                     'showButtonPane'=>true,
                                            
                                                                                                             'dateFormat'=>'yy-mm-dd',   
                                     ),
                             )
                     );
                     ?>
		<?php echo $form->error($model,'birthday'); ?>

    </label>
        </div>
        
 
        <div class="col-3">
            <label id="resp_form">

<label><?php echo Yii::t('app','Birth place'); ?> </label>

                        
                            <?php 
                            $criteria = new CDbCriteria(array('order'=>'city_name'));
		
                            echo $form->dropDownList($model, 'cities',
                            CHtml::listData(Cities::model()->findAll($criteria),'id','city_name'),
                            array('prompt'=>Yii::t('app','-- Please select city --'))
                            );
                            ?>
                            
                       <?php echo $form->error($model,'cities'); ?> 
                    </label>
        </div>


    <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'adresse'); ?>
                        <?php echo $form->textField($model,'adresse',array('size'=>60,'maxlength'=>255,  'placeholder'=>Yii::t('app','Adresse'))); ?>
                        <?php echo $form->error($model,'adresse'); ?>
                    </label>
        </div>

       <div class="col-3">
            <label id="resp_form"> 

<?php echo $form->labelEx($model,'phone'); ?>
                        <?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Phone'))); ?>
                        <?php echo $form->error($model,'phone'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form"> 

<?php echo $form->labelEx($model,'health_state'); ?>
                        <?php echo $form->textField($model,'health_state',array('size'=>60,'maxlength'=>255, 'placeholder'=>Yii::t('app','Health state'))); ?>
                        <?php echo $form->error($model,'health_state'); ?>
                    </label>
        </div>


<!-- chan pesonalize -->
                   <!-- Champs personalisable ICI  -->    
       
        <?php
                    $criteria = new CDbCriteria; 
                    $criteria->condition = "field_related_to='stud'";
        if(!isset($_GET['id'])){  // Si on est en mode creation des champs personalisables 
                    
                    $mCustomField = CustomField::model()->findAll($criteria); 
                    $i=0;
                    foreach($mCustomField as $mc){
                        switch ($mc->field_type){
                            case "txt" : {


                    ?> 

                    <div class="col-3">
                        <label id="resp_form">
                        <label><?php echo $mc->field_label; ?></label>
                        <input size="60" name="<?php echo $mc->field_name; ?>" placeholder="<?php echo $mc->field_label; ?>" >
                       </label> 
                    </div>


                    <?php 
                    }
                    break;
                            case "date" : {

                    ?>
                    <div class="col-3">
                        <label id="resp_form">
                        <label><?php echo $mc->field_label; ?></label>
                    <input size="60" class="custom_date" name="<?php echo $mc->field_name; ?>" placeholder="<?php echo $mc->field_label; ?>" type="text">
                    </label>
                    </div>

                    <?php 
                    }
                    break;
                            case "combo" :{

                    ?>
                        <div class="col-3">
                            <label id="resp_form">
                            <label><?php echo $mc->field_label; ?></label>
                            <?php
                                echo '<select name="'.$mc->field_name.'">';
                                $field_value = explode(",", $mc->field_option);
                                foreach($field_value as $fv){
                                   echo '<option value="'.$fv.'">'.$fv.'</option>';
                                }
                                echo '</select>';
                            ?>
                        </label>
                        </div>
                    <?php 

                    }
                        }
                    }
        }else{ // Mise à jour des champs personalisables 
                 $modelCustomFieldData = new CustomFieldData;
                    $mCustomField = CustomField::model()->findAll($criteria); 
                    $i=0;
                    $id_postulant = $_GET['id'];
                    foreach($mCustomField as $mc){
                        switch ($mc->field_type){
                            case "txt" : {


                    ?> 

                    <div class="col-3">
                        <label id="resp_form">
                        <label><?php echo $mc->field_label; ?></label>
                        <input value="<?php echo $modelCustomFieldData->getCustomFieldValue($id_postulant, $mc->id); ?>" size="60" name="<?php echo $mc->field_name; ?>" placeholder="<?php echo $mc->field_label; ?>" >
                       </label> 
                    </div>


                    <?php 
                    }
                    break;
                            case "date" : {

                    ?>
                    <div class="col-3">
                        <label id="resp_form">
                        <label><?php echo $mc->field_label; ?></label>
                    <input  value="<?php echo $modelCustomFieldData->getCustomFieldValue($id_postulant, $mc->id); ?>" size="60" class="custom_date" name="<?php echo $mc->field_name; ?>" placeholder="<?php echo $mc->field_label; ?>" type="text">
                    </label>
                    </div>

                    <?php 
                    }
                    break;
                            case "combo" :{

                    ?>
                        <div class="col-3">
                            <label id="resp_form">
                            <label><?php echo $mc->field_label; ?></label>
                            <?php
                                echo '<select name="'.$mc->field_name.'">';
                                $field_value = explode(",", $mc->field_option);
                                echo '<option value="'.$modelCustomFieldData->getCustomFieldValue($id_postulant, $mc->id).'" selected="selected">'.$modelCustomFieldData->getCustomFieldValue($id_postulant, $mc->id).'</option>';
                                foreach($field_value as $fv){
                                    
                                   echo '<option value="'.$fv.'">'.$fv.'</option>';
                                }
                                echo '</select>';
                            ?>
                        </label>
                        </div>
                    <?php 

                    }
                        }
                    }
        }
        
// Fin creation data champs personalisable    

                    ?>
             
                    <!-- FIN des champs personablisables ICI -->





<!-- fen chan pesonalize -->

  
	<div class="col-3">
            <label id="resp_form">

	<?php echo $form->labelEx($model,'person_liable'); ?>
                        <?php 
                              if($this->person_liable!='')
                                $model->setAttribute('person_liable',$this->person_liable);
                              
                             echo $form->textField($model,'person_liable',array('size'=>60,'maxlength'=>100, 'placeholder'=>Yii::t('app','Person liable')));  
                            echo $form->error($model,'person_liable'); 
                        ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">
                    
                    <?php echo $form->labelEx($model,'person_liable_phone'); ?>
                        <?php 
                              if($this->person_liable_phone!='')
                                $model->setAttribute('person_liable_phone',$this->person_liable_phone);	
                                
                               echo $form->textField($model,'person_liable_phone',array('size'=>60,'maxlength'=>65, 'placeholder'=>Yii::t('app','Person liable phone'))); ?>
                        <?php echo $form->error($model,'person_liable_phone'); ?>
                    </label>
        </div>

	
	<div class="col-3">
            <label id="resp_form">

		<?php echo $form->labelEx($model,'person_liable_adresse'); ?>
		<?php echo $form->textField($model,'person_liable_adresse',array('size'=>60,'maxlength'=>255, 'disabled'=>'')); ?>
                              <?php echo $form->error($model,'person_liable_adresse'); ?>
                           </label>
        </div>


<div class="col-3">
            <label id="resp_form">
    

<?php 
                
              
                                echo $form->labelEx($model,'person_liable_relation');
                               ?>
						   
             
						    <?php       
						                $criteria = new CDbCriteria(array('order'=>'relation_name',));
								
								echo $form->dropDownList($model, 'person_liable_relation',
								CHtml::listData(Relations::model()->findAll($criteria),'id','relation_name'),
								array('prompt'=>Yii::t('app','-- Please select relation type --'), 'disabled'=>'')
								);
						                
						               
								 echo $form->error($model,'person_liable_relation'); 
								 
                              
								 
								 ?>
                         
                          
                          
                            </label>
        </div>

	
	<div class="col-3">
            <label id="resp_form">

<label> <?php echo '<span class="required">'.Yii::t('app','Entry Level').'*</span>'; //echo $form->labelEx($model,'apply_for_level'); ?> </label>
                    
                        <?php 
					 
					 
						if(isset($_GET['id']))
						  {  							     
					          if($this->idLevel!='')
						         echo $form->dropDownList($model,'apply_for_level',loadAllLevel(), array('options' => array($this->idLevel=>array('selected'=>true)), 'onchange'=> 'submit()',)); 
							  else
								  echo $form->dropDownList($model,'apply_for_level',loadAllLevel(), array('onchange'=> 'submit()' )); 
					       }else{
                                               // A travailler ici pour mettre l'AJAX 
                                               echo $form->dropDownList($model,'apply_for_level',loadAllLevel(),
                                                array(
                                                    'id'=>'apply_for_level',
                                                    'name'=>'apply_for_level',
                                                   // 'prompt'=>Yii::t('app','-- Select --'),    
                                                    'ajax' => array(
                                                    'type'=>'POST', //request type
                                                    'url'=>CController::createUrl('loadPreviousLevel'), //url to call.
                                                    'update'=>'#previous_level', //selector to update

                                                    )));

                                               }
                                               // Fin AJAX 
                                               /*
						else //for create
							 if($this->idLevel!='')
							    echo $form->dropDownList($model,'apply_for_level',$this->loadAllLevel(), array('onchange'=> 'submit()','options' => array($this->idLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($model,'apply_for_level',$this->loadAllLevel(), array('onchange'=> 'submit()' )); 
						
						echo $form->error($model,'level'); 
						
                                                */
					  ?>
                    </label>
        </div>
        


<div class="col-3">
            <label id="resp_form"> 

             <label> <?php echo '<span class="required">'.Yii::t('app','Previous Level').'*</span>';  ?> </label>
                                           
                    <?php 
                 //    echo $form->labelEx($modelRoom1,'[1]'.Yii::t('app','Room'));
						
					          	
						//for update
					if(isset($_GET['id'])&&($_GET['id']!=''))
						{
							if($this->idPreviousLevel!='')
							    echo $form->dropDownList($model,'previous_level',loadPreviousLevel($model->apply_for_level), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($model,'previous_level',loadPreviousLevel($model->apply_for_level)  ); 

							
						}
					 else
					   {  //for create
						 // A travailler ici pour j'AJAX 
                                             
                                       // echo $form->labelEx($modelSection,Yii::t('app','Section'));
                                        echo CHtml::dropDownList('previous_level','', array(),
                                        array(
                                            'prompt'=>Yii::t('app','-- Select --'),    
                                            'ajax' => array(
                                            'type'=>'POST', //request type
                                            //'url'=>CController::createUrl('grades/loadLevel'), //url to call.
                                           // 'update'=>'#level', //selector to update

                                        )));
     
                                             
                                             /*
							 if($this->idPreviousLevel!='')
							    echo $form->dropDownList($model,'previous_level',$this->loadPreviousLevel($model->apply_for_level), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($model,'previous_level',$this->loadPreviousLevel($model->apply_for_level)); 
						*/		 
					   }

		
		 echo $form->error($model,'previous_level'); 
		 
					
                    ?>
                    </label>
        </div>
        


	<div class="col-3">
            <label id="resp_form"> 
                        <?php echo $form->labelEx($model,'previous_school'); ?>
                    
                        <?php 
                        
                              if($this->previousSchool!='')
                                $model->setAttribute('previous_school',$this->previousSchool);
                                
                            echo $form->textField($model,'previous_school',array('size'=>60,'maxlength'=>255, 'placeholder'=>Yii::t('app','Previous School'))); ?>
                        <?php echo $form->error($model,'previous_school'); ?>
                    </label>
        </div>
        
 
	<div class="col-3">
            <label id="resp_form">
	<?php echo $form->labelEx($model,'last_average'); ?>
                        <?php 
                              if($this->last_average!='')
                                $model->setAttribute('last_average',$this->last_average);
                                
                                echo $form->textField($model,'last_average',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Last Average')));  
                                
                               echo $form->error($model,'last_average'); 
                        
                        ?>
                    </label>
        </div>

	

         
	   <div class="col-3">
            <label id="resp_form">
                        <?php 
                           
                            echo $form->labelEx($model,'school_date_entry'); 
                        ?>
                    
                        <?php 
                            
                              //if($this->school_date_entry!='')
                               // $model->setAttribute('school_date_entry',$this->school_date_entry);
                                 if(isset($_GET['id'])&&($_GET['id']!=''))
	                                   $date__ = $model->school_date_entry;
	                                else
	                                   $date__ = date('Y-m-d');
	                                      
	                                  

                        
                               $this->widget('zii.widgets.jui.CJuiDatePicker',
												 array(
                                 'model'=>'$model',
                                 'name'=>'Postulant[school_date_entry]',
                                 'language'=>'fr',
                                 'value'=>$date__,  //$model->school_date_entry,
                                 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important'),
                                         'options'=>array(
                                         'showButtonPanel'=>true,
                                         'changeYear'=>true,                                      
                                         'dateFormat'=>'yy-mm-dd',
                                         'yearRange'=>'1900:2100',
                                         'changeMonth'=>true,
                                          'showButtonPane'=>true,
                                              
                                                                                                                 'dateFormat'=>'yy-mm-dd',   
                                         ),
                                 )
                         );
		?>
                <?php echo $form->error($model,'school_date_entry'); ?>        
                        
                           </label>
        </div>

  
<div class="col-submit"> 
                                
                                <?php
                                
                                if(!isAchiveMode($acad_sess))
                                 { 
                                 	 if(!isset($_GET['id'])){
                                         echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                             
                                             }
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                              
                                ?>
                </div>
        </form>
</div>

<script>
        
  $(function() {
    $( ".custom_date" ).datepicker({
      
      changeMonth: true,
      changeYear: true,
      
      
    });
  });
  
  </script>
 

