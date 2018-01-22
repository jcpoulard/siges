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

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class Admission extends Persons
{
    public $last_name; 
    public $first_name; 
    public $sexe;
    public $admission_en;
    public $phone;
    public $father_full_name;
    public $mother_full_name;
    public $person_liable; 
    public $person_liable_phone;
    public $previous_school;
    public $comments; 
    public $cities;
    
    
    public function rules()
        {
            return array(
                array('last_name, first_name, gender, admission_en','required'),
                );
        }
        
   public function attributeLabels() {
       parent::attributeLabels();
       return array(
           'last_name'=>Yii::t('app','Last name'),
           'first_name'=>Yii::t('app','First name'),
           'gender'=>Yii::t('app','Gender'),
           'birthday'=>Yii::t('app','Birthday'),
           'phone'=>Yii::t('app','Phone'),
           'citizenship'=>Yii::t('app','Citizenship'),
           'father_full_name'=>Yii::t('app','Father full name'),
           'mother_full_name'=>Yii::t('app','Mother full name'),
           'person_liable'=>Yii::t('app','Person liable'),
           'person_liable_phone'=>Yii::t('app','Person liable phone'),
           'previous_school'=>Yii::t('app','Previous school'),
           'comments'=>Yii::t('app','Comments'),
       );
   }
   
   public function getCityname($x){
       if($x!=0){
       $model_city = Cities::model()->findByPk($x);
       
       return $model_city->city_name; 
       }else{
           return 'N/A';
       }
       
   }
   
   public function getLevelname($x){
       if($x!=0){
       $model_level = Levels::model()->findByPk($x);
       
       return $model_level->level_name; 
       }else{
           return 'N/A';
       }
       
   }
   
    
    
}