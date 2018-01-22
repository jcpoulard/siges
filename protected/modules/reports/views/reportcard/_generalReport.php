<?php
/* @var $this SiteController */
$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',));

$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 
 
$acad_name=Yii::app()->session['currentName_academic_year'];
        
   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
   if($current_acad==null)
						          $condition = '';
						     else{
						     	   if($acad!=$current_acad->id)
							         $condition = '';
							      else
							         $condition = 'p.active IN(1,2) AND ';
						        }



       
        
$this->pageTitle=Yii::app()->name;
$baseUrl = Yii::app()->baseUrl;


 $modelRoom1 = new Rooms;
	    $modelRoom2 = new Rooms;
	    $modelRoom3 = new Rooms;
	    
$modelEvaluation1= new EvaluationByYear;



  $id_teacher='';   
           	
           	 $pers=User::model()->getPersonByUserId(Yii::app()->user->userid);
				 $pers=$pers->getData();
				 foreach($pers as $p)
				      $id_teacher=$p->id;
				





 
?>
<?php
/* @var $this SiteController */
// Set the page title at the index (dashboard) with the profil name and the user name of the login user.
$this->pageTitle=Yii::app()->name;
?>
 
 
<div class="b_mail">
</br>
<div class="box box-info">
         <div class="box-body">
                  <div class="table-responsive">
                  
                                         
                          
   <div class="span9" style="width:100%; margin-bottom:10px; border:0px solid blue;" >   
    <div style=" margin-top:-20px; width:50%;  align:center; border:0px solid red;" >
			
		<?php  //default shift
		         $modelShift = new Shifts;
		         
		         
		            if(isset($_GET['shi'])) $this->shift_id_rpt=$_GET['shi'];
				  else{$idShift = Yii::app()->session['Shifts-rpt'];
				  $this->shift_id_rpt=$idShift;}
				  
			      if(isset($_GET['sec'])) $this->section_id_rpt=$_GET['sec'];
				  else{$section = Yii::app()->session['Sections-rpt'];
				      $this->section_id_rpt=$section;}
								       
						$default_vacation=null;
			      $criteria = new CDbCriteria;
				   								$criteria->condition='item_name=:item_name';
				   								$criteria->params=array(':item_name'=>'default_vacation',);
				   		$default_vacation_name = GeneralConfig::model()->find($criteria)->item_value;
				   		
				   		$criteria2 = new CDbCriteria;
				   								$criteria2->condition='shift_name=:item_name';
				   								$criteria2->params=array(':item_name'=>$default_vacation_name,);
				   		$default_vacation = Shifts::model()->find($criteria2);
				   		
				   		

		
		?>
		
		
		<!--section(liee au Shift choisi)-->
			<div class="right" style="margin-left:10px;" >
			    <?php
						$modelSection = new Sections;
						
						echo $form->labelEx($modelSection,Yii::t('app','Section'));
						
							    if(isset($this->section_id_rpt))
							       echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->shift_id_rpt), array('options' => array($this->section_id_rpt=>array('selected'=>true)),'onchange'=> 'submit()')); 
							    else
								  { 
									if(($this->shift_id_rpt==''))
									  { if($default_vacation!=null)
								          $this->shift_id_rpt=$default_vacation->id;
								          
									   }
								          echo $form->dropDownList($modelSection,'section_name',$this->loadSectionByIdShift($this->shift_id_rpt), array('onchange'=> 'submit()' )); 
						           }					      
						  
						echo $form->error($modelSection,'section_name'); 
						
					
											
					   ?>
				</div>
			

         
	<!--Shift(vacation)-->
        <div class="right" style="margin-left:10px;">
		
			<?php 
			     	
			     echo $form->labelEx($modelShift,Yii::t('app','Shift'));					
						  if(isset($this->shift_id_rpt)&&($this->shift_id_rpt!=''))
						        {  
					               echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array($this->shift_id_rpt=>array('selected'=>true)),'onchange'=> 'submit()' )); 
					             }
							  else
								{ 
								    if($default_vacation!=null)
								       { echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('options' => array(($default_vacation->id)=>array('selected'=>true)),'onchange'=> 'submit()' ));
								              $this->shift_id_rpt=$default_vacation->id;
								       } 
								    else
								       echo $form->dropDownList($modelShift,'shift_name',$this->loadShift(), array('onchange'=> 'submit()' )); 
								}
							
						echo $form->error($modelShift,'shift_name'); 
						
					
					  ?>
				</div>
         
          
         
          </div>
          
          
          
          
		
	</div>               
                         
   <div style="clear:both;"></div>       
    
                    <table class="table no-margin">
                      
                      <tbody>
                      
                        <tr>
                          <td colspan="4">
                             
<!-- //########################################  MOYENNE CLASSE - MOYENNE FILLE - MOYENNE GARCON  ############################################### -->


<div class="span10" style="width:80%; ">

      <div class="" style="width:100%; ">
	
	<div class="" style="float:left; width:100%; ">
<h2 id="grph1"></h2>
	<h5>	<?php	
	if($this->class_average==1)
		{ echo $form->checkBox($model,'class_average',array('onchange'=> 'submit()','checked'=>'checked'));
		    
		  }
    elseif($this->class_average==0)
       echo $form->checkBox($model,'class_average',array('onchange'=> 'submit()'));
        
        
      
      
  ?>
    <?php echo Yii::t('app','Grade Average by Class and Gender'); ?>
		    
	</h5> </div> 

         
 <?php 
    if($this->class_average==1)
	  {
				  if(isset($_GET['ev'])) $this->eval_id_class_average=$_GET['ev'];
				  else{$eval = Yii::app()->session['EvaluationByYear-class-average'];
				  $this->eval_id_class_average=$eval;}
				  
				
    ?>
    
         
         <!--evaluation   (inutilise)LOAD EVALUATIONS IN WHICH REPORTCARDS ARE ALREADY DONE loadEvaluationReportcardDone()  --> 
                  
			<div class="left" style="margin-left:10px;">
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php 			           

					         $modelEvaluation= new EvaluationByYear();
							    if(isset($this->eval_id_class_average)&&($this->eval_id_class_average!=''))
							       echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()', 'options' => array($this->eval_id_class_average=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation,'evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation,'evaluation');  
						  						
					   ?>
				</div>
			
						
  
  <?php 
  
	  }
    
    ?>
      
     </div>
</div>

