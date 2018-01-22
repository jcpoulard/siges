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
 * This is the model class for table "record_infraction".
 *
 * The followings are the available columns in table 'record_infraction':
 * @property string $id
 * @property integer $student
 * @property integer $infraction_type
 * @property string $record_by
 * @property string $incident_date
 * @property string $incident_description
 * @property string $decision_description
 * @property double $value_deduction
 * @property string $general_comment
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property InfractionType $infractionType
 * @property Persons $student0
 */
class BaseRecordInfraction extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseRecordInfraction the static model class
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
		return 'record_infraction';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('student, infraction_type, record_by, incident_date, incident_description', 'required'),
			array('student, infraction_type', 'numerical', 'integerOnly'=>true),
			array('value_deduction', 'numerical'),
			array('record_by', 'length', 'max'=>64),
			array('decision_description,date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, student, infraction_type, record_by, incident_date, incident_description, decision_description, value_deduction, general_comment, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'infractionType' => array(self::BELONGS_TO, 'InfractionType', 'infraction_type'),
			'student0' => array(self::BELONGS_TO, 'Persons', 'student'),
                        
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
			'infraction_type' =>Yii::t('app','Infraction Type'),
			'record_by' =>Yii::t('app','Record By'),
			'incident_date' =>Yii::t('app','Incident Date'),
			'incident_description' =>Yii::t('app','Incident Description'),
			'decision_description' =>Yii::t('app','Decision Description'),
			'value_deduction' =>Yii::t('app','Value Deduction'),
			'general_comment' =>Yii::t('app','General Comment'),
            'incidentDate'=>Yii::t('app','Incident Date'),
            'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app', 'Date Updated'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
		);
	}

	
}