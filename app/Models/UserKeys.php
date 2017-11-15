<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserKeys extends Model {
    protected $table = 'user_keys';

    protected $fillable = ['api_key'];

    public function user()
    {
        return $this->hasOne('App\Models\BotUsers', 'id', 'bot_user_id');
    }

}