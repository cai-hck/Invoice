@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>صندوق مبيعات فواتير الزبائن</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <div class="input-group form-group" style="padding-buttom:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">اسم المسافر </span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text"> رقم الفاتورة</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">رقم التلفون</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">ملاحظات</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">PRN/Passport</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">رقم التذكره</span>
                            </div>
                            <?php $i=0 ; foreach($invoices as $invoice){ $i++;}?>
                            <?php if($i>0 && ($employee->edit_invoices || $employee->delete_invoices)){?>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            </div>
                            <?php }?>
                        </div>
                    </div>  
                    <?php foreach($invoices as $invoice){?>
                    <div class="input-group form-group"  style="padding-top:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$invoice->name}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$invoice->id}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$invoice->phone}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$invoice->note}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$invoice->passport}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$invoice->et}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:#f7f7f7;">
                            <?php if(Auth::user()->permission == 1){?>
                                <a class="btn btn-success" style="width:50%" href="{{ url('/editinvoice/'.$invoice->id)}}">تعديل</a>
                                <a class="btn btn-danger"  style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delinvoice/'.$invoice->id)}}">حذف</a>
                            <?php }else{
                                if($employee->edit_invoices){?>
                                    <a class="btn btn-success" style="width:50%" href="{{ url('/editinvoice/'.$invoice->id)}}">تعديل</a>
                                <?php }
                                if($employee->delete_invoices){?>
                                    <a class="btn btn-danger"  style="width:50%" onclick="return confirm('قم بتأكيد الحذف?')" href="{{ url('/delinvoice/'.$invoice->id)}}">حذف</a>
                                <?php }
                                }?>
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