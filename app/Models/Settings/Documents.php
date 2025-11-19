<?php

namespace App\Models\Settings;

use App\Models\Academics\University;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\CssSelector\Node\FunctionNode;

class Documents extends Model
{
    protected $table = 'documents';
    protected $fillable = ['name','acceptable_type','max_size','is_required','university_id'];

    public function university(){
        return $this->belongsTo(University::class);
    }
}
