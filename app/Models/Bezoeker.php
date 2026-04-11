<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bezoeker extends Model
{
    use HasFactory;

    /**
     * Table name matches migration
     *
     * @var string
     */
    protected $table = 'bezoekers';

    protected $fillable = [
        'voornaam',
        'achternaam',
        'telefoonnummer',
        'email',
        'start_bezoek',
        'status',
    ];

    protected $casts = [
        'start_bezoek' => 'datetime',
    ];
}
