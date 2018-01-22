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




class BasePersons extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return 'persons';
	}

	public function rules()
	{
		return array(
			array('last_name, first_name', 'required'),
			array('cities,paid', 'numerical', 'integerOnly'=>true),
			array('last_name, gender, phone, email,citizenship, create_by, update_by', 'length', 'max'=>45),
			array('first_name', 'length', 'max'=>120),
			array('mother_first_name', 'length', 'max'=>55),
			array('identifiant,matricule,nif_cin', 'length', 'max'=>100),
			array('id_number', 'length', 'max'=>50),
			array('adresse,comment', 'length', 'max'=>255),
			array('birthday, date_created, date_updated, active, blood_group', 'safe'),
			array('id, last_name, first_name, gender, nif_cin, paid,  blood_group, citizenship, birthday, id_number, adresse, phone, email, cities,identifiant,matricule, comment, date_created, date_updated, create_by, update_by', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
			'courses' => array(self::HAS_MANY, 'Courses', 'teacher'),
			'grades' => array(self::HAS_MANY, 'Grades', 'student'),
			'levelHasPeople' => array(self::HAS_MANY, 'LevelHasPerson', 'students'),
			'cities0' => array(self::BELONGS_TO, 'Cities', 'cities'),
			'titles' => array(self::MANY_MANY, 'Titles', 'persons_has_titles(persons_id, titles_id)'),
			'roomHasPeople' => array(self::HAS_MANY, 'RoomHasPerson', 'students'),
                        'billings' => array(self::HAS_MANY, 'Billings', 'student'),
		);
	}

	public function behaviors()
	{
		return array('CAdvancedArBehavior',
				array('class' => 'ext.CAdvancedArBehavior')
				);
	}

	public function attributeLabels()
	{
		return array(
			'id' => Yii::t('app', 'ID'),
			'last_name' => Yii::t('app', 'Last Name'),
			'first_name' => Yii::t('app', 'First Name'),
			'mother_first_name' => Yii::t('app', 'Mother\'s First Name'),
			'gender' => Yii::t('app', 'Gender'),
			'blood_group' => Yii::t('app', 'Blood Group'),
			'birthday' => Yii::t('app', 'Birthday'),
			'citizenship'=>Yii::t('app', 'Citizenship'),
			'id_number' => Yii::t('app', 'Id Number'),
			'identifiant' => Yii::t('app', 'Identifiant'),
			'matricule' => Yii::t('app', 'Matricule'),
			'adresse' => Yii::t('app', 'Adresse'),
			'phone' => Yii::t('app', 'Phone'),
			'email' => Yii::t('app', 'Email'),
			'nif_cin'=> Yii::t('app', 'NIF / CIN'),
			'cities' => Yii::t('app', 'Cities'),
			'paid'=> Yii::t('app', 'Paid'),
			'date_created' => Yii::t('app', 'Date Created'),
			'date_updated' => Yii::t('app', 'Date Updated'),
			'create_by' => Yii::t('app', 'Create By'),
			'update_by' => Yii::t('app', 'Update By'),
			'comment' => Yii::t('app', 'Comment'),
			
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;
		
		

		$criteria->compare('id',$this->id);

		$criteria->compare('last_name',$this->last_name,true);

		$criteria->compare('first_name',$this->first_name,true);
		
		$criteria->compare('mother_first_name',$this->mother_first_name,true);

		$criteria->compare('gender',$this->gender,true);
		
		$criteria->compare('blood_group',$this->blood_group,true);
		
		$criteria->compare('citizenship',$this->citizenship,true);

		$criteria->compare('birthday',$this->birthday,true);

		$criteria->compare('id_number',$this->id_number,true);
		
		$criteria->compare('identifiant',$this->identifiant,true);
		
		$criteria->compare('matricule',$this->matricule,true);
		
		$criteria->compare('nif_cin',$this->nif_cin,true);

		$criteria->compare('adresse',$this->adresse,true);

		$criteria->compare('phone',$this->phone,true);

		$criteria->compare('email',$this->email,true);

		$criteria->compare('cities',$this->cities);

		$criteria->compare('date_created',$this->date_created,true);

		$criteria->compare('date_updated',$this->date_updated,true);

		$criteria->compare('create_by',$this->create_by,true);

		$criteria->compare('update_by',$this->update_by,true);
		
		$criteria->compare('comment',$this->comment,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}