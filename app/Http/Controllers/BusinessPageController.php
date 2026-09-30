<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Support\Facades\Storage;

class BusinessPageController extends Controller
{
    public function show(string $slug)
    {
        $business = Business::query()
            ->where('slug', $slug)
            ->where('status', 'published')
            ->with([
                'links' => fn ($query) => $query
                    ->where('is_active', true)
                    ->orderBy('sort_order'),
            ])
            ->firstOrFail();

        $links = $business->links->filter(
            fn ($link) =>
                filter_var($link->url, FILTER_VALIDATE_URL)
                && in_array(
                    strtolower((string) parse_url($link->url, PHP_URL_SCHEME)),
                    ['http', 'https'],
                    true
                )
        );

        $accentColor = preg_match(
            '/^#[0-9a-fA-F]{6}$/',
            $business->accent_color ?? ''
        ) ? $business->accent_color : '#10233F';

        return view('business.show', [
            'business' => $business,
            'links' => $links,
            'accentColor' => $accentColor,
            'logoUrl' => $business->logo_path
                ? Storage::disk('public')->url($business->logo_path)
                : null,
            'coverUrl' => $business->cover_path
                ? Storage::disk('public')->url($business->cover_path)
                : null,
        ]);
    }
}