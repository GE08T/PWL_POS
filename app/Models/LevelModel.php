<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelModel extends Model
{
    use HasFactory;
    protected $table = 'm_level';
    protected $primaryKey = 'level_id';

    // public function user() {
    //     return $this->belongsTo(UserModel::class, 'level_id', 'level_id');
    // }
}
