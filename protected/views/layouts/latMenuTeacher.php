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
      
          case 'Admin':
                     $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,    
					'activateParents'=>true,
					'items'=>array(
					
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Working Teachers').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Working Teachers').'</span>', 'url'=>array('/academic/persons/listForReport','isstud'=>0,'from'=>'teach')),
						array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Course').'</span>','url'=>array('/schoolconfig/courses/index','isstud'=>0,'from'=>'teach')),
						array('label'=>'<span class="fa fa-phone"> '.Yii::t('app','Contact info').'</span>','url'=>array('/academic/contactInfo/index','mn'=>'std','from'=>'teach')),
					    
					        )),
					
					))); 


                 break;
                 
          case 'Manager':
                   $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,    
					'activateParents'=>true,
					'items'=>array(
					
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Working Teachers').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Working Teachers').'</span>', 'url'=>array('/academic/persons/listForReport','isstud'=>0,'from'=>'teach')),
						array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Course').'</span>','url'=>array('/schoolconfig/courses/index','isstud'=>0,'from'=>'teach')),
						array('label'=>'<span class="fa fa-phone"> '.Yii::t('app','Contact info').'</span>','url'=>array('/academic/contactInfo/index','mn'=>'std','from'=>'teach')),
					    
					        )),
					
					))); 


          
                 break;
                 
          case 'Billing':
                     $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,    
					'activateParents'=>true,
					'items'=>array(
					
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Working Teachers').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Working Teachers').'</span>', 'url'=>array('/academic/persons/listForReport','isstud'=>0,'from'=>'teach')),
						array('label'=>'<span class="fa fa-phone"> '.Yii::t('app','Contact info').'</span>','url'=>array('/academic/contactInfo/index','mn'=>'std','from'=>'teach')),
					    
					        )),
					
					))); 


                 break;
                 
          case 'Teacher':
          					
          					$this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,    
					'activateParents'=>true,
					'items'=>array(
					
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Working Teachers').'</span>', 
					//'linkOptions'=>array('id'=>'menuTeacher'),
					//'itemOptions'=>array('id'=>'itemTeacher'),
					
					'items'=>array(
						array('label'=>'<span class="fa fa-male"> '.Yii::t('app','Working Teachers').'</span>', 'url'=>array('/academic/persons/listForReport','from'=>'teach','isstud'=>0)),
						 
						//array('label'=>'<span class="fa fa-check-square-o"> '.Yii::t('app','Evaluation by period').'</span>','url'=>array('/schoolconfig/evaluationbyyear/index','from'=>'teach')),
						
						// array('label'=>'<span class="fa fa-calendar"> '.Yii::t('app','Schedules').'</span>', 'url'=>array('/schoolconfig/schedules/viewForTeacher','from'=>'teach')),
						 
						 //array('label'=>'<span class="fa fa-folder-open-o"> '.Yii::t('app','Course').'</span>','url'=>array('/schoolconfig/courses/viewForTeacher','isstud'=>0,'from'=>'teach')),
						 
						array('label'=>'<span class="fa fa-phone"> '.Yii::t('app','Contact info').'</span>','url'=>array('/academic/contactInfo/viewcontact','mn'=>'std','from'=>'teach')),
						
						
						
					   
					    
					        )),
					
					))); 
          					
          
                 break;
                 
          }

}//fen issetProfil

	
	
	
	
}




?>					 