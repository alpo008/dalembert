<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Attachment;
use App\Models\AirmaxActivity;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use App\Casts\Coords;

class AirmaxClient extends Model
{
    use HasFactory;

    const CLIENTS_ALL = 'all';
    const CLIENTS_ACTIVE = 'active';
    const CLIENTS_DISABLED = 'disabled';
    const CLIENTS_DEBTORS = 'overdue';
    const CLIENTS_DEBTORS_BUT_ACTIVE = 'overdueButActive';
    const CLIENTS_TO_REMIND = 'remind';

    /** 
     * @inheritdoc
     */
    protected static function boot()
    {
        parent::boot();

        static::deleting(function($model) { 
            $model->attachments()->each(function($attachment) {
                $attachment->delete(); 
            });
            $model->payments()->each(function($payment) {
                $payment->delete(); 
            });
        });
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'place', 'name', 'email', 'location', 'phone', 'ap_model', 'wlan_mac', 'lan_mac', 'ap_mac', 'ip_address', 
        'router_model', 'router_mac', 'router_ip_address', 'ssid', 'password', 'installed_on', 'admin', 'active'
    ];

    /**
     *
     * @var array
     */
    protected $casts = [
        'password' => 'encrypted',
        'admin' => 'encrypted',
        'installed_on' => 'datetime:Y-m-d',
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
        'active' => 'boolean',
        'location' => Coords::class
    ];

    /**
     * Get all of the clients's payments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function payments(): MorphMany
    {
        return $this->morphMany(Payment::class, 'payer');
    }

    /**
     * Get all of the attachments.
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function attachments(): MorphMany
    {
        return $this->morphMany(Attachment::class, 'morphable');
    }

    /**
     * Get the airmax client activities report.
     */
    public function airmaxActivities(): HasMany
    {
        return $this->hasMany(AirmaxActivity::class);
    }


    /**
     * Format installed_on date.
     */
    protected function installedOn(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => Carbon::parse($value)->format('d.m.Y')
        );
    }

    /**
     * @param string $keyword
     * 
     * @return Illuminate\Database\Eloquent\Collection|null
     * */
    public static function statistics(string $keyword): ?Collection
    {
        $yearAgo = date('Y-m-d', strtotime("-1 year", time()));
        $timeToPay = date('Y-m-d', strtotime("-350 days", time()));
        $overdueQuery = AirmaxClient::with('payments')->whereNotIn('id', function(Builder $query) use($yearAgo){
            $query->select('payer_id')
            ->from('payments')
            ->where('payer_type', '=', 'App\\Models\\AirmaxClient')
            ->where('doi', '>', $yearAgo);
        })->select('place', 'name', 'phone', 'ip_address', 'active');
        $toRemind = DB::table('payments')
            ->select(DB::raw('payer_id, MAX(doi)  last_paid'))
            ->havingBetween('last_paid', [$yearAgo, $timeToPay])
            ->groupBy('payer_id')          
            ->get()
            ->toArray();
        $remindQuery = AirmaxClient::with('payments')->whereIn('id', array_column($toRemind, 'payer_id'))->select('place', 'name', 'phone', 'ip_address', 'active');

        switch ($keyword) {
            case self::CLIENTS_ALL :
                return AirmaxClient::select('place', 'name', 'phone', 'ip_address', 'active')
                    ->get();
                break;
            case self::CLIENTS_ACTIVE :
                return AirmaxClient::where('active', true)->select('place', 'name', 'phone', 'ip_address', 'active')
                    ->get();
                break;
            case self::CLIENTS_DISABLED :
                return AirmaxClient::where('active', false)->select('place', 'name', 'phone', 'ip_address', 'active')
                    ->get();
                break;
            case self::CLIENTS_DEBTORS :
                return $overdueQuery->get();
                break;
            case self::CLIENTS_DEBTORS_BUT_ACTIVE :
                return $overdueQuery->where('active', true)->get();
                break;
            case self::CLIENTS_TO_REMIND :
                return $remindQuery->where('active', true)->get();
                break;
            default:
            return null;
        }
    }
}
