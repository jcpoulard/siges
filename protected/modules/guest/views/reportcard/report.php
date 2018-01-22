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
	   
?>


	
			

	

	
<!-- Menu of CRUD  -->

<div id="dash">
		<div class="span3"><h2>


		       <?php      
          
			$full_name=$this->getStudent($this->student_id);
	      if($group_name=='Parent')
	         echo Yii::t('app','Report Card');
	      elseif($group_name=='Student')
	          echo Yii::t('app','View my reportcards'); 
		?></h2> </div>
     
 <div class="span3">
             <div class="span4">
                      <?php
                         
                           $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                    
                           echo CHtml::link($images,array('/guest/grades/index')); 
                   ?>

                  </div> 
           </div>
  </div>
			 
		   
						
			
	

<div style="clear:both"></div>	

</br>
<div class="b_mail">
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reportcard-form',
	'enableAjaxValidation'=>true,
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
      ),
)); 

echo $this->renderPartial('_list', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
	


<div class="row buttons">

	
</div>

<?php $this->endWidget(); ?>

</div>
</div>
