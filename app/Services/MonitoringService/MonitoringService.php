<?php

namespace App\Services\MonitoringService;

use Illuminate\Http\Request;

interface MonitoringService{
    public function getSensorData(Request $data);
}