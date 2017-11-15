<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BotUsers extends Model {
    protected $table = 'bot_users';

    public function keys()
    {
        return $this->hasMany('App\Models\UserKeys', 'bot_user_id', 'id');
    }

}