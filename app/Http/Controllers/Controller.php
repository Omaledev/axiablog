<?php

namespace App\Http\Controllers;

abstract class Controller
{
    //
}

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Password;
// use Illuminate\Support\str;

// class AuthController extends Controller
// {
//     // showing the registeration form on the web
//     public function showregister()
//     {
//         return view('auth.register');
//     }

//     // handling registration
//     public function register(Request $request) {

//         // register validation
//         $request->validate([
//          'name' => 'required|string|max: 255',
//          'email' => 'required|email|unique:users,email',
//          'password' => 'required|min:8|confirmed'
//         ]);

//         $user = User::create([
//         'name'=> $request->name,
//         'email' => $request->email,
//         'password' => Hash::make($request->password)
//         ]);

//         Auth::login($user);

//         return redirect()->route('dashboard')->with('success', 'You have successfully logged login!');

//     }

//     // showing the login form on the web
//     public function showlogin()
//     {
//         return view('auth.login');
//     }
//     //    handling login
//     public function login (request $request) {

//         // login validation
//         $request->validate([
//          'email' => 'required|email',
//          'password' => 'required'
//         ]);

//         if(auth::attempt($request->only(['email','password']), $request->remember)) {
//            $request->session()->regenerate();


//            // Get the authenticated user with the created teams
//              $user = Auth::user();

//               // Check if user has owned teams
//              if ($user->createdTeams->count() > 0) {
//             $request->session()->put('current_team', $user->createdTeams->first());
//           }

//            return redirect()->intended('dashboard')
//            ->with('success', 'You have successfully login!');
//         }

//         return back()
//         ->withErrors([
//             'email' => 'Invalid credentials',
//             'password' => 'Invalid credentials'
//         ]);
//     }

//     // handling logout
//     public function logout(request $request) {
//      auth::logout();

//      $request->session()->invalidate();
//      $request->session()->regenerateToken();

//      return redirect()->route('login')
//      ->with('success', 'Logged out successfully');
//     }

// }

// -----------
// <?php
// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Team;
// use App\Models\User;
// use App\Models\Message;
// use Illuminate\Support\Facades\Auth;

// class ChatController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();
//         $teams = $user->teams()->with(['members', 'messages' => function($query) {
//             $query->latest()->limit(50);
//         }])->get();

//         return view('chat.index', [
//             'teams' => $teams,
//             'user' => $user
//         ]);
//     }
// }
// -------------

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\User;
// use Illuminate\Support\Facades\Auth;

// class ContactController extends Controller
// {
//     public function index()
//     {
//         $user = Auth::user();

//         // Get team members from all teams the user belongs to
//         $contacts = User::whereHas('teams', function($query) use ($user) {
//             $query->whereIn('id', $user->teams()->pluck('teams.id'));
//         })
//         ->where('id', '!=', $user->id)
//         ->with(['teams' => function($query) use ($user) {
//             $query->whereIn('id', $user->teams()->pluck('teams.id'));
//         }])
//         ->get();

//         return view('contacts.index', [
//             'contacts' => $contacts
//         ]);
//     }
// }
// -------------

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use App\Models\Team;
// use Illuminate\Support\Str;
// use Illuminate\Support\Facades\DB;
// use Illuminate\Validation\ValidationException;
// use Exception;
// use Illuminate\Support\Facades\Auth;

// class CreateTeamController extends Controller
// {
//     public function createTeam()
//     {
//         return view('teams.create');
//     }


//     public function createTeams(Request $request)
//     {
//         try {
//             $validated = $request->validate([
//                 'name' => 'required|string|max:255|unique:teams,name',
//             ]);

//             $userId = Auth::id();

//             $team = DB::transaction(function () use ($validated, $userId) {
//                 $team = Team::create([
//                     'name' => $validated['name'],
//                     'invite_code' => 'TEAM-' . Str::upper(Str::random(6)),
//                     'created_by' => $userId
//                 ]);

//                 $team->members()->attach($userId, ['role' => 'owner']);
//                 return $team;
//             });

//             return redirect()
//                 ->route('dashboard')
//                 ->with([
//                     'success' => 'Team "'.$team->name.'" created successfully!',
//                     'invite_code' => $team->invite_code,
//                     'current_team' => $team
//             ]);

//         } catch (ValidationException $e) {
//             return back()
//                 ->withErrors($e->errors())
//                 ->withInput();

//         } catch (Exception $e) {
//             return back()
//                 ->with('error', 'Failed to create team: '.$e->getMessage())
//                 ->withInput();
//         }
//     }
// }
// -----------------------

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use App\Models\User;
// use App\Models\Team;
// use Illuminate\Database\Eloquent\Collection;

// class DashboardController extends Controller
// {
//     public function dashboard()
//     {
//         /** @var User $user */ // Type hint for IDE
//         $user = Auth::user();

//         /** @var Collection<Team> $joinedTeams */ // Type hint for collection
//         $joinedTeams = $user->teams()
//             ->with('owner')
//             ->where('created_by', '!=', $user->id)
//             ->get();

//         return view('dashboard', [
//             'user' => $user,
//             'ownedTeams' => $user->createdTeams,
//             'joinedTeams' => $joinedTeams
//         ]);
//     }
// }

// -------------------

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Validation\Rules\Password;

// class ProfileController extends Controller
// {
//     public function show()
//     {
//         $user = Auth::user();
//         return view('profile.show', compact('user'));
//     }
// }
// ----------------

// <?php

// namespace App\Http\Controllers;

// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Validation\Rule;
// use Illuminate\Support\Facades\Hash;

// class SettingsController extends Controller
// {
//     public function edit()
//     {
//         $user = Auth::user();
//         return view('settings.edit', compact('user'));
//     }

//     public function update(Request $request)
//     {
//         $user = Auth::user();

//         $validated = $request->validate([
//             'name' => ['required', 'string', 'max:255'],
//             'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
//             'current_password' => ['nullable', 'required_with:new_password', 'current_password'],
//             'new_password' => ['nullable', 'confirmed', Password::defaults()],
//         ]);

//         $user->name = $validated['name'];
//         $user->email = $validated['email'];

//         if ($request->filled('new_password')) {
//             $user->password = Hash::make($validated['new_password']);
//         }

//         $user->save();

//         return redirect()->route('settings')->with('success', 'Settings updated successfully!');
//     }
// }
// ----------------


// <?php

// namespace App\Mail;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Mail\Mailable;
// use Illuminate\Mail\Mailables\Content;
// use Illuminate\Mail\Mailables\Envelope;
// use Illuminate\Queue\SerializesModels;

// class PasswordResetMail extends Mailable
// {
//     use Queueable, SerializesModels;

//     public $resetUrl;

//     /**
//      * Create a new message instance.
//      */
//     public function __construct($resetUrl)
//     {
//         $this->resetUrl = $resetUrl;
//     }

//     public function build() {
//         return $this->subject('password Reset Request')
//         ->view('email.password-reset');
//     }

//     /**
//      * Get the message envelope.
//      */
//     public function envelope(): Envelope
//     {
//         return new Envelope(
//             subject: 'SwiftNotes Reset Mail',
//         );
//     }

//     /**
//      * Get the message content definition.
//      */
//     public function content(): Content
//     {
//         return new Content(
//             view: 'email.password-reset',
//         );
//     }

//     /**
//      * Get the attachments for the message.
//      *
//      * @return array<int, \Illuminate\Mail\Mailables\Attachment>
//      */
//     public function attachments(): array
//     {
//         return [];
//     }
// }


