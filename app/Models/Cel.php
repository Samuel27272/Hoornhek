<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cel extends Model
{
    use HasFactory;
    /**
     * Table name matches migration
     *
     * @var string
     */
    protected $table = 'cellen';
    protected $fillable = [
        'cel_nummer',
        'block',
        'capaciteit',
        'status',
        'opmerkingen',
    ];

    public function gedetineerden()
    {
        return $this->hasMany(Gedetineerde::class, 'cel_id');
    }
}
