<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClearanceRequest extends Model
{
    use HasFactory;
     
    protected $guarded = [];

    /**
     * Get all of the documents for the ClearanceRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function documents(): HasMany
    {
        return $this->hasMany(RequestDocument::class);
    }

    /**
     * Get the student that owns the ClearanceRequest
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function getStatusColorAttribute(){
        return match ($this->status) {
            'processing' => 'yellow',
            'rejected' => 'red',
            'approved' => 'green',
            default => 'gray'
        };
    }

    public function currentDesk()
    {
        return $this->hasOne(Desk::class, 'request_id')->latest();
    }
}
