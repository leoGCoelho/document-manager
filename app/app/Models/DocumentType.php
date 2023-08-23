<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentType extends Model
{
    use HasFactory;

    protected $table = 'document_types';

    protected $fillable = [
        'name',
        'pdftemplate'
    ];

    public function cols()
    {
        return $this->hasMany(DocumentCol::class)->orderBy('position', 'asc');
    }

    public function values()
    {
        return $this->hasManyThrough(DocumentValue::class, DocumentCol::class);
    }
}
