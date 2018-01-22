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
          
          
             
           
                  
         echo '<li class="';  if($this->part == 'schhol') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/scholarshipholder/index?part='.$this->part.'">';    
         echo Yii::t('app','Scholarship holder');
         echo'</a></li>';
         
         echo '<li class="';  if($this->part == 'payset') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/payrollSettings/index?part='.$this->part.'">';    
         echo Yii::t('app','Payroll');
         echo'</a></li>';
         
         echo '<li class="';  if($this->part == 'taxset') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/taxes/index?part='.$this->part.'">';    
         echo Yii::t('app','Taxes');
         echo'</a></li>';
         
        if( ($userid == 2)||($userid == 3) )
         { 
         echo '<li class="';  if($this->part == 'brem') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/bareme/index?part='.$this->part.'">';    
         echo Yii::t('app','IRI ');
         echo'</a></li>';
         
         }
         
         echo '<li class="';  if($this->part == 'incdes') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/otherIncomesDescription/index?part='.$this->part.'">';    
         echo Yii::t('app','Other incomes description');
         echo'</a></li>';
         
         
         echo '<li class="';  if($this->part == 'exdesc') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/chargeDescription/index?part='.$this->part.'">';    
         echo Yii::t('app','Charge descriptions');
         echo'</a></li>';
         
       
         
		 echo '<li class="';  if($this->part == 'feedes') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/billings/feesLabel/index?part='.$this->part.'">';    
         echo Yii::t('app','Fee Description');
         echo'</a></li>';				
						
		 
		 echo '<li class="';  if($this->part == 'curren') echo "active"; else echo ""; 
		 echo '"><a href="'.Yii::app()->baseUrl.'/index.php/configuration/fees/index?part='.$this->part.'">';    
         echo Yii::t('app','Fee');
         echo'</a></li>';				
						
						
		 echo '<li class="';  if($this->part == 'paymet') echo "active"; else echo ""; 
         echo '"><a href="'.Yii::app()->baseUrl.'/index.php/configuration/paymentmethod/index?part='.$this->part.'">';    
         echo Yii::t('app','Payment method');
         echo'</a></li>';
         
         

        
         

         
     
         
?>
</ul>
     
 </div>
 

<!-- </div> -->
