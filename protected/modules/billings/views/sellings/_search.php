<?php
/*
 * © 2016 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

/* @var $this SellingsController */
/* @var $model Sellings */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

    
    <div class="row">
        <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                      array(
                                 'model'=>'$model',
                                 'name'=>'src_date_1',
                                 'language'=>'fr',
                                
                                 'htmlOptions'=>array('size'=>40, 'style'=>'','placeholder'=>Yii::t('app','Date Start')),
                                         'options'=>array(
                                         'showButtonPanel'=>true,
                                         'changeYear'=>true,                                      
                                         'dateFormat'=>'yy-mm-dd',
                                         'yearRange'=>'2010:2100',
                                 'changeMonth'=>true,
                                 'showButtonPane'=>true,   
                                         ),
                                 )
                         );

        ?>
        
        <?php
                $this->widget('zii.widgets.jui.CJuiDatePicker',
                      array(
                                 'model'=>'$model',
                                 'name'=>'src_date_2',
                                 'language'=>'fr',
                                // 'value'=>'src_date_1',
                                 'htmlOptions'=>array('size'=>40, 'style'=>'','placeholder'=>Yii::t('app','Date End')),
                                         'options'=>array(
                                         'showButtonPanel'=>true,
                                         'changeYear'=>true,                                      
                                         'dateFormat'=>'yy-mm-dd',
                                         'yearRange'=>'2010:2100',
                                 'changeMonth'=>true,
                                 'showButtonPane'=>true,   
                                         ),
                                 )
                         );

        ?>
        
        <?php echo CHtml::submitButton(Yii::t('app','Search')); ?>
    </div>
    
    
	

<?php $this->endWidget(); ?>

</div><!-- search-form -->