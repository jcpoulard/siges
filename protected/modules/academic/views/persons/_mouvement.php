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

  $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }

      
$content=null;	


?>


<!-- <div class="principal">  -->

         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        

                             
                              <tr>
                                 <td colspan="2" style="background-color:#EFF3F8;border: none; ">
  

  
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
		
    
		       
		        <!--affectation level-->
			   <div class="left" style="margin-left:10px; margin-bottom:10px;">
			     <label for="Levels"> 
			
			 
	<?php
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
											
	 ?>				  
			    </div>
		      
		    
		       
		           
  
					    
				           </td>
                    </tr>
                 <tr>
                     <td colspan="2" style="background-color:#EFF3F8;border: none; ">
  

		
 <!--affectation room -->
			<div class="left" style="margin-left:10px; margin-bottom:10px;">
			     <label for="Rooms_from"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','From room'); 
					//else echo 'Titles'; ?>
</label><?php 
					
					 
						$modelRoom = new Rooms; 
						    
					
		                	 if(isset($this->room_id))
							   {
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel_sort_zero), array('options' => array($this->room_id=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							   else
							      echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel_sort_zero), array('onchange'=> 'submit()' )); 
		                 
		                 		                
		                
						echo $form->error($modelRoom,'room_name'); 
						
					if($this->room_id!=0)
				      {  $dataProvider=Persons::model()->searchStudentsToMove($condition,$this->idShift,$this->section_id,$this->idLevel_sort_zero,$this->room_id,$acad_sess);                  $content = $dataProvider->getData();
				      
				      
				      
				         }
		     
									   
					   ?>
				</div>
				
        
         <!--affectation room -->
			<div class="left" style="margin-left:10px; margin-bottom:10px;">
			     <label for="Rooms_to"> <?php 
					if(((isset($_GET['isstud'])) && ($_GET['isstud']==1))||($model->is_student==1)) echo Yii::t('app','To room'); 
					//else echo 'Titles'; ?>
</label><?php 
					
					 
						$modelRoomTo = new Rooms; 
						  
							  if(isset($this->room_id_to)&&($this->room_id_to!=''))
							   {
						          echo $form->dropDownList($modelRoomTo,'[1]room_name',$this->loadRoom_To($this->room_id,$this->idLevel_sort_zero), array('options' => array($this->room_id_to=>array('selected'=>true)) )); 
					             }
							   else
							      echo $form->dropDownList($modelRoomTo,'[1]room_name',$this->loadRoom_To($this->room_id,$this->idLevel_sort_zero)); 
						
						
		               
		                
						echo $form->error($modelRoomTo,'[1]room_name'); 
						
					
									   
					   ?>
				</div>
				
<?php    
    if($content!=null)
        {
        	
  ?>				
			
				<div class="left" style="margin: 15px 10px 10px"> 
    <label> <?php    ?> </label> 

 <div class="row buttons" style="">  
	<?php if(!isAchiveMode($acad_sess))
	           echo '<div class="left" style="margin-left:5px;">'.CHtml::submitButton(Yii::t('app', 'Execute'),array('name'=>'execute','class'=>'btn btn-warning'));
	        
	       echo '</div><div class="left" style="margin-left:5px;">'.CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              
                                          


	?>
    </div>  
                           

</div>
				
<?php    }

?>				                                      
	
	                           
 					    
				           </td>
                    </tr>
                    
                    
					    <tr>
					       <td colspan="4" style="background-color:#EFF3F8;border: none;">

  <div class="list_secondaire">
      
  	
											
<div class="clear"></div>  
<div style="float:left; margin-top:-20px; width:100%;">
			<?php 		
	    
		
			 
		if((isset($this->room_id))&&($this->room_id!=null))
		{    
		   
	           if($this->room_id!=0)
				{  
				    $level=$this->getLevel($this->idLevel);
					$section=$this->getSection($this->section_id);
					$shift=$this->getShift($this->idShift);
				}
				
  
		    
		// $dataProvider=Persons::model()->searchStudents($condition,$this->idShift,$this->section_id,$this->idLevel_sort_zero,$this->room_id,$acad_sess);
		     
		   

					   
		
		        $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'persons-grid',
				'summaryText'=>'',//
				'showTableOnEmpty'=>'true',
				'selectableRows' => 2,
				'dataProvider'=>$dataProvider,
				
				'columns'=>array(
					
					array(
                                'name' => 'first_name',
                                'type' => 'raw',
                                'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>1,"from"=>"lr_af")))',
                                
                                ),

				
				array(
                                'name' => 'last_name',
                                'type' => 'raw',
                                'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>1,"from"=>"lr_af")))',
                                
                                ),

					array(
                                            'name'=>'gender',
                                            'value'=>'$data->genders1',
                                            ),
					
					'id_number',
					 array(
                                        'header'=>Yii::t('app','Room Name'),
                                        'name'=>'room_name',
                                        'value'=>'$data->getRooms($data->id,'.$acad_sess.')',
                                        'htmlOptions'=>array('width'=>'200px'),
						),	
						

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
                     <td colspan="2" style="background-color:#EFF3F8;border: none; ">
  


<?php 

   if($content!=null)
        {
?>
			
<div  id="resp_form_siges">

        <form  id="resp_form">  
  
<div class="col-submit">
	<?php if(!isAchiveMode($acad))
	           echo CHtml::submitButton(Yii::t('app', 'Execute'),array('name'=>'execute','class'=>'btn btn-warning'));
	        
	       echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              
                                          


	?>
   </div>

 </form>
</div  >

				
				                                      
	
	                           
  <?php 
   }//end if
?>
					    
				           </td>
                    </tr>


                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                
<!-- /.box-body -->
                
              </div>
