<?php

namespace App\Http\Controllers\Auth;

use App\Enums\QueuePriority;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Jobs\V1\ProcessOTPGenerateJob;
use App\Models\OrganizationUser;
use App\Models\OTPToken;
use App\Models\SiteAdmin;
use App\Models\User;
use App\Notifications\V1\OTPVerified;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class TokenVerificationController extends Controller
{
    public function verify(Request $request): RedirectResponse|string|Exception
    {
        $validated = $request->validate([
            'token' => ['required', 'numeric', 'min:000000', 'max:999999'],
        ]);

        /** @var User $user */
        $user = $request->user();

        /** @var OTPToken $token */
        $token = $user->activeToken();

        if (!$token) {
            return response()->error('The token validity period has ended or we haven\'t sent you an OTP token yet.');
        }

        if ($validated['token'] !== $user->activeToken()->token) {
            throw ValidationException::withMessages([
                'token' => 'The token does not match with our record.',
            ]);
        }

        $user->email_verified_at = now();
        $user->save();

        $token->is_used = 1;
        $token->save();

        $user->notify(new OTPVerified);

        return response()->noContent();
    }

    public function resend(Request $request): JsonResponse
    {
        /** @var SiteAdmin|User */
        $user = $request->user();

        if ((bool) $user->email_verified_at) {
            return response()->error('Dear ' . $user->first_name . ', you email is already verified.');
        }

        ProcessOTPGenerateJob::dispatch($user)->onQueue(QueuePriority::HIGH->value);

        return response()->success('The OTP token has been sent to your mailbox. Please do check your mail shortly.');
    }
}
