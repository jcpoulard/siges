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

$acad_sess=acad_sess();
$acad=Yii::app()->session['currentId_academic_year']; 

?>

         <div class="box-body">
                  <div class="table-responsive">
                    <table class="table no-margin">
                      
                      <tbody>
                        
                        <tr>
                          <td colspan="4">

<?php 
$pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
$this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'general-config-grid',
	'dataProvider'=>$model->search(),
	'selectableRows' => 2,
	'showTableOnEmpty'=>'true',
	
	'columns'=>array(
		
		 array('name'=>'name', 'header'=>Yii::t('app','Name'),'htmlOptions'=>array('width'=>'200px'),),
		
        array('header' =>Yii::t('app','Item Value'), 'id'=>'itemValue', 'value' => '\'
              <input name="generalconfig[\'.$data->id.\']" value="\'.$data->item_value.\'" type=text style="width:100%%" />
          
   		   <input name="id_config[\'.$data->id.\']" type="hidden" value="\'.$data->id.\'" />
             
              \'','type'=>'raw' ),
			  'description',
                          'english_comment',
		
	),
)); ?>

  								</td>
  								
  							</tr>
  							<tr>
  							    <td colspan="4">
  							         <?php  if(!isAchiveMode($acad_sess))
  							                   echo CHtml::submitButton(Yii::t('app', 'Save'),array('name'=>'update','class'=>'btn btn-warning'));
                                            
                                              echo CHtml::submitButton(Yii::t('app', 'Cancel '),array('name'=>'cancel','class'=>'btn btn-secondary'));
                                              
                                             
                                           //back button   
                                              $url=Yii::app()->request->urlReferrer;
                                              $explode_url= explode("php",substr($url,0));
				             
                                              echo ' <a href="'.$explode_url[0].'php'.$this->back_url.'" class="btn btn-secondary">'.Yii::t('app', 'Back').'</a>';
                                          

	                                             
                                ?>

  							    </td>
  							</tr>
						 </tbody>
                    </table>
                  </div><!-- /.table-responsive -->
               <!-- /.box-body -->
                
              </div>


