<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ServiceModel;

class Services extends BaseController
{
    public function index()
    {
        $model = new ServiceModel();
        $data['services'] = $model->findAll();
        return view('admin/services/index', $data);
    }

    public function new()
    {
        return view('admin/services/form', ['action' => 'create']);
    }

    public function create()
    {
        $model = new ServiceModel();
        $data = $this->request->getPost();
        
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $data['icon_image'] = 'uploads/' . $newName;
        }

        $model->insert($data);
        return redirect()->to('/admin/services')->with('message', 'Service added');
    }

    public function edit($id = null)
    {
        $model = new ServiceModel();
        $data['service'] = $model->find($id);
        $data['action'] = 'edit';
        return view('admin/services/form', $data);
    }

    public function update($id = null)
    {
        $model = new ServiceModel();
        $data = $this->request->getPost();

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $data['icon_image'] = 'uploads/' . $newName;
        }

        $model->update($id, $data);
        return redirect()->to('/admin/services')->with('message', 'Service updated');
    }

    public function delete($id = null)
    {
        $model = new ServiceModel();
        $model->delete($id);
        return redirect()->to('/admin/services')->with('message', 'Service deleted');
    }
}
