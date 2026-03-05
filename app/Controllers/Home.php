<?php

namespace App\Controllers;

use App\Models\UserModel;

class Home extends BaseController
{
    public function index()
    {
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/signin');
        }

        $userModel = new UserModel();
        $data['users'] = $userModel->getAllUsersExcept(session()->get('user_id'));
        
        return view('home/landing', $data);
    }
}
