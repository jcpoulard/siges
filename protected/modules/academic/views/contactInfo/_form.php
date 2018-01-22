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
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


   $disable_contact='';
   $disable_other_fields=''



?>

<?php $this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); ?>

</br>

<div class="b_mail">        
	<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';
	
	 echo $form->errorSummary($model);
	 
	    	        
	        //error message 
	        	if(($this->filledMessage)||($this->alreadyExist))//||($this->success))
			      { 
				      //echo '">';
				      				      
			          			       
			       }			      
				 					     	
				   
				    if($this->filledMessage)
				     echo '<span style="color:red" >'.Yii::t('app','Please check \'Add\' or \'Use Contact\'.').'</span>'.'<br/>';
				 
				    if($this->alreadyExist)
				      echo '<span style="color:red" >'.Yii::t('app','Please verify your data, This record already exist.').'</span>'.'<br/>';
				    
				
				   
					   
			     if(($this->filledMessage)||($this->alreadyExist))//||($this->success))
			      { 
			       }
       		
	    
	?>


<div  id="resp_form_siges">

        <form  id="resp_form">

<div class="col-2">
            <label id="resp_form">
                          <?php echo $form->labelEx($model,'contact_name'); ?>
								<?php
								    
								   
			                         if($this->use_contact==1)
					                   $disable_contact='disabled';
					                 elseif($this->use_contact==0)
					                   $disable_contact='';
                           
                           if(($this->add==0)&&($this->ch_name==0))
						       { 
					             if(isset($_GET['from'])&&($_GET['from']!=""))
					            	{  $this->extern=true;
						                $pers_id=0;
						               if($_GET['from']=="stud")
						                 {
                                            if($this->temoin_update)
                                             {  
                                                if(isset($_GET['id'])&&($_GET['id']!=''))
                                                    $pers_id=$_GET['id'];
                                                
                                             	$criteria = new CDbCriteria(array('group'=>'contact_name','alias'=>'c', 'order'=>'contact_name','join'=>'left join persons p on(c.person = p.id)', 'condition'=>'p.is_student=1 AND p.active IN(1, 2)  AND c.id='.$pers_id));
                                                $this->contact_id=$pers_id;
                                              }
                                            else
						            	      $criteria = new CDbCriteria(array('group'=>'contact_name','alias'=>'c', 'order'=>'contact_name','join'=>'left join persons p on(c.person = p.id)', 'condition'=>'p.is_student=1 AND p.active IN(1, 2) '));//.' AND p.id='.$_GET['pers']));
								
										if(isset($this->contact_id)&&($this->contact_id!=''))
										   echo $form->dropDownList($model, 'contact_name',CHtml::listData(ContactInfo::model()->findAll($criteria),'id','contact_name'),array('onchange'=> 'submit()','options' => array($this->contact_id=>array('selected'=>true)), 'disabled'=>$disable_contact));
										else
										   echo $form->dropDownList($model, 'contact_name',CHtml::listData(ContactInfo::model()->findAll($criteria),'id','contact_name'),array('onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Search for contact --'), 'disabled'=>$disable_contact));
					
						            	   
						            	 }
						              elseif(($_GET['from']=="emp")||($_GET['from']=="teach"))
						                 {
						                 	if($this->temoin_update)
                                             {  
                                                if(isset($_GET['id'])&&($_GET['id']!=''))
                                                    $pers_id=$_GET['id'];
                                                
                                             	$criteria = new CDbCriteria(array('group'=>'contact_name','alias'=>'c', 'order'=>'contact_name','join'=>'left join persons p on(c.person = p.id)', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND c.id='.$pers_id));
								                        $this->contact_id=$pers_id;
                                              }
                                            else
						            	         $criteria = new CDbCriteria(array('group'=>'contact_name','alias'=>'c', 'order'=>'contact_name','join'=>'left join persons p on(c.person = p.id)', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) '));


										if(isset($this->contact_id)&&($this->contact_id!=''))
										   echo $form->dropDownList($model, 'contact_name',CHtml::listData(ContactInfo::model()->findAll($criteria),'id','contact_name'),array('onchange'=> 'submit()','options' => array($this->contact_id=>array('selected'=>true)), 'disabled'=>$disable_contact));
										else
										   echo $form->dropDownList($model, 'contact_name',CHtml::listData(ContactInfo::model()->findAll($criteria),'id','contact_name'),array('onchange'=> 'submit()', 'prompt'=>Yii::t('app','-- Search for contact --'), 'disabled'=>$disable_contact));

						                  }
						                
						            
					            	  }							            	  
						           }
						        else
						          {  if(($this->add==1))
						               { 
						               	   echo $form->textField($model,'contact_name',array('size'=>60,'maxlength'=>45 ));     	
						                    
						                 }
						               elseif(($this->ch_name==1))
						               {  
						               	  				
						               	   
						               	   $model_contact=ContactInfo::model()->findByPk($model->id);
						               	   
						               	    $model_=new ContactInfo;
						               	    if($model->contact_name!=null)
						               	     {  echo $form->textField($model_,'contact_name',array('size'=>60,'maxlength'=>45, 'placeholder'=>$model_contact->contact_name));     	
						               	        $this->contact=$model_contact->contact_name;
						               	       }
						               	    else
						               	        echo $form->textField($model_,'contact_name',array('size'=>60,'maxlength'=>45, 'placeholder'=>$model_contact->contact_name));     	
 
						                    
						                 }
						          	}            
						          	                        
								 echo $form->error($model,'contact_name'); 
								 
								?>
			</label>
        </div>
        
        <div class="col-2">
            <label id="resp_form">

				<?php 
                              if(!$this->temoin_update)
                               {      
                                  if(!$this->search_set)
	                                {
	                                	 echo $form->label($model,'add'); 
		                              if($this->add==1)
				                          { echo $form->checkBox($model,'add',array('onchange'=> 'submit()','checked'=>'checked'));
				                              $this->add=0;
				                           }
						                 else
							               echo $form->checkBox($model,'add',array('onchange'=> 'submit()'));
	                                	
	                                  }
	                                else
	                                 {
	                                
	                                echo $form->label($model,'use_contact'); 
		                              if($this->use_contact==1)
				                          { echo $form->checkBox($model,'use_contact',array('onchange'=> 'submit()','checked'=>'checked'));
				                              $this->use_contact=0;
                    	                     $disable_other_fields='disabled';
   				                           }
						                 else
							               {  echo $form->checkBox($model,'use_contact',array('onchange'=> 'submit()')); 
							                  $disable_other_fields='';
							               }
	                                } 
	                                
                                 }
                                else
                                  {  
                                  	echo $form->label($model,'ch_name'); 
		                              if($this->ch_name==1)
				                          { echo $form->checkBox($model,'ch_name',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
   				                           }
						                 else
							               {  echo $form->checkBox($model,'ch_name',array('onchange'=> 'submit()')); 
							                  
							               }
                                  	
                                  	}
                                  	
                                  	               
					                ?>
							
            </label>
        </div>
        
     

                <?php     
                  if(($this->search_set)||($this->add==0))
                    { 
                    	 
                    	
                    	?>    
               
  <div class="col-2">
                 <label id="resp_form">

					<?php echo $form->labelEx($model,'person'); ?> 
                            <?php if(isset($_GET['pers'])&&($_GET['pers']!=""))
					            { 
					              if(isset($_GET['from'])&&($_GET['from']!=""))
					            	{ if($_GET['from']=="stud")
						            	{ $this->extern=true;
						            	  $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name','join'=>'left join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1, 2) AND rh.academic_year ='.$acad_sess.' AND p.id='.$_GET['pers']));
								
												if($this->temoin_update)
												   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
												else
												   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>''));
					
						            	 }
						            	elseif(($_GET['from']=="view"))
						            	 {  $this->extern=true;
						            	  $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name', 'condition'=>'is_student=0 AND active IN(1, 2) AND p.id='.$_GET['pers']));
								
										
										   
						            	  
						            	  }
						  elseif(($_GET['from']=="emp")||($_GET['from']=="teach"))
						            	 {  $this->extern=true;
						            	  $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name', 'condition'=>'is_student=0 AND active IN(1, 2) AND p.id='.$_GET['pers']));
								
										if($this->temoin_update)
										   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
										else
										   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>''));
						            	  
						            	  }
						            	
						            	  
					                  
					               }
					
					            }
					          else
					            {  if(isset($_GET['from'])&&($_GET['from']!=""))
					            	{ if($_GET['from']=="stud")
						            	{ $this->extern=true;
						            	  $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name','join'=>'left join room_has_person rh on(rh.students = p.id)', 'condition'=>'is_student=1 AND active IN(1, 2) AND rh.academic_year ='.$acad_sess));
								
										if($this->temoin_update)
										   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
										else
										   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>''));
					
						            	 }
						            elseif(($_GET['from']=="teach"))
						            	 {  $this->extern=true;
						            	  $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'last_name', 'condition'=>'is_student=0 AND active IN(1, 2) AND p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE (a.year='.$acad_sess.' OR (a.id='.$acad_sess.')) ) ' ));
								
										if($this->temoin_update)
										   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
										else
										   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>''));
						            	  
						            	  }
						            	elseif(($_GET['from']=="emp"))
						            	 {  $this->extern=true;
						            	  $criteria = new CDbCriteria(array('alias'=>'p', 'order'=>'p.last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND p.id NOT IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE a.year='.$acad_sess.')' ));
								
										if($this->temoin_update)
										   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
										else
										   echo $form->dropDownList($model, 'person',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>''));
						            	  
						            	  }
						            	  
					                  
					               }

									      
					            }
					        ?>
                                <?php echo $form->error($model,'person'); ?>
               </label>
        </div>
        
    <div class="col-2">
            <label id="resp_form">
    

