<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cage extends Model
{
    use HasFactory;
    protected $table = 'cages';
    protected $fillable = [
        'name', 'capacity'
    ];
    public function animals()
    {
        return $this->hasMany(Animal::class);
    }
} 