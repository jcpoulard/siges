<div class="row span12">
    <div id="dash">
            <div class="span3"><h2><?php echo Yii::t('app','Custom report builder');  ?></h2></div>
            <div class="span3">       
         <div class="span4">
                  <?php

                 $images = '<i class="fa fa-bars">&nbsp;'.Yii::t('app','List reports').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('customReport/list?part=stud&from1=rpt'));
                 
                   ?>
        </div> 
           
        <div class="span4">
              <?php

                  $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('customReport/list?part=stud&from1=rpt')); 

               ?>
        </div>
     </div>
    </div>
    
    
    
</div>

<div style="clear:both"></div>

<div class="row-fluid">
<?php
    echo $this->renderPartial('//layouts/navCustomReport',NULL,true);	
 ?>
</div>
<div class="row-fluid">
    <div class="span12 well">
           <?php
            $form=$this->beginWidget('CActiveForm', array(
                'id'=>'custom-report-stud',
                'enableAjaxValidation'=>true,
                )); 
            ?>
          
            <div class="row-fluid">
                <div class="span3">
                    <label id="resp_form">
                        <label><?php echo Yii::t('app','Report title'); ?></label>
                        <input id="report_title" type="text" name="report_title" placeholder="<?php echo Yii::t('app','Report title'); ?>"/>
                    </label>
                </div>
                <div class="span3">
                    <label id="resp_form">
                        <label><?php echo Yii::t('app','Descripton'); ?></label>
                        <input id="report_title" type="text" name="report_description" placeholder="<?php echo Yii::t('app','Desription'); ?>"/>
                    </label>
                </div>
                <!-- A activer ulterieurement pour d'autres rapports
                <div class="span3">
                    <label id="resp_form">
                        <label><?php echo Yii::t('app','Report dimension'); ?></label>
                        <input type="radio" name="dimreport" id="grade" value="grade" checked="checked" /> <?php echo Yii::t('app','Grade'); ?>
                        <input type="radio" name="dimreport" id="age" value="discipline" /> <?php echo Yii::t('app','Discipline'); ?>
                        <input type="radio" name="dimreport" id="billing" value="billing" /> <?php echo Yii::t('app','Billings'); ?>
                    </label>
                </div>
                -->
                 <div class="span3">
                    <label id="resp_form">
                        <label><?php echo Yii::t('app','Academic year'); ?></label>
                        
                        <?php
                        $criteria = new CDbCriteria(array('condition'=>'is_year=1'));
                       
                        echo CHtml::dropDownList('academic_year','', CHtml::listData(AcademicPeriods::model()->findAll($criteria),'id','name_period'),
                            array(
                            'prompt'=>Yii::t('app','-- Please select year --'),    
                            'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>CController::createUrl('customReport/loadAcademicPeriod'), //url to call.
                            
                            'update'=>'#period_id', //selector to update
                            
                            ))); 
                        ?>
                        
                    </label>
                </div>
                
                <div class="span3">
                    <label id="lblAcaPeriod">
                        <label><?php echo Yii::t('app','Academic period'); ?></label>
                        <?php
                            echo CHtml::dropDownList('period_id','', array());
                        
                            ?>
                        
                    </label>
                </div>
                
                
            </div>
            
    
            <div class="row-fluid">
               
                
                <div class="span3">
                    <label id="resp_form">
                        <label><?php echo Yii::t('app','Report range'); ?></label>
                        <input type="radio" name="rangereport" id="all" value="all" checked="checked" /> <?php echo Yii::t('app','By Average'); ?>
                      
                        <input type="radio" name="rangereport" id="byroom" value="byroom" /> <?php echo Yii::t('app','By Course'); ?>
                    </label>
                </div>
                
                <div class="span3">
                    <label id="cmb_shift">
                        <label><?php echo Yii::t('app','Shift'); ?></label>
                           
                        
                        <?php
                        $criteria = new CDbCriteria(array('order'=>'shift_name'));
                       
                        echo CHtml::dropDownList('shift_id','', CHtml::listData(Shifts::model()->findAll($criteria),'id','shift_name'),
                            array(
                            'prompt'=>Yii::t('app','-- Please select shift --'),    
                            'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>CController::createUrl('customReport/loadRoomByShift'), //url to call.
                            
                            'update'=>'#room_name', //selector to update
                            
                            ))); 
                        ?>
                    </label>
                </div>
                <div class="span3">
                  <label id="cmb_room">
                        <label><?php echo Yii::t('app','Choose Room'); ?></label>
                        <?php
                        $criteria = new CDbCriteria(array('order'=>'room_name'));
                        echo CHtml::dropDownList('room_name','', array(),
                                 array(
                            'prompt'=>Yii::t('app','-- Please select room --'),    
                            'ajax' => array(
                            'type'=>'POST', //request type
                            'url'=>CController::createUrl('customReport/loadCourse'), //url to call.
                            
                            'update'=>'#course_id', //selector to update
                            
                            )));
                       
                        ?>
                     </label>
                 </div>
                <div class="span3" id="course_area">
                    <label>
                        <label><?php echo Yii::t('app','Choose course'); ?></label>
                        <?php
                            echo CHtml::dropDownList('course_id','', array());
                        
                            ?>
                    </label>
                </div>
                
    </div>
    
    <div id="pd_report">
           
    <!-- Quand on traite de la dimension notes -->
            <div class="row-fluid" id="dpy_note">
                
               
                <div class="span4">
                    <label>
                        <label><?php echo Yii::t('app','Have a grade : '); ?></label>
                        <select id="select_condition" name="rptCondition">
                            <option value=""><?php echo Yii::t('app','Choose a condition'); ?></option>
                            <option value="="><?php echo Yii::t('app','= (Equal)'); ?></option>
                            <option value=">"><?php echo Yii::t('app','> (Greater than)'); ?></option>
                            <option value="<"><?php echo Yii::t('app','< (Lesser than)'); ?></option>
                            <option value=">="><?php echo Yii::t('app','>= (Greater than or equal)'); ?></option>
                            <option value="<="><?php echo Yii::t('app','<= (Lesser than or equal)'); ?></option>
                            <option value="between"><?php echo Yii::t('app','Between'); ?></option>
                        </select>
                    </label>
                </div>
                <div class="span3" id="wholeValue">
                    <label>
                        <label><?php echo Yii::t('app','Grade Value') ?></label>
                        <input type="text" name="value_compare" placeholder="<?php echo Yii::t('app','Grade Value') ?>"/>
                    </label>
                </div>
                <div class="span3">
                        <label class="betweenValue">
                        <label><?php echo Yii::t('app','Grade from') ?></label>
                        <input type="text" name="betFrom" />
                        </label>
                    </div> 
                    <div class="span3">
                        <label class="betweenValue">
                       <label><?php echo Yii::t('app','Grade to') ?></label>
                        <input type="text" name="betTo" />    
                        </label>
                    </div>
                
            </div>
                  
                
    </div><!-- FIN DIV PARAM DETAIL REPORT pdReport --> 
   <br/> 
    <div class="row-fluid">
        
        <div class="span2">
            
        </div>
        <div class="span2">
            <?php
            echo CHtml::ajaxSubmitButton(
                    Yii::t('app','Preview report'),
                    array('customReport/previewReport'),
                    array(
                        'update'=>'#req_res02',
                        ), 
                    array('class' => "btn btn-primary",'name'=>'btnPreview','disabled'=>'disabled')
                    );
            ?>
        </div>
        
        <div class="span2" id="btnSaveZ">
            <button id=btnSave"" class="btn btn-success"  name="btnSave"><?php echo Yii::t('app','Save Report'); ?></button>
        </div>
        <div class="span2">
            <button class="btn btn-danger" name="btnCancel"><?php echo Yii::t('app','Cancel Report'); ?></button>
        </div>
        
        <div class="span2">
            
        </div>
        
    </div>
    
                 </div>
                
 </div>                 
 <!-- FIN de la dimension Notes -->           
            
    
 <div class="row-fluid">        
        
    <div class="span6 well">
        <div class="tst" style="height: 350px"></div>
    </div>
    <div class="span6 well">
        <div id="gauss_chart" style="height:350px;">
                
        </div>
     
    </div>
    
 </div> 

