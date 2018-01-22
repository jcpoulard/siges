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




/**
 * This is the model class for table "billings".
 *
 * The followings are the available columns in table 'billings':
 * @property string $id
 * @property integer $student
 * @property integer $fee
 * @property double $amount_pay
 * @property double $balance
 * @property string $date_pay
 * @property string $comments
 *
 * The followings are the available model relations:
 * @property Persons $student0
 * @property FeeLevelYear $fee0
 */
class Billings extends BaseBillings
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseBillings the static model class
	 */
	
	public $student_fullname;
	public $student_lname; 
	public $student_fname;
	public $method_fname; 
	public $fee_fname; 
	public $status; 
	public $is_only_balance;
	public $balance_to_pay;
	public $id_bill;
    public $academic_year;
    public $period_academic_lname;	
    
	 public $recettesItems;
	 
	  // Pour les besoins du dashboard 
      public $montant = null;
      public $balance_ = null;
	 
	 
	 	
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'billings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
             return array_merge(
		    	parent::rules(),
		 array(
			               array('id,date_pay', 'length', 'max'=>10),
			               array('student_fname,student_lname,student_fullname', 'length', 'max'=>40),
			               array('comments', 'length', 'max'=>255),
			               // array('date_pay','unsafe'),
                            array('id, student, academic_year, student_fullname, student_fname, student_lname, method_fname, fee_fname, fee_period, amount_to_pay, amount_pay, balance, date_pay, payment_method, comments, date_created, date_updated, created_by, updated_by', 'safe', 'on'=>'search'),
		));
	}


