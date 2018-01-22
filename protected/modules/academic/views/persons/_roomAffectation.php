
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

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
 
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


?>


<!-- <div class="principal">  -->

         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                      
                        <tr>
                          <td colspan="4" style="background-color:#EFF3F8;border: none;">
<div style="padding:0px;">			
					
			<!--level-->
			<div class="left" style="margin-left:10px;  margin-right:20px;">
	
					 <?php 
					 
					 		           if($this->sort_by_level==0)
					                   $disable_sortting='disabled';
					                 elseif($this->sort_by_level==1)
					                   $disable_sortting='';
					 
					 
					 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelLevelPerson = new LevelHasPerson;
						
						
							if(isset($this->idLevel))
								    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevel(), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', 'disabled'=>$disable_sortting )); 
								 else
									{ $this->idLevel=0;
									  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevel(), array('onchange'=> 'submit()', 'disabled'=>$disable_sortting ));
						             }
						             
					    
						echo $form->error($modelLevelPerson,'level'); 
						
					} 
					  ?>
				</div>

			
</div>
			
	      
	                 <?php   echo $form->label($model,'sort_by_level'); 
		                              if($this->sort_by_level==1)
				                          { echo $form->checkBox($model,'sort_by_level',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
				                           }
						                 else
							               echo $form->checkBox($model,'sort_by_level',array('onchange'=> 'submit()'));
	                   ?>
	                   </td>
	       
					       
					    </tr>
					    
					    <tr>
					       <td colspan="4">

	<?php 
        
  	 //error message 
	        	if(($this->messageERROR!=0)||($this->messageSUCCESS)||($this->messageNoStud))
			      { echo '<br/><div class="" style=" padding-left:0px;margin-left:274px; margin-bottom:-52px; ';//-20px; ';
				      echo '">';
				      				      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			       
			       }			      
				 					     	
				   
				   if($this->messageNoStud)
				     {  echo '<span style="color:red;" >'.Yii::t('app','All students in this level are already enrolled a room.').'</span>'.'<br/>';
						          $this->messageERROR=0;
									
									
					   echo'</td>
						    </tr>
							</table>';
						
	                      echo '</div>';
				       }

				   
				    if($this->messageERROR)
				     { switch($this->messageERROR)
				        { 
						  case 1: echo '<span style="color:red;" >'.Yii::t('app','Please select a ROOM.').'</span>'.'<br/>';
						          $this->messageERROR=0;
									break;
									
						  case 2: echo '<span style="color:red;" >'.Yii::t('app','Please check which students to affect to this room.').'</span>'.'<br/>';
						          $this->messageERROR=0;
									break;
									
						  }
						  
							  echo'</td>
						    </tr>
							</table>';
						
	                      echo '</div>';
				       }
						
				   
				   if($this->messageSUCCESS)
				        { echo '<span style="color:green;" >'.Yii::t('app','Operation SUCCESS.').'</span>'.'<br/>';
						   $this->messageSUCCESS=false;
						 
							    echo'</td>
						    </tr>
							</table>';
						
	                      echo '</div>';
						 }
				     		

?>

  <div class="list_secondaire">
      
      
      	<?php 
         
			       
if(isset($_GET['isstud']))
   { if($_GET['isstud']==1) 
		   { 
		   	 $this->female_s =0;
		   $this->male_s =0;
		   $this->tot_stud_s =0;
		     $dataProvider_s=null;
		    $dataProvider_s1=null;
		    
		    if($this->sort_by_level==1)
		      { //total students
			     $dataProvider_s= LevelHasPerson::model()->searchTotalStudentsBy($this->idLevel,$acad_sess);
		      	 //total by gender
			     $dataProvider_s1= LevelHasPerson::model()->searchTotalGenderBy($this->idLevel,$acad_sess);
		     
		         if((isset($this->idLevel))&&($this->idLevel!=null))
		          $dataProvider=$model->searchStudentsByLevel($this->idLevel,$acad_sess);
		         else
		           $dataProvider=$model->searchStudentsByLevel(0,$acad_sess);
		     
		     
		      	}
		     elseif($this->sort_by_level==0)
		      { 
		      	   //total students
			     $dataProvider_s= Persons::model()->searchTotalStudentsToAffectRoom($acad_sess);
		      	 //total by gender
			     $dataProvider_s1= Persons::model()->searchTotalGenderToAffectRoom($acad_sess);
		     
		         
		          $dataProvider=Persons::model()->searchStudentsToAffectRoom($acad_sess);
		     
		   

		      	}
		      	
		      	
			 //total students
				  if(isset($dataProvider_s))														  
					{ $person_s=$dataProvider_s->getData();
																 								   
						foreach($person_s as $stud)
						  { 
							$this->tot_stud_s += $stud->total_stud;
					      }
						  
					 }
			 //total by gender
			 
				  if(isset($dataProvider_s1))														  
					{ $person_s1=$dataProvider_s1->getData();
																		
						foreach($person_s1 as $stud1)
						  {  
							if($stud1->gender==0)
							  { 
							  $this->male_s += $stud1->total_gender;
							  }
							elseif($stud1->gender==1)
							   $this->female_s += $stud1->total_gender;
					      }
						  
					 }
					 
					 
echo '<div class="all_gender">
<div class="total_student">'. Yii::t('app','Total Students').'<div>'.$this->tot_stud_s.'</div></div>

<div class="gender">'.Yii::t('app','').'<div class="female">'.Yii::t('app','Female').'<br/>'.$this->female_s.'</div><div class="male">'.Yii::t('app','Male').'<br/>'.$this->male_s.'</div></div>

</div>';
    }
  }	

    	   
			


?>
	
											
<div class="clear"></div>  
<div style="float:left; margin-top:-20px; width:100%;">
			<?php 		
	    
			
			 
		if((isset($this->idLevel))&&($this->idLevel!=null))
		{    
		   
	           if($this->idLevel!=0)
				{  
				    $level=$this->getLevel($this->idLevel);
					$section=$this->getSection($this->section_id);
					$shift=$this->getShift($this->idShift);
				}
					   
		   $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
		        $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'persons-grid',
				'summaryText'=>'',//
				'showTableOnEmpty'=>'true',
				'selectableRows' => 2,
				'dataProvider'=>$dataProvider,
				
				'columns'=>array(
					
					'first_name',
					'last_name',
					array(
                                            'name'=>'gender',
                                            'value'=>'$data->genders1',
                                            ),
					
					'id_number',
					 array(
                                        'header'=>Yii::t('app','Level Name'),
                                        'name'=>'level_name',
                                        'value'=>'$data->getLevel($data->id,'.$acad_sess.')',
                                        'htmlOptions'=>array('width'=>'200px'),
						),
						
						

					array(
						'class'=>'CCheckBoxColumn',   
                           'id'=>'chk',
					   
					),
				),
			));
			
		  }
		else
		  {
		  	$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
		        $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'persons-grid',
				'summaryText'=>'',//
				'showTableOnEmpty'=>'true',
				'selectableRows' => 2,
				'dataProvider'=>$dataProvider,
				
				'columns'=>array(
					
					'first_name',
					'last_name',
					array(
                                            'name'=>'gender',
                                            'value'=>'$data->genders1',
                                            ),
					
					'id_number',
					 array(
                                        'header'=>Yii::t('app','Level Name'),
                                        'name'=>'level_name',
                                        'value'=>'$data->getLevel($data->id,'.$acad_sess.')',
                                        'htmlOptions'=>array('width'=>'200px'),
						),	
						
					'comment',
						

					array(
						'class'=>'CCheckBoxColumn',   
                           'id'=>'chk',
					   
					),
				),
			));

		  	
		  	}
		  
			     ?>
	</div>		     
