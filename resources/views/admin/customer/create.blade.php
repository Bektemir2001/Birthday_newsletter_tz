@extends('layouts.main')
@section('content')
    <div class="col-sm-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Добавить клиента</h4>
                </div>
                <div class="header-action">
                    <i data-toggle="collapse" data-target="#form-element-1" aria-expanded="false">
                        <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </i>
                </div>
            </div>
            <div class="card-body">
                <div class="collapse" id="form-element-1">
                    <div class="card">
                    </div>
                </div>
                <form action="{{route('customers.store')}}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="full_name">ФИО</label>
                        <input type="text" class="form-control" id="full_name" name="full_name">
                    </div>
                    <div class="form-group">
                        <label for="phone_number">Телефон</label>
                        <input type="text" class="form-control" id="phone_number" name="phone_number">
                    </div>
                    <div class="form-group">
                        <label for="birthday">День рождения</label>
                        <input type="date" class="form-control" id="birthday" name="birthday">
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{route('customers.index')}}" class="btn bg-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-12 col-lg-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between">
                <div class="header-title">
                    <h4 class="card-title">Загрузить файл</h4>
                </div>
                <div class="header-action">
                    <i data-toggle="collapse" data-target="#form-element-1" aria-expanded="false">
                        <svg width="20" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4" />
                        </svg>
                    </i>
                </div>
            </div>
            <div class="card-body">
                <div class="collapse" id="form-element-1">
                    <div class="card">
                    </div>
                </div>
                <form action="{{route('customers.upload.file')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="file">csv/xls файл</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".csv, .xls, .xlsx">
                        @error('file')
                        <p class="text-danger">{{$message}}</p>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <a href="{{route('customers.index')}}" class="btn bg-danger">Cancel</a>
                </form>
            </div>
        </div>
    </div>
@endsection
