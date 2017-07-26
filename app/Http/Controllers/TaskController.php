<?php

namespace App\Http\Controllers;

use App\Repositories\TaskRepository;
use App\Task;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Common validation rules
     * 
     * @var array
     */
    protected $rules = [
        'title' => 'required|max:255',
    ];

    /**
     * Using auth middleware
     *
     * @param TaskRepository $tasks
     */
    public function __construct(TaskRepository $tasks)
    {
        $this->middleware('auth');
        $this->tasks = $tasks;

        if (!\Auth::check()) {
            return redirect('/login');
        }
    }

    /**
     * Task repository
     *
     * @var TaskRepository
     */
    protected $tasks;

    /**
     * List tasks
     *
     * @param  Request $request
     * @return Response
     */
    public function index(Request $request):Response
    {
        // handling showall cookie
        $cookie = false;
        $showall = $request->cookie('showall');
        if(isset($request->state)) {
            if ($request->state == 'true') {
                $showall = true;
                $cookie = cookie('showall', $request->state, 60);
            } else {
                $showall = false;
                $cookie = \Cookie::forget('showall');
            }
        }
        
        $response = response(view('tasks', [
            'showall' => $showall,
            'search' => $request->search,
            'tasks' => $this->tasks->filter($request->user(), $showall, $request->search)
        ])->render());

        return $cookie ? $response->withCookie($cookie) : $response;
    }

    /**
     * Load record for ajax calls
     * 
     * @param Task $task
     * @return Response
     */
    public function load(Task $task): Response
    {
        $this->authorize('owner', $task);
        return new Response(json_encode($task));
    }

    /**
     * Create a new task
     *
     * @param  Request $request
     * @return Response
     */
    public function create(Request $request): Response
    {
        try {
            $this->validate($request, $this->rules);
        } catch (ValidationException $ex) {
            return new Response(json_encode([
                'status' => false,
                'errors' => $ex->validator->getMessageBag()->all(),
            ]));
        }

        /** @var Task $task */
        $task = $request->user()->tasks()->create([
            'title' => $request->title,
            'description' => $request->description,
        ]);
        $task->created_at_human = $task->getHumanDiffDate();

        return new Response(json_encode([
            'status' => true,
            'data' => $task,
        ]));
    }

    /**
     * Modify given task
     *
     * @param Task $task
     * @param  Request $request
     * 
     * @return Response
     */
    public function modify(Task $task, Request $request): Response
    {
        $this->authorize('owner', $task);

        try {
            $this->validate($request, $this->rules);
        } catch (ValidationException $ex) {
            return new Response(json_encode([
                'status' => false,
                'errors' => $ex->validator->getMessageBag()->all(),
            ]));
        }

        $task->title = $request->get('title');
        $task->description = $request->get('description');
        $task->save();
        
        $task->created_at_human = $task->getHumanDiffDate();

        return new Response(json_encode([
            'status' => true,
            'data' => $task,
        ]));
    }

    /**
     * Delete the given task
     *
     * @param  Request $request
     * @param  Task $task
     * 
     * @return Response
     */
    public function delete(Request $request, Task $task): Response
    {
        $this->authorize('owner', $task);

        $task->delete();

        return new Response(json_encode(['status' => true]));
    }
    
    /**
     * Toggles the given task's status
     *
     * @param Request $request
     * @param Task $task
     * 
     * @return Response
     */
    public function toggle(Request $request, Task $task): Response
    {
        $this->authorize('owner', $task);

        $task->done_at = $task->done_at ? NULL : date('Y-m-d H:i:s');
        $task->save();

        return new Response(json_encode(['status' => true, 'current' => $task->done_at ? 'done' : '']));
    }
}