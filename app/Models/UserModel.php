<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email', 'password', 'name'];
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    public function getUserByEmail($email)
    {
        return $this->where('email', $email)->first();
    }

    public function getAllUsersExcept($userId)
    {
        return $this->where('id !=', $userId)->findAll();
    }
}
