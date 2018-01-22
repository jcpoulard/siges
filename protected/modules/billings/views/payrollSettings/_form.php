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
/* @var $this PayrollSettingsController */
/* @var $model PayrollSettings */
/* @var $form CActiveForm */


$acad_sess=acad_sess();

$acad=Yii::app()->session['currentId_academic_year'];
$acad_name=Yii::app()->session['currentName_academic_year'];

$this->widget('ext.yiiselect2.YiiSelect2',array('target'=>'select',)); 



?>



<div class="form">
	
<?php
	echo '<p class="note">'.Yii::t('app','Fields with <span class="required">*</span> are required.').'</p>';
    
	  if(!isset($_GET['all']))
             echo $form->errorSummary($model); 
             
             
          $dataProvider_noPerson ='';
          $dataProvider_updateOne ='';
          
          $noPerson=false;
          $there_is_employee_or_teacher =true;

	
	 
	  //error message 
	        	if(($this->message_asAlreadySetAs)||($this->message_eitherEmployeeNorTeacher)||($this->message_notEmployee)||($this->message_notTeacher)||($this->message_employeeOrTeacher))
			      { echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:-17px; ';//-20px; ';
				      echo '">';
				      				      
			           echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';
			       
			       }			      
				 					     	
				if($this->group==0)  
				  { 
				    if($this->message_eitherEmployeeNorTeacher)
				      {  echo '<span style="color:red;" > '.Yii::t('app','{name} is not an employee either a teacher.', array('{name}'=>$model->person->fullName)).'</span>'.'<br/>';
				      }
				  if($this->message_notEmployee)
				      {  echo '<span style="color:red;" > '.Yii::t('app','{name} is not an employee.', array('{name}'=>$model->person->fullName)).'</span>'.'<br/>';
				      }
				    				   
				  if($this->message_notTeacher)
				     echo '<span style="color:red;" >'.Yii::t('app','{name} is not a teacher.', array('{name}'=>$model->person->fullName)).'</span>'.'<br/>';
					
				  if($this->message_asAlreadySetAs)
				     echo '<span style="color:red;" >'.Yii::t('app','{name} is already set as {name1}.', array('{name}'=>$model->person->fullName, '{name1}'=>$model->getAsValue() )).'</span>'.'<br/>';

				  
				  
				  }
					
					 
				   if($this->message_employeeOrTeacher)
				      echo '<span style="color:red;" >'.Yii::t('app','Persons with a wrong status(employee or teacher) are not saved.').'</span>'.'<br/>';
					   
			     if(($this->message_asAlreadySetAs)||($this->message_eitherEmployeeNorTeacher)||($this->message_notEmployee)||($this->message_notTeacher)||($this->message_employeeOrTeacher))
			      { 
					 echo'</td>
					    </tr>
						</table>';
					
                      echo '</div>';
			       }
       		
	?>


