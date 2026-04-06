<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Annee extends Model
{
    protected $table = 'annees';
    protected $primaryKey = 'id_annee';
    protected $fillable = ['libelle', 'est_active'];

    public function universites() {
        return $this->hasMany(Universite::class, 'id_annee');
    }
}