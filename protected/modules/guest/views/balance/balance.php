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
/* @var $this BillingsController */
/* @var $model Billings */

  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));
    
$acad=Yii::app()->session['currentId_academic_year']; 


Yii::app()->clientScript->registerScript('searchByParentUsername', "
$('.search-button').click(function(){
				$('.search-form').toggle();
				return false;
				});
			$('.search-form form').submit(function(){
				$.fn.yiiGridView.update('balance-grid', {
data: $(this).serialize()
});

				return false;
				});
			");
	
?>



		
<div id="dash">
		<div class="span3"><h2>
<?php echo Yii::t('app','Balance to be paid'); ?> </h2> </div>
      <div class="span3">
             <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                           // build the link in Yii standard
                 echo CHtml::link($images,array('/guest/billings/index')); 
               ?>
  </div>  


</div>
</div>
 
<div style="clear:both"></div>	




<?php 

       //reket pou delete tout liy balans yo a zewo
   
  
     $userName='';
		     $group_name='';
		     
		       if(isset(Yii::app()->user->name))
		           $userName=Yii::app()->user->name;
	
	if(isset(Yii::app()->user->groupid))
	   {    
	      $groupid=Yii::app()->user->groupid;
	      $group=Groups::model()->findByPk($groupid);
			
		  $group_name=$group->group_name;
	   }	
			if($group_name=='Parent')
			  {	
			  	$dataProvider=$model->searchByParentUsername($userName);
			  }
			 elseif($group_name=='Student')
			 {
			 	$dataProvider=$model->searchByStudentUsername($userName);
			 } 
			 
		

        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'balance-grid',
	'dataProvider'=>$dataProvider,
	
	'columns'=>array(
		
		
		array('name'=>'student_fname',
			'header'=>Yii::t('app','Student first name'), 
			'value'=>'$data->student0->first_name'),
			
		array('name'=>'student_lname',
			'header'=>Yii::t('app','Student last name'), 
			'value'=>'$data->student0->last_name'),
		
		'balance',
		
		
		
		array(
			'class'=>'CButtonColumn',
			'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('balance-grid',{ data:{pageSize: $(this).val() }})",
                    )),
				'template'=>'',
			   'buttons'=>array (
        
							'view'=>array(
							     'label'=>'View',
							  
							     'url'=>'Yii::app()->createUrl("billings/balance/view?stud=$data->student&id=$data->id")',
							     'options'=>array( 'class'=>'icon-search' ),
                                ),
		               ),
	),
	),
)); 







?>


