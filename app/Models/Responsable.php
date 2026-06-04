<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Responsable extends Model
{
    protected $table = 'responsables';
    protected $primaryKey = 'id_responsable';
    protected $fillable = ['nom', 'prenom', 'email', 'password', 'telephone', 'fonction', 'id_universite', 'statut', 'photo'];
    protected $hidden = ['password'];

    public function universite() {
        return $this->belongsTo(Universite::class, 'id_universite');
    }
}