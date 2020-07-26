<template>
    <apexchart width="100%" height="300" type="area" :options="options" :series="series"></apexchart>
</template>

<script>
    export default {
        props: ['keys', 'values'],

        data() {
            return {
                options: {
                    chart: {
                        toolbar: {
                            show: false
                        },
                        id: 'orders-per-week',
                        foreColor: '#718096'
                    },
                    stroke: {
                        width: 1
                    },
                    xaxis: {
                        categories: this.keys
                    },
                    grid: {
                        borderColor: '#F7FAFC'
                    },
                    theme: {
                        mode: 'light',
                        palette: 'palette1',
                        monochrome: {
                            enabled: true,
                            color: '#0366D6',
                            shadeTo: 'dark',
                            shadeIntensity: 0.65
                        },
                    },
                    legend: {
                        labels: {
                            useSeriesColors: true
                        },
                        onItemClick: {
                            toggleDataSeries: true
                        },
                        onItemHover: {
                            highlightDataSeries: true
                        },
                    },
                    fill: {
                        opacity: 1,
                        gradient: {
                            enabled: true,
                            opacityFrom: 0.55,
                            opacityTo: 0
                        }
                    },
                    dataLabels: {
                        enabled: false,
                    },
                },
                series: [{
                    name: 'Orders',
                    data: this.values
                }],
                tooltip: {
                    theme: "dark"
                },
            }
        },

        mounted() {
            console.log(this.keys);
        }
    }
</script>
