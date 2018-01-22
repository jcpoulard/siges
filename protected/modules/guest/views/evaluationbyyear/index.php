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
 /* @var $this EvaluationByYearController */
/* @var $model EvaluationByYear */

 
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  


$siges_structure = infoGeneralConfig('siges_structure_session');
	     
	   if($siges_structure==1)
	    {
	         $sess=Yii::app()->session['currentId_academic_session'];  
             $sess_name=Yii::app()->session['currentName_academic_session'];	
	      }

$acad=Yii::app()->session['currentId_academic_year']; 
$acad_sess = $acad;
		
		if($siges_structure==1)
    $acad_sess = $sess;
elseif($siges_structure==0)
   $acad_sess = $acad;



$template1 ='';
$template ='';

?>


<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','Evaluations for the current academic year'); ?> </h2> </div>
      <div class="span3">
             <div class="span4">

                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('../site/index')); 

                   ?>

                  </div>   


       

                               

 </div>

</div>
 
<div style="clear:both"></div>	





<?php


		Yii::app()->clientScript->registerScript('search('.$acad_sess.')', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('evaluation-by-year-grid', {
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
	'id'=>'evaluation-by-year-grid',
	'dataProvider'=>$model->search($acad_sess),
	'mergeColumns'=>array('evaluation_name' ),
	
	'columns'=>array(
	
   		array(
               'name'=>'evaluation_name',
               'header'=>Yii::t('app','Evaluation name'),
               'value'=>'$data->evaluation0->evaluation_name',
               ),
   		array(
   	          'name'=>'academic_year',
   	          'header'=>Yii::t('app','Academic period'),
   	          'value'=>'$data->academicYear->name_period',
   	          ),
		array('name'=>'evaluation_date','value'=>'$data->EvaluationDate'),
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>'',
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('evaluation-by-year-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 

 
?>


