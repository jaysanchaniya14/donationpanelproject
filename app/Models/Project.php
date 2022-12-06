<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $with = [
        'images',
    ];

    protected $appends = [
        'raised_amount',
        'donor_count',
        'donated_qty',
        'percentage_goal_reached',
    ];

    public function images(){
        return $this->hasMany(ProjectImage::class);
    }

    public function donations(){
        return $this->hasMany(Donation::class)
            ->select('id', 'user_id', 'project_id', 'amount')
            ->where('payment_status', 'success')
            ->orderBy('amount', 'desc')
            ->limit(5);
    }

    public function sub_projects(){
        return $this->hasMany(Project::class, 'parent_id', 'id');
    }

    public function getRaisedAmountAttribute(){
        return Donation::where('project_id', $this->id)
            ->where('payment_status', 'success')->sum('amount');
    }

    public function getDonorCountAttribute(){
        return Donation::where('project_id', $this->id)
            ->where('payment_status', 'success')->count();
    }

    public function getDonatedQtyAttribute(){
        return (int) Donation::where('project_id', $this->id)
            ->where('payment_status', 'success')->sum('qty');
    }

    public function getPercentageGoalReachedAttribute(){
        if($this->type == "fixed_goal"){
            $val = floatval(number_format($this->raised_amount * 100/ $this->goal, 2, '.', ''));
            return $val > 100 ? 100.00 : $val;
        }
        else{
             return 0;
        }
    }

    public function parent_project(){
        return $this->belongsTo(Project::class, 'parent_id', 'id')->without('images');
    }

    public function newsfeed(){
        return $this->hasMany(Newsfeed::class, 'project_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    protected $casts = [
        'is_active' => 'boolean',
        'is_completed' => 'boolean',
        'donation_type' => 'array',
    ];
}
