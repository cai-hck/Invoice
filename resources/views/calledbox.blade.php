@extends('layouts.app')

@section('css')
<style>
.adult-block .invoice-adult.invoice-no input {
    max-width: 150px;
}
</style>
@endsection
@section('content')
<section id="main" class="float-left w-100">
    <article class="article" id="source_report">
        <h3 class="tab-content-title  bg-primary text-white">الصندوق</h3>
        <div class="header-form">
            <div class="header-form_inner float-left w-100">
                <form action="{{url('find')}}" method="POST">
                    @csrf
                    <input type="hidden" value="calledbox" name="type">
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
                        <input type="text" name="source" class="source">
                        <label for=""> المصدر </label>
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
                        <input type="text" name="et" class="source">
                        <label for="">رقم التذكره</label>
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
        <div class="invoice-form">
            <div class="input-group form-group ">
                <h6 class="adult-title">مجموع المسافرين</h6>
                <div class="adult-block">
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">البالغ</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['adult_no'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">الطفل</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['child_no'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">الرضيع</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['infant_no'];} echo $sum;?>" class="form-control" readonly>
                </div>
                </div>
                <h6 class="adult-title">مجموع سعر البيع</h6>
                <div class="adult-block">
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">البالغ</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['adult_no'] * $invoice['adult_sell'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">الطفل</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['child_no'] * $invoice['child_sell'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">الرضيع</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['infant_no'] * $invoice['infant_sell'];} echo $sum;?>" class="form-control" readonly>
                </div>
                </div>
                <h6 class="adult-title">مجموع سعر الشراء</h6>
                <div class="adult-block">
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">البالغ</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['adult_no'] * $invoice['adult_buy'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">الطفل</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['child_no'] * $invoice['child_buy'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">الرضيع</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['infant_no'] * $invoice['infant_buy'];} echo $sum;?>" class="form-control" readonly>
                </div>
                </div>
                <h6 class="adult-title">مجموع سعر الفير</h6>
                <div class="adult-block">
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">البالغ</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['adult_no'] * $invoice['adult_fair'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">الطفل</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['child_no'] * $invoice['child_fair'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">الرضيع</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += $invoice['infant_no'] * $invoice['infant_fair'];} echo $sum;?>" class="form-control" readonly>
                </div>
                </div>
                <h6 class="adult-title">مجموع</h6>
                <div class="adult-block">
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">سعر البيع</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += ($invoice['adult_no'] * $invoice['adult_sell'] + $invoice['child_no'] * $invoice['child_sell'] + $invoice['infant_no'] * $invoice['infant_sell']);} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">سعر الشراء</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += ($invoice['adult_no'] * $invoice['adult_buy'] + $invoice['child_no'] * $invoice['child_buy'] + $invoice['infant_no'] * $invoice['infant_buy']);} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no">
                    <div class="input-group-prepend ">
                        <span class="input-group-text">سعر الفير</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += ($invoice['adult_no'] * $invoice['infant_fair'] + $invoice['child_no'] * $invoice['infant_fair'] + $invoice['infant_no'] * $invoice['infant_fair']);} echo $sum;?>" class="form-control" readonly>
                </div>
                </div>
                <div class="adult-block">
                <div class="invoice-adult invoice-no" style="width:50%">
                    <div class="input-group-prepend " style="max-width:250px">
                        <span class="input-group-text">مجموع أرباح المسافر</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += ($invoice['adult_no'] * $invoice['adult_sell'] + $invoice['child_no'] * $invoice['child_sell'] + $invoice['infant_no'] * $invoice['infant_sell'])* $invoice['comission_passenger'];} echo $sum;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no" style="width:50%">
                    <div class="input-group-prepend "  style="max-width:250px">
                        <span class="input-group-text">مجموع أرباح المصدر</span>
                    </div>
                    <input type="number" value="<?php $sum = 0;foreach($invoices  as $invoice){$sum += ($invoice['adult_no'] * $invoice['infant_fair'] + $invoice['child_no'] * $invoice['infant_fair'] + $invoice['infant_no'] * $invoice['infant_fair'])* $invoice['comission_source'];} echo $sum;?>" class="form-control" readonly>
                </div>
                </div>
                <div class="adult-block">
                <div class="invoice-adult invoice-no" style="width:50%">
                    <div class="input-group-prepend " style="max-width:250px">
                        <span class="input-group-text">صندوق المسافر</span>
                    </div>
                    <input type="number" value="<?php $sum1 = 0;foreach($invoices  as $invoice){$sum1 += ($invoice['adult_no'] * $invoice['adult_sell'] + $invoice['child_no'] * $invoice['child_sell'] + $invoice['infant_no'] * $invoice['infant_sell'])* (1 - $invoice['comission_passenger']);} echo $sum1;?>" class="form-control" readonly>
                </div>
                <div class="invoice-adult invoice-no" style="width:50%">
                    <div class="input-group-prepend "  style="max-width:250px">
                        <span class="input-group-text">صندوق المصدر</span>
                    </div>
                    <input type="number" value="<?php $sum2 = 0;foreach($invoices  as $invoice){$sum2 += (($invoice['adult_no'] * $invoice['adult_buy'] + $invoice['child_no'] * $invoice['child_buy'] + $invoice['infant_no'] * $invoice['infant_buy']) - ($invoice['adult_no'] * $invoice['infant_fair'] + $invoice['child_no'] * $invoice['infant_fair'] + $invoice['infant_no'] * $invoice['infant_fair'])* $invoice['comission_source']);} echo $sum2;?>" class="form-control" readonly>
                </div>
                </div>
                <div class="adult-block">
                <div class="invoice-adult invoice-no" style="width:50%">
                    <div class="input-group-prepend " style="max-width:250px">
                        <span class="input-group-text">مجموع صندوق الأرباح</span>
                    </div>
                    <input type="number" value="<?php echo $sum1 - $sum2;?>" class="form-control" readonly>
                </div>
                </div>
            </div>
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