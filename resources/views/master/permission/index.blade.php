@extends('layouts.master')

@section('title') Permission Level @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title mb-0"><i class="fa-solid fa-shield-halved me-1"></i>Permission Level</h4>
                <span class="text-muted small">Kelola akses menu berdasarkan level</span>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="dataTable" class="table table-sm table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Level</th>
                                <th>Total Permission</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($levels as $lvl)
                            <tr>
                                <td>{{ $lvl->kode }}</td>
                                <td>{{ $lvl->nama ?? $lvl->kode }}</td>
                                <td>
                                    @php($count = $lvl->permissions()->count())
                                    @if($count > 0)
                                        <span class="badge bg-primary">{{ $count }} menu</span>
                                    @else
                                        <span class="badge bg-secondary">Belum diatur</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis"></i>
                                        </button>
                                        <ul class="dropdown-menu dropdown-menu-end">
                                            <li><a class="dropdown-item" href="{{ route('permission.edit', $lvl->kode) }}"><i class="fa-solid fa-shield-halved me-1"></i>Atur Permission</a></li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .dropdown-menu { min-width: 8rem; }
</style>
@endsection