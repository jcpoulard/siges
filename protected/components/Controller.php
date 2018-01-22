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

?>
<?php



/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	//public $profil_selected;
        //public $layout='//layouts/lefty';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
        
       // public $acad = null;
       // $acad=AcademicPeriods::model()->searchCurrentAcademicPeriod(/*date('Y-m-d')*/);
        
        //public $acad = "Test"; 
        
       /**
         * This function return an array of action extract from the database using 
         * The searchActionById($id) method
         * @return an array of rules extract from the DB 
         */
         
      public $noSession = false;   

        public function getRulesArray($moduleName,$controller)
        {
                        $action_aray = array();
         if(isset(Yii::app()->user->groupid)&&(Yii::app()->user->groupid!=0))
           { 
           	
           	$a = Actions::model()->searchActionById($controller, $moduleName, Yii::app()->user->groupid);
            $action = $a->getData();
           // $action_aray[]=null;
           
            foreach($action as $ac)
                {
                 
                 $action_aray[] = $ac->action_id;
                 
                    
                }
              
            }
               return $action_aray;
            
        }
        
        public function getModulesArray()
        {
            
            $a = Modules::model()->searchModuleByGroupId();
            $module = $a->getData();
            foreach($module as $m)
                {
                    $module_array[] = $m->module_short_name;   
                }
                return $module_array;
        }
        
        public function getModuleName($mod_name)
        {
            $is_mod_exist = false; 
            foreach($this->getModulesArray() as $ma)
            {
              if($ma == $mod_name) 
              {
                  $is_mod_exist = true;
              }
            }
            return $is_mod_exist; 
        }
        
   
     
      
         
        
}