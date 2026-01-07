<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class Profile extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function index()
    {
        // Assume user ID is stored in session upon login
        $userId = session()->get('id');
        if (!$userId) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Edit Profil',
            'user' => $this->userModel->find($userId),
            'validation' => \Config\Services::validation()
        ];
        return view('admin/profile/index', $data);
    }

    public function update()
    {
        $userId = session()->get('id');
        $user = $this->userModel->find($userId);

        if (!$user) {
            return redirect()->to('/login');
        }

        $rules = [
            'username' => "required|min_length[3]|is_unique[users.username,id,{$userId}]",
            'avatar'   => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,2048]',
        ];

        // Only validate password if it's being changed
        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['password_confirm'] = 'required|matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'id' => $userId,
            'username' => $this->request->getPost('username'),
        ];

        // Update password if provided
        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        // Handle Avatar Upload
        $img = $this->request->getFile('avatar');
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads/avatars', $newName);

            // Delete old avatar if exists
            if (!empty($user['avatar']) && file_exists(ROOTPATH . 'public/' . $user['avatar'])) {
                unlink(ROOTPATH . 'public/' . $user['avatar']);
            }

            $data['avatar'] = 'uploads/avatars/' . $newName;
            
            // Update session data for avatar
            session()->set('user_avatar', $data['avatar']);
        }

        $this->userModel->save($data);
        
        // Update session data for username
        session()->set('username', $data['username']);

        return redirect()->to('/admin/profile')->with('success', 'Profil berhasil diperbarui');
    }
}
