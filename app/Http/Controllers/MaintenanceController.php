<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use App\Models\User;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class MaintenanceController extends Controller
{
    /* */
    public function index(Request $request)
    {

        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $isAdmin = $loggedInUser->role_id === 2;
        if (!$isAdmin) {
            $userMaintenance = Maintenance::with('user:id,first_name,last_name,society_id,block_number,mobile')
                ->where('user_id', $loggedInUser->id)
                ->orderBy('id', 'desc')
                ->get();
            if ($userMaintenance->isEmpty()) {
                return response()->json([
                    'status' => true,
                    'message' => 'No maintenance records found.',
                    'data' => [
                        'maintenance_status' => 'No Maintenance'
                    ],
                ], 200);
            }
            $allApproved = $userMaintenance->every(function ($maintenance) {
                return $maintenance->maintenance_status === 'Approved';
            });

            $maintenanceStatus = $allApproved ? 'All Maintenance Approved' : 'Some Maintenance Pending';

            return response()->json([
                'status' => true,
                'message' => 'Maintenance records fetched successfully',
                'data' => [
                    'maintenance_status' => $maintenanceStatus,
                    'maintenance_records' => $userMaintenance->map(function ($maintenanceRecord) {
                        return [
                            'no' => $maintenanceRecord->id,
                            'id' => $maintenanceRecord->id,
                            'amount' => $maintenanceRecord->amount,
                            'date' => $maintenanceRecord->date,
                            'maintenance_status' => $maintenanceRecord->maintenance_status,
                        ];
                    }),
                ],
            ], 200);
        }
        $activeUsers = User::where('society_id', $loggedInSocietyId)
            ->whereIn('role_id', [3, 4])
            ->where('status', 'active')
            ->select('id', 'first_name', 'last_name', 'block_number', 'mobile', 'profile_photo')
            ->get();
        $maintenanceRecords = Maintenance::with('user:id,first_name,last_name,society_id,block_number,mobile,profile_photo')
            ->whereHas('user', function ($query) use ($loggedInSocietyId) {
                $query->where('society_id', $loggedInSocietyId);
            })
            ->orderBy('id', 'desc')
            ->get();
        $groupedData = $activeUsers->groupBy('block_number')->map(function ($users, $block) use ($maintenanceRecords) {

            $blockMaintenance = $maintenanceRecords->where('block_number', $block);

            $rows = $users->map(function ($user) use ($blockMaintenance) {

                $userMaintenance = $blockMaintenance->where('user_id', $user->id);
                if ($userMaintenance->isEmpty()) {
                    return [
                        'user_id' => $user->id,
                        'blockNumber' => $user->block_number,
                        'image' => $user->profile_photo ? url('storage/' . $user->profile_photo) : null,
                        'ownerName' => $user->first_name . ' ' . $user->last_name,
                        'maintenance_status' => 'No Maintenance',
                        'society_id' => $user->society_id,
                        'maintenance' => [],
                    ];
                }
                $allApproved = $userMaintenance->every(function ($maintenance) {
                    return $maintenance->maintenance_status === 'Approved';
                });

                $maintenanceStatus = $allApproved ? 'All Maintenance Approved' : 'Some Maintenance Pending';
                $maintenance = $userMaintenance->map(function ($maintenanceRecord) {
                    return [
                        'no' => $maintenanceRecord->id,
                        'id' => $maintenanceRecord->id,
                        'amount' => $maintenanceRecord->amount,
                        'date' => $maintenanceRecord->date,
                        'maintenance_status' => $maintenanceRecord->maintenance_status,
                    ];
                });

                return [
                    'user_id' => $user->id,
                    'blockNumber' => $user->block_number,
                    'image' => $user->profile_photo ? url('storage/' . $user->profile_photo) : null,
                    'ownerName' => $user->first_name . ' ' . $user->last_name,
                    'maintenance_status' => $maintenanceStatus,
                    'society_id' => $user->society_id,
                    'maintenance' => $maintenance,
                ];
            });

            return [
                'title' => substr($block, 0, 1),
                'rows' => $rows->values(),
            ];
        });
        $finalGroupedData = $groupedData->values()->groupBy('title')->map(function ($items) {
            return [
                'title' => $items->first()['title'],
                'rows' => $items->flatMap(function ($item) {
                    return $item['rows'];
                })->values(),
            ];
        });
        $finalGroupedData = $finalGroupedData->sortBy(function ($item) {
            return $item['title'];
        })->values();
        return response()->json([
            'status' => true,
            'message' => 'Maintenance records fetched successfully',
            'data' => $finalGroupedData->values(),
        ], 200);
    }
    /**
     * Helper method to format maintenance records
     */
    private function formatMaintenanceRecords($records)
    {

        $groupedRecords = $records->groupBy(function ($record) {
            return strtoupper(substr($record->block_number, 0, 1));
        });
        return $groupedRecords->map(function ($records, $blockLetter) {
            return [
                'title' => "Block-" . $blockLetter,
                'rows' => $records->values()->map(function ($record, $index) {
                    $date = \Carbon\Carbon::parse($record->date);
                    return [
                        'no' => $index + 1,
                        'id' => $record->id,
                        'user_id' => $record->user_id,
                        'blockNumber' => $record->block_number,
                        'image' => config('app.url') . '/public/storage/' . $record->photo,
                        'ownerName' => $record->owner_name,
                        'maintenance_status' => $record->maintenance_status,
                        'society_id' => $record->user->society_id,
                    ];
                })->toArray(),
            ];
        })->sortBy('title')->values()->toArray();
    }
    public function show(Request $request)
    {

        $id = $request->input('id');
        $userId = $request->input('user_id');
        if (!$id && !$userId) {
            return response()->json([
                'status' => false,
                'message' => 'Please provide either an ID or user_id to fetch records.',
                'data' => []
            ], 200);
        }
        $maintenanceQuery = Maintenance::with('user:id,society_id');
        if ($userId) {
            $maintenanceQuery->where('user_id', $userId);
        }
        if ($id) {
            $maintenanceQuery->where('id', $id);
        }
        $maintenanceRecords = $maintenanceQuery->orderBy('date', 'desc')->get();
        if ($maintenanceRecords->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No maintenance records found for the specified criteria.',
                'data' => []
            ], 200);
        }
        $groupedRecords = $maintenanceRecords->groupBy('block_number');
        $response = $groupedRecords->map(function ($records, $blockNumber) {
            return $records->values()->map(function ($record, $index) {
                $date = \Carbon\Carbon::parse($record->date);
                return [
                    'no' => $index + 1,
                    'id' => $record->id,
                    'user_id' => $record->user_id,
                    'blockNumber' => $record->block_number,
                    'image' => config('app.url') . '/public/storage/' . $record->photo,
                    'ownerName' => $record->owner_name,
                    'amount' => (string)$record->amount,
                    'maintenance_status' => $record->maintenance_status,
                    'date' => \Carbon\Carbon::parse($date)->format('d-m-Y'),
                    'description' => $record->description,
                    'status' => ucfirst(strtolower($record->maintenance_status)),
                    'society_id' => $record->user->society_id,
                ];
            });
        });
        return response()->json([
            'status' => true,
            'message' => 'Maintenance records fetched successfully',
            'data' => $response->flatten(1)->toArray()
        ], 200);
    }
    public function store(Request $request)
    {

        $missingArguments = [];
        $requiredFields = ['user_id', 'amount', 'date', 'description'];
        foreach ($requiredFields as $field) {
            if (!$request->has($field)) {
                $missingArguments[] = $field;
            }
        }
        if (!empty($missingArguments)) {
            return response()->json([
                'status' => false,
                'message' => 'Missing required arguments',
                'missing_arguments' => $missingArguments
            ], 200);
        }
        $validated = $request->validate([
            'block_number' => 'nullable|string|max:50',
            'maintenance_status' => 'nullable|in:PENDING,COMPLETED',
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|integer',
            'date' => 'required|date',
            'description' => 'required|string',
            'status' => 'nullable|in:active,deactive',
            'photo' => 'nullable|string|max:2048',
        ]);
        $user = User::find($validated['user_id']);
        if (!$user) {
            return response()->json(['status' => false, 'message' => 'User not found'], 200);
        }
        $maintenanceStatus = $validated['maintenance_status'] ?? 'PENDING';
        $maintenance = new Maintenance();
        $maintenance->user_id = $validated['user_id'];
        $maintenance->block_number = $user->block_number;
        $maintenance->owner_name = $user->first_name . ' ' . $user->last_name;
        $maintenance->block = substr($user->block_number, 0, 1);
        $maintenance->amount = $validated['amount'];
        $maintenance->date = $validated['date'];
        $maintenance->description = $validated['description'];
        $maintenance->maintenance_status = $maintenanceStatus;
        $maintenance->status = $validated['status'] ?? 'active';
        $maintenance->photo = $validated['photo'] ?? "profile_photos/avatar.png";
        $maintenance->save();
        $maintenance->society_id = auth()->user()->society_id;
        return response()->json([
            'status' => true,
            'message' => 'Maintenance record created successfully',
            'data' => $maintenance
        ], 201);
    }
    public function update(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'ID is required',
                'data' => []
            ], 200);
        }

        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json([
                'status' => false,
                'message' => 'Maintenance record not found',
                'data' => []
            ], 200);
        }

        $validatedData = $request->validate([
            'block_number' => 'nullable|string|max:50',
            'maintenance_status' => 'nullable|in:PENDING,COMPLETED',
            'block' => 'nullable|string|max:50',
            'photo' => 'nullable|string|max:256',
            'user_id' => 'nullable|exists:users,id',
            'amount' => 'nullable|integer',
            'date' => 'nullable|date',
            'description' => 'nullable|string',
            'status' => 'nullable|in:active,deactive',
        ]);
        if (isset($validatedData['user_id'])) {
            $user = User::findOrFail($validatedData['user_id']);
            $validatedData['owner_name'] = $user->first_name . ' ' . $user->last_name;
        }

        $maintenance->update($validatedData);
        $maintenance->society_id = auth()->user()->society_id;

        return response()->json([
            'status' => true,
            'message' => 'Maintenance record updated successfully',
            'data' => $maintenance
        ], 200);
    }
    public function destroy(Request $request)
    {
        $id = $request->input('id');
        if (!$id) {
            return response()->json([
                'status' => false,
                'message' => 'ID is required',
                'data' => []
            ], 200);
        }

        $maintenance = Maintenance::find($id);
        if (!$maintenance) {
            return response()->json([
                'status' => false,
                'message' => 'Maintenance record not found',
                'data' => []
            ], 200);
        }

        $maintenance->delete();

        return response()->json([
            'status' => true,
            'message' => 'Maintenance record deleted successfully',
            'data' => []
        ], 200);
    }

    protected function storeFileInPublicFolder($file, $folder)
    {

        $filename = time() . '_' . $file->getClientOriginalName();
        $filename = str_replace(' ', '_', $filename);

        $file->move(public_path("storage/{$folder}"), $filename);
        return "{$folder}/{$filename}";
    }
}
