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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

$template ='';

?>
<?php
$this->breadcrumbs=array(
	Yii::t('app','Subjects')=>array('index'),
	Yii::t('app', 'Manage'),
);

?>




<!-- Menu of CRUD  -->
<div id="dash">
          
          <div class="span3"><h2>
<?php echo Yii::t('app', 'Subject');?> 
</h2> </div> 
     
		   <div class="span3">
  
          <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{update}{delete}';    
        ?>

           	      
	      <div class="span4">				
                  <?php   $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('subjects/create')); 
                   ?>
                  </div>
                       
                        <?php if(infoGeneralConfig('grid_creation')!=null){ ?>
                       <div class="span4">
                          <?php  
                          $images = '<i class="fa fa-table"> &nbsp; '.Yii::t('app','Mass adding').'</i>'; 
                          echo CHtml::link($images,array('subjects/massAddingSubjects'));
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
                     echo CHtml::link($images,array('/academic/persons/viewListAdmission/isstud/1/pg/lr/mn/std')); 
                   ?>
                  </div>   


        </div>          
                           
</div>



<div style="clear:both"></div>


<?php


		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('subjects-grid', {
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

<div class="clear"></div>


<?php 
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'subjects-grid',
	'dataProvider'=>$model->searchReport(),
	'mergeColumns'=>'subjectParent.subject_name',
	'columns'=>array(
		
                 array(
                    'name' => 'subjectParent.subject_name',
                    'htmlOptions'=>array('width'=>'250px'),
                ),
		 array(
                    'name' => 'subject_name',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->subject_name,Yii::app()->createUrl("/schoolconfig/subjects/view",array("id"=>$data->id)))',
                    'htmlOptions'=>array('width'=>'250px'),
                ),

         array(
                    'name' => 'short_subject_name',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->short_subject_name,Yii::app()->createUrl("/schoolconfig/subjects/view",array("id"=>$data->id)))',
                    'htmlOptions'=>array('width'=>'250px'),
                ),				
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                         'onchange'=>"$.fn.yiiGridView.update('subjects-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 

$content=$model->searchReport()->getData();
        if((isset($content))&&($content!=null))
              $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
?>

