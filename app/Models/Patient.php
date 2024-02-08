<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
 use Illuminate\Database\Eloquent\Factories\HasFactory;
class Patient extends Model
{
    use HasFactory;    public $table = 'patients';

    public $fillable = [
        'tuteur_id',
        'niveau_scolaire_id',
        'nom',
        'prenom',
        'telephone',
        'cin',
        'email',
        'image',
        'adresse',
        'remarques',
        'date_naissance',
        'sexe',
    ];

    protected $casts = [
        'nom' => 'string',
        'prenom' => 'string',
        'telephone' => 'string',
        'cin' => 'string',
        'email' => 'string',
        'image' => 'string',
        'adresse' => 'string',
        'remarques' => 'string',
        'date_naissance' => 'date',
        'sexe' => 'string',
    ];

    public static array $rules = [
        'tuteur_id' => 'nullable',
        'niveau_scolaire_id' => 'nullable',
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'telephone' => 'nullable|string|max:255',
        'cin' => 'nullable|string|max:255',
        'email' => 'nullable|string|max:255',
        'image' => 'nullable|file|max:255',
        'adresse' => 'nullable|string|max:255',
        'remarques' => 'nullable|string|max:65535',
        'created_at' => 'nullable',
        'updated_at' => 'nullable',
        'date_naissance' => 'nullable',
        'sexe' => 'nullable',
    ];

    public function niveauScolaire(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\NiveauScolaire::class, 'niveau_scolaire_id');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\Tuteur::class, 'tuteur_id');
    }

    public function dossierPatients(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\DossierPatient::class, 'patient_id');
    }

    public function reclamations(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(\App\Models\Reclamation::class, 'patients_id');
    }
}
