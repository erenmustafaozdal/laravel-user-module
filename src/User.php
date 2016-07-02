<?php

namespace ErenMustafaOzdal\LaravelUserModule;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

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
    protected $fillable = ['first_name', 'last_name', 'email', 'password', 'is_active', 'photo','permissions'];

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
     * @param string $type  original or thumbnails key
     * @param boolean $onlyUrl
     * @return string
     */
    public function getPhoto($attributes = [], $type='original', $onlyUrl = false)
    {
        if( ! is_null($this->photo)) {
            $src  = config('laravel-user-module.user.uploads.path')."/{$this->id}/";
            $src .= $type === 'original' ? "original/{$this->photo}" : "thumbnails/{$type}_{$this->photo}";
        } else {
            $type = $type === 'original' ? 'biggest' : $type;
            $src = config('laravel-user-module.user.avatar_path') . "/{$type}.jpg";
        }

        $attr = '';
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
            $query->where('first_name', 'like', "%{$request->get('first_name')}%")
                ->orWhere('last_name', 'like', "%{$request->get('first_name')}%");
        }
        // filter status
        if ($request->has('status')) {
            $query->where('is_active',$request->get('status'));
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
     * Set password encrypted
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] =  Hash::make($password);
    }

    /**
     * Set the is_active attribute.
     *
     * @param boolean $value
     * @return string
     */
    public function setIsActiveAttribute($value)
    {
        $this->attributes['is_active'] = $value == 1 || $value === 'true' || $value === true ? true : false;
    }

    /**
     * Get the is_active attribute.
     *
     * @param boolean $value
     * @return string
     */
    public function getIsActiveAttribute($value)
    {
        return $value == 1 ? true : false;
    }

    /**
     * Get the is_super_admin attribute.
     *
     * @param boolean $value
     * @return string
     */
    public function getIsSuperAdminAttribute($value)
    {
        return $value == 1 ? true : false;
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
     * Get the last_login attribute for humans.
     *
     * @return string
     */
    public function getLastLoginForHumansAttribute()
    {
        return (is_null($this->last_login)) ? null : Carbon::parse($this->last_login)->diffForHumans();
    }

    /**
     * Get the login_at attribute for datatable.
     *
     * @return array
     */
    public function getLastLoginTableAttribute()
    {
        return is_null($this->last_login) ? ['display' => '', 'timestamp' => ''] : [
            'display'       => $this->last_login_for_humans,
            'timestamp'     => Carbon::parse($this->last_login)->timestamp,
        ];
    }

    /**
     * Get the permissions attribute.
     *
     * @param array $value
     * @return string
     */
    public function getPermissionsAttribute($value)
    {
        if ( ! $value) {
            return [];
        }

        $permissions = [];
        foreach(json_decode($value, true) as $route => $permission) {
            $permissions[$route] = $permission ? true : false;
        }
        return $permissions;
    }

    /**
     * Get the permission collect attribute.
     *
     * @return string
     */
    public function getPermissionCollectAttribute()
    {
        return $this->permissions ? collect( $this->permissions ) : collect();
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
     * Get the created_at attribute for humans.
     *
     * @return string
     */
    public function getCreatedAtForHumansAttribute()
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    /**
     * Get the created_at attribute for datatable.
     *
     * @return array
     */
    public function getCreatedAtTableAttribute()
    {
        return [
            'display'       => $this->created_at_for_humans,
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
     * Get the updated_at attribute for humans.
     *
     * @return string
     */
    public function getUpdatedAtForHumansAttribute()
    {
        return Carbon::parse($this->updated_at)->diffForHumans();
    }

    /**
     * Get the updated_at attribute for datatable.
     *
     * @return array
     */
    public function getUpdatedAtTableAttribute()
    {
        return [
            'display'       => $this->updated_at_for_humans,
            'timestamp'     => Carbon::parse($this->updated_at)->timestamp,
        ];
    }





    /*
    |--------------------------------------------------------------------------
    | Model Events
    |--------------------------------------------------------------------------
    */

    /**
     * model boot method
     */
    protected static function boot()
    {
        parent::boot();

        /**
         * model saved metod
         *
         * @param $user
         */
        parent::saved(function($user)
        {
            if (Request::has('roles')) {
                $user->roles()->sync( Request::get('roles') );
            }
        });
    }
}
