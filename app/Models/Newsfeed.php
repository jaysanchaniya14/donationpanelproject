<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class Newsfeed extends Model
{
    use HasFactory;

    protected $casts = [
        'media' => 'array',
        'is_liked' => 'boolean'
    ];


    public function likes(){
        return $this->hasMany(NewsfeedLike::class, 'feed_id');
    }

    public function project(){
        return $this->belongsTo(Project::class)->with(['parent_project', 'donations'])
            ->where('is_active', 1);
    }

    public function donation(){
        return $this->belongsTo(Donation::class)
            ->select('id', 'project_id', 'user_id', 'amount', 'created_at')
            ->where('payment_status', 'success');
    }

    public function user(){
        return $this->belongsTo(User::class)
            ->select('id', 'first_name', 'last_name', 'profile');
    }

}
