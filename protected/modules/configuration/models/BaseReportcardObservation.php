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
 * This is the model class for table "reportcard_observation".
 *
 * The followings are the available columns in table 'reportcard_observation':
 * @property integer $id
 * @property integer $section
 * @property double $start_range
 * @property double $end_range
 * @property string $comment
 * @property integer $academic_year
 * @property string $create_by
 * @property string $update_by
 * @property string $create_date
 * @property string $update_date
 *
 * The followings are the available model relations:
 * @property Academicperiods $academicYear
 */
class BaseReportcardObservation extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseReportcardObservation the static model class
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
		return 'reportcard_observation';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('section,start_range, end_range, academic_year', 'required'),
			array('academic_year', 'numerical', 'integerOnly'=>true),
			array('start_range, end_range', 'numerical'),
			array('comment', 'length', 'max'=>255),
			array('create_by, update_by', 'length', 'max'=>64),
			array('create_date, update_date', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, section, start_range, end_range, comment, academic_year, create_by, update_by, create_date, update_date', 'safe', 'on'=>'search'),
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
			'academicYear' => array(self::BELONGS_TO, 'Academicperiods', 'academic_year'),
			'section0' => array(self::BELONGS_TO, 'Sections', 'section'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'section'=>Yii::t('app','Section'),
			'start_range' => Yii::t('app','Start range'),
			'end_range' => Yii::t('app','End range'),
			'comment' => Yii::t('app','Comment'),
			'academic_year' => Yii::t('app','Academic year')',
			'create_by' => Yii::t('app','Create by'),
			'update_by' => Yii::t('app','Update by'),
			'create_date' => Yii::t('app','Create date'),
			'update_date' => Yii::t('app','Update date'),
		);
	}
*/
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('section',$this->section);
		$criteria->compare('start_range',$this->start_range);
		$criteria->compare('end_range',$this->end_range);
		$criteria->compare('comment',$this->comment,true);
		$criteria->compare('academic_year',$this->academic_year);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	*/
}