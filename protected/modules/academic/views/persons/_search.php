
<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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

<div class="wide form">

<?php 
$form=$this->beginWidget('CActiveForm', array(
        'action'=>Yii::app()->createUrl($this->route),
        'method'=>'get',
		
		
)); ?>

       
     <div>
                         <?php echo $form->textField($model,'first_name',array('size'=>20,'maxlength'=>20, 'placeholder'=>Yii::t('app','First Name'))); ?>
						 <?php echo $form->textField($model,'last_name',array('size'=>20,'maxlength'=>20, 'placeholder'=>Yii::t('app','Last Name'))); ?>
						 <?php echo CHtml::submitButton(Yii::t('app', 'Search')); ?>
				<?php  ?>
        </div>


<?php $this->endWidget(); ?>

</div><!-- search-form -->
