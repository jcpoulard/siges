
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


$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

   $template = '';
   $template1 = '';

?>






<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>
          
       <?php  $drop=0;
      if(isset($_GET['from']))
        { if($_GET['from']=='stud'){ $drop=1; echo Yii::t('app','Students'); }
			elseif($_GET['from']=='teach'){ $drop=2;  echo Yii::t('app','Teachers');}
			elseif($_GET['from']=='emp'){ $drop=2;  echo Yii::t('app','Employees');} 
		}
      
		?>
                 
             </h2> </div>
             
      <div class="span3">

 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{update}{delete}';
              $template1 = '{update}';  
        
   ?>

              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard
                   if(isset($_GET['from'])&&($_GET['from']=='rpt')) 
                     { 
                     	echo '';
                     }
                    else
		              {    if(isset($_GET['isstud'])) 
		                     {  if($_GET['isstud']==1)
		                           echo CHtml::link($images,array('persons/create?isstud=1')); 
							 
							    elseif($_GET['isstud']==0)
								       echo CHtml::link($images,array('persons/create?isstud=0'));
							   }
						   else      
								    echo CHtml::link($images,array('persons/create')); 
								    
                         
                     }
					   

                   ?>

              </div> 

              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard
                     if(isset($_GET['from'])&&($_GET['from']=='rpt')) 
                     { 
                     	echo '';
                     }
                    else
		              { if(isset($_GET['isstud'])) 
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
		              }   

                   ?>

              </div> 
  <?php
        }
      
      ?>       
             
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
  
                      
                        if(isset($_GET['from'])){
                            
                          if($_GET['from']=='teach')
                          {
                               
                             	 if(isset($_GET['pg'])&&($_GET['pg']!=''))
                             	  { if($_GET['pg']=='ci')
								     echo CHtml::link($images,array('contactinfo/index','from'=>'stud')); 
								    // Au cas d'un besoin de retour 
                                                                    //else
								    //  echo CHtml::link($images, array('persons/listForReport','isstud'=>0,'from'=>'teach'));
                             	  }
								echo CHtml::link($images, array('persons/listForReport','isstud'=>0,'from'=>'teach'));
                             
                                  
                          }
                          
                          else{
                              if(($drop==1)||($_GET['from']=='stud'))
                                { 
								    if(isset($_GET['pg']))
										 {  if($_GET['pg']=='lr')
											  echo CHtml::link($images,array('listForReport','isstud'=>1,'from'=>'stud'));
											elseif($_GET['pg']=='l')
												   echo CHtml::link($images,array('list','isstud'=>1,'from'=>'stud'));
												elseif($_GET['pg']=='ci')
								                   echo CHtml::link($images,array('contactinfo/index','from'=>'stud'));
												
										 }
									   else
										 echo CHtml::link($images,array('persons/listForReport?isstud=1&from=stud'));
						 
								}
                              elseif($_GET['from']=='emp')
                                {  if(isset($_GET['pg'])&&($_GET['pg']!=''))
                                    { 
                                	     echo CHtml::link($images,array('persons/listForReport','from'=>'emp')); 
                                    }
                                   
                                }
                                  
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
										 
                                          echo CHtml::link($images,array('persons/listForReport'));
                                     
                                    }

                                
                        }
                       
                     
                   ?>

                  </div>  
    
        </div>
 </div>	


<div style="clear:both"></div>
			
<div id="dash">
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php 
          echo $model->fullName; ?></span></h2> </div>

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
                    'value'=>$model->getLevel($model->id,$acad_sess),
                ), 
       array(     'header'=>Yii::t('app','Room'),
                    'name'=>Yii::t('app','Room'),
                    'value'=>$model->getRooms($model->id,$acad_sess),
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
                    'value'=>$model->getWorkingDepartment($model->id,$acad), //depatman sou tout ane a
                ), 
        array(     'header'=>Yii::t('app','Title'),
                    'name'=>Yii::t('app','Title'),
                    'value'=>$model->getTitles($model->id,$acad),tit sou tout ane a
                ),
                
		
			),
		));
   	
   	}   ?>
   	
   	
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {      
        
   ?>
   	
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
        }
      
      ?>       
   
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
			      <br /><div style="float:left; margin-bottom:-20px; width:50%; " ><div id="dash" >
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php echo Yii::t('app','Contact info'); ?></span></h2> </div></div>        
	<div style="clear:both;"></div>
	
