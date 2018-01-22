<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if(isset($_GET['id'])){
    $id_report = (int)$_GET['id'];
    $data_one = $model->findByPk($id_report);
    $a_value = json_decode($data_one->data,true);
    $range_report = $a_value['rangereport']; 
    if($range_report=="byroom"){
            $titre = $a_value['report_title'];
            
            //$report_sub_title  = Yii::t('app',$a_value['dimreport']);
            
            $academic_period = $a_value['period_id'];
            $room_name = $a_value['room_name'];
            $course_id = $a_value['course_id'];
            $value_compare = $a_value['value_compare'];
            $rptCondition = $a_value['rptCondition'];
            
           $shift_name = Shifts::model()->findByPk($a_value['shift_id'])->shift_name;

            $subject_name = null;
            $concat_name = array();
            $array_grade = array();
            $array_grade_f = array();
            $array_grade_m = array();
            $concat_name_f = array();
            $concat_name_m = array();
            $string_sub_title = null;
            $string_periode = null;
            $string_room = null;
            $string_acad = null;
            $coefficient = null;
            $query_condition = null; 
            $string_when_between = null;
            if($rptCondition=="between"){
                $query_condition = "BETWEEN ".$a_value['betFrom']." AND ".$a_value['betTo'];
                $string_when_between = YII::t('app','Between {betFrom} & {betTo}',array('{betFrom}'=>$a_value['betFrom'],'{betTo}'=>$a_value['betTo']));
            }else{
                $query_condition = "$rptCondition $value_compare";
                $string_when_between = "$rptCondition $value_compare";
            }

            /**
             * Contruction du rapport en SQL 
             */
            
            $string_sql = "SELECT g.id, p.first_name, p.last_name, p.gender, (YEAR(Now())-YEAR(p.birthday)) AS 'age',s.subject_name, a.name_period, g.grade_value, c.weight,
                        r.room_name
                        FROM `grades` g 
                        INNER JOIN persons p ON (g.student = p.id)
                        INNER JOIN courses c ON (g.course = c.id)
                        INNER JOIN rooms r ON (c.room = r.id)
                        INNER JOIN subjects s ON (c.subject = s.id)
                        INNER JOIN evaluation_by_year eby ON (g.evaluation = eby.id)
                        INNER JOIN academicperiods a ON (eby.academic_year = a.id)

                        WHERE c.id = $course_id AND a.id = $academic_period AND g.grade_value $query_condition ORDER BY p.last_name";

            $data = Grades::model()->findAllBySql($string_sql);
            $i=0;
            $count_male=0;
            $count_female=0;
    }elseif($range_report=="all"){
                    $titre = $a_value['report_title'];
            
           // $report_sub_title  = $a_value['dimreport'];
            
            $academic_period = $a_value['period_id'];
            $room_name = $a_value['room_name'];
            $value_compare = $a_value['value_compare'];
            $rptCondition = $a_value['rptCondition'];
            
           $shift_name = Shifts::model()->findByPk($a_value['shift_id'])->shift_name;

            $subject_name = null;
            $concat_name = array();
            $array_grade = array();
            $array_grade_f = array();
            $array_grade_m = array();
            $concat_name_f = array();
            $concat_name_m = array();
            $string_sub_title = null;
            $string_periode = null;
            $string_room = null;
            $string_acad = null;
            $coefficient = null;
            $query_condition = null; 
            $string_when_between = null;
            if($rptCondition=="between"){
                $query_condition = "BETWEEN ".$a_value['betFrom']." AND ".$a_value['betTo'];
                $string_when_between = YII::t('app','Between {betFrom} & {betTo}',array('{betFrom}'=>$a_value['betFrom'],'{betTo}'=>$a_value['betTo']));
            }else{
                $query_condition = "$rptCondition $value_compare";
                $string_when_between = "$rptCondition $value_compare";
            }

            /**
             * Contruction du rapport en SQL 
             */
            
            $string_sql = "SELECT  abp.student, r.room_name, r.id, a.name_period, abp.sum, abp.academic_year, abp.evaluation_by_year, abp.average, abp.place, p.last_name, p.first_name, p.gender, p.birthday  FROM `average_by_period` abp 
                            INNER JOIN persons p ON (abp.student = p.id)
                            INNER JOIN evaluation_by_year eby ON (abp.evaluation_by_year = eby.id)
                            INNER JOIN academicperiods a ON (eby.academic_year = a.id)
                            INNER JOIN room_has_person rhp ON (abp.student = rhp.students)
                            INNER JOIN rooms r ON (rhp.room = r.id)

                        WHERE r.id = $room_name AND a.id = $academic_period AND abp.average $query_condition ORDER BY p.last_name";

            $data = AverageByPeriod::model()->findAllBySql($string_sql);
            $i=0;
            $count_male=0;
            $count_female=0;
    }
}

