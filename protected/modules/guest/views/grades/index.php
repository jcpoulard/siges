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

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));

$acad=Yii::app()->session['currentId_academic_year']; 


?>

		<?php 
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
	   
	   ?>			

<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2> <?php  if($group_name=='Parent')
																	  echo Yii::t('app','Grades');
																	elseif($group_name=='Student')
																	    echo Yii::t('app','My Grades'); ?> 
</h2> </div>
      <div class="span3">
             <div class="span4">
                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('../site/index')); 

                   ?>

                  </div>  
				  
				  
		

                  

 </div>
</div>
 
<div style="clear:both"></div>	


			

	   	
	<?php 			
		
			
if($group_name=='Parent')
  {	
	?>
	<div style="margin-bottom:80px;">
	<?php 	
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	
)); 


			  	
		?>			 
		    <!--evaluation-->
			<div class="left" style="margin-right:5px;">
			<label for="student"><?php echo Yii::t('app','Child'); ?></label>
	 <?php 					
					         $modelPerson= new Persons();
							    if(isset($this->student_id))
							       echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()')); 
						           }					      
				
					    						
					   ?>
				</div>
		<?php		
				
	     $this->endWidget();    		         	
		    ?>
		    </div>
		    

	<?php    }
		       elseif($group_name=='Student')
		         {
		         	?>
	<div style="margin-bottom:0px;">
	<?php 	
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	
)); 


		         	$user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
		         	    
		         	  $this->endWidget();    		         	
		    ?>
		    </div>
		    <?php
		        
		         }
		       
	     ?>	
			
	
			
	

 
<?php


$this->menu=array(
		array('label'=>Yii::t('app',
				'List Grades'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Grades'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('searchByStudentId', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('grades-grid', {
data: $(this).serialize()
});

				return false;
				});
			");
		?>




<div style="clear:both"></div>
<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php    

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
   $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'grades-grid',
	'dataProvider'=>$model->searchByStudentIdForGuestUser($this->student_id,$acad),
	'emptyText'=>Yii::t('app','Not yet available.'),
       'mergeColumns'=>array('evaluation0.examName',),
	
	'columns'=>array(
		
                array('header'=>Yii::t('app','Exam name'),
                    'name'=>'evaluation0.examName',
                    'htmlOptions'=>array('style'=>'vertical-align: top'),
                    ),
                array('header'=>Yii::t('app','Course name'),'name'=>'course0.courseName'),
                
               
		'grade_value',
                'course0.weight',
				array('header'=>Yii::t('app','Class Average'),'name'=>'Class Average','value'=>'course_average($data->course0->id,$data->evaluation0->id)'),
               
               array('header'=>Yii::t('app','Com. '),'name'=>'comment',
                    'type' => 'raw','value'=>'CHtml::link(($data->comment == null) ? " " : "<span data-toggle=\"tooltip\" title=\"$data->comment\"><i class=\"fa fa-comment-o\"></i> </span>
",Yii::app()->createUrl("#",array("id"=>$data->id,"from"=>"stud")))',
                ),
                
		
		array(
			'class'=>'CButtonColumn',
			'template'=>'',
			'buttons'=>array (
        'update'=> array(
            'label'=>'Update',
            
            'url'=>'Yii::app()->createUrl("/academic/grades/update?id=$data->id&from=0")',
            'options'=>array( 'class'=>'icon-edit' ),
        ),
         'view'=>array(
            'label'=>'View',
            
            'url'=>'Yii::app()->createUrl("/academic/grades/view?id=$data->id&from=0")',
            'options'=>array( 'class'=>'icon-search' ),
        ),
        
    ),
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('grades-grid',{ data:{pageSize: $(this).val() }})",
                    )),
		),
	),
) ); 
   
   
   
   
   
  
   
   
   
   ?>