<div style="margin-top:-7px;"> 
		           
			<?php          
			
			$gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'contact-info-grid',
				'dataProvider'=> ContactInfo::model()->searchByPersonId($_GET['id']),
				
			        'emptyText'=>Yii::t('app','No contact found'),
			        'summaryText'=>'',
			        
				'columns'=>array(
					
					array(
                                    'name' => 'contact_name',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->contact_name,Yii::app()->createUrl("/academic/contactinfo/view",array("id"=>$data->id,"pg"=>"lr","isstud"=>1,"pers"=>'.$_GET['id'].',"from"=>"stud")))',
                                    'htmlOptions'=>array('width'=>'150px'),
                                ),
				
					
			                'phone',
			               
				 array( 'class'=>'CButtonColumn',
			                    'template'=>$template, 
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
       </div>
 <div style="clear:both;"></div>

<?php
if(isset($_GET['from']))
   { if($_GET['from']=='stud') //STUDENTS
	    { ?>
	  	 <br /><div style="float:left; margin-bottom:-20px; width:50%; " ><div id="dash" >
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php echo Yii::t('app','Grade'); ?></span></h2> </div></div>        
  <div style="clear:both;"></div>
	
<div style="margin-top:-7px;"> 

        
<?php 
 
      
		   	  
		   	 if(isset($_GET['from']))
		   	   { 
                             $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
                             $columns=array(
					array('header'=>Yii::t('app','Exam Name'),'name'=>'examName','value'=>'$data->evaluation0->examName','htmlOptions'=>array('style'=>'vertical-align: top')),
					array('header'=>Yii::t('app','Course name'),'name'=>'course_name','value'=>'$data->course0->courseName'),
				
			                'grade_value',
			                'course0.weight',
					
			             array( 'class'=>'CButtonColumn',
			                    'template'=>$template1, 
			                 'buttons'=>array (
			        'update'=> array(
			            'label'=>'<i class="fa fa-pencil-square-o"></i>',
			            'imageUrl'=>false,
			            'url'=>'Yii::app()->createUrl("/academic/grades/update?id=$data->id&from1=stud&isstud=1&pg=lr")',
			            'options'=>array( 'title'=>Yii::t('app','Update') ),
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
		   	   { 
                             
                             $columns=array(
		
					array('header'=>Yii::t('app','Course name'),'name'=>'course_name','value'=>'$data->course0->courseName'),
					array('header'=>Yii::t('app','Exam Name'),'name'=>'examName','value'=>'$data->evaluation0->examName'),
			               
			                'grade_value',
			                'course0.weight',
                          
					
			            
			            );
		   	     
		   	   }
    
                           
			    $gridWidget=$this->widget('groupgridview.GroupGridView', array(
				'id'=>'grades-grid',
				'dataProvider'=>  Grades::model()->searchByStudentId($_GET['id'],$acad_sess),
			        'emptyText'=>Yii::t('app','No grade found'),
			        'summaryText'=>'',
                                'mergeColumns'=>'examName',
				'columns'=>$columns,
			        
                          
					));
			 ?>
		    
	</div>   

<?php
        }
     elseif($_GET['from']=='teach') //TEACHERS
		 {   ?>
   		   <div style="clear:both;"></div>
			 <br /><div style="float:left; margin-bottom:-20px; width:50%; " ><div id="dash" >
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php echo Yii::t('app','Teacher more info'); ?></span></h2> </div></div>        
	<div style="clear:both;"></div>
	
<div style="margin-top:-7px;"> 
	         
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
			 'summaryText'=>'',      
			'columns'=>$columns,
				));
		
		    ?>
		    
	</div>
	
		
   		   <br/><div style="float:left; margin-bottom:-20px; width:50%; " ><div id="dash" >
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php echo Yii::t('app','List Courses belongs'); ?></span></h2> </div></div>
    <div style="clear:both;"></div>
	
<div style="margin-top:-7px;"> 


           
           <?php 
		         
	     if(isset($_GET['id'])&&($_GET['id']!=""))
           {
	         $dataProvider_course=Courses::model()->getCourses($_GET['id'],$acad_sess);
           }
	     else
		   { if(isset($_GET['pg']))
		       {
		       	  $dataProvider_course=Courses::model()->getAllCourses($_GET['id']);
		       }
		     else
		       {
		       	  $dataProvider_course=Courses::model()->getCourses($_GET['id'],$acad_sess);
		       }
		       
		   }
        
        $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'courses-grid',
	'dataProvider'=>$dataProvider_course,
	
	'emptyText'=>Yii::t('app','No course found (or not yet scheduled)'),
	'summaryText'=>'',//		        
	'columns'=>array(
		
		array('name'=>'subject_name','value'=>'$data->subject_name'),
		array('name'=>'room_name','value'=>'$data->room_name'),
		 
		'weight',
		
            	   		
		   ),
		  
     ));
     ?>
   	    
	</div> 
<?php
   if(!isset($_GET['pg'])){
	 ?>
 <?php // Here is where the schedule beging ?>
				<div style="clear:both;"></div>
				 <br /><div style="float:left; margin-bottom:-20px; width:50%; " ><div id="dash" >
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php echo Yii::t('app','Schedules belong'); ?></span></h2> </div></div>
<div style="clear:both;"></div>
	
<div style="margin-top:-7px;"> 

			
			
			<?php		 
				$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
			   $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'schedules-grid',
				'dataProvider'=>Schedules::model()->searchForOneTeacher($_GET['id'],$acad_sess),
				
				'emptyText'=>Yii::t('app','No schedule found)'),
				'summaryText'=>'',
				'columns'=>array(
					
					'day',
					'time_start',
					'time_end',
					array('name'=>'course','value'=>'$data->course0->courseName'),
					
						),
					));
		       ?>
    	    
	</div>
	<?php				
             }//fin $_GET['pg'] not set
  
	     }
	   elseif($_GET['from']=='emp')//EMPLOYEE
	       {  ?>
   	       <div style="clear:both;"></div>
			 <br /><div style="float:left; margin-bottom:-20px; width:50%; " ><div id="dash" >
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php echo Yii::t('app','Employee More Info'); ?></span></h2> </div></div>        
<div style="clear:both;"></div>
	
<div style="margin-top:-7px;"> 

		
		         
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
			'summaryText'=>'',
			'columns'=>$columns,
				));
		
	?>	    
	</div>	
