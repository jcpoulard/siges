<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
// Test commit 
//print_r($data);


  
$acad=Yii::app()->session['currentId_academic_year']; 



$display_period_summary = infoGeneralConfig('display_period_summary');
$lastEvaluation_done = false;



function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
 $currency_symbol = Yii::app()->session['currencySymbol'];
//print_r($data_periode);
?>

<?php 
            if(isset(Yii::app()->user->profil) && isset(Yii::app()->user->groupid)){
                $profil = Yii::app()->user->profil; 
                $group_id = Yii::app()->user->groupid; 
                $group_name = Groups::model()->findByPk($group_id)->group_name;
                if((($profil=="Admin" || $profil == "Manager") || ($group_name == "Direction" || $group_name == "Administrateur systeme")) || $profil=="Billing"){
            
        ?>

<div class="row-fluid">
    
    <div>
        <div class="span4" style="align-content: center">
            <div class="clear"></div>
            <div style="text-align: center"><text x="181" text-anchor="middle" class="highcharts-title" zIndex="4" style="color:#333333;font-size:18px;fill:#333333;width:297px;" y="24"><tspan><b><?php echo Yii::t('app','Billing: {name}',array('{name}'=>$room_name));?></b></tspan></text></div>
            <div id="stat1" style="min-width: 20px; height: 250px; margin: 0 auto">
            </div>
        </div>
    <div class="span4" id="stat2" style="min-width: 20px; height: 300px; margin: 0 auto">
        
    </div>
    <div class="span4" id="stat3" style="min-width: 200px; height: 300px;  margin: 0 auto">
       
    </div>
</div>
</div>
                <?php }elseif($group_name=="Developer"){
                     
                ?>

                <div class="row-fluid">
                    
                    
                    <div class="span4" style="align-content: center">
                        <div class="clear"></div>
                        <div style="text-align: center"><text x="181" text-anchor="middle" class="highcharts-title" zIndex="4" style="color:#333333;font-size:18px;fill:#333333;width:297px;" y="24"><tspan><b><?php echo Yii::t('app','Billing: {name}',array('{name}'=>$room_name));?></b></tspan></text></div>
                        <div id="stat1" style="min-width: 20px; height: 250px; margin: 0 auto">
                        </div>
                    </div>
                    <div class="span4" id="stat2" style="min-width: 20px; height: 300px;  margin: 0 auto">
                        
                    </div>
                    
                    
                   <!-- <div class="span4" id="stat3" style="min-width: 100%; height: 100%;  margin: 0 auto"> -->
                     <div id="stat3" style="min-width: 20px; height: 300px; overflow-y: auto; background-color: rgb(255, 255, 255);">   
                        
                    </div>
                </div>

                <?php     
                } else { ?>

<div class="row-fluid">
    
    
    <div class="span6" id="stat2" style="min-width: 20px; height: 300px;  margin: 0 auto">
        STAT 2
    </div>
    <div class="span6" id="stat3" style="min-width: 20px; height: 300px;  margin: 0 auto">
        STAT 3
    </div>
</div>

            <?php }}  ?>

<div id="dvData">
<div class="grid-view" id="table-container" >
    
