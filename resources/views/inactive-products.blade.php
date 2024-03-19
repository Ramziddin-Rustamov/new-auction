@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-body">
     <div class="container">
        <h1>All of the active products </h1>
    </div><section style="background-color: #eee;">
      <div class="container py-5">
        <div class="row justify-content-center mb-3">
          <div class="col-md-12 col-xl-10">
           {{-- Beginiing --}}

           <div class="card shadow-0 border rounded-3">
              <div class="card-body">
                <div class="row">
                  <div class="col-md-12 col-lg-3 col-xl-3 mb-4 mb-lg-0">

                    <div class="bg-image hover-zoom ripple rounded ripple-surface">
                      <img src="https://mdbcdn.b-cdn.net/img/Photos/Horizontal/E-commerce/Products/img%20(4).webp"
                        class="w-100" />
                      <a href="#!">
                        <div class="hover-overlay">
                          <div class="mask" style="background-color: rgba(253, 253, 253, 0.15);"></div>
                        </div>
                      </a>
                    </div>
                  </div>
                  <div class="col-md-6 col-lg-6 col-xl-6">
                    <h5>Quant trident shirts</h5>
                    <div class="d-flex flex-row">
                      <div class="text-danger mb-1 me-2">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                      </div>
                      <span>310</span>
                    </div>
                    <div class="mt-1 mb-0 text-muted small">
                      <span>100% cotton</span>
                      <span class="text-primary"> • </span>
                      <span>Light weight</span>
                      <span class="text-primary"> • </span>
                      <span>Best finish<br /></span>
                    </div>
                    <div class="mb-2 text-muted small">
                      <span>Unique design</span>
                      <span class="text-primary"> • </span>
                      <span>For men</span>
                      <span class="text-primary"> • </span>
                      <span>Casual<br /></span>
                    </div>
                    <p class="text-truncate mb-4 mb-md-0">
                      There are many variations of passages of Lorem Ipsum available, but the
                      majority have suffered alteration in some form, by injected humour, or
                      randomised words which don't look even slightly believable.
                    </p>

                  </div>
                  <div class="col-md-6 col-lg-3 col-xl-3 border-sm-start-none border-start">
                      <h6 class="text-success">Starting price </h6>
                    <div class="d-flex flex-row align-items-center mb-1">
                      <h4 class="mb-1 me-1">$13.99</h4>
                      <span class="text-danger"><s>$20.99</s></span>
                    </div>

                    <h6 class="text-success">Last  price </h6>
                    <div class="d-flex flex-row align-items-center mb-1">
                      <h4 class="mb-1 me-1 text-danger">$13.99</h4>
                    </div>

                    <div class="d-flex flex-column mt-4">
                      {{-- <input class="form-control" type="form-control" />
                      <button class="btn btn-outline-primary btn-sm mt-2" type="button">
                        Add new price
                      </button> --}}
                      <div class="my-3">
                         <span class="text-primary"> Started : 7 - may 2000 </span> <br>
                          <span class="text-danger">End: 1 - yanvar 2001</span>  <br>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
           {{-- end --}}
                 {{-- User bid --}}
                 <div class="card my-2">
                  <div class="card-body">
                      <h4>Owner of this product </h4>
                  </div>
              </div>
                {{-- User Bid --}}
          </div>
        </div>
      </div>
    </section>
     </div>

  </div>
</div>
@endsection
