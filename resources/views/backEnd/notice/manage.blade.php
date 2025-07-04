@extends('backEnd.layouts.master')
@section('title','Manage Notice')
@section('content')
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h5 class="m-0 text-dark">Welcome !! {{auth::user()->name}}</h5>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active"><a href="#">Notice</a></li>
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
                <h5>Manage Notice Info</h5>
              </div>
              <div class="quick-button">
                <a href="{{url('editor/notice/create')}}" class="btn btn-primary btn-actions btn-create">
                Create
                </a>
              </div>
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
                        <th>Title</th>
                        <th>Status</th>
                        <th>Published</th>
                        <th>Action</th>
                      </tr>
                      </thead>
                      <tbody>
                        @foreach($show_data as $key=>$value)
                        <tr>
                          <td>{{$loop->iteration}}</td>
                          <td>{{$value->title}}</td>
                          <td>{{$value->status==1?"Active":"Inactive"}}</td>
                          <td>{{$value->published==1?"Published":"Unpublished"}}</td>
                          <td>
                            <ul class="action_buttons dropdown">
                              <button class="btn btn-primary dropdown-toggle m-2" type="button" data-toggle="dropdown">Action Button
                              <span class="caret"></span></button>
                              <ul class="dropdown-menu">
                                <li>
                                  @if($value->status==1)
                                  <form action="{{url('editor/notice/inactive')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                    <button type="submit" class="thumbs_up" title="unpublished"><i class="fa fa-thumbs-up"></i> Active</button>
                                  </form>
                                  @else
                                    <form action="{{url('editor/notice/active')}}" method="POST">
                                      @csrf
                                      <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                      <button type="submit" class="thumbs_down" title="published"><i class="fa fa-thumbs-down"></i> Inactive</button>
                                    </form>
                                  @endif
                                </li>
                                  <li>
                                      <a class="edit_icon" href="{{url('editor/notice/edit/'.$value->id)}}" title="Edit"><i class="fa fa-edit"></i> Edit</a>
                                  </li>
                                  <li>
                                    <form action="{{url('editor/notice/delete')}}" method="POST">
                                      @csrf
                                      <input type="hidden" name="hidden_id" value="{{$value->id}}">
                                      <button type="submit" onclick="return confirm('Are you delete this this?')" class="trash_icon" title="Delete"><i class="fa fa-trash"></i> Delete</button>
                                    </form>
                                  </li>
                                </ul>
                              </ul>
                            @if($value->published == 1)
                              <a href="{{ url('editor/notice/'.$value->id.'/publish/0') }}" class="btn btn-danger m-2">Unpublished</a>
                            @else
                              <a href="{{ url('editor/notice/'.$value->id.'/publish/1') }}" class="btn btn-primary m-2">Publish</a>
                            @endif
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
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

@section('custom_js_script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prepare only active notices for the popup
    var notices = [
        @foreach($show_data as $notice)
            @if($notice->status == 1)
            {
                id: "{{ $notice->id }}",
                title: @json($notice->title),
                status: "Active",
                published: "{{ $notice->published == 1 ? 'Published' : 'Unpublished' }}"
            },
            @endif
        @endforeach
    ];

    // Show all active notices in the popup
    if (notices.length > 0) {
        var html = '<ul style="text-align:left;">';
        notices.forEach(function(n) {
            html += '<li><strong>' + n.title + '</strong> (' + n.published + ')</li>';
        });
        html += '</ul>';
        showGlobalPopupB({
            title: 'Active Notices',
            message: html,
            buttons: [
                {
                    text: 'OK',
                    class: 'btn-primary',
                    onClick: function() {
                        bootstrap.Modal.getInstance(document.getElementById('globalPopupBModal')).hide();
                    }
                }
            ]
        });
    }
});
</script>
@endsection