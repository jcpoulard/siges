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
 echo CHtml::form(); ?>
    <div id="language-select">
       
        <?php 
       
        if(sizeof($languages) < 4) {
            $lastElement = end($languages);
            foreach($languages as $key=>$lang) {
                if($key != $currentLang) {
                    echo CHtml::ajaxLink($lang,'',
                        array(
                            'type'=>'post',
                            'data'=>'_lang='.$key.'&YII_CSRF_TOKEN='.Yii::app()->request->csrfToken,
                            'success' => 'function(data) {window.location.reload();}'
                        ),
                        array()
                    );
                } else echo '<b>'.$lang.'</b>';
                if($lang != $lastElement) echo ' | ';
            }
        }
        else {
            echo CHtml::dropDownList('_lang', $currentLang, $languages,
                array(
                    'submit' => '',
                    'csrf'=>true,
                )
            ); 
        }
        

         
        
        ?>
    </div>
<?php echo CHtml::endForm(); ?>


 
