<?php

class Good
{
    public $name;
    public $meta;
// public function __toString()
// {
//     return implode(', ', [$this->name, $this->meta]);
// }
}

header('Content-Type: application/json; charset=utf-8');

$db = new PDO('mysql:host=mariadb;dbname=beta;charset=utf8', 'beta', 'beta');