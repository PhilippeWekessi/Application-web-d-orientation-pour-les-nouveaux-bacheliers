<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Recommandation extends Model
{
    protected $table = 'recommandations';
    protected $primaryKey = 'id_recommandation';
    protected $fillable = ['score', 'diagnostic', 'id_user', 'id_filiere', 'id_serie'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function filiere() {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
    public function serie() {
        return $this->belongsTo(Serie::class, 'id_serie');
    }
    public function matieres() {
        return $this->belongsToMany(Matiere::class, 'recommandation_matieres', 'id_recommandation', 'id_matiere')
                    ->withPivot('note', 'coefficient');
    }
}