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
 * This is the model class for table "taxes".
 *
 * The followings are the available columns in table 'taxes':
 * @property integer $id
 * @property string $taxe_description
 * @property integer $employeur_employee
 * @property double $taxe_value
 * @property integer $particulier
 * @property integer $academic_year
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 */
class BaseTaxes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Taxes the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'taxes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('taxe_description, taxe_value, academic_year,employeur_employe', 'required'),
			array('academic_year,employeur_employe,particulier', 'numerical', 'integerOnly'=>true),
			array('taxe_value', 'numerical'),
			array('taxe_description', 'length', 'max'=>120),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, taxe_description, employeur_employe,particulier, taxe_value, academic_year', 'safe', 'on'=>'search'),
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
		        'academicYear' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_year'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'taxe_description' => Yii::t('app','Taxe Description'),
			'employeur_employe'=> Yii::t('app','Employer/Employee'),
			'taxe_value' => Yii::t('app','Taxe Value'),
			'particulier'=> Yii::t('app','Particular'),
			'academic_year' =>Yii::t('app', 'Academic year'),
		);
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
		$criteria->condition='academic_year='.$acad;

		$criteria->compare('id',$this->id);
		$criteria->compare('taxe_description',$this->taxe_description,true);
		$criteria->compare('employeur_employe',$this->employeur_employe,true);
		$criteria->compare('taxe_value',$this->taxe_value);
		$criteria->compare('particulier',$this->particulier,true);
		$criteria->compare('academic_year',$this->academic_year);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}


}

