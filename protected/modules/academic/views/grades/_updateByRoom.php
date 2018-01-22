
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
					
 
$grades_comment = infoGeneralConfig('grades_comment');	

if($grades_comment==0)
  { $item_array=array(
	 
	array('name'=>'first_name',
                'header'=>Yii::t('app','First Name'),
	        'value'=>'$data->first_name'
			),
	array('name'=>'last_name',
                'header'=>Yii::t('app','Last Name'),
	        'value'=>'$data->last_name'
			),
     array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
           <input name="grades[\'.$data->id.\']" value="\'.$data->grade_value.\'" type=text style="width:100%" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
           
    
		              
		
    );

  }
elseif($grades_comment==1)
{
	$item_array=array(
	 
	array('name'=>'first_name',
                'header'=>Yii::t('app','First Name'),
	        'value'=>'$data->first_name'
			),
	array('name'=>'last_name',
                'header'=>Yii::t('app','Last Name'),
	        'value'=>'$data->last_name'
			),

   array('header' =>Yii::t('app','Grade Value'), 'id'=>'gradeValue', 'value' => '\'
           <input name="grades[\'.$data->id.\']" value="\'.$data->grade_value.\'" type=text style="width:100%" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
           
     array('header' =>Yii::t('app','Comment'), 'id'=>'commentValue', 'value' => '\'
           <input name="comments[\'.$data->id.\']" value="\'.$data->comment.\'" type=text style="width:100%%" />
          
		   <input name="id_stud[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
           \'','type'=>'raw' ),
        
		              
		
    );
}
		 
 
	 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		
 

 
 
 $id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				

 
 
 
                                $this->room_id= Yii::app()->session['Rooms'];
								   
								   $this->course_id= Yii::app()->session['Courses'];
								   
								   $this->evaluation_id= Yii::app()->session['Evaluation'];

					    

 
 ?>
 
<!-- <div class="liste_note">  -->

<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >
			

			
			<!--evaluation-->
			<div class="span2" >
			    <label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php //echo $form->labelEx($model,'Evaluation Period'); ?>
			           <?php 
					
					        $modelEvaluation= new EvaluationByYear();
							    if(isset($this->evaluation_id)&&($this->evaluation_id!=''))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()','options' => array($this->evaluation_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation'); 
						
															
					   ?>
			</div>
       
		
	  
			<!--room-->
			<div class="span2" >
                           
			<?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					     
						    
						  if((Yii::app()->user->profil!='Teacher'))
		                    {												  
							 
							  if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoom($acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoom($acad_sess), array('onchange'=> 'submit()')); 
							          //echo $this->room_id;
									 $this->room_id=0;
							      }
		                    }//fen if((Yii::app()->user->profil!='Teacher'))
		                  else // Yii::app()->user->profil!='Teacher'
		                     {
		                           if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()')); 
							          
									 $this->room_id=0;
							      }	
		                     } // fen Yii::app()->user->profil!='Teacher'  
							      
							      
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
			</div>

			
			<!--Courses-->
			<div class="span2" >
			   
					  
					 <?php $modelCourse = new Courses;
					  ?></label><?php 
					        echo $form->labelEx($modelCourse,Yii::t('app','Course'));
					        
						
						if(isset($this->room_id)&&($this->room_id!='')){
						   	   
					 if((Yii::app()->user->profil!='Teacher'))
                       {
                       	   if(isset($this->course_id))
						        {   
					               echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByRoom($this->room_id,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id=>array('selected'=>true)) )); 
					             }
							  else
								{ $this->course_id=0;
								    echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByRoom($this->room_id,$acad_sess),array('onchange'=> 'submit()')); 
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
								    echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom(2,588,$acad_sess),array('onchange'=> 'submit()')); 
								}
								
                           }//fen  Yii::app()->user->profil=='Teacher'
						  }
						else
							echo $form->dropDownList($modelCourse,'subject',$this->loadSubject(null,null,$acad_sess),array('onchange'=> 'submit()'));
						 
						echo $form->error($modelCourse,'subject'); 
						
					
					  ?>
					  
			   </div>
  </div>
						
						
