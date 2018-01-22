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




$acad=Yii::app()->session['currentId_academic_year']; 



?>


<div class="principal">

<div style="padding:0px;">			
					
			<!--level-->
			<div class="left" style="margin-left:10px;">
			<label for="Levels"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Level'); 
					 ?>
				</label>
					 <?php 
					 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelLevelPerson = new LevelHasPerson;
						if(isset($this->idLevel))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevel(), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevel(), array('onchange'=> 'submit()' )); 
					             }
						echo $form->error($modelLevelPerson,'level'); 
						
					} 
					  ?>
				</div>
				
				
<div style="color:red; margin-left:150px;">
				<?php switch($this->messageERROR)
				        { case 0: echo ''; // initial state
						
									break;
									
						  case 1: echo Yii::t('app','Please select a ROOM.');
						
									break;
									
						  case 2: echo Yii::t('app','Please check which students to affect to this room.');
						
									break;
									
						}
				?>
				</div>
<div style="color:green; margin-left:150px;">
				<?php if($this->messageSUCCESS)
				        { echo Yii::t('app','Operation SUCCESS.');
						   $this->messageSUCCESS=false;
						 }
				?>
				</div>
			
			
</div>
			
			
  <div class="list_secondaire">
      <div class="clear"></div>
      
      <?php 
	  
	
	  
if(isset($_GET['isstud']))
   { if($_GET['isstud']==1) 
		   { 
		   	 $this->female_s =0;
		   $this->male_s =0;
		   $this->tot_stud_s =0;
		   
			 //total students
			 $dataProvider_s= LevelHasPerson::model()->searchTotalStudentsBy($this->idLevel,$acad);
				  if(isset($dataProvider_s))														  
					{ $person_s=$dataProvider_s->getData();
																 								   
						foreach($person_s as $stud)
						  { 
							$this->tot_stud_s += $stud->total_stud;
					      }
						  
					 }
			 //total by gender
			 $dataProvider_s1= LevelHasPerson::model()->searchTotalGenderBy($this->idLevel,$acad);
			 
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
				'showTableOnEmpty'=>'true',
				'selectableRows' => 2,
				'dataProvider'=>$model->searchStudentsByLevel($this->idLevel,$acad),
				
				'columns'=>array(
					
					'first_name',
					'last_name',
					array(
                                            'name'=>'gender',
                                            'value'=>'$data->genders1',
                                            ),
					
					'id_number',
						

					array(
						'class'=>'CCheckBoxColumn',   
                           'id'=>'chk',
					   
					),
				),
			));
			
		}
			
			
			
			
			
			    
				
			     ?>

  </div>
  
  
<div style="clear:both"></div>

<?php 
   if($this->tot_stud_s!=0)
        {
?>
  <div class="left" style="margin-left:10px;"><?php echo Yii::t('app','AFFECT TO'); ?></div>
  
	<!--affectation Shift(vacation)-->
        <div class="left">
		
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
			<div class="left" style="margin-left:10px;">
			<label for="Sections"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Section'); 
					?></label><?php 
					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelSection = new Sections;
							    if(isset($this->section_id))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSection(), array('onchange'=> 'submit()','options' => array($this->section_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelSection,'section_name',$this->loadSection(), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelSection,'section_name'); 
						
					}
											
					   ?>
				</div>
				
 <!--affectation room -->
			<div class="left" style="margin-left:10px;">
			     <label for="Rooms"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Room'); 
					//else echo 'Titles'; ?></label><?php 
					
					 
						$modelRoom = new Rooms; 
						    
							  
							  if(isset($this->room_id))
							   {
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel)); 
						echo $form->error($modelRoom,'room_name'); 
						
					
									   
					   ?>
				</div>
	
	<div class="row buttons">
	<?php  echo CHtml::submitButton(Yii::t('app', 'Execute'),array('name'=>'execute'));

	?>
    </div>
  <?php 
   }//end if
?>
  
 </div>