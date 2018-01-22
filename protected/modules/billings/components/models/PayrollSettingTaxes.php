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
 * This is the model class for table "payroll_setting_taxes".
 *
 * The followings are the available columns in table 'payroll_setting_taxes':
 * @property integer $id
 * @property integer $id_payroll_set
 * @property integer $id_taxe
 *
 * The followings are the available model relations:
 * @property Taxes $idTaxe
 * @property PayrollSettings $idParollSet
 */
class PayrollSettingTaxes extends BasePayrollSettingTaxes
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PayrollSettingTaxes the static model class
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
		return array(
			  array('id_payroll_set+id_taxe', 'application.extensions.uniqueMultiColumnValidator'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'idTaxe' => array(self::BELONGS_TO, 'Taxes', 'id_taxe'),
			'idParollSet' => array(self::BELONGS_TO, 'PayrollSettings', 'id_payroll_set'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'id_payroll_set' => 'Id Payroll Set',
			'id_taxe' => 'Id Taxe',
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
		$criteria->compare('id_payroll_set',$this->id_payroll_set);
		$criteria->compare('id_taxe',$this->id_taxe);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}