?>

<div class="row span12">
    <div id="dash">
            <div class="span3"><h2><?php echo Yii::t('app','Report details : {name}',array('{name}'=>$titre));  ?></h2></div>
    
    <div class="span3">       
         <div class="span4">
                  <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Create report').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('customReport/customReportStud?part=stud&from1=rpt'));
                 
                   ?>
        </div> 
           
        <div class="span4">
              <?php

                  $images = '<i class="fa fa-bars"> &nbsp;'.Yii::t('app','List reports').'</i>';
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
    <div class="span6 well">
        <div id="graph_1" style="height: 350px"></div>
     </div>
    <div class="span6 well">
        <div id="graph_2" style="height: 350px"></div>
     </div>
</div>

<div class="row-fluid">
    <div class="span6 well">
        <div id="graph_3" style="height: 350px"></div>
     </div>
    <div class="span6 well">
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
</div>

<div class="row-fluid">
    <div class="span12 well">
        
        <?php
        if(isset($_GET['id'])){
            
           if($range_report=="byroom"){     

            echo '<h3 id="custom_report">'.$titre.'</h3><div class="grid-view" id="dvData"><table class="items">'
            . '<tr><td><b>'.Yii::t('app','#').'</b.</td>'
                    . '<td>'.Yii::t('app','Last name').'</td>'
                    . '<td>'.Yii::t('app','First name').'</td>'
                    . '<td>'.Yii::t('app','Gender').'</td>'
                    . '<td>'.Yii::t('app','Grade').'</td>'
                    . '<td>'.Yii::t('app','Weight').'</td></tr>';
            foreach($data as $d){
                if($d["gender"]==0){
                    $sexe_value = Yii::t('app','Male');
                    $array_grade_m[$i]=$d["grade_value"];
                    $concat_name_m[$i] = $d["first_name"].' '.$d["last_name"];
                    $count_male++;
                }else{
                    $sexe_value = Yii::t('app','Female');
                    $array_grade_f[$i]=$d["grade_value"];
                    $concat_name_f[$i] = $d["first_name"].' '.$d["last_name"];
                    $count_female++;
                }
                $subject_name = $d["subject_name"].', '.$d["room_name"];

                $concat_name[$i] = $d["first_name"].' '.$d["last_name"];
                $array_grade[$i] = $d["grade_value"];
                $string_periode = $d["name_period"];
                $string_room = $d["room_name"];
                $coefficient = $d["weight"];
                $string_acad = getAcademicYearNameByPeriodId($academic_period);
                $string_sub_title = $d["subject_name"].' '.$string_room.' '.$shift_name.' , '.Yii::t('app','Grades : ').$string_when_between.'<br/> ('.$string_acad.'/'.$string_periode.')';

                $i++;
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$d["last_name"].'</td>';
                echo '<td>'.$d["first_name"].'</td>';
                echo '<td>'.$sexe_value.'</td>';
                echo '<td>'.$d["grade_value"].'</td>';
                echo '<td>'.$d["weight"].'</td>';
                echo '</tr>';

               // print_r($d);

            }
            echo '</table></div>';
            echo '<br/>';
            
            // Construction des donnees du graphe (nom des etudiants)
            // Calcul de la moyenne
            $asum_ = array_sum($array_grade);
            $acount_ = count($array_grade);
            $average_ = round($asum_/$acount_,2);
            $max_ = max($array_grade);
            $min_ = min($array_grade);
            // Calcul de l'ecrat-type (Standard deviation) 
            //$standard_deviation_ = round(standard_deviation($array_grade,FALSE),2);
            $standard_deviation_ = round(standard_deviation($array_grade,false),2);
            //echo '<br/>Moyenne : '.$average_.'<br/>';
            $string_student_name = join($concat_name, "','");
            $string_student_name_f = join($concat_name_f, "','");
            $string_student_name_m = join($concat_name_m, "','");
            // Notes des etudiants 
            $string_grade_value =  join($array_grade, ',');
            $string_grade_value_f =  join($array_grade_f, ',');
            $string_grade_value_m =  join($array_grade_m, ',');
            
            
        }elseif($range_report=="all"){
            echo '<h3 id="custom_report">'.$titre.'</h3><div class="grid-view" id="dvData"><table class="items">'
            . '<tr><td><b>'.Yii::t('app','#').'</b.</td>'
                    . '<td>'.Yii::t('app','Last name').'</td>'
                    . '<td>'.Yii::t('app','First name').'</td>'
                    . '<td>'.Yii::t('app','Gender').'</td>'
                    . '<td>'.Yii::t('app','Average').'</td>';
                  //  . '<td>'.Yii::t('app','Weight').'</td></tr>';
            foreach($data as $d){
                if($d["gender"]==0){
                    $sexe_value = Yii::t('app','Male');
                    $array_grade_m[$i]=$d["average"];
                    $concat_name_m[$i] = $d["first_name"].' '.$d["last_name"];
                    $count_male++;
                }else{
                    $sexe_value = Yii::t('app','Female');
                    $array_grade_f[$i]=$d["average"];
                    $concat_name_f[$i] = $d["first_name"].' '.$d["last_name"];
                    $count_female++;
                }
                $subject_name = $d["name_period"].', '.$d["room_name"];

                $concat_name[$i] = $d["first_name"].' '.$d["last_name"];
                $array_grade[$i] = $d["average"];
                $string_periode = $d["name_period"];
                $string_room = $d["room_name"];
               // $coefficient = $d["weight"];
                $string_acad = getAcademicYearNameByPeriodId($academic_period);
                $string_sub_title = $d["name_period"].' '.$string_room.' '.$shift_name.' , '.Yii::t('app','Grades : ').$string_when_between.'<br/> ('.$string_acad.'/'.$string_periode.')';

                $i++;
                echo '<tr>';
                echo '<td>'.$i.'</td>';
                echo '<td>'.$d["last_name"].'</td>';
                echo '<td>'.$d["first_name"].'</td>';
                echo '<td>'.$sexe_value.'</td>';
                echo '<td>'.$d["average"].'</td>';
                //echo '<td>'.$d["weight"].'</td>';
                echo '</tr>';

               // print_r($d);

            }
            echo '</table></div>';
            echo '<br/>';
            
            // Construction des donnees du graphe (nom des etudiants)
            // Calcul de la moyenne
            $asum_ = array_sum($array_grade);
            $acount_ = count($array_grade);
            $average_ = round($asum_/$acount_,2);
            $max_ = max($array_grade);
            $min_ = min($array_grade);
            // Calcul de l'ecrat-type (Standard deviation) 
            //$standard_deviation_ = round(standard_deviation($array_grade,FALSE),2);
            $standard_deviation_ = round(standard_deviation($array_grade,false),2);
            //echo '<br/>Moyenne : '.$average_.'<br/>';
            $string_student_name = join($concat_name, "','");
            $string_student_name_f = join($concat_name_f, "','");
            $string_student_name_m = join($concat_name_m, "','");
            // Notes des etudiants 
            $string_grade_value =  join($array_grade, ',');
            $string_grade_value_f =  join($array_grade_f, ',');
            $string_grade_value_m =  join($array_grade_m, ',');
        }
        
        }
        
                
        ?>
        
        <a href="#" id="export-button" class="export btn btn-info"><i class="fa fa-arrow-right"></i> CSV</a>
    </div>