<div  id="resp_form_siges">

        <form  id="resp_form">

       <div class="col-1">
            <label id="resp_form">
            
              <?php 
                                  if((!isset($_GET['all']))&&(!isset($_GET['id'])))
                                   {  
                                      echo $form->label($model,'group'); 
		                              if($this->group==1)
				                          { echo $form->checkBox($model,'group',array('onchange'=> 'submit()','checked'=>'checked'));
				                              
				                           }
						                 else
							               echo $form->checkBox($model,'group',array('onchange'=> 'submit()'));
							               
                                     }
							      
                          ?>
               </label>
        </div>
            
            
            
        <div class="col-1">
            <label id="resp_form">    
            
            <?php  if(!isset($_GET['all']))
                                echo $form->labelEx($model,'person_id'); ?>
                    
                        <?php 
                               $criteria='';
                               
                               if(isset($_GET['id']))
                                  $this->person_id=$model->person_id;
                               
                           				                  
                               if($this->group==0)
                                  {//one by one
                                    
    //_______________________________ YON MOUN KA GEN 2 CHEK (ALAFWA ANPLWAYE - PWOFESE)  ___________________________________________//       
                        	
                                      if(isset($this->person_id)&&($this->person_id!=''))
										 {  
										 	$criteria = new CDbCriteria(array('group'=>'id','alias'=>'p', 'order'=>'last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) AND (p.id IN(SELECT person_id FROM payroll_settings ps WHERE (ps.academic_year='.$acad.') )) '));
										 	echo $form->dropDownList($model, 'person_id',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array('options' => array($this->person_id=>array('selected'=>true)), 'disabled'=>'disabled'));
										 	
										 	$dataProvider_updateOne =Persons::model()->findAll($criteria);
										    
										 }
										else
										  {
										  	 $criteria = new CDbCriteria(array('group'=>'id','alias'=>'p', 'order'=>'last_name', 'condition'=>'p.is_student=0 AND p.active IN(1, 2) '));
										  	 echo $form->dropDownList($model, 'person_id',CHtml::listData(Persons::model()->findAll($criteria),'id','fullName'),array( 'prompt'=>Yii::t('app','-- Search --'), 'disabled'=>''));
										  	 
										  	 $dataProvider_createOne =Persons::model()->findAll($criteria);
										  	  if($dataProvider_createOne!=null)
										  	    $there_is_employee_or_teacher=true;
										  	  else
										  	    $there_is_employee_or_teacher=false;
										    }
			
	//__________________________________________________________________________________________________________________________// 
        							    
       							    

                                   }
                               elseif($this->group==1)
				                   { 
			                         if(!isset($_GET['all']))
                                     {   
			                          if($this->grouppayroll!=null)
			                           {
									      echo $form->dropDownList($model, 'group_payroll',$model->getPayrollGroup(),array('onchange'=> 'submit()','options' => array($this->grouppayroll=>array('selected'=>true))));
						                }
						               else
						                 {
						                    echo $form->dropDownList($model, 'group_payroll',$model->getPayrollGroup(),array('onchange'=> 'submit()'));
						                   }
						                   
                                       }
                                     else
                                       {
                                       	 if($this->grouppayroll!=null)
				                           {
										      $model_ = new PayrollSettings;
										      echo $form->dropDownList($model_, 'group_payroll',$model_->getPayrollGroup(),array('onchange'=> 'submit()','options' => array($this->grouppayroll=>array('selected'=>true)), 'disabled'=>'disabled'));
							                }
							               						                      

                                       	
                                       	}
                                       	
                                       	
				                    }
                             
                            
                            ?>
                        <?php if(!isset($_GET['all']))
                                 echo $form->error($model,'employee_fname'); ?>
                  

            
              </label>
        </div>
    
    <?php if($this->group==0)
       {   
     ?>
                 <div class="col-1">
                   <label id="resp_form" style="margin-left:40px; margin-top:30px;" > 
                    
                   <?php
                    echo $form->radioButtonList($model,'as',
												    array(0=>Yii::t('app','Employees'),
												          1=>Yii::t('app','Teachers') 
												          ),
												    array(
												        'template'=>'{input}{label}',
												        'separator'=>'',
												        'labelOptions'=>array(
												            'style'=> '
												                
												                width: auto;
												                float: left;
												                margin-left:-10%;
												                margin-top:-1%;
												            '),
												          'style'=>'float:left;',
												          )                              
												      );  
												                   
                   ?> 
                         
                   </label>
               </div> 
               
    <?php
       /*     if(isset($_GET['id']))
              {
    ?>           
        <!--        <div class="col-1">
            <label id="resp_form">
            
          -->    <?php 
                               //         echo $form->label($model,'old_new'); 
		                              
							   //            echo $form->checkBox($model,'old_new',array('onchange'=> 'submit()'));
							               
                                    
                          ?>
        <!--       </label>
            </div>
         -->   
<?php
              }
              */
    ?> 
    
               
   <?php                           	
            $modPerson=Persons::model()->findAll($criteria);
                    	
           if($modPerson!=null)
             {
             	
       ?>
       
 <br/>
                <div class="col-3">
                   <label id="resp_form">    
                             <?php echo $form->labelEx($model,'amount'); ?>
                         <?php echo $form->textField($model,'amount',array('size'=>60,'placeholder'=>Yii::t('app','Amount'))); ?>
                          <?php echo $form->error($model,'amount'); ?>
            
                   </label>
               </div>   
                    
               <div class="col-3">
                   <label id="resp_form">    
                             
                         
                          <?php echo $form->labelEx($model,'number_of_hour'); ?>
                         <?php echo $form->textField($model,'number_of_hour',array('size'=>60,'placeholder'=>Yii::t('app','Number Of Hour'))); ?>
                          <?php echo $form->error($model,'number_of_hour'); ?>  
            
                   </label>
               </div>     
               
                <div class="col-3">
                   <label id="resp_form">    
                       
                   </label>
               </div>         
             
 <?php     }
         else
            {
    ?>

 <br/>         
      <div class="col-1">
            <label id="resp_form">    
            <?php 
					          echo '<div class="" style=" padding-left:0px;margin-right:250px; margin-bottom:0px; ">';//-20px; ';
									      
									    echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
										   <tr>
										    <td style="text-align:center;">';	  
									  			
									 if($there_is_employee_or_teacher==false)
							  		   {
							  		   	    if($this->as==0)
							  			      echo '<span style="color:red;" >'.Yii::t('app','No employee to set payroll for.').' </span> <br/>';
							  			    elseif($this->as==1)
							  			     echo '<span style="color:red;" >'.Yii::t('app','No teacher to set payroll for.').' </span> <br/>';
							  			      
							  		   	} 	
							  		  else 	
							  		   	echo '<span style="color:blue;" >'.Yii::t('app','Leave "Number Of Hour" field blank if not a timely salary.').' </span>';
							  		   	
							  		   	//echo '<span style="color:red;" >'.Yii::t('app','Payroll is already set for everyone. You can use UPDATE option.').' </span> <br/>';
									  			 	
									  		 
										
										 echo'</td>
										    </tr>
											</table>';
										
					           echo '</div>';
              
              
                      ?>
            
              </label>
        </div>

<?php        
    }
              
  }
 elseif($this->group==1)
   {         
   	
   	
  ?>  
     
     
     
     
  <br/>   
     
     
       
           
                       <div class="list_secondaire" style="margin-left:10px; width:90%;">
											

			<?php
			
			$header='';
              $condition='';
               
               $id='';
 
     //_______________________________ YON MOUN KA GEN 2 CHEK (ALAFWA ANPLWAYE - PWOFESE)  _______________________________________// 
        
                 if(!isset($_GET['all'])) //to create
                   { 
	    	  	       if($this->grouppayroll=='2')//teacher
                                 {
                                 	  $command= Yii::app()->db->createCommand('SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE  c.old_new=1 AND (a.year='.$acad.' OR (a.id='.$acad.'))' );
                                 	
                                 	 $check_teacher_this_year = $command->queryAll();
		                        if($check_teacher_this_year==null)
		                           $there_is_employee_or_teacher =false;
		 
                                 	
                                $condition=' is_student=0 AND (p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE c.old_new=1 AND (a.year='.$acad.' OR (a.id='.$acad.'))  ) AND p.id NOT IN(SELECT person_id FROM payroll_settings ps WHERE ps.as=1  AND ps.academic_year='.$acad.') ) AND active IN(1, 2) ';  //depi moun nan ap fe ton kou
                                    
                                    $header=Yii::t('app','Teachers name');
                                 }
                               elseif($this->grouppayroll=='1')//employee
                                  { 
                                  	
                                  	$command= Yii::app()->db->createCommand('SELECT persons_id FROM persons_has_titles pt WHERE pt.academic_year='.$acad );
                                 	
                                 	 $check_employee_this_year = $command->queryAll();
		                        if($check_employee_this_year==null)
		                           $there_is_employee_or_teacher =false;
		 

                                 $condition=' is_student=0 AND active IN(1, 2) AND ( p.id IN(SELECT persons_id FROM persons_has_titles pt WHERE pt.academic_year='.$acad.' ) AND p.id NOT IN(SELECT person_id FROM payroll_settings ps WHERE ps.as=0 AND ps.academic_year='.$acad.') ) ';   //depi moun nan gen yon tit(title)
                                  
                                      $header=Yii::t('app','Employees name');
                                   }
                                   
                         $dataProvider_noPerson =Persons::model()->searchEmployeeForPayroll($condition);
	    	  	       $dataProvider_noPerson =$dataProvider_noPerson->getData();
	    	  	       
                   }
                 else  //to update
                  {
                  	     if($this->grouppayroll=='2')//teacher
                                 {
                                $condition='is_student=0 AND (p.id IN(SELECT teacher FROM courses c left join academicperiods a on(a.id=c.academic_period) WHERE c.old_new=1 AND (a.year='.$acad.' OR (a.id='.$acad.'))  ) AND (p.id IN(SELECT person_id FROM payroll_settings ps WHERE (ps.academic_year='.$acad.' AND ps.as=1) ))  ) AND active IN(1, 2) ';   //depi moun nan ap fe ton kou
                                    
                                    $header=Yii::t('app','Teachers name');
                                 }
                               elseif($this->grouppayroll=='1')//employee
                                  { $condition='is_student=0 AND active IN(1, 2) AND (p.id IN(SELECT persons_id FROM persons_has_titles pt WHERE  pt.academic_year='.$acad.'  ) AND (p.id IN(SELECT person_id FROM payroll_settings ps WHERE (ps.academic_year='.$acad.' AND ps.as=0) ))  ) ';     //depi moun nan gen yon tit(title)
                                  
                                      $header=Yii::t('app','Employees name');
                                   }
                           $dataProvider_noPerson =Persons::model()->searchEmployeeForPayroll($condition);
	    	  	       $dataProvider_noPerson =$dataProvider_noPerson->getData();
                  	}            
               
        //___________________________________________________________________________________________________________________________//
          
                              
               if( ($dataProvider_noPerson ==null)||($there_is_employee_or_teacher==false))                     
                 echo ' <label style="width:100%; padding-left:0px;margin-right:250px; margin-bottom:-20px;"><div class="" style=" padding-left:0px;margin-right:290px; margin-bottom:-18px; ">';//-20px; ';
               else
                  echo '<label style="width:100%; padding-left:0px;margin-right:250px; margin-bottom:-20px;"><div class="" style=" padding-left:0px;margin-right:290px; margin-bottom:-48px; ">';//-20px; ';
				      
				    echo '<table class="responstable" style="width:100%; background-color:#F8F8c9;  ">
					   <tr>
					    <td style="text-align:center;">';	  
				  		   
				  		   if($there_is_employee_or_teacher==false)
				  		   {
				  		   	    if($this->grouppayroll==1)
				  			      echo '<span style="color:red;" >'.Yii::t('app','No employee to set payroll for.').' </span> <br/>';
				  			    elseif($this->grouppayroll==2)
				  			     echo '<span style="color:red;" >'.Yii::t('app','No teacher to set payroll for.').' </span> <br/>';
				  			      
				  		   	}
				  		   elseif( $dataProvider_noPerson ==null) 
				  			{   
				  				$noPerson=true;
				  				
				  				if($this->grouppayroll==1)
				  			      $all='e';
				  			    elseif($this->grouppayroll==2)
				  			      $all='t';
				  			   
				  			   //to get an id  
				  			     $mod_id= $model->search_($acad);
				  			      $mod_id=$mod_id->getData();
				  			      foreach($mod_id as $i)
				  			        {
				  			        	$id = $i->id;
				  			        	 break;
				  			        	}
				  			      
				  			 	echo '<span style="color:red;" >'.Yii::t('app','Payroll is already set for everyone.').CHtml::link(Yii::t('app',' Click here to use UPDATE option.'),array('/billings/payrollSettings/update/','id'=>$id,'all'=>$all)).' </span> <br/>';
				  			 	}
				  			
				  			if($this->message_noAmountEntered)
				  			 {
				  			 	echo '<span style="color:red;" >'.Yii::t('app','You must enter at least one AMOUNT.').' </span> <br/>';
				  			 	}
				   			 			   
				  		 echo '<span style="color:blue;" >'.Yii::t('app','Leave "Number Of Hour" field blank if not a timely salary.').' </span>';
					
					 echo'</td>
					    </tr>
						</table>';
					
           echo '</div></label>';
              
              	    	  	
	    	  	 if(!isset($_GET['all'])) //to create
                   {
	    	  	       
	    	  	       $dataProvider=Persons::model()->searchEmployeeForPayroll($condition);
	    	  	    
	    	  	         $this->widget('zii.widgets.grid.CGridView', array(
					    
						'dataProvider'=>$dataProvider,
						'showTableOnEmpty'=>'true',
						'selectableRows' => 2,
						//'filter'=>$model,
					    'columns'=>array(
						  
							
						  array('name'=>$header,//'Student name',
					                'header'=>$header,//Yii::t('app','Student name'),
						        'value'=>'$data->first_name." ".$data->last_name'
								),
					     array('header' =>Yii::t('app','Amount'), 'id'=>'amountValue', 'value' => '\'
					           <input name="amount[\'.$data->id.\']" type=text style="width:92%;" />
					          
							   <input name="id_pers[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
					           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
					           \'','type'=>'raw' ),
					       
					      array('header' =>Yii::t('app','Number Of Hour'), 'id'=>'numberHourValue', 'value' => '\'
					           <input name="numberHour[\'.$data->id.\']" type=text style="width:92%;" />
					          
							   <input name="id_pers[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
					           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
					           \'','type'=>'raw' ),
					              
					      
					       array(             'class'=>'CCheckBoxColumn',   
					                           'id'=>'chk',
					                 ),           
							
					       ),
					    ));
					                          
                     }
                  else  //to update
                    {
                         
                         $dataProvider=Persons::model()->searchPersonsForShowingPayrollSetting($condition,$acad);	
                         
                         $this->widget('zii.widgets.grid.CGridView', array(
					  
						'dataProvider'=>$dataProvider,
						'showTableOnEmpty'=>'true',
						'selectableRows' => 2,
						
					    'columns'=>array(
						  
							
				         array('name'=>$header,//'Student name',
					                'header'=>$header,//Yii::t('app','Student name'),
						        'value'=>'$data->first_name." ".$data->last_name'
								),
					     array('header' =>Yii::t('app','Amount'), 'id'=>'amountValue', 'value' => '\'
					           <input name="amount[\'.$data->id.\']" type=text value=\'.$data->amount.\' style="width:92%;" />
					          
							   <input name="id_pers[\'.$data->id.\']" type="hidden" value="\'.$data->personId.\'" />
							   <input name="id_ps[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
					           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
					           \'','type'=>'raw' ),
					       
					    array('header' =>Yii::t('app','Number Of Hour'), 'id'=>'numberHourValue', 'value' => '\'
					           <input name="numberHour[\'.$data->id.\']" type=text value="\'.$data->numberHour_update.\'" style="width:92%;" />
					          
							   <input name="id_pers[\'.$data->id.\']" type="hidden" value="\'.$data->personId.\'" />
							   <input name="id_ps[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
					           <!--<input type="image" src="'.Yii::app()->request->baseUrl.'/img.png" />  -->
					           \'','type'=>'raw' ),

					              
                    
					       
					       
					       array(             'class'=>'CCheckBoxColumn',   
					                           'id'=>'chk',
					                 ),           
							
						    ),
						));
							

                     
                     
                      }
	    	  	
	    	  	 
				

			 ?>

 
 
                        </div>       

                  
     
                    
    <?php   }
       
       if(($noPerson==false)&&($there_is_employee_or_teacher==true))
         {
         	
       ?>
       

 <br/>       
        <div class="col-1"  style =" width:100%;">
            <label id="resp_form"  style =" width:90%;">           
                    <label for=""><?php echo Yii::t('app','Choose taxes to be paid'); ?></label>                      
                               <?php // Obligation
                                       				   
					$taxes_desc = array();
					$modelTaxes= new Taxes();
					$taxe = Taxes::model()->searchTaxesForPS($acad);
                 		
                 		if($taxe!=null)
				                     {  
					                   foreach($taxe as $id_taxe)
					                      {
			 	                                $taxes_desc[$id_taxe["id"]] = $id_taxe["taxe_description"];
										        						
											}
											
								       }

					
					 
					 
				if($taxes_desc!=null)
				 {	   
                                                              
           ?>
				
		
			
						<?php
						       $modelTaxe = new Taxes;
				
				              if((isset($_GET['id'])))
                                   {  
                                   	$payrollSettingTaxe=new PayrollSettingTaxes;
                        $payrollSettingTaxe=PayrollSettingTaxes::model()->findByAttributes(array('id_payroll_set'=>$_GET['id']));
                        
                           $checked_taxes = PayrollSettingTaxes::model()->findAllByAttributes(array('id_payroll_set'=>$_GET['id']));
                                
                                
                                     $checked_taxes_array = array();
                                      if($checked_taxes!=null)
                                       { foreach($checked_taxes as $checked)
                                           $checked_taxes_array[] = $checked['id_taxe'];
                                        }
                                      
                                    if($taxe!=null)
				                     {   $i=0;
					                   foreach($taxe as $id_taxe)
					                      {   
			 	                               
			 	                                
			                                if (in_array($id_taxe["id"], $checked_taxes_array))  
					                          { 
		 echo '<div class="rmodal"> <div class=""  style="float:left; width:auto;"> <div class="l">'.$id_taxe["taxe_description"].'</div><div class="r" style="margin-right:40px;"><input type="checkbox" name="'.$id_taxe["id"].'" id="'.$id_taxe["id"].'" checked="checked" value="'.$id_taxe["id"].'"></div></div></div>';
			                              
					                           }
							                 else
							                   echo '<div class="rmodal"> <div class=""  style="float:left; width:auto;"> <div class="l">'.$id_taxe["taxe_description"].'</div><div class="r" style="margin-right:40px;"><input type="checkbox" name="'.$id_taxe["id"].'" id="'.$id_taxe["id"].'" value="'.$id_taxe["id"].'"></div></div></div>';

								               
								               $i++;

										        						
											}
											
											
											
								       }
								      
                                      
			                            
                                     }
                                  else
                                    {   $i=0;
                                    	 foreach($taxe as $id_taxe)
					                      {   $modelTaxe = new Taxes;
			 	                               
			 	                               
			 	                                 echo '<div class="rmodal"> <div class=""  style="float:left; width:auto;"> <div class="l">'.$id_taxe["taxe_description"].'</div><div class="r" style="margin-right:40px;"><input type="checkbox" name="'.$id_taxe["id"].'" id="'.$id_taxe["id"].'" value="'.$id_taxe["id"].'"></div></div></div>';
			 	                                
					                        }
                                   
                                                                       
					                      }
	         
	         
				 }
				 
				 
				 
	                     ?>
	               
	            </label>
        </div>
  
   <?php
         }
        else 
           echo '<br/><br/>';
   ?>            
	<div class="col-submit">                                        
                                <?php 
 
                         
                            	    if(!isset($_GET['id'])){
                            	    	
                            	      if(($noPerson==false)&&($there_is_employee_or_teacher==true))
                            	       {
                                         if(!isAchiveMode($acad_sess))
                                            echo CHtml::submitButton(Yii::t('app', 'Create '),array('name'=>'create','class'=>'btn btn-warning')); //'Create ' avec espace a la fin POUR AVOIR UNE TRADUCTION "ENREGISTRER"
                                        
                                         echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary')); //'Cancel ' avec espace a la fin POUR AVOIR UNE TRADUCTION "Annuler"/ sans espace=>'Retour'
                                        
                            	       }
                                        
                                        }
                                         else
                                           {  if(!isAchiveMode($acad_sess))
                                                 echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             } 
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

                        
                                ?>
         </div>
        </form>
</div>
                        
<!-- END OF TEST -->

</div>
     
     
     
  