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
                 echo CHtml::link($images,array('postulant/create'));
               ?>
        </div>
         
           
  <?php
         }
      
      ?>       
     
      
        <div class="span4">
              <?php

                  $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/academic/postulant/viewListAdmission/part/enrlis/from/stud')); 
                 
                  
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



<div class="search-form" style="">
<?php  $content='';
 
	$content= $model->search($acad_sess)->getData();
	  
	  $this->renderPartial('_search',array(
'model'=>$model,
)); ?>
</div>


<?php 

$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'postulant-grid',
	'dataProvider'=>$model->search($acad_sess),
	//'filter'=>$model,
	'showTableOnEmpty'=>true,
	
        //'mergeColumns'=>'level_lname',
        
	'columns'=>array(
		
		'id',
		
		array(
                    'name' => 'first_name',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/postulant/viewAdmissionDetail",array("id"=>$data->id,"part"=>"enrlis","pg"=>"")))',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),
		
		array(
                    'name' => 'last_name',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/postulant/viewAdmissionDetail",array("id"=>$data->id,"part"=>"enrlis","pg"=>"")))',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),
                     
		array(
            'name'=>'gender',
             'value'=>'$data->getGenders1()',
             'htmlOptions'=>array('width'=>'50px'),
						),
        
         array('name'=>'apply_for_level',
			'header'=>Yii::t('app','Level'), 
			'value'=>'$data->applyForLevel->level_name'),

		
		array('name'=>'paid',
			'header'=>Yii::t('app','Paid'), 
			'value'=>'$data->Paid'),
		
		array('name'=>'status',
			'header'=>Yii::t('app','Status'), 
			'value'=>'$data->Status'),
		
				array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/academic/postulant/update?id=$data->id&part=enrlis&from=")',
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
)); 



     $content=$model->search($acad_sess)->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
         
?>

</div>

		      
		 


	
	  
