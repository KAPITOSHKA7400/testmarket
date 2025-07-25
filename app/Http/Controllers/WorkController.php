<?php
namespace App\Http\Controllers;

use App\Models\Work;
use App\Models\WorkView;

class WorkController extends Controller
{
    public function show(Work $work)
    {
        if (auth()->check()) {
            WorkView::firstOrCreate([
                'user_id' => auth()->id(),
                'work_id' => $work->id,
            ]);
        }

        return view('work_detail', compact('work'));
    }

}
