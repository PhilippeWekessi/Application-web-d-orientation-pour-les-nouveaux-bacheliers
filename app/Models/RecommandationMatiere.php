<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RecommandationMatiere extends Model
{
    protected $table      = 'recommandation_matieres';
    protected $primaryKey = 'id';
    public $timestamps    = false;

    protected $fillable = [
        'id_recommandation',
        'id_matiere',
        'note',
        'coefficient',
    ];

    public function recommandation()
    {
        return $this->belongsTo(Recommandation::class, 'id_recommandation', 'id_recommandation');
    }

    public function matiere()
    {
        return $this->belongsTo(Matiere::class, 'id_matiere', 'id_matieres');
    }
}