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




<div id="dash">
      
       <?php  $drop=0;
      if(isset($_GET['isstud']))
        { if($_GET['isstud']==1){ $drop=1; echo '<div class="span3"><h2>'.Yii::t('app','Students').'</h2> </div>'; }
			elseif($_GET['isstud']==0){ $drop=2;  echo '<div class="span3"><h2>'.Yii::t('app','Teachers').'</h2> </div>';} 
		}
      else		
	      echo '<div class="span3"><h2>'.Yii::t('app','Employees').'</h2> </div>'; 
		?>
                 
                  <div class="icon-dash">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard
  
                      
                        if(isset($_GET['from'])){
                            
                          if($_GET['from']=='teach'){
                              echo CHtml::link($images, array('persons/listForReport','isstud'=>0,'from'=>'teach'));
                             
                                  
                          }
                          
                          else{
                              if($drop==1)
                                { 
								    if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport','isstud'=>1,'from'=>'stud'));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list','isstud'=>1,'from'=>'stud'));
												
										 }
									   else
										 echo CHtml::link($images,array('persons/listForReport?isstud=1&from=stud'));
						 
								}
                              elseif($_GET['from']=='emp')
                                 echo CHtml::link($images,array('persons/listForReport','from'=>'emp')); 
                      
                                  
                          }
                      }
                      else  //$_GET['from'] not set
                        {
                             if($drop==1)
                                { 
								    if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport','isstud'=>1));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list','isstud'=>1));
												
										 }
									   else
										 echo CHtml::link($images,array('persons/listForReport?isstud=1'));
						 
								}
                              elseif($drop==2)
                                  {
                                  	    if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport','isstud'=>0));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list','isstud'=>0));
												 elseif($_GET['pg']=='ext')
												     echo CHtml::link($images,array('persons/exteachers','isstud'=>0));
												
										 }
									   else
										 echo CHtml::link($images,array('persons/listForReport?isstud=0'));
                                    } 
                                  else 
                                    {  
                                    	if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport' ));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list' ));
												 elseif($_GET['pg']=='la')
												     echo CHtml::link($images,array('persons/listArchive' ));
												
										 }
									   else
										 //if($_GET['from']=='emp')
                                          //echo CHtml::link($images,array('persons/listForReport','from'=>'emp')); 
                                          echo CHtml::link($images,array('persons/listForReport'));
                                     
                                    }

                                
                        }
                       
                     
                   ?>

                  </div>  
                  
                  <div class="icon-dash">

                  <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';


                               // build the link in Yii standard
                    if(isset($_GET['isstud'])) 
                     {  if($_GET['isstud']==1)
                          {       
                             if(isset($_GET['pg']))
								 {  if($_GET['pg']=='lr')
									  echo CHtml::link($images,array('persons/update','id'=>$model->id,'pg'=>'vrlr','isstud'=>1));
									elseif($_GET['pg']=='l')
										   echo CHtml::link($images,array('persons/update','id'=>$model->id,'pg'=>'vrl','isstud'=>1));
								 }
							   else
								 echo CHtml::link($images,array('persons/update','id'=>$model->id,'pg'=>'vr','isstud'=>1)); 
					       }
					    elseif($_GET['isstud']==0)
						       echo CHtml::link($images,array('persons/update','id'=>$model->id,'isstud'=>0,'from'=>'teach','from1'=>'teach_view'));
					   }
				   else      
						    echo CHtml::link($images,array('persons/update','id'=>$model->id,'from1'=>'view')); 
					   

                   ?>

              </div> 
    
                  <div class="icon-dash">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';


                               // build the link in Yii standard
                    if(isset($_GET['isstud'])) 
                     {  if($_GET['isstud']==1)
                           echo CHtml::link($images,array('persons/create?isstud=1')); 
					 
					    elseif($_GET['isstud']==0)
						       echo CHtml::link($images,array('persons/create?isstud=0'));
					   }
				   else      
						    echo CHtml::link($images,array('persons/create')); 
					   

                   ?>

              </div> 

 </div>	
			
