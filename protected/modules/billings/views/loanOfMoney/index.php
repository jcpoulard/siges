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


/* @var $this LoanOfMoneyController */
/* @var $dataProvider CActiveDataProvider */

  
$acad=Yii::app()->session['currentId_academic_year'];

   $template = '';

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 




?>


<div id="dash">
          
          <div class="span3"><h2>
              <?php echo Yii::t('app','Manage loan of money'); ?>
              
          </h2> </div>
     
		   <div class="span3">
 
 <?php 
     
     if(!isAchiveMode($acad))
        {    $template = '{update}';  
        
   ?>
            
 <div class="span4">
              <?php

                 $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/billings/loanOfMoney/create/part/pay/from/stud')); 
               ?>
   </div>
  
  <?php
        }
      
      ?>       
 
   <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('/site/index/')); 
               ?>
  </div>  



  </div>

</div>



<div style="clear:both"></div>






<div class="b_m">




<br/>


<ul class="nav nav-tabs nav-justified">  
<?php
      $last_dat = ''; 
     $display = true;
       
     $month_ = 0;
     $year_ =0;
     $current_month =0;
     $current_year =0;
     $i = 0;
     $class = "";
 
     
     if(!isset($_GET['month_']))
       {
       	   $sql__ = 'SELECT DISTINCT loan_date FROM loan_of_money l LEFT JOIN academicperiods a ON(a.id = l.academic_year) WHERE a.id='.$acad.' ORDER BY loan_date DESC';
												
		  $command__ = Yii::app()->db->createCommand($sql__);
		  $result__ = $command__->queryAll(); 
													       	   
			if($result__!=null) 
			 { foreach($result__ as $r)
			     { if($r['loan_date']!='0000-00-00')
			        { $current_month = getMonth($r['loan_date']);
			           $current_year = getYear($r['loan_date']);
			           $last_dat = $r['loan_date'];
			         }
			       else
			         { $current_month = getMonth(date('Y-m-d'));
			           $current_year = getYear(date('Y-m-d'));
			          }
			         
			          break;
			     }
			  }
			else
			 { $current_month = getMonth(date('Y-m-d'));
       	     // $month_display=$current_month;
       	         $current_year = getYear(date('Y-m-d'));
			  }
			  
			 
		   if(!isDateInAcademicRange($last_dat,$acad))
              $display = false;

			  
        }
     else 
       {  $current_month = $_GET['month_'];
       	  //$month_display= $_GET['month_'];
       	  $current_year = $_GET['year_'];
        }


  if($display)
    {
  
     $sql = 'SELECT DISTINCT loan_date FROM loan_of_money l LEFT JOIN academicperiods a ON(a.id = l.academic_year) WHERE a.id='.$acad.' ORDER BY loan_date ASC';
												
	  $command = Yii::app()->db->createCommand($sql);
	  $result = $command->queryAll(); 
												       	   
		if($result!=null) 
		 { 
		 	$old_month= '';
		 	 $new_month ='';
		 	
		 	
		     foreach($result as $s){
		        
			       if($i==0)
			         { $i=1;
				         $month_=getMonth($s['loan_date']);
				         $year_=getYear($s['loan_date']);
				        
				         if($month_!=$current_month)
				           {  $class = "";
				           
				            }
				         else 
				           { if($year_!=$current_year)
				               $class = "";
				             else
				                 $class = "active";
				           	  
				            }
				         
				          $new_month = getShortMonth(getMonth($s['loan_date'])).' '.getYear($s['loan_date']);
				         
				         if($old_month!= $new_month)
				           {
				         echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/billings/loanOfMoney/index?month_='.$month_.'&year_='.getYear($s['loan_date']).'">';    
				            
				            echo getShortMonth(getMonth($s['loan_date'])).' '.getYear($s['loan_date']);
				         echo'</a></li>';
				           
				              $old_month = getShortMonth(getMonth($s['loan_date'])).' '.getYear($s['loan_date']);
				           }
				         
			         
			         } 
			      elseif($month_!=getMonth($s['loan_date']))
			         {
			         	
				           $month_=getMonth($s['loan_date']);
				           $year_=getYear($s['loan_date']);
				           
				           
				           if($month_!=$current_month)
				             $class = "";
				           else 
				            { if($year_!=$current_year)
				               $class = "";
				             else
				                 $class = "active";
				           	  
				            }
				           
				           $new_month = getShortMonth(getMonth($s['loan_date'])).' '.getYear($s['loan_date']);
				         
				         if($old_month!= $new_month)
				           {  
				           echo '<li class="'.$class.'"><a href="'.Yii::app()->baseUrl.'/index.php/billings/loanOfMoney/index?month_='.$month_.'&year_='.getYear($s['loan_date']).'">'; 
				           
				           
				           echo getShortMonth(getMonth($s['loan_date'])).' '.getYear($s['loan_date']);
				           echo '</a></li>';
			                 
				              $old_month = getShortMonth(getMonth($s['loan_date'])).' '.getYear($s['loan_date']);
				           }
				         
			         
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
	$('#loan-of-money-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");

?>


<div  class="search-form">
<?php 
      
    $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
 
      
<?php 

  if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_UpdateAlreadyPaid=true;
	
			//error message
	    if(($this->message_UpdateAlreadyPaid))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-top:20px; margin-bottom:-50px; ';//-20px; ';
				      echo '">';
				      
				      echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	
				      				      
			       }			      
				 				   
				  if($this->message_UpdateAlreadyPaid)
				     { echo '<span style="color:red;" >'.Yii::t('app','Update is denied, this loan is already paid.').'</span>';
				     $this->message_UpdateAlreadyPaid=false;
				     }
				     
				 
			 echo'</td>
					    </tr>
						</table>';
					
           echo '</div>
           <div style="clear:both;"></div>';
           
           
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'loan-of-money-grid',
	'dataProvider'=>$model->searchByMonth($current_month,$acad),
	'showTableOnEmpty'=>true,
	 'mergeColumns'=>array('person.fullName'),
	//'filter'=>$model,
	'columns'=>array(
		
		array('name'=>'person.fullName',
			'header'=>Yii::t('app','Full name'),
                        'type' => 'raw',
			'value'=>'CHtml::link($data->person->fullName,Yii::app()->createUrl("/billings/loanOfMoney/view",array("id"=>$data->id)))',
                        'htmlOptions'=>array('style'=>'vertical-align: top'),
                        // 'htmlOptions'=>array('width'=>'125px'),
                    ),
		array('header'=>Yii::t('app','Amount'),'name'=>'Amount'),
		
		array('name'=>'repayment_start_on',
		                'header'=>Yii::t('app','Repayment start on'),
			        'value'=>'$data->longMonth',
					),
		
		array('name'=>'loan_date',
		                //'header'=>Yii::t('app','Loan date'),
			        'value'=>'$data->LoanDate',
					),
		
		array('name'=>'paid',
		                'header'=>Yii::t('app','Paid'),
			        'value'=>'$data->loanPaid',
					),
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
                           'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100,100000=>Yii::t('app','all')),array(
                             'onchange'=>"$.fn.yiiGridView.update('loan-of-money-grid',{ data:{pageSize: $(this).val() }})",
                             )),
                             
                             
		      ),
	),
)); 


    // Export to CSV 
  $content=$model->searchByMonth($current_month,$acad)->getData();
 if((isset($content))&&($content!=null))
   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));




?>


</div>


