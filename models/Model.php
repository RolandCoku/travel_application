<?php

abstract class Model
{
  public function __construct(
    protected readonly mysqli $conn,
    protected readonly string $table,
    private readonly array    $requiredKeys
  ) {}

  public function getAll(): array
  {
    $sql_select = "SELECT * FROM $this->table";
    $result = $this->conn->query($sql_select);
    return $result->fetch_all(MYSQLI_ASSOC);
  }

  public function getById(int $id): false|array|null
  {
    $queryString = "SELECT * FROM $this->table
                        WHERE id=?;
                        ";

    $getQuery = $this->conn->prepare("$queryString");

    $getQuery->bind_param('i', $id);
    $getQuery->execute();
    $result = $getQuery->get_result();

    return $result->fetch_assoc();
    // fetch_assoc says it's going to return an array, cause it returns an associative array (HashMap)
  }

  public function create($obj): bool|string
  {
    if (!$this->confirmInsertSchema($obj))
      return "Bad Object Signature";

    $columns = array_keys($obj);
    $values = array_values($obj);
    $columnString = implode(", ", $columns);
    $valueString = implode(", ", array_fill(0, count($columns), "?"));

    $insertQuery = $this->conn->prepare("INSERT INTO $this->table ($columnString) 
                                                   VALUES ($valueString);
                                            ");

    $types = '';

    foreach ($values as $value) {
      $types .= $this->getParamType($value);
    }

    $insertQuery->bind_param($types, ...$values);
    $returnVal = $insertQuery->execute();
    $insertQuery->close();

    return $returnVal;
  }

  public function createAndGetId($obj)
  {
    // if (!$this->confirmInsertSchema($obj))
    //       return "Bad Object Signature";
    if (!$this->confirmUpdateSchema($obj))
      return null;

    $columns = array_keys($obj);
    $values = array_values($obj);
    $columnString = implode(", ", $columns);
    $valueString = implode(", ", array_fill(0, count($columns), "?"));

    $insertQuery = $this->conn->prepare("INSERT INTO $this->table ($columnString) 
                                                   VALUES ($valueString);
                                            ");

    $types = '';

    foreach ($values as $value) {
      $types .= $this->getParamType($value);
    }

    $insertQuery->bind_param($types, ...$values);

    if (!$insertQuery->execute()) {
      $insertQuery->close();
      return null;
    }
    $insertQuery->close();

    return $insertQuery->insert_id;
  }

  public function updateById(int $id, array $obj): bool
  {
    if (!$this->confirmUpdateSchema($obj)) {
      echo "Bad Object Signature";
      return false;
    }

    $columns = array_keys($obj);
    $values = array_values($obj);
    $setStatement = implode("=?, ", $columns) . "=?"; // will make a col1=?, col2=?, ...

    $updateQuery = $this->conn->prepare("UPDATE $this->table
                                                   SET $setStatement
                                                   WHERE id=?;
                                            ");
    $types = '';

    foreach ($values as $value) {
      $types .= $this->getParamType($value);
    }

    $types .= 'i'; // for the id

    $valuesAndId = [...$values, $id]; // adding the id to be bound

    $updateQuery->bind_param($types, ...$valuesAndId);
    $returnVal = $updateQuery->execute();
    $updateQuery->close();
    return $returnVal;
  }

  public function update($data): bool // this should be fine right?
  {
    $id = $data['id'];
    unset($data['id']);
    return $this->updateById($id, $data);
  }

  public function delete(int $id): bool
  {
    $deleteQuery = $this->conn->prepare("DELETE FROM $this->table
                                                   WHERE id=?;
                                            ");

    $deleteQuery->bind_param('i', $id);
    $returnVal = $deleteQuery->execute();
    $deleteQuery->close();
    return $returnVal;
  }

  public function paginate(int $page, int $limit, array $keys): array
  {
    $offset = ($page - 1) * $limit;
    if (empty($keys)) {
      $queryString = "SELECT * FROM $this->table
                            LIMIT ? OFFSET ?;
                            ";
    } else {
      $columns = implode(", ", $keys);
      $queryString = "SELECT $columns FROM $this->table
                            LIMIT ? OFFSET ?;
                            ";
    }
    $getQuery = $this->conn->prepare("$queryString");

    $getQuery->bind_param('ii', $limit, $offset);
    $getQuery->execute();
    $result = $getQuery->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
      $data[$row['id']] = $row;
    }

    //Set the current page and the total number of pages
    $currentPage = $page;
    $totalPages = ceil($this->conn->query("SELECT COUNT(*) FROM $this->table")->fetch_row()[0] / $limit);

    return [
      'currentPage' => $currentPage,
      'totalPages' => $totalPages,
      'data' => $data
    ];
  }

  public function countByDateRange($startDate, $endDate)
  {
    $queryString = "SELECT COUNT(*) FROM $this->table
                        WHERE created_at BETWEEN ? AND ?;
                        ";

    $getQuery = $this->conn->prepare("$queryString");

    $getQuery->bind_param('ss', $startDate, $endDate);
    $getQuery->execute();
    $result = $getQuery->get_result();

    return $result->fetch_row()[0];
  }

  public function getByDateRange($startDate, $endDate): array
  {
    $queryString = "SELECT * FROM $this->table
                        WHERE created_at BETWEEN ? AND ?;
                        ";

    $getQuery = $this->conn->prepare("$queryString");

    $getQuery->bind_param('ss', $startDate, $endDate);
    $getQuery->execute();
    $result = $getQuery->get_result();

    $data = [];
    while ($row = $result->fetch_assoc()) {
      $data[$row['id']] = $row;
    }

    return $data;
  }

  public function searchInColumns(string $searchString, array $columns)
  {
    if (empty($columns)) {
      return []; // Return empty array if no columns are provided
    }

    $queryString = "SELECT * FROM " . $this->table . " WHERE ";
    $conditions = [];

    foreach ($columns as $column) {
      // Sanitize the column name (VERY IMPORTANT!)
      $safeColumn = preg_replace('/[^a-zA-Z0-9_]/', '', $column);
      $conditions[] = "`" . $safeColumn . "` LIKE ?";
    }

    $queryString .= implode(" OR ", $conditions);

    $stmt = $this->conn->prepare($queryString);
    if ($stmt === false) {
      error_log("Prepare failed: " . $this->conn->error);
      return [];
    }

    // Bind the search string to each parameter
    $bindParams = array_fill(0, count($columns), "%" . $searchString . "%");
    $types = str_repeat('s', count($columns));

    $stmt->bind_param($types, ...$bindParams);

    if ($stmt->execute() === false) {
      error_log("Execute failed: " . $stmt->error);
      $stmt->close();
      return [];
    }

    $result = $stmt->get_result();
    if ($result === false) {
      error_log("get_result failed: " . $stmt->error);
      $stmt->close();
      return [];
    }

    $data = $result->fetch_all(MYSQLI_ASSOC);
    $stmt->close();
    return $data;
  }

  private function getParamType($value): string
  {
    if (is_int($value))
      return 'i';
    if (is_float($value))
      return 'd';
    if (is_string($value))
      return 's';
    return 'b';
  }

  private function confirmInsertSchema($obj): bool
  {
    $obj_keys = array_keys($obj);

    if (count($obj_keys) !== count($this->requiredKeys))
      return false;

    foreach ($this->requiredKeys as $key) {
      if (!array_key_exists($key, $obj))
        return false;
    }
    return true;
  }

  private function confirmUpdateSchema($obj): bool  // we check that the update object keys fit the criteria
  {
    $obj_keys = array_keys($obj);
    // if (count($obj_keys) > count($this->requiredKeys))
    //     return false;

    foreach ($obj_keys as $key) {
      if (!in_array($key, $this->requiredKeys))
        return false;
    }

    return true;
  }
}
