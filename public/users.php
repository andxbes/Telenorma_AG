<?php

// INSERT INTO `users` (`ID`, `first_name`, `last_name`, `position_id`) VALUES (NULL, 'Lindsay', 'Walton', 1);
// INSERT INTO `users` (`ID`, `first_name`, `last_name`, `position_id`) VALUES (NULL, 'Courtney', 'Henry', 2);
// INSERT INTO `users` (`ID`, `first_name`, `last_name`, `position_id`) VALUES (NULL, 'Tom', 'Cook', 3); 

header('Content-Type: application/json; charset=utf-8');
$users = new Users();
switch ($_SERVER['REQUEST_METHOD']) {
    case 'DELETE':
        $users->delete_user(filter_input(INPUT_GET, 'user_id', FILTER_SANITIZE_NUMBER_INT));
        break;
    // case 'PUT': // Как оказалось пыха не поддерживает данный метод, тут в большей степени можно обработать но дописывать самому обработку данных 
    //     break; 
    case 'POST':
        if (!empty($user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT))) {
            $users->update_user($user_id);
        } else {
            $users->add_user();
        }
        break;
    case 'OPTIONS':
        break;
    case 'GET':
    default:
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

    public function update_user($user_id)
    {
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        $sql = "UPDATE `users` 
                SET first_name = :first_name, last_name = :last_name, position_id = (
                    SELECT id 
                    FROM positions 
                    WHERE positions.position = :position 
                    LIMIT 1
                    ) 
                WHERE `users`.`id` = :user_id;";

        $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY])->execute([
            ':user_id' => $user_id,
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':position' => $position
        ]);

    }

    public function add_user()
    {
        $first_name = filter_input(INPUT_POST, 'first_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $last_name = filter_input(INPUT_POST, 'last_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $position = filter_input(INPUT_POST, 'position', FILTER_SANITIZE_FULL_SPECIAL_CHARS);


        $sql = "INSERT INTO `users` (`ID`, `first_name`, `last_name`, `position_id`) 
                VALUES (NULL, :first_name, :last_name, (
                    SELECT id 
                    FROM positions 
                    WHERE positions.position = :position 
                    LIMIT 1
                ));";
        $sth = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $sth->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':position' => $position
        ]);


    }

    public function delete_user($id)
    {
        $sql = "DELETE FROM users WHERE `users`.`id` = ? ;";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
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