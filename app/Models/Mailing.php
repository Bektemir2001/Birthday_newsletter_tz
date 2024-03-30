<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    use HasFactory;
    protected $guarded = false;

    public function customerMails()
    {
        return $this->hasMany(CustomerMail::class);
    }
}
