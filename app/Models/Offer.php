<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    use HasFactory;

    protected $table = 'offers';
    protected $fillable = ['issue_date', 'insurance_premium', 'insured_name', 'insured_cnp'];

    public function offer()
    {
        return $this->belongsTo(User::class);
    }
}
