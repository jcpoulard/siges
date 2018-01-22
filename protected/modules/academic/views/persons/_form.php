
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
$automatic_code_ = infoGeneralConfig('automatic_code');
$disabled = '';
$placeholder_code = Yii::t('app','Id Number');

if($automatic_code_ ==1)
 { $disabled = 'disabled';
  $placeholder_code = Yii::t('app','Id Number').Yii::t('app',' automatic');
 }

	

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


 $modelEmployeeInfo = new EmployeeInfo;
 $modelCustomFieldData = new CustomFieldData;

?>
    
 

<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>  <br/>';

	  echo $form->errorSummary($model); ?>


<?php if(!isset($_GET['isstud'])||$_GET['isstud']==0) 
    {
    ?>
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
                             'name'=>'Persons[birthday]',
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

<?php echo $form->labelEx($model,'nif_cin'); ?>

                        <?php echo $form->textField($model,'nif_cin',array('size'=>60,'maxlength'=>100, 'placeholder'=>Yii::t('app','Id Number'))); ?>
                        <?php echo $form->error($model,'nif_cin'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'cities'); ?>

                        <?php 
                            $criteria = new CDbCriteria(array('order'=>'city_name'));
		
                            echo $form->dropDownList($model, 'cities',
                            CHtml::listData(Cities::model()->findAll($criteria),'id','city_name'),
                            array('prompt'=>Yii::t('app','-- Please select city --'))
                            );
                            ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form"> 

<?php echo $form->labelEx($model,'citizenship'); ?>
                        <?php echo $form->textField($model,'citizenship',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Citizenship')));  
                            echo $form->error($model,'citizenship'); 
                        ?>
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

<?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Email'))); ?>
                        <?php echo $form->error($model,'email'); ?>
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

<?php echo $form->labelEx($model,'image'); 
			           if(isset($model->image))
				              echo $model->image;?>
                    
                        <input size="60" name="image" type="file" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" />
                        <?php echo $form->error($model,'image'); ?>
                   </label>
        </div>
        
       
                <?php if(!isset($_GET['isstud']) || $_GET['isstud']==0){  // Change ceci en elevement la condition !isset($_GET['isstud'])?>
        
        <div class="col-3">
            <label id="resp_form">

 <label> <?php echo Yii::t('app','Employee\'s Status'); ?> </label>
                        <?php echo $form->dropDownList($model,'active',$model->getStatusValue(),array('options' => array(2=>array('selected'=>true))  )); ?>
                        <?php echo $form->error($model,'active'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

	<label><?php echo Yii::t('app','Titles'); ?> </label>
                        
                        <div class="row">
                        <button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">
                            <?php echo Yii::t('app','Select a title') ?>
                        </button>
                        <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog"> 
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="myModalLabel"><?php echo Yii::t('app','Select a title') ?></h4>
        </div>
        <div class="modal-body">
           
                <?php //for others titles
                            $title = CHtml::listData(Titles::model()->findAll(), 'id', 'title_name');
                            $selected_keys = array_keys(CHtml::listData( $model->titles, 'id' , 'id'));
                           
                            echo CHtml::checkBoxList('Persons[Title][]', $selected_keys, $title,array('template'=>'<div class="rmodal"> <div class="row"> <div class="l">{label}</div><div class="r">{input}</div></div></div>'));
							
                ?>
             
           
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">
              <?php echo Yii::t('app','Save'); ?>
          </button>
        </div>
      </div>
      
    </div> 
  </div>
                        </div>
             
                    </label>
        </div>
            
        
                <?php } else {?>
           
        <div class="col-3">
            <label id="resp_form">

<label> <?php echo Yii::t('app','Teacher\'s status'); ?> </label>

<?php echo $form->dropDownList($model,'active',$model->getStatusValue(),array('options' => array(2=>array('selected'=>true))  )); ?>
                        <?php echo $form->error($model,'active'); ?>
                    </label>
        </div>
            
                          </br> 


                <?php } ?>
           
            
        <div class="col-3">
            <label id="resp_form">

	<label><?php echo Yii::t('app','Working department'); ?> </label>
                        <?php  
								      
                            $modelDepartment = new DepartmentHasPerson;
                                  if($model->is_student==0)//for update
                          {  if($this->temoin_update==0)//pour l'affichage
                               {  $dep=$this->getDepartmentByEmployeeId($model->id,$acad); //depatman sou tout ane akademik lan
                               if($dep !=null)
                                  $this->department_id=$dep->id;
                               else 
                                   $this->department_id = null;
                              
                            }
							   
                                 if(isset($this->department_id))
                                              echo $form->dropDownList($modelDepartment,'department_id',$this->loaddepartment(), array('options' => array($this->department_id=>array('selected'=>true)))); 
                                          else  
                                                   echo $form->dropDownList($modelDepartment,'department_id',$this->loadDepartment());
                               }
                                else //for create
                                   {	 	
                                         if(isset($this->department_id))
                                              echo $form->dropDownList($modelDepartment,'department_id',$this->loaddepartment(), array('options' => array($this->department_id=>array('selected'=>true)))); 
                                          else  
                                                   echo $form->dropDownList($modelDepartment,'department_id',$this->loadDepartment());   

                                   }    
                     echo $form->error($modelDepartment,'department_id'); 

                               ?>
                    </label>
       			 </div>
            
        <div class="col-3">
            <label id="resp_form">


<?php echo $form->labelEx($modelEmployeeInfo,'job_status'); ?>                        
               <?php   if($model->is_student==0)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $job=$this->getJobStatus($model->id);
                                                       if($job !=null)
						          $this->job_status_id=$job;//->id;
                                                       else 
                                                           $this->job_status_id = null;
                                                      
					            }
							   
					         if(isset($this->job_status_id))
							      echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus(), array('options' => array($this->job_status_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus());
					       }
						else //for create
						   {	 	
							 if(isset($this->job_status_id))
							      echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus(), array('options' => array($this->job_status_id=>array('selected'=>true)))); 
							  else  
								   echo $form->dropDownList($modelEmployeeInfo,'job_status',$this->loadJobStatus());   
	                             
						   }    

                              echo $form->error($modelEmployeeInfo,'job_status'); 
                              
                              ?>
                   </label>
        </div>
            
        <div class="col-3">
            <label id="resp_form">
                        <?php 
								
				if($model->is_student==0)//for update
                                  {  if($this->temoin_update==0)//pour l'affichage
                                       {  $h_date=$this->getHireDate($model->id);
                                       if($h_date !=null)
                                          $modelEmployeeInfo =$h_date;//->id;


                                    }
                                  }    
                                    echo $form->labelEx($modelEmployeeInfo,'hire_date'); ?>
                    
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',
                                                         array(
                                                                         'model'=>'$modelEmployeeInfo',
                                                                         'name'=>'EmployeeInfo[hire_date]',
                                                                         'language'=>'fr',
                                                                         'value'=>$modelEmployeeInfo->hire_date,
                                                                        
'htmlOptions'=>array('size'=>60, 'style'=>'width:100% !important','placeholder'=>Yii::t('app','Hire Date')),
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
						<?php echo $form->error($modelEmployeeInfo,'hire_date'); ?>
                    </label>
        </div>
            
        
        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($modelEmployeeInfo,'permis_enseignant'); ?>
                        <?php echo $form->textField($modelEmployeeInfo,'permis_enseignant',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Permis Enseignant'))); ?>
                        <?php echo $form->error($modelEmployeeInfo,'permis_enseignant'); ?>
                    </label>
        </div>
        
        
        <div class="col-3">
            <label id="resp_form">
<?php echo $form->labelEx($model,'id_number'); ?>
                        <?php echo $form->textField($model,'id_number',array('size'=>60,'maxlength'=>45, 'disabled'=>$disabled, 'placeholder'=>$placeholder_code )); ?>
                        <?php echo $form->error($model,'id_number'); ?>
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








    <?php } 
  if(isset($_GET['isstud'])&& $_GET['isstud']==1)
    {
      $this->kals_dat_panull = false;
         $modelStudentOtherInfo = new StudentOtherInfo;
         
         if((isset($_GET['id']))&&($_GET['id']!=''))
           {
           	   $modelStudentOtherInfo = StudentOtherInfo::model()->find('student=:IdStudent',array(':IdStudent'=>$model->id ));
           
	           if($modelStudentOtherInfo ==null)
		           $modelStudentOtherInfo=new StudentOtherInfo;
		       elseif(($modelStudentOtherInfo->school_date_entry!='') && ($modelStudentOtherInfo->previous_level!=''))
		          {
		          	  $this->kals_dat_panull = true;
		          	}
		          	
		          	
	        }

    
    ?>
    
   <div  id="resp_form_siges">

        <form  id="resp_form">
        
        <div class="col-3">
            <label id="resp_form">


<?php echo $form->labelEx($model,'last_name'); ?>
                        <?php echo $form->textField($model,'last_name',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Last Name'))); ?>
                        <?php echo $form->error($model,'last_name'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'first_name'); ?>
                        <?php echo $form->textField($model,'first_name',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','First Name'))); ?>
                        <?php echo $form->error($model,'first_name'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

	<label><?php echo Yii::t('app','Blood Group');?> </label>
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
                             'name'=>'Persons[birthday]',
                             'language'=>'fr',
                             'value'=>$model->birthday,
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
		<?php echo $form->error($model,'birthday'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">
<?php echo $form->labelEx($model,'id_number'); ?>
                        <?php echo $form->textField($model,'id_number',array('size'=>60,'maxlength'=>45, 'disabled'=>$disabled, 'placeholder'=>$placeholder_code )); ?>
                        <?php echo $form->error($model,'id_number'); ?>
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
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">
<?php echo $form->labelEx($model,'image'); 
			           if(isset($model->image))
				              echo $model->image;?>
                    
                        <input size="60" name="image" type="file" style="font-family:Verdana, Arial, Helvetica, sans-serif; font-size:10pt" />
                        <?php echo $form->error($model,'image'); ?>
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

	<?php echo $form->labelEx($model,'email'); ?>
                        <?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Email'))); ?>
                        <?php echo $form->error($model,'email'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">
	<?php echo $form->labelEx($model,'adresse'); ?>
                        <?php echo $form->textField($model,'adresse',array('size'=>60,'maxlength'=>255, 'placeholder'=>Yii::t('app','Adresse'))); ?>
                        <?php echo $form->error($model,'adresse'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">
<?php echo $form->labelEx($model,'citizenship'); ?>
                        <?php echo $form->textField($model,'citizenship',array('size'=>60,'maxlength'=>45, 'placeholder'=>Yii::t('app','Citizenship'))); 
                            echo $form->error($model,'citizenship'); 
                        ?>
                    </label>
        </div>
        


        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'identifiant'); ?>
                        <?php echo $form->textField($model,'identifiant',array('size'=>60,'maxlength'=>100, 'placeholder'=>Yii::t('app','Identifiant'))); ?>
                        <?php echo $form->error($model,'identifiant'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<?php echo $form->labelEx($model,'matricule'); ?>
                        <?php echo $form->textField($model,'matricule',array('size'=>60,'maxlength'=>100, 'placeholder'=>Yii::t('app','Matricule')));  
                            echo $form->error($model,'matricule'); 
                        ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

	<?php echo $form->labelEx($model,'mother_first_name'); ?>
                        <?php echo $form->textField($model,'mother_first_name',array('size'=>60,'maxlength'=>55, 'placeholder'=>Yii::t('app','Mother\'s First Name'))); ?>
                        <?php echo $form->error($model,'mother_first_name'); ?>
                    </label>
        </div>
        

  
 <?php if(!isset($_GET['id']))
        {
        
    ?>	        
        <div class="col-3">
            <label id="resp_form">

<label><?php echo Yii::t('app','Student\'s Status'); ?></label>
                        <?php 
                             
                           echo $form->dropDownList($model,'active',$model->getStatusValue() );
                           
                           ?>
                        <?php echo $form->error($model,'active'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<label> <?php echo Yii::t('app','Shift'); ?> </label>
                   
                       <?php 
					
					 
						$modelShift = new Shifts;
						
						  $default_vacation=null;
			      $criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'default_vacation',);
				   		$default_vacation_name = GeneralConfig::model()->find($criteria)->item_value;
				   		
				   		$criteria2 = new CDbCriteria;
				   								$criteria2->condition='shift_name=:item_name';
				   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
				   		$default_vacation = Shifts::model()->find($criteria2);
				   		
				   		

						if($model->is_student==1)//for update
						  {    
						  if($this->temoin_update==0)//pour l'affichage
						       {  $shift=$this->getShiftByStudentId($model->id,$acad_sess);
                                                       if($shift!=null)
					              $this->idShift= $shift->id;
                                                       else
                                                           $this->idShift=null;
					            }
					         if(isset($this->idShift)&&($this->idShift!=""))
						       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)), 'onchange'=> 'submit()',)); 
						      else
								{  $this->idLevel=0;
								     if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								             $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' ));    
					            }
					       }
						else //for create
						   {  if($this->idShift!='')
						        echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('prompt'=>'Select shift','onchange'=> 'submit()','options' => array($this->idShift=>array('selected'=>true)) )); 
					          else
								{  if($default_vacation!=null)
								      { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								            $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('prompt'=>'Select shift','onchange'=> 'submit()' ));                   
								}
					        }
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<label> <?php echo Yii::t('app','Section'); ?> </label>
                    
                       <?php 
					
					 
						$modelSection = new Sections;
						if($model->is_student==1)//for update
						  {   if($this->temoin_update==0)//pour l'affichage
						       { $section=$this->getSectionByStudentId($model->id,$acad_sess);
                                                       if($section!=null)
						         $this->section_id=$section->id;
                                                       else 
                                                           $this->section_id=null;
					            }
							   
					        if($this->section_id!='')
						        echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							else
							   {  $this->idLevel=0;
								echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
					           }
					       }
						else //for create
						   { 
							    if($this->section_id!='')
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							    else
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
					       }
						echo $form->error($modelSection,'section_name'); 
						
					
											
					   ?> 
                    
</label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<label> <?php echo Yii::t('app','Entry Level'); ?> </label>
                    
                        <?php 
					 
					 
						$modelLevelPerson = new LevelHasPerson;
						if($model->is_student==1)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {   $level=$this->getLevelByStudentId($model->id,$acad_sess);
                                                       if($level != null)
						          $this->idLevel=$level->id;
                                                       else
                                                           $this->idLevel=null;
                                                       
					            }
							     
					          if($this->idLevel!='')
						         echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('options' => array($this->idLevel=>array('selected'=>true)), 'onchange'=> 'submit()',)); 
							  else
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()' )); 
					       }
						else //for create
							 if($this->idLevel!='')
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()','options' => array($this->idLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()' )); 
						
						echo $form->error($modelLevelPerson,'level'); 
						
					 
					  ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

                       <label> <?php  echo Yii::t('app','Room'); ?> </label> 
                    
                       <?php 
					
					 
						$modelRoom = new RoomHasPerson;
						if($model->is_student==1)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $room=$this->getRoomByStudentId($model->id,$acad_sess);
                                                       if($room !=null)
						          $this->room_id=$room->id;
                                                       else 
                                                           $this->room_id = null;
                                                      
					            }
							   
					         if($this->room_id!='')
						         echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('options' => array($this->room_id=>array('selected'=>true)))); 
							 else
								 echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel)); 
					       }
						else //for create
						   {  
							   if($this->room_id!='')
							      echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('options' => array($this->room_id=>array('selected'=>true)))); 
							   else
								   echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel)); 
					       }
						echo $form->error($modelRoom,'room'); 
						
					
										
					   ?> 
                           </label>
        </div>
                    <?php
                                           ?>
            
        
        <div class="col-3">
            <label id="resp_form">
                        <?php 
                           
                            echo $form->labelEx($modelStudentOtherInfo,'school_date_entry'); 
                        ?>
                    
                        <?php 
                            
                              if($this->school_date_entry!='')
                                $modelStudentOtherInfo->setAttribute('school_date_entry',$this->school_date_entry);
                        
                               $this->widget('zii.widgets.jui.CJuiDatePicker',
												 array(
                                 'model'=>'$modelStudentOtherInfo',
                                 'name'=>'StudentOtherInfo[school_date_entry]',
                                 'language'=>'fr',
                                 'value'=>$modelStudentOtherInfo->school_date_entry,
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
                <?php echo $form->error($modelStudentOtherInfo,'school_date_entry'); ?>        
                        
                           </label>
        </div>
          <?php ?>
                
                <?php     ?>
        
        <div class="col-3">
            <label id="resp_form"> 
                        <?php echo $form->labelEx($modelStudentOtherInfo,'previous_school'); ?>
                    
                        <?php 
                        
                              if($this->previousSchool!='')
                                $modelStudentOtherInfo->setAttribute('previous_school',$this->previousSchool);
                                
                            echo $form->textField($modelStudentOtherInfo,'previous_school',array('size'=>60,'maxlength'=>255, 'placeholder'=>Yii::t('app','Previous School'))); ?>
                        <?php echo $form->error($modelStudentOtherInfo,'previous_school'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form"> 

                        <?php echo $form->labelEx($modelStudentOtherInfo,'previous_level'); ?>
                    
                    <?php 
                     
						
						//for update
					if(isset($_GET['id'])&&($_GET['id']!=''))
						{
							if($this->idPreviousLevel!='')
							    echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id)  ); 

							
						}
					 else
					   {  //for create
						 
							 if($this->idPreviousLevel!='')
							    echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadPreviousLevel($this->idLevel), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadPreviousLevel($this->idLevel)); 
								 
					   }

		
		 echo $form->error($modelStudentOtherInfo,'previous_level'); 
		 
					
                    ?>
                    </label>
        </div>
