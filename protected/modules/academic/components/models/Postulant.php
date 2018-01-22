<?php 
/*
 * © 2010 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
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
 * This is the model class for table "postulant".
 *
 * The followings are the available columns in table 'postulant':
 * @property integer $id
 * @property string $first_name
 * @property string $last_name
 * @property string $gender
 * @property string $blood_group
 * @property string $birthday
 * @property integer $cities
 * @property string $adresse
 * @property string $phone
 * @property string $health_state
 * @property string $person_liable
 * @property string $person_liable_phone
 * @property string $person_liable_adresse
 * @property integer $person_liable_relation
 * @property integer $apply_for_level
 * @property integer $previous_level
 * @property string $previous_school
 * @property string $school_date_entry
 * @property double $last_average
 * @property integer $status
 * @property integer $academic_year
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Levels $applyForLevel
 * @property Cities $cities0
 * @property Levels $previousLevel
 * @property Relations $personLiableRelation
 */
 
class Postulant extends BasePostulant
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Postulant the static model class
	 */
	
	 const MALE = 0;
    const FEMALE = 1; 

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'postulant';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   //array('full_name, employee_lname, employee_fname,academic_year,date_payroll', 'length', 'max'=>65),
                  // array('person_id+as+academic_year', 'application.extensions.uniqueMultiColumnValidator'),
                   
                 					
		));
	}

     //'academicPeriod' => array(self::BELONGS_TO, 'Academicperiods', 'academic_year'),
	//'applyForLevel' => array(self::BELONGS_TO, 'Levels', 'apply_for_level'),
	//'cities0' => array(self::BELONGS_TO, 'Cities', 'cities'),
	//'previousLevel' => array(self::BELONGS_TO, 'Levels', 'previous_level'),
	//'personLiableRelation' => array(self::BELONGS_TO, 'Relations', 'person_liable_relation'),
	
	
public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                        'paid'=> Yii::t('app','Paid'),
                       
                                   
                        )
                    );
           
	}


 
 
  public function getStatus(){
            switch($this->status)
            {
                case 0:
                     return Yii::t('app','None');
                case 1:
                    return Yii::t('app','Approve');
                case 2:
                    return Yii::t('app','Put on hold');
                case 3:
                    return Yii::t('app','Reject');
               
            }
        }
        
   public function getStatusValue(){
            return array(
                0=>Yii::t('app','None'),
                1=>Yii::t('app','Approve'),
                2=>Yii::t('app','Put on hold'),
                3=>Yii::t('app','Reject'),
                             
            );            
        } 		   
    
 
   public function getFullName(){
       
       return $this->first_name. ' '.$this->last_name;
   }
    
    // Take the gender
   public function getGenders(){
            return array(
                self::MALE=>Yii::t('app','Male'),
                self::FEMALE=>Yii::t('app','Female'),
                               
            );            
        }
        
        public function getSexe(){
            
            $sex = $this->gender;
            $sex_name = null;
            if($sex==0)
                {
                   $sex_name = Yii::t('app','Male'); 
                }
                elseif($sex==1)
                {
                    $sex_name = Yii::t('app','Female');
                }
                
                return $sex_name;
                
        }




        /* public function getOneGender(){
            $gender = $this->getGenders();
            return $gender[$this->gender];
        } */
			
			public function getGenders1()
			{
			
				switch($this->gender)
				{
					case 0:
						return Yii::t('app','Male');
				
					case 1:
						return Yii::t('app','Female');
					
					}
			}
			
	
	    /**
         * 
         * @return blood_group  value 
         * 1 -> O+ 
         * 2 -> O-
         * 3 -> A+
         * 4 -> A-
         * 5 -> B+
         * 6 -> B-
         * 7 -> AB+
         * 8 -> AB-
         */
        public function getBlood_group(){
           
       if($this->blood_group!='')
		  {  
            switch($this->blood_group)
            {
                case 1:
                    return Yii::t('app','O+');
                    
                case 2:
                    return Yii::t('app','O-');
                case 3:
                    return Yii::t('app','A+');
                case 4:
                    return Yii::t('app','A-');
                case 5:
                    return Yii::t('app','B+');
                case 6:
                    return Yii::t('app','B-');
                case 7:
                    return Yii::t('app','AB+');
                case 8:
                    return Yii::t('app','AB-');
                
            }
            
		  }
		 else
		     return null; 
		  
        }


      /**
         * 
         * @return type
         * Return human readable value for blood_group from the DB 
         * 1 -> O+ 
         * 2 -> O-
         * 3 -> A+
         * 4 -> A-
         * 5 -> B+
         * 6 -> B-
         * 7 -> AB+
         * 8 -> AB-
         */
         public function getBlood_groupValue(){
            return array(
                1=>Yii::t('app','O+'),
                2=>Yii::t('app','O-'),
                3=>Yii::t('app','A+'),
                4=>Yii::t('app','A-'),
                5=>Yii::t('app','B+'),
                6=>Yii::t('app','B-'),
                7=>Yii::t('app','AB+'),
                8=>Yii::t('app','AB-'),
                              
            );            
        } 	


 //************************  getRelation($id) ******************************/
   public function getRelation($id)
	{
		$relat = new Relations;
		
		if($id!='')
		{ 
		   $relat=Relations::model()->findByPk($id);
        
			
		    if(isset($relat))
				return $relat->relation_name;
		}
		else
		   return null;
		
	}


 //************************  getLevel($id) ******************************/
   public function getLevel($id)
	{
		$level = new Levels;
		
		if($id!='')
		  {  
		     $level=Levels::model()->findByPk($id);
        
			
		    if(isset($level))
				return $level->level_name;
				
		  }
		 else
		    return null;
		
	}


   public function getCity()
	{
		
		if($this->cities!='')
		  {  
		     $city=Cities::model()->findByPk($this->cities);
        
			
		    if(isset($city))
				return $city->city_name;
				
		  }
		 else
		    return null;
		
	}

