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
		$object_attributes = $object->attributes();
		
		foreach($record as $attribute=>$value) {
			if(array_key_exists($attribute, $object_attributes)) {
				$object->$attribute = $value;
			}
		}
		
		return $object;	
	}
	
	protected function attributes() {
		// return an array of attribute keys and their values
		$attributes=array();
		foreach(static::$db_fields as $field) {
			if(property_exists($this, $field)) {
				$attributes[$field] = $this->$field;
			}
		}
		return $attributes;
	}
	
	protected function sanitized_attributes() {
		global $database;
		
		$clean_attributes = array();
		
		foreach($this->attributes() as $key=>$value) {
			$clean_attributes[$key] = $database->escape_string($value);
		}
		
		return $clean_attributes;
	}
	
	public function save() {
		return (isset($this->id)) ? $this->update() : $this->create();
	}
	
	public function create() {
		global $database;
		
		$attributes = $this->sanitized_attributes();
		
		$sql = "INSERT INTO " . static::$table_name . " (";
		$sql .= join(",",array_keys($attributes)) . ") ";
		$sql .= "VALUES ('";
		$sql .= join("','",array_values($attributes)) . "')";
		
		if($database->query($sql)) {
			$this->id = $database->insert_id();
			return true;
		}
		else {
			return false;
		}
		
	}
	
	public function update() {
		global $database;
		$attributes = $this->sanitized_attributes();
		
		$attribute_pairs = array();
		foreach($attributes as $key=>$value) {
			$attribute_pairs[] = "{$key}='{$value}'";
		}
		
		$sql = "UPDATE " . static::$table_name . " SET ";
		$sql .= join(",", $attribute_pairs);
		$sql .= " WHERE id=" . $database->escape_value($this->id);

		$database->query($sql);
		
		return ($database->affected_rows()==1) ? true : false;
	}
	
	public function delete() {
		global $database;
		
		$sql = "DELETE FROM " . static::$table_name;
		$sql .= " WHERE id=" . $database->escape_value($this->id);
		$sql .= " LIMIT 1";
		$database->query($sql);
		
		return ($database->affected_rows() == 1) ? true : false;
	}
}

?>
