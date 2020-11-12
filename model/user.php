<?php
require_once('dao/dataDAO.php');
class user{

    private $dataDao;

    function __construct()  {
        $this->dataDao = new dataDAO();
    }

    public function isExistedUsername($username)  {
        $query = 'SELECT * FROM tbl_member where username = ?';
        $type = 's';
        $value = array($username);
        $resultArray = $this->dataDao->select($query, $type, $value);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }

    public function isExistedEmail($email){
        $query = 'SELECT * FROM tbl_member where email = ?';
        $type = 's';
        $value = array($email);
        $resultArray = $this->dataDao->select($query, $type, $value);
        $count = 0;
        if (is_array($resultArray)) {
            $count = count($resultArray);
        }
        if ($count > 0) {
            $result = true;
        } else {
            $result = false;
        }
        return $result;
    }


    public function registerUser(){
      $usernmae = $_POST["username"];
        $isExistedUsername = $this->isExistedUsername($_POST["username"]);
        $isExistedEmail = $this->isExistedEmail($_POST["email"]);
        if($_POST["username"]==""){
            $response = array("status" => "error", "message" => "Please fill all required(*).");
        }
        else if ($_POST["email"]==""){
            $response = array("status" => "error", "message" => "Please fill all required(*).");
        }
        else if ($_POST["signup-password"]==""){
            $response = array("status" => "error", "message" => "Please fill all required(*).");
        }
        else if ($_POST["confirm-password"]==""){
            $response = array("status" => "error", "message" => "Please fill all required(*).");
        }
        else if ($_POST["signup-password"]!= $_POST["confirm-password"]) {
          $response = array("status" => "error", "message" => "Confirm password must be same.");
        }
        else if(!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)){
          $response = array("status" => "error", "message" => "Please enter a valid email.");
        }

        else if ($isExistedUsername) {
            $response = array("status" => "error", "message" => "Username is already existed.");
        } else if ($isExistedEmail) {
            $response = array("status" => "error", "message" => "Email is already existed.");
        } else {
            if (isset($_POST["signup-password"])) {
                $hashedPassword = password_hash($_POST["signup-password"], PASSWORD_DEFAULT);
            }
            $query = 'INSERT INTO tbl_member (username, password, email) VALUES (?, ?, ?)';
            $type = 'sss';
            $value = array($_POST["username"],$hashedPassword,$_POST["email"]);
            $userinfo = $this->dataDao->insert($query, $type, $value);
            if (isset($userinfo)) {
                $response = array("status" => "success", "message" => "You have registered successfully.");
            }
        }
        return $response;
    }

    public function getUser($username){
        $query = 'SELECT * FROM tbl_member where username = ?';
        $type = 's';
        $value = array($username);
        $userData = $this->dataDao->select($query, $type, $value);
        return $userData;
    }

    public function loginUser(){
        $userData= $this->getUser($_POST["username"]);
        $loginPass = 0;
        if (isset($userData)) {
            if (isset($_POST["login-password"])) {
                $password = $_POST["login-password"];
            }
            $hashedPassword = $userData[0]["password"];
          
            if (password_verify($password, $hashedPassword)) {
                $loginPass = 1;
            }
        } else {
            $loginPass = 0;
        }
        if ($loginPass == 1) {
            session_start();
            $_SESSION["username"] = $userData[0]["username"];
            session_write_close();
            header("Location: ./user-page.php");
        } else if ($loginPass == 0) {
            $loginError = "Invalid username or password.";
            return $loginError;
        }
    }
	
	
}
