<?php
namespace Larafa\UserProfile;

use Larafa\UserProfile\Profile;

trait hasProfile {
	
	public function profile()
    {
        return $this->belongsTo(Profile::class , 'id', 'user_id');
    }

    public static function create(array $attributes = [])
    {
        $user = static::query()->create($attributes);
        Profile::create([
            'user_id'=> $user->id
        ]);
        return $user;
    }

    public function save(array $options = [])
    {
        parent::save($options);
        Profile::create([
            'user_id'=> $this->id
        ]);
        return $this;
    }

    public static function getProfileTraitName(){
	    return  __TRAIT__;
    }
}