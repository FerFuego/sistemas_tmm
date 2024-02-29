<?php 

namespace App\Http\ViewComposers;

use App\User;
use App\BranchOffice;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class ProfileComposer {
    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        if(Auth::guest()){
            $auth = false;
        }else{
            $auth = true;
        }
        $branch = BranchOffice::where('idusers', Auth::id())->get();
        $view->with('user',Auth::user())
             ->with('auth', $auth)
             ->with('sucursales', $branch);
    }

}