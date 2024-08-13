<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RequestDocument extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Get the clearance_request that owns the RequestDocument
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function clearance_request(): BelongsTo
    {
        return $this->belongsTo(ClearanceRequest::class, 'request_id');
    }
}
