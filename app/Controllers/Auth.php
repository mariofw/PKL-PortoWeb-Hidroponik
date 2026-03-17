<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Auth extends BaseController
{
    public function index()
    {
        if (session()->get('is_logged_in')) {
            return redirect()->to('/admin');
        }
        return view('auth/login');
    }

    public function login()
    {
        $username = (string)$this->request->getPost('username');
        $password = (string)$this->request->getPost('password');

        $userModel = new UserModel();
        // Fetch user from database
        $user = $userModel->where('username', $username)->first();

        // Strict case-sensitive and exact match check
        if ($user && $user['username'] === $username) {
            if (password_verify($password, $user['password_hash'])) {
                session()->set([
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'user_avatar' => $user['avatar'] ?? null, // Safely handle potential missing avatar
                    'is_logged_in' => true
                ]);
                return redirect()->to('/admin');
            }
        }

        return redirect()->back()->withInput()->with('error', 'Invalid username or password');
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}