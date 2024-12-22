<?php

class Model{
  public function __construct( 
    private mysqli $conn,
    private string $table,
    private array $requiredKeys
  ) {}

  public function getAll(): array
  {
    $sql_select = "SELECT * FROM users";
    $result = $this->conn->query($sql_select);
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getById(int $id)
  {
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
    $getQuery->execute();
    $result = $getQuery->get_result();
    return $result->fetch_assoc();
    // fetch_assoc says it's going to return an array, cause it returns an associative array (HashMap)
  }

  public function create($obj)
  {
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
    return $insertQuery->execute();
  }

  public function updateById(int $id, array $obj)
  {
    if(!$this->confirmUpdateSchema($obj)){
      echo "Bad Object Signature";
      return false;
    }
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
    return $updateQuery->execute();
  }

  public function delete(int $id)
  {
    $deleteQuery = $this->conn->prepare("
      DELETE FROM $this->table
      WHERE id=?;
    ");
    $deleteQuery->bind_param('i', $id);
    return $deleteQuery->execute();
  }
  
  private function getParamType($value)
  {
    if(is_int($value))
      return 'i';
    if(is_float($value))
      return 'd';
    if(is_string($value))
      return 's';
    return 'b';
  }

  private function confirmInsertSchema($obj)
  {
    $obj_keys = array_keys($obj);
    if(count($obj_keys) !== count($this->requiredKeys))
      return false;
    foreach($this->requiredKeys as $key){
      if(!array_key_exists($key, $obj))
        return false;
    }
    return true;
  }

  private function confirmUpdateSchema($obj)  // we check that the update object keys fit the criteria
  {
    $obj_keys = array_keys($obj);
    if(count($obj_keys) > count($this->requiredKeys))
      return false;
    foreach($obj_keys as $key){
      if(!in_array($key, $this->requiredKeys))
        return false;
    }
    return true;
  }
}