<div class="row-fluid">
  <div class="span6 well">  
    <div id="graph_pie" style="height: 350px">
         
     </div>
  </div>
         
<div class="span6 well" style="height: 350px">
    <div class="row-fluid">
                     <div class="span6">
                         <div class="box2 box2-default">
                             <div class="box-header with-border box-primary">
                                 <h5 class="box-title"><?php echo Yii::t('app','Average of sample') ?></h5>
                                 <div class="box-tools pull-right"></div>
                             </div>
                             
                             <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
				<i class="fa fa-bar-chart "></i>
                               <div class="box-tools pull-right" id="sample_avg"></div>
                            </div>
                         </div>
                     </div>
                     
                      <div class="span6">
                         <div class="box2 box2-default">
                             <div class="box-header with-border">
                                 <h5 class="box-title"><?php echo Yii::t('app','S.D. of sample') ?></h5>
                                 <div class="box-tools pull-right"></div>
                             </div>
                             
                             <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
				<i class="fa fa-bar-chart "></i>
                               <div class="box-tools pull-right"  id="sample_stdv"></div>
                            </div>
                         </div>
                     </div>
        </div>
    <div class="row-fluid">             
                     <div class="span6">
                         <div class="box2 box2-default">
                             <div class="box-header with-border">
                                 <h5 class="box-title"><?php echo Yii::t('app','Max') ?></h5>
                                 <div class="box-tools pull-right"></div>
                             </div>
                             
                             <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
				<i class="fa fa-bar-chart "></i>
                               <div class="box-tools pull-right"  id="sample_max"></div>
                            </div>
                         </div>
                     </div>
                     
                     <div class="span6">
                         <div class="box2 box2-default">
                             <div class="box-header with-border">
                                 <h5 class="box-title"><?php echo Yii::t('app','Min') ?></h5>
                                 <div class="box-tools pull-right"></div>
                             </div>
                             
                             <div class="box2-body" style="vertical-align: center; alignment-adjust: middle;  color:#EE6539; clear: both;">           
				<i class="fa fa-bar-chart "></i>
                               <div class="box-tools pull-right"  id="sample_min"></div>
                            </div>
                         </div>
                     </div>
    </div>                 
                 </div>
   </div>
   
