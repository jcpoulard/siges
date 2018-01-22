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
    <div id="profil-select">
        <?php 
        echo Yii::t("app","Profil: "); 
        if(sizeof($profil_log) < 4) {
            $lastElement = end($profil_log);
            foreach($profil_log as $key=>$prof) {
                if($key != $currentProf) {
                    echo CHtml::ajaxLink(Yii::t("app","$prof"),"",
                        array(// ajaxOptions
                            'type'=>'post',
                            'data'=>'_prof='.$key.'&YII_CSRF_TOKEN='.Yii::app()->request->csrfToken,
                           
                            'success' => 'function(data) {window.location.href = "'.Yii::app()->baseUrl.'/index.php";}'
                        ),
                        array(//htmlOptions
                           //  'href' => Yii::app()->baseUrl.'/index.php',
                           )
                    );
                } else echo '<b>'.Yii::t("app","$prof").'</b>';
                if($prof != $lastElement) echo ' | ';
            }
        }
        else {
            echo CHtml::dropDownList('_prof', $currentProf, $profil_log,
                array(
                    'submit' => '',
                    'csrf'=>true,
                )
            ); 
        }
        ?>
    </div>
<?php echo CHtml::endForm(); ?>
