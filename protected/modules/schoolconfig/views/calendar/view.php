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
/* @var $this CalendarController */
/* @var $model Calendar */

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

?>

<div id="dash">
          
          <div class="span3"><h2> <?php echo Yii::t('app','Our Events'); ?>

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

                     echo CHtml::link($images,array('calendar/create')); 

                   ?>

              </div>    
            <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('calendar/update/','id'=>$model->id)); 

                     ?>

              </div>    

      <?php
                 }
      
      ?>       


     <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('calendar/index')); 

                   ?>

            </div> 



       </div>
</div>

<div style="clear:both"></div>
<div id="dash" style="width:auto; float:left;">
		<h2> <span class="fa fa-2y" style="font-size: 19px;"><?php 
          echo $model->c_title; ?></span>  </div>

<div style="clear:both"></div>


<div class="span5">
	
     <div class="CDetailView_photo" >
     	
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	
		'description',
		array('name'=>'start_date','value'=>$model->startDate),
		
		array('name'=>'end_date','value'=>$model->endDate),
		
		//'start_time',
		//'end_time',
		
	),
)); ?>
</div>
</div>

<div  >
<?php

  //pou GWOSE EKRITI TIT LA
      /* cheche liy sa nan bootstrap.min.css: "h2{font-size:30px;line-height:40px}"
         ranplasel pa liy sa: "h2{font-size:18px;line-height:27px}"
         
         */
     $criteria = new CDbCriteria;
                                   $criteria->condition='item_name=:item_name';
								   $criteria->params=array(':item_name'=>'agenda_duration',);
								   $agenda_duration = GeneralConfig::model()->find($criteria)->item_value;  
								   
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
								    
								    
    $this->widget('ext.fullcalendar.FullCalendar', array(
    'themeCssFile'=>'cupertino/jquery-ui.min.css',
      'lang'=>'fr',
     // raw html tags
    'htmlOptions'=>array(
        // you can scale it down as well, try 80%
        'style'=>'width:57%;float:left; background: #ECF0F5 '
         ),
         
       'options'=>array(
        'header'=>array(
            'left'=>'prev,next,today',
            'center'=>'title',
            'right'=>'month,agendaWeek,agendaDay',
        ),
        // 'slotDuration'=>$slotDuration,
         'editable'=>true,
        'selectable' => true, 
        'events'=> $this->createUrl('calendarEvents'), 
        'eventClick'=>'js:function(calEvent, jsEvent, view) { //alert(\'Event: \' + calEvent.title + \'\nStart Time: \' + calEvent.start);
         $("#myModalHeader").html("'.Yii::t("app","Event Detail").'");
         $("#myModalBody").load("'.Yii::app()->createUrl("/schoolconfig/calendar/viewForIndex/id/").'/"+ calEvent.id +"?asModal=true");
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
        <?php $this->widget(
            'bootstrap.widgets.TbButton',
            array(
                'label' => Yii::t('app','Close'),
                'url' => '#',
                'htmlOptions' => array('data-dismiss' => 'modal'),
            )
        ); ?>
    </div>
 
<?php $this->endWidget(); ?>
</div>

