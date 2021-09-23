@extends('admin.layout.default')


@section('content')
<div class="main-container">
    {{-- Tables --}}
    <div class="row">
        <!-- With Action-->
        <div class="col s12">
            <div class="card-panel">
                <div class="row box-title">
                    <div class="col s12">
                        <h5 class="content-headline">Company Table</h5>
                        <p>You can Delete.</p>
                    </div>
                    <!-- Modal Structure -->
                </div>
                <div class="row">
                    <div class="col s12">
                        <div class="datatable-wrapper">
                            <table class="datatable-badges display cell-border" style="text-align:center">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>LOGO</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($companies as $company)
                                        <tr>
                                            <td>{{$company->id }}</td>
                                            <td>{{$company->name }}</td>
                                            <td><img src="{{asset('upload/logo/'.$company->photo)}}" style="width:100%" class="img-fluid"></td>
                                            <td>{{$company->phone }}</td>
                                            <td>{{$company->address }}</td>
                                            <td>{{$company->email }}</td>
                                            <td>{{Carbon\Carbon::parse($company->created_at)->format('d-m-Y H:i:s')}}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/delcompany/'.$company->id)}}">
                                                        <i class="material-icons">delete</i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                <tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')        

<script>
    $(document).ready(function() {
		$('select[name=DataTables_Table_0_length]').show();
	});
    $('.datatable-badges').DataTable({
        columnDefs: [{
            width: '5%',
            targets: [0]
        }, {
            width: '15%',
            targets: [1]
        }, {
            width: '10%',
            targets: [2]
        }, {
            width: '10%',
            targets: [3]
        }, {
            width: '25%',
            targets: [4]
        },{
            width: '10%',
            targets: [5]
        },{
            width: '15%',
            targets: [6]
        },{
            width: 'auto',
            targets: [7]
        }]
    });
</script>
@endsection
