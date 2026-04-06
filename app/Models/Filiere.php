<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Filiere extends Model
{
    protected $table = 'filieres';
    protected $primaryKey = 'id_filiere';
    protected $fillable = ['nom', 'description', 'duree_annees', 'mode_entree', 'quota_bourse', 'quota_aide_fpp'];

    public function campus() {
        return $this->belongsToMany(Campus::class, 'uni_filieres', 'id_filiere', 'id_campus')
                    ->with('universite');
    }
    public function debouches() {
        return $this->belongsToMany(Debouche::class, 'filiere_debouche', 'id_filiere', 'id_debouche');
    }
    public function interets() {
        return $this->belongsToMany(Interet::class, 'filiere_interet', 'id_filiere', 'id_interet');
    }
    public function series() {
        return $this->belongsToMany(Serie::class, 'filiere_serie_matieres', 'id_filiere', 'id_serie');
    }
    public function recommandations() {
        return $this->hasMany(Recommandation::class, 'id_filiere');
    }
    public function temoignages() {
        return $this->hasMany(Temoignage::class, 'id_filiere');
    }
}