
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

      


	 if(isset($_GET['shi'])) $this->idShift=$_GET['shi'];
				  else{$idShift = Yii::app()->session['Shifts'];
				  $this->idShift=$idShift;}
				  
			      if(isset($_GET['sec'])) $this->section_id=$_GET['sec'];
				  else{$section = Yii::app()->session['Sections'];
				  $this->section_id=$section;}
				  
				  if(isset($_GET['lev'])) $this->idLevel=$_GET['lev'];
				  else{$level = Yii::app()->session['LevelHasPerson'];
				  $this->idLevel=$level;}
				  
				  if(!isset($_POST['Rooms']))
	                  if(isset($_GET['roo'])) $this->room_id=$_GET['roo'];
				  
				  
				  				  

?>






         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="4" style="background-color:#EFF3F8;border: none;" >
<div style="padding:0px;">			

		   
			<!--Shift(vacation)-->
        <div class="left" style="margin-left:10px;">
		
			<?php $modelShift = new Shifts;
			echo $form->labelEx($modelShift,Yii::t('app','Shift'));?>
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
				   		
				   		
						
						  if(isset($this->idShift)&&($this->idShift!=''))
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
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad_sess), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  //$this->room_id=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id,$acad_sess), array('onchange'=> 'submit()' )); 
					              
							      }
						echo $form->error($modelLevelPerson,'level'); 
					 
					  ?>
				</div>
			
			<!--room-->
			<div class="left" style="margin-left:10px;">
			     <?php  $modelRoom = new Rooms;
			                     echo $form->labelEx($modelRoom,Yii::t('app','Room')); ?>
			          <?php 
					
					
						    
							  
							  if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()')); 
							          
									 $this->room_id=0;
							      }
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>
				</div>
			
				
</div>

						 </td>
	       
					       
					    </tr>
					    
					    <tr>
					       <td colspan="4" style="background-color:#EFF3F8;border: none;">


  <div class="list_secondaire">
											
   <?php 				  //And you can get values like this:
            
			  
			

		 $dataProvider=Persons::model()->searchStudentsToDisable($condition,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess); 
	     
	     $tmwen=false;
	 
		 if($dataProvider->getItemCount()==0)
			{ 
				 $tmwen=false;
				if(($this->room_id==null)&&($this->idLevel!=null)&&($this->section_id!=null)&&($this->idShift!=null))
			    echo "";//"Just pick an other room or move ....";
			 
		    }
         else
		   {  $this->tot_stud=$dataProvider->getItemCount();
			    $this->noStud=1;
			    $tmwen=true;
			}
            			       Yii::app()->session['tot_stud'] = $this->tot_stud; 
    
        //error message 
	        	if( ($this->message)||($this->success)||(($this->noStud ===0) && ($this->room_id != null)) )		
			      { echo '<div class="" style=" padding-left:0px;margin-right:240px; margin-bottom:-20px; ';//-20px; ';
				      echo '">';
			      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			      }			      
				  
				   	  
				 
					     	
				   if($this->message)
				     echo '<span style="color:red;" >'.Yii::t('app','You must check all students.').'</span>'.'<br/>';
				   
				   if($this->success)
				     echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span>'.'<br/>';
					  
				   if(($this->noStud ===0) && ($this->room_id != null))
				      echo '<span style="color:red;" >'.Yii::t('app','No student in this room.').'</span>'.'<br/>';
				
				if( ($this->message)||($this->success)||(($this->noStud ===0) && ($this->room_id != null)) )		
			      {						   					
					 echo'</td>
					    </tr>
						</table>';
					
                    echo '</div>';
	              }

		     		  
				
						$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'reportCard',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>'true',
	'selectableRows' =>2,
	
    'columns'=>array(
	 
	array('name'=>Yii::t('app','Code student'),
	      'type' => 'raw',
	      'value'=>'CHtml::link($data->id_number,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"ds")))'
	      
	
	     ),
		
	  array('name'=>Yii::t('app','Student name'),
	        'type' => 'raw',
	        'value'=>'CHtml::link($data->first_name." ".$data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"ds")))'
			),
     
       array(             'class'=>'CCheckBoxColumn',   
                           'id'=>'chk',
                 ),           
		
    ),
));
				
				
		
		   
			 ?>

</div>
						 </td>
	       
					       
					    </tr>
					    
					
			              <tr>
					       <td colspan="4" style="background-color:#EFF3F8;border: none;">
		                
	 <?php 
           if(($this->room_id!=null)&&($this->idLevel!=null)&&($this->section_id!=null)&&($this->idShift!=null))		
			      {
				      if($this->noStud===1)
						{              
		                         if(!isset($_GET['id'])){
                                         if(!isAchiveMode($acad_sess))
                                             echo CHtml::submitButton(Yii::t('app', 'Apply'),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                         
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
                                          

                           		
                  
				 
			}
                        }
                        
                        
                                                                  

	?>
	
                          </td>
                           </tr>

 
 
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
         
    