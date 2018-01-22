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

  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
  
$this->pageTitle = Yii::app()->name.' - '.Yii::t('app','Manage academic periods');


?>



<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
<?php echo Yii::t('app','Manage academic periods');?> </h2> </div>
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
           
            

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('academic-periods-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>


<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>
                
		<?php 
                $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
                $gridWidget = $this->widget('groupgridview.GroupGridView', array(
			'id'=>'academic-periods-grid',
			'dataProvider'=>$model->search(),
                        'showTableOnEmpty'=>false,
                        'emptyText'=>Yii::t('app','No academic period found'),
			'summaryText'=>Yii::t('app','View academic period from {start} to {end} (total of {count})'),
                        'mergeColumns'=>'year0.name_period',
			'columns'=>array(
                                'year0.name_period',
				'name_period',
				'date_start',
				'date_end',
                                
				array('header'=>Yii::t('app','Is year?'),'value'=>'$data->isYear'),
				
		           
		                
				array(
					'class'=>'CButtonColumn',
					'template'=>'',
                                    
                                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                          'onchange'=>"$.fn.yiiGridView.update('academic-periods-grid',{ data:{pageSize: $(this).val() }})",
                                )),
				),
                            
			),
		)); 
		
		
?>
