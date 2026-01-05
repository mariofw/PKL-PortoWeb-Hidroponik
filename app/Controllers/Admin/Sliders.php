<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;

class Sliders extends BaseController
{
    public function index()
    {
        $model = new SliderModel();
        $data['sliders'] = $model->orderBy('order_index', 'ASC')->findAll();
        return view('admin/sliders/index', $data);
    }

    public function new()
    {
        return view('admin/sliders/form', ['action' => 'create']);
    }

    public function create()
    {
        $model = new SliderModel();
        $data = $this->request->getPost();
        
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $data['image_path'] = 'uploads/' . $newName;
        }

        $model->insert($data);
        return redirect()->to('/admin/sliders')->with('message', 'Slider added');
    }

    public function edit($id = null)
    {
        $model = new SliderModel();
        $data['slider'] = $model->find($id);
        $data['action'] = 'edit';
        return view('admin/sliders/form', $data);
    }

    public function update($id = null)
    {
        $model = new SliderModel();
        $data = $this->request->getPost();

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $data['image_path'] = 'uploads/' . $newName;
        }

        $model->update($id, $data);
        return redirect()->to('/admin/sliders')->with('message', 'Slider updated');
    }

    public function delete($id = null)
    {
        $model = new SliderModel();
        $model->delete($id);
        return redirect()->to('/admin/sliders')->with('message', 'Slider deleted');
    }
}
