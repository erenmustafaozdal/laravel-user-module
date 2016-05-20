<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Cartalyst\Sentinel\Roles\EloquentRole as Sentinel;

class Role extends Sentinel
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'roles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'slug', 'permissions'];
}
