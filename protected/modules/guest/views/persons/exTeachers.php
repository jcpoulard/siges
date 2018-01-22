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
$this->breadcrumbs = array(
	Yii::t('app','Persons'),
	Yii::t('app', 'Index'),
);


Yii::app()->clientScript->registerScript('searchExTeachers', "
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

       <?php
     
		echo '<div class="span3"><h2>'.Yii::t('app','List Ex Teachers').'</h2> </div>'; 
		
		?>
                 
                  <div class="icon-dash">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard
                      
                     
                     echo CHtml::link($images,array('/reports/reportcard/generalreport')); 

                   ?>

                  </div>  




 </div>
 


<div style="clear:both"></div>			
				

<div class="search-form" style="display:none">

</div>

<?php $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
 
          $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchExTeachers(),
			
			'columns'=>array(
				
				'last_name',
				'first_name',
				 array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						), 
				array(
							'name'=>Yii::t('app','Working department'),
							'value'=>'$data->getWorkedDepartment($data->id)',
						), 
				
 
				
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>'{view}',
			   'buttons'=>array (
        
         'view'=>array(
            'label'=>'View',
            
            'url'=>'Yii::app()->createUrl("persons/viewForReport?id=$data->id&isstud=0&pg=ext")',
            'options'=>array( 'class'=>'icon-search' ),
        ),
        
    ),
				),
			),
		   )); 
	


?>

