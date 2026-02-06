@extends('layouts.app')

@section('content')
<style>
    /* Styling Pagination (Sama seperti referensi) */
    .page-item.active .page-link {
        background-color: #dc3545;
        border-color: #dc3545;
        color: white;
    }
    .page-link {
        color: #dc3545;
    }
    .page-link:hover {
        color: #a71d2a;
    }
    /* Hover row halus */
    .table-hover tbody tr:hover {
        background-color: rgba(220, 53, 69, 0.03);
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold text-dark border-bottom pb-2 mb-0">
            <i class="fas fa-user-cog me-2 text-danger"></i>Service Advisor
        </h1>
        <a href="{{ route('advisor.create') }}" class="btn btn-danger shadow-sm px-4">
            <i class="fas fa-plus me-2"></i>Buat SA Baru
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow border-0 rounded-4">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light border-bottom">
                        <tr>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Tanggal</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Customer & Motor</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Pekerjaan Jasa</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Estimasi Parts</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold">Total Biaya</th>
                            <th scope="col" class="py-3 px-4 text-secondary text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($advisors as $advisor)
                        <tr>
                            <td class="px-4 text-secondary">
                                {{ $advisor->created_at->format('d M Y, H:i') }}
                            </td>
                            <td class="px-4">
                                <span class="d-block fw-bold text-dark">{{ $advisor->booking->customer_name ?? 'N/A' }}</span>
                                <small class="text-danger fw-bold">{{ $advisor->booking->plate_number ?? '-' }}</small>
                            </td>
                            <td class="px-4 text-dark">
                                {{ $advisor->jobs }}
                            </td>
                            <td class="px-4 text-secondary">
                                Rp {{ number_format($advisor->estimation_parts, 0, ',', '.') }}
                            </td>
                            <td class="px-4 fw-bold text-success">
                                Rp {{ number_format($advisor->total_estimation, 0, ',', '.') }}
                            </td>
                            <td class="px-4 text-center">
                                <div class="btn-group" role="group">
                                    {{-- Tombol Print --}}
                                    <a href="{{ route('advisor.print', $advisor->id) }}" target="_blank" class="btn btn-sm btn-light text-primary border shadow-sm" title="Print PDF">
                                        <i class="fas fa-print"></i>
                                    </a>
                                    
                                    {{-- Tombol Edit --}}
                                    <a href="{{ route('advisor.edit', $advisor->id) }}" class="btn btn-sm btn-light text-warning border shadow-sm" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Tombol Delete 
                                    <form action="{{ route('advisor.destroy', $advisor->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus data ini?');" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger border shadow-sm rounded-end" title="Hapus">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>--}}
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-clipboard-list fa-3x mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data Service Advisor.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            @if ($advisors->hasPages())
            <div class="card-footer bg-white border-top-0 py-3">
                {{ $advisors->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection