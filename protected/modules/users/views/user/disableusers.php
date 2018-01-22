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


/* @var $this UserController */
/* @var $model User */

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
 $acad_sess=acad_sess();   
$acad=Yii::app()->session['currentId_academic_year']; 

?>



<!-- Menu of CRUD  -->
<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','Disable Users'); ?>  </h2> </div>
    <div class="span3">
             
     
              <div class="span4">
                      <?php
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     echo CHtml::link($images,array('/users/user/index')); 
                   ?>
                 </div>    
          
        </div>
</div>

<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseUser',NULL,true);	
    ?>
</div>





<?php

Yii::app()->clientScript->registerScript('searchDisableUsers', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#user-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>


<div class="clear"></div>


<div>
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div class="clear"></div>

<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->searchDisableUsers(),
	'showTableOnEmpty'=>true,
	
	
	'columns'=>array(
		array(
                    'name' => 'username',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->username,Yii::app()->createUrl("users/user/view",array("id"=>$data->id)))',
                    'htmlOptions'=>array('width'=>'150px'),
                                ),
		
		
				array(
                    'name'=>'full_name',
                    'header'=>Yii::t('app','Full name'),
                    'value'=>'$data->full_name',
                    ),
                
                    'profilUser',
		
		array(
			'class'=>'CButtonColumn',
				'template'=>'{view}',
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("users/user/view?id=$data->id&from=dis")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
                 ),
        
            ),    
    
            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('user-grid',{ data:{pageSize: $(this).val() }})",
           
                   )),
		),
	),
));

// Export to CSV 
  $content=$model->searchDisableUsers()->getData();
 if((isset($content))&&($content!=null)) 
$this->renderExportGridButton($gridWidget, '<span class="fa fa-arrow-right">'.Yii::t('app',' CSV').'</span>',array('class'=>'btn-info btn'));
?>


