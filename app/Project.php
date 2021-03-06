<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use SoftDeletes;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'projects';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function projectLead()
    {
        return $this->belongsTo(User::class, 'project_lead');
    }

    public function members()
    {
        return $this->hasMany(ProjectMember::class, 'user_id');
    }

    public function status()
    {
        return $this->belongsTo(ProjectStatus::class, 'project_status_id');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

}
