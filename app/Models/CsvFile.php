<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CsvFile extends Model
{
    protected $table = 'csv';
    protected $fillable = ['year', 'industry_code', 'industry_name', 'rme_size_grp', 'variable', 'value', 'unit'];
}
