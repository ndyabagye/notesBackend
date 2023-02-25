<?php

namespace App\Models;

use App\Models\Scopes\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Notes extends Model
{
    use HasFactory;
    use Searchable;

    protected $fillable = ['user_id', 'title', 'description', 'color'];

    protected $searchableFields = ['*'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function allTags()
    {
        return $this->belongsToMany(Tags::class);
    }
}
