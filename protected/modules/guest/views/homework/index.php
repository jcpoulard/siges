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
/* @var $this HomeworkController */
/* @var $model Homework */

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad=Yii::app()->session['currentId_academic_year']; 

?>

		
<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Manage homework'); ?>
		</h2> </div>
     
		   <div class="span3">
                       <?php
                     // Chek if a parent to disable the Submit homework button        
                 if(isset(Yii::app()->user->groupid))
	   {    
	      $groupid=Yii::app()->user->groupid;
	      $group=Groups::model()->findByPk($groupid);
			
		  $group_name=$group->group_name;
	   }
                 if($group_name == 'Parent') {
                     
                  
                      }
                else{  
                       ?>
              <div class="span4">
                 <?php
                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Submit').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('homeworkSubmission/create?from=stud')); 
               ?>
             </div>
                <?php } ?>       
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                    
				    echo CHtml::link($images,array('/guest/homework/index/isstud/1/from/stud'));
				                                  
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


Yii::app()->clientScript->registerScript('searchHomeworkByRoomId', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#homework-grid').yiiGridView('update', {
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
                
      
       
       $content=$model->searchHomeworkByRoomId($room_id,$acad)->getData();
        if((isset($content))&&($content!=null))
           $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>





<?php 



        
        

      
             $dataProvider = $model->searchHomeworkByRoomId($room_id,$acad);
           

 $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
       $gridWidget  = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'homework-grid',
	'dataProvider'=>$dataProvider,
	'mergeColumns'=>array('Course','Teacher'),
	'showTableOnEmpty'=>true,
	
	'columns'=>array(
		
	 array(
                                    'header'=>Yii::t('app','Teacher'),
                                    'name' => 'Teacher',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->person->FullName,Yii::app()->createUrl("/guest/homework/view",array("id"=>$data->id)))',
                                    
                                ),

		
	array(
                                    'header'=>Yii::t('app','Course'),
                                    'name' => 'Course',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->course0->subject0->subject_name,Yii::app()->createUrl("/guest/homework/view",array("id"=>$data->id)))',
                                    
                                ),
                                
		
		array(
                                    'header'=>Yii::t('app','Homework Title'),
                                    'name' => 'title',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->title,Yii::app()->createUrl("/guest/homework/view",array("id"=>$data->id)))',
                                   
                                ),
                                
		
		/*array(
                                    'header'=>Yii::t('app','Description'),
                                    'name' => 'description',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->description,Yii::app()->createUrl("/guest/homework/view",array("id"=>$data->id)))',
                                    
                                ),
           */                     
		
		array(
                                    'header'=>Yii::t('app','Submission deadline'),
                                    'name' => 'limit_date_submission',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->limitDateSubmission,Yii::app()->createUrl("/guest/homework/view",array("id"=>$data->id)))',
                                    
                                ),
                                
		//'attachment_ref',  //mete klik sou li pouw ka wel nan viewerJS
		array(
                                    'header'=>Yii::t('app','Files'),
                                    'name' => 'attachment_ref',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link(($data->attachment_ref == null) ? " " : "<span class=\"fa fa-paperclip\"></span>",Yii::app()->createUrl("/guest/homework/view",array("id"=>$data->id)))',
                                   
                                ),
                                
		
		array(
			'class'=>'CButtonColumn',
					
			'template'=>'',
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'View',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("/academic/homework/view?id=$data->id&from=stud")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
              ),
        'update'=>array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            'imageUrl'=>false,
           
            'url'=>'Yii::app()->createUrl("academic/homework/update?id=$data->id&from=stud")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
              ),

              ),
            
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('homework-grid',{ data:{pageSize: $(this).val() }})",
            )),

		),
		
	),
)); 

// Export to CSV 
  $content=$model->searchHomeworkByRoomId($room_id,$acad)->getData();
 if((isset($content))&&($content!=null))
$this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));

?>


