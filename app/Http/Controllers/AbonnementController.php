<?php
namespace App\Http\Controllers;

use App\Models\Abonnement;
use Illuminate\Http\Request;

class AbonnementController extends Controller
{
    public function ajouter($id_actualite)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        $existe = Abonnement::where('id_user', session('user_id'))
                             ->where('id_actualite', $id_actualite)
                             ->exists();

        if (!$existe) {
            Abonnement::create([
                'id_user'      => session('user_id'),
                'id_actualite' => $id_actualite,
            ]);
        }

        return back()->with('success', 'Vous êtes maintenant abonné à cette actualité !');
    }

    public function retirer($id_actualite)
    {
        if (!session('user_id')) {
            return redirect()->route('login');
        }

        Abonnement::where('id_user', session('user_id'))
                   ->where('id_actualite', $id_actualite)
                   ->delete();

        return back()->with('success', 'Abonnement retiré.');
    }
}