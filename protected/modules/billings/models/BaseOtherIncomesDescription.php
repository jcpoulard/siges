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
 * This is the model class for table "other_incomes_description".
 *
 * The followings are the available columns in table 'other_incomes_description':
 * @property integer $id
 * @property string $income_description
 * @property string $comment
 *
 * The followings are the available model relations:
 * @property BaseOtherIncomes[] $otherIncomes
 */
class BaseOtherIncomesDescription extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseOtherIncomesDescription the static model class
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
		return 'other_incomes_description';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('income_description, category', 'required'),
			array('category', 'numerical', 'integerOnly'=>true),
			array('income_description', 'length', 'max'=>65),
			array('comment', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, income_description, category, comment', 'safe', 'on'=>'search'),
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
			'otherIncomes' => array(self::HAS_MANY, 'OtherIncomes', 'id_income_description'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app','ID'),
			'income_description' => Yii::t('app','Income Description'),
			'category'=> Yii::t('app','Category'),
			'comment' => Yii::t('app','Comment'),
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
		
		$criteria->alias = 'oid';
		$criteria->order = 'oid.category ASC';
		//$criteria->join='inner join label_category_for_billing lcb on(oid.category = lcb.id)';


		$criteria->compare('id',$this->id);
		$criteria->compare('income_description',$this->income_description,true);
		$criteria->compare('oid.category',$this->category,true);
		//$criteria->compare('lcb.category',$this->category);
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}