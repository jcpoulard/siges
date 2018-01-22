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
 * This is the model class for table "contact_info".
 *
 * The followings are the available columns in table 'contact_info':
 * @property integer $id
 * @property integer $person
 * @property string $contact_name
 * @property integer $contact_relationship
 * @property string $profession
 * @property string $phone
 * @property string $address
 * @property string $email
 * @property string $date_created
 * @property string $date_updated
 * @property string $create_by
 * @property string $update_by
 *
 * The followings are the available model relations:
 * @property Relations $contactRelationship
 * @property Persons $person0
 */
class BaseContactInfo extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseContactInfo the static model class
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
		return 'contact_info';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('person', 'required'),
			array('person, contact_relationship', 'numerical', 'integerOnly'=>true),
			array('contact_name, create_by, update_by', 'length', 'max'=>45),
			array('profession', 'length', 'max'=>100),
			array('phone, email', 'length', 'max'=>64),
			array('address', 'length', 'max'=>255),
			array('date_created, date_updated', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, person, contact_name, contact_relationship, profession, phone, address, email, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
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
			'contactRelationship' => array(self::BELONGS_TO, 'Relations', 'contact_relationship'),
			'person0' => array(self::BELONGS_TO, 'Persons', 'person'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' =>Yii::t('app','ID'),
			'person' =>Yii::t('app','Person'),
			'contact_name' =>Yii::t('app', 'Contact Name'),
			'contact_relationship' =>Yii::t('app', 'Contact Relationship'),
			'profession' => Yii::t('app', 'Profession'),
			'phone' =>Yii::t('app', 'Phone'),
			'address' =>Yii::t('app', 'Address'),
			'email' =>Yii::t('app', 'Email'),
			'date_created' =>Yii::t('app', 'Date Created'),
			'date_updated' =>Yii::t('app', 'Date Updated'),
			'create_by' =>Yii::t('app', 'Create By'),
			'update_by' =>Yii::t('app', 'Update By'),
		);
	}

	
	
	
 public function search($condition,$acad)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->with = array('person0','contactRelationship');
                $criteria->join = 'left join room_has_person rh on (rh.students=person)';
                $criteria->condition = $condition.' rh.academic_year=:acad';
		$criteria->params = array(':acad'=>$acad);

		$criteria->compare('id',$this->id);
		$criteria->compare('person',$this->person);
		$criteria->compare('contact_name',$this->contact_name,true);
		$criteria->compare('contact_relationship',$this->contact_relationship);
		$criteria->compare('profession',$this->profession,true);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('address',$this->address,true);
		$criteria->compare('email',$this->email,true);
		$criteria->compare('date_created',$this->date_created,true);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('create_by',$this->create_by,true);
		$criteria->compare('update_by',$this->update_by,true);
                $criteria->compare('person0.last_name',$this->person_lname, true);
                $criteria->compare('person0.first_name', $this->person_fname,true);
                $criteria->compare('contactRelationship.relation_name', $this->relation_lname,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	} 
	
}