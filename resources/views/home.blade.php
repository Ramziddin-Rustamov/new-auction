@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card py-2 my-2">
                <div class="card-header">{{ __('My products ') }}</div>

                <div class="card-body">
                    @if($myproducts->isEmpty())
                        <div class="alert alert-danger" role="alert">
                            You have no products yet
                        </div>
                    @endif

                    @foreach($myproducts as $product)
                        <div class="card pb-2 my-2">
                            <div class="card-body"></div>
                                <h5 class="card-title mx-1">{{$product->name}}</h5>
                                <p class="card-text mx-1">{{$product->description}}</p>
                                <a href="/products/{{$product->id}}" class="btn btn-primary my-4 mx-1">View</a>
                                <a href="/products/{{$product->id}}/edit" class="btn btn-primary mb-3 mx-1">Edit</a>
                                <form action="/products/{{$product->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger my-1 mx-1">Delete</button>
                                </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- col 6 second one  --}}
        <div class="col-md-6">
            <div class="card py-2 my-2">
                <div class="card-header">{{ __('My Bids') }}</div>

                <div class="card-body">
                    @if($myproducts->isEmpty())
                        <div class="alert alert-danger" role="alert">
                            You have no products bidding yet
                        </div>
                    @endif

                    @foreach($myproductBid as $bid)
                        <div class="card pb-2 my-2">
                            <h3 class="card-body">This is your bid</h3>
                                <h5 class="card-title mx-1"> Biided  {{$bid->user->fullname}}</h5>
                                <h5 class="card-title mx-1"> Biided username {{$bid->user->username}}</h5>
                                <p class="card-text mx-1">Your bid = {{$bid->price}}</p>
                                <p class="card-text mx-1"><strong>Product name </strong>{{$bid->product->name}}</p>
                                <p class="card-text mx-1"><strong>Product image url</strong> {{$bid->product->img}}</p>
                                <p class="card-text mx-1">  <strong>Product bidmargin</strong> {{$bid->price}}</p>
                                <p class="card-text mx-1"> <strong>Product discription </strong> {{$bid->product->description}}</p>
                                <a href="/products/{{$product->id}}" class="btn btn-dark my-4 mx-1">View</a>
                                <a href="/products/{{$product->id}}/edit" class="btn btn-dark mb-3 mx-1">Edit</a>
                                <form action="/products/{{$product->id}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger my-1 mx-1">Delete</button>
                                </form>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
