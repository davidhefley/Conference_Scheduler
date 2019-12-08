<?php


class track_conference {
    private $room_num, $title_name, $lName,  $category_name, $session_number, $conference_name;
    function __construct($room_num, $title_name, $lName, $category_name, $session_number, $conference_name) {
        
        
        $this->room_num = $room_num;
        $this->title_name = $title_name;
        $this->lName = $lName;
        $this->category_name = $category_name;
        $this->session_number = $session_number;
        $this->conference_name = $conference_name;
        
        
        
    }
    
    function getRoom_num() {
        return $this->room_num;
    }
    
    function getTitle_name() {
        return $this->title_name;
    }

    function getLName() {
        return $this->lName;
    }
    
    function getCategory_name() {
        return $this->category_name;
    }
    
    function getSession_number() {
        return $this->session_number;
    }
    
    function getConference_name() {
        return $this->conference_name;
    }

    function setRoom_num($room_num) {
        $this->room_num = $room_num;
    }

    function setTitle_name($title_name) {
        $this->title_name = $title_name;
    }

    function setLName($lName) {
        $this->lName = $lName;
    }
    
    function setCategory_name($category_name) {
        $this->category_name = $category_name;
    }
    
    function setSession_number($session_number) {
        $this->session_number = $session_number;
    }    
    
    function setConference_name($conference_name) {
        $this->conference_name = $conference_name;
    }
}