<div class="span3"><h2>

<?php 
          echo $model->fullName; ?></h2> </div>

<?php
$this->breadcrumbs=array(
	Yii::t('app','Persons')=>array('index'),
	$model->fullName,
);


?>



<?php 

   echo '<div class="CDetailView_photo" >';
 if((isset($_GET['isstud']))&&($_GET['isstud']==1)) //STUDENTS 
   { $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array(     'header'=>Yii::t('app','Blood Group'),
                    'name'=>Yii::t('app','Blood Group'),
                    'value'=>$model->getBlood_group(),
                ),  
        'birthday',
		'adresse',
		'phone',
		'email',
		'cities0.city_name',
		array(     'header'=>Yii::t('app','Username'),
                    'name'=>Yii::t('app','Username'),
                    'value'=>$model->getUsername($model->id),
                ), 
		'status',
		array(     'header'=>Yii::t('app','Level'),
                    'name'=>Yii::t('app','Level'),
                    'value'=>$model->getLevel($model->id,$acad),
                ), 
       array(     'header'=>Yii::t('app','Room'),
                    'name'=>Yii::t('app','Room'),
                    'value'=>$model->getRooms($model->id,$acad),
                ), 
       
		
			),
		));
    }
 else //EMPLOYEE
   {  $create_moreInfo=false;
   	
   	  $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		array(     'header'=>Yii::t('app','Blood Group'),
                    'name'=>Yii::t('app','Blood Group'),
                    'value'=>$model->getBlood_group(),
                ), 
		'birthday',
		'adresse',
		'phone',
		'email',
		'cities0.city_name',
		array(     'header'=>Yii::t('app','Username'),
                    'name'=>Yii::t('app','Username'),
                    'value'=>$model->getUsername($model->id),
                ), 
		'status',
		array(     'header'=>Yii::t('app','Working department'),
                    'name'=>Yii::t('app','Working department'),//'Working department',
                    'value'=>$model->getWorkingDepartment($model->id,$acad),
                ), 
        array(     'header'=>Yii::t('app','Title'),
                    'name'=>Yii::t('app','Title'),
                    'value'=>$model->getTitles($model->id,$acad),
                ),
                
		
			),
		));
   	
   	}   ?>
   	   <div style="width:40%;padding:10px; background: -webkit-linear-gradient(#E5F1F4 30%, #4c99c5 100%);
												background: -o-linear-gradient(#E5F1F4 30%, #4c99c5 100%);
												background: -moz-linear-gradient(#E5F1F4 30%, #4c99c5 100%); 
												background: -ms-linear-gradient(#E5F1F4 30%, #4c99c5 100%);
												background: linear-gradient(#E5F1F4 30%, #4c99c5 100%);">
			
	        <?php   echo Yii::t('app','Enable or Disable {first} {last}',array('{first}'=>$model->first_name,'{last}'=>$model->last_name));
	                echo '<hr style="width:90%; border:thin solid black;"/>';
	                $form=$this->beginWidget('CActiveForm', array(
								'id'=>'persons-form',
								'enableAjaxValidation'=>true,
								'htmlOptions' => array(
							        'enctype' => 'multipart/form-data',
							      ),
							)); 
					?>
				<div class="checkbox_view" style="margin-left:20px;margin-top:5px;">
				
				   <?php			
						   echo Yii::t('app','Active');
						   
					 if($model->active==0)
						  echo '&nbsp;&nbsp;&nbsp;<input type="checkbox" id="active" name="active" value="1" >';
				     else
				           echo '&nbsp;&nbsp;&nbsp;'.CHtml::checkBox('active',$model);//<input type="checkbox" id="active" name="active" checked="checked" >';
						   
						   echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.CHtml::submitButton(Yii::t('app','Apply'), array('name'=>'apply', ));
						   
						?>
					</div>
				<?php
						   
				   $this->endWidget();
			 ?>
	        
	    </div>
   
   	<?php

			 echo '</div> ';
	          echo '<div class="photo_view" >';
                  if($model->image!=null)
                    
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/photo-Uploads/1/'.$model->image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/photo-Uploads/1/no_pic.png');
	                 
			echo '</div>
			';
 ?>

	
<?php

echo '<div class="CDetailView_photo" >';

?>
   <!-- <div style="clear:both;"></div>  -->
			      <br /><div style="margin-bottom:-47px;" ><?php echo "<h4><br/><b>".Yii::t('app','Contact info')."  </b></h4> "; ?><br/></div>        
			           
			<?php          
			
			$gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'contact-info-grid',
				'dataProvider'=> ContactInfo::model()->searchByPersonId($_GET['id']),
				
			        'emptyText'=>Yii::t('app','No contact found'),
			        'summaryText'=>Yii::t('app','{nameStudent} has {count} contact',array('{nameStudent}'=>$model->fullName)),
			        
				'columns'=>array(
					'contact_name',
				
					
			                'phone',
			               
				 array( 'class'=>'CButtonColumn',
			                    'template'=>'{view}{update}{delete}', 
			                 'buttons'=>array (
			        'update'=> array(
			            'label'=>'Update',
			            
			            'url'=>'Yii::app()->createUrl("/academic/contactinfo/update?id=$data->id&pers='.$_GET['id'].'&from=stud&isstud=1&pg=lr")',
			            'options'=>array( 'class'=>'icon-edit' ),
			        ),
			         'view'=>array(
			            'label'=>'View',
			           
			            'url'=>'Yii::app()->createUrl("/academic/contactinfo/view?id=$data->id&pers='.$_GET['id'].'&from=stud&isstud=1&pg=lr")',
			            'options'=>array( 'class'=>'icon-search' ),
			        ),
			        'delete'=>array(
			            'label'=>'Delete',
			           
			            'url'=>'Yii::app()->createUrl("/academic/contactinfo/delete?id=$data->id&pers='.$_GET['id'].'&from1=stud&isstud=1&pg=lr")',
			            'options'=>array( 'class'=>'icon-delete' ),
			        )),
			                 ),
			            )
			            ));
          ?>

 <div style="clear:both;"></div>

<?php
if(isset($_GET['isstud']))
   { if($_GET['isstud']==1) //STUDENTS
	    { ?>
	  	 <br /><div style="margin-bottom:-47px" ><?php echo "<h4><br/><b>".Yii::t('app','Grade')."  </b></h4> "; ?><br /></div>        
        
         
<?php 
 
       //$template='';
		   	  
		   	 if(isset($_GET['from']))
		   	   { $columns=array(
					
					array('header'=>Yii::t('app','Course name'),'name'=>'course_name','value'=>'$data->course0->courseName'),
					array('header'=>Yii::t('app','Exam Name'),'name'=>'examName','value'=>'$data->evaluation0->examName'),
			              
			                'grade_value',
			                'course0.weight',
					
			             array( 'class'=>'CButtonColumn',
			                    'template'=>'{view}{update}', 
			                 'buttons'=>array (
			        'update'=> array(
			            'label'=>'Update',
			            
			            'url'=>'Yii::app()->createUrl("/academic/grades/update?id=$data->id&from1=stud&isstud=1&pg=lr")',
			            'options'=>array( 'class'=>'icon-edit' ),
			        ),
			         'view'=>array(
			            'label'=>'View',
			           
			            'url'=>'Yii::app()->createUrl("/academic/grades/view?id=$data->id&from1=stud&isstud=1&pg=lr")',
			            'options'=>array( 'class'=>'icon-search' ),
			        )),
			                 ),
			            );
		   	      
		   	   }
		   	 else
		   	   { $columns=array(
		
					array('header'=>Yii::t('app','Course name'),'name'=>'course_name','value'=>'$data->course0->courseName'),
					array('header'=>Yii::t('app','Exam Name'),'name'=>'examName','value'=>'$data->evaluation0->examName'),
			              
			                'grade_value',
			                'course0.weight',
					
			            
			            );
		   	     
		   	   }
    
    
			    $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'grades-grid',
				'dataProvider'=>  Grades::model()->searchByStudentId($_GET['id'],$acad),
			        'emptyText'=>Yii::t('app','No grade found'),
			        'summaryText'=>Yii::t('app','{nameStudent} has {count} grades for this year',array('{nameStudent}'=>$model->fullName)),
				
				'columns'=>$columns,
			        
					));
			    

        }
     elseif($_GET['isstud']==0) //TEACHERS
		 {   ?>
   		   <div style="clear:both;"></div>
			 <br /><div style="margin-bottom:-27px" ><?php echo "<h4><br/><b>".Yii::t('app','Teacher more info')."  </b></h4> "; ?></div>        
		
		         
		<?php
		         $create_moreInfo=false;
		         
		         $dataProvider=EmployeeInfo::model()->searchForOneEmployee($_GET['id']);
		         $data=$dataProvider->getData();
		       
		          $button=array( 'class'=>'CButtonColumn',
			                    'template'=>'{view}', 
			                 'buttons'=>array (
			        'update'=> array(
			            'label'=>'Update',
			            
			            'url'=>'Yii::app()->createUrl("/academic/employeeinfo/update?id=$data->id&pers='.$_GET['id'].'&from='.$_GET['from'].'&isstud=0&pg=vr")',
			            'options'=>array( 'class'=>'icon-edit' ),
			        ),
			         'view'=>array(
			            'label'=>'View',
			           
			            'url'=>'Yii::app()->createUrl("/academic/employeeinfo/view?id=$data->id&pers='.$_GET['id'].'&from='.$_GET['from'].'&isstud=0&pg=vr")',
			            'options'=>array( 'class'=>'icon-search' ),
			        )),
			                 );
			                 
		         if((isset($data))&&($data!=null))
		           {  foreach($data as $field)
		                { if($field!="")
		                    { 
		                    	if(($field->field_study!=null)&&($field->qualification!=null))
		                          $columns=array('hire_date', array('header'=>Yii::t('app','Teacher qualification'),'name'=>'employee_qualification','value'=>'$data->qualification0->qualification_name'), array('header'=>Yii::t('app','Field study'),'name'=>'employee_field_study','value'=>'$data->fieldStudy->field_name'),$button);
		                         else
		                          $columns=array('hire_date','university_or_school','number_of_year_of_study');
		                    }
		           	       else
		           	           $columns=array('hire_date','university_or_school','number_of_year_of_study');
		                }
		           
		            }
		         else
		           {   $create_moreInfo=true;
		               $columns=array('hire_date','university_or_school','number_of_year_of_study');
		           }
		           
		        $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'teacher-info-grid',
			'dataProvider'=>  EmployeeInfo::model()->searchForOneEmployee($_GET['id']),
			
			'emptyText'=>Yii::t('app','No more info found'),
			        
			'columns'=>$columns,
				));
		
		    ?>
		
   		   <br/><div style="margin-bottom:-27px" ><?php echo "<h4><br/><b>".Yii::t('app','List Courses belongs')."  </b></h4> "; ?></div>
           <?php 
		         
	     if(isset($_GET['id'])&&($_GET['id']!=""))
           {
	         $dataProvider_course=Courses::model()->getCourses($_GET['id'],$acad);
           }
	     else
		   { if(isset($_GET['pg']))
		       {
		       	  $dataProvider_course=Courses::model()->getAllCourses($_GET['id']);
		       }
		     else
		       {
		       	  $dataProvider_course=Courses::model()->getCourses($_GET['id'],$acad);
		       }
		       
		   }
        
        $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'courses-grid',
	'dataProvider'=>$dataProvider_course,
	
	'emptyText'=>Yii::t('app','No course found (or not yet scheduled)'),
			        
	'columns'=>array(
		
		array('name'=>'subject_name','value'=>'$data->subject_name'),
		array('name'=>'room_name','value'=>'$data->room_name'),
		
		'weight',
		
            	   		
		   ),
		  
     )); 

   if(!isset($_GET['pg'])){
	 ?>
 <?php // Here is where the schedule beging ?>
				<div style="clear:both;"></div>
				 <br /><div style="margin-bottom:-27px" ><?php echo "<h4><br/><b>".Yii::t('app','Schedules belong')."  </b></h4> "; ?></div>
			<?php		 
				$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
			   $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'schedules-grid',
				'dataProvider'=>Schedules::model()->searchForOneTeacher($_GET['id'],$acad),
				
				'emptyText'=>Yii::t('app','No schedule found)'),
				'columns'=>array(
					
					'day',
					'time_start',
					'time_end',
					array('name'=>'course','value'=>'$data->course0->courseName'),
					
						),
					));
             }//fin $_GET['pg'] not set
  
	     }
             
  }
  else //EMPLOYEE
   {  ?>
   	       <div style="clear:both;"></div>
			 <br /><div style="margin-bottom:-27px" ><?php echo "<h4><br/><b>".Yii::t('app','Employee More Info')."  </b></h4> "; ?></div>        
		
		         
		<?php
		         $create_moreInfo=false;
		         
		         $dataProvider=EmployeeInfo::model()->searchForOneEmployee($_GET['id']);
		         $data=$dataProvider->getData();
		       
		          $button=array( 'class'=>'CButtonColumn',
			                    'template'=>'{view}', 
			                 'buttons'=>array (
			        'update'=> array(
			            'label'=>'Update',
			           
			            'url'=>'Yii::app()->createUrl("/academic/employeeinfo/update?id=$data->id&pers='.$_GET['id'].'&from='.$_GET['from'].'&isstud=0&pg=vr")',
			            'options'=>array( 'class'=>'icon-edit' ),
			        ),
			         'view'=>array(
			            'label'=>'View',
			           
			            'url'=>'Yii::app()->createUrl("/academic/employeeinfo/view?id=$data->id&pers='.$_GET['id'].'&from='.$_GET['from'].'&isstud=0&pg=vr")',
			            'options'=>array( 'class'=>'icon-search' ),
			        )),
			                 );
			                 
		         if((isset($data))&&($data!=null))
		           {  foreach($data as $field)
		                { if($field!="")
		                    { 
		                    	if(($field->field_study!=null)&&($field->qualification!=null))
		                          $columns=array('hire_date', array('header'=>Yii::t('app','Teacher qualification'),'name'=>'employee_qualification','value'=>'$data->qualification0->qualification_name'), array('header'=>Yii::t('app','Field study'),'name'=>'employee_field_study','value'=>'$data->fieldStudy->field_name'),$button);
		                         else
		                          $columns=array('hire_date','university_or_school','number_of_year_of_study');
		                    }
		           	       else
		           	           $columns=array('hire_date','university_or_school','number_of_year_of_study');
		                }
		           
		            }
		         else
		           {   $create_moreInfo=true;
		               $columns=array('hire_date','university_or_school','number_of_year_of_study');
		           }
		           
		        $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'teacher-info-grid',
			'dataProvider'=>  EmployeeInfo::model()->searchForOneEmployee($_GET['id']),
			
			'emptyText'=>Yii::t('app','No more info found'),
			'columns'=>$columns,
				));
		
		    
		

   	
   	}
  
  echo '</div>';
  
  echo '<div class="photo_view" style="padding-top:10px;padding-left:5px;margin-top:-70px; border:1px solid red; height:250px;" >';
  
  if(isset($_GET['isstud']))
   { if($_GET['isstud']==1) //STUDENTS
	    { 
	  	  if(isset($_GET['from']))
            { if($_GET['from']=="stud") //STUDENTS
	            {  
	               echo '<br /><div style="margin-bottom:-47px;" > <h4><br/><b>'.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'from'=>'stud')).'  </b></h4> <br/></div> ';       
			       echo '<br /><div style="margin-bottom:-47px;" > <h4><br/><b>'.CHtml::link(Yii::t('app','Create grade'), array('grades/create','stud'=>$_GET['id'],'from'=>'stud')).'  </b></h4> <br/></div> ';    
			       echo '<br /><div style="margin-bottom:-47px;" > <h4><br/><b>'.CHtml::link(Yii::t('app','View reportcard'), array('../reports/reportcard/report','stud'=>$_GET['id'],'pg'=>'vr','from'=>'stud')).'  </b></h4> <br/></div> ';
			       
			
	            }
            }
         
 
       
		   	  
		   	     
			   
			    

        }
     elseif($_GET['isstud']==0) //TEACHERS (or EMPLOYEES)
		 {  
		 	if(isset($_GET['from']))
               { if($_GET['from']=="teach") //TEACHERS
	               {
			         echo '<br /><div style="margin-bottom:-47px;" > <h4><br/><b>'.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'from'=>'teach')).'  </b></h4> <br/></div> '; 
			         
			         if($create_moreInfo)
			            {  $text=Yii::t('app','Create more info');
			               $url=array('employeeinfo/create','emp'=>$_GET['id'],'isstud'=>0,'from'=>'teach');
			            }
			         else
			            { $text=Yii::t('app','Update more info');
			              $url=array('employeeinfo/update','emp'=>$_GET['id'],'isstud'=>0,'from'=>'teach');
			            }
			              echo '<br /><div style="margin-bottom:-27px" ><h4><br/><b>'.CHtml::link($text,$url ).'  </b></h4> </div>';        
		
	               }
	             elseif($_GET['from']=="emp") //EMPLOYEES
	               {
			         echo '<br /><div style="margin-bottom:-47px;" > <h4><br/><b>'.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'from'=>'emp')).'  </b></h4> <br/></div> '; 
			         echo '<br /><div style="margin-bottom:-27px" ><h4><br/><b>'.CHtml::link(Yii::t('app','Update more info'), array('academic/employeeinfo/update','emp'=>$_GET['id'],'isstud'=>0,'from'=>'emp')).'  </b></h4> </div>';
			         
	               }
	               
               }
					     
     
	     }
             
  }
  else
    {
    	if(isset($_GET['from']))
               { if($_GET['from']=="emp") //EMPLOYEES
	               {
			         echo '<br /><div style="margin-bottom:-47px;" > <h4><br/><b>'.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'from'=>'emp')).'  </b></h4> <br/></div> ';
			         
			         
			         $dataProvider=EmployeeInfo::model()->searchForOneEmployee($_GET['id']);
		         $data=$dataProvider->getData();
		       
		         if((!isset($data))||($data==null))
		              $create_moreInfo=true;
		            			         
			         if($create_moreInfo)
			            {  $text=Yii::t('app','Create more info');
			               $url=array('employeeinfo/create','emp'=>$_GET['id'],'isstud'=>0,'from'=>'emp');
			            }
			         else
			            { $text=Yii::t('app','Update more info');
			              $url=array('employeeinfo/update','emp'=>$_GET['id'],'isstud'=>0,'from'=>'emp');
			            }
			              echo '<br /><div style="margin-bottom:-27px" ><h4><br/><b>'.CHtml::link($text,$url ).'  </b></h4> </div>';   
			         
			          
			         echo '<br /><div style="margin-bottom:-27px" ><h4><br/><b>'.CHtml::link(Yii::t('app','create courses'), array('../schoolconfig/courses/create','emp'=>$_GET['id'],'isstud'=>0,'from'=>'emp')).'  </b></h4> </div>';

			         
	               }
	               
               }
				
    }

  echo '</div >';
  
  
        