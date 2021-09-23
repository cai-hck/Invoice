@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main" class="float-left w-100">
    <article class="article" id="source_report">
        <h3 class="tab-content-title  bg-primary text-white">كشف المبيعات</h3>
        <div class="header-form">
            <div class="header-form_inner float-left w-100">
                <form action="{{url('find')}}" method="POST">
                    @csrf
                    <input type="hidden" value="invoicereport" name="type">
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text" name="from" class="date_from" placeholder="dd/mm/yyyy">
                        <label class="label2" for="">من</label>    
                    </div>
                    </div>
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text" name="to" placeholder="dd/mm/yyyy" class="date_from">
                        <label class="label2" for=""> الى</label>
                    </div>
                    </div>
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="number" name="id" class="pnr-code" >
                        <label class="label2" for=""> رقم الفاتورة</label>
                    </div>
                    </div>   
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <label for=""> المصدر </label>
                        <select name="source" class="source">
                            <option value=""></option>
                            <?php foreach($sources as $source){?>
                                <option value="{{$source->name}}">{{$source->name}}</option>
                            <?php }?>
                        </select>
                    </div>
                    </div>      
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text"  name="passport" class="pnr-code">
                        <label for="">Passport/PRN</label>
                    </div>
                    </div>
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <label for="">الخطوط الجوية</label>
                        <select name="airline" class="source">
                            <option value=""></option>
                            <?php foreach($airlines as $airline){?>
                                <option value="{{$airline->name}}">{{$airline->name}}</option>
                            <?php }?>
                        </select>
                    </div>
                    </div>  
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text" name="et" class="source">
                        <label for="">رقم التذكره</label>
                    </div>
                    </div>  
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text" name="name" class="source">
                        <label for="">اسم المسافر</label>
                    </div>
                    </div>      
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text"  name="phone" class="pnr-code">
                        <label for="">رقم التلفون</label>
                    </div>
                    </div>
                    <div class="header-form_input">
                     <div class="header_form_input_inner table-buttons-group float-left w-100 d-flex justify-content-between" style="margin:0;">
                        <button class="btn btn-success" type="submit" style="background-color:#175593;">Filter</button>
                    </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="table">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">رقم الفاتورة</th>
                <th scope="col">التاريخ</th>
                <th scope="col">اسم موظف اصدار الفاتوره</th>
                <th scope="col">اسم المسافر </th>
                <th scope="col">مجموع البيع</th>
                <th scope="col">مجموع الشراء</th>
                <th scope="col">مجموع الفير</th>
                <th scope="col">المصدر</th>
                <th scope="col">عمولة المصدر</th>
                <th scope="col">عمولة تخفيض المسافر %</th>
                <th scope="col">الصندوق </th>
                <th scope="col">الباقي </th>
                <th scope="col">PRN/Passport</th>
                <th scope="col">الخطوط الجوية</th>
                <th scope="col">رقم التذكره</th>
                <th scope="col">أسترجاع الرصيد من المصدر</th>
                <th scope="col">أسترجاع الرصيد الى المسافر</th>
                <th scope="col">رقم التلفون</th>
                <th scope="col">التفاصيل</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($invoices as $invoice){?>
                <tr>
                    <td>{{$invoice['id']}}</td>
                    <td>{{$invoice['created_at']}}</td>
                    <td>{{$invoice['employee']}}</td>
                    <td>{{$invoice['name']}}</td>
                    <td>{{$invoice['adult_no']*$invoice['adult_sell'] + $invoice['child_no']*$invoice['child_sell'] + $invoice['infant_no']*$invoice['infant_sell']}}</td>
                    <td>{{$invoice['adult_no']*$invoice['adult_buy'] + $invoice['child_no']*$invoice['child_buy'] + $invoice['infant_no']*$invoice['infant_buy']}}</td>
                    <td>{{$invoice['adult_no']*$invoice['adult_fair'] + $invoice['child_no']*$invoice['child_fair']}}</td>
                    <td>{{$invoice['source']}}</td>
                    <td>{{$invoice['comission_source']}}</td>
                    <td>{{$invoice['comission_passenger']}}</td>
                    <td>{{$invoice['paid']}}</td>
                    <td>{{$invoice['to_pay'] - $invoice['paid']}}</td>
                    <td>{{$invoice['passport']}}</td>
                    <td>{{$invoice['airline']}}</td>
                    <td>{{$invoice['et']}}</td>
                    <td>{{$invoice['returned_balance_from_source']}}</td>
                    <td>{{$invoice['returned_balance_to_passenger']}}</td>
                    <td>{{$invoice['phone']}}</td>
                    <td>{{$invoice['details']}}</td>
                </tr>
                <?php }?>
            </tbody>
            </table>
        </div>
        <div class="table-buttons-group float-left w-100 d-flex justify-content-between" style="display:none!important">
            <button class="btn btn-success"> previous </button> 
            <button class="btn btn-success"> Print </button>
            <button class="btn btn-success"> Next </button>
        </div>
    </article>
</section>
@endsection

@section('js')
<script>

</script>
@endsection