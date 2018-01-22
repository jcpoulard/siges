
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
/* @var $this HomeworkController */
/* @var $model Homework */

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$template = '';

$id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				




Yii::app()->clientScript->registerScript('search', "
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

		
<div id="dash">
		<div class="span3"><h2>
		     <?php echo Yii::t('app','Manage homework'); ?>
		</h2> </div>
     
		   <div class="span3">
           
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{update}';  
        
   ?>
 
              <div class="span4">
                 <?php
                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('homework/create?from=stud')); 
               ?>
             </div>

 <?php
        }
      
      ?>       

             
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                    
				    echo CHtml::link($images,array('/academic/persons/listforreport/isstud/1/from/stud'));
				                                  
               ?>
             </div>  
      </div>

</div>

<div style="clear:both"></div>

<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>




<?php 

        
        
         if(isset($_GET['msgulds'])&&($_GET['msgulds']=='y'))
           $this->message_UpdateLimitDateSubmission=true;
	
			//error message
	    if(($this->message_UpdateLimitDateSubmission)||($this->success))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-45px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }			      
				 				   
				  if($this->message_UpdateLimitDateSubmission)
				     { echo '<span style="color:red;" >'.Yii::t('app','Update operation is denied due to the "Limit Submission Date".').'</span><br/>';
				     $this->message_UpdateLimitDateSubmission=false;
				     }
				     
				   if($this->success)
				     {   echo '<span style="color:green;" >'.Yii::t('app','Operation terminated successfully.').'</span>'.'<br/>';
				     $this->success=false;
				     }
				     
				 
			 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';

 

      if((Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Manager'))
           { 
           	    $dataProvider = $model->search($acad_sess);
            }
         elseif((Yii::app()->user->profil=='Teacher'))
           {  
               $dataProvider = $model->searchForTeacher($id_teacher,$acad_sess);
            }
         elseif((Yii::app()->user->profil=='Guest'))
           { 
             $dataProvider = $model->searchForStudent($acad_sess);
           }

 $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
       $gridWidget  = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'homework-grid',
	'dataProvider'=>$dataProvider,
	'showTableOnEmpty'=>true,
	
	'columns'=>array(
		
	 array(
                                    'header'=>Yii::t('app','Teacher'),
                                    'name' => 'Teacher',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->person->FullName,Yii::app()->createUrl("/academic/homework/view",array("id"=>$data->id,"from"=>"stud")))',
                                   
                                ),

	array(
                                    'header'=>Yii::t('app','Room'),
                                    'name' => 'Room',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->course0->room0->short_room_name,Yii::app()->createUrl("/academic/homework/view",array("id"=>$data->id,"from"=>"stud")))',
                                    
                                ),
   	
	array(
                                    'header'=>Yii::t('app','Course'),
                                    'name' => 'Course',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->course0->subject0->subject_name,Yii::app()->createUrl("/academic/homework/view",array("id"=>$data->id,"from"=>"stud")))',
                                    
                                ),
                                
		
	/*	array(
                                    'header'=>Yii::t('app','Description'),
                                    'name' => 'description',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->description,Yii::app()->createUrl("/academic/homework/view",array("id"=>$data->id,"from"=>"stud")))',
                                    
                                ),
           */                     
		
		array(
                                    
                                    'name' => 'limit_date_submission',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link($data->limitDateSubmission,Yii::app()->createUrl("/academic/homework/view",array("id"=>$data->id,"from"=>"stud")))',
                                    
                                ),
                                
		
		array(
                                    'header'=>Yii::t('app','Files'),
                                    'name' => 'attachment_ref',
                                    'type' => 'raw',
                                    'value'=>'CHtml::link(($data->attachment_ref == null) ? " " : "<span class=\"fa fa-paperclip\"></span>",Yii::app()->createUrl("/academic/homework/view",array("id"=>$data->id,"from"=>"stud")))',
                                    
                                ),
                    
		
		array(
			'class'=>'CButtonColumn',
					
			'template'=>$template,
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
  $content=$model->search($acad_sess)->getData();
 if((isset($content))&&($content!=null))
$this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));

?>


