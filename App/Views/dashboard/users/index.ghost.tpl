{{ extends('layouts.master') }}

#set[content]
<div class="panel panel-default">
    <div class="panel-body">
        <h1>
            Lista de usuarios
            <a class="btn btn-success" href="{{ url('/dashboard/users/form') }}">
                <span class="glyphicon glyphicon-plus"></span>
            </a>
        </h1>
        <div data-update="#container-user-table">
            {{ component('pagination') }}
        </div>
        <div id="container-user-table" class="table-responsive container-data-table">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th></th>
                    <th data-column="user_name">Nombre</th>
                    <th data-column="user_login">Login</th>
                    <th data-column="user_email">Email</th>
                    <th data-column="user_registered">Fecha de registro</th>
                </tr>
                </thead>
                <tfoot>
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Login</th>
                    <th>Email</th>
                    <th>Fecha de registro</th>
                </tr>
                </tfoot>
                <tbody>
                #foreach($users as $user)
                <tr>
                    <td>
                        <a class="btn btn-primary" href="{{ url('/dashboard/users/form/') }}{{$user->id}}">
                            <span class="glyphicon glyphicon-edit"></span>
                        </a>
                        <button class="btn btn-danger" type="button" data-delete-id="{{$user->id}}" data-toggle="modal" data-target="#modal-delete" data-delete-action="/dashboard/users/delete" data-update="#container-user-table #messages .pagination-container">
                            <span class="glyphicon glyphicon-remove"></span>
                        </button>
                    </td>
                    <td>{{$user->user_name}}</td>
                    <td>{{$user->user_login}}</td>
                    <td>{{$user->user_email}}</td>
                    <td>{{$user->user_registered}}</td>
                </tr>
                #endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
{{ include('includes.modaldelete') }}
#end

#set[scripts]
<script src="{{ asset('js/modal-dialog.js') }}" type="text/javascript"></script>
<script src="{{ asset('js/data-list.js') }}" type="text/javascript"></script>
#end
