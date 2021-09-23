@extends('layouts.app')

@section('css')
<style>

</style>
@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>تنبيهات اليوم</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <div class="input-group form-group" style="padding-buttom:0px">
                        <div class="invoice-name invoice-no">
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">اسم المسافر </span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">رقم الفاتورة</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">رقم الهاتف</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">المصدر</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px">
                                <span class="input-group-text">Passport/PRN</span>
                            </div>
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
                                <span class="input-group-text" style="color:black;">{{$invoice->source}}</span>
                            </div>
                            <div class="input-group-prepend " style="margin:1px 10px;background:white;">
                                <span class="input-group-text" style="color:black;">{{$invoice->passport}}</span>
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