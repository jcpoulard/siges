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
/* @var $this OtherIncomesController */
/* @var $dataProvider CActiveDataProvider */

$acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year'];

$template = '';


$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 


?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Manage other incomes '); ?>
              
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
                  if($this->recettesItems==0)
                     echo CHtml::link($images,array('/billings/billings/create/part/rec/ri/0/from/stud'));
                  elseif($this->recettesItems==1)
                     echo CHtml::link($images,array('/billings/billings/create/part/rec/ri/1/from/stud'));
                   elseif($this->recettesItems==2)
                     echo CHtml::link($images,array('/billings/otherIncomes/create/part/rec/ri/2/from/stud'));
                  
               ?>
   </div>

 <?php
        }
      
      ?>       

   
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                  
                 if($this->recettesItems==0)
                     echo CHtml::link($images,array('/billings/billings/index/part/rec/ri/0/from/stud'));
                  elseif($this->recettesItems==1)
                     echo CHtml::link($images,array('/billings/billings/index/part/rec/ri/0/from/stud'));
                  elseif($this->recettesItems==2)
                     echo CHtml::link($images,array('/billings/billings/index/part/rec/ri/0/from/stud'));
               ?>
  </div>  


  </div>

</div>



<div style="clear:both"></div>






<div class="b_m">


<div class="row" style="padding: 5px 10px;"> 
     
      <div class="span9" >                        

<?php
    $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'record-infraction-form',
	'enableAjaxValidation'=>false,
));


?>                           
     
      						<div class="span2" >
                                
                                <?php echo $form->errorSummary($model); ?>
                                <div class="left" style="padding-left:20px;">
                                    <?php 
                                        
                                        echo $form->labelEx($model,Yii::t('app','Recettes Items'));
                                        
                                        if(isset($this->recettesItems)&&($this->recettesItems!=''))
							       echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItems(), array('onchange'=> 'submit()')); 
								  }

                                    ?>
                                </div>
                                
                            </div>
 <?php $this->endWidget(); ?>          
                     
        </div>
    </div>


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
       	   $sql__ = 'SELECT DISTINCT income_date FROM other_incomes oi LEFT JOIN academicperiods a ON(a.id = oi.academic_year) WHERE a.id='.$acad.' ORDER BY income_date DESC';
												
		  $command__ = Yii::app()->db->createCommand($sql__);
		  $result__ = $command__->queryAll(); 
													       	   
			if($result__!=null) 
			 { foreach($result__ as $r)
			     { $current_month = getMonth($r['income_date']);
			     $last_dat = $r['income_date'];
			          break;
			     }
			  }
			else
			  $current_month = getMonth(date('Y-m-d'));
       	  // $month_display=$current_month;
       	  
       	   if(!isDateInAcademicRange($last_dat,$acad))
              $display = false;
       	  
        }
     else 
       {  $current_month = $_GET['month_'];
       	  //$month_display= $_GET['month_'];
        }


  if($display)
    {
 
     $sql = 'SELECT DISTINCT income_date FROM other_incomes oi LEFT JOIN academicperiods a ON(a.id = oi.academic_year) WHERE a.id='.$acad.' ORDER BY income_date ASC';
												
	  $command = Yii::app()->db->createCommand($sql);
	  $result = $command->queryAll(); 
												       	   
		if($result!=null) 
		 { 
		     foreach($result as $s){
			        
			       if($i==0)
			         { $i=1;
				         $month_=getMonth($s['income_date']);
				        
				         if($month_!=$current_month)
				             $class = "";
				         else 
				            $class = "active";
				         
				         echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/billings/otherIncomes/index?month_='.$month_.'&ri=2&from=b">';    
				            
				            echo getShortMonth(getMonth($s['income_date'])).' '.getYear($s['income_date']);
				         echo'</a></li>';
				         
			         
			         } 
			      elseif($month_!=getMonth($s['income_date']))
			         {
			         	
				           $month_=getMonth($s['income_date']);
				           if($month_!=$current_month)
				             $class = "";
				           else 
				            $class = "active";
				             
				           echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/billings/otherIncomes/index?month_='.$month_.'&ri=2&from=b">'; 
				           
				           
				           echo getShortMonth(getMonth($s['income_date'])).' '.getYear($s['income_date']);
				           echo '</a></li>';
			         
			         
			          }
			          
			      }
         
     
		 }
		 
      } 
?>
</ul>







<div class="grid-view">

<?php
 
		
	Yii::app()->clientScript->registerScript('searchByMonth('.$current_month.','.$acad.')', "
	$('.search-button').click(function(){
		$('.search-form').toggle();
		return false;
	});
	$('.search-form form').submit(function(){
		$('#other-incomes-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");

?>


<?php 
        
            
function evenOdd($num)
{
($num % 2==0) ? $class = 'odd' : $class = 'even';
return $class;
}


$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);

$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'other-incomes-grid',
	'dataProvider'=>$model->searchByMonth($current_month, $acad),
	//'filter'=>$model,
	'showTableOnEmpty'=>true,
	//'emptyText'=>Yii::t('app','No academic period found'),
			//'summaryText'=>Yii::t('app','View academic period from {start} to {end} (total of {count})'),
               'mergeColumns'=>array('idIncomeDescription.income_description', 'income_date', ),
	
	'columns'=>array(
		
		array('name'=>'income_date',
			'value'=>'$data->IncomeDate'),
		'idIncomeDescription.income_description',
		array('header'=>Yii::t('app','Amount'),'name'=>'Amount'),
		'description',
		'created_by',
		
		array(
			'class'=>'CButtonColumn',
			              'template'=>$template,
                         'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
                            'imageUrl'=>false,
                            'url'=>'Yii::app()->createUrl("/billings/otherIncomes/update?id=$data->id&ri='.$this->recettesItems.'&part=rec&from=stud")',
                            'options'=>array('title'=>Yii::t('app','Update')),
                             
                            ),
                            'delete'=>array('label'=>'<span class="fa fa-trash-o"></span>',
                            'imageUrl'=>false,
                            'options'=>array('title'=>Yii::t('app','Delete')),
                                
                            ),
                            ),
                      'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('other-incomes-grid',{ data:{pageSize: $(this).val() }})",
                             )),
		),
	),
)); 


    // Export to CSV 
  $content=$model->searchByMonth($current_month, $acad)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));


?>



</div>






