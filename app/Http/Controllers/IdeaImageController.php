<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Idea;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class IdeaImageController extends Controller
{
    public function destroy(Idea $idea)
    {
        Gate::authorize('workWith', $idea);

        if (!empty($idea->image_path) && Storage::disk('public')->exists($idea->image_path)) {
            Storage::disk('public')->delete($idea->image_path);
        }

        $idea->update(['image_path' => null]);

        return back();
    }
}
