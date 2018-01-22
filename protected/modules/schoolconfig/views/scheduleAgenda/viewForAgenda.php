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

$acad_ses=acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];
?>
    
<?php
/* @var $this ScheduleAgendaController */
/* @var $model ScheduleAgenda */


?>

<div id="dash">
          
          <div class="span3"><h2>
 <?php echo Yii::t('app','{name}', array('{name}'=>$model->c_description)); ?>

</h2> </div>
        
         
</div>



     	
<?php 
         $day = 2000;
         
         if(isset($_GET['day'])&&($_GET['day']!=''))
            $day = $_GET['day'];
            

$this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	
		//'c_description',
		array('name'=>'start_date','value'=>'('.getLongDay($day).') '.$model->startDate),
		//'endDate',
		'start_time',
		'end_time',
		
	),
)); ?>

<div class="b_mail">
<div class="form">

<div class="grid-view">
<div  id="resp_form_siges">

 <?php 
    if(!isAchiveMode($acad_sess))
     {
       if(!isset($_GET['indx']))
         {
?>  
        <form  id="resp_form">
            <div class="col-submit">
 
        <input type="hidden" name="agenda" id="agenda" value= "<?php echo $model->id; ?>" / >                        
                                <?php 
                                         echo CHtml::submitButton(Yii::t('app', 'Delete'),array('name'=>'delete', 'class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                        
                                                                                  

                                ?>
     
                            
                  </div>
      </form>
      
        <?php   } 
        
             }
         ?>
              </div>
          </div>
          
  </div>
          </div>    
          