<?php 
                
              
                                echo $form->labelEx($model,'contact_relationship');
                               ?>
						   
             
						    <?php       
						                $criteria = new CDbCriteria(array('order'=>'relation_name',));
								
								echo $form->dropDownList($model, 'contact_relationship',
								CHtml::listData(Relations::model()->findAll($criteria),'id','relation_name'),
								array('prompt'=>Yii::t('app','-- Please select relation type --'), 'disabled'=>'')
								);
						                
						               
								 echo $form->error($model,'contact_relationship'); 
								 
                              
								 
								 ?>
                         
                          
                          
                            </label>
        </div>
                       
                       <div class="col-2">
            <label id="resp_form">

			<?php echo $form->labelEx($model,'profession'); ?>
							<?php echo $form->textField($model,'profession',array('size'=>60,'maxlength'=>100, 'disabled'=>$disable_other_fields)); ?>
							<?php echo $form->error($model,'profession'); ?>                          
						  </label>
        </div>
            
        <div class="col-2">
            <label id="resp_form">

		<?php echo $form->labelEx($model,'phone'); ?>
                              <?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>64, 'disabled'=>$disable_other_fields)); ?>
                              <?php echo $form->error($model,'phone'); ?>
                          </label>
        </div>
            
        <div class="col-2">
            <label id="resp_form">

		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255, 'disabled'=>$disable_other_fields)); ?>
                              <?php echo $form->error($model,'address'); ?>
                           </label>
        </div>
            
        <div class="col-2">
            <label id="resp_form">
			<?php echo $form->labelEx($model,'email'); ?>
                           <?php
                              
                                   if(($this->ch_name==1))
						               {  
						               	  				
						               	   
						               	   $model_contact=ContactInfo::model()->findByPk($model->id);
						               	   
						               	    $model_=new ContactInfo;
						               	    if($model->email!=null)
						               	     {  echo  $form->textField($model_,'email',array('size'=>60,'maxlength'=>45, 'placeholder'=>$model_contact->email));     	
						               	        
						               	       }
						               	    else
						               	        echo  $form->textField($model_,'email',array('size'=>60,'maxlength'=>45, 'placeholder'=>''));     	
 
						                    
						                 }
						              else
						                 {
                                                                  if(isset($model->id)){
                                                                    
                                                                    $model_contact=ContactInfo::model()->findByPk($model->id);
                                                                    
						                 	 echo  $form->textField($model_contact,'email',array('size'=>60,'maxlength'=>64, 'disabled'=>$disable_other_fields) ); 
                                                                  }
                                                                  else{
                                                                      echo  $form->textField($model,'email',array('size'=>60,'maxlength'=>64, 'disabled'=>'') ); 
                                                                  }
						                 }
                               echo $form->error($model,'email'); 
                               
                               
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
                                           {  if(!isAchiveMode($acad_sess))
                                                  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

	                                             
                                ?>
                         
                <?php 
	                    } 
	                      ?>  
                                           
                      </div>
        </form>
</div>
              
   
<!-- END OF TEST -->





