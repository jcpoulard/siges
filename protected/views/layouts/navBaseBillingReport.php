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
						
  
	
	
	if(isset(Yii::app()->user->userid))
                        {
                            $userid = Yii::app()->user->userid;
                        }
                        else 
                        {
                            $userid = null;
                        }
                        
             
?>

 <div class="coontainer">
 
 <ul class="nav nav-tabs nav-justified">  
<?php
          
          
      $groupid=Yii::app()->user->groupid;
                   $group=Groups::model()->findByPk($groupid);
                   
                    
                    
                       $group_name=$group->group_name;
           $personId=0;

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
       
           
			         echo '<li class="';  if($this->part == 'balanc') echo "active"; else echo ""; 
			         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/balance/balance?part='.$this->part.'">';    
			         echo Yii::t('app','Balance to pay');
			         echo'</a></li>';
			         
			         				
					 echo '<li class="';  if($this->part == 'payrec') echo "active"; else echo ""; 
			         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/billings/paymentReceipt?part='.$this->part.'">';    
			         echo Yii::t('app','Payment receipt');
			         echo'</a></li>';
			         
                 }
               else
                 {
                 	 echo '<li class="';  if($this->part == 'balanc') echo "active"; else echo ""; 
			         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/balance/balance?part='.$this->part.'">';    
			         echo Yii::t('app','Balance to pay');
			         echo'</a></li>';
			         
			         
					 echo '<li class="';  if($this->part == 'payrollrec') echo "active"; else echo ""; 
			         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/payroll/receipt?part='.$this->part.'">';    
			         echo Yii::t('app','Payroll receipt');
			         echo'</a></li>';				
									
									
					 echo '<li class="';  if($this->part == 'etatf') echo "active"; else echo ""; 
			         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/reports/etatF?part='.$this->part.'">';    
			         echo Yii::t('app','Financial statement');
			         echo'</a></li>';
			         
			                     echo '<li class="';  if($this->part == 'taxrep') echo "active"; else echo ""; 
			         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/reports/taxreport?part='.$this->part.'">';    
			         echo Yii::t('app','Tax report');
			         echo'</a></li>';
			         
			                      echo '<li class="';  if($this->part == 'Fdmensuelle') echo "active"; else echo ""; 
			         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/reports/fdm?part='.$this->part.'">';    
			         echo Yii::t('app','FDM');
			         echo'</a></li>';

                                  

           
                                 

                 	}
     
         
?>
</ul>
     
 </div>
 

<!-- </div> -->
