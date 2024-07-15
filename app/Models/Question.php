<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ua_mst_leads_questions';
    protected $fillable = [
        'question', 'multiple_answer', 'type_grid', 'page', 'confirmation', 'createdBy', 'createdAt', 'updatedBy',
        'updatedAt', 'deletedBy', 'deletedAt'
    ];
}
