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
 *//* @var $this ScholarshipholderController */
/* @var $model ScholarshipHolder */
/* @var $form CActiveForm */




   
	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

$message_validation = Yii::t('app','Percentage to pay can\'t be gerater than 100 !');

?>



<div class="form">
	
<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p><br/>';
    
	  
             echo $form->errorSummary($model); 
             
          
?>

<div  id="resp_form_siges">

        <form  id="resp_form">

       <div class="col-1">
            <label id="resp_form">
                    
              <?php 
                                    
                                      echo $form->label($model,'is_internal'); 
		                              if($this->is_internal==1)
				                          { echo $form->checkBox($model,'is_internal',array('onchange'=> 'submit()','checked'=>'checked'));
				                             
				                           }
						                 else
							               echo $form->checkBox($model,'is_internal',array('onchange'=> 'submit()'));
							               
                                     
							      
                          ?>
               </label>
        </div>
            

 <br/>
                <div class="col-4">
                   <label id="resp_form">    
                             <?php echo $form->labelEx($model,'student'); ?>
                         <?php 
                         
                                $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name ASC','join'=>'inner join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1,2) AND rh.academic_year ='.$acad_sess));
								
							if(isset($_GET['id']))
							 {	 
								echo $form->dropDownList($model, 'student',
								CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
								array( 'disabled'=>'disabled','onchange'=> 'submit()')
								);
							  }
							else
							  {
							  	if($this->student_id!='')
							  	 {
								  	echo $form->dropDownList($model, 'student',
									CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
									array('options' => array($this->student_id=>array('selected'=>true)),'onchange'=> 'submit()' )
									);
							  	  }
							  	else
							  	  {
							  	  	echo $form->dropDownList($model, 'student',
									CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
									array( 'prompt'=>Yii::t('app','-- Please select student --'),'onchange'=> 'submit()')
									);
							  	  }
								
							  	}
							  	
							 ?>
                          <?php echo $form->error($model,'student'); ?>
            
                   </label>
               </div>  


           <div class="col-4">
                   <label id="resp_form">    
                             <?php echo $form->labelEx($model,'sponsor'); ?>
                         <?php
                               if($this->is_internal==0)
                                 { 
                                 	 
								
									if(isset($_GET['id']))
									 {	 
										if($model->partner !='')
										 {	echo $form->dropDownList($model, 'partner',
											CHtml::listData(Partners::model()->findAll(),'id','name'),
											array( 'disabled'=>'')
											  );
											  
										  }
										else
										  {
										  	    echo $form->dropDownList($model, 'partner',
												CHtml::listData(Partners::model()->findAll(),'id','name'),
												array( 'prompt'=>Yii::t('app','-- Please select --'))
												);
										  	}
									  }
									else
									  {
									  	  echo $form->dropDownList($model, 'partner',
											CHtml::listData(Partners::model()->findAll(),'id','name'),
											array( 'prompt'=>Yii::t('app','-- Please select --'))
											);
											
									  }
										
									  	 
                                 
                                   }
                               elseif($this->is_internal==1)
                                 {   
                                 	echo $form->textField($model,'partner_name',array('size'=>60, 'disabled'=>'disabled'));
                                 	}
                               ?>
                          <?php echo $form->error($model,'partner'); ?>
            
                   </label>
               </div> 

           
            <div class="col-4">
            <label id="resp_form">    
                          
                        <?php echo $form->labelEx($model,'fee'); ?>
                          
                                <?php 
								    $level_ =0;
									
								  if(isset($_GET['id']))
							        {    $level = Levels::model()-> getLevel($model->student,$acad_sess); //$acad_sess,pou session
											  if($level!=NULL)
											   { $level=$level->getData();
												   foreach($level as $l)
												   $level_ = $l->id;
											   }
										   
									}
								   else
									   {  if($this->student_id!='')
										   {
											   $level = Levels::model()-> getLevel($this->student_id,$acad_sess); //$acad_sess,pou session
												  if($level!=NULL)
												   { $level=$level->getData();
													   foreach($level as $l)
													   $level_ = $l->id;
												   }
										     }
											 
									   }
									 
								 $criteria = new CDbCriteria(array('distinct'=>true,'alias'=>'f','join'=>'inner join fees_label fl on(f.fee=fl.id)','condition'=>'fl.fee_label NOT LIKE("Pending balance") AND f.academic_period='.$acad.' AND f.level='.$level_,'order'=>'fl.id'));
		
						     if(isset($_GET['id']))	//update
						       {
						       	    echo $form->dropDownList($model, 'fee',
								CHtml::listData(Fees::model()->findAll($criteria),'id','fee0.fee_label'), 
                                                                       
								array('options' => array($model->fee=>array('selected'=>true)),'prompt'=>Yii::t('app','-- Please select fee --'))
								);

						        }
						     else  //create
						       {	
								echo $form->dropDownList($model, 'fee',
								loadFeeNameByLevelForScholarship($level_,$acad_sess),//CHtml::listData(FeesLabel::model()->findAll($criteria),'id','fee_label'), 
                                                                       
								array('prompt'=>Yii::t('app','-- Please select fee --'))
								);
								
						       }
								
								
								
								 ?>
								 
                              
            </label>
        </div>


           <div class="col-4">
                   <label id="resp_form">    
                             <?php echo $form->labelEx($model,'percentage_pay'); ?>
                         <?php  echo '<input type="hidden" name="percent" id="percent" value="'.$model->percentage_pay.'" />';
                         echo $form->textField($model,'percentage_pay',array('size'=>60,'placeholder'=>Yii::t('app','Percentage'),'name'=>'percentage_pay','id'=>'percentage_pay', 'onchange'=>'validatePercent("percentage_pay","'.$message_validation.'")' )); ?>
                          <?php echo $form->error($model,'percentage_pay'); ?>
            
                   </label>
               </div> 
               	
	<div class="col-submit">                                        
                                <?php 
                         
                            	    if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('id'=>'btnSave', 'name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                        
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                  echo CHtml::submitButton(Yii::t('app', 'Save'),array('id'=>'btnSave', 'name'=>'update','class'=>'btn btn-warning'));
                                            
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
 
<!--  Valider le pourcentage de la bourse d'etude -->

<script type="text/javascript">
    function validatePercent(elementId,message){
        var valeur = parseFloat(document.getElementById(elementId).value);
        if(valeur > 100){
            alert(message);
            document.getElementById("btnSave").disabled = "disabled";
        }
        
        if(valeur <= 100){
             document.getElementById("percent").value = valeur;
             document.getElementById("btnSave").disabled = "";
        }
    }

</script>
    
     


		