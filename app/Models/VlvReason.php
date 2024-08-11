<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class VlvReason extends Model
{
    use HasFactory;
    protected $table = 'vlv_reason';

    public function api_reason(Request $request){
        $s = $request->s;
        $q = str_replace(' ','%',"%{$request->q}").'%';
        $result = VlvReason::select(
                                'subreason_id as id',
                                'motivo as text'
                            )
                            ->where('motivo','LIKE',$q)
                            ->orderBy('motivo')
                            ->limit(env('RESULT_SELECT2',30))
                            ->get();
        return response()->json(['results' => $result]);
    }
}
