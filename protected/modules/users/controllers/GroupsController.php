<?php

/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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


class GroupsController extends Controller
{
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	public $belongs_to_profil;
	public $old_groupName;
	
	public $message_default_group_u = false;
    public $message_studentparent_group_u = false;	
    public $warning_message_for_developer = false;

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

	public function actionCreate()
	{
		$model=new Groups;

		$this->performAjaxValidation($model);

		if(isset($_POST['Groups']))
		{
			$model->attributes=$_POST['Groups'];
			$this->belongs_to_profil=$model->belongs_to_profil;            
			
		   if(isset($_POST['create']))
             {
                     if(isset($_POST['Groups']['Actions']))
                           $model->actions = $_POST['Groups']['Actions'];
                         
                        
                        $test_save = false; 
                        
                        $model->setAttribute('create_by',Yii::app()->user->name);
						$model->setAttribute('create_date',date('Y-m-d'));
                      
                        if($model->save())
                          { 
                        	
			                        unset($mod_id); 
		                            $mod_id = null;
		                            unset($modul);
		                            $modul=new GroupsHasModules;
		                           
		                            //get all modules correspondind to the choosen profil
									$mod_modules=Modules::model()->searchByProfil($this->belongs_to_profil);
									$modules= $mod_modules->getData();
		                             foreach($modules as $m)
		                              {
		                                 $mod_id = $m->id;
		                                 
		                                 $modul->setAttribute('groups_id', $model->id);
		                                 $modul->setAttribute('modules_id', $mod_id);
		                                 if($modul->save())
	                                        {  
	                                        	$modul->unSetAttributes();
									            $modul= new GroupsHasModules;
									   
									        }

		                               
		                                
		                               }

			                         
			                              $test_save = true; 
			                           
			                           
			                                            
                           $this->redirect(array('index'));
                           
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
		$this->message_default_group_u = false;
		$this->warning_message_for_developer = false;
		
		$model=$this->loadModel();
		
        $this->performAjaxValidation($model);
        
        $this->belongs_to_profil=$model->belongs_to_profil;
        $this->old_groupName= $model->group_name;
        
        //
        if(Yii::app()->user->groupid!=1)
	      {  if(($this->old_groupName=="Developer")||($this->old_groupName=="Default Group") )        
	          { $this->message_default_group_u = true;
	             
	              $url=Yii::app()->request->urlReferrer; 
	              
	              $explode_url= explode("?",substr($url,0));
	   		      	    if(isset($explode_url[1]))
			      	      {  
			      	      	$this->redirect(Yii::app()->request->urlReferrer.'&msguv=y');
			      	      	  
	                     }
			      	    else
			      	       $this->redirect($url.'?msguv=y');
			      	       
			      	       
	            }
	            
	       
        
	        if(($this->old_groupName=="Student")||($this->old_groupName=="Parent")||($this->old_groupName=="Economat ADM")||($this->old_groupName=="Administrateur systeme"))        
	           $this->message_studentparent_group_u = true;
          }
        else
           {
           	       if(($this->old_groupName=="Developer")||($this->old_groupName=="Default Group")||($this->old_groupName=="Economat ADM")||($this->old_groupName=="Administrateur systeme")||($this->old_groupName=="Student")||($this->old_groupName=="Parent"))
           	         $this->warning_message_for_developer = true;
           	
           	}
           	
           	
		$this->performAjaxValidation($model);

		if(isset($_POST['Groups']))
		{
			
			$model->attributes=$_POST['Groups'];
						
             $this->belongs_to_profil=$model->belongs_to_profil;            
			
		   if(isset($_POST['update']))
             {    
             	$test_save = false; 
             	if(Yii::app()->user->groupid!=1)
	      		 { 
	      		  if(($this->old_groupName!="Default Group"))        
                    {    
                    	if(isset($_POST['Groups']['Actions']))
                           $model->actions = $_POST['Groups']['Actions'];
                          else
                            $model->actions = null;
                            
                          
                        
                        if(($this->old_groupName=="Student")||($this->old_groupName=="Parent")||($this->old_groupName=="Economat ADM")||($this->old_groupName=="Administrateur systeme"))
                          {
                          	   $model->setAttribute('group_name', $this->old_groupName);
                               $model->setAttribute('belongs_to_profil', $this->belongs_to_profil);
                          	}
                            
                            $model->setAttribute('update_by',Yii::app()->user->name);
						    $model->setAttribute('update_date',date('Y-m-d'));
						
	                      if($model->save())
	                       { 
		                            unset($mod_id); 
		                            $mod_id = null;
		                            unset($modul);
		                            $modul=new GroupsHasModules;
		                           	                            
		                            //supprimer tous les lignes de ce groupe ds la table 'groups_has_modules'
									GroupsHasModules::model()->deleteAll('groups_id=:IdGroup',array(':IdGroup'=>$model->id,));
									//get all modules correspondind to the choosen profil
									$mod_modules=Modules::model()->searchByProfil($this->belongs_to_profil);
									$modules= $mod_modules->getData();
		                             foreach($modules as $m)
		                              {
		                                 $mod_id = $m->id;
		                                 
		                                 $modul->setAttribute('groups_id', $model->id);
		                                 $modul->setAttribute('modules_id', $mod_id);
		                                 if($modul->save())
	                                        {  
	                                        	$modul->unSetAttributes();
									            $modul= new GroupsHasModules;
									   
									        }

		                               
		                                
		                               }
		                           
		                          		                         
		                              $test_save = true; 
	
	                             
	                          
	                             $this->redirect(array('index'));
	                          }

		            }
		           else
		             { $this->message_default_group_u = true;
		                
		                 
		             }
		             
	      		  }
	      		 else
	      		   {
	      		   	       if(isset($_POST['Groups']['Actions']))
                           $model->actions = $_POST['Groups']['Actions'];
                          else
                            $model->actions = null;
                            
                          	   $model->setAttribute('group_name', $this->old_groupName);
                               $model->setAttribute('belongs_to_profil', $this->belongs_to_profil);
                          	
                            
                            $model->setAttribute('update_by',Yii::app()->user->name);
						    $model->setAttribute('update_date',date('Y-m-d'));
						
	                      if($model->save())
	                       { 
		                            unset($mod_id); 
		                            $mod_id = null;
		                            unset($modul);
		                            $modul=new GroupsHasModules;
		                            
		                            //supprimer tous les lignes de ce groupe ds la table 'groups_has_modules'
                                            GroupsHasModules::model()->deleteAll('groups_id=:IdGroup',array(':IdGroup'=>$model->id,));
									//get all modules correspondind to the choosen profil
									$mod_modules=Modules::model()->searchByProfil($this->belongs_to_profil);
									$modules= $mod_modules->getData();
		                             foreach($modules as $m)
		                              {
		                                 $mod_id = $m->id;
		                                 
		                                 $modul->setAttribute('groups_id', $model->id);
		                                 $modul->setAttribute('modules_id', $mod_id);
		                                 if($modul->save())
	                                        {  
	                                        	$modul->unSetAttributes();
									            $modul= new GroupsHasModules;
									   
									        }

		                               
		                                
		                               }
	                             $this->redirect(array('index'));
	                          }
 
	      		   	
	      		   	}//END Yii::app()->user->
	      		 
		            
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
   			 $this->message_default_group_u=false;
		
			$model=$this->loadModel();
	        
	        $groupName= $model->group_name;
	        
	        
            if(($groupName!="Developer")&&($groupName!="Default Group")&&($groupName!="Student")&&($groupName!="Parent")&&($groupName!="Economat ADM")&&($groupName!="Administrateur systeme")&&($groupName!="Pedagogie")&&($groupName!="Discipline")&&($groupName!="Administration"))        
               {  
                 $this->loadModel()->delete();
                 
               }
             else
               { $this->message_default_group_u=true;
                   $url=Yii::app()->request->urlReferrer;
		       	    
		       	    $explode_url= explode("?",$url);
            
   		      	    if($explode_url!=null)
		      	      $this->redirect($url.'?msguv=y');
		      	    else
		      	       $this->redirect($url.'&msguv=y');

                }
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
        
        

	public function actionIndex()
	{
		 if (isset($_GET['pageSize'])) {
		    Yii::app()->user->setState('pageSize',(int)$_GET['pageSize']);
		    unset($_GET['pageSize']);
			} 
			
	$model=new Groups('search');
		if(isset($_GET['Groups']))
			$model->attributes=$_GET['Groups'];

		$this->render('index',array(
			'model'=>$model,
		));
	}



//************************  loadBelongsProfil ******************************/
public function loadBelongsProfil()
	{    	     $acad=Yii::app()->session['currentId_academic_year']; 
		 
		 $result = Yii::app()->db->createCommand("select id, profil_name from profil");
         $res    = $result->query();
	    

           $code= array();
		   
		    $code[null]= Yii::t('app','-- Select --');
		    foreach($res as $r){
			    $id=$r['id'];
			    $code[$id]= $r['profil_name'];
		           
		      }
		   
		return $code;
         
	}


public function loadModel()
	{
		if($this->_model===null)
		{
			if(isset($_GET['id']))
				$this->_model=Groups::model()->findbyPk($_GET['id']);
			if($this->_model===null)
				throw new CHttpException(404, Yii::t('app', 'The requested page does not exist.'));
		}
		return $this->_model;
	}

protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='groups-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
