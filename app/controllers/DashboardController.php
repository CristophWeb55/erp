<?php

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'pageTitle' => 'Dashboard Principal',
            'controller' => 'Dashboard'
        ];
        $this->view('dashboard/index', $data);
    }
}
