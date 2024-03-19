@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
        <div class="container">
            <h1>All of the active products</h1>
        </div>
        <section style="background-color: #eee;">
            <div class="container py-2">
                <div class="row justify-content-center mb-3">
                    <div class="col-md-12 col-xl-12">
                        {{-- Beginning --}}
                        <div class="card shadow-0 border rounded-3">
                            <div class="card-body">
                                <div class="row">
                                    @foreach($products as $product)
                                    <div class="col-md-12 col-lg-6 col-xl-4 py-2 border-1 mb-4 border">
                                        <div class="bg-image hover-zoom ripple rounded ripple-surface">
                                            <img src="https://picsum.photos/id/{{ $product->id }}/200/300"
                                                class="w-100 rounded" />
                                            <a href="#!">
                                                <div class="hover-overlay">
                                                    <div class="mask"
                                                        style="background-color: rgba(253, 253, 253, 0.15);"></div>
                                                </div>
                                            </a>
                                        </div>
                                        <h5 class="my-2">{{ $product->name }}</h5>
                                        <div class="d-flex flex-row">
                                            <div class="text-danger mb-1 me-2">
                                                @for ($i = 0; $i < 4; $i++)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                            </div>
                                            <span>310</span>
                                        </div>
                                        <div class="mt-3">
                                            <h6 class="text-success">Starting price</h6>
                                            <div class="d-flex flex-row align-items-center">
                                                <h4 class="mb-1 me-1">${{ $product->bidmargin }}</h4>
                                                <span class="text-danger"><s>${{ $product->bidmargin * 2 }}</s></span>
                                            </div>
                                            <h6 class="text-success">Last price</h6>
                                            <div class="d-flex flex-row align-items-center">
                                                <h4 class="mb-1 me-1 text-danger">${{ $product->currentBid ? $product->currentBid->price : $product->bidmargin }}</h4>
                                            </div>
                                            <div class="d-flex flex-column mt-3">
                                                <a href="{{ route('view', ['id' => $product->id]) }}"
                                                    class="btn btn-primary">View</a>
                                                <div class="my-3">
                                                    <span class="text-primary">Started: {{ $product->created_at }}</span><br>
                                                    <span class="text-danger">End: 2 Days</span><br>
                                                    @php
                                                        $end_date = \Carbon\Carbon::parse($product->created_at)->addDays(2);
                                                        $now = \Carbon\Carbon::now();
                                                        $diff = $end_date->diffInSeconds($now);
                                                        $remaining = $diff > 0 ? gmdate('H:i:s', $diff) : 'Auction ended';
                                                    @endphp
                                                    <span class="text-info">Time Left: {{ $remaining }}</span><br>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        {{-- End --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection
