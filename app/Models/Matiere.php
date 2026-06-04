<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{
    protected $table = 'matieres';
    protected $primaryKey = 'id_matieres';
    protected $fillable = ['nom'];
    public $timestamps = false;

    public function series() {
        return $this->belongsToMany(Serie::class, 'serie_matiere', 'id_matiere', 'id_serie')
                    ->withPivot('coefficient');
    }
    public function recommandations() {
        return $this->belongsToMany(Recommandation::class, 'recommandation_matieres', 'id_matiere', 'id_recommandation')
                    ->withPivot('note', 'coefficient');
    }
}