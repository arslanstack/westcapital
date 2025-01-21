<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    use HasFactory;

    protected $table = 'configs';

    protected $fillable = [
        'key',
        'value',
    ];

    public function getAppName(){
        return $this->where('key', 'app_name')->first()->value;
    }

    public function getAppOwner(){
        return $this->where('key', 'app_owner')->first()->value;
    }

    public function getApiUsername(){
        return $this->where('key', 'api_username')->first()->value;
    }

    public function getApiPassword(){
        return $this->where('key', 'api_password')->first()->value;
    }

    public function getApiTitle(){
        return $this->where('key', 'api_title')->first()->value;
    }

    public function getSessionId(){
        return $this->where('key', 'session_id')->first()->value;
    }

}
