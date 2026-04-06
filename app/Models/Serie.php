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
        return $this->belongsToMany(Matiere::class, 'filiere_serie_matieres', 'id_serie', 'id_matiere')
                    ->withPivot('coefficient');
    }
}