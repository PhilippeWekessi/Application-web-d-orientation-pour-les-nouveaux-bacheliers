<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Abonnement extends Model
{
    protected $table      = 'abonnements';
    protected $primaryKey = null;
    public    $incrementing = false;
    public    $timestamps = false;

    protected $fillable = [
        'id_user',
        'id_actualite',
    ];
}