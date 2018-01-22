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



// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
Yii::setPathOfAlias('chartjs', dirname(__FILE__).'/../extensions/yii-chartjs');
Yii::setPathOfAlias('editable', dirname(__FILE__).'/../extensions/x-editable');
Yii::setPathOfAlias('groupgridview',dirname(__FILE__).'/../extensions/groupgridview');
Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.




require_once( dirname(__FILE__) . '/../components/GlobalCustomFunction.php');


return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'SIGES',
        'sourceLanguage'=>'en',
        
        
	//'language'=>'ht',
        //'theme'=>'basic',
        
        'behaviors'=>array(
           'onBeginRequest' => array(
                                      'class' => 'application.components.behaviors.BeginRequest'
                                     ),
           'onBeginRequest1' => array(
                                      'class' => 'application.components.behaviors.BeginRequest1'
                                     ),
           'onBeginAnyAction' => array(
                                      'class' => 'application.components.behaviors.BeginAnyAction'
                                     ),
        ),
        
	// preloading 'log' component
	'preload'=>array('log', 'chartjs','editable'),

	// autoloading model and component classes
	'import'=>array(
               
               
		'application.models.*',
		'application.components.*',
                'application.components.models.*',
                'application.modules.academic.components.*',
                'application.modules.academic.models.*',
                'application.modules.academic.components.models.*',
                'application.modules.academic.controllers.*',
                'application.modules.users.controllers.*',
                'application.modules.users.models.*',
                'application.modules.users.components.models.*',
                'application.modules.configuration.controllers.*',
                'application.modules.configuration.models.*',
                'application.modules.configuration.components.models.*',
                'application.modules.schoolconfig.controllers.*',
                'application.modules.schoolconfig.models.*',
                'application.modules.schoolconfig.components.models.*',
                'application.modules.billings.controllers.*',
                'application.modules.billings.models.*',
                'application.modules.billings.components.models.*',
                'application.modules.reports.controllers.*',
                'application.modules.reports.models.*',
                'application.modules.reports.components.models.*',
                'application.modules.guest.controllers.*',
                'application.modules.guest.models.*',
                'application.modules.guest.components.models.*',
                'application.modules.guest.views.*',
                'application.modules.discipline.components.models.*',
                'application.modules.discipline.controllers.*',                
                'application.modules.discipline.models.*',
                'application.modules.portal.components.models.*',
                'application.modules.portal.controllers.*',                
                'application.modules.portal.models.*',
				'application.modules.portal.views.*',
            
               // 'application.modules.srbac.controllers.SBaseController',
                'editable.*',
                'groupgridview.*',
                
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
                'academic',
                'billings',
                'configuration',
                'reports',
              
                'schoolconfig',
                'discipline',
                'portal',
               
                'users',
                'guest',
               
                
            
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'test',
                       // 'generatorPaths'=>array('ext.gtc'),
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
                    // GII Boostrap 
                    'generatorPaths'=>array(
                    'bootstrap.gii',
                ),
		),
            
         
//                'user'=>array(
//                    'debug'=> true,
//                    'modules' => array(
//				'role',
//				'profiles',
//				'messages',
//				),
//
//                ),
           		
	),

	// application components
	'components'=>array(
            // for languages selection purpose 
            'request'=>array(
            'enableCookieValidation'=>true,
            'enableCsrfValidation'=>true,
            ),
            
            // Manage session
          //comment if you need gii 
           
              'session' => array(
                        'class' => 'application.components.DbHttpSession',
                        'connectionID' => 'db',
                        'sessionTableName' => 'session',
                        'userTableName' => 'users'
                ),
           /*   * 
             */
             
           
             
             
             		
		'chartjs'=>array(
		    'class' => 'chartjs.components.ChartJs',
		),
		'editable'=>array(
		'class'=>'editable.EditableConfig',
		'form'=>'jqueryui',
		'mode'=>'inline',
		'defaults'=>array(
		'emptytext'=>'Click to edit'
		),
		),
                
                 'bootstrap'=>array(
                 'class'=>'bootstrap.components.Bootstrap',
                    ),
		
//            'authManager'=>array(
//              //  'class'=>'application.modules.srbac.components.SDbAuthManager',
//                //'class'=>'CDbAuthManager',
//                'class'=>'RDbAuthManager',
//                'connectionID'=>'db',
//                'assignmentTable'=>'auth_assignment',
//                'itemTable'=>'auth_item',
//                'itemChildTable'=>'auth_item_child',
//            ),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		
		
		// uncomment the following to use a MySQL database
		
		'db'=>require(dirname(__FILE__).'/db.php'),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),
         
         
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
            'languages'=>array('ht'=>'Kreyòl', 'fr'=>'Français', 'en_us'=>'English'),// 'fr'=>'Français'),
            'profils'=>array('emp'=>Yii::t('app','Employee'), 'teach'=>Yii::t('app','Teacher') ), 
		// this is used in contact page
		'adminEmail'=>'siges@logipam.com',
                //'session_timeout'=>$sessionTimeout,
                'defaultPageSize'=>20,
                 
	),
);