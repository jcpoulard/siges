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
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * Menu to navigate to the configuration system.
 * 
 */
?>

<ul>
    <li><?php echo CHtml::link(Yii::t('app','Shifts'), array('shifts/index')); ?></li>
    <li><?php echo CHtml::link('Sections', array('sections/index')); ?></li>
    <li><?php echo CHtml::link('Levels', array('levels/index')); ?></li>
    <li><?php echo CHtml::link('Rooms',array('rooms/index')); ?></li>
    <li><?php echo CHtml::link('Subjects', array('subjects/index')); ?></li>
    <li><?php echo CHtml::link('Academic Periods', array('academicperiods/index')); ?></li>
    <li><?php echo CHtml::link('Periods', array('periods/index')); ?></li>
    <li><?php echo CHtml::link(Yii::t('app','Departments'),array('departments/index')); ?></li>
    <li><?php echo CHtml::link(Yii::t('app','Arrondissements'),array('arrondissements/index')); ?></li>
    <li><?php echo CHtml::link(Yii::t('app','Cities'),array('cities/index')); ?></li>
    <li><?php echo CHtml::link(Yii::t('app','Titles'),array('titles/index')); ?></li>
    <li><?php echo CHtml::link(Yii::t('app','Evaluations'),array('evaluations/index')); ?></li>
</ul


