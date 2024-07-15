<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PackageMembership extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $table = 'ua_package_memberships';
    protected $fillable = [
        'org_id', 'club_id', 'membership_type_id', 'membership_categories_id', 'membership_payment_id', 'membership_promo_id',
        'membership_type_card_id', 'shift_id', 'name', 'description', 'price', 'admin_fee', 'subs_disc_val', 'subs_disc_pcn',
        'session', 'expired', 'add_on', 'images', 'icon', 'is_mobile', 'min_value', 'max_value', 'createdBy', 'createdAt', 'updatedBy',
        'updatedAt', 'deletedBy', 'deletedAt', 'is_active', 'is_deleted', 'month', 'total_session'
    ];
}
