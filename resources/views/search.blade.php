@extends('layout')

@section('search')
    <div class="flex">
        <form action="{{ $urlPath }}" method="POST" class="w-full max-w-lg mx-auto bg-white p-4 my-4">
            @csrf
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block capitalize tracking-wide text-gray-700 text-xs font-bold mb-2"
                           for="search">Search:</label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        name="search" id="search" type="text" value="{{ request('search') }}"/>
                    @error('search')
                    <p class="text-red-500 text-xs italic">{{ $errors->first('search') }}</p>
                    @enderror
                </div>
            </div>
            <div class="flex flex-wrap -mx-3 mb-6">
                <div class="w-full px-3 mb-6 md:mb-0">
                    <label class="block capitalize tracking-wide text-gray-700 text-xs font-bold mb-2" for="maxResults">
                        Maximum results to get their is a maximum of 50.
                    </label>
                    <input
                        class="appearance-none block w-full bg-gray-200 text-gray-700 border rounded py-3 px-4 mb-3 leading-tight focus:outline-none focus:bg-white"
                        id="maxResults" name="maxResults" type="text"
                        value="@if(request('maxResults')){{ request('maxResults') }} @else 48 @endif">
                    @error('maxResults')
                    {{ $errors->first('maxResults') }}
                    @enderror
                </div>
            </div>

            <div class="md:flex md:flex-wrap">
{{--                <div class="md:flex md:items-center mb-6 md:w-1/2 pt-4">--}}
{{--                    <div><h3>Type</h3>--}}
{{--                        <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2">--}}
{{--                            <input--}}
{{--                                class="mr-2 leading-tight"--}}
{{--                                type="checkbox"--}}
{{--                                name="type[channel]"--}}
{{--                                value="channel"--}}
{{--                                @if(isset(request('type')['channel']) || request('type') === null) checked @else  @endif >--}}
{{--                            <span class="text-sm">channel</span>--}}
{{--                        </label>--}}
{{--                        <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2">--}}
{{--                            <input--}}
{{--                                class="mr-2 leading-tight"--}}
{{--                                type="checkbox"--}}
{{--                                name="type[playlist]"--}}
{{--                                value="playlist"--}}
{{--                                @if(isset(request('type')['playlist']) || request('type') === null) checked @else  @endif >--}}
{{--                            <span class="text-sm">playlist</span>--}}
{{--                        </label>--}}
{{--                        <label class="block tracking-wide text-gray-700 text-xs font-bold mb-2">--}}
{{--                            <input--}}
{{--                                class="mr-2 leading-tight"--}}
{{--                                type="checkbox"--}}
{{--                                name="type[video]"--}}
{{--                                value="video"--}}
{{--                                @if(isset(request('type')['video']) || request('type') === null) checked @else  @endif >--}}
{{--                            <span class="text-sm">video</span>--}}
{{--                        </label>--}}
{{--                        @error('type')--}}
{{--                        {{ $errors->first('type') }}--}}
{{--                        @enderror--}}
{{--                    </div>--}}
{{--                </div>--}}
                {{--    {{ dd(request('type')) }}--}}

                <div class="md:flex md:items-center mb-6 md:w-1/2">
                    <div>
                        <h3>Quality</h3>
                        <label class="block text-gray-700 font-bold">
                            <input
                                class="mr-2 leading-tight"
                                type="radio"
                                name="videoDefinition"
                                value="any"
                                @if(request('videoDefinition') === 'any' || request('videoDefinition') === null) checked @else  @endif >
                            <span class="text-sm">
            any
        </span>
                        </label>
                        <label class="block text-gray-700 font-bold">
                            <input
                                class="mr-2 leading-tight"
                                type="radio"
                                name="videoDefinition"
                                value="high"
                                @if( request('videoDefinition') === 'high') checked @else  @endif >
                            <span class="text-sm">
            high
        </span>
                        </label>
                        <label class="block text-gray-700 font-bold">
                            <input
                                class="mr-2 leading-tight"
                                type="radio"
                                name="videoDefinition"
                                value="standard"
                                @if( request('videoDefinition') === 'standard') checked @else  @endif >
                            <span class="text-sm">
            standard
        </span>
                        </label>
                        @error('videoDefinition')
                        {{ $errors->first('videoDefinition') }}
                        @enderror
                    </div>
                </div>
            </div>
            <div class="mb-4">
                <h3>Order</h3>
                @error('order')
                {{ $errors->first('order') }}
                @enderror
                <div class="inline-block">
                    <label class="ml-3 text-gray-700 font-bold">
                        <input class="mr-1 leading-tight" type="radio" name="order" value="date"
                               @if( request('order') === 'date') checked @else  @endif>
                        <span class="text-sm">Date</span>
                    </label>
                </div>
                <div class="inline-block">
                    <label class="ml-3 text-gray-700 font-bold">
                        <input class="mr-1 leading-tight" type="radio" name="order" value="rating"
                               @if( request('order') === 'rating') checked @else  @endif>
                        <span class="text-sm">Rating</span>
                    </label>
                </div>
                <div class="inline-block">
                    <label class="ml-3 text-gray-700 font-bold">
                        <input class="mr-1 leading-tight" type="radio" name="order" value="relevance"
                               @if( request('order') === 'relevance' || request('order') === null ) checked @else  @endif>
                        <span class="text-sm">Relevance</span>
                    </label>
                </div>
                <div class="inline-block">
                    <label class="ml-3 text-gray-700 font-bold">
                        <input class="mr-1 leading-tight" type="radio" name="order" value="title"
                               @if( request('order') === 'title') checked @else  @endif>
                        <span class="text-sm">Title</span>
                    </label>
                </div>
                {{--                <div class="inline-block">--}}
                {{--                    <label class="ml-2 text-gray-700 font-bold" for="videoCount">--}}
                {{--                        <input class="mr-2 leading-tight" type="radio" name="order" value="videoCount">--}}
                {{--                        <span class="text-sm">Video Count (Channels Only)</span>--}}
                {{--                    </label>--}}
                {{--                </div>--}}
                <div class="inline-block">
                    <label class="ml-3 text-gray-700 font-bold">
                        <input class="mr-1 leading-tight" type="radio" name="order" value="viewCount"
                               @if( request('order') === 'viewCount') checked @else  @endif>
                        <span class="text-sm ">View Count</span>
                    </label>
                </div>
            </div>
            <div class="md:flex md:items-center">
                <div class="m-auto">
                    <button
                        class="shadow bg-purple-500 hover:bg-purple-400 focus:shadow-outline focus:outline-none text-white font-bold py-2 px-4 rounded"
                        type="submit">Find
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
