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
/* @var $this OtherIncomesDescriptionController */
/* @var $dataProvider CActiveDataProvider */

$acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year'];

$template = '';

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#other-incomes-description-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Manage other incomes description'); ?>
              
          </h2> </div>
     
		   <div class="span3">
             
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{update}{delete}';  
        
   ?>

 <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/otherIncomesDescription/create/part/rec/from/stud')); 
               ?>
   </div>
 
 <?php
        }
      
      ?>       
  
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/billings/index/part/rec/from/stud')); 
               ?>
  </div>  


  </div>

</div>



<div style="clear:both"></div>


<br/>


    <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>



<div class="b_m">


<div class="grid-view">


<?php 

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'other-incomes-description-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'showTableOnEmpty'=>true,
	 'mergeColumns'=>array('category'),
	
	'columns'=>array(
		'income_description',
		array('name'=>'category', 'header' =>Yii::t('app','Category'), 
					            'value'=>'$data->Category',
					             ),
		'comment',
		array(
			'class'=>'CButtonColumn',
			          'template'=>$template,
                         'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/billings/otherIncomesDescription/update?id=$data->id&part=rec&from=stud")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                      'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('other-incomes-description-grid',{ data:{pageSize: $(this).val() }})",
                             )),
		),
	),
)); 


    // Export to CSV 
  $content=$model->search()->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));



?>


</div>














