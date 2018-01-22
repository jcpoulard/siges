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

$this->pageTitle = Yii::t('app','Inactive people');
?>


<div id="dash">
    
    <?php echo '<h1>'.Yii::t('app','Inactive people').'</h1>'; ?>
    
    <div class="icon-dash">

      <?php

     $images = '<i class="fa fa-arrow-left"> &nbsp;'.Yii::t('app','Cancel').'</i>';

        // build the link in Yii standard

        echo CHtml::link($images,array('/reports/reportcard/generalreport')); 

   ?>

  </div>
    
    <div style="clear:both"></div>	
    
    
</div>    
 
 <div id="form">
     
     <div class="search-form" style="">
        
        <?php 
            $this->renderPartial('_search',array(
                'model'=>$model,
                ));
        ?>
        
    </div>
    
     <?php
     
     $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']); // set controller and model for that before
     $gridWidget=$this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'persons-archive-grid',
            'showTableOnEmpty'=>'true',
            'dataProvider'=>$model->searchInactiveEmployee(),
            'columns'=>array(
                    'first_name',
                    'last_name',
                    array(
                        'name'=>'gender',
                        'value'=>'$data->genders1',
                        ),

                    'status',

                    array(
                            'class'=>'CButtonColumn',

                            'header'=>CHtml::dropDownList('pageSize',$pageSize,array(10=>10,20=>20,50=>50,100=>100),array(
              'onchange'=>"$.fn.yiiGridView.update('persons-archive-grid',{ data:{pageSize: $(this).val() }})", 
)),
                    'template'=>'{view}',
                       'buttons'=>array (

                             'update'=> array(
                                    'label'=>'Update',
                                    
                                    'url'=>'Yii::app()->createUrl("persons/update?id=$data->id&pg=la")',
                                    'options'=>array( 'class'=>'icon-edit' ),
                            ),
                            'view'=>array(
                                    'label'=>'View',
                                    
                                    'url'=>'Yii::app()->createUrl("persons/viewForReport?id=$data->id&pg=la")',
                                    'options'=>array( 'class'=>'icon-search' ),
                            ),

                    ),

                    ),
            ),
    ));
     ?>
 </div>
    
    
   


