<?php

namespace App\Services\MonitoringService\Implement;

use App\Repositories\MonitoringRepository\Implement\PatientMonitoringRepository;
use App\Services\MonitoringService\MonitoringService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PatientMonitoringService implements MonitoringService
{

    protected PatientMonitoringRepository $monitoringRepo;

    public function __construct(PatientMonitoringRepository $repo)
    {
        $this->monitoringRepo = $repo;
    }

    public function updateTotalMonitoring(int $patient_id, int $total)
    {
        $totalCurrentMonitoring = $this->monitoringRepo->get($patient_id);
        if ($totalCurrentMonitoring < 3) {
            $currentUpdateMonitoring = $totalCurrentMonitoring + $total;
            $this->monitoringRepo->update($patient_id, $currentUpdateMonitoring);
        } else {
            // roll back to 0 value, because max monitoring is 3
            $this->monitoringRepo->update($patient_id, 0);
        }
    }

    public function initialMonitoring(int $patient_id, int $total)
    {
        $this->monitoringRepo->create($patient_id, $total);
    }


    /**
     * * Get patient has been authenticated
     */
    public function getCurrentPatientAuthenticated()
    {
        return Auth::guard('patientapi')->user();
    }
}
