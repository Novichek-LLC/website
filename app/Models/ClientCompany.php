<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClientCompany extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'contact_person',
        'email',
        'phone',
        'inn',
        'kpp',
        'ogrn',
        'address',
        'notes',
    ];

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    public function projects(): HasMany
    {
        return $this->hasMany(ClientProject::class);
    }
}