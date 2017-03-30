@extends('layout')

@section('main')

    <style>
        body {
            padding-top: 15px;
        }
    </style>

    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <p>
                <a href="{!! route('index') !!}" class="btn btn-md btn-primary">
                    <span class="glyphicon glyphicon-arrow-left"></span> Back
                </a>
                </p>
            </div>
        </div>


        @if (count($errors) > 0)
            <div class="row">
                <div class="col-xs-12">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        @endif

    </div>

    <section class="upload-form container">
        <form method="post" action="{{ route("photo.store") }}" enctype="multipart/form-data">

            {!! csrf_field() !!}

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" placeholder="What is this?" name="title" maxlength="50">
            </div>

            <div class="form-group">
                <label for="exampleInputFile">File input</label>
                <input style="background-color:white;" type="file" id="exampleInputFile" accept="image/jpeg,image/png,image/gif" name="file">
            </div>

            <div class="form-group">
                <textarea id="textarea"  class="form-control" rows="5" placeholder="Why did this inspire you?"  name="description" maxlength="350"></textarea>
                <div id="textarea_feedback" class="charNum text-muted"> </p>
            </div>
            <br>
            <div class="text-center">
                <button type="submit" class="btn btn-lg btn-warning"><span class="glyphicon glyphicon-open"></span> Upload</button>
            </div>

        </form>
    </section>
    
@endsection
@push('scripts')
        <script type="text/javascript" src=" {{asset('js/form.js')}} "></script>
 @endpush