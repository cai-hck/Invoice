@extends('layouts.app')

@section('css')

@endsection
@section('content')
<section id="main">
    <article class="article" id="new_invoice">
        <div class="new-invoice">
            <h4>إضافة مستفيد</h4>
            <div class="new-invoice-inner">
                <div class="invoice-form">
                    <form  action="{{url('newucompany')}}" method="POST" enctype="multipart/form-data" name="invoice_form" class="" id="invoice_form" >
                        @csrf
                        <div class="input-group form-group">
                            <div class="invoice-name invoice-no">
                            <div class="input-group-prepend ">
                                <span class="input-group-text">اسم الشركة</span>
                                </div>
                                <input type="text" name="name" aria-label="Name" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="form-group custom-btn" style="text-align:center;"> 
                            <button class="btn btn-success">اضافة</button>
                        </div>
                    </form>
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