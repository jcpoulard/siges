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


	
// auto-loading



class Fees extends BaseFees
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public $fee_name;
	public $fee_label;
	public $level_lname; 
	public $devise_lname; 
	public $period_academic_lname; 
	public $amount_pay;
	
	
	//public $arroondissement_name;
  public function rules()
	{
              
              return array_merge(
		    	parent::rules(), array(
			array('date_limit_payment', 'required'),
			
			array('level+fee+academic_period', 'application.extensions.uniqueMultiColumnValidator'),
			
					array('id, level, level_lname, devise_lname, period_academic_lname, academic_period, date_limit_payment, checked, fee, fee_name, amount, devise, description, date_create, date_update, create_by, update_by', 'safe', 'on'=>'search'),
									
									));
	}
	
    
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('academicPeriod','level0','devise0','fee0');

$criteria->alias='f';
    
		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('devise',$this->devise);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
                $criteria->compare('date_limit_payment',$this->date_limit_payment,true);
                $criteria->compare('f.checked',$this->checked);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('fee0.fee_label',$this->fee_name,true);
		$criteria->compare('level0.level_name', $this->level_lname, true); 
		$criteria->compare('devise0.devise_name', $this->devise_lname, true); 
		$criteria->compare('academicPeriod.name_period', $this->period_academic_lname, true); 

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}


public function search_($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('academicPeriod','level0', 'fee0');
		
		$criteria->alias='f';
		
		$criteria->condition='academic_period ='.$acad ;

		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('fee0.fee_label',$this->fee_name,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
                $criteria->compare('date_limit_payment',$this->date_limit_payment,true);
                $criteria->compare('f.checked',$this->checked);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('level0.level_name', $this->level_lname, true); 
		$criteria->compare('academicPeriod.name_period', $this->period_academic_lname, true); 
		
		$criteria->order='level0.level_name ASC, date_limit_payment ASC' ;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}

	


public function searchByLevel($level,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('academicPeriod','level0', 'fee0');
		
		$criteria->alias='f';
		
		$criteria->condition='fee0.status=1 AND level='.$level.' AND academic_period ='.$acad ;

		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('fee0.fee_label',$this->fee_name,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
                $criteria->compare('date_limit_payment',$this->date_limit_payment,true);
                $criteria->compare('f.checked',$this->checked);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('level0.level_name', $this->level_lname, true); 
		$criteria->compare('academicPeriod.name_period', $this->period_academic_lname, true); 
		
		$criteria->order='level0.level_name ASC, date_limit_payment ASC' ;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                        'pagination'=>array(
                        'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
                        ),
		));
	}

        
