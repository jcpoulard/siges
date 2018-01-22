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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class BeginRequest extends CBehavior {
    // The attachEventHandler() mathod attaches an event handler to an event. 
    // So: onBeginRequest, the handleBeginRequest() method will be called.
    public function attach($owner) {
        $owner->attachEventHandler('onBeginRequest', array($this, 'handleBeginRequest'));
        
    }
    
    
 
    public function handleBeginRequest($event) {        
        $app = Yii::app();
        $user = $app->user;
       
       //Language
        if (isset($_POST['_lang']))
        {
            $app->language = $_POST['_lang'];
            $app->user->setState('_lang', $_POST['_lang']);
            $cookie = new CHttpCookie('_lang', $_POST['_lang']);
            $cookie->expire = time() + (60*60*24*365); // (1 year)
            Yii::app()->request->cookies['_lang'] = $cookie;
        }
        else if ($app->user->hasState('_lang'))
            $app->language = $app->user->getState('_lang');
        else if(isset(Yii::app()->request->cookies['_lang']))
               $app->language = Yii::app()->request->cookies['_lang']->value;
             else
                $app->language = 'fr';
      
            
    }
    

    
    
    
    
}