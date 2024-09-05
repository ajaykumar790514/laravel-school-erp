<?php

namespace App\Exports;
use App\Models\Students;
use App\Models\Parents;
use App\Models\SessionSetups;
use App\Models\ClassSetups;
use App\Models\Religions;
use App\Models\CastCategorySetups;
use App\Models\Cities;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\Exportable;

class PlayersExport implements FromView
{
    use Exportable;

   
    public function view(): View
    {
         $data = DB::table('players')->select('name', 'cpaton')->distinct()->orderByRaw('RAND()')->take(11)->get();
        return view('backend.exports.player', [
            'data' =>$data
        ]);
    }
}
