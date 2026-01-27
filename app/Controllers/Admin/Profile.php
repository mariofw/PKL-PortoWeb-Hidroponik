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
            'avatar'   => 'permit_empty|is_image[avatar]|mime_in[avatar,image/jpg,image/jpeg,image/png,image/webp]|max_size[avatar,15360]',
        ];

        if ($this->request->getPost('password')) {
            $rules['password'] = 'required|min_length[6]';
            $rules['password_confirm'] = 'required|matches[password]';
        }

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $userId,
            'username' => $this->request->getPost('username'),
        ];

        if ($this->request->getPost('password')) {
            $data['password_hash'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $newImageUploaded = false;
        $croppedImage = $this->request->getPost('cropped_avatar');
        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
            if ($imagePath) {
                $data['avatar'] = $imagePath;
                $newImageUploaded = true;
            }
        } else {
            $img = $this->request->getFile('avatar');
            if ($img && $img->isValid() && !$img->hasMoved()) {
                $newName = $img->getRandomName();
                $img->move(ROOTPATH . 'public/uploads/avatars', $newName);
                $data['avatar'] = 'uploads/avatars/' . $newName;
                $newImageUploaded = true;
            }
        }

        if ($newImageUploaded) {
            if (!empty($user['avatar']) && file_exists(ROOTPATH . 'public/' . $user['avatar'])) {
                @unlink(ROOTPATH . 'public/' . $user['avatar']);
            }
            session()->set('user_avatar', $data['avatar']);
        }

        $this->userModel->save($data);
        session()->set('username', $data['username']);

        return redirect()->to('/admin/profile')->with('success', 'Profil berhasil diperbarui');
    }

    private function _saveBase64Image($base64String) {
        if (empty($base64String) || strpos($base64String, 'data:image') !== 0) {
            return null;
        }
        
        list($type, $data) = explode(';', $base64String);
        list(, $data)      = explode(',', $data);
        $decodedData = base64_decode($data);

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->buffer($decodedData);
        $extensions = [
            'image/jpeg' => 'jpg', 'image/png'  => 'png', 'image/gif'  => 'gif', 'image/webp' => 'webp'
        ];
        $extension = $extensions[$mime_type] ?? 'jpg';
        
        $newName = bin2hex(random_bytes(10)) . '.' . $extension;
        $uploadPath = ROOTPATH . 'public/uploads/avatars';

        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0777, true);
        }
        
        $filePath = $uploadPath . '/' . $newName;
        if (file_put_contents($filePath, $decodedData)) {
            return 'uploads/avatars/' . $newName;
        }
        
        return null;
    }
}