<div style="clear:both"></div>

             
<?php 
    if($this->class_average==1)
	  {
        
        
            $label_class_name='';
            $data_class_average='';
            $data_female_average='';
            $data_male_average='';
 
 
  //get all levels in the specify shift
  
        $level=$this->getLevelByIdShiftSection($this->shift_id_rpt,$this->section_id_rpt,$acad_sess);
        
       if(isset( $level)&&( $level!=''))
        {
        	$pass=0;
        	$pass1=0;
        	
        	foreach($level as$l)
        	  {  
        	  	  
        	  	  $level_name=$this->getLevelShortName($l->level);
        	  	  
        	  	  if($pass==0)
        	  	    { $pass=1;  $label_class_name=$level_name;   }
        	  	  else
        	  	    $label_class_name=$label_class_name.','.$level_name;    
        	  	    
        	  	 //return an array which content is: class_average, female_average, male_average, tot_female, tot_male
        	  	 $data=$this->getClassAverageForReport($l->level,$this->eval_id_class_average, $acad_sess); 
        	  	 
        	  	  if($pass1==0)
        	  	    { $pass1=1;  $data_class_average=$data["class_average"];   
        	  	       $data_female_average=$data["female_average"];
        	  	       $data_male_average=$data["male_average"];
        	  	    }
        	  	 else
        	  	   { $data_class_average=$data_class_average.','.$data["class_average"]; 
        	  	         $data_female_average=$data_female_average.','.$data["female_average"];
        	  	          $data_male_average=$data_male_average.','.$data["male_average"];
        	  	    } 
        	  	
        	  	}
        	  	
        	}
          else
            {
            	 $label_class_name=Yii::t('app','N/A');
                $data_class_average=0;
            
            	}         
 
 // To find period name in in evaluation by year 
       $period_exam_name='';
                                                                
     $result=EvaluationByYear::model()->searchPeriodName($this->eval_id_class_average);
	 if(isset($result))
	   {  $result=$result->getData();//return a list of  objects
		  foreach($result as $r)
			{
				$period_exam_name= $r->name_period;
				$period_acad_id = $r->id;
			}
		}
 // end  
    $shift=$this->getShift($this->shift_id_rpt);
 
    echo '<input type="hidden" id="label_class_name" value="'.$label_class_name.'" />';
     echo '<input type="hidden" id="data_class_average" value="'.$data_class_average.'" />';
      echo '<input type="hidden" id="data_female_average" value="'.$data_female_average.'" />';
       echo '<input type="hidden" id="data_male_average" value="'.$data_male_average.'" />';
       
        
        echo '<input type="hidden" id="title_chart" value="'.Yii::t("app","Average").' '.$period_exam_name.'" />';
        echo '<input type="hidden" id="vertical_left_title" value="'.Yii::t("app","Shift").': '.$shift.'" />';
        echo '<input type="hidden" id="label1_legend" value="'.Yii::t("app","Girl").'" />';
        echo '<input type="hidden" id="label2_legend" value="'.Yii::t("app","Class").'" />';
        echo '<input type="hidden" id="label3_legend" value="'.Yii::t("app","Boy").'" />';
        
 
?>
<div class="">

     <div id="container" name="container" style="height:370px;" > </div>
<script>
    $(function () {
  
  var title_chart=document.getElementById("title_chart").value;
  var vertical_left_title='';
  var label1_legend=document.getElementById("label1_legend").value;
  var label2_legend=document.getElementById("label2_legend").value;
  var label3_legend=document.getElementById("label3_legend").value;
  
  
  
  var label_class_name=document.getElementById("label_class_name").value;
  var data_class_average=document.getElementById("data_class_average").value;
  
  var data_female_average=document.getElementById("data_female_average").value;
  var data_male_average=document.getElementById("data_male_average").value;
  
   var tab_label = label_class_name.split(",");
   var tab_data = data_class_average.split(",");
   
   var tab_data_female = data_female_average.split(",");
   
   var tab_data_male = data_male_average.split(",");
   
   var tab_female=[];
   var tab_male=[];
   var tab_class=[];
   var i;
   
   //table value for male
   for(i=0;i<tab_data_male.length; i++)
    {
    	tab_male.push(parseFloat(tab_data_male[i]));
    	}
   //table value for female
   for(i=0;i<tab_data_female.length; i++)
    {
    	tab_female.push(parseFloat(tab_data_female[i]));
    	}

  //table value for class
   for(i=0;i<tab_data.length; i++)
    {
    	tab_class.push(parseFloat(tab_data[i]));
    	}
   
   
  
   
    $('#container').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: title_chart //titre principal
        },
       xAxis: {
            categories: tab_label //label de l'axe des X
        },
        
       yAxis: {
            //min: 0,
            title: {
                text: ''  //titre vertical gauche
            },
        },
        
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            formatter: function () {
                return '<b>' + this.x + '</b><br/>' +
                    this.series.name + ': ' + this.y + '<br/>' ;//+
                        //somme des piles
            }
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white',
                    style: {
                        textShadow: '0 0 0px black'
                    }
                }
            }
        },
        series: [{
            name: label1_legend,  //label1 du legend
            data: tab_female     //les donnees du label1
        }, {
            name: label2_legend,  //label2 du legend
            data: tab_class  //les donnees du label2
        }, {
            name: label3_legend,    //label3 du legend
            data: tab_male   //les donnees du label3
        }]
    });
});

     
 </script>   



   </div>

<?php   

	  }//end of if($this->class_average==1)
		

?>

    
<!--//####################  FIN  ###################  -->

<div style="clear:both"></div>

                          </td>
                        </tr> 
       
        <!-- //si c yon prof, pa afiche liy sa  -->  
<?php       
 
