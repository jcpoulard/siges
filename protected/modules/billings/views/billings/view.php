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
 $exam_period;
 	
	$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
 $acad_name=Yii::app()->session['currentName_academic_year'];
 
 $previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
 
 $pending_balance=null;


$condition = '';
$ri= 1;

 if(isset($_GET['ri']))
   {         
       if($_GET['ri']==0)
         {  $ri= 0;     
        
          }
        elseif($_GET['ri']==1)
          { $ri= 1;     
         
          	 }
               
               
               
               
    }

 function evenOdd($num)
            {
                ($num % 2==0) ? $class = 'odd' : $class = 'even';
                return $class;
            }
?>

<?php
/* @var $this BillingsController */
/* @var $model Billings */


 $student_id = 0;
      	 $birthday = '0000-00-00';
     $image='';
    
   if(isset($model->student))
      {
      	 $student_id = $model->student0->id;
      	 $birthday = $model->student0->birthday;
      	 $image= $model->student0->image;
      	 $full_name = $model->student0->fullName;
      }
   else
      {
      	  if(isset($_GET['stud']))
      	    {  $student_id = $_GET['stud'];
      	       
      	       $student=Persons::model()->findByPk($student_id);
      	   
      	       $birthday = $student->birthday;
      	       
      	       $image= $student->image;
      	       $full_name = $student->fullName;
      	   
      	    }
       }

?>