public function attributeLabels()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
             return array_merge(
		    	parent::attributeLabels(), array(
			               'recettesItems' =>Yii::t('app','Recettes Items'),
		));
	}		
			
				
	public function search($condition, $acad)  //il fo cree colonne academic_year ds la table BILLINGS
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.


		$criteria=new CDbCriteria;
		$criteria->with= array('student0','feePeriod','academicperiods0','paymentMethod');
		
		$criteria->condition = $condition.'b.amount_pay<>0 AND b.academic_year='.$acad.' AND rh.academic_year='.$acad;
		//$criteria->params = array( ':acad1'=>$acad,':acad2'=>$acad);
		$criteria->order = 'student0.last_name ASC, feePeriod.date_limit_payment ASC, date_pay ASC';

		$criteria->alias='b';
		$criteria->join='inner join fees f on(f.id=b.fee_period) inner join fees_label fl on(fl.id=f.fee) left join room_has_person rh on(rh.students = b.student) ';
		
		$criteria->compare('b.id',$this->id,true);
		$criteria->compare('b.academicperiods0.name_periode',$this->academic_year,true);
		$criteria->compare('student',$this->student,true);
		$criteria->compare('fee_period',$this->fee_period);
		$criteria->compare('amount_to_pay',$this->amount_to_pay);
		$criteria->compare('amount_pay',$this->amount_pay);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_pay',$this->date_pay,true);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('fl.fee_label',$this->fee_fname,true);
		$criteria->compare('paymentMethod.method_name',$this->method_fname,true);
	    
		//$criteria->compare('id',$this->id_bill, true); 

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	
	

				
public function searchByMonth($condition, $month_, $acad)  //il fo cree colonne academic_year ds la table BILLINGS
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0','feePeriod','academicperiods0','paymentMethod');
		
		$criteria->condition = 'MONTH(b.date_pay)='.$month_.' AND '.$condition.'b.amount_pay<>0 AND b.academic_year='.$acad.' AND rh.academic_year='.$acad;
		//$criteria->params = array( ':acad1'=>$acad,':acad2'=>$acad);
		$criteria->order = 'b.date_pay DESC, concat(student0.first_name,student0.last_name) ASC, feePeriod.date_limit_payment ASC';

		$criteria->alias='b';
		$criteria->join='inner join fees f on(f.id=b.fee_period) inner join fees_label fl on(fl.id=f.fee) left join room_has_person rh on(rh.students = b.student) ';
		
		$criteria->compare('b.id',$this->id,true);
		$criteria->compare('b.academicperiods0.name_periode',$this->academic_year,true);
		$criteria->compare('student',$this->student,true);
		//$criteria->compare('concat(student0.first_name," ",student0.last_name)',$this->student_fullname,true);
		$criteria->compare('fee_period',$this->fee_period);
		$criteria->compare('amount_to_pay',$this->amount_to_pay);
		$criteria->compare('amount_pay',$this->amount_pay);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_pay',$this->date_pay,true);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('fl.fee_label',$this->fee_fname,true);
		$criteria->compare('paymentMethod.method_name',$this->method_fname,true);
	    
		//$criteria->compare('id',$this->id_bill, true); 

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	

				
	public function searchForView($condition, $student,$acad) //il fo cree colonne academic_year ds la table BILLINGS
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0','feePeriod','academicperiods0','paymentMethod');
		
		$criteria->condition = $condition.'b.student='.$student.' AND b.amount_pay<>0 AND b.academic_year='.$acad.' AND rh.academic_year='.$acad;
		//$criteria->params = array( ':acad1'=>$acad,':acad2'=>$acad);
		$criteria->order = 'date_pay ASC, feePeriod.date_limit_payment ASC';

		$criteria->alias='b';
		$criteria->join='inner join fees f on(f.id=b.fee_period) inner join fees_label fl on(fl.id=f.fee) left join room_has_person rh on(rh.students = b.student) ';
		
		$criteria->compare('b.id',$this->id,true);
		$criteria->compare('b.academicperiods0.name_periode',$this->academic_year,true);
		$criteria->compare('student',$this->student,true);
		$criteria->compare('fee_period',$this->fee_period);
		$criteria->compare('amount_to_pay',$this->amount_to_pay);
		$criteria->compare('amount_pay',$this->amount_pay);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_pay',$this->date_pay,true);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('fl.fee_label',$this->fee_fname,true);
		$criteria->compare('paymentMethod.method_name',$this->method_fname,true);
	    
		//$criteria->compare('id',$this->id_bill, true); 

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	
	

	
	public function searchByStudentId($condition, $stud_id,$acad)  //il fo cree colonne academic_year ds la table BILLINGS
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0','feePeriod','academicperiods0','paymentMethod');
        
        $criteria->condition = 'b.amount_pay<>0 AND '.$condition.'b.student='.$stud_id.' AND b.academic_year='.$acad.' AND rh.academic_year='.$acad;
	    

		$criteria->alias='b';
		$criteria->join='inner join fees f on(f.id=b.fee_period) inner join fees_label fl on(fl.id=f.fee) left join room_has_person rh on(rh.students = b.student) ';
		
		$criteria->compare('b.id',$this->id,true);
		$criteria->compare('academicperiods0.name_period',$this->academic_year,true);
		$criteria->compare('student',$this->student,true);
		$criteria->compare('fee_period',$this->fee_period);
		$criteria->compare('amount_to_pay',$this->amount_to_pay);
		$criteria->compare('amount_pay',$this->amount_pay);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_pay',$this->date_pay,true);
		$criteria->compare('payment_method',$this->payment_method);
		$criteria->compare('comments',$this->comments,true);
		$criteria->compare('b.date_created',$this->date_created,true);
		$criteria->compare('b.date_updated',$this->date_updated,true);
		$criteria->compare('b.created_by',$this->created_by,true);
		$criteria->compare('b.updated_by',$this->updated_by,true);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('fl.fee_label',$this->fee_fname,true);
		$criteria->compare('paymentMethod.method_name',$this->method_fname,true);
	    
	    //$criteria->params = array( ':stud'=>$stud_id, ':acad1'=>$acad,':acad2'=>$acad);
		
		
		$criteria->order='b.date_pay ASC, b.id ASC'; 
		 
		 		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	

	
	
	public function searchForBalance($id_stud) 
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0','feePeriod','paymentMethod');

		$criteria->alias='b';
		//$criteria->join='inner join fees f on(f.id=b.fee_period) inner join fees_label fl on(fl.id=f.fee) left join room_has_person rh on(rh.students = b.student) ';
		
		$criteria->condition = '((b.amount_to_pay=b.balance)) AND b.student=:stud';
		$criteria->params = array( ':stud'=>$id_stud);
		
		$criteria->compare('b.id',$this->id,true);
		$criteria->compare('b.academicperiods0.name_periode',$this->academic_year,true);
		$criteria->compare('b.student',$this->student,true);
		$criteria->compare('b.fee_period',$this->fee_period,true);
		$criteria->compare('b.amount_to_pay',$this->amount_to_pay,true);
		$criteria->compare('b.amount_pay',$this->amount_pay,true);
		$criteria->compare('b.balance',$this->balance,true);
		$criteria->compare('b.date_pay',$this->date_pay,true);
		$criteria->compare('b.payment_method',$this->payment_method);
		$criteria->compare('b.comments',$this->comments,true);
		$criteria->compare('b.date_created',$this->date_created,true);
		$criteria->compare('b.date_updated',$this->date_updated,true);
		$criteria->compare('b.created_by',$this->created_by,true);
		$criteria->compare('b.updated_by',$this->updated_by,true);
		$criteria->compare('b.student0.first_name',$this->student_fname,true);
		$criteria->compare('b.student0.last_name',$this->student_lname,true);
		//$criteria->compare('fl.fee_label',$this->fee_fname,true);
		//$criteria->compare('fl.status',$this->status,true);
		$criteria->compare('feePeriod.fee0.status',$this->status,true);
		$criteria->compare('b.paymentMethod.method_name',$this->method_fname,true);
		


		return new CActiveDataProvider($this, array(
						
			'criteria'=>$criteria,
		)); 
	}
	
	
	public function searchForBalance2($id_stud) 
	{
		// Warning: Please modify the following id to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0','feePeriod','paymentMethod');

		$criteria->alias='b';
		//$criteria->join='inner join fees f on(f.id=b.fee_period) inner join fees_label fl on(fl.id=f.fee) left join room_has_person rh on(rh.students = b.student) ';
		
		$criteria->condition = '((b.balance > 0) AND (b.amount_to_pay<>b.balance) ) AND fee_totally_paid=0 AND b.student=:stud';
		$criteria->params = array( ':stud'=>$id_stud);
		
		$criteria->order = 'b.id DESC';
		
		
		
		$criteria->compare('b.id',$this->id,true);
		$criteria->compare('b.academicperiods0.name_periode',$this->academic_year,true);
		$criteria->compare('b.student',$this->student,true);
		$criteria->compare('b.fee_period',$this->fee_period,true);
		$criteria->compare('b.amount_to_pay',$this->amount_to_pay,true);
		$criteria->compare('b.amount_pay',$this->amount_pay,true);
		$criteria->compare('b.balance',$this->balance,true);
		$criteria->compare('b.date_pay',$this->date_pay,true);
		$criteria->compare('b.payment_method',$this->payment_method);
		$criteria->compare('b.comments',$this->comments,true);
		$criteria->compare('b.date_created',$this->date_created,true);
		$criteria->compare('b.date_updated',$this->date_updated,true);
		$criteria->compare('b.created_by',$this->created_by,true);
		$criteria->compare('b.updated_by',$this->updated_by,true);
		$criteria->compare('b.student0.first_name',$this->student_fname,true);
		$criteria->compare('b.student0.last_name',$this->student_lname,true);
		//$criteria->compare('fl.fee_label',$this->fee_fname,true);
		//$criteria->compare('fl.status',$this->status,true);
		$criteria->compare('feePeriod.fee0.status',$this->status,true);
		$criteria->compare('b.paymentMethod.method_name',$this->method_fname,true);
		
$criteria->limit = 1;

		return new CActiveDataProvider($this, array(
						
			'criteria'=>$criteria,
		)); 
	}

	
   public function checkForBalance($stud, $fee_period, $status, $acad_year){
            
			$bill = new Billings;
		        $result=$bill->find(array( 'alias'=>'b',
				                           'select'=>'b.id, b.amount_pay, b.balance',
				                           'join'=>'inner join fees f on(b.fee_period=f.id) inner join fees_label fl on(f.fee=fl.id) ',
				                           'condition'=>'fl.status=:status AND b.student=:stud AND b.fee_period=:fee AND b.academic_year=:acad order by b.id DESC ',
		                                    'params'=>array(':status'=>$status, ':stud'=>$stud,':fee'=>$fee_period,':acad'=>$acad_year, ),
		                               ));
		
						return $result; 
        }
	

   public function getPreviousFeeBalance($stud, $level,$date_limit_fee, $acad_year){
            
		     $fee_period =0; 
		  
		   $sql='select f.id from fees f  where f.date_limit_payment<\''.$date_limit_fee.'\' AND f.level='.$level.' AND f.academic_period='.$acad_year.' order by f.date_limit_payment DESC ';
		      		      
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           if($result!=null)
             {  foreach($result as $r)
                 {  $fee_period = $r["id"];
                   break;
                 }
             }
           
	  
		$bill = new Billings;
		        $result=$bill->find(array( 'alias'=>'b',
				                           'select'=>'b.id, b.amount_pay, b.balance',
				                           'join'=>'inner join fees f on(b.fee_period=f.id) inner join fees_label fl on(f.fee=fl.id) ',
				                           'condition'=>'b.student=:stud AND b.fee_period=:fee AND b.academic_year=:acad order by b.id DESC ',
		                                    'params'=>array(':stud'=>$stud,':fee'=>$fee_period,':acad'=>$acad_year, ),
		                               ));
		
						return $result;
						
						
        }
	



    public function searchStat($acad){   //il fo cree colonne academic_year ds la table BILLINGS
                    $criteria = new CDbCriteria;
//SELECT student, SUM(grade_value) as max_grade FROM `grades` WHERE evaluation like(1) GROUP BY student ORDER BY max_grade			
		$criteria->condition = 'h.academic_year=:acad1 AND g.academic_year=:acad2';//rooms.shift=:idShift AND rooms.section=:idSection AND rooms.level=:idLevel AND rooms.id=:roomId AND evaluation like(:evaluation)';
		$criteria->params = array(':acad1' => $acad,':acad2'=>$acad,);//':idLevel'=>$level,':roomId'=>$room,':evaluation'=>$evaluation_id);
		
		$criteria->alias = 'g';
		$criteria->select = 'SUM(g.amount_to_pay) as amount';
		$criteria->join = 'left join room_has_person h on (g.student = h.students) ';//left join rooms on (h.room=rooms.id)';//shift, level and room
		$criteria->group = 'fee_period';
		//$criteria->order = 'amount DESC';
  
  return new CActiveDataProvider($this, array(
                    
			'pagination'=>array(
    			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
			),
			
			'criteria'=>$criteria, 
			
        ));
}
	


