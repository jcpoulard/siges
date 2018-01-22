<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class AverageByPeriod extends CActiveRecord
{

    public $gender; 
    public $first_name;
    public $last_name;
    public $name_period;
    public $room_name;
    
    
    
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
		return 'average_by_period';
	}
        
        
        
        
}