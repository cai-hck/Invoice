<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\company;
use App\employee;
use App\invoice;

use Illuminate\Support\Facades\Mail;
use App\Mail\forgot;
class LoginController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
              $this->user = Auth::user();
              if(Auth::user() != '')
              {
                if(Auth::user()->permission == 1)
                    return redirect('/profile');
                else if(Auth::user()->permission == 2)
                    return redirect('/listinvoice');
              }
              return $next($request);
          });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('welcome');
    }
    public function userlogin(Request $request)
    {
        $email = $request['email'];
        $password = $request['password'];
        $remember = $request['remember'];
        if (Auth::attempt(['email' => $email, 'password' => $password], $remember)) {
            // The user is being remembered...
            //Update online status            
            $user = Auth::user();
            $user->save();
            if(Auth::user()->permission == 1)
                return redirect('/profile');
            else if(Auth::user()->permission == 2)
                return redirect('/listinvoice');           
        }
        return back();
    }
    public function forgotemail(Request $request)
    {
        $user = User::select()
                ->where('email',$request->email)
                ->first();
        Mail::to($request->email)->send(new forgot($user));
        return back();
    }
    public function resetpassword($token)
    {
        return view('resetpassword')
                ->with('token',$token);
    }
    public function newpassword(Request $request)
    {
        $user = User::select()
                ->where('api_token',$request->token)
                ->first();
        $user->password = bcrypt($request->password);
        $user->save();
        if($user->permission == 1)
        {
            $company = company::select()
                ->where('email',$user->email)
                ->first();
            $company->password = base64_encode($request->password);
            $company->save();
        }
        else
        {
            $employee = employee::select()
                    ->where('email',$user->email)
                    ->first();
            $employee->password = base64_encode($request->password);
            $employee->save();
        }
        return redirect('/');
    }
}
