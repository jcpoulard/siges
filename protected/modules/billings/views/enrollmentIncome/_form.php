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
/* @var $this BillingsController */
/* @var $model Billings */
/* @var $form CActiveForm */



   $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

?>


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        

                           
     
      						<div class="span2" >
                                
                               
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Recettes Items'));
                                        
                                        if(isset($this->recettesItems)&&($this->recettesItems!=''))
							       echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true)), 'disabled'=>'disabled')); 
							    else
								  { 
									echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
                     
        </div>
    </div>


<div class="grid-view">

	<?php

	 echo '<br/>'.$form->errorSummary($model); 
		 
	 
	 ?>

	
	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form"> 
                          <?php echo $form->labelEx($model,'postulant'); ?>
								<?php 
									
								$criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC', 'condition'=>'p.id NOT IN(select postulant from enrollment_income where academic_year ='.$acad_sess.')'));
								
							if(isset($_GET['id']))
							 {	 
									if(isset($_GET['stud']))
									 {  $this->postulant = $_GET['postu'];
									 	
									 	echo $form->dropDownList($model,'postulant',$this->loadPostulantByCriteria($criteria), array('onchange'=> 'submit()', 'options' => array($this->postulant=>array('selected'=>true)) ));
										
									  }
									else
									  {
									  	echo $form->dropDownList($model,'postulant',$this->loadPostulantByCriteria($criteria), array('onchange'=> 'submit()', 'disabled'=>'disabled' ));

										
									   }
									   
							  }
							else
							  {
							  	if($this->postulant!='')
							  	 {
								  	
								  	 echo $form->dropDownList($model,'postulant',$this->loadPostulantByCriteria($criteria), array('onchange'=> 'submit()', 'options' => array($this->postulant=>array('selected'=>true)) ));
								  	 
								  	
							  	  }
							  	else
							  	  {
							  	  	
							  	  	  echo $form->dropDownList($model,'postulant',$this->loadPostulantByCriteria($criteria), array('onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Please select postulant --') ));
							  	  	
							  	  	
							  	  }
								
							  	}
							 	
								 ?>
								<?php echo $form->error($model,'postulant'); ?>
                           </label>
        </div>
  
 <?php
      if($this->postulant!='')
       {
 
 ?>
  
       
 
        <div class="col-3">
            <label id="resp_form">
                               <?php echo $form->labelEx($model,'apply_level'); ?>
                          
                          
							<?php 
							    
							          $criteria = new CDbCriteria(array('alias'=>'l','join'=>'inner join postulant p on(p.apply_for_level=l.id)','condition'=>'p.id='.$this->postulant));
									
									echo $form->dropDownList($model, 'apply_level',
									CHtml::listData(Levels::model()->findAll($criteria),'id','level_name')
									);
									

							      
							       ?>
         				 </label>
        </div>
        
        
        <div class="col-3">
            <label id="resp_form">
                              <label for="fee_name" ><?php echo Yii::t('app','Amount Pay'); ?></label> 
                          
                          
							<?php 
							    	echo $form->textField($model,'amount',array('size'=>60,'placeholder'=>Yii::t('app','Amount Pay')));
							      
							       ?>
         				 </label>
        </div>

        
    <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'payment_method'); ?> 

<?php 								$criteria = new CDbCriteria(array('order'=>'method_name'));
									
									echo $form->dropDownList($model, 'payment_method',
									CHtml::listData(PaymentMethod::model()->findAll($criteria),'id','method_name'),
									array('prompt'=>Yii::t('app','-- Please select a payment method --')));
									
									
									?>
									<?php echo $form->error($model,'payment_method'); 
									     
									     //echo '<br/><span class="required">'.Yii::t('app','Please fill payment method Field.').'</span>';
									           
									       
									?>
						 </label>
        </div>

    
           
   
   
        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'payment_date'); ?>                              
							<?php 
							        
                                
	                                if(isset($_GET['id'])&&($_GET['id']!=''))
	                                   $date__ = $model->payment_date;
	                                else
	                                   $date__ = date('Y-m-d');
							
							
					 	   		 $this->widget('zii.widgets.jui.CJuiDatePicker',
							      array(
									 'model'=>'$model',
									 'name'=>'EnrollmentIncome[payment_date]',
									 'language'=>'fr',
									 'value'=>$date__,
									 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Payment date')),
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
								    //echo '<br/><span class="required">'.Yii::t('app','You must have a date for this payment.').'</span>';
								         								
								?>
                           </label>
        </div>

         <div class="col-3">
            <label id="resp_form">

					<?php echo $form->labelEx($model,'comments'); ?>                              
							<?php 
							        
                                echo  $form->textArea($model,'comments',array('rows'=>3, 'cols'=>160)); 
                                echo $form->error($model,'comments');
                          								
								?>
                           </label>
        </div>


                       
                            
                            <div class="col-submit">
 
                                
                                <?php if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {       if(!isAchiveMode($acad_sess))
                                                          echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                                    echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                                                                               
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                ?>
     
                            
                  </div><!-- /.table-responsive -->
             
     <?php
       }
 
 ?>
                  
                </form>
              </div>



</div>

