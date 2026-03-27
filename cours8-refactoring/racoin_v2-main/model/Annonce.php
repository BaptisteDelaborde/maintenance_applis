<?php

namespace model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Annonce extends Model
{
    protected $table = 'annonce';
    protected $primaryKey = 'id_annonce';
    public $timestamps = false;

    /** @var array|null */
    public ?array $links = null; // Typage PHP 8 autorisé ici car c'est votre propriété

    public function annonceur(): BelongsTo
    {
        return $this->belongsTo(Annonceur::class, 'id_annonceur');
    }

    public function photo(): HasMany
    {
        // Remplacement de 'id_photo' par 'id_annonce' qui est la clé étrangère dans la table photo
        return $this->hasMany(Photo::class, 'id_annonce');
    }
}