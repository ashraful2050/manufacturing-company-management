<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Document extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'folder_id',
        'title',
        'file_name',
        'file_path',
        'file_type',
        'file_size_kb',
        'document_category',
        'description',
        'tags',
        'version',
        'is_public',
        'uploaded_by',
    ];
}