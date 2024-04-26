<?php

namespace App\Http\Controllers\V1\Register;

use App\DTO\UserDTO;
use App\Enums\QueuePriority;
use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Http\Requests\V1\Register\RegisterStoreRequest;
use App\Jobs\V1\ProcessOTPGenerateJob;
use App\Models\OrganizationUser;
use App\Services\Writes\UserRegisterService;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(public UserRegisterService $registerService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(RegisterStoreRequest $request): JsonResponse
    {
        $userDTO = new UserDTO(
            $request->first_name,
            $request->last_name,
            $request->email,
            $request->password,
            $request->gender,
            $request->marital_status,
        );

        $user = $this->registerService->create($userDTO);

        ProcessOTPGenerateJob::dispatch($user)->onQueue(QueuePriority::HIGH->value);

        return response()->success('Your account created successfully.', [
            'message' => 'You will receive an OTP token in your mailbox to verify your account.',
        ]);
    }
}
