@extends('layouts.master')
@section('title','Dashboard')
@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Tasks</h1>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Home</a></li>
        <li class="breadcrumb-item active" aria-current="page">Tasks</li>
    </ol>
</div>

<div class="row mb-3">

    <div class="col-xl-12 col-lg-12 mb-4">
        <div class="card">
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Our Tasks</h6>
                <button class="m-0 float-right btn btn-warning btn-sm" class="btn btn-primary" data-toggle="modal" data-target="#addTask">ADD <i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">DeadLine</th>
                        </tr>
                    </thead>
                    <tbody id="date_each_timezone">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal To Add Task -->
<div class="modal fade" id="addTask" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add New Task</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action='/create/task'>
                    @csrf
                    <div class="form-group">
                        <label for="task_name">Name</label>
                        <input type="text" class="form-control" id="task_name" name="name" placeholder="Enter Task Name">
                        @error('name')
                        <span style="color: red;margin-top:5px">{{$message}}</span>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Deadline</label>
                        <input type="datetime-local" class="form-control" id="task_date" name="date" placeholder="Enter Deadline Date for Task">
                        @error('date')
                        <span style="color: red;margin-top:5px">{{$message}}</span>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Save</button>
                </form>
            </div>
            <div class="modal-footer">
                <!-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> -->
            </div>
        </div>
    </div>
</div>
<!-- Modal End Here -->
<script>
    $(document).ready(function() {
        var dp = "";
        var timezone = Intl.DateTimeFormat().resolvedOptions().timeZone;
        var taskArray = @json($tasks);
        console.log(taskArray, 'Task Array');

        if (taskArray.length > 0) {
            taskArray.forEach(element => {
                var asiaTime = new Date(element.date).toLocaleString("en-US", {
                    timeZone: timezone,
                });
                asiaTime = new Date(asiaTime);

                var time = asiaTime.toLocaleString('en-US', {
                    hour: 'numeric',
                    minute: '2-digit'
                })
                var options = {
                    month: "long",
                }

                const nth = function(d) {
                    if (d > 3 && d < 21) return 'th';
                    switch (d % 10) {
                        case 1:
                            return "st";
                        case 2:
                            return "nd";
                        case 3:
                            return "rd";
                        default:
                            return "th";
                    }
                }
                const fortnightAway = asiaTime;

                const date = fortnightAway.getDate();

                var a = nth(date);

                var day = asiaTime.getDate() + a;

                var month_name = asiaTime.toLocaleDateString("en-US", options);

                dp += `
                    <tr><td>${element.id}</td>
                    <td>${element.name}</td>
                    <td>${time}, ${day} ${month_name}</td>
                    `;
            });
            $("#date_each_timezone").empty().append(dp);
        }
    });
</script>
@endsection