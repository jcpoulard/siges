
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


   <?php	
           
$acad=Yii::app()->session['currentId_academic_year']; 
           
       ?>




<!-- Menu of CRUD  -->



<div id="dash">
          
          <div class="span3"><h2>
          
       <?php  
              if(isset($_GET['from'])&&($_GET['from']=='ind'))
                 echo  Yii::t('app','View postulant'); 
              else
                  echo  Yii::t('app','Admission sheet'); 
		
		?>
                 
             </h2> </div>
             
             
      <div class="span3">
           
    <?php
            if(isset($_GET['p'])&&($_GET['p']!=''))
            {     
            	
           ?>
              <div class="span4">                       
                  <?php
                        $images = '<i class="fa fa-print">&nbsp;'.Yii::t('app','Print').'</i>';

                               // build the link in Yii standard
                   	
					    echo CHtml::link($images,array('/academic/persons/admission','id'=>$model->id), array('onclick'=>"printDiv('print_receipt')") );
					   
											
                   ?>

               </div>
     <?php          	
              }
           else
             {    
           
       ?>                               

               <div class="span4">                       
                  <?php
                        $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard
                   	
					    echo CHtml::link($images,array('/academic/persons/admission','id'=>$model->id));
					   
											
                   ?>

               </div>
              
   
              
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
  
                      echo CHtml::link($images, array('/academic/persons/viewListAdmission'));
                             
                                                 
                   ?>

                  </div>  
    
    <?php   }  ?>
    
        </div>
 </div>	



<div style="clear:both"></div>

<br/>

	

<div class="b_m">

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payment-receipt-form',
	//'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_viewDetailAdmission', array(
	'model'=>$model,
	'form' =>$form
	)); ?>


<?php $this->endWidget(); ?>

</div>

</div>
















