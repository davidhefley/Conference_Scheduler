<<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of location_title_db
 *      $this->room_titleID = $room_titleID;
        $this->titleID = $room_num;
        $this->room_num = $titleID;
 * @author william.remaklus
 */
class location_title_db {
    
    public static function assign_location($locationID, $titleID, $session_number, $conference_num) {// will have autogenerated id#
        $db = Database::getDB();
        $query = 'INSERT INTO location_title
                 (locationID, titleID, session_number, conference_num)
              VALUES
                 (:locationID, :titleID, :session_number, :conference_num)';
        $statement = $db->prepare($query);

        $statement->bindValue(':locationID', $locationID);
        $statement->bindValue(':titleID', $titleID);
        $statement->bindValue(':session_number', $session_number);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function select_all() {
        $db = Database::getDB();

        $queryUsers = 'SELECT * FROM location_title';
        $statement = $db->prepare($queryUsers);
        $statement->execute();
        $rows = $statement->fetchAll();
        $locations = [];

        foreach ($rows as $value) {
            $locations[$value['location_titleID']] = new locations($value['location_titleID'], $value['locationID'], $value['titleID'], $value['session_number'], $value['conference_num']);
        }
        $statement->closeCursor();

        return $locations;
    }
    
    public static function select_all_by_conference_num($conference_num) {
        $db = Database::getDB();

        $queryUsers = 'SELECT * FROM location_title where conference_num = :conference_num';
        $statement = $db->prepare($queryUsers);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $rows = $statement->fetchAll();
        $location_titles = [];

        foreach ($rows as $value) {
            $location_title[$value['location_titleID']] = new location_title($value['location_titleID'], $value['locationID'], $value['titleID'], $value['session_number'], $value['conference_num']);
        }
        $statement->closeCursor();

        return $location_titles;
    }
    
    public static function get_session_by_locationID($locationID) {
        $db = Database::getDB();
        $query = 'SELECT session
              FROM location_title
              WHERE locationID = :locationID';

        $statement = $db->prepare($query);
        $statement->bindValue(':locationID', $locationID);
        $statement->execute();
        $location_session = $statement->fetch();
        $statement->closeCursor();
        return $location_session;
    }
    
    public static function get_distinct_session_by_conference_num($conference_num) {
        $db = Database::getDB();
        $query = 'SELECT count(distinct session_number)
              FROM location_title
              where conference_num = :conference_num';

        $statement = $db->prepare($query);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $location_session = $statement->fetch();
        $statement->closeCursor();
        return $location_session;
    }
    
    public static function get_session_by_titleID($titleID) {
        $db = Database::getDB();
        $query = 'SELECT session_number
              FROM location_title
              WHERE titleID = :titleID';

        $statement = $db->prepare($query);
        $statement->bindValue(':titleID', $titleID);
        $statement->execute();
        $title_session = $statement->fetch();
        $statement->closeCursor();
        return $title_session;
    }
    
    public static function assign_title_to_location($locationID, $titleID, $session, $conference_num) {
        $db = Database::getDB();

        $query = 'INSERT INTO location_title
                 (locationID, titleID, session, conference_num)
                 VALUES
                 (:locationID, :titleID, :session, :conference_num)';
        $statement = $db->prepare($query);
        $statement->bindValue(':locationID', $locationID);
        $statement->bindValue(':titleID', $titleID);
        $statement->bindValue(':session', $session);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $statement->closeCursor();
    
        $location_titleID = $db->lastInsertId();
            return $location_titleID;
    
            
    }
    
    public static function select_with_conference_number($conference_num) {
        $db = Database::getDB();

        $queryUsers = 'SELECT locationID, titleID, session_number FROM location_title where conference_num = :conference_num';
        $statement = $db->prepare($queryUsers);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $rows = $statement->fetchAll();
        $location_titles = [];

        foreach ($rows as $value) {
            array_push($location_titles, $value['locationID'], $value['titleID'], $value['session_number']);
            
        }
        $statement->closeCursor();

        return $location_titles;
    }
    
    public static function track_conference_call() {
        $db = Database::getDB();

        $queryUsers = 'select locations.room_num, title.title_name, speakers.lName, category.category_name, location_title.session, conferences.conference_name from locations 
	join location_title on locations.locationID = location_titleID 
    join title on location_title.titleID = title.titleID 
    join title_speakers on title.titleID = title_speakers.titleID 
    join speakers on title_speakers.speakersID = speakers.speakerID 
    join conference_speakers on speakers.speakerID = conference_speakers.speakerID 
    join conferences on conference_speakers.conference_num = conferences.conference_num 
    where locationID = :locationID && titleID = :titleID && conference_num = :conference_num;';
        $statement = $db->prepare($queryUsers);
        $statement->bindValue(':locationID', $locationID);
        $statement->bindValue(':titleID', $titleID);
        $statement->bindValue(':lName', $lName);
        $statement->bindValue(':category_name', $category_name);
        $statement->bindValue(':session', $session);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $rows = $statement->fetchAll();
        $location_titles = [];

        foreach ($rows as $value) {
            $location_title[$value['location_titleID']] = new conference_speakers($value['location_titleID'], $value['locationID'], $value['titleID'], $value['lName'], $value['category_name'], $value['session'], $value['conference_num']);
        }
        $statement->closeCursor();

        return $location_titles;
    }
    
    public static function scheduled_conference_call() {
        $db = Database::getDB();

        $queryUsers = 'select locations.room_num, title.title_name, speakers.lName, location_title.session, conferences.conference_name from locations 
	join location_title on locations.locationID = location_titleID 
    join title on location_title.titleID = title.titleID 
    join title_speakers on title.titleID = title_speakers.titleID 
    join speakers on title_speakers.speakersID = speakers.speakerID 
    join conference_speakers on speakers.speakerID = conference_speakers.speakerID 
    join conferences on conference_speakers.conference_num = conferences.conference_num 
    where locationID = :locationID && titleID = :titleID && conference_num = :conference_num;';
        $statement = $db->prepare($queryUsers);
        $statement->bindValue(':locationID', $locationID);
        $statement->bindValue(':titleID', $titleID);
        $statement->bindValue(':lName', $lName);
        $statement->bindValue(':session', $session);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $rows = $statement->fetchAll();
        $location_titles = [];

        foreach ($rows as $value) {
            $location_title[$value['location_titleID']] = new conference_speakers($value['location_titleID'], $value['locationID'], $value['titleID'], $value['lName'], $value['session'], $value['conference_num']);
        }
        $statement->closeCursor();

        return $location_titles;
    }
    
    public static function get_conference_name($conference_num) {
        $db = Database::getDB();
        $query = 'SELECT conference_name
              FROM conferences
              WHERE conference_num = :conference_num';

        $statement = $db->prepare($query);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $conference_name = $statement->fetch();
        $statement->closeCursor();
        return $conference_name;
    }
    
    public static function get_speaker_name($titleID) {
        $db = Database::getDB();
        $query = 'SELECT speakers.lName from location_title join title_speakers on location_title.titleID = title_speakers.titleID join speakers on title_speakers.speakerID = speakers.speakerID where location_title.titleID = :titleID';

        $statement = $db->prepare($query);
        $statement->bindValue(':titleID', $titleID);
        $statement->execute();
        $speaker_name = $statement->fetch();
        $statement->closeCursor();
        return $speaker_name;
    }
    
    public static function get_room_num($locationID) {
        $db = Database::getDB();
        $query = 'SELECT room_num
              FROM locations
              WHERE locationID = :locationID';

        $statement = $db->prepare($query);
        $statement->bindValue(':locationID', $locationID);
        $statement->execute();
        $room_num = $statement->fetch();
        $statement->closeCursor();
        return $room_num;
    }
    
    public static function get_category_name($titleID) {
        $db = Database::getDB();
        $query = 'SELECT category.category_name from title join title_categories on title_categories.titleID = title.titleID join category on title_categories.categoryID = category.categoryID where title.titleID = :titleID';

        $statement = $db->prepare($query);
        $statement->bindValue(':titleID', $titleID);
        $statement->execute();
        $category_name = $statement->fetch();
        $statement->closeCursor();
        return $category_name;
    }
    
    public static function get_title_name($titleID) {
        $db = Database::getDB();
        $query = 'SELECT title_name
              FROM title
              WHERE titleID = :titleID';

        $statement = $db->prepare($query);
        $statement->bindValue(':titleID', $titleID);
        $statement->execute();
        $title_name = $statement->fetch();
        $statement->closeCursor();
        return $title_name;
    }
}
