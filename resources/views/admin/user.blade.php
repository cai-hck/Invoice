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
                                    <th>Company Name</th>
                                    <th>Education</th>
                                    <th>Specilized</th>
                                    <th>Phone</th>
                                    <th>Address</th>
                                    <th>Email</th>
                                    <th>Notes</th>
                                    <th>Created Time</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{$user->id }}</td>
                                            <td>{{$user->name }}</td>
                                            <td>{{$user->cname }}</td>
                                            <td>{{$user->education }}</td>
                                            <td>{{$user->specilized }}</td>
                                            <td>{{$user->phone }}</td>
                                            <td>{{$user->address }}</td>
                                            <td>{{$user->email }}</td>
                                            <td>{{$user->note }}</td>
                                            <td>{{Carbon\Carbon::parse($user->created_at)->format('d-m-Y H:i:s')}}</td>
                                            <td>
                                                <div class="action-btns">
                                                    <a class="btn-floating error-bg" onclick="return confirm('Are you sure?')" href="{{ url('/admin/deluser/'.$user->id)}}">
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
            width: '10%',
            targets: [1]
        }, {
            width: '10%',
            targets: [2]
        }, {
            width: '10%',
            targets: [3]
        }, {
            width: '10%',
            targets: [4]
        },{
            width: '10%',
            targets: [5]
        },{
            width: '10%',
            targets: [6]
        },{
            width: '10%',
            targets: [7]
        },{
            width: '10%',
            targets: [8]
        },{
            width: '10%',
            targets: [9]
        },{
            width: 'auto',
            targets: [10]
        }]
    });
</script>
@endsection
