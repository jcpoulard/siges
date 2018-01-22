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




class StudentOtherInfoController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	public $extern=false; //pou konn si c nan view apel update(kreyasyon) an fet
	public $idLevel;
	public $temoin_update=-1;


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
		    
		  $explode_url= explode("/",substr($_SERVER['REQUEST_URI'], 1));
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
	
		$model=new StudentOtherInfo;

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_GET['stud'])&&($_GET['stud']!=""))
           {   $this->extern=true;
                $student=$_GET['stud'];
           
           }
       else
            $this->extern=false;


		
		if(isset($_POST['StudentOtherInfo']))
		{
			$model->attributes=$_POST['StudentOtherInfo'];
			
			if(isset($_POST['LevelHasPerson']))
			  $this->idLevel=$_POST['LevelHasPerson']['level'];
			  
			  
			 
			  
			 if(isset($_POST['create']))
			  { //on vient de presser le bouton
				
				if(isset($_GET['stud'])&&($_GET['stud']!=""))
	             {   $model->setAttribute('student',$student);
	             
	               }
	               
	               
				$model->setAttribute('date_created',date('Y-m-d'));
				if($model->save())
					{	 
				  	  if($this->extern)
					   	   {   
					   	   	  $this->extern=false; 
					   	   	  $this->redirect(array('persons/viewForReport','id'=>$_GET['stud'],'pg'=>'lr','isstud'=>1,'from'=>$_GET['from']));
					   	   	 
					   	   }
					   	 else
					   	    $this->redirect(array('view','id'=>$model->id));
					   	    
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

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate()
	{
		 
		 $id_info='';
		 $this->temoin_update=0;
		if(isset($_GET['stud'])&&($_GET['stud']!=''))
		   $id_info=$this->getIdMoreInfoByStudentID($_GET['stud']);
		    
		   
		   
		      $model=$this->loadModel($id_info);
		      

		// Uncomment the following line if AJAX validation is needed
		 $this->performAjaxValidation($model);

		if(isset($_POST['StudentOtherInfo']))
		{
			$model->attributes=$_POST['StudentOtherInfo'];
			
			 if(isset($_POST['update']))
               {
                          	
					if($model->save())
						$this->redirect(array('persons/viewForReport','id'=>$_GET['stud'],'pg'=>'lr','isstud'=>1,'from'=>'stud'));
						
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
   			 $this->loadModel($id)->delete();
   			 // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			  if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
			
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
		$dataProvider=new CActiveDataProvider('StudentOtherInfo');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new StudentOtherInfo('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['StudentOtherInfo']))
			$model->attributes=$_GET['StudentOtherInfo'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

			//************************  loadLevelByIdShiftSectionId  ******************************/
	public function loadLevelByStudentId($stud_id)
	{    
       	 
		 
		  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	      $modelRoom= new Rooms();
	      $level_id=$modelRoom->findAll(array('alias'=>'r','select'=>'r.level,l.id,l.level_name',
                                     'join'=>'inner join room_has_person rh on(rh.room = r.id ) inner join levels l on(l.id=r.level) inner join academicperiods ap on(ap.id=rh.academic_year)',
                                     'condition'=>'rh.students=:stud',
                                     'order'=>'ap.date_start ASC',
                                     'params'=>array(':stud'=>$stud_id, ),
                               ));
          //load tout level de la section dans laquelle appartient l'eleve                     
			if(isset($level_id))
			 {  
			    foreach($level_id as $i){			   
					 
						       $code[$i->id]= $i->level_name;
						       
						       break;
					    
							   }						 
		    
						  }	
			
		return $code;
         
	}
	
	   public function ChangeDateFormat($d){
            if(($d!='')&&($d!='0000-00-00'))
              { $time = strtotime($d);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
               return $day.'/'.$month.'/'.$year; 
               }
             else
                return '00/00/0000';     
        }

	
	
	//************************  loadPreviousLevel  ******************************/
	public function loadPreviousLevel($idLevel)
	{    
       	  
		  $code= array();
          $code[null]= Yii::t('app','-- Select --');
	       $modelLevel= new Levels();

	      $pLevel_id=$modelLevel->findAll(array('select'=>'previous_level',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel),
                               ));
			if(isset($pLevel_id))
			 {  
			    foreach($pLevel_id as $i){			   
					 					   
					  
					  
					  $level=$modelLevel->findAll(array('select'=>'id, level_name',
												 'condition'=>'id=:levelID OR id=:IDLevel',
												 'params'=>array(':levelID'=>$i->previous_level,':IDLevel'=>$idLevel),
										   ));
						
					if(isset($level)){
						  foreach($level as $l)
						       $code[$l->id]= $l->level_name;
					    }  
							   }						 
		    
						  }	
			
		return $code;
         
	}
	

  public function getIdMoreInfoByStudentID($stud_id)
	{
		$info_id='';
		$stud_other_info=new StudentOtherInfo;
		  $info=$stud_other_info->findAll(array('select'=>'id',
												 'condition'=>'student=:stud',
												 'params'=>array(':stud'=>$stud_id),
										   ));
						
					if(isset($info)){
						  foreach($info as $i)
						       $info_id= $i->id;
					    }  
           return $info_id;
		
	}
		
	
		//************************  getRoomByStudentId($id,$acad) ******************************/
	public function getRoomByStudentId($id,$acad)
	{
		$modelRoomH=new RoomHasPerson;
		
		
		 
		$idRoom = $modelRoomH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$id,':acad'=>$acad),
                               ));
		$room = new Rooms;
      if(isset($idRoom)){           
		   $result=$room->find(array('select'=>'id,room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
						   

				if(isset($result))			   
					return $result;
				else
				return null;	
				
		  }
		  else
		    return null;
		
	}


//************************  getLevelByStudentId($id,$acad) ******************************/
	public function getLevelByStudentId($id,$acad)
	{
		
		 
		$idRoom= $this->getRoomByStudentId($id,$acad);
		
	  if(isset($idRoom)){	
		$modelRoom=new Rooms;
		$idLevel = $modelRoom->find(array('select'=>'level',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->id),
                               ));
		$level = new Levels;
        if(isset($idLevel)){
		   $result=$level->find(array('select'=>'id,level_name',
                                     'condition'=>'id=:levelID',
                                     'params'=>array(':levelID'=>$idLevel->level),
                               ));
		       if(isset($result))
				    return $result;
			    else
				    return null;
				
		   }
		  else
		     return null;
				
		}
	  else
	      return null;
		
	}
	
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return StudentOtherInfo the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=StudentOtherInfo::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param StudentOtherInfo $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='student-other-info-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
