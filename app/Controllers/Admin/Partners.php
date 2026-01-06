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
        if (!$this->validate([
            'name' => 'required',
            'logo' => [
                'uploaded[logo]',
                'mime_in[logo,image/jpg,image/jpeg,image/png,image/gif]',
                'max_size[logo,2048]',
            ],
        ])) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $logo = $this->request->getFile('logo');
        $newName = $logo->getRandomName();
        $logo->move(ROOTPATH . 'public/uploads/partners', $newName);

        $this->partnerModel->save([
            'name' => $this->request->getPost('name'),
            'logo_path' => 'uploads/partners/' . $newName,
        ]);

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

        $rules = [
            'name' => 'required',
        ];

        if ($this->request->getFile('logo')->isValid()) {
            $rules['logo'] = [
                'uploaded[logo]',
                'mime_in[logo,image/jpg,image/jpeg,image/png,image/gif]',
                'max_size[logo,2048]',
            ];
        }

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'id' => $id,
            'name' => $this->request->getPost('name'),
        ];

        $logo = $this->request->getFile('logo');
        if ($logo->isValid() && !$logo->hasMoved()) {
            // Delete old image
            if (file_exists(ROOTPATH . 'public/' . $partner['logo_path'])) {
                unlink(ROOTPATH . 'public/' . $partner['logo_path']);
            }

            $newName = $logo->getRandomName();
            $logo->move(ROOTPATH . 'public/uploads/partners', $newName);
            $data['logo_path'] = 'uploads/partners/' . $newName;
        }

        $this->partnerModel->save($data);

        return redirect()->to('/admin/partners')->with('success', 'Partner berhasil diperbarui');
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
