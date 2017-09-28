<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
	protected $table = 'records';
	protected $fillable = ['key', 'value', 'question', 'answer', 'created_at', 'updated_at'];
}
