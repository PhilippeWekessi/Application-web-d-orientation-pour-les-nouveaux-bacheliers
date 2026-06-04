<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admins';
    protected $primaryKey = 'id_admin';
    protected $fillable = ['nom', 'prenom', 'email', 'password', 'photo'];

    public function actualites() {
        return $this->hasMany(Actualite::class, 'id_admin');
    }
}