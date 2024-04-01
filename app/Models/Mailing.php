<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Mailing extends Model
{
    use HasFactory;

    protected $guarded = false;

    const PENDING = 0;
    const SENT = 1;
    const CANCELLED = 2;

    public static function getStatuses(): array
    {
        return [
            self::PENDING => 'PENDING',
            self::SENT => 'SENT',
            self::CANCELLED => 'CANCELLED'
        ];
    }
    public function customerMails(): HasMany
    {
        return $this->hasMany(CustomerMail::class, 'mail_id');
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: fn (int $value) => self::getStatuses()[$value]
        );
    }


}
