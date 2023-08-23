<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentCol extends Model
{
    use HasFactory;

    protected $table = 'document_cols';

    protected $fillable = [
        'name',
        'position',
        'typecol'
    ];

    public function doctype()
    {
        return $this->belongsTo(DocumentValue::class)->withPivot('document_type_id');
    }

    public function values()
    {
        return $this->hasMany(DocumentValue::class);
    }
}
