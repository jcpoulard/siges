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



$acad=Yii::app()->session['currentId_academic_year'];
$room_id=0;

$model_p = new RecordPresence;
$room_ = $model_p->searchRoomWithStudent($acad);

if($room_!=null)
  $room_id = $room_->room;

						
if($acad!=null){  
							
if(isset(Yii::app()->user->profil))
{   $profil=Yii::app()->user->profil;
   switch($profil)
     {
        case 'Guest':
                  if(isset(Yii::app()->user->groupid))
            {    
                   $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                    
                          $group_name=$group->group_name;
            if($group_name=='Parent')
              {
                 $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Discipline').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						
					    array('label'=>'<i class="fa fa-clock-o"></i> '.Yii::t('app','Attendance Journal'),'url'=>array('/guest/recordInfraction/viewParent')),
					    
					   
					    
					        )),
					
					))); 
                 
               }
              elseif($group_name=='Student')
                { 
                     $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Discipline').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						
					    array('label'=>'<i class="fa fa-clock-o"></i> '.Yii::t('app','Attendance Journal'),'url'=>array('/guest/recordInfraction/view')),
					    
					    					    
					        )),
					
					))); 
                     
                  
                  }
               
            }

               
               break;
               
          case 'Admin':
                  $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Discipline').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						array('label'=>'<i class="fa fa-legal"></i> '.Yii::t('app','Infraction record'), 'url'=>array('/discipline/recordInfraction/index')),
					    
					    array('label'=>'<i class="fa fa-clock-o"></i> '.Yii::t('app','Attendance Journal'),'url'=>array('/discipline/recordPresence/admin')),
					    
					    
					    
					        )),
					
					))); 


                 break;
                 
          case 'Manager':
                  $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Discipline').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						array('label'=>'<i class="fa fa-legal"></i> '.Yii::t('app','Infraction record'), 'url'=>array('/discipline/recordInfraction/index')),
					    
					    array('label'=>'<i class="fa fa-clock-o"></i> '.Yii::t('app','Attendance Journal'),'url'=>array('/discipline/recordPresence/admin')),
					    
					   
					    
					        )),
					
					))); 


          
                 break;
                 
          case 'Billing':
          
                 break;
                 
          case 'Teacher':
          
                 break;
                 
          }

}//fen issetProfil




}



?>					 