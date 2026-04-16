<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class UniFiliere extends Model
{
    protected $table = 'uni_filieres';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id_campus', 'id_filiere', 'id_annee', 'quota_bourse', 'seuil_bourse'];

    public function filiere() {
        return $this->belongsTo(Filiere::class, 'id_filiere');
    }
    public function campus() {
        return $this->belongsTo(Campus::class, 'id_campus');
    }
}