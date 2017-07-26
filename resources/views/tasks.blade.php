<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>SD-todo</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">

        <link href="{{ asset('css/sd-todo.css') }}" rel="stylesheet">


        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Raleway', sans-serif;
                font-weight: 100;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 12px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @if (Auth::check())
                        <a href="{{ url('/tasks') }}">Tasks</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                    @else
                        <a href="{{ url('/login') }}">Login</a>
                        <a href="{{ url('/register') }}">Register</a>
                    @endif
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Tasks
                </div>
                
                <div>
                    <form id="showallform" action="{{ url('tasks') }}" method="GET">
                        {{ csrf_field() }}
                        <input type="checkbox" name="showall" id="showall" @if ($showall) checked @endif><label for="showall">Show completed tasks</label>
                        <input type="hidden" name="state">
                    </form>
                </div>
                
                <div>
                    <ul id="tasks">
                        @foreach($tasks['available'] as $task)
                            <li data-li-id="{{ $task->id }}">
                                <input type="checkbox" data-done-id="{{ $task->id }}">
                                <a href="#" class="taskedit" data-id="{{ $task->id }}">{{ $task->title }} {{ $task->getHumanDiffDate() }}</a>
                                <a href="#" class="taskdel" data-del-id="{{ $task->id }}">(del)</a>
                            </li>
                        @endforeach
                        @foreach($tasks['completed'] as $task)
                            <li data-li-id="{{ $task->id }}" class="done">
                                <input type="checkbox" data-done-id="{{ $task->id }}" checked>
                                <a href="#" class="taskedit" data-id="{{ $task->id }}">{{ $task->title }} {{ $task->getHumanDiffDate() }}</a>
                                <a href="#" class="taskdel" data-del-id="{{ $task->id }}">(del)</a>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <form id="taskform" action="{{ url('task') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="id" value="">
                    <div>
                        <input type="text" name="title" placeholder="title">
                    </div>
                    <div>
                        <textarea name="description"></textarea>
                    </div>
                    <button type="submit">Add Task</button>
                </form>
                <br>

                <form id="searchform" action="{{ url('tasks') }}" method="GET">
                    {{ csrf_field() }}
                    <div>
                        <input type="text" name="search" placeholder="search" value="{{ $search }}">
                    </div>
                    <button type="submit">Search</button>
                </form>

            </div>
        </div>
        <!-- Scripts -->
        <script src="http://code.jquery.com/jquery-3.2.1.min.js"></script>
        <script src="{{ asset('js/sd-todo.js') }}"></script>
    </body>
</html>
