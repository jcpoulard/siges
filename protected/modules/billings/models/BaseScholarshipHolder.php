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
class BaseScholarshipHolder extends CActiveRecord
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

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'scholarship_holder';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, percentage_pay, academic_year', 'required'),
			array('student, partner, is_internal, academic_year', 'numerical', 'integerOnly'=>true),
			array('percentage_pay', 'numerical'),
			array('comment', 'length', 'max'=>255),
			array('create_by, update_by', 'length', 'max'=>45),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, student, partner, percentage_pay, is_internal, academic_year, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'student' => Yii::t('app','Student'),
			'partner' => Yii::t('app','Partner'),
			'fee'=> Yii::t('app','Fee Name'),
			'percentage_pay' => Yii::t('app','Percentage Pay'),
			'is_internal' => Yii::t('app','Is Internal'),
			'academic_year' => Yii::t('app','Academic Year'),
			'comment' =>Yii::t('app', 'Comment'),
			'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app', 'Date Updated'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
/* public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('partner',$this->partner);
		$criteria->compare('percentage_pay',$this->percentage_pay);
		$criteria->compare('is_internal',$this->is_internal);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	*/
	
	
	
	
}