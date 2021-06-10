<?php

namespace App\Services\DeviceService\Implement;

use App\Repositories\DeviceRepository\Implement\PatientHardwareRepository;
use App\Services\DeviceService\DeviceOperationService;
use App\Services\DeviceService\DeviceService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientHardwareService implements DeviceService, DeviceOperationService
{

    protected $hardwareRepository;

    public function __construct(PatientHardwareRepository $hardware)
    {
        $this->hardwareRepository = $hardware;
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

        return $deviceStatus;
    }
}