//return a double as balance		
public function updateMainBalance($student, $acad)
	{   	    
       $sql='SELECT SUM(b.balance) as sum_balance FROM billings b WHERE b.student ='.$student.' AND b.academic_year='.$acad;
		  $result = Yii::app()->db->createCommand($sql)->queryAll();
           
           foreach($result as $r)
            return $r["sum_balance"];
            
 }



    public function getAjaxStudents($acad)
    {
        // search keyword from ajax
        $q = $_GET['q'];

        $rows = array();

       // $sql = 'SELECT id, `name` FROM city WHERE `name` LIKE "%' . $q . '%"';
		 $sql = 'SELECT p.id, CONCAT(p.first_name," ",p.last_name) as name FROM persons p left join room_has_person rh on (p.id=rh.students) WHERE `p.last_name` LIKE "%' . $q . '%" AND p.is_student = 1 AND rh.academic_year='.$acad;
        $rows = Yii::app()->db->createCommand($sql)->queryAll();
		return $rows; 
        //if ($rows)
        //    echo CJSON::encode($rows);
    }
	
	 
	//return a integer (id)
	public function getLastTransactionID($student, $condition_fee_status, $acad)
	  {
	  	  
	  	  $sql = "SELECT  b.id, f.date_limit_payment FROM billings b INNER JOIN fees f ON(b.fee_period= f.id) INNER JOIN fees_label fl ON(f.fee=fl.id) WHERE ".$condition_fee_status." b.student=".$student." AND (b.amount_to_pay <> b.balance) AND b.academic_year=".$acad.' ORDER BY f.date_limit_payment ASC';
										
          $command = Yii::app()->db->createCommand($sql);
 
           $result = $command->queryAll();
           
           $last_payment_date = null;
           $last_id = null;
           
           if($result!=null)
             {
             	 
             	 foreach($result as $r)
             	  { 
             	  	if($last_payment_date==null)
             	  	  { $last_payment_date=  $r['date_limit_payment'];
             	  	     $last_id = $r['id'];
             	  	   }
             	  	   if($last_payment_date < $r['date_limit_payment'])
             	  	     { $last_payment_date=  $r['date_limit_payment'];
             	  	        $last_id = $r['id'];
             	  	     }
             	  	   else
             	  	     {   if($last_id < $r['id'])
             	  	     	       $last_id = $r['id'];
             	  	     	
             	  	     	}
             	   
               	  }
               	  
               	 return $last_id;
             	  
             }
           else
             return  null;
             
            
     }

	//return a integer (id)
