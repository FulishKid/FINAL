<?php

namespace App\Services;
use App\Mail\RegistrationMail;
use App\Mail\ResetPasswordMail;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Database\Eloquent;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Resend\Laravel\Facades\Resend;
use Tymon\JWTAuth\Facades\JWTAuth;


class UserService


{
    /**
     * Реєстрація нового користувача.
     *
     * @param array $data
     * @return User
     */
    public function registerUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        $user = User::create($data);
        $user_id = $user->user_id;


        $this->createUserProfile($user_id, $data);

        $user->generateVerificationToken();


        Mail::to($user->email)->send(new RegistrationMail("Thank you for registering with us. Please click on the below link to verify your email address:", url('http://127.0.0.1:8000/verify/' . $user->verification_token)));

    }

    public function verify($verification_token): bool
    {
        $user = User::where('verification_token', $verification_token)->first();

        if ($user && !$user->email_verified_at) {
            $user->email_verified_at = now();
            $user->verification_token = null; // Clear the verification token
            $user->save();
            return true;
        }

        return false;
    }


    /**
     * Генерація та відправлення лінку для скидання паролю.
     *
     * @param string $email
     * @return bool
     */
    public function resetPassword($email)
    {
        $user = User::where('email', $email)->first();
        if (!$user || $user->email_verified_at == null) {
            return false;
        }

        $user->generateVerificationToken();


        Mail::to($user->email)->send(new ResetPasswordMail(url('http://127.0.0.1:8000/api/reset-password/' . $user->verification_token)));
        return true;
    }

    public function passwordResetSubmitService($submitData)
    {
        $user = User::where('verification_token', $submitData->token)->firstOrFail();
        if ($user) {
            $user->password = Hash::make($submitData->password);
            $user->verification_token = null; // Clear the token after use
            $user->save();
            return true;
        }else return false;

    }

    public function createUserProfile($user_id, array $data)
    {

        $profile = Profile::create(['user_id' => $user_id, 'bio' => $data['bio'], 'favorite_genres' => $data['genres']]);

        return (bool)$profile;
    }
}
