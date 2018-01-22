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
 * This is the model class for table "balance".
 *
 * The followings are the available columns in table 'balance':
 * @property integer $id
 * @property integer $student
 * @property double $balance
 * @property string $date_created
 *
 * The followings are the available model relations:
 * @property Persons $student0
 */
class Balance extends BaseBalance
{
	
	
	public $student_lname; 
	public $student_fname; 
	public $method_fname; 
	public $fee_fname; 
	public $is_only_balance;
	public $balance_to_pay;
	public $id_bill;
    public $academic_year;
    public $fee_name;
    public $room_name;
	
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseBalance the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
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
			array('student, student_fname, student_lname, room_name, fee_name, balance', 'safe', 'on'=>'search'),
		));
		
		
	}

	

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0');


		$criteria->alias='b';
		$criteria->join='left join room_has_person rh on(rh.students = b.student) ';

		$criteria->compare('b.id',$this->id);
		$criteria->compare('b.student',$this->student);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_created',$this->date_created,true);
		//$criteria->condition = 'b.amount_pay<>0 AND b.academic_year=:acad1 AND rh.academic_year=:acad2';
	    //$criteria->params = array( ':acad1'=>$acad,':acad2'=>$acad);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
    	    'criteria'=>$criteria,
		));
	}
	

	public function searchByRoom($room)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0');


		$criteria->alias='b';
		$criteria->join='inner join room_has_person rh on(rh.students = b.student) ';
        $criteria->condition = 'rh.room='.$room;
	    
	    $criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_created',$this->date_created,true);
		
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
    	    'criteria'=>$criteria,
		));
	}
	
	public function searchByRoomFee($room,$fee)
	{
		// SELECT distinct b.student FROM balance b inner join persons p on(p.id=b.student) inner join room_has_person rh on(rh.students = b.student) where b.student in(select bs.student from billings bs inner join fees f on(f.id=bs.fee_period) where f.fee=1 and fee_totally_paid=0) and rh.room=8 

		$criteria=new CDbCriteria;
		
		$criteria->alias='b';
		$criteria->join='inner join persons p on(p.id=b.student) inner join room_has_person rh on(rh.students = b.student)';
		
		if($fee!=NULL)
           $criteria->condition = ' b.student in(select bs.student from billings bs inner join fees f on(f.id=bs.fee_period) where f.fee='.$fee.' and fee_totally_paid=0) and rh.room='.$room;
        else
           $criteria->condition = ' b.student in(select bs.student from billings bs where fee_totally_paid=0) and rh.room='.$room;
	    
	    
	    
	    //$criteria->select='b.id,b.student,p.first_name,p.last_name,b.balance,b.date_created';
	    $criteria->compare('b.id',$this->id);
		$criteria->compare('b.student',$this->student);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('b.balance',$this->balance);
		$criteria->compare('b.date_created',$this->date_created,true);
	    
		
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
    	    'criteria'=>$criteria,
		));
	}
	
	
	
	public function searchByParentUsername($userName)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0');

		$criteria->condition = 'u.username=:user AND u.is_parent=1 ';
	    $criteria->params = array( ':user'=>$userName,);


		$criteria->alias='b';
		$criteria->join='left join room_has_person rh on(rh.students = b.student) inner join users u ON(u.person_id=b.student) ';
        
		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_created',$this->date_created,true);
		
		
		
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
    	    'criteria'=>$criteria,
		));
	}
	
	
		

	
	public function searchByStudentUsername($userName)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('student0');

		$criteria->condition = 'u.username=:user AND u.is_parent=0 ';
	    $criteria->params = array( ':user'=>$userName,);


		$criteria->alias='b';
		$criteria->join='left join room_has_person rh on(rh.students = b.student) inner join users u ON(u.person_id=b.student) ';
        
		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('student0.first_name',$this->student_fname,true);
		$criteria->compare('student0.last_name',$this->student_lname,true);
		$criteria->compare('balance',$this->balance);
		$criteria->compare('date_created',$this->date_created,true);
		
		
		
		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
    	    'criteria'=>$criteria,
		));
	}
	
	
	     public function getBalance(){
            $currency_name = Yii::app()->session['currencyName'];
	        $currency_symbol = Yii::app()->session['currencySymbol']; 

            return $currency_symbol.' '.numberAccountingFormat($this->balance);
        }
    	
	
	public function getRooms($stud)
			{ 
				$acad=Yii::app()->session['currentId_academic_year']; 
				
			$modelRH=new RoomHasPerson;
		$idRoom = $modelRH->find(array('select'=>'room',
                                     'condition'=>'students=:studID AND academic_year=:acad',
                                     'params'=>array(':studID'=>$stud,':acad'=>$acad),
                               ));
		$room = new Rooms;
                if($idRoom !=null){
                        $result=$room->find(array('select'=>'id,room_name',
                                     'condition'=>'id=:roomID',
                                     'params'=>array(':roomID'=>$idRoom->room),
                               ));
			
                
						   

						   
				if($result!=null)		   
				   return $result->room_name;
				else
				   return null;
				   
                }
                else
                  return null;
                
			}
	
	
	
	
	
}