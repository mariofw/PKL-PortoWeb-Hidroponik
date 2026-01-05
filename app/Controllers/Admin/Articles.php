<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\ArticleModel;

class Articles extends BaseController
{
    public function index()
    {
        $model = new ArticleModel();
        $data['articles'] = $model->findAll();
        return view('admin/articles/index', $data);
    }

    public function new()
    {
        return view('admin/articles/form', ['action' => 'create']);
    }

    public function create()
    {
        $model = new ArticleModel();
        $data = $this->request->getPost();
        
        // Handle logic if needed, though model allowedFields covers it
        if($data['link_type'] === 'external') {
            $data['content'] = ''; // Clear content if external
        } else {
            $data['external_url'] = ''; // Clear URL if internal
        }

        $data['slug'] = url_title($data['title'], '-', true);
        
        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $data['image_path'] = 'uploads/' . $newName;
        }

        $model->insert($data);
        return redirect()->to('/admin/articles')->with('message', 'Article added');
    }

    public function edit($id = null)
    {
        $model = new ArticleModel();
        $data['article'] = $model->find($id);
        $data['action'] = 'edit';
        return view('admin/articles/form', $data);
    }

    public function update($id = null)
    {
        $model = new ArticleModel();
        $data = $this->request->getPost();
        
        // Handle logic if needed, though model allowedFields covers it
        if($data['link_type'] === 'external') {
            $data['content'] = ''; // Clear content if external
        } else {
            $data['external_url'] = ''; // Clear URL if internal
        }

        $data['slug'] = url_title($data['title'], '-', true);

        $file = $this->request->getFile('image');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads', $newName);
            $data['image_path'] = 'uploads/' . $newName;
        }

        $model->update($id, $data);
        return redirect()->to('/admin/articles')->with('message', 'Article updated');
    }

    public function delete($id = null)
    {
        $model = new ArticleModel();
        $model->delete($id);
        return redirect()->to('/admin/articles')->with('message', 'Article deleted');
    }
}