<div id="dash">
          
          <div class="span3"><h2>
               <?php  
                      if(isset($model->student))
                       echo CHtml::link($model->student0->fullName,Yii::app()->createUrl("/academic/persons/viewForReport",array("id"=>$model->student0->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")));                     
                      else
                        echo $full_name;
                ?>
               
          </h2> </div>
     
		   <div class="span3">
              
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {  
        	
        	if(isset($model->student))
        	  {
        	    
        
   ?>

           <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard
                     if((isset($_GET['from1'])))
                       { 
                       	 if(($_GET['from1']=='vfr'))
                       	     echo CHtml::link($images,array('/billings/billings/create/id/'.$model->id.'/part/rec/stud/'.$_GET['stud'].'/from1/vfr/from/stud'));
                         elseif($_GET['from1']=='sho')
                                   echo CHtml::link($images,array('/billings/billings/create/id/'.$model->id.'/part/rec/stud/'.$_GET['stud'].'/from1/sho/from/stud'));
                                elseif($_GET['from1']=='exem')
                                   echo CHtml::link($images,array('/billings/billings/create/id/'.$model->id.'/part/rec/stud/'.$_GET['stud'].'/from1/exem/from/stud'));
                           }
                     else
                        {  
                        	echo CHtml::link($images,array('/billings/billings/create/part/rec/ri/'.$ri.'/from/stud'));
                        	
                           }

                   ?>

              </div>
              
<?php

 if( (!isset($_GET['from1'])) || (($_GET['from1']!='sho')&&($_GET['from1']!='exem')) )
        {                           
                                
?>              
              
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                        if((isset($_GET['from1'])))
                           {  
                              if(($_GET['from1']=='vfr'))
                                 echo CHtml::link($images,array('billings/update/id/'.$model->id.'/part/rec/stud/'.$_GET['stud'].'/from1/vfr/ri/'.$ri.'/from/view'));
                               elseif($_GET['from1']=='sho')
                                   echo CHtml::link($images,array('billings/update/id/'.$model->id.'/part/rec/stud/'.$_GET['stud'].'/from1/sho/ri/'.$ri.'/from/view'));
                                elseif($_GET['from1']=='exem')
                                   echo CHtml::link($images,array('billings/update/id/'.$model->id.'/part/rec/stud/'.$_GET['stud'].'/from1/exem/ri/'.$ri.'/from/view'));
                           }
                        else
                          { 
                          	 echo CHtml::link($images,array('billings/update/id/'.$model->id.'/part/rec/ri/'.$ri.'/from/view')); 
                          	 
                          }

                     ?>

              </div> 
              
 <?php
        }
        
           
           
           
           
           
           
                 }
        }
      ?>       

  
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                       if(isset($_GET['from1']))
                       { if($_GET['from1']=='vfr')
                               echo CHtml::link($images,array('/academic/persons/viewForReport/id/'.$_GET['stud'].'/pg/lr/pi/no/isstud/1/from/stud'));
                         elseif($_GET['from1']=='sho')
                             echo CHtml::link($images,array('/billings/scholarshipholder/index/from/bil'));
                            elseif($_GET['from1']=='exem')
                             echo CHtml::link($images,array('/billings/scholarshipholder/index_exempt/from/bil'));
                         
                       }
                      else
                          {
                          	 echo CHtml::link($images,array('/billings/billings/index/part/rec/ri/'.$ri.'/from/stud'));
                          }

                   ?>

            </div> 

        </div>
  </div>



<div style="clear:both"></div>




<div class="span3"></div>
<div style="clear:both"></div>

<!-- La ligne superiure  -->


<div class="row-fluid">
       

    
<div class="span3 grid-view">
	
<div style="background-color:#EDF1F6; color:#F0652E; border:1px solid #DDDDDD; padding:5px;">
        <?php
        /*
        $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'view-billings-form',
	'enableAjaxValidation'=>true,
));
       */
        ?>
           <label for="period_name" style="font-weight:bold;"><?php echo Yii::t('app','Summary'); //echo Yii::t('app','-- Select --') ?></label> 
       
 <?php       
       	
	
	//echo $form->dropDownList($model,'recettesItems',$this->loadRecettesItemsSummary(), array('onchange'=> 'submit()','options' => array($this->recettesItems=>array('selected'=>true))));
        ?>
        
        <?php //$this->endWidget(); ?>
    </div>
    
 
 
 
        
    <table class="detail-view table table-striped table-condensed">
        
        <tr class="odd"><th><?php echo Yii::t('app','Exonerate Fee(s) '); ?></th></tr>
        <tr class="odd">
            <td>
                    
         <?php // 
                     
                if($this->recettesItems ==  0)     
					{ $this->status_ = 1;	
					  $ri=0;
					}				              
				elseif($this->recettesItems ==  1)     
					{   $this->status_ = 0;
					    $ri=1;
					}

 //gad si elev la gen balans ane pase ki poko peye
$modelPendingBal=PendingBalance::model()->findAll(array('select'=>'id, balance',
	'condition'=>'student=:stud AND is_paid=0 AND academic_year=:acad',
	'params'=>array(':stud'=>$student_id,':acad'=>$previous_year),
	));
//si gen pending, ajoutel nan lis apeye a			
if( (isset($modelPendingBal))&&($modelPendingBal!=null) )
 {
   foreach($modelPendingBal as $bal)
	 {	
	 	$pending_balance = $bal->balance;
	 }
 }				          
         
              $condition ='fl.status ='.$this->status_.' AND ';
              $condition_receipt = '';
              
              $full_paid_fees_array = array();
					$fees_paid_array = array();
					$paid_fees_array = array();
			  $arraya_size=0;
					
					 
					 //tcheke si elev sa se yon bousye
					 $is_scholarshipHolder = Persons::model()->getIsScholarshipHolder($student_id,$acad_sess);    
														           	  
				     if($is_scholarshipHolder == 1) //se yon bousye
					   {  //tcheke tout fee ki peye net yo    // pou ajoute l/yo sou $fees_paid 
					       $full_paid_fee = Billings::model()->searchFullPaidFeeByStudentId($student_id, $this->status_, $acad_sess);
					       
					       if($full_paid_fee!=null)
				             {  $i=0; 
					           foreach($full_paid_fee as $full_paid)
					             {
					                 $full_paid_fees_array[0][$i] = Yii::t('app',$full_paid["fee_label"]); 
					                 $full_paid_fees_array[1][$i] = $full_paid["id_fee"]; 
					                 
					                 //ajoute full paid fee
					                 $paid_fees_array[] = $full_paid["id_fee"];
					                 $arraya_size++;
					                 $i++;    	 
					              }
					          }
					       
					    }
					    
				        if($full_paid_fees_array!=null)
				                     {  
					                   if(sizeof($full_paid_fees_array)==0)
					                     {
					                     	echo '<div class="rmodal"> <div class=""  style="float:left; margin-left:5px; width:auto;"> <div class="l" >'.$full_paid_fees_array[0][0].'</div><div class="r checkbox_view" style="margin-left:5px; margin-top:-3px;"><input type="checkbox" name="'.$full_paid_fees_array[1][0].'" id="'.$full_paid_fees_array[1][0].'" checked="checked" value="'.$full_paid_fees_array[1][0].'" disabled="disabled" ></div></div></div>';
					                    
					                    }
					                 else
					                    {
					                   
					                   
					                   for($k=0; $k<$arraya_size; $k++)
					                      {   
			 	                               
		 echo '<div class="rmodal"> <div class=""  style="float:left; margin-left:5px; width:auto;"> <div class="l" >'.$full_paid_fees_array[0][$k].'</div><div class="r checkbox_view" style="margin-left:5px; margin-top:-3px;"><input type="checkbox" name="'.$full_paid_fees_array[1][$k].'" id="'.$full_paid_fees_array[1][$k].'" checked="checked" value="'.$full_paid_fees_array[1][$k].'" disabled="disabled" ></div></div></div>';
			                              										        						
											}
											
					                    }
											
								       }		       				 
	                     ?>
        
            </td>
        </tr>
        
                <tr class="odd"><th><?php echo Yii::t('app','Paid Fee(s) '); ?></th></tr>
        <tr class="odd">
            <td>
                    
         <?php // 
                     
                if($this->recettesItems ==  0)     
					{ $this->status_ = 1;	
					  $ri=0;
					}				              
				elseif($this->recettesItems ==  1)     
					{   $this->status_ = 0;
					    $ri=1;
					}
					          
         
              $condition ='fl.status ='.$this->status_.' AND ';
              $condition_receipt = '';
               
              
					                       				   
					$fees_desc = array();
				     			                      
			    //return id_fee, fee_name
					 $fees_paid = Billings::model()->searchPaidFeesByStudentId($student_id, $this->status_, $acad_sess);
                 		
                 		      if($fees_paid!=null)
				                     {  
					                   foreach($fees_paid as $id_fees_paid)
					                      {   
			 	                               
		 echo '<div class="rmodal"> <div class=""  style="float:left; margin-left:5px; width:auto;"> <div class="l">'.Yii::t('app',$id_fees_paid["fee_label"]).'</div><div class="r checkbox_view" style="margin-left:5px; margin-top:-3px;"><input type="checkbox" name="'.$id_fees_paid["id_fee"].'" id="'.$id_fees_paid["id_fee"].'" checked="checked" value="'.$id_fees_paid["id_fee"].'" disabled="disabled" ></div></div></div>';
			                              										        						
											}
											
								       }
								     
							       				 
	                     ?>
        
            </td>
        </tr>
        
        <tr class="odd"><th><?php echo Yii::t('app','Pending Fee(s) '); ?></th></tr>
        <tr class="odd">
        <td>

           <?php // 
               
               if($this->status_==1)
                 {                        				   
					 $fees_desc = array();
					 
					 
                                      
                       if($fees_paid!=null)
                         { foreach($fees_paid as $fee)
                              $paid_fees_array[] = $fee["id_fee"];
                           }
                    	
                    					 
					 
					 $level=$this->getLevelByStudentId($student_id,$acad_sess)->id;
					                              //return id_fee, fee_name
					$fees_pending = Billings::model()->searchPendingFeesByStudentId($level, $acad_sess);
                 		
                 		      if($fees_pending!=null)
				                     {  
					                   foreach($fees_pending as $fees_pen)
					                      {  
			 	                              if (!in_array($fees_pen["id_fee"], $paid_fees_array))  
					                          {  
					                          	if($pending_balance==null)
					                          	 {
					                          	  if($fees_pen["fee_label"] !="Pending balance")
					                          	    { 
					                          	   
		echo '<div class="rmodal"> <div class=""  style="float:left; margin-left:5px; width:auto;"> <div class="l">'.Yii::t('app',$fees_pen["fee_label"]).'('.numberAccountingFormat($fees_pen["amount"]).')</div><div class="r checkbox_view" style="margin-left:5px; margin-top:-3px;"><input type="checkbox" name="'.$fees_pen["id_fee"].'" id="'.$fees_pen["id_fee"].'"  value="'.$fees_pen["id_fee"].'" disabled="disabled" ></div></div></div>';	
					                          	    }
					                          	    
					                          	 }
					                            else
					                              {
					                              	    if($fees_pen["fee_label"] !="Pending balance")
					                          	            $pending_balance = $fees_pen["amount"];
					                          	            
					                          	         echo '<div class="rmodal"> <div class=""  style="float:left; margin-left:5px; width:auto;"> <div class="l">'.Yii::t('app',$fees_pen["fee_label"]).'('.numberAccountingFormat($pending_balance).')</div><div class="r checkbox_view" style="margin-left:5px; margin-top:-3px;"><input type="checkbox" name="'.$fees_pen["id_fee"].'" id="'.$fees_pen["id_fee"].'"  value="'.$fees_pen["id_fee"].'" disabled="disabled" ></div></div></div>';
					                              	} 
					                          	 		                              
					                           }
					                             
											}
											
								       }
						
                    }
                 	       				 
	                     ?>        
        
        </td>
        </tr>
        

        
        
    </table>

</div>


<?php

   if(isset($model->student))
      {
?>

<div class="span6 grid-view">
<?php 
    
    $see_detail = '';
    
    if($model->comments!='')
        $see_detail = Yii::t('app','See details');
   

  $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		//'student0.fullName',
		//'feePeriod.simpleFeeName',
		array('name'=>Yii::t('app','Fee name'),'value'=>$model->feePeriod->simpleFeeName), 
		//'amount_to_pay',
                 //array('label'=>Yii::t('app','Amount To Pay'),'value'=>'amountToPay'),
                'amountToPay',
                'amountPay',
		//'amount_pay',
		//'balance',
                'BalanceCurrency',
        array('name'=>'date_pay','value'=>$model->datePay),        
		//'date_pay',
		'paymentMethod.method_name',
		//'comments',
		array('header'=>Yii::t('app','Comments'),'name'=>'comments',
                    'type' => 'raw','value'=>'<span class="btn-link"  data-toggle="modal" data-toggle="tooltip" data-target="#comments" title="'.$model->comments.'"> '.$see_detail.'</span>',
                    ),
		'academicperiods0.name_period',
		//array('name'=>'academic_year','value'=>'academicperiods0.name_period'),
	),
)); ?>


</div>
    
    
   <?php

      }
