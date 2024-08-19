@extends('layouts.app')
@section('content')
    <div class="py-8 px-4 mx-auto max-w-screen-xl text-center lg:py-16 lg:px-12">
        <section class="flex items-center mb-3">
            <div class="w-full max-w-screen-xl px-4 mx-auto">
                <div class="relative overflow-hidden bg-white shadow-md dark:bg-gray-800 sm:rounded-lg">
                    <div class="flex-row items-center justify-between p-4 space-y-3 sm:flex sm:space-y-0 sm:space-x-4">
                        <div>
                            <h5 class="mr-3 font-semibold dark:text-white">Comparison details</h5>
                        </div>
                        <a href="/" type="button"
                            class="flex items-center justify-center px-4 py-2 text-sm font-medium dark:text-white  rounded-lg bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 focus:outline-none dark:focus:ring-primary-800">
                            New Comparison
                        </a>
                    </div>
                </div>
            </div>
        </section>
        <section class="flex items-center mb-3 p-4">
            <div class="grid grid-cols-12 gap-4">
                <div class="bg-white rounded-lg col-span-9 shadow dark:bg-gray-800 p-4 md:p-6">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-4 py-3">PARTICULARS</th>
                                <th scope="col" class="px-4 py-3">DOCUMENT I</th>
                                <th scope="col" class="px-4 py-3">DOCUMENT II</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    File name
                                </th>
                                <td class="px-4 py-5">{{ $paths[0]['file_name'] }}</td>
                                <td class="px-4 py-5">{{ $paths[1]['file_name'] }}</td>
                            </tr>
                            <tr class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    Word Count
                                </th>
                                <td class="px-4 py-5">{{ number_format($paths[0]['word_count']) }}</td>
                                <td class="px-4 py-5">{{ number_format($paths[1]['word_count']) }}</td>
                            </tr>
                            <tr class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    String Count
                                </th>
                                <td class="px-4 py-5">{{ number_format($paths[0]['string_count']) }}</td>
                                <td class="px-4 py-5">{{ number_format($paths[1]['string_count']) }}</td>
                            </tr>
                            <tr class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    File Size
                                </th>
                                <td class="px-4 py-5">{{ number_format($paths[0]['file_size'], 2) }} <span
                                        class="text-slate-200 text-xs">KB</span></td>
                                <td class="px-4 py-5">{{ number_format($paths[1]['file_size'], 2) }} <span
                                        class="text-slate-200 text-xs">KB</td>
                            </tr>
                            <tr class="border-b dark:border-gray-700">
                                <th scope="row"
                                    class="px-4 py-5 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    File type
                                </th>
                                <td class="px-4 py-5">{{ $paths[0]['file_extension'] }} </td>
                                <td class="px-4 py-5">{{ $paths[1]['file_extension'] }}
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-span-3">
                    <div class="max-w-sm w-full bg-white rounded-lg shadow dark:bg-gray-800 p-4 md:p-6 h-full">
                        <div class="flex justify-between mb-3">
                            <div class="flex justify-center items-center">
                                <h5 class="text-xl font-bold leading-none text-gray-900 dark:text-white pe-1">Similarity
                                    report</h5>
                            </div>
                        </div>
                        <!-- Donut Chart -->
                        <div class="py-6" id="donut-chart" class="text-white"></div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    @push('script')
        <script>
            const getChartOptions = () => {
                return {
                    series: [{{ $similarity }}, {{ 100 - $similarity }}],
                    colors: ["#00FF00", "#1D1D1D"],
                    chart: {
                        height: 320,
                        width: "100%",
                        type: "donut",
                    },
                    stroke: {
                        colors: ["transparent"],
                        lineCap: "",
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        show: true,
                                        fontFamily: "Inter, sans-serif",
                                        offsetY: 20,
                                    },
                                    total: {
                                        showAlways: true,
                                        show: true,
                                        label: "similarity",
                                        fontFamily: "Inter, sans-serif",
                                        formatter: function(w) {
                                            return w.globals.seriesTotals[0] + '%'
                                        },
                                    },
                                    value: {
                                        show: true,
                                        fontFamily: "Inter, sans-serif",
                                        offsetY: -20,
                                        formatter: function(value) {
                                            return value + "k"
                                        },
                                    },
                                },
                                size: "80%",
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: -2,
                        },
                    },
                    labels: ["Similar", "Not similar"],
                    dataLabels: {
                        enabled: false,
                    },
                    legend: {
                        position: "bottom",
                        fontFamily: "Inter, sans-serif",
                    },
                    yaxis: {
                        labels: {
                            formatter: function(value) {
                                return value + "k"
                            },
                        },
                    },
                    xaxis: {
                        labels: {
                            formatter: function(value) {
                                return value + "k"
                            },
                        },
                        axisTicks: {
                            show: false,
                        },
                        axisBorder: {
                            show: false,
                        },
                    },
                }
            }

            if (document.getElementById("donut-chart") && typeof ApexCharts !== 'undefined') {
                console.log(getChartOptions());
                const chart = new ApexCharts(document.getElementById("donut-chart"), getChartOptions());
                chart.render();
            }
        </script>
    @endpush
@endsection
