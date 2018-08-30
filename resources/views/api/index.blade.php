<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <!-- Styles -->

    </head>
    <body>
        <div class="container">
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
               Create
            </button>

            <!-- Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <form action="{{route('api.store')}}" method="post" >
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        {{csrf_field()}}
                            <div class="modal-body">
                            <div class="form-group">
                                <label for="usr">Name:</label>
                                <input type="text" name="name" placeholder="Name" required="" class="form-control" id="name">
                            </div>
                            <div class="form-group">
                                <label for="usr">Description:</label>
                                <input type="text" name="description" placeholder="description" required="" class="form-control" id="description">
                            </div>
                            <div class="form-group">
                                <label for="usr">Price:</label>
                                <input type="number" name="price" placeholder="price" required="" class="form-control" id="price">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </div>
                    </form>

                </div>
            </div>
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Description</th>
                    <th scope="col">Price</th>
                    <th scope="col">Option</th>
                </tr>
                </thead>
                <tbody>
                @foreach($products->data as $product)
                <tr>
                    <td><a href="{{route('api.show',$product->id)}}">{{$product->id}}</a></td>
                    <td>{{$product->name}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->price}}</td>
                    @php $id = "'product-{$product->id}'" @endphp
                    <td><a href="#" onclick="event.preventDefault();
                            document.getElementById({{ $id }}).submit();">Delete</a>
                        <a href="javascript:void(0)" data-toggle="modal" data-target="#example-{{$product->id}}">Update</a></td>
                    <form action="{{route('api.destroy',$product->id)}}" id="product-{{ $product->id }}" method="POST">
                        @method('delete')
                        @csrf
                    </form>
                </tr>


                <!-- Modal -->
                <div class="modal fade" id="example-{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <form action="{{route('api.update',$product->id)}}" method="post" >
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Create Product</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                {{csrf_field()}}
                                @method('PUT')
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label for="usr">Name:</label>
                                        <input type="text" value="{{$product->name}}" name="name" placeholder="Name" required="" class="form-control" id="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr">Description:</label>
                                        <input type="text" value=" {{$product->description}}" name="description" placeholder="description" required="" class="form-control" id="description">
                                    </div>
                                    <div class="form-group">
                                        <label for="usr">Price:</label>
                                        <input type="number" value="{{$product->price}}" name="price" placeholder="price" required="" class="form-control" id="price">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Save changes</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                 @endforeach
                </tbody>
            </table>
        </div>
    </body>
</html>
