<?php

  class Pagamento  {

    public $id;
    public $price;
    // create object
    function __construct($id, $price) {

      $this->id = $id;
      $this->price = $price;
    }
    // print object
    function printMe(){

      echo $this->id . ": " .
           $this->price . "<br>";
    }
  }

  // COLLEGAMENTO DB + DOWNLOAD TABELLA
  $servername = "localhost";
  $username = "root";
  $password = "aspideee";
  $dbname = "Prova1";

  // Sql connection
  $conn = new mysqli($servername, $username, $password, $dbname);

  // check connection
  if ($conn->connect_errno) {

    echo $conn->connect_error;

    return;
  }
  // Query
  $sql = "
          SELECT id, status, price
          FROM pagamenti
  ";
  $result = $conn->query($sql);

  // create empty array
  $pending = [];
  $accepted = [];
  $rejected = [];

  if ($result->num_rows > 0) {
    // output data of each row
    while ($row = $result->fetch_assoc()) {
      // push obj with pending payments status
       if ($row["status"] == "pending") {
        $pending[] =  new Pagamento($row["id"], $row["price"]);
        // push obj with rejected payments status
      } if ($row["status"] == "rejected") {
        $rejected[] = new Pagamento($row["id"], $row["price"]);
        // push obj with accepted payments status
      } else if ($row["status"] == "accepted") {
        $accepted[] = new Pagamento($row["id"], $row["price"]);
      }
    }
  }

  $conn->close();

  // Print Arrays
  echo "Pending Payment:" . "<br>";
  foreach ($pending as $value) {
      $value->printMe();
  }
  echo "Rejected Payment:" . "<br>";
  foreach ($rejected as $value) {
      $value->printMe();
  }
  echo "Accepted Payment:" . "<br>";
  foreach ($accepted as $value) {
      $value->printMe();
  }

 ?>
