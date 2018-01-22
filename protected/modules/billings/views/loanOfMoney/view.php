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
/* @var $model LoanOfMoney */

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year'];
 $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            

 function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }

?>



<div id="dash">
          
          <div class="span3"><h2>
               <?php 
                      
                      echo CHtml::link($model->person->fullName,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$model->person->id,"from"=>"emp")));            
                  ?>
               
          </h2> </div>
     
		   <div class="span3">
 
  <?php 
     
     if(!isAchiveMode($acad))
        {    
        
   ?>


 
 <?php
       if( (Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Billing') )
		 {
 ?>             
           <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/billings/loanOfMoney/create/part/pay/from/stud')); 

                   ?>

              </div>
              
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                       if(isset($_GET['all']))
                         { 
                       	   echo CHtml::link($images,array('/billings/loanOfMoney/update/','id'=>$_GET['id'],'part'=>'pay','all'=>$_GET['all'],'from'=>'view'));
                       	   
                         }
                       else 
                           echo CHtml::link($images,array('/billings/loanOfMoney/update/','id'=>$model->id,'part'=>'pay','from'=>'view'));

                     ?>

              </div> 
  <?php
		 }
  
  ?>            


 <?php
        }
      
      ?>       

              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
                        
                        if( (Yii::app()->user->profil=='Admin')||(Yii::app()->user->profil=='Billing') )
		                 {
                            if(isset($_GET['from'])&&($_GET['from']=='pay'))
	                           echo CHtml::link($images,array('/billings/payroll/view/id/'.$_GET['id_'].'/month_/'.$_GET['month_'].'/year_/'.$_GET['year_'].'/di/'.$_GET['di'].'/part/pay/from/emp'));
	                       else
	                           echo CHtml::link($images,array('/billings/loanOfMoney/index/part/pay/from/stud')); 
	                           
		                    }
		                  else
		                     echo CHtml::link($images,array('/billings/payroll/view/id/'.$_GET['id_'].'/month_/'.$_GET['month_'].'/year_/'.$_GET['year_'].'/di/'.$_GET['di']));

                   ?>

            </div> 

        </div>
  </div>



<div style="clear:both"></div>


<div class="span3"></div>
<div style="clear:both"></div>

<!-- La ligne superiure  -->

<?php 

  if(isset($_GET['msguv'])&&($_GET['msguv']=='y'))
           $this->message_UpdateAlreadyPaid=true;
	
			//error message
	    if(($this->message_UpdateAlreadyPaid))		
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px;  margin-bottom:0px; ';//-20px; ';
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
           ?>
           
<div class="row-fluid">
   
           
<div class="span3 grid-view">
	 <strong><?php  
	                  echo Yii::t('app','Loan summary');
	                    
	         ?></strong>
	         
      <table class="detail-view table table-striped table-condensed">
        
        <tr class="odd"><th><?php echo Yii::t('app','Total Loan '); ?></th></tr>
        <tr class="odd">
            <td >
                    
                     <?php // 
                                       				   
					$total_loan = 0;
					
				$total_loan = LoanOfMoney::model()->getTotalLoan($model->person_id, $acad);
                 echo '<div style="margin-left:20px;   " > '.$currency_symbol.' '.numberAccountingFormat($total_loan).' </div>';
								       				 
	                     ?>
        
            </td>
        </tr>
        
        <tr class="odd"><th><?php echo Yii::t('app','Total Balance'); ?></th></tr>
        <tr class="odd">
        <td>

                     <?php // 
                           $total_solde = 0;            				   
					 $total_solde = LoanOfMoney::model()->getTotalSolde($model->person_id, $acad);
					  
					echo '<div style="margin-left:20px;   " > '.$currency_symbol.' '.numberAccountingFormat($total_solde).' </div>';			       				 
	                     ?>        
        
        </td>
        </tr>
        

        
        
    </table>

</div>



<div class="span6 grid-view">
<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		
		array('name'=>'amount',
		                'header'=>Yii::t('app','Amount'),
			        'value'=>$model->Amount,
					),
		
		array('name'=>'deduction_percentage',
		                'header'=>Yii::t('app','Deduction Percentage'),
			        'value'=>$model->deduction_percentage."% ",
					),
		
		array('name'=>'repayment_start_on',
		                'header'=>Yii::t('app','Repayment start on'),
			        'value'=>"$model->longMonth",
					),
	    
	    array('name'=>'number_of_month_repayment',
		                'header'=>Yii::t('app','Number Of Month Repayment'),
			        'value'=>"$model->number_of_month_repayment",
					),
					
		 array('name'=>'remaining_month_number',
		                'header'=>Yii::t('app','Remaining Month Number'),
			        'value'=>"$model->remaining_month_number",
					),


		'Solde',
		
		array('name'=>'paid',
		                'header'=>Yii::t('app','Paid'),
			        'value'=>"$model->loanPaid",
					),

		

	),
)); ?>


</div>
    
    
    
<div class="span2 photo_view">
    <?php
        echo '<b>'.Yii::t('app','Gross salary').': '.Payroll::model()->getGrossSalary($model->person_id).'</b>';
    if($model->person->image!=null)
                   
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/photo-Uploads/1/'.$model->person->image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
    ?>


    
</div>
      
</div>

<div style="clear:both"></div>
 <!-- Seconde ligne -->
 

<div class="row-fluid">
           



<?php 

$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'loan-of-money-grid',
	'dataProvider'=>LoanOfMoney::model()->searchForView($model->person_id,$acad),
	'showTableOnEmpty'=>true,
	//'emptyText'=>Yii::t('app','No academic period found'),
	'summaryText'=>'',
               //'mergeColumns'=>array('fee_fname'),
    
        //'rowCssClassExpression'=>'($data->paid==0)?"paid":evenOdd($row)',
	
	'columns'=>array(
		
		
		array(
		    'name'=>'id',
			'header'=>Yii::t('app','ID'),
                        'type' => 'raw',
			'value'=>'CHtml::link($data->id,Yii::app()->createUrl("/billings/loanOfMoney/view",array("id"=>$data->id)))',
                        //'htmlOptions'=>array('width'=>'125px'),
                    ),
		             
        array('name'=>'remaining_month_number',
		                'header'=>Yii::t('app','Remaining month number'),
			        'type' => 'raw',
			'value'=>'CHtml::link($data->remaining_month_number,Yii::app()->createUrl("/billings/loanOfMoney/view",array("id"=>$data->id)))',
			'htmlOptions'=>array('width'=>'255px'),
					),

		
		
		array('name'=>'paid',
		                'header'=>Yii::t('app','Paid'),
			        'type' => 'raw',
			'value'=>'CHtml::link($data->loanPaid,Yii::app()->createUrl("/billings/loanOfMoney/view",array("id"=>$data->id)))',
					),

           
		 
	),
)); 



 ?>


</div>
      







