<?php


namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FormTemplates extends Model
{
    protected $fillable = [ 'id', 'user_id' ,'template_name','content', 'status', 'created_at', 'updated_at', 'deleted_at' ] ;
}
