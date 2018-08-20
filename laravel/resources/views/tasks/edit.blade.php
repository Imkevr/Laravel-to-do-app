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
                <h1>To Dowies - Taak bewerken </h1>
            </div>
        <!-- success message -->
            @if (Session::has('success'))
                <div class="alert alert-success">
                    <strong> {{Session::get('success') }}</strong>
                </div>
            @endif
        <!--error message -->
            @if (count($errors) > 0)
                <div class="alert alert-danger">
                    <strong>Error:</strong>
                    <ul>
                        @foreach ( $errors -> all() as $error )
                            <li> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row">
            <!-- Edit task form -->
                <form action="{{ route('tasks.update', [$currentTask->id]) }}" method="POST">
                 {{ csrf_field() }}
                    <input type="hidden" name='_method' value='PUT'>
                <!-- Edit task name-->
                    <div class="form-group">
                        <p class="input-lg" style="margin-left:0px; padding-left:0px">Taak naam*</p>
                        <input type="text" name="updateName" class="form-control input-lg" value='{{$currentTask->name }}'>
                    </div>
                <!-- Edit task description-->
                    <div class="form-group">
                        <p class="input-lg" style="margin-left:0px; padding-left:0px;">Taak omschrijving*<p>
                        <textarea type="text" name="updateTaskDescription" class="form-control input-lg"  rows="3">{{$currentTask->description}}</textarea>
                    </div>
                <!-- Edit task due date-->
                    <div class="form-group">                  
                        <p class="input-lg" style="margin-left:0px; padding-left:0px";>Taak moet af zijn tegen*</p>
                        <input type="date" name="updateDueDate" class="form-control input-lg" value="{{$currentTask->dueDate}}" style="width:250px;" >
                    </div>
                <!-- Edit task submit and go back home button-->
                    <div class="form-group">
                        <p>(*) deze velden zijn verplicht </p>
                        <a href="{{route('tasks.index')}}" class="btn btn-lg btn-default">Terug naar takenlijst</a>
                        <input type="submit" value="Taak opslaan" class="btn btn-success btn-lg align-right"/>
                    </div>
                </form>
             </div>
             @endif
        </div>
    </div>
</body>
</html>