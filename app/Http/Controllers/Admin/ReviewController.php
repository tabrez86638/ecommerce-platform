<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index()
    {
        $reviews = Review::with([
            'user',
            'product',
            'order',
        ])
        ->latest()
        ->paginate(15);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'status' => 'approved',
        ]);

        return back()->with(
            'success',
            'Review approved successfully.'
        );
    }

    public function reject(Review $review)
    {
        $review->update([
            'status' => 'rejected',
        ]);

        return back()->with(
            'success',
            'Review rejected successfully.'
        );
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return back()->with(
            'success',
            'Review deleted successfully.'
        );
    }
}