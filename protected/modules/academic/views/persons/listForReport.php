
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is  a free software: you can redistribute it and/or modify
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

 $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
						/*  if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							     */
							         $condition = 'p.active IN(1,2) AND ';
						        //}




$id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				

$template1 ='';
$template ='';
?>


	
			

	

	
<!-- Menu of CRUD  -->

<div id="dash">
          
          <div class="span3"><h2>      
       <?php  $drop=0;
      if(isset($_GET['isstud']))
        { if($_GET['isstud']==1){ $drop=1; echo Yii::t('app','Students'); }
			elseif($_GET['isstud']==0) echo Yii::t('app','Working Teachers'); 
		}
      else		
	      echo Yii::t('app','Employees'); 
		?>
              </h2> </div>
              
      <div class="span3">
             

        <?php 
               if(!isAchiveMode($acad_sess))
                 {    if(isset($_GET['isstud']))
						{ if($_GET['isstud']==1) 
							{ 
								   	  //$template='';  
								   	  
								  if((Yii::app()->user->profil=='Teacher'))
						            $template='';
								  else  //Yii::app()->user->profil != 'Teacher'
								   	{
						              if((isset($_GET['from']))&&($_GET['from']=='stud'))
								   	      $template='{update}{delete}{mail}'; //{view}
						              else
								   	    $template='';
								   	 
								   	}//fen if((Yii::app()->user->profil!='Teacher'))
						                  
						     }
						 elseif($_GET['isstud']==0)
							{    
						            
								   if((Yii::app()->user->profil=='Teacher'))
						             $template='';
								   else  //Yii::app()->user->profil != 'Teacher'
								   	{               
									   	if(isset($_GET['from']))
									   	   $template='{update}{mail}';
									   	else
									   	    $template='';//'{view}';
									}	  
							 }
							 
						  }
						else
						  {  if(isset($_GET['from']))
							   $template='{update}{delete}{mail}';
							 else
							   $template='';
								
						   }
   
   
                 $template1 = $template;   
                  
        ?>
                  <?php

                     $images = '<i class="fa fa-plus">&nbsp;'.Yii::t('app','Add').'</i>';

                               // build the link in Yii standard
                    if(isset($_GET['isstud'])) 
                     {  if($_GET['isstud']==1)
                           {  if(!isset($_GET['from1']))
                                {
                           	       if((Yii::app()->user->profil!='Teacher'))
         							 {  
         							 	echo '<div class="span4">';
         							 	echo CHtml::link($images,array('persons/create?isstud=1&pg=lr&from=stud'));
         							 	
         							 	echo '  </div>'; 
         							 }
									
								 }
                           }
                           
					   }
				   else      
					  {   if(!isset($_GET['from1']))
                                {	
                                	if((isset($_GET['from']))&&($_GET['from']=='emp'))
                                      {	    
                                      	echo '<div class="span4">';
                                      	echo CHtml::link($images,array('persons/create?pg=lr&from=emp')); 
                                         echo '</div> ';
                                       }  
                                         
                                
                                }
                                
					  }
					   
              
                   ?>

      <?php
                 }
      
      ?>       

             

                              
              
					
			   <div class="span4">
                  <?php

                     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

                               // build the link in Yii standard

                    // if ($drop==1)
					   
                     if(isset($_GET['from'])){
                        if($_GET['from']=='teach')
                         echo CHtml::link($images,array('../site/index'));
                        elseif($_GET['from']=='emp')
                                  echo CHtml::link($images,array('../site/index'));
                          else
                            echo CHtml::link($images,array('../site/index'));
                                                          
                     }
                     else
                        {   if(isset($_GET['from1']))
                                {
                            	    if($_GET['from1']=='rpt')
                                       echo CHtml::link($images,array('/reports/reportcard/generalreport?from1=rpt'));
                                  }

                        	                         	 
                        }
                   ?>

                  </div> 
    
               
         </div> 

 </div>



<div style="clear:both"></div>				
				

</br>

         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
