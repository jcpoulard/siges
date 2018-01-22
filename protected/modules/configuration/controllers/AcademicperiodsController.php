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




class AcademicperiodsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	
	public $message=false;
	
	public $is_year;
	

       
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

	public function accessRules()
	{
            
		$explode_url= explode("/",substr($_SERVER['REQUEST_URI'], 1));
           
                $controller = $explode_url[3];    
            
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

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	public function actionCreate()
	{
		$siges_structure = infoGeneralConfig('siges_structure_session');
		
		$model=new AcademicPeriods;
		
		$ane_avan_kreyasyon='';
		$endDate_avan_kreyasyon='';
		
		$pase =false;

		$this->performAjaxValidation($model);

	   if(isset($_POST['AcademicPeriods']))
		{
			$model->attributes=$_POST['AcademicPeriods'];
		  
		   	
		 if(isset($_POST['AcademicPeriods']['is_year']))
			         { $this->is_year=$_POST['AcademicPeriods']['is_year']; 
			         
			         } 
			         
		   if($this->is_year==0)
		    {
				   if(isset($_POST['AcademicPeriods']['year']))
				      $model->year = $_POST['AcademicPeriods']['year'];
				      
				  if($siges_structure==1)
			       {
			       	 if(isset($_POST['AcademicPeriods']['previous_academic_year']))
				      $model->previous_academic_year = $_POST['AcademicPeriods']['previous_academic_year'];
			       }
				
		     }
		   elseif($this->is_year==1)
		        {
		           if(isset($_POST['AcademicPeriods']['previous_academic_year']))
				      $model->previous_academic_year = $_POST['AcademicPeriods']['previous_academic_year'];
				      
		         }
		         		      
		   if(isset($_POST['create']))
            {
                          	
		     if((isset($_GET['from']))&&($_GET['from']=='gol'))
			   {
			   	$model->setAttribute('is_year',1);
			   	  $pase = true;
			    }
			  else
			    {
			    	if($this->is_year==1)
		             { //si c yon ane akademik ki vin apre ane sa, pa kreye l (mesaj-> tann ou boukle ane sa)
				    	$lastAcadDate=$model->denyeAneAkademikNanSistemLan();
				    	$lastAcad_endDate=$lastAcadDate['date_end'];
				    	$ane_avan_kreyasyon=$lastAcadDate['id'];
				    	$endDate_avan_kreyasyon=$lastAcadDate['date_end'];
				    	if(getYear($lastAcad_endDate) <= getYear($model->date_start))  //new year must follow old one
				    	  {   
				    	      // ..., gad si ane sa achive
				    	  	  // 	  if(isAchiveMode($lastAcadDate['id']))
				    	  	   	    // $pase = true;
				    	  	 //  	   else
				    	  	 //  	    {
				    	  	 //  	    	 $pase = false;
				    	  	   	       //message achive(flash)
				    	  	 //  	          Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Current academic year should be achive first before creating a new one.'));
				    	  
				    	     //          }
				    	     
				    	             if($model->date_start!=date('Y-m-d') )
				    	               {
				    	               	Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Start date must be today.'));
				    	               	}
				    	              else
				    	                $pase = true;

				    	   }
				    	else //si c yon ane akademik ki vin avan ane sa, gad si ane sa achive
				    	  {
				    	  	 $firstAcadDate=$model->premyeAneAkademikNanSistemLan();
				    	  	 $firstAcad_startDate=$firstAcadDate['date_start'];
				    	  	 if(getYear($firstAcad_startDate)==getYear($model->date_end)) 
				    	  	   {
				    	  	   	   // ..., gad si ane sa achive
				    	  	   	   if(isAchiveMode($firstAcadDate['id']))
				    	  	   	     $pase = true;
				    	  	   	   else
				    	  	   	     {$pase = false;
				    	  	   	       //message achive(flash)
				    	  	   	       Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Academic year should be achive first before creating an earlier one.'));
				    	  	   	      }
				    	  	   	
				    	  	   	}
				    	  	  else
				    	  	     { $pase = false;
				    	  	         Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Be accurate while creating academic year according to the current data system.'));
				    	  	       }
				    	  	 
				    	  }
				    	  	
		               }
		             else
		                $pase = true;
			    	
			      }
		
		
		if($pase)
		  {	    
		     $model->setAttribute('create_by',Yii::app()->user->name);
		     $model->setAttribute('date_created',date('Y-m-d'));
			 $model->setAttribute('date_updated',date('Y-m-d'));
			 
			
			 
			  $firstAcadDate=$model->premyeAneAkademikNanSistemLan();
												 
				$firstAcad_startDate=$firstAcadDate['date_start'];
				$firstAcad_id=$firstAcadDate['id'];
			 
			 //get the more recent academic year
			   //get  date_end of the last academic year
                            $lastAcadDate=$model->denyeAneAkademikNanSistemLan();
							 
							 $greater_date=$lastAcadDate['date_end'];
							 $greater_date_id=$lastAcadDate['id'];
							 
								
						    
					if($model->save())
						{ //check if the new academic_year is next to the past one
						  
						    //if($acad==null)
						   if($model->is_year==1) //to b sur that is a new academic year
						     {  
						    	$model->setAttribute('year',$model->id);
						        $model->save(); 
						      }
						                             
					   if((isset($_GET['from']))&&($_GET['from']=='gol'))
			             { 
						   if($model->is_year==1) //to b sur that is a new academic year
						    {  
						    	$model->setAttribute('year',$model->id);
						    	$model->setAttribute('previous_academic_year',$greater_date_id);
						    	  
						    	    $model->setAttribute('date_start',date('Y-m-d'));//date("Y-m-d", strtotime(date('Y-m-d')." - 1 day")));
						        $model->save();
						        
						        //gad si poko gen taxe ditou nan baz la pou ajoute
						        $criteria = new CDbCriteria(array('order'=>'id ASC'));
						        $modelTaxe= Taxes::model()->findAll($criteria);
						        if($modelTaxe==null)
						          {
						          	//ajoute taxes yo
						          	$command_01 = Yii::app()->db->createCommand();
										   	       
										   	       $command_01->insert('taxes', array(
														'id'=>1,
														'taxe_description'=>'IRI',
														'employeur_employe'=>0,
														'taxe_value'=>0,
														'particulier'=>0,
														'academic_year'=>$model->id,
														
													));
													
									$command_02 = Yii::app()->db->createCommand();
										   	       
										   	       $command_02->insert('taxes', array(
														'id'=>2,
														'taxe_description'=>'TMS',
														'employeur_employe'=>1,
														'taxe_value'=>1,
														'particulier'=>0,
														'academic_year'=>$model->id,
														
													));				
													
									$command_03 = Yii::app()->db->createCommand();
										   	       
										   	       $command_03->insert('taxes', array(
														'id'=>3,
														'taxe_description'=>'ONA',
														'employeur_employe'=>0,
														'taxe_value'=>6,
														'particulier'=>0,
														'academic_year'=>$model->id,
														
													));
													
									$command_04 = Yii::app()->db->createCommand();
										   	       
										   	       $command_04->insert('taxes', array(
														'id'=>4,
														'taxe_description'=>'ONA',
														'employeur_employe'=>1,
														'taxe_value'=>6,
														'particulier'=>0,
														'academic_year'=>$model->id,
														
													));				
													
									$command_05 = Yii::app()->db->createCommand();
										   	       
										   	       $command_05->insert('taxes', array(
														'id'=>5,
														'taxe_description'=>'CAS',
														'employeur_employe'=>0,
														'taxe_value'=>1,
														'particulier'=>0,
														'academic_year'=>$model->id,
														
													));								
													
									$command_06 = Yii::app()->db->createCommand();
										   	       
										   	       $command_06->insert('taxes', array(
														'id'=>6,
														'taxe_description'=>'FDU',
														'employeur_employe'=>0,
														'taxe_value'=>1,
														'particulier'=>0,
														'academic_year'=>$model->id,
														
													));				
													

						          	}
						        
						      if($greater_date_id!=0)
						        {   
						        						         
						       if(substr($greater_date,0,4)==substr($model->date_start,0,4))  //new year must follow old one
						          {
						          	  //voye enfo nan year_migration_check
						              $command_0 = Yii::app()->db->createCommand();
										   	       
										   	       $command_0->insert('year_migration_check', array(
														'period'=>0,
														'postulant'=>0,
														'course'=>0,
														'evaluation'=>0,
														'passing_grade'=>0,
														'reportcard_observation'=>0,
														'fees'=>0,
														'taxes'=>0,
														'pending_balance'=>0,
														'academic_year'=>$model->id,
														'create_by'=>Yii::app()->user->name,
		                                                'date_created'=>date('Y-m-d'),
			 
														
													));
				 		        
			 			     		   
						         														
												  
										   
										   
									    }
									    
						            }
							     
							     
							     }
							  
							  
							  
								   $this->message=false;
								   //set current academic variable session
								   Yii::app()->session['currentId_academic_year']=$model->id;
								   Yii::app()->session['currentName_academic_year']=$model->name_period;
								   
								  								   
								   if($greater_date_id!=0)
								       $this->redirect (array('/reports/reportcard/yearMigrationCheck'));
								   else
								      $this->redirect (array('/configuration/academicperiods/index'));
								     
								     
								     
								 }
			                  else
					             { 
								   
								   if($model->is_year==1) //to b sur that is a new academic year
								    {  									    	
									    	$model->setAttribute('year',$model->id);
									    	//$model->setAttribute('previous_academic_year',$model->id);sa pou ane ki vin aprel la
									        $model->save(); 
									        
									        $this->message=false;
											   //set current academic variable session
											   Yii::app()->session['currentId_academic_year']=$model->id;
											   Yii::app()->session['currentName_academic_year']=$model->name_period;
											    
									    if(substr($greater_date,0,4)==substr($model->date_start,0,4))  //new year must follow old one
								          {
								          	  
								          	  if($model->previous_academic_year!=0)
								          	    {   $command_acad_year = Yii::app()->db->createCommand();
									                  $command_acad_year->update('academicperiods', array(
																	'date_end'=>date('Y-m-d'),'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'id=:acad', array(':acad'=>$model->previous_academic_year) );
								          	    }
																
								          	  //voye enfo nan year_migration_check
								              $command_0 = Yii::app()->db->createCommand();
												   	       
												   	       $command_0->insert('year_migration_check', array(
																'period'=>0,
																'postulant'=>0,
																'course'=>0,
																'evaluation'=>0,
																'passing_grade'=>0,
																'reportcard_observation'=>0,
																'fees'=>0,
																'taxes'=>0,
																'pending_balance'=>0,
																'academic_year'=>$model->id,
																'create_by'=>Yii::app()->user->name,
				                                                'date_created'=>date('Y-m-d'),
					 
																
															));
						 		        
					 			     		   
					 			     		    $this->redirect (array('/reports/reportcard/yearMigrationCheck'));
					 			     	   }
					 			     	 else
					 			     	   {
												 if(substr($firstAcad_startDate,0,4)==substr($model->date_end,0,4))  //new year before the first one in the system
												   {
												   	  //update previous_year of the first Academic year
												   	  $command_acad_year = Yii::app()->db->createCommand();
									                  $command_acad_year->update('academicperiods', array(
																	'previous_academic_year'=>$model->id,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'id=:acad', array(':acad'=>$firstAcad_id) );
												   	  
												   	}
 
				    	  	   
					 			     	   	}
									           
										      
									 }
								   elseif($model->is_year==0)
								     {
								     	$acad_sess = acad_sess();
								     	$prosper_marc_hilaire_poulard =0;
								     	//si se premye peryod pou ane a, tou anpeche migration peryod
								     	//return id,date_start,date_end
 											$all_period = AcademicPeriods::model()->getAllPeriodInAcademicYear($acad_sess);
 											$all_period = $all_period->getData();
 											foreach($all_period as $p)
 											  {
 					 						  
 											  	 $prosper_marc_hilaire_poulard ++;
 											   }
 				

								     	 if($prosper_marc_hilaire_poulard==1) //plis ke 1 se ke li bloke deja
								     	   {
								     	   	  $command_yearMigrationCheck = Yii::app()->db->createCommand();
									           $command_yearMigrationCheck->update('year_migration_check', array(
																	'period'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
								     	 
								     	   	} 
								     	   	
								       } 
									  
									  
										   
										   
										  								   
										  
										     $this->redirect (array('index'));
								 }
							  
							
							 
							
							}
							
		             }		
							
							
							
							
           
            } 
            
             if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }              
                  
                           
			
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate()
	{
                $model=$this->loadModel();
                
            $siges_structure = infoGeneralConfig('siges_structure_session');
		 
        if($model->is_year==1)
		    $this->is_year=1;
		else
		    $this->is_year=0;

		$this->performAjaxValidation($model);

                if(isset($_POST['AcademicPeriods']))
		{
                    $model->attributes=$_POST['AcademicPeriods'];
                    
                    if(isset($_POST['AcademicPeriods']['is_year']))
			         { $this->is_year=$_POST['AcademicPeriods']['is_year']; 
			         
			         } 
			         
		   if($this->is_year==0)
		    {
				   if(isset($_POST['AcademicPeriods']['year']))
				      $model->year = $_POST['AcademicPeriods']['year'];
				
		     }
		   elseif($this->is_year==1)
		        {
		           if(isset($_POST['AcademicPeriods']['previous_academic_year']))
				      $model->previous_academic_year = $_POST['AcademicPeriods']['previous_academic_year'];
				      
		         }
			
                   // if(isset($_POST['AcademicPeriods']['year']))
                   // $model->year = $_POST['AcademicPeriods']['year'];
			
                    if(isset($_POST['update']))
                    {             	
			            $model->setAttribute('date_updated',date('Y-m-d'));
			
                        $model->update_by = Yii::app()->user->name;
		
						if($model->save())
						  {
							//si c ane akad la ki sot modifye,verifye si "date fin" an poko pase
							if($model->is_year==1)
						        {
						        	$current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
                   
                                    if($current_acad!=null)//voyel creye yon nouvel ane akad
	                                 {
	                                    if( $current_acad->date_end <= date('Y-m-d'))
						                   {
						                   	   unset(Yii::app()->session['currentId_academic_year'] );
						                   	   unset(Yii::app()->session['currentName_academic_year'] );
						                   	   
						                   	      if(Yii::app()->user->profil=='Admin')
													   $this->redirect(Yii::app()->baseUrl.'/index.php/configuration/academicperiods/create?from=gol');
												  else
												     Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Please see your the administrator to set new academic year.' ));
						                   	}
						                 else 
										   {
										   	 if($model->previous_academic_year!=0)
								          	    {   $command_acad_year = Yii::app()->db->createCommand();
									                  $command_acad_year->update('academicperiods', array(
																	'date_end'=>$model->date_start,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'id=:acad', array(':acad'=>$model->previous_academic_year) );
								          	    }
										   	 
										   	 $this->redirect (array('index'));
										   }
										    
	                                 }
									    
						        }
						      else
						        $this->redirect (array('index'));
							
						  }
				
				
          }
       
        if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
                          }    
          
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete()
	{
		
		
		try {
   			 $this->loadModel()->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(array('index'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			       
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}


	}



	public function actionIndex()
	{
            if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}
            $model=new AcademicPeriods('search');
            $model->unsetAttributes();
		if(isset($_GET['AcademicPeriods']))
			$model->attributes=$_GET['AcademicPeriods'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of academic periods: ')), null,false);
			
			$this->exportCSV($model->search(), array(
					'name_period',
					'date_start',
					'date_end',
					'is_year',
					'year0.name_period')); 
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=AcademicPeriods::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='academic-periods-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	// Behavior the create Export to CSV 
	public function behaviors() {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','academic period.csv'),
	            'csvDelimiter' => ',',
	            ));
	}
	
	
}
