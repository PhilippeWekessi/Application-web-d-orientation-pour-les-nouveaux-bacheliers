<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Temoignage extends Model
{
    protected $table = 'temoignages';
    protected $primaryKey = 'id_temoignage';
    protected $fillable = ['contenu', 'note', 'statut', 'id_user', 'id_filiere'];

    public function user() {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function filiere() {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
}