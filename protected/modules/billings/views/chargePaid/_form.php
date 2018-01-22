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
/* @var $this ChargePaidController */
/* @var $model ChargePaid */
/* @var $form CActiveForm */
  
  $acad_sess=acad_sess();  
$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 




?>

<div class="b_m">


<?php

if(!isset($_GET['id']))
 {
?>


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        

                           
     
      						<div class="span2" >
                                
                               
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                       echo $form->labelEx($model,Yii::t('app','Depenses Items'));
                                        
                                        if(isset($this->depensesItems2)&&($this->depensesItems2!=''))
							       echo $form->dropDownList($model,'depensesItems',$this->loadDepensesItems(), array('onchange'=> 'submit()','options' => array($this->depensesItems2=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'depensesItems',$this->loadDepensesItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
                     
        </div>
    </div>

<br/>

<?php
    }
?>






<div class="grid-view">

<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p> <br/>';

	  echo $form->errorSummary($model); ?>


<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-4">
            <label id="resp_form">
                    
           <?php echo $form->labelEx($model,'id_charge_description'); ?>
                 <?php 
                 
                        if($this->id_charge_desc!='')
						  {  
							  
							  echo $form->dropDownList($model, 'id_charge_description',CHtml::listData(ChargeDescription::model()->findAll(),'id','description'),array( 'options' => array($this->id_charge_desc=>array('selected'=>true)), 'disabled'=>'disabled'));
										   
							}
						 else
							{   
								 echo $form->dropDownList($model, 'id_charge_description',CHtml::listData(ChargeDescription::model()->findAll(),'id','description'),array(  'prompt'=>Yii::t('app','-- Search --'), 'disabled'=>''));
										  	
										  	
							 }
							 
						 ?>
						 <?php echo $form->error($model,'id_charge_description'); ?>
                    
               </label>
        </div>



       <div class="col-4">
            <label id="resp_form">

		         <?php echo $form->labelEx($model,'amount'); ?>
				<?php echo $form->textField($model,'amount',array('size'=>60,'placeholder'=>Yii::t('app','Amount')) ); ?>
				<?php echo $form->error($model,'amount'); ?>
             
               </label>
        </div>



       <div class="col-4">
            <label id="resp_form">

			<?php echo $form->labelEx($model,'payment_date'); ?>
			
			<?php      if((isset($_GET['id'])&&($_GET['id']!=''))||($model->payment_date!=''))
	                                   $date__ = $model->payment_date;
	                                else
	                                   $date__ = date('Y-m-d');
							 
  		
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'ChargePaid[payment_date]',
									 'language'=>'fr',
									 'value'=>$date__,
									 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Expense date')),
										 'options'=>array(
										 'showButtonPanel'=>true,
										 'changeYear'=>true,                                      
										 'changeYear'=>true,
	                                     'dateFormat'=>'yy-mm-dd',   
										 ),
									 )
								 );
										
								
								?>
								<?php echo $form->error($model,'payment_date'); 
								     if($this->message_paymentDate)
								       { echo '<br/><span class="required">'.Yii::t('app','You must have a date for this expense.').'</span>';
								           $this->message_paymentDate=false;
								       }
								 ?>

               </label>
        </div>



       <div class="col-4">
            <label id="resp_form">

				<?php echo $form->labelEx($model,'comment'); ?>
                              <?php echo $form->textArea($model,'comment',array('rows'=>3, 'cols'=>70,'placeholder'=>Yii::t('app','Comment'))); ?>
                              <?php echo $form->error($model,'comment');  ?>

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
              
              
              
      </div>        
              
           



      


     
		
			