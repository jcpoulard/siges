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




class BillingsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
	private $_model;
	
	
        public $student_id; 
	public $is_b_check; 
	public $old_balance;
	public $old_student;
	
	public $message_paymentMethod=false;
	public $message_datepay=false;
	
	
	
	
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
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}


	/**
	 * Manages all models.
	 */
	
	public function actionIndex()
	{
		
		$acad=Yii::app()->session['currentId_academic_year']; 
		 
		 
			
		        $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    //$group= $group->getData();
                    
                     //foreach($group as $g)
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

       
         if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			}        
                         
                    
		$model=new Billings('searchByStudentId');
		
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Billings']))
			$model->attributes=$_GET['Billings'];
                
    
  
		$this->render('index',array(
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
	public function getLevelByStudentId($id, $acad)
	{
		//$acad=Yii::app()->session['currentId_academic_year']; 
		 
		$idRoom= $this->getRoomByStudentId($id, $acad);
		
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
	
	//xxxxxxxxxxxxxxx STUDENT  xxxxxxxxxxxxxxxxx
	    //************************  getStudent($id) ******************************/
   public function getStudent($id)
	{
		
		$student=Persons::model()->findByPk($id);
        
			
		       if(isset($student))
				return $student->first_name.' '.$student->last_name;
		
	}

	
        
        // Export to CSV 
    public function behaviors() {
        return array(
        'exportableGrid' => array(
           'class' => 'application.components.ExportableGridBehavior',
           'filename' => Yii::t('app','billings.csv'),
           'csvDelimiter' => ',',
           ));
        }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Billings the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Billings::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Billings $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='billings-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	
	
		
	// Fonction to load the fees as AJAX autocomplete 
	
	public function actionFee()
	    {
	        // search keyword from ajax
	        $q = $_GET['q'];

	        $rows = array();
			
			$stringSql = 'SELECT id, fee_name FROM fees WHERE fee_name LIKE "%'.$q.'%"'; 
			$sql = $stringSql;
	        //$sql = 'SELECT id, `fee_name` FROM fees WHERE `fee_name` LIKE "%' . $q . '%"';
	        $rows = Yii::app()->db->createCommand($sql)->queryAll();
	        if ($rows)
	            echo CJSON::encode($rows);
	    }
		
		
		public function actionSearch($term)
		     {
		          if(Yii::app()->request->isAjaxRequest && !empty($term))
		        {
		              $variants = array();
		              $criteria = new CDbCriteria;
		              $criteria->select='last_name';
		              $criteria->addSearchCondition('last_name',$term.'%',false);
		              $tags = Persons::model()->findAll($criteria);
		              if(!empty($tags))
		              {
		                foreach($tags as $tag)
		                {
		                    $variants[] = $tag->attributes['last_name'];
		                }
		              }
		              echo CJSON::encode($variants);
		        }
		        else
		            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		     }
	
}
