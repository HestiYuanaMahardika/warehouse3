@extends('layouts.main')
@section('title', __('Proyek'))
@section('custom-css')
    <link rel="stylesheet" href="/plugins/toastr/toastr.min.css">
@endsection
@section('content')
    <div class="content-header">
        <div class="container-fluid">
        <div class="row mb-2">
        </div>
        </div>
    </div>
    <section class="content">
    <div class="container-fluid">
        <div class="card">
        <div class="card-header">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-proyek" onclick="addProyek()"><i class="fas fa-plus"></i> Tambah Proyek</button>
        </div>
        <div class="card-body">
            <table id="table" class="table table-sm table-bordered table-hover table-striped">
            <thead>
                <tr class="text-center">
                    <th>No.</th>
                    <th>{{ __('Proyek Name') }}</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
            @if(count($proyek) > 0)
                @foreach($proyek as $key => $d)
                @php
                    $data = ["proyek_id" => $d->proyek_id, "proyek_name" => $d->proyek_name];
                @endphp
                <tr>
                    <td class="text-center">{{ $proyek->firstItem() + $key }}</td>
                    <td>{{ $data['proyek_name'] }}</td>
                    <td class="text-center"><button title="Edit Proyek" type="button" class="btn btn-success btn-xs" data-toggle="modal" data-target="#add-proyek" onclick="editProyek({{ json_encode($data) }})"><i class="fas fa-edit"></i></button> <button title="Hapus Proyek" type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#delete-proyek" onclick="deleteProyek({{ json_encode($data) }})"><i class="fas fa-trash"></i></button></td>
                </tr>
                @endforeach
            @else
                <tr class="text-center">
                    <td colspan="3">{{ __('No data.') }}</td>
                </tr>
            @endif
            </tbody>
            </table>
        </div>
        </div>
        <div>
        {{ $proyek->links("pagination::bootstrap-4") }}
        </div>
    </div>
    <div class="modal fade" id="add-proyek">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Add New Proyek') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="update" action="{{ route('products.proyek.save') }}" method="post">
                        @csrf
                        <input type="hidden" id="proyek_id" name="proyek_id">
                        <div class="form-group row">
                            <label for="proyek_name" class="col-sm-4 col-form-label">{{ __('Name') }}</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control" id="proyek_name" name="proyek_name">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button id="button-save" type="button" class="btn btn-primary" onclick="$('#update').submit();">{{ __('Add') }}</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="delete-proyek">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 id="modal-title" class="modal-title">{{ __('Hapus Proyek') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form role="form" id="delete" action="{{ route('products.proyek.delete') }}" method="post">
                        @csrf
                        @method('delete')
                        <input type="hidden" id="delete_id" name="delete_id">
                    </form>
                    <div>
                        <p class="text-danger">Perhatian! Stok serta history yang berada di proyek ini juga akan ikut terhapus!</p>
                        <p>Anda yakin ingin tetap menghapus proyek <span id="delete_name" class="font-weight-bold"></span>?</p>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{ __('Cancel') }}</button>
                    <button id="button-delete" type="button" class="btn btn-danger" onclick="$('#delete').submit();">{{ __('Ya, hapus') }}</button>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('custom-js')
    <script>
        function resetForm(){
            $('#update').trigger("reset");
            $('#proyek_id').val('');
        }

        function addProyek(){
            resetForm();
            $('#modal-title').text("Tambah Proyek");
            $('#button-save').text("Add");
        }

        function editProyek(data){
            resetForm();
            $('#modal-title').text("Edit Proyek");
            $('#button-save').text("Simpan");
            $('#proyek_id').val(data.proyek_id);
            $('#proyek_name').val(data.proyek_name);
        }

        function deleteProyek(data){
            $('#delete_id').val(data.proyek_id);
            $('#delete_name').text(data.proyek_name);
        }
    </script>
    <script src="/plugins/toastr/toastr.min.js"></script>
    @if(Session::has('success'))
        <script>toastr.success('{!! Session::get("success") !!}');</script>
    @endif
    @if(Session::has('error'))
        <script>toastr.error('{!! Session::get("error") !!}');</script>
    @endif
    @if(!empty($errors->all()))
        <script>toastr.error('{!! implode("", $errors->all("<li>:message</li>")) !!}');</script>
    @endif
@endsection