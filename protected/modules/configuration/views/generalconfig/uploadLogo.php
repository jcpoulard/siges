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
	


<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'logo-form',
	
	'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
      ),
	
)); 


        echo $this->renderPartial('_uploadLogo', array('model'=>$model,'form'=>$form));
  ?>

<?php $this->endWidget(); ?>

</div>
