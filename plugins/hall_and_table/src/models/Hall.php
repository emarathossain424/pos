<?php

namespace Plugin\HallAndTable\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hall extends Model
{
    use HasFactory;

    protected $table = 'halls';

    /**
     * Get all of the tables for the Hall
     *
     * @return void
     */
    public function tables()
    {
        return $this->hasMany(Table::class);
    }
}