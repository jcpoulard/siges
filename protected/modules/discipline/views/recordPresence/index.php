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

 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$template = '';


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('record-presence-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="dash">
   <div class="span3"><h2>
          <?php echo Yii::t('app','Manage attendance record'); ?>
          
   </h2> </div>
    
     <div class="span3">
       
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{update}';  
        
   ?>
       
         <div class="span4">
                  <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('recordPresence/recordPresence'));
                 
                   ?>
  </div> 
  <?php
        }
      
      ?>       
          
               <div class="span4">
              <?php

                  $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/discipline/recordPresence/admin')); 

               ?>
          </div>
   </div>

</div>


<div style="clear:both"></div>




<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 
    $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
    $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'record-presence-grid',
	'dataProvider'=>$model->search($acad_sess),
	
	'columns'=>array(
		array(
                    'name' => 'student',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->student0->fullName,Yii::app()->createUrl("discipline/recordPresence/view",array("id"=>$data->id)))',
                    'htmlOptions'=>array('width'=>'250px'),
                     ),
		
		array('name'=>'date_record','value'=>'$data->dateRecord'),
		
                array(
                    'name' => 'room',
                    'header'=>Yii::t('app','Room'),
                    'type' => 'raw',
                    'value'=>'$data->room0->room_name',
                    
                    'htmlOptions'=>array('width'=>'100px'),
                     ),
                
                'presence',
		
			array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(1=>1,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('record-presence-grid',{ data:{pageSize: $(this).val() }})",
            )),

		),
	),
)); ?>
