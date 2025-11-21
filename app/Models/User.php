<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
               'name', 'email', 'password','code','mobile','profile_photo_path','status','user_type', 'address','gst'

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
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

    // getdown the line users
    public function getAllDownlineUserIds(): array
    {
        $ids = [];

        foreach ($this->teamMembers as $report) {
            $childUserId = $report->user_id;
            $ids[] = $childUserId;

            // Recursive call for deeper hierarchy
            $childUser = User::find($childUserId);
            if ($childUser) {
                $ids = array_merge($ids, $childUser->getAllDownlineUserIds());
            }
        }

        return $ids;
    }

    // All users who report to this user
    public function teamMembers()
    {
        return $this->hasMany(ReportingManager::class, 'reporting_user_id');
    }


     // ---------------------------------------------
    // Roles downline (recursive)
    // ---------------------------------------------
    public function getAllDownlineRoleIds(): array
    {
        $roleIds = [];

        $myRoles = $this->roles()->pluck('id')->toArray(); // get all roles of user

        foreach ($myRoles as $roleId) {
            $roleIds[] = $roleId; // include own role
            $roleIds = array_merge($roleIds, $this->getChildRoles($roleId));
        }

        return array_unique($roleIds);
    }

    // Recursive helper for child roles
    private function getChildRoles(int $parentRoleId): array
    {
        $childRoles = RoleReporting::where('parent_id', $parentRoleId)->pluck('role_id')->toArray();
        $all = [];

        foreach ($childRoles as $childRoleId) {
            $all[] = $childRoleId;
            $all = array_merge($all, $this->getChildRoles($childRoleId));
        }

        return $all;
    }




}
