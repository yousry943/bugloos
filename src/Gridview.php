<?php
//create package for laravel library that can quickly generate a gridview response on the server.
//this is the main class that will be used to generate the gridview response.
class Gridview
{
    private $host = "localhost"; // your host name  
    private $username = "root"; // your user name  
    private $password = "root"; // your password  
    private $db = "test"; // your database name 
    private $conn; // connection variable
    private $table; // table name
    private $columns; // columns to be selected
    private $where; // where clause
    private $order; // order by clause
    private $limit; // limit clause
    private $offset; // offset clause
    private $search; // search clause
    private $searchColumns; // columns to be searched
    private $searchOperator; // search operator
    private $searchValue; // search value
    private $searchType; // search type
    private $searchValueArray; // search value array
    private $searchTypeArray; // search type array
    private $searchOperatorArray; // search operator array
    private $searchColumnsArray; // search columns array
    private $searchArray; // search array
    private $searchArrayCount; // search array count
    private $searchArrayIndex; // search array index
    private $searchArrayIndexCount; // search array index count
    private $searchArrayIndexCountArray; // search array index count array

    //constructor

    public function __construct($table)
    {
        $this->table = $table;
   
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->db);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    //set where clause

    public function where($where)
    {
        $this->where = $where;
    }

    //set order by clause

    public function order($order)
    {
        $this->order = $order;
    }

    //set limit clause

    public function limit($limit)
    {
        $this->limit = $limit;
    }

    //set offset clause

    public function offset($offset)
    {
        $this->offset = $offset;
    }

    //set search clause

    public function search($search)
    {
        $this->search = $search;
    }

    //set search columns

    public function searchColumns($searchColumns)
    {
        $this->searchColumns = $searchColumns;
    }

    //set search operator

    public function searchOperator($searchOperator)
    {
        $this->searchOperator = $searchOperator;
    }

    //set search value

    public function searchValue($searchValue)
    {
        $this->searchValue = $searchValue;
    }

    //set search type

    public function searchType($searchType)
    {
        $this->searchType = $searchType;
    }


    //get data

    public function getData()
    {
        $this->searchArray = explode(";", $this->search);
        $this->searchArrayCount = count($this->searchArray);
        $this->searchArrayIndex = 0;
        $this->searchArrayIndexCount = 0;
        $this->searchArrayIndexCountArray = array();
        $this->searchColumnsArray = explode(";", $this->searchColumns);
        $this->searchOperatorArray = explode(";", $this->searchOperator);
        $this->searchValueArray = explode(";", $this->searchValue);
        $this->searchTypeArray = explode(";", $this->searchType);
        $sql = "SELECT " . $this->columns . " FROM " . $this->table;
        if ($this->where != "") {
            $sql .= " WHERE " . $this->where;
        }
        if ($this->search != "") {
            if ($this->where != "") {
                $sql .= " AND (";
            } else {
                $sql .= " WHERE (";
            }
            for ($i = 0; $i < $this->searchArrayCount; $i++) {
                if ($this->searchArray[$i] == "AND" || $this->searchArray[$i] == "OR") {
                    $sql .= " " . $this->searchArray[$i] . " ";
                } else {
                    $sql .= $this->searchColumnsArray[$this->searchArrayIndex] . " " . $this->searchOperatorArray[$this->searchArrayIndex] . " ";
                    if ($this->searchTypeArray[$this->searchArrayIndex] == "string") {
                        $sql .= "'" . $this->searchValueArray[$this->searchArrayIndexCount] . "'";
                    } else {
                        $sql .= $this->searchValueArray[$this->searchArrayIndexCount];
                    }
                    $this->searchArrayIndexCount++;
                    $this->searchArrayIndex++;
                }
            }
            $sql .= ")";
        }
        if ($this->order != "") {
            $sql .= " ORDER BY " . $this->order;
        }
        if ($this->limit != "") {
            $sql .= " LIMIT " . $this->limit;
        }
        if ($this->offset != "") {
            $sql .= " OFFSET " . $this->offset;
        }



        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data;

    }

    //get total count

