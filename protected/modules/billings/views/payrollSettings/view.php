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


/* @var $this PayrollSettingsController */
/* @var $model PayrollSettings */

$acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year'];

?>


<div id="dash">
          
          <div class="span3"><h2>
               <?php if(isset($_GET['all']))
                       {  
                       	  if($_GET['all']=='t')
                             echo Yii::t('app', 'Payroll setting for teachers');
                          elseif($_GET['all']=='e')
                              echo Yii::t('app', 'Payroll setting for employees');
                         
                       }
                     else
                        echo Yii::t('app', 'Payroll setting for: {name}',array('{name}'=>$model->person->fullName));            
                  ?>
               
          </h2> </div>
     
		   <div class="span3">
              
 <?php 
     
     if(!isAchiveMode($acad_sess))
        {     
        
   ?>

           <div class="span4">

                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/billings/payrollSettings/create/part/pay/from/stud')); 

                   ?>

              </div>
              
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard

                       if(isset($_GET['all']))
                         { 
                       	   echo CHtml::link($images,array('/billings/payrollSettings/update/part/pay/','id'=>$_GET['id'],'all'=>$_GET['all'],'from'=>'view'));
                       	   
                         }
                       else 
                           echo CHtml::link($images,array('/billings/payrollSettings/update/part/pay/','id'=>$model->id,'from'=>'view'));

                     ?>

              </div> 

 <?php
        }
      
      ?>       
              
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                     echo CHtml::link($images,array('/billings/payrollSettings/index/part/pay/from/stud')); 

                   ?>

            </div> 

        </div>
  </div>



<div style="clear:both"></div>



<br/>
  <?php
    echo $this->renderPartial('//layouts/navBaseBilling',NULL,true);	
    ?>




<?php 

if(!isset($_GET['all']))
{
	   $this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>array(
			
			'Amount',
			
			
			array('name'=>'as',
			
			'value'=>$model->AsValue
			  ),
			  
			'AnHour',
			array('name'=>Yii::t('app','Taxe'),
			
			'value'=>$model->TaxeToPay
			  ),
			'academicYear.name_period',
			'date_created',
			
		    ),
	    ));
  }
else
 {
 	if(($_GET['all']=='t')||($_GET['all']=='e'))
      {
      	    $header='';
                            if($_GET['all']=='t')//teacher
                                 {
                                $condition='is_student=0 AND p.id IN(SELECT teacher FROM courses c left join room_has_person rh on(c.room=rh.room) WHERE (c.academic_period='.$acad.' OR rh.academic_year='.$acad.') ) AND active IN(1, 2) ';
                                    
                                    $header=Yii::t('app','Teachers name');
                                 }
                               elseif($_GET['all']=='e')//employee
                                  { $condition='is_student=0 AND active IN(1, 2) AND p.id NOT IN(SELECT teacher FROM courses c left join room_has_person rh on(c.room=rh.room) WHERE (c.academic_period='.$acad.' OR rh.academic_year='.$acad.') ) ';
                                  
                                      $header=Yii::t('app','Employees name');
                                   }
	    	  	$dataProvider=Persons::model()->searchPersonsForShowingPayrollSetting($condition,$acad);
	    	  	

      	
		      	$this->widget('zii.widgets.grid.CGridView', array(
		    //'id'=>'grades-grid',
			'dataProvider'=>$dataProvider,
			'showTableOnEmpty'=>'true',
			//'selectableRows' => 2,
			//'filter'=>$model,
		    'columns'=>array(
			  //'id',
			//array('name'=>'student_iD','value'=>'$data->id'),
				
			  array('name'=>$header,//'Student name',
		                'header'=>$header,//Yii::t('app','Student name'),
			        'value'=>'$data->first_name." ".$data->last_name'
					),
		     array('header' =>Yii::t('app','Amount'), 'id'=>'amountValue', 'value' => '\'
		           <input name="amount[\'.$data->id.\']" type=text value="\'.$data->amount.\'" style="width:92%;" disabled="disabled" />
		          
				   <!--<input name="id_pers[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" /> -->
		           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
		           \'','type'=>'raw' ),
		           
		       array('name'=>'an_hour',
		                'header'=>Yii::t('app','An Hour'),
			        'value'=>'$data->AnHour_'
					),
			   //'number_of_hour',
			    array('name'=>'number_of_hour',
		                'header'=>Yii::t('app','Number Of Hour'),
			        'value'=>'$data->numberHour_'
					),
					
		       				
		      ),
		    ));

      }
      
      
  }




 ?>
