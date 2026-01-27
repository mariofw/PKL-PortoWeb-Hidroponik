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

    public function create()
    {
        return view('admin/articles/form', ['action' => 'create']);
    }

    public function store()
    {
        $model = new ArticleModel();
        $data = $this->request->getPost();
        
        if($data['link_type'] === 'external') {
            $data['content'] = '';
        } else {
            $data['external_url'] = '';
        }
        $data['slug'] = url_title($data['title'], '-', true);
        
        $croppedImage = $this->request->getPost('cropped_image');
        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
            if ($imagePath) {
                $data['image_path'] = $imagePath;
            }
        } else {
            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads', $newName);
                $data['image_path'] = 'uploads/' . $newName;
            }
        }

        unset($data['cropped_image']);
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
        
        if($data['link_type'] === 'external') {
            $data['content'] = '';
        } else {
            $data['external_url'] = '';
        }
        $data['slug'] = url_title($data['title'], '-', true);
        
        $newImageUploaded = false;
        $croppedImage = $this->request->getPost('cropped_image');
        if (!empty($croppedImage)) {
            $imagePath = $this->_saveBase64Image($croppedImage);
            if ($imagePath) {
                $data['image_path'] = $imagePath;
                $newImageUploaded = true;
            }
        } else {
            $file = $this->request->getFile('image');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $file->move(FCPATH . 'uploads', $newName);
                $data['image_path'] = 'uploads/' . $newName;
                $newImageUploaded = true;
            }
        }

        if ($newImageUploaded) {
            $existing = $model->find($id);
            if ($existing && !empty($existing['image_path']) && file_exists(FCPATH . $existing['image_path'])) {
                @unlink(FCPATH . $existing['image_path']);
            }
        }

        unset($data['cropped_image']);
        $model->update($id, $data);
        return redirect()->to('/admin/articles')->with('message', 'Article updated');
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
        $uploadPath = FCPATH . 'uploads';

        if (!is_dir($uploadPath)) {
            @mkdir($uploadPath, 0777, true);
        }
        
        $filePath = $uploadPath . '/' . $newName;
        if (file_put_contents($filePath, $decodedData)) {
            return 'uploads/' . $newName;
        }
        
        return null;
    }

    public function delete($id = null)
    {
        $model = new ArticleModel();
        $article = $model->find($id);

        if ($article) {
            if (!empty($article['image_path']) && file_exists(FCPATH . $article['image_path'])) {
                @unlink(FCPATH . $article['image_path']);
            }
            
            $model->delete($id);
            return redirect()->to('/admin/articles')->with('message', 'Article deleted');
        }

        return redirect()->to('/admin/articles')->with('error', 'Article not found');
    }
}
