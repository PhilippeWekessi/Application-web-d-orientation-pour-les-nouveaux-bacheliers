<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id_user';
    protected $fillable = ['nom', 'prenom', 'email', 'password', 'id_serie'];
    protected $hidden = ['password'];

    public function serie() {
        return $this->belongsTo(Serie::class, 'id_serie');
    }
    public function recommandations() {
        return $this->hasMany(Recommandation::class, 'id_user');
    }
    public function temoignages() {
        return $this->hasMany(Temoignage::class, 'id_user');
    }
    public function abonnements() {
        return $this->belongsToMany(Actualite::class, 'abonnements', 'id_user', 'id_actualite')
                    ->withPivot('date_abonnement');
    }
}