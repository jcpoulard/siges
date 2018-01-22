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
/* @var $this ReservationController */
/* @var $model Reservation */
/* @var $form CActiveForm */

    
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

$percentage_pay =0;


if(!isset($_GET['id']))
 {
?>


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span5" >                        

                           
     
                                    <?php 
                                        
                                                                           
                                    
                                    
                                    
                                     
                    
                   
                    echo $form->radioButtonList($model,'postulant_or_student',
												    array(0=>Yii::t('app','New Student(s)'),
												          1=>Yii::t('app','Student(s)') 
												          ),
												    array(
												        'onclick'=>"this.form.submit()",
												        'template'=>'{input}{label}',
												        'separator'=>'',
												        'labelOptions'=>array(
												            'style'=> '
												                
												                width: 23%;
												                float: left;
												                margin-left:-8%;
												                margin-top:1%;
												            '),
												          'style'=>'float:left; margin-top:2%;',
												          )                              
												      );  
												                   
                   
                                         ?>
                               
                     
        </div>
    </div>



<?php
    }
   
?>






<div class="grid-view">

	<?php
	 echo '<br/>'.$form->errorSummary($model); 
	 	 
	 ?>

	
	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form"> 
                         
								<?php 
							 if($model->postulant_or_student==0)//postulant
							  {	 
							  	 echo '<label >'. Yii::t('app','New Student(s)').' </label> ';
							  	
								$criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC', 'condition'=>'status=1 AND academic_year ='.$acad_sess.' AND id not in(select postulant_student from reservation where is_student=0 and academic_year='.$acad_sess.')' ));
								
								$data_ = $this->loadPostulantByCriteria($criteria);
								
							  }
							elseif($model->postulant_or_student==1) //student
							 {
							    echo '<label >'. Yii::t('app','Student(s)').' </label> ';
							  	
								 $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC','join'=>'left join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1,2) AND rh.academic_year ='.$acad_sess));
								 
								 $data_ = $this->loadStudentByCriteria($criteria);	
								 
							   }
								
							if(isset($_GET['id']))
							 {	 
									if(isset($_GET['pers']))
									 {  $this->student_postulant = $_GET['pers'];
									    
									     if($model->is_student==1)
									       {  $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC','join'=>'left join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1,2) AND rh.academic_year ='.$acad_sess));
									        
									        $data_ = $this->loadStudentByCriteria($criteria);
									       }
									     elseif($model->is_student==0)
									       {
									       	  $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC', 'condition'=>'status=1 AND academic_year ='.$acad_sess.' AND id in(select postulant_student from reservation where is_student=0 and academic_year='.$acad_sess.')' ));
									       
									        $data_ = $this->loadPostulantByCriteria($criteria);
									       	}
								 
									
									 	
									 	echo $form->dropDownList($model,'postulant_student',$data_ , array('onchange'=> 'submit()', 'options' => array($this->student_postulant=>array('selected'=>true)), 'disabled'=>'disabled' ));
										
									  }
									else
									  {
									  	echo $form->dropDownList($model,'postulant_student',$data_ , array('onchange'=> 'submit()', 'disabled'=>'disabled' ));

										
									   }
									   
							  }
							else
							  {
							  	if($this->student_postulant!='')
							  	 {
								  	
								  	 echo $form->dropDownList($model,'postulant_student',$data_ , array('onchange'=> 'submit()', 'options' => array($this->student_postulant=>array('selected'=>true)) ));
								  	 
								  	
							  	  }
							  	else
							  	  {
							  	  	
							  	  	  echo $form->dropDownList($model,'postulant_student',$data_ , array('onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Please select --') ));
							  	  	
							  	  	
							  	  }
								
							  	}
							  	
								 ?>
								<?php echo $form->error($model,'postulant_student'); ?>
                           </label>
        </div>

<?php 
   
   if(( $this->student_postulant!=''))
     {
?>                            
         
    <div class="col-3">
            <label id="resp_form">

<?php echo '<label >'. Yii::t('app','Amount Pay').' </label> ';  ?>
 
<?php  echo $form->textField($model,'amount', array('size'=>60,'placeholder'=>Yii::t('app','Amount Pay'))); ?>

								<?php echo $form->error($model,'amount'); ?>
                           </label>
        </div>
   

         

        
    <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'payment_method'); ?> 

<?php 
		
									$criteria = new CDbCriteria(array('order'=>'method_name'));
									
									echo $form->dropDownList($model, 'payment_method',
									CHtml::listData(PaymentMethod::model()->findAll($criteria),'id','method_name'),
									array('prompt'=>Yii::t('app','-- Please select a payment method --')));
									
									
									?>
									<?php echo $form->error($model,'payment_method'); 
									     if($this->message_paymentMethod)
									       { echo '<br/><span class="required">'.Yii::t('app','Please fill payment method Field.').'</span>';
									           $this->message_paymentMethod=false;
									       }
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
									 'name'=>'Reservation[payment_date]',
									 'language'=>'fr',
									 'value'=>$date__,
									 'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Date Pay')),
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
								     if($this->message_datepay)
								       { echo '<br/><span class="required">'.Yii::t('app','You must have a date for this payment.').'</span>';
								           $this->message_datepay=false;
								       }
								
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
                                           {  
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

