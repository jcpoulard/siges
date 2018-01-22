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
/* @var $this BalanceController */
/* @var $model Balance */

  
   
	
	$siges_structure = infoGeneralConfig('siges_structure_session');
	     
	   if($siges_structure==1)
	    {
	         $sess=Yii::app()->session['currentId_academic_session'];  
             $sess_name=Yii::app()->session['currentName_academic_session'];	
	      }

$acad=Yii::app()->session['currentId_academic_year']; 
		
 if($siges_structure==1)
 {  if( $sess=='')
        $acad_sess = 0;
    else 
		$acad_sess = $sess;
 }
 elseif($siges_structure==0)
   $acad_sess = $acad;

?>


<div id="dash">
          
          <div class="span3"><h2>
               <?php echo Yii::t('app','Balance to be paid'); ?>
               
          </h2> </div>
     
		   <div class="span3">
              <div class="span4">
                  <?php

                 $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';
                           // build the link in Yii standard
                 echo CHtml::link($images,array('balance/balance')); 
               ?>
  </div>  
</div>

</div>

<div style="clear:both"></div>	




<div id="dash">
		<h2><span class="fa fa-2y" style="font-size: 19px;"><?php echo Yii::t('app','View Balances'); ?></span></h2> </div>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		//'id',
			array('name'=>Yii::t('app','First name'),
			'header'=>Yii::t('app','First name'), 
			'value'=>$model->student0->first_name),
			
			array('name'=>Yii::t('app','Last name'),
			'header'=>Yii::t('app','Last name'), 
			'value'=>$model->student0->last_name),
		array(
			'name'=>Yii::t('app','Balance'),
			'header'=>Yii::t('app','Balance'), 
                        'value'=>$model->Balance,
                    ),
		//'date_created',
		array(
			'name'=>Yii::t('app','Date Created'),
			'header'=>Yii::t('app','Date Created'), 
                        'value'=>ChangeDateFormat($model->date_created),
                    ),
	),
)); 
?>

<div style="clear:both"></div>	

<?php

function evenOdd($num)
{
($num % 2==0) ? $class = 'odd' : $class = 'even';
return $class;
}


$modelBillings = Billings::model()->searchForBalance($_GET['stud']);

if($modelBillings->getData()!=null)
{
?><div id="dash" style="margin-top:20px; margin-bottom:-15px;">
		<h2><span class="fa fa-2y" style="font-size: 15px; font-style:italic;"><?php echo Yii::t('app','On pending fees'); ?></span></h2> </div>
<?php 
}
else
{
?><div id="dash" style="margin-top:20px; margin-bottom:15px;">
		<h2><span class="fa fa-2y" style="font-size: 15px; font-style:italic;"><?php echo Yii::t('app','On pending fees'); ?></span></h2> </div>
<?php 
}


$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'billings-grid',
	'dataProvider'=>$modelBillings,
    
     //   'rowCssClassExpression'=>'($data->balance>0)?"balance":evenOdd($row)',
	
	'columns'=>array(
		//'code',
		
		/*array('name'=>'student_fname',
			'header'=>Yii::t('app','Student first name'), 
			'value'=>'$data->student0->first_name'),
		
		array('name'=>'student_lname',
			'header'=>Yii::t('app','Student last name'), 
			'value'=>'$data->student0->last_name'),
	     */
		array('name'=>'fee_fname',
			'header'=>Yii::t('app','Fee name'), 
			'value'=>'$data->feePeriod->simpleFeeName',
			'htmlOptions'=>array('width'=>'250px'),),
		
	        array('header'=>Yii::t('app','Amount To Pay'),'value'=>'$data->amountToPay'),
        //    array('header'=>Yii::t('app', 'Amount Pay'),'value'=>'$data->amountPay'),
		    array('header'=>Yii::t('app', 'Balance'),'value'=>'$data->balanceCurrency'),
	
		array('name'=>'period_academic_lname',
			'header'=>Yii::t('app','Academic period'), 
			'value'=>'$data->academicperiods0->name_period',
			'htmlOptions'=>array('width'=>'150px'),
			), 
			
		
	   /*
		array(
			'class'=>'CButtonColumn',
                        'template'=>'',//'{update}',
                        
									       
									             'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
									            'imageUrl'=>false,
									            'url'=>'Yii::app()->createUrl("billings/billings/update?id=$data->id&pers=$data->student&from=bap&idap='.$_GET['id'].'&ri=$data->FeeStatus")',
									            'options'=>array('title'=>Yii::t('app','Update')),
									        ),			
         
                                ),

		),
		*/
	 
	),
)); 


 $modelBillings2 = Billings::model()->searchForBalance2($_GET['stud']);

if($modelBillings2->getData()!=null)
{
 ?><div id="dash" style="margin-top:20px; margin-bottom:-15px;">
		<h2><span class="fa fa-2y" style="font-size: 15px; font-style:italic;"><?php echo Yii::t('app','On transactions'); ?></span></h2> </div>
<?php
}
else
{
 ?><div id="dash" style="margin-top:20px; margin-bottom:15px;">
		<h2><span class="fa fa-2y" style="font-size: 15px; font-style:italic;"><?php echo Yii::t('app','On transactions'); ?></span></h2> </div>
<?php
}

$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'billings-grid',
	'dataProvider'=>$modelBillings2,
    
     //   'rowCssClassExpression'=>'($data->balance>0)?"balance":evenOdd($row)',
	
	'columns'=>array(
		//'code',
		
		/*array('name'=>'student_fname',
			'header'=>Yii::t('app',''), 
			'value'=>'$data->student0->first_name'),
		
		array('name'=>'student_lname',
			'header'=>Yii::t('app','Student last name'), 
			'value'=>'$data->student0->last_name'),
	     */
		array('name'=>'fee_fname',
			'header'=>Yii::t('app','Fee name'), 
			'value'=>'$data->feePeriod->simpleFeeName',
			'htmlOptions'=>array('width'=>'250px'),),
		
	        array('header'=>Yii::t('app','Amount To Pay'),'value'=>'$data->amountToPay'),
            array('header'=>Yii::t('app', 'Amount Pay'),'value'=>'$data->amountPay'),
		    array('header'=>Yii::t('app', 'Balance'),'value'=>'$data->balanceCurrency'),
	
		array('name'=>'period_academic_lname',
			'header'=>Yii::t('app','Academic period'), 
			'value'=>'$data->academicperiods0->name_period',
			'htmlOptions'=>array('width'=>'150px'),
			), 
			
		
	 /*
		array(
			'class'=>'CButtonColumn',
                        'template'=>'{update}',
                        
									       
									             'buttons'=>array('update'=>array('label'=>'<span class="fa fa-pencil-square-o"></span>',
									            'imageUrl'=>false,
									            'url'=>'Yii::app()->createUrl("billings/billings/update?id=$data->id&pers=$data->student&from=bap&idap='.$_GET['id'].'&ri=$data->FeeStatus")',
									            'options'=>array('title'=>Yii::t('app','Update')),
									        ),			
         
                                ),

		),
		*/
	 
	),
)); 



?>

