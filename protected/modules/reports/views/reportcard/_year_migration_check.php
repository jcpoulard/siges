<?php 
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
$acad_name=Yii::app()->session['currentName_academic_year'];

$siges_structure = infoGeneralConfig('siges_structure_session');

if($siges_structure==1)//previous
  {  $previous_acad_sess= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
     if($previous_acad_sess=='')
        $previous_acad_sess=0;
        
  }
  

/* @var $this SellingsController */
/* @var $model Sellings */
/* @var $form CActiveForm */
?>

 <div id="dash">
    <div class="span3">
<h2><?php if($siges_structure==0)
             echo Yii::t('app','Data migration from previous year.');
          elseif($siges_structure==1)
             echo Yii::t('app','Data migration from previous session.'); ?></h2>
    </div>
</div>

<div style="clear:both"></div>



<div class="form">
<?php 

        $form=$this->beginWidget('CActiveForm', array(
            'id'=>'migration-form',
            'enableAjaxValidation'=>true,
        )); 
    
   
        $all_step= ''; 
					                
   ////-1: migration not yet done; 1: migration is not completed; 2: migration done; 0: no migration to do 
							//migration check to display link 
							if($siges_structure==0)
							   $check= getYearMigrationCheck($acad_sess);
							elseif($siges_structure==1)//previous
							 {
							 	$check= getYearMigrationCheck($previous_acad_sess);
							 	}
							
							$display = true;
							$no_result=false;
							
							if( ($check==-1) || ($check== 1) )
							  { //nap jere afichaj link lan pou 2 mwa
							      $start_date =''; // dat ane akademik lan t kreye
							      $nonb_de_jou =0;
							        if($siges_structure==0)
							            $data_migrationCheck = YearMigrationCheck::model()->getValueYearMigrationCheck($acad_sess);
							        elseif($siges_structure==1)//previous
							         {
							         	 $data_migrationCheck = YearMigrationCheck::model()->getValueYearMigrationCheck($previous_acad_sess);
							         	}
							    
							         if($data_migrationCheck!=null)
							           {  foreach($data_migrationCheck as $d)
							               {
							    	         if($d['date_created']!='')
							    	            $start_date = $d['date_created'];
							    	            
							    	         if($siges_structure==0)
							    	          {   
							                  //period  
							                  if($d['period']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:-10px; "> <div class="l" >'.Yii::t('app','Period').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:-10px; width:auto;"> <div class="l" >'.Yii::t('app','Period').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //postulant  
							                   if($d['postulant']==0)
							                   $all_step = $all_step. '
<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Postulant').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Postulant').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   // student 
							                   if($d['student']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Student').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Student').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //course  
							                   if($d['course']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Course').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Course').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //evaluation  
							                   if($d['evaluation']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Evaluation').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Evaluation').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //passing grade  
							                   if($d['passing_grade']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Passing Grades').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Passing Grades').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //reportcard_observation  
							                   if($d['reportcard_observation']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Observation reportcard').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Observation reportcard').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //fees 
							                   if($d['fees']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Fees').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Fees').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //taxes  
							                   if($d['taxes']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Taxes').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Taxes').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //pending balance  
							                   if($d['pending_balance']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Pending balance').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Pending balance').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                     
							    	          }
							    	        elseif($siges_structure==1)//previous
							                 {
							                   
							                   //postulant  
							                   if($d['postulant']==0)
							                   $all_step = $all_step. '
<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Postulant').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Postulant').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   // student 
							                   if($d['student']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Student').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Student').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   							                   							                   
							                   //passing grade  
							                   if($d['passing_grade']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Passing Grades').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Passing Grades').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //reportcard_observation  
							                   if($d['reportcard_observation']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Observation reportcard').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Observation reportcard').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   
							                   //pending balance  
							                   if($d['pending_balance']==0)
							                   $all_step = $all_step. '<div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Pending balance').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-square-o" aria-hidden="true"></i> </div></div></div>';
							                  else
							                     $all_step = $all_step. '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Pending balance').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>';
							                   }
				 			                      
							                }
							           }
							           
							  if($siges_structure==0)
							     {  
							       if($start_date!='')
							           $nonb_de_jou = date_diff ( date_create($start_date)  , date_create(date('Y-m-d') ))->format('%R%a');
								
								  if($nonb_de_jou > 60) //60 jou
							         {  $display = false;
							  	     	$message_year_migration= Yii::t('app','Migration is not allowed after 60 days start from the begining of the academic year.');
							  	     }
							  	     
							     }
							  
							  }
							elseif($check==2)
							  { $display = false; 
							    
							  if($siges_structure==0)
							    {
							      $all_step = '<div class="rmodal"> <div style="float:left; margin-left:-10px; width:auto;"> <div class="l" >'.Yii::t('app','Period').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Postulant').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div> 
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Student').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Course').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Evaluation').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Passing Grades').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Observation reportcard').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Fees').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Pending balance').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>

							    
							    ';
							      
							      }
							    elseif($siges_structure==1)//previous
							         {
							              $all_step = '<div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Postulant').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div> 
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Student').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Passing Grades').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Observation reportcard').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div  style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Taxes').'</div><div class="r " style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>
							                 
							                 <div class="rmodal"> <div style="float:left; margin-left:15px; width:auto;"> <div class="l" >'.Yii::t('app','Pending balance').'</div><div class="r" style="margin-left:5px; margin-top:3px;"> <i class="fa fa-check-square-o" aria-hidden="true"></i> </div></div></div>

							    
							    ';
							           }
							    
							  	$message_year_migration= Yii::t('app','All migration already done.');
							                          
							   }
							 elseif($check==0)
							  { $display = false; 
							     $no_result=true;
							  	$message_year_migration= Yii::t('app','No migration to do.');
							  	
							                          
							   } 
							
   
        
   ?>
   
