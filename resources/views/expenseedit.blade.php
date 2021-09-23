@extends('layouts.app')

@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>قائمة المصاريف </h4>
            <div class="new-invoice-inner">
                <div class="invoice-form" style="padding:60px;">
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">رقم الفاتورة</span>
                            </div>
                            <input type="text" aria-label="Reference Number" class="form-control" placeholder="" readonly value="{{$expense->id}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">اسم المسافر </span>
                            </div>
                            <input type="text" aria-label="Name" class="form-control" placeholder="" readonly value="{{$expense->name}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">التفاصيل</span>
                            </div>
                            <input type="text" aria-label="Note" class="form-control" placeholder="" readonly value="{{$expense->details}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">ملاحظات</span>
                            </div>
                            <input type="text" aria-label="Note" class="form-control" placeholder="" readonly value="{{$expense->note}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">المبلغ</span>
                            </div>
                            <input type="text" aria-label="Cost" class="form-control" placeholder="" readonly value="{{$expense->cost}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">المبلغ المسترجع</span>
                            </div>
                            <input type="text" aria-label="User" class="form-control" placeholder="" readonly value="{{$expense->returned}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">اسم موظف اصدار الفاتوره</span>
                            </div>
                            <input type="text" aria-label="User" class="form-control" placeholder="" readonly value="{{$expense->employee}}">
                        </div>
                    </div>
                    <div class="input-group form-group">
                        <div class="invoice-name invoice-no">
                        <div class="input-group-prepend ">
                            <span class="input-group-text">التاريخ</span>
                            </div>
                            <input type="text" aria-label="Date" class="form-control" placeholder="" readonly value="{{$expense->created_at}}">
                        </div>
                    </div>
                </div>
                <div class="invoice-form" style="    border-top: 5px solid #e8e8e8;padding:60px;">
                    <form method="POST" action="{{url('updateexpense')}}" name="invoice_form" class="" id="paid_form">
                        @csrf
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">ملاحظات</span>
                                </div>
                                <input type="text" name="note"aria-label="Note" class="form-control" placeholder="">
                            </div>
                        </div>
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">المبلغ المسترجع</span>
                                </div>
                                <input type="number" name="returned"aria-label="Returned" class="form-control" value="0" min="0" id="paid_money">
                            </div>
                        </div>
                        <input type="hidden" name="id" value="{{$expense->id}}">
                        <div class="form-group custom-btn"> 
                            <button type="submit" class="btn btn-success" id="paid_form_button" >إضافة / طباعة</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </article>
</section>
<!-- Modal -->
<div class="modal fade" id="confirmmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalScrollableTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalScrollableTitle">يرجى تأكيد المبلغ المسترجع</h5>
            </div>
            <div class="modal-body text-center">
                <div class="model-logo">
                    <input class="form-control" type="text" readonly id="confirm_paid_money" style="text-align: center;">
                </div>
                <div class="model-button">
                    <button class="btn btn-success" id="confirm_modal"> إضافة / طباعة</button>
                    <button class="btn btn-danger" id="cancel_modal"> إلغاء</button>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="0" id="formstatus">
@endsection
@section('js')
<script>
    $('#paid_form_button').on('click',function(){
        $('#confirm_paid_money').val($('#paid_money').val());
    })
    $('#paid_form').submit(function(){
        if($('#formstatus').val() == '0')
        {
            $('#confirmmodal').modal();
            return false;
        }
        return true;
    })
    $('#confirm_modal').on('click',function(){
        $('#formstatus').val('1');
        $('#paid_form').submit();
    })
    $('#cancel_modal').on('click',function(){
        $('#confirmmodal').modal('toggle');
    })
</script>
@endsection