public function getLastTransactionIdByFeeId($student, $fee_id, $acad)
	  {
	  	  
	  	  $sql = "SELECT  b.id, f.date_limit_payment FROM billings b INNER JOIN fees f ON(b.fee_period= f.id) WHERE f.id=".$fee_id." AND b.student=".$student." AND (b.amount_to_pay <> b.balance) AND b.academic_year=".$acad.' ORDER BY f.date_limit_payment ASC';
										
          $command = Yii::app()->db->createCommand($sql);
 
           $result = $command->queryAll();
           
           $last_payment_date = null;
           $last_id = null;
           
           if($result!=null)
             {
             	 
             	 foreach($result as $r)
             	  { 
             	  	if($last_payment_date==null)
             	  	  { $last_payment_date=  $r['date_limit_payment'];
             	  	     $last_id = $r['id'];
             	  	   }
             	  	   if($last_payment_date < $r['date_limit_payment'])
             	  	     { $last_payment_date=  $r['date_limit_payment'];
             	  	        $last_id = $r['id'];
             	  	     }
             	  	   else
             	  	     {   if($last_id < $r['id'])
             	  	     	       $last_id = $r['id'];
             	  	     	
             	  	     	}
             	   
               	  }
               	  
               	 return $last_id;
             	  
             }
           else
             return  null;
             
            
     }


