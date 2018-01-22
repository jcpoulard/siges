
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
		
		 <?php  	
	      echo Yii::t('app','End Year Decision Update'); 
		?>
	</h2> </div>
	
      <div class="span3">
             <div class="span4">


                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                     
                       echo CHtml::link($images,array('/academic/persons/listforreport?isstud=1&from=stud')); 
                                $this->back_url='/academic/persons/listforreport?isstud=1&from=stud';   

        ?>

                  </div>   
         
            </div> 
 </div>




<div class="clear"></div>

</br>
<div class="b_mail">
<div class="form">
    

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'decision-form',
	//'enableAjaxValidation'=>true,
)); 
      echo $this->renderPartial('_endYearDecisionUpdate', array(
									'model'=>$model,
									'form' =>$form
									));

 ?>
    
   

<?php $this->endWidget(); ?>

</div>
</div>

<!-- form -->
