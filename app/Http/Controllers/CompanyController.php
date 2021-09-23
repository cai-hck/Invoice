<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\company;
use App\ucompany;
use App\employee;
use App\invoice;
use App\source;
use App\airline;
use App\User;
use App\expense;
class CompanyController extends Controller
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
                return $next($request);
              else if(Auth::user()->permission == 2)
                return redirect('/listinvoice');
            }
            return redirect('/');
        });
    }
    public function companylogout()
    {
        Auth::logout(); // log the user out of our application
        return redirect('/'); // redirect the user to the login screen
    }
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */


    public function index()
    {
        
    }
    public function profile()
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        return view('company/profile')
                    ->with('company',$company)
                    ->with('name','profile');
    }
    public function updateprofile(Request $request)
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $company->name = $request->name;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $company->email = $request->email;
        if ($request->hasFile('photo')) {
            $this->validate($request, [
                'photo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
              ]);
            $image = $request->file('photo');
            $name = rand(100000, 999999).$_FILES["photo"]["name"];
            $destinationPath = public_path('/upload/logo');
            $imagePath = $destinationPath. "/".  $name;
            $image->move($destinationPath, $name);
            $company->photo = $name;
        }
        $company->status = 'edited by '.$company->id.'(company)';
        $company->save();
        $user = User::select()
            ->where('email',Auth::User()->email)
            ->first();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->photo = $company->photo;
        $user->save();
        $employees = employee::select()
                    ->where('company_id',$company->id)
                    ->get();
        foreach($employees as $employee)
        {
            $user = User::select()
                ->where('email',$employee->email)
                ->first();
            $user->photo = $company->photo;
            $user->save();
        }
        return back();
        
    }
    public function adduser()
    {
        return view('company/useradd')
                    ->with('name','adduser');
    }
    public function newuser(Request $request)
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $employee = new employee();
        $employee->company_id = $company->id;
        $employee->name = $request->name;
        $employee->education = $request->education;
        $employee->specilized = $request->specilized;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->note = $request->note;
        $employee->password = base64_encode($request->password);
        $employee->status = 'created by '.$company->id.'(company)';
        $employee->generator = $request->generator;
        $employee->cashier = $request->cashier;
        $employee->edit_invoices = $request->edit_invoices;
        $employee->see_allinvoices = $request->see_allinvoices;
        $employee->expenser = $request->expenser;
        $employee->edit_expenses = $request->edit_expenses;
        $employee->see_allexpenses = $request->see_allexpenses;
        $employee->delete_invoices = $request->delete_invoices;
        $employee->delete_expenses = $request->delete_expenses;
        $employee->generator1 = $request->generator1;
        $employee->edit_invoice1s = $request->edit_invoice1s;
        $employee->see_allinvoice1s = $request->see_allinvoice1s;
        $employee->delete_invoice1s = $request->delete_invoice1s;
        $employee->paying = $request->paying;
        $employee->edit_payings = $request->edit_payings;
        $employee->see_allpayings = $request->see_allpayings;
        $employee->delete_payings = $request->delete_payings;
        $employee->paid = $request->paid;
        $employee->edit_paids = $request->edit_paids;
        $employee->see_allpaids = $request->see_allpaids;
        $employee->delete_paids = $request->delete_paids;
        $employee->save();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->photo = Auth::User()->photo;
        $user->permission = 2;/* Employee */
        $user->password = bcrypt($request->password);
        $user->save();
        return back();
    }
    public function listuser()
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $employee = employee::select()
            ->where('company_id',$company->id)
            ->get();
        return view('company/user')
                    ->with('employees',$employee)
                    ->with('name','user');
    }
    public function edituser($id)
    {
        $employee = employee::select()
        ->where('id',$id)
        ->first();
        return view('company/useredit')
                    ->with('employee',$employee)
                    ->with('name','user');
    }
    public function deluser($id)
    {
        $employee = employee::select()
                    ->where('id',$id)
                    ->first();
                    
        $user = User::select()
            ->where('email',$employee->email)
            ->first();
        $user->delete();
        $employee->delete();
        return back();
    }
    public function updateuser(Request $request)
    {
        $employee = employee::select()
                        ->where('id',$request->id)
                        ->first();
        $company = company::select()
                    ->where('email',Auth::User()->email)
                    ->first();
        $user = User::select()
                ->where('email',$employee->email)
                ->first();
        $employee->name = $request->name;
        $employee->education = $request->education;
        $employee->specilized = $request->specilized;
        $employee->email = $request->email;
        $employee->phone = $request->phone;
        $employee->address = $request->address;
        $employee->note = $request->note;
        if($request->password != '')
        {
            $employee->password = base64_encode($request->password);
        }
        $employee->generator = $request->generator;
        $employee->cashier = $request->cashier;
        $employee->edit_invoices = $request->edit_invoices;
        $employee->see_allinvoices = $request->see_allinvoices;
        $employee->expenser = $request->expenser;
        $employee->edit_expenses = $request->edit_expenses;
        $employee->see_allexpenses = $request->see_allexpenses;
        $employee->delete_invoices = $request->delete_invoices;
        $employee->delete_expenses = $request->delete_expenses;
        
        $employee->generator1 = $request->generator1;
        $employee->edit_invoice1s = $request->edit_invoice1s;
        $employee->see_allinvoice1s = $request->see_allinvoice1s;
        $employee->delete_invoice1s = $request->delete_invoice1s;
        $employee->paying = $request->paying;
        $employee->edit_payings = $request->edit_payings;
        $employee->see_allpayings = $request->see_allpayings;
        $employee->delete_payings = $request->delete_payings;
        $employee->paid = $request->paid;
        $employee->edit_paids = $request->edit_paids;
        $employee->see_allpaids = $request->see_allpaids;
        $employee->delete_paids = $request->delete_paids;

        $employee->status = 'edited by '.$company->id.'(company)';
        $employee->save();

        $user->name = $request->name;
        $user->email = $request->email;
        if($request->password != '')
        {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return back();
    }
    public function addsource()
    {
        return view('company/sourceadd')
                    ->with('name','addsource');
    }
    public function newsource(Request $request)
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $source = new source();
        $source->company_id = $company->id;
        $source->name = $request->name;
        $source->email = $request->email;
        $source->phone = $request->phone;
        $source->address = $request->address;
        $source->note = $request->note;
        $source->status = 'created by '.$company->id.'(company)';
        $source->save();
        return back();
    }
    public function listsource()
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $source = source::select()
            ->where('company_id',$company->id)
            ->get();
        return view('company/source')
                    ->with('sources',$source)
                    ->with('name','source');
    }
    public function editsource($id)
    {
        $source = source::select()
        ->where('id',$id)
        ->first();
        return view('company/sourceedit')
                    ->with('source',$source)
                    ->with('name','source');
    }
    public function updatesource(Request $request)
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $source = source::select()
            ->where('id',$request->id)
            ->first();
        $source->name = $request->name;
        $source->email = $request->email;
        $source->phone = $request->phone;
        $source->address = $request->address;
        $source->note = $request->note;
        $source->status = 'edited by '.$company->id.'(company)';
        $source->save();
        return back();
    }
    public function delsource($id)
    {
        $source = source::select()
                    ->where('id',$id)
                    ->first();
        $source->delete();
        return back();
    }
    public function addairline()
    {
        return view('company/airlineadd')
                    ->with('name','addairline');
    }
    public function newairline(Request $request)
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $airline = new airline();
        $airline->company_id = $company->id;
        $airline->name = $request->name;
        $airline->status = 'created by '.$company->id.'(company)';
        $airline->save();
        return back();
    }
    public function listairline()
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $airline = airline::select()
            ->where('company_id',$company->id)
            ->get();
        return view('company/airline')
                    ->with('airlines',$airline)
                    ->with('name','airline');
    }
    public function editairline($id)
    {
        $airline = airline::select()
        ->where('id',$id)
        ->first();
        return view('company/airlineedit')
                    ->with('airline',$airline)
                    ->with('name','airline');
    }
    public function updateairline(Request $request)
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $airline = airline::select()
            ->where('id',$request->id)
            ->first();
        $airline->name = $request->name;
        $airline->status = 'edited by '.$company->id.'(company)';
        $airline->save();
        return back();
    }
    public function delairline($id)
    {
        $airline = airline::select()
                    ->where('id',$id)
                    ->first();
        $airline->delete();
        return back();
    }
    public function adducompany()
    {
        return view('company/ucompanyadd')
                    ->with('name','adducompany');
    }
    public function newucompany(Request $request)
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $ucompany = new ucompany();
        $ucompany->company_id = $company->id;
        $ucompany->name = $request->name;
        $ucompany->status = 'created by '.$company->id.'(company)';
        $ucompany->save();
        return back();
    }
    public function listucompany()
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $ucompany = ucompany::select()
            ->where('company_id',$company->id)
            ->get();
        return view('company/ucompany')
                    ->with('ucompanys',$ucompany)
                    ->with('name','ucompany');
    }
    public function editucompany($id)
    {
        $ucompany = ucompany::select()
        ->where('id',$id)
        ->first();
        return view('company/ucompanyedit')
                    ->with('ucompany',$ucompany)
                    ->with('name','ucompany');
    }
    public function updateucompany(Request $request)
    {
        $company = company::select()
            ->where('email',Auth::User()->email)
            ->first();
        $ucompany = ucompany::select()
            ->where('id',$request->id)
            ->first();
        $ucompany->name = $request->name;
        $ucompany->status = 'edited by '.$company->id.'(company)';
        $ucompany->save();
        return back();
    }
    public function delucompany($id)
    {
        $ucompany = ucompany::select()
                    ->where('id',$id)
                    ->first();
        $ucompany->delete();
        return back();
    }
}
