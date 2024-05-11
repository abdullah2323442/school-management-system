<?php

namespace App\Http\Middleware;

use App\Models\Classes;
use App\Models\Section;
use Closure;
use Illuminate\Http\Request;

class FetchRegistrationData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $classes = Classes::all();
        $sections = Section::all();

        $request->merge([
            'classes' => $classes,
            'sections' => $sections,
        ]);

        return $next($request);
    }
}
