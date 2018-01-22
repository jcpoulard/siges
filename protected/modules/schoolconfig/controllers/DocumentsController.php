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




// always load alternative config file for examples
//require_once('/../extensions/tcpdf/config/tcpdf_config.php');
// Include the main TCPDF library (search for installation path).
//require_once('/../extensions/tcpdf/tcpdf.php');

//Yii::import('ext.tcpdf.*');



class DocumentsController extends Controller
{
	
	
	
	public $layout='//layouts/column2';
	private $_model;
	
	public $back_url='';
	
	
	
		
	public $pathLink="";
	
		    
	
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


public function actionIndex()
	{
		$model = new Documents;
		
		$this->render('index',array(
			'model'=>$model,
		));
	}
     
	     


   
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	

  
	
	
	
}









?>