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
/* @var $this OtherIncomesController */
/* @var $model OtherIncomes */
/* @var $form CActiveForm */



    $acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


 $disabled='';
	  
	 if((isset($_GET['p'])&&($_GET['p']!='')&&($_GET['p_id']!=0))&&(isset($_GET['p_id'])&&($_GET['p_id']!='')&&($_GET['p_id']!=0)))
	   {
	   	    $disabled='disabled';
	   	    $student= $this->getStudent($_GET['p_id']);
	   	    $description = Yii::t('app','Admission fee for ').$student;
	   	    
	   	    $this->id_income_desc = 1;  //admission
	   	    
	    } 

?>




<?php

if(!isset($_GET['id']))
 {
?>


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        

                           
     
      						<div class="span2" >
                                
                                
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Recettes Items'));
                                        
                                        if(isset($this->recettesItems)&&($this->recettesItems!=''))
							       echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true)), 'disabled'=>$disabled)); 
							    else
								  { 
									echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
                     
        </div>
    </div>

<br/>
<ul class="nav nav-tabs nav-justified"></ul>
<?php
    }
?>






<div class="grid-view" style=" margin-top:-20px;">

<?php
	
	 echo '<br/>';

	  echo $form->errorSummary($model); 
	  
	                      	 
	?>


<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-4">
            <label id="resp_form">
                    
           <?php echo $form->labelEx($model,'id_income_description'); ?>
                 <?php 
                 
                        if($this->id_income_desc!='')
						  {  
							  $model->setAttribute('id_income_description',1);//Admission
							  
							  echo $form->dropDownList($model, 'id_income_description',CHtml::listData(OtherIncomesDescription::model()->findAll(),'id','income_description'),array( 'options' => array($this->id_income_desc=>array('selected'=>true)), 'disabled'=>$disabled));
										   
							}
						 else
							{   
								 echo $form->dropDownList($model, 'id_income_description',CHtml::listData(OtherIncomesDescription::model()->findAll(),'id','income_description'),array(  'prompt'=>Yii::t('app','-- Search --'), 'disabled'=>''));
										  	
										  	
							 }
							 
						 ?>
						 <?php echo $form->error($model,'id_income_description'); ?>
                    </label>
        </div>


 <div class="col-4">
            <label id="resp_form">

<?php echo $form->labelEx($model,'description'); ?>
<?php 

       if($disabled!='')
           {
              $model->setAttribute('description',$description);
              
              echo $form->textArea($model,'description',array('size'=>60,'placeholder'=>Yii::t('app','Description'),'disabled'=>$disabled ));
              
           }
        else
           echo $form->textArea($model,'description',array('size'=>60,'placeholder'=>Yii::t('app','Description')));
          
            
        ?>
		                <?php echo $form->error($model,'description'); ?>
                    </label>
        </div>



 <div class="col-4">
            <label id="resp_form">

<?php echo $form->labelEx($model,'amount'); ?>
<?php 

      if($disabled!='')
           {
              $model->setAttribute('amount',$_GET['p']);
              
                echo $form->textField($model,'amount',array('size'=>60,'placeholder'=>Yii::t('app','Amount'), 'disabled'=>$disabled )); 
                
           } 
         else
             echo $form->textField($model,'amount',array('size'=>60,'placeholder'=>Yii::t('app','Amount'))); 
           
        ?>
		                <?php echo $form->error($model,'amount'); ?>
                    </label>
        </div>



        <div class="col-4">
            <label id="resp_form">

<?php echo $form->labelEx($model,'income_date'); ?>
                        <?php  
                                
                                if(isset($_GET['id'])&&($_GET['id']!=''))
                                   $date__ = $model->income_date;
                                else
                                   $date__ = date('Y-m-d');
                               
                            $this->widget('zii.widgets.jui.CJuiDatePicker',
                             array(
                             'model'=>'$model',
                             'name'=>'OtherIncomes[income_date]',
                             'language'=>'fr',
                             'value'=>$date__,
                             'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Income Date')),
                                     'options'=>array(
                                     'showButtonPanel'=>true,
                                     'changeYear'=>true,                                      
                                     'dateFormat'=>'yy-mm-dd',
                                     'yearRange'=>'1900:2100',
                                     'changeMonth'=>true,
                                     'showButtonPane'=>true,
                                      //'showOn'=>'both',      
                                             'dateFormat'=>'yy-mm-dd',   
                                     ),
                             )
                     );
                     
                     ?>
                     <?php echo $form->error($model,'income_date'); ?>
                    </label>
        </div>
   
       

                   <div class="col-submit">
                                
                                <?php 
                         
                            	    if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                        
                                         if($disabled=='')
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
				                           
				                           if($disabled=='')
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                        
                                ?>
                </div>         
                      
                </form>
              </div>
              
              
              
      </div>        
              
              
              
              
              
              
