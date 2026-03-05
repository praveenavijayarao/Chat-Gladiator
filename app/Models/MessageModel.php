<?php

namespace App\Models;

use CodeIgniter\Model;

class MessageModel extends Model
{
    protected $table = 'messages';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'sender_id',
        'receiver_id',
        'message',
        'is_read',
        'created_at'
    ];

    protected $useTimestamps = false;
}