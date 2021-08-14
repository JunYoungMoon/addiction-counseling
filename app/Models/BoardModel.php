<?php namespace App\Models;

use CodeIgniter\Model;

class BoardModel extends Model
{
    protected $table = 'board';

    protected $primaryKey = 'boardId';
    
    protected $allowedFields = ['boardId', 'id', 'password', 'title', 'content', 'boardPw', 'modifyed', 'create', 'hit'];
}