<?php 
/* © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
 */?>
<?php

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'record-presence-form',
	'enableAjaxValidation'=>false,
));


 
?>
 
<div class="b_m">


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        

                           
     
      						<div class="span2" >
                                
                                <?php echo $form->errorSummary($model); ?>
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Room'));
                                        echo $form->dropDownList($model, 'room_attendance',CHtml::listData(Rooms::model()->findAll(),'id','room_name'),array('onchange'=> 'submit()','prompt'=>Yii::t('app','-- Please select room --'),'disabled'=>false,'options' => array($this->room_atten=>array('selected'=>true))));
                                    ?>
                                </div>
                                
                            </div>
                     
        </div>
    </div>





<div> 


</br>

<?php

    
    
   $month_ = 0;
    $day_ = 0;
    $month_display = 0;
    $student_ = "";
    $i = 0;
    $class = "";
     
     $stud_ = null;
     $stud_2 = null;
  if($this->room_atten!='')
   { $sql_attendance = "SELECT *  FROM record_presence  WHERE room = $this->room_atten ORDER BY date_record ASC";
    $stud_ = RecordPresence::model()->findAllBySql($sql_attendance);
    // Requete pour afficher les eleves 
    $sql_attendance2 = "SELECT *  FROM record_presence rp INNER JOIN persons p ON(p.id=rp.student) WHERE room = $this->room_atten ORDER BY p.last_name ASC, p.first_name ASC,date_record ASC";
    $stud_2 = RecordPresence::model()->findAllBySql($sql_attendance2);
    
    
    if($this->month_atten ==0) 
    {
       $sql_attendance_____ = 'SELECT date_record  FROM record_presence  WHERE room ='.$this->room_atten.' ORDER BY date_record DESC';
           $command__ = Yii::app()->db->createCommand($sql_attendance_____);
		  $result = $command__->queryAll(); 
													       	   
			if($result!=null) 
			 { foreach($result as $r)
			     { if($r['date_record']!='0000-00-00')
			          { $this->month_atten = $this->getMonthAttendance($r['date_record']);
			            
			          }
			       else
			        { $this->month_atten = $this->getMonthAttendance(date('Y-m-d'));
			           
			        }
			         
			          break;
			     }
			  }
			else
			  { $this->month_atten = $this->getMonthAttendance(date('Y-m-d'));
			      
			  }
			  
           $month_ = $this->month_atten;
       }
    
    
       	   $current_month = $this->month_atten;
       	 
    
    }
    
   
    
      
    
    function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
    
    //nav nav-pills // nav nav-tabs nav-justified // nav nav-tabs
 ?>

<ul class="nav nav-tabs nav-justified">  
<?php
  if($stud_!=null)
   { 
    foreach($stud_ as $s){
        
       if($i==0)
         { $i=1;
         $month_=$this->getMonthAttendance($s->date_record);
        
         if($month_!=$current_month)
             $class = "";
         else 
            $class = "active";
         
         echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/discipline/recordPresence/admin?room='.$this->room_atten.'&month_='.$month_.'&part=di">';    
            
            echo getShortMonth($this->getMonthAttendance($s->date_record)).' '.$this->getYearAttendance($s->date_record);
         echo'</a></li>';
         
         } 
      
       elseif($month_!=$this->getMonthAttendance($s->date_record))
         {
           $month_=$this->getMonthAttendance($s->date_record);
           if($month_!=$current_month)
             $class = "";
           else 
            $class = "active";
             
           echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/discipline/recordPresence/admin?room='.$this->room_atten.'&month_='.$month_.'&part=di">'; 
           
           
           echo getShortMonth($this->getMonthAttendance($s->date_record)).' '.$this->getYearAttendance($s->date_record);
           echo '</a></li>';
         
          }
      }
   
   }
    
?>
</ul>
<div class="grid-view">
<table class="items">
    <thead>
        <tr>
            <th><?php echo Yii::t('app','Name'); ?></th><th><?php echo Yii::t('app','Abs.'); ?></th><th><?php echo Yii::t('app','Tar.');?></th>
            <?php 
      
 if($stud_!=null)
   {   
    foreach($stud_ as $s){
                
       if($this->getMonthAttendance($s->date_record)==$current_month){
       if($i==0)
         { $i=1;
         $day_=$this->getDayAttendance($s->date_record);
        
         echo '<th>';    
            
            echo $this->getDayAttendance($s->date_record);
         echo'</th>';
         
         } 
      
       elseif($day_!=$this->getDayAttendance($s->date_record)){
           $day_=$this->getDayAttendance($s->date_record);
           
           echo '<th>'; 
           
           
           echo $this->getDayAttendance($s->date_record);
           echo '</th>';
         
       }
       }
      
     }
     
  }
            
            ?>
           
                
        </tr>
        </thead>
         <tbody>
        <?php
        $j=0;
        $line_number=1;
    if($stud_!=null)
      { 
        foreach ($stud_2 as $st){
            
        if($this->getMonthAttendance($st->date_record)==$current_month){  
            
         if($student_!=$st->student0->fullName){
             
             if($i==0)
         { $i=1;
         echo '<tr class="'.evenOdd($line_number).'">';
         
         }else echo '</tr><tr class="'.evenOdd($line_number).'">'; 
            
             echo '<td>';
           $student_=$st->student0->fullName;
           $student_id = $st->student;
           echo $student_;
           echo '</td><td><b>'.$model->getTotalAbsenceByMonth($current_month, $st->student, $acad_sess).'</b></td><td><b>'.$model->getTotalRetardByMonth($current_month, $st->student, $acad_sess).'</b></td>'; 
           echo '<td>';
           echo '<span data-toggle="tooltip" title="'.$model->getPresenceFull($this->getPresenceCode($st->student, $st->date_record)).'"> '.$model->getPresenceAbreviate($this->getPresenceCode($st->student, $st->date_record)).'</span>';
           echo'</td>';
           
          
         
       }
      else {
           echo '<td>';
           echo '<span data-toggle="tooltip" title="'.$model->getPresenceFull($this->getPresenceCode($st->student, $st->date_record)).'"> '.$model->getPresenceAbreviate($this->getPresenceCode($st->student, $st->date_record)).'</span>';
           echo'</td>';
           
       }
       
    }
    
       $line_number++;
      
     
         }
         
    }
       
       echo '</tr>';     
        
        
        
        ?>
         
             
             
         </tbody>
</table>
    
</div>    
</div> </div> 




<?php $this->endWidget(); ?>