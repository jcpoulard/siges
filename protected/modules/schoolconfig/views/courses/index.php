<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 

 $template =''; 
 
    $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
      if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'teacher0.active IN(1,2) AND ';
						        }

     
     
      

?>


<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>


 <?php echo Yii::t('app','Courses'); ?></h2> </div>
     
		   <div class="span3">

        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{update}{delete}';    
        ?>
             		<div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                        if(isset($_GET['from'])&&($_GET['from']=='teach'))
                          {  
                              echo CHtml::link($images,array('courses/create/from/teach')); 
                              
                           }
                        else
                          echo CHtml::link($images,array('courses/create')); 

                   ?>

            	</div>
                       <?php if(infoGeneralConfig('grid_creation')!=null){ ?>
                       <div class="span4">
                          <?php  
                          $images = '<i class="fa fa-table"> &nbsp; '.Yii::t('app','Mass adding').'</i>'; 
                          echo CHtml::link($images,array('courses/gridcreateCourse/isstud/1/pg/lr/mn/std'));
                          ?>
                       </div>              
                       
                       <?php } ?>
        
       <?php
                 }
      
      ?>       
       
        
        
          <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard
                      if(isset($_GET['from'])&&($_GET['from']=='teach'))
                        {  
                          
                          
                          echo CHtml::link($images,array('/academic/persons/listForReport/isstud/0/from/teach')); 
                          
                         }
                      else
                       {  
                          echo CHtml::link($images,array('/academic/persons/viewListAdmission/isstud/1/pg/lr/mn/std')); 
                          
                         }

                   ?>

            </div>   


         </div>
 </div>



<div style="clear:both"></div>


<?php

$this->menu=array(
		array('label'=>Yii::t('app',
				'List Courses'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Courses'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('courses-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>



<div  class="search-form">
<?php 
       
           $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>


<?php 
        
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);    
        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'courses-grid',
	'dataProvider'=>$model->search($condition,$acad_sess),
	'mergeColumns'=>array('subject_name','room_name','teacher_lname'),
           
	'columns'=>array(
		
          array('name'=>'subject_name',
			'header'=>Yii::t('app','Subject name'),
			'value'=>'$data->subject0->subjectName'),
		
			'weight',
		
          array('name'=>Yii::t('app','Minimum Passing'),
			'header'=>Yii::t('app','Minimum Passing'),
			'value'=>'$data->getPassingGradeForCourse($data->id)',
			),
 
         array('name'=>'room_name',
			'header'=>Yii::t('app','Room'),
			'value'=>'$data->room0->short_room_name'),
            
           array('name'=>'debase',
                 'header'=>Yii::t('app','De base'),
                 'value'=>'$data->Debase',
                 ),
                 
           array('name'=>'optional',
                 'header'=>Yii::t('app','Optional'),
                 'value'=>'$data->Optional',
                 ),   
		
           array(
                    'name' => 'teacher_lname',
                    'header'=>Yii::t('app','Teacher Name'),
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->teacher0->first_name." ".$data->teacher0->last_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->teacher,"isstud"=>0,"from"=>"teach")))',
                    'htmlOptions'=>array('width'=>'150px'),  
                ),
                
			
		                                
				array(
			'class'=>'CButtonColumn',
                        'template'=> $template,
                        'buttons'=>array(
                           'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/schoolconfig/courses/update?id=$data->id&pg=tea&pers=$data->id")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                        'onchange'=>"$.fn.yiiGridView.update('courses-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 

$content=$model->search($condition,$acad_sess)->getData();
if((isset($content)) && ($content != null)) {
    $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app', ' CSV'), array('class' => 'btn-info btn'));
}

?>


