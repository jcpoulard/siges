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
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Billings').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						array('label'=>'<i class="fa fa-calendar"></i> '.Yii::t('app','Date of payment'), 'url'=>array('/guest/fees/index')),
					    
					    array('label'=>'<i class="fa fa-usd"></i> '.Yii::t('app','My Transactions'), 'url'=>array('/guest/billings/index')),
					    
					    					    
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
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Billings').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						array('label'=>'<i class="fa fa-usd"></i> '.Yii::t('app','My Transactions'), 'url'=>array('/guest/billings/index')),
					    
					   	array('label'=>'<i class="fa fa-calendar"></i> '.Yii::t('app','Date of payment'), 'url'=>array('/guest/fees/index')),
					    
					    				    
					        )),
					
					))); 
                     
                  
                  }
               
            }

               
               break;
               
          case 'Admin':
                  
				  $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                    
                       $group_name=$group->group_name;
					   
					   
				   if($group_name=='Administrateur systeme')
				   {
					   
					   					  $this->widget('zii.widgets.CMenu', array(
						'activeCssClass'=>'active',
						'encodeLabel'=>false,     
						'activateParents'=>true,
						'items'=>array(
						
						array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Billings').'</span>', 
						//'linkOptions'=>array('id'=>'menuBillings'),
						//'itemOptions'=>array('id'=>'itemBillings'),
						
						'items'=>array(
							
						   array('label'=>'<i class="fa fa-arrow-right"></i> '.Yii::t('app','Recettes'), 'url'=>array('/billings/billings/index/part/rec/from/stud')),
							
						   array('label'=>'<i class="fa fa-arrow-left"></i> '.Yii::t('app','Depenses'),'url'=>array('/billings/chargePaid/index/part/pay/from/stud')),
												 
						   array('label'=>'<i class="fa fa-credit-card"></i> '.Yii::t('app','Scholarship holder'),'url'=>array('/billings/scholarshipholder/index/from/bil')),
						   
						   array('label'=>'<i class="fa fa-shopping-cart"></i> '.Yii::t('app','Point of sale'),'url'=>array('/billings/sellings/create/part/pay/from/')),
						   
							
								)),
						
						))); 

					   
				   }
				  else
				   {  
					  $this->widget('zii.widgets.CMenu', array(
						'activeCssClass'=>'active',
						'encodeLabel'=>false,     
						'activateParents'=>true,
						'items'=>array(
						
						array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Billings').'</span>', 
						//'linkOptions'=>array('id'=>'menuBillings'),
						//'itemOptions'=>array('id'=>'itemBillings'),
						
						'items'=>array(
							
							array('label'=>'<i class="fa fa-arrow-right"></i> '.Yii::t('app','Recettes'), 'url'=>array('/billings/billings/index/part/rec/from/stud')),
							
						   array('label'=>'<i class="fa fa-arrow-left"></i> '.Yii::t('app','Depenses'),'url'=>array('/billings/payroll/index/part/pay/from/stud')),
												 
						   array('label'=>'<i class="fa fa-university"></i> '.Yii::t('app','Loan of Money'),'url'=>array('/billings/loanOfMoney/index/part/pay/from/stud')),
						   
						   array('label'=>'<i class="fa fa-credit-card"></i> '.Yii::t('app','Scholarship holder'),'url'=>array('/billings/scholarshipholder/index/from/bil')),
						   
						   array('label'=>'<i class="fa fa-shopping-cart"></i> '.Yii::t('app','Point of sale'),'url'=>array('/billings/sellings/create/part/pay/from/')),
						   
						   array('label'=>'<i class="fa fa-line-chart"></i> '.Yii::t('app','Report'),'url'=>array('/billings/reports/etatF?part=taxrep')),
						   
						   array('label'=>'<i class="fa fa-wrench"></i> '.Yii::t('app','Exemption'), 'url'=>array('/billings/scholarshipholder/index_exempt/from/bil')),  
						   
						   array('label'=>'<i class="fa fa-wrench"></i> '.Yii::t('app','Configuration'), 'url'=>array('/configuration/fees/index/part/rec/from/stud')),

						   
							 
							
							
								)),
						
						))); 

				    }
                 break;
                 
          case 'Manager':
                   
                   $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                    
                    
                       $group_name=$group->group_name;
           

                      $userid = Yii::app()->user->userid;
                  	    //get the person ID
			            	$personInfo = Persons::model()->getIdPersonByUserID($userid);
			            	
			            	$personInfo = $personInfo->getData();
			            	foreach($personInfo as $p)
			            	 {
			            	 	$personId = $p->id;
			            	 	}
			            	 	
			            	$last_pay_id =0;
					         $month_=0;
					         $year_=0;
					         
					          $result = Payroll::model()->getInfoLastPayrollForOne($personId);
					          if($result!=null)
					            {   $result = $result->getData();
					            	foreach($result as $r)
					            	  { $last_pay_id = $r->id;
					                
					                     $month_=$r->payroll_month;
					                     
					                     $time = strtotime($month_);
                                         $year_=date("Y",$time);
					                    
					                    
					            	  }
					             }
					            
					        
					        if($last_pay_id!=0)
					          {
					          $url = array('/billings/payroll/view/id/'.$last_pay_id.'/month_/'.$month_.'/year_/'.$year_.'/di/1/from/stud');
					          	$billings = array('label'=>'<span class="fa fa-money"> '.Yii::t('app','Payroll').'</span>', 'url'=>$url, 'visible'=>!Yii::app()->user->isGuest);
					          	
					         
					         
					           }
					         else
					           {
					           	    $billings = array('label'=>''); 
					          	
					           	 }
					         
                if($group_name=='Administration')
                 {
                   $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Billings').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						array('label'=>'<i class="fa fa-usd"></i> '.Yii::t('app','Billings '), 'url'=>array('/billings/billings/index')),
					    
					   					   					     
					   array('label'=>'<i class="fa fa-shopping-cart"></i> '.Yii::t('app','Point of sale'),'url'=>array('/billings/sellings/create/part/pay/from/')),
					   
					   array('label'=>'<i class="fa fa-line-chart"></i> '.Yii::t('app','Report'),'url'=>array('/billings/balance/balance')),  
					   
					   $billings,

					    
					    
					        )),
					
					))); 
					
                  }
                else
                  {
                  	$this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Billings').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						$billings,

					    
					    
					        )),
					
					))); 
					
					
                  	}
          
                 break;
                 
          case 'Billing':
                    
                    $group_name= '';
                     
                     if(isset(Yii::app()->user->groupid))
                       {    
		                   $groupid=Yii::app()->user->groupid;
		                   $group=Groups::model()->findByPk($groupid);
                    
                    
                          $group_name=$group->group_name;
                        }
                        
                        
                if($group_name=='Economat ADM')
                 {  
                	 $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Billings').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						array('label'=>'<i class="fa fa-arrow-right"></i> '.Yii::t('app','Recettes'), 'url'=>array('/billings/billings/index/part/rec/from/stud')),
					    
					   array('label'=>'<i class="fa fa-arrow-left"></i> '.Yii::t('app','Depenses'),'url'=>array('/billings/payroll/index/part/pay/from/stud')),
					   					     
					   array('label'=>'<i class="fa fa-university"></i> '.Yii::t('app','Loan of Money'),'url'=>array('/billings/loanOfMoney/index/part/pay/from/stud')),
					   
					   array('label'=>'<i class="fa fa-credit-card"></i> '.Yii::t('app','Scholarship holder'),'url'=>array('/billings/scholarshipholder/index/from/bil')),
					   
					   array('label'=>'<i class="fa fa-shopping-cart"></i> '.Yii::t('app','Point of sale'),'url'=>array('/billings/sellings/create/part/pay/from/')),
					   
					   array('label'=>'<i class="fa fa-line-chart"></i> '.Yii::t('app','Report'),'url'=>array('/billings/reports/etatF?part=taxrep')),  
					    
					    array('label'=>'<i class="fa fa-wrench"></i> '.Yii::t('app','Exemption'), 'url'=>array('/billings/scholarshipholder/index_exempt/from/bil')),  
						   
						array('label'=>'<i class="fa fa-wrench"></i> '.Yii::t('app','Configuration'), 'url'=>array('/configuration/fees/index/part/rec/from/stud')),   
					        )),
					
					))); 

                	}
                else
                   { 
                          $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;">  '.Yii::t('app','Billings').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						array('label'=>'<i class="fa fa-arrow-right"></i> '.Yii::t('app','Recettes'), 'url'=>array('/billings/billings/index/part/rec/from/stud')),
					    
					   array('label'=>'<i class="fa fa-arrow-left"></i> '.Yii::t('app','Depenses'),'url'=>array('/billings/payroll/index/part/pay/from/stud')),
					   					     
					   array('label'=>'<i class="fa fa-university"></i> '.Yii::t('app','Loan of Money'),'url'=>array('/billings/loanOfMoney/index/part/pay/from/stud')),
					   
					   array('label'=>'<i class="fa fa-credit-card"></i> '.Yii::t('app','Scholarship holder'),'url'=>array('/billings/scholarshipholder/index/from/bil')),
					   
					   array('label'=>'<i class="fa fa-shopping-cart"></i> '.Yii::t('app','Point of sale'),'url'=>array('/billings/sellings/create/part/pay/from/')),
					   
					   array('label'=>'<i class="fa fa-line-chart"></i> '.Yii::t('app','Report'),'url'=>array('/billings/balance/balance')),  
					    
					    
					        )),
					
					))); 

                   }
          
                 break;
                 
              case 'Teacher':  
                         $userid = Yii::app()->user->userid;
                  	    //get the person ID
			            	$personInfo = Persons::model()->getIdPersonByUserID($userid);
			            	
			            	$personInfo = $personInfo->getData();
			            	foreach($personInfo as $p)
			            	 {
			            	 	$personId = $p->id;
			            	 	}
			            	 	
			            	$last_pay_id =0;
					         $month_=0;
					         $year_=0;
					         
					          $result = Payroll::model()->getInfoLastPayrollForOne($personId);
					          if($result!=null)
					            {   $result = $result->getData();
					            	foreach($result as $r)
					            	  { $last_pay_id = $r->id;
					                
					                     $month_=$r->payroll_month;
					                     
					                     $time = strtotime($month_);
                                         $year_=date("Y",$time);
					                    
					                    
					            	  }
					             }
					            
					        
					        if($last_pay_id!=0)
					          {
					          	$url = array('/billings/payroll/view/id/'.$last_pay_id.'/month_/'.$month_.'/year_/'.$year_.'/di/1/from/emp');
					          	$title = '';
					          	
					         
					         
					           }
					         else
					           {
					           	   $url = array('');
					          	$title = Yii::t('app','No transactions.');
					          	
					          	
					           	 }
					         

                  	   $this->widget('zii.widgets.CMenu', array(
					'activeCssClass'=>'active',
					'encodeLabel'=>false,     
					'activateParents'=>true,
					'items'=>array(
					
					array('label'=>'<span class="fa fa-2y" style="font-size: 23px;"> '.Yii::t('app','Billings').'</span>', 
					//'linkOptions'=>array('id'=>'menuBillings'),
					//'itemOptions'=>array('id'=>'itemBillings'),
					
					'items'=>array(
						array('label'=>'<i class="fa "></i> '.Yii::t('app',''), 'url'=>$url),
					    
					    					    
					        )),
					
					))); 
                   
                   break;
                 
          
                 
          }

}//fen issetProfil




}



?>					 