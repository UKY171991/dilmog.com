@extends('backEnd.layouts.master')
@section('title','Manage Feature')
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          {{-- <h5 class="m-0 text-dark">Welcome !! {{auth::user()->name}}</h5> --}}
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">Statistics Details</a></li>
            <li class="breadcrumb-item active">Manage</li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
          <div class="col-sm-12">
            <div class="manage-button">
              <div class="body-title">
                <h5>Manage Statistics Details</h5>
              </div>
              {{-- <div class="quick-button">
                <a href="{{ route('statistics-details.create') }}" class="btn btn-primary btn-actions btn-create">
                Create
                </a>
              </div> --}}
            </div>
          </div>
      </div>
        <div class="box-content">
          <div class="row">
            <div class="col-sm-12 col-md-12 col-lg-12">
                <div class="card">
                  <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                      <thead>
                      <tr>
                        <th>Id</th>
                        <th>Type</th>
                        <th>Total Delivery</th>
                        <th>Total Customers</th>
                        <th>Total Years</th>
                        <th>Total Members</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($StatisticsDetails as $key=>$value)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          </td>
                          <td>{{$value->type}}</td>
                          <td>{{$value->total_delivery}}</td>
                          <td>{{$value->total_customers}}</td>
                          <td>{{$value->total_years}}</td>
                          <td>{{$value->total_member}}</td>
                          <td>{{$value->is_active==1?"Active":"Inactive"}}</td>
                          <td><ul class="action_buttons dropdown">
                              <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action Button
                              <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                {{-- <li>
                                  @if($value->status==1)
                                  <form action="{{url('editor/feature/inactive')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                    <button type="submit" class="thumbs_up" title="unpublished"><i class="fa fa-thumbs-up"></i> Active</button>
                                  </form>
                                  @else
                                    <form action="{{url('editor/feature/active')}}" method="POST">
                                      @csrf
                                      <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                      <button type="submit" class="thumbs_down" title="published"><i class="fa fa-thumbs-down"></i> Inactive</button>
                                    </form>
                                  @endif
                                </li> --}}
                                  <li>
                                      <a class="edit_icon" href="{{ route('statistics-details.edit', $value->id) }}" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                  </li>
                                  {{-- <li>
                                    <form action="{{url('editor/feature/delete')}}" method="POST">
                                      @csrf
                                      <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                      <button type="submit" onclick="return confirm('Are you delete this this?')" class="trash_icon" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                  </li> --}}
                                </ul>
                              </ul>
                          </td>
                        </tr>
                        @endforeach
                      </tfoot>
                    </table>
                  </div>
                  <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
          </div>
        </div>
    </div>
  </section>
@endsection