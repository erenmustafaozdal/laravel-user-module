<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];



    /*
    |--------------------------------------------------------------------------
    | Get Data Metods
    |--------------------------------------------------------------------------
    */



    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Get the fullname attribute.
     *
     * @return string
     */
    public function getFullnameAttribute()
    {
        return $this->first_name.' '.$this->last_name;
    }

    /**
     * Set the is_active attribute.
     *
     * @param   boolean     $value
     * @return string
     */
    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = $value ? 1 : 0;
    }
}