<table id="maintable" class="scroll table-striped table-bordered table-hover table-condensed">
    <thead>
        
    <tr>
        <th style="width: 50px; background-color: #00E4C1;"></th>
        <th style="width: 250px; background-color: #00E4C1;"><?php echo Yii::t('app','Students');?></th>
        <?php 
            if(isset(Yii::app()->user->profil) && isset(Yii::app()->user->groupid)){
                $profil = Yii::app()->user->profil; 
                $group_id = Yii::app()->user->groupid; 
                $group_name = Groups::model()->findByPk($group_id)->group_name;
                if((($profil=="Admin" || $profil == "Manager") || ($group_name == "Direction" || $group_name == "Administrateur systeme")) || $profil=="Billing"){
            
        ?>
        <th style="width: 200px; background-color: #A9E65D;"><?php echo Yii::t('app','Paid'); ?></th>
        <th style="width: 200px; background-color: #A9E65D;"><?php echo Yii::t('app','Balance'); ?></th>
        
                <?php }elseif($group_name=="Developer"){  ?>
        
        <th style="width: 200px; background-color: #A9E65D;"><?php echo Yii::t('app','Paid'); ?></th>
        <th style="width: 200px; background-color: #A9E65D;"><?php echo Yii::t('app','Balance'); ?></th>
        
                <?php  } } ?>
        
        <?php  if($data_periode !=null)
                {
                   foreach($data_periode as $p)
                     {
                     	//gade si se denye evalyasyon
                     	$modelEvalByPeriod = EvaluationByYear::model()->findByPk($p->evaluation);
                     	if($modelEvalByPeriod->last_evaluation == 1)
                     	  $lastEvaluation_done= true;
            ?>
					        <th style="width: 200px; background-color: #049cdb;"><?php  echo $p->name_period; ?></th>
        <?php 
                      }
                      
                      if(($display_period_summary ==1) && ($lastEvaluation_done == true) )
						{
						?>  
						   <th style="width: 200px; background-color: #049cdb;"><?php  echo Yii::t('app','Summary '); ?></th> 
					<?php	
						}
                }
        ?>
        <th style="width: 100px; background-color: #FABA3C;"><?php echo Yii::t('app','# Abs');?></th>
        <th style="width: 100px; background-color: #FABA3C;"><?php echo Yii::t('app','# Ret');?></th>
        <th style="width: 100px; background-color: #FABA3C;"><?php echo Yii::t('app','# Infr');?></th>
        <th style="width: 100px; background-color: #FABA3C;"><?php echo Yii::t('app','Summary ');?></th>
    </tr>
    </thead>
    <tbody>
       
        <?php
            if($data !=null)
                {
            $i=1;
            foreach($data as $d){
                
        ?>
        <tr class="<?php echo evenOdd($i); ?>">
        <td style="width: 50px"><?php echo $i++; ?></td>
        <?php
            // Affiche une photo de l'eleve dans SIGES
            if($d->image==NULL){
                $string_image_location = "<img src='".Yii::app()->baseUrl."/css/images/no_pic.png'>";
            }else{
                $string_image_location = "<img src='".Yii::app()->baseUrl."/documents/photo-Uploads/1/".$d->image."'>";
            }
            
            $contact_inf = $this->getStudentContactInfo($d->id);
			
			$string_stud_tool_tip_data = (Persons::model()->getIsScholarshipHolder($d->id,$acad)==1)? "<span><b>". Yii::t('app','Scholarship holder ')."</b></span><br/>" : "";
           
            if($contact_inf!=NUll){
            $string_stud_tool_tip_data = $string_stud_tool_tip_data
			        ."<span><b>". Yii::t('app','Contact info')."</b></span><br/>"
                    . "<i class='fa fa-users'></i> ".$contact_inf['contact_name']."<br/>"
                    . "<i class='fa fa-phone'></i> ".$contact_inf['contact_phone']."<br/>"
                    . "<i class='fa fa-building'></i> ".$contact_inf['address']."<br/>"
                    . "<i class='fa fa-envelope'></i> ".$contact_inf['email'];
                    
            }
			//else{
               // $string_stud_tool_tip_data = "";
            //}
            
        ?>
        <td style="width: 250px"><a data-toggle="tooltip" data-html="true" title="<div class='row-fluid'><div class='span4'><?php echo $string_image_location; ?></div><div class='span8' align='left'><?php echo $string_stud_tool_tip_data; ?></div></div>"   href="<?php echo Yii::app()->baseUrl.'/index.php/academic/persons/viewForReport/id/'.$d->id.'/pg/lr/pi/no/isstud/1/from/stud' ?>"><?php echo $d->fullName; ?></a>
        
        </td>
        <?php 
            if(isset(Yii::app()->user->profil) && isset(Yii::app()->user->groupid)){
                $profil = Yii::app()->user->profil; 
                $group_id = Yii::app()->user->groupid; 
                $group_name = Groups::model()->findByPk($group_id)->group_name;
                if((($profil=="Admin" || $profil == "Manager") || ($group_name == "Direction" || $group_name=="Administrateur systeme")) || $profil=="Billing"){
            
        ?>
        <td style="width: 200px;"><?php echo $currency_symbol." ".numberAccountingFormat($this->getStudentPay($d->id, $acad)); ?></td>
        <td style="width: 200px;"><?php echo $currency_symbol." ".numberAccountingFormat($this->getStudentBalance($d->id, $acad)) ; ?></td>
          <?php }elseif($group_name=="Developer"){  ?>
            
            <td style="width: 200px;"><?php echo $currency_symbol." ".numberAccountingFormat($this->getStudentPay($d->id, $acad)); ?></td>
            <td style="width: 200px;"><?php echo $currency_symbol." ".numberAccountingFormat($this->getStudentBalance($d->id, $acad)) ; ?></td>
          <?php } } ?>
        <?php
      
       $summary_grade = 0;
       $summary_grade_count=0;
       
        foreach($data_periode as $p){
           ?>
        <td style="width: 200px;">
                <?php
                   $grade='';    
                $customRep = new CustomReport; 
                $grade=$customRep->calMoyStudent($d->id, $p->evaluation);
                if($grade >= $passing_grade){
                    echo  $grade;
                }else{
                    echo '<span id="koule_not" style="color: #F15C80">'.$grade.'</span>';
                } 
                
                if(($display_period_summary ==1) && ($lastEvaluation_done == true) )
				 { $summary_grade = $summary_grade + $grade;
				    $summary_grade_count++;
				 }
                   
                ?>
        </td>
        <?php
        
        } 
        
         if(($display_period_summary ==1) && ($lastEvaluation_done == true) )
						{
						?>  <td style="width: 200px;">
				                <?php
				                       $tot_summary_grade = 0;
												   
									if($summary_grade_count!= 0)
									  $tot_summary_grade = round( ($summary_grade / $summary_grade_count), 2); 
									
				                
				                if($tot_summary_grade >= $passing_grade){
				                    echo  $tot_summary_grade;
				                }else{
				                    echo '<span id="koule_not" style="color: #F15C80">'.$tot_summary_grade.'</span>';
				                }    
				                ?>
                           </td> 
					<?php	
						}
        ?>
       
        <td style="width: 100px;">
            <?php
                echo getTotalAbsenceByStudent($d->id,$acad);
            ?>
        </td>
        <td style="width: 100px;">
            <?php
                echo getTotalRetardByStudent($d->id,$acad);
            ?>
        </td>
        <td style="width: 100px;">
            <?php 
            echo numberOfInfraction($d->id, $acad);
        ?>
        </td>
        <td style="width: 100px;">
            <?php
               $disc = new RecordInfraction;
               $konte_peryod = 0;
               $mwayen_disiplin = 0;
               $som_peryod = 0.00;
               
               foreach($data_periode as $p){
                  $som_peryod += $disc->getDisciplineGradeByExamPeriod($d->id, $p->idantite_peryod);
                  $konte_peryod++;
               }
               
               if($konte_peryod!=0){
                   $mwayen_disiplin = $som_peryod/$konte_peryod; 
               }
                echo round($mwayen_disiplin,2); 
              
            ?>
        </td>
        </tr>
            <?php
            
            }
            } ?>
        
    </tbody>  
