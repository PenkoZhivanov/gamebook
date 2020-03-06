<?php

class User {

    var $firstname = null, $lastname = null, $username = null, $isAuthor = null, $id = null, $db = null, $books = [];
    var $password = null, $email = null;

    public function __construct($db, $userID = null) {
        $this->db = $db;
        if ($userID) {
            $this->setFields($userID);
        }
    }

    /**
     * 
     * @param type $id - author id
     * @abstract set user fields
     */
    private function setFields($id) {
        $result = $this->getUserById($id)[0];

        if ($result) {
            $this->firstname = $result['firstname'];
            $this->lastname = $result['lastname'];
            $this->id = $result['id'];
            $this->username = $result['username'];
            $this->isAuthor = $result['isAuthor'];
            $this->email = $result['email'];
            if ($result['isAuthor'] > 0) {
                $this->books = $this->getBooksByAuthorID($this->id);
            }
        }
    }

    /**
     * 
     * @param type $id - user id
     * @return type user data
     */
    public function getUserById($id) {

        $sql = "SELECT * FROM user WHERE id=" . $id;
        return $this->db->query($sql);
    }

    public function getEmail($email) {
        return $this->email;
    }
    public function getAllUsers() {
        $sql = "SELECT * FROM user";
        return $this->db->query($sql);
    }

    /**
     * 
     * @param type $name - First name, Last Name or username
     * @return type - array of users
     */
    public function getUserByName($name) {
        $sql = "SELECT * FROM user WHERE = user.firstname LIKE '%$name%' OR user.lastname LIKE '%$name%' OR user.username LIKE '%$name%'";
        return $this->db->query($sql);
    }

    /**
     * 
     * @param type $id - Author id
     * @return type -array of author's books
     */
    public function getBooksByAuthorID($id) {
        $sql = "SELECT * FROM Book WHERE book_author=" . $id;
        return $this->db->query($sql);
    }

    
    public function viewUser() {
        if (!$this->id) {
            return;
        }
    }

    public function setFirstName($firstname) {
        $this->firstname = $firstname;
    }

    public function setLastName($lastname) {
        $this->lastname = $lastname;
    }

    public function userName($username) {
        $this->username = $username;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setPassword($pass) {
        $this->password = $pass;
    }

    public function setAuthor($param) {
        $this->isAuthor = $param;
    }

    public function save() {
        if (!$this->validate()) {
            return 0;
        }
        $sql = "INSERT INTO user "
                . "(firstname, lastname, username, password, isAuthor, email) "
                . "VALUES('$this->firstname','$this->lastname','$this->username','$this->password', $this->isAuthor, '$this->email')";
        $this->db->query($sql);
    }

    public function update() {
        if (!$this->validate()) {
            return 0;
        }

        $sql = "UPDATE user SET firstname='$this->firstname', lastname='$this->lastname',"
                . " username='$this->username', '$this->password', isAuthor=$this->isAuthor, email='$this->email') WHERE id=" . $this->id;
        $this->db->query($sql);
    }

    public function delete() {
        $sql = "UPDATE user SET isDeleted = 1 WHERE id=$this->id";
        return $this->db->query($sql);
    }

    private function validate() {
        $validator = true;
        if (strlen(trim($this->firstname)) * strlen(trim($this->lastname)) * strlen(trim($this->username)) * strlen(trim($this->password)) * strlen(trim($this->email)) == 0) {
            $validator = false;
        }
        return $validator;
    }

}
