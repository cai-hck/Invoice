@extends('admin.layout.default')
@section('css')

@endsection

@section('jsPostApp')
@endsection

@section('content')
<div class="main-container">
    <div class="card small">
        <div class="row">
            <form class="col s12" action="{{url('admin/newcompany')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">account_circle</i>
                        <input id="icon_prefix" type="text" class="validate" name="name" required>
                        <label for="icon_prefix">Company Name</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">phone</i>
                        <input id="icon_telephone" type="text" class="validate" name="phone" required>
                        <label for="icon_telephone">Telephone</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">work</i>
                        <input id="icon_prefix" type="text" class="validate" name="address" required>
                        <label for="icon_prefix">Address</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix">email</i>
                        <input id="icon_telephone" type="email" class="validate" name="email" required>
                        <label for="icon_telephone">Email</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix">vpn_key</i>
                        <input id="icon_prefix" type="password" class="validate" name="password" required autocomplete="new-password">
                        <label for="icon_prefix">Password</label>
                    </div>
                    <div class="input-field col s6">
                        <div class="file-field input-field">
                            <div class="btn">
                                <span>LOGO</span>
                                <input type="file" name="photo" required>
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="text-align:right">
                    <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                        <i class="material-icons right">send</i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
