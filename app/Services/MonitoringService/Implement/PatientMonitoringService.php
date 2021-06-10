<?php

namespace App\Services\MonitoringService\Implement;

use App\Repositories\MonitoringRepository\Implement\PatientMonitoringRepository;
use App\Services\MonitoringService\MonitoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientMonitoringService implements MonitoringService{

    /**
     * * Instansiasi repo
     */
     protected $repositoryMonitoring;

     public function __construct(PatientMonitoringRepository $repo)
     {
         $this->repositoryMonitoring = $repo;
     }

    public function getSensorData(Request $data)
    {
             
    }
}