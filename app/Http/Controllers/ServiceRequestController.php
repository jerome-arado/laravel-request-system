<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ServiceRequestController extends Controller
{
    /**
     * List requests.
     * - Students see only their own.
     * - Admins see all.
     */
    public function index(Request $request)
    {
        Gate::authorize('viewAny', ServiceRequest::class);

        $query = ServiceRequest::query();

        if (! $request->user()->is_admin) {
            $query->where('user_id', $request->user()->id);
        }

        $requests = $query->latest()->paginate(10);

        return view('requests.index', compact('requests'));
    }

    /**
     * Show the create form.
     * Only students may create.
     */
    public function create(Request $request)
    {
        Gate::authorize('create', ServiceRequest::class);

        return view('requests.create');
    }

    /**
     * Store a new request.
     * Trusted fields are assigned from the signed-in user.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', ServiceRequest::class);

        $validated = $request->validate([
            'item_name' => ['required', 'string', 'max:150'],
            'quantity'  => ['required', 'integer', 'min:1'],
            'purpose'   => ['required', 'string', 'max:2000'],
        ]);

        $request->user()->serviceRequests()->create([
            'item_name'       => $validated['item_name'],
            'quantity'        => $validated['quantity'],
            'purpose'         => $validated['purpose'],
            'requester_name'  => $request->user()->name,
            'requester_email' => $request->user()->email,
            'status'          => 'pending',
        ]);

        return redirect()
            ->route('requests.index')
            ->with('success', 'Request submitted successfully.');
    }

    /**
     * Show a single request.
     * Owner or admin only; others receive 404.
     */
    public function show(ServiceRequest $serviceRequest)
    {
        Gate::authorize('view', $serviceRequest);

        return view('requests.show', compact('serviceRequest'));
    }

    /**
     * Update the request status.
     * Admin only.
     */
    public function updateStatus(Request $request, ServiceRequest $serviceRequest)
    {
        Gate::authorize('updateStatus', $serviceRequest);

        $validated = $request->validate([
            'status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $serviceRequest->update(['status' => $validated['status']]);

        return redirect()
            ->route('requests.show', $serviceRequest)
            ->with('success', 'Status updated.');
    }
}