</table>
<div id="bottom_anchor"></div>
</div>

<a href="#" id="export-button" class="export btn btn-info"><i class="fa fa-arrow-right"></i> CSV</a>
</div>

<script>
    // Convert Table in Excel File 


 $(document).ready(function () {

    function exportTableToCSV($table, filename) {

        var $rows = $table.find('tr:has(td)'),

            // Temporary delimiter characters unlikely to be typed by keyboard
            // This is to avoid accidentally splitting the actual contents
            tmpColDelim = String.fromCharCode(11), // vertical tab character
            tmpRowDelim = String.fromCharCode(0), // null character

            // actual delimiter characters for CSV format
            colDelim = '","',
            rowDelim = '"\r\n"',

            // Grab text from table into CSV formatted string
            csv = '"' + $rows.map(function (i, row) {
                var $row = $(row),
                    $cols = $row.find('td');

                return $cols.map(function (j, col) {
                    var $col = $(col),
                        text = $col.text();

                    return text.replace(/"/g, '""'); // escape double quotes

                }).get().join(tmpColDelim);

            }).get().join(tmpRowDelim)
                .split(tmpRowDelim).join(rowDelim)
                .split(tmpColDelim).join(colDelim) + '"',

            // Data URI
            csvData = 'data:application/csv;charset=utf-8,' + encodeURIComponent(csv);

        $(this)
            .attr({
            'download': filename,
                'href': csvData,
                'target': '_blank'
        });
    }

    // This must be a hyperlink
    $(".export").on('click', function (event) {
        // CSV
        exportTableToCSV.apply(this, [$('#table-container>table'), 'custom_report_export.csv']);
        
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
});  

// Change the selector if needed

var $table = $('table.scroll'),
    $bodyCells = $table.find('tbody tr').children(),
    colWidth;

// Adjust the width of thead cells when window resizes

$(window).resize(function() {
    // Get the tbody columns width array
    colWidth = $bodyCells.map(function() {
        return $(this).width();
    }).get();
    
    // Set the width of thead columns
    $table.find('thead tr').children().each(function(i, v) {
        $(v).width(colWidth[i]);
    });    
}).resize(); // Trigger resize handler


// Morris Chart 
Morris.Donut({
   
  element: 'stat1',
  colors : ['#5BACD9','#A9E65D','#FABA3C'],
  resize: true,
  data: [
    {label: "<?php echo Yii::t('app','Student totally pay'); ?>", value: <?php echo $count_stud_no_debt; ?>},
    {label: "<?php echo Yii::t('app','Student with debt') ?>", value: <?php echo $count_stud_with_debt; ?>},
    {label: "<?php echo Yii::t('app','Student not pay at all') ?>", value: <?php echo $count_stud_never_pay;  ?>}
  ]
});
   


$(function () {
    $('#stat2').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '<b><?php  echo Yii::t('app','Performances: {name}',array('{name}'=>$room_name)); ?></b>'
        },
        
        xAxis: {
            categories: [
                '<?php  echo $list_period ?>'
                
            ],
            crosshair: true
        },
        yAxis: {
            labels:{
                enabled: false
            },
            min: 0,
            title: {
                text: ''
            }
            
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [{
            name: '<?php echo Yii::t('app','Enrolled'); ?>',
            data: [<?php  echo $list_effectif; ?>]

        }, {
              color: '#A9E65D',           
		   name: '<?php echo Yii::t('app','Success'); ?>',
            data: [<?php echo $list_success; ?>]

        }, {
             color: '#FABA3C',
			name: '<?php echo Yii::t('app','Failed'); ?>',
            data: [<?php  echo $list_fail; ?>]

        }]
    });
});



var chartData = [{
  "title": '<?php echo Yii::t('app','Tardy'); ?>',
  "value": <?php echo $count_tardy; ?>,
  //"url":"#",
  "description":"click to drill-down",
  "color": "#5BACD9",        
  
  "data": [
    { "title": "<?php echo Yii::t('app','Male'); ?>", "value": <?php echo $count_tardy_m; ?>,"color": "#A9E65D" },
    { "title": "<?php echo Yii::t('app','Female') ?>", "value": <?php echo $count_tardy_f; ?>,"color": "#5BACD9" }
   
  ]
}, {
  "title": "<?php echo Yii::t('app','Absence') ?>",
  "value": <?php echo $count_absence; ?>,
  "url":"#",
  "description":"click to drill-down",
  "color": "#A9E65D",
  "data": [
    { "title": "<?php echo Yii::t('app','Male'); ?>", "value": <?php echo $count_absence_m; ?>,"color": "#A9E65D" },
    { "title": "<?php echo Yii::t('app','Female'); ?>", "value": <?php echo $count_absence_f; ?>, "color": "#5BACD9" }
    
  ]
}, {
  "title": "<?php echo Yii::t('app','Infractions'); ?>",
  "value": <?php  echo $count_infraction; ?>,
  "url":"#",
  "description":"click to drill-down",
  "color": "#FABA3C",
  "data": [
  <?php echo $data_other_infraction; ?>
  
  ]
}];

// create pie chart
var chart = AmCharts.makeChart("stat3", {
  "type": "pie",
  "dataProvider": chartData,
  //"depth3D": 8,
  "pullOutRadius": "5%",
  "labelsEnabled": false,
  "fontSize": 11,
  "valueField": "value",
  "marginBottom": 0,
  "marginTop": 0,
  "colorField": "color",
  "titleField": "title",
  "labelText": "[[title]]: [[value]]",
  
  "legend": {
		"enabled": true,
                "combineLegend": true,
		"align": "right",
                "equalWidths": false,
                "position": "right",
                "labelWidth": 3,
                "right": 50,
		"markerSize": 4,
		"markerType": "square",
                "valueAlign": "left",
                "valueWidth": 5,
                "marginLeft": 50,
               
	},
       
        
  "pullOutOnlyOne": true,
  "titles": [{
    "text": "<?php echo Yii::t('app','Discipline: {name}',array('{name}'=>$room_name));?>",
    "size": 15
  }],
  "allLabels": []
});

// initialize step array
chart.drillLevels = [{
  "title": "<?php echo Yii::t('app','Discipline: {name}',array('{name}'=>$room_name));?>",
  "data": chartData,
  
}];

// add slice click handler
chart.addListener("clickSlice", function (event) {
  
  // get chart object
  var chart = event.chart;
  
  // check if drill-down data is avaliable
  if (event.dataItem.dataContext.data !== undefined) {
    
    // save for back button
    chart.drillLevels.push(event.dataItem.dataContext);
    
    // replace data
    chart.dataProvider = event.dataItem.dataContext.data;
    
    // replace title
    chart.titles[0].text = event.dataItem.dataContext.title;
    
    // add back link
    // let's add a label to go back to yearly data
    event.chart.addLabel(
      0, 25, 
      "<?php echo Yii::t('app','Back'); ?>",
      undefined, 
      undefined, 
      undefined, 
      undefined, 
      undefined, 
      undefined, 
      'javascript:drillUp();');
    
    // take in data and animate
    chart.validateData();
    chart.animateAgain();
  }
});

function drillUp() {
  
  // get level
  chart.drillLevels.pop();
  var level = chart.drillLevels[chart.drillLevels.length - 1];
  
  // replace data
  chart.dataProvider = level.data;

  // replace title
  chart.titles[0].text = level.title;
  
  // remove labels
  if (chart.drillLevels.length === 1)
    chart.clearLabels();
    chart.invalidateSize(); // Bay grav la tay li te gen anvan an
    // take in data and animate
    chart.validateData();
    chart.animateAgain();
}



</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('a[data-toggle=tooltip]').tooltip();
        
        
    });
  </script>