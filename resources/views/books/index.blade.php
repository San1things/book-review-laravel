@extends('layouts.app')

@section('content')
    <h1 class="mb-10 text-2x1">Books</h1>
    <form class="flex items-center space-x-2" action="{{ route('books.index') }}" method="GET">
        <input class="input" name="title" type="text" value="{{ request('title') }}" placeholder="Search by title...">
        <input name="filter" type="hidden" value="{{ request('filter') }}">
        <button class="btn" type="submit">Search</button>
        <a class="btn" href="{{ route('books.index') }}">Clear</a>
    </form>

    <div class="filter-container mb-4 flex">
        @php
            $filters = [
                '' => 'Latest',
                'popular_last_month' => 'Popular Last Month',
                'popular_last_6months' => 'Popular Last 6 Month',
                'highest_rated_last_month' => 'Highest Rated Last Month',
                'highest_rated_last_6months' => 'Highest Rated Last 6 Month',
            ];
        @endphp

        @foreach ($filters as $key => $label)
            <a class="{{ request('filter') === $key || (request('filter') === null && $key === '') ? 'filter-item-active' : 'filter-item' }}"
                href="{{ route('books.index', [...request()->query(), 'filter' => $key]) }}">
                {{ $label }}
            </a>
        @endforeach
    </div>
    <ul>
        @forelse ($books as $book)
            <li class="mb-4">
                <div class="book-item">
                    <div class="flex flex-wrap items-center justify-between">
                        <div class="w-full flex-grow sm:w-auto">
                            <a class="book-title" href="{{ route('books.show', $book) }}">{{ $book->title }}</a>
                            <span class="book-author">by {{ $book->author }}</span>
                        </div>
                        <div>
                            <div class="book-rating">
                                {{ number_format($book->reviews_avg_rating, 1) }}
                                <x-star-rating :rating="$book->reviews_avg_rating" />
                            </div>
                            <div class="book-review-count">
                                out of {{ $book->reviews_count }} reviews.
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        @empty
            <li class="mb-4">
                <div class="empty-book-item">
                    <p class="empty-text">No books found</p>
                    <a class="reset-link" href="{{ route('books.index') }}">Reset criteria</a>
                </div>
            </li>
        @endforelse
    </ul>
@endsection
