
<?php

class dataDAO
{

   const HOST = "127.0.0.1:81";

    const USERNAME = "root";

    const PASSWORD = "";

    const DATABASENAME = "greenvalley";

    private $conn;




    function __construct()
    {
        $this->conn = $this->getConnection();
    }


    public function getConnection()
    {
        $conn = new \mysqli(self::HOST, self::USERNAME, self::PASSWORD, self::DATABASENAME);

        if (mysqli_connect_errno()) {
            trigger_error("Problem with connecting to database.");
        }

        $conn->set_charset("utf8");
        return $conn;
    }

    public function getPdoConnection()
    {
        $conn = FALSE;
        try {
            $dsn = 'mysql:host=' . self::HOST . ';dbname=' . self::DATABASENAME;
            $conn = new \PDO($dsn, self::USERNAME, self::PASSWORD);
            $conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\Exception $e) {
            exit("PDO Connect Error: " . $e->getMessage());
        }
        return $conn;
    }


    public function select($query, $paramType = "", $paramArray = array())
    {
        $stmt = $this->conn->prepare($query);

        if (! empty($paramType) && ! empty($paramArray)) {

            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $resultset[] = $row;
            }
        }

        if (! empty($resultset)) {
            return $resultset;
        }
    }


    public function insert($query, $paramType, $paramArray)
    {
        $stmt = $this->conn->prepare($query);
        $this->bindQueryParams($stmt, $paramType, $paramArray);

        $stmt->execute();
        $insertId = $stmt->insert_id;
        return $insertId;
    }


    public function execute($query, $paramType = "", $paramArray = array())
    {
        $stmt = $this->conn->prepare($query);

        if (! empty($paramType) && ! empty($paramArray)) {
            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        $stmt->execute();
    }


    public function bindQueryParams($stmt, $paramType, $paramArray = array())
    {
        $paramValueReference[] = & $paramType;
        for ($i = 0; $i < count($paramArray); $i ++) {
            $paramValueReference[] = & $paramArray[$i];
        }
        call_user_func_array(array(
            $stmt,
            'bind_param'
        ), $paramValueReference);
    }

    public function getRecordCount($query, $paramType = "", $paramArray = array())
    {
        $stmt = $this->conn->prepare($query);
        if (! empty($paramType) && ! empty($paramArray)) {

            $this->bindQueryParams($stmt, $paramType, $paramArray);
        }
        $stmt->execute();
        $stmt->store_result();
        $recordCount = $stmt->num_rows;

        return $recordCount;
    }
	
	
}



function db_connect(){
		
$dbHost     = "127.0.0.1:81";
$dbUsername = "root";
$dbPassword = "";
$dbName     = "greenvalley";

	   $link = mysqli_connect($dbHost, $dbUsername, $dbPassword, $dbName)  or die("Server Connection Error!!"); 
	   //mysql_select_db($database) or die("Select Database Error!!");
	   mysqli_query($link, 'SET NAMES \'utf8\'');  
	   return $link;
	}

	function db_query( $link, $query ){
		if(!($x = mysqli_query($link, $query))) //or die("Query failed!!");
		{	echo mysqli_error($link);
			exit();
		}
		return $x;
	}

	function db_close( $link ){
	   mysqli_close($link); 
	}
	
	function db_free_result( $result ){
		mysql_free_result( $result );
	}

	
	
	function db_fetch_assoc( &$result ){
		return mysqli_fetch_assoc(  $result );
	}

 
	
