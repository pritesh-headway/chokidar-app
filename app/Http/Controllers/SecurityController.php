<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use App\Models\Security;
use App\Models\UserRole;
use App\Models\GateDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class SecurityController extends Controller
{

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'guard_name' => 'required|string|max:50',
            'mobile' => 'required|string|max:20',
            'address' => 'required|string|max:255',
            'gate_no' => 'required|integer',
            'details' => 'required|string',
            'guard_image' => 'required|string|max:256',
            'documents' => 'required|array',
            'status' => 'nullable|in:active,deactive',
        ]);
        $status = $request->get('status', 'deactive');
        $security = Security::create([
            'guard_name' => $request->guard_name,
            'mobile' => $request->mobile,
            'address' => $request->address,
            'gate_no' => $request->gate_no,
            'details' => $request->details,
            'guard_image' => $request->guard_image,
            'documents' => json_encode($request->documents),
            'status' => $status,
        ]);
        return response()->json(['message' => 'Security record created successfully.', 'data' => $security], 201);
    }
    public function show(Request $request)
    {
        $validatedData = $request->validate([
            'id' => 'nullable|exists:securities,id',
            'guard_name' => 'nullable|string',
            'mobile' => 'nullable|string',
            'gate_no' => 'nullable|string',
            'status' => 'nullable|in:active,deactive',
        ]);
        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $query = Security::where('society_id', $loggedInSocietyId);
        if (!empty($validatedData['id'])) {
            $query->where('id', $validatedData['id']);
        }
        if (!empty($validatedData['guard_name'])) {
            $query->where('guard_name', 'like', "%{$validatedData['guard_name']}%");
        }
        if (!empty($validatedData['mobile'])) {
            $query->where('mobile', $validatedData['mobile']);
        }
        if (!empty($validatedData['gate_no'])) {
            $query->where('gate_no', $validatedData['gate_no']);
        }
        if (!empty($validatedData['status'])) {
            $query->where('status', $validatedData['status']);
        }
        $securities = $query->get();
        if ($securities->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'No security guards found.',
                'data' => [],
            ], 404);
        }
        $securityData = $securities->map(function ($security) {
            return [
                'id' => $security->id,
                'guard_name' => $security->guard_name,
                'user_id' => $security->user_id,
                'mobile' => $security->mobile,
                'address' => $security->address,
                'gate_no' => $security->gate_no,
                'details' => $security->details,
                'guard_image' => $this->getFullUrl($security->guard_image),

                'documents' => $this->getFullUrls($security->documents),
                'status' => $security->status,
                'society_id' => $security->society_id,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Security records retrieved successfully.',
            'data' => $securityData,
        ], 200);
    }
    public function update(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id' => 'required|integer|exists:securities,id',
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'mobile' => 'nullable|string|max:20',
            'gate_no' => 'nullable|integer',
            'address' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors(),
            ], 422);
        }
        $security = Security::findOrFail($request->id);
        $user = User::findOrFail($security->user_id);
        $gateDetail = GateDetail::where('security_id', $security->id)->first();
        if ($request->filled('mobile') && $request->mobile !== $user->mobile) {
            $mobileExists = User::where('mobile', $request->mobile)->where('id', '!=', $user->id)->exists();
            if ($mobileExists) {
                return response()->json([
                    'status' => false,
                    'message' => 'Validation errors',
                    'errors' => ['mobile' => ['This mobile number is already registered.']],
                ], 422);
            }
        }
        DB::beginTransaction();
        try {

            $updateData = [];
            if ($request->filled('first_name') || $request->filled('last_name')) {
                $guard_name = trim(($request->first_name ?? $user->first_name) . ' ' . ($request->last_name ?? $user->last_name));
                $updateData['guard_name'] = $guard_name;
            }
            if ($request->filled('gate_no')) {
                $updateData['gate_no'] = $request->gate_no;
            }
            if ($request->filled('address')) {
                $updateData['address'] = $request->address;
            }
            if ($request->filled('mobile')) {
                $updateData['mobile'] = $request->mobile;
            }
            $security->update($updateData);
            $user->update($request->only(['first_name', 'last_name', 'mobile']));
            if ($gateDetail) {
                $gateDetail->update([
                    'gate_no' => $request->gate_no ?? $gateDetail->gate_no,

                ]);
            }

            DB::commit();
            $data = $security;
            $data->gate_mobile = $gateDetail->gate_mobile;

            return response()->json([
                'status' => true,
                'message' => 'Security guard updated successfully',
                'data' => $data,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status' => false,
                'message' => 'Update failed',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function destroy(Request $request)
    {

        $validatedData = $request->validate([
            'id' => 'required|integer|exists:securities,id',
        ]);
        $security = Security::findOrFail($request->id);
        $userId = $security->user_id;
        $securityId = $security->id;
        $security->delete();
        GateDetail::where('security_id', $securityId)->delete();
        UserRole::where('user_id', $userId)->delete();
        User::where('id', $userId)->delete();

        return response()->json(['status' => true, 'message' => 'Security and associated records deleted successfully.']);
    }
    public function index(Request $request)
    {

        $loggedInUser = auth()->user();
        $loggedInSocietyId = $loggedInUser->society_id;
        $securities = Security::where('society_id', $loggedInSocietyId)
            ->get();
        $securitiesWithDetails = $securities->map(function ($security, $index) use ($loggedInSocietyId) {

            $gateDetail = GateDetail::where('society_id', $loggedInSocietyId)
                ->where('gate_no', $security->gate_no)
                ->first();
            $gateMobile = $gateDetail ? $gateDetail->gate_mobile : null;

            return [
                'id' => $security->id,
                'no' => $index + 1,
                'user_id' => $security->user_id,
                'guard_name' => $security->guard_name,
                'personal_mobile' => $security->mobile,
                'address' => $security->address,
                'gate_no' => $security->gate_no,
                'gate_contact_no' => $gateMobile,
                'details' => $security->details,
                'guard_image' => $this->getFullUrl($security->guard_image),
                'documents' => $this->getFullUrls($security->documents),
                'status' => $security->status,
            ];
        });

        return response()->json([
            'status' => true,
            'message' => 'Securities retrieved successfully.',
            'data' => $securitiesWithDetails,
        ]);
    }
    protected function getFullUrls($documents)
    {

        $documentsArray = json_decode($documents, true);
        if (is_array($documentsArray)) {
            return collect($documentsArray)->map(function ($doc) {
                return $this->getFullUrl($doc);
            })->toArray();
        }
        return [];
    }
    protected function getFullUrl($path)
    {

        return config('app.url') . '/public/storage/' . $path;
    }
    public function registerSecurity(Request $request)
    {

        $messages = [
            'first_name.required' => 'First name is required.',
            'last_name.required' => 'Last name is required.',
            'mobile.required' => 'Mobile number is required.',
            'mobile.unique' => 'This mobile number is already registered.',
            'otp.required' => 'OTP is required.',
            'gate_no.required' => 'Gate number is required.',
            'address.required' => 'Address is required.',
            'status.in' => 'Invalid status value.',
            'society_id.exists' => 'Invalid society ID.',
            'role_id.exists' => 'Invalid role ID.',
            'guard_image.required' => 'Guard image is required.',
            'guard_image.image' => 'Guard image must be an image file.',
            'guard_image.mimes' => 'Guard image must be of type jpeg, png, jpg, or gif.',
            'documents.required' => 'Documents are required.',
            'documents.file' => 'Documents must be a valid file.',
            'documents.mimes' => 'Documents must be of type pdf, doc, or docx.',
        ];
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'mobile' => 'required|string|unique:users,mobile',
            'otp' => 'sometimes|string',
            'gate_no' => 'required|string|max:255',
            'address' => 'required|string',
            'status' => 'nullable|in:active,deactive',
            'society_id' => 'nullable|exists:societies,id',
            'role_id' => 'nullable|exists:roles,id',
            'guard_image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'documents' => 'required|array',
            'documents.*' => 'file',
        ], $messages);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation errors',
                'errors' => $validator->errors()
            ], 422);
        }
        $user = auth()->user();
        if ($user->role_id !== Role::where('name', 'admin')->first()->id) {
            return response()->json([
                'status' => false,
                'message' => 'Forbidden. Only an admin can register a security guard.'
            ], 403);
        }
        $securityUser = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'mobile' => (int)$request->mobile,
            'otp' => $request->otp ?? '0096',
            'status' => $request->status ?? 'active',
            'society_id' => $user->society_id,
            'role_id' => $request->role_id ?? Role::where('name', 'security')->first()->id,
        ]);
        $role = Role::where('name', 'security')->first();
        $securityUser->roles()->attach($role);
        $guardImagePath = $this->storeFileInPublicFolder($request->file('guard_image'), 'guard_images');
        $documentPaths = [];
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {

                $fileName = $document->getClientOriginalName();
                $document->move(public_path('storage/guard_documents'), $fileName);
                $documentPaths[] = 'guard_documents/' . $fileName;
            }
        }
        $security = Security::create([
            'user_id' => $securityUser->id,
            'guard_name' => $securityUser->first_name . ' ' . $securityUser->last_name,
            'gate_no' => $request->gate_no,
            'address' => $request->address,
            'mobile' => $securityUser->mobile,
            'guard_image' => $guardImagePath,
            'documents' => json_encode($documentPaths),
            'status' => $request->status ?? 'active',
            'society_id' => $user->society_id,
            'details' => $request->details ?? '',
        ]);
        GateDetail::create([
            'society_id' => $user->society_id,
            'gate_no' => $request->gate_no,
            'security_id' => $security->id,
            'gate_mobile' => $securityUser->mobile,
            'status' => $request->status ?? 'active',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Security guard added successfully',
            'data' => $security
        ], 201);
    }
    protected function storeFileInPublicFolder($file, $folder)
    {

        $filename = time() . '_' . preg_replace("/[^A-Za-z0-9\-_\.]/", '_', $file->getClientOriginalName());
        $filename = str_replace(' ', '_', $filename);

        $file->move(public_path("storage/{$folder}"), $filename);
        return "{$folder}/{$filename}";
    }
}
