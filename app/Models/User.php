<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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
            'is_super_admin' => 'boolean',
            'last_login_at' => 'datetime',
        ];
    }

    public function companies()
    {
        return $this->belongsToMany(Company::class, 'company_user')
            ->withPivot(['is_owner', 'status', 'invited_at', 'joined_at'])
            ->withTimestamps();
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles')
            ->withTimestamps();
    }

    public function employee()
    {
        return $this->hasOne(Employee::class);
    }

    /**
     * Check if user has a specific role in a company.
     */
    public function hasRoleInCompany(string $roleSlug, int $companyId): bool
    {
        return UserRole::query()
            ->where('user_id', $this->id)
            ->where('company_id', $companyId)
            ->whereHas('role', function ($query) use ($roleSlug) {
                $query->where('slug', $roleSlug);
            })
            ->exists();
    }

    /**
     * Get all companies the user can access (active membership only).
     */
    public function accessibleCompanies()
    {
        return $this->companies()
            ->where('company_user.status', 'active')
            ->where('companies.is_active', true)
            ->orderBy('companies.name')
            ->get();
    }
}

