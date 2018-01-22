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
/* @var $this CoursesController */
/* @var $model Courses */
  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  


$this->breadcrumbs=array(
	Yii::t('app','Courses')=>array('index'),
	Yii::t('app', 'Manage'),
);


$acad=Yii::app()->session['currentId_academic_year']; 


	    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
     if($acad!=$current_acad->id)
         $condition1 = '';
      else
         $condition1 = 'teacher0.active IN(1,2) AND ';
      



?>





<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','My Courses'); ?>
</h2> </div>        
<div class="span3">
             <div class="span4">
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     echo CHtml::link($images,array('/guest/evaluationbyyear/index')); 

                   ?>

                  </div>   

		</div>

 </div>

<div style="clear:both"></div>
<div>			
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
			if($group_name=='Parent')
			  {	
				
		?>			 
		    <!--evaluation-->
			<div class="left" style="margin-right:5px;">
			<label for="student"><?php echo Yii::t('app','Child'); ?></label>
	 <?php 
					 $form=$this->beginWidget('CActiveForm', array(
						'id'=>'person-form',
						
					));
					         $modelPerson= new Persons();
							    if(isset($this->student_id))
							       echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()')); 
						           }					      
						  
					$this->endWidget();  
						    						
					   ?>
				</div>
			
		<?php    }
		       elseif($group_name=='Student')
		         {
		         	$user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
		         	
		         }
		        
	     ?>	
<!--	</div>		-->

</div>
 
<div style="clear:both"></div>	


<?php

$this->menu=array(
		array('label'=>Yii::t('app',
				'List Courses'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Courses'),
				'url'=>array('create')),
			);

Yii::app()->clientScript->registerScript('searchCourseByRoomId', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#courses-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

		?>





<div  class="search-form">
<?php 
        $room_id=0;
         //get room ID in which this child enrolled
          $modelRoom=Rooms::model()->getRoom($this->student_id, $acad)->getData();
                
                if(isset($modelRoom))
                  {  foreach($modelRoom as $r)
                       $room_id=$r->id;
                       
                  }
                
      
       
       $content=$model->searchCourseByRoomId($condition1,$room_id,$acad)->getData();
        if((isset($content))&&($content!=null))
           $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php 
        
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);    
        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'courses-grid',
	
	'dataProvider'=>$model->searchCourseByRoomId($condition1,$room_id,$acad),
	'mergeColumns'=>array('teacher_lname','email'),
	'columns'=>array(
		
                
		array('name'=>'teacher_lname', 
			'header'=>Yii::t('app','Teacher last name'),
			'value'=>'$data->teacher0->fullName',
                        'htmlOptions'=>array('style'=>'vertical-align: top'),
                    ),
		
	
		array('name'=>'subject_name',
			'header'=>Yii::t('app','Subject name'),
			'value'=>'$data->subject0->subject_name'),
			
		'weight',
		
		array('name'=>'room_name',
			'header'=>Yii::t('app','Room'),
			'value'=>'$data->room0->room_name'),
            
            
            
            array(
                'name'=>'email',
                'header'=>Yii::t('app','Email teacher'),
                'type'=>'raw',
                'value'=>'CHtml::link(($data->teacher0->email == null) ? " " : "<span><i class=\"fa fa-envelope\"></i> </span>
",Yii::app()->createUrl("/guest/mails/create",array("stud"=>$data->teacher0->id,"from"=>"stud","mod"=>"guest")))',
                
            ),
	
		
		array(
			'class'=>'CButtonColumn',
                      'template'=>'',
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('courses-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 

 
         
         
?>


