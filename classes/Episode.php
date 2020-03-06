<?php

/**
 * Description of Episode
 *
 * @author User
 */
class Episode {

    var $id = null, $db = null, $bookID = null, $episodeText = null;

    public function __construct($db, $bookID, $episodeText = null) {
        $this->db = $db;
        $this->episodeText = $episodeText;
        $this->bookID = $bookID;
    }

    public function setEpisode($text) {
        $this->episodeText = $text;
    }

    public function save() {
        if (strlen(trim($this->episodeText)) < 5) {
            return 0;
        }

        $sql = "INSERT INTO episode (bookID,episodeText) VALUES($this->bookID,'$this->episodeText')";
        return $this->db->query($sql);
    }

    public function update() {
        if (strlen(trim($this->episodeText)) < 5) {
            return 0;
        }

        $sql = "UPDATE episode SET bookID=$this->bookID, episodeText='$this->episodeText' WHERE id=$this->id";
        return $this->db->query($sql);
    }

    public function delete() {
        $sql = "DELETE FROM episode WHERE id=$this->id AND bookID=$this->bookID";
        return $this->db->query($sql);
    }

}
