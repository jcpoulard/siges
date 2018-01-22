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

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$siges_structure = infoGeneralConfig('siges_structure_session');



?>

<?php
	//echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';

	  echo $form->errorSummary($model); ?>




<?php
//error message 
	        	if(($this->messageWeightBase) )
				    {   echo '<div class="" style=" padding-left:0px;margin-right:0px; margin-bottom:-40px; ';//-20px; ';
				      echo '">';
				      
				   	
				   	 
				    echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	  
				  
					     	
				   echo '<span style="color:red;" >'.Yii::t('app','Course weight doesn\'t match your average base.').'</span>'.'<br/>';
				   
					   // echo '<span style="color:blue;" ><b>'.Yii::t('app','- COURSE WEIGHT : ').$weight.' - </b></span>';
					
					 echo'</td>
					    </tr>
						</table>';
					
           echo '</div> <br/>';
           
				    }

    ?>
				    	
<div  id="resp_form_siges">

<form  id="resp_form">

<?php

if(isset($_GET['id'])&&($_GET['id']!="")) 
   {

?>  
 <div class="col-3">
	 <label id="resp_form">
				 <div>
				      <?php echo Yii::t('app','Substitute teacher'); ?>
			  
			       <?php if($this->new_teacher==1)
			                   echo CHtml::checkBox('new_teacher',true,array('onchange'=> 'submit()'));
			              elseif($this->new_teacher==0)
			                  echo CHtml::checkBox('new_teacher',false,array('onchange'=> 'submit()'));     
			        ?>
			</div>
 </label>
</div>
  
<?php
      }
?>            
                     
<div class="col-3">
	 <label id="resp_form">

<div for="Subjects"><?php echo Yii::t('app','Subject' ); ?></div>
                         	    

<?php 

			$criteria = new CDbCriteria(array('order'=>'subject_name',));
			
			if($this->usedCourse==false)
			  {					
				  echo $form->dropDownList($model, 'subject',
					 CHtml::listData(Subjects::model()->findAll($criteria),'id','subjectName'),
					 array('prompt'=>Yii::t('app','-- Please select a subject --'))
						);
			    }
			 elseif($this->usedCourse==true)
			  {					
				  echo $form->dropDownList($model, 'subject',
					 CHtml::listData(Subjects::model()->findAll($criteria),'id','subjectName'),
					 array('disabled'=>'disabled')
						);
			    }

?>   


 
			    


                          
 </label>
</div>
	


                          
<div class="col-3">
	 <label id="resp_form">


<div for="Persons"><?php echo Yii::t('app', 'Teacher'); ?></div>
                         
                                    <?php 
								if(isset($_GET['emp'])&&($_GET['emp']!="")) 
								  {
						            	$this->extern=true;
						            	
						            	
								      $criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=0 AND active IN(1,2) AND id='.$_GET['emp']));
								
										echo $form->dropDownList($model, 'teacher',
										CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
						
						            }
						          elseif(isset($_GET['id'])&&($_GET['id']!="")) 
								  {
						              if($this->new_teacher==1)
						                {
						                	$criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=0 AND active IN(1, 2)'));
										
											echo $form->dropDownList($model, 'teacher',
											CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
											array('prompt'=>Yii::t('app','-- Please select a teacher --'))
											);
											
						                }
						              elseif($this->new_teacher==0)	
						                { 
						                	$criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=0 AND active IN(1,2)'));
								
											echo $form->dropDownList($model, 'teacher',
											CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('disabled'=>'disabled'));
						                }
						                
						            }
						          else
						            {	
										$criteria = new CDbCriteria(array('order'=>'last_name','condition'=>'is_student=0 AND active IN(1, 2)'));
										
										echo $form->dropDownList($model, 'teacher',
										CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),
										array('prompt'=>Yii::t('app','-- Please select a teacher --'))
										);
										
						            }
										
						        ?>  
                         </label>
	  </div>
	
	
	
<div class="col-3">
	<label id="resp_form">

<div for="Rooms"><?php echo Yii::t('app', 'Room'); ?></div>
                          
            <?php 
			            if($siges_structure==0)
			                $criteria = new CDbCriteria(array('order'=>'room_name',));
			            elseif($siges_structure==1)
			                $criteria = new CDbCriteria(array('alias'=>'r','join'=>'inner join room_has_person rhp on(rhp.room=r.id) ','condition'=>'rhp.academic_year='.$acad_sess, 'order'=>'room_name',));
			            
			            
			            
									
						if($this->usedCourse==false)
			               {			
									echo $form->dropDownList($model, 'room',
									CHtml::listData(Rooms::model()->findAll($criteria),'id','room_name'),
									array('prompt'=>Yii::t('app','-- Please select a room --'))
									);
									
			               }
			             elseif($this->usedCourse==true)
			               {			
									echo $form->dropDownList($model, 'room',
									CHtml::listData(Rooms::model()->findAll($criteria),'id','room_name'),
									array('disabled'=>'disabled')
									);
									
			               }
							       
	     ?> 
                          

