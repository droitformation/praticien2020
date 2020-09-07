<?php namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Praticien\Theme\Repo\ThemeInterface;

class ThemeController extends Controller
{
    protected $theme;

    public function __construct(ThemeInterface $theme)
    {
        $this->theme = $theme;
    }

    public function store(Request $request)
    {
        $theme = $this->theme->create($request->only('name'));

        return $request->ajax() ? response()->json($theme) : redirect()->back();
    }
}
