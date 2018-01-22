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
           
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 $template1 ='';
 $template ='';         
          
  $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                   
                          $group_name=$group->group_name;
  
  
  $part ='enrlis';
  
  if(isset($_GET['part']))
    $part = $_GET['part'];          
 
     
     
//Extract school name 
$school_name = infoGeneralConfig('school_name');
//Extract school address
$school_address = infoGeneralConfig('school_address');
//Extract  email address 
 $school_email_address = infoGeneralConfig('school_email_address');
  //Extract Phone Number
$school_phone_number = infoGeneralConfig('school_phone_number');
 //Extract admission note
$admission_note = infoGeneralConfig('admission_note');

?>
             


<!-- Menu of CRUD  -->



<div id="dash">
          
          <div class="span3"><h2>
          
       <?php  
       
             echo Yii::t('app','Postulant').' ('.$model->FullName.')'; 
                      	   
		?>
                 
             </h2> </div>
             
             
      <div class="span3">
 
         <?php 
               if(!isAchiveMode($acad_sess))
                 {     $template1 = $template;    
        ?>
        
          
      <?php   
             if(!isset($_GET['part'])||($_GET['part']!='rec'))
              {
	             $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';
	
	                               // build the link in Yii standard
	                  	 echo ' <div class="span4">';
				         echo CHtml::link($images,array('/academic/postulant/create?')); 
				         echo ' </div>';     
				      
				      
				      
				    $images = '<i class="fa fa-edit">&nbsp;'.Yii::t('app','Update').'</i>';
	
	                               // build the link in Yii standard
	                  	 	   echo ' <div class="span4">';
							echo CHtml::link($images,array('/academic/postulant/update','id'=>$model->id,'part'=>$part,'pg'=>''));
							echo ' </div>'; 
								
                }
               
                   ?>

               
              
     <?php        }
             
             
            
            ?>
  
           
              <div class="span4">

                      <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard
  
                      if($part=='enrlis')
	                   {   echo CHtml::link($images, array('/academic/postulant/viewListAdmission','part'=>$part,'pg'=>'' ));
	                      $this->back_url='/academic/postulant/viewListAdmission/part/'.$part.'/pg/';   
	                   }
	                   elseif($part=='applis') 
	                   {   echo CHtml::link($images, array('/academic/postulant/viewApprovePostulant','part'=>$part,'pg'=>'' ));
	                      $this->back_url='/academic/postulant/viewApprovePostulant/part/'.$part.'/pg/';   
	                   }
	                   elseif(($part=='bill')||($part=='rec'))
	                   {   echo CHtml::link($images, array('/billings/enrollmentIncome/index','part'=>$part,'pg'=>'' ));
	                      $this->back_url='/billings/enrollmentIncome/index/part/'.$part.'/pg/';   
	                   } 
	                /*   elseif($part=='rec') 
	                   {   echo CHtml::link($images, array('/billings/enrollmentIncome/index','part'=>$part,'pg'=>'' ));
	                      $this->back_url='/billings/enrollmentIncome/index/part/'.$part.'/pg/';   
	                   }                         
                      */                       
                     
                   ?>

                  </div>  
    
        </div>
 </div>	


<div class="clear" > </div>


<!--  ************************** POSTULANT *************************    -->
<div>
  <ul class="nav nav-tabs">
    <!--  ************************** POSTULANT INFO *************************    -->
    <li class="active"><a data-toggle="tab" href="#postulantinfo"><?php echo Yii::t('app','Postulant info'); ?></a></li>
    
    	      
  </ul>


  <div class="tab-content">
    
    <!--  ************************** POSTULANT INFO *************************    -->

<div id="postulantinfo" class="tab-pane fade in active">

<div  style="float:left; padding:10px; border:1px solid #EDF1F6; width:78%; ">
       
      <div class="span6">
        <div class="activat">

