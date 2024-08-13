<?php

namespace Deirdrelear\Seat\FleetTracking\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Seat\Web\Models\User;

class FleetParticipant extends Model
{
    protected $table = 'fleet_tracking_participants';

    protected $fillable = [
        'fleet_id', 'character_id', 'ship_type_id', 'join_time', 'leave_time'
    ];

    protected $dates = [
        'join_time', 'leave_time'
    ];

    public function fleet(): BelongsTo
    {
        return $this->belongsTo(Fleet::class);
    }

    public function character(): BelongsTo
    {
        return $this->belongsTo(User::class, 'character_id');
    }
}