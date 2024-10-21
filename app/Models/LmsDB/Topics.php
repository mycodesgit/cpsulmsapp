<?php

namespace App\Models\LmsDB;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topics extends Model
{
    use HasFactory;

    //protected $connection = 'mysql';
    protected $table = 'classfile_upload';

    protected $fillable = [
        'schlyear',
        'semester',
        'campus',
        'instructorID',
        'subjectID',
        'topicname',
        'desctopicname',
        'filedocs', 
        'postedBy'
    ];
}