<?php

         //Extract admission note
          $admission_note = infoGeneralConfig('admission_note');
                                 
                                 		
 echo '<div class="CDetailView_photo" style="margin-bottom:20px;  width:100%;"  >';
	                         
		   	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
            
             array('name'=>Yii::t('app','Sexe'),'value'=>$model->getSexe() ),
             
             array('name'=>Yii::t('app','Blood Group'),'value'=>$model->getBlood_group() ),
		      
		     array('name'=>'birthday','value'=>ChangeDateFormat($model->birthday)),
                       
			 array('name'=>Yii::t('app','Birth place'),'value'=>$model->getCity()),
				
			  'adresse',
				
			  'phone',
			  
			  array(     'header'=>Yii::t('app','Health state'),
		                    'name'=>Yii::t('app','Health state'),
		                    'value'=>$model->health_state,
		                ), 
		               				
				
				
					),
				));
				
		 		      
		 	echo '</div>';	
		 
		 
		  echo '<div class="CDetailView_photo" style="margin-left:0px;  width:100%;" >';
	                         
		   	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
			
		       array( 'name'=>Yii::t('app','Apply for level'),'value'=>$model->getLevel($model->apply_for_level ) ), 
		       
		       array( 'name'=>Yii::t('app','Previous level name'),'value'=>$model->getLevel($model->previous_level) ),  
		               
		        array( 'name'=>Yii::t('app','Previous school'),'value'=>$model->previous_school ), 
		        
		        'last_average',
		        
		        array('name'=>'school_date_entry','value'=>ChangeDateFormat($model->school_date_entry)),
		    
				array('name'=>'status', 'value'=>$model->Status ),
				
				array('name'=>'paid', 'value'=>$model->Paid),
				
					),
				));
				
		 		      
		 	echo '</div>';	
		 	
	
	?>
	</div>
	</div>
	
           
     
	
	
	
	
	<div class="span6">
        <div class="activat">
        
       
         <!-- Debut affichage des champs personalisables -->
              <?php
                    $criteria = new CDbCriteria;
                    $criteria->condition = "field_related_to='stud'";
                    $data_custom_label = CustomField::model()->findAll($criteria);
                    $id_student = $_GET['id'];
                    $konte_liy=0;
                    /*
                    function evenOdd($num)
                        {
                            ($num % 2==0) ? $class = 'odd' : $class = 'even';
                            return $class;
                        }
                     * 
                     */
                     
     if($data_custom_label!=null)
     {                
          	
             echo '<div class="CDetailView_photo" style="margin-bottom:20px; margin-left:0px; width:100%;"  >';   
               ?>
              
              

              <table class="detail-view">
                  <tbody>
                      <?php  foreach($data_custom_label as $dcl){ ?>
                      <tr class="<?php ($konte_liy % 2==0) ? $class = 'odd' : $class = 'even'; echo $class;  ?>">
                          <th> <?php echo $dcl->field_label ?></th>
                          <td><?php echo CustomFieldData::model()->getCustomFieldValue($id_student,$dcl->id); ?></td>
                      </tr>
                      <?php 
                      $konte_liy++;
                      
                      } ?>
                  </tbody>
              </table>
   
    <?php
             echo '</div >';   
     }
             

	echo '<div class="CDetailView_photo" style="margin-left:0px;   width:100%;" >';
	                         
		   	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
              array('name'=>Yii::t('app','Person liable'),'value'=>$model->person_liable ),  
		      
		      array('name'=>Yii::t('app','Person liable phone'),'value'=>$model->person_liable_phone ),  
		      
		      array('name'=>Yii::t('app','Person Liable Adresse'),'value'=>$model->person_liable_adresse ),  
		      
		      array('name'=>Yii::t('app','Person Liable Relation'),'value'=>$model->getRelation($model->person_liable_relation) ),   
		      
                         
				
					),
				));
				
		 		      
		 	echo '</div>';	
		 	
    //admission
    ?>
	</div>
	 <!-- Note: -->
<div style=" margin-bottom:90px;   width:100%;" >
<?php
  echo Yii::t('app','Note').': <textarea id="note" rows="4" cols="140" style="height:60px; width:97%; display:inline;" >'.$admission_note.' </textarea>'; 
?>

</div>
	</div>
	
	
<div style="margin-top:250px; text-indent: 150px; font-weight: bold; font-style: italic;"> &nbsp;&nbsp;&nbsp;<?php echo Yii::t('app','Authorized signature'); ?></div><br/>
			         
			       
		<div style="float:right; text-align: right; font-size: 6px; margin-bottom:-8px;"> SIGES, <?php echo  Yii::t('app','Powered by '); ?>LOGIPAM </div>		      
			    
			    
			     </div>


 <div class="col-submit">                             
                                <a  class="btn btn-success col-4" style="margin-left:10px; margin-right: 5px;" onclick="printDiv('print_receipt')"><?php echo Yii::t('app','Print'); ?></a>  
                                
                             <?php   $url=Yii::app()->request->urlReferrer;//$_SERVER['REQUEST_URI'];
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';

				                     ?>
                                              
   </div>


      
  </div>
</div>

</div>


<!-- ###################################   -->

           


<div id="print_receipt" style="display:none;   border:1px solid #EDF1F6; width:100%; ">
  <div   >     
     
 <?php    
             $date_end = AcademicPeriods::model()->findByPk($acad_sess)->date_end;
				            $year_end = date("Y",strtotime($date_end));
				            $string_year = $year_end.'-'.($year_end+1);
				            //echo Yii::t('app','Academic year').': '.$string_year; 
			            
				            
 echo ' <div id="header" style="display:none; "><div class="info">'.headerLogo().'<b>'.strtoupper(strtr($school_name, pa_daksan() )).'</b><br/>'.$school_address.' &nbsp; / &nbsp; '.Yii::t('app','Tel: ').$school_phone_number.' &nbsp; / &nbsp; '.Yii::t('app','Email: ').$school_email_address.'<br/></div> 
                  
                  <br/> 
                  
                  <div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Admission sheet'), pa_daksan() )).'</b> <br/> '.Yii::t('app','Academic year').' '.$string_year.' </div>
                             
                             <!--<div class="info" style="text-align:center; "> <b>'.strtoupper(strtr(Yii::t('app','Enrollment receipt'), pa_daksan() )).'</b></div> -->
                  <br/>
                  </div>
                  '; 
        ?>
     
            
     <div class="CDetailView_photo" style="margin-top:-13px; margin-bottom:7px;  width:100%;"  >
