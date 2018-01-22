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
 $exam_period='';
 
  $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
   
   
 function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
?>
<div id="dash">
		<div class="span3">
                    <h2>
		    <?php   
                    
                    echo CHtml::link($model->student0->fullName,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$model->student0->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")));                     
                    ?>
		    
		</h2> 
                </div>
		
    <div class="span3">
         
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {     
        
   ?>

         
             <div class="span4">

                  <?php

                      $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('recordInfraction/create')); 


                   ?>

             </div>
             
        <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('recordInfraction/update/','id'=>$model->id,'from'=>'view')); 

                     ?>

               </div>

 <?php
        }
      
      ?>       

        <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('recordInfraction/index'));
                     
                   ?>

              </div>

       </div>
 </div>

<div style="clear:both"></div>


<div class="span3"></div>
<div style="clear:both"></div>

<!-- La ligne superiure  -->

<div class="row-fluid">
       

    
<div class="span3 grid-view">

<div style="background-color:#EDF1F6; color:#F0652E; border:1px solid #DDDDDD; padding:5px;">
        <?php
        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'view-infraction-form',
	'enableAjaxValidation'=>true,
));
        ?>
           <label for="period_name" style="font-weight:bold;"><?php echo Yii::t('app','Choose an exam period') ?></label> 
       
 <?php       
        $criteria = new CDbCriteria;
			
	
	$criteria->condition = 'is_year = 0 AND ((date_start<=\''.date('Y-m-d').'\' AND date_end>=\''.date('Y-m-d').'\') OR (date_end<\''.date('Y-m-d').'\')) AND year='.$acad_sess;
        
        $criteria->order = 'date_end ASC';
        echo $form->dropDownList($model_d, 'exam_period',CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),array('onchange'=> 'submit()','options' => array($this->exam_period=>array('selected'=>true))));
        ?>
        
        <?php $this->endWidget(); ?>
    </div>
    
    <div>

 <strong><?php 
         
         if($model->searchCurrentExamPeriod(date('Y-m-d'))!=null){
                           
	                  echo Yii::t('app','Discipline summary :  {name} ', array('{name}'=>AcademicPeriods::model()->findByPk($this->exam_period)->name_period));
                            }
                          else
	                    echo Yii::t('app','Discipline summary :  {name} ', array('{name}'=>null));
	                    
	                    ?></strong>
    </div>
    <table class="detail-view table table-striped table-condensed">
        <tr class="odd">
        <?php 
        echo '<th>';
        echo Yii::t('app','Discipline grade : ');
        echo '</th>';
        if($model->searchCurrentExamPeriod(date('Y-m-d'))!=null)
          $exam_period = $model->searchCurrentExamPeriod(date('Y-m-d'))->id;
        else
           $exam_period = '';
        echo '<td>';
        if($exam_period != '')
           echo $model->getDisciplineGradeByExamPeriod($model->student0->id,$this->exam_period);
         else
           echo Yii::t('app','N/A');
        echo '</td>';
        ?> 
         
        </tr>
        <tr class="even">
        <?php 
        echo '<th>';
        echo Yii::t('app','Number of tardy : '); 
        echo '</th>';
         
        if($exam_period != '')
           $total_retard = RecordPresence::model()->getTotalRetardByExam($this->exam_period, $model->student0->id, $acad_sess);
        else
           $total_retard = Yii::t('app','N/A');
           
        echo '<td>';
        echo $total_retard;
        echo '</td>';
        ?> 
        </tr>
        
        <tr class="odd">
    
        <?php 
         echo '<th>';
        echo Yii::t('app','Number of absence : '); 
         echo '</th>';
        if($exam_period != '')
           $total_absence = RecordPresence::model()->getTotalPresenceByExam($this->exam_period, $model->student0->id, $acad_sess);
        else
           $total_absence = Yii::t('app','N/A');
           
        echo '<td>';
        echo $total_absence;
        echo '</td>';
        ?> 
        </tr>
        
        <tr class="even">
    
        <?php 
         echo '<th>';
        echo Yii::t('app','Number of infraction : '); 
         echo '</th>';
        if($exam_period != '')
           $total_number_absence = $model->numberOfInfraction($model->student0->id,$this->exam_period);
        else
           $total_number_absence = Yii::t('app','N/A');
           
        echo '<td>';
        
        echo $total_number_absence;
        echo '</td>';
        ?> 
        </tr>
        
    </table>

</div>

<div class="span6 grid-view">
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		
		
		'infractionType.name',
		'record_by',
		'incidentDate',
                'value_deduction',
		
	),
)); ?>
        <table class="detail-view table table-striped table-condensed">
            <tr class="odd">
                <th>
                    <?php echo Yii::t('app','Incident Description'); ?>
                </th>
                <td>
                    <?php echo '<span class="btn-link"  data-toggle="modal" data-toggle="tooltip" data-target="#incident" title="'.$model->incident_description.'"> '.Yii::t('app','See details').'</span>'; ?>
                </td>
            </tr>
            <tr class="even">
                <th>
                    <?php echo Yii::t('app','Decision Description'); ?>
                </th>
                <td>
                   
                    <?php 
                    if($model->decision_description !='') {
                        echo '<span class="btn-link"  data-toggle="modal" data-toggle="tooltip" data-target="#decision" title="'.$model->decision_description.'"> '.Yii::t('app','See details').'</span>';
                    }
                        else echo ''; ?>
                </td>
            </tr>
            
            <tr class="odd">
                <th>
                    <?php echo Yii::t('app','General Comment'); ?>
                </th>
                <td>
                   <?php 
                   if($model->general_comment!='') {
                       echo '<span class="btn-link"  data-toggle="modal" data-toggle="tooltip" data-target="#comment" title="'.$model->general_comment.'"> '.Yii::t('app','See details').'</span>';
                       
                        } 
                   else echo ''; ?>
                </td>
            </tr>
        </table>
        
