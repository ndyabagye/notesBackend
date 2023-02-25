<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tags extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['title'];

    protected $searchableFields = ['*'];

    public function allNotes()
    {
        return $this->belongsToMany(Notes::class);
    }
}
