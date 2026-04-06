<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FiliereSerieMatiere extends Model
{
    protected $table = 'filiere_serie_matieres';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id_filiere', 'id_serie', 'id_matiere', 'coefficient'];

    public function filiere() {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
    public function serie() {
        return $this->belongsTo(Serie::class, 'id_serie');
    }
    public function matiere() {
        return $this->belongsTo(Matiere::class, 'id_matiere');
    }
}