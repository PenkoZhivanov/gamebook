<?php

class Book {

    var $db;

    /**
     * Book id
     */
    var $id;
    var $author, $title, $description, $author_name;

    public function __construct($db, $id = null) {
        $this->db = $db;
        if ($id) {
            $this->setFields($id);
        }
    }

    private function setFields($id) {
        $book = current($this->getBookById($id));

        $this->title = $book['book_name'];
        $this->author_name = $book['firstname'] . " " . $book['lastname'];
        $this->description = $book['book_description'];
        $this->id=$id;
    }

    public function getId($param) : int{
        return $this->id;
    }

    public function getTitle($param) {
        return $this->title;
    }

    public function getAuthor($param) {
        return $this->author;
    }

    public function getDescription($param) {

        return $this->description;
    }

    /**
     * 
     * @param type $id 
     * @return type array
     */
    public function getBookById($id) {
        $sql = "SELECT * FROM Book LEFT JOIN user ON book.book_author = user.id WHERE book.id=" . $id;
        return $this->db->query($sql);
    }

    /**
     * 
     * @param type $id - author id
     * @return type array
     */
    public function getBooksByAuthorID($id) {
        $sql = "SELECT * FROM Book WHERE book_author=" . $id;
        return $this->db->query($sql);
    }

    /**
     * 
     * @param type $param - user Firstname or Lastname or Username
     * @return type array
     */
    public function getBooksByAuthorName($param) {
        $sql = "SELECT * FROM book LEFT JOIN user on book.book_author=user.id WHERE user.firstname LIKE '%$param%' OR user.lastname LIKE '%$param%' OR user.username LIKE '%$param%'";
        return $this->db->query($sql);
    }

    /**
     * 
     * @param type $bookname - Book name
     * @return type array
     */
    public function findBookByName($bookname) {
        $sql = "SELECT * FROM book WHERE boot_title LIKE %'$bookname'%";
        return $this->db->query($sql);
    }

    /**
     * 
     * @param type $param optional not used yet
     * @return type - array - all books
     */
    public function getAll($param = null) {
        return $this->db->getAll('book');
    }

    public function setAuthor($author) {
        $this->author = $author;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function setDescription($desc) {
        $this->description = $desc;
    }

    public function deleteBook($id) {
        $sql = "DELETE FROM book WHERE id=" . $id;
        $this->db->query($sql);
    }

    public function save() {
          if(!$this->validate()){
            return 0;
        }
     
        $sql = "INSERT INTO book (book_name,book_author,book_description) VALUES('$this->title',$this->author,'$this->description')";
        $this->db->query($sql);
    }

    public function update() {
          if(!$this->validate()){
            return 0;
        }
        $sql = "UPDATE book SET date_updated=CURRENT_TIMESTAMP,"
                . " book_name='$this->title',"
                . "book_author=$this->author,"
                . "book_description='$this->description' "
                . "WHERE id=" . $this->id;
        $this->db->query($sql);
    }
    
    private function validate(){
        $validator=true;
        if(strlen(trim($this->description))*strlen(trim($this->title))==0){
           $validator=false;
        }
        return $validator;
    }
}
