@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main" class="float-left w-100">
    <article class="article" id="source_report">
        <h3 class="tab-content-title  bg-primary text-white">الدين</h3>
        <div class="header-form">
            <div class="header-form_inner float-left w-100">
                <form action="{{url('findpay')}}" method="POST">
                    @csrf
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text"  name="from" class="date_from" placeholder="dd/mm/yyyy">
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
                        <input type="number" name="total" class="pnr-code" >
                        <label class="label2" for="">مجموع الرصيد </label>
                    </div>
                    </div>   
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text"  name="return" class="source">
                        <label for="">مجموع استرجاع الرصيد </label>
                    </div>
                    </div>   
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text"  name="total_return" class="pnr-code ">
                        <label for="">مجموع الرصيد النهائي </label>
                    </div>
                    </div>     
                    <div class="header-form_input">
                     <div class="table-buttons-group float-left w-100 d-flex justify-content-between" style="margin:0;">
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
                <th scope="col">اسم الشركة</th>
                <th scope="col">رقم الوصل</th>
                <th scope="col">الرصيد</th>
                <th scope="col">استرجاع الرصيد من الشركة</th>
                <th scope="col">المجموع النهائي</th>
                <th scope="col">الملاحظات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($paids as $paid){?>
                <tr>
                    <td>{{$paid['id']}}</td>
                    <td>{{$paid['ucompany']}}</td>
                    <td>{{$paid['invoice_nu']}}</td>
                    <td>{{$paid['amount']}}</td>
                    <td>{{$paid['returned_balance_from_source']}}</td>
                    <td>{{ $paid['amount'] - $paid['returned_balance_from_source']}}</td>
                    <td>{{$paid['details']}}</td>
                </tr>
                <?php }?>
            </tbody>
            </table>
        </div>
        <div class="table">
            <table class="table">
            <thead>
                <tr>
                <th scope="col">رقم الفاتورة</th>
                <th scope="col">المصدر </th>
                <th scope="col">رقم الوصل</th>
                <th scope="col">الرصيد</th>
                <th scope="col">استرجاع الرصيد من الشركة</th>
                <th scope="col">المجموع النهائي</th>
                <th scope="col">الملاحظات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($payings as $paying){?>
                <tr>
                    <td>{{$paying['id']}}</td>
                    <td>{{$paying['ucompany']}}</td>
                    <td>{{$paying['invoice_nu']}}</td>
                    <td>{{$paying['amount']}}</td>
                    <td>{{$paying['returned_balance_from_source']}}</td>
                    <td>{{ $paying['amount'] - $paying['returned_balance_from_source']}}</td>
                    <td>{{$paying['details']}}</td>
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