//return id_fee, fee_name
	public function searchPaidFeesByStudentId($student, $status, $acad)
	  {
	  	  $p_date = null;
          
	  	  $sql = "SELECT DISTINCT fee_period as id_fee, fl.fee_label FROM billings INNER JOIN fees f ON(fee_period = f.id) INNER JOIN fees_label fl ON(f.fee=fl.id)  WHERE fl.status=".$status." AND student=".$student." AND balance <= 0 AND academic_period=".$acad;
										
          $command = Yii::app()->db->createCommand($sql);
 
           $result = $command->queryAll();
           
                        
           return $result;
           
	  	}
	  	


//return id_fee, fee_name
	public function searchFullPaidFeeByStudentId($student, $status, $acad)
	  {
	  
	  	  $sql = "SELECT DISTINCT f.id as id_fee, fl.fee_label FROM fees f INNER JOIN fees_label fl ON(f.fee=fl.id) INNER JOIN level_has_person lhp ON(lhp.level=f.level) WHERE (lhp.students=".$student." AND fl.status=".$status." AND academic_period=".$acad.") AND ( f.id IN( SELECT fee FROM scholarship_holder WHERE partner IS NULL AND percentage_pay=100 AND student=".$student." AND academic_year=".$acad." )  )";
	  	  
	  	 $command = Yii::app()->db->createCommand($sql);
 
           $result = $command->queryAll();
           
                        
           return $result;
           
	  	}
	  	

