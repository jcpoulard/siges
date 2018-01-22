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
 * This is the model class for table "bareme".
 *
 * The followings are the available columns in table 'bareme':
 * @property integer $id
 * @property double $min_value
 * @property double $max_value
 * @property double $percentage
 * @property integer $compteur
 * @property integer $old_new
 * @property string $date_created
 * @property string $created_by
 *
 */
class BaseBareme extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Bareme the static model class
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
		return 'bareme';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('min_value, max_value, percentage', 'required'),
			array('compteur, old_new', 'numerical', 'integerOnly'=>true),
			array('min_value, max_value, percentage', 'numerical'),
			array('created_by', 'length', 'max'=>64),
			array('date_created', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, min_value, max_value, percentage, compteur, old_new, created_by, date_created', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'min_value' => Yii::t('app', 'Minimum value'),
			'max_value' => Yii::t('app', 'Maximum value'),
			'percentage' => Yii::t('app', 'Percentage'),
			'compteur' => Yii::t('app', 'Compteur'),
			'old_new' => Yii::t('app','New setting'),
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
		$criteria->compare('min_value',$this->min_value);
		$criteria->compare('max_value',$this->max_value);
		$criteria->compare('percentage',$this->percentage);
		$criteria->compare('compteur',$this->compteur);
		$criteria->compare('old_new',$this->old_new);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('created_by',$this->created_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}