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
/* @var $this BillingsController */
/* @var $model Billings */


$acad_sess=acad_sess();


$ri= 1;

 if(isset($_GET['ri']))
   {         
       if($_GET['ri']==0)
         {  $ri= 0;     
         	  
          }
        elseif($_GET['ri']==1)
          { $ri= 1;     
          	          	
          	 }
   }

?>

<!-- Menu of CRUD  -->
<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Update Billings no: {name} with balance: {balance}',array('{name}'=>$model->id,'{balance}'=>$model->balance)); ?>
              
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
                 if((isset($_GET['from1']))&&($_GET['from1']=='vfr'))
                      {  
                      	echo CHtml::link($images,array('/billings/billings/create/id/'.$_GET['id'].'/stud/'.$_GET['stud'].'/from1/vfr/from/stud')); 
                                                
                       }
                     else
                       {
                       	   echo CHtml::link($images,array('/billings/billings/create/part/rec/ri/'.$ri.'/from/stud')); 
                       	   
                        }
               ?>
   </div>
<?php
        }
?>     
     <div class="span4">
                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                               // build the link in Yii standard
                     if((isset($_GET['from1']))&&($_GET['from1']=='vfr'))
                      {  
                      	echo CHtml::link($images,array('/billings/billings/view/id/'.$_GET['id'].'/stud/'.$_GET['stud'].'/ri/0/part/rec/from1/vfr/from/stud')); 
                        $this->back_url='/billings/billings/view/id/'.$_GET['id'].'/stud/'.$_GET['stud'].'/ri/0/part/rec/from1/vfr/from/stud';
                        
                       }
                     else
                       {
                       	   
		                     if(isset($_GET['from']))
		                       {  if($_GET['from']=='view')
		                             {  echo CHtml::link($images,array('/billings/billings/view/id/'.$model->id.'/part/rec/ri/'.$ri.'/from/stud')); 
		                                $this->back_url='/billings/billings/view/id/'.$model->id.'/part/rec/ri/'.$ri.'/from/stud';
		                             }
		                          elseif($_GET['from']=='bap')
		                             {  echo CHtml::link($images,array('/billings/balance/view?id='.$_GET['idap'].'&stud='.$_GET['pers'].'&from=bap')); 
		                               $this->back_url='/billings/balance/view?id='.$_GET['idap'].'&stud='.$_GET['pers'].'&from=bap';
		                             }
		                            elseif($_GET['from']=='stud')
		                             {  echo CHtml::link($images,array('/billings/billings/index/part/rec/ri/'.$ri.'/from/stud')); 
		                         $this->back_url='/billings/billings/index/part/rec/ri/'.$ri.'/from/stud';
		                             }
		                       }
		                     else
		                      { echo CHtml::link($images,array('/billings/billings/index/part/rec/ri/'.$ri.'/from/stud')); 
		                         $this->back_url='/billings/billings/index/part/rec/ri/'.$ri.'/from/stud';
		                      }
		                      
                        }
                       
                   ?>
      </div> 
    </div>
 </div>


<div style="clear:both"></div>
	

<div class="b_m">
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'billings-form',
	//'enableAjaxValidation'=>true,
)); 
echo $this->renderPartial('_form', array(
	'model'=>$model,
	'form' =>$form
	)); ?> 


<?php $this->endWidget(); ?>

</div>
</div>


