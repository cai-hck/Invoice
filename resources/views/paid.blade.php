@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>صندوق فواتير تسديد الشركات</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <div class="input-group form-group" style="padding-buttom:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 1px">
                                <span class="input-group-text">رقم الفاتورة</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px">
                                <span class="input-group-text">رقم الوصل</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px">
                                <span class="input-group-text">اسم الشركة</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px">
                                <span class="input-group-text">ملاحظات</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px">
                                <span class="input-group-text">مجموع الرصيد</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px">
                                <span class="input-group-text">مجموع استرجاع الرصيد </span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px">
                                <span class="input-group-text">مجموع الرصيد النهائي  </span>
                            </div>
                            <?php $i=0 ; foreach($paids as $paid){ $i++;}?>
                            <?php if($i >0 && ($employee->edit_paids || $employee->delete_paids) ){?>
                            <div class="input-group-prepend " style="margin:1px 1px;background:#f7f7f7;">
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php foreach($paids as $paid){?>
                    <div class="input-group form-group"  style="padding-top:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 1px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paid->id}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paid->invoice_nu}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paid->ucompany}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paid->details}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paid->amount}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paid->returned_balance_from_source}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paid->amount - $paid->returned_balance_from_source}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 1px;background:#f7f7f7;">
                            <?php if(Auth::user()->permission == 1){?>
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editpaid/'.$paid->id)}}">تعديل</a>
                                <a class="btn btn-danger" style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delpaid/'.$paid->id)}}">حذف</a>
                            <?php }else {
                                if($employee->edit_paids){?>
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editpaid/'.$paid->id)}}">تعديل</a>
                            <?php }
                                if($employee->delete_paids){?>
                                <a class="btn btn-danger" style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delpaid/'.$paid->id)}}">حذف</a>
                            <?php }}?>
                            </div>
                        </div>
                    </div>
                    <?php }?>
                </div>
            </div>
        </div>
    </article>
</section>
@endsection

@section('js')
<script>

</script>
@endsection