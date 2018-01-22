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
 * This is the model class for table "scholarship_holder".
 *
 * The followings are the available columns in table 'scholarship_holder':
 * @property integer $id
 * @property integer $student
 * @property integer $partner
 * @property integer $fee
 * @property double $percentage_pay
 * @property integer $is_internal
 * @property integer $academic_year
 * @property string $comment
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 * @property Persons $student0
 */
class ScholarshipHolder extends BaseScholarshipHolder
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return ScholarshipHolder the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	
	
public $student_fullname;
public $partner_name;
public $sponsor;
public $is_full;




public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
            array('student_fullname, partner_name', 'length', 'max'=>200),
			array('id, student, student_fullname, partner_name, partner, fee, percentage_pay, is_internal, academic_year, comment,date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
			array('student+fee+academic_year', 'application.extensions.uniqueMultiColumnValidator'),
                   
									
		));
	}	

  public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                    
                    'partner_name' => Yii::t('app','Partner'),
                    'student_fullname' => Yii::t('app','Student'),
                   // 'student0.fullNmae'=> Yii::t('app','Student name'),
                    'IsInternal'=>Yii::t('app','Interne'),
                    'Partner' => Yii::t('app','Partner'),
                    'sponsor'=> Yii::t('app','Donor'),
                    'fee'=> Yii::t('app','Fee Name'),
                    
                                        
                        )
                    );
           
	}
	

	
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search_($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with= array('student0','academicYear');
		$criteria->alias= 'sh';
		$criteria->condition = 'sh.comment IS NULL AND academic_year='.$acad;
		$criteria->order = 'partner ASC, student0.last_name ASC';

		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('concat(student0.first_name," ",student0.last_name)',$this->student_fullname,true);
		$criteria->compare('partner',$this->partner);
		
		$criteria->compare('percentage_pay',$this->percentage_pay);
		$criteria->compare('is_internal',$this->is_internal);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('sh.comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
    			
		));
	}


	public function search_exemption($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with= array('student0','academicYear');
		
		$criteria->alias= 'sh';
		
		$criteria->condition = 'sh.comment IS NOT NULL AND academic_year='.$acad;
		$criteria->order = 'partner ASC, student0.last_name ASC,fee ASC';
		

		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('concat(student0.first_name," ",student0.last_name)',$this->student_fullname,true);
		$criteria->compare('partner',$this->partner);
		
		$criteria->compare('percentage_pay',$this->percentage_pay);
		$criteria->compare('is_internal',$this->is_internal);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('sh.comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
    			
		));
	}


	
	public function feeNotNullByStudentId($stud,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with= array('student0','academicYear');
		
		$criteria->condition = 'fee IS NOT NULL AND student='.$stud.' AND academic_year='.$acad;
		
		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('concat(student0.first_name," ",student0.last_name)',$this->student_fullname,true);
		$criteria->compare('partner',$this->partner);
		
		$criteria->compare('percentage_pay',$this->percentage_pay);
		$criteria->compare('is_internal',$this->is_internal);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=>20,
    			),
    			
		));
	}

	public function getScholarshipPartnerByStudentIdFee($stud,$fee,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		
		$criteria->with= array('student0','academicYear');
		if($fee==NULL)
			$criteria->condition = ' student='.$stud.' AND academic_year='.$acad;
		else
		    $criteria->condition = 'fee='.$fee.' AND student='.$stud.' AND academic_year='.$acad;
		
		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('concat(student0.first_name," ",student0.last_name)',$this->student_fullname,true);
		$criteria->compare('partner',$this->partner);
		
		$criteria->compare('percentage_pay',$this->percentage_pay);
		$criteria->compare('is_internal',$this->is_internal);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('comment',$this->comment);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			
			'pagination'=>array(
        			'pageSize'=>20,
    			),
    			
		));
	}
		
	
	public function getPartner()
	{
        $partner ='';
        
        if($this->partner == '')
          {
          	  $school_name = infoGeneralConfig('school_name');
			  
			  $partner = $school_name;
           }
        else
          {
        
		        $partner_ = Partners::model()->findByAttributes(array(
		            'id'=>$this->partner,
		        ));
				    
			     $partner = $partner_->name;
            }
            
		return $partner;
		
	}
	
	
public function getFee()
	{
        $fee_name ='';
        
        if($this->fee == NULL)
          {
          	  
			  $fee_name = Yii::t('app','All fees');
           }
        else
          {   $model_fee = Fees::model()->findByPk($this->fee);
          
   		        $fee_name_ = FeesLabel::model()->findByPk($model_fee->fee);
				$fee_name= $fee_name_->fee_label;
				
            }
            
		return $fee_name;
		
	 }


public function getAmountForPercentage($percentage,$fee,$level,$acad)
      {         
      	     $tot_amount =0;
      	     
      	     if($fee==null)
      	     {
      	     	$command= Yii::app()->db->createCommand('SELECT amount FROM fees WHERE  level='.$level.' AND academic_period='.$acad);
		
					$fee_info_ = $command->queryAll();
		        
			    if($fee_info_!=null)
			      { 
			      	foreach($fee_info_ as $fee_)
			      	{ $tot_amount = $tot_amount + (($fee_['amount'] * $percentage ) / 100 );
			          
			      	}
			          
			      }

      	     }
      	     else
      	      {
      	       $fee_info_ = Fees::model()->findByAttributes(array(
		            'id'=>$fee,'level'=> $level, 'academic_period'=> $acad,
		        ));
				    
			    if($fee_info_!=null)
			      $tot_amount = ($fee_info_->amount * $percentage ) / 100;
      	       }
      	      
			    
			    
			     return $tot_amount;
      	
      	}
      	
 
 public function getAmount()
      {   
      	$acad=Yii::app()->session['currentId_academic_year']; 
      	
      	     $tot_amount =0;
      	     
      	     //get level
      	      $level = Persons::model()->getLevelIdByStudentId($this->student,$acad);
      	     
      	     if($this->fee==null)
      	     {
      	     	$command= Yii::app()->db->createCommand('SELECT amount FROM fees WHERE  level='.$level.' AND academic_period='.$acad);
		
					$fee_info_ = $command->queryAll();
		        
			    if($fee_info_!=null)
			      { 
			      	foreach($fee_info_ as $fee_)
			      	{ $tot_amount = $tot_amount + (($fee_['amount'] * $this->percentage_pay ) / 100 );
			          
			      	}
			          
			      }

      	     }
      	     else
      	      {
      	       $fee_info_ = Fees::model()->findByAttributes(array(
		            'id'=>$this->fee,'level'=> $level, 'academic_period'=> $acad,
		        ));
				    
			    if($fee_info_!=null)
			      $tot_amount = ($fee_info_->amount * $this->percentage_pay ) / 100;
      	       }
      	      
			    
			    
			     return $tot_amount;
      	
      	}     	

      		
	public function getIsInternal(){
            switch($this->is_internal)
            {
                case 0:
                    return Yii::t('app','No');
                case 1:
                    return Yii::t('app','Yes');
                
            }
        }

	
	
}