<?php

namespace App\Repositories\MedicalRecordRepository;

interface IMedicalRecordRepository
{
    function get($patient_id);
    function save($patient_id, $avgSpo2, $status, $recomendation);
    function update($patient_id);
}
