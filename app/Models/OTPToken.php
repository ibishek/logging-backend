<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OTPToken extends Model
{
    use HasFactory;

    protected $table = 'otp_tokens';

    protected $fillable = [
        'token',
        'expired_at',
        'is_used',
        'user_id',
    ];

    /**
     * Get the user that owns the OTP token.
     *
     * @return BelongsTo<User, OTPToken>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
