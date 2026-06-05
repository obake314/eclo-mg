(function () {
	'use strict';

	// Intl.DateTimeFormat with timezone handles DST automatically
	function formatTime(timezone) {
		var parts = new Intl.DateTimeFormat('ja-JP', {
			timeZone: timezone,
			year:     'numeric',
			month:    '2-digit',
			day:      '2-digit',
			hour:     '2-digit',
			minute:   '2-digit',
			hour12:   false,
		}).formatToParts(new Date());
		var p = {};
		parts.forEach(function (part) { p[part.type] = part.value; });
		return p.year + '.' + p.month + '.' + p.day + ' ' + p.hour + ':' + p.minute;
	}

	function tick() {
		var berlinEl = document.getElementById('js-berlin-time');
		var tokyoEl  = document.getElementById('js-tokyo-time');
		if (berlinEl) { berlinEl.textContent = formatTime('Europe/Berlin'); }
		if (tokyoEl)  { tokyoEl.textContent  = formatTime('Asia/Tokyo');    }
	}

	// WMO weather code → { icon, label }
	var WMO = {
		0:  { icon: '☀',  label: '快晴'     },
		1:  { icon: '🌤', label: '晴れ'     },
		2:  { icon: '⛅', label: '薄曇り'   },
		3:  { icon: '☁',  label: '曇り'     },
		45: { icon: '🌫', label: '霧'       },
		48: { icon: '🌫', label: '霧氷'     },
		51: { icon: '🌦', label: '霧雨'     },
		53: { icon: '🌦', label: '霧雨'     },
		55: { icon: '🌦', label: '濃い霧雨' },
		61: { icon: '🌧', label: '小雨'     },
		63: { icon: '🌧', label: '雨'       },
		65: { icon: '🌧', label: '強雨'     },
		71: { icon: '🌨', label: '小雪'     },
		73: { icon: '🌨', label: '雪'       },
		75: { icon: '❄',  label: '大雪'     },
		77: { icon: '🌨', label: '細氷'     },
		80: { icon: '🌧', label: 'にわか雨' },
		81: { icon: '🌧', label: 'にわか雨' },
		82: { icon: '⛈',  label: '激しい雨' },
		85: { icon: '🌨', label: 'にわか雪' },
		86: { icon: '❄',  label: '大雪'     },
		95: { icon: '⛈',  label: '雷雨'     },
		96: { icon: '⛈',  label: '雷雨＋雹' },
		99: { icon: '⛈',  label: '雷雨＋雹' },
	};

	// Open-Meteo — free, no API key required
	// Berlin: lat 52.52, lon 13.405
	function fetchWeather() {
		var tempEl  = document.getElementById('js-berlin-temp');
		var iconEl  = document.getElementById('js-berlin-weather-icon');
		var labelEl = document.getElementById('js-berlin-weather-label');
		if (!tempEl) { return; }
		fetch(
			'https://api.open-meteo.com/v1/forecast' +
			'?latitude=52.52&longitude=13.405' +
			'&current=temperature_2m,weather_code' +
			'&timezone=Europe%2FBerlin'
		)
			.then(function (r) { return r.json(); })
			.then(function (data) {
				var cur = data.current;
				if (!cur) { return; }
				if (cur.temperature_2m !== undefined) {
					tempEl.textContent = Math.round(cur.temperature_2m);
				}
				var w = WMO[cur.weather_code];
				if (w) {
					if (iconEl)  { iconEl.textContent  = w.icon;  }
					if (labelEl) { labelEl.textContent = w.label; }
				}
			})
			.catch(function () {});
	}

	// @fawazahmed0/currency-api — jsDelivr CDN, free, no API key, daily updates
	// Fallback URL used if primary CDN is unavailable
	function fetchRate() {
		var el = document.getElementById('js-eur-jpy');
		if (!el) { return; }

		var cacheKey = 'okberlin_eur_jpy';
		var cached   = sessionStorage.getItem(cacheKey);
		if (cached) {
			el.textContent = cached;
			return;
		}

		var primary  = 'https://cdn.jsdelivr.net/npm/@fawazahmed0/currency-api@latest/v1/currencies/eur.min.json';
		var fallback = 'https://latest.currency-api.pages.dev/v1/currencies/eur.min.json';

		function applyRate(data) {
			var jpy = data && data.eur && data.eur.jpy;
			if (!jpy) { return; }
			var rate = Math.round(jpy).toLocaleString('ja-JP');
			el.textContent = rate;
			sessionStorage.setItem(cacheKey, rate);
		}

		fetch(primary)
			.then(function (r) { return r.json(); })
			.then(applyRate)
			.catch(function () {
				fetch(fallback)
					.then(function (r) { return r.json(); })
					.then(applyRate)
					.catch(function () {});
			});
	}

	document.addEventListener('DOMContentLoaded', function () {
		tick();
		setInterval(tick, 60000);
		fetchWeather();
		fetchRate();
	});
}());
