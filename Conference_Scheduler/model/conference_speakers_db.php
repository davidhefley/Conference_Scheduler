<?php

//conference_titleID
//titleID
//
//$conference_titleID
//$titleID
//need to add fields to finish
class conference_speakers_db {
    
    public static function select_all() {
        $db = Database::getDB();

        $queryUsers = 'SELECT * FROM conference_speakers';
        $statement = $db->prepare($queryUsers);
        $statement->execute();
        $rows = $statement->fetchAll();
        $conferences_speakers = [];

        foreach ($rows as $value) {
            $conferences_speakers[$value['conference_titleID']] = new conference_speakers($value['conference_titleID'], $value['titleID']);
        }
        $statement->closeCursor();

        return $conferences_speakers;
    }
    
    public static function get_titles_by_with_category_conference_num($conference_num) {
    $db = Database::getDB();
    $query = 'SELECT titleID, categoryID FROM title_category join conference_speakers on title_category.titleID = conference_speakers.titleID WHERE conference_num = :conference_num order by titleID;';
    $statement = $db->prepare($query);
    $statement->bindValue(':conference_num', $conference_num);
    $statement->bindValue(':titleID', $titleID);
    $statement->execute();
    $rows = $statement->fetchAll();
    $conference_titles  = [];

        foreach ($rows as $value) {
            array_push($conference_titles, $value['titleID'], $value['categoryID']);
        }
        $statement->closeCursor();

        return $conference_titles;
}

    public static function get_titles_by_conference_num($conference_num) {
    $db = Database::getDB();
    $query = 'SELECT titleID FROM conference_speakers WHERE conference_num = :conference_num order by titleID;';
    $statement = $db->prepare($query);
    $statement->bindValue(':conference_num', $conference_num);
    $statement->bindValue(':titleID', $titleID);
    $statement->execute();
    $rows = $statement->fetchAll();
    $conference_titles  = [];

        foreach ($rows as $value) {
            array_push($conference_titles, $value['titleID']);
        }
        $statement->closeCursor();

        return $conference_titles;
}


    public static function add_conference_title($titleID, $conference_num) {
    $db = Database::getDB();

    $query = 'INSERT INTO conference_speakers
                 (titleID, conference_num)
              VALUES
                 (:titleID, :conference_num)';
    $statement = $db->prepare($query);
    $statement->bindValue(':titleID', $titleID);
    $statement->bindValue(':conference_num', $conference_num);
    $statement->execute();
    $statement->closeCursor();
    
     $user_id = $db->lastInsertId();
            return $user_id;
    
            
    }
    
    public static function delete_by_ID($conference_titleID) {
        $db = Database::getDB();
        $query = 'DELETE from conference_speakers WHERE conference_titleID = :conference_titleID';
        try {
            $statement = $db->prepare($query);
            $statement->bindValue(':title_speakerID', $conference_titleID);
            $row_count = $statement->execute();
            $statement->closeCursor();
            return $row_count;
        } catch (PDOException $e) {
            $error_message = $e->getMessage();
            display_db_error($error_message);
        }
    }
    
    public static function get_distinct_category_count_for_conference($conference_num) {
        $db = Database::getDB();
    
        $query = 'SELECT count(distinct title_category.categoryID) FROM title_category join conference_speakers on title_category.titleID = conference_speakers.titleID WHERE conference_num = :conference_num;';
        $statement = $db->prepare($query);
        $statement->bindValue(':$conference_num', conference_num);
        $statement->execute();
        $row = $statement->fetch();
        $statement->closeCursor();
    
        return new conference_count($row['conference_count']);
    }
    
    public static function get_categories_in_conference($conference_num) {
        $db = Database::getDB();

        $queryUsers = 'select category.categoryID FROM title_category join conference_speakers on title_category.titleID = conference_speakers.titleID WHERE conference_speakersID = conference_num order by category.categoryID;';
        $statement = $db->prepare($queryUsers);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->bindValue(':categoryID', $categoryID);
        $statement->execute();
        $rows = $statement->fetchAll();
        $conferences_categories = [];

        foreach ($rows as $value) {
            array_push($conferences_categories, $value['categoryID']);
        }
        $statement->closeCursor();

        return $conferences_categories;
    }
    
    public static function get_title_count_by_category_in_conference($conference_num) {
        $db = Database::getDB();

        $queryUsers = 'select count(titleID.title_category), category.categoryID FROM title_category join conference_speakers on title_category.titleID = conference_speakers.titleID WHERE conference_num = :conference_num group by category.categoryID;';
        $statement = $db->prepare($queryUsers);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->bindValue(':categoryID', $categoryID);
        $statement->bindValue(':titleID', $titleID);
        $statement->execute();
        $rows = $statement->fetchAll();
        $conferences_categories = [];

        foreach ($rows as $value) {
            array_push($conferences_categories, $value['categoryID'], $value['count(titleID)']);
        }
        $statement->closeCursor();

        return $conferences_categories;
    }
    
    public static function get_title_count_conference($conference_num) {
        $db = Database::getDB();

        $queryUsers = 'select count(titleID), FROM conference_speakers WHERE conference_num = :conference_num;';
        $statement = $db->prepare($queryUsers);
        $statement->bindValue(':conference_num', $conference_num);
        $statement->bindValue(':titleID', $titleID);
        $statement->execute();
        $rows = $statement->fetch();

        return $rows;
    }
}