if((Yii::app()->user->profil!='Teacher'))
   {	    
 
 ?>                        
                        <tr> 
                          <td colspan="4">
                  
<!--//########################################   PROGRESSION D'1 ELEVE PAR RAPPORT A LA CLASSE   ###############################################  -->

<div class="row-fluid" style=" border:0px solid pink;">

 <div class="row-fluid" style=" border:0px solid green;  ">
<div class="chart_g">	
	<div class="" style="margin-left:-9px;width:100%; border:0px solid blue;">
	<!-- Creating a heading with an anchorID -->
<h2 id="grph2"></h2>
<h5>	<?php	
	if($this->progress_student_class==1)
		{ echo $form->checkBox($model,'progress_student_class',array('onchange'=> 'submit()','checked'=>'checked'));
		    
		  }
    elseif($this->progress_student_class==0)
       echo $form->checkBox($model,'progress_student_class',array('onchange'=> 'submit()'));
        
         
      if((isset($_GET['stud1'])&&($_GET['stud1']!=''))&&(isset($_GET['roo1'])&&($_GET['roo1']!='')))
  	    {
  	      Yii::app()->session['stud_id1']=$_GET['stud1'];
  	       if(Yii::app()->session['Rooms-rpt_student_class']!=$_GET['roo1'])
  	         { $this->room_id_student_class= Yii::app()->session['Rooms-rpt_student_class'];
  	             Yii::app()->session['stud_id1']=0;
  	           }
  	         else
  	          {
  	          	$this->room_id_student_class= $_GET['roo1'];
  	             
  	          	}
  	    }
      else
      {
      	   $this->room_id_student_class= Yii::app()->session['Rooms-rpt_student_class'];
      	}
     	
      	
  ?>
    <?php echo Yii::t('app','Progression d\'un élève par rapport à la classe'); ?>
		    
	</h5> </div> 

         
 <?php 
    if($this->progress_student_class==1)
	  {
        
     		
    ?>
 <div style="clear:both;"></div>   
  <div class="span2" style="width:auto;  border:0px solid blue;">       
 	
 	   <!--room-->
			<div class="left" style="margin-left:0px; margin-bottom:7px;">
                           
			<?php  
			                     echo $form->labelEx($modelRoom1,'[1]'.Yii::t('app','Room')); ?>
			          <?php 
					
					      
							  
							  if(isset($this->room_id_student_class))
							   { 
						          echo $form->dropDownList($modelRoom1,'[1]room_name',$this->loadRoomByIdSection($this->section_id_rpt), array('onchange'=> 'submit()','options' => array($this->room_id_student_class=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom1,'[1]room_name',$this->loadRoomByIdSection($this->section_id_rpt), array('onchange'=> 'submit()')); 
							          
									 $this->room_id_student_class=0;
							      }
						echo $form->error($modelRoom1,'[1]room_name'); 
						
										
					   ?>
			</div> <!--room-->
      </div> <!-- span2-->	   
	</div> <!-- class="row-fluid"--> 
			
  <?php
	 
	 
	  }
    
    ?>          



             
<?php 
   
 if($this->progress_student_class==1)
   {
        
          
    $stud_id1='';
                $display1=false;
    
       
 if((isset($_GET['stud1'])&&($_GET['stud1']!=''))&&($this->room_id_student_class!=''))
  {

	if((isset($_GET['roo1'])&&($_GET['roo1']!=''))&&($this->room_id_student_class==$_GET['roo1']))
	{
	     $display1=true;
	     $stud_id1 = $_GET['stud1'];
	     Yii::app()->session['stud_id1'] = $_GET['stud1'];
	  }
	
  
  }
else
  {
  	  $stud_id1 = Yii::app()->session['stud_id1'];
  	  
      $idRoom1= $this->getRoomByStudentId($stud_id1);
		  	  
		if(isset($idRoom1)&&($idRoom1!=''))
        {   
	         if($idRoom1->id==$this->room_id_student_class)
	  	       $display1=true;
          }

  	
  	}
         

  
   
   
   $old_p='';
   $label_period1='';
   $data_average_class='';
   $data_average_student=''; 
   
            
            
            $data_sps='';
            $data_grade='';

if($display1)
  {
  	  		  
	  $stud_name1=$this->getStudent($stud_id1);
	  
  echo '<input type="hidden" id="stud_id1" value="'.$stud_id1.'" />';
  
   
 //PERIOD
    $period_id=array();
     $modelEvaluation= new EvaluationByYear();
 
 
         	$pass=0; 
	        $go=0;
	        $pass1=0;
        	$compt1=0;
        	$data_average_class='';
	        $data_average_student='';

          
           $result= $modelEvaluation->searchIdName($acad_sess);
	     if(isset($result))
	      {  $p=$result->getData();//return a list of  objects
           
          foreach($p as $period) 
	         { 	
	            	            
	            
				       if($pass1==0)
	         	 		   { $pass1=1; $label_period1= $period->name_period; }
	         			 else
	         	  		    $label_period1= $label_period1.','.$period->name_period;
	         	      
	         	    
	         	  		  
	       	
			    	//average class
			    	   
			    	    $level_id=$this->getLevelByStudentId($stud_id1)->id;
			    	   //return an array which content is: class_average, female_average, male_average, tot_female, tot_male
        	  	       $data=$this->getClassAverageForReport($level_id,$period->id, $acad_sess); 
        	  	 
        	  	  	   if($go==0)
				         { $go=1; $data_average_class=$data["class_average"];}
					   else 
				         $data_average_class=$data_average_class.','.$data["class_average"];
						
	         	                          	     
					 //average student 
					     //return a number
					     $average = $this->getAverageForAStudent($stud_id1, $this->room_id_student_class, $period->id, $acad_sess);
											      
				              
                             	
								  	if($pass==0)
					        	  	    { 
					        	  	    	$pass=1;  
					        	  	      
					        	  	         $data_average_student= $average;
					        	  	    }
					        	  	  else
					        	  	   {  
					        	  	      
					        	  	         $data_average_student= $data_average_student.','.$average;
					        	  	   }
		        
	                $compt1++;
	          }
	          
	          echo '<input type="hidden" id="compt" value="'.$compt1.'" />';
	          
			  echo '<input type="hidden" id="label_period1" value="'.$label_period1.'" />';
			  echo '<input type="hidden" id="data_average_student" value="'.$data_average_student.'" />';
	          echo '<input type="hidden" id="data_average_class" value="'.$data_average_class.'" />';
	          
	          echo '<input type="hidden" id="_name1" value="'.Yii::t("app","Student Average").'" />';
	          echo '<input type="hidden" id="_name2" value="'.Yii::t("app","Class Average").'" />';
	          
	          
	       }
	          
		
          
        	 
			 
  }
else
   {  
     $stud_name1='';
     $compt1=1;
     echo '<input type="hidden" id="compt" value="'.$compt1.'" />';
     
       echo '<input type="hidden" id="label_period1" value=" " />';
       echo '<input type="hidden" id="data_average_student" value=" " />';
	   echo '<input type="hidden" id="data_average_class" value=" " />';
	   
	    echo '<input type="hidden" id="_name1" value="'.Yii::t("app","Student Average").'" />';
	    echo '<input type="hidden" id="_name2" value="'.Yii::t("app","Class Average").'" />';
	     
	   
	  	
   	}
  
   
   
   
   
   
   
     
?>


<div class="row-fluid" style=" width:auto; border:0px solid yellow;">
    <div class="login span2" style="float:left;  height:410px; overflow:auto; border:0px solid red; margin-right:0px;">
         
        
  <?php 
          
          $dataProvider_psp= Persons::model()->getStudentsByRoomForReport($condition,$this->room_id_student_class,$acad_sess);
		  $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
            
          $url=$explode_url[0].'/'.$explode_url[1].'/'.$explode_url[2];		   	 
		   
		   $dataProvider_psp=$dataProvider_psp->getData();
		     
		   foreach($dataProvider_psp as $pers)
		    {
		    	echo CHtml::link("<p>$pers->first_name $pers->last_name</p>",array("/reports/reportcard/generalReport/from1/rpt/stud1/$pers->id/roo1/$this->room_id_student_class#grph2"  ));
		    	
		    	
		    	}
		
		  
  ?>
    </div>  <!--span2-->
<div class="span9" style="width:1%; border:0px solid blue;" >   
    <div style="float:left; margin-top:-20px; width:100%; text-align:center; border:0px solid red;" >
		<span class="fa fa-2y " style="font-size:14px; color:#F06530; font-weight:bold; "><?php echo $stud_name1; ?></span> </div>
		
	</div>
   
<div class="row-fluid" >    
  
            
 
 		<div class="span10 left" id="container1" name="container1"  style="height:410px;  border:0px solid blue;"> 
 		 </div>  <!--span8-->
    
   </div> 
			<script>
			
			var name=0;
			
			   function changeGraph() {
			   
			   }
			 
			 $(function () {
			  
			 
			  
			  var i;
			   var j;
			
			  var _container;
			   name = parseInt(name)+1;
			  
			  var data_average_student = document.getElementById("data_average_student").value;
			  var data_average_class = document.getElementById("data_average_class").value;
			  var label_period = document.getElementById("label_period1").value;
			  var _name1 = document.getElementById("_name1").value;
			  var _name2 = document.getElementById("_name2").value;
			  
			  var tab_label_period=[];
			  var tab_classAverage=[]; 
			  var tab_studentAverage=[];
			 
			  			   
			  var _series=[];
			  var _data1=[];
			  var _data2=[];
			
			  
			     tab_label_period = label_period.split(",");
			     tab_studentAverage = data_average_student.split(",");
			     tab_classAverage = data_average_class.split(",");
			    
			    for(j=0;j<tab_studentAverage.length; j++)
			     {
			     	_data1.push(parseFloat(tab_studentAverage[j]));
			    	
			       }
			       
			    for(j=0;j<tab_classAverage.length; j++)
			     {
			     	_data2.push(parseFloat(tab_classAverage[j]));
			    	
			       }
			       
			    
			     
			    
			  
			   for(i=1;i<=2;i++)        
			     {  
			     	if(i==1)
			          _series.push({name:_name1,data:_data1});
			        else
			          _series.push({name:_name2,data:_data2});
			     
			      }
			   
			   			 
			    $('#container1').highcharts({
			        chart: {
			            type: 'line'
			        },
			        title: {
			            text: ''
			        },
			        subtitle: {
			            text: ''
			        },
			        xAxis: {
			            categories: tab_label_period //['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] //
			        },
			        yAxis: {
			            min: 0, 
			            
			            title: {
			                text: ''
			            }
			        },
			        plotOptions: {
			            line: {
			                dataLabels: {
			                    enabled: true
			                },
			                enableMouseTracking: true
			            }
			        },
			        series: _series
			        
			             
				    });
				  
				
				});
				
				  
				  
				 </script>   
				
				
		 
		 
         


 </div> <!-- end class="row-fluid" -->
   
  
<?php   

	  }//end of if($this->progress_student_class==1)
		

?>

</div> <!-- end class="row-fluid" -->


    
<!--//####################  FIN  ###################  -->

<div style="clear:both"></div>



                          </td>
                        </tr>
              
              
        <!-- //si c yon prof, pa afiche liy sa  -->   
<?php       
      }
      
if((Yii::app()->user->profil!='Teacher'))
   {	    
 
 ?>                        
                            
                        <tr>  
                          <td colspan="4">
                          
<!--//########################################   PROGRESSION D'1 ELEVE PAR MATIERE A CHAQUE ETAPE   ###############################################  -->

<div class="row-fluid" style=" border:0px solid pink;">

 <div class="row-fluid" style=" border:0px solid green;  ">
	
	<div class="" style="margin-left:-9px;width:100%; border:0px solid blue;">
<h2 id="grph3"></h2>
	<h5>	<?php	
	if($this->progress_subject_period==1)
		{ echo $form->checkBox($model,'progress_subject_period',array('onchange'=> 'submit()','checked'=>'checked'));
		   
		  }
    elseif($this->progress_subject_period==0)
       echo $form->checkBox($model,'progress_subject_period',array('onchange'=> 'submit()'));
        
        
    $stud_name=''; 
      if((isset($_GET['stud2'])&&($_GET['stud2']!=''))&&(isset($_GET['roo2'])&&($_GET['roo2']!='')))
  	    {
  	      Yii::app()->session['stud_id2']=$_GET['stud2'];
  	       if(Yii::app()->session['Rooms-rpt_subject_period']!=$_GET['roo2'])
  	         { $this->room_id_subject_period= Yii::app()->session['Rooms-rpt_subject_period'];
  	             Yii::app()->session['stud_id2']=0;
  	           }
  	         else
  	          {
  	          	$this->room_id_subject_period= $_GET['roo2'];
  	             
  	          	}
  	    }
      else
      {
      	   $this->room_id_subject_period= Yii::app()->session['Rooms-rpt_subject_period'];
      	}  
      
  ?>
    <?php echo Yii::t('app','Progression d\'un élève par matière'); ?>
		    
	</h5> </div> 

         
 <?php 
    if($this->progress_subject_period==1)
	  {
        
     		
    ?>
 <div style="clear:both;"></div>   
  <div class="span2" style="width:auto;  border:0px solid blue;">       
 	
 	   <!--room-->
			<div class="left" style="margin-left:0px; margin-bottom:7px;">
                           
			<?php  
			                     echo $form->labelEx($modelRoom2,'[2]'.Yii::t('app','Room')); ?>
			          <?php 
					
					      
							  
							  if(isset($this->room_id_subject_period))
							   { 
						          echo $form->dropDownList($modelRoom2,'[2]room_name',$this->loadRoomByIdSection($this->section_id_rpt), array('onchange'=> 'submit()','options' => array($this->room_id_subject_period=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom2,'[2]room_name',$this->loadRoomByIdSection($this->section_id_rpt), array('onchange'=> 'submit()')); 
							          
									 $this->room_id_subject_period=0;
							      }
						echo $form->error($modelRoom2,'[2]room_name'); 
						
										
					   ?>
			</div> <!--room-->
      </div> <!-- span2-->	   
	</div> <!-- class="row-fluid"--> 
			
  <?php
	 
	 
	  }
    
    ?>          



             
<?php 
    if($this->progress_subject_period==1)
	  {
        
   $compt2=0;
   $stud_id2='';
   $old_p2='';
   $label_period2='';
   $label_subject_name='';
   $each_subject_grade=''; 
   
            
            
            $data_sps='';
            $data_grade='';
            $display2=false;
    
       
 if((isset($_GET['stud2'])&&($_GET['stud2']!=''))&&($this->room_id_subject_period!=''))
  {

	if((isset($_GET['roo2'])&&($_GET['roo2']!=''))&&($this->room_id_subject_period==$_GET['roo2']))
	{
	     $display2=true;
	     $stud_id2 = $_GET['stud2'];
	     Yii::app()->session['stud_id2'] = $_GET['stud2'];
	  }
	
  
  }
else
  {
  	  $stud_id2 = Yii::app()->session['stud_id2'];
  	  
      $idRoom= $this->getRoomByStudentId($stud_id2);
		  	  
		if(isset($idRoom)&&($idRoom!=''))
        {   
	         if($idRoom->id==$this->room_id_subject_period)
	  	       $display2=true;
          }

  	
  	}
         


if($display2)
{  	     
  	 
    		  
	  $stud_name2=$this->getStudent($stud_id2);
	  
  echo '<input type="hidden" id="stud_id2" value="'.$stud_id2.'" />';
  
   
 //PERIOD
    $period_id=array();
     $modelEvaluation= new EvaluationByYear();

      
 
 
  //get all subjects in the specify room

      $Courses=$this->getCoursesByRoomForGraph($this->room_id_subject_period,$acad_sess);
        
                
	   if(isset($Courses))
	    {  $Courses=$Courses->getData();//return a list of Course objects
	    	$pass=0;
        	$pass1=0;
        	$compt=0;
          
           $result= $modelEvaluation->searchIdName($acad_sess);
	     if(isset($result))
	      {  $p=$result->getData();//return a list of  objects
           
          foreach($p as $period) 
	         { 	
	              $aller=0; 
	              $pass=0; 
	              $go=0;
	          	
	        	$label_subject_name='';
	            $each_subject_grade='';
	            
	            if($old_p2!=$period->name_period)
				  { $old_p2 =$period->name_period; 
		             
	         	                          
	         	       $label_period2= $period->name_period;

				  }
	         	  		  
	       	
			    foreach($Courses as $Course)
			      {			   
					   $weight='';
					   $weight_data =Courses::model()->getWeight($Course->id)->getData();
					   
					   foreach($weight_data as $w)
					     $weight = $w->weight;
					   
					   if($go==0)
				         { $go=1; $label_subject_name=$Course->subject_name;}
					   else 
				         $label_subject_name=$label_subject_name.','.$Course->subject_name;
						
	         	                          	     
					   
					   $grade=Grades::model()->getGradeByStudentIdForGraph($stud_id2,$Course->id, $period->id, $acad_sess);
				             
				         if(isset($grade)&&($grade!=null))
				           { 
				              $grade___=$grade->getData();//return a list of  objects
                               
                             if(($grade___!=null))
				              {
           						foreach($grade___ as $g) 
								  {	
								  	if($pass==0)
					        	  	    { 
					        	  	    	$pass=1;  



					        	  	       
					        	  	       if($g->grade_value=='')
					        	  	         $each_subject_grade= 0;
					        	  	       else
					        	  	         $each_subject_grade= round( ($g->grade_value / $weight)*100, 2);
					        	  	    }
					        	  	  else
					        	  	   {  
					        	  	      if($g->grade_value=='')
					        	  	          $each_subject_grade =$each_subject_grade.',0';
					        	  	      else
					        	  	         $each_subject_grade =$each_subject_grade.','.(round( ($g->grade_value / $weight)*100, 2));
					        	  	   }
		                                      
		                                                                           
    
								     
								    }
								    
				                }
				               else //course has no grade recorded 
			                    {
			                    	 if($pass==0)
					        	  	    { $pass=1;  
					        	  	       	
					        	  	       	$each_subject_grade= '0';
					        	  	      
					        	  	    }
					        	  	  else
					        	  	   { 
					        	  	   	  $each_subject_grade =$each_subject_grade.',0';
					        	  	      
					        	  	   }
		                                     
			                   } 
				                
				                
		                
			                    }
			                  else //course has no grade recorded 
			                    {
			                    	 if($pass==0)
					        	  	    { $pass=1;  
					        	  	       	
					        	  	       	$each_subject_grade= 0;
					        	  	      
					        	  	    }
					        	  	  else
					        	  	   { 
					        	  	   	  $each_subject_grade =$each_subject_grade.',0';
					        	  	      
					        	  	   }
		                                     
			                   }
		                
		                
					 
	       
				   }
				    
				    
				  if($aller==0)
				   { $aller=1; $data_grade=$each_subject_grade;}
				  else 
				   $data_grade=$data_grade.','.$each_subject_grade;
				  
				    
				    echo '<input type="hidden" id="label_period2'.$compt2.'" value="'.$label_period2.'" />';
     				echo '<input type="hidden" id="data_grade'.$compt2.'" value="'.$data_grade.'" />'; 
				   
				   $data_grade='';
				   $aller=0;				   
	            
	            
	                 echo '<input type="hidden" id="label_subject_name'.$compt2.'" value="'.$label_subject_name.'" />';
	                 
	              $compt2++;
	            }
		          
		          echo '<input type="hidden" id="compt2" value="'.$compt2.'" />';
		       }
		          
			 }
		 else
	       {
	           $label_subject_name=Yii::t('app','N/A');
	         }	 
			 
	  }
	else
	   {  
	     $stud_name2='';
	     $compt2=1;
	     echo '<input type="hidden" id="compt2" value="'.$compt2.'" />';
	     
	       echo '<input type="hidden" id="label_period2" value=" " />';
	       echo '<input type="hidden" id="data_grade" value=" " />'; 
		   echo '<input type="hidden" id="label_subject_name" value=" " />';
		     
		   
		  	
	   	}
  

   
  
   
   
   
     
?>


<div class="row-fluid" style=" width:auto; border:0px solid yellow;">
    <div class="login span2" style="float:left;  height:410px; overflow:auto; border:0px solid red; margin-right:0px;">
         
        
  <?php 
          
          $dataProvider_psp1= Persons::model()->getStudentsByRoomForReport($condition,$this->room_id_subject_period,$acad_sess);
		  $explode_url1= explode("/",substr($_SERVER['REQUEST_URI'],1));
            
          $url1=$explode_url1[0].'/'.$explode_url1[1].'/'.$explode_url1[2];		   	 
		   
		   $dataProvider_psp1=$dataProvider_psp1->getData();
		     
		   foreach($dataProvider_psp1 as $pers)
		    {
		    	echo CHtml::link("<p>$pers->first_name $pers->last_name</p>",array("/reports/reportcard/generalReport/from1/rpt/stud2/$pers->id/roo2/$this->room_id_subject_period"  ));
		    			    	
		    	}
		
		  
  ?>
    </div>  <!--span2-->
<div class="span9" style="width:1%; border:0px solid blue;" >   
    <div style="float:left; margin-top:-20px; width:100%; text-align:center; border:0px solid red;" >
		<span class="fa fa-2y " style="font-size:14px; color:#F06530; font-weight:bold; "><?php echo $stud_name2; ?></span> </div>
		
	</div>
   
<div class="row-fluid" >    
 
            
 
 		<div class="span10 left" id="container2" name="container2"  style="height:410px;  border:0x solid blue;"> 
 		 </div>  <!--span8-->
    
   </div> 
			<script>
			
			var name=0;
			
			   function changeGraph() {
			   
			   }
			 
			 $(function () {
			  
			 
			  
			  var i;
			   var j;
			
			  var _container;
			   name = parseInt(name)+1;
			  _container = "c"+name;
			 
			  var compt = parseInt(document.getElementById("compt2").value);
			  
			  var label_subject;
			  var label_period;
			  var data_grade;
			  var tab_grade=[]; 
			  var tab_label_subject=[];
			 
			  var _name;
			  var _label_subject=[];
			   
			    var _series=[];
			
			  for(etape=0; etape<compt; etape++)
			   { 
			  	 var _data=[];
			  	  var _name;
			  
			  	 label_period = document.getElementById("label_period2"+etape).value;
			     data_grade = document.getElementById("data_grade"+etape).value;
			     label_subject = document.getElementById("label_subject_name"+etape).value;
			    
			    
			     tab_label_subject = label_subject.split(",");
			     tab_grade = data_grade.split(",");
			     
			    for(j=0;j<tab_label_subject.length; j++)
			     {
			     	_label_subject.push(tab_label_subject[j]);
			    	
			       }
			    for(j=0;j<tab_grade.length; j++)
			     {
			     	_data.push(parseFloat(tab_grade[j]));
			    	
			       }	
			  	
			  	_name = label_period;
				           
			   _series.push({name:_name,data:_data});
			   
			     }
			 
			    $('#container2').highcharts({
			        chart: {
			            type: 'line'
			        },
			        title: {
			            text: ''
			        },
			        subtitle: {
			            text: ''
			        },
			        xAxis: {
			            categories: _label_subject //['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'] //
			        },
			        yAxis: {
			                        
			        	min: 0,         
			        	
			        	title: {
			                text: ''
			            }
			        },
			        plotOptions: {
			            line: {
			                dataLabels: {
			                    enabled: true
			                },
			                enableMouseTracking: true
			            }
			        },
			        series: _series
			        
			              
				    });
				  
				
				});
				
				  
				  
				 </script>   
				
				<?php  //}  ?>
		 
		 
         


 </div> <!-- end class="row-fluid" -->
   
  
<?php   

	  }//end of if($this->progress_subject_period==1)
		

?>

</div> <!-- end class="row-fluid" -->


    
<!--//####################  FIN  ###################  -->

<div style="clear:both"></div>

                          
                          </td>
                        </tr> 
                  
<?php       
 
      }
      //FEN if((Yii::app()->user->profil!='Teacher'))   
   	    
 
 ?> <!-- //FEN si c yon prof, pa afiche liy sa  -->
          
                        
                         <tr>  
                          <td colspan="4">
                          
                  
<!--//########################################   REPARTITION DES NOTES POUR UNE MATIERE AVEC LIGNE DE REGRASSION   ###############################################  -->

<div class="row-fluid" style=" border:0px solid pink;">

 <div class="row-fluid" style=" border:0px solid green;  ">
	
	<div class="" style="margin-left:-9px;width:100%; border:0px solid blue;">
<h2 id="grph4"></h2>
	<h5>	<?php	
	if($this->repartition_grade_subject==1)
		{ echo $form->checkBox($model,'repartition_grade_subject',array('onchange'=> 'submit()','checked'=>'checked'));
		    
		  }
    elseif($this->repartition_grade_subject==0)
       echo $form->checkBox($model,'repartition_grade_subject',array('onchange'=> 'submit()'));
        
        
    $stud_name='';  
      
  ?>
    <?php echo Yii::t('app','Repartition des notes pour une matière'); ?>
		    
	</h5> </div> 

 <div style="clear:both"></div>        
             
<?php
 if($this->repartition_grade_subject==1)
  { 


    if(($this->course_id_grade_subject!='')&&($this->eval_id_grade_subject!=''))
	  {
		        
		   $line_name=Yii::t('app','Regression Line');
		   $observation_name=Yii::t('app','Observations');
		   $vertical_left_text=Yii::t('app','Grades');
		   
		   $label_class_average=Yii::t('app','Class Average');
		   $label_ecart_type=Yii::t('app','Ecart-type');
		   $label_max=Yii::t('app','Max');
		   $label_min=Yii::t('app','Min');
		   $label_total_stud=Yii::t('app','Number of students: ');
		   $label_total_success=Yii::t('app',' Total Success');
		   $label_male_success=Yii::t('app',' Success(M)');
		   $label_female_success=Yii::t('app',' Success(F)');
		   
		   $class_average_value=0; 
	$ecart_type_value=0;
	
	$total_success_value=0;
	$male_success_value=0;
	$female_success_value=0;	    	
	$passing_grade=0;	
					    
		   
		   $data_observation=''; 
		   $tot_stud=0;
	   	   $pass=0;
	   	   $grade_array = array();
	   	   $max = 0;
	   	   $min = 0;
	   	   $variance=0;
	   	   $i=0;
	   	   
	   	        
	             //return level ID,shift ID,section ID
	              $info = $this->getInfoRoom($this->room_id_grade_subject);
	             
	   	          
				//calculer grade puis afficher
							                            $debase_passingGrade=0;
							                            $debase='';
							                             $weight='';
							                            
							                            
							                            $resultDebase=Courses::model()->ifCourseDeBase($this->course_id_grade_subject);
							                            if($resultDebase!=null)
							                             {
							                             	foreach($resultDebase as $base)
							                             	 { $weight=$base["weight"];
							                             	   $debase=$base["debase"];
							                             	  }
							                             	  
							                               }
							                            
							                            if($debase==1)
							                              {
							                                 $pass_gra=PassingGrades::model()->getCoursePassingGrade($this->course_id_grade_subject, $acad_sess);
							                              	  if($pass_gra!=null)
							                              	    $debase_passingGrade=$pass_gra;
							                              	    
							                              	    $passing_grade=$debase_passingGrade;
							                              	
							                              	}
							                             else
							                               {   
							                               	  $passing_grade = $weight/2;
							                               	  
							                                 }
							                              	
			       	
							       	
			   $grade=Grades::model()->searchByRoom($this->course_id_grade_subject, $this->eval_id_grade_subject);
						             
				if(isset($grade)&&($grade!=null))
				 { 
				    $grade___=$grade->getData();//return a list of  objects
		                               
		               if(($grade___!=null))
						{ 
							
							
		           		  foreach($grade___ as $g) 
							{	
																
								if( $g->grade_value >= $passing_grade)//( ($passing_grade * $g->weight) /100 ) )
								  {  
								  	  $total_success_value++;
										
										if($g->gender==0)
										   $male_success_value++;
										else
								           $female_success_value++;
								       
								   }
								       
								 
								
								if($pass==0)
							       { 
							          $pass=1;  
							        	  	       
							        	if($g->grade_value=='')
							        	  {  $data_observation= 0;
							        	     //initial.. $max and $min
							        	     $max = 0;
							        	     $min = 0;
                                             
                                              $grade_array[$i] = 0;
							        	   }
							            else
							        	  {	$data_observation= $g->grade_value;
							        	  
							        	  //initial.. $max and $min
							        	     $max = $g->grade_value;
							        	     $min = $g->grade_value;
							        	     
							        	     $grade_array[$i] = $g->grade_value;
							        	   }
							         }
							       else
							         {  
							             if($g->grade_value=='')
							        	  	{ $data_observation =$data_observation.',0';
							        	  	  $grade_array[$i] = 0;
							        	  	}
							        	 else
							        	   { $data_observation =$data_observation.','.$g->grade_value;
							        	       $grade_array[$i] = $g->grade_value;
							        	     }
							          }
				                      
				                //total stud / number of grades      
				                 $tot_stud++;
								//max and min of grades
								if($g->grade_value!='')
							      {  
							      	 //max 
									 if($g->grade_value > $max)
									   $max = $g->grade_value;
									 // min
									 if($g->grade_value < $min)
									   $min = $g->grade_value;
							       }
                
				                                                                           
		                          $i++;
										     
								}
										    
						     }
						   else //course has no grade recorded 
					         {
					             if($pass==0)
							       { $pass=1;  
							        	  	       	
							          $data_observation= '0';
							        	  	      
							        }
							      else
							        { 
							           $data_observation =$data_observation.',0';
							        	  	      
							         }
				                                     
					           } 
						                
						 
					    $class_average_value = round(average_for_array($grade_array),2);
					    
					    $variance = variance($grade_array);
					    
					    $ecart_type_value = round(sqrt($variance),2); 
					     
					       echo '<input type="hidden" id="line_name" value="'.$line_name.'" />';
					       echo '<input type="hidden" id="observation_name" value="'.$observation_name.'" />';
					       echo '<input type="hidden" id="tot_stud" value='.$tot_stud.' />'; 
						   echo '<input type="hidden" id="data_observation" value="'.$data_observation.'" />';
						   echo '<input type="hidden" id="vertical_left_text" value="'.$vertical_left_text.'" />';
						   
						       
				                
					     
					     
					     
					     }
					  else
					   {  
					     
					        echo '<input type="hidden" id="line_name" value="'.$line_name.'" />';
					       echo '<input type="hidden" id="observation_name" value="'.$observation_name.'" />';
					       echo '<input type="hidden" id="vertical_left_text" value="'.$vertical_left_text.'" />';
					       
					       
					       
						   echo '<input type="hidden" id="tot_stud" value=0 />';
						    echo '<input type="hidden" id="data_observation" value=" " />';
						     
						   
						  	
					   	}

				                
				                
		 }
			     
	   
	  
  
  


     
?>


<div class="row-fluid" style=" width:auto; border:0px solid yellow;">
  
  <div class="row-fluid">
    <div class="login left" style=" width:auto;  margin-right:20px; margin-bottom:5px; border:0px solid red; ">
         
         
            
  <div class="" style="width:auto;  border:0px solid blue;">       
 
 <?php
 
if(Yii::app()->user->profil!='Teacher')
  {
 ?>	
 	   <!--room-->
			<div class="left" style="margin-left:10px; ">
                           
			<?php  
			                     echo $form->labelEx($modelRoom3,'[3]'.Yii::t('app','Room')); ?>
			          <?php 
					
					      
							  
							  if(isset($this->room_id_grade_subject))
							   { 
						          echo $form->dropDownList($modelRoom3,'[3]room_name',$this->loadRoomByIdSection($this->section_id_rpt), array('onchange'=> 'submit()','options' => array($this->room_id_grade_subject=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom3,'[3]room_name',$this->loadRoomByIdSection($this->section_id_rpt), array('onchange'=> 'submit()')); 
							          
									 $this->room_id_grade_subject=0;
							      }
						echo $form->error($modelRoom3,'[3]room_name'); 
						
										
					   ?>
			</div> <!--room-->
			
			<!--Courses   -->
			<div class="left" style="margin-left:10px;">
			 	<label for="Course"><?php echo Yii::t('app','Course'); ?></label>
			 		 <?php 
					         $modelCourse = new Courses;
					         
					         
					        
						
						if(isset($this->room_id_grade_subject)&&($this->room_id_grade_subject!=''))
						 {
						 	if(isset($this->course_id_grade_subject))
						        {   
					              echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByRoomInReport($this->room_id_grade_subject,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id_grade_subject=>array('selected'=>true)) ));
					                	
					                	 
					             }
							  else
								{ $this->course_id_grade_subject=0;
								   echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByRoomInReport($this->room_id_grade_subject,$acad_sess), array('onchange'=> 'submit()')); 
					                  
								}
						  }
						else
							echo $form->dropDownList($modelCourse,'subject',$this->loadSubject(null,null,$acad_sess), array('onchange'=> 'submit()'));
						 
						echo $form->error($modelCourse,'subject'); 
						
						
					
					  ?>
			   </div>
			   
		
		<!--evaluation   (inutilise)LOAD EVALUATIONS IN WHICH REPORTCARDS ARE ALREADY DONE loadEvaluationReportcardDone()  --> 
                  
			<div class="left" style="margin-left:10px;">
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php 			           

					        
							    if(isset($this->eval_id_grade_subject)&&($this->eval_id_grade_subject!=''))
							       echo $form->dropDownList($modelEvaluation1,'[1]evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()', 'options' => array($this->eval_id_grade_subject=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation1,'[1]evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation1,'[1]evaluation');  
						  						
					   ?>
				</div>
			
<?php 
       }
     else //Yii::app()->user->profil=='Teacher'
       {	
    ?>
                <!--room-->
			<div class="left" style="margin-left:10px; ">
                           
			<?php  
			                     echo $form->labelEx($modelRoom3,'[3]'.Yii::t('app','Room')); ?>
			          <?php 
					
					      
							  
							  if(isset($this->room_id_grade_subject))
							   { 
						          echo $form->dropDownList($modelRoom3,'[3]room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->room_id_grade_subject=>array('selected'=>true)) )); 
					             }
							   else
							      { echo $form->dropDownList($modelRoom3,'[3]room_name',$this->loadRoomByIdTeacher($id_teacher,$acad_sess), array('onchange'=> 'submit()')); 
							          
									 $this->room_id_grade_subject=0;
							      }
						echo $form->error($modelRoom3,'[3]room_name'); 
						
										
					   ?>
			</div> <!--room-->
			
			<!--Courses   -->
			<div class="left" style="margin-left:10px;">
			 	<label for="Course"><?php echo Yii::t('app','Course'); ?></label>
			 		 <?php 
					         $modelCourse = new Courses;
					         
					        
					        
						
						if(isset($this->room_id_grade_subject)&&($this->room_id_grade_subject!=''))
						 {
						 	if(isset($this->course_id_grade_subject))
						        {   
					              echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id_grade_subject,$id_teacher,$acad_sess), array('onchange'=> 'submit()','options' => array($this->course_id_grade_subject=>array('selected'=>true)) ));
					                	
					                	 
					             }
							  else
								{ $this->course_id_grade_subject=0;
								   echo $form->dropDownList($modelCourse,'subject',$this->loadSubjectByTeacherRoom($this->room_id_grade_subject,$id_teacher,$acad_sess), array('onchange'=> 'submit()')); 
					                  
								}
						  }
						else
							echo $form->dropDownList($modelCourse,'subject',$this->loadSubject(null,null,$acad), array('onchange'=> 'submit()'));
						 
						echo $form->error($modelCourse,'subject'); 
						
						
					
					  ?>
			   </div>
			   
		
		<!--evaluation   (inutilise)LOAD EVALUATIONS IN WHICH REPORTCARDS ARE ALREADY DONE loadEvaluationReportcardDone()  --> 
                  
			<div class="left" style="margin-left:10px;">
			<label for="Evaluation_name"><?php echo Yii::t('app','Evaluation Period'); ?></label><?php 			           

					        
							    if(isset($this->eval_id_grade_subject)&&($this->eval_id_grade_subject!=''))
							       echo $form->dropDownList($modelEvaluation1,'[1]evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()', 'options' => array($this->eval_id_grade_subject=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelEvaluation1,'[1]evaluation',$this->loadEvaluation($acad_sess), array('onchange'=> 'submit()')); 
						           }					      
						  
						echo $form->error($modelEvaluation1,'[1]evaluation');  
						  						
					   ?>
				</div>
    
 <?php   
       }//fen Yii::app()->user->profil=='Teacher'
       
   ?>					 
			   
      </div> <!-- span2-->	   
	</div>  <!--class=""--> 
			
		  
  
   <!-- </div>  span2-->

  
     

            
<?php 
    if(($this->course_id_grade_subject!='')&&($this->eval_id_grade_subject!=''))
	  {
	 ?> 	 
 		<div class="span5 left" style=" border:1px solid gray; padding:10px; font-weight:normal;  background: #E4E9EF; -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; behavior: url(/pie/PIE.htc);  ">
 		   <div class="row-fluid">
  <?php 
         	
		   
		   
		   	echo '<div class="left " style="  border:px solid red; margin-left:12px;">'.$label_class_average.': <span style="font-size:14px; font-weight:bold;">'.$class_average_value.'</span></div><div class="left " style="  border:px solid red;  margin-left:12px;">'.$label_ecart_type.': <span style="font-size:14px; font-weight:bold;">'.$ecart_type_value.'</span></div><div class="left " style="  border:px solid red; margin-left:12px;">'.$label_max.': <span style="font-size:14px; font-weight:bold;">'.$max.'</span></div><div class="left " style="  border:px solid red; margin-left:12px;">'.$label_min.': <span style="font-size:14px; font-weight:bold;">'.$min.'</span></div><div class="left " style="  border:px solid red; margin-left:12px;">'.$label_total_stud.' <span style="font-size:14px; font-weight:bold;">'.$tot_stud.'</span></div><div class="left " style="  border:px solid red; margin-left:12px;">'.$label_total_success.': <span style="font-size:14px; font-weight:bold;">'.$total_success_value.'</span></div><div class="left " style="  border:px solid red; margin-left:12px;">'.$label_male_success.': <span style="font-size:14px; font-weight:bold;">'.$male_success_value.'</span></div><div class="left" style="  border:px solid red; margin-left:12px;">'.$label_female_success.': <span style="font-size:14px; font-weight:bold;">'.$female_success_value.'</span></div>';
		    	
	
			  
  ?>
          </div> 
 		</div> <!--span6-->
 		
 		<div class="span10 left" style=" margin-left:10px; border:0px solid blue;"> 
 		       <div class="" id="container3" name="container3"  style="height:410px;  "> 
 		        </div>
 		 </div>  <!--span8-->
    
     </div>
  </div> 
			<script>
			 
			 
			 $(function () {
			  
			 
			  
			  var i;
			   var j;
			   
			
		 
		   
		   var vertical_left_text = document.getElementById("vertical_left_text").value;
		   var vertical_left_text = document.getElementById("vertical_left_text").value;
			
			  var vertical_left_text = document.getElementById("vertical_left_text").value;
			  var tot_stud = parseInt(document.getElementById("tot_stud").value);
			  var observation_name = document.getElementById("observation_name").value;
			  var line_name = document.getElementById("line_name").value;
			  
			  var data_observation;
			  var tab_observation=[]; 
			  
			  
			  var _data_observation =[];
			  	 
			  	 
			     data_observation = document.getElementById("data_observation").value;
			     			    
			     tab_observation = data_observation.split(",");
			     
			    _data_observation[0]=0;
			    for(i=0;i<tab_observation.length; i++)
			     {
			     	
			     	_data_observation[i+1]=parseFloat(tab_observation[i]);
			    	
			       }	
			  	
			  	
			     
			    $('#container3').highcharts({         
			    	xAxis: {             
			    		min: 1, //-0.5,             
			    		max: tot_stud //+0.5 //5.5         
			    		},         
			        yAxis: {             
			        	min: 0,         
			            title: {             
			       	           text: vertical_left_text //''
			       	              
			       	          }
			        	},         
			       title: {             
			       	    text: ''
			       	              
			       	   },         
			       series: [
			               
			       	  {          
			       	    type: 'scatter',             
			       	    name: observation_name, //'Observations',             
			       	    data: _data_observation, //[1, 1.5, 2.8, 3.5, 3.9, 4.2],             
			       	    marker: {                 
			       	    	     radius: 5            
			       	    	    }         
			       	    	    
			       	    	 }]     
			       	    	 
			       	 }); 
				  
				
				});
				
				  
				  
				 </script>   
				
				
		 
		 
         


 </div> <!-- end class="row-fluid" -->
   
  
<?php   

	  }//end of if($this->progress_subject_period==1)
		
}
?>
   
 </div></div> <!-- end class="row-fluid" -->


    
<!--//####################  FIN  ###################  -->

<div style="clear:both"></div>



                          </td>
                        </tr> 
                        
                         <tr>  
                          <td colspan="4">
                          </td>
                        </tr>  
                                              
                                           
                      </tbody>
                    </table>
                 </div> </div><!-- /.table-responsive -->
                </div><!-- /.box-body -->
                
              </div>
<!-- END OF TEST -->






<?php 
//pending to use
/*
 echo '<canvas id="all-stat" height="300" width="500"></canvas>';
 
   echo '<input type="hidden" id="label_class_name" value="'.$label_class_name.'" />';
     echo '<input type="hidden" id="data_class_average" value="'.$data_class_average.'" />';
      echo '<input type="hidden" id="data_female_average" value="'.$data_female_average.'" />';
       echo '<input type="hidden" id="data_male_average" value="'.$data_male_average.'" />';
       
        //echo '<input type="hidden" id="period_exam_name" value="'.$period_exam_name.'" />';
       // echo '<input type="hidden" id="title_chart" value="'.Yii::t("app","Average").'<br/>'.Yii::t("app","Evaluation Period").': '.$period_exam_name.'" />';
        echo '<input type="hidden" id="title_chart" value="'.Yii::t("app","Average").' '.$period_exam_name.'" />';
        echo '<input type="hidden" id="vertical_left_title" value="'.Yii::t("app","Shift").': '.$shift.'" />';
        echo '<input type="hidden" id="label1_legend" value="'.Yii::t("app","Girl").'" />';
        echo '<input type="hidden" id="label2_legend" value="'.Yii::t("app","Class").'" />';
        echo '<input type="hidden" id="label3_legend" value="'.Yii::t("app","Boy").'" />';
        
        
 
            
    Yii::app()->clientScript->registerScript('all-stat', '
  var randomScalingFactor = function(){ return Math.round(Math.random()*100)};

  var label_class_name=document.getElementById("label_class_name").value;
  var data_class_average=document.getElementById("data_class_average").value;
  
  var data_female_average=document.getElementById("data_female_average").value;
  var data_male_average=document.getElementById("data_male_average").value;
  
   var tab_label = label_class_name.split(",");
   var tab_data = data_class_average.split(",");
   
   var tab_data_female = data_female_average.split(",");
   
   var tab_data_male = data_male_average.split(",");
	
	var barChartData = {
		labels : tab_label,
		datasets : [
			
			  //female average
			{  
				fillColor : "rgba(216,255,89,0.5)",
				strokeColor : "rgba(216,255,89,0.8)",
				highlightFill : "rgba(216,255,89,0.75)",
				highlightStroke : "rgba(216,255,89,1)",
				data : tab_data_female
			},
			
			// class average
			{
				fillColor : "rgba(151,187,205,0.5)",
				strokeColor : "rgba(151,187,205,0.8)",
				highlightFill : "rgba(151,187,205,0.75)",
				highlightStroke : "rgba(151,187,205,1)",
				data : tab_data
			},
			
			  //male average
			{  
				fillColor : "rgba(255,186,48,0.5)",
				strokeColor : "rgba(255,186,48,0.8)",
				highlightFill : "rgba(255,186,48,0.75)",
				highlightStroke : "rgba(255,186,48,1)",
				data : tab_data_male
			},
			
		]

	}
	window.onload = function(){
		var ctx = document.getElementById("all-stat").getContext("2d");
		window.myBar = new Chart(ctx).Bar(barChartData, {
			responsive : true
		});
	}
			');
		
            */
 ?>
         


     
                           
       