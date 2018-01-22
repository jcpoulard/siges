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
			<!--Shift(vacation)-->
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
						
					}
					  ?>
				</div>
			 
		    <!--section(liee au Shift choisi)-->
			<div class="left" style="margin-left:10px;">
			<label for="Sections"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Section'); 
					?></label><?php 
					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelSection = new Sections;
							    if(isset($this->section_id))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('options' => array($this->section_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { $this->idLevel=0;
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
						           }					      
						  
						echo $form->error($modelSection,'section_name'); 
						
					}
											
					   ?>
				</div>
			
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
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()' )); 
					             }
						echo $form->error($modelLevelPerson,'level'); 
						
					} 
					  ?>
				</div>
			
			<!--room / title-->
			<div class="left" style="margin-left:10px;">
			     <label for="Titles"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','Room'); 
					//else echo 'Titles'; ?></label><?php 
					
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1))//for students
					{ 
						$modelRoom = new RoomHasPerson;
						    
							  
							  if(isset($this->room_id))
							   {
						          echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()')); 
						echo $form->error($modelRoom,'room'); 
						
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
			 $dataProvider_s= RoomHasPerson::model()->searchTotalStudentsBy($this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad);
				  if(isset($dataProvider_s))														  
					{ $person_s=$dataProvider_s->getData();
																 								   
						foreach($person_s as $stud)
						  { 
							$this->tot_stud_s += $stud->total_stud;
					      }
						  
					 }
			 //total by gender
			 $dataProvider_s1= RoomHasPerson::model()->searchTotalGenderBy($this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad);
			 
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
	    
			
			 
		if((isset($this->idShift))&&($this->idShift!=null)&&(isset($this->section_id))&&($this->section_id!=null)&&(isset($this->idLevel))&&($this->idLevel!=null)&&(isset($this->room_id))&&($this->room_id!=null))
		{    
		   
	           if($this->room_id!=0)
				{  $room=$this->getRoom($this->room_id);
				    $level=$this->getLevel($this->idLevel);
					$section=$this->getSection($this->section_id);
					$shift=$this->getShift($this->idShift);
				}
					  
		   $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
		         $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'persons-grid',
				'showTableOnEmpty'=>'true',
				'dataProvider'=>$model->searchStudents($this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad),
				
				'columns'=>array(
					//'id',
					'first_name',
					'last_name',
					array(
                                            'name'=>'gender',
                                            'value'=>'$data->genders1',
                                            ),
					
					'id_number',
						

					array(
						'class'=>'CButtonColumn',
						
						'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})", 
                    )),
					'template'=>'{view}{update}{delete}',
					   'buttons'=>array (
				
						 'update'=> array(
							'label'=>'Update',
							
							'url'=>'Yii::app()->createUrl("persons/update?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-edit' ),
						),
						'view'=>array(
							'label'=>'View',
							
							'url'=>'Yii::app()->createUrl("persons/viewForReport?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-search' ),
						),
						
					),
	
					),
				),
			));
			$this->renderExportGridButton($gridWidget, Yii::t('app','Export to CSV'),array('class'=>'btn-info'));
		}
		elseif((isset($this->idShift))&&($this->idShift!=null)&&(isset($this->section_id))&&($this->section_id!=null)&&(isset($this->idLevel))&&($this->idLevel!=null))
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
				'dataProvider'=>$model->searchStudents($this->idShift,$this->section_id,$this->idLevel,null,$acad),
				
				'columns'=>array(
					
					'first_name',
					'last_name',
					array(
                                            'name'=>'gender',
                                            'value'=>'$data->genders1',
                                            ),
					
					'id_number',
						

					array(
						'class'=>'CButtonColumn',
					    'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					    'template'=>'{view}{update}',
					   'buttons'=>array (
				
						 'update'=> array(
							'label'=>'Update',
							
							'url'=>'Yii::app()->createUrl("persons/update?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-edit' ),
						),
						'view'=>array(
							'label'=>'View',
							
							'url'=>'Yii::app()->createUrl("persons/viewForReport?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-search' ),
						),
						
					),
					),
				),
			));
			$this->renderExportGridButton($gridWidget, Yii::t('app','Export to CSV'),array('class'=>'btn-info'));
		}
		elseif((isset($this->idShift))&&($this->idShift!=null)&&(isset($this->section_id))&&($this->section_id!=null))
		{  
		   
	          $shift=null;
			  $section=null;
	           if($this->section_id!=0)
				 {   $section=$this->getSection($this->section_id);
					 $shift=$this->getShift($this->idShift);
			     }
					   
					$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before   
	            $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'persons-grid',
				'showTableOnEmpty'=>'true',
				'dataProvider'=>$model->searchStudents($this->idShift,$this->section_id,null,null,$acad),
				
				'columns'=>array(
					
					'first_name',
					'last_name',
					array(
                                            'name'=>'gender',
                                            'value'=>'$data->genders1',
                                            ),
					
					'id_number',
						

					array(
						'class'=>'CButtonColumn',
						'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                           )),
						   
						 'template'=>'{view}{update}',
					   'buttons'=>array (
				
						 'update'=> array(
							'label'=>'Update',
							
							'url'=>'Yii::app()->createUrl("persons/update?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-edit' ),
						),
						'view'=>array(
							'label'=>'View',
							
							'url'=>'Yii::app()->createUrl("persons/viewForReport?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-search' ),
						),
						
					),
					
					),
				),
			));
			$this->renderExportGridButton($gridWidget, Yii::t('app','Export to CSV'),array('class'=>'btn-info'));
		}
		elseif((isset($this->idShift))&&($this->idShift!=null))
		{      
	       	  $shift=null;
			  if($this->idShift!=0)
				$shift=$this->getShift($this->idShift);
					
					//echo $shift;
					   $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before   
				$gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'persons-grid',
				'showTableOnEmpty'=>'true',
				'dataProvider'=>$model->searchStudents($this->idShift,null,null,null,$acad),
				
				'columns'=>array(
					
					'first_name',
					'last_name',
					array(
                                            'name'=>'gender',
                                             'value'=>'$data->genders1',
                                             ),
                                   
					
					'id_number',
						

					array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                          )),
						 
						 'template'=>'{view}{update}',
					   'buttons'=>array (
				
						 'update'=> array(
							'label'=>'Update',
							
							'url'=>'Yii::app()->createUrl("persons/update?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-edit' ),
						),
						'view'=>array(
							'label'=>'View',
							
							'url'=>'Yii::app()->createUrl("persons/viewForReport?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-search' ),
						),
						
					),
					),
				),
			));
			$this->renderExportGridButton($gridWidget, Yii::t('app','Export to CSV'),array('class'=>'btn-info'));
		}
		else
		{      	$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before   
		       $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'persons-grid',
				
				'showTableOnEmpty'=>'true',
				'dataProvider'=>$model->searchStudents(null,null,null,null,$acad),
				
				'columns'=>array(
					
					'first_name',
					'last_name',
					array(
                                            'name'=>'gender',
                                             'value'=>'$data->genders1',
                                             ),
                                
					
					'id_number',
						

					array(
						'class'=>'CButtonColumn',
						'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                          )),
						 
						 'template'=>'{view}{update}',
					   'buttons'=>array (
				
						 'update'=> array(
							'label'=>'Update',
							
							'url'=>'Yii::app()->createUrl("persons/update?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-edit' ),
						),
						'view'=>array(
							'label'=>'View',
							
							'url'=>'Yii::app()->createUrl("persons/viewForReport?id=$data->id&pg=l&isstud=1&from=stud")',
							'options'=>array( 'class'=>'icon-search' ),
						),
						
					),
					),
				),
			));
			
		}
			
			
			
			
			
			
			    
				
			     ?>

  </div>

  
 
  
  
 </div>