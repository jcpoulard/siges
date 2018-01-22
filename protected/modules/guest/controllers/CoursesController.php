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



class CoursesController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $extern=false; //pou konn si c nan view apel kreyasyon an fet
	public $student_id;

	public function filters()
	{
		return array(
			'accessControl', 
		);
	}

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

	public function actionView()
	{
		$this->render('view',array(
			'model'=>$this->loadModel(),
		));
	}

	

	public function actionAdmin()
	{$acad=Yii::app()->session['currentId_academic_year']; 
		 
		$model=new Courses('searchCourseByRoomId(4,'.$acad.')');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Courses']))
			$model->attributes=$_GET['Courses'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}



	public function actionIndex()
	{
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
		 
           
           $room_id=0;     
         
              $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                          $group_name=$group->group_name;
            if($group_name=='Student')
              {
                   $user=$this->getUserInfo();
		         	if(isset($user)&&($user!=''))
		         	    $this->student_id=$user->person_id;
              }
            elseif($group_name=='Parent')	    
		      {  //get ID of selected child  
		         if(isset($_POST['Persons']))
		           {  $pers=$_POST['Persons']['id'];
		              
		               unset(Yii::app()->session['child']);
		              //set current child variable session
					   Yii::app()->session['child']=$pers;
		            	$this->student_id=$pers;	
		            		        	           
		           }
		           else
                     $this->student_id=Yii::app()->session['child'];
		        }

                          
          	           //get room ID in which this child enrolled
                $modelRoom=Rooms::model()->getRoom($this->student_id, $acad)->getData();
                
                foreach($modelRoom as $r)
                   $room_id=$r->id;
                
             if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}     
                
                $model=new Courses('searchCourseByRoomId');
                $model->unsetAttributes();

		if(isset($_GET['Courses']))
			$model->attributes=$_GET['Courses'];
		
	

		$this->render('index',array(
			'model'=>$model,
		));
	}
	
	
	
	public function actionViewForTeacher()
	{
		
            
                if (isset($_GET['pageSize'])) {
                    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
                    unset($_GET['pageSize']);
                }
                $model=new Courses('search');
                $model->unsetAttributes();
		if(isset($_GET['Courses']))
			$model->attributes=$_GET['Courses'];
                
                // Here to export to CSV 
		if($this->isExportRequest()){
			$this->exportCSV(array(Yii::t('app','List of courses: ')), null,false);
                            $this->exportCSV($model->search(), array(
				'teacher0.last_name',
				'teacher0.first_name',
				'subject0.subject_name',
				'room0.room_name',
				'academicPeriod.name_period',
				'weight')); 
		}

		$this->render('viewForTeacher',array(
			'model'=>$model,
		));
	}
	
	
	
	
	//************************  loadChildren($userName) ******************************/
	public function loadChildren($userName)
	{     
	      $acad=Yii::app()->session['currentId_academic_year']; 
		 
		 
		  $userid = null;
		 $code= array();
          $code[null]= Yii::t('app','-- Select --');
          
          $contact=null;
          
		 if(isset(Yii::app()->user->userid))
           $userid = Yii::app()->user->userid;
                            
           $contact_ID=ContactInfo::model()->getIdContactByUserID($userid);
	       $contact_ID= $contact_ID->getData();
					                    
			     foreach($contact_ID as $c)
					{  $contact= $c->id;
                       break;					
					}
			
			if($contact!=null)       
              {
                  $modelPerson= new Persons();
					   
					  $person=$modelPerson->findAll(array('alias'=>'p',
					                             'select'=>'p.id,p.first_name, p.last_name',
					                             'join'=>'left join contact_info c on(c.person=p.id)',
												 'condition'=>'p.is_student=1 AND p.active IN(1,2) AND (c.id=:contact OR c.one_more=:contact)',
												 'params'=>array(':contact'=>$contact),
										   ));
						
						 if(isset($person)){
						     foreach($person as $child)
							    $code[$child->id]= $child->first_name.' '.$child->last_name;
						   }	   
                }
                
		   
		return $code;
		
         
	}

	public function getUserInfo()
	  {
	  	 $userid =null;
	  	 
	  	if(isset(Yii::app()->user->userid))
          {
               $userid = Yii::app()->user->userid;
           
           }
           
           
           $this->_model=User::model()->findbyPk($userid);
	  	
	  	return $this->_model;
	  	
	  	
	  	}





	public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Courses::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='courses-form')
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
	           'filename' => Yii::t('app','courses.csv'),
	           'csvDelimiter' => ',',
	           ));
	}
	
}
