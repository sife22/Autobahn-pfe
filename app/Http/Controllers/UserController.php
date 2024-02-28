<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Voiture;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\Console\Input\Input;

class UserController extends Controller
{
    // ======= page connexion admin ===========
    public function index(){
        return view('admin.connexionadmin');
    }
    // ========================================

    // =============== login admin ===========================
    public function loginAdmin(Request $request){
        $email = $request['email'];
        $password = $request['password'];

        $validateData = $request->validate([
            'email'=>'required',
            'password'=>'required',
        ],[
            'email.required'=>'le email est obligatoire',
            'password.required'=>'le mot de passe est obligatoire',
        ]);
        
        $admin = User::where('email', '=', $validateData['email'])->where('password', '=', $validateData['password'])->first();
        if($admin){
            $request->session()->put('adminId', $admin->id);
            return redirect('/accueiladmin');
        }else{
            session()->flash('failed', 'Vous êtes pas un client!');
            return redirect()->back()->onlyInput('email', 'password');
        }
    }
    // ====================================================================

    // ================= log Out ============================
    public function logoutAdmin(){
        if(session()->has('adminId')){
            session()->pull('adminId');
            return redirect('/connexionadmin');
        }
    }
    // ===================================================

    // ================== page profile ======================
    public function profile(Request $request){
        $data = array();
        $data = User::find(session()->get('adminId'));
        $voitures = Voiture::all();
        return view('admin.accueiladmin')->with(['data'=>$data, 'voitures'=>$voitures]);
    }
    // ============================================================
}
