<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
            <!-- bootstrap css -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
        integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
            <!-- bootstrap js -->
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy"
        crossorigin="anonymous"></script>
        <title>To Dowies</title>
    </head>
    <body>
         <div class="container">
            <div class="col-md-offset-2 col-md-8">
            
            <!--Login requierd-->
              @if(!Auth::check())
                <h2> Oeps! U moet ingelogd zijn om deze pagina te kunnen bekijken.<h2>
                <div class="col-md-2 col-md-offset-5" style="margin-top:20px;">
                    <a href="{{ route('login')}}" class="btn-default btn">Login</a>
                    <a href="{{ route('register')}}" class="btn-default btn">Register</a>
                </div>
              @endif

            <!-- if logged in -->
              @if(Auth::check())
                <form  action="{{ route('logout') }}" method="POST" >
                    {{ csrf_field() }}
                    <p>Ingelogd als <strong> {{Auth::user()->name }}</strong></p>
                    <button type="submit" class="waves-effect waves-light btn">uitloggen</button>
                </form>

                <div class="row">
                    <h1>To Dowies - Nieuwe taak aanmaken</h1>
                </div>

        <!-- succes message -->
                @if (Session::has('success'))
                    <div class="alert alert-success">
                        <strong>{{Session::get('success') }} </strong>
                    </div>
                @endif

        <!--error message -->
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <strong>Error:</strong>
                        <ul>
                            @foreach ($errors -> all() as $error)
                                <li> {{$error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

        <!--create new task form -->
                <div class="row" style='margin-top: 10px; margin-bottom: 50px;'>
                    <form action="{{ route('tasks.store') }}" method="POST">
                        {{ csrf_field() }}
                    <!--input new name-->
                            <div class="col-md-9">
                                <p>Taak naam*<p>
                                <input type="text" name="newTaskName" class="form-control">
                            </div>
                    <!--input new description-->
                            <div class="col-md-9">
                                <p>Taak omschrijving*<p>
                                <textarea type="text" name="newTaskDescription" class="form-control "  rows="3"></textarea>
                            </div>
                    <!--input new due date-->
                            <div class="col-md-9">                  
                                <p>Taak moet af zijn tegen (datum en tijd)*</p>
                                <input type="date" name="newDueDate" class="form-control" >
                            </div>
                    <!--submit new task-->
                            <div class="col-md-9">
                                <p>(*) deze velden zijn verplicht</p>
                                <input type="submit" class="btn btn-primary" value="Nieuwe taak toevoegen">   
                            </div>
                    </form>
                </div>

        <!--task table -->
            @if (count($taskData) > 0)
                <table class="table" style="border: 2px solid #DDDDDD; margin-top:50px; width:800px;">
                    <caption style="font-size:25px; color:#A983B6;">Takenlijst</caption>
                    <thead>
                        <th></th>
                        <th>Taak naam</th>
                        <th>Aangemaakt op</th>
                        <th>Taak vervalt op</th>
                        <th></th>
                        <th></th>
                    </thead>
                    <tbody>
                        @foreach ($taskData as $data)
                            @if(!$data->taskCompleted)
                                <tr>
                                <!--Edit task link -->
                                    <td>
                                        <a href="{{ route('tasks.edit' , ['tasks' => $data->id]) }}" class="btn btn-info ">
                                            Bewerken
                                        </a>
                                    </td>
                                <!--task name -->
                                    <td>{{$data ->name}}</td>
                                <!--task creation date -->
                                    <td>{{ date('j M Y ', strtotime( $data ->created_at ) ) }}</td>
                                <!--task due date if due date is surpassed due date = color red -->
                                    @if($data->dueDate >  date('Y-m-d H:i:s'))
                                        <td >{{ date('j M Y ', strtotime( $data ->dueDate ) ) }}</td>
                                    @else  <td style="color:red;">{{ date('j M Y ', strtotime( $data ->dueDate ) ) }}</td>
                                    @endif
                                <!--task completed button -->
                                    <td>
                                        <form action="{{ route('task.complete') }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden" name="completeTaskId" class="form-control" value="{{$data->id}}">
                                            <div class="col-md-9">
                                                <input type="submit" class="btn btn-warning" value="Taak afgewerkt">   
                                            </div>
                                        </form>
                                    </td>
                                <!-- delete task button -->
                                    <td>
                                        <form action="{{ route('tasks.destroy', ['tasks' => $data->id]) }}" method='POST'>
                                            {{ csrf_field() }} 
                                            <input type="hidden" name='_method' value='DELETE'>
                                            <input type="submit" class="btn btn-danger" value="Taak verwijderen">
                                        </form>
                                    </td>
                                </tr>
                                <tr>
                                <!--task description-->
                                    <th>Omschrijving:</th>
                                    <td class="col-md-9">{{$data ->description}}</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                </tr>
                        @endif
                     @endforeach
                </tbody>
            @endif
            
        <hr>
        <!-- table completed tasks -->
             
            <table class="table" style="border: 2px solid #DDDDDD; margin-top:100px; width:800px;">
                <caption style="font-size:25px; color:#A0893D;">Voltooide taken</caption>
                <thead>
                    <th>Taak naam</th>
                    <th>Taak omschrijving</th>
                    <th>Aangemaakt op</th>
                    <th></th>
                </thead>
                <tbody>
                    @foreach ($taskData as $data)
                        @if($data->taskCompleted)
                            <tr>
                            <!-- completed task name -->
                                <td>{{$data ->name}}</td>
                            <!-- completed task description -->
                                <td>{{$data->description}} </td>
                            <!-- completed task creayion date -->
                                <td>{{ date('j M Y ', strtotime( $data ->created_at ) ) }}</td>
                            <!-- completed task delete button -->
                                <td>
                                    <form action="{{ route('tasks.destroy', ['tasks' => $data->id]) }}" method='POST'>
                                        {{ csrf_field() }} 
                                        <input type="hidden" name='_method' value='DELETE'>
                                        <input type="submit" class="btn btn-danger" value="Taak verwijderen">
                                    </form>
                                </td>
                            </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
               @endif
            </div>
        </div>  
    </body>
</html>