
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


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));


$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];


 ?>

     
      <div class="span3" style="margin-left:0px;" >                        

                           
     
      						   
                                <div class="left" >
                                   <?php  $modelRoom = new Rooms;
			                             //echo $form->labelEx($modelRoom,Yii::t('app','Room')); 
			                     ?>
			          <?php 
					
					     	if(isset($this->room_id)&&($this->room_id!=''))
							   { 
						          echo $form->dropDownList($modelRoom,'room_name',$this->loadRoom($acad), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom,'room_name',$this->loadRoom($acad), array('onchange'=> 'submit()')); 
							          //echo $this->room_id;
									 $this->room_id=0;
							      }
		                   
		                   
							      
							      
						echo $form->error($modelRoom,'room_name'); 
						
										
					   ?>

                                </div>
                                
                           
                     
        </div>
   
	
<div style="clear:both"></div>


<div id="print_receipt" style="float:left; padding:10px; border:1px solid #EDF1F6; width:98%; ">
                 
          <?php 
                                            
           echo '<div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Tax reports'), pa_daksan() )).'</b>  </div> '; 
			
			echo '<br/>';
                


		 echo '<table style="font-size:12px; background-color:#F4F6F6;">
		           <tr>
		               <td style="width:50px; "></td><td style="width:150px; "></td>';
		               
		      $column_number =0;     
		      
		      $room_array=$modelRoom->findAll(array('alias'=>'r',
									 'select'=>'*',
									 'distinct'=>true,
                                     'join'=>'left join room_has_person rh on(rh.room=r.id)',
									 'condition'=>'rh.academic_year=:acad ',
                                     'params'=>array(':acad'=>$acad,),
									 'order'=>'r.room_name',
                               ));
            
		   	  
		         foreach($room_array as $room)
		           {
		           	   $column_number++;
		                 	echo '<td style="width:70px; text-align:center;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'.$room->short_room_name.'</b></td>';
		           	}
		           	
		           	echo '</tr>';
		           	$column_number = $column_number+1;
		   		 for($i=1; $i<=7; $i++)
		           { 
		            	$d1 = '2016-05-10';
		            	$d2 = '2016-05-15';
		            	
		            	$day_start = strtotime($d1);//DateTime::createFromFormat('Y-m-d', '2016-05-10');
		            	$day_end = strtotime($d2);//DateTime::createFromFormat('Y-m-d', '2016-05-15');
		                 	
		               for($j=$day_start; $j<=$day_end; $j+=86400 )
		                 {	 
		                 	$date_ = date("Y-m-d",$j);
		                 	$d = DateTime::createFromFormat('Y-m-d', $date_);
		                 	  //seaching times
		                 	  
		                    $sch_times = ScheduleAgenda::model()->searchTimesByDate($date_);
		                        
		                 	
		                 	$nb_line = sizeof($sch_times);
		                 	
		                 	$day = getShortDay($i);      
		                 	
		                 	$pass =1;
		                       
		                  if($nb_line>0)         
		                    {    foreach($sch_times as $times )
		                          { 
		                          	echo '<tr>';  
		                          	  
		                          	  if($pass==1)
		                          	    { echo '<td rowspan="'.$nb_line.'" style=" text-align:left;  background-color: #F1F1F1; border-left: 1px solid #FFFFFF;"><b>'; 
		         echo getLongDay($i);   
		                       echo '</b></td>';    	    
		                          	    }
		         
		                             $pass++;
		         
		   // echo $day.'-----'.getDay($d).'-----'.getShortDay(getDay($d) ).'-----'.$times["start_time"];
		                          	
		                          	  //echo $day_given_date->format('D');
		                            if($day==$d->format('D') ) 
		                              {     
		                          	
		                          	      echo '<td style="width:150px; border:solid 1px blue;">'.$times["start_time"].' - '.$times["end_time"].'</td>';
		                             
			                             foreach($room_array as $room)
			                               {
			                               	  echo '<td  style=" text-align:center; width:70px; border:solid 1px blue;">';
			                               	    
			                               	     //retreive course name   $day_given_date
		                                          $sch_course_name = ScheduleAgenda::model()->searchDescriptionByDate($date_,$times["start_time"],$times["end_time"]);
		                                          foreach($sch_course_name as $course )
		                                             echo $course["c_description"];
		                                          
			                               	  echo '</td>';
			                                 }
		                                 
		                              
		                                 }
		                              
		                            echo '</tr>';
		                            
		                           }
		                         
		                       }
		                           
		                         
		                        }
		                     
		                            
		                        
                              }  
		                 	
		                 
		  
		 
		echo ' </table>
