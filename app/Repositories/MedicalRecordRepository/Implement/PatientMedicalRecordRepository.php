<?php

namespace App\Repositories\MedicalRecordRepository\Implement;

use App\Models\MedicalRecord\MedicalRecord;
use App\Models\Patient\Patient;
use App\Repositories\MedicalRecordRepository\IMedicalRecordRepository;

class PatientMedicalRecordRepository implements IMedicalRecordRepository
{

    private Patient $patient;
    private MedicalRecord $medicalRecord;

    public function __construct(Patient $model, MedicalRecord $medicalRecord)
    {
        $this->patient = $model;
        $this->medicalRecord = $medicalRecord;
    }

    public function get($patient_id)
    {
        $patient = $this->patient::find($patient_id);
    }

    public function save($patient_id, $avgSpo2, $status, $recomendation)
    {
    }

    public function update($patient_id)
    {
    }
}
