<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Desk extends Model
{
    use HasFactory;
    protected $guarded = [];

    /**
     * Get the staff that owns the Desk
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function staff(): BelongsTo
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function request()
    {
        return $this->belongsTo(ClearanceRequest::class);
    }
    
}
