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
/* @var $this ReservationController */
/* @var $dataProvider CActiveDataProvider */



Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#reservation-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
   
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

$template = '{view}';

$part='reserv';

if(isset($_GET['part']))
{
	$part=$_GET['part'];
	}


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 

	
?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php   echo Yii::t('app','Manage Reservation');
                    
                  ?>
              
          </h2> </div>
     
		   <div class="span3">
             
<?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{view}{update}{delete}';  
        
   ?>

     <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                  echo CHtml::link($images,array('/billings/reservation/create/part/reserv')); 
               ?>
   </div>
   
  <?php
        }
      
      ?>       

 
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 
                 echo CHtml::link($images,array('/billings/reservation/index/part/reserv'));
                   
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


                     

<?php 

function evenOdd($num)
{
($num % 2==0) ? $class = 'odd' : $class = 'even';
return $class;
}




$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'reservation-grid',

	'dataProvider'=>$model->search($acad_sess),
	'mergeColumns'=>array('payment_date', ),
	
	//'filter'=>$model,
	'columns'=>array(
		//'id',
		
		array('name'=>'postulant_student',
			'header'=>Yii::t('app','Name'), 
			'type' => 'raw',
                    'value'=>'CHtml::link($data->PersonFullName,Yii::app()->createUrl("/billings/reservation/view",array("id"=>$data->id,"pers"=>$data->postulant_student, "part"=>"'.$part.'")))',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),
                     
		array('name'=>'amount',
			'header'=>Yii::t('app','Amount Pay'), 
			'value'=>'$data->Amount'),
			
		array('name'=>'payment_date',
			'header'=>Yii::t('app','Payment date'), 
			'value'=>'$data->PaymentDate'),
		
		
		array('name'=>'Is_sudent',
			'header'=>Yii::t('app','Is Student'), 
			'value'=>'$data->IsStudent'),
		
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                        'buttons'=>array(
                          'view'=>array(
				            'label'=>'<i class="fa fa-eye"></i>',
				            'imageUrl'=>false,
				            'url'=>'Yii::app()->createUrl("/billings/reservation/view?id=$data->id&part='.$part.'&pg")',
				            'options'=>array( 'title'=>Yii::t('app','View') ),
				        ),
                            'update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/billings/reservation/update?id=$data->id&pers=$data->postulant_student&part='.$part.'&pg")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                         'onchange'=>"$.fn.yiiGridView.update('reservation-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 


$content=$model->search($acad_sess)->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));


?>


</div>
</div>
