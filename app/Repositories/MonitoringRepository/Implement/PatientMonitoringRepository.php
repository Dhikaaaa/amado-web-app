<?php

namespace App\Repositories\MonitoringRepository\Implement;

use App\Models\Patient;
use App\Repositories\MonitoringRepository\MonitoringRepository;


class PatientMonitoringRepository implements MonitoringRepository{
    /**
     * *Instansiasi objek pasien
     */
    protected $patient;
    
    public function __construct(Patient $model)
    {
        $this->patient = $model;
    }

    
    public function getData($data, $patient_id)
    {

    }
}