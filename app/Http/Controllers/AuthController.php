<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    // Afficher le formulaire d'inscription
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    // Inscription via Blade - CORRIGÉ
    public function registerWeb(Request $request)
    {
        try {
            $data = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|unique:users',
                'password' => 'required|string|min:6|confirmed',
                'role' => 'required|in:mercerie,couturier',
            ]);

            // Avatar par défaut selon le rôle
            $defaultAvatar = $data['role'] === 'mercerie'
                ? 'images/avatars/mercerie.png'
                : 'images/avatars/couturier.png';

            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'role' => $data['role'],
                'avatar' => $defaultAvatar,
            ]);

            // Log pour debug
            Log::info('Utilisateur créé avec succès', ['user_id' => $user->id, 'email' => $user->email]);

            // Dispatch email verification notification
            event(new Registered($user));

            // ✅ CONNEXION AUTOMATIQUE après inscription
            auth()->login($user);
            
            // Régénérer la session pour sécurité
            $request->session()->regenerate();

            Log::info('Utilisateur connecté après inscription', ['user_id' => $user->id]);

            // ✅ Redirection selon le rôle SANS vérification email obligatoire
            if ($user->isMercerie()) {
                return redirect()->route('merchant.supplies.index')
                    ->with('success', 'Inscription réussie ! Bienvenue sur votre espace mercerie.');
            } else {
                return redirect()->route('supplies.selection')
                    ->with('success', 'Inscription réussie ! Bienvenue sur votre espace couturier.');
            }

        } catch (\Exception $e) {
            Log::error('Erreur lors de l\'inscription', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return redirect()->back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Une erreur est survenue lors de l\'inscription. Veuillez réessayer.');
        }
    }

    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Connexion via Blade - CORRIGÉ
    public function loginWeb(Request $request)
    {
        try {
            $credentials = $request->validate([
                'email' => 'required|email',
                'password' => 'required|string',
            ]);

            Log::info('Tentative de connexion', ['email' => $credentials['email']]);

            // ✅ Vérifier si l'utilisateur existe
            $user = User::where('email', $credentials['email'])->first();
            
            if (!$user) {
                Log::warning('Utilisateur introuvable', ['email' => $credentials['email']]);
                return back()->withErrors(['email' => 'Aucun compte trouvé avec cet email.'])->withInput();
            }

            // ✅ Vérifier le mot de passe
            if (!Hash::check($credentials['password'], $user->password)) {
                Log::warning('Mot de passe incorrect', ['email' => $credentials['email']]);
                return back()->withErrors(['email' => 'Email ou mot de passe incorrect.'])->withInput();
            }

            // ✅ Connexion manuelle
            auth()->login($user, $request->filled('remember'));
            $request->session()->regenerate();

            Log::info('Connexion réussie', ['user_id' => $user->id, 'email' => $user->email]);

            // ✅ Gestion de la redirection
            $redirectTo = $request->input('redirect_to');
            
            if (!empty($redirectTo)) {
                // Valider l'URL de redirection
                if (strpos($redirectTo, '/') === 0) {
                    return redirect($redirectTo)->with('success', 'Connexion réussie !');
                }

                $parsed = parse_url($redirectTo);
                if ($parsed && isset($parsed['host'])) {
                    $targetHost = $parsed['host'];
                    $appHost = parse_url(config('app.url'), PHP_URL_HOST);
                    $requestHost = $request->getHost();
                    
                    if ($targetHost === $appHost || $targetHost === $requestHost) {
                        return redirect($redirectTo)->with('success', 'Connexion réussie !');
                    }
                }
            }

            // ✅ Redirection par défaut selon le rôle
            if ($user->isMercerie()) {
                return redirect()->route('merchant.supplies.index')->with('success', 'Connexion réussie !');
            } elseif ($user->isCouturier()) {
                return redirect()->route('supplies.selection')->with('success', 'Connexion réussie !');
            } elseif ($user->isAdmin()) {
                return redirect()->route('admin.supplies.index')->with('success', 'Connexion réussie !');
            }

            return redirect()->route('landing')->with('success', 'Connexion réussie !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la connexion', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->withInput($request->only('email'))
                ->with('error', 'Une erreur est survenue. Veuillez réessayer.');
        }
    }

    // Déconnexion via Blade
    public function logoutWeb(Request $request)
    {
        auth()->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form')->with('success', 'Déconnexion réussie !');
    }

    // Show form to request password reset link
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    // Send reset link email
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
                    ? back()->with(['status' => __($status)])
                    : back()->withErrors(['email' => __($status)]);
    }

    // Show reset form
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Reset password
    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:6',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
                    ? redirect()->route('login.form')->with('success', __($status))
                    : back()->withErrors(['email' => [__($status)]]);
    }

    // Email verification views / actions - OPTIONNEL maintenant
    public function verificationNotice()
    {
        return view('auth.verify');
    }

    public function verify(Request $request, $id, $hash)
    {
        $user = User::find($id);
        if (! $user) {
            abort(404);
        }

        if (! hash_equals((string) $hash, sha1($user->getEmailForVerification()))) {
            abort(403);
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('landing')->with('info', 'Email déjà vérifié.');
        }

        $user->markEmailAsVerified();
        event(new Verified($user));

        return redirect()->route('landing')->with('success', 'Email vérifié avec succès !');
    }

    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->input('email'))->firstOrFail();
        if ($user->hasVerifiedEmail()) {
            return back()->with('info', 'Email déjà vérifié.');
        }

        $user->sendEmailVerificationNotification();
        return back()->with('success', 'Email de vérification renvoyé.');
    }
}