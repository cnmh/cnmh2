<?php

namespace App\Repositories\EntretienSocial;

use App\Models\DossierPatient;
use App\Repositories\BaseRepository;
use App\Models\EtatCivil;
use App\Models\NiveauScolaire;
use App\Models\Service;
use App\Models\TypeHandicap;
use App\Models\CouvertureMedical;
use App\Models\Patient;
use App\Models\Tuteur;
use App\Models\DossierPatient_typeHandycape;
use App\Models\Dossier_patient_service;
use App\Models\DossierPatientConsultation;
use App\Models\Consultation;

class DossierPatientRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'patient_id',
        'couverture_medical_id',
        'numero_dossier',
        'etat',
        'date_enregsitrement'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

   
    public function entretienSocial($enquette,$patiendID){
        $enquette['patient_id'] = $patiendID;
        $this->model->newInstance($enquette);
        $this->model->create($enquette);
        $dossierPatient =  $this->model->where('numero_dossier', $enquette['numero_dossier'])->first();
        $typeHandycapeIDs = $enquette->input('type_handicap_id');
        $service_ids = $enquette->input('services_id');
        $dossierPatientID = $dossierPatient->id;
        $date_enregsitrement = $enquette->date_enregsitrement;
        $this->DossierPatient_typeHandycape($typeHandycapeIDs,$dossierPatientID);
        $this->Dossier_patient_service($service_ids,$dossierPatientID);
        // Ajouter dossier en list d'attente
        $this->Consultation($date_enregsitrement,$dossierPatientID);
    }

     // Ajouter dossier patient type handicap
    public function DossierPatient_typeHandycape($typeHandycapeIDs,$dossierPatientID){
        foreach ($typeHandycapeIDs as $typeHandycapeID) {
            $DossierPatient_typeHandycape = new DossierPatient_typeHandycape;
            $DossierPatient_typeHandycape->type_handicap_id = $typeHandycapeID;
            $DossierPatient_typeHandycape->dossier_patient_id = $dossierPatientID;
            $DossierPatient_typeHandycape->save();
        }
    }

    // Ajouter dossier patient service demander
    public function Dossier_patient_service($service_ids,$dossierPatientID){

        foreach($service_ids as $service_id){
            $service_patient_demander = new Dossier_patient_service;
            $service_patient_demander->service_id = $service_id;
            $service_patient_demander->dossier_patient_id = $dossierPatientID;
            $service_patient_demander->save();
        }
    }

    // Ajouter consultation
    public function Consultation($date_enregsitrement,$dossierPatientID){

        $consultation = new Consultation();
        $consultation->date_enregistrement=$date_enregsitrement;
        $consultation->type="medecinGeneral";
        $consultation->etat="enAttente";
        $consultation->save();
        $consultationID = $consultation->id;
        $this->dossierPatientConsultation($dossierPatientID,$consultationID);


    }

    // Ajouter dossier patient consultation
    public function dossierPatientConsultation($dossierPatientID,$consultationID){

        $DossierPatient_consultation =  new DossierPatientConsultation;
        $DossierPatient_consultation->dossier_patient_id = $dossierPatientID;
        $DossierPatient_consultation->consultation_id  = $consultationID;
        $DossierPatient_consultation->save();
    }

    public function model(): string
    {
        return DossierPatient::class;
    }
}