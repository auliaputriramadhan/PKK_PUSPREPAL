<?php
ini_set('display_errors', '1');
session_start();
require_once ('./DBController.php');

$dataController = new DataController;
$redirctUrl = "http://localhost/php/crud/admin.php";

// Create => if request has post method and create action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {    
    if (isset($_POST['create'])) {
        $response = $dataController->store($_POST);
        $_SESSION['response'] = $response;
        header('Location:'.$redirctUrl);
    }
}

// Update => if request has post method and update action
if ($_SERVER['REQUEST_METHOD'] == 'POST') {   
   
    if (isset($_POST['update'])) {
        $response = $dataController->update($_POST);
        $_SESSION['response'] = $response;
        header('Location:'.$redirctUrl);
    }
}


// Delete => if request has get method and delete action
if ($_SERVER['REQUEST_METHOD'] == 'GET') {   
    if (isset($_GET['delete'])) {
        $response = $dataController->delete($_GET);
        $_SESSION['response'] = $response;
        header('Location:'.$redirctUrl);
    }
}


class DataController {
    public $conn;
    public $dbController;
    public $request = [];
    public $response = [];

    function __construct()
    {
        $this->dbController = new DBController();
        $this->conn = $this->dbController->connect();
        $this->request = $_POST;        
    }

    /**
     * Create Post
     * @param $request
     * @return response array
     */
    function store($request):array {
        $inputs = $this->sanitizeInputs($request);

        $stmt = $this->conn->prepare("INSERT INTO posts (title, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $inputs['title'], $inputs['description']);

        if ($stmt->execute()) {
            $this->response['status'] = "success";
            $this->response['message'] = "Success! Post created.";
        }

        else {
            $this->response['status'] = "failed";
            $this->response['message'] = "Failed! Post not created.";
        }

        $stmt->close();
        $this->dbController->close($this->conn);
        
        return $this->response;       
    }

    /**
     * Sanitize inputs
     * @param $request
     * @return $inputs[]
     */
    function sanitizeInputs($request):array {
        $inputs = [];
        $inputs['id_prestasi'] = trim(filter_var($this->conn->real_escape_string($request['id_prestasi']), FILTER_SANITIZE_STRING));
        $inputs['id_kategori'] = trim(filter_var($this->conn->real_escape_string($request['id_kategori']), FILTER_SANITIZE_STRING));
        $inputs['foto_prestasi'] = trim(filter_var($this->conn->real_escape_string($request['foto_prestasi']), FILTER_SANITIZE_STRING));
        $inputs['caption_prestasi'] = trim(filter_var($this->conn->real_escape_string($request['caption_prestasi']), FILTER_SANITIZE_STRING));
        $inputs['tanggal_prestasi'] = trim(filter_var($this->conn->real_escape_string($request['tanggal_prestasi']), FILTER_SANITIZE_STRING));

       
        return $inputs;
    }

    /**
     * @param NO
     * @return $response:array
     */
    function posts():array {

        $stmt = $this->conn->prepare("SELECT id_prestasi, id_kategori, foto_prestasi, caption_prestasi, tanggal_prestasi, FROM prestasi ORDER BY id_prestasi DESC");
        
        if ($stmt->execute()) {
            $result = $stmt->get_result();

            if($result->num_rows > 0) {
                $this->response  = $result->fetch_all(MYSQLI_ASSOC);
            }
        }
        
        $stmt->close();
        $this->dbController->close($this->conn);
        
        return $this->response;
    }

    /**
     * @param $id
     * @return $response:array
     */
    function post($id_prestasi):array {

        try {

            // sanitize param
            $this->checkParam($id_prestasi);

            // prepared statement
            $stmt = $this->conn->prepare("SELECT id_prestasi, id_kategori, foto_prestasi, caption_prestasi, tanggal_prestasi FROM prestasi WHERE id_prestasi = ?");
            $stmt->bind_param("i", $id);
            if($stmt->execute()) {
                $result = $stmt->get_result();
                if($result->num_rows > 0) {
                    $this->response  = $result->fetch_assoc();
                }
            }
            return $this->response;
        }
        catch (Exception $e) {
            echo $e->getMessage();
        }
    }

    /**
     * Sanitize param 
     * @param $param
     * @return int $param
     */
    function checkParam($param):int {
        return (int)filter_var($this->conn->real_escape_string($param), FILTER_SANITIZE_STRING);
    }

    /**
     * Update Post
     * @param $request
     * @return response array
     */
    function update($request):array {

        $inputs = $this->sanitizeInputs($request);
        $id = $this->checkParam($request['id_prestasi']);

        $stmt = $this->conn->prepare("UPDATE posts SET title = ?, description = ? WHERE id = ?");
        $stmt->bind_param("ssi", $inputs['id_kategori'], $inputs['foto_prestasi'], $inputs['caption_prestasi'], $inputs['tanggal_prestasi'], $id_prestasi);

        if ($stmt->execute()) {
            $this->response['status'] = "success";
            $this->response['message'] = "Success! Post updated.";
        }

        else {
            $this->response['status'] = "failed";
            $this->response['message'] = "Failed! Post not updated.";
        }

        $stmt->close();
        $this->dbController->close($this->conn);
        
        return $this->response;       
    }

     /**
     * Delete Post
     * @param $request
     * @return response array
     */
    function delete($request):array {
        $id = $this->checkParam($request['delete']);

        // prepared statement
        $stmt = $this->conn->prepare("DELETE FROM prestasi WHERE id_prestasi = ?");
        $stmt->bind_param("i", $id_prestasi);

        if($stmt->execute()) {
            $result = $stmt->get_result();
            $this->response['status'] = "success";
            $this->response['message'] = "Success! Post deleted.";
        }

        else {
            $this->response['status'] = "failed";
            $this->response['message'] = "Failed! Post not deleted.";
        }

        $stmt->close();
        $this->dbController->close($this->conn);

        return $this->response;
    }
}