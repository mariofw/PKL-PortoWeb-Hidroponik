<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VisitorModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $visitorModel = new VisitorModel();
        
        $data = [
            'total_visitors' => $visitorModel->countAll(),
            'today_visitors' => $visitorModel->where('visit_date', date('Y-m-d'))->countAllResults(),
        ];

        return view('admin/dashboard', $data);
    }
}