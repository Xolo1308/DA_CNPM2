<?php
class AccountModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function register($username, $password, $fullname, $role) {
        $sql = "INSERT INTO tbluser (username, password, fullname, role)
                VALUES ('$username', '$password', '$fullname', '$role')";
        return $this->conn->query($sql);
    }

    public function login($username, $password, $role) {
        $sql = "SELECT * FROM tbluser 
                WHERE username='$username' AND password='$password' AND role='$role'";
        return $this->conn->query($sql);
    }
}
?>
