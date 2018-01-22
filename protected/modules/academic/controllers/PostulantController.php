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

class PostulantController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	
	public $back_url;
	public $part;
	
	public $person_liable;
	public $person_liable_phone;
	public $idLevel;
	public $city;
	public $idPreviousLevel;
	public $previousSchool;
	public $school_date_entry;
	public $last_average;

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
            
            $actions=$this->getRulesArray($this->module->name,$controller);
          
            if($this->getModuleName($this->module->name))
                {
		            if($actions!=null)
             			 {     return array(
				              	  	array('allow',  
					                	
					                	'actions'=>array_merge($actions,array('loadPreviousLevel')),
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
		
		$model=new Postulant;

		
		$this->person_liable=''; 
		 $this->person_liable_phone='';
		 $this->city='';
		 $this->idLevel='';
		 $this->idPreviousLevel='';
		 $this->previousSchool='';
		 $this->school_date_entry='';
		 
		 
		$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

 $this->part='enrlis';
 
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Postulant']))
		{
			$model->attributes=$_POST['Postulant'];
				 
			/*	$this->city=$model->cities;
				$this->idLevel=$model->apply_for_level;
			    $this->person_liable=$model->person_liable; 
				$this->person_liable_phone=$model->person_liable_phone;
				$this->idPreviousLevel=$model->previous_level;
				$this->previousSchool=$model->previous_school;
				$this->school_date_entry=$model->school_date_entry;
			  */
			  
			 if(isset($_POST['create']))
				  { //on vient de presser le bouton
				       
				            			
						//les donnees pr person
					   $model->attributes=$_POST['Postulant'];
					   					   
				       $school_date_entry=$_POST['Postulant']['school_date_entry'];
                                       
                                       // Pour les cas d'ajax
                                       if(isset($_POST['apply_for_level'])&& isset($_POST['previous_level'])){
                                           $model->setAttribute('apply_for_level',$_POST['apply_for_level']);
                                           $model->setAttribute('previous_level',$_POST['previous_level']);
                                       }
				       if($school_date_entry=='')
				          $model->setAttribute('school_date_entry', date('Y-m-d') );
				       else
				          $model->setAttribute('school_date_entry',$school_date_entry);
					  
					   $model->setAttribute('date_created',date('Y-m-d'));
					    
					  $model->setAttribute('academic_year',$acad_sess);
					  
					  $model->setAttribute('create_by',Yii::app()->user->name);
					
					if($model->save())
						{   
							// Demarrer enregistrement champs personalisables 
							$modelCustomFieldData = new CustomFieldData;
					        $criteria_cf = new CDbCriteria; 
					        $criteria_cf->condition = "field_related_to = 'stud'";
					        $cfData = CustomField::model()->findAll($criteria_cf);
					        foreach($cfData as $cd){
					            if(isset($_POST[$cd->field_name])){
					                $customFieldValue = $_POST[$cd->field_name];
					                $modelCustomFieldData->setAttribute('field_link', $cd->id);
					                $modelCustomFieldData->setAttribute('field_data', $customFieldValue);
					                $modelCustomFieldData->setAttribute('object_id', $model->id);
					                $modelCustomFieldData->save();
					                $modelCustomFieldData->unsetAttributes();
					                $modelCustomFieldData = new CustomFieldData;
					            }
					        }
					        // Terminer Enregistrement champs personalisables
                        
                         Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.') );

                           $this->redirect(array('viewListAdmission','part'=>'enrlis'));
                           
						}
				  
				     if(isset($_POST['cancel']))
                          {
                               $this->redirect(Yii::app()->request->urlReferrer);
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
		$modelCustomFieldData = new CustomFieldData;
		
		$model=$this->loadModel($id);
		
		$this->idLevel=$model->apply_for_level;
		$this->idPreviousLevel=$model->previous_level;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Postulant']))
		{
			$model->attributes=$_POST['Postulant'];
			
			
			 if(isset($_POST['update']))
				  { //on vient de presser le bouton
				  $model->attributes=$_POST['Postulant'];
				  
				    $school_date_entry=$_POST['Postulant']['school_date_entry'];
				    
				    $model->setAttribute('school_date_entry',$school_date_entry);
				     
				      $model->setAttribute('date_updated',date('Y-m-d'));
					    
					  $model->setAttribute('update_by',Yii::app()->user->name);
					
					if($model->save())
						{ 
							
							    // Demarrer mise a jours champs personalisables 
							    $modelCustomFieldData = new CustomFieldData;
						        $criteria_cf = new CDbCriteria; 
						        $criteria_cf->condition = "field_related_to = 'stud'";
						        $cfData = CustomField::model()->findAll($criteria_cf);
						        if(isset($_GET['id'])){$id_postulant = $_GET['id'];}
						        foreach($cfData as $cd){
						            if(isset($_POST[$cd->field_name])){
						                $customFieldValue = $_POST[$cd->field_name];
						                $modelCustomFieldData = CustomFieldData::model()->loadCustomFieldValue($id_postulant,$cd->id);
						                if($modelCustomFieldData!=null){ // S'il y a deja des donnees on fait la mise a jour
						                $modelCustomFieldData->setAttribute('field_link', $cd->id);
						                $modelCustomFieldData->setAttribute('field_data', $customFieldValue);
						                $modelCustomFieldData->setAttribute('object_id', $model->id);
						                $modelCustomFieldData->save();
						                $modelCustomFieldData->unsetAttributes();
						                $modelCustomFieldData = new CustomFieldData;
						                }else{ // S'il n'y a pas de donnees on ajoute
						                $modelCustomFieldData = new CustomFieldData;
						                $modelCustomFieldData->setAttribute('field_link', $cd->id);
						                $modelCustomFieldData->setAttribute('field_data', $customFieldValue);
						                $modelCustomFieldData->setAttribute('object_id', $model->id);
						                $modelCustomFieldData->save();
						                $modelCustomFieldData->unsetAttributes();
						                $modelCustomFieldData = new CustomFieldData;
						                }
						            }
						        }
						        // Terminer mise a jour des champs personalisables                
                                                
							
							
							Yii::app()->user->setFlash(Yii::t('app','Warning'), Yii::t('app','Operation terminated successfully.') );

							if( isset($_GET['part'])&&($_GET['part']!='') )
							  { if($_GET['part']=='enrlis')
							       $this->redirect(array('viewListAdmission','part'=>'enrlis','pg'=>''));
							    elseif( $_GET['part']=='decisi')
							        $this->redirect(array('viewApprovePostulant','part'=>'decisi','pg'=>''));
							  }
							
							 
							
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

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		try {
			
			  $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
			
			   $model2delete = new Postulant;
			   
			$model2delete = $this->loadModel($id);
		    
		    $modelEnrollmentIncome= EnrollmentIncome::model()->findByAttributes(array('postulant'=>$model2delete->id,'academic_year'=>$acad_sess));
         
           if(isset($modelEnrollmentIncome)&&($modelEnrollmentIncome!=null))
            {
               //gade si date peman nan ane acad ankour la, delete peman tou
		         $prosper_marc_hilaire_poulard = isDateInAcademicRange($modelEnrollmentIncome->payment_date,$acad_sess);
		     
				     if($prosper_marc_hilaire_poulard)
				        $modelEnrollmentIncome->delete();
			
		       }
		       	
		       	
		       	$model2delete->delete();
		       	  
		       

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('viewListAdmission'));
			
		} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			       
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
		$dataProvider=new CActiveDataProvider('Postulant');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Postulant('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Postulant']))
			$model->attributes=$_GET['Postulant'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}


public function actionViewListAdmission()
	{       
	     $this->part='enrlis';
	     
	     $model=new Postulant;
		 
         $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		 
		   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
    	       		
		
					if (isset($_GET['pageSize'])) {
					Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
					unset($_GET['pageSize']);
					}
			       $model=new Postulant('search('.$acad_sess.')');
					
					 if(isset($_GET['Postulant']))
						$model->attributes=$_GET['Postulant']; 
						  // Here to export to CSV 
					if($this->isExportRequest()){
						$this->exportCSV(array(Yii::t('app','Admission list: ')), null,false);
						$this->exportCSV($model->search($acad_sess) , array(
								'last_name',
								'first_name',
								'birthday',
								'sexe',
								'status',
								'')); 
						}

						
				
			   $this->render('viewListAdmission',array(
			  'model'=>$model,
		  ));
		
	}



public function actionDecisionAdmission()
	{       
	     $this->part='decisi';
	  $acad_sess= acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
     
	     $siges_structure = infoGeneralConfig('siges_structure_session');
	     $day_for_currentYear_postulant = infoGeneralConfig('day_for_currentYear_postulant');

$previous_acad_sess= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
if($previous_acad_sess=='')	
  $previous_acad_sess=0; 
      
	     $model=new Postulant;
		 
       		 
		   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 	
		  if(isset($_POST['Postulant']))
		    {
				$model->attributes=$_POST['Postulant'];
				 
				$this->idLevel=$model->apply_for_level;
				
				
				
				 if(isset($_POST['create']))
				  { //on vient de presser le bouton
				 
					   //$this->message_noGradeEntered=false;
					   $no_decision_for_pos=true;
					   
					     if($day_for_currentYear_postulant=='')
							        $day_for_currentYear_postulant=30;
							              
							                    $nonb_de_jou = 0;
							                     $start_date = '';
							                     $acad_ifo=AcademicPeriods::model()->denyeAneAkademikNanSistemLan();
							                     $start_date = $acad_ifo['date_start'];
							                   	  //gad si 
							                   	  if($start_date!='')
											           $nonb_de_jou = date_diff ( date_create($start_date)  , date_create(date('Y-m-d') ))->format('%R%a');
					  
					  if($nonb_de_jou < $day_for_currentYear_postulant)             
					     $acad_sess = $previous_acad_sess;
					  	
					   
				/*	  foreach($_POST['id_pos'] as $id)
                        {   	   
						   if(isset($_POST['postulant'][$id])&&($_POST['postulant'][$id]!=''))
						      $no_decision_for_pos=false;
							
						}
						
					  
					if(!$no_decision_for_pos) 
						{ 
							
					 */   
					       $yon_decision_ =0;
					    
					     foreach($_POST['id_pos'] as $id)
	                        {   	   
							           if(isset($_POST['postulant'][$id])&&($_POST['postulant'][$id]!=0))
							              {  
							              	$decision =$_POST['postulant'][$id];
							                 
							                 if($decision==1)
							                   $yon_decision_=1;
							                
							                   	 
							              }
										else
											$decision=0;
											
									    
						               
								   //check if grade is higher than the course weight	
								//	if($decision != '')  	   
								//		{  									
											  $command = Yii::app()->db->createCommand();
					                          $command->update('postulant', array( 'status'=>$decision, 'create_by'=> Yii::app()->user->name), 'id=:ID', array(':ID'=>$id));
	   
										   
									// 	 }
								    
		                     
							}
							
							           
							           
							       
							             
											           
						                   if(($yon_decision_ ==1)&&($nonb_de_jou < $day_for_currentYear_postulant))
							                   {  //si poko gen 3 mwa ki pase nan ane akademik lan, aktive migrasyion an
							                     
											  	     	//update migration_check a 0 si li la
											  	     	$command_yearMigrationCheck = Yii::app()->db->createCommand();
									    				$command_yearMigrationCheck->update('year_migration_check', array(
																	'postulant'=>0,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
											  	     
							                   	 }
							                
							                if($nonb_de_jou >= $day_for_currentYear_postulant)
							                  {   //update migration_check a 1 oka ou li t a zewo
							                  
											  	     	$command_yearMigrationCheck = Yii::app()->db->createCommand();
									    				$command_yearMigrationCheck->update('year_migration_check', array(
																	'postulant'=>1,'update_by'=>Yii::app()->user->name,'date_updated'=>date('Y-m-d')
																), 'academic_year=:acad', array(':acad'=>$acad_sess) );
											  	     
							                   	 } 
							                   	 
							          	 
							                   	 
							                   	 
				   /*     }
				     */
							
							
				  }
				  
		    if(isset($_POST['cancel']))
              {
                 
                     $this->redirect(Yii::app()->request->urlReferrer);
                          
                 }
		
	      }
		
		$this->render('decisionAdmission',array(
			'model'=>$model,
		));
					
							
							
							
									
	}


public function actionViewApprovePostulant()
	{       
	     $this->part='applis';
	     
	     $model=new Postulant;
		 
          $acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		 
		   $current_acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(date('Y-m-d'));
 
    	    	 if (isset($_GET['pageSize'])) {
					Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
					unset($_GET['pageSize']);
					}
			       $model=new Postulant('searchApproved('.$acad_sess.')');
					
					 if(isset($_GET['Postulant']))
						$model->attributes=$_GET['Postulant']; 
						  // Here to export to CSV 
					if($this->isExportRequest()){
						$this->exportCSV(array(Yii::t('app','Admission list: ')), null,false);
						$this->exportCSV($model->searchApproved($acad_sess) , array(
								'last_name',
								'first_name',
								'birthday',
								'sexe',
								'status',
								'')); 
						}

						
				
			   $this->render('viewApprovePostulant',array(
			  'model'=>$model,
		  ));
		
	}




public function actionViewAdmissionDetail()
	{    
		$id=$_GET['id'];
		  
		 $model=$this->loadModel($id);
		 
		 
		$this->render('viewAdmissionDetail',array(
			'model'=>$model,
		));
		
	}
	
	
	


	

  //************************  getLevel($id) ******************************/
   public function getLevel($id)
	{
		$level = new Levels;
		
		 
		$level=Levels::model()->findByPk($id);
        
			
		    if(isset($level))
				return $level->level_name;
		
	}
		
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Postulant the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Postulant::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Postulant $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='postulant-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
		
// Behavior the create Export to CSV 
public function behaviors() 
   {
	    return array(
	        'exportableGrid' => array(
	            'class' => 'application.components.ExportableGridBehavior',
	            'filename' => Yii::t('app','postulant.csv'),
	            'csvDelimiter' => ',',
	            ));
	}

public function actionLoadPreviousLevel(){
        $modelLevel = new Levels; 
        
        $pLevel_id=$modelLevel->findAll(array('select'=>'previous_level',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>(int)$_POST['apply_for_level']),
                               ));
			if(isset($pLevel_id))
			 {  
			    foreach($pLevel_id as $i){			   
					 					   
					  
					  
					  $level=$modelLevel->findAll(array('select'=>'id, level_name',
								'condition'=>'id=:levelID OR id=:IDLevel',
								'params'=>array(':levelID'=>$i->previous_level,':IDLevel'=>(int)$_POST['apply_for_level']),
										   ));
						
					if(isset($level)){
						  foreach($level as $l)
						       $code[$l->id]= $l->level_name;
					    }  
							   }						 
		    
						  }
        
          echo CHtml::tag('option',array('value'=>null),CHtml::encode(null),true);
            $level=CHtml::listData($level,'id','level_name');
            foreach($level as $value=>$name)
            {
                echo CHtml::tag('option',
                           array('value'=>$value),CHtml::encode($name),true);
            }
        }	
	
	
	
}