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
/* @var $this SubjectsController */
/* @var $model Subjects */
  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  
$this->breadcrumbs=array(
	Yii::t('app','Subjects')=>array('index'),
	Yii::t('app', 'Manage'),
);

?>




<!-- Menu of CRUD  -->
<div id="dash">
		<div class="span3"><h2>


 <?php echo Yii::t('app', 'Subjects teach at school');?> </h2> </div>
     
 <div class="span3">
             <div class="span4">
                      <?php
				
                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                     echo CHtml::link($images,array('/guest/evaluationbyyear/index')); 
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
        $content=$model->search()->getData();
        if((isset($content))&&($content!=null))
		  $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php 
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
    $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'subjects-grid',
	'dataProvider'=>$model->search(),
	
	'columns'=>array(
		
		'subject_name',
		
		
		array(
			'class'=>'CButtonColumn',
                      'template'=>'',
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                         'onchange'=>"$.fn.yiiGridView.update('subjects-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 

     
?>

