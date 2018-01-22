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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];


if(!isAchiveMode($acad_sess))
  {
  	$eventClick = 'js:function(calEvent, jsEvent, view) { //alert(\'Event: \' + calEvent.title + \'\nStart Time: \' + calEvent.start);
        var day_ = moment(calEvent.start).isoWeekday();
         $("#myModalHeader").html("'.Yii::t("app","Course Detail").'");
         $("#myModalBody").load("'.Yii::app()->createUrl("/schoolconfig/scheduleAgenda/viewForAgenda/").'/?id="+ calEvent.id +"&day="+day_+"&asModal=true");
         $("#myModal").modal();
           
    		}';
    		
    $select =  'js:function(start,end, jsEvent, view) {
			/*	var allDay = !start.hasTime() && !end.hasTime();
             alert(["Event Start date: " + moment(start).format(),
                "Event End date: " + moment(end).format(),
                "AllDay: " + allDay].join("\n"));
             */   
               // var title = prompt("Event Title:");
                 var eventData;
				var sta_t=moment(start).format("hh:mm");
			    var end_t=moment(end).format("hh:mm");
			    var sta_day=moment(start).format("YYYY-M-D");
				 var day_ = moment(start).isoWeekday();
				 var week_ = moment(start).week();
				
				 $("#myModalHeader").html("'.Yii::t("app","Add course to agenda").'");
         $("#myModalBody").load("'.Yii::app()->createUrl("/schoolconfig/scheduleAgenda/addCourse/").'/?asModal=true&week="+week_+"&day="+day_+"&sta_d="+sta_day+"&t_start="+sta_t+"&t_end="+end_t+"&room='.$this->room_id.'");
         $("#myModal").modal();

                
                
			}';	
    		
  	 }
  else
    {  $select='';
         $eventClick='';
    	
    	}
  	 
  	 
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
         'editable'=>false,
        'selectable' => true,
        
        'eventLimit' => true, // allow "more" link when too many events
         
        'selectHelper' => true,
        'droppable' => false, // this allows things to be dropped onto the calendar
        
        'events'=> $this->createUrl('schedulesAgenda'), 
        
        'eventClick'=>$eventClick,
    	 
    	/*
    	eventRender: function (event, element) {
        element.attr('href', 'javascript:void(0);');
        element.click(function() {
            $("#startTime").html(moment(event.start).format('MMM Do h:mm A'));
            $("#endTime").html(moment(event.end).format('MMM Do h:mm A'));
            $("#eventInfo").html(event.description);
            $("#eventLink").attr('href', event.url);
            $("#eventContent").dialog({ modal: true, title: event.title, width:350});
        });
        */
      /*  
    	eventDrop: function(event, delta) {
            alert(event.title + ' was moved ' + delta + ' days\n' +
                '(should probably update your database)');
        },
          timeFormat: 'H:mm' ,
          */
        
        
         'select'=>$select,
			
			
					     
          
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
	
	
	
		
			