
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

	

<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
		
		<?php     echo Yii::t('app','Validate / Publish Grades');


	?>  
	
	</h2> </div>
	
      <div class="span3">
             <div class="span4">


                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                      
								echo CHtml::link($images,array('/academic/grades/index?from=stud&mn=std'));
								$this->back_url='/academic/grades/index?from=stud&mn=std';
                   ?>

                  </div>   
         
            </div> 
 </div>

<?php
$this->breadcrumbs=array(
	Yii::t('app','Grades')=>array('index'),
	
	Yii::t('app', 'Update'),
);


?>

<div class="clear"></div>

</br>

<div class="form">
    

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grades-form',
	'enableAjaxValidation'=>true,
)); 
     echo $this->renderPartial('_validate-publish', array(
									'model'=>$model,
									'form' =>$form
									));

 ?>
    
   
    <div class="clear"></div>


<?php $this->endWidget(); ?>

</div>

<!-- form -->
