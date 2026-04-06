<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Debouche extends Model
{
    protected $table = 'debouches';
    protected $primaryKey = 'id_debouche';
    protected $fillable = ['intitule', 'secteur'];

    public function filieres() {
        return $this->belongsToMany(Filiere::class, 'filiere_debouche', 'id_debouche', 'id_filiere');
    }
}