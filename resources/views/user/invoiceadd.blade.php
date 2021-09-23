@extends('layouts.app')

@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>إنشاء فاتورة جديدة</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <form method="POST" action="{{url('newinvoice')}}" name="invoice_form" class="" id="invoice_form">
                        @csrf
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">اسم المسافر </span>
                                </div>
                                <input type="text" name="name" aria-label="Name of passenger" class="form-control" placeholder="" >
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-details invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">التفاصيل</span>
                                </div>
                                <input type="text" name="details" aria-label="Details" class="form-control" placeholder="" >
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-passenger invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عدد البالغين</span>
                            </div>
                            <input type="number" aria-label="Adult No" name="adult_no" class="form-control priceinput"  min="0" required style="max-width:250px">
                            </div>
                            <div class="invoice-passenger invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عدد الأطفال</span>
                            </div>
                            <input type="number" aria-label="Child No" name="child_no" class="form-control priceinput"  min="0"  style="max-width:250px">
                            </div>
                            <div class="invoice-passenger invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عدد الرضع</span>
                            </div>
                            <input type="number" aria-label="Infant No" name="infant_no" class="form-control priceinput"  min="0"  style="max-width:250px" >
                            </div>

                        </div>
                        <h6 class="adult-title">سعر البالغ</h6>
                        <div class="input-group form-group ">
                            
                            <div class="adult-block">
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر البيع</span>
                                </div>
                                <input type="number" aria-label="Sell" name="adult_sell" class="form-control priceinput"  min="0" required>
                            </div>
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر الشراء</span>
                                </div>
                                <input type="number" aria-label="Buy" name="adult_buy" class="form-control priceinput"  min="0" required>
                            </div>
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر الفير</span>
                                </div>
                                <input type="number" aria-label="Fare" name="adult_fair" class="form-control priceinput"  min="0" >
                            </div>
                            </div>
                        </div>
                        <h6 class="adult-title">سعر الطفل</h6>
                        <div class="input-group form-group ">
                            
                            <div class="adult-block">
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر البيع</span>
                                </div>
                                <input type="number" aria-label="Sell" name="child_sell" class="form-control priceinput"  min="0" >
                            </div>
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر الشراء</span>
                                </div>
                                <input type="number" aria-label="Buy" name="child_buy" class="form-control priceinput"  min="0" >
                            </div>
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر الفير</span>
                                </div>
                                <input type="number" aria-label="Fare" name="child_fair" class="form-control priceinput"  min="0" >
                            </div>
                            </div>
                        </div>
                        <h6 class="adult-title">سعر الرضيع</h6>
                        <div class="input-group form-group ">
                        
                            <div class="adult-block">
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر البيع</span>
                                </div>
                                <input type="number" aria-label="Sell" name="infant_sell" class="form-control priceinput"  min="0" >
                            </div>
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر الشراء</span>
                                </div>
                                <input type="number" aria-label="Buy" name="infant_buy" class="form-control priceinput"  min="0" >
                            </div>
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">سعر الفير</span>
                                </div>
                                <input type="number" aria-label="Buy" name="infant_fair" class="form-control priceinput"  min="0" >
                            </div>
                            </div>
                            <div class="adult-block">
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">مجموع البيع</span>
                                </div>
                                <input type="text" aria-label="Sell" class="form-control"  readonly id="totalsell">
                            </div>
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">مجموع الشراء</span>
                                </div>
                                <input type="text" aria-label="Buy" class="form-control"  readonly id="totalbuy">
                            </div>
                            <div class="invoice-adult invoice-no">
                                <div class="input-group-prepend ">
                                    <span class="input-group-text">مجموع الفير </span>
                                </div>
                                <input type="text" aria-label="Fare" class="form-control"  readonly id="totalfair">
                            </div>
                            </div>
                        </div>
                        <div class="input-group form-group d-flex date-no">
                            <div class="airline-code invoice-no d-flex">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">المصدر</span>
                                </div>
                                <select class="form-control" id="source" name="source_id">
                                    <?php foreach($sources as $source){?>
                                        <option value="{{$source->id}}">{{$source->name}}</option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class="invoice-reduce invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عمولة المصدر ٪</span>
                                </div>
                                <input type="number"step="0.001" name="comission_source" aria-label="Source Comission" class="form-control priceinput"   min="0"  max="1" >
                            </div>
                        </div>
                        <div class="input-group form-group d-flex date-no">
                            <div class="invoice-reduce invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">عمولة تخفيض المسافر %</span>
                                </div>
                                <input type="number" step="0.001" name="comission_passenger" aria-label="Reduce P Comission" class="form-control priceinput"   min="0"  max="1" >
                            </div>
                            <div class="invoice-passenger-phone invoice-no d-flex">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">رقم التلفون</span>
                                </div>
                                <input type="text"  name="phone" aria-label="Passenger phone" class="form-control" placeholder="" >
                            </div>
                        </div>
                        <div class="input-group form-group d-flex date-no">
                            <div class="pnr-passport invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">رقم الجواز  أو  PNR</span>
                                </div>
                                <input type="text" name="passport" aria-label="PNR/Passport" class="form-control" placeholder="" required>
                            </div>
                            <div class="invoice-travel-date invoice-no d-flex">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">رقم التذكره</span>
                                </div>
                                <input type="text"  name="et" aria-label="ET" class="form-control" placeholder=""   style="max-width:100%">
                            </div>
                        </div>
                        <div class="input-group form-group d-flex date-no">
                            <div class="invoice-travel-date invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">تاريخ السفر</span>
                                </div>
                                <input type="text" name="date_travel" placeholder="dd/mm/yyyy" class="date_from" value="<?php echo date('d/m/Y');?>" >
                            </div>
                            <div class="airline-code invoice-no d-flex">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">الخطوط الجوية</span>
                                </div>
                                <select class="form-control" id="airline_code"  name="airline_id">
                                    <?php foreach($airlines as $airline){?>
                                        <option value="{{$airline->id}}">{{$airline->name}}</option>
                                    <?php }?>
                                </select>
                            </div>
                            
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-to-pay invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">واصل</span>
                                </div>
                                <input type="number" name="to_pay" aria-label="To pay" class="form-control" placeholder="المبلغ" >
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-notes invoice-no d-flex">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">الملاحظات ؟</span>
                                </div>
                                <input type="text" name="note" aria-label="Notes" class="form-control" placeholder="" >
                            </div>
                        </div>


                        <div class="form-group Comission-block " style="display:none;">
                            <div class="Comission-block-inner">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">أرباح المصدر</span>
                            </div>
                            <input type="number" aria-label="Comission Profit" class="form-control" placeholder="المبلغ" id="comission_profit" readonly>
                            </div>
                            <div class="Comission-block-inner">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">أرباح المسافر</span>
                            </div>
                            <input type="number" aria-label="Passenger Profit" class="form-control" placeholder="المبلغ" id="passenger_profit" readonly>
                            </div>
                            <div class="Comission-block-inner"  style="display:none">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">صندوق الارباح</span>
                            </div>
                            <input type="number" aria-label="Profit" class="form-control" placeholder="المبلغ" id="profit" readonly>
                            </div>
                            <div class="Comission-block-inner" >
                            <div class="input-group-prepend ">
                                <span class="input-group-text">صندوق المسافر</span>
                            </div>
                            <input type="number" aria-label="Total pay to Source" class="form-control" placeholder="المبلغ" id="total_pay_to_source" readonly >
                            </div>
                            <div class="Comission-block-inner">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">صندوق المصدر</span>
                            </div>
                            <input type="number" aria-label="Debt of Source" class="form-control" placeholder="المبلغ" id="debt_of_source" readonly>
                            </div>
                        </div>
                        <div class="form-group custom-btn"> 
                            <button type="submit" id="buttonprint" class="btn btn-success">اصدار / طباعة</button>
                            <button type="submit" id="buttonsave" class="btn btn-success">اصدار / حفظ</button>
                            <button type="submit" id="buttonemail"class="btn btn-success">ارسال البريد الإلكتروني / حفظ</button>
                        </div>
                        <input type="hidden" id="modaltype" name="type">
                    </form>
                </div>
            </div>
        </div>
    </article>
</section>
<div class="modal fade" id="sendemailmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
        <div class="modal-header send-mail">
            <h5 class="modal-title" id="exampleModalScrollableTitle">إرسال إلى ايميل</h5>
        </div>
        <form class="modal-body text-center" id="sendemailform">
            <div class="model-logo">
                <img src="{{ asset('assets/images/logo.png')}}" alt="">
                <p>يرجى إدخال عنوان البريد الإلكتروني</p>
                <input class="form-control" type="email" placeholder="Email Address"id="pemail"required>
            </div>
            <div class="model-button">
                <button class="btn btn-send"> إرسال</button>
            </div>
        </form>
    </div>
    </div>
</div>
@endsection
@section('js')
<script>
    $('#buttonprint').on('click',function(){
        $('#modaltype').val('print');
    })
    $('#buttonsave').on('click',function(){
        $('#modaltype').val('save');
    })
    $('#buttonemail').on('click',function(){
        $('#modaltype').val('email');
    })
    $('#invoice_form').submit(function(){
        if($('#modaltype').val() == 'email')
        {
            $('#sendemailmodal').modal();
            return false;
        }
        alert('تمت عملية الاصدار بنجاح  ');
        if($('#modaltype').val() == 'print')
        {
            setTimeout(function() { window.location = $('#addinvoice_a').prop('href'); }, 3000);
        }
        return true;
    })
    $('#sendemailform').submit(function(){
        $('#modaltype').val($('#pemail').val());
        $('#invoice_form').submit();
        return false;
    })
    $('.priceinput').on('input',function(){
        $('#totalsell').val(
            $('input[name="adult_sell"]').val()*$('input[name="adult_no"]').val() +
            $('input[name="child_sell"]').val()*$('input[name="child_no"]').val() +
            $('input[name="infant_sell"]').val()*$('input[name="infant_no"]').val()
        );
        $('#comission_profit').val(
            ($('input[name="adult_fair"]').val()*$('input[name="adult_no"]').val() +
            $('input[name="child_fair"]').val()*$('input[name="child_no"]').val() +
            $('input[name="infant_fair"]').val()*$('input[name="infant_no"]').val())*$('input[name="comission_source"]').val()
        );
        $('#passenger_profit').val(
            $('#totalsell').val()*$('input[name="comission_passenger"]').val()
        );
        $('#totalbuy').val(
            $('input[name="adult_buy"]').val()*$('input[name="adult_no"]').val() +
            $('input[name="child_buy"]').val()*$('input[name="child_no"]').val() +
            $('input[name="infant_buy"]').val()*$('input[name="infant_no"]').val()
        );
        $('#totalfair').val(
            $('input[name="adult_fair"]').val()*$('input[name="adult_no"]').val() +
            $('input[name="child_fair"]').val()*$('input[name="child_no"]').val() +
            $('input[name="infant_fair"]').val()*$('input[name="infant_no"]').val()
        );
        $('#total_pay_to_source').val(
            $('#totalsell').val() -  $('#passenger_profit').val()
        );
        $('#profit').val(
            $('#total_pay_to_source').val() -  $('#totalbuy').val() + $('#comission_profit').val()
        );
        $('#debt_of_source').val(
            $('#totalbuy').val() - $('#comission_profit').val() 
        );
        $('#pay_to_source').val(0);
        $('#return_paid').val(0);
    })

</script>
@endsection