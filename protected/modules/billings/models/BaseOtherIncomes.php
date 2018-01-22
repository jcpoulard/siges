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
 * This is the model class for table "other_incomes".
 *
 * The followings are the available columns in table 'other_incomes':
 * @property integer $id
 * @property integer $id_income_description
 * @property integer $amount
 * @property string $income_date
 * @property string $description
 * @property integer $academic_year
 * @property string $date_created
 * @property string $date_updated
 * @property string $created_by
 * @property string $updated_by
 *
 * The followings are the available model relations:
 * @property BaseOtherIncomesDescription $idIncomeDescription
 * @property Academicperiods $academicYear
 */
class BaseOtherIncomes extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseOtherIncomes the static model class
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
		return 'other_incomes';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id_income_description, amount, income_date, description, academic_year', 'required'),
			array('id_income_description, amount, academic_year', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('created_by, updated_by', 'length', 'max'=>65),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, id_income_description, amount, income_date, academic_year', 'safe', 'on'=>'search'),
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
			'idIncomeDescription' => array(self::BELONGS_TO, 'OtherIncomesDescription', 'id_income_description'),
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
			'id_income_description' => Yii::t('app','Id Income Description'),
			'amount' => Yii::t('app','Amount'),
			'income_date' => Yii::t('app','Income Date'),
			'academic_year' => Yii::t('app','Academic Year'),
			'description'=> Yii::t('app','Description'),
			'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app', 'Date Updated'),
			'created_by' =>Yii::t('app', 'Created By'),
			'updated_by' =>Yii::t('app', 'Updated By'),
			
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
/*	public function search($acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		$criteria->with= array('idIncomeDescription','academicYear');
		
		$criteria->condition = 'academic_year='.$acad;


		$criteria->compare('id',$this->id);
		$criteria->compare('id_income_description',$this->id_income_description);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('income_date',$this->income_date,true);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'pagination'=>array(
        			'pageSize'=> Yii::app()->user->getState('pageSize',Yii::app()->params['defaultPageSize']),
    			),
			'criteria'=>$criteria,
		));
	}
	*/
	
	
}