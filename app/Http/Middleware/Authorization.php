<?php

    namespace App\Http\Middleware;

    use Illuminate\Support\Facades\Auth;
    use App\Permission;
    use App\RolePermission;
    use Closure;

    class Authorization
    {
        /**
         * Handle an incoming request.
         *
         * @param  \Illuminate\Http\Request  $request
         * @param  \Closure  $next
         * @return mixed
         */
        public function handle($request, Closure $next, $permission_name)
        {
            $permission = Permission::where('name',$permission_name)->first();
            // cek user must logged in first
            if (Auth::check()) {
                if($permission){
                    $role = Auth::user()->role;
                    $check_permission = RolePermission::where('role_id',$role->id)->where('permission_id',$permission->id)->first();
                    if($check_permission){
                        return $next($request);
                    }
                }
            
                return Response(view('unauthorized')->with('role', $permission_name));
            }
            // if not logged in
            else {
                return redirect('/sertifikat');
            }
        }
    }