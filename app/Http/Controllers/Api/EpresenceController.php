<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Epresence\StoreEpresence;
use App\Models\Epresence;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EpresenceController extends Controller
{
    public function index()
    {
        try {
            $user = Auth::user();
            $epresence = Epresence::where('id_users', $user->id)->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Data presence successfully fetched',
                'data' => $epresence
            ]);
        } catch (Exception $e) {
            Log::error('Epresence.index', ['error' => $e, 'request' => null]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while fetching presence data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(StoreEpresence $request)
    {
        try {
            /** @var App\Model\User */
            $user = Auth::user();

            $epresence = $user->epresence()->create([
                'type' => $request->type,
                'is_approve' => false,
                'waktu' => now()
            ]);

            return response()->json([
                'status' => 'success',
                'message' => 'Presence data inserted',
                'data' => $epresence
            ], 201);
        } catch (Exception $e) {
            Log::error('Epresence.store', ['error' => $e, 'request' => $request->all()]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while inserting presence data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function approve($id)
    {
        try {
            /** @var App\Model\User */
            $supervisor = Auth::user();

            if ($supervisor->npp_supervisor) {
                return response()->json(['message' => 'Unauthorized. You are not a supervisor'], 403);
            }

            $epresence = Epresence::find($id);

            if (!$epresence) {
                return response()->json(['message' => 'Presence data not found'], 404);
            }

            $userPresent = User::find($epresence->id_users);

            if ($userPresent->npp_supervisor != $supervisor->npp) {
                return response()->json([
                    'message' => 'Unauthorized. You are not the supervisor of this user'
                ], 403);
            }

            $epresence->update([
                'is_approve' => true
            ]);

            return response()->json(['message' => 'Presence data approved']);
        } catch (Exception $e) {
            Log::error('Epresence.approve', ['error' => $e, 'request' => ['id' => $id]]);

            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while approving presence data',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
