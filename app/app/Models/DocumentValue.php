<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentValue extends Model
{
    use HasFactory;

    protected $table = 'document_values';

    protected $fillable = [
        'uid',
        'value'
    ];

    public function document_col()
    {
        return $this->belongsTo(DocumentCol::class);
    }
}
