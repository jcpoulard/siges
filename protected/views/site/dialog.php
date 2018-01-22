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


if($flashes = Yii::app()->user->getFlashes()) {
    foreach($flashes as $key => $message) {
        if($key != 'counters') {
            $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id'=>$key,
                        'options'=>array(
                            'show' => 'blind',
                            'hide' => 'explode',
                            'modal' => 'true',
                            'title' => $key,
                            'autoOpen'=>true,
                            ),
                        ));
 
            printf('<span class="dialog">%s</span>', $message);
 
            $this->endWidget('zii.widgets.jui.CJuiDialog');
        }
    }
}
 
 
?>