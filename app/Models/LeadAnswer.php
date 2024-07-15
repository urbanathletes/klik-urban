<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeadAnswer extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ua_mst_leads_answers';
    protected $fillable = [
        'lead_id', 'question_id', 'answer_id', 'createdBy', 'createdAt', 'updatedBy',
        'updatedAt', 'deletedBy', 'deletedAt'
    ];
}