public function getPaid()
			{
			  $paid=0;
			  
			  $result= EnrollmentIncome::model()->find(array('select'=>'id,apply_level,amount,payment_date',
                                     'condition'=>'postulant=:pos AND academic_year=:acad',
                                     'params'=>array(':pos'=>$this->id, ':acad'=>$this->academic_year),
                               ));
			
         				   
				if($result!=null)		   
				   $paid=1;
				
				
				
				switch($paid)
				{
					case 0:
						return Yii::t('app','No');
				
					case 1:
						return Yii::t('app','Yes');
					
					}
			}   
			

public function getPaidAmount()
			{
			  //$currency_name=Yii::app()->session['currencyName'];
			   $currency_symbol=Yii::app()->session['currencySymbol'];
			   
			   
			  $paid=0;
			  
			  $result= EnrollmentIncome::model()->find(array('select'=>'id,apply_level,amount,payment_date',
                                     'condition'=>'postulant=:pos AND academic_year=:acad',
                                     'params'=>array(':pos'=>$this->id, ':acad'=>$this->academic_year),
                               ));
			
         				   
				if($result!=null)		   
				   $paid=1;
				
				
				
				switch($paid)
				{
					case 0:
						return Yii::t('app','No');
				
					case 1:
						return Yii::t('app','Yes').' ('.$currency_symbol.' '.numberAccountingFormat($result->amount).')';
					
					}
			}   
			    
        
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->alias='p';
		
		$criteria->with=array('academicPeriod','applyForLevel','cities0','previousLevel','personLiableRelation');
		$criteria->condition = 'status <> 1 AND p.academic_year='.$acad;
         
         $criteria->order = 'p.id DESC';
         
		$criteria->compare('p.id',$this->id);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('blood_group',$this->blood_group,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('cities',$this->cities);
		$criteria->compare('adresse',$this->adresse,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('health_state',$this->health_state,true);
		$criteria->compare('person_liable',$this->person_liable,true);
		$criteria->compare('person_liable_phone',$this->person_liable_phone,true);
		$criteria->compare('person_liable_adresse',$this->person_liable_adresse,true);
		$criteria->compare('person_liable_relation',$this->person_liable_relation);
		$criteria->compare('p.apply_for_level',$this->apply_for_level);
		$criteria->compare('previous_level',$this->previous_level);
		$criteria->compare('previous_school',$this->previous_school,true);
		$criteria->compare('school_date_entry',$this->school_date_entry,true);
		$criteria->compare('last_average',$this->last_average);
		$criteria->compare('status',$this->status);
		$criteria->compare('p.academic_year',$this->academic_year,true);
		$criteria->compare('p.date_updated',$this->date_updated,true);
		$criteria->compare('p.create_by',$this->create_by,true);
		$criteria->compare('p.update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
		));
	}



	public function searchForDecision($idLevel,$status,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->alias='p';
		
		$criteria->with=array('academicPeriod','applyForLevel','cities0','previousLevel','personLiableRelation');
		
		if(($idLevel==''))
		   {
		   	   if($status=='')
		   	      $status=0;
		   	   
		   	   $criteria->condition = 'status ='.$status.' AND p.academic_year='.$acad;
		   	   
		   }
		else
          {  
          	 
          	 $criteria->condition = 'status ='.$status.' AND apply_for_level='.$idLevel.' AND p.academic_year='.$acad;
          	 
          }
          
          $criteria->order = 'last_name ASC';
          
		$criteria->compare('p.id',$this->id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('blood_group',$this->blood_group,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('cities',$this->cities);
		$criteria->compare('adresse',$this->adresse,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('health_state',$this->health_state,true);
		$criteria->compare('person_liable',$this->person_liable,true);
		$criteria->compare('person_liable_phone',$this->person_liable_phone,true);
		$criteria->compare('person_liable_adresse',$this->person_liable_adresse,true);
		$criteria->compare('person_liable_relation',$this->person_liable_relation);
		$criteria->compare('p.apply_for_level',$this->apply_for_level);
		$criteria->compare('previous_level',$this->previous_level);
		$criteria->compare('previous_school',$this->previous_school,true);
		$criteria->compare('school_date_entry',$this->school_date_entry,true);
		$criteria->compare('last_average',$this->last_average);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('p.academic_year',$this->academic_year,true);
		$criteria->compare('p.date_updated',$this->date_updated,true);
		$criteria->compare('p.create_by',$this->create_by,true);
		$criteria->compare('p.update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
		));
	}


	
	public function searchApproved($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->alias='p';
		
		$criteria->with=array('academicPeriod','applyForLevel','cities0','previousLevel','personLiableRelation');
		$criteria->condition = 'status = 1 AND p.academic_year='.$acad;
        
        $criteria->order = 'apply_for_level ASC, last_name ASC';
        
		$criteria->compare('p.id',$this->id,true);
		$criteria->compare('first_name',$this->first_name,true);
		$criteria->compare('last_name',$this->last_name,true);
		$criteria->compare('gender',$this->gender,true);
		$criteria->compare('blood_group',$this->blood_group,true);
		$criteria->compare('birthday',$this->birthday,true);
		$criteria->compare('cities',$this->cities);
		$criteria->compare('adresse',$this->adresse,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('health_state',$this->health_state,true);
		$criteria->compare('person_liable',$this->person_liable,true);
		$criteria->compare('person_liable_phone',$this->person_liable_phone,true);
		$criteria->compare('person_liable_adresse',$this->person_liable_adresse,true);
		$criteria->compare('person_liable_relation',$this->person_liable_relation);
		$criteria->compare('p.apply_for_level',$this->apply_for_level);
		$criteria->compare('previous_level',$this->previous_level);
		$criteria->compare('previous_school',$this->previous_school,true);
		$criteria->compare('school_date_entry',$this->school_date_entry,true);
		$criteria->compare('last_average',$this->last_average);
		$criteria->compare('status',$this->status);
		$criteria->compare('p.academic_year',$this->academic_year,true);
		$criteria->compare('p.date_updated',$this->date_updated,true);
		$criteria->compare('p.create_by',$this->create_by,true);
		$criteria->compare('p.update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
		'criteria'=>$criteria,
		));
	}
	
	
	
	
	
	
	
}