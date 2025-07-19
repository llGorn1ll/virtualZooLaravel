<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;
    protected $table = 'animals';
    protected $fillable = [
        'species', 'name', 'age', 'description', 'image', 'cage_id'
    ];
    public $timestamps = false;
    public function cage()
    {
        return $this->belongsTo(Cage::class);
    }
} 