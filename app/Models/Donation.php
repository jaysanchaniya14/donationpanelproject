<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use HasFactory;

    protected $appends = [
        'profile',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function project(){
        return $this->belongsTo(Project::class)->with('parent_project');
    }

    public function getProfileAttribute(){
        if($user = $this->user()->first()){
            return $user->profile;
        }
        return null;
    }
}
