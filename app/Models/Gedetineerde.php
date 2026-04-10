<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gedetineerde extends Model
{
    use HasFactory;
    /**
     * Explicit table name (Dutch pluralization differs from Eloquent's guess)
     *
     * @var string
     */
    protected $table = 'gedetineerden';
    /** @var array<int,string> */
    protected $fillable = [
        'bsn_nummer',
        'voornaam',
        'achternaam',
        'geboortedatum',
        'straatnaam',
        'huisnummer',
        'postcode',
        'woonplaats',
        'telefoonnummer',
        'email',
        'foto_pad',
        'aanhoudingsdatum',
        'datum_schorsing',
        'status',
        'cel_id',
        'opmerkingen',
    ];

    protected $casts = [
        'geboortedatum' => 'date',
        'aanhoudingsdatum' => 'date',
        'datum_schorsing' => 'date',
    ];

    public function cel()
    {
        return $this->belongsTo(Cel::class, 'cel_id');
    }

    public function documenten()
    {
        return $this->hasMany(Document::class, 'gedetineerde_id');
    }

    public function historie()
    {
        return $this->hasMany(Historie::class, 'gedetineerde_id');
    }

    public function zaken()
    {
        return $this->belongsToMany(Zaak::class, 'gedetineerde_zaak', 'gedetineerde_id', 'zaak_id')->withTimestamps();
    }
}
