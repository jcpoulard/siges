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
 * This is the model class for table "fees".
 *
 * The followings are the available columns in table 'fees':
 * @property integer $id
 * @property integer $level
 * @property integer $academic_period
 * @property string $fee
 * @property double $amount
 * @property integer $devise
 * @property string $date_limit_payment
 * @property integer $checked
 * @property string $description
 * @property string $date_create
 * @property string $date_update
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Devises $devise0
 * @property Academicperiods $academicPeriod
 * @property Levels $level0
 */
class BaseFees extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseFees the static model class
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
		return 'fees';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level, academic_period, fee, amount', 'required'),
			array('level, academic_period, fee, devise, checked', 'numerical', 'integerOnly'=>true),
			array('amount', 'numerical'),
			array('create_by, update_by', 'length', 'max'=>45),
			array('date_limit_payment, description, date_create, date_update', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, level, academic_period, fee, amount, devise, date_limit_payment, checked, description, date_create, date_update, create_by, update_by', 'safe', 'on'=>'search'),
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
			
			'devise0' => array(self::BELONGS_TO, 'Devises', 'devise'),
			'academicPeriod' => array(self::BELONGS_TO, 'AcademicPeriods', 'academic_period'),
			'level0' => array(self::BELONGS_TO, 'Levels', 'level'),
			'fee0' => array(self::BELONGS_TO, 'FeesLabel', 'fee'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'level' => Yii::t('app','Level'),
			'academic_period' => Yii::t('app','Academic Period'),
			'fee_name' => Yii::t('app','Fee Name'),
			'fee' => Yii::t('app','Fee Name'),
			'amount' =>Yii::t('app', 'Amount'),
			'devise' => Yii::t('app','Devise'),
			'date_limit_payment' => Yii::t('app','Date Limit Payment'),
			'checked' => Yii::t('app','Checked'),
			'description' => Yii::t('app','Description'),
			'date_create' => Yii::t('app','Date Create'),
			'date_update' => Yii::t('app','Date Update'),
			'create_by' => Yii::t('app','Create By'),
			'update_by' => Yii::t('app','Update By'),
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
		$criteria->compare('level',$this->level);
		$criteria->compare('fee',$this->fee);
		$criteria->compare('academic_period',$this->academic_period);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('devise',$this->devise);
		$criteria->compare('date_limit_payment',$this->date_limit_payment,true);
		//$criteria->compare('checked',$this->checked);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('date_create',$this->date_create,true);
		$criteria->compare('date_update',$this->date_update,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}