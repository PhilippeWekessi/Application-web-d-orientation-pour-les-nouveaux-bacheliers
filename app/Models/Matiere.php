<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $table = 'matieres';
    protected $primaryKey = 'id_matiere';
    protected $fillable = ['nom'];

    public function series() {
        return $this->belongsToMany(Serie::class, 'filiere_serie_matieres', 'id_matiere', 'id_serie')
                    ->withPivot('coefficient');
    }
    public function recommandations() {
        return $this->belongsToMany(Recommandation::class, 'recommandation_matieres', 'id_matiere', 'id_recommandation')
                    ->withPivot('note', 'coefficient');
    }
}