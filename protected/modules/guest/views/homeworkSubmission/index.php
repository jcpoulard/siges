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
/* @var $this HomeworkSubmissionController */
/* @var $dataProvider CActiveDataProvider */

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad=Yii::app()->session['currentId_academic_year']; 

?>

		
<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Manage submited homework'); ?>
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
                 echo CHtml::link($images,array('/guest/homeworkSubmission/create?from=stud'));
                 
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

Yii::app()->clientScript->registerScript('searchSubmitedHomeworkByRoomId', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#homework-submission-grid').yiiGridView('update', {
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
                
      
       
       $content=$model->searchSubmitedHomeworkByStudentId($this->student_id,$acad)->getData();
        if((isset($content))&&($content!=null))
           $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>





<?php 


$template='';

   if($group_name=='Student')
     {
         $template='';
         
         if(isset($_GET['msgulds'])&&($_GET['msgulds']=='y'))
           $this->message_UpdateLimitDateSubmission=true;
	
			//error message
	    if(($this->message_UpdateLimitDateSubmission))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-top:15px;  margin-bottom:-47px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }			      
				 				   
				  if($this->message_UpdateLimitDateSubmission)
				     { echo '<span style="color:red;" >'.Yii::t('app','Update operation is denied due to the "Limit Submission Date".').'</span><br/>';
				     $this->message_UpdateLimitDateSubmission=false;
				     }
				     
				 
			 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';
           
           
     }
     
     

      
             $dataProvider = $model->searchSubmitedHomeworkByStudentId($this->student_id,$acad);
           

 $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
       $gridWidget  = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'homework-submission-grid',
	'dataProvider'=>$dataProvider,
	'mergeColumns'=>array('homework_id','homework->person'),
	
	'columns'=>array(
		
		array(
                                    'header'=>Yii::t('app','Homework'),
                                    'name' => 'homework_id',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->homework->title,Yii::app()->createUrl("/guest/homeworkSubmission/view",array("id"=>$data->id,)))',
                 ),
                                    
		 array(
                                    'header'=>Yii::t('app','Teacher'),
                                    'name' => 'homework->person',
                                    'value'=>'$data->homework->person->first_name." ".$data->homework->person->last_name',
                 ),
       

		array(
                                    'header'=>Yii::t('app','Submission Date'),
                                    'name' => 'date_submission',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->dateSubmission,Yii::app()->createUrl("/guest/homeworkSubmission/view",array("id"=>$data->id,)))',
                 ),
                 
		
		array(
                                    'header'=>Yii::t('app','Comment'),
                                    'name' => 'comment',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->comment,Yii::app()->createUrl("/guest/homeworkSubmission/view",array("id"=>$data->id,)))',
                 ),
                 
		
		array(
                                    'header'=>Yii::t('app','Files'),
                                    'name' => 'attachment_ref',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link(($data->attachment_ref == null) ? " " : "<span class=\"fa fa-paperclip\"></span>",Yii::app()->createUrl("/guest/homeworkSubmission/view",array("id"=>$data->id,)))',
                 ),
                 
                 
	  
		array(
			'class'=>'CButtonColumn',
			
			'template'=>$template,
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'View',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("/guest/homeworkSubmission/view?id=$data->id&from=stud")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
              ),
        'update'=>array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("/guest/homeworkSubmission/update?id=$data->id&from=stud")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
              ),

              ),
            
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('homework-submission-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
));


// Export to CSV 
  $content=$model->searchSubmitedHomeworkByStudentId($this->student_id,$acad)->getData();
 if((isset($content))&&($content!=null))
$this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));

?>

