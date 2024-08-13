<?php

namespace Deirdrelear\Seat\FleetTracking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Seat\Web\Models\User;

class Fleet extends Model
{
    protected $table = 'fleet_tracking_fleets';

    protected $fillable = [
        'name', 'fc_id', 'start_time', 'end_time', 'status', 'location', 'doctrine', 'game_id'
    ];

    protected $dates = [
        'start_time', 'end_time'
    ];

    public function commander(): BelongsTo
    {
        return $this->belongsTo(User::class, 'fc_id');
    }

    public function participants(): HasMany
    {
        return $this->hasMany(FleetParticipant::class);
    }
}