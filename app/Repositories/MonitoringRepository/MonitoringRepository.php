<?php

namespace App\Repositories\MonitoringRepository;

interface MonitoringRepository{
    public function getData($data, $patient_id);
}