<?php
if((isset($_GET['isstud']) && ($_GET['isstud']==0))&&((isset($_GET['from1']) && ($_GET['from1']=='rpt'))))
   {
?>                        
                        <tr>
                          <td colspan="4" style="background-color:#EFF3F8;border: none;">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	'enableAjaxValidation'=>true,
));
?>

   <div  style="padding:0px;">			
			<!--Shift(vacation)-->
        <div class="left" style="margin-left:10px;" >
		
			<label for="Shifts"> <?php 
					 echo Yii::t('app','Shift'); 
					 ?>
				</label>
					 <?php 
					   
					 
						$modelShift = new Shifts;
						
						$default_vacation=null;
			            
			            $default_vacation_name = infoGeneralConfig('default_vacation');
			            
			            $default_vacation = infoGeneralConfig($default_vacation_name);
			            
			            
						    
						
			

						      if(isset($this->idShift)&&($this->idShift!=""))
						        {   
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->idShift=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ $this->idLevel=0;
								     if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' )); 
								            $this->idShift=$default_vacation->id;
								       }
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' )); 
								}
							
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
				</div>
			 
		    <!--section(liee au Shift choisi)-->
			<div class="left" style="margin-left:10px;" >
			<label for="Sections"> <?php 
					echo Yii::t('app','Section'); 
					?></label><?php 
					
					
											$modelSection = new Sections;
							    if(isset($this->section_id))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('options' => array($this->section_id=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { $this->section_id=0; $this->idLevel=0; $this->room_id=0;
									echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->idShift), array('onchange'=> 'submit()' )); 
						           }					      
						  
						echo $form->error($modelSection,'section_name'); 
						
					
											
					   ?>
				</div>
			
			<!--level-->
			<div class="left" style="margin-left:10px;">
			<label for="Levels"> <?php 
					 echo Yii::t('app','Level'); 
					 ?>
				</label>
					 <?php 
					 
					 
						$modelLevelPerson = new LevelHasPerson;
						if(isset($this->idLevel))
							    echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('options' => array($this->idLevel=>array('selected'=>true)),'onchange'=> 'submit()', )); 
							 else
								{ $this->idLevel=0;
								  echo $form->dropDownList($modelLevelPerson,'level',$this->loadLevelByIdShiftSectionId($this->idShift,$this->section_id), array('onchange'=> 'submit()' )); 
					             }
						echo $form->error($modelLevelPerson,'level'); 
						
					 
					  ?>
				</div>
			
			<!--room / title-->
			<div class="left" style="margin-left:10px;">
			     <label for="Titles"> <?php 
					 echo Yii::t('app','Room'); 
					 ?></label><?php 
					
					 
						$modelRoom = new RoomHasPerson;
						    
							  
							  if(isset($this->room_id))
							   {
						          echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()','options' => array($this->room_id=>array('selected'=>true)) )); 
					             }
							   else
							      echo $form->dropDownList($modelRoom,'room',$this->loadRoomByIdShiftSectionLevel($this->idShift,$this->section_id,$this->idLevel), array('onchange'=> 'submit()')); 
						echo $form->error($modelRoom,'room'); 
						
								   
					   ?>
				</div>
			
     </div>
     
     
<?php $this->endWidget();  ?>     
                              </td>
	       
					       
					    </tr>
<?php
   }
   
?>					    
					    <tr>
					       <td colspan="4" style="background-color:#EFF3F8;border: none;">



<div class="search-form" style="">
 
<?php

