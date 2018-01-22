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
/* @var $this FeesController */
/* @var $model Fees */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];

?>



<div id="dash">
		<div class="span3"><h2>
		    <?php echo Yii::t('app','{name1} / {name2}',array('{name1}'=>$model->fee0->fee_label,'{name2}'=>$model->level0["level_name"])); ?>
		    
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

                     echo CHtml::link($images,array('fees/create')); 


                   ?>

             </div>
        <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('fees/update/','id'=>$model->id,'from'=>'view')); 

                     ?>

              </div>
    
<?php
        }
      
      ?>       

    
        <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('fees/index'));
                     
                   ?>

              </div>

       </div>
 </div>


<div style="clear:both"></div>


<br/>
  <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>


		

<?php
    		//error message 
        if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_u=true;
           
      	 
           
                				       
			if($this->message_u)		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ">';
				      	
				      	echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';			      
			      
			       echo '<span style="color:red;" >'.Yii::t('app','Cannot either update nor delete a fee which payment is already started.').'</span>';
				        $this->message_u=false;
				        echo'</td>
					    </tr>
						</table>';
					
				           echo '</div>
				           <div style="clear:both;"></div>';
				     }
				     			     	
				  
			
			       
?>
	
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'fee0.fee_label',
		'Amount',
		'level0.level_name',
		'academicPeriod.name_period',
		
        array('name'=>'date_limit_payment','value'=>$model->dateLimitPayment),
		'description',
		
	),
)); ?>
