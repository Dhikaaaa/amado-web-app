<?php

namespace App\Services\UserService\Implement;

use App\Repositories\UserRepository\Implement\PatientRepository;
use App\Services\UserService\UserService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientService implements UserService
{

    protected $patientRepository;

    public function __construct(PatientRepository $patientRepository)
    {
        $this->patientRepository = $patientRepository;
    }


    // update patien data
    public function updateUser($request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'jenis_kelamin' => 'required',
            'tanggal_lahir' => 'required',
            'phone' => 'required',
            'alamat' => 'required',
        ]);

        if ($validator->fails()) {
            return;
        }

        $patientUpdateData = collect($request);

        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();

        $patientUpdated = $this->patientRepository->saveUpdateUser($patientHasBeenAuthenticated, $patientUpdateData);

        return $patientUpdated;
    }


    // update patient photo profile
    public function updateUserPhoto($request)
    {
        $validator = Validator::make($request->all(), [
            'photo' => 'required'
        ]);

        if ($validator->fails()) {
            return;
        }

        // get base 64 file
        $patientPhotoFile = $request->photo;

        // get patient authenticated
        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();

        // convert to image
        $image = convertBase64ToImage($patientPhotoFile);

        // save profile
        $patientPhotoUpdated = $this->patientRepository->savePhotoProfile($patientHasBeenAuthenticated, $image);

        return $patientPhotoUpdated;
    }


    public function getUserPhoto($request)
    {
        $patientHasBeenAuthenticated = Auth::guard('patientapi')->user();

        $imagePath = $this->patientRepository->getPhotoProfile($patientHasBeenAuthenticated->id);

        if ($imagePath != null) {
            $base64 =  convertImageToBase64($imagePath);
            return $base64;
        }

        return null;
    }

    public function getBiodata($request)
    {
        $patientId = $request->id;
        $patientBiodata = $this->patientRepository->getPatient($patientId);
        return $patientBiodata;
    }
}