/*   */       
        
      public function checkDateLimitPayment($current_date,$acad)//date_du_jour >= date_limt_payment AND checked=0
        {
        	$criteria=new CDbCriteria;
		$criteria->with= array('academicPeriod','level0','fee0');
		
		$criteria->alias='f';

        $siges_structure = infoGeneralConfig('siges_structure_session');
	     
	   if($siges_structure==1)
	       $criteria->condition = 'fee0.status=1 AND (date_limit_payment<:cDate OR date_limit_payment=:cDate) AND f.checked=0 AND academicPeriod.year=:acad';
	    elseif($siges_structure==0)
	         $criteria->condition = 'fee0.status=1 AND (date_limit_payment<:cDate OR date_limit_payment=:cDate) AND f.checked=0 AND academic_period=:acad';   
	       
		$criteria->params = array( ':cDate'=>$current_date,':acad'=>$acad);
		
		$criteria->compare('id',$this->id);
		$criteria->compare('level',$this->level);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('fee0.fee_label',$this->fee_name,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
                $criteria->compare('date_limit_payment',$this->date_limit_payment,true);
                $criteria->compare('f.checked',$this->checked);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('level0.level_name', $this->level_lname, true); 
		$criteria->compare('academicPeriod.name_period', $this->period_academic_lname, true); 
		
		$criteria->order = 'date_limit_payment ASC';
		//$criteria->group = 'level,date_limit_payment';

		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
              'pagination'=>array(
        			'pageSize'=>500,
    			),          
		));

        	
        }
      
    
      public function checkDateLimitPaymentByLevel($current_date, $level,$acad)//date_du_jour >= date_limt_payment 
        {
        	$criteria=new CDbCriteria;
		$criteria->with= array('academicPeriod','level0', 'fee0');
		
		$criteria->alias='f';

$siges_structure = infoGeneralConfig('siges_structure_session');
	     
        if($siges_structure==1)
	       $criteria->condition = 'fee0.status=1 AND level=:level AND (date_limit_payment<:cDate OR date_limit_payment=:cDate)  AND academicPeriod.year=:acad';
	    elseif($siges_structure==0)
	       $criteria->condition = 'fee0.status=1 AND level=:level AND (date_limit_payment<:cDate OR date_limit_payment=:cDate)  AND academic_period=:acad';
	       
		$criteria->params = array( ':level'=>$level,':cDate'=>$current_date,':acad'=>$acad );
		
		$criteria->compare('id',$this->id,true);
		$criteria->compare('level',$this->level,true);
		$criteria->compare('fee',$this->fee,true);
		$criteria->compare('academic_period',$this->academic_period,true);
		$criteria->compare('fee0.fee_label',$this->fee_name,true);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
                $criteria->compare('date_limit_payment',$this->date_limit_payment,true);
                $criteria->compare('f.checked',$this->checked,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('level0.level_name', $this->level_lname, true); 
		$criteria->compare('academicPeriod.name_period', $this->period_academic_lname, true); 

		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=>500,
    			),  
                        
		));

        	
        }
      
 
public function getFeeStatus($fee_period_id)
 {
 	$sql='SELECT fl.status FROM fees f inner join fees_label fl on(f.fee=fl.id) WHERE f.id ='.$fee_period_id;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           foreach($result as $r)
            return $r["status"];
            
 	}
 	
    
//return 		
public function getFeeInfoByLevelAcademicperiodChecked($level, $acad, $condition_checked)
	{   	    
       $sql='SELECT f.id, f.level, f.fee, f.academic_period, f.date_limit_payment, f.checked, f.amount, f.devise, f.description, f.date_create, f.date_update, f.create_by, f.update_by  FROM fees f INNER JOIN fees_label fl ON(f.fee = fl.id) WHERE fl.status=1 AND level ='.$level.' AND academic_period='.$acad.' AND f.id NOT IN( SELECT fee_period FROM billings b INNER JOIN fees f1 ON(f1.id=b.fee_period) INNER JOIN fees_label fl1 ON(f1.fee = fl1.id) WHERE  fl1.status=1 AND  f1.level='.$level.' AND f1.academic_period='.$acad.' ) ORDER BY date_limit_payment ASC';
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
            return $result;
            
 }


      
