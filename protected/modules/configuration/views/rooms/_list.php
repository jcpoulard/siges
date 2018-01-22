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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];
$template ='';


?>


<?php echo $form->errorSummary($model); ?>

<?php
  
  if(!isAchiveMode($acad_sess))
     $template ='{update}{delete}';
                 
       Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('rooms-grid', {
data: $(this).serialize()
});
				return false;
				});
			"); 
 ?>
		
<div style="margin-bottom:-27px" ><?php echo CHtml::link(Yii::t('app', 'Advanced Search'),'#',array('class'=>'search-button')); ?></div>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php 
   $from=$_GET['from'];
   if($from==1)//la creation vient de la page room
   { $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'rooms-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		
		'room_name',
   		array(
               'name'=>'level_lname',
               'header'=>Yii::t('app','Level'),
               'value'=>'$data->level0->level_name',
               ),
   		array(
   	          'name'=>'shift_sname',
   	          'header'=>Yii::t('app','Shift'),
   	          'value'=>'$data->shift0->shift_name',
   	          ),
   		array(
   	          'name'=>'section_sname',
   	           'header'=>Yii::t('app','Section'),
   	           'value'=>'$data->section0->section_name',
   	           ),
		
		
				
		array( 'class'=>'CButtonColumn',
		         'template'=>$template,),		   
		   ),
     )); 
	}
   elseif($from==0)//la creation vient de la page level
   { $this->widget('zii.widgets.grid.CGridView', array(
	   'id'=>'rooms-grid',
	   'dataProvider'=>$model->search(),
	   'filter'=>$model,
	'columns'=>array(
		
		'room_name',
   		array(
               'name'=>'level_lname',
               'header'=>Yii::t('app','Level'),
               'value'=>'$data->level0->level_name',
               ),
   		array(
   	          'name'=>'shift_sname',
   	          'header'=>Yii::t('app','Shift'),
   	          'value'=>'$data->shift0->shift_name',
   	          ),
   		array(
   	          'name'=>'section_sname',
   	           'header'=>Yii::t('app','Section'),
   	           'value'=>'$data->section0->section_name',
   	           ),
		
		
						   
		   ),
     )); 
	}
				
				

?>