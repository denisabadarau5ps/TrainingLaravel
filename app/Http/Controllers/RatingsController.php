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
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'rating' => 'required|numeric',
            'cname' => 'required',
            'comment' => 'required',
        ]);
        $product = Product::where('id', $request->input('id'))->first();
        $rating = new Rating();
        $rating->rating = $validatedData['rating'];
        $rating->name = $validatedData['cname'];
        $rating->comment = $validatedData['comment'];
        $product->ratings()->save($rating);
        return back()->with('status', 'Rating added');
    }

    /**
     * All approved ratings for a product
     * @param $id
     * @return array|void
     */
    static public function approvedRatings($id)
    {
        if (Product::where('id', $id)->exists()) {
            $ratings = Rating::where('approved', 1)->where('product_id', $id)->exists() ? Rating::where('approved', 1)->where('product_id', $id)->orderBy('created_at','desc')->get() : [];
            return $ratings;
        } else {
            abort(404);
        }
    }

    /**
     * All unprocessed ratings
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $ratings = Rating::where('approved', 0)->get();
        return view('reviews', ['ratings' => $ratings]);
    }

    public function approve(Request $request)
    {
        if ($request->has('id')) {
            $id = $request->input('id');
            $rating = Rating::where('id', $id)->first();
            $rating->approved = 1;
            $rating->save();
            return redirect()->route('show.ratings');
        } else {
            abort(404);
        }
    }

    public function reject(Request $request)
    {
        if ($request->has('id')){
            $id = $request->input('id');
            $rating = Rating::where('id', $id)->first();
            $rating->delete();
            return redirect()->route('show.ratings');
        } else {
            abort(404);
        }
    }
}