</div>

<?php
    if($range_report=="byroom"){
?> 


<script>
  
$(function() {
    $(document).ready(function (){
        $('#graph_1').highcharts({
        title: {
            text: '<?php echo $titre; ?>'
        },

        subtitle: {
            text: '<?php echo $string_sub_title; ?>'
        },


        xAxis: {
            categories: ['<?php echo $string_student_name; ?>'],
            labels: {
                enabled: false
            },
            minorTickLength: 0,
            tickLength: 0
        },
        yAxis: {
            title: { 
                text: '<?php echo Yii::t('app','Grades/{name}',array('{name}'=>$coefficient)); ?>'
                }, 
        },        

        series: [{
        		name: '<?php echo $subject_name; ?>',
            data: [<?php echo $string_grade_value; ?>]
        }]
    });
    });
}); 


$(function() {
    $(document).ready(function (){
        
       
        $('#graph_2').highcharts({
        
        chart: {
            type: 'line',
            
        },
        
        tooltip: {
            enabled: true
        },    
        title: {
            text: '<?php echo Yii::t('app','Grades chart of sample by gender'); ?>'
        },
                
        subtitle: {
            text: '<?php echo $string_sub_title; ?>'
        },


        xAxis:[
            {
                categories: ['<?php echo $string_student_name_f; ?>'],
                id: 'f',
                labels: {
                enabled: false
            },
            minorTickLength: 0,
            tickLength: 0
            },
            {
                categories: ['<?php echo $string_student_name_m; ?>'],
                id: 'm',
                opposite: true,
                labels: {
                enabled: false
            },
            minorTickLength: 0,
            tickLength: 0
            }
        ] ,
        yAxis: {
            min: 0,
            title: { 
                text: '<?php echo Yii::t('app','Grades/{name}',array('{name}'=>$coefficient)); ?>'
                }, 
        },        

        series: [{
            name: '<?php echo Yii::t('app','Female grades for {name}',array('{name}'=>$subject_name)); ?>',
            data: [<?php echo $string_grade_value_f; ?>],
            xAxis: 'f'
        },
        {
            name: '<?php echo Yii::t('app','Male grades for {name}',array('{name}'=>$subject_name)); ?>',
            data: [<?php echo $string_grade_value_m; ?>],
            xAxis: 'm'
        }
    ]
    });
    });
});


$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#graph_3').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '<?php echo Yii::t('app','Sample distribution by sex');?>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: '<?php echo Yii::t('app','Sample value');?>',
                colorByPoint: true,
                data: [{
                    name: '<?php echo Yii::t('app','Male ({name})',array('{name}'=>$count_male)); ?>',
                    y: <?php echo $count_male; ?>
                }, {
                    name: '<?php echo Yii::t('app','Female ({name})',array('{name}'=>$count_female)); ?>',
                    y: <?php echo $count_female; ?>,
                    sliced: true,
                    selected: true
                }, ]
            }]
        });
    });
});

