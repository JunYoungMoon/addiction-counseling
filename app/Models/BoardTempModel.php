<?php namespace App\Models;

use CodeIgniter\Model;

class BoardTempModel extends Model
{
    protected $table = 'boardtemp';

    protected $primaryKey = 'boardTempId';
    
    protected $allowedFields = ['boardTempId','id', 'title', 'content', 'create'];
}