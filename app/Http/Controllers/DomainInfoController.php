<?php

namespace App\Http\Controllers;

use App\Http\Resources\DomainInfoResource;
use App\Models\DomainInfo;
use Illuminate\Http\Request;

class DomainInfoController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('search'); // Get the 'search' query parameter
        $query = DomainInfo::query();

        if ($search) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        return DomaininfoResource::collection($query->paginate(100));
    }
}
