@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main" class="float-left w-100">
    <article class="article" id="source_report">
        <h3 class="tab-content-title  bg-primary text-white">التقارير</h3>
        <div class="header-form">
            <div class="header-form_inner float-left w-100">
                <form action="{{url('findreport')}}" method="POST">
                    @csrf
                    <input type="hidden" value="debt" name="type">
                    <div class="header-form_input">
                    <div class="header_form_input_inner d-flex flex-row justify-content-end">
                        <input type="text"  name="date" class="date_from" placeholder="dd/mm/yyyy" required>
                        <label class="label2" for="">من</label>    
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
                <th scope="col">نوع الفاتورة </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($result as $one){?>
                <tr>
                    <td>{{$one['id']}}</td>
                    <td>{{$one['created_at']}}</td>
                    <td>{{$one['employee']}}</td>
                    <td>{{$one['name']}}</td>
                    <td>{{$one['type']}}</td>
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