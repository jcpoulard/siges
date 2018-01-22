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
    
$acad=Yii::app()->session['currentId_academic_year']; 


  
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $this->student_id=$p->id;
				
				
	$room_id=0;
         //get room ID in which this child enrolled
          $modelRoom=Rooms::model()->getRoom($this->student_id, $acad)->getData();
                
                if(isset($modelRoom))
                  {  foreach($modelRoom as $r)
                       $room_id=$r->id;
                       
                  }			
					
				
				
				
?>


	<p class="note"><?php echo Yii::t('app','Fields with <span class="required">*</span> are required.'); ?></p>

	<?php echo $form->errorSummary($model);
	 
	   
?>
  	
<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td ><?php echo $form->labelEx($model,'homework_id'); ?></td>
                          <td>
	<div>
<?php
	 
	    if(isset($_GET['hw_id'])&&($_GET['hw_id']!=''))
	      $this->homework_id = $_GET['hw_id'];
	 
	       	
	            if(isset($this->homework_id))
                     echo $form->dropDownList($model,'homework_id',$this->loadHomeworkByRoomId($room_id,$acad), array('options' => array($this->homework_id=>array('selected'=>true)))); 
                else  
                   echo $form->dropDownList($model,'homework_id',$this->loadHomeworkByRoomId($room_id,$acad));
                               

?>
	
	<?php echo $form->error($model,'homework_id'); ?>
	                       </div>
	                       </td>
	                       
	
	     <td><?php echo $form->labelEx($model,'comment'); ?></td>
           <td>
				<?php echo $form->textArea($model,'comment',array('rows'=>2, 'cols'=>60)); ?>
				<?php echo $form->error($model,'comment'); ?>
			</td>               
	                    
	                    
	  </tr>
	   <tr>
          <td colspan="4"> 
	      
                          <?php echo $form->labelEx($model,'attachment_ref');
					           if(isset($model->attachment_ref))
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
						            
		                    </td>
		          </tr>  
		          <tr>   
		                    <td colspan="4"> <label id="upload">
		                        <input name="document" id="document" type="file"  /> </label>
									<?php echo $form->error($model,'document'); ?>
		                    </td>
                       
                       </tr>
                       
                                            
                       <tr>
                          <td colspan="4"> 
                                
                                <?php if(!isset($_GET['id'])){
                                         echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                          //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        }
                                         else
                                           {  echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

	                                             
                                ?>
                                
                            </td> 
                       </tr>
                
                  
                                           
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>
<!-- END OF TEST -->




