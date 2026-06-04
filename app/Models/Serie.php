<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Serie extends Model
{
    protected $table = 'series';
    protected $primaryKey = 'id_serie';
    protected $fillable = ['code', 'libelle'];

    public function filieres() {
        return $this->belongsToMany(Filiere::class, 'filiere_serie_matieres', 'id_serie', 'id_filiere');
    }
    public function users() {
        return $this->hasMany(User::class, 'id_serie');
    }

    public function matieres() {
        return $this->belongsToMany(
            Matiere::class,
            'serie_matiere',  // pivot
            'id_serie',       // FK → series
            'id_matiere',     // FK dans le pivot
            'id_serie',       // PK de series
            'id_matieres'     // PK de matieres (avec s)
        )->withPivot('coefficient');
    }
}
