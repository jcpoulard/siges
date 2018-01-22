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



	
// auto-loading



class Documents extends CFormModel
{
	
	
        
        

//return info of all evaluations for Palmares Average       
public static function searchPeriodForPA($acad)
  {
		$command= Yii::app()->db->createCommand("SELECT DISTINCT abp.evaluation_by_year, ap.name_period FROM average_by_period abp LEFT JOIN evaluation_by_year ey on (ey.id = abp.evaluation_by_year) LEFT JOIN academicperiods ap on(ap.id=ey.academic_year) WHERE ap.year=".$acad." AND abp.academic_year=".$acad." order by ey.evaluation_date ASC");
		
		$sql_result = $command->queryAll();
		
		  return $sql_result;
  }
       

    

	
	
	
	}
