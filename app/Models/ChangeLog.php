<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    protected $fillable = ['entity_type', 'entity_id', 'old_value', 'new_value', 'change_type', 'user_id'];
}
