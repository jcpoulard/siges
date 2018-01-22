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


$this->breadcrumbs=array(
	Yii::t('app','Report Card')=>array('create'),
	Yii::t('app', 'Create'),
);
?>


			

	

	
<!-- Menu of CRUD  -->

<div id="dash">
      
       <?php  
	      echo '<div class="span3"><h2>'.Yii::t('app','Making report card').' </h2> </div>'; 
		?>
                 
                  <div class="icon-dash">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';


                               // build the link in Yii standard

                     if(isset($_GET['from']))
                       {  if($_GET['from']=='rpt')
		                       //if ($drop==1)
							    echo CHtml::link($images,array('/reports/reportcard/generalreport')); 
		                     // else
							  
						 elseif($_GET['from']=='stud')
						       echo CHtml::link($images,array('/academic/persons/listforreport?isstud=1&from=stud')); 
						 
                       }
                   ?>

                  </div>  
				  
				 
				 <div class="icon-dash">

                  <?php
                                  	              //display if PDF file exit 
	                       if($this->allowLink)
					        {  
							    $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
	
									   // build the link in Yii standard
	                            echo CHtml::link($images, Yii::app()->baseUrl.$this->pathLink,array( 'target'=>'_blank'));
						  
							
	                         }
                        
                   ?>

            	</div>

 </div>

<div style="clear:both"></div>	


</br>
<div class="b_mail">
<div class="form">

<?php 

 $form=$this->beginWidget('CActiveForm', array(
	'id'=>'reportCard-form',
	'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_create', array(
	'model'=>$model,
	'form' =>$form
	)); ?>
<div class="clear"></div>
<div class="row buttons">
	<?php if(((isset($this->evaluation_id))&&($this->evaluation_id!=""))&&((isset($this->room_id))&&($this->room_id!="")))
          {
            if($this->noStud===1)
			{ echo CHtml::submitButton(Yii::t('app', 'View Student\'s ReportCard '),array('name'=>'view')); 
                           
                         if(isset($_GET['from']))
                       {  if($_GET['from']=='stud')
						       echo CHtml::submitButton(Yii::t('app', 'Create ReportCards for This Room'),array('name'=>'create')); 
						 
                       }
  
                           		
                  
			}
                        }
	?>
	
</div>
<?php $this->endWidget(); ?>

</div>
</div>
