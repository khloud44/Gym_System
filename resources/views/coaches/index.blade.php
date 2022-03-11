@extends('layouts.app')

@if(Auth::user()->hasRole('coach'))
@section('starter_script')
@php
    $id = Auth::user()->id;
    $url = url("/coaches/$id");
    // dd($url);
@endphp
<script>
    window.location.href = "{{$url}}";
</script>
@endsection
@endif

@section('third_party_stylesheets')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.css">
<meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('content')
@if(Auth::user()->hasRole('Super-Admin'))
<br><br>
<div class="text-center mydiv">
    <a href="{{route('coaches.create')}}" class="btn btn-success">Add New Coach </a>
<table id="table_id" class="table table-responsive-md  cell-border compact stripe table-dark my-4 text-dark">
    <thead>
        <tr class="text-white">
            <th>id</th>
            <th>name</th>
            <th>email</th>
            <th>avatar</th>
            <th>national_id</th>
            <th>is_baned</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    </tbody>
</table>
</div>

@endif


@endsection

@section('third_party_scripts')
    <script src="{{ mix('js/app.js') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.js" defer></script>
    <script>
        $(document).ready( function () {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        $('#table_id').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('coaches.index') }}"
            },
            columns: [{
                    data: 'id',
                    name: 'id',
                },
                {
                    data: 'name',
                    name: 'name',
                },
                {
                    data: 'email',
                    name: 'email',
                },
                {
                    data:'avatar',
                    name:'avatar',
                    render:function(data,type,full,meta)
                    {
                        return "<img src="+data+" width='70' class='img-thumbnail' />";
                    },
                    orderable: false
                },
                {
                    data:'national_id',
                    name:'national_id',
                },
                {
                    data:"is_baned",
                    name:"is_baned",
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                },
            ]
        });
    } );
    function deleteFunc(id){
        if (confirm("Delete Record?") == true) {
        var id = id;
         // ajax
        $.ajax({
           type:"POST",
           url: "{{ url('destroy-coach') }}",
           data: { id: id },
           dataType: 'json',
           success: function(res){
            $('#table_id').DataTable().ajax.reload();
              },
            error:function(){ 
            alert("Failed");
        }
         });
         
    }}
    </script>
@endsection
