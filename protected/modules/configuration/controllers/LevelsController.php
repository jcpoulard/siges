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



class LevelsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
    
	public $idLevel;
	public $section_id;
	public $cycle_id;
	public $addCycleLine=false;
	
	
	
	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

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
		$this->addCycleLine=false;
		
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
 

		$model=new Levels;
		$modelSection= new Sections;
		$modelSectionHasCycle= new SectionHasCycle;
		

		$this->performAjaxValidation($model);

		if(isset($_POST['Levels']))
		{
			$model->attributes=$_POST['Levels'];
			
			$model->section = $_POST['Levels']['section'];
			$this->section_id=$model->section;
			
			if($this->section_id!='')
			 {
				//get section name
				$section_name=$this->getSection($this->section_id);
				
				    $this->addCycleLine=true;
				
			 
			 }
			 
			 if($this->addCycleLine)
			  {
			  	  if(isset($_POST['SectionHasCycle']))
			  	   {
			  	   	 $modelSectionHasCycle->attributes = $_POST['SectionHasCycle'];
			  	   	 $this->cycle_id = $modelSectionHasCycle->cycle;
			  	   	}
			  	}
			

			
			$OK=0;
			
			if(isset($_POST['create']))
             {
             	$OK=1;
             	
             }
             if(isset($_POST['addRoom']))
             {
             	$OK=2;
             	
             }
            
             if(($OK==1)||($OK==2))
             {
             	
				$model->setAttribute('date_created',date('Y-m-d'));
				$model->setAttribute('date_updated',date('Y-m-d'));
	             $model->create_by = Yii::app()->user->name;
			
	
				if($model->save())
				  {  
				  	   if($this->addCycleLine)
			              { 
							  	 	$modelSectionHasCycle = new SectionHasCycle;
							  	 	$modelSectionHasCycle->attributes=$_POST['SectionHasCycle'];
							  	 	$modelSectionHasCycle->setAttribute('level',$model->id);
			              			$modelSectionHasCycle->setAttribute('section',$this->section_id);
			              			$modelSectionHasCycle->setAttribute('academic_year',$acad_sess);
			              			$modelSectionHasCycle->save();
							
			                }

				  	  
				  	 if($OK==1)	
					    $this->redirect(array('view','id'=>$model->id));
					 elseif($OK==2)
						 $this->redirect(array('Rooms/create?from=0&id=0&levelID='.$model->id));
					
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
		$this->addCycleLine=false;
		
$acad_sess = acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 
		
		$modelSection= new Sections;
		$modelSectionHasCycle= new SectionHasCycle;
		
		$model=$this->loadModel();

		$this->performAjaxValidation($model);
		if(isset($_GET['id']))
		  {	$idLev=$_GET['id'];
		     
		     $this->section_id=$model->section;
		     //get section name
				$section_name=$this->getSection($this->section_id);
				
				    $this->addCycleLine=true;
			
		    }

		if(isset($_POST['Levels']))
		{
			
			$model->attributes=$_POST['Levels'];
			
			$modelSection->attributes=$_POST['Sections'];
			$this->section_id=$modelSection->section_name;
			
			if($this->section_id!='')
			 {//
				//get section name
				$section_name=$this->getSection($this->section_id);
				
				    $this->addCycleLine=true;
				
				
		 
			 }
			 
			 if($this->addCycleLine)
			  {
			  	  if(isset($_POST['SectionHasCycle']))
			  	   {
			  	   	 $modelSectionHasCycle->attributes = $_POST['SectionHasCycle'];
			  	   	 $this->cycle_id = $modelSectionHasCycle->cycle;
			  	   	}
			  	}
			
			$OK=0;
			
			if(isset($_POST['update']))
             {
             	$OK=1;
             	
             }
             if(isset($_POST['addRoom']))
             {
             	$OK=2;
             	
             }
            
             if(($OK==1)||($OK==2))
             {
			
					$model->setAttribute('section',$this->section_id);
					$model->setAttribute('date_updated',date('Y-m-d'));
		            $model->update_by = Yii::app()->user->name;
			
					if($model->save())
					  {
						
						 if($this->addCycleLine)
			              { 
			              	 //load modelSectionHasCycle correspondant
			              	 $modelCHS= new SectionHasCycle;
							  	$modelCHS=SectionHasCycle::model()->getCycleBySectionIdLevelId($model->section,$model->id,$acad_sess);
							  	 
							  	if(isset($modelCHS)&&($modelCHS!=null))
							  	 { 
									$modelCHS_= new SectionHasCycle;
									
									$modelCHS_->attributes=$_POST['SectionHasCycle'];
									//
									$this->cycle_id =$modelCHS_->cycle;
									
									//
							       $command = Yii::app()->db->createCommand();
								  $command->update('section_has_cycle', array(
								   'cycle'=>$this->cycle_id,'level'=>$model->id,'section'=>$model->section ), 'section=:sect AND level=:lev AND academic_year=:year', array(':sect'=>$model->section,'lev'=>$model->id, ':year'=>$acad_sess));
		
									
																		    
							  	 }
							  	else
							  	 {
							  	 	$modelSectionHasCycle = new SectionHasCycle;
							  	 	$modelSectionHasCycle->attributes=$_POST['SectionHasCycle'];
							  	 	$modelSectionHasCycle->setAttribute('level',$model->id);
			              			$modelSectionHasCycle->setAttribute('section',$model->section);
			              			$modelSectionHasCycle->setAttribute('academic_year',$acad_sess);
			              			$modelSectionHasCycle->save();
							  	  
							  	   }
	
			              	 
			                }
							  	 	

						if($OK==1)	
						    $this->redirect(array('levels/index'));
						 elseif($OK==2)
							 $this->redirect(array('rooms/create?from=0&id=0&levelID='.$idLev));
						
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
				$this->redirect( array('index'));
			
			} catch (CDbException $e) {
			    if($e->errorInfo[1] == 1451) {
			        
			        header($_SERVER["SERVER_PROTOCOL"]." 500 Relation Restriction");
			        echo Yii::t('app',"\n\n There are dependant elements, you have to delete them first.\n\n");
			    } else {
			        throw $e;
			    }
			}


	}


	
	//************************  loadLevel ******************************
	public function loadLevel()
	{    $modelLevel= new Levels();
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}
	
	
	
//************************  loadCycle ******************************
	public function loadCycle()
	{    $modelCycle= new Cycles();
           $code= array();
		   
		  $cycles=$modelCycle->findAll();
            $code[null]= Yii::t('app','-- Select --');
		    if(isset($cycles))
			 {  foreach($cycles as $cycle){
			        $code[$cycle->id]= $cycle->cycle_description;
		           
		           }
			 }
		   
		return $code;
         
	}
	
		
	//xxxxxxxxxxxxxxx  SECTION  xxxxxxxxxxxxxxxxxxx
		
	//************************  loadSection ******************************
	public function loadSection()
	{    $modelSection= new Sections();
           $code= array();
		   
		  $modelPersonSection=$modelSection->findAll();
            
		    if(isset($modelPersonSection))
			 {  foreach($modelPersonSection as $section){
			        $code[$section->id]= $section->section_name;
		           
		           }
			 }
		   
		return $code;
         
	}
   //************************  getSection($id) ******************************
   public function getSection($id)
	{
		
		$section=Sections::model()->findByPk($id);
        
			
		       if(isset($section))
				return $section->section_name;
		
	}
	
	


public function actionIndex()
	{
		
                if (isset($_GET['pageSize'])) {
                Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                unset($_GET['pageSize']);
                }
            $model=new Levels('search');
            $model->unsetAttributes();

                
		if(isset($_GET['Levels']))
			$model->attributes=$_GET['Levels'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of levels: ')), null,false);
			
			$this->exportCSV($model->search(), array(
				'level_name',
				'previousLevel.level_name',
				)); 
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
				$this->_model=Levels::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='levels-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	// Export to CSV 
	public function behaviors() {
	   return array(
	       'exportableGrid' => array(
	           'class' => 'application.components.ExportableGridBehavior',
	           'filename' => Yii::t('app','levels.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
	
}
