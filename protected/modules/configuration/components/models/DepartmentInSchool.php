<?php 
/*
 * © 2015 LOGIPAM services / www.logipam.com siges@logipam.com et contributeurs (voir www.logipam.com)
 * 
 * This file is part of SIGES.

    SIGES is a free software: you can redistribute it and/or modify
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

 */
class DepartmentInSchool extends BaseDepartmentInSchool
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseDepartmentInSchool the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

		/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array_merge(
		    	parent::rules(), array(
			
			array('date_created,date_updated', 'unsafe'),
						// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, department_name, date_created, date_updated, created_by, updated_by', 'safe', 'on'=>'search'),
		));
	}

	
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'department_name' => Yii::t('app', 'Department Name'),
			'date_created' => Yii::t('app', 'Date Created'),
			'date_updated' => Yii::t('app', 'Date Updated'),
			'created_by' => Yii::t('app', 'Created By'),
			'updated_by' => Yii::t('app', 'Updated By'),
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
		$criteria->compare('department_name',$this->department_name,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('created_by',$this->created_by,true);
		$criteria->compare('updated_by',$this->updated_by,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}