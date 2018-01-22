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
 * This is the model class for table "mutual".
 *
 * The followings are the available columns in table 'mutual':
 * @property integer $id
 * @property integer $person_id
 * @property double $amount
 * @property string $deposit_date
 *
 * The followings are the available model relations:
 * @property Persons $person
 */
class Mutual extends BaseMutual
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Mutual the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return array relational rules.
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
		$criteria->compare('amount',$this->amount);
		$criteria->compare('deposit_date',$this->deposit_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}