<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

if($range_report == "all") {

?>

<script>
  
$(function() {
    $(document).ready(function (){
        $('.tst').highcharts({
        title: {
            text: '<?php echo $report_title; ?>'
        },

        subtitle: {
            text: '<?php echo $sub_title; ?>'
        },


        xAxis: {
            categories: ['<?php echo $concat_name; ?>'],
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
            data: [<?php echo $array_grade; ?>]
        }]
    });
    });
});   

$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#graph_pie').highcharts({
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
                        enabled: false
                    },
                    showInLegend: true
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
    
    
    
   
function NormalDensityZx(x, Mean, StdDev)
{
	var a = x - Mean;
	return Math.exp(-(a * a) / (2 * StdDev * StdDev)) / (Math.sqrt(2 * Math.PI) * StdDev); 
}


   
   
$(function() {
    $(document).ready(function (){
        
       
        $('#gauss_chart').highcharts({
        
        chart: {
            type: 'line',
            
        },
        
        tooltip: {
            enabled: true
        },    
        title: {
            text: '<?php echo Yii::t('app','Chart average by gender'); ?>'
        },
                
        subtitle: {
            text: '<?php echo $sub_title; ?>'
        },


        xAxis:[
            {
                categories: ['<?php echo $concat_name_f; ?>'],
                id: 'f',
                labels: {
                enabled: false
            },
            minorTickLength: 0,
            tickLength: 0
            },
            {
                categories: ['<?php echo $concat_name_m; ?>'],
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
            data: [<?php echo $array_grade_f; ?>],
            xAxis: 'f'
        },
        {
            name: '<?php echo Yii::t('app','Male average for {name}',array('{name}'=>$subject_name)); ?>',
            data: [<?php echo $array_grade_m; ?>],
            xAxis: 'm'
        }
    ]
    });
    });
});   
   
   
   
   // Transfert value via JQuery
   $('#sample_avg').html('<?php echo $average_; ?>');
   $('#sample_stdv').html('<?php echo $standard_deviation_; ?>');
   $('#sample_max').html('<?php echo $max_; ?>');
   $('#sample_min').html('<?php echo $min_; ?>');
</script>

<?php } else{ ?>
<script>
  
$(function() {
    $(document).ready(function (){
        $('.tst').highcharts({
        title: {
            text: '<?php echo $report_title; ?>'
        },

        subtitle: {
            text: '<?php echo $sub_title; ?>'
        },


        xAxis: {
            categories: ['<?php echo $concat_name; ?>'],
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
            data: [<?php echo $array_grade; ?>]
        }]
    });
    });
});   

$(function () {

    $(document).ready(function () {

        // Build the chart
        $('#graph_pie').highcharts({
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
                        enabled: false
                    },
                    showInLegend: true
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
    
    
    
   
function NormalDensityZx(x, Mean, StdDev)
{
	var a = x - Mean;
	return Math.exp(-(a * a) / (2 * StdDev * StdDev)) / (Math.sqrt(2 * Math.PI) * StdDev); 
}


   
   
$(function() {
    $(document).ready(function (){
        
       
        $('#gauss_chart').highcharts({
        
        chart: {
            type: 'line',
            
        },
        
        tooltip: {
            enabled: true
        },    
        title: {
            text: '<?php echo Yii::t('app','Grades chart by gender'); ?>'
        },
                
        subtitle: {
            text: '<?php echo $sub_title; ?>'
        },


        xAxis:[
            {
                categories: ['<?php echo $concat_name_f; ?>'],
                id: 'f',
                labels: {
                enabled: false
            },
            minorTickLength: 0,
            tickLength: 0
            },
            {
                categories: ['<?php echo $concat_name_m; ?>'],
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
            data: [<?php echo $array_grade_f; ?>],
            xAxis: 'f'
        },
        {
            name: '<?php echo Yii::t('app','Male grades for {name}',array('{name}'=>$subject_name)); ?>',
            data: [<?php echo $array_grade_m; ?>],
            xAxis: 'm'
        }
    ]
    });
    });
});   
   
   
   
   // Transfert value via JQuery
   $('#sample_avg').html('<?php echo $average_; ?>');
   $('#sample_stdv').html('<?php echo $standard_deviation_; ?>');
   $('#sample_max').html('<?php echo $max_; ?>');
   $('#sample_min').html('<?php echo $min_; ?>');
</script>

<?php } ?>