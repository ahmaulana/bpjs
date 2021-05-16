<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'jenis_kelamin',
        'no_hp',
        'program',
        'jenis_kepesertaan',
        'kantor_cabang',
        'berkas_foto',
        'berkas_ktp',
        'berkas_kk',
        'berkas_buku_tabungan',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function wage()
    {
        return $this->hasOne(Wage::class);
    }

    public function construction()
    {
        return $this->hasOne(Construction::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function latest_invoice()
    {
        return $this->invoices()
            ->whereIn('id', function ($q) {
                $q->select(DB::raw('MAX(id) FROM invoices GROUP BY user_id'));
            });
    }

    public function last_invoice()
    {
        return $this->invoices()->latest('created_at')->first();
    }

    public function last_payment()
    {
        return $this->invoices()->where('status', true)->latest('created_at')->first();
    }

    public function scopeSelectLastInvoice($query, $alias)
    {
        dd($query);
        $query->addSelect([
            $alias => Invoice::selectRaw('GROUP_CONCAT("Rp.",FORMAT(tagihan,2))')
                ->leftJoin('users', 'user_id', 'users.id')
                ->whereColumn('user_id', 'users.id')
        ]);
    }

    public function scopeHasPaid($query, $alias)
    {
        $query->addSelect([
            $alias => Invoice::selectRaw('IF(invoices.status, "Terbayar", "Belum Terbayar")')
                ->leftJoin('users', 'users.id', 'user_id')
                ->whereColumn('invoices.user_id', 'users.id')
                ->latest('invoices.created_at')
                ->limit(1)
        ]);
    }
}
