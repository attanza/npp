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

class DreamController extends Controller
{
    public function storeDream(DreamUpdateRequest $request, $id)
    {
        // return $request->all();
        $dream = Dream::where('user_id', $id)->first();
        $dream->dream = $request->dream;
        $dream->keyword = $request->keyword;
        $dream->description = clean($request->description);
        $dream->save();

        $user = User::with('dream')->find($id);
        // Send Email;
        Mail::to($user)->send(new CreateDreamMail($user));

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
        $dreams = Dream::with('user')->whereHas('medias')
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
}
