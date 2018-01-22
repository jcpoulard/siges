<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class RptCustom extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return BaseCmsArticle the static model class
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
		return 'rpt_custom';
	}
        
        
        public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, data,categorie', 'required'),
			
			array('title', 'length', 'max'=>255),
			array('categorie', 'length', 'max'=>255),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, data, categorie, date_create, create_by', 'safe', 'on'=>'search'),
		);
	}
        
        
}