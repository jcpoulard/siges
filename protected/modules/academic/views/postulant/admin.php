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
/* @var $this PostulantController */
/* @var $model Postulant */

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 

$template = '';


$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 




Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#postulant-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>



<div id="dash">
   <div class="span3"><h2>
         <?php echo Yii::t('app','Manage Postulants'); ?>
         
   </h2> </div>
   
   
     <div class="span3">
   
 <?php 
     
         $template = '';  
         
         if(!isAchiveMode($acad_sess))
         { $template = '{update}{delete}';  
        
   ?>
   
         <div class="span4">
                  <?php

                $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('fees/create'));
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
    echo $this->renderPartial('//layouts/navBaseEnrollment',NULL,true);	
    ?>


<div class="b_m">


<div class="grid-view">


<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->



<?php 

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'postulant-grid',
	'dataProvider'=>$model->search(),
	//'filter'=>$model,
	'showTableOnEmpty'=>true,
	
        //'mergeColumns'=>'level_lname',
        
	'columns'=>array(
		'id',
		'first_name',
		'last_name',
		'gender',
		'blood_group',
		'birthday', 
		'paid',
		
		/*
		 array('name'=>'level_lname',
			'header'=>Yii::t('app','Level'), 
			'value'=>'$data->level0->level_name'),
			
		array(
                    'name' => 'fee',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->fee0->fee_label,Yii::app()->createUrl("configuration/fees/view",array("id"=>$data->id)))',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),
           array('name'=>'date_limit_payment','value'=>'$data->DateLimitPayment'),
                     
		'cities',
		'adresse',
		'phone',
		'person_liable',
		'person_liable_phone',
		'person_liable_adresse',
		'person_liable_relation',
		'apply_for_level',
		'previous_level',
		'previous_school',
		'school_date_entry',
		'last_average',
		'status',
		'date_created',
		'date_updated',
		'create_by',
		'update_by',
		*/
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
                         'onchange'=>"$.fn.yiiGridView.update('postulant-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); ?>

</div>