// Transfert value via JQuery
   $('#sample_avg').html('<?php echo $average_; ?>');
   $('#sample_stdv').html('<?php echo $standard_deviation_; ?>');
   $('#sample_max').html('<?php echo $max_; ?>');
   $('#sample_min').html('<?php echo $min_; ?>');
   
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
        exportTableToCSV.apply(this, [$('#dvData>table'), 'custom_report_export.csv']);
        
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
});  
   

</script>

    <?php }elseif($range_report=="all"){ ?>
     
<script>
    $(function() {
    $(document).ready(function (){
        $('#graph_1').highcharts({
        title: {
            text: '<?php echo $titre; ?>'
        },

        subtitle: {
            text: '<?php echo $string_sub_title; ?>'
        },


        xAxis: {
            categories: ['<?php echo $string_student_name; ?>'],
            labels: {
                enabled: false
            },
            minorTickLength: 0,
            tickLength: 0
        },
        yAxis: {
            title: { 
                text: '<?php echo Yii::t('app','Average'); ?>'
                }, 
        },        

        series: [{
        		name: '<?php echo $subject_name; ?>',
            data: [<?php echo $string_grade_value; ?>]
        }]
    });
    });
}); 


$(function() {
    $(document).ready(function (){
        
       
        $('#graph_2').highcharts({
        
        chart: {
            type: 'line',
            
        },
        
        tooltip: {
            enabled: true
        },    
        title: {
            text: '<?php echo Yii::t('app','Average of sample by gender'); ?>'
        },
                
        subtitle: {
            text: '<?php echo $string_sub_title; ?>'
        },


        xAxis:[
            {
                categories: ['<?php echo $string_student_name_f; ?>'],
                id: 'f',
                labels: {
                enabled: false
            },
            minorTickLength: 0,
            tickLength: 0
            },
            {
                categories: ['<?php echo $string_student_name_m; ?>'],
                id: 'm',
                opposite: true,
                labels: {
                enabled: false
            },
            minorTickLength: 0,
            tickLength: 0
            }
        ] ,
        yAxis: {
            min: 0,
            title: { 
                text: '<?php echo Yii::t('app','Average'); ?>'
                }, 
        },        

        series: [{
            name: '<?php echo Yii::t('app','Female average for {name}',array('{name}'=>$subject_name)); ?>',
            data: [<?php echo $string_grade_value_f; ?>],
            xAxis: 'f'
        },
        {
            name: '<?php echo Yii::t('app','Male average for {name}',array('{name}'=>$subject_name)); ?>',
            data: [<?php echo $string_grade_value_m; ?>],
            xAxis: 'm'
        }
    ]
    });
    });
});


$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#graph_3').highcharts({
            chart: {
                plotBackgroundColor: null,
                plotBorderWidth: null,
                plotShadow: false,
                type: 'pie'
            },
            title: {
                text: '<?php echo Yii::t('app','Sample distribution by sex');?>'
            },
            tooltip: {
                pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
            },
            plotOptions: {
                pie: {
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: {
                        enabled: true
                    },
                    showInLegend: false
                }
            },
            series: [{
                name: '<?php echo Yii::t('app','Sample value');?>',
                colorByPoint: true,
                data: [{
                    name: '<?php echo Yii::t('app','Male ({name})',array('{name}'=>$count_male)); ?>',
                    y: <?php echo $count_male; ?>
                }, {
                    name: '<?php echo Yii::t('app','Female ({name})',array('{name}'=>$count_female)); ?>',
                    y: <?php echo $count_female; ?>,
                    sliced: true,
                    selected: true
                }, ]
            }]
        });
    });
});

// Transfert value via JQuery
   $('#sample_avg').html('<?php echo $average_; ?>');
   $('#sample_stdv').html('<?php echo $standard_deviation_; ?>');
   $('#sample_max').html('<?php echo $max_; ?>');
   $('#sample_min').html('<?php echo $min_; ?>');
   
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
        exportTableToCSV.apply(this, [$('#dvData>table'), 'custom_report_export.csv']);
        
        // IF CSV, don't do event.preventDefault() or return false
        // We actually need this to be a typical hyperlink
    });
});  
   
</script>

    <?php } ?>
