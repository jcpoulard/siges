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
 *//* @var $this PartnersController */
/* @var $model Partners */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

?>


<div id="dash">
          
          <div class="span3"><h2>
               <?php echo Yii::t('app', '{name}',array('{name}'=>$model->name));            
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

                     echo CHtml::link($images,array('/configuration/partners/create/part/pay/from/stud'));  

                   ?>

              </div>
              
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/configuration/partners/update/','id'=>$model->id,'part'=>'pay','from'=>'stud'));

                     ?>

              </div> 

     <?php
                 }
      
      ?>       
              
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/configuration/partners/index/part/pay/from/stud')); 

                   ?>

            </div> 

        </div>
  </div>



<div style="clear:both"></div>

<div id="dash">
		<div class="student1">

<?php 
        
         echo $model->name; 

?> </div> 




</div>

<div style="clear:both"></div>



<!--  ************************** PARTNERS *************************    -->
<div>
  <ul class="nav nav-tabs">
    <!--  ************************** PARTNERS INFO *************************    -->
    <li class="active"><a data-toggle="tab" href="#partnerinfo"><?php echo Yii::t('app','Partner info'); ?></a></li>
    
        
  </ul>


  <div class="tab-content">
    
    <!--  ************************** PARTNERS INFO *************************    -->

<div id="partnerinfo" class="tab-pane fade in active">
       

      <div class="span6">
        <div class="activat">

   <?php		
       echo '<div class="CDetailView_photo" >';
	    
	   $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		'address',
		'email',
		'phone',
		'activity_field',
		'contact',
		'date_created',
		
		'create_by',
		
	),
));     
	        
		
  ?>
	 
<?php

	echo '</div> ';
			 
?>
			 
			 
			 
	       </div>
       </div>

	 
			 
    </div>
    

      
  
  
        


		

  </div>
</div>

<!--  ************************** END PARTNERS *************************    -->



