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
 * This is the model class for table "fees_label".
 *
 * The followings are the available columns in table 'fees_label':
 * @property integer $id
 * @property string $fee_label
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Fees[] $fees
 */
class BaseFeesLabel extends CActiveRecord
{
/**
* Returns the static model of the specified AR class.
* @param string $className active record class name.
* @return FeesLabel the static model class
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
return 'fees_label';
}

/**
* @return array validation rules for model attributes.
*/
public function rules()
{
// NOTE: you should only define rules for those attributes that
// will receive user inputs.
return array(
array('fee_label', 'required'),
array('status', 'numerical', 'integerOnly'=>true),
array('fee_label', 'length', 'max'=>100),
// The following rule is used by search().
// Please remove those attributes that should not be searched.
array('id, fee_label, status', 'safe', 'on'=>'search'),
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
'fees' => array(self::HAS_MANY, 'Fees', 'fee'),
);
}

/**
* @return array customized attribute labels (name=>label)
*/
public function attributeLabels()
{
return array(
'id' => Yii::t('app','ID'),
'fee_label' => Yii::t('app','Fee Description'),
'status' => Yii::t('app','Type of fees'),
);
}

/**
* Retrieves a list of models based on the current search/filter conditions.
* @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.

public function search()
{
// Warning: Please modify the following code to remove attributes that
// should not be searched.

$criteria=new CDbCriteria;

$criteria->compare('id',$this->id);
$criteria->compare('fee_label',$this->fee_label,true);
$criteria->compare('status',$this->status);

return new CActiveDataProvider($this, array(
'criteria'=>$criteria,
));
}
*/

}








