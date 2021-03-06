<?php

//locationID
//bldg_name
//room_num
//need to edit field names
class locations_db {
    
     public static function select_all() {
        $db = Database::getDB();

        $queryUsers = 'SELECT * FROM locations';
        $statement = $db->prepare($queryUsers);
        $statement->execute();
        $rows = $statement->fetchAll();
        $locations = [];

        foreach ($rows as $value) {
            $locations[$value['locationID']] = new locations($value['locationID'], $value['bldg_name'], $value['room_num']);
        }
        $statement->closeCursor();

        return $locations;
    }
    
    
    public static function get_location($locationID) {
        $db = Database::getDB();
        $query = 'SELECT * FROM locations
              WHERE locationID = :locationID';
        $statement = $db->prepare($query);
        $statement->bindValue(':locationID', $locationID);
        $statement->execute();
        $row = $statement->fetch();

        $statement->closeCursor();
        return new locations(
                $row['locationID'], $row['bldg_name'], $row['room_num']);

    }

    public static function get_locations($bldg_name) {
        $db = Database::getDB();

        $queryLocations = 'SELECT *'
                . 'FROM locations '
                . 'WHERE bldg_name = :bldg_name';

        $statement = $db->prepare($queryLocations);
        $statement->bindValue(':bldg_name', $bldg_name);
        $statement->execute();
        $rows = $statement->fetchAll();


        $locations = [];
        foreach ($rows as $row) {
            $locations[$row['bldg_name']] = new locations($value['locationID'], $value['bldg_name'], $value['room_num']);
        }

        $statement->closeCursor();
        return $locations;
    }
    
    public static function add_location($bldg_name, $room_num) {
        $db = Database::getDB();
        $query = 'INSERT INTO locations
                 (bldg_name, room_num)
              VALUES
                 (:bldg_name, :room_num)';
        $statement = $db->prepare($query);

        $statement->bindValue(':bldg_name', $bldg_name);
        $statement->bindValue(':room_num', $room_num);
        $statement->execute();
        $statement->closeCursor();
    }

    public static function update_location($locationID, $bldg_name, $room_num) {
        $db = Database::getDB();
        $query = 'UPDATE locations
              SET bldg_name = :bldg_name,
                  room_num = :room_num
              WHERE locationID = :locationID';
        $statement = $db->prepare($query);
        $statement->bindValue(':bldg_name', $bldg_name);
        $statement->bindValue(':room_num', $room_num);
        $statement->bindValue(':locationID', $locationID);
        $statement->execute();
        $statement->closeCursor();
    }
    
    public static function get_location_with_conference_num($conference_num) {
        $db = Database::getDB();
        $query = 'SELECT locationID FROM locations join conference_locations as locations.locationID = conference_locations.locationID join conferences as conference_locations.conference_num = conference.conference_num WHERE conference_num = :conference_num';
        $statement = $db->prepare($query);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $row = $statement->fetch();

        $statement->closeCursor();
        return new locations(
                $row['locationID'], $row['bldg_name'], $row['room_num']);

    }
    
    public static function get_locationID_with_conference_num($conference_num) {
        $db = Database::getDB();
        $query = 'SELECT conference_locations.locationID FROM conference_locations WHERE conference_num = :conference_num';
        $statement = $db->prepare($query);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->execute();
        $rows = $statement->fetchAll();
        
        $locations = [];
        
        foreach ($rows as $value) {
            array_push($locations, $value['locationID']);
        }

        $statement->closeCursor();
        return $locations;

    }
    

}
?>

