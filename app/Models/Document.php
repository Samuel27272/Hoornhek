<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Table name matches migration
     *
     * @var string
     */
    protected $table = 'documenten';

    protected $fillable = [
        'gedetineerde_id',
        'geupload_door',
        'bestandsnaam',
        'bestand_pad',
        'mime_type',
        'type',
        'omschrijving',
    ];

    public function gedetineerde()
    {
        return $this->belongsTo(Gedetineerde::class, 'gedetineerde_id');
    }

    public function geuploadDoor()
    {
        return $this->belongsTo(User::class, 'geupload_door');
    }
}