<div style="float:right; text-align: right; font-size: 6px; margin-top:40px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>		
		</div>';
	  
  
 
 
 
  
  ?> 
      	         
		           	
              
  </label > 
      
	        
</div>        

  	
<div class="span12" style="margin-left:0px; width:100%; margin-top:20px;" >


<?php

  //pou GWOSE EKRITI TIT LA
      /* cheche liy sa nan bootstrap.min.css: "h2{font-size:30px;line-height:40px}"
         ranplasel pa liy sa: "h2{font-size:18px;line-height:27px}"
         
         */
  
 $agenda_duration = infoGeneralConfig('agenda_duration'); 
   
   if($agenda_duration == null)
   {  
     	$duration =30;
   	}
   else
    {
     if($agenda_duration==1) 
       $duration =10; 
     elseif($agenda_duration==2) 
       $duration =15; 
       elseif($agenda_duration==3) 
       $duration =30;   
      
      } 
              
     $slotDuration = '00:'.$duration.':00';



    
    $shift_time_start= null;
	$shift_time_end = null;
							
	$timeShift=Shifts::model()->searchTimesByRoomId($this->room_id);
	if(isset($timeShift))
	  { $ts=$timeShift->getData();
		 foreach($ts as $t)
		   { 
              $shift_time_start = $t->time_start;
			  $shift_time_end = $t->time_end;
			}
							   
		}
							  
		                                                                                                                                                                                                                                                                                                                      
    $this->widget('ext.fullcalendar.FullCalendar', array(
    'themeCssFile'=>'cupertino/jquery-ui.min.css',
      'lang'=>'fr',
     // raw html tags
    'htmlOptions'=>array(
        // you can scale it down as well, try 80%
        'style'=>'width:100%; float:left; '
         ),
         
       'options'=>array(
        'header'=>array(
            'left'=>'prev,next,today',
            'center'=>'title',
           // 'right'=>'agendaWeek',
        ),
        
        'weekends' =>true, // will hide Saturdays and Sundays
        'defaultView'=>'agendaWeek',
        'scrollTime'=>'08:00:00',
        'minTime'=>$shift_time_start,
        'maxTime'=>$shift_time_end,
        'slotEventOverlap'=>false,
        'slotDuration'=>$slotDuration,
        //'snapDuration'=>1,
       // 'slotWidth'=>,
        // 'editable'=>false,
        //'selectable' => true,
        
        'eventLimit' => true, // allow "more" link when too many events
         
        'selectHelper' => true,
        'droppable' => false, // this allows things to be dropped onto the calendar
        
        'events'=> $this->createUrl('schedulesAgenda'), 
        
        'eventClick'=>'js:function(calEvent, jsEvent, view) { //alert(\'Event: \' + calEvent.title + \'\nStart Time: \' + calEvent.start);
        var day_ = moment(calEvent.start).isoWeekday();
         $("#myModalHeader").html("'.Yii::t("app","Course Detail").'");
         $("#myModalBody").load("'.Yii::app()->createUrl("/schoolconfig/scheduleAgenda/viewForAgenda/").'/?id="+ calEvent.id +"&day="+day_+"&indx=0&asModal=true");
         $("#myModal").modal();
           
    		}',
    	 	
             
          
    )
    
    
));

 

?>
<?php $this->beginWidget(
    'bootstrap.widgets.TbModal',
    array('id' => 'myModal')
); ?>
 
  

		
    <div class="modal-header">
        <a class="close" data-dismiss="modal">&times;</a>
        <h4 id="myModalHeader">Modal header</h4>
    </div>
 
    <div class="modal-body" id="myModalBody">
        <p>One fine body...</p>
    </div>
 
    <div class="modal-footer">
        <?php 
        
        /* $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => Yii::t('app','Close'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
            
         ); 
        */
       ?>
        
        
    </div>
 
<?php $this->endWidget(); ?>
</div>
	
	
	
		
			