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

 $acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$template =''; 


$this->pageTitle = Yii::app()->name .' - '.Yii::t('app','Manage Evaluations');
?>


<!-- Menu of CRUD  -->

<div id="dash">
   <div class="span3"><h2>
         <?php echo Yii::t('app','Manage Evaluations'); ?>
         
    </h2> </div>

     
     <div class="span3">
      
        <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template ='{update}{delete}';    
        ?>
      
         <div class="span4">
                  <?php

                       $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('evaluations/create'));
                     
                   ?>

                 </div> 
                 
     <?php
                 }
      
      ?>       
                 
           
               <div class="span4">
                    <?php
                          $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/configuration/academicperiods/index')); 

                   ?>

              </div>

        </div>
 </div>


<div style="clear:both"></div>

<div class="search-form">
    <?php
    echo $this->renderPartial('//layouts/navBaseConfiguration',NULL,true);	
    ?>
</div>


<?php


		Yii::app()->clientScript->registerScript('search_', "
			$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('evaluations-grid', {
data: $(this).serialize()
});
				return false;
				});
			");
		?>



	
<!--IMPORTANT-->
<!-- pa efase sa, sinon lyen peryod academic nan update lan pap mache-->
<!--	<div class="span3"></div> -->


<div class="clear"></div>


<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div>

<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'evaluations-grid',
	'dataProvider'=>$model->search_($acad),//sou tout ane akademik lan
	'showTableOnEmpty'=>true,
        
	
	'columns'=>array(
		
		
                array(
                    'name' => 'evaluation_name',
                    
                    'value'=>'$data->evaluation_name',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),
		      
		      'weight',
		     
		      array(
   	          'name'=>'academic_year',
   	          'header'=>Yii::t('app','Academic Year'),
   	          'value'=>'$data->academicYear->name_period',
   	          ),
   	          

		
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
                        'onchange'=>"$.fn.yiiGridView.update('jobstatus-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
));


 // Export to CSV 
  $content=$model->search_($acad)->getData();  //sou tout ane akademik lan
  if((isset($content))&&($content!=null))
        $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app','CSV'),array('class'=>'btn-info btn'));
        
    $date_start ='';
		      $acad_result=AcademicPeriods::model()->getAcademicPeriodNameById($acad);  ///sou tout ane akademik lan
		     
		      $date_start = $acad_result->date_start;
		      
		      
		$gridWidget1 = $this->widget('groupgridview.GroupGridView', array(
			
			'dataProvider'=>$model->searchPast($acad, $date_start),
                        'showTableOnEmpty'=>false,
                        'emptyText'=>'',
			'summaryText'=>'',
                        'mergeColumns'=>array('academic_year'),
			'columns'=>array(
                       
				
                           
                                
                               
                array(
                    'name' => 'evaluation_name',
                    
                    'value'=>'$data->evaluation_name',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),
		      
		      'weight',
		     
		      array(
   	          'name'=>'academic_year',
   	          'header'=>Yii::t('app','Academic Year'),
   	          'value'=>'$data->academicYear->name_period',
   	          ),
   	          

				
				array(
					'class'=>'CButtonColumn',
					'template'=>'',
                                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                                        'imageUrl'=>false,
                                        'options'=>array('title'=>Yii::t('app','Update')),

                                        ),
                                        'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                                        'imageUrl'=>false,
                                        'options'=>array('title'=>Yii::t('app','Delete')),


                                        ),
                                        ),
                                    
                     'header'=>CHtml::dropDownList('pageSize',$pageSize,array(1000000=> Yii::t('app','All')  )),
				),

		           
             
			),
		)); 
     
 ?>