?>        
    
<div class="span2 photo_view">
    <?php
    $modelStud = new Persons;
   

    if($modelStud->ageCalculator($birthday)!=null)
         	  echo '<strong>'.$modelStud->ageCalculator($birthday).Yii::t('app',' yr old').' / '.$modelStud->getRooms($student_id, $acad_sess).'</strong>';
         	else
         	  echo $modelStud->getRooms($student_id, $acad_sess).' ';
    if($image!=null)
                    //if(file_exists(Yii::app()->basePath .'/../photo-Uploads/1/'.$model->image)) // if pdf file exist, allowlink to print it 
                                     echo CHtml::image(Yii::app()->request->baseUrl.'/documents/photo-Uploads/1/'.$image);
                                else         
                                    echo CHtml::image(Yii::app()->request->baseUrl.'/css/images/no_pic.png');
    ?>


    
</div>
      
</div>

<div style="clear:both"></div>
 <!-- Seconde ligne -->
 

<?php

   if(isset($model->student))
      {
?>
<div class="row-fluid">
  
    <div>   
        <ul class="nav nav-tabs">
    <li class="active"><a data-toggle="tab" href="#transaction_list">  <?php echo Yii::t('app','Transactions list'); ?></a></li>
    
    <li ><a data-toggle="tab" href="#payment_receipt">  <?php echo Yii::t('app','Payment receipt'); ?></a></li>
   

    
        </ul>
  
  
   <div class="tab-content">
    
    <!--  ************************** Transactions list *************************    -->

<div id="transaction_list" class="tab-pane fade in active">
       
     
<?php

      $condition ='';
 
$gridWidget = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'billings-grid',
	'dataProvider'=>Billings::model()->searchForView($condition,$model->student,$acad_sess),
	'showTableOnEmpty'=>true,
	//'emptyText'=>Yii::t('app','No academic period found'),
	'summaryText'=>'',
               'mergeColumns'=>array('fee_fname'),
    
        'rowCssClassExpression'=>'($data->balance>0)?"balance":evenOdd($row)',
	
	'columns'=>array(
		
		
		array('name'=>'date_pay',
			//'header'=>Yii::t('app','Fee name'), 
			'value'=>'$data->DatePay'),
       	 
        array(
		    'name'=>'Transaction ID',
			'header'=>Yii::t('app','Transaction ID'),
                        'type' => 'raw',
			'value'=>'CHtml::link($data->id,Yii::app()->createUrl("/billings/billings/view",array("id"=>$data->id,"ri"=>'.$ri.',"from"=>"vie")))',
                        //'htmlOptions'=>array('width'=>'125px'),
                    ),
		             
    			
		array('name'=>'fee_fname',
			'header'=>Yii::t('app','Fee name'), 
			'type' => 'raw',
			'value'=>'CHtml::link($data->feePeriod->simpleFeeName,Yii::app()->createUrl("/billings/billings/view",array("id"=>$data->id,"ri"=>'.$ri.',"from"=>"vie")))',
                        'htmlOptions'=>array('width'=>'325px'),   ),
	
	           
            array('header'=>Yii::t('app', 'Expected amount'),
                  'type' => 'raw',
                  'value'=>'CHtml::link($data->amountToPay,Yii::app()->createUrl("/billings/billings/view",array("id"=>$data->id,"ri"=>'.$ri.',"from"=>"vie")))',
                          ),
                          
                          
             array('header'=>Yii::t('app', 'Amount Pay'),
                  'type' => 'raw',
                  'value'=>'CHtml::link($data->amountPay,Yii::app()->createUrl("/billings/billings/view",array("id"=>$data->id,"ri"=>'.$ri.',"from"=>"vie")))',
                          ),
		
            array('header'=>Yii::t('app', 'Balance'),'value'=>'$data->balanceCurrency'),
		
		
	  ),
)); 

