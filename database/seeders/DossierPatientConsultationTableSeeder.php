<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DossierPatientConsultation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;



/**
 * Class DossierPatientConsultationTableSeeder
 *
 * @author Amine Lamchatab
 * CodeCampers
 */


class DossierPatientConsultationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dossierPatients = \App\Models\DossierPatient::all();
        $consultations = \App\Models\Consultation::all();

        foreach ($dossierPatients as $dossierPatient) {
            $randomConsultation = $consultations->random();

            DossierPatientConsultation::insert([
                'dossier_patient_id' => $dossierPatient->id,
                'consultation_id' => $randomConsultation->id,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
