<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Rating extends Model
{
    protected $guarded = [''];

	public function documents()
	{
		return $this->belongsTo(Document::class,'r_document_id');
	}

    public function user()
    {
        return $this->belongsTo(User::class,'r_user_id');
    }
}
