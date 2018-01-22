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



class RoomsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	
	public $back_url='';
	
	public $idLevel;
	public $idShift;
	public $section_id;

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
		$model=new Rooms;
		$modelShift= new Shifts;
		$modelLevel= new Levels;
		
				$this->performAjaxValidation($model);

		if(isset($_POST['Rooms']))
		{
			 $from=$_GET['from'];
		  if(($from==1)||($from==0))
		    {
			  if($from==1)//la creation vient de la page room
				 {
                                 $model->level = $_POST['Rooms']['level'];
                                 
                                 
                                 $this->idLevel = $model->level;
				 }
			  elseif($from==0)//la creation vient de la page level
			    {   $idLev=$_GET['levelID'];
			        
				}
		      
		       }
				
				$model->attributes=$_POST['Rooms'];
                                
				$modelShift->attributes = $_POST['Shifts']; 
				$this->idShift=$modelShift->shift_name;
							   
				
				$OK=0;
			
				if(isset($_POST['create']))
				   $OK=1;
				   
				if(isset($_POST['addNewRoom']))
                  	$OK=2;
				
				
				if(($OK==1)||($OK==2))
                  {				
						if($from==1)//la creation vient de la page room
							$model->setAttribute('level',$this->idLevel);
						elseif($from==0)//la creation vient de la page level
							  $model->setAttribute('level',$idLev);
						  
						  $model->setAttribute('shift',$this->idShift);
						  
						  
		                                 $model->setAttribute('date_created',date('Y-m-d'));
						 $model->setAttribute('date_updated',date('Y-m-d'));
		                                 $model->create_by = Yii::app()->user->name;
					
		
						if($model->save())
							{
							  if($OK==1)	
								{ if($from==0)//la creation vient de la page level
									$this->redirect(array('levels/index'));
								  elseif($from==1)//la creation vient de la page room
									  $this->redirect(array('index'));
								}
							  elseif($OK==2)
								 {  if($from==0)//la creation vient de la page level
										$this->redirect(array('Rooms/create?from=0&id=0&levelID='.$idLev));
									elseif($from==1)//la creation vient de la page room
										$this->redirect(array('Rooms/create?from=1&id=0'));
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
	{    $modelShift= new Shifts;
		$modelLevel= new Levels;
		
		$model=$this->loadModel();

		$this->performAjaxValidation($model);

		if(isset($_POST['Rooms']))
		{
			    $modelLevel->attributes=$_POST['Levels'];
			    $this->idLevel=$modelLevel->level_name;
								
				$modelShift->attributes=$_POST['Shifts']; 
				$this->idShift=$modelShift->shift_name;
							   
				
				$model->attributes=$_POST['Rooms'];
			 
			 $OK=0;
			
				if(isset($_POST['update']))
				   $OK=1;
				   
				if(isset($_POST['addNewRoom']))
                  	$OK=2;
				
				
				if(($OK==1)||($OK==2))
                  {				
			  
					  $model->setAttribute('level',$this->idLevel);
					  $model->setAttribute('shift',$this->idShift);
					  $model->setAttribute('date_updated',date('Y-m-d'));
	                  $model->update_by = Yii::app()->user->name;
			
				if($model->save())
				 {	
				           if($OK==1)	
								{ //la creation vient de la page room
									  $this->redirect(array('index'));
								}
							  elseif($OK==2)
								 {  //la creation vient de la page room
										$this->redirect(array('Rooms/create?from=1&id=0'));
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


	
	//xxxxxxxxxxxxxxx  LEVEL xxxxxxxxxxxxxxxxxxx
	//************************  loadLevel ******************************
	public function loadLevel()
	{    $modelLevel= new Levels();
           $code= array();
		   
		  $modelPersonLevel=$modelLevel->findAll();
            
		    foreach($modelPersonLevel as $level){
			    $code[$level->id]= $level->level_name;
		           
		      }
		   
		return $code;
         
	}
   //************************  getLevel($id) ******************************
   public function getLevel($id)
	{
		$level = new Levels;
		$level=Levels::model()->findByPk($id);
        
			
		    if(isset($level))
				return $level->level_name;
		
	}


	//xxxxxxxxxxxxxxx  SHIFT xxxxxxxxxxxxxxxxxxx
	//************************  loadShift ******************************
	public function loadShift()
	{    $modelShift= new Shifts();
           $code= array();
		   
		  $modelPersonShift=$modelShift->findAll();
            
		    foreach($modelPersonShift as $shift){
			    $code[$shift->id]= $shift->shift_name;
		           
		      }
		   
		return $code;
         
	}
   //************************  getShift($id) ******************************
   public function getShift($id)
	{
		
		$shift=Shifts::model()->findByPk($id);
        
			
		      if(isset($shift))
				return $shift->shift_name;
		
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
	
	
	//************************  getLevelByIdRoom($id) ******************************
	public function getLevelByIdRoom($id)
	{
		$model=new Rooms;
		$iDLevel = $model->find(array('select'=>'level',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$id),
                               ));
		$level = new Levels;
        $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$iDLevel->level),
                               ));
			
						   
				return $result;
		
	}
	
	//************************  getShiftByIdRoom($id) ******************************
	public function getShiftByIdRoom($id)
	{
		$model=new Rooms;
		$iDShift = $model->find(array('select'=>'shift',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$id),
                               ));
		$shift = new Shifts;
        $result=$shift->find(array('select'=>'id,shift_name',
                                     'condition'=>'id=:shiftID',
                                     'params'=>array(':shiftID'=>$iDShift->shift),
                               ));
						   
				return $result;
		
	}
	
	//************************  getSectionByIdRoom ******************************
	public function getSectionByIdRoom($id)
	{
		$model=new Rooms;
		$idSec = $model->find(array('select'=>'section',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$id),
                               ));
		$section = new Sections;
        $result=$section->find(array('select'=>'id,section_name',
                                     'condition'=>'id=:idSection',
                                     'params'=>array(':idSection'=>$idSec->section),
                               ));
			
						   
				return $result;
		
	}
	
	public function actionIndex()
	{
            if (isset($_GET['pageSize'])) {
            Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
            unset($_GET['pageSize']);
            }
            $model=new Rooms('search');
            $model->unsetAttributes();

            
		
		if(isset($_GET['Rooms']))
			$model->attributes=$_GET['Rooms'];
		
		// Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of rooms: ')), null,false);
			
			$this->exportCSV($model->search(), array(
				'room_name',
				'level0.level_name',
				'section0.section_name',
				'shift0.shift_name',)); 
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
				$this->_model=Rooms::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='rooms-form')
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
	           'filename' => Yii::t('app','rooms.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
}
