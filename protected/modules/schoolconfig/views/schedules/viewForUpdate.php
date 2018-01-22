<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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
$this->breadcrumbs=array(
	Yii::t('app','Schedules')=>array('index'),
	Yii::t('app', 'Manage'),
);



 $acad_sess=acad_sess();   
$acad=Yii::app()->session['currentId_academic_year']; 





if(isset($_GET['room']))
$this->room_id=$_GET['room'];
else
$this->room_id= Yii::app()->session['Rooms_sch'];

?>





<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>
<?php echo Yii::t('app','View Schedule for Update'); ?>
</h2> </div>
     
		   <div class="span3">
             
				  <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('schedules/create')); 

                   ?>

            	</div>
            	
            	<div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('schedules/index')); 

                   ?>

                  </div>   
				  

         </div>

</div>

<div style="clear:both"></div>


<?php

$this->menu=array(
		array('label'=>Yii::t('app',
				'List Schedules'), 'url'=>array('index')),
		array('label'=>Yii::t('app', 'Create Schedules'),
				'url'=>array('create')),
			);

		Yii::app()->clientScript->registerScript('search', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('schedules-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>




<div class="search-form" style="display:none">

</div>


<?php  
       $dataProvider=Schedules::model()->searchCoursesAndTimes($this->room_id,$acad);// en fonction de id_room 
       
       $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
       
     $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'schedules-grid',
	'dataProvider'=>$dataProvider,
	
	
	'columns'=>array(
		
		array('name'=>'course','value'=>'$data->course0->courseName'),
		
		array('header'=>Yii::t('app','Day'),'value'=>'$data->day'),
	  'time_start',
	  'time_end',
		
		
		array(
			'class'=>'CButtonColumn',
			  'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),

			'template'=>'{update}{delete}',
			
			'buttons'=>array (
            'update'=> array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            
            'imageUrl'=>false,
            'url'=>'Yii::app()->createUrl("schoolconfig/schedules/update?id=$data->id&room='.$this->room_id.'")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
        ),
		
          
        'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
		),
	),
	),
	
)); ?>