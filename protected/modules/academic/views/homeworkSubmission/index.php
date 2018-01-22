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
/* @var $dataProvider CActiveDataProvider */

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 


$template1 = '';

$template='';

		     $userName='';
		     $group_name='';
		     
		      if(isset(Yii::app()->user->name))
		           $userName=Yii::app()->user->name;
	
	if(isset(Yii::app()->user->groupid))
	   {    
	      $groupid=Yii::app()->user->groupid;
	      $group=Groups::model()->findByPk($groupid);
			
		  $group_name=$group->group_name;
	   }	


 $id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				
			
		        


 if(!isAchiveMode($acad_sess))
      $template1 = $template;	     
?>

		
<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Manage submited homework'); ?>
		</h2> </div>
     
		   <div class="span3">
                                   
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                    
				    echo CHtml::link($images,array('/academic/homework/index/isstud/1/from/stud'));
				                                  
               ?>
             </div>  
      </div>

</div>


<div style="clear:both"></div>


<?php 

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#homework-submission-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");


 ?>




<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'homeworkSubmission-form',
	
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
      ),
)); 
?>
</br>

         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="4" style="background-color:#EFF3F8;border:none;">
<div style="padding:0px;">			
	<?php 
 if((Yii::app()->user->profil!='Teacher'))
      {
	    
	    
            	?>	
			<!--Shift(vacation)-->
        <div class="left" style="margin-left:10px;">
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('app','Shift '));?>
					 <?php 
					         $default_vacation=null;
			      $criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'default_vacation',);
				   		$default_vacation_name = GeneralConfig::model()->find($criteria)->item_value;
				   		
				   		$criteria2 = new CDbCriteria;
				   								$criteria2->condition='shift_name=:item_name';
				   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
				   		$default_vacation = Shifts::model()->find($criteria2);
				   		
				   		

						
						  if(isset($this->idShift)&&($this->idShift!=""))
						        {   
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ $this->idLevel=0;
								    if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								              $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' )); 
								}
							
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
				</div>
			 
		    <!--section(liee au Shift choisi)-->
			<div class="left" style="margin-left:10px;">
			<?php $modelSection = new Sections;
			                   echo $form->labelEx($modelSection,Yii::t('app','Section')); ?>
			           <?php 
					
					    
							    if(isset($this->section_id)&&($this->section_id!=''))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('options' => array($this->section_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { $this->idLevel=0;
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
						           }					      
						  
						echo $form->error($modelSection,'section_name'); 
						
															
					   ?>
				</div>
			
			<!--level-->
			<div class="left" style="margin-left:10px;">
			<?php $modelLevelPerson = new LevelHasPerson;
			                       echo $form->labelEx($modelLevelPerson,Yii::t('app','Level'));?> 
					   <?php 
					 
					   
						if(isset($this->idLevel)&&($this->idLevel!=''))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionIdAcademicP($this->idShift,$this->section_id,$acad_sess), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionIdAcademicP($this->idShift,$this->section_id,$acad_sess), array('onchange'=> 'submit()' )); 
					              $this->room_id=0;
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			
			<!--room-->
			<div class="left" style="margin-left:10px;">
			   <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					        if(($this->room_id==null)||($this->room_id==0))
			                   $this->room_id=Yii::app()->session['Rooms']; 
						    
							  
							  if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel,$acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel,$acad_sess), array('onchange'=> 'submit()')); 
							          
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
				
		   <!--course-->
			<div class="left" style="margin-left:10px;">
				<?php $modelCourse = new Courses;
					  ?></label><?php 
					        echo $form->labelEx($modelCourse,Yii::t('app','Course'));
					        
						
			  if(isset($this->room_id)){
						   
						     
					 if((Yii::app()->user->profil!='Teacher'))
                       {
                       	   if(isset($this->course_id))
						        {   
					               echo $form->dropDownList($modelCourse,'subject',$this->loadSubject($this->room_id,$this->idLevel,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) )); 
					             }
							  else
								{ $this->course_id=0;
								    echo $form->dropDownList($modelCourse,'subject',$this->loadSubject($this->room_id,$this->idLevel,$acad_sess),array('onchange'=> 'submit()')); 
								}
                       	                       	
                        }//fen  if((Yii::app()->user->profil!='Teacher'))
                      else // Yii::app()->user->profil=='Teacher'
                        {
                      	   
						    if(isset($this->course_id))
						        {   
					               echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id,$id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) )); 
					             }
							  else
								{ $this->course_id=0;
								    echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id,$id_teacher,$acad_sess),array('onchange'=> 'submit()')); 
								}
								
                           }//fen  Yii::app()->user->profil=='Teacher'
      
	    	
								
								
						  }
						else
							echo $form->dropDownList($modelCourse,'subject',$this->loadSubject(null,null,$acad_sess),array('onchange'=> 'submit()'));
						 
						echo $form->error($modelCourse,'subject'); 
						
					
					  ?>
              
              </div>
			
		 <?php          
      }//fen if((Yii::app()->user->profil!='Teacher'))
 else // Yii::app()->user->profil=='Teacher'
  {
  	?>
			<!--room-->
			<div class="left" style="margin-left:10px;">
			   <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
			                  
			                   
												  
							  if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()')); 
							          
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
				
					
		   <!--course-->
			<div class="left" style="margin-left:10px;">
				<?php $modelCourse = new Courses;
					  ?></label><?php 
					        echo $form->labelEx($modelCourse,Yii::t('app','Course'));
					        
						
			  if(isset($this->room_id)){
						   
						     
					  // Yii::app()->user->profil=='Teacher'
                        
                      	   
						    if(isset($this->course_id))
						        {   
					               echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id,$id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) )); 
					             }
							  else
								{ $this->course_id=0;
								    echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id,$id_teacher,$acad_sess),array('onchange'=> 'submit()')); 
								}
								
                           //fen  Yii::app()->user->profil=='Teacher'
      
	    	
								
								
						  }
						else
							echo $form->dropDownList($modelCourse,'subject',$this->loadSubject(null,null),array('onchange'=> 'submit()'));
						 
						echo $form->error($modelCourse,'subject'); 
						
					
					  ?>
              
              </div>
			
			
