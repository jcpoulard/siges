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
/* @var $this CalendarController */
/* @var $model Calendar */


?>

<div id="dash">
          
          
<div class="span3"><h2>

<?php echo Yii::t('app','Our Events'); ?></h2> </div>
     
		   <div class="span3">
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
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php 
          echo $model->c_title; ?></span></h2> </div>

<div style="clear:both"></div>


<div class="span5">
	
     <div class="CDetailView_photo" >
     	
<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'attributes'=>array(
	
		'description',
		'start_date',
		'end_date',
		'start_time',
		'end_time',
		
	),
)); ?>
</div>
</div>

<div  >
<?php

  //pou GWOSE EKRITI TIT LA
      /* cheche liy sa nan bootstrap.min.css: "h2{font-size:30px;line-height:40px}"
         ranplasel p[a liy sa: "h2{font-size:18px;line-height:27px}"
         
         */
    $this->widget('ext.fullcalendar.EFullCalendarHeart', array(
    'themeCssFile'=>'cupertino/jquery-ui.min.css',
      'lang'=>'fr',
     // raw html tags
    'htmlOptions'=>array(
        // you can scale it down as well, try 80%
        'style'=>'width:57%;float:left; '
         ),
         
       'options'=>array(
        'header'=>array(
            'left'=>'prev,next,today',
            'center'=>'title',
            'right'=>'month,agendaWeek,agendaDay',
        ),
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

