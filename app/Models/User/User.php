<?php

namespace App\Models\User;

use App\Models\User\TypeUser\TypeUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Concerns\HasUuids;


class User extends Authenticatable
{
    use HasFactory, Notifiable;
    use HasUuids;

    protected $table = 'tbl_user';

    protected $fillable = [
        'username',
        'avatar',
        'name',
        'email',
        'password',
        'encrypted_password',
        'email_confirmation',
        'idtype_user',
        'status',
    ];

    protected $hidden = [
        'password',
        'encrypted_password',
        'created_at',
        'updated_at'
    ];

    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    #Relaciones
    public function typeUser(): HasOne
    {
        return $this->hasOne(TypeUser::class, 'id', 'idtype_user');
    }
}
