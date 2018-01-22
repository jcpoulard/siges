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
 * This is the model class for table "record_presence".
 *
 * The followings are the available columns in table 'record_presence':
 * @property integer $id
 * @property integer $student
 * @property string $date_record
 * @property integer $presence_type
 * @property string $comments
 * @property integer $room
 * @property integer $academic_period
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Persons $student0
 */
class BaseRecordPresence extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseRecordPresence the static model class
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
		return 'record_presence';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, date_record, presence_type', 'required'),
                        array('student, presence_type, room, academic_period', 'numerical', 'integerOnly'=>true),
                        
               array('date_created, date_updated', 'safe'),
                        
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student, date_record, room, presence_type, comments, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
                        array('student+date_record', 'application.extensions.uniqueMultiColumnValidator'), 
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
			'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
                        'academicPeriod'=>array(self::BELONGS_TO, 'AcademicPeriods','academic_period'),
                        'room0'=>array(self::BELONGS_TO, 'Rooms','room'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'student' =>Yii::t('app','Student'),
			'date_record' =>Yii::t('app','Date Record'),
			'presence_type' =>Yii::t('app','Presence Type'),
			'comments' =>Yii::t('app','Comments'),
            'presence'=>Yii::t('app','Presence Type'),
            'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app', 'Date Updated'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
		);
	}

	
}