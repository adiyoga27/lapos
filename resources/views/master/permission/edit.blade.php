@extends('layouts.master')

@section('title') Atur Permission - {{ $level->nama ?? $level->kode }} @endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <h4 class="card-title mb-0"><i class="fa-solid fa-shield-halved me-1"></i>Atur Permission</h4>
                    <small class="text-muted">Level: <strong>{{ $level->kode }}</strong> — {{ $level->nama ?? '-' }}</small>
                </div>
                <a href="{{ route('permission.index') }}" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-arrow-left me-1"></i>Kembali</a>
            </div>
            <div class="card-body">
                <form action="{{ route('permission.update', $level->kode) }}" method="POST">
                    @csrf @method('PUT')

                    <div class="mb-3 d-flex gap-2">
                        <button type="button" class="btn btn-sm btn-outline-primary" onclick="checkAll(true)"><i class="fa-solid fa-check-double me-1"></i>Pilih Semua</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="checkAll(false)"><i class="fa-solid fa-xmark me-1"></i>Hapus Semua</button>
                    </div>

                    @php
                        $groups = [];
                        foreach ($menuItems as $key => $item) {
                            $groups[$item['group']][] = ['key' => $key, 'label' => $item['label']];
                        }
                    @endphp

                    @foreach($groups as $groupName => $items)
                    <div class="card mb-3">
                        <div class="card-header py-2 d-flex justify-content-between align-items-center">
                            <h6 class="mb-0"><i class="fa-solid fa-folder me-1"></i>{{ $groupName }}</h6>
                            <div class="form-check">
                                <input class="form-check-input group-check" type="checkbox" data-group="{{ $groupName }}" id="group_{{ \Str::slug($groupName) }}">
                                <label class="form-check-label small text-muted" for="group_{{ \Str::slug($groupName) }}">Pilih semua</label>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @foreach($items as $item)
                                <div class="col-md-4 col-lg-3 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input perm-check" data-group="{{ $groupName }}" type="checkbox" name="permissions[]" value="{{ $item['key'] }}" id="perm_{{ $item['key'] }}" {{ in_array($item['key'], $permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="perm_{{ $item['key'] }}">{{ $item['label'] }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach

                    <div class="text-end mt-3">
                        <a href="{{ route('permission.index') }}" class="btn btn-secondary"><i class="fa-solid fa-xmark me-1"></i>Batal</a>
                        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i>Simpan Permission</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('css')
<style>
    .card-header h6 { font-size: 0.85rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.03em; }
    .form-check-label { font-size: 0.875rem; }
</style>
@endsection

@section('js')
<script>
function checkAll(state) {
    document.querySelectorAll('.perm-check').forEach(cb => cb.checked = state);
    document.querySelectorAll('.group-check').forEach(cb => cb.checked = state);
    updateGroupChecks();
}

document.querySelectorAll('.group-check').forEach(gc => {
    gc.addEventListener('change', function() {
        const group = this.dataset.group;
        document.querySelectorAll(`.perm-check[data-group="${group}"]`).forEach(cb => cb.checked = this.checked);
    });
});

function updateGroupChecks() {
    document.querySelectorAll('.group-check').forEach(gc => {
        const group = gc.dataset.group;
        const checks = document.querySelectorAll(`.perm-check[data-group="${group}"]`);
        const allChecked = [...checks].every(cb => cb.checked);
        gc.checked = allChecked;
    });
}

document.querySelectorAll('.perm-check').forEach(cb => {
    cb.addEventListener('change', updateGroupChecks);
});

updateGroupChecks();
</script>
@endsection