<?php
require_once '../app/models/Dashboard.php';

class DashboardController extends Controller
{
    public function index()
    {
        $model = new Dashboard();
        $kpis = $model->getKpis();
        $activity = $model->getRecentActivity();

        $data = [
            'pageTitle' => 'Dashboard Principal',
            'controller' => 'Dashboard',
            'kpis' => $kpis,
            'activity' => $activity
        ];
        $this->view('dashboard/index', $data);
    }
}
