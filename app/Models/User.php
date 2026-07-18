<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Filament\Panel;
use App\Enums\UserRoleEnum;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements FilamentUser
{
   use HasFactory, Notifiable;

   /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
   protected $fillable = [
      'name',
      'email',
      'password',
      'role'
   ];

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
         'role' => UserRoleEnum::class,
      ];
   }

   public function isSuperAdmin()
   {
      return $this->role == UserRoleEnum::SuperAdmin;
   }

   public function isAdmin()
   {
      return $this->role == UserRoleEnum::Admin;
   }


   public function isUser()
   {
      return $this->role == UserRoleEnum::User;
   }


   public function canAccessPanel(Panel $panel): bool
   {
      //   return str_ends_with($this->email, '@yourdomain.com') && $this->hasVerifiedEmail();
      return true;
   }
}
