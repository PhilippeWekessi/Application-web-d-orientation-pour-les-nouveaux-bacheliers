<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Campus extends Model
{
    protected $table = 'campus';
    protected $primaryKey = 'id_campus';
    protected $fillable = ['nom', 'adresse', 'ville', 'latitude', 'longitude', 'id_universite'];

    public function universite() {
        return $this->belongsTo(Universite::class, 'id_universite');
    }
    public function filieres() {
        return $this->belongsToMany(Filiere::class, 'uni_filieres', 'id_campus', 'id_filiere');
    }
}