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
//$model = new RecordInfraction;
 $exam_period;
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
		    
		    
		</h2> 
                </div>
		
    <div class="span3">
             
        <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('recordInfraction/index'));
                     
                   ?>

              </div>

       </div>
 </div>

<div style="clear:both"><br/></div>


<!-- La ligne superiure  -->

<div class="row-fluid">
       

    
<div class="span9 grid-view">
    <div>
      
        <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#home">  <?php echo Yii::t('app','Infraction list'); ?></a></li>
    <li><a data-toggle="tab" href="#menu1"><?php echo Yii::t('app','Discipline summary : << {name} >>', array('{name}'=>$model->searchCurrentExamPeriod(date('Y-m-d'))->name_period)); ?></a></li>
   
    <li><a data-toggle="tab" href="#menu2"><?php echo Yii::t('app','Attendance Journal'); ?></a></li>
    
        </ul>
        

    <?php
     $modelInfraction = new RecordInfraction;
     $all_infraction = $modelInfraction->searchStudent($acad, $this->person_id)->getData();
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
            <td style="width:20px;"><?php  echo $model->getDateFormate($ai->incident_date); ?></td>
            <td style="width:80px;"><?php  echo $ai->infractionType->name; ?></td>
            
            <td style="width:90px;"><?php  echo $ai->incident_description; ?></td>
            <td style="width:90px;"><?php  echo $ai->decision_description; ?></td>
            <td style="width:20px;"><?php  echo $ai->value_deduction; ?></td>
        </tr>
             <?php 
             $i++;
             
        } 
          ?>
     
    </table>
   </div>
    </div>
        
        <div id="menu1" class="tab-pane fade">
            
       <div class="grid-view">     
	
    <table class="detail-view table table-striped table-condensed">
        <tr class="odd">
        <?php 
        echo '<th>';
        echo Yii::t('app','Discipline grade : ');
        echo '</th>';
        $exam_period = $model->searchCurrentExamPeriod(date('Y-m-d'))->id;
        echo '<td>';
        echo $model->getDisciplineGradeByExamPeriod($this->person_id, $exam_period);
        echo '</td>';
        ?> 
         
        </tr>
        <tr class="even">
        <?php 
        echo '<th>';
        echo Yii::t('app','Number of tardy : '); 
        echo '</th>';
       
        $total_retard = RecordPresence::model()->getTotalRetardByExam($exam_period, $this->person_id, $acad);
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
        $total_absence = RecordPresence::model()->getTotalPresenceByExam($exam_period, $this->person_id, $acad);
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
        $total_number_absence = $model->numberOfInfraction($this->person_id,$exam_period);
        echo '<td>';
        
        echo $total_number_absence;
        echo '</td>';
        ?> 
        </tr>
        
    </table>

       </div>
        </div>
    
    
        
        <!-- Second tab -->
        <div id="menu2" class="tab-pane fade">
      
    
    
    <?php
     $modelPresence = new RecordPresence;
     $all_presence = $modelPresence->searchStudent($acad, $this->person_id)->getData();
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
            <td><?php  echo $ap->presence; ?></td>
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

<div style="clear:both"></div>