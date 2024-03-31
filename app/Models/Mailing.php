<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mailing extends Model
{
    use HasFactory;
    protected $guarded = false;
    public function customerMails()
    {
        return $this->hasMany(CustomerMail::class, 'mail_id');
    }

    protected function status(): Attribute
    {
        $statuses = ['PENDING', 'SENT', 'CANCELLED'];
        return Attribute::make(
            get: fn (int $value) => $statuses[$value]
        );
    }


}
