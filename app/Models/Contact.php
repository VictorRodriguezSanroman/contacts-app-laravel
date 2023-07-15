<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'age',
        'user_id',
        'profile_picture'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sharedWithUsers()
    {
        return  $this->belongsToMany(User::class, 'contact_shares');
    }
}