</div>
    
    
           
    
<div class="span2 photo_view">
    <?php
    $modelStud = new Persons;
    if($modelStud->ageCalculator($model->student0->birthday)!=null)
         	  echo '<strong>'.$modelStud->ageCalculator($model->student0->birthday).Yii::t('app',' yr old').' / '.$modelStud->getRooms($model->student0->id, $acad_sess).'</strong>';
         	else
         	  echo $modelStud->getRooms($model->student0->id, $acad_sess).' ';
    if($model->student0->image!=null)
                    
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/documents/photo-Uploads/1/'.$model->student0->image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
    ?>


    
</div>
      
</div>

<div style="clear:both"></div>
 <!-- Seconde ligne -->
 
 
<div class="row-fluid">
  
    <div>   
        <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">  <?php echo Yii::t('app','Infraction list'); ?></a></li>
   
    <li><a data-toggle="tab" href="#menu2"><?php echo Yii::t('app','Attendance Journal'); ?></a></li>
    
        </ul>
        

    <?php
     $modelInfraction = new RecordInfraction;
     $all_infraction = $modelInfraction->searchStudent($acad_sess, $model->student0->id)->getData();
     $i=0;
         
    ?>
    <div class="tab-content">
    <div id="home" class="tab-pane fade in active">    
        
   <div class="grid-view">    
    <table class="items">
        <thead>
        <tr>
        <th style="width:5px;">
           <?php echo Yii::t('app','#'); ?> 
        </th>
        
         <th style="width: 20px;">
           <?php echo Yii::t('app','Incident Date'); ?> 
        </th>
        
        <th style="width: 80px;">
           <?php echo Yii::t('app','Infraction type'); ?> 
        </th>
        
       
        
        <th style="width: 100px;">
           <?php echo Yii::t('app','Incident Description'); ?> 
        </th>
        
        <th style="width: 100px;">
           <?php echo Yii::t('app','Decision Description'); ?> 
        </th>
        
        <th style="width: 30px;">
           <?php echo Yii::t('app','Value Deduction'); ?> 
        </th>
        
        </tr>
        </thead>
        <?php
       
             foreach($all_infraction as $ai){
        ?>
        <tr class="<?php echo evenOdd($i); ?>">
            <td style="width:5px;"><?php echo $i+1; ?></td>
            <td style="width:20px;"><a href="<?php echo $ai->id;  ?>"><?php  echo $model->getDateFormate($ai->incident_date); ?></a></td>
            <td style="width:80px;"><a href="<?php echo $ai->id;  ?>"><?php  echo $ai->infractionType->name; ?></a></td>
            
            <td style="width:100px;"><?php  echo $ai->incident_description; ?></td>
            <td style="width:100px;"><?php  echo $ai->decision_description; ?></td>
            <td style="width:20px;"><?php  echo $ai->value_deduction; ?></td>
        </tr>
             <?php 
             $i++;
             
        } 
          ?>
     
    </table>
   </div>
    </div>
    
        
        <!-- Second tab -->
        <div id="menu2" class="tab-pane fade">
      
          <div style="clear:both"></div>
          
          <div>
    
    <?php
     $modelPresence = new RecordPresence;
     $all_presence = $modelPresence->searchStudent($acad_sess, $model->student0->id)->getData();
     $j=0;
         
    ?>
   <div class="grid-view">    
    <table class="items">
        <thead>
        <tr>
        <th>
           <?php echo Yii::t('app','#'); ?> 
        </th>
        
        <th>
           <?php echo Yii::t('app','Presence type'); ?> 
        </th>
        
        <th>
           <?php echo Yii::t('app','Record date'); ?> 
        </th>
        
        
        </tr>
        </thead>
        <?php
       
             foreach($all_presence as $ap){
        ?>
        <tr class="<?php echo evenOdd($j); ?>">
            <td><?php echo $j+1; ?></td>
            <td><a href="<?php echo Yii::app()->baseUrl;?>/index.php/discipline/recordPresence/view/id/<?php echo $ap->id;  ?>"><?php  echo $ap->presence; ?></a></td>
            <td><?php  echo $model->getDateFormate($ap->date_record); ?></td>
           
        </tr>
             <?php 
             $j++;
             
        } 
          ?>
     
    </table>
   </div>
</div>
  
    </div>
        </div>
</div>
</div>
 
 
 <!-- Modal description incident -->
  <div class="modal fade" id="incident" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo Yii::t('app','Incident Description'); ?></h4>
        </div>
        <div class="modal-body">
        <?php echo $model->incident_description; ?>
            
        <!-- Fin contenu modal -->  
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app','Close'); ?></button>
        </div>
      </div>
    </div>
  </div>
 
 <!-- Modal description decision/sanction -->
  <div class="modal fade" id="decision" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo Yii::t('app','Decision Description'); ?></h4>
        </div>
        <div class="modal-body">
        <?php echo $model->decision_description; ?>
            
        <!-- Fin contenu modal -->  
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app','Close'); ?></button>
        </div>
      </div>
    </div>
  </div>
 
 <!-- Modal Commentaire -->
  <div class="modal fade" id="comment" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo Yii::t('app','General comment'); ?></h4>
        </div>
        <div class="modal-body">
        <?php echo $model->general_comment; ?>
            
        <!-- Fin contenu modal -->  
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app','Close'); ?></button>
        </div>
      </div>
    </div>
  </div>
  