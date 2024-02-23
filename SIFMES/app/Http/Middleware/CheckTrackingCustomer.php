<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTrackingCustomer
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    $route = $request->route()->getName();
    if (str_contains($route, 'tracking.customers')) {
      $roles = $request->session()->get('roles');
      if ($roles->contains('FK_Id_Role', 10)) {
        return $next($request);
      }
      return redirect()->route('index')->with('type', 'danger')->with('message', 'Bạn không có quyền truy cập');
    }
    return $next($request);
  }
}
