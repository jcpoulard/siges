<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

?>
<?php

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; //current academic year

$chosen_acad=Yii::app()->session['AcademicP_sch']; //the chosen academic year


?>








<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2> <?php echo Yii::t('app','Manage agenda'); ?>

</h2> </div>
     
		   <div class="span3">
             
            <?php   
		      if((Yii::app()->user->profil!='Teacher'))
			   {
			
			      if((!isset($_GET['from']))||($_GET['from']!='teach'))
					   {                ?>
				   <?php 
               if(!isAchiveMode($acad_sess))
                 {       
        ?>
                  <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/schoolconfig/scheduleAgenda/create?ad')); 

                   ?>

            	</div>

              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/schoolconfig/scheduleAgenda/create?up')); 

                   ?>

            	</div>
			 
			   <?php
					   }
					   
			    }
			   
			   
			    ?>
			 <?php
			   }
			 ?>
            	 <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                       if((Yii::app()->user->profil!='Teacher'))
                        {
                 		if((!isset($_GET['from']))||($_GET['from']!='teach'))
					       {   echo CHtml::link($images,array('/academic/persons/viewListAdmission/isstud/1/pg/lr/mn/std')); 
					       }
					     elseif((isset($_GET['from']))&&($_GET['from']=='teach'))
					       echo CHtml::link($images,array('/academic/persons/listForReport/from/teach/isstud/0'));
						}
					   elseif((Yii::app()->user->profil=='Teacher'))
					      echo CHtml::link($images,array('/academic/persons/listForReport/from/teach/isstud/0'));
                   ?>

                  </div> 
				
						
				  
        </div> 
 </div>



<div style="clear:both"></div>

</br>
<div class="b_mail">
<div class="form">


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'schedule-agenda-form',
	
)); 
echo $this->renderPartial('_index', array(
	'model'=>$model,
	'form' =>$form
	)); ?>



<?php $this->endWidget(); ?>

</div>
</div>

