<?php
require_once('dao/dataDAO.php');

class admin{
    private $dataDao;

    function __construct(){
        $this->dataDao = new dataDAO();
    }

    public function getAdmin($adminname){
      $query = 'SELECT * FROM admin where adminname = ?';
      $type = 's';
      $value = array($adminname);
      $adminData = $this->dataDao->select($query, $type, $value);
      return $adminData;
    }

    public function loginAdmin(){
      $adminData = $this->getAdmin($_POST["adminname"]);
        $loginPass = 0;
        if (isset($adminData)) {
            if (isset($_POST["admin-password"])) {
                $password = $_POST["admin-password"];
            }
            $savedPassword = $adminData[0]["password"];
            if ($password == $savedPassword) {
                $loginPass = 1;
            }
        } else {
            $loginPass = 0;
        }

        if ($loginPass == 1) {
            session_start();
            $_SESSION["adminname"] = $adminData[0]["adminname"];
            session_write_close();
            header("Location: ./admin_page.php");
        } else if ($loginPass == 0) {
            $loginError = "Invalid username or password.";
            return $loginError;
        }
    }
}