if(isset($_GET['isstud']))
   {  if($_GET['isstud']==1) 
		{ 
			 Yii::app()->clientScript->registerScript('searchStudents_('.$condition.','.$acad_sess.')', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
					});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('persons-grid', {
	data: $(this).serialize()
	});
					return false;
					});
				");


		
		}
      elseif($_GET['isstud']==0)
         {  
         	if((isset($_GET['from1'])) && ($_GET['from1']=='rpt'))
		      {
		   			  Yii::app()->clientScript->registerScript('searchTeacherSortBy('.$condition.','.$this->idShift.','.$this->section_id.','.$this->idLevel.','.$this->room_id.','.$acad_sess.')', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
					});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('persons-grid', {
	data: $(this).serialize()
	});
					return false;
					});
				");

		        }
		     else
			  {  
			  	  Yii::app()->clientScript->registerScript('searchTeacher('.$condition.','.$acad_sess.')', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
					});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('persons-grid', {
	data: $(this).serialize()
	});
					return false;
					});
				");
			  	 }
			  
			  	 
         }
         
	}   
 else
    {
    	 Yii::app()->clientScript->registerScript('searchEmployee('.$condition.','.$acad_sess.')', "
				$('.search-button').click(function(){
					$('.search-form').toggle();
					return false;
					});
				$('.search-form form').submit(function(){
					$.fn.yiiGridView.update('persons-grid', {
	data: $(this).serialize()
	});
					return false;
					});
				");

    	
     }	  

	   
			
?>



<?php  $content='';
if(isset($_GET['isstud']))
   { if($_GET['isstud']==1) 
		 $content= $model->searchStudents_($condition,$acad_sess)->getData();
     elseif($_GET['isstud']==0)
       {  
       	   if((isset($_GET['from1'])) && ($_GET['from1']=='rpt'))
			{
			   $content=$model->searchTeacherSortBy($condition,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess)->getData();
			  }
			else
			  {  
			  	 $content=$model->searchTeacher($condition,$acad_sess)->getData();
			  	 }
        }
        
	}   
else
    $content=$model->searchEmployee($condition,$acad_sess)->getData();
	  
	 
 
	  $this->renderPartial('_search',array(
'model'=>$model,
)); ?>
</div>




<?php 

?>

<?php $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
 if(isset($_GET['isstud']))
   { if($_GET['isstud']==1) 
		   { 
		   	  //$template=''; 
              		  
		   	  
		  if((Yii::app()->user->profil=='Teacher'))
           {  
           	             	
             	if((isset($_GET['from']))&&($_GET['from']=='stud'))
		   	   { $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")))';
		   	      $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")))';
		   	      
		   	      $value_cod='CHtml::link($data->id_number,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")))';
		   	   }
		   	 else
		   	   { $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from1"=>"rpt")))';
		   	     $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from1"=>"rpt")))';
		   	     
		   	     $value_cod='CHtml::link($data->id_number,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from1"=>"rpt")))';
		   	   }
		   	
		   	 $dataProvider=$model->searchStudentsForTeacher($condition,$id_teacher,$acad_sess);
		   	 //$template='';
		   	 $url_view='';
			 
			
		   			   
             }
		   else  //Yii::app()->user->profil != 'Teacher'
		   	{
                  $dataProvider=$model->searchStudents_($condition,$acad_sess);
				  
				  
		   	 if((isset($_GET['from']))&&($_GET['from']=='stud'))
		   	   { 
                             
                             //$template='{update}{delete}{mail}'; //{view}
                             
		   	      $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pg=lr&isstud=1&from=stud")';
		   	      $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")))';
		   	      $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")))';
		   	      
		   	      $value_cod='CHtml::link($data->id_number,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from"=>"stud")))';
		   	   }
		   	 else
		   	   {//$template='';
		   	     $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pi=no&pg=lr&isstud=1")';
		   	     $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from1"=>"rpt")))';
		   	     $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from1"=>"rpt")))';
		   	     
		   	     $value_cod='CHtml::link($data->id_number,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pg"=>"lr","pi"=>"no","isstud"=>1,"from1"=>"rpt")))';
		   	   }
		   	 
		   	    
		   	    
		   	  }//fen if((Yii::app()->user->profil!='Teacher'))
             
         		   	 
  $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$dataProvider,
			 
			 
			'columns'=>array(
				
                                array(
                                        'name'=>Yii::t('app','Code student'),
                                        'type' => 'raw',
                                        'value'=>$value_cod,
                                        'htmlOptions'=>array('width'=>'100px'),
				),
                                
                                array(
                                'name' => 'first_name',
                                'type' => 'raw',
                                'value'=>$value_f,
                                'htmlOptions'=>array('width'=>'150px'),
                                ),
                                
                                array(
                                'name' => 'last_name',
                                'type' => 'raw',
                                'value'=>$value_l,
                                'htmlOptions'=>array('width'=>'150px'),
                                ),
                                
                                
				array(
                                    'name'=>'gender',
                                    'value'=>'$data->getGenders1()',
                                    'htmlOptions'=>array('width'=>'50px'),
						),
				
				
                                    array(
                                        'header'=>Yii::t('app','Room Name'),
                                        'name'=>'room_name',
                                        'value'=>'$data->getShortRooms($data->id,'.$acad_sess.')',
                                        'htmlOptions'=>array('width'=>'200px'),
						),				
				
				
				
				array('header'=>Yii::t('app','Status'),
                                    'name'=>'status',
                                    'value'=>'$data->status',
                                    'htmlOptions'=>array('width'=>'50px'),
                                    ),
				
				
				
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>$template1,
			   'buttons'=>array (
        
         'update'=> array(
            'label'=>'<span class="fa fa-pencil-square-o"></span>',
             'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("academic/persons/update?id=$data->id&pi=no&pg=lr&isstud=1&from=stud")',
            'options'=>array('title'=>Yii::t('app','Update' )),
        ),
		'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            'url'=>$url_view,
            'options'=>array( 'title'=>Yii::t('app','View') ),
        ),
          'delete'=>array(
              'label'=>'<span class="fa fa-trash-o"></span>',
              'imageUrl'=>false,
              'options'=>array('title'=>Yii::t('app','Delete')),
              
              
          ),
                               
                               
                              
         'mail'=> array(
            'label'=>'<span class="fa fa-envelope"></span>',
             'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("academic/mails/create?stud=$data->id&pi=no&pg=lr&isstud=1&from=stud&afich=lists")',
            'options'=>array('title'=>Yii::t('app','Send email' )),
        ),
                               
        
    ),
				),
			),
		   ));
		   
		 
		 if((Yii::app()->user->profil=='Teacher'))
         { 
		   $content=$model->searchStudentsForTeacher($condition,$id_teacher,$acad_sess)->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
            
           } //fen if((Yii::app()->user->profil=='Teacher'))
        else //fen Yii::app()->user->profil!='Teacher'
          {
		   $content=$model->searchStudents_($condition,$acad_sess)->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
			  	 
			  
            
		   }//fen Yii::app()->user->profil!='Teacher'
             

		 }
        elseif($_GET['isstud']==0)
		 {    
            
		   if((Yii::app()->user->profil=='Teacher'))
             {  
             	if(isset($_GET['from']))
			   	   {  $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pi=no&isstud=0&from=teach")';
			   	      $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>0,"from"=>"teach")))';
			   	      $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>0,"from"=>"teach")))';
			   	   }
			   	 else
			   	   {  $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pi=no&isstud=0")';
			   	     $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>0,"pi"=>"no","from1"=>"rpt")))';
			   	     $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>0,"pi"=>"no","from1"=>"rpt")))';
			   	   }
             	
	             
			   	 //$template='';
			   	 $url_view='';
		   			   
             }
		   else  //Yii::app()->user->profil != 'Teacher'
		   	{               
			   	 if(isset($_GET['from']))
			   	   { //$template='{update}{mail}';
			   	      $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pi=no&isstud=0&from=teach")';
			   	      $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>0,"from"=>"teach")))';
			   	      $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>0,"from"=>"teach")))';
			   	   }
			   	 else
			   	   { //$template='';//'{view}';
			   	     $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pi=no&isstud=0")';
			   	     $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>0,"pi"=>"no","from1"=>"rpt")))';
			   	     $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"isstud"=>0,"pi"=>"no","from1"=>"rpt")))';
			   	   }
			   
			  
			   	   
              }
		  
		  if((isset($_GET['from1'])) && ($_GET['from1']=='rpt'))
		      $dataProvider=$model->searchTeacherSortBy($condition,$this->idShift,$this->section_id,$this->idLevel,$this->room_id,$acad_sess);
		  else
		     $dataProvider=$model->searchTeacher($condition,$acad_sess);
		     
		   	   
            $gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$dataProvider,
			
			'columns'=>array(
				
                                 array(
                                    'name' => 'first_name',
                                    'type' => 'raw',
                                    'value'=>$value_f,
                                    'htmlOptions'=>array('width'=>'150px'),
                                ),
                                array(
                                    
                                    'name' => 'last_name',
                                    'type' => 'raw',
                                    'value'=>$value_l,
                                    'htmlOptions'=>array('width'=>'150px'),
                                    ),
				
				array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						), 
				
				array(
							'name'=>Yii::t('app','Phone'),
							'value'=>'$data->phone',
						),
				
				
 
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>$template1,
			   'buttons'=>array (
        
         'update'=> array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
             'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("academic/persons/update?id=$data->id&isstud=0&from=teach")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
        ),
		'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
             'imageUrl'=>false,       
           
            'url'=>$url_view,
            'options'=>array( 'title'=>Yii::t('app','View') ),
        ),
        'delete'=>array(
              'label'=>'<span class="fa fa-trash-o"></span>',
              'imageUrl'=>false,
              'options'=>array('title'=>Yii::t('app','Delete')),
              
              
          ),
         'mail'=> array(
            'label'=>'<span class="fa fa-envelope"></span>',
             'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("academic/mails/create?stud=$data->id&isstud=0&from=teach&mn=teach&afich=listt")',
            'options'=>array('title'=>Yii::t('app','Send email' )),
        ),
       
    ),
				),
			),
		   ));
            // Export to CSV 
            $content=$dataProvider->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
            
	    }
	  }
	else
	  {  
	  	  
		   	  
		   	 if(isset($_GET['from']))
		   	   { //$template='{update}{delete}{mail}';
		   	      $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pi=no&from=emp")';
		   	      $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"from"=>"emp")))';
		   	      $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"from"=>"emp")))';
		   	   }
		   	 else
		   	   { //$template='';
		   	     $url_view='Yii::app()->createUrl("academic/persons/viewForReport?id=$data->id&pi=no")';
		   	     $value_f='CHtml::link($data->first_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pi"=>"no","from1"=>"rpt")))';
		   	     $value_l='CHtml::link($data->last_name,Yii::app()->createUrl("academic/persons/viewForReport",array("id"=>$data->id,"pi"=>"no","from1"=>"rpt")))';
		   	   }
		   	   

	  	
	  	$gridWidget = $this->widget('zii.widgets.grid.CGridView', array(
			'id'=>'persons-grid',
			'dataProvider'=>$model->searchEmployee($condition,$acad_sess),
			
			'columns'=>array(
				
                                 array(
                                    'name' => 'first_name',
                                    'type' => 'raw',
                                    'value'=>$value_f,
                                   
                                ),
                                array(
                                    
                                    'name' => 'last_name',
                                    'type' => 'raw',
                                    'value'=>$value_l,
                                    
                                    ),
				
				array(
							'name'=>'gender',
							'value'=>'$data->getGenders1()',
						),
				
				array(
							'name'=>Yii::t('app','Phone'),
							'value'=>'$data->phone',
						),
			   array(     
			                    'name'=>Yii::t('app','Title'),
			                    'value'=>'$data->getTitles($data->id,'.$acad_sess.')',
			                ),
			   
				array(
					'class'=>'CButtonColumn',
					'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
                                  'onchange'=>"$.fn.yiiGridView.update('persons-grid',{ data:{pageSize: $(this).val() }})",
                    )),
					'template'=>$template1,
			   'buttons'=>array (
        
         'update'=> array(
            'label'=>'<i class="fa fa-pencil-square-o"></i>',
            'imageUrl'=>false,
            'url'=>'Yii::app()->createUrl("academic/persons/update?id=$data->id&pi=no&from=emp")',
            'options'=>array( 'title'=>Yii::t('app','Update') ),
        ),
		'view'=>array(
            'label'=>'<i class="fa fa-eye"></i>',
            'imageUrl'=>false,
            
            'url'=>$url_view,
            'options'=>array( 'title'=>Yii::t('app','View') ),
        ),
        'delete'=>array(
              'label'=>'<span class="fa fa-trash-o"></span>',
              'imageUrl'=>false,
              'options'=>array('title'=>Yii::t('app','Delete')),
              
              
          ),
        'mail'=> array(
            'label'=>'<span class="fa fa-envelope"></span>',
             'imageUrl'=>false,
            
            'url'=>'Yii::app()->createUrl("academic/mails/create?stud=$data->id&from=emp&mn=teach&afich=liste")',
            'options'=>array('title'=>Yii::t('app','Send email' )),
        ),
        
    ),
				),
			),
		   ));
                // Export to CSV 
            $content=$model->searchEmployee($condition,$acad_sess)->getData();
	        if((isset($content))&&($content!=null)) 
			   $this->renderExportGridButton($gridWidget, '<i class="fa fa-arrow-right"></i>'.Yii::t('app',' CSV'),array('class'=>'btn-info btn'));
  


	  }



?>



                                            </td>
                                      </tr>
                       </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
            


