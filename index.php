<?php 

// change the following paths if necessary

$yii=dirname(__FILE__).'/../yii/framework/yii.php';
if(!is_file($yii)){
   $yii=dirname(__FILE__).'/yii/framework/yii.php';
}



$config=dirname(__FILE__).'/protected/config/main.php';



require_once($yii);

if(is_dir("install")){
   if(!file_exists("install.siges")){
        header('Location: install/index.php');
   }
   elseif(file_exists("install.siges") && is_dir("install")){
      
                if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                    shell_exec("RD /S /Q C:\\install");
                    shell_exec("MD C:\\install");
                }
                else{
                    
                   $cmd = "rm -rf install";
                   shell_exec($cmd);
               }
       Yii::createWebApplication($config)->run();
   }
   
}else{
	
	   
	
        // remove the following lines when in production mode
        defined('YII_DEBUG') or define('YII_DEBUG',true);
        // specify how many levels of call stack should be shown in each log message
       defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
       Yii::createWebApplication($config)->run();
}



