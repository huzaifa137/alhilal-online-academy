<?php

namespace App\Http\Controllers;

use App\Models\password_reset_table;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Mail;


class UserController extends Controller
{

    public function createNewPassword($id)
    {
        $generated_id = url('password/reset/' . $id);
        $resetEntry = DB::table('password_reset_tables')->where('token', $generated_id)->first();

        if ($resetEntry) {
            if ($resetEntry->link_status == 0) {
                if (now()->diffInMinutes($resetEntry->created_at) <= 30) {
                    return view('users.reset-password-2', compact(['generated_id']));
                } else {
                    return 'users.login'->with('fail', 'This reset password link has expired');
                }
            } else {
                return redirect()->route('users.login')->with('fail', 'This link has already been used, request for a new link');
            }
        } else {
            return redirect()->route('users.login')->with('fail', 'Invalid Link');
        }
    }

    public function generateForgotPasswordLink(Request $request)
    {
        $email = $request->email;
        $username = DB::table('users')->where('email', $email)->value('username');

        $user = User::where('email', $email)->first();

        if ($user == null) {
            return back()->withInput()->with('fail', 'The email provided is not registered in the system');
        } else {
            $token = Str::random(60);

            $resetUrl = url('password/reset', $token);

            $post = new password_reset_table;

            $post->email = $email;
            $post->token = $resetUrl;
            $post->created_at = now();

            $post->save();

            $data = [
                'email' => $email,
                'username' => $username,
                'resetUrl' => $resetUrl,
                'title' => 'UP O.T.P:Reset Password Link',
            ];

            Mail::send('emails.reset_email', $data, function ($message) use ($data) {
                $message->to($data['email'], $data['email'])->subject($data['title']);
            });

            return back()->with('success', 'Link has been sent to your email : ' . ' ' . $email);
        }
    }

    public function store_new_password(Request $request)
    {
        $request->validate(
            [
                'password' => ['required', 'string', 'min:6', 'regex:/[A-Z]/', 'regex:/[a-z]/', 'regex:/[0-9]/', 'regex:/[@$!%*?&#]/'],
            ],
            [
                'password.required' => 'The password field is required.',
                'password.string' => 'The password must be a string.',
                'password.min' => 'The password must be at least 6 characters.',
                'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
            ],
        );

        $password = $request->password;
        $confirm = $request->confirmPassword;
        $generated_id = $request->generated_id;

        if ($password == $confirm) {
            $record = DB::table('password_reset_tables')->where('token', $generated_id)->first();
            $record_id = $record->id;
            $user_email = $record->email;

            $new_password = Hash::make($password);

            DB::table('users')
                ->where('email', $user_email)
                ->update(['password' => $new_password]);

            $post = password_reset_table::find($record_id);
            $post->link_status = 1;
            $post->save();

            return redirect()->route('users.login')->with('success', 'Password has been updated successfully');
        } else {
            return back()->with('fail', 'Passwords do not match');
        }
    }

    // REMOVED: supplierOtpVerification method - No longer needed

    public function reload_captcha()
    {
        return response()->json(['captcha' => captcha_img('flat')]);
    }

    public function userLogout()
    {

        session()->flush();
        redirect()->route('login');

        return back();
    }

    public function teacherLogout()
    {
        if (session()->has('LoggedTeacher')) {
            session()->forget('LoggedTeacher');
            session()->flush();

            return redirect()->route('login')->with('success', 'You have been logged out successfully');
        }

        return redirect()->route('login');
    }

    public function forgotPassword()
    {
        return view('users.forgot-password');
    }

    public function dashboard()
    {
       
        return view('Admin.dashboard');
    }

    public function checkUser(Request $request)
    {
        $request->validate([
            'login' => ['required', 'string'],
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/[a-z]/',
                'regex:/[A-Z]/',
                'regex:/\d/',
                'regex:/[\W_]/',
            ],
        ]);

        $loginField = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $userInfo = User::where($loginField, '=', $request->login)->first();

