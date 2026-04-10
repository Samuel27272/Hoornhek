<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zaak extends Model
{
    use HasFactory;
    /**
     * Table name matches migration
     *
     * @var string
     */
    protected $table = 'zaken';
    protected $fillable = [
        'zaaknummer',
        'omschrijving',
        'misdaad_type',
        'status',
        'datum_aangemaakt',
        'datum_gesloten',
        'opmerkingen',
        'aangemaakt_door',
    ];

    protected $casts = [
        'datum_aangemaakt' => 'date',
        'datum_gesloten' => 'date',
    ];

    public function aangemaaktDoor()
    {
        return $this->belongsTo(User::class, 'aangemaakt_door');
    }

    public function gedetineerden()
    {
        return $this->belongsToMany(Gedetineerde::class, 'gedetineerde_zaak', 'zaak_id', 'gedetineerde_id')->withTimestamps();
    }
}
