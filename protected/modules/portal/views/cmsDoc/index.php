<?php
/* @var $this CmsDocController */
/* @var $model CmsDoc */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#cms-doc-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage school web site documents');

?>

<div id="dash">
   <div class="span3">
       <h2>
        <?php echo Yii::t('app','Manage documents');?>
        
    </h2> 
   </div>
    
    <div class="span3">
        <div class="span4">
            <?php
                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('cmsDoc/create')); 
            ?>
        </div>
        
        
        
        <div class="span4">
            <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                     echo CHtml::link($images,array('/portal/cmsDoc/index')); 

                    ?>
        </div>
    </div>
    
    
</div>

<div class="clear"></div>


<?php
    echo $this->renderPartial('//layouts/navBasePortal',NULL,true);	
?>







<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->



<?php

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'cms-doc-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'columns'=>array(
            
                array(
                    'name' => 'document_title',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->document_title,Yii::app()->createUrl("portal/cmsDoc/view",array("id"=>$data->id)))',
                   
                     ),
		//'document_title',
		'document_name',
		
		
		
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
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('cms-article-grid',{ data:{pageSize: $(this).val() }})",
                    )),
                        
		),
            
		
	),
)); ?>
