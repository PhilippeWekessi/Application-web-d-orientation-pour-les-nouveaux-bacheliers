<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use App\Models\Filiere;

class Universite extends Model
{
    protected $table = 'universites';
    protected $primaryKey = 'id_universite';
    protected $fillable = ['nom', 'sigle', 'ville', 'type', 'latitude', 'longitude', 'id_annee', 'statut', 'motif_rejet', 'id_responsable_soumis'];
    

    public function campus() {
        return $this->hasMany(Campus::class, 'id_universite');
    }

    public function filieres() {
        return $this->hasManyThrough(Filiere::class, Campus::class, 'id_universite', 'id_campus', 'id_universite', 'id_campus');
    }

    public function annee() {
        return $this->belongsTo(Annee::class, 'id_annee');
    }
}