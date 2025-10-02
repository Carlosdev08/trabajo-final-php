<?php
namespace App\Models;


use Core\DB;
use PDO;


abstract class BaseModel
{
    protected PDO $pdo;


    public function __construct()
    {
        $this->pdo = DB::pdo();
    }
}