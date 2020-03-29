<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface;
use App\Services\ApiServices\Interfaces\TranslatorInterface;
use Closure;
use Illuminate\Http\Response;
use Laravel\Lumen\Routing\Router;

final class VerifySenderCredentials
{
    /** @var \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory */
    private ApiResponseFactoryInterface $apiResponseFactory;

    /** @var \App\Services\ApiServices\Interfaces\TranslatorInterface $translator */
    private TranslatorInterface $translator;

    /**
     * VerifiedWithDetails constructor.
     *
     * @param \App\Services\ApiServices\Interfaces\ApiResponseFactoryInterface $apiResponseFactory
     * @param \App\Services\ApiServices\Interfaces\TranslatorInterface $translator
     */
    public function __construct(ApiResponseFactoryInterface $apiResponseFactory, TranslatorInterface $translator)
    {
        $this->apiResponseFactory = $apiResponseFactory;
        $this->translator = $translator;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next)
    {
        /** @var null|\App\Database\Models\User $user */
        $user = $request->user();

        $userIdFromRoute = $request->route('userId');

        if (
            $user === null ||
            $userIdFromRoute instanceof Router === true ||
            $user->getKey() !== $userIdFromRoute
        ) {
            return \response([
                'message' => $this->translator->trans('responses.unauthorized'),
                'data' => ['sender_id' => $userIdFromRoute],
                'code' => 401
            ], 401);
        }

        $request->merge(['sender_id' => $userIdFromRoute]);

        return $next($request);
    }
}
