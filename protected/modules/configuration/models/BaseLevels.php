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
 * This is the model class for table "levels".
 *
 * The followings are the available columns in table 'levels':
 * @property integer $id
 * @property string $level_name
  * @property string $short_level_name
 * @property integer $previous_level
 * @property integer $section
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property LevelHasPerson[] $levelHasPeople
 * @property Sections $section0
 * @property BaseLevels $previousLevel
 * @property BaseLevels[] $levels
 * @property Rooms[] $rooms
 */
class BaseLevels extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseLevels the static model class
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
		return 'levels';
	}
	
	public $name_plevel;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('level_name,short_level_name, section', 'required'),
			array('previous_level, section', 'numerical', 'integerOnly'=>true),
			array('level_name,short_level_name, create_by, update_by', 'length', 'max'=>45),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, level_name,short_level_name, section', 'safe', 'on'=>'search'),
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
			'levelHasPeople' => array(self::HAS_MANY, 'LevelHasPerson', 'level'),
			'previousLevel' => array(self::BELONGS_TO, 'Levels', 'previous_level'),
			'section0' => array(self::BELONGS_TO, 'Sections', 'section'),
			'levels' => array(self::HAS_MANY, 'Levels', 'previous_level'),
			'rooms' => array(self::HAS_MANY, 'Rooms', 'level'),
			'sectionHasCycle' => array(self::HAS_MANY, 'SectionHasCycle', 'cycle'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app','ID'),
			'level_name' =>Yii::t('app', 'Level Name'),
			'short_level_name' =>Yii::t('app', 'Short Level Name'),
			'previous_level' =>Yii::t('app', 'Previous Level'),
			'section' => Yii::t('app', 'Section'),
			'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app','Date Updated'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
			'previousLevel.level_name'=>Yii::t('app','Previous level'),
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
		$criteria->compare('level_name',$this->level_name,true);
		$criteria->compare('short_level_name',$this->short_level_name,true);
		$criteria->compare('previous_level',$this->previous_level);
		$criteria->compare('section',$this->section);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
		

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}