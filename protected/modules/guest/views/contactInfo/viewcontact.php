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



<div id="dash">
		<div class="span3"><h2> <?php  echo ''.Yii::t('app','Contact Info').'';  ?>
</h2> </div>
    	
 </div>	


 
 <?php 

$userid = null;
if(isset(Yii::app()->user->userid))
                        {
                            $userid = Yii::app()->user->userid;
                        }
                        else 
                        {
                            $userid = null;
                        }
$userName='';
		     $group_name='';
		     
		       if(isset(Yii::app()->user->name))
		           $userName=Yii::app()->user->name;

				$groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                    
                          $group_name=$group->group_name;
						  
						  
			
if($group_name=='Parent')
  {	
	?>
	<div style="margin-bottom:80px;">
	<?php 	
	$form=$this->beginWidget('CActiveForm', array(
	'id'=>'persons-form',
	
)); 


			  	
		?>			 
		    <!--evaluation-->
			<div class="left" style="margin-right:5px;">
			<label for="student"><?php echo Yii::t('app','Child'); ?></label>
	 <?php 					
					         $modelPerson= new Persons();
							    if(isset($this->student_id))
							       echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()', 'options' => array($this->student_id=>array('selected'=>true)))); 
							    else
								  { 
									echo $form->dropDownList($modelPerson,'id',$this->loadChildren($userName), array('onchange'=> 'submit()')); 
						           }					      
				
					    						
					   ?>
				</div>
		<?php		
				
	     $this->endWidget();    		         	
		    ?>
		    </div>
		    <div style="clear:both"></div>	

	<?php    }
		      
						  
						  
						  
            if($group_name=='Parent')
              {
				  
				  
				  
				  
				  $dataProvider =ContactInfo::model()->searchByPersonId($this->student_id);
			  }
			elseif($group_name=='Student')
                { 
				   $person_ID=Persons::model()->getIdPersonByUserID($userid);
									   $person_ID= $person_ID->getData();
											                    
									     foreach($person_ID as $c)
											$person_id= $c->id;
											
				      $dataProvider =ContactInfo::model()->searchByPersonId($person_id);
				}
       		                 
				                 


 $pageSize=Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']);
       $gridWidget  = $this->widget('groupgridview.GroupGridView', array(
	'id'=>'contact-info-grid',
	'dataProvider'=>$dataProvider,
	'mergeColumns'=>array('contact_name'),
	'columns'=>array(
		
         
            		 array(
                                    'name' => 'contact_name',
                                    'value'=>'$data->contact_name',
                                    'htmlOptions'=>array('width'=>'250px'),
                                ),
		
    
            'contactRelationship.relation_name',
        
		'profession',
		
		'address',
		
		'phone',
		
		
		'email',
		
		
		array(
			'class'=>'CButtonColumn',
			
			'template'=>'',
			   'buttons'=>array (
                              

              ),
           

		),
	),
)); 
?>

