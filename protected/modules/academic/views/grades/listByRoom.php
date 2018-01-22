
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

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

?>

	

 <!--Menu of CRUD  -->

<div id="dash">
		<div class="span3"><h2>
		    <?php  if((Yii::app()->user->profil!='Teacher'))
																		echo Yii::t("app", "List student's grades by room");
																	else
																	   echo Yii::t("app", "Grades By Rooms");
																	 ?>
		</h2> </div>
		 
		 
      <div class="span3">
             	
             	
  <?php 
     
     if(!isAchiveMode($acad_sess))
        {     
        
   ?>
                        		  
				  <div class="span4">

                  <?php



                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/academic/grades/create?from=stud&mn=std')); 

                   ?>

              </div>
			  
			  
			  <?php if(Yii::app()->user->profil=='Teacher')
			         {
				?>
				     
			  <div class="span4">

                  <?php



                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('grades/update?all=1&from=stud&mn=std')); 

                   ?>

              </div>
				
			  <?php
					  }
					  
				?> 
              
 <?php
        }
      
      ?>       
              
                     
      <div class="span4">
                      <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/academic/persons/listforreport?isstud=1&from=stud')); 

                   ?>

                  </div>   
		
     </div>    

 </div>



<div class="clear"></div>
				     



<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'grades-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_listByRoom', array(
	'model'=>$model,
	'form' =>$form
	)); ?>

<div class="row buttons">
	
</div>

<?php $this->endWidget(); ?>

</div>
