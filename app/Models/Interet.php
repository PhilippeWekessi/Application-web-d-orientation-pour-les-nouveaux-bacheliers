<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Interet extends Model
{
    protected $table = 'interets';
    protected $primaryKey = 'id_interet';
    protected $fillable = ['libelle', 'icone'];

    public function filieres() {
        return $this->belongsToMany(Filiere::class, 'filiere_interet', 'id_interet', 'id_filiere');
    }
}