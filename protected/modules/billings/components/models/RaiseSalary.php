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






class RaiseSalary extends BaseRaiseSalary
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return RaiseSalary the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	
/*	
 public function rules()
	{
		 return array_merge(
                parent::rules(), array(
                   // array(),
                   
									
		));
	}
 */
	
//relations:'person' => array(self::BELONGS_TO, 'Persons', 'person_id'),
     public function attributeLabels()
	{
		
            return array_merge(
                    parent::attributeLabels(), 
                    array(
                    
                    'id' => Yii::t('app','ID'),
			'person_id' => Yii::t('app','Person'),
			'amount' => Yii::t('app','Amount'),
			'raising_date' => Yii::t('app','Rising Date'),
			'academic_year' => Yii::t('app','Academic Year'),
                    
                        )
                    );
           
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

		$criteria->compare('id',$this->id);
		$criteria->compare('person_id',$this->person_id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('raising_date',$this->raising_date,true);
		$criteria->compare('academic_year',$this->academic_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}