<?php		                    
		   	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
             array('name'=>Yii::t('app','Postulant'),'value'=>$model->getFullName() ), 
             
             array('name'=>Yii::t('app','Sexe'),'value'=>$model->getSexe() ),
             
             //array('name'=>Yii::t('app','Blood Group'),'value'=>$model->getBlood_group() ),
		      
		     array('name'=>'birthday','value'=>ChangeDateFormat($model->birthday)),
                       
			  array('name'=>Yii::t('app','Birth place'),'value'=>$model->getCity()),
				
			  'adresse',
				
			  'phone',
			 
			   array(     'header'=>Yii::t('app','Health state'),
		                    'name'=>Yii::t('app','Health state'),
		                    'value'=>$model->health_state,
		                ),
					),
					
				));
	?>			
	</div>
        
	<div class="CDetailView_photo" style="margin-left:0px; margin-bottom:7px;  width:100%;" >
	<?php                         
		   	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
			
		       array( 'name'=>Yii::t('app','Apply for level'),'value'=>$model->getLevel($model->apply_for_level ) ), 
		       
		       //array( 'name'=>Yii::t('app','Previous level name'),'value'=>$model->getLevel($model->previous_level) ),  
		               
		        array( 'name'=>Yii::t('app','Previous school'),'value'=>$model->previous_school ), 
		        
		        'last_average',
		        
		        array('name'=>'school_date_entry','value'=>ChangeDateFormat($model->school_date_entry)),
		    
				//array('name'=>'status', 'value'=>$model->Status ),
				
				array('name'=>'paid', 'value'=>$model->PaidAmount),
				
					),
				));
	?>   
      </div> 
         
       <?php
                    $criteria = new CDbCriteria;
                    $criteria->condition = "field_related_to='stud'";
                    $data_custom_label = CustomField::model()->findAll($criteria);
                    $id_student = $_GET['id'];
                    $konte_liy=0;
                     
     if($data_custom_label!=null)
     {    
       ?>  
                          
          <div class="CDetailView_photo" style="margin-bottom:7px; margin-left:0px; width:100%;"  >
            <table class="detail-view">
                  <tbody>
                      <?php  foreach($data_custom_label as $dcl){ ?>
                      <tr class="<?php ($konte_liy % 2==0) ? $class = 'odd' : $class = 'even'; echo $class;  ?>">
                          <th> <?php echo $dcl->field_label ?></th>
                          <td><?php echo CustomFieldData::model()->getCustomFieldValue($id_student,$dcl->id); ?></td>
                      </tr>
                      <?php 
                      $konte_liy++;
                      
                      } ?>
                  </tbody>
              </table>
           </div >
           
<?php
            
     }
     ?>
     
  
	<div class="CDetailView_photo" style="margin-left:0px; margin-bottom:7px;   width:100%;" >
	                         
	<?php
		   	$this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				
              array('name'=>Yii::t('app','Person liable'),'value'=>$model->person_liable ),  
		      
		      array('name'=>Yii::t('app','Person liable phone'),'value'=>$model->person_liable_phone ),  
		      
		      //array('name'=>Yii::t('app','Person Liable Adresse'),'value'=>$model->person_liable_adresse ),  
		      
		      array('name'=>Yii::t('app','Person Liable Relation'),'value'=>$model->getRelation($model->person_liable_relation) ),   
		      
                         
				
					),
				));
		?>
  </div>

        		 	
	 </div>
	 <!-- Note: -->
<div style=" margin-bottom:35px;   width:100%;" >
  
<?php
   echo Yii::t('app','Note').':<p> <textarea id="note1" rows="6" cols="140" style="font-size: 10px; line-height:14px; padding-top:4px;padding-bottom:4px; height:60px; width:98%; display:inline;">  </textarea></p>'; 
?>

</div>

<div>	 
<div style="float:left; width:40%; margin-bottom:-7px; text-indent: 90px; font-weight: bold; font-style: italic;"> &nbsp;&nbsp;&nbsp;<?php echo Yii::t('app','Authorized signature'); ?></div>
<div style="float:right; margin-right:140px;  width:27%; margin-bottom:-17px; font-weight: bold; font-style: italic;"> &nbsp;&nbsp;&nbsp;<?php echo Yii::t('app','Person liable'); ?></div>
			         
			       
		<div style="float:right;  width:16%; text-align: right; font-size: 6px; margin-top:-17px;"> SIGES, <?php echo  Yii::t('app','Powered by '); ?>LOGIPAM </div>		      
  </div>			    
			    
			     </div>


 





<script type="text/javascript">
    
function printDiv(divName) {
     document.getElementById("header").style.display = "block";
     document.getElementById(divName).style.display = "block"; 
      var notes = document.getElementById("note").value;
     document.getElementById("note1").innerHTML = notes;
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;
     
     
     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
     document.getElementById(divName).style.display = "none";
     document.getElementById("header").style.display = "none";
} 


</script>


<!--  ************************** END POSTULANT *************************    -->


      




     