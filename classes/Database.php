<?php
include_once(__DIR__ . "/../includes/config.php");
?>
<?php
class Database
{
    public $host   = DB_HOST;
    public $port   = DB_PORT;
    public $user   = DB_USER;
    public $pass   = DB_PASS;
    public $dbname = DB_NAME;

    public $conn;
    public $error;

    public function __construct()
    {
        $this->connectDB();
    }
    private function connectDB()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;port=$this->port;dbname=$this->dbname;sslmode=verify-ca;sslrootcert='../includes/ca.pem'", $this->user, $this->pass);
        } catch (PDOException $e) {
            $this->error = "Connection fail" . $e->getMessage();
            return false;
        }
    }
    public function selectNonParam($query)
    {
        try {
            $statement = $this->conn->query($query);
            $ex = $statement->fetchAll(PDO::FETCH_ASSOC);
            return $ex;
        } catch (PDOException $e) {
            throw new PDOException("error");
        }
    }
    public function selectParam($query, $params) // 
    {
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        return  $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertNonParam($query)
    {
        try {
            $statement = $this->conn->query($query);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            throw new PDOException("error");
        }
    }

    public function insertParam($query, $params)
    {
        $statement = $this->conn->prepare($query);
        $statement->execute($params);
        return $this->conn->lastInsertId();
    }

    public function updateNonParam($query)
    {

        try {
            $statement = $this->conn->prepare($query);
            $ex = $statement->execute();
            if (!$ex) throw new PDOException("error");
            return true;
        } catch (PDOException $e) {
            throw new PDOException("error");
        }
    }

    public function update($query, $params)
    {
        $statement = $this->conn->prepare($query);
        return $statement->execute($params) ? true : false;
    }

    public function delete($query, $params)
    {
        $statement = $this->conn->prepare($query);
        return $statement->execute($params) ? true : false;
    }
    public function deleteNonParam($query)
    {
        try {
            $statement = $this->conn->prepare($query);
            $ex = $statement->execute();
            if (!$ex) throw new PDOException("error");
            return true;
        } catch (PDOException $e) {
            throw new PDOException("error");
        }
    }
}
