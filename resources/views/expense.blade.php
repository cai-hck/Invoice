@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>قائمة المصاريف </h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <div class="input-group form-group" style="padding-buttom:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">رقم الفاتورة</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">ملاحظات</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">المبلغ</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">المبلغ المسترجع</span>
                            </div>
                            <?php $i=0 ; foreach($expenses as $expense){ $i++;}?>
                            <?php if($i >0 && ($employee->edit_expenses || $employee->delete_expenses) ){?>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php foreach($expenses as $expense){?>
                    <div class="input-group form-group"  style="padding-top:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$expense->id}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$expense->note}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$expense->cost}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$expense->returned}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            <?php if(Auth::user()->permission == 1){?>
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editexpense/'.$expense->id)}}">تعديل</a>
                                <a class="btn btn-danger" style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delexpense/'.$expense->id)}}">حذف</a>
                            <?php }else {
                                if($employee->edit_expenses){?>
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editexpense/'.$expense->id)}}">تعديل</a>
                            <?php }
                                if($employee->delete_expenses){?>
                                <a class="btn btn-danger" style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delexpense/'.$expense->id)}}">حذف</a>
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