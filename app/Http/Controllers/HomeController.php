<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\company;
use App\ucompany;
use App\employee;
use App\invoice;
use App\invoice1;
use App\source;
use App\airline;
use App\expense;
use App\paid;
use App\paying;

use Illuminate\Support\Facades\Mail;
use App\Mail\sendinvoice;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function userlogout()
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
    public function listinvoice()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice = invoice::select()
                ->where('invoices.company_id',$company->id)
                ->get();
            return view('invoice')
                ->with('invoices',$invoice)
                ->with('employee','')
                ->with('name','invoice');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoices == '1')
        {
            $invoice = invoice::select('invoices.*','sources.name as source')
                ->where('invoices.company_id',$employee->company_id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->get();
        }
        else
        {
            $invoice = invoice::select('invoices.*','sources.name as source')
                ->where('invoices.company_id',$employee->company_id)
                ->where('generator_id',$employee->id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->get();
        }
        return view('invoice')
                    ->with('invoices',$invoice)
                    ->with('employee',$employee)
                    ->with('name','invoice');
    }
    public function listinvoice1()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice = invoice1::select('invoice1s.*','sources.name as source')
                ->where('invoice1s.company_id',$company->id)
                ->leftjoin('sources','sources.id','=','invoice1s.source_id')
                ->get();
            return view('invoice1')
                ->with('invoices',$invoice)
                ->with('employee','')
                ->with('name','invoice1');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoice1s == '1')
        {
            $invoice = invoice1::select('invoice1s.*','sources.name as source')
                ->where('invoice1s.company_id',$employee->company_id)
                ->leftjoin('sources','sources.id','=','invoice1s.source_id')
                ->get();
        }
        else
        {
            $invoice = invoice1::select('invoice1s.*','sources.name as source')
                ->where('invoice1s.company_id',$employee->company_id)
                ->where('generator_id',$employee->id)
                ->leftjoin('sources','sources.id','=','invoice1s.source_id')
                ->get();
        }
        return view('invoice1')
                    ->with('invoices',$invoice)
                    ->with('employee',$employee)
                    ->with('name','invoice1');
    }
    public function addinvoice()
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $source = source::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $airline = airline::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('user/invoiceadd')
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('employee',$employee)
                    ->with('name','addinvoice');
    }
    public function addinvoice1()
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $source = source::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $airline = airline::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $ucompany = ucompany::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('user/invoice1add')
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('employee',$employee)
                    ->with('ucompanys',$ucompany)
                    ->with('name','addinvoice1');
    }
    public function newinvoice(Request $request)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        
        $invoice = New invoice();
        $invoice->company_id = $employee->company_id;
        $invoice->generator_id = $employee->id;
        $invoice->cashier_id = 0;
        $invoice->name = $request->name;
        $invoice->details = $request->details;
        $invoice->adult_no = $request->adult_no;
        $invoice->child_no = $request->child_no;
        $invoice->infant_no = $request->infant_no;
        $invoice->adult_buy = $request->adult_buy;
        $invoice->adult_sell = $request->adult_sell;
        $invoice->adult_fair = $request->adult_fair;
        $invoice->child_buy = $request->child_buy;
        $invoice->child_sell = $request->child_sell;
        $invoice->child_fair = $request->child_fair;
        $invoice->infant_buy = $request->infant_buy;
        $invoice->infant_sell = $request->infant_sell;
        $invoice->infant_fair = $request->infant_fair;
        $invoice->source_id = $request->source_id;
        $invoice->comission_source = $request->comission_source;
        $invoice->comission_passenger = $request->comission_passenger;
        $invoice->phone = $request->phone;
        $invoice->passport = $request->passport;
        $invoice->et = $request->et;
        $date = str_replace('/', '-', $request->date_travel);  
        $invoice->date_travel = date("Y-m-d", strtotime($date));
        $invoice->airline_id = $request->airline_id;
        $invoice->to_pay = $request->to_pay;
        $invoice->note = $request->note;
        $invoice->paid = 0;
        $invoice->status = 'Created by '.$employee->id.'(employee)';
        $invoice->save();

        $company = company::select()
            ->where('id',$employee->company_id)
            ->first();
        
        if($request->type == 'print')
        {
            $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
            $string = 'invoice'.$invoice->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'invoice'.$invoice->id));
            $data = ['invoice' => $invoice,'company' => $company,'qr' => 'invoice'.$invoice->id,'airline' => $airline];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('print', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
            $string = 'invoice'.$invoice->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'invoice'.$invoice->id));
            $data = ['invoice' => $invoice,'company' => $company,'qr' => 'invoice'.$invoice->id,'airline' => $airline];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('print', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$invoice->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);
            Mail::to($request->type)->send(new sendinvoice($invoice->id.'-'.$rd.'.pdf',$company->name,$invoice->id,$company->email));
        }
        return back();
    }
    public function newinvoice1(Request $request)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        
        $invoice = New invoice1();
        $invoice->company_id = $employee->company_id;
        $invoice->generator_id = $employee->id;
        $invoice->cashier_id = 0;
        $invoice->name = $request->name;
        $invoice->details = $request->details;
        $invoice->adult_no = $request->adult_no;
        $invoice->child_no = $request->child_no;
        $invoice->infant_no = $request->infant_no;
        $invoice->adult_buy = $request->adult_buy;
        $invoice->adult_sell = $request->adult_sell;
        $invoice->adult_fair = $request->adult_fair;
        $invoice->child_buy = $request->child_buy;
        $invoice->child_sell = $request->child_sell;
        $invoice->child_fair = $request->child_fair;
        $invoice->infant_buy = $request->infant_buy;
        $invoice->infant_sell = $request->infant_sell;
        $invoice->infant_fair = $request->infant_fair;
        $invoice->source_id = $request->source_id;
        $invoice->comission_source = $request->comission_source;
        $invoice->comission_passenger = $request->comission_passenger;
        $invoice->phone = $request->phone;
        $invoice->passport = $request->passport;
        $invoice->et = $request->et;
        $date = str_replace('/', '-', $request->date_travel);  
        $invoice->date_travel = date("Y-m-d", strtotime($date));
        $invoice->airline_id = $request->airline_id;
        $invoice->to_pay = $request->to_pay;
        $invoice->note = $request->note;
        $invoice->paid = 0;
        $invoice->status = 'Created by '.$employee->id.'(employee)';
        $invoice->save();

        $company = company::select()
            ->where('id',$employee->company_id)
            ->first();
        
        if($request->type == 'print')
        {
            $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
            $string = 'invoice1'.$invoice->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'invoice1'.$invoice->id));
            $data = ['invoice' => $invoice,'company' => $company,'qr' => 'invoice1'.$invoice->id,'airline' => $airline];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('print', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
            $string = 'invoice1'.$invoice->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'invoice1'.$invoice->id));
            $data = ['invoice' => $invoice,'company' => $company,'qr' => 'invoice1'.$invoice->id,'airline' => $airline];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('print', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$invoice->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);
            Mail::to($request->type)->send(new sendinvoice($invoice->id.'-'.$rd.'.pdf',$company->name,$invoice->id,$company->email));
        }
        return back();
    }
    public function updateinvoice(Request $request)
    {
        $invoice = invoice::select()
            ->where('id',$request->id)
            ->first();
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice->status = 'edited by '.$company->id.'(company)';
        }
        else
        {
            $employee = employee::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice->status = 'edited by '.$employee->id.'(employee)';
            $company = company::select()
                ->where('id',$employee->company_id)
                ->first();
        }
        $invoice->name = $request->name;
        $invoice->details = $request->details;
        $invoice->adult_no = $request->adult_no;
        $invoice->child_no = $request->child_no;
        $invoice->infant_no = $request->infant_no;
        $invoice->adult_buy = $request->adult_buy;
        $invoice->adult_sell = $request->adult_sell;
        $invoice->adult_fair = $request->adult_fair;
        $invoice->child_buy = $request->child_buy;
        $invoice->child_sell = $request->child_sell;
        $invoice->child_fair = $request->child_fair;
        $invoice->infant_buy = $request->infant_buy;
        $invoice->infant_sell = $request->infant_sell;
        $invoice->infant_fair = $request->infant_fair;
        $invoice->source_id = $request->source_id;
        $invoice->comission_source = $request->comission_source;
        $invoice->comission_passenger = $request->comission_passenger;
        $invoice->phone = $request->phone;
        $invoice->passport = $request->passport;
        $invoice->et = $request->et;
        $date = str_replace('/', '-', $request->date_travel);  
        $invoice->date_travel = date("Y-m-d", strtotime($date));
        $invoice->airline_id = $request->airline_id;
        $invoice->to_pay = $request->to_pay;
        $invoice->note = $request->note;
        $invoice->returned_balance_to_passenger = $request->returned_balance_to_passenger;
        $invoice->returned_balance_from_source = $request->returned_balance_from_source;
        $invoice->save();
        if($request->type == 'print')
        {
            $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
            $string = 'invoice'.$invoice->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'invoice'.$invoice->id));
            $data = ['invoice' => $invoice,'company' => $company,'qr' => 'invoice'.$invoice->id,'airline' => $airline];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('print', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
            $string = 'invoice'.$invoice->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'invoice'.$invoice->id));
            $data = ['invoice' => $invoice,'company' => $company,'qr' => 'invoice'.$invoice->id,'airline' => $airline];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('print', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$invoice->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);

            Mail::to($request->type)->send(new sendinvoice($invoice->id.'-'.$rd.'.pdf',$company->name,$invoice->id,$company->email));

        }
        return back();
    }
    public function updateinvoice1(Request $request)
    {
        $invoice = invoice1::select()
            ->where('id',$request->id)
            ->first();
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice->status = 'edited by '.$company->id.'(company)';
        }
        else
        {
            $employee = employee::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice->status = 'edited by '.$employee->id.'(employee)';
            $company = company::select()
                ->where('id',$employee->company_id)
                ->first();
        }
        $invoice->name = $request->name;
        $invoice->details = $request->details;
        $invoice->adult_no = $request->adult_no;
        $invoice->child_no = $request->child_no;
        $invoice->infant_no = $request->infant_no;
        $invoice->adult_buy = $request->adult_buy;
        $invoice->adult_sell = $request->adult_sell;
        $invoice->adult_fair = $request->adult_fair;
        $invoice->child_buy = $request->child_buy;
        $invoice->child_sell = $request->child_sell;
        $invoice->child_fair = $request->child_fair;
        $invoice->infant_buy = $request->infant_buy;
        $invoice->infant_sell = $request->infant_sell;
        $invoice->infant_fair = $request->infant_fair;
        $invoice->source_id = $request->source_id;
        $invoice->comission_source = $request->comission_source;
        $invoice->comission_passenger = $request->comission_passenger;
        $invoice->phone = $request->phone;
        $invoice->passport = $request->passport;
        $invoice->et = $request->et;
        $date = str_replace('/', '-', $request->date_travel);  
        $invoice->date_travel = date("Y-m-d", strtotime($date));
        $invoice->airline_id = $request->airline_id;
        $invoice->to_pay = $request->to_pay;
        $invoice->note = $request->note;
        $invoice->returned_balance_to_passenger = $request->returned_balance_to_passenger;
        $invoice->returned_balance_from_source = $request->returned_balance_from_source;
        $invoice->save();
        if($request->type == 'print')
        {
            $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
            $string = 'invoice1'.$invoice->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'invoice'.$invoice->id));
            $data = ['invoice' => $invoice,'company' => $company,'qr' => 'invoice1'.$invoice->id,'airline' => $airline];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('print', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
            $string = 'invoice1'.$invoice->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'invoice1'.$invoice->id));
            $data = ['invoice' => $invoice,'company' => $company,'qr' => 'invoice1'.$invoice->id,'airline' => $airline];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('print', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$invoice->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);

            Mail::to($request->type)->send(new sendinvoice($invoice->id.'-'.$rd.'.pdf',$company->name,$invoice->id,$company->email));

        }
        return back();
    }
    public function addcashier()
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        return view('user/cashieradd')
                    ->with('employee',$employee)
                    ->with('invoice','')
                    ->with('name','addcashier');
    }
    public function findinvoice(Request $request)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($request->id != '' && $request->passport !='')
        {
            $invoice = invoice::select('invoices.*','employees.name as generator')
                ->where('invoices.id',$request->id)
                ->where('invoices.passport',$request->passport)
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->first();
        }
        else if($request->id !='')
        {
            $invoice = invoice::select('invoices.*','employees.name as generator')
                ->where('invoices.id',$request->id)
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->first();
        }
        else if($request->passport !='')
        {
            $invoice = invoice::select('invoices.*','employees.name as generator')
                ->where('invoices.passport',$request->passport)
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->first();
        }
        else
        {
            $invoice='';
        }
        return view('user/cashieradd')
                    ->with('employee',$employee)
                    ->with('invoice',$invoice)
                    ->with('name','addcashier');
    }
    public function newcashier(Request $request)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $invoice = invoice::select()
            ->where('id',$request->id)
            ->first();
        $invoice->paid += $request->paid;
        $invoice->status = 'Paid by '.$employee->id.'(employee)';;
        $invoice->save();
        if($request->type == 'save')
            return redirect('addcashier');
        $company = company::select()
                ->where('id',$employee->company_id)
                ->first();
        $airline = airline::select()
                        ->where('id',$invoice->airline_id)
                        ->first();
        $string = 'cash'.$invoice->id.'-'.$company->name;
        \QrCode::size(500)
        ->format('png')
        ->generate($string, public_path('/upload/qr/'.'cash'.$invoice->id));
        $data = ['invoice' => $invoice,'company' => $company,'qr' => 'cash'.$invoice->id,'airline' => $airline];
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML(view('print', $data)->render());
        return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
    }
    public function addexpense()
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        return view('user/expenseadd')
                    ->with('employee',$employee)
                    ->with('invoice','')
                    ->with('name','addexpense');
    }
    public function newexpense(Request $request)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $expense = new expense();
        $expense->company_id = $employee->company_id;
        $expense->employee_id = $employee->id;
        $expense->cost = $request->cost;
        $expense->note = $request->note;
        $expense->details = $request->details;
        $expense->name = $request->name;
        $expense->status = 'created by '.$employee->id.'(employee)';;
        $expense->save();
        
        $company = company::select()
            ->where('id',$employee->company_id)
            ->first();
        if($request->type == 'print')
        {
            $string = 'expense'.$expense->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'expense'.$expense->id));
            $data = ['expense' => $expense,'company' => $company,'qr' => 'expense'.$expense->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->SetDirectionality('rtl');
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('printexpense', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $string = 'expense'.$expense->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'expense'.$expense->id));
            $data = ['expense' => $expense,'company' => $company,'qr' => 'expense'.$expense->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->SetDirectionality('rtl');
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('printexpense', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$expense->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);

            Mail::to($request->type)->send(new sendinvoice($expense->id.'-'.$rd.'.pdf',$company->name,$expense->id,$company->email));
        }
        return back();
    }
    public function listexpense()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $expense = expense::select()
                ->where('company_id',$company->id)
                ->get();
            return view('expense')
                ->with('expenses',$expense)
                ->with('employee','')
                ->with('name','expense');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allexpenses == '1')
        {
            $expense = expense::select()
                ->where('company_id',$employee->company_id)
                ->get();
        }
        else
        {
            $expense = expense::select()
                ->where('company_id',$employee->company_id)
                ->where('employee_id',$employee->id)
                ->get();
        }
        return view('expense')
                    ->with('expenses',$expense)
                    ->with('employee',$employee)
                    ->with('name','expense');
    }
    public function expensereport()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $expense = expense::select('expenses.*','employees.name as employee')
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->where('expenses.company_id',$company->id)
                ->get();
            return view('expensereport')
                ->with('expenses',$expense)
                ->with('employee','')
                ->with('name','expensereport');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allexpenses == '1')
        {
            $expense = expense::select('expenses.*','employees.name as employee')
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->where('expenses.company_id',$employee->company_id)
                ->get();
        }
        else
        {
            $expense = expense::select('expenses.*','employees.name as employee')
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->where('expenses.company_id',$employee->company_id)
                ->where('expenses.employee_id',$employee->id)
                ->get();
        }
        return view('expensereport')
                    ->with('expenses',$expense)
                    ->with('employee',$employee)
                    ->with('name','expensereport');
    }
    public function editexpense($id)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $expense = expense::select('expenses.*','employees.name as employee')
            ->leftjoin('employees','employees.id','=','expenses.employee_id')
            ->where('expenses.id',$id)
            ->first();
        return view('expenseedit')
                    ->with('employee',$employee)
                    ->with('expense',$expense)
                    ->with('name','expense');
    }
    public function updateexpense(Request $request)
    {
        $expense = expense::select()
            ->where('id',$request->id)
            ->first();
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $expense->status = 'edited by '.$company->id.'(company)';
            $employee = employee::select()
                ->where('id',$expense->employee_id)
                ->first();
        }
        else
        {
            $employee = employee::select()
                ->where('email',Auth::User()->email)
                ->first();
            $expense->status = 'edited by '.$employee->id.'(employee)';
            $company = company::select()
                ->where('id',$employee->company_id)
                ->first();
        }
        $expense->returned += $request->returned;
        if($request->note != '')
            $expense->note = $request->note;
        $expense->save();

        $string = 'expense'.$expense->id.'-'.$company->name;
        \QrCode::size(500)
        ->format('png')
        ->generate($string, public_path('/upload/qr/'.$string));
        $data = ['expense' => $expense,'company' => $company,'qr' => 'expense'.$expense->id,'employee' => $employee];
        $mpdf = new \Mpdf\Mpdf();
        $mpdf->SetDirectionality('rtl');
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        $mpdf->WriteHTML(view('printexpense', $data)->render());
        return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
    }
    public function editinvoice($id)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $invoice = invoice::select('invoices.*','sources.name as source','airlines.name as airline')
            ->where('invoices.id',$id)
            ->leftjoin('sources','sources.id','=','invoices.source_id')
            ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
            ->first();
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $source = source::select()
                ->where('company_id',$company->id)
                ->get();
            $airline = airline::select()
                ->where('company_id',$company->id)
                ->get();
        }
        else
        {
            $source = source::select()
                ->where('company_id',$employee->company_id)
                ->get();
            $airline = airline::select()
                ->where('company_id',$employee->company_id)
                ->get();
        }
        return view('invoiceedit')
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('employee',$employee)
                    ->with('invoice',$invoice)
                    ->with('name','invoice');
    }
    public function editinvoice1($id)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $invoice = invoice1::select('invoice1s.*','sources.name as source','airlines.name as airline','ucompanies.name as ucompany')
            ->where('invoice1s.id',$id)
            ->leftjoin('sources','sources.id','=','invoice1s.source_id')
            ->leftjoin('airlines','airlines.id','=','invoice1s.airline_id')
            ->leftjoin('ucompanies','ucompanies.id','=','invoice1s.to_pay')
            ->first();
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $source = source::select()
                ->where('company_id',$company->id)
                ->get();
            $airline = airline::select()
                ->where('company_id',$company->id)
                ->get();
            $ucompany = ucompany::select()
                ->where('company_id',$company->id)
                ->get();
        }
        else
        {
            $source = source::select()
                ->where('company_id',$employee->company_id)
                ->get();
            $airline = airline::select()
                ->where('company_id',$employee->company_id)
                ->get();
            $ucompany = ucompany::select()
                ->where('company_id',$employee->company_id)
                ->get();
        }
        return view('invoice1edit')
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('ucompanys',$ucompany)
                    ->with('employee',$employee)
                    ->with('invoice',$invoice)
                    ->with('name','invoice1');
    }
    public function sourcereport()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$company->id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
            $source = source::select()
                ->where('company_id',$company->id)
                ->get();
            $airline = airline::select()
                ->where('company_id',$company->id)
                ->get();
            $employees = employee::select()
                ->where('company_id',$company->id)
                ->get();
            return view('sourcereport')
                ->with('invoices',$invoice)
                ->with('employee','')
                ->with('employees',$employees)
                ->with('sources',$source)
                ->with('airlines',$airline)
                ->with('name','sourcereport');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoices == '1')
        {
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        else
        {
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->where('invoices.generator_id',$employee->id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        $source = source::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $airline = airline::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $employees = employee::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('sourcereport')
                    ->with('invoices',$invoice)
                    ->with('employee',$employee)
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('employees',$employees)
                    ->with('name','sourcereport');
    }
    public function invoicereport()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$company->id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
            $source = source::select()
                ->where('company_id',$company->id)
                ->get();
            $airline = airline::select()
                ->where('company_id',$company->id)
                ->get();
            return view('sourcereport')
                ->with('invoices',$invoice)
                ->with('sources',$source)
                ->with('airlines',$airline)
                ->with('employee','')
                ->with('name','sourcereport');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoices == '1')
        {
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        else
        {
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->where('invoices.generator_id',$employee->id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        $source = source::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $airline = airline::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('invoicereport')
                    ->with('invoices',$invoice)
                    ->with('employee',$employee)
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('name','invoicereport');
    }
    public function invoicereport1()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$company->id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
            $source = source::select()
                ->where('company_id',$company->id)
                ->get();
            $airline = airline::select()
                ->where('company_id',$company->id)
                ->get();
            $employees = employee::select()
                ->where('company_id',$company->id)
                ->get();
            return view('sourcereport')
                ->with('invoices',$invoice)
                ->with('sources',$source)
                ->with('airlines',$airline)
                ->with('employees',$employees)
                ->with('employee','')
                ->with('name','sourcereport');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoices == '1')
        {
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        else
        {
            $invoice = invoice::select('invoices.*','airlines.name as airline','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->where('invoices.generator_id',$employee->id)
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        $source = source::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $airline = airline::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $employees = employee::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('invoicereport1')
                    ->with('invoices',$invoice)
                    ->with('employee',$employee)
                    ->with('employees',$employees)
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('name','invoicereport1');
    }
    public function debt()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice = invoice::select('invoices.*','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$company->id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
            return view('debt')
                ->with('invoices',$invoice)
                ->with('employee','')
                ->with('name','debt');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoices == '1')
        {
            $invoice = invoice::select('invoices.*','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        else
        {
            $invoice = invoice::select('invoices.*','sources.name as source','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->where('generator_id',$employee->id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        return view('debt')
                    ->with('invoices',$invoice)
                    ->with('employee',$employee)
                    ->with('name','debt');
    }
    public function calledbox()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice = invoice::select('invoices.*','sources.name as source')
                ->where('invoices.company_id',$company->id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->get();
            return view('debt')
                ->with('invoices',$invoice)
                ->with('employee','')
                ->with('name','debt');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoices == '1')
        {
            $invoice = invoice::select('invoices.*','sources.name as source')
                ->where('invoices.company_id',$employee->company_id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->get();
        }
        else
        {
            $invoice = invoice::select('invoices.*','sources.name as source')
                ->where('invoices.company_id',$employee->company_id)
                ->where('generator_id',$employee->id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->get();
        }
        return view('calledbox')
                    ->with('invoices',$invoice)
                    ->with('employee',$employee)
                    ->with('name','calledbox');
    }
    public function find(Request $request)
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            
            $invoices = invoice::select('invoices.*','sources.name as source','airlines.name as airline','employees.name as employee')
                ->where('invoices.company_id',$company->id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
            
            $findinvoice = array();
    
            $from = str_replace('/', '-', $request->from);  
            $to = str_replace('/', '-', $request->to);  
            foreach($invoices as $invoice)
            {
                if( ($request->from == '' || $invoice->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($from))))&&
                    ($request->to == '' || $invoice->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($to))))&&
                    ($request->source == '' || $request->source==$invoice->source)&&
                    ($request->passport == '' || $request->passport==$invoice->passport)&&
                    ($request->comission == '' || ($request->comission==$invoice->comission_passenger &&$request->type =='debt') || ($request->comission==$invoice->comission_source&&$request->type =='sourcereport'))&&
                    ($request->id == '' || $request->id==$invoice->id)&&
                    ($request->airline == '' || $request->airline==$invoice->airline)&&
                    ($request->et == '' || $request->et==$invoice->et)&&
                    ($request->phone == '' || $request->phone==$invoice->phone)&&
                    ($request->name == '' || $request->name==$invoice->name)&&
                    ($request->employee == '' || $request->employee==$invoice->employee))
                {
                    array_push($findinvoice,array(
                        'id' => $invoice->id,'created_at' => $invoice->created_at,'details' => $invoice->details,'comission_source' => $invoice->comission_source,
                        'adult_no' => $invoice->adult_no,'child_no' => $invoice->child_no,'infant_no' => $invoice->infant_no,
                        'adult_sell' => $invoice->adult_sell,'child_sell' => $invoice->child_sell,'infant_sell' => $invoice->infant_sell,
                        'adult_buy' => $invoice->adult_buy,'child_buy' => $invoice->child_buy,'infant_buy' => $invoice->infant_buy,
                        'adult_fair' => $invoice->adult_fair,'child_fair' => $invoice->child_fair,'infant_fair' => $invoice->infant_fair,
                        'paid' => $invoice->paid,'to_pay' => $invoice->to_pay,
                        'name' => $invoice->name,'comission_passenger' => $invoice->comission_passenger,'source' => $invoice->source,'note' => $invoice->note,
                        'phone' => $invoice->phone,'et' => $invoice->et,'passport' => $invoice->passport,'airline' => $invoice->airline,'employee' => $invoice->employee,
                        'returned_balance_to_passenger' => $invoice->returned_balance_to_passenger,'returned_balance_from_source' => $invoice->returned_balance_from_source));
                }
            }
            $source = source::select()
                ->where('company_id',$company->id)
                ->get();
            $airline = airline::select()
                ->where('company_id',$company->id)
                ->get();
            $employees = employee::select()
                ->where('company_id',$company->id)
                ->get();
            if($request->type == "debt")
            {
                return view('debt')
                    ->with('invoices',$findinvoice)
                    ->with('employee','')
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('name','debt');
            }
            if($request->type == "invoicereport")
            {
                return view('invoicereport')
                    ->with('invoices',$findinvoice)
                    ->with('employee','')
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('name','invoicereport');
            }
            if($request->type == "invoicereport1")
            {
                return view('invoicereport1')
                    ->with('invoices',$findinvoice)
                    ->with('employee','')
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('employees',$employees)
                    ->with('name','invoicereport1');
            }
            if($request->type == "calledbox")
            {
                return view('calledbox')
                    ->with('invoices',$findinvoice)
                    ->with('employee','')
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('name','calledbox');
            }
            return view('sourcereport')
                ->with('invoices',$findinvoice)
                ->with('employee','')
                ->with('sources',$source)
                ->with('airlines',$airline)
                ->with('employees',$employees)
                ->with('name','sourcereport');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoices == '1')
        {
            $invoices = invoice::select('invoices.*','sources.name as source','airlines.name as airline','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        else
        {
            $invoices = invoice::select('invoices.*','sources.name as source','airlines.name as airline','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->where('generator_id',$employee->id)
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->leftjoin('airlines','airlines.id','=','invoices.airline_id')
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        $findinvoice = array();
        
        $from = str_replace('/', '-', $request->from);  
        $to = str_replace('/', '-', $request->to);  
        foreach($invoices as $invoice)
        {
            if( ($request->from == '' || $invoice->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($from))))&&
                ($request->to == '' || $invoice->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($to))))&&
                ($request->source == '' || $request->source==$invoice->source)&&
                ($request->passport == '' || $request->passport==$invoice->passport)&&
                ($request->comission == '' || ($request->comission==$invoice->comission_passenger &&$request->type =='debt') || ($request->comission==$invoice->comission_source&&$request->type =='sourcereport'))&&
                ($request->id == '' || $request->id==$invoice->id)&&
                ($request->airline == '' || $request->airline==$invoice->airline)&&
                ($request->et == '' || $request->et==$invoice->et)&&
                ($request->phone == '' || $request->phone==$invoice->phone)&&
                ($request->name == '' || $request->name==$invoice->name)&&
                ($request->employee == '' || $request->employee==$invoice->employee))
            {
                array_push($findinvoice,array(
                    'id' => $invoice->id,'created_at' => $invoice->created_at,'details' => $invoice->details,'comission_source' => $invoice->comission_source,
                    'adult_no' => $invoice->adult_no,'child_no' => $invoice->child_no,'infant_no' => $invoice->infant_no,
                    'adult_sell' => $invoice->adult_sell,'child_sell' => $invoice->child_sell,'infant_sell' => $invoice->infant_sell,
                    'adult_buy' => $invoice->adult_buy,'child_buy' => $invoice->child_buy,'infant_buy' => $invoice->infant_buy,
                    'adult_fair' => $invoice->adult_fair,'child_fair' => $invoice->child_fair,'infant_fair' => $invoice->infant_fair,
                    'paid' => $invoice->paid,'to_pay' => $invoice->to_pay,
                    'name' => $invoice->name,'comission_passenger' => $invoice->comission_passenger,'source' => $invoice->source,'note' => $invoice->note,
                    'phone' => $invoice->phone,'et' => $invoice->et,'passport' => $invoice->passport,'airline' => $invoice->airline,'employee' => $invoice->employee,
                    'returned_balance_to_passenger' => $invoice->returned_balance_to_passenger,'returned_balance_from_source' => $invoice->returned_balance_from_source));
            }
        }
        
        $source = source::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $airline = airline::select()
            ->where('company_id',$employee->company_id)
            ->get();
        $employees = employee::select()
            ->where('company_id',$employee->company_id)
            ->get();
        if($request->type == "debt")
        {
            return view('debt')
                    ->with('invoices',$findinvoice)
                    ->with('employee',$employee)
                    ->with('sources',$source)
                    ->with('airlines',$airline)
                    ->with('name','debt');
        }
        if($request->type == "invoicereport")
        {
            return view('invoicereport')
                ->with('invoices',$findinvoice)
                ->with('employee',$employee)
                ->with('sources',$source)
                ->with('airlines',$airline)
                ->with('name','invoicereport');
        }
        if($request->type == "invoicereport1")
        {
            return view('invoicereport1')
                ->with('invoices',$findinvoice)
                ->with('employee',$employee)
                ->with('sources',$source)
                ->with('airlines',$airline)
                ->with('employees',$employees)
                ->with('name','invoicereport1');
        }
        if($request->type == "calledbox")
        {
            return view('calledbox')
                ->with('invoices',$findinvoice)
                ->with('employee',$employee)
                ->with('sources',$source)
                ->with('airlines',$airline)
                ->with('name','calledbox');
        }
        return view('sourcereport')
                ->with('invoices',$findinvoice)
                ->with('employee',$employee)
                ->with('sources',$source)
                ->with('airlines',$airline)
                ->with('employees',$employees)
                ->with('name','sourcereport');

    }
    public function today()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $invoice = invoice::select('invoices.*','sources.name as source')
                ->where('invoices.company_id',$company->id)
                ->where('date_travel',date('Y-m-d'))
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->get();
            return view('today')
                ->with('invoices',$invoice)
                ->with('employee','')
                ->with('name','today');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allinvoices == '1')
        {

            $invoice = invoice::select('invoices.*','sources.name as source')
                ->where('invoices.company_id',$employee->company_id)
                ->where('date_travel',date('Y-m-d'))
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->get();
        }
        else
        {
            $invoice = invoice::select('invoices.*','sources.name as source')
                ->where('invoices.company_id',$employee->company_id)
                ->where('generator_id',$employee->id)
                ->where('date_travel',date('Y-m-d'))
                ->leftjoin('sources','sources.id','=','invoices.source_id')
                ->get();
        }
        return view('today')
            ->with('invoices',$invoice)
            ->with('employee',$employee)
            ->with('name','today');
    }
    public function delexpense($id)
    {
        $expense = expense::select()
                    ->where('id',$id)
                    ->first();
        $expense->delete();
        return back();
    }
    public function delinvoice($id)
    {
        $invoice = invoice::select()
                    ->where('id',$id)
                    ->first();
        $invoice->delete();
        return back();
    }
    public function delinvoice1($id)
    {
        $invoice = invoice1::select()
                    ->where('id',$id)
                    ->first();
        $invoice->delete();
        return back();
    }
    public function delpaid($id)
    {
        $paid = paid::select()
                    ->where('id',$id)
                    ->first();
        $paid->delete();
        return back();
    }
    public function addpaid()
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $ucompany = ucompany::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('user/paidadd')
                    ->with('employee',$employee)
                    ->with('ucompanies',$ucompany)
                    ->with('invoice','')
                    ->with('name','addpaid');
    }
    public function newpaid(Request $request)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $paid = new paid();
        $paid->company_id = $employee->company_id;
        $paid->employee_id = $employee->id;
        $paid->username = $request->username;
        $paid->invoice_nu = $request->invoice_nu;
        $paid->amount = $request->amount;
        $paid->u_company_id = $request->u_company_id;
        $paid->details = $request->details;
        $paid->total = $request->total;
        $paid->status = 'created by '.$employee->id.'(employee)';
        $paid->save();
        
        
        
        $company = company::select()
            ->where('id',$employee->company_id)
            ->first();
        
        if($request->type == 'print')
        {
            $string = 'paid'.$paid->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'paid'.$paying->id));
            $data = ['pp' => $paid,'company' => $company,'qr' => 'paid'.$paying->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->SetDirectionality('rtl');
            $mpdf->WriteHTML(view('printpaid_paying', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $string = 'paid'.$paid->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'paid'.$paying->id));
            $data = ['pp' => $paid,'company' => $company,'qr' => 'paid'.$paying->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->SetDirectionality('rtl');
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('printpaid_paying', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$paid->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);
            Mail::to($request->type)->send(new sendinvoice($paid->id.'-'.$rd.'.pdf',$company->name,$paid->id,$company->email));
        }
        return back();
    }
    public function listpaid()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $paid = paid::select('paids.*','employees.name as employee','ucompanies.name as ucompany')
                ->leftjoin('employees','employees.id','=','paids.employee_id')
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->where('paids.company_id',$company->id)
                ->get();
            return view('paid')
                ->with('paids',$paid)
                ->with('employee','')
                ->with('name','paid');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allpaid == '1')
        {
            $paid = paid::select('paids.*','employees.name as employee','ucompanies.name as ucompany')
                ->leftjoin('employees','employees.id','=','paids.employee_id')
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->where('paids.company_id',$employee->company_id)
                ->get();
        }
        else
        {
            $paid = paid::select('paids.*','employees.name as employee','ucompanies.name as ucompany')
                ->leftjoin('employees','employees.id','=','paids.employee_id')
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->where('paids.company_id',$employee->company_id)
                ->where('paids.employee_id',$employee->id)
                ->get();
        }
        return view('paid')
                    ->with('paids',$paid)
                    ->with('employee',$employee)
                    ->with('name','paid');
    }
    public function editpaid($id)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $paid = paid::select('paids.*','employees.name as employee','ucompanies.name as ucompany')
            ->leftjoin('employees','employees.id','=','paids.employee_id')
            ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
            ->where('paids.id',$id)
            ->first();
        $ucompany = ucompany::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('paidedit')
                    ->with('employee',$employee)
                    ->with('paid',$paid)
                    ->with('ucompanies',$ucompany)
                    ->with('name','paid');
    }
    public function updatepaid(Request $request)
    {
        $paid = paid::select()
            ->where('id',$request->id)
            ->first();
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $paid->status = 'edited by '.$company->id.'(company)';
            $employee = employee::select()
                ->where('id',$paid->employee_id)
                ->first();
        }
        else
        {
            $employee = employee::select()
                ->where('email',Auth::User()->email)
                ->first();
            $paid->status = 'edited by '.$employee->id.'(employee)';
            $company = company::select()
                ->where('id',$employee->company_id)
                ->first();
        }
        
        $paid->username = $request->username;
        $paid->invoice_nu = $request->invoice_nu;
        $paid->amount = $request->amount;
        $paid->u_company_id = $request->u_company_id;
        $paid->details = $request->details;
        $paid->total = $request->total;
        $paid->returned_balance_to_passenger = $request->returned_balance_to_passenger;
        $paid->returned_balance_from_source = $request->returned_balance_from_source;
        $paid->save();

        
        if($request->type == 'print')
        {
            $string = 'paid'.$paid->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'paid'.$paying->id));
            $data = ['pp' => $paid,'company' => $company,'qr' => 'paid'.$paying->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->SetDirectionality('rtl');
            $mpdf->WriteHTML(view('printpaid_paying', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $string = 'paid'.$paid->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'paid'.$paying->id));
            $data = ['pp' => $paid,'company' => $company,'qr' => 'paid'.$paying->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->SetDirectionality('rtl');
            $mpdf->WriteHTML(view('printpaid_paying', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$paid->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);
            Mail::to($request->type)->send(new sendinvoice($paid->id.'-'.$rd.'.pdf',$company->name,$paid->id,$company->email));
        }
        return back();
    }
    public function delpaying($id)
    {
        $paying = paying::select()
                    ->where('id',$id)
                    ->first();
        $paying->delete();
        return back();
    }
    public function addpaying()
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $source = source::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('user/payingadd')
                    ->with('employee',$employee)
                    ->with('sources',$source)
                    ->with('invoice','')
                    ->with('name','addpaying');
    }
    public function newpaying(Request $request)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $paying = new paying();
        $paying->company_id = $employee->company_id;
        $paying->employee_id = $employee->id;
        $paying->username = $request->username;
        $paying->invoice_nu = $request->invoice_nu;
        $paying->amount = $request->amount;
        $paying->u_company_id = $request->u_company_id;
        $paying->details = $request->details;
        $paying->total = $request->total;
        $paying->status = 'created by '.$employee->id.'(employee)';
        $paying->save();
        
        $company = company::select()
            ->where('id',$employee->company_id)
            ->first();
        
        if($request->type == 'print')
        {
            $string = 'paying'.$paying->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'paying'.$paying->id));
            $data = ['pp' => $paying,'company' => $company,'qr' => 'paying'.$paying->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->SetDirectionality('rtl');
            $mpdf->WriteHTML(view('printpaid_paying', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $string = 'paying'.$paying->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'paying'.$paying->id));
            $data = ['pp' => $paying,'company' => $company,'qr' => 'paying'.$paying->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->SetDirectionality('rtl');
            $mpdf->WriteHTML(view('printpaid_paying', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$paying->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);
            Mail::to($request->type)->send(new sendinvoice($paying->id.'-'.$rd.'.pdf',$company->name,$paying->id,$company->email));
        }
        return back();
    }
    public function listpaying()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $paying = paying::select('payings.*','employees.name as employee','sources.name as source')
                ->leftjoin('employees','employees.id','=','payings.employee_id')
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->where('payings.company_id',$company->id)
                ->get();
            return view('paying')
                ->with('payings',$paying)
                ->with('employee','')
                ->with('name','paying');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allpaying == '1')
        {
            $paying = paying::select('payings.*','employees.name as employee','sources.name as source')
                ->leftjoin('employees','employees.id','=','payings.employee_id')
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->where('payings.company_id',$employee->company_id)
                ->get();
        }
        else
        {
            $paying = paying::select('payings.*','employees.name as employee','sources.name as source')
                ->leftjoin('employees','employees.id','=','payings.employee_id')
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->where('payings.company_id',$employee->company_id)
                ->where('payings.employee_id',$employee->id)
                ->get();
        }
        return view('paying')
                    ->with('payings',$paying)
                    ->with('employee',$employee)
                    ->with('name','paying');
    }
    public function editpaying($id)
    {
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        $paying = paying::select('payings.*','employees.name as employee','sources.name as source')
            ->leftjoin('employees','employees.id','=','payings.employee_id')
            ->leftjoin('sources','sources.id','=','payings.u_company_id')
            ->where('payings.id',$id)
            ->first();
        $source = source::select()
            ->where('company_id',$employee->company_id)
            ->get();
        return view('payingedit')
                    ->with('employee',$employee)
                    ->with('paying',$paying)
                    ->with('sources',$source)
                    ->with('name','paying');
    }
    public function updatepaying(Request $request)
    {
        $paying = paying::select()
            ->where('id',$request->id)
            ->first();
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $paying->status = 'edited by '.$company->id.'(company)';
            $employee = employee::select()
                ->where('id',$paying->employee_id)
                ->first();
        }
        else
        {
            $employee = employee::select()
                ->where('email',Auth::User()->email)
                ->first();
            $paying->status = 'edited by '.$employee->id.'(employee)';
            $company = company::select()
                ->where('id',$employee->company_id)
                ->first();
        }
        
        $paying->username = $request->username;
        $paying->invoice_nu = $request->invoice_nu;
        $paying->amount = $request->amount;
        $paying->u_company_id = $request->u_company_id;
        $paying->details = $request->details;
        $paying->total = $request->total;
        $paying->returned_balance_to_passenger = $request->returned_balance_to_passenger;
        $paying->returned_balance_from_source = $request->returned_balance_from_source;
        
        $paying->save();

    
        if($request->type == 'print')
        {
            $string = 'paying'.$paying->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'paying'.$paying->id));
            $data = ['pp' => $paying,'company' => $company,'qr' => 'paying'.$paying->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            $mpdf->SetDirectionality('rtl');
            $mpdf->WriteHTML(view('printpaid_paying', $data)->render());
            return $mpdf->Output('Details.pdf',\Mpdf\Output\Destination::DOWNLOAD);
        }
        else if($request->type != 'save')
        {
            $string = 'paying'.$paying->id.'-'.$company->name;
            \QrCode::size(500)
            ->format('png')
            ->generate($string, public_path('/upload/qr/'.'paying'.$paying->id));
            $data = ['pp' => $paying,'company' => $company,'qr' => 'paying'.$paying->id,'employee' => $employee];
            $mpdf = new \Mpdf\Mpdf();
            $mpdf->autoScriptToLang = true;
            $mpdf->SetDirectionality('rtl');
            $mpdf->autoLangToFont = true;
            $mpdf->WriteHTML(view('printpaid_paying', $data)->render());
            $rd = rand(100000,999999);
            $mpdf->Output('upload/pdf/'.$paying->id.'-'.$rd.'.pdf',\Mpdf\Output\Destination::FILE);
            Mail::to($request->type)->send(new sendinvoice($paying->id.'-'.$rd.'.pdf',$company->name,$paying->id,$company->email));
        }
        return back();
    }
    public function findexpense(Request $request)
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            
            $expenses = expense::select('expenses.*','employees.name as employee')
                ->where('expenses.company_id',$company->id)
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->get();
            
            $findexpense = array();
    
            $from = str_replace('/', '-', $request->from);  
            $to = str_replace('/', '-', $request->to);  
            foreach($expenses as $expense)
            {
                if( ($request->from == '' || $expense->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($from))))&&
                    ($request->to == '' || $expense->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($to))))&&
                    ($request->employee == '' || $request->employee==$expense->employee)&&
                    ($request->id == '' || $request->id==$expense->id)&&
                    ($request->name == '' || $request->name==$expense->name))
                {
                    array_push($findexpense,array(
                        'id' => $expense->id,'created_at' => $expense->created_at,
                        'employee' => $expense->employee,
                        'cost' => $expense->cost,
                        'returned' => $expense->returned,
                        'note' => $expense->note,
                        'name' => $expense->name));
                }
            }
            return view('expensereport')
                ->with('expenses',$findexpense)
                ->with('employee','')
                ->with('name','sourcereport');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allexpenses == '1')
        {
            $expenses = expense::select('expenses.*','employees.name as employee')
                ->where('expenses.company_id',$employee->company_id)
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->get();
        }
        else
        {
            $expenses = expense::select('expenses.*','employees.name as employee')
                ->where('expenses.company_id',$employee->company_id)
                ->where('employee_id',$employee->id)
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->get();
        }
        $findexpense = array();
    
        $from = str_replace('/', '-', $request->from);  
        $to = str_replace('/', '-', $request->to);  
        foreach($expenses as $expense)
        {
            if( ($request->from == '' || $expense->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($from))))&&
                ($request->to == '' || $expense->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($to))))&&
                ($request->employee == '' || $request->employee==$expense->employee)&&
                ($request->id == '' || $request->id==$expense->id)&&
                ($request->name == '' || $request->name==$expense->name))
            {
                array_push($findexpense,array(
                    'id' => $expense->id,'created_at' => $expense->created_at,
                    'employee' => $expense->employee,
                    'cost' => $expense->cost,
                    'returned' => $expense->returned,
                    'note' => $expense->note,
                    'name' => $expense->name));
            }
        }
        return view('expensereport')
            ->with('expenses',$findexpense)
            ->with('employee',$employee)
            ->with('name','sourcereport');

    }
    public function report()
    {
        $result = array();
        if(Auth::User()->permission == 1)
        {
            return view('report')
                    ->with('employee','')
                    ->with('result',$result)
                    ->with('name','report');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        return view('report')
                    ->with('employee',$employee)
                    ->with('result',$result)
                    ->with('name','report');
    }
    public function findreport(Request $request)
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            
            $expenses = expense::select('expenses.*','employees.name as employee')
                ->where('expenses.company_id',$company->id)
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->get();
            $invoices = invoice::select('invoices.*','employees.name as employee')
                ->where('invoices.company_id',$company->id)
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
            $invoice1s = invoice1::select('invoice1s.*','employees.name as employee')
                ->where('invoice1s.company_id',$company->id)
                ->leftjoin('employees','employees.id','=','invoice1s.generator_id')
                ->get();
            $payings = paying::select('payings.*','employees.name as employee')
                ->where('payings.company_id',$company->id)
                ->leftjoin('employees','employees.id','=','payings.employee_id')
                ->get();
            $paids = paid::select('paids.*','employees.name as employee')
                ->where('paids.company_id',$company->id)
                ->leftjoin('employees','employees.id','=','paids.employee_id')
                ->get();
            
            $findreport = array();
    
            $date = str_replace('/', '-', $request->date);  
            foreach($expenses as $one)
            {
                if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                    ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
                {
                    array_push($findreport,array(
                        'id' => $one->id,'created_at' => $one->created_at,
                        'employee' => $one->employee,
                        'type' => 'انشاء فاتورة مصاريف',
                        'name' => $one->name));
                }
            }
            foreach($invoices as $one)
            {
                if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                    ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
                {
                    array_push($findreport,array(
                        'id' => $one->id,'created_at' => $one->created_at,
                        'employee' => $one->employee,
                        'type' => 'انشاء فاتورة المسافر',
                        'name' => $one->name));
                }
            }
            foreach($invoice1s as $one)
            {
                if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                    ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
                {
                    array_push($findreport,array(
                        'id' => $one->id,'created_at' => $one->created_at,
                        'employee' => $one->employee,
                        'type' => 'انشاء فاتورة الشركات',
                        'name' => $one->name));
                }
            }
            foreach($payings as $one)
            {
                if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                    ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
                {
                    array_push($findreport,array(
                        'id' => $one->id,'created_at' => $one->created_at,
                        'employee' => $one->employee,
                        'type' => 'انشاء فاتورة تسديد المصادر',
                        'name' => $one->name));
                }
            }
            foreach($paids as $one)
            {
                if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                    ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
                {
                    array_push($findreport,array(
                        'id' => $one->id,'created_at' => $one->created_at,
                        'employee' => $one->employee,
                        'type' => 'انشاء فاتورة تسديد الشركات',
                        'name' => $one->name));
                }
            }
            return view('report')
                ->with('result',$findreport)
                ->with('employee','')
                ->with('name','report');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allexpenses == '1')
        {
            $expenses = expense::select('expenses.*','employees.name as employee')
                ->where('expenses.company_id',$employee->company_id)
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->get();
        }
        else
        {
            $expenses = expense::select('expenses.*','employees.name as employee')
                ->where('expenses.company_id',$employee->company_id)
                ->where('employee_id',$employee->id)
                ->leftjoin('employees','employees.id','=','expenses.employee_id')
                ->get();
        }
        if($employee->see_allinvoices == '1')
        {
            $invoices = invoice::select('invoices.*','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        else
        {
            $invoices = invoice::select('invoices.*','employees.name as employee')
                ->where('invoices.company_id',$employee->company_id)
                ->where('generator_id',$employee->id)
                ->leftjoin('employees','employees.id','=','invoices.generator_id')
                ->get();
        }
        if($employee->see_allinvoice1s == '1')
        {
            $invoice1s = invoice1::select('invoice1s.*','employees.name as employee')
                ->where('invoice1s.company_id',$employee->company_id)
                ->leftjoin('employees','employees.id','=','invoice1s.generator_id')
                ->get();
        }
        else
        {
            $invoice1s = invoice1::select('invoice1s.*','employees.name as employee')
                ->where('invoice1s.company_id',$employee->company_id)
                ->where('generator_id',$employee->id)
                ->leftjoin('employees','employees.id','=','invoice1s.generator_id')
                ->get();
        }
        if($employee->see_allpayings == '1')
        {
            $payings = paying::select('payings.*','employees.name as employee')
                ->where('payings.company_id',$employee->company_id)
                ->leftjoin('employees','employees.id','=','payings.employee_id')
                ->get();
        }
        else
        {
            $payings = paying::select('payings.*','employees.name as employee')
                ->where('payings.company_id',$employee->company_id)
                ->where('employee_id',$employee->id)
                ->leftjoin('employees','employees.id','=','payings.employee_id')
                ->get();
        }
        if($employee->see_allpaids == '1')
        {
            $paids = paid::select('paids.*','employees.name as employee')
                ->where('paids.company_id',$employee->company_id)
                ->leftjoin('employees','employees.id','=','paids.employee_id')
                ->get();
        }
        else
        {
            $paids = paid::select('paids.*','employees.name as employee')
                ->where('paids.company_id',$employee->company_id)
                ->where('employee_id',$employee->id)
                ->leftjoin('employees','employees.id','=','paids.employee_id')
                ->get();
        }
        $findreport = array();
    
        $date = str_replace('/', '-', $request->date);  
        foreach($expenses as $one)
        {
            if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
            {
                array_push($findreport,array(
                    'id' => $one->id,'created_at' => $one->created_at,
                    'employee' => $one->employee,
                    'type' => 'انشاء فاتورة مصاريف',
                    'name' => $one->name));
            }
        }
        foreach($invoices as $one)
        {
            if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
            {
                array_push($findreport,array(
                    'id' => $one->id,'created_at' => $one->created_at,
                    'employee' => $one->employee,
                    'type' => 'انشاء فاتورة المسافر',
                    'name' => $one->name));
            }
        }
        foreach($invoice1s as $one)
        {
            if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
            {
                array_push($findreport,array(
                    'id' => $one->id,'created_at' => $one->created_at,
                    'employee' => $one->employee,
                    'type' => 'انشاء فاتورة الشركات',
                    'name' => $one->name));
            }
        }
        foreach($payings as $one)
        {
            if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
            {
                array_push($findreport,array(
                    'id' => $one->id,'created_at' => $one->created_at,
                    'employee' => $one->employee,
                    'type' => 'انشاء فاتورة تسديد المصادر',
                    'name' => $one->name));
            }
        }
        foreach($paids as $one)
        {
            if( ($one->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($date))))&&
                ($one->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($date)))))
            {
                array_push($findreport,array(
                    'id' => $one->id,'created_at' => $one->created_at,
                    'employee' => $one->employee,
                    'type' => 'انشاء فاتورة تسديد الشركات',
                    'name' => $one->name));
            }
        }
        return view('report')
            ->with('result',$findreport)
            ->with('employee',$employee)
            ->with('name','report');

    }
    public function pay()
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            $paid = paid::select('paids.*','ucompanies.name as ucompany')
                ->where('paids.company_id',$company->id)
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->get();
            $paying = paying::select('payings.*','sources.name as ucompany')
                ->where('payings.company_id',$company->id)
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->get();
            return view('pay')
                ->with('paids',$paid)
                ->with('payings',$paying)
                ->with('employee','')
                ->with('name','pay');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allpaids == '1')
        {
            $paid = paid::select('paids.*','ucompanies.name as ucompany')
                ->where('paids.company_id',$employee->company_id)
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->get();
        }
        else
        {
            $paid = paid::select('paids.*','ucompanies.name as ucompany')
                ->where('paids.company_id',$employee->company_id)
                ->where('paids.employee_id',$employee->id)
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->get();
        }
        if($employee->see_allpayings == '1')
        {
            $paying = paying::select('payings.*','sources.name as ucompany')
                ->where('payings.company_id',$employee->company_id)
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->get();
        }
        else
        {
            $paying = paying::select('payings.*','sources.name as ucompany')
                ->where('payings.company_id',$employee->company_id)
                ->where('payings.employee_id',$employee->id)
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->get();
        }
        return view('pay')
                    ->with('employee',$employee)
                    ->with('paids',$paid)
                    ->with('payings',$paying)
                    ->with('name','pay');
    }
    public function findpay(Request $request)
    {
        if(Auth::User()->permission == 1)
        {
            $company = company::select()
                ->where('email',Auth::User()->email)
                ->first();
            
            $paids = paid::select('paids.*','ucompanies.name as ucompany')
                ->where('paids.company_id',$company->id)
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->get();
            $payings = paying::select('payings.*','sources.name as ucompany')
                ->where('payings.company_id',$company->id)
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->get();
            
            $findpaid = array();
    
            $from = str_replace('/', '-', $request->from);  
            $to = str_replace('/', '-', $request->to);  
            foreach($paids as $paid)
            {
                if( ($request->from == '' || $paid->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($from))))&&
                    ($request->to == '' || $paid->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($to))))&&
                    ($request->total == '' || $request->total==$paid->amount)&&
                    ($request->return == '' || $request->return==$paid->returned_balance_from_source)&&
                    ($request->total_return == '' || $request->total_return==($paid->amount - $paid->returned_balance_from_source)))
                {
                    array_push($findpaid,array(
                        'id' => $paid->id,'created_at' => $paid->created_at,
                        'ucompany' => $paid->ucompany,
                        'invoice_nu' => $paid->invoice_nu,
                        'amount' => $paid->amount,
                        'returned_balance_from_source' => $paid->returned_balance_from_source,
                        'details' => $paid->details));
                }
            }
            $findpaying = array();
    
            $from = str_replace('/', '-', $request->from);  
            $to = str_replace('/', '-', $request->to);  
            foreach($payings as $paying)
            {
                if( ($request->from == '' || $paying->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($from))))&&
                    ($request->to == '' || $paying->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($to))))&&
                    ($request->total == '' || $request->total==$paying->amount)&&
                    ($request->return == '' || $request->return==$paying->returned_balance_from_source)&&
                    ($request->total_return == '' || $request->total_return==($paying->amount - $paying->returned_balance_from_source)))
                {
                    array_push($findpaying,array(
                        'id' => $paying->id,'created_at' => $paying->created_at,
                        'ucompany' => $paying->ucompany,
                        'invoice_nu' => $paying->invoice_nu,
                        'amount' => $paying->amount,
                        'returned_balance_from_source' => $paying->returned_balance_from_source,
                        'details' => $paying->details));
                }
            }
            return view('pay')
                ->with('paids',$findpaid)
                ->with('payings',$findpaying)
                ->with('employee','')
                ->with('name','pay');
        }
        $employee = employee::select()
            ->where('email',Auth::User()->email)
            ->first();
        if($employee->see_allpaids == '1')
        {
            $paids = paid::select('paids.*','ucompanies.name as ucompany')
                ->where('paids.company_id',$employee->company_id)
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->get();
        }
        else
        {
            $paids = paid::select('paids.*','ucompanies.name as ucompany')
                ->where('paids.company_id',$employee->company_id)
                ->where('paids.employee_id',$employee->id)
                ->leftjoin('ucompanies','ucompanies.id','=','paids.u_company_id')
                ->get();
        }
        if($employee->see_allpayings == '1')
        {
            $payings = paying::select('payings.*','sources.name as ucompany')
                ->where('payings.company_id',$employee->company_id)
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->get();
        }
        else
        {
            $payings = paying::select('payings.*','sources.name as ucompany')
                ->where('payings.company_id',$employee->company_id)
                ->where('payings.employee_id',$employee->id)
                ->leftjoin('sources','sources.id','=','payings.u_company_id')
                ->get();
        }
        $findpaid = array();
    
        $from = str_replace('/', '-', $request->from);  
        $to = str_replace('/', '-', $request->to);  
        foreach($paids as $paid)
        {
            if( ($request->from == '' || $paid->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($from))))&&
                ($request->to == '' || $paid->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($to))))&&
                ($request->total == '' || $request->total==$paid->amount)&&
                ($request->return == '' || $request->return==$paid->returned_balance_from_source)&&
                ($request->total_return == '' || $request->total_return==($paid->amount - $paid->returned_balance_from_source)))
            {
                array_push($findpaid,array(
                    'id' => $paid->id,'created_at' => $paid->created_at,
                    'ucompany' => $paid->ucompany,
                    'invoice_nu' => $paid->invoice_nu,
                    'amount' => $paid->amount,
                    'returned_balance_from_source' => $paid->returned_balance_from_source,
                    'details' => $paid->details));
            }
        }
        $findpaying = array();

        $from = str_replace('/', '-', $request->from);  
        $to = str_replace('/', '-', $request->to);  
        foreach($payings as $paying)
        {
            if( ($request->from == '' || $paying->created_at > date('Y-m-d 23:59:59', strtotime('-1 day', strtotime($from))))&&
                ($request->to == '' || $paying->created_at < date('Y-m-d 00:00:00', strtotime('+1 day', strtotime($to))))&&
                ($request->total == '' || $request->total==$paying->amount)&&
                ($request->return == '' || $request->return==$paying->returned_balance_from_source)&&
                ($request->total_return == '' || $request->total_return==($paying->amount - $paying->returned_balance_from_source)))
            {
                array_push($findpaying,array(
                    'id' => $paying->id,'created_at' => $paying->created_at,
                    'ucompany' => $paying->ucompany,
                    'invoice_nu' => $paying->invoice_nu,
                    'amount' => $paying->amount,
                    'returned_balance_from_source' => $paying->returned_balance_from_source,
                    'details' => $paying->details));
            }
        }
        return view('pay')
                    ->with('employee',$employee)
                    ->with('paids',$findpaid)
                    ->with('payings',$findpaying)
                    ->with('name','pay');
    }
}
