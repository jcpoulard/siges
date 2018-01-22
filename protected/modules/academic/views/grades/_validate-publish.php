
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
					
 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 
 
  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
    if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }


      

   $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                          $group_name=$group->group_name;
 
 ?>
 
<div class="b_mail">

<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >
			

			<!--room-->
			<div class="span2" >
                           
			<?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					        if(isset($_GET['room']))
							      $this->room_id=$_GET['room'];
							if(isset($_GET['course']))
							      $this->course_id=$_GET['course'];
							if(isset($_GET['eval']))
							      $this->evaluation_id=$_GET['eval'];
						    
							  
							  if(isset($this->room_id))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoom($acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoom($acad_sess), array('onchange'=> 'submit()')); 
							         
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
			</div>
      
      	  
			<!--evaluation-->
			<div class="span2"  >
			    <label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
			           <?php 
					
					        $modelEvaluation= new EvaluationByYear();
							    if(isset($this->evaluation_id))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()','options' => array($this->evaluation_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation'); 
						
															
					   ?>
			</div>
			<!--Courses-->
			<div class="span2" >
			  <label for="Courses"><?php echo Yii::t('app','Course');  ?></label>
					 <?php 
					        
						$modelCourse = new Courses;
						if(isset($this->room_id)&&($this->room_id!=''))
						 {
						 	if(isset($this->course_id))
						        {   
					              if((Yii::app()->user->fullname!='Admin Super')&&($group_name!='Developer'))
					                { echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByRoomToValidateGrades($this->room_id,$this->evaluation_id,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) ));
					                }
					              else
					                {
					                	echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByRoomToValidateGrades($this->room_id,$this->evaluation_id,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) ));
					                	}
					                	 
					             }
							  else
								{ $this->course_id=0;
								   if((Yii::app()->user->fullname!='Admin Super')&&($group_name!='Developer'))
					                {  echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByRoomToValidateGrades($this->room_id,$this->evaluation_id,$acad_sess), array('onchange'=> 'submit()')); 
					                
					                }
					              else
					                {
					                	echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByRoomToValidateGrades($this->room_id,$this->evaluation_id,$acad_sess), array('onchange'=> 'submit()')); 
					                  }
								}
						  }
						else
							echo $form->dropDownList($modelCourse,'subject',$this->loadSubject(null,null,$acad_sess), array('onchange'=> 'submit()'));
						 
						echo $form->error($modelCourse,'subject'); 
						
					
					  ?>
			   </div>
		
													   
    </div>
			          
			          
						
<br/><br/><br/>

  <div >
												

			<?php 	
					 
                    		//error message 
	        	if(($this->messageNoCheck)||($this->message_validate)||($this->success))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-105px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }			      
				 elseif($this->message_already_validate)	 	
				   	{
				   		echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ';//-20px; ';
				      echo '">';
				      
				           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				            
				   	  }
				   	elseif($this->message_course_already_validate)	 	
				   	{
				   		echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ';//-20px; ';
				      echo '">';
				      
				           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				           
				   	  }  
				   	 
				      
				  
					     	
				  if($this->message_validate)
				     { echo '<span style="color:red;" >'.Yii::t('app','Grades must be validated to publish.<br/>').'</span>';
				     $this->message_validate=false;
				     }
				     
				  if($this->message_already_validate)
				    {  echo '<span style="color:red;" >'.Yii::t('app','Grades are already validated and published.<br/>').'</span>';
				       $this->message_already_validate=false;
				    }
				 
				 if($this->message_course_already_validate)
				    {  echo '<span style="color:red;" >'.Yii::t('app','All courses already have validated and published grades.<br/>').'</span>';
				       $this->message_course_already_validate=false;
				    }

				 if($this->messageNoCheck)
					 {
						     
							echo '<span style="color:red;" >'.Yii::t('app','You must check grades to validate/publish.<br/>').'</span>';
					        
						   	$this->messageNoCheck=false;					
		              }
				   
				   
					if($this->success)
				       {   echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span>'.'<br/>';
				            $this->success=false;
				       }
					  
				   
			      
					
					 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';
			                 
           
	       	  
		     		  
		     		  
	
			if($this->room_id!=0)
				{  $room=$this->getRoom($this->room_id);
				    
				}
					   
				      
		     		  $dataProvider=Grades::model()->searchToValidate($condition,$this->course_id,$this->evaluation_id);	     		  
		     		  
		     		  
			 
	$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grades-grid',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>true,
	'selectableRows' => 2,
	
    'columns'=>array(
	  
	array('header' =>Yii::t('app','Student Name'),
	          'name'=>Yii::t('app','student_name'),
	        'value'=>'$data->first_name." ".$data->last_name'
			),
	array('header' =>Yii::t('app','Grade Value'),
	         'name'=>'grade',
	        'value'=>'$data->grade_value'
			),
	
	array('header' =>Yii::t('app','Weight'),
	         'name'=>'weight',
	        'value'=>'$data->weight'
			),
	array('header' =>Yii::t('app','Validate'),
	         'name'=>'validate',
	        'value'=>'$data->validateGrade'
			),
			
	array('header' =>Yii::t('app','Publish'),
	         'name'=>'publish',
	        'value'=>'$data->publishGrade'
			),
	
	
   
       array(             'class'=>'CCheckBoxColumn',   
                           'id'=>'chk',
                 ),           
		
    ),
));
				
				
				

			 ?>
      <?php echo $form->error($model,'grade_value'); ?>

  	</div> 
  	

<div  id="resp_form_siges">

        <form  id="resp_form">  
 	

<div class="col-submit">
	    <?php $content=$dataProvider->getData();
		      if((isset($content))&&($content!=null))
	             {  
	             	if(!isAchiveMode($acad_sess))
                      { 
	        	         echo CHtml::submitButton(Yii::t('app', 'Validate & Publish'),array('name'=>'validate_publish','class'=>'btn btn-warning'));
		                 echo CHtml::submitButton(Yii::t('app', 'Validate'),array('name'=>'validate','class'=>'btn btn-warning')); 
		                echo CHtml::submitButton(Yii::t('app', 'Publish'),array('name'=>'publish','class'=>'btn btn-warning'));
                       }
	                   echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
	                   
	                  //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

	             } 
			 
	    ?>
 </div>

 </form>
</div  >


            
         </div>
      </div>
            
</div>