?>

   </div>
   
   
   <!--  ************************** payment receipt *************************    -->
   
<div id="payment_receipt" class="tab-pane fade">
       

<div class="grid-view">

	<?php
	
		//Extract school name 
								               $school_name = infoGeneralConfig('school_name');
                                                                                                //Extract school address
				   								$school_address = infoGeneralConfig('school_address');
                                                                                                //Extract  email address 
                                               $school_email_address = infoGeneralConfig('school_email_address');
                                                                                                //Extract Phone Number
                                                $school_phone_number = infoGeneralConfig('school_phone_number');


	//get level for this student
								$level=0;
								$modelLevel=$this->getLevelByStudentId($model->student,$acad_sess);
								if($modelLevel!=null)
								 {
								 	$level=$modelLevel->id;
								 	
								   }
								
									
?>
	
	
<div  id="resp_form_siges">

        <form  id="resp_form">
        
       
<?php
   
$levelName='';
         if($model->student!='')
           $levelName=$this->getLevelByStudentId($model->student,$acad_sess)->level_name;
         
         $student=$this->getStudent($model->student);
         
		 

?>  

 <div style="width:90%;">
            <label id="resp_form" style="width:100%;">
  
       

      <?php     $pa_daksan = pa_daksan();
         				             
           echo '<div id="rpaie" style="float:left; padding:10px; border:1px solid #EDF1F6; width:98%; ">
                  
                  <div id="header" style="display:none; ">
                     <div class="info">'.headerLogo().'<b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' &nbsp; / &nbsp; '.Yii::t('app','Tel: ').$school_phone_number.' &nbsp; / &nbsp; '.Yii::t('app','Email: ').$school_email_address.'<br/></div> 
                  
                  <br/>
                  
                  <div class="info" style="text-align:center;  margin-top:-9px; margin-bottom:-15px; "> <b>'.strtoupper(strtr(Yii::t('app','Payment receipt'), $pa_daksan )).'</b></div> '; 
			
			echo '<br/>  </div>
			
			    <div class="info" >
			      <div id="stud_name" style="display:none; float:left;">'.Yii::t('app','Name').':  '.$student.' </div>
			     
			           <div id="level" style="display:none; margin-left:62%;">'.Yii::t('app','Level').': '.$levelName.'</div> 
			           
			      
			         <br/><div id="acad" style="display:none; margin-left:62%;">'.Yii::t('app','Academic year').' '.$acad_name.' </div>   ';
			         
			         					  
					  						                
			           	
				if($model->student!='')
				   $dataPro = Billings::model()->searchByStudentId($condition_receipt,$model->student,$acad_sess);
				else
				    $dataPro = Billings::model()->searchByStudentId($condition_receipt,0,$acad_sess);

 
         echo '<br/><div style="margin-left:1%;"> 
			         				<table class="" style="width:99%; background-color: #E5F1F4; color: #1E65A4; -webkit-border-top-left-radius: 5px;-webkit-border-top-right-radius: 5px;-moz-border-radius-topleft: 5px;-moz-border-radius-topright: 5px;border-top-left-radius: 5px;border-top-right-radius: 5px;">
									   <tr>
									   
									       <td style="text-align:center; font-weight: bold; "> '.Yii::t('app','Date Pay').'</td>
									       <td style="text-align:center; font-weight: bold;"> '.Yii::t('app','No.').' </td>
									       <td style="text-align:center; font-weight: bold;">'.Yii::t('app','Rubric').' </td>
									       <td style="text-align:center; font-weight: bold; "> '.Yii::t('app','Expected amount').'</td>
									       <td style="text-align:center; font-weight: bold; "> '.Yii::t('app', 'Received amount').'</td>
									       <td style="text-align:center; font-weight: bold; "> '.Yii::t('app', 'Remain to pay').'</td>
									       
									       
									       
									    </tr>';

 	
						           	  if($dataPro->getData()!= null)  
						           	    { 
						           	    	$result = $dataPro->getData();			           	    	
						           	    	$i=0;
						           	    	foreach($result as $r)
											     { 
											     	
											     	echo '<tr>
												           <td style="text-align:center; "> '.$r->DatePay.'</td>
												           <td style="text-align:center;"> '.$r->id.'  </td>
														   <td style="text-align:center; ">'.$r->feePeriod->simpleFeeName.' </td>
														   <td style="text-align:center; "> '.$r->amountToPay.'</td>
														   <td style="text-align:center;"> '.$r->amountPay.'  </td>
														   <td style="text-align:center; ">'.$r->balanceCurrency.' </td>
														   
														  </tr>';
			
														     
													  
												    }
														  
												 
								              
							           	      } 
							              
							             echo '  </table> 
						                    </div>';
				                          
				             
							         
			               
		echo '	    <br/>
			      <div style="text-indent: 200px; font-weight: bold; font-style: italic;"> &nbsp;&nbsp;&nbsp;'.Yii::t('app','Authorized signature').'</div><br/><br/>
			         
			       </div>
			<div style="float:right; text-align: right; font-size: 6px; margin-bottom:-8px;"> SIGES, '. Yii::t('app','Powered by ').'LOGIPAM </div>      
			     </div>';
										
	   ?>
	   </label>
    </div> 

