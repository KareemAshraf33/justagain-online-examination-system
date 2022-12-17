<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    
     protected $fillable = [
        'exam_name',
        'date',
        'time'
    ];
    
    public function getQnaExam()
    {
        return $this->hasMany(QnaExam::class,'exam_id','id');
    }
}
