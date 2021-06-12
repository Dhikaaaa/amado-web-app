<?php

namespace App\Services\DeviceService\Implement;

use App\Repositories\DeviceRepository\Implement\PatientHardwareRepository;
use App\Services\DeviceService\DeviceOperationService;
use App\Services\DeviceService\DeviceService;
use App\Services\MonitoringService\Implement\PatientMonitoringService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repositories\MonitoringRepository\Implement\PatientMonitoringRepository;
use Illuminate\Support\Facades\Log;

class PatientHardwareService implements DeviceService, DeviceOperationService
{

    protected PatientHardwareRepository $hardwareRepository;
    protected PatientMonitoringService $monitoringService;


    public function __construct(
        PatientHardwareRepository $hardware,
        PatientMonitoringService $service
    ) {
        $this->hardwareRepository = $hardware;
        $this->monitoringService = $service;
    }


    public function storeDevice($request)
    {
        $validator = Validator::make($request->all(), [
            'serial_number' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();
        $hardwareDeviceStored = $this->hardwareRepository->saveDevice($patientHasBeenAuthenticated->id, $request->serial_number);

        // initialiizing 0 times monitoring
        $this->monitoringService->initialMonitoring($patientHasBeenAuthenticated->id, 0);

        return $hardwareDeviceStored;
    }



    public function updateDevice()
    {
        // TODO : Update Device
    }



    public function deleteDevice()
    {
        // TODO : Delete Device
    }



    public function enableDevice($request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();
        $deviceStatus = $this->hardwareRepository->on($patientHasBeenAuthenticated->id, $request->status);

        Log::info("Enabled Device for patient id {$patientHasBeenAuthenticated->id}");

        return $deviceStatus;
    }



    public function disableDevice($request)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();
        $deviceStatus = $this->hardwareRepository->off($patientHasBeenAuthenticated->id, $request->status);
        Log::info("Disabled device for patient id {$patientHasBeenAuthenticated->id}");

        // upgrade monitoring value to + 1
        $this->monitoringService->updateTotalMonitoring($patientHasBeenAuthenticated->id, 1);

        return $deviceStatus;
    }
}