</label>
	  </div>
	
	

 <div class="col-3">
	<label id="resp_form">

<?php echo $form->labelEx($model,'weight'); ?>


 <?php 
                   //if($this->usedCourse==false)
			       //   {			
						 echo $form->textField($model,'weight', array('size'=>60,'placeholder'=>Yii::t('app','Weight')) ); 
									
			       //    }
			       // elseif($this->usedCourse==true)
			       //   {			
					//	echo $form->textField($model,'weight', array('size'=>60,'placeholder'=>Yii::t('app','Weight'),'disabled'=>'disabled') );									
			       //    }

 
          ?>  
			    



         <?php echo $form->error($model,'weight'); ?>
                         </label>
	  </div>
                  

<?php

if(isset($_GET['id'])&&($_GET['id']!="")) 
   {
   ?>
		<div class="col-3">
			<label id="resp_form"  style='width:70%;'>   	
  <?php         
       if($this->optional!=1)
           {
?>
    <div style='float:left; margin-right:50px;'>    <?php echo $form->labelEx($model,'debase'); ?>
                          
   <?php if($this->debase==1)
		  {  echo $form->checkBox($model,'debase',array('onchange'=> 'submit()','checked'=>'checked'));
		   }
		 else
			echo $form->checkBox($model,'debase',array('onchange'=> 'submit()'));				               
		  
		   ?>
   <?php echo $form->error($model,'debase'); ?> 
</div>
 
<?php  }  
        
     if($this->debase!=1)
       {
?>
    
    <div style='margin-left:50px;'>    <?php echo $form->labelEx($model,'optional'); ?>
                          
   <?php if($this->optional==1)
		  {  echo $form->checkBox($model,'optional',array('onchange'=> 'submit()','checked'=>'checked')); 
		   }
		 else
			echo $form->checkBox($model,'optional',array('onchange'=> 'submit()'));
		  ?>
   <?php echo $form->error($model,'optional'); ?> 
</div>

<?php  }  ?>


 </label>
</div>
 
<?php  } 
     else
     {
 
       if($this->optional!=1)
           {
?>
<div class="col-3">
	<label id="resp_form">

        
    <div>    <?php echo $form->labelEx($model,'debase'); ?>
                          
   <?php if($this->debase==1)
		  {  echo $form->checkBox($model,'debase',array('onchange'=> 'submit()','checked'=>'checked'));
		   }
		 else
			echo $form->checkBox($model,'debase',array('onchange'=> 'submit()'));				               
		  
		   ?>
   <?php echo $form->error($model,'debase'); ?> 
</div>
 </label>
</div>

<?php  }  ?>
<?php
         if($this->debase!=1)
           {
?>
<div class="col-3">
	<label id="resp_form">

        
    <div>    <?php echo $form->labelEx($model,'optional'); ?>
                          
   <?php if($this->optional==1)
		  {  echo $form->checkBox($model,'optional',array('onchange'=> 'submit()','checked'=>'checked')); 
		   }
		 else
			echo $form->checkBox($model,'optional',array('onchange'=> 'submit()'));
		  ?>
   <?php echo $form->error($model,'optional'); ?> 
</div>
 </label>
</div>

<?php  }  ?>

<?php  }  ?>
	
<div class="col-3">
	<label id="resp_form">



<div for="AcademicPeriods"><?php echo Yii::t('app', 'Academic period'); ?></div>

<?php 
			
								$criteria = new CDbCriteria(array('condition'=>'year=:acad2 OR id =:acad2','params'=>array(':acad2'=>$acad_sess),'order'=>'date_end DESC',));
								
								if($model->academic_period !='')
								  {  echo $form->dropDownList($model, 'academic_period',
								      CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
								      array('prompt'=>Yii::t('app','-- Please select academic period --') )
								       );
								    }
								 else
								   {   echo $form->dropDownList($model, 'academic_period',
								      CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
								      array('prompt'=>Yii::t('app','-- Please select academic period --'), 'options' => array($acad_sess=>array('selected'=>true)) )
								       );
								   	 
								   	 }
								
								
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
                                
   </div>                                                    
                        </form>

</div>                
              </div>
<!-- END OF TEST -->
	
	
	
	
	
	
	
	
	
			