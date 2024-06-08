<?php

namespace App\Models;

use App\Enums\UserGender;
use App\Enums\UserMaritalStatus;
use App\Traits\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Sluggable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'user_name',
        'password',
        'gender',
        'marital_status',
        'honorific',
    ];

    public string $slugColumn = 'user_name';

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
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the associated organizations through organization user.
     *
     * @return HasManyThrough<Organization>
     */
    public function organizations(): HasManyThrough
    {
        return $this->hasManyThrough(Organization::class, OrganizationUser::class);
    }

    /**
     * Get the attached image of the user.
     *
     * @return MorphOne<Image>
     */
    public function image(): MorphOne
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    /**
     * Get the OTP token associated with the user.
     */
    public function activeToken(): ?OTPToken
    {
        return $this->hasOne(OTPToken::class)
            ->where('expired_at', '>', now())
            ->where('is_used', 0)
            ->latest('id')
            ->first();
    }

    /**
     * Get the user's gender.
     *
     * @return Attribute<null|string, null|int>
     */
    public function gender(): Attribute
    {
        return Attribute::make(
            get: function (?int $gender) {
                return UserGender::gender($gender);
            },
            set: function (?string $gender) {
                return UserGender::gender($gender);
            }
        );
    }

    /**
     * Get the user's marital status.
     *
     * @return Attribute<null|string, null|int>
     */
    public function maritalStatus(): Attribute
    {
        return Attribute::make(
            get: function (?int $status) {
                return UserMaritalStatus::maritalStatus($status);
            },
            set: function (?string $status) {
                return UserMaritalStatus::maritalStatus($status);
            }
        );
    }

    /**
     * Get the user's honorific.
     *
     * @return Attribute<string, never>
     */
    protected function provideHonorific(): Attribute
    {
        return Attribute::make(get: function (?string $honorific) {
            if ($honorific) {
                return $honorific;
            }

            if ($this->gender === UserGender::MALE->value) {
                return 'Mr.';
            }

            if ($this->gender === UserGender::FEMALE->value) {
                if ($this->marital_status === UserMaritalStatus::UNMARRIED->value) {
                    return 'Miss';
                }

                return 'Mrs.';
            }

            return 'They';
        });
    }

    /**
     * Get the user's full name
     *
     * @return Attribute<string, never>
     */
    protected function fullName(): Attribute
    {
        return Attribute::make(get: function () {
            return $this->first_name . ' ' . $this->last_name;
        });
    }
}
