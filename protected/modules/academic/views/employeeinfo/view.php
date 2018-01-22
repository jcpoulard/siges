
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
/* @var $this EmployeeinfoController */
/* @var $model EmployeeInfo */

$acad=Yii::app()->session['currentId_academic_year'];

$acad_sess=acad_sess();  


?>

<div id="dash">
          
          <div class="span3"><h2>
               <?php echo Yii::t('app', 'More info for : {name}',array('{name}'=>$model->employee0->fullName)); ?> 
          
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

                   if(isset($_GET['from'])&&($_GET['from']=='rpt')) 
                     { 
                     	echo '';
                     }
                    else
		              { echo CHtml::link($images,array('employeeinfo/create')); 
		              
		              }

                   ?>

              </div>

              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';

                               // build the link in Yii standard
                              $from='';
                              $emp='';
                             if(isset($_GET['from']))
                               $from=$_GET['from'];
                               
                             if(isset($_GET['pers']))
                               $emp=$_GET['pers'];
                              
                              if($from!='rpt')    
                                  echo CHtml::link($images,array('employeeinfo/update/','id'=>$model->id,'from'=>'view','from1'=>$from,'emp'=>$emp)); 

                     ?>

              </div> 

 <?php
        }
      
      ?>       
         
              <div class="span4">

                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                    if(isset($_GET['from'])&&($_GET['from']=='rpt')) 
                     { 
                     	echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=ext&isstud=0&from=rpt'));
                     	
                     }
                    else
		              {  if(isset($_GET['pers'])&&($_GET['pers']!=""))
                           {   if(isset($_GET['from']))
						           { if($_GET['from']=='stud')
						                   echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=1&from=stud'));
						             elseif($_GET['from']=='teach')
						                 echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&isstud=0&from=teach'));
						                 elseif($_GET['from']=='emp')
						                     echo CHtml::link($images,array('/academic/persons/viewForReport?id='.$_GET['pers'].'&pg=lr&from=emp')); 
						                     
						           }   
						                   
		                      }
		                      else        
		                        echo CHtml::link($images,array('employeeinfo/index?from=emp')); 	
		                        
		              }

                   ?>

            </div>        
       </div>
</div>

<div style="clear:both"></div>


<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		
		'employee0.fullName',
		'hire_date',
		'country_of_birth',
		'university_or_school',
		'number_of_year_of_study',
		'fieldStudy.field_name',
		'qualification0.qualification_name',
		'jobStatus.status_name',
		'permis_enseignant',
		'leaving_date',
		'comments',
		
	),
)); ?>
