<template>
    <div class="Weather">
        {{ timestamp }} | São Paulo {{ weather }} Graus
    </div>
</template>

<script>
    export default {
        props: {
        },
        data: function () {
            return {
                timestamp: "",
                weather: ""
            }
        },
        created() {
            setInterval(this.getNow, 1000);
            this.getWeather();
        },
        methods: {
            getNow: function () {
                const today = new Date();
                const date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
                const time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
                const dateTime = time;
                this.timestamp = dateTime;
            },
            getWeather: function () {
                axios.get("../api/weather").then(({ data }) => (this.weather = data));
            }
        }
    };
</script>