<?php
  	
    }//fen Yii::app()->user->profil=='Teacher'
 	             
		            
		 
		 
		 
		  ?>	
			
		
				
													   
    </div>
 
			              </td>
			           </tr>
			            <tr>
			              <td colspan="4" style="background-color:#EFF3F8;border: none;">
			

<?php 




   if($group_name=='Student')
     {
         $template='';//'{update}';
         
         if(isset($_GET['msgulds'])&&($_GET['msgulds']=='y'))
           $this->message_UpdateLimitDateSubmission=true;
	
			//error message
	    if(($this->message_UpdateLimitDateSubmission))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-top:15px;  margin-bottom:-47px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }			      
				 				   
				  if($this->message_UpdateLimitDateSubmission)
				     { echo '<span style="color:red;" >'.Yii::t('app','Update operation is denied due to the "Limit Submission Date".').'</span><br/>';
				     $this->message_UpdateLimitDateSubmission=false;
				     }
				     
				 
			 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';
           
           
     }
     
     

             if($this->course_id==null)
                 $this->course_id = 0;
             
             $path='';    
             if($this->room_id!='')
                 $path=$this->getPath_teacher($this->room_id);
                
                
             $dataProvider = $model->searchSubmitedHomework($this->course_id,$acad_sess);
    				
                     

 $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
       $gridWidget  = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'homework-submission-grid',
	'dataProvider'=>$dataProvider,
	'mergeColumns'=>array('student','homework_id','homework->person'),
	
	'columns'=>array(
		
		array(
                                    'header'=>Yii::t('app','Student name'),
                                    'name' => 'student',
                                    'value'=>'$data->student0->first_name." ".$data->student0->last_name." (".$data->student0->id_number.")"',
                 ),
        
       array(
                                    'header'=>Yii::t('app','Teacher'),
                                    'name' => 'homework->person',
                                    'value'=>'$data->homework->person->first_name." ".$data->homework->person->last_name',
                 ),
       
        array(
                                    'header'=>Yii::t('app','Homework Title'),
                                    'name' => 'homework_id',
                                    'value'=>'$data->homework->title."( ".$data->homework->course0->subject0->subject_name." )"',
                 ),
                                    
		
		array(
                                    'header'=>Yii::t('app','Submission Date'),
                                    'name' => 'date_submission',
                                    'value'=>'$data->dateSubmission',
                 ),
                 
		
		array(
                                    'header'=>Yii::t('app','Comment'),
                                    'name' => 'comment',
                                    'value'=>'$data->comment',
                 ),
                 
		
		array(
                                    'header'=>Yii::t('app','Files'),
                                    'name' => 'attachment_ref',
                                    'type' => 'raw',
                    'value'=>'($data->attachment_ref == null) ? " " : "<a href=\"'.Yii::app()->baseUrl.'/documents/homework_submission/'.$path.'/$data->attachment_ref\" target=\"_blank\"><span class=\"fa fa-paperclip\"></span></a>"',
                 ),
                 
	
		array(
			'class'=>'CButtonColumn',
			
			'template'=>$template1,
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'View',
            'imageUrl'=>false,
           
            'url'=>'Yii::app()->createUrl("/academic/homeworkSubmission/view?id=$data->id&from=stud")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
              ),
        'update'=>array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("/academic/homeworkSubmission/update?id=$data->id&from=stud")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
              ),

              ),
            
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('homework-submission-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
));



?>

                          </td> 
                       </tr>
                
                  
                                           
                      </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
        
              
      </div>

<?php $this->endWidget(); ?>


