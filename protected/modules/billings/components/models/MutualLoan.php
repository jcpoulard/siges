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
 * This is the model class for table "mutual_loan".
 *
 * The followings are the available columns in table 'mutual_loan':
 * @property integer $id
 * @property integer $person_id
 * @property string $loan_date
 * @property double $amount
 * @property double $interet
 * @property double $solde
 * @property integer $paid
 * @property string $date_updated
 *
 * The followings are the available model relations:
 * @property Persons $person
 */
class MutualLoan extends BaseMutualLoan
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MutualLoan the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	
	/**
	 * @return array validation rules for model attributes.
	 */
/* public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
             return array_merge(
		    	parent::rules(),
		                       array(
			         			 // array(),
			       ));
	}

*/
	

	/**
	 * @return array customized attribute labels (name=>label)
	 */
/*
public function attributeLabels()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
             return array_merge(
		    	parent::attributeLabels(), array(
			               
		));
	}		
*/


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
		$criteria->compare('loan_date',$this->loan_date,true);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('interet',$this->interet);
		$criteria->compare('solde',$this->solde);
		$criteria->compare('paid',$this->paid);
		$criteria->compare('date_updated',$this->date_updated,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}