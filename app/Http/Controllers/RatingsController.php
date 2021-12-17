<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\Request;

class RatingsController extends Controller
{
    /**
     * Store a rating for a product
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validatedData = $request->validate([
            'rating' => 'required|numeric',
            'cname' => 'required',
            'comment' => 'required',
        ]);
        $product = Product::findOrFail($request->input('id'));
        $rating = new Rating();
        $rating->rating = $validatedData['rating'];
        $rating->name = $validatedData['cname'];
        $rating->comment = $validatedData['comment'];
        $product->ratings()->save($rating);
        return back()->with('status', 'Rating added');
    }

    /**
     * All unprocessed ratings
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $ratings = Rating::where('approved', 0)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('reviews', ['ratings' => $ratings]);
    }

    public function approve(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            Rating::findOrFail($id)
                ->update(['approved' => 1]);
            return redirect()->route('show.ratings');
        } else {
            abort(404);
        }
    }

    public function reject(Request $request)
    {
        if ($request->has('id')){
            $id = $request->input('id');
            Rating::findOrFail($id)->delete();
            return redirect()->route('show.ratings');
        } else {
            abort(404);
        }
    }
}
