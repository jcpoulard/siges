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




class PayrollSettingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $part='payset';
	
	public $back_url;
	public $person_id;
	public $group;
	public $an_hour;
	public $grouppayroll=1;
	//public $as_;
	public $as;
	public $old_new;
	
	public $message_noAmountEntered=false;
	public $message_eitherEmployeeNorTeacher=false;
	public $message_notEmployee=false;
	public $message_notTeacher=false;
	public $message_employeeOrTeacher=false;
	public $message_asAlreadySetAs=false;
	

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		 $explode_url= explode("/",substr($_SERVER['REQUEST_URI'],1));
            $controller=$explode_url[3];
            //print_r($explode_url);
             
            $actions=$this->getRulesArray($this->module->name,$controller);
        
          if($this->getModuleName($this->module->name))
                {
		            if($actions!=null)
             			 {     return array(
				              	  	array('allow',  
					                	
					                	'actions'=> $actions,
		                                  'users'=>array(Yii::app()->user->name),
				                    	),
				              		  array('deny',  
					                 	'users'=>array('*'),
				                    ),
			                );
             			 }
             			 else
             			  return array(array('deny', 'users'=>array('*')),);
                }
                else
                {
                    return array(array('deny', 'users'=>array('*')),);
                }

 
		 
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new PayrollSettings;
		
		$acad=Yii::app()->session['currentId_academic_year'];
		
		$this->message_eitherEmployeeNorTeacher=false;
		$this->message_notEmployee=false;
		$this->message_notTeacher=false;
		$this->message_employeeOrTeacher=false;
		$this->message_asAlreadySetAs=false;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);
		
		$this->as = $model->as;

		if(isset($_POST['PayrollSettings']))
		{
			
			
			if(isset($_POST['PayrollSettings']['group']))
			  {
                        $this->group = $_POST['PayrollSettings']['group'];
                    }
                    
            if(isset($_POST['PayrollSettings']['group_payroll']))
			  {
                        $this->grouppayroll = $_POST['PayrollSettings']['group_payroll'];
                    }
			
			if(isset($_POST['create']))
			  {
				if($this->group==0)
				  {
				  	$model->attributes=$_POST['PayrollSettings'];
					$this->as = $model->as;
				  	
				  	//return id PayrollSettings
				  	$ifAsAlreadySetAs = PayrollSettings::model()->ifAsAlreadySetAs($model->person_id, $this->as, $acad);
				  	
				  if($ifAsAlreadySetAs==null)	
				  	{
					  	//return 0 when employee, 1 when teacher; return 2 when employee-teacher; return -1 when either employee nor teacher
					  	$employee_or_teacher = Persons::model()->isEmployeeOrTeacher($model->person_id, $acad);	
				  	
					  	if($employee_or_teacher!= -1)
					  	 {
				  	 	
						  	if(($employee_or_teacher==2)||($model->as==$employee_or_teacher))
						  	 {
							  	if($model->number_of_hour !='') //if(isset($_POST['PayrollSettings']['an_hour']))
						           $this->an_hour = 1; // $_POST['PayrollSettings']['an_hour'];
						        else
						           $this->an_hour = 0;
			                    
						  	
						  	$model->setAttribute('an_hour',$this->an_hour);
						  	$model->setAttribute('academic_year',$acad);
						  	$model->setAttribute('old_new',1);
						  	$model->setAttribute('date_created',date('Y-m-d'));
						  	$model->setAttribute('created_by',Yii::app()->user->name);
						  	
						  	 	if($model->save())
								  {
								    
									$taxe = Taxes::model()->searchTaxesForPS($acad);
									     		
						             if($taxe!=null)
									   {  
									   	   $i=0;
									   	   
										  foreach($taxe as $id_taxe)
										    {     
										    	//$taxe_description = $id_taxe["id"];
										    	
										    	$modelTaxes= new Taxes();
									 	          if(isset($_POST[$id_taxe["id"]]))
									       	 	    {
									       	 	    	$taxeID=$_POST[$id_taxe["id"]];
									       	 	    	
														   $modelPayrollSettingTaxe = new PayrollSettingTaxes;
															      	  
														   $modelPayrollSettingTaxe->setAttribute('id_payroll_set',$model->id);
														   $modelPayrollSettingTaxe->setAttribute('id_taxe',$taxeID);
																      	  
														    $modelPayrollSettingTaxe->save();
																      	  
														   $modelPayrollSettingTaxe->unSetAttributes();
														   //$modelPayrollSettingTaxe = new PayrollSettingTaxes;
														   
														   $modelTaxes->unSetAttributes();
																      	
									       	 	      }
									       	 	      
									       	 	      
																        						
										       }
																	
						                  }					   
		
								     
								  	//$this->redirect(array('view','id'=>$model->id,'part'=>'payset','from'=>''));
								  	$this->redirect(array('index','part'=>'payset','from'=>''));
								  	
								   }
							     else
									  $model->setAttribute('academic_year','');
						  	      
						  	      }
						  	     else
						  	       {
						  	       	  if($model->as==0)
						  	       	      $this->message_notEmployee=true;
						  	       	  elseif($model->as==1)
						  	       	       $this->message_notTeacher=true;
						  	       	 }
								
					        }
					       else
					          $this->message_eitherEmployeeNorTeacher=true;
				  	
				  	     }
				  	   else
				  	      $this->message_asAlreadySetAs=true;
				        
				        
						
				   }
				 elseif($this->group==1)
					{
					
					     $this->message_noAmountEntered=false;
					   $no_pers_has_amount=true;
					   $temwen=false;
					   $person='';
					   $as = 0;
					   
					   if( $this->grouppayroll==1)
					        $as = 0;
					    elseif($this->grouppayroll==2)
					           $as = 1;
					           
					   
					  foreach($_POST['id_pers'] as $id)
                        {   	   
						           if(isset($_POST['amount'][$id])&&($_POST['amount'][$id]!=''))
						                $no_pers_has_amount=false;
							
						}
						
					  
					if(!$no_pers_has_amount) 
						{  foreach($_POST['id_pers'] as $id)
		                        {   	   
								     //return 0 when employee, 1 when teacher; return 2 when either employee nor teacher
								  	$employee_or_teacher = Persons::model()->isEmployeeOrTeacher($id, $acad);	
								  	
								  	if($employee_or_teacher!=2)
								  	 {
								  	 	
									  	if($as==$employee_or_teacher)
									  	 {
                                         $numberHour = 0;     
								           if(isset($_POST['numberHour'][$id]))
								             {   
								             	if($_POST['numberHour'][$id]!='')
								                  {    $this->an_hour=1;
								                     $numberHour = $_POST['numberHour'][$id];
								                   }
								                 else
								                     $this->an_hour=0;
								              }
											else
												$this->an_hour=0; 
												
												
											if(isset($_POST['amount'][$id]))
								                $amount=$_POST['amount'][$id];
											else
												$amount=0;
							               
									       
											   $model->setAttribute('person_id',$id);
											   $model->setAttribute('amount',$amount);
											   $model->setAttribute('as',$as);
											   $model->setAttribute('old_new',1);
											   $model->setAttribute('an_hour',$this->an_hour);
											   $model->setAttribute('number_of_hour',$numberHour);
											   $model->setAttribute('academic_year',$acad);
											   $model->setAttribute('date_created',date('Y-m-d'));
											   $model->setAttribute('created_by',Yii::app()->user->name);
											   
											   if($model->save())
				                                 {  
				                                 	$person = $model->id;
				                                 	
				                                    $taxe = Taxes::model()->searchTaxesForPS($acad);
							     		
										             if($taxe!=null)
													   {  
													   	   $i=0;
													   	   
														  foreach($taxe as $id_taxe)
														    {     
														    	//$taxe_description = $id_taxe["id"];
														    	
													    	$modelTaxes= new Taxes();
												 	          if(isset($_POST[$id_taxe["id"]]))
												       	 	    {
												       	 	    	$taxeID=$_POST[$id_taxe["id"]];
												       	 	    																		   																					$modelPayrollSettingTaxe = new PayrollSettingTaxes;
																		      	  
																	   $modelPayrollSettingTaxe->setAttribute('id_payroll_set',$model->id);
																	   $modelPayrollSettingTaxe->setAttribute('id_taxe',$taxeID);
																			      	  
																	    $modelPayrollSettingTaxe->save();
																			      	  
																	   $modelPayrollSettingTaxe->unSetAttributes();
																	   //$modelPayrollSettingTaxe = new PayrollSettingTaxes;
																	   
																	   $modelTaxes->unSetAttributes();
																			      	
												       	 	      }
												       	 	      
												       	 	      
																			        						
													          }
																				
									                      }	
						     				                                 	
				                                 	$model->unSetAttributes();
												    $model= new PayrollSettings;
												   
												   $temwen=true;
												   
												   
										         }
										         
										 
										  }
								  	     else
								  	       {
								  	       	  if($as==0)
								  	       	      $this->message_employeeOrTeacher=true;
								  	       	  elseif($as==1)
								  	       	       $this->message_employeeOrTeacher=true;
								  	       	 }
										
							        }
							       else
							          $this->message_eitherEmployeeNorTeacher=true;
				         

										 
										 	
			                     
								   }
							   
				        }
				      else //message vous n'avez entre aucune note
						{
							$this->message_noAmountEntered=true;
							
							}
							
					
					  if($temwen)
					    {
					    	
					       $this->redirect(array('index','part'=>'payset','from'=>''));
					     }
								
					 }
					
					  	
					
			   }
			   
			   
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		$new_payroll_setting = new PayrollSettings;
		
		$this->message_eitherEmployeeNorTeacher=false;
		$this->message_notEmployee=false;
		$this->message_notTeacher=false;
		$this->message_employeeOrTeacher=false;
	  
     if(!isset($_GET['all']))
      {
		$model=$this->loadModel($id);
		
		
        }
      else
        {
                $model=new PayrollSettings;
                $condition='';
                
                        if($_GET['all']=='t')//teacher
                                 {
                                $condition='is_student=0 AND id IN(SELECT teacher FROM courses c left join room_has_person rh on(c.room=rh.room) WHERE (c.academic_period='.$acad.' OR rh.academic_year='.$acad.') ) AND active IN(1, 2) ';
                                 }
                               elseif($_GET['all']=='e')//employee
                                  { $condition='is_student=0 AND active IN(1, 2) AND p.id NOT IN(SELECT teacher FROM courses c left join room_has_person rh on(c.room=rh.room) WHERE (c.academic_period='.$acad.' OR rh.academic_year='.$acad.') ) ';
                               
                                  }
           
          }

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

	     /* if(isset($_POST['PayrollSettings']['old_new']))
			      {
                        $this->old_new = $_POST['PayrollSettings']['old_new'];
                        
                        if($this->old_new==1)
				           $model->setAttribute('old_new',1);
				        else
				            $model->setAttribute('old_new',0);
				        
                    }
                */    
		
		  if(isset($_POST['update']))
		   {	
		   	   
		   	
			if(!isset($_GET['all']))
				  {
				  	$new_payroll_setting->attributes=$_POST['PayrollSettings'];
				  	
				  	$new_payroll_setting->setAttribute('person_id',$model->person_id);
				  	//return 0 when employee, 1 when teacher; return 2 when employee-teacher; return -1 when either employee nor teacher
				  	$employee_or_teacher = Persons::model()->isEmployeeOrTeacher($new_payroll_setting->person_id, $acad);	
			  	
				  	if($employee_or_teacher!= -1)				  	 
				  	  {
				  	 	
					  	if(($employee_or_teacher==2)||($new_payroll_setting->as==$employee_or_teacher))
					  	 {
						  	
						  	      $new_payroll_setting->setAttribute('academic_year',$acad);
							  	if(($new_payroll_setting->number_of_hour!='')&&($new_payroll_setting->number_of_hour!=0))
							  	  $new_payroll_setting->setAttribute('an_hour',1);
							  
							  	$new_payroll_setting->setAttribute('person_id',$model->person_id);  
							  	$new_payroll_setting->setAttribute('old_new',1);
							  	$new_payroll_setting->setAttribute('date_created',date('Y-m-d'));
							  	$new_payroll_setting->setAttribute('created_by',Yii::app()->user->name);
							  	
							  	
//print_r('<br/><br/>*************************************************************'.$model->id.'***********'.$model->old_new.'*******'.$acad.'********'.$new_payroll_setting->person_id);
						  		if($new_payroll_setting->save())
								  {
								  	   $model->setAttribute('old_new',0);
						  	           $model->setAttribute('date_updated',date('Y-m-d'));
						  	           $model->setAttribute('updated_by',Yii::app()->user->name);
						  	           $model->save();
						  	           
						  	           $model->unSetAttributes();
				                       $model=new PayrollSettings;
				                                 	    
								  	   
								  	       $id_payroll_set=$new_payroll_setting->id;
						                   $payrollSettingTaxe=new PayrollSettingTaxes;
									 		  //supprimer tous les   de la personne ds la table 'payroll_setting_taxes'
									 //$payrollSettingTaxe::model()->deleteAll('id_payroll_set=:IdPayrollSet',array(':IdPayrollSet'=>$new_payroll_setting->id ));
		
		        	
						                  $taxe = Taxes::model()->searchTaxesForPS($acad);
									     		
							             if($taxe!=null)
										   {  
										   	   $i=0;
										   	   
											  foreach($taxe as $id_taxe)
											    {     
										    	//$taxe_description = $id_taxe["id"];
										    	
										    
									 	          if(isset($_POST[$id_taxe["id"]]))
									       	 	    {
									       	 	    	$taxeID=$_POST[$id_taxe["id"]];
									       	 	    	
														   $modelPayrollSettingTaxe = new PayrollSettingTaxes;
															      	  
														   $modelPayrollSettingTaxe->setAttribute('id_payroll_set',$new_payroll_setting->id);
														   $modelPayrollSettingTaxe->setAttribute('id_taxe',$taxeID);
																      	  
														    $modelPayrollSettingTaxe->save();
																      	  
														   $modelPayrollSettingTaxe->unSetAttributes();
														   //$modelPayrollSettingTaxe = new PayrollSettingTaxes;
														   
														  
																      	
									       	 	       }
									       	 	      
									       	 	      
																        						
										            }
																	
						                         }	
		
									  	$this->redirect(array('view','id'=>$new_payroll_setting->id,'part'=>'pay','from'=>''));
									  	
									  }
									else
									  $new_payroll_setting->setAttribute('academic_year',$acad);
								 
					  	           
					  	           
					  	          
								 
								 
								 
								 
								  
							
							}
					  	     else
					  	       {
					  	       	  if($new_payroll_setting->as==0)
					  	       	      $this->message_notEmployee=true;
					  	       	  elseif($new_payroll_setting->as==1)
					  	       	       $this->message_notTeacher=true;
					  	       	 }
							
				        }
				       else
				          $this->message_eitherEmployeeNorTeacher=true;
				         
						
				   }
				 else
					{
					
					     $this->message_noAmountEntered=false;
					   $temwen=false;
					   $person='';
					  
					 
					  
					  foreach($_POST['id_ps'] as $id)
		                 {   	   
							 	
								             $numberHour = 0;     
								           if(isset($_POST['numberHour'][$id]))
								             {   
								             	if($_POST['numberHour'][$id]!='')
								                  {    $this->an_hour=1;
								                     $numberHour = $_POST['numberHour'][$id];
								                   }
								                 else
								                     $this->an_hour=0;
								              }
											else
												$this->an_hour=0; 
								                     	
												if(isset($_POST['amount'][$id]))
								                $amount=$_POST['amount'][$id];
											
																		  		
								  	    
					                          $new_payroll_setting->setAttribute('academic_year',$acad);
											   $new_payroll_setting->setAttribute('old_new',1);
											     $new_payroll_setting->setAttribute('amount',$amount);
					                         	    $new_payroll_setting->setAttribute('an_hour',$this->an_hour);
					                         	     $new_payroll_setting->setAttribute('number_of_hour',$numberHour);
					                         	     $new_payroll_setting->setAttribute('date_created',date('Y-m-d'));
						  	                        $new_payroll_setting->setAttribute('created_by',Yii::app()->user->name);


										 if($new_payroll_setting->save())
				                                 {  	 
				                                 	
				                                 	   $model=PayrollSettings::model()->findByPk($id);
												  	   $model->setAttribute('old_new',0);
										  	           $model->setAttribute('date_updated',date('Y-m-d'));
										  	           $model->setAttribute('updated_by',Yii::app()->user->name);
										  	           $model->save(); 
										  	           
										  	            $model->unSetAttributes();
				                                 	    $model=new PayrollSettings;
						  	           
						  	                
						  	                 $person=$new_payroll_setting->id;
				                                 	
				                                 	
				                                 	
								                   $payrollSettingTaxe=new PayrollSettingTaxes;
													  //supprimer tous les   de la personne ds la table 'payroll_setting_taxes'
											 //$payrollSettingTaxe::model()->deleteAll('id_payroll_set=:IdPayrollSet',array(':IdPayrollSet'=>$new_payroll_setting->id ));
				
				        	
								                  $taxe = Taxes::model()->searchTaxesForPS($acad);
							     		
							             if($taxe!=null)
										   {  
										   	   $i=0;
										   	   
											  foreach($taxe as $id_taxe)
											    {     
										    	//$taxe_description = $id_taxe["id"];
										    	
										    	
									 	          if(isset($_POST[$id_taxe["id"]]))
									       	 	    {
									       	 	    	$taxeID=$_POST[$id_taxe["id"]];
									       	 	    	
														   $modelPayrollSettingTaxe = new PayrollSettingTaxes;
															      	  
														   $modelPayrollSettingTaxe->setAttribute('id_payroll_set',$new_payroll_setting->id);
														   $modelPayrollSettingTaxe->setAttribute('id_taxe',$taxeID);
																      	  
														    $modelPayrollSettingTaxe->save();
																      	  
														   $modelPayrollSettingTaxe->unSetAttributes();
														   
																      	
									       	 	       }
									       	 	      
									       	 	      
																        						
										            }
																	
						                         }	

				                                 	
				                                 	$new_payroll_setting->unSetAttributes();
												   $new_payroll_setting= new PayrollSettings;
												   
												   $temwen=true;
												   
												   
										         }
										 	
			                     
								   }
							   
				       
					  if($temwen)
					    {
					    	if($_GET['all']=='e')
					    	   $this->redirect(array('view','id'=>$person,'all'=>'e','part'=>'pay','from'=>''));
					    	elseif($_GET['all']=='t')
					    	   $this->redirect(array('view','id'=>$person,'all'=>'t','part'=>'pay','from'=>''));
					
					     }
								
					 }
		       
		        }
		 
		 
       

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		try {
   			 $this->loadModel($id)->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			        //header("HTTP/1.0 400 Relation Restriction");
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}



	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year'];
		
		if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
		
		$model=new PayrollSettings('search('.$acad.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PayrollSettings']))
			$model->attributes=$_GET['PayrollSettings'];
			
	                    // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','Payroll Setting: ')), null,false);
                            $this->exportCSV($model->search($acad), array(
                               
				'person.last_name',
				'person.first_name',
				'Amount',
				'anHour',
				'academicYear.name_period',
				'date_created',
                )); 
		}


		$this->render('index',array(
			'model'=>$model,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new PayrollSettings('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['PayrollSettings']))
			$model->attributes=$_GET['PayrollSettings'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


 // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','payrollSettings.csv'),
           'csvDelimiter' => ',',
           ));
        }



	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return PayrollSettings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=PayrollSettings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param PayrollSettings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='payroll-settings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
