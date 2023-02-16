<?php

// INSERT INTO `users` (`ID`, `first_name`, `last_name`, `position_id`) VALUES (NULL, 'Lindsay', 'Walton', 1);
// INSERT INTO `users` (`ID`, `first_name`, `last_name`, `position_id`) VALUES (NULL, 'Courtney', 'Henry', 2);
// INSERT INTO `users` (`ID`, `first_name`, `last_name`, `position_id`) VALUES (NULL, 'Tom', 'Cook', 3); 
header('Content-Type: application/json; charset=utf-8');
switch ($_SERVER['REQUEST_METHOD']) {
    case 'DELETE':
        break;
    case 'PUT':
        break;
    case 'POST':
        break;
    case 'GET':
    default:
        $users = new Users();
        print json_encode($users->get_users());
}

class Users
{
    // private $users;
    private $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=mariadb;dbname=beta;charset=utf8', 'beta', 'beta');
    }

    public function get_users()
    {
        return $this->db->query('
        SELECT 
            users.id AS id ,
            users.first_name AS first_name,
            users.last_name AS last_name,
            positions.position AS position
        FROM `users` INNER JOIN `positions` 
        ON users.position_id = positions.id 
        LIMIT 1000;
        ')->fetchAll(PDO::FETCH_CLASS, 'User');
    }
    public function get_user($id)
    {

    }

    public function update_user()
    {

    }

    public function add_user()
    {

    }

    public function delete_user($id)
    {

    }

    public function __destruct()
    {
        $this->db = null;
    }
}

class User
{
    public $id;
    public $first_name;
    public $last_name;
    public $position;
}