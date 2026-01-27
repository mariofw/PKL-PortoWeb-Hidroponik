<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SiteSettingModel;

class Settings extends BaseController
{
    public function index()
    {
        $model = new SiteSettingModel();
        $settings = $model->findAll();
        $data = [];
        foreach ($settings as $s) {
            $data[$s['setting_key']] = $s['setting_value'];
        }
        return view('admin/settings', ['settings' => $data]);
    }

    public function save()
    {
        $model = new SiteSettingModel();
        $postData = $this->request->getPost();
        
        // Process standard file uploads (fallback, if cropper not used for a specific input)
        $files = $this->request->getFiles();
        if ($files) {
            foreach ($files as $key => $file) {
                $croppedDataSent = !empty($postData['cropped_' . $key]);
                
                if ($file->isValid() && !$file->hasMoved() && !$croppedDataSent) {
                    $this->_deleteOldSettingImage($key); // Delete old one
                    
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads', $newName);
                    $this->saveSetting($key, 'uploads/' . $newName);
                }
            }
        }

        // Process Cropped Images
        foreach ($postData as $key => $value) {
            if (strpos($key, 'cropped_') === 0 && !empty($value)) {
                $settingKey = str_replace('cropped_', '', $key); // 'cropped_site_logo' -> 'site_logo'
                
                $this->_deleteOldSettingImage($settingKey); // Delete old one first
                $imagePath = $this->_saveBase64Image($value);
                if ($imagePath) {
                    $this->saveSetting($settingKey, $imagePath);
                }
            }
        }
        
        // Process text inputs
        foreach ($postData as $key => $value) {
            if (strpos($key, 'cropped_') !== 0 && !array_key_exists($key, $files)) {
                $this->saveSetting($key, $value);
            }
        }

        return redirect()->to('/admin/settings')->with('message', 'Settings saved');
    }

    private function _deleteOldSettingImage($settingKey)
    {
        $model = new SiteSettingModel();
        $setting = $model->where('setting_key', $settingKey)->first();
        if ($setting && !empty($setting['setting_value']) && file_exists(FCPATH . $setting['setting_value'])) {
            @unlink(FCPATH . $setting['setting_value']);
        }
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

    private function saveSetting($key, $val) {
        $model = new SiteSettingModel();
        $existing = $model->where('setting_key', $key)->first();
        if ($existing) {
            $model->update($existing['id'], ['setting_value' => $val]);
        } else {
            $model->insert(['setting_key' => $key, 'setting_value' => $val]);
        }
    }
}
