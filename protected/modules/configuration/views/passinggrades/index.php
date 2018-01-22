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
/* @var $this PassinggradesController */
/* @var $model PassingGrades */

    


 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
 

$template ='';

$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage Passing grades');
?>

<div id="dash">
   <div class="span3"><h2>
         <?php echo Yii::t('app','Manage Passing grades'); ?>
         
    </h2> </div>
   
   
    <div class="span3">

        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{update}{delete}';    
        ?>
        
       
        <div class="span4">
             <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('passinggrades/create')); 
               ?>
        </div>

      <?php
                 }
      
      ?>       

        
        <div class="span4">
           <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/configuration/academicperiods/index')); 
               ?>
        </div>
    </div>
</div>




<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>




<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#passing-grades-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
 



	
<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->
<!--	<div class="span3"></div> -->
<div class="clear"></div>


<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
	'model'=>$modelC,
)); ?>
</div>


<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'passing-grades-grid',
	'dataProvider'=>$model->searchLevels($acad_sess),
        'showTableOnEmpty'=>true,
        'emptyText'=>Yii::t('app','No Passing grade found'),
        'summaryText'=>Yii::t('app','View passing grades from {start} to {end} (total of {count})'),
	'mergeColumns'=>'academic_lname',
	'columns'=>array(
		array('name'=>'academic_lname',
				'header'=>Yii::t('app','Academic Period'), 
				'value'=>'$data->academicPeriod->name_period'),	
		
		array(
                    'name' => 'level_lname',
                    'header'=>Yii::t('app','Levels'),
                    
                    'value'=>'$data->level0->level_name',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),	
		
		'minimum_passing',
		
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
                    'header'=>CHtml::dropDownList('pageSize',$pageSize,array(Yii::t('app', 'All')),array(
            )),
		),
	),
));


 
$gridWidget1 = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'passing-grades-grid',
	'dataProvider'=>$modelC->searchCourses($acad_sess),
        'showTableOnEmpty'=>false,
        'emptyText'=>Yii::t('app','No Passing grade found'),
        'summaryText'=>Yii::t('app','View passing grades from {start} to {end} (total of {count})'),
	'mergeColumns'=>'academic_lname',
	'columns'=>array(
		array('name'=>'academic_lname',
				'header'=>Yii::t('app','Academic Period'), 
				'value'=>'$data->academicPeriod->name_period'),	
		
		array(
                    'name' => Yii::t('app','Courses'),
                    'header'=>Yii::t('app','Courses'),
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->course0->subject0->subject_name,Yii::app()->createUrl("/configuration/passinggrades/view",array("id"=>$data->id))) ." [". $data->course0->room0->short_room_name."]"',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),	
		
		'minimum_passing',
		
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
                    'header'=>CHtml::dropDownList('pageSize',$pageSize,array(Yii::t('app', 'All')),array(
            )),
		),
	),
));







?>