<div id="req_res02" class="well">...</div>
    <?php $this->endWidget(); ?>
    

<script>
    
    /*
     * Choose with jquery what list to display 
     */
    $(document).ready(function(){
        // For report range
      //  $("#cmb_shift").hide();
      //  $("#cmb_room").hide();
       // $("#pd_report").hide();
       $("#course_area").hide();
        $(".betweenValue").hide();
        $("#btnSaveZ").hide();
        
        $("#all").click(function(){
            $("#course_area").hide();
           // $("#cmb_room").hide();
           // $("#pd_report").hide();
    });
    
    
    
    $("#byroom").click(function(){
       // $("#cmb_shift").show();
      //  $("#cmb_room").show();
       // $("#pd_report").show();
        $("#course_area").show();
    });
    
   
    
    
   // $("#lblAcaPeriod").hide();
    
    $("#academic_year").click(function(){
       $("#lblAcaPeriod").show(); 
    });
    
    // Activer le bouton save report 
    
    $("#btnPreview").click(function(){
        $("#btnSaveZ").show();

    });
    
   // aktive bouton yo le moun nan ekri yon bagay nan tit la 
    $('#btnPreview').attr('disabled',true);
    
    $('#report_title').keyup(function(){
        if($(this).val().length !=0){
            $('#btnPreview').attr('disabled', false);
            
        }
        
        else
        {
            $('#btnPreview').attr('disabled', true);        
        }
    })
   
   
});

var conditions = jQuery('#select_condition');
var select = this.value;
conditions.change(function () {
    if ($(this).val() === 'between') {
        $('.betweenValue').show();
        $('#wholeValue').hide();
    }
    else { 
        $('.betweenValue').hide();
        $('#wholeValue').show();
    } // hide div if value is not "between"
    
});

</script>