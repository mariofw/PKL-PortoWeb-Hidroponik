<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PartnerModel;

class Partners extends BaseController
{
    protected $partnerModel;

    public function __construct()
    {
        $this->partnerModel = new PartnerModel();
    }

    public function index()
    {
        $data = [
            'partners' => $this->partnerModel->findAll(),
            'pager' => $this->partnerModel->pager,
        ];
        return view('admin/partners/index', $data);
    }

    public function create()
    {
        return view('admin/partners/form', ['title' => 'Tambah Partner']);
    }

    public function store()
    {
        $rules = [ 'name' => 'required' ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [ 'name' => $this->request->getPost('name') ];
        $imagePath = null;
        $croppedImage = $this->request->getPost('cropped_logo');

        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
        } else {
            $logo = $this->request->getFile('logo');
            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                $newName = $logo->getRandomName();
                $logo->move(ROOTPATH . 'public/uploads/partners', $newName);
                $imagePath = 'uploads/partners/' . $newName;
            }
        }
        
        if ($imagePath) {
            $data['logo_path'] = $imagePath;
        } else {
            return redirect()->back()->withInput()->with('errors', ['logo' => 'Logo image is required.']);
        }

        $this->partnerModel->save($data);
        return redirect()->to('/admin/partners')->with('success', 'Partner berhasil ditambahkan');
    }

    public function edit($id)
    {
        $partner = $this->partnerModel->find($id);
        if (!$partner) {
            return redirect()->to('/admin/partners')->with('error', 'Partner tidak ditemukan');
        }

        return view('admin/partners/form', [
            'title' => 'Edit Partner',
            'partner' => $partner,
        ]);
    }

    public function update($id)
    {
        $partner = $this->partnerModel->find($id);
        if (!$partner) {
            return redirect()->to('/admin/partners')->with('error', 'Partner tidak ditemukan');
        }

        if (!$this->validate(['name' => 'required'])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
        ];

        $imagePath = null;
        $newImageUploaded = false;
        $croppedImage = $this->request->getPost('cropped_logo');

        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
            $newImageUploaded = true;
        } else {
            $logo = $this->request->getFile('logo');
            if ($logo && $logo->isValid() && !$logo->hasMoved()) {
                $newName = $logo->getRandomName();
                $logo->move(ROOTPATH . 'public/uploads/partners', $newName);
                $imagePath = 'uploads/partners/' . $newName;
                $newImageUploaded = true;
            }
        }

        if ($newImageUploaded && $imagePath) {
            if (!empty($partner['logo_path']) && file_exists(ROOTPATH . 'public/' . $partner['logo_path'])) {
                @unlink(ROOTPATH . 'public/' . $partner['logo_path']);
            }
            $data['logo_path'] = $imagePath;
        }

        $this->partnerModel->save($data);
        return redirect()->to('/admin/partners')->with('success', 'Partner berhasil diperbarui');
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
        $uploadPath = ROOTPATH . 'public/uploads/partners';

        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0777, true);
        }
        
        $filePath = $uploadPath . '/' . $newName;
        if (file_put_contents($filePath, $decodedData)) {
            return 'uploads/partners/' . $newName;
        }
        
        return null;
    }

    public function delete($id)
    {
        $partner = $this->partnerModel->find($id);
        if ($partner) {
            if (file_exists(ROOTPATH . 'public/' . $partner['logo_path'])) {
                unlink(ROOTPATH . 'public/' . $partner['logo_path']);
            }
            $this->partnerModel->delete($id);
            return redirect()->to('/admin/partners')->with('success', 'Partner berhasil dihapus');
        }
        return redirect()->to('/admin/partners')->with('error', 'Partner tidak ditemukan');
    }
}
