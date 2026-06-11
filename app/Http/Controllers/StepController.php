<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Step;
use Illuminate\Support\Facades\Gate;

class StepController extends Controller
{
    public function update(Step $step)
    {
        Gate::authorize('workWith', $step->idea);

        $step->update([
            'completed' => ! $step->completed,
        ]);

        return back();
    }
}