</div>
 
                                 </td>
                              </tr>
                             
                              <tr>
                                 <td colspan="2">
  


<?php 

if($this->sort_by_level==1)
 {
   if($this->tot_stud_s!=0)
        {
?>
  <div class="" style="margin-left:10px;margin-bottom:10px;"><?php echo Yii::t('app','AFFECT TO'); ?></div>
  
	<!--affectation Shift(vacation)-->
        <div class="left"  style="margin-left:10px;margin-bottom:10px; float:left;">
		
			<label for="Shifts"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Shift'); 
					 ?>
				</label>
					 <?php 
					 
					 					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
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
				   		
				   		
					 
						
						  if(isset($this->idShift)&&($this->idShift!=""))
						        {   
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()','options' => array($this->idShift=>array('selected'=>true)) )); 
					             }
							  else
								{ 
								    if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								              $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()')); 
								}
							
						echo $form->error($modelShift,'shift_name'); 
						
					}
					  ?>
				</div>
			 
		    <!--affectation section-->
			<div class="left" style="margin-left:10px; margin-bottom:10px;">
			<label for="Sections"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Section'); 
					?></label><?php 
					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelSection = new Sections;
							   
						if(($this->sort_by_level==1))
		                  {	 
		                  	     if(isset($this->section_id))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByLevel($this->idLevel), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByLevel($this->idLevel), array('onchange'=> 'submit()')); 
						           }	
		                  	
		                    }
		                elseif(($this->sort_by_level==0))
		                   {  
							    if(isset($this->section_id))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSection(), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelSection,'section_name',$this->loadSection(), array('onchange'=> 'submit()')); 
						           }	
						           
		                      }  				      
						  
						echo $form->error($modelSection,'section_name'); 
						
					}
											
					   ?>
				</div>
		
  <?php    
		if(($this->sort_by_level==0))
		  {       
		    echo '    <!--affectation level-->
			   <div class="left" style="margin-left:10px; margin-bottom:10px;">
			     <label for="Levels"> ';
			
			 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Level'); 
			echo '</label>'; 
					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						 $modelLevelPerson1 = new LevelHasPerson;
						
						
							if(isset($this->idLevel_sort_zero))
								    echo $form->dropDownList($modelLevelPerson1,'level',$this->loadLevelBySection($this->section_id), array('options' => array($this->idLevel_sort_zero=>array('selected'=>true)),'onchange'=> 'submit()', )); 
								 else
									{ 
									  echo $form->dropDownList($modelLevelPerson1,'level',$this->loadLevelBySection($this->section_id), array('onchange'=> 'submit()', ));
						             } 				      
						  
						echo $form->error($modelLevelPerson1,'level'); 
						
					}
											
					  
			echo '</div>';
		      
		  }  
		       
		           
   ?>
		
 <!--affectation room -->
			<div class="left" style="margin-left:10px; margin-bottom:10px;">
			     <label for="Rooms"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Room'); 
					 ?>
</label><?php 
					
					 
						$modelRoom = new Rooms; 
						    
					if(($this->sort_by_level==1))
		              {		  
							  if(isset($this->room_id))
							   {
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel)); 
						
						
		                }
		             elseif(($this->sort_by_level==0))
		                {
		                	 if(isset($this->room_id))
							   {
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel_sort_zero), array('options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel_sort_zero)); 
		                 
		                 }
		                
		                
						echo $form->error($modelRoom,'room_name'); 
						
					
									   
					   ?>
				</div>
				
        
			
				<div class="left" style="margin: 15px 10px 10px"> 
    <label> <?php    ?> </label> 

 <div class="row buttons" style="">  
	<?php  if(!isAchiveMode($acad_sess))
              echo '<div class="left" style="margin-left:5px;">'.CHtml::submitButton(Yii::t('app', 'Execute'),array('name'=>'execute','class'=>'btn btn-warning'));
	        
	       echo '</div><div class="left" style="margin-left:5px;">'.CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                             
                                          


	?>
    </div>  
                           

</div>
				
				                                      
	
	                             </td>
                                                      </tr>
  <?php 
   }//end if
   
 }
?>
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
               
<!-- /.box-body -->
                
              </div>
