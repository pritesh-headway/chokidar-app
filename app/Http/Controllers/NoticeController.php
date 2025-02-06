<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function store(Request $request)
    {

        $user = auth()->user();
        if (!in_array($user->role_id, [1, 2])) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to create notices.',
            ], 403);
        }
        $validated = $request->validate([
            'notice_title' => 'required|string|max:255',
            'notice_desc' => 'required|string',
            'date' => 'sometimes|date',
            'time' => 'sometimes|date_format:H:i:s',
            'documents' => 'nullable',
        ]);
        $currentDate = now()->toDateString();
        $currentTime = now()->format('g:i A');

        $documentPaths = [];
        if ($request->hasFile('documents')) {

            if (is_array($request->file('documents'))) {
                foreach ($request->file('documents') as $document) {

                    $documentPath = $this->storeFileInPublicFolder($document, 'documents');
                    $documentPaths[] = $documentPath;
                }
            } else {

                $documentPath = $this->storeFileInPublicFolder($request->file('documents'), 'notice_documents');
                $documentPaths[] = $documentPath;
            }
        }
        $notice = Notice::create([
            'notice_title' => $request->notice_title,
            'notice_desc' => $request->notice_desc,
            'date' => $request->date ?? $currentDate,
            'time' => $request->time ?? now()->format('H:i:s'),
            'status' => 'active',
            'documents' => json_encode($documentPaths),
            'society_id' => $user->society_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notice created successfully.',
            'data' => $notice
        ], 201);
    }
    public function index(Request $request)
    {

        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $notices = Notice::where('society_id', $loggedInSocietyId)
            ->orderBy('updated_at', 'desc')
            ->get();
        $noticesWithNo = $notices->map(function ($notice, $index) {
            return [
                'no' => $index + 1,
                'id' => $notice->id,
                'notice_title' => $notice->notice_title,
                'notice_desc' => $notice->notice_desc,
                'date' => \Carbon\Carbon::parse($notice->date)->format('d-m-Y'),
                'time' => \Carbon\Carbon::parse($notice->time)->format('g:i A'),
                'status' => $notice->status,
                'documents' => $notice->documents ? array_map(function ($document) {
                    return asset('storage/' . $document);
                }, json_decode($notice->documents)) : [],
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Notices retrieved successfully.',
            'data' => $noticesWithNo
        ]);
    }
    public function show(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|integer|exists:notices,id',
        ]);
        $notice = Notice::findOrFail($request->id);

        return response()->json([
            'status' => true,
            'message' => 'Notice retrieved successfully.',
            'data' => [
                'no' => 1,
                'id' => $notice->id,
                'notice_title' => $notice->notice_title,
                'notice_desc' => $notice->notice_desc,
                'date' => \Carbon\Carbon::parse($notice->date)->format('d-m-Y'),
                'time' => $notice->time,
                'status' => $notice->status,
                'documents' => $notice->documents ? array_map(function ($document) {
                    return asset('storage/' . $document);
                }, json_decode($notice->documents)) : [],
            ]
        ]);
    }
    public function update(Request $request)
    {

        $user = auth()->user();
        if (!in_array($user->role_id, [1, 2])) {
            return response()->json([
                'status' => false,
                'message' => 'You do not have permission to update notices.',
            ], 403);
        }
        $validated = $request->validate([
            'id' => 'required|integer|exists:notices,id',
            'notice_title' => 'nullable|string|max:255',
            'notice_desc' => 'nullable|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i:s',
            'status' => 'nullable|in:active,deactive',
            'documents' => 'nullable',
        ]);
        $notice = Notice::findOrFail($request->id);
        $documentPaths = json_decode($notice->documents, true) ?: [];
        if ($request->hasFile('documents')) {

            if (is_array($request->file('documents'))) {
                foreach ($request->file('documents') as $document) {

                    $documentPath = $this->storeFileInPublicFolder($document, 'documents');
                    $documentPaths[] = $documentPath;
                }
            } else {

                $documentPath = $this->storeFileInPublicFolder($request->file('documents'), 'notice_documents');
                $documentPaths[] = $documentPath;
            }
        }
        $notice->update([
            'notice_title' => $request->notice_title ?? $notice->notice_title,
            'notice_desc' => $request->notice_desc ?? $notice->notice_desc,
            'date' => $request->date ??  \Carbon\Carbon::parse($notice->date)->format('Y-m-d'),
            'time' => $request->time ?? $notice->time,
            'status' => $request->status ?? $notice->status,
            'documents' => json_encode($documentPaths),
            'society_id' => $user->society_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Notice updated successfully.',
            'data' => $notice
        ]);
    }
    public function destroy(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required|integer|exists:notices,id',
        ]);
        $notice = Notice::findOrFail($request->id);
        $notice->delete();

        return response()->json([
            'status' => true,
            'message' => 'Notice deleted successfully.',
            'data' => null
        ]);
    }

    protected function storeFileInPublicFolder($file, $folder)
    {

        $filename = time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);

        $file->move(public_path("storage/{$folder}"), $filename);
        return "{$folder}/{$filename}";
    }
}
