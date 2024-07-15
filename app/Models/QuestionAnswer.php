<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuestionAnswer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ua_mst_leads_questions';
    protected $fillable = [
        'question_id', 'answer', 'value', 'createdBy', 'createdAt', 'updatedBy',
        'updatedAt', 'deletedBy', 'deletedAt'
    ];
}
