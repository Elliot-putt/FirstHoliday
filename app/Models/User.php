<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;
use phpDocumentor\Reflection\Types\False_;
use Spatie\MediaLibrary\HasMedia as HasMediaAlias;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements HasMediaAlias {

    use HasApiTokens, HasFactory, Notifiable, InteractsWithMedia;

    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    /////////////////////////////////////////////
    /////// user get and set attributes/////////
    /////////////////////////////////////////////
    public function name(): Attribute
    {
        return new Attribute(
            fn($value) => ucfirst(str_replace('_', ' ', $value)),
            fn($value) => strtolower($value),
        );
    }

    public function email(): Attribute
    {
        return new Attribute(
            fn($value) => strtolower($value),
            fn($value) => strtolower($value),
        );
    }

    public function username(): Attribute
    {
        return new Attribute(
            fn($value) => ucwords($value),
            fn($value) => strtolower($value),
        );
    }
    //////////////////////////////////////////////
    //////// User username generator ////////////
    /////////////////////////////////////////////
    public function generateUsername(): string
    {
        return $this->name[0] . Carbon::now()->format('d') . $this->name[0] . $this->id;
    }
    public static  function gUsername( string $string = '' ,int $id = 1): string
    {
        return Str::random(30);
    }
    //////////////////////////////////////////////
    //////// User Password generator ////////////
    /////////////////////////////////////////////
    public function random_password($length): string
    {
        //A list of characters that can be used in our
        //random password.
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!-.[]?*()';
        //Create a blank string.
        $password = '';
        //Get the index of the last character in our $characters string.
        $characterListLength = mb_strlen($characters, '8bit') - 1;
        //Loop from 1 to the $length that was specified.
        foreach(range(1, $length) as $i)
        {
            $password .= $characters[random_int(0, $characterListLength)];
        }

        return $password;
    }
    public static function rpassword($length): string
    {
        //A list of characters that can be used in our
        //random password.
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!-.[]?*()';
        //Create a blank string.
        $password = '';
        //Get the index of the last character in our $characters string.
        $characterListLength = mb_strlen($characters, '8bit') - 1;
        //Loop from 1 to the $length that was specified.
        foreach(range(1, $length) as $i)
        {
            $password .= $characters[random_int(0, $characterListLength)];
        }

        return $password;
    }

    //Spatie Media library allows file uploads
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('Profile');
    }

    public function Photo()
    {
        return $this->getFirstMediaUrl('Profile');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_users');
    }

    public function companiesArray()
    {
        return auth()->user()->companies()->pluck('company_id')->toArray();
    }

    public function hasCompany($id)
    {
        $array = $this->companies()->pluck('company_id')->toArray();
        if(in_array($id, $array))
        {
            return false;
        } else
        {
            return true;
        }
    }

    public function scopeUsernameFilter($query, $username)
    {
        return $query->where('username', 'LIKE', '%' . $username . '%');
    }

    public function enableNotification()
    {
        foreach(Setting::where('name', 'Like', '%' . 'notifications' . '%')->get() as $notification)
        {

            $setting = $notification;
            $value = $setting->value;
            if($value == null)
            {

                $array = [];
                $array[] = $this->id;
                $setting->value = serialize($array);
                $setting->save();
            } else if(! in_array($this->id, unserialize($setting->value)))
            {
                //if the user is not in the array but there is an array already created add the current user into the array field
                $array = unserialize($setting->value);
                $array[] = $this->id;
                $setting->value = serialize($array);
                $setting->save();
            }
        }

    }
    public function enableCalendar()
    {
        $calendar = Setting::whereName('calendar')->first();
        if($calendar){

            $setting = $calendar;
            $value = $setting->value;
            if($value == null)
            {
                $array = [];
                $array[] = $this->id;
                $setting->value = serialize($array);
                $setting->save();
            } else if(! in_array($this->id, unserialize($setting->value)))
            {
                //if the user is not in the array but there is an array already created add the current user into the array field
                $array = unserialize($setting->value);
                $array[] = $this->id;
                $setting->value = serialize($array);
                $setting->save();
            }
        }

    }

    public function hours()
    {
        return $this->morphMany(Hour::class, 'model');
    }

    public function workingHours($day)
    {
        $filtered = [];
        $hours = $this->hours->first()->toArray();
        $key_1 = $day . '_start';
        $key_2 = $day . '_end';
        //set keys to monday_end to find them in the array
        $filtered[$key_1] = '';
        $filtered[$key_2] = '';

        return array_intersect_key($hours, $filtered);
    }

    public function defaultHours()
    {
        return Hour::create([
            'model_id' => $this->id,
            'model_type' => 'User',
            'monday_start' => '09:00',
            'monday_end' => '17:00',
            'tuesday_start' => '09:00',
            'tuesday_end' => '17:00',
            'wednesday_start' => '09:00',
            'wednesday_end' => '17:00',
            'thursday_start' => '09:00',
            'thursday_end' => '17:00',
            'friday_start' => '09:00',
            'friday_end' => '17:00',
            'saturday_start' => '09:00',
            'saturday_end' => '17:00',
            'sunday_start' => '09:00',
            'sunday_end' => '17:00',
        ]);
    }
    //Booking Controller - logic
    public static function matchUserHours(int $user, string $day, array $times , $interval = 5)
    {
        //remove this if-statement if you no long want to manage this by user working hours
        if($user !== 0)
        {
            //get members working hours start and end for the selected day
            $memberHours = User::whereId($user)->first()->workingHours($day);
            //get users 15 minute intervals
            $userTimes = Hour::times($memberHours, $interval);

            //finds all duplicate array keys and keeps them as these are the hours in which users and the company hours can work
            $newTimes = array_values(array_intersect($times, $userTimes));

            return $newTimes;
        } else
        {
            return $times;
        }

    }

}
