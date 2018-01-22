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
/* @var $this HomeworkSubmissionController */
/* @var $model HomeworkSubmission */
/* @var $form CActiveForm */
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
 

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 


 
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $this->student_id=$p->id;
				
				
	$room_id=0;
         //get room ID in which this child enrolled
          $modelRoom=Rooms::model()->getRoom($this->student_id, $acad_sess)->getData();
                
                if(isset($modelRoom))
                  {  foreach($modelRoom as $r)
                       $room_id=$r->id;
                       
                  }			
					
				
				
				
?>

</br>
<div class="b_m">



	<p class="note"><?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model);
	 
	   
?>
  	
<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >
      
   
    <div  id="resp_form_siges">

        <form  id="resp_form">
        
            <div class="col-2">
                
                     <?php echo $form->labelEx($model,'homework_id'); ?>	
                     
                   <label>
<?php
	 
	    if(isset($_GET['hw_id'])&&($_GET['hw_id']!=''))
	      $this->homework_id = $_GET['hw_id'];
	 
	       	
	            if(isset($this->homework_id))
                     echo $form->dropDownList($model,'homework_id',$this->loadHomeworkByRoomId($room_id,$acad_sess), array('options' => array($this->homework_id=>array('selected'=>true)))); 
                else  
                   echo $form->dropDownList($model,'homework_id',$this->loadHomeworkByRoomId($room_id,$acad_sess));
                               

?>
	
	<?php echo $form->error($model,'homework_id'); ?>
	                       </label>
	                 </div>
	                      
	                       

	    <div class="col-2">
	          <?php echo $form->labelEx($model,'comment'); ?></td>
           <label>
				<?php echo $form->textArea($model,'comment',array('rows'=>2, 'cols'=>60)); ?>
				<?php echo $form->error($model,'comment'); ?>
			</label>               
	      </div>             
	                    
	    <div class="col-2">
                
                              <?php echo $form->labelEx($model,'attachment_ref'); ?>
					<label>        
					  <?php         if(isset($model->attachment_ref))
						           {   $explode_name= explode("/",substr($model->attachment_ref, 0));
                                            $i=0;
						           	     foreach($explode_name as $name)
						           	        { if($i==0)
						           	            { echo $name;
						           	               $i=1;
						           	              }
						           	           else
						           	              echo ' / '.$name;
						           	         
						           	         }
						                   
						                   if(isset($_GET['id']))  
		                                    { 
		                                    	if($model->attachment_ref!='')
		                                    	   echo $form->label($model,'keepDoc').' '.$form->checkBox($model,'keepDoc',array('checked'=>0));
		                                      }
						              } 
						           

						        
						           ?>
						            
		                    <label id="upload">
		                        <input name="document" id="document" type="file"  /> </label>
									<?php echo $form->error($model,'document'); ?>
		                     
		                     </div>                       
                
                  </label>
        </div>                            
                       <div class="col-submit"> 
                                
                                <?php if(!isset($_GET['id'])){
                                          if(!isAchiveMode($acad_sess))
                                              echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
                                        }
                                         else
                                           {  
                                              if(!isAchiveMode($acad_sess))
                                                   echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              
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
    </div>
<!-- END OF TEST -->




