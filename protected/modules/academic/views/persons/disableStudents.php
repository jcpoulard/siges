<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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


	
            $acad=Yii::app()->session['currentId_academic_year'];
               
                 if(isset($_GET['shi'])) $this->idShift=$_GET['shi'];
				  else{$idShift = Yii::app()->session['Shifts'];
				  $this->idShift=$idShift;}
				  
			      if(isset($_GET['sec'])) $this->section_id=$_GET['sec'];
				  else{$section = Yii::app()->session['Sections'];
				  $this->section_id=$section;}
				  
				  if(isset($_GET['lev'])) $this->idLevel=$_GET['lev'];
				  else{$level = Yii::app()->session['LevelHasPerson'];
				  $this->idLevel=$level;}
				  
				  if(!isset($_POST['Rooms']))
	                  if(isset($_GET['roo'])) $this->room_id=$_GET['roo'];
				  
				  
				 if(isset($_GET['stud'])) $this->student_id=$_GET['stud'];
				 

              



?>


	
			

	

	
<!-- Menu of CRUD  -->

		
<div id="dash">
		<div class="span3"><h2>
      
       <?php  
	      echo Yii::t('app','Disable Students'); 
		?>
         
        </h2> </div>
           
           
      <div class="span3">
             
            	
            	<div class="span4">


                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                               echo CHtml::link($images,array('/schoolconfig/evaluationbyyear/index/mn/aset')); 
						       $this->back_url='/schoolconfig/evaluationbyyear/index/mn/aset';
					  ?>

                  </div>  
				  
				
        </div>
 </div>

<div style="clear:both"></div>	


</br>

<div class="form">

<?php 

 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'disableStudents-form',
	
)); 
echo $this->renderPartial('_disableStudents', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
<div class="clear"></div>
<div class="row buttons">
		
</div>
<?php $this->endWidget(); ?>

</div>

