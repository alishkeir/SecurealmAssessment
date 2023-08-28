<?php

namespace App\Models;

// use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserCertificates extends Model
{
    // use HasFactory;

    protected $table = 'user_certificates';



    protected $fillable = [
        'user_id',
        'certificate_id',

    ];


    public function user()
    {
        return $this->hasMany(User::class);
    }

    public function certificate()
    {
        return $this->hasMany(Certificate::class);
    }

}