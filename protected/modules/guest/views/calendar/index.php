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
/* @var $this CalendarController */
/* @var $dataProvider CActiveDataProvider */

$acad=Yii::app()->session['currentId_academic_year']; //current academic year


?>


<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>

<?php echo Yii::t('app','Manage Events'); ?></h2> </div>
     
		   <div class="span3">
             
          		
		      <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/schoolconfig/calendar/create')); 

                   ?>

              </div>    
   
     <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     echo CHtml::link($images,array('/schoolconfig/calendar/index'));
                     $this->back_url='/schoolconfig/calendar/index'; 

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
	$('#calendar-grid').yiiGridView('update', {
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
	'id'=>'calendar-grid',
	'dataProvider'=>$model->search($acad),
	
	'showTableOnEmpty'=>true,
        'emptyText'=>Yii::t('app','No event found'),
        
        'mergeColumns' =>array('academicYear.name_period', 'start_date'),
'columns'=>array(
		
		array(
                    'name' => 'c_title',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->c_title,Yii::app()->createUrl("/schoolconfig/calendar/view",array("id"=>$data->id)))',
                    
                     ),
        array(
                    'name' => 'description',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->description,Yii::app()->createUrl("/schoolconfig/calendar/view",array("id"=>$data->id)))',
                    
                     ),
		'location',
		'start_date',
		'end_date',
		
		 array(
                    'name' => 'academicYear.name_period',
                    'type' => 'raw',
                    'value'=>'$data->academicYear->name_period',
                    'htmlOptions'=>array('style'=>'vertical-align: top'),
                     ),

		
		array(
			'class'=>'CButtonColumn',
			'template'=>'{update}{delete}',
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                        'onchange'=>"$.fn.yiiGridView.update('calendar-grid',{ data:{pageSize: $(this).val() }})",
                        )),
		),
	),
));


$content=$model->search($acad)->getData();
if((isset($content)) && ($content != null)) {
$this->renderExportGridButton($gridWidget, '<span class="fa fa-arrow-right">'.Yii::t('app',' CSV').'</span>',array('class'=>'btn-info btn'));
}



 ?>
	





