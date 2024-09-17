<?php

namespace App\Http\Controllers;

use App\Http\Resources\DomainInfoResource;
use App\Models\DomainInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DomainInfoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search');
        $query = DomainInfo::query();

        if ($search) {
            // Escape wildcards and sanitize input
            $search = str_replace(['%', '_'], ['\%', '\_'], trim($search));
            $query->where('name', 'like', '%' . $search . '%');
        }

        $validator = Validator::make($request->all(), [
            'search' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422); // Custom error handling
        }

        return DomaininfoResource::collection($query->paginate(100));
    }
}
