<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ua_mst_members';
    protected $fillable = [
        'org_id', 'club_id', 'leads_id', 'email', 'password'
    ];
}
