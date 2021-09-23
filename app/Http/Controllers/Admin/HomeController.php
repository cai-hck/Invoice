<?php

namespace App\Http\Controllers\Admin;

use App\User;
use App\Role;
use App\Admin;
use App\Permission;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\company;
use App\employee;
use App\invoice;
class HomeController extends Controller
{
    public function index()
    {
        return view('admin.home')
            ->with('name','Dashboard');
    }
    public function addcompany()
    {
        return view('admin.companyadd')
            ->with('name','Add Company');
    }
    public function newcompany(Request $request)
    {
        $company = new company();
        $company->name = $request->name;
        $company->phone = $request->phone;
        $company->address = $request->address;
        $company->email = $request->email;
        $company->password = base64_encode($request->password);
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
        $company->status = 'created by admin';
        $company->save();

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->photo = $company->photo;
        $user->permission = 1;/* Company */
        $user->password = bcrypt($request->password);
        $user->save();
        return back();
    }
    public function delcompany($id)
    {
        $company = company::select()
                    ->where('id',$id)
                    ->first();
        $user = User::select()
            ->where('email',$company->email)
            ->first();
        $user->delete();
        $company->delete();
        return back();

    }
    public function listcompany()
    {
        $companies = company::select()
                            ->get();
        return view('admin.company')
            ->with('companies',$companies)
            ->with('name','Company List');
    }
    public function listuser()
    {
        $users = employee::select('employees.*','companies.name as cname')
                            ->leftjoin('companies','companies.id','=','employees.company_id')
                            ->get();
        return view('admin.user')
            ->with('users',$users)
            ->with('name','User List');
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
    public function listinvoice()
    {
        $invoices = invoice::select('invoices.id','invoices.name','invoices.phone','invoices.date_travel','invoices.to_pay','invoices.created_at',
                                    'companies.name as cname','sources.name as source','airlines.name as airline','A.name as generator','B.name as cashier')
                            ->leftjoin('companies','companies.id','=','invoices.company_id')
                            ->leftjoin('sources','sources.id','=','invoices.source_id')
                            ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                            ->leftjoin('employees as A','A.id','=','invoices.generator_id')
                            ->leftjoin('employees as B','B.id','=','invoices.cashier_id')
                            ->get();
        return view('admin.invoice')
            ->with('invoices',$invoices)
            ->with('name','Invoice List');
    }
    public function delinvoice($id)
    {
        $invoice = invoice::select()
                    ->where('id',$id)
                    ->first();
        $invoice->delete();
        return back();

    }
}
