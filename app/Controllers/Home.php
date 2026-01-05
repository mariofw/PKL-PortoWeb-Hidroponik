<?php

namespace App\Controllers;

use App\Models\SliderModel;
use App\Models\ServiceModel;
use App\Models\ArticleModel;
use App\Models\SiteSettingModel;
use App\Models\VisitorModel;

class Home extends BaseController
{
    public function index()
    {
        // Tracking Logic
        $visitorModel = new VisitorModel();
        $ip = $this->request->getIPAddress();
        $agent = $this->request->getUserAgent();
        $today = date('Y-m-d');

        // Only count if this IP hasn't visited today
        if (!$visitorModel->where('ip_address', $ip)->where('visit_date', $today)->first()) {
            $visitorModel->save([
                'ip_address' => $ip,
                'user_agent' => (string) $agent,
                'visit_date' => $today
            ]);
        }

        $data = [];
        $data['sliders'] = (new SliderModel())->orderBy('order_index', 'ASC')->findAll();
        $data['services'] = (new ServiceModel())->findAll();
        $data['articles'] = (new ArticleModel())->orderBy('created_at', 'DESC')->findAll();
        
        $settings = (new SiteSettingModel())->findAll();
        $data['settings'] = [];
        foreach($settings as $s) {
            $data['settings'][$s['setting_key']] = $s['setting_value'];
        }

        return view('landing_page', $data);
    }

    public function article($slug)
    {
        $model = new ArticleModel();
        $article = $model->where('slug', $slug)->first();

        if (!$article) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // If it's external, redirect (safety net, though link should handle it)
        if ($article['link_type'] === 'external' && !empty($article['external_url'])) {
            return redirect()->to($article['external_url']);
        }

        $settings = (new SiteSettingModel())->findAll();
        $data['settings'] = [];
        foreach($settings as $s) {
            $data['settings'][$s['setting_key']] = $s['setting_value'];
        }
        
        $data['article'] = $article;
        return view('article_detail', $data);
    }
}
