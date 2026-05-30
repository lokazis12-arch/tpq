<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPaymentStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user();

        if ($user && $user->role === 'wali_santri') {
            $activeId = session('active_santri_id');
            $santri = $activeId 
                ? \App\Models\Santri::where('wali_santri_id', $user->id)->where('id', $activeId)->first()
                : \App\Models\Santri::where('wali_santri_id', $user->id)->first();

            if ($santri) {
                $pembayaran = \App\Models\Pembayaran::where('santri_id', $santri->id)
                    ->where('bulan', now()->month)
                    ->where('tahun', now()->year)
                    ->where('status', 'lunas')
                    ->first();

                if (!$pembayaran) {
                    // Allow dashboard access but show warning; block other pages
                    $currentRoute = $request->route()->getName();
                    if ($currentRoute && !str_contains($currentRoute, 'dashboard')) {
                        return response()->view('blocked', [
                            'santri' => $santri,
                            'bulan' => now()->translatedFormat('F Y'),
                        ], 403);
                    }
                }
            }
        }

        return $next($request);
    }
}
