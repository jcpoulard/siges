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

 $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 


   $template = '';


?>

<div id="dash">
   <div class="span3"><h2>
          <?php echo Yii::t('app','Manage infraction record'); ?>
          
   </h2> </div>
    
     <div class="span3">
      

 <?php 
     
     if(!isAchiveMode($acad_sess))
        {    $template = '{update}{delete}';  
        
   ?>
      
         <div class="span4">
                  <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('recordInfraction/create'));
                 
                   ?>
  </div> 
 
 <?php
        }
      
      ?>       
           
               <div class="span4">
              <?php

                  $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/discipline/recordInfraction/index')); 

               ?>
          </div>
   </div>

</div>


<div style="clear:both"></div>

<br/>



<ul class="nav nav-tabs nav-justified">  
<?php
     
     $last_dat = ''; 
     $display = true;
      
     $month_ = 0;
     $current_month =0;
     $i = 0;
     $class = "";
 
     
     if(!isset($_GET['month_']))
       {
       	   $sql__ = 'SELECT DISTINCT incident_date FROM record_infraction ri LEFT JOIN academicperiods a ON(a.id = ri.academic_period) WHERE a.id='.$acad_sess.' ORDER BY incident_date DESC';
												
		  $command__ = Yii::app()->db->createCommand($sql__);
		  $result__ = $command__->queryAll(); 
													       	   
			if($result__!=null) 
			 { foreach($result__ as $r)
			     { $current_month = getMonth($r['incident_date']);
			        $last_dat = $r['incident_date'];  
			          break;
			     }
			  }
			else
			  $current_month = getMonth(date('Y-m-d'));
			  
		   
		   if(!isDateInAcademicRange($last_dat,$acad_sess))
              $display = false;
       	  
        }
     else 
       {  
         $current_month = $_GET['month_'];
       	 
        }

 
  if($display)
    {
 
     $sql = 'SELECT DISTINCT ri.incident_date FROM record_infraction ri LEFT JOIN academicperiods a ON(a.id = ri.academic_period) WHERE a.id='.$acad_sess.'  ORDER BY incident_date ASC';
												
	  $command = Yii::app()->db->createCommand($sql);
	  $result = $command->queryAll(); 
												       	   
	
     if($result!=null) 
		 { 
		     foreach($result as $s){
			        
			       if($i==0)
			         { $i=1;
				         $month_=getMonth($s['incident_date']);
				        
				         if($month_!=$current_month)
				             $class = "";
				         else 
				            $class = "active";
				         
				         echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/discipline/recordInfraction/index?month_='.$month_.'&from=stud">';    
				            
				            echo getShortMonth(getMonth($s['incident_date'])).' '.getYear($s['incident_date']);
				         echo'</a></li>';
				         
			         
			         } 
			      elseif($month_!=getMonth($s['incident_date']))
			         {
			         	
				           $month_=getMonth($s['incident_date']);
				           if($month_!=$current_month)
				             $class = "";
				           else 
				            $class = "active";
				             
				           echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/discipline/recordInfraction/index?month_='.$month_.'&from=stud">'; 
				           
				           
				           echo getShortMonth(getMonth($s['incident_date'])).' '.getYear($s['incident_date']);
				           echo '</a></li>';
			         
			         
			          }
			          
			      }
         
     
		 }
		
     } 
		 
?>
</ul>




<div class="grid-view">

<div  class="search-form">
<br/>
<?php  

Yii::app()->clientScript->registerScript('search_('.$current_month.', '.$acad_sess.')', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('record-infraction-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

?>

<div class="search-form">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php 



        $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
        
        $gridWidget = $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'record-infraction-grid',
	'dataProvider'=>$model->search_($current_month,$acad_sess),
	
	'columns'=>array(
		array(
                    'name' => 'student',
                    'type' => 'raw',
                    'value'=>'CHtml::link($data->student0->fullName." (".$data->student0->id_number.")",Yii::app()->createUrl("discipline/recordInfraction/view",array("id"=>$data->id)))',
                    'htmlOptions'=>array('width'=>'200px'),
                     ),
		
		
                array(
                    'name' => 'infraction_type',
                    'type' => 'raw',
                    'value'=>'$data->infractionType->name',
                    'htmlOptions'=>array('width'=>'200px'),
                     ),
		'record_by',
                'value_deduction',
                array('name'=>'incident_date','value'=>'$data->incidentDate'),
		
		     	array(
			'class'=>'CButtonColumn',
                        'template'=>$template,
                        'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                             
                            ),
                            
                            ),
                        'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                        'onchange'=>"$.fn.yiiGridView.update('record-infraction-grid',{ data:{pageSize: $(this).val() }})",
            )),

		),
	),
)); 


   // Export to CSV 
  $content=$model->search_($month_,$acad_sess)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));




?>



</div>
