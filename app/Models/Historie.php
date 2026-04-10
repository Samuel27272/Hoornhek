<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Historie extends Model
{
    /**
     * Table name is singular in migration
     *
     * @var string
     */
    protected $table = 'historie';

    protected $fillable = [
        'gedetineerde_id',
        'uitgevoerd_door',
        'gebeurtenis',
        'cel_oud',
        'cel_nieuw',
        'type',
        'opmerkingen',
        'datum',
    ];

    protected $casts = [
        'datum' => 'datetime',
    ];

    public function gedetineerde()
    {
        return $this->belongsTo(Gedetineerde::class, 'gedetineerde_id');
    }

    public function uitgevoerdDoor()
    {
        return $this->belongsTo(User::class, 'uitgevoerd_door');
    }

    public function celOud()
    {
        return $this->belongsTo(Cel::class, 'cel_oud');
    }

    public function celNieuw()
    {
        return $this->belongsTo(Cel::class, 'cel_nieuw');
    }
}
