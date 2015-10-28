<?php

require_once('db.php');

class DatabaseObject {
	public static function find_by_id($id=0) {
		$result = static::find_by_sql("SELECT * FROM " . static::$table_name . " WHERE id={$id} LIMIT 1");
		
		if($result) {
			return $result[0];
		}
		else {
			return false;
		}
	}
	
	public static function find_by_sql($sql="") {
		global $database;
		
		if(!empty($sql)) {
			$object_array = array();
			$result_set = $database->query($sql);
			while($row = $result_set->fetch_array()) {
				$object_array[] = static::instantiate($row);
			}

			return $object_array;
		}
		else {
			return false;
		}
	}
	
	private static function instantiate($record) {
		$object = new static;
		$object_attributes = get_object_vars($object);
		
		foreach($record as $attribute=>$value) {
			if(array_key_exists($attribute, $object_attributes)) {
				$object->$attribute = $value;
			}
		}
		
		return $object;	
	}
}

?>
