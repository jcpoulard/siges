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

?>
<?php

/**
 * This is the model class for table "menfp_grades".
 *
 * The followings are the available columns in table 'menfp_grades':
 * @property integer $id
 * @property integer $student
 * @property integer $menfp_exam
 * @property double $grade
 *
 * The followings are the available model relations:
 * @property ExamenMenfp $menfpExam
 * @property Persons $student0
 */
class BaseMenfpGrades extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return MenfpGrades the static model class
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
		return 'menfp_grades';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, menfp_exam', 'required'),
			array('student, menfp_exam', 'numerical', 'integerOnly'=>true),
			array('grade', 'numerical'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('id, student, menfp_exam, grade', 'safe', 'on'=>'search'),
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
			'menfpExam' => array(self::BELONGS_TO, 'ExamenMenfp', 'menfp_exam'),
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
			'menfp_exam' => Yii::t('app','Menfp Exam'),
			'grade' => Yii::t('app','Grade'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
/*	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('student',$this->student);
		$criteria->compare('menfp_exam',$this->menfp_exam);
		$criteria->compare('grade',$this->grade);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	*/
	
	
}