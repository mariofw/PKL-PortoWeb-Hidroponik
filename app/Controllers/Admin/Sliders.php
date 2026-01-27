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
            $existingSlider = $model->find($id);
            if ($existingSlider && !empty($existingSlider['image_path']) && file_exists(FCPATH . $existingSlider['image_path'])) {
                @unlink(FCPATH . $existingSlider['image_path']);
            }
        }

        unset($data['cropped_image']);
        $model->update($id, $data);
        return redirect()->to('/admin/sliders')->with('message', 'Slider updated');
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
        $model = new SliderModel();
        $slider = $model->find($id);

        if ($slider) {
            // Delete the image file first
            if (!empty($slider['image_path']) && file_exists(FCPATH . $slider['image_path'])) {
                @unlink(FCPATH . $slider['image_path']);
            }
            
            $model->delete($id);
            return redirect()->to('/admin/sliders')->with('message', 'Slider deleted successfully');
        }

        return redirect()->to('/admin/sliders')->with('error', 'Slider not found');
    }
}
