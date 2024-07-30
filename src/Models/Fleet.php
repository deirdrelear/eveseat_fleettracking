<?php

namespace drlear\FleetTracking\Models;

use Illuminate\Database\Eloquent\Model;
use drlear\Seat\Web\Models\User;

class Fleet extends Model
{
    protected $table = 'fleet_tracking_fleets';

    protected $fillable = [
        'name', 'fc_id', 'start_time', 'end_time', 'status', 'location', 'doctrine', 'game_id'
    ];

    protected $dates = [
        'start_time', 'end_time'
    ];

    public function commander()
    {
        return $this->belongsTo(User::class, 'fc_id');
    }

    public function participants()
    {
        return $this->hasMany(FleetParticipant::class);
    }
}
