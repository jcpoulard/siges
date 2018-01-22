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
 *//* @var $this CmsSectionController */
/* @var $model CmsSection */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cms-section-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage cms sections');
?>

<div id="dash">
   <div class="span3"><h2>
        <?php echo Yii::t('app','Manage cms sections');?>
        
   </h2> </div>
    
    <div class="span3">
        <div class="span4">
            <?php
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('cmsSection/create')); 
            ?>
        </div>
        <div class="span4">
            <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                     echo CHtml::link($images,array('/portal/cmsSection/index')); 

                    ?>
        </div>
    </div>
</div>

<div class="clear"></div>


<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cms-section-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		
		
                 array(
                    'name' => 'section_name',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->section_name,Yii::app()->createUrl("portal/cmsSection/view",array("id"=>$data->id)))',
                   
                     ),
		
		'is_publish:boolean',
		
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
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(1=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('cms-section-grid',{ data:{pageSize: $(this).val() }})",
                    )),
                        
		),
	),
)); ?>