<?php
        	
        }
      else
        { if((isset($_GET['id']))&&($_GET['id']!=''))
           {
              if(($model->active==2)) //if(($this->kals_dat_panull==false)&&($model->active==2))
               {	 
        	
       ?> 	      
        <div class="col-3">
            <label id="resp_form">

<label><?php echo Yii::t('app','Student\'s Status'); ?></label>
                        <?php 
                             
                           echo $form->dropDownList($model,'active',$model->getStatusValue() );
                           
                           ?>
                        <?php echo $form->error($model,'active'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<label> <?php echo Yii::t('app','Shift'); ?> </label>
                   
                       <?php 
					
					 
						$modelShift = new Shifts;
						
						  $default_vacation=null;
			      $criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'default_vacation',);
				   		$default_vacation_name = GeneralConfig::model()->find($criteria)->item_value;
				   		
				   		$criteria2 = new CDbCriteria;
				   								$criteria2->condition='shift_name=:item_name';
				   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
				   		$default_vacation = Shifts::model()->find($criteria2);
				   		
				   		

						if($model->is_student==1)//for update
						  {    
						  if($this->temoin_update==0)//pour l'affichage
						       {  $shift=$this->getShiftByStudentId($model->id,$acad_sess);
                                                       if($shift!=null)
					              $this->idShift= $shift->id;
                                                       else
                                                           $this->idShift=null;
					            }
					         if(isset($this->idShift)&&($this->idShift!=""))
						       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)), 'onchange'=> 'submit()',)); 
						      else
								{  $this->idLevel=0;
								     if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								             $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' ));    
					            }
					       }
						else //for create
						   {  if($this->idShift!='')
						        echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('prompt'=>'Select shift','onchange'=> 'submit()','options' => array($this->idShift=>array('selected'=>true)) )); 
					          else
								{  if($default_vacation!=null)
								      { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								            $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('prompt'=>'Select shift','onchange'=> 'submit()' ));                   
								}
					        }
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<label> <?php echo Yii::t('app','Section'); ?> </label>
                    
                       <?php 
					
					 
						$modelSection = new Sections;
						if($model->is_student==1)//for update
						  {   if($this->temoin_update==0)//pour l'affichage
						       { $section=$this->getSectionByStudentId($model->id,$acad_sess);
                                                       if($section!=null)
						         $this->section_id=$section->id;
                                                       else 
                                                           $this->section_id=null;
					            }
							   
					        if($this->section_id!='')
						        echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							else
							   {  $this->idLevel=0;
								echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
					           }
					       }
						else //for create
						   { 
							    if($this->section_id!='')
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							    else
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
					       }
						echo $form->error($modelSection,'section_name'); 
						
					
											
					   ?> 
                    
