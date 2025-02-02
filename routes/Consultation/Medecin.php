<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Consultation\ConsultationController;

Route::prefix('Médecin-général')->group(function () {
   // List des consultation et editer et supprimer et consulter la consultation
Route::get('/',[ConsultationController::class, 'list_consultations'])->name('consultations.list');
Route::get('/Consultations/Consultation/{consultationID}',[ConsultationController::class, 'show'])->name('consultations.consulter');
Route::get('/Consultations/{consultationID}/edit',[ConsultationController::class, 'edit'])->name('consultations.formEdit');
Route::patch('/Consultations/{consultationID}/update',[ConsultationController::class, 'update'])->name('consultations.modifier');
Route::delete('/Consultations/{consultationID}/delete',[ConsultationController::class, 'destroy'])->name('consultations.supprimer');

// Phase 1 = choix un dossier bénéficiaire dans rendez vous
Route::get('/Consultations/Rendez-Vous',[ConsultationController::class, 'list_rendezVous'])->name('consultations.rendezvous');
Route::get('/Consultations/Choix-Rendez-Vous',[ConsultationController::class, 'SelectRendezVous'])->name('consultations.rendezvous-select');

// Phase 2 = voir les informations de bénéficiaire
Route::get('/Consultations/Choix-Rendez-Vous/dossier-bénéficiaire-id/{dossier_patient_id}/bénéficiaire',[ConsultationController::class, 'InformationPatient'])->name('consultations.patientInformation');

// Phase 3 = Ajouter un consultation
Route::get('/Consultations/Choix-Rendez-Vous/dossier-bénéficiaire-id/{dossier_patient_id}/bénéficiaire/Form-consultation', [ConsultationController::class, 'FormAjouterConsultation'])->name('consultations.FormAjouterConsultation');
Route::post('/Consultations/Choix-Rendez-Vous/dossier-bénéficiaire-id/{dossier_patient_id}/bénéficiaire/Form-consultation/ajouter', [ConsultationController::class, 'AjouterConsultation'])->name('consultations.AjouterConsultation');
Route::get('/dossiers-patients',[App\Http\Controllers\PoleSocial\EntretienSocialController::class, 'list_dossier'])->name('dossier-patients.Médecin-général');


});