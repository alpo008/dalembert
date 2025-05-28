<?php

namespace App\Models;

use App\Models\AirmaxClient;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class AirmaxActivity extends Model
{
    use HasFactory;

    protected $fillable = ['airmax_client_id', 'status', 'changed_at'];

    public $timestamps = false;

    /**
     * Get the user that owns the phone.
     */
    public function airmaxClient(): BelongsTo
    {
        return $this->belongsTo(AirmaxClient::class);
    }

    public static function updateStatus($activityData)
    {
        if($id = $activityData['airmax_client_id']) {
            $lastActivity = self::where('airmax_client_id', '=', $id)
                ->orderBy('changed_at', 'desc')
                ->limit(1)
                ->first();
            if($lastActivity instanceof self) {
                $changedAt = Carbon::parse($lastActivity->changed_at);
                $now = Carbon::now();
                var_dump($lastActivity->changed_at);
                var_dump($changedAt->diffInHours($now));
            }
            if(is_null($lastActivity)) {
                $activityData['changed_at'] = Carbon::now('Europe/Moscow')
                    ->format($dateFormat);
                //AirmaxActivity::create($airmaxActivity);
            }
        }
    }
}