    public function getTotalCount()
    {
        $this->searchArray = explode(";", $this->search);
        $this->searchArrayCount = count($this->searchArray);
        $this->searchArrayIndex = 0;
        $this->searchArrayIndexCount = 0;
        $this->searchArrayIndexCountArray = array();
        $this->searchColumnsArray = explode(";", $this->searchColumns);
        $this->searchOperatorArray = explode(";", $this->searchOperator);
        $this->searchValueArray = explode(";", $this->searchValue);
        $this->searchTypeArray = explode(";", $this->searchType);
        $sql = "SELECT COUNT(*) AS total_count FROM " . $this->table;
        if ($this->where != "") {
            $sql .= " WHERE " . $this->where;
        }
        if ($this->search != "") {
            if ($this->where != "") {
                $sql .= " AND (";
            } else {
                $sql .= " WHERE (";
            }
            for ($i = 0; $i < $this->searchArrayCount; $i++) {
                if ($this->searchArray[$i] == "AND" || $this->searchArray[$i] == "OR") {
                    $sql .= " " . $this->searchArray[$i] . " ";
                } else {
                    $sql .= $this->searchColumnsArray[$this->searchArrayIndex] . " " . $this->searchOperatorArray[$this->searchArrayIndex] . " ";
                    if ($this->searchTypeArray[$this->searchArrayIndex] == "string") {
                        $sql .= "'" . $this->searchValueArray[$this->searchArrayIndexCount] . "'";
                    } else {
                        $sql .= $this->searchValueArray[$this->searchArrayIndexCount];
                    }
                    $this->searchArrayIndexCount++;
                    $this->searchArrayIndex++;
                }
            }
            $sql .= ")";
        }
        $result = $this->conn->query($sql);
        $data = array();
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
        }
        return $data[0]['total_count'];
    }


    public function setTable($table)
    {
        $this->table = $table;
    }

    public function setColumns($columns)
    {
        $this->columns = $columns;
    }

    public function setWhere($where)
    {
        $this->where = $where;
    }

    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function setLimit($limit)
    {
        $this->limit = $limit;
    }

    public function setOffset($offset)
    {
        $this->offset = $offset;
    }

    public function setSearch($search)
    {
        $this->search = $search;
    }

    public function setSearchColumns($searchColumns)
    {
        $this->searchColumns = $searchColumns;
    }

    public function setSearchOperator($searchOperator)
    {
        $this->searchOperator = $searchOperator;
    }

    public function setSearchValue($searchValue)
    {
        $this->searchValue = $searchValue;
    }

    public function setSearchType($searchType)
    {
        $this->searchType = $searchType;
    }



// get the server name  and folder path 
    public function getServerName()
    {
        $serverName = $_SERVER['SERVER_NAME'];
        $folderPath = $_SERVER['REQUEST_URI'];
        $folderPath = explode("/", $folderPath);
        $folderPath = $folderPath[1];
        $serverName = $serverName . "/" . $folderPath;
        return $serverName;
    }

    public function insertTable($table, $columns, $values)
    {
        $sql = "INSERT INTO " . $table . " (" . $columns . ") VALUES (" . $values . ")";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function dataJson()
    {
        $data = $this->getData();
        $total_count = $this->getTotalCount();
        $data = array(
            "total_count" => $total_count,
            "data" => $data
        );
        return json_encode($data);
    }

    public function Pagination() {
        $offset = $_GET['offset'] = isset($_GET['offset']) ? $_GET['offset'] : 0;
       $serverName = self::getServerName();
       self::setLimit(1);
       self::setOffset($_GET['offset']);
        $total_count = self::getTotalCount();
        $total_pages = ceil($total_count / $this->limit);
        $page = 1;
        $pagination = "";
     
        $pagination = array(
            "total_count" => $total_count,
             "total_page" => $total_pages,
            "current_page" => $offset,
            "limit" => $this->limit,
            "next_page" => $this->offset + 1,
            "prev_page" => $this->offset - 1,
            "first_page" => 0,
            "last_page" => $total_count - 1, 
            "first_page_url" => "$serverName"."?limit=1&offset=0",   
            "last_page_url" => "$serverName"."?limit=1&offset=" . ($total_count - 1),
            "next_page_url" => "$serverName"."?limit=1&offset=" . ($this->offset + 1),   
            "prev_page_url" => "$serverName"."?limit=1&offset=" . ($this->offset - 1),
         
            
            "data" => $this->getData()
        );
        return json_encode($pagination , JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    }

   

   

}

$Gridview = new Gridview('posts');
//$test->insertTable('posts', 'name, content', "'test', 'test'");


//  $test->setTable("posts");

  $Gridview->setColumns("id, name");
//   $Gridview->setWhere("name  LIKE '%koko%'");
   $Gridview->Search( "name LIKE '%koko%'");
   
  

 
    $Gridview->setOrder("id DESC");
    $data = $Gridview->dataJson();

//   echo  $Gridview->Pagination();







//  //$test->setLimit(1);

//$Gridview->setWhere("name='koko'");

 //echo $Gridview->Pagination();
 
   // $test->setWhere("id = 1");
 //$test->setWhere("name='koko'");
// // $test->setOrder("column1 ASC");
// // $test->setLimit("10");
// // $test->setOffset("0");
// // $test->search("AND;OR");
// // $test->searchColumns("column1;column2");
// // $test->searchOperator("LIKE;LIKE");
// // $test->searchValue("value1;value2");
// // $test->searchType("string;string");

 //echo $test->dataJson();
// $total_count = $test->getTotalCount();

 //echo $test->dataJson();


?>
