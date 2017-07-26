<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * Mass assignable attributes
     *
     * @var array
     */
    protected $fillable = ['title', 'description'];
    
    /**
     * User that owns the task
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Returns created date diff in human readable format
     * 
     * @return string
     */
    public function getHumanDiffDate() :string 
    {
        return Carbon::createFromTimeStamp(strtotime($this->created_at))->diffForHumans();
    }
}
