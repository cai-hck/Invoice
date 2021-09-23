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
                <form action="{{url('findexpense')}}" method="POST">
                    @csrf
                    <input type="hidden" value="debt" name="type">
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
                        <input type="number" name="id" class="pnr-code" >
                        <label class="label2" for=""> رقم الفاتورة</label>
                    </div>
                    </div>   
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text"  name="employee" class="source">
                        <label for="">اسم موظف اصدار الفاتوره</label>
                    </div>
                    </div>   
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text"  name="name" class="pnr-code ">
                        <label for="">اسم المسافر</label>
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
                <th scope="col">التاريخ</th>
                <th scope="col">اسم موظف اصدار الفاتوره</th>
                <th scope="col">اسم المسافر </th>
                <th scope="col">المبلغ</th>
                <th scope="col">المبلغ المسترجع</th>
                <th scope="col">ملاحظات</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($expenses as $expense){?>
                <tr>
                    <td>{{$expense['id']}}</td>
                    <td>{{$expense['created_at']}}</td>
                    <td>{{$expense['employee']}}</td>
                    <td>{{$expense['name']}}</td>
                    <td>{{$expense['cost']}}</td>
                    <td>{{$expense['returned']}}</td>
                    <td>{{$expense['note']}}</td>
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