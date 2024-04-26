<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Upload extends Model
{
    use HasFactory;

    /**
     * Get the user who uploaded this upload.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
