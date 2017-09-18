<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Dream;
use App\Http\Requests\DreamUpdateRequest;
use Purifier;
use Mail;
use App\Mail\CreateDreamMail;
use App\Jobs\UploadDreamJob;
use Auth;
use Carbon\Carbon;

class DreamController extends Controller
{
    public function storeDream(DreamUpdateRequest $request, $userId)
    {
        $dream = Dream::where('user_id', $userId)->first();
        if (count($dream) == 0) {
            return response()->json([
                'msg' => 'Mimpi tidak ditemukan'
            ], 422);
        }
        if (Auth::id() != $userId) {
            return response()->json([
                'msg' => 'Operasi tidak diizinkan'
            ], 403);
        }
        $dream_title = $request->dream;
        $dream->dream = $dream_title;
        $dream->slug = str_slug(str_limit($dream_title, 50).'-'.Auth::user()->username);
        $dream->keyword = $request->keyword;
        $dream->description = clean($request->description);
        $dream->save();

        $user = User::with('dream')->find($userId);
        // Send Email;
        $when = Carbon::now()->addMinutes(5);
        Mail::to($user)->queue(new CreateDreamMail($user));
        return response()->json([
            'dream' => $dream
        ], 200);
    }

    public function uploadDreamPhoto(Request $request, $id)
    {
        $this->validate($request, [
          'file' => 'required|string'
        ]);

        $dream = Dream::find($id);

        dispatch(new UploadDreamJob($dream, $request->file));
        return response()->json(1, 200);
    }

    public function dreamList(Request $request)
    {
        $this->validate($request, [
          'paginate' => 'required|integer',
        ]);
        $dreams = Dream::with('user')
            // ->whereHas('medias')
            ->where('dream', '<>', '')
            ->orderBy('id', 'desc')
            ->paginate($request->paginate);
        $response = [
            'pagination' => [
                'total' => $dreams->total(),
                'per_page' => $dreams->perPage(),
                'current_page' => $dreams->currentPage(),
                'last_page' => $dreams->lastPage(),
                'from' => $dreams->firstItem(),
                'to' => $dreams->lastItem()
            ],
            'dreams' => $dreams
        ];

        if ($request->ajax()) {
            return response()->json($response, 200);
        }
    }

    public function dreamShow($slug)
    {
        $dream = Dream::with('user')
        ->where('slug', $slug)->first();
        if (count($dream) == 0) {
            return redirect()->route('bmi.index')->withError('Mimpi tidak ditemukan');
        }

        return view('dream.show')->withDream($dream);
    }

    public function dreamRedirector($slug, $id)
    {
        $dream = Dream::where('slug', $slug)->first();
        return view('dream.redirector')->with([
          'dream' => $dream,
          'commentId' => $id
        ]);
    }

    public function dreamCount(Request $request)
    {
        if ($request->ajax()) {
            $dreams = Dream::where('dream', '<>', '')->count();
            return response()->json([
              'dream_count' => $dreams
            ], 200);
        } else {
            return redirect('/');
        }
    }
}
