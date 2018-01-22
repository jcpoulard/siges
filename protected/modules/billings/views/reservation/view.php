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
/* @var $this ReservationController */
/* @var $model Reservation */



$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$part='reserv';

if(isset($_GET['part']))
{
	$part=$_GET['part'];
	}


?>


<div id="dash">
		<div class="span3"><h2>
		
		<?php   echo Yii::t('app','Reservation of').': '. $model->PersonFullName; ?> 
    
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

                     echo CHtml::link($images,array('reservation/create/part/'.$part)); 

                   ?>

              </div>

          <div class="span4">

                  <?php



                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('reservation/update','id'=>$model->id,'pers'=>$model->postulant_student,'part'=>$part)); 

                   ?>

              </div>  
              
  <?php
        }
      
      ?>       

         
            <div class="span4">

                  <?php



                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                         echo CHtml::link($images,array('reservation/index/part/'.$part)); 
					  
				?>

            </div> 

        </div>

</div>


<div style="clear:both"></div>



<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
		//'postulant_student',
		/*array(
                                    'header'=>Yii::t('app','Name'),
                                    'name' => 'Name',
                                    'type' => 'raw',
                                    'value'=>$model->PersonFullName,
                 ),
                 */
		//'Amount',
		array(
                                    'header'=>Yii::t('app','Amount Pay'),
                                    'name' => 'amount',
                                    'type' => 'raw',
                                    'value'=>$model->Amount,
                 ),
		//'payment_date',
		array(
                                    'header'=>Yii::t('app','Payment Date'),
                                    'name' => 'payment_date',
                                    'type' => 'raw',
                                    'value'=>ChangeDateFormat($model->payment_date),
                 ),
         
		//'paymentMethod.method_name',
		array(
                                    'header'=>Yii::t('app','Payment Method'),
                                    'name' => 'payment_method',
                                    'type' => 'raw',
                                    'value'=>$model->paymentMethod->method_name,
                 ),
  		'IsStudent',
		//'already_checked',
		'comments',
		//'academicperiods0.name_period',
		array(
                                    'header'=>Yii::t('app','Academic Year'),
                                    'name' => 'academic_year',
                                    'type' => 'raw',
                                    'value'=>$model->academicperiods0->name_period,
                 ),
		'create_by',
		//'date_created',
		array(
                                    'header'=>Yii::t('app','Date Created'),
                                    'name' => 'date_created',
                                    'type' => 'raw',
                                    'value'=>ChangeDateFormat($model->date_created),
                 ),
         'update_by',
		//'date_updated',
		array(
                                    'header'=>Yii::t('app','Date Updated'),
                                    'name' => 'date_updated',
                                    'type' => 'raw',
                                    'value'=>ChangeDateFormat($model->date_updated),
                 ),
		
	),
)); ?>