<?php
   	
   	}
             
  }
   
   
  
  echo '</div>';

?>


 <?php 
     
     if(!isAchiveMode($acad_sess))
        {      
        
   ?>


<?php
  
  echo '<div  style="background: #ECF0F5; padding-top:10px;padding-left:5px;margin-top:-70px; border:0px solid red; height:auto; position: fixed; right: 5px;" >';
    
   
 	 if(isset($_GET['from']))
            { if($_GET['from']=="stud") //STUDENTS
           {  
                     
              echo '<span class="btn btn-link fa fa-phone" style="padding: 10px"> '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/> ';       
      echo '<span class="btn btn-link fa fa-list-alt" style="padding: 10px" > '.CHtml::link(Yii::t('app','Create grade'), array('grades/create','stud'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/>';    
      echo '<span class="btn btn-link fa fa-print" style="padding: 10px" > '.CHtml::link(Yii::t('app','View reportcard'), array('../reports/reportcard/report','stud'=>$_GET['id'],'pg'=>'vr','isstud'=>1,'from'=>'stud')).'  </span><br/>';
      
                           
           }
         elseif($_GET['from']=="teach") //TEACHERS
              {
        echo '<span class="btn btn-link fa fa-phone" style="padding: 10px;" > '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'isstud'=>0,'from'=>'teach')).'</span><br/> '; 
        
        if($create_moreInfo)
           {  $text=Yii::t('app','Create more info');
              $url=array('employeeinfo/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach');
           }
        else
           { $text=Yii::t('app','Update more info');
             $url=array('employeeinfo/update','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach');
           }
             echo '<span class="btn btn-link fa fa-plus-square-o" style="padding 10px"> '.CHtml::link($text,$url ).' </span><br/>'; 
             echo '<span class="btn btn-link fa fa-folder-open-o" style="padding 10px"> '.CHtml::link(Yii::t('app','Add courses'), array('../schoolconfig/courses/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'teach')).' </span><br/>'; 
             
              }
            elseif($_GET['from']=="emp") //EMPLOYEES
              {
                                    echo '<span class="btn btn-link fa fa-phone" style="padding: 10px;"> '.CHtml::link(Yii::t('app','Create contact info'), array('contactInfo/create','pers'=>$_GET['id'],'pg'=>'r','isstud'=>0,'from'=>'emp')).'</span><br/> '; 
        
          
        $dataProvider=EmployeeInfo::model()->searchForOneEmployee($_GET['id']);
        $data=$dataProvider->getData();
       
        if((!isset($data))||($data==null))
             $create_moreInfo=true;
           	        
        if($create_moreInfo)
           {  $text=Yii::t('app','Create more info');
              $url=array('employeeinfo/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'emp');
           }
        else
           { $text=Yii::t('app','Update more info');
             $url=array('employeeinfo/update','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'emp');
           }
             echo '<span class="btn btn-link fa fa-plus-square-o" style="padding: 10px" > '.CHtml::link($text,$url ).'</span> <br/>';   
        
         
        echo '<span class="btn btn-link fa fa-folder-open-o" style="padding: 10px" > '.CHtml::link(Yii::t('app','create courses'), array('../schoolconfig/courses/create','emp'=>$_GET['id'],'isstud'=>0,'pg'=>'vr','from'=>'emp')).'</span><br/>';

        
              }
            
            
            
            
            }
         
 
  echo '</div >';

  ?>
  
  <?php
        }
      
      ?>       
 
  
        