<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\User\ImportUserArrayRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateProfileRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\RoleResource;
use App\Http\Resources\UserResource;
use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Notifications\UserCreatedNotification;
use App\Services\FileHandler\FileHandlerInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use League\Csv\Reader;

class UserController extends ApiController
{
    public function getRoles(Request $request)
    {
        return $this->handleResponseWithCount(RoleResource::collection(Role::all()), Role::count());
    }

    public function getPermissions(Request $request)
    {
        return $this->handleResponseWithCount(RoleResource::collection(Permission::all()), Permission::count());
    }

    public function index(Request $request)
    {
        $filters = $this->getFilters($request);
        $users = User::belongsToAuthenticatedTenant()
            ->notAdmin()
            ->search($filters['search'])
            ->filterByType($request->user_type)
            ->filterByProject($request->project_id)
            ->orderBy($filters['order_by'], $filters['order_type'])
            ->paginate($filters['limit']);

        return $this->handlePaginateResponse(UserResource::collection($users));
    }

    public function show(User $user)
    {
        return $this->handleResponse(new UserResource($user));
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated() + [
            'tenant_id' => $request->user()->tenant_id,
            'password'  => $request->has('password') ? Hash::make($request->password) :'random'
        ]);

        $user->permissions()->attach($request->permissions);
        if ($request->has('assigned_projects')) {
            $user->projects()->attach($request->assigned_projects);
        }
        if ($request->has('invite_message') || !$request->has('password')) {
            $user->notifyUserForInvitation($request->invite_message);
        } else {
            $user->notify(new UserCreatedNotification());
        }
        return $this->handleResponse(new UserResource($user));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update($request->validated() + [
            'password'  => Hash::make($request->password ?? $user->password)
        ]);
        if ($request->has('permissions')) {
            $user->permissions()->sync($request->permissions);
        }
        if ($request->has('assigned_projects')) {
            $user->projects()->sync($request->assigned_projects);
        }
        return $this->handleResponse(new UserResource($user));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->handleResponseMessage('user deleted successfully');
    }

    public function importCsv(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|mimes:csv,txt',
        ]);

        // Handle file upload
        $file = $request->file('file');
        $csv = Reader::createFromPath($file->getRealPath(), 'r');
        $csv->setHeaderOffset(0); // Set the header offset to 0 (CSV has headers)

        $records = $csv->getRecords(); // Get CSV records
        $users =  [];
        foreach ($records as $key => $record) {
            $validator = Validator::make($record, [
                'first_name' => 'required|string',
                'last_name' => 'required|string',
                'email' => 'required|string|email|max:255|unique:users',
                // 'password' => 'required|string|min:6',
                'phone' => 'required|string',
                'company' => 'required|string',
                'position' => 'required|string',
                'role' => 'required|in:subcontractor,builder',
            ]);

            if ($validator->fails()) {
                $errors = [];
                foreach ($validator->errors()->messages() as $errorKey => $message) {
                    $errors['record.'.$key.'.'.$errorKey] = $message;
                }
                throw ValidationException::withMessages($errors);
            }
            $users[] = [
                'first_name' => $record['first_name'],
                'last_name'  => $record['last_name'],
                'email'      => $record['email'],
                'phone'      => $record['phone'],
                'company'    => $record['company'],
                'position'   => $record['position'],
                'role'       => $record['role'],
            ];
        }


        return $this->handleResponseWithCount($users, count($users));
    }

    public function importArray(ImportUserArrayRequest $request)
    {

        foreach ($request->users as $user) {
            $user = User::create([
                'tenant_id' => auth()->user()->tenant_id,
                'first_name' => $user['first_name'],
                'last_name'  => $user['last_name'],
                'email'      => $user['email'],
                'password'   => 'random',
                'company'    => $user['company'],
                'position'   => $user['position'],
                'role_id'    => Role::where('name', $user['role'])->first()->id,
            ]);

            $user->notifyUserForPasswordCreation();
        }

        return $this->handleResponseMessage('Users uploaded successfully.');
    }

    public function getProfile(Request $request)
    {
        return $this->handleResponse(new UserResource($request->user()));
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $request->user()->update($request->validated());

        if($request->has('password')) {
            $request->user()->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return $this->handleResponse(new UserResource($request->user()->fresh()));
    }

    public function updatePassword(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8|confirmed', // The confirmed rule checks if 'new_password' and 'new_password_confirmation' match
        ]);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the current password matches the user's current password
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match our records.'],
            ]);
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->new_password),
        ]);

        return $this->handleResponseMessage('Password updated successfully.');
    }

    /**
     * Export users to a CSV file.
     *
     * @return \Illuminate\Http\Response
     */
    public function exportCsv()
    {
        $users = User::all();
        $csvData = "ID,first_name,last_name,email,phone,company,position,role\n";

        foreach ($users as $user) {
            $csvData .= "{$user->id},{$user->first_name},{$user->last_name},{$user->email},{$user->phone},{$user->company},{$user->position},{$user->role->name}\n";
        }

        $filename = "users_" . date('Ymd_His') . ".csv";
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        return response($csvData, 200, $headers);
    }
}
