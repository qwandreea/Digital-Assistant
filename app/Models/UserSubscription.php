<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class UserSubscription extends Model
{
    use HasFactory;
    
    protected $table = 'user_subscription';
    
    public $primaryKey = 'id';
    
    public $timestamps = true;
    
    protected $fillable = [
        'user_id',
        'no_checks_available',
    ];
    
     public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
