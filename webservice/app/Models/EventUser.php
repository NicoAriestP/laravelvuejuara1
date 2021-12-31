<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    use HasFactory;

    protected $table = 'event_user';

    protected $guarded = [];

    public function events()
    {
        return $this->hasOne(Event::class, 'id', 'event_id');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
