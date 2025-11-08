<?php

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new PDO('mysql:host=localhost;dbname=soundsnack;charset=utf8', 'root', '');
    }
}
