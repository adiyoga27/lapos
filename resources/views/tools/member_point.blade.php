@extends('layouts.master')

@section('title', 'Member Point')

@section('content')
<h4 class="mb-3">Member Point</h4>

<div x-data="memberPoint()">
    <div class="card mb-3">
        <div class="card-body">
            <div class="position-relative">
                <input type="text" x-model="memberSearch"
                       @input.debounce.300ms="searchMember()"
                       placeholder="Cari member berdasarkan ID / Kode..."
                       class="form-control form-control-lg">
                <div x-show="showDropdown && memberResults.length > 0" x-cloak
                     @click.away="showDropdown = false"
                     class="position-absolute w-100 bg-white border rounded shadow-sm" style="z-index:1050; top:100%; max-height:240px; overflow-y:auto;">
                    <template x-for="m in memberResults" :key="m.id_kartu">
                        <div @click="selectMember(m); showDropdown = false"
                             class="px-3 py-2 border-bottom cursor-pointer hover-bg" style="cursor:pointer;"
                             @mouseenter="$el.style.background='#e8f0fe'" @mouseleave="$el.style.background=''">
                            <p class="mb-0 small fw-medium" x-text="m.id_kartu + ' - ' + m.nama"></p>
                            <p class="mb-0 text-muted" style="font-size:0.75rem;">
                                <span x-text="m.no_telp || '-'"></span> |
                                Point: <strong class="text-primary" x-text="m.point || 0"></strong>
                            </p>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>

    <div x-show="selectedMember" class="card mb-3">
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <small class="text-muted">Nama Member</small>
                    <p class="fs-5 fw-bold mb-0" x-text="selectedMember ? selectedMember.nama : ''"></p>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">No. Telepon</small>
                    <p class="fw-medium mb-0" x-text="selectedMember ? selectedMember.no_telp || '-' : ''"></p>
                </div>
                <div class="col-md-3">
                    <small class="text-muted">Point Saat Ini</small>
                    <p class="fs-4 fw-bold text-primary mb-0" x-text="selectedMember ? (selectedMember.point || 0) : 0"></p>
                </div>
            </div>

            <hr>

            <h6 class="fw-semibold mb-3">Riwayat Point</h6>
            <div class="table-responsive">
                <table class="table table-bordered table-sm">
                    <thead class="table-light">
                        <tr>
                            <th>Tanggal</th>
                            <th>Keterangan</th>
                            <th class="text-center">Point</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, i) in pointHistory" :key="i">
                            <tr>
                                <td x-text="formatDate(item.tanggal)"></td>
                                <td x-text="item.keterangan || 'Point transaksi'"></td>
                                <td class="text-center">
                                    <span :class="item.point_kredit ? 'text-success' : 'text-danger'"
                                          x-text="(item.point_kredit ? '+' : '-') + (item.point_kredit || item.point_debet || 0)"></span>
                                </td>
                            </tr>
                        </template>
                        <tr x-show="pointHistory.length === 0">
                            <td colspan="3" class="text-center text-muted py-3">Belum ada riwayat point</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <h6 class="fw-semibold mb-3">Tukar Point</h6>
            <div class="bg-primary bg-opacity-10 rounded p-3">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label small">Jumlah Point</label>
                        <input type="number" x-model.number="redeemPoints" min="1" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label small">Nilai Tukar (Rp)</label>
                        <input type="text" x-model="redeemValue" readonly class="form-control form-control-sm fw-bold text-success bg-light">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button @click="redeemPoints > 0 ? redeemPoint() : null" :disabled="!redeemPoints || redeemPoints > (selectedMember ? selectedMember.point : 0)"
                                class="btn btn-success btn-sm w-100">
                            <i class="fa-solid fa-exchange-alt me-1"></i> Tukar
                        </button>
                    </div>
                </div>
                <p class="text-muted small mt-2 mb-0">* 1 point = Rp 100 (dapat disesuaikan)</p>
            </div>
        </div>
    </div>

    <div x-show="!selectedMember" class="card">
        <div class="card-body text-center py-5 text-muted">
            <i class="fa-solid fa-users fa-3x mb-3 d-block" style="color:#ccc;"></i>
            <p class="mb-0">Cari member untuk melihat informasi point</p>
        </div>
    </div>
</div>
@endsection

@section('script-bottom')
<script>
    function memberPoint() {
        return {
            memberSearch: '',
            memberResults: [],
            showDropdown: false,
            selectedMember: null,
            pointHistory: [],
            redeemPoints: 0,
            redeemValue: '0',

            async searchMember() {
                if (this.memberSearch.length < 1) {
                    this.memberResults = [];
                    this.showDropdown = false;
                    return;
                }
                try {
                    const res = await fetch('/member/search/' + encodeURIComponent(this.memberSearch), {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.memberResults = data.data;
                        this.showDropdown = true;
                    }
                } catch (e) {
                    this.memberResults = [];
                }
            },

            async selectMember(member) {
                this.selectedMember = member;
                this.memberSearch = member.id_kartu + ' - ' + member.nama;
                this.showDropdown = false;
                this.redeemPoints = 0;
                this.redeemValue = '0';
                await this.loadHistory();
            },

            async loadHistory() {
                if (!this.selectedMember) return;
                try {
                    const res = await fetch('/member/point-history/' + encodeURIComponent(this.selectedMember.id_kartu), {
                        headers: { 'Accept': 'application/json' }
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.pointHistory = data.data || [];
                    }
                } catch (e) {
                    this.pointHistory = [];
                }
            },

            calcRedeemValue() {
                this.redeemValue = new Intl.NumberFormat('id-ID').format((this.redeemPoints || 0) * 100);
            },

            async redeemPoint() {
                if (!confirm('Tukar ' + this.redeemPoints + ' point?')) return;
                try {
                    const res = await fetch('/member/redeem-point', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({
                            id_member: this.selectedMember.id_kartu,
                            point: this.redeemPoints,
                        }),
                    });
                    const data = await res.json();
                    if (data.success) {
                        this.selectedMember.point = (this.selectedMember.point || 0) - this.redeemPoints;
                        this.redeemPoints = 0;
                        this.redeemValue = '0';
                        await this.loadHistory();
                        alert('Point berhasil ditukar!');
                    } else {
                        alert(data.message || 'Gagal menukar point');
                    }
                } catch (e) {
                    alert('Gagal menukar point');
                }
            },

            formatDate(dateStr) {
                if (!dateStr) return '-';
                var d = new Date(dateStr);
                return d.toLocaleDateString('id-ID');
            },
        }
    }
</script>
@endsection