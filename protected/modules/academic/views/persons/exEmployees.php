
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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


$acad=Yii::app()->session['currentId_academic_year'];


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 




Yii::app()->clientScript->registerScript('searchExEmployee', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('persons-grid', {
data: $(this).serialize()
});
				return false;
				});
			");



?>

	
			

	

	
<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>

       <?php
     
		echo Yii::t('app','Inactive Employees List'); 
		
		?>
            </h2> </div>
            
      <div class="span3">
             <div class="span4">
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                      
                     
                     echo CHtml::link($images,array('/reports/reportcard/generalreport?from1=rpt')); 

                   ?>

                  </div>  

       </div>


 </div>
 


<div style="clear:both"></div>			
				

<div class="search-form" >
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
 
          $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchExEmployee(),
			'showTableOnEmpty'=>true,
			
			'columns'=>array(
				
		array(
				'name'=>'last_name',
				 'type' => 'raw',
                 'value'=>'CHtml::link($data->last_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pg"=>"ext","from"=>"rpt")))',
                       
                                    ),
       array(
				'name'=>'first_name',
				 'type' => 'raw',
                 'value'=>'CHtml::link($data->first_name,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pg"=>"ext","from"=>"rpt")))',
                            
				    ),
				 array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						), 
				array(
							'name'=>Yii::t('app','Working department'),
							'value'=>$model->getWorkedDepartment($model->id),
						), 
				
        
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>'',
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
           
            'url'=>'Yii::app()->createUrl("/academic/persons/viewForReport?id=$data->id&isstud=0&pg=ext&from1=rpt")',
            'options'=>array( 'title'=>Yii::t('app','View') ),
        ),
        
    ),
				),
			),
		   )); 
	


?>