        if (!$userInfo) {
            return response()->json([
                'status' => false,
                'message' => 'We don\'t recognise the provided username or password',
            ]);
        } else {
            if (Hash::check($request->password, $userInfo->password)) {

                $userId = $userInfo->id;
                $userRole = $userInfo->user_role;

                // Set session based on role
                if ($userRole == 2) {
                    $request->session()->put('LoggedTeacher', $userId);
                } elseif ($userRole == 3) {
                    $request->session()->put('LoggedAdmin', $userId);
                } else {
                    $request->session()->put('LoggedStudent', $userId);
                }

                // Update registration status to active
                DB::table('users')
                    ->where('id', $userId)
                    ->update(['registration_status' => 1]);

                // Redirect based on role
                if ($userRole == 2) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login successful',
                        'redirect_url' => '/teacher/dashboard',
                    ]);
                } elseif ($userRole == 3) {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login successful',
                        'redirect_url' => '/users/dashboard',
                    ]);
                } else {
                    return response()->json([
                        'status' => true,
                        'message' => 'Login successful',
                        'redirect_url' => '/student/dashboard',
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Invalid password or username/email being entered',
                ]);
            }
        }
    }

    public function homePage()
    {
        return view('home-page');
    }

    public function editUserInformation()
    {

        $info = DB::table('users')->where('id', Session('LoggedAdmin'))->first();

        return view('users.edit-user-information', compact(['info']));
    }

    public function editSpecificUser($userId)
    {

        $info = DB::table('users')->where('id', $userId)->first();

        return view('users.edit-user-information', compact(['info']));
    }

    public function userInformation(Request $request)
    {
        $users = User::all();
        $mc_code = DB::table('master_datas')
            ->join('master_codes', 'md_master_code_id', '=', 'master_codes.id')
            ->get();

        if ($request->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', function ($user) {
                    $links = [];
                    $links[] = '<a class="dropdown-item" href="user-account-information/' . $user->id . '"><i class="fa fa-fw fa-eye"></i> View</a>';
                    $links[] = '<a class="dropdown-item" href="/users/edit-specific-user/' . $user->id . '"><i class="fa fa-fw fa-edit"></i> Edit</a>';
                    $links[] = '<a onclick="return confirm(\'Are you sure you want to delete ' . $user->firstname . ' ' . $user->lastname . '?\'); " class="dropdown-item" href="delete-user/' . $user->id . '"><i class="fa fa-fw fa-times"></i> Delete</a>';

                    return '<div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton' . $user->id . '" data-bs-toggle="dropdown" aria-expanded="false">
                                Actions
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton' . $user->id . '">
                                ' . implode('', $links) . '
                            </ul>
                        </div>';
                })
                ->make(true);
        }

        return view('users.user-information', [
            'mc_code' => $mc_code,
            'users' => $users,
            'LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first(),
        ]);
    }

    public function userAccountInformation($id)
    {

        $next = DB::table('users')->where('id', '>', $id)->orderBy('id', 'ASC')->value('id');
        $prev = DB::table('users')->where('id', '<', $id)->orderBy('id', 'DESC')->value('id');

        $user_profile_data = DB::table('users')->where('id', $id)->first();

        $data = ['LoggedUserAdmin' => User::where('id', '=', session('LoggedAdmin'))->first()];

        return view('users.user-account-information', $data, compact(['user_profile_data']))
            ->with('next', $next)
            ->with('prev', $prev);
    }

    public function storeUpdatedInformation(Request $request)
    {

        $id = $request->hidden_id;

        $reference = DB::table('users')->where('id', $id)->value('user_reference');

        $request->validate([

            'email' => 'nullable|email',
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required',
            'gender' => 'required',
            'user_role' => 'required',
            'phonenumber' => 'required',
            'title' => 'required',
        ]);

        $role_name = $request->user_role;

        $userRoleId = DB::table('user_roles')->where('user_name', $role_name)->value('user_id');

        $email = $request->email;
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $username = $request->username;
        $gender = $request->gender;
        $user_role = $request->user_role;
        $phonenumber = $request->phonenumber;
        $account_status = $request->account_status;
        $title = $request->title;
        $user_title = $request->user_title;

        $user_supervisior = $request->user_supervisor;
        $passport = $request->passport;
        $country = $request->country;
        $password = $request->password;

        $all_emails = DB::table('users')->pluck('email');
        $all_username = DB::table('users')->pluck('username');

        // Only check email uniqueness if email is provided
        if ($email) {
            foreach ($all_emails as $specific_email) {
                if ($email == $specific_email) {
                    $user_id = DB::table('users')->where('email', $email)->value('id');
                    if ($user_id != $id) {
                        return back()->with('fail', 'The provided Email id is already registered to another user');
                    }
                }
            }
        }

        foreach ($all_username as $specific_username) {

            if ($username == $specific_username) {

                $user_id = DB::table('users')->where('username', $username)->value('id');

                if ($user_id != $id) {
                    return back()->with('fail', 'The provided username is already registered to another user');
                }
            }
        }

        DB::table('users')->where('id', $id)
            ->update([
                'email' => $email,
                'firstname' => $firstname,
                'lastname' => $lastname,
                'username' => $username,
                'gender' => $gender,
                'user_role' => $user_role,
                'phonenumber' => $phonenumber,
                'account_status' => $account_status,
                'user_id' => $userRoleId,
                'Title' => $title,
                'user_supervisor' => $user_supervisior,
                'user_title' => $user_title,
                'passport_number' => $passport,
                'country' => $country,
            ]);

        $units = $request->requisitionunits;

        $currentTimestamp = time();
        $twoYearsFromNow = strtotime('+2 years', $currentTimestamp);

        return back()->with('success', 'User Information has been updated successfully');
    }

    public function deleteUser($id)
    {
        $data = User::find($id);

        $data->delete();

        return back()->with('success', 'user ' . $data->username . ' has been deleted successfully');
    }

    public function userAccountCreation(Request $request)
    {
        $request->validate([
            'fullname' => 'required|string|min:3|max:255',
            'username' => 'required|string|min:3|max:255|unique:users,username|regex:/^[a-zA-Z0-9_]+$/',
            'email' => 'nullable|email|unique:users,email',
            'phone' => 'required|string|regex:/^[\+]?[0-9\s\-\(\)]{10,20}$/',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&]/',
            ],
            'role' => 'nullable|integer|in:1,2,3',
            'terms' => 'accepted',
        ], [
            'fullname.required' => 'Full Name is required.',
            'fullname.min' => 'Full Name must be at least 3 characters.',
            'username.required' => 'Username is required for login.',
            'username.unique' => 'This username is already taken. Please choose another.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'email.email' => 'Please enter a valid email address or leave it blank.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required for account recovery.',
            'phone.regex' => 'Please enter a valid phone number (e.g., +256 700 123456 or 0700123456).',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'password.regex' => 'Password must include at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&).',
            'terms.accepted' => 'You must agree to the terms and policies.',
        ]);

        try {
            DB::beginTransaction();

            $nameParts = explode(' ', trim($request->fullname), 2);
            $firstname = $nameParts[0];
            $lastname = $nameParts[1] ?? '';

            $userRole = $request->role ?? 1;

            $user = new User();
            $user->firstname = $firstname;
            $user->lastname = $lastname;
            $user->username = $request->username;
            $user->email = $request->email;
            $user->phonenumber = $request->phone;
            $user->password = Hash::make($request->password);
            $user->registration_status = 1;
            $user->user_role = $userRole;
            $user->account_status = 10;

            $user->save();

            $user->reg_number = $this->generateRegistrationNumber($user->id, $userRole);
            $user->save();

            DB::commit();

            if (!empty($user->email)) {
                try {

                    $roleNames = [
                        1 => 'Student',
                        2 => 'Teacher',
                        3 => 'Admin'
                    ];

                    $data = [
                        'subject' => 'Welcome to Al-Hilal Online Academy! 🎓',
                        'username' => (string) $user->username,
                        'email' => (string) $user->email,
                        'firstname' => (string) $firstname,
                        'lastname' => (string) $lastname,
                        'phone' => (string) $user->phonenumber,
                        'reg_number' => (string) ($user->reg_number ?? ''),
                        'role_name' => (string) ($roleNames[$userRole] ?? 'Student'),
                        'welcome_text' => 'Your account has been created successfully! We\'re excited to have you join our learning community.',
                    ];

                    Mail::send('emails.user-account-created', $data, function ($message) use ($user) {
                        $message->to($user->email)
                            ->subject('Welcome to Al-Hilal Online Academy! 🎓');
                    });

                } catch (\Exception $e) {
                    \Log::error('Welcome email failed: ' . $e->getMessage());
                    \Log::error('Email error trace: ' . $e->getTraceAsString());
                }
            }

            session()->put('LoggedStudent', $user->id);

            return response()->json([
                'status' => true,
                'message' => 'Registration successful! Welcome to Al-Hilal Online Academy.',
                'redirect_url' => '/student/dashboard',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();

            \Log::error('User registration failed: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Registration failed. Please try again.',
            ], 500);
        }
    }

    private function generateRegistrationNumber($userId, $role)
    {
        $prefix = '';

        switch ($role) {
            case 1: // Student
                $prefix = 'STU';
                break;
            case 2: // Admin
                $prefix = 'ADM';
                break;
            case 3: // Teacher
                $prefix = 'TCH';
                break;
            default:
                $prefix = 'USR';
        }

        return $prefix . '-' . date('Y') . '-' . str_pad($userId, 4, '0', STR_PAD_LEFT);
    }

    public function editRecord($md_id)
    {

        $data = ['LoggedUserAdmin' => Admin::where('id', '=', session('LoggedAdmin'))->first()];

        $tb_record = DB::table('master_datas')
            ->where('md_id', $md_id)
            ->get();

        $md_master_code_id = DB::table('master_datas')->where('md_id', $md_id)->pluck('md_master_code_id');
        $md_master_code_id = $md_master_code_id[0];

        $selected = DB::select('select id, mc_name from master_codes');

        if (is_numeric($md_master_code_id)) {

            $master_code_name = DB::table('master_codes')->where('id', $md_master_code_id)->pluck('mc_name');
            $master_code_id = DB::table('master_codes')->where('id', $md_master_code_id)->pluck('mc_id');

            if (isset($master_code_name[0])) {

                $master_code_name = $master_code_name[0];
                $master_code_id = $master_code_id[0];

                return view('master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));
            } else {
                $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
                $master_code_id = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

                $master_code_name = $master_code_name[0];
                $master_code_id = $master_code_id[0];

                return view('master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));

            }
        } else {
            $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
            $master_code_id = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

            $master_code_name = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_name');
            $master_code_id = DB::table('master_codes')->where('mc_id', $md_master_code_id)->pluck('mc_id');

            $master_code_name = $master_code_name[0];
            $master_code_id = $master_code_id[0];

            return view('master-logic.master-logic.edit-record', $data, compact(['tb_record', 'selected', 'master_code_name', 'master_code_id', 'md_id']));

        }
    }

    public function storeInternalUser(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'nullable|email|unique:users',
            'password' => [
                'required',
                'string',
                'min:6',
                'regex:/[A-Z]/',
                'regex:/[a-z]/',
                'regex:/[0-9]/',
                'regex:/[@$!%*?&#]/',
            ],
        ], [
            'password.required' => 'The password field is required.',
            'password.string' => 'The password must be a string.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
        ]);

        $user = new User;

        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->registration_status = 1; // Active immediately
        $save = $user->save();

        $data = [
            'email' => $request->email,
            'username' => $request->username,
            'password' => $request->password,
            'title' => 'Al-Hilal Online Academy - User Account has been created successfully.',
        ];

        return back()->with('success', 'User account has been created successfully');
    }

    public function storeUpdatedInternalUser(Request $request)
    {

        $request->validate([
            'username' => 'required',
            'email' => 'nullable|email',
        ]);

        if ($request->password != null && $request->confirmPassword != null) {
            $request->validate(
                [
                    'password' => [
                        'required',
                        'string',
                        'min:6',
                        'regex:/[A-Z]/',
                        'regex:/[a-z]/',
                        'regex:/[0-9]/',
                        'regex:/[@$!%*?&#]/',
                    ],
                ],
                [
                    'password.required' => 'The password field is required.',
                    'password.string' => 'The password must be a string.',
                    'password.min' => 'The password must be at least 6 characters.',
                    'password.regex' => 'The password must include at least one uppercase letter, one lowercase letter, one digit, and one special character.',
                ]
            );
        }

        $password = trim($request->password);

        if ($request->password != null) {

            User::updateOrCreate(
                ['id' => $request->user_id],
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'password' => Hash::make($password),
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'gender' => $request->gender,
                    'phonenumber' => $request->phonenumber,
                    'country' => $request->country,
                ]
            );

            return back()->with('success', 'User account has been updated successfully');

        } else {

            User::updateOrCreate(
                ['id' => $request->user_id],
                [
                    'username' => $request->username,
                    'email' => $request->email,
                    'firstname' => $request->firstname,
                    'lastname' => $request->lastname,
                    'gender' => $request->gender,
                    'phonenumber' => $request->phonenumber,
                    'country' => $request->country,
                ]
            );

            return back()->with('success', 'User account has been updated successfully');
        }

    }


    public function userProfile()
    {
        $loggedInUser = Helper::getLoggedInUser();

        if (!$loggedInUser) {
            return redirect('/users/home-page')
                ->with('fail', 'You must be logged in');
        }

        $user = DB::table('users')
            ->where('id', $loggedInUser['id'])
            ->first();

        return view('users.user-profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $loggedInUser = session()->get('LoggedStudent');

        if (!$loggedInUser) {
            return response()->json([
                'status' => false,
                'message' => 'Session expired. Please login again.'
            ], 401);
        }

        $user = DB::table('users')->where('id', $loggedInUser)->first();

        if (!$user) {
            return response()->json([
                'status' => false,
                'message' => 'User not found.'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|min:2|max:255',
            'lastname' => 'required|string|min:2|max:255',
            'username' => [
                'required',
                'string',
                'min:3',
                'max:255',
                'regex:/^[a-zA-Z0-9_]+$/',
                Rule::unique('users')->ignore($user->id)
            ],
            'email' => 'nullable|email|unique:users,email,' . $user->id,
            'phonenumber' => 'required|string|regex:/^[\+]?[0-9\s\-\(\)]{10,20}$/',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed|regex:/[A-Z]/|regex:/[a-z]/|regex:/[0-9]/|regex:/[@$!%*?&]/',
            'new_password_confirmation' => 'nullable'
        ], [
            'firstname.required' => 'First name is required.',
            'lastname.required' => 'Last name is required.',
            'username.required' => 'Username is required.',
            'username.unique' => 'This username is already taken.',
            'username.regex' => 'Username can only contain letters, numbers, and underscores.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phonenumber.required' => 'Phone number is required.',
            'phonenumber.regex' => 'Please enter a valid phone number.',
            'current_password.required_with' => 'Current password is required to change password.',
            'new_password.min' => 'New password must be at least 8 characters.',
            'new_password.confirmed' => 'Password confirmation does not match.',
            'new_password.regex' => 'Password must include uppercase, lowercase, number, and special character.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Verify current password if changing password
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json([
                    'status' => false,
                    'errors' => ['current_password' => ['Current password is incorrect.']]
                ], 422);
            }
        }

        try {
            DB::beginTransaction();

            $updateData = [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'email' => $request->email,
                'phonenumber' => $request->phonenumber,
                'updated_at' => now()
            ];

            if ($request->filled('new_password')) {
                $updateData['password'] = Hash::make($request->new_password);
            }

            DB::table('users')->where('id', $user->id)->update($updateData);

            DB::commit();

            return response()->json([
                'status' => true,
                'message' => 'Profile updated successfully!',
                'user' => (object) array_merge((array) $user, $updateData)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Profile update failed: ' . $e->getMessage());

            return response()->json([
                'status' => false,
                'message' => 'Failed to update profile. Please try again.'
            ], 500);
        }
    }

    private function getUserStats($userId)
    {
        $stats = [
            'total_lessons_completed' => 2,
            'total_quizzes_passed' => 3,
            'certificates_earned' => 3,
            'current_level' => 4,
            'join_date' => 25 - 12 - 22025,
        ];

        return $stats;
    }
}
