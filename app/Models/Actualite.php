<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Actualite extends Model
{
    protected $table = 'actualites';
    protected $primaryKey = 'id_actualite';
    protected $fillable = ['titre', 'contenu', 'image', 'id_admin'];

    public function admin() {
        return $this->belongsTo(Admin::class, 'id_admin');
    }
    public function abonnes() {
        return $this->belongsToMany(User::class, 'abonnements', 'id_actualite', 'id_user')
                    ->withPivot('date_abonnement');
    }
}