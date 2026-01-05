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
        $postData = $this->request->getPost(); // Text fields
        
        // Save text fields
        foreach ($postData as $key => $val) {
             $this->saveSetting($key, $val);
        }

        // Handle files
        $files = $this->request->getFiles();
        if ($files) {
            foreach ($files as $key => $file) {
                if ($file->isValid() && ! $file->hasMoved()) {
                    $newName = $file->getRandomName();
                    $file->move(FCPATH . 'uploads', $newName);
                    $this->saveSetting($key, 'uploads/' . $newName);
                }
            }
        }

        return redirect()->to('/admin/settings')->with('message', 'Settings saved');
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
