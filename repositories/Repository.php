<?php

class Repository{
  private readonly string $table;
  private readonly array $keys; // string array for the keys of each table
  private mysqli $conn;
  
  protected function __construct(string $table, array $keys){
    $this->table = $table;
    global $conn; // you can declare this global in every method you want to use it, if you don't want to make a field variable
    if (!isset($conn)) { 
      require_once __DIR__ . '\..\config\db_connection.php'; // once is less performant but more secure;
    }
    $this->conn = $conn;
    $this->keys = $keys;
  }

  public function getAll(): array{
    $getAllQuery = $this->conn->prepare("
      SELECT * FROM $this->table;
    ");
    $isOk = $getAllQuery->execute();
    if(!$isOk)
      return [];
    $result = $getAllQuery->get_result();
    $arr = $result->fetch_all();
    return $arr;
  }

  public function getById(int $id){
    $queryString = "
      SELECT * FROM $this->table
      WHERE id=?;
    ";
    echo $queryString;
    $getQuery = $this->conn->prepare("
      SELECT * FROM $this->table
      WHERE id=?;
    ");
    $getQuery->bind_param('i', $id);
    if($getQuery->execute() == false)
      return null;
    $result = $getQuery->get_result();
    return $result->fetch_assoc();
    // fetch_assoc says it's going to return an array, cause it returns an associative array (HashMap)
  }

  public function insert($obj){
    if(!$this->confirmInsertSchema($obj))
      return "Bad Object Signature";
    $columns = array_keys($obj);
    $values = array_values($obj);
    $columnString = implode(", ", $columns);
    $valueString = implode(", ", array_fill(0, count($columns), "?"));
    $insertQuery = $this->conn->prepare("
      INSERT INTO $this->table ($columnString)
      VALUES ($valueString);
    ");
    $types = '';
    foreach($values as $value){
      $types.= $this->getParamType($value);
    }
    $insertQuery->bind_param($types, ...$values);
    $insertQuery->execute();
    if($insertQuery->affected_rows<1)
      return "Insertion Unsuccessful";
    return "Insertion Successful";
  }

  public function updateById(int $id, array $obj){
    if(!$this->confirmUpdateSchema($obj))
      return "Bad Object Signature";
    $columns = array_keys($obj);
    $values = array_values($obj);
    $setStatement = implode("=?, ", $columns) . "=?"; // will make a col1=?, col2=?, ...
    $updateQuery = $this->conn->prepare("
      UPDATE $this->table
      SET $setStatement
      WHERE id=?;
    ");
    $types = '';
    foreach($values as $value){
      $types.= $this->getParamType($value);
    }
    $types.='i'; // for the id
    $valuesAndId = [...$values, $id]; // adding the id to be binded
    $updateQuery->bind_param($types, ...$valuesAndId);
    $updateQuery->execute();
    $this->conn->commit();
    if($updateQuery->affected_rows<1)
      return "Update Unsuccessful"; // I might return sth different in the end
    return "Update Successful";
  }

  public function deleteById(int $id){
    $deleteQuery = $this->conn->prepare("
      DELETE FROM $this->table
      WHERE id=?;
    ");
    $deleteQuery->bind_param('i', $id);
    $deleteQuery->execute();
    $this->conn->commit();
    if($deleteQuery->affected_rows<1)
      return "Deletion Unsuccessful";
    return "Deletion Successful";
  }
  
  private function getParamType($value){
    if(is_int($value))
      return 'i';
    if(is_float($value))
      return 'd';
    if(is_string($value))
      return 's';
    return 'b';
  }

  private function confirmInsertSchema($obj){
    $obj_keys = array_keys($obj);
    if(count($obj_keys) !== count($this->keys))
      return false;
    foreach($this->keys as $key){
      if(!array_key_exists($key, $obj))
        return false;
    }
    return true;
  }

  private function confirmUpdateSchema($obj){
    $obj_keys = array_keys($obj);
    if(count($obj_keys) > count($this->keys))
      return false;
    foreach($obj_keys as $key){
      if(!in_array($key, $this->keys))
        return false;
    }
    return true;
  }
}