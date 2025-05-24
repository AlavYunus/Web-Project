<style>
.weather{
    margin: auto;
    text-align: center;
    max-width: 400px;
}
.alert {
    margin-top: 20px;
}
</style>

<div class='weather' id='weather-result'>
    <h1>THE WEATHER</h1>  
</div>

<script>
    // Run on page load
    window.onload = () => Position();

    function Position() {  
        if (navigator.geolocation) {  
            navigator.geolocation.getCurrentPosition(  
                position => fetchWeatherByCoords(position.coords),  
                error => showError(error)  
            );  
        } else {  
            document.getElementById('weather-result').innerHTML =   
                '<p>Your browser does not support geolocation.</p>';  
        }  
    }  

    async function fetchWeatherByCoords(coords) {  
       
        const url='the url weather source json file';

        try {  
            const response = await fetch(url);  
            const data = await response.json();  
            displayWeather(data);  
        } catch (error) {  
            document.getElementById('weather-result').innerHTML =   
                '<p>There was an error retrieving the weather data.</p>';  
        }  
    }  

    function displayWeather(data) {  
        const weatherDiv = document.getElementById('weather-result');  

        // Weather main description to decide alert type
        const weatherMain = data.weather[0].main.toLowerCase();

        // The array contains the bad weather conditions 
        const badWeather = ['rain', 'drizzle', 'thunderstorm', 'snow', 'mist', 'fog', 'haze', 'smoke', 'dust', 'sand', 'ash', 'squall', 'tornado'];

        let alertClass = 'alert-primary';
        let alertMessage = 'Today, the weather is suitable for events.';

        if (badWeather.includes(weatherMain)) {
            alertClass = 'alert-danger';
            alertMessage = 'Today ,the weather is not suitable for events.';
        }

        weatherDiv.innerHTML = `
            <h4>${data.name}, ${data.sys.country}</h4>  
            <img src="url" alt="Weather icon" title="${data.weather[0].description}">                      
            <p>Temperature: ${Math.round(data.main.temp)}°C, ${data.weather[0].description}</p>                      
            <p>Perceived Temperature: ${Math.round(data.main.feels_like)}°C</p>  
            <div class="alert ${alertClass}" role="alert">${alertMessage}</div>
        `;
    }  

    function showError(error) {  
        const weatherDiv = document.getElementById('weather-result');  
        
        switch(error.code) {  
            case error.PERMISSION_DENIED:  
                weatherDiv.innerHTML = '<p>Location access denied.</p>';  
                break;  
            case error.POSITION_UNAVAILABLE:  
                weatherDiv.innerHTML = '<p>Location information is unavailable.</p>';  
                break;  
            case error.TIMEOUT:  
                weatherDiv.innerHTML = '<p>The request timed out.</p>';  
                break;  
            default:
                weatherDiv.innerHTML = '<p>Unable to retrieve your location.</p>';
                break;
        }  
    }  
</script>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
