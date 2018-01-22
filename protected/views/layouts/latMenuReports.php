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

$acad=Yii::app()->session['currentId_academic_year']; 
						
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
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Statistics').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						
						array('label'=>Yii::t('app','General reports'), 'url'=>array('/guest/reportcard/generalreport?from1=rpt')),
                                                
                                                   
                                          
                                            
					        ),
                                             
                                            
                                            ),
					
					)));

               }
              elseif($group_name=='Student')
                { 
                              $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Statistics').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						
						array('label'=>Yii::t('app','General reports'), 'url'=>array('/guest/reportcard/generalreport?from1=rpt')),                        
                                                   
                                           
                                            
					        ),
                                             
                                            
                                            ),
					
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
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Reports').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						array('label'=>Yii::t('app','General reports'), 'url'=>array('/reports/reportcard/generalreport?from1=rpt')),
                                                
                                                   
                             array('label'=>Yii::t('app','Periods Summary'),'url'=>array('/reports/reportcard/periodsSummary?from=rpt')),                    
                            array('label'=>Yii::t('app','Discipline'),'url'=>array('/reports/reportcard/disciplineReport?from1=rpt')),
                            
                           // array('label'=>Yii::t('app','Palmares average'),'url'=>array('/reports/reportcard/paverage?isstud=1&from1=rpt')),
                            array('label'=>Yii::t('app','List Students'),'url'=>array('/academic/persons/list','isstud'=>1,'pg'=>'lr','from'=>'rpt','mn'=>'std')),
				    
                    
					        array('label'=>Yii::t('app','Sort teachers'),'url'=>array('/academic/persons/listForReport?isstud=0&from1=rpt')),
					        array('label'=>Yii::t('app','Inactive people'),'url'=>array('/academic/persons/listArchive?from1=rpt')),
					        
					        
					         //array('label'=>Yii::t('app','Dashboard'),'url'=>array('/reports/customReport/dashboard?from1=rpt')),
					        // array('label'=>Yii::t('app','Custom report'),'url'=>array('/reports/customReport/list?from1=rpt')),
                                                
                                               
                                            
					        ),
                                             
                                            
                                            ),
					
					)));
                               
			     break;
                 
          case 'Manager':
                      $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Statistics').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						array('label'=>Yii::t('app','General reports'), 'url'=>array('/reports/reportcard/generalreport?from1=rpt')),
                                                
                                                   
                             array('label'=>Yii::t('app','Periods Summary'),'url'=>array('/reports/reportcard/periodsSummary?from=rpt')),                   
                            array('label'=>Yii::t('app','Discipline'),'url'=>array('/reports/reportcard/disciplineReport?from1=rpt')),
                            
                           // array('label'=>Yii::t('app','Palmares average'),'url'=>array('/reports/reportcard/paverage?isstud=1&from1=rpt')),
                           array('label'=>Yii::t('app','List Students'),'url'=>array('/academic/persons/list','isstud'=>1,'pg'=>'lr','from'=>'rpt','mn'=>'std')),
				    
                            array('label'=>Yii::t('app','Sort teachers'),'url'=>array('/academic/persons/listForReport?isstud=0&from1=rpt')),
					         array('label'=>Yii::t('app','Inactive people'),'url'=>array('/academic/persons/listArchive?from1=rpt')),
                                                
                                             
                                            
					        ),
                                             
                                            
                                            ),
					
					)));
					

                 break;
                 
          case 'Billing':
                       $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Statistics').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						array('label'=>Yii::t('app','General reports'), 'url'=>array('/reports/reportcard/generalreport?from1=rpt')),
                                                
                                                   
                                                
                           array('label'=>Yii::t('app','List Students'),'url'=>array('/academic/persons/list','isstud'=>1,'pg'=>'lr','from'=>'rpt','mn'=>'std')),
				    
                            array('label'=>Yii::t('app','Sort teachers'),'url'=>array('/academic/persons/listForReport?isstud=0&from1=rpt')),
					        array('label'=>Yii::t('app','List employees'),'url'=>array('/academic/persons/listForReport?from1=rpt')),
					                            
                                               
                                            
					        ),
                                             
                                            
                                            ),
					
					)));
					

                 break;
                 
          case 'Teacher':
                        $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Statistics').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						array('label'=>Yii::t('app','General reports'), 'url'=>array('/reports/reportcard/generalreport?from1=rpt')),
                                                
                                                   
                                        
                                            
					        ),
                                             
                                            
                                            ),
					
					)));
					
                 break;
                 
            

                 
          
                 
          
                 
          }

}//fen issetProfil




}







 
?>					 