//return id_fee, fee_name
	public function searchPendingFeesByStudentId($level, $acad)
	  {
	  	  $p_date = null;
          
	  	  $sql = "SELECT DISTINCT f.id as id_fee, fl.fee_label, f.amount FROM fees f INNER JOIN fees_label fl ON(fee=fl.id) WHERE fl.status=1 AND level=".$level." AND academic_period=".$acad;
										
          $command = Yii::app()->db->createCommand($sql);
 
           $result = $command->queryAll();
           
                        
           return $result;
           
	  	}
	 
	 	  		
//pou scholarship
public function isFeeAlreadyUse($stud,$fee_check, $acad)
	  {
	  	  if($fee_check==NULL)//gade si elev la gentan nan tab billings lan pou ane acad
			  $sql = "SELECT b.id FROM billings b INNER JOIN fees f ON(f.id=b.fee_period) WHERE b.student=".$stud." AND f.academic_period=".$acad." AND b.academic_year=".$acad;
		  else            //gade si elev la gen tranzaksyon sou fre sa
			   $sql = "SELECT b.id FROM billings b INNER JOIN fees f ON(f.id=b.fee_period) WHERE b.student=".$stud." AND f.id=".$fee_check." AND f.academic_period=".$acad." AND b.academic_year=".$acad;
          
	  	  $command = Yii::app()->db->createCommand($sql);
 
           $result = $command->queryAll();
           
                        
           return $result;
           
	  	}

		
  public function getFeeStatus()
	{
       $fee_id = Fees::model()->findByAttributes(array(
            'id'=>$this->fee_period,
        ));
        
      
        $fee_status = FeesLabel::model()->findByAttributes(array(
            'id'=>$fee_id->fee,
        ));
        
		return $fee_status->status;
	}
	

	public function getFeeAmount()
	{
        $currency_name = Yii::app()->session['currencyName'];
	    $currency_symbol = Yii::app()->session['currencySymbol']; 

      $f_amount = Fees::model()->findByAttributes(array(
            'id'=>$this->fee_period,
        ));
        
        
		return $currency_symbol.' '.numberAccountingFormat($f_amount->amount);
	}

        public function getAmountToPay(){
           $currency_name = Yii::app()->session['currencyName'];
	       $currency_symbol = Yii::app()->session['currencySymbol']; 

            return $currency_symbol.' '.numberAccountingFormat($this->amount_to_pay);
            
        }
        
        public function getAmountPay(){
            $currency_name = Yii::app()->session['currencyName'];
	        $currency_symbol = Yii::app()->session['currencySymbol']; 

            return $currency_symbol.' '.numberAccountingFormat($this->amount_pay);
        }


 public function getAmount(){
            $currency_name = Yii::app()->session['currencyName'];
	        $currency_symbol = Yii::app()->session['currencySymbol']; 

            return $currency_symbol.' '.numberAccountingFormat($this->amount);
        }


        
        public function getBalanceCurrency(){
            $currency_name = Yii::app()->session['currencyName'];
	         $currency_symbol = Yii::app()->session['currencySymbol']; 

             return $currency_symbol.' '.numberAccountingFormat($this->balance);
        }
        
        public function getDatePay(){
            if(($this->date_pay!=null)&&($this->date_pay!='0000-00-00'))
             {  $time = strtotime($this->date_pay);
                         $month=date("m",$time);
                         $year=date("Y",$time);
                         $day=date("j",$time);
                         
            return $day.'/'.$month.'/'.$year;  
             }
           else
             return '00/00/0000'; 
           	   
        }

        
}