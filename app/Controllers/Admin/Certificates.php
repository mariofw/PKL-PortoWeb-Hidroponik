<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CertificateModel;

class Certificates extends BaseController
{
    protected $certificateModel;

    public function __construct()
    {
        $this->certificateModel = new CertificateModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Manajemen Sertifikat Kompetensi',
            'certificates' => $this->certificateModel->findAll()
        ];
        return view('admin/certificates/index', $data);
    }

    public function new()
    {
        $data = [
            'title' => 'Tambah Sertifikat',
            'validation' => \Config\Services::validation()
        ];
        return view('admin/certificates/form', $data);
    }

    public function create()
    {
        $rules = [
            'title' => 'required|min_length[3]',
            'image' => 'uploaded[image]|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $img = $this->request->getFile('image');
        $newName = $img->getRandomName();
        $img->move(ROOTPATH . 'public/uploads', $newName);

        $this->certificateModel->save([
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
            'image_path' => 'uploads/' . $newName,
        ]);

        return redirect()->to('/admin/certificates')->with('success', 'Sertifikat berhasil ditambahkan');
    }

    public function edit($id)
    {
        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return redirect()->to('/admin/certificates')->with('error', 'Data tidak ditemukan');
        }

        $data = [
            'title' => 'Edit Sertifikat',
            'certificate' => $certificate,
            'validation' => \Config\Services::validation()
        ];
        return view('admin/certificates/form', $data);
    }

    public function update($id)
    {
        $certificate = $this->certificateModel->find($id);
        if (!$certificate) {
            return redirect()->to('/admin/certificates')->with('error', 'Data tidak ditemukan');
        }

        $rules = [
            'title' => 'required|min_length[3]',
            'image' => 'permit_empty|is_image[image]|mime_in[image,image/jpg,image/jpeg,image/png,image/webp]|max_size[image,2048]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput();
        }

        $data = [
            'id' => $id,
            'title' => $this->request->getPost('title'),
            'description' => $this->request->getPost('description'),
        ];

        $img = $this->request->getFile('image');
        if ($img->isValid() && !$img->hasMoved()) {
            $newName = $img->getRandomName();
            $img->move(ROOTPATH . 'public/uploads', $newName);
            
            // Delete old image if exists
            if (!empty($certificate['image_path']) && file_exists(ROOTPATH . 'public/' . $certificate['image_path'])) {
                unlink(ROOTPATH . 'public/' . $certificate['image_path']);
            }
            
            $data['image_path'] = 'uploads/' . $newName;
        }

        $this->certificateModel->save($data);

        return redirect()->to('/admin/certificates')->with('success', 'Sertifikat berhasil diperbarui');
    }

    public function delete($id)
    {
        $certificate = $this->certificateModel->find($id);
        if ($certificate) {
            if (!empty($certificate['image_path']) && file_exists(ROOTPATH . 'public/' . $certificate['image_path'])) {
                unlink(ROOTPATH . 'public/' . $certificate['image_path']);
            }
            $this->certificateModel->delete($id);
        }
        return redirect()->to('/admin/certificates')->with('success', 'Sertifikat berhasil dihapus');
    }
}