<br/><br/><br/>

  <div >
											

			<?php 	
			        $weight = ' ';
                     
                     $result = Courses::model()->getWeight($this->course_id);
                    $result =$result->getData();
                    foreach($result as $r)
                      $weight = $r->weight;
                     
                      
                      
				//error message 
      
        if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_UpdateValidate=true;
        
        if(isset($_GET['ok'])&&($_GET['ok']=='yes'))
           $this->success_=1;
        
        if(isset($_GET['greater'])&&($_GET['greater']==1)) 
           $this->message_GradeHigherWeight=true;
           			
  			
	
	 $dataProvider=Grades::model()->searchByRoom($this->course_id,$this->evaluation_id);
	 
	      if(Yii::app()->user->profil=='Teacher')
	        {/* *///for teacher user
		     if($dataProvider->getData()!=null)
		      { $result = $dataProvider->getData(); 
		      	foreach($result as $g)
		          {
					if($g->validate==1)
					  {
				        $this->message_UpdateValidate1=true;
				       
											       	     
					   }
				  }
				 
	        }
	        }				                     
                  		
	        	if((($this->message_UpdateValidate)||($this->message_UpdateValidate1)||($this->message_UpdatePublish)||($this->success_==1)||($this->message_GradeHigherWeight))&&($dataProvider->getData()!=null))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				      	
				      				      
			       }			      
				 elseif($this->message_noGrades)	 	
				   	{
				   		echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				      
				   	  }
				    elseif($dataProvider->getData()!=null) 	
				   	{
				   		echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				            
				   	  }
				   	else
				   	  { 
				   	  	 echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-15px; ';//-20px; ';
				      echo '">';
				   	  	
				   	  	}
				  
				    echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
				  
				  if($this->message_noGrades)
				     { echo '<span style="color:red;" >'.Yii::t('app','No Grades to be updated.').'</span><br/>';
				     $this->message_noGrades=false;
				     }
				     
				     
				  					     	
				  if($this->message_UpdateValidate)
				     { echo '<span style="color:red;" >'.Yii::t('app','Validated Grades can\'t be updated.<br/>').'</span><br/>';
				     $this->message_UpdateValidate=false;
				     }
				     
				   if($this->message_UpdateValidate1)
				     { echo '<span style="color:red;" >'.Yii::t('app','At least one validated grade, please proceed update operation another way.').'</span><br/>';
				        
				     }
				     
				   
				   if($this->message_UpdatePublish)
				     { echo '<span style="color:red;" >'.Yii::t('app','Published Grades can\'t be updated.<br/>').'</span><br/>';
				     $this->message_UpdatePublish=false;
				     }
				     
					if($this->success_==1)
				       {   echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span><br/>';
				            $this->success_=0;
				       }
					  
				   
				   if($this->message_GradeHigherWeight)
					 {
						    echo '<span style="color:red;" >'.Yii::t('app','Grades GREATER than COURSE WEIGHT are ignored.').'</span><br/>';
					        
						   	$this->message_GradeHigherWeight=false;					
		              }


                 
					
					   echo '<span style="color:blue;" ><b>'.Yii::t('app','- COURSE WEIGHT : ').$weight.' - </b></span>';
					   
					 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';
           
           

	  
			
			if($this->room_id!=0)
				{  $room=$this->getRoom($this->room_id);
				    
				}
					   
				      
		     		 
			 
	$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'grades-grid',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' => 2,
	
    'columns'=>$item_array,
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
	           	if(!$this->message_UpdateValidate1)
	           	 { if(!isAchiveMode($acad_sess))
                       echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                   echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
	             
	               //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

	           	 }
	           	 
	           }
	           
	           
	                                                     

	    ?>
    </div>

 </form>
</div  >


            
         </div>
      </div>
            
