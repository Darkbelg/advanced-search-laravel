{{--@extends('layout')--}}
@extends('search')
@section('result')
    @isset($results)
        <div class="w-7/9 p-4">
            <h2 class="w-1/6 p-6 m-auto">Results</h2>
            <canvas id="advancedSearch"></canvas>
            <div class="flex flex-wrap">
                {{--                {{dd($results)}}--}}
                @foreach ($results as $result)
                    @if(!is_null($result->getSnippet()->getThumbnails()))
                        <div class="w-1/3 md:w-1/6">
                            <a href="https://www.youtube.com/watch?v={{$result->getId()->getVideoId()}}"
                               target="_blank"><img
                                    src="{{ $result->getSnippet()->getThumbnails()->getMedium()->getUrl() }}"
                                    alt=""></a>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
        <script>
            var ctx = document.getElementById('advancedSearch').getContext('2d');
            var chart = new Chart(ctx, {
                // The type of chart we want to create
                type: 'bar',
                tooltipTemplate: "<%= addCommas(value) %>",

                // The data for our dataset
                data: {
                    labels: [{!! $dataSetResultCount !!}],
                    datasets: [{
                        label: 'Views',
                        backgroundColor: 'rgb(255, 99, 132)',
                        borderColor: 'rgb(255, 99, 132)',
                        data: [{!! $dataSet !!}]
                    }]
                },

                // Configuration options go here
                options: {}
            });
        </script>
    @endisset
@endsection