<br/>
                 
                            <div class="col-submit">
 
                                
                                <?php  echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                                       if($dataPro->getData()!=null)
                                         {
									       
									       echo '<a  class="btn btn-success col-4" style="margin-left:10px; " onclick="printDiv(\'rpaie\')">'. Yii::t('app','Print').'</a>';
									       
									     
									     echo '<br/>';
									               
                                         }
                                         
                                         
                                              //back button   
                                              $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo '  <a href="index/part/rec/from/stud" style="margin-left:10px;margin-top:10px;" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                                ?>
     
                            
                  </div><!-- /.table-responsive -->
                  
<?php
 
?>

                  
                </form>
              </div>



</div>



</div>



 <!-- Modal Commentaire -->
  <div class="modal fade" id="comments" role="dialog">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo Yii::t('app','Comments'); ?></h4>
        </div>
        <div class="modal-body">
        <?php echo $model->comments; ?>
            
        <!-- Fin contenu modal -->  
        
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo Yii::t('app','Close'); ?></button>
        </div>
      </div>
    </div>
  </div>


<script type="text/javascript">
    
function printDiv(divName) {
     document.getElementById("header").style.display = "block";
     document.getElementById("stud_name").style.display = "block";
     document.getElementById("level").style.display = "block";
     document.getElementById("acad").style.display = "block";
     document.getElementById(divName).style.display = "block";
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
     document.getElementById("header").style.display = "none";
     document.getElementById("stud_name").style.display = "none";
     document.getElementById("level").style.display = "none";
     document.getElementById("acad").style.display = "none";

} 


</script>


<?php
      }

?>

