public function searchFeesToExempt($student,$level,$acad) 
  {
  	if($student=='')
  	   $student=0;
  	if($level=='')
  	   $level=0;
  	   
  	  
  	     	$criteria=new CDbCriteria;
  	
			$criteria->alias = 'f';
			/*
			select * from fees f inner join fees_label fl on(fl.id=f.fee) inner join billings b on(b.fee_period=f.id) where (b.student=465 AND b.balance >0 AND b.fee_totally_paid=0 AND b.academic_year=17) OR (f.checked=0 AND (f.id not in(select fee from scholarship_holder sh where student=465 AND partner IS NULL AND academic_year=17 AND percentage_pay=100 ) ) ) AND level=8 AND academic_period=17 */
			
			
			//if(($student=='')&&($level==''))
			
		    $criteria->select = ' f.id, level, fl.fee_label, f.amount,f.date_limit_payment';
		    
	        $criteria->join = 'inner join fees_label fl on(fl.id=f.fee) inner join billings b on(b.fee_period=f.id)';
 			
              $criteria->condition = 'level ='.$level.' AND academic_period='.$acad.' AND ( (b.student='.$student.' AND b.balance >0 AND b.fee_totally_paid=0 AND b.academic_year='.$acad.') OR (f.checked=0 AND (f.id not in(select fee from scholarship_holder sh where student='.$student.' AND partner IS NULL AND academic_year='.$acad.' AND percentage_pay=100 )  ) )  )' ;         
			 $criteria->order = 'f.date_limit_payment ASC';
			
		    
		    		 
    return new CActiveDataProvider($this, array(
        'pagination'=>array(
        			'pageSize'=> 100,
    			),
				
		'criteria'=>$criteria,
		
		
    ));

 }


 public function getFeeAmount($student,$acad_sess,$amount)
  {
  	$previous_year= AcademicPeriods::model()->getPreviousAcademicYear($acad_sess);
  	
	  if($amount==0)
	    {
	    	 //gad si elev la gen balans ane pase ki poko peye
				$modelPendingBal=PendingBalance::model()->findAll(array('select'=>'id, balance',
					'condition'=>'student=:stud AND is_paid=0 AND academic_year=:acad',
					'params'=>array(':stud'=>$student,':acad'=>$previous_year),
					));
				//si gen pending, ajoutel nan lis apeye a			
				if( (isset($modelPendingBal))&&($modelPendingBal!=null) )
				 {
				   foreach($modelPendingBal as $bal)
					 {	
					 	return $bal->balance;
					 }
				 }
			   else
			     return 0;	
	      }
	   else
	     return $amount;
	
	
	}

 public function getTotalAmountPayOnFee($stud,$fee_id)
      {   
      	 $acad_sess = acad_sess();
      	 
      	
      	     $tot_amount =0;
      	     
      	     //al nan billings fe total kob li peye pou fe sa nan acad sa
      	        $command= Yii::app()->db->createCommand('SELECT SUM(amount_pay) as total_amount FROM billings WHERE  student='.$stud.' AND fee_period='.$fee_id.' AND academic_year='.$acad_sess);
		
					$bill_info_ = $command->queryAll();
      	     
      	        if($bill_info_!=null)
			      { 
			      	foreach($bill_info_ as $bill)
			      	 {
			      	   if($bill['total_amount']!=null)
			      	     $tot_amount = $bill['total_amount'];
			           else
	      	            $tot_amount =0;
			      	
			      	 }
			      	 
			      }
                else
	      	      $tot_amount = 0;
	      	       	      	       
      	      
			    
			    
			     return $tot_amount;
      	
      	}    

public function getAmountPayOnFee($stud,$fee_id)
      {   
      	 $currency_symbol = Yii::app()->session['currencySymbol'];
      	
      	     $tot_amount =  $currency_symbol." ".numberAccountingFormat( Fees::getTotalAmountPayOnFee($stud,$fee_id) );
      	     
      	     return $tot_amount;
      	
      	}   


    public function getAmount(){
           
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
           
            return $currency_symbol.' '.numberAccountingFormat($this->amount);
        }
 
        public function getDateLimit(){
            if($this->date_limit_payment=='0000-00-00')
                return Yii::t('app','No date payment limit');
            else
                return $this->date_limit_payment;
        }
        
        public function getFeeName(){
        	   $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 
            return Yii::t('app',$this->fee0->fee_label).' '.$this->level0->level_name.' '.$currency_symbol.' '.numberAccountingFormat($this->amount);
        }
        
        public function getSimpleFeeName(){
            return Yii::t('app',$this->fee0->fee_label).' '.$this->level0->level_name;
        }



        
public function getDateLimitPayment(){
            $time = strtotime($this->date_limit_payment);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;    
        }

	
//return TRUE if payment is already started and FALSE if not
public function isPaymentStarted($fee,$acad){
            $sql='SELECT id, student FROM billings b WHERE b.amount_pay<>0 AND b.fee_period ='.$fee.' AND b.academic_year='.$acad;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           if($result !=null)
              return true;
            else              
              return false;    
        }

	
	
	
}
