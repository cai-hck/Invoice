@extends('layouts.app')

@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>اصدار فاتورة تسديد الشركات</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form" style="padding:60px;">
                    <form method="POST" action="{{url('newpaid')}}" id="invoice_form" name="invoice_form" class="" id="paid_form">
                        @csrf
                        <div class="input-group form-group d-flex date-no">
                            <div class="invoice-travel-date invoice-no d-flex">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">التاريخ</span>
                                </div>
                                <input type="text"  aria-label="Date" class="form-control" placeholder="" value="<?php echo date('d/m/Y');?>"  style="max-width:100%" readonly>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">رقم الوصل</span>
                                </div>
                                <input type="number" name="invoice_nu" aria-label="Invoice_nu" class="form-control" min="0" required>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">المبلغ</span>
                                </div>
                                <input type="number" name="amount" aria-label="Total" class="form-control"  min="0" >
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">اسم الشركة</span>
                                </div>
                                <select name="u_company_id" class="form-control" style="height:68px">
                                <?php foreach($ucompanies as $ucompany){?>
                                <option value="{{$ucompany->id}}">{{$ucompany->name}} </option>
                                <?php }?>
                                </select>
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">ملاحظات</span>
                                </div>
                                <input type="text" name="details"aria-label="Details" class="form-control" placeholder="" >
                            </div>
                        </div>
                        <div class="input-group form-group" style="display:none;">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text"></span>
                                </div>
                                <input type="number" name="total" aria-label="Total" class="form-control" value="0" min="0" id="paid_money" value="0">
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
<!-- Modal -->
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
            setTimeout(function() { window.location = $('#addpaid_a').prop('href'); }, 3000);
        }
        return true;
    })
    $('#sendemailform').submit(function(){
        $('#modaltype').val($('#pemail').val());
        $('#invoice_form').submit();
        return false;
    })
</script>
@endsection
