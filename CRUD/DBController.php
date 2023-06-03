<?php 

class DBController {
    public string $hostname;
    public string $dbname;
    public string $username;
    public string $password; 

    /**
     * Constructor
     * @param No
     */
    function __construct()
    {
        $this->hostname = "localhost";
        $this->dbname = "pusprepal";
        $this->username = "root";
        $this->password = "";
    }

    /**
     * Create Connection 
     * @param No
     * @return $conn
     */
    function connect() {
        $conn = new mysqli($this->hostname, $this->username, $this->password, $this->dbname);
        if($conn->connect_errno > 0) {
            die("database connection failed <br/>" . $conn->connect_error);
        }
        return $conn;
    }

    /**
     * Close connection
     * @param $conn
     * @return null
     */
    function close($conn) {
        $conn->close();
    }
}