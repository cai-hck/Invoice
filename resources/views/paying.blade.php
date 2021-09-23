@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>صندوق فواتير تسديد المصادر</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <div class="input-group form-group" style="padding-buttom:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">رقم الفاتورة</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">رقم الوصل</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">اسم الشركة</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">التفاصيل</span>
                            </div>
                            <?php $i=0 ; foreach($payings as $paying){ $i++;}?>
                            <?php if($i >0 && ($employee->edit_payings || $employee->delete_payings) ){?>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            </div>
                            <?php }?>
                        </div>
                    </div>
                    <?php foreach($payings as $paying){?>
                    <div class="input-group form-group"  style="padding-top:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paying->id}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paying->invoice_nu}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paying->source}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$paying->details}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            <?php if(Auth::user()->permission == 1){?>
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editpaying/'.$paying->id)}}">تعديل</a>
                                <a class="btn btn-danger" style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delpaying/'.$paying->id)}}">حذف</a>
                            <?php }else {
                                if($employee->edit_payings){?>
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editpaying/'.$paying->id)}}">تعديل</a>
                            <?php }
                                if($employee->delete_payings){?>
                                <a class="btn btn-danger" style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delpaying/'.$paying->id)}}">حذف</a>
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