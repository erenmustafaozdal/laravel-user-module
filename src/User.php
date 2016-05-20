<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

use Carbon\Carbon;

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

    /**
     * get the html photo element
     *
     * @param array $attributes
     * @param string $type  original|thumbnail
     * @param boolean $onlyUrl
     * @return string
     */
    public function getPhoto($attributes = [], $type='thumbnail', $onlyUrl = false)
    {
        $src = config('laravel-user-module.user.avatar_url');
        $attr = '';
        if( ! is_null($this->photo)) {
            $src = config('laravel-user-module.user.upload_photo.url')."/{$this->id}/{$type}/{$this->photo}";
        }

        foreach($attributes as $key => $value) {
            $attr .= $key.'="'.$value.'" ';
        }
        return $onlyUrl ? asset($src) : '<img src="'.asset($src).'" '.$attr.'>';
    }





    /*
    |--------------------------------------------------------------------------
    | Model Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * query filter with id scope
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query, $request)
    {
        // filter id
        if ($request->has('id')) {
            $query->where('id',$request->get('id'));
        }
        // filter first_name
        if ($request->has('first_name')) {
            $query->where('first_name', 'like', "%{$request->get('first_name')}%");
        }
        // filter last_name
        if ($request->has('last_name')) {
            $query->where('last_name', 'like', "%{$request->get('last_name')}%");
        }
        // filter email
        if ($request->has('email')) {
            $query->where('email', 'like', "%{$request->get('email')}%");
        }
        // filter status
        if ($request->has('status')) {
            $query->where('is_active',$request->get('status'));
        }
        // filter last_login
        if ($request->has('last_login_from')) {
            $query->where('last_login', '>=', Carbon::parse($request->get('last_login_from')));
        }
        if ($request->has('last_login_to')) {
            $query->where('last_login', '<=', Carbon::parse($request->get('last_login_to')));
        }
        // filter created_at
        if ($request->has('created_at_from')) {
            $query->where('created_at', '>=', Carbon::parse($request->get('created_at_from')));
        }
        if ($request->has('created_at_to')) {
            $query->where('created_at', '<=', Carbon::parse($request->get('created_at_to')));
        }
        return $query;
    }





    /*
    |--------------------------------------------------------------------------
    | Model Set and Get Attributes
    |--------------------------------------------------------------------------
    */

    /**
     * Get the first_name attribute.
     *
     * @param  string $first_name
     * @return string
     */
    public function getFirstNameAttribute($first_name)
    {
        return ucfirst_tr($first_name);
    }

    /**
     * Get the last_name attribute.
     *
     * @param  string $last_name
     * @return string
     */
    public function getLastNameAttribute($last_name)
    {
        return strtoupper_tr($last_name);
    }

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
     * @param boolean $value
     * @return string
     */
    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = $value ? 1 : 0;
    }

    /**
     * Get the is_active attribute.
     *
     * @param boolean $value
     * @return string
     */
    public function getIsActiveAttribute($value)
    {
        return $value ? true : false;
    }

    /**
     * Get the login_at attribute.
     *
     * @param  $date
     * @return string
     */
    public function getLastLoginAttribute($date)
    {
        return (is_null($date)) ? null : Carbon::parse($date)->format(config('laravel-user-module.date_format'));
    }

    /**
     * Get the login_at attribute for datatable.
     *
     * @return array
     */
    public function getLastLoginTableAttribute()
    {
        return is_null($this->last_login) ? ['display' => '', 'timestamp' => ''] : [
            'display'       => Carbon::parse($this->last_login)->diffForHumans(),
            'timestamp'     => Carbon::parse($this->last_login)->timestamp,
        ];
    }

    /**
     * Get the created_at attribute.
     *
     * @param  $date
     * @return string
     */
    public function getCreatedAtAttribute($date)
    {
        return Carbon::parse($date)->format(config('laravel-user-module.date_format'));
    }

    /**
     * Get the created_at attribute for datatable.
     *
     * @return array
     */
    public function getCreatedAtTableAttribute()
    {
        return [
            'display'       => Carbon::parse($this->created_at)->diffForHumans(),
            'timestamp'     => Carbon::parse($this->created_at)->timestamp,
        ];
    }

    /**
     * Get the updated_at attribute.
     *
     * @param  $date
     * @return string
     */
    public function getUpdatedAtAttribute($date)
    {
        return Carbon::parse($date)->format(config('laravel-user-module.date_format'));
    }

    /**
     * Get the updated_at attribute for datatable.
     *
     * @return array
     */
    public function getUpdatedAtTableAttribute()
    {
        return [
            'display'       => Carbon::parse($this->updated_at)->diffForHumans(),
            'timestamp'     => Carbon::parse($this->updated_at)->timestamp,
        ];
    }
}
