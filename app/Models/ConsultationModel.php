<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationModel extends Model
{
    use HasFactory;

    protected $table = 'consultations';

    public function createConsultation($data, $doctor_id)
    {
        $this->user_id = $data['user_id'];
        $this->doctor_id = $doctor_id->id;

        $this->patient_complaints = $data['patient_complaints'];
        $this->examination_description = $data['examination_description'];
        $this->saturation = $data['saturation'];
        $this->pressure = $data['pressure'];
        $this->temperature = $data['temperature'];
        $this->weight = $data['weight'];
        $this->height = $data['height'];
        $this->icd_code = $data['icd_code'];
        $this->additional_information = $data['additional_information'];
        $this->final_prescription = $data['final_prescription'];
        $this->recommendations_prescription = $data['recommendations_prescription'];
        $this->save();

        return $this->id;
    }
}