<div class="b_m">

<div class="row">
    
    
    
      <div id="transac" class="" style="width:99%; background-color: #fff; min-height: 180px; padding: 5px;">
        
       <div class="box box-primary" style="  background-color: #FF4B4B">
            <div class="  with-border " style=' padding:8px 0px 8px 0; margin-left:-7px;'>
                <h3 class="box-title" style='color: #D5F5DE'>
                    <?php 
                        echo "<span class='badge' style=' padding:5px 45px 5px 8px; background: #fff; color: #EE6539; font-size:16pt; font-weight: bold;'>".Yii::t('app','Warning')."</span>";
                    ?>
                </h3>
            </div>
        </div>    
            <div class="box-body" style='height: 250px; overflow: scroll'>
             La migration de données permet de transférer les données et configurations de l’année scolaire précédente vers la nouvelle année que vous venez de créer. Spécifiquement, les données qui seront migrées sont : Périodes académiques, Postulants, Elèves, Cours, Evaluation, Notes de passage, Observation bulletin, Frais et Balance antérieure. Une fois migrées, toutes ces informations pourront être modifiées pour refléter la réalité de l’année en cours. C’est un processus assez important, il faut donc être prêt pour le faire. Donc, il faut absolument vérifier que :<br/>1.	<b>L’année académique précédente touche à sa fin (Date de fin, où « Est année » est OUI)</b> <br/> 2.	<b>Les décisions de fin d’année soient prises</b>   <br/>Il existe deux manières d’exécuter les décisions de fin d’année dans SIGES : automatiquement ou manuellement. Il faut configurer cette fonctionnalité dans la partie configuration générale du logiciel. Cette action est importante parce qu’elle permet de migrer les informations personnelles des élèves. Le logiciel migrera les élèves dans leurs classes respectives conformément aux décisions qui auront été prises. L’utilisateur devra par la suite distribuer les élèves dans leurs salles en utilisant la fonctionnalité « Répartition en classe » dans le module de Gestion académique. 
            </div>
            
             <?php
                   if($no_result==false)
                    {
                ?>
                <div class="box-footer with-border" style=" padding:1px 5px 0px 5px; margin-bottom:-20px; font-size:9pt; font-weight: bold;">
               
	                <div class="alert alert-success" style="text-align: center; ">
	                    <strong><?php  echo $all_step.'.'; ?></strong>
	                </div>
                               
            </div>
            
             <?php
                    }
                ?>
                
        </div>
        
      

    <form  id="resp_form">
        <div class="row-fluid">
            
            <?php 
               if($display==true)
                 {
              ?>
		            <div class="col-submit" style="margin: 10px auto;">
		                   <?php echo CHtml::submitButton(Yii::t('app', 'Process'),array('name'=>'create','class'=>'btn btn-warning btn-large')); ?>
		            </div>
            <?php
                   } 
                else
                  {
              ?>
                    <div  style="color:red; font-size:10pt; font-weight: bold; margin-left:10px;">
                          <?php  echo $message_year_migration; ?>
                    </div>
               
               <?php  }
               
                  ?>
            
        </div>
    </form>
    

</div>
</div>
<?php $this->endWidget(); ?>

</div>
