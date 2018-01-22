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
/* @var $this FeesController */
/* @var $model Fees */

$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];

  
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));


?>


		
<div id="dash">
		<div class="span3"><h2> <?php echo Yii::t('app','Date of payment'); ?> </h2> </div>
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
			  	
	?>
	<div style="margin-bottom:80px;">
	<?php 	
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	
)); 


			  	
		?>	
		    <!--evaluation-->
			<div class="left" style="margin-right:5px;">
			<label for="student"><?php echo Yii::t('app','Child'); ?></label>
	 <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	
)); 

					
					         $modelPerson= new Persons();
							    if(isset($this->student_id))
							       echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()')); 
						           }					      
				
					    		$this->endWidget(); 				
					   ?>
				</div>
		<?php		
				
	     $this->endWidget();    		         	
		    ?>
		    </div>
		    

	<?php    }
		       elseif($group_name=='Student')
		         {
		         	?>
	<div style="margin-bottom:0px;">
	<?php 	
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	
)); 

	         	
		         	$user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
		         	    
	     	    
		         	  $this->endWidget();    		         	
		    ?>
		    </div>
		    <?php
		        
		         }
		       


$level=0;
$modelLevel= Levels::model()->getLevel($this->student_id,$acad);
if($modelLevel!=null)
  {  $modelLevel= $modelLevel->getData();
  	    foreach($modelLevel as $level_)
  	     { $level= $level_->id;
  	     }
  	}


Yii::app()->clientScript->registerScript('searchByLevel('.$level.','.$acad.')', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#fees-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

	
?>	
			
				

<div style="clear:both"></div>



<div  class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php  
            
             
             
        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        $gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'fees-grid',
	'dataProvider'=>$model->searchByLevel($level,$acad),
	'showTableOnEmpty'=>true,
	
                        'mergeColumns'=>'level_lname',
	
	'columns'=>array(
		
        array('name'=>'level_lname',
			'header'=>Yii::t('app','Level'), 
			'value'=>'$data->level0->level_name'),
			
		array(
                    'name' => 'fee_name',
                    'type' => 'raw',
                    'value'=>'$data->fee0->fee_label',
                    'htmlOptions'=>array('width'=>'150px'),
                     ),
		
		array('name'=>'amount','value'=>'$data->Amount'),
	
		array('name'=>'date_limit_payment','value'=>'$data->dateLimitPayment'),
		
		      
       				
		
		array(
			'class'=>'CButtonColumn',
                        'template'=>'',
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                         'onchange'=>"$.fn.yiiGridView.update('fees-grid',{ data:{pageSize: $(this).val() }})",
            )),
		),
	),
)); 

?>