</label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

<label> <?php echo Yii::t('app','Entry Level'); ?> </label>
                    
                        <?php 
					 
					 
						$modelLevelPerson = new LevelHasPerson;
						if($model->is_student==1)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {   $level=$this->getLevelByStudentId($model->id,$acad_sess);
                                                       if($level != null)
						          $this->idLevel=$level->id;
                                                       else
                                                           $this->idLevel=null;
                                                       
					            }
							     
					          if($this->idLevel!='')
						         echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('options' => array($this->idLevel=>array('selected'=>true)), 'onchange'=> 'submit()',)); 
							  else
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()' )); 
					       }
						else //for create
							 if($this->idLevel!='')
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()','options' => array($this->idLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()' )); 
						
						echo $form->error($modelLevelPerson,'level'); 
						
					 
					  ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

                       <label> <?php  echo Yii::t('app','Room'); ?> </label> 
                    
                       <?php 
					
					 
						$modelRoom = new RoomHasPerson;
						if($model->is_student==1)//for update
						  {  if($this->temoin_update==0)//pour l'affichage
						       {  $room=$this->getRoomByStudentId($model->id,$acad_sess);
                                                       if($room !=null)
						          $this->room_id=$room->id;
                                                       else 
                                                           $this->room_id = null;
                                                      
					            }
							   
					         if($this->room_id!='')
						         echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('options' => array($this->room_id=>array('selected'=>true)))); 
							 else
								 echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel)); 
					       }
						else //for create
						   {  
							   if($this->room_id!='')
							      echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('options' => array($this->room_id=>array('selected'=>true)))); 
							   else
								   echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel)); 
					       }
						echo $form->error($modelRoom,'room'); 
						
					
										
					   ?> 
                           </label>
        </div>
                    <?php
                                           ?>
            
        
        <div class="col-3">
            <label id="resp_form">
                        <?php 
                            
                            echo $form->labelEx($modelStudentOtherInfo,'school_date_entry'); 
                        ?>
                    
                        <?php 
                            
                              if($this->school_date_entry!='')
                                $modelStudentOtherInfo->setAttribute('school_date_entry',$this->school_date_entry);
                        
                               $this->widget('zii.widgets.jui.CJuiDatePicker',
												 array(
                                 'model'=>'$modelStudentOtherInfo',
                                 'name'=>'StudentOtherInfo[school_date_entry]',
                                 'language'=>'fr',
                                 'value'=>$modelStudentOtherInfo->school_date_entry,
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
                <?php echo $form->error($modelStudentOtherInfo,'school_date_entry'); ?>        
                        
                           </label>
        </div>
          <?php ?>
                
                <?php     ?>
        
        <div class="col-3">
            <label id="resp_form"> 
                        <?php echo $form->labelEx($modelStudentOtherInfo,'previous_school'); ?>
                    
                        <?php 
                        
                              if($this->previousSchool!='')
                                $modelStudentOtherInfo->setAttribute('previous_school',$this->previousSchool);
                                
                            echo $form->textField($modelStudentOtherInfo,'previous_school',array('size'=>60,'maxlength'=>255, 'placeholder'=>Yii::t('app','Previous School'))); ?>
                        <?php echo $form->error($modelStudentOtherInfo,'previous_school'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form"> 

                        <?php echo $form->labelEx($modelStudentOtherInfo,'previous_level'); ?>
                    
                    <?php 
                     
						
						//for update
					if(isset($_GET['id'])&&($_GET['id']!=''))
						{
							if($this->idPreviousLevel!='')
							    echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadPreviousLevel($this->idLevel), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadPreviousLevel($this->idLevel)  ); 

							
						}
					 else
					   {  //for create
						 
							 if($this->idPreviousLevel!='')
							    echo $form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadPreviousLevel($this->idLevel), array('options' => array($this->idPreviousLevel=>array('selected'=>true)) )); 
							 else
								 echo $this->idLevel.'='.$form->dropDownList($modelStudentOtherInfo,'previous_level',$this->loadPreviousLevel($this->idLevel)); 
								 
					   }

		
		 echo $form->error($modelStudentOtherInfo,'previous_level'); 
		 
					
                    ?>
                    </label>
        </div>
  <?php      
        
                   }
             	
               }
        	        	
          } 
        	
       ?> 	      
         <div class="col-3">
            <label id="resp_form">
	<?php echo $form->labelEx($modelStudentOtherInfo,'health_state'); ?>
                        <?php 
                              if($this->health_state!='')
                                $modelStudentOtherInfo->setAttribute('health_state',$this->health_state);
                                
                                echo $form->textField($modelStudentOtherInfo,'health_state',array('size'=>60,'maxlength'=>255, 'placeholder'=>Yii::t('app','Health state')));  
                                
                               echo $form->error($modelStudentOtherInfo,'health_state'); 
                        
                        ?>
                    </label>
        </div>
        

        <div class="col-3">
            <label id="resp_form">
	<?php echo $form->labelEx($modelStudentOtherInfo,'father_full_name'); ?>
                        <?php 
                              if($this->father_full_name!='')
                                $modelStudentOtherInfo->setAttribute('father_full_name',$this->father_full_name);

                              echo $form->textField($modelStudentOtherInfo,'father_full_name',array('size'=>60,'maxlength'=>100, 'placeholder'=>Yii::t('app','Father full name'))); ?>
                        <?php echo $form->error($modelStudentOtherInfo,'father_full_name'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

	<?php echo $form->labelEx($modelStudentOtherInfo,'mother_full_name'); ?>
                        <?php 
                               if($this->mother_full_name!='')
                                $modelStudentOtherInfo->setAttribute('mother_full_name',$this->mother_full_name);
                              
                               echo $form->textField($modelStudentOtherInfo,'mother_full_name',array('size'=>60,'maxlength'=>100, 'placeholder'=>Yii::t('app','Mother full name'))); ?>
                        <?php echo $form->error($modelStudentOtherInfo,'mother_full_name'); ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">

	<?php echo $form->labelEx($modelStudentOtherInfo,'person_liable'); ?>
                        <?php 
                              if($this->person_liable!='')
                                $modelStudentOtherInfo->setAttribute('person_liable',$this->person_liable);
                              
                             echo $form->textField($modelStudentOtherInfo,'person_liable',array('size'=>60,'maxlength'=>100, 'placeholder'=>Yii::t('app','Person liable')));  
                            echo $form->error($modelStudentOtherInfo,'person_liable'); 
                        ?>
                    </label>
        </div>
        
        <div class="col-3">
            <label id="resp_form">
                    
                    <?php echo $form->labelEx($modelStudentOtherInfo,'person_liable_phone'); ?>
                        <?php 
                              if($this->person_liable_phone!='')
                                $modelStudentOtherInfo->setAttribute('person_liable_phone',$this->person_liable_phone);	
                                
                               echo $form->textField($modelStudentOtherInfo,'person_liable_phone',array('size'=>60,'maxlength'=>65, 'placeholder'=>Yii::t('app','Person liable phone'))); ?>
                        <?php echo $form->error($modelStudentOtherInfo,'person_liable_phone'); ?>
                    </label>
        </div>
  
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
                    $mCustomField = CustomField::model()->findAll($criteria); 
                    $i=0;
                    $id_student = $_GET['id'];
                    foreach($mCustomField as $mc){
                        switch ($mc->field_type){
                            case "txt" : {


                    ?> 

                    <div class="col-3">
                        <label id="resp_form">
                        <label><?php echo $mc->field_label; ?></label>
                        <input value="<?php echo $modelCustomFieldData->getCustomFieldValue($id_student, $mc->id); ?>" size="60" name="<?php echo $mc->field_name; ?>" placeholder="<?php echo $mc->field_label; ?>" >
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
                    <input  value="<?php echo $modelCustomFieldData->getCustomFieldValue($id_student, $mc->id); ?>" size="60" class="custom_date" name="<?php echo $mc->field_name; ?>" placeholder="<?php echo $mc->field_label; ?>" type="text">
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
                                echo '<option value="'.$modelCustomFieldData->getCustomFieldValue($id_student, $mc->id).'" selected="selected">'.$modelCustomFieldData->getCustomFieldValue($id_student, $mc->id).'</option>';
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

    <?php } ?>
<!--
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl ?>/js/jquery-ui.css" />
<script src="<?php echo Yii::app()->baseUrl ?>/js/jquery-ui.js" type="text/javascript">
</script>
-->

<script>
        
  $(function() {
    $( ".custom_date" ).datepicker({
      
      changeMonth: true,
      changeYear: true,
      
      
    });
  });
  
  </script